<?php

if (!defined('ABSPATH')) {
    die();
}
if (!class_exists('CPTAjaxHandle')) {
    class CPTAjaxHandle
    {

        function __construct()
        {
            add_action('wp_ajax_cpt_verify_purchase_code', [$this, 'verify_purchase_code']);
            add_action('wp_ajax_cpt_log_out', [$this, 'log_out']);
            add_action('wp_ajax_cpt_install_plugin', [$this, 'install_plugin']);
            add_action('wp_ajax_cpt_activate_plugin', [$this, 'activate_plugin']);
            add_action('wp_ajax_cpt_update_plugin', [$this, 'update_plugin']);
            add_action('wp_ajax_cpt_update_theme', [$this, 'update_theme']);
            add_action('wp_ajax_cpt_can_import_demo', [$this, 'can_import_demo']);
            add_action('wp_ajax_cpt_dismiss', [$this, 'dismiss']);
            add_action('wp_ajax_cpt_update_auth', [$this, 'update_auth']);
            add_action('wp_ajax_cpt_update_required_plugins', [$this, 'update_required_plugins']);
            add_action('wp_ajax_cpt_update_theme_info', [$this, 'update_theme_info']);
        }

        function verify_purchase_code()
        {
            try {
                if (!isset($_POST['purchase_code']) || empty($_POST['purchase_code'])) {
                    throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                }

                if (!check_ajax_referer('cpt_verify_purchase_code', false, false))
                    throw new Exception(__('Invalid request!', CPT_TEXT_DOMAIN));

                // Check if user is administrator
                $current_user = wp_get_current_user();
                if (!in_array('administrator', (array) $current_user->roles))
                    throw new Exception(esc_html__('You are not allowed to do this!', 'wastia'));

                $current_theme = wp_get_theme();
                if (is_child_theme()) {
                    $current_theme = $current_theme->parent();
                }
                $params = [
                    'host' => str_replace('www.', '', cpt_get_host()),
                    'email' => $_POST['email'] ?? '',
                    'name' => $_POST['name'] ?? '',
                    'purchase_code' => $_POST['purchase_code'],
                    'theme_slug' => $current_theme->get('TextDomain'),
                ];

                $request = wp_remote_post(cpt_get_server_url() . '/verify/purchase-code', [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode($params),
                    'sslverify' => false,
                ]);
                $responseCode = wp_remote_retrieve_response_code($request);
                if ($responseCode !== 200) {
                    $responseMessage = wp_remote_retrieve_response_message($request);
                    throw new Exception($responseMessage ?: __('Verify Fail!', CPT_TEXT_DOMAIN));
                }

                $body = @json_decode(wp_remote_retrieve_body($request), true);
                if ($body === false && json_last_error() !== JSON_ERROR_NONE)
                    throw new Exception(__('Invalid response data!', CPT_TEXT_DOMAIN));

                update_option('cpt_oauth', $body);
                set_transient(CPT_SERVER_REQUESTABLE, 1, DAY_IN_SECONDS * 7);
                $result = [
                    'stt' => true,
                    'msg' => __('Verified Successfully!', CPT_TEXT_DOMAIN),
                    'data' => $body,
                ];
            } catch (Exception $e) {
                set_transient(CPT_SERVER_REQUESTABLE, -1, DAY_IN_SECONDS * 7);
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => [],
                ];
            }

            wp_send_json($result);
            die();
        }

        function log_out()
        {
            try {
                update_option('cpt_oauth', '');
                $result = [
                    'stt' => true,
                    'msg' => __('Successfully!', CPT_TEXT_DOMAIN),
                    'data' => [],
                ];
            } catch (Exception $e) {
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => [],
                ];
            }

            wp_send_json($result);
            die();
        }

        function install_plugin()
        {
            try {
                if (!isset($_POST['type']) || empty($_POST['type']) || !isset($_POST['plugin_slug']) || empty($_POST['plugin_slug'])) {
                    throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                }

                if (!check_ajax_referer('install-plugin', false, false))
                    throw new Exception(__('Invalid request!', CPT_TEXT_DOMAIN));

                // Check if user is administrator
                $current_user = wp_get_current_user();
                if (!in_array('administrator', (array) $current_user->roles))
                    throw new Exception(esc_html__('You are not allowed to do this!', 'wastia'));

                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

                $download_link = '';
                switch ($_POST['type']) {
                    case 'internal':
                        if (!isset($_POST['download_link']) || empty($_POST['download_link']))
                            throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                        if (!cpt_is_same_domain($_POST['download_link'], cpt_get_server_url())) {
                            throw new Exception(__('Invalid download link!', CPT_TEXT_DOMAIN));
                        }
                        $download_link = $_POST['download_link'];
                        break;
                    case 'external':
                        $api = plugins_api(
                            'plugin_information',
                            array(
                                'slug' => sanitize_key(wp_unslash($_POST['plugin_slug'])),
                                'fields' => array(
                                    'sections' => false,
                                ),
                            )
                        );
                        if (is_wp_error($api))
                            throw new Exception(__('Fail to get plugin information!', CPT_TEXT_DOMAIN));
                        $download_link = $api->download_link;
                        break;
                    default:
                        throw new Exception(__('Invalid plugin type!', CPT_TEXT_DOMAIN));
                }

                $skin = new WP_Ajax_Upgrader_Skin();
                $upgrader = new Plugin_Upgrader($skin);
                $install_result = $upgrader->install($download_link);

                if (!$install_result)
                    throw new Exception(__('Fail to install plugin!', CPT_TEXT_DOMAIN));
                $installed_plugins = [];
                $installed_plugins_data = get_plugins();
                foreach ($installed_plugins_data as $installed_plugin_file => $installed_plugin_data) {
                    $installed_plugin_file = explode('/', $installed_plugin_file);
                    $installed_plugins[$installed_plugin_file[0]] = $installed_plugin_data;
                }
                $result = [
                    'stt' => true,
                    'msg' => __('Successfully!', CPT_TEXT_DOMAIN),
                    'data' => $installed_plugins,
                ];
            } catch (Exception $e) {
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => '',
                ];
            }

            wp_send_json($result);
            die();
        }

        function activate_plugin()
        {
            try {
                if (!isset($_POST['plugin_slug']) || empty($_POST['plugin_slug'])) {
                    throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                }

                if (!check_ajax_referer('activate-plugin', false, false))
                    throw new Exception(__('Invalid request!', CPT_TEXT_DOMAIN));

                // Check if user is administrator
                $current_user = wp_get_current_user();
                if (!in_array('administrator', (array) $current_user->roles))
                    throw new Exception(esc_html__('You are not allowed to do this!', 'wastia'));

                $result = [
                    'stt' => false,
                    'msg' => __('Fail!', CPT_TEXT_DOMAIN),
                    'data' => [],
                ];

                $installed_plugins_data = get_plugins();
                foreach ($installed_plugins_data as $installed_plugin_file => $installed_plugin_data) {
                    $_installed_plugin_file = explode('/', $installed_plugin_file);
                    if ($_installed_plugin_file[0] == $_POST['plugin_slug']) {
                        if (is_plugin_active($installed_plugin_file)) {
                            throw new Exception(__('Plugin was activated!', CPT_TEXT_DOMAIN));
                        } else {
                            // null|WP_Error Null on success, WP_Error on invalid file.
                            $active_result = activate_plugin($installed_plugin_file);

                            if (!is_null($active_result)) {
                                $result = [
                                    'stt' => false,
                                    'msg' => __('Fail to activate plugin!', CPT_TEXT_DOMAIN),
                                    'data' => [],
                                ];
                            } else {
                                $active_plugins = [];
                                $active_plugins_data = get_option('active_plugins');
                                foreach ($active_plugins_data as $active_plugin_file) {
                                    $active_plugin_file = explode('/', $active_plugin_file);
                                    $active_plugins[] = $active_plugin_file[0];
                                }
                                $result = [
                                    'stt' => true,
                                    'msg' => __('Successfully!', CPT_TEXT_DOMAIN),
                                    'data' => $active_plugins,
                                ];
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => '',
                ];
            }

            wp_send_json($result);
            die();
        }

        function update_plugin()
        {
            try {
                if (!isset($_POST['type']) || empty($_POST['type']) || !isset($_POST['plugin_slug']) || empty($_POST['plugin_slug'])) {
                    throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                }

                if (!check_ajax_referer('update-plugin', false, false))
                    throw new Exception(__('Invalid request!', CPT_TEXT_DOMAIN));

                // Check if user is administrator
                $current_user = wp_get_current_user();
                if (!in_array('administrator', (array) $current_user->roles))
                    throw new Exception(esc_html__('You are not allowed to do this!', 'wastia'));

                $result = [
                    'stt' => false,
                    'msg' => __('Fail!', CPT_TEXT_DOMAIN),
                    'data' => [],
                ];

                if ($_POST['type'] == 'internal') {
                    if (!isset($_POST['download_link']) || empty($_POST['download_link'])) {
                        throw new Exception(message: __('Something went wrong!', CPT_TEXT_DOMAIN));
                    }
                    if (!cpt_is_same_domain($_POST['download_link'], cpt_get_server_url())) {
                        throw new Exception(__('Invalid download link!', CPT_TEXT_DOMAIN));
                    }
                    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

                    $installed_plugins_data = get_plugins();
                    foreach ($installed_plugins_data as $installed_plugin_file => $installed_plugin_data) {
                        $_installed_plugin_file = explode('/', $installed_plugin_file);
                        if ($_installed_plugin_file[0] == $_POST['plugin_slug']) {
                            $repo_updates = get_site_transient('update_plugins');

                            if (!is_object($repo_updates)) {
                                $repo_updates = new stdClass;
                            }

                            if (empty($repo_updates->response[$installed_plugin_file])) {
                                $repo_updates->response[$installed_plugin_file] = new stdClass;
                            }

                            $repo_updates->response[$installed_plugin_file]->slug = $_POST['plugin_slug'];
                            $repo_updates->response[$installed_plugin_file]->plugin = $installed_plugin_file;
                            $repo_updates->response[$installed_plugin_file]->package = $_POST['download_link'];

                            set_site_transient('update_plugins', $repo_updates);

                            $skin = new WP_Ajax_Upgrader_Skin();
                            $upgrader = new Plugin_Upgrader($skin);
                            $update_result = $upgrader->upgrade($installed_plugin_file);

                            if (!$update_result) {
                                $result = [
                                    'stt' => false,
                                    'msg' => __('Fail to update plugin!', CPT_TEXT_DOMAIN),
                                    'data' => [],
                                ];
                            } else {
                                $activate_result = activate_plugin($installed_plugin_file);

                                if (!is_null($activate_result)) {
                                    $result = [
                                        'stt' => false,
                                        'msg' => __('Fail to reactivate plugin after updated!', CPT_TEXT_DOMAIN),
                                        'data' => [],
                                    ];
                                } else {
                                    $installed_plugins = [];
                                    $installed_plugins_data = get_plugins();
                                    foreach ($installed_plugins_data as $installed_plugin_file => $installed_plugin_data) {
                                        $installed_plugin_file = explode('/', $installed_plugin_file);
                                        $installed_plugins[$installed_plugin_file[0]] = $installed_plugin_data;
                                    }
                                    $result = [
                                        'stt' => true,
                                        'msg' => __('Successfully!', CPT_TEXT_DOMAIN),
                                        'data' => $installed_plugins,
                                    ];
                                }
                            }
                        }
                    }
                } elseif ($_POST['type'] == 'external') {
                    $_POST['slug'] = $_POST['plugin_slug'];
                    $_POST['plugin'] = $_POST['plugin_slug'];
                    $installed_plugins_data = get_plugins();
                    foreach ($installed_plugins_data as $installed_plugin_file => $installed_plugin_data) {
                        $_installed_plugin_file = explode('/', $installed_plugin_file);
                        if ($_installed_plugin_file[0] == $_POST['plugin_slug']) {
                            $_POST['plugin'] = $installed_plugin_file;
                        }
                    }
                    $plugin = plugin_basename(sanitize_text_field(wp_unslash($_POST['plugin'])));

                    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

                    wp_update_plugins();

                    $skin = new WP_Ajax_Upgrader_Skin();
                    $upgrader = new Plugin_Upgrader($skin);
                    $result = $upgrader->bulk_upgrade(array($plugin));
                    if (is_wp_error($skin->result)) {
                        $result = [
                            'stt' => false,
                            'msg' => $skin->result->get_error_message(),
                            'data' => [],
                        ];
                    } elseif ($skin->get_errors()->has_errors()) {
                        $result = [
                            'stt' => false,
                            'msg' => $skin->get_error_messages(),
                            'data' => [],
                        ];
                    } elseif (is_array($result) && !empty($result[$plugin])) {
                        $installed_plugins = [];
                        $installed_plugins_data = get_plugins();
                        foreach ($installed_plugins_data as $installed_plugin_file => $installed_plugin_data) {
                            $installed_plugin_file = explode('/', $installed_plugin_file);
                            $installed_plugins[$installed_plugin_file[0]] = $installed_plugin_data;
                        }
                        $result = [
                            'stt' => true,
                            'msg' => __('Successfully!', CPT_TEXT_DOMAIN),
                            'data' => $installed_plugins,
                        ];
                    } elseif (false === $result) {
                        global $wp_filesystem;

                        $result = [
                            'stt' => false,
                            'msg' => __('Unable to connect to the filesystem. Please confirm your credentials.', CPT_TEXT_DOMAIN),
                            'data' => [],
                        ];

                        // Pass through the error from WP_Filesystem if one was raised.
                        if ($wp_filesystem instanceof WP_Filesystem_Base && is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->has_errors()) {
                            $result['msg'] = esc_html($wp_filesystem->errors->get_error_message());
                        }
                    }
                }
            } catch (Exception $e) {
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => '',
                ];
            }

            wp_send_json($result);
            die();
        }

        function update_theme()
        {
            try {
                if (!isset($_POST['download_link']) || empty($_POST['download_link'])) {
                    throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                }
                if (!check_ajax_referer('update-theme', false, false))
                    throw new Exception(__('Invalid request!', CPT_TEXT_DOMAIN));
                if (!cpt_is_same_domain($_POST['download_link'], cpt_get_server_url())) {
                    throw new Exception(__('Invalid download link!', CPT_TEXT_DOMAIN));
                }
                // Check if user is administrator
                $current_user = wp_get_current_user();
                if (!in_array('administrator', (array) $current_user->roles))
                    throw new Exception(esc_html__('You are not allowed to do this!', 'wastia'));
                $current_theme = wp_get_theme();
                if (is_child_theme()) {
                    $current_theme = $current_theme->parent();
                }
                $params = [
                    'host' => str_replace('www.', '', cpt_get_host()),
                    'theme_slug' => $current_theme->get('TextDomain'),
                ];

                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                include_once ABSPATH . 'wp-admin/includes/theme-install.php';

                $repo_updates = get_site_transient('update_themes');
                if (!is_object($repo_updates)) {
                    $repo_updates = new stdClass;
                }

                if (empty($repo_updates->response[$params['theme_slug']])) {
                    $repo_updates->response[$params['theme_slug']] = [];
                }

                $repo_updates->response[$params['theme_slug']]['theme'] = $params['theme_slug'];
                $repo_updates->response[$params['theme_slug']]['package'] = $_POST['download_link'];

                set_site_transient('update_themes', $repo_updates);

                $skin = new WP_Ajax_Upgrader_Skin();
                $upgrader = new Theme_Upgrader($skin);
                $update_result = $upgrader->upgrade($params['theme_slug']);

                if (!$update_result) {
                    $result = [
                        'stt' => false,
                        'msg' => __('Fail to update theme!', CPT_TEXT_DOMAIN),
                        'data' => []
                    ];
                } else {
                    $result = [
                        'stt' => true,
                        'msg' => __('Successfully!', CPT_TEXT_DOMAIN),
                        'data' => []
                    ];
                }
            } catch (Exception $e) {
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => [],
                ];
            }

            wp_send_json($result);
            die();
        }

        function can_import_demo()
        {
            $result = [
                'stt' => false,
                'msg' => 'Please make sure installed Import Plugin',
                'data' => [],
            ];

            if ((class_exists('SWA_Import_Export') || class_exists('EF3_Import_Export')) && (class_exists('Elementor_Theme_Core') || class_exists('CmssuperheroesCore'))) {
                $url = '';
                if (class_exists('SWA_Import_Export')) {
                    $url = admin_url('admin.php?page=swa-import');
                } elseif (class_exists('EF3_Import_Export')) {
                    $url = admin_url('admin.php?page=ef3-import-and-export');
                }
                $result = [
                    'stt' => true,
                    'msg' => 'Installed Import Plugin',
                    'data' => esc_url($url),
                ];
            }

            wp_send_json($result);
            die();
        }

        function dismiss()
        {
            try {
                if (!isset($_POST['key']) || empty($_POST['key'])) {
                    throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                }

                switch ($_POST['key']) {
                    case CPT_DISMISS_THEME_INFO:
                        set_transient(CPT_DISMISS_THEME_INFO, true, DAY_IN_SECONDS * 7);
                        break;

                    case CPT_DISMISS_REQUIRED_PLUGINS:
                        set_transient(CPT_DISMISS_REQUIRED_PLUGINS, true, DAY_IN_SECONDS * 7);
                        break;
                }

                $result = [
                    'stt' => true,
                    'msg' => __('Dismiss Successfully', CPT_TEXT_DOMAIN),
                    'data' => [],
                ];
            } catch (Exception $e) {
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => [],
                ];
            }

            wp_send_json($result);
            die();
        }

        function update_auth()
        {
            try {
                if (!isset($_POST['oAuth']) || empty($_POST['oAuth'])) {
                    throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                }

                update_option('cpt_oauth', $_POST['oAuth']);

                $result = [
                    'stt' => true,
                    'msg' => __('Update Authentication Successfully', CPT_TEXT_DOMAIN),
                    'data' => [],
                ];
            } catch (Exception $e) {
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => [],
                ];
            }

            wp_send_json($result);
            die();
        }

        function update_required_plugins()
        {
            try {
                if (!isset($_POST['required_plugins']) || empty($_POST['required_plugins'])) {
                    throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                }

                set_transient(CPT_REQUIRED_PLUGINS_OPTION, $_POST['required_plugins'], DAY_IN_SECONDS * 7);

                $result = [
                    'stt' => true,
                    'msg' => __('Update Required Plugins Successfully', CPT_TEXT_DOMAIN),
                    'data' => [],
                ];
            } catch (Exception $e) {
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => [],
                ];
            }

            wp_send_json($result);
            die();
        }

        function update_theme_info()
        {
            try {
                if (!isset($_POST['theme']) || empty($_POST['theme'])) {
                    throw new Exception(__('Something went wrong!', CPT_TEXT_DOMAIN));
                }

                set_transient(CPT_THEME_OPTION, $_POST['theme'], DAY_IN_SECONDS * 7);

                $result = [
                    'stt' => true,
                    'msg' => __('Update Required Plugins Successfully', CPT_TEXT_DOMAIN),
                    'data' => [],
                ];
            } catch (Exception $e) {
                $result = [
                    'stt' => false,
                    'msg' => $e->getMessage(),
                    'data' => [],
                ];
            }

            wp_send_json($result);
            die();
        }
    }
}