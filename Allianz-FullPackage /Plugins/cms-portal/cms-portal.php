<?php
/**
 * Plugin Name: CMS Portal
 * Description: Support to install, activate and update Plugins and Themes
 * Plugin URI:  https://cmssuperheroes.com/
 * Version:     2.1.0
 * Author:      KennethRoy
 * Author URI:  https://cmssuperheroes.com/
 * Text Domain: cms-portal
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('CPT_TEXT_DOMAIN', 'cms-portal');
define('CPT_PATH', __DIR__);
define('CPT_URL', plugin_dir_url(__FILE__));
define('CPT_TEMPLATE_PATH', 'cms-portal' . DIRECTORY_SEPARATOR);
define('CPT_SERVER_URL', 'https://core.cmssuperheroes.com/wp-json/api-bearer-auth/v1');
define('CPT_FAROST_SERVER_URL', 'https://core.farost.net/wp-json/api-bearer-auth/v1');
define('CPT_7OROOF_SERVER_OLD_URL', 'https://core.7oroof.com/wp-json/api-bearer-auth/v1');
define('CPT_7OROOF_SERVER_URL', 'https://core.7oroofthemes.com/wp-json/api-bearer-auth/v1');
define('CMS_PORTAL_VERSION', '2.1.0');
define('CPT_SELF_CHECKING', 'cpt-self-checking');
define('CPT_DISMISS_THEME_INFO', 'cpt-dismiss-theme-info');
define('CPT_DISMISS_REQUIRED_PLUGINS', 'cpt-dismiss-required-plugins');
define('CPT_REQUIRED_PLUGINS_OPTION', 'cpt-required-plugins-option');
define('CPT_THEME_OPTION', 'cpt-theme-option');
define('CPT_PLUGIN_DOWNLOAD_LINK_OPTION', 'cpt-plugin-download-link');
define('CPT_THEME_DOWNLOAD_LINK_OPTION', 'cpt-theme-download-link');
define('CPT_SERVER_REQUESTABLE', 'cpt-server-requestable');
define('CPT_CACHE_ALLOWED', true);

final class CMS_PORTAL
{
    private static $_instance = null;

    public $plugin_slug;
    public $plugin_base_name;
    public $menu_page;
    public $ajax_handle;

    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;

    }

    public function __construct()
    {
        $this->plugin_slug = plugin_basename(__DIR__);
        $this->plugin_base_name = plugin_basename(__FILE__);

        add_action('init', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init']);

        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue']);

        add_action('admin_init', array($this, 'disable_revslider_open_welcome_page'));
        add_action('admin_init', array($this, 'disable_vc_open_welcome_page'));
        add_action('admin_init', array($this, 'disable_woo_variation_swatches_open_welcome_page'));
        add_action('admin_init', array($this, 'disable_newsletter_open_welcome_page'));
        add_action('admin_init', array($this, 'disable_booked_open_welcome_page'), 8);
        add_action('admin_init', array($this, 'disable_custom_post_type_ui_open_welcome_page'), 0);
        add_action('admin_init', array($this, 'disable_elementor_open_welcome_page'));

        add_filter('plugins_api', array($this, 'info'), 20, 3);
        add_filter('site_transient_update_plugins', array($this, 'update'));
        add_action('upgrader_process_complete', array($this, 'purge'), 10, 2);
    }

    public function i18n()
    {
        load_plugin_textdomain(CPT_TEXT_DOMAIN);
    }

    public function init()
    {
        require_once __DIR__ . '/inc/helpers/template.php';
        require_once __DIR__ . '/inc/helpers/common.php';
        require_once __DIR__ . '/inc/helpers/api.php';

        if (!class_exists('CPTMenuPage')) {
            require_once CPT_PATH . '/inc/classes/class-menu-page.php';
            $this->menu_page = new CPTMenuPage();
        }

        if (!class_exists('CPTAjaxHandle')) {
            require_once CPT_PATH . '/inc/classes/class-ajax-handle.php';
            $this->ajax_handle = new CPTAjaxHandle();
        }

        // add_action('admin_notices', [$this, 'admin_notice_introduction_theme']);
        // add_action('admin_notices', [$this, 'admin_notice_required_plugins']);
    }

    public function enqueue()
    {

    }

    public function admin_enqueue()
    {
        $current_theme = wp_get_theme();
        if (is_child_theme()) {
            $current_theme = $current_theme->parent();
        }
        wp_enqueue_style('bootstrap-css', CPT_URL . 'assets/css/bootstrap.css', [], '4.5.0');
        wp_enqueue_style('cpt-admin-css', CPT_URL . 'assets/css/admin/main.css', [], CMS_PORTAL_VERSION);
        wp_enqueue_style('cpt-alert-css', CPT_URL . 'assets/css/admin/alert.css', [], CMS_PORTAL_VERSION);
        $cms_portal_localizes = [];
        if (isset($_GET['page']) && $_GET['page'] == $current_theme->get('TextDomain')) {
            wp_enqueue_script('underscore');
            wp_enqueue_script('cpt-alert-js', CPT_URL . 'assets/js/admin/alert.js', ['jquery'], CMS_PORTAL_VERSION);
            wp_enqueue_script('cpt-admin-js', CPT_URL . 'assets/js/admin/main.js', ['jquery', 'cpt-alert-js'], CMS_PORTAL_VERSION);

            $current_theme = wp_get_theme();
            if (is_child_theme()) {
                $current_theme = $current_theme->parent();
            }
            $server_url = cpt_get_server_url();
            $cpt_dashboard_config = apply_filters('cpt_dashboard_config', []);
            $cpt_dashboard_config = array_merge([
                'documentation_link' => '#',
                'ticket_link' => '#',
                'video_tutorial_link' => '#',
                'demo_link' => '#',
                'rating_link' => 'https://themeforest.net/downloads',
            ], $cpt_dashboard_config);
            $dev_mode = apply_filters('cpt_dev_mode', false);

            $installed_plugins = [];
            $installed_plugins_data = get_plugins();
            foreach ($installed_plugins_data as $installed_plugin_file => $installed_plugin_data) {
                $installed_plugin_file = explode('/', $installed_plugin_file);
                $installed_plugins[$installed_plugin_file[0]] = $installed_plugin_data;
            }

            $active_plugins = [];
            $active_plugins_data = get_option('active_plugins');
            foreach ($active_plugins_data as $active_plugin_file) {
                $active_plugin_file = explode('/', $active_plugin_file);
                $active_plugins[] = $active_plugin_file[0];
            }

            $result_required_plugins = cpt_get_required_plugins();
            $result_theme = cpt_get_theme();

            $cms_portal_localizes = [
                'ajax_url' => admin_url('admin-ajax.php'),
                'host' => str_replace('www.', '', cpt_get_host()),
                'dashboard_config' => $cpt_dashboard_config,
                'dev_mode' => $dev_mode,
                'current_theme' => [
                    'slug' => $current_theme->get('TextDomain'),
                    'name' => $current_theme->get('Name'),
                    'description' => $current_theme->get('Description'),
                    'version' => $current_theme->get('Version'),
                    'author' => $current_theme->get('Author'),
                    'author_uri' => $current_theme->get('AuthorURI'),
                    'screenshot' => $current_theme->get_screenshot(),
                    'logo' => apply_filters('cpt_theme_logo', get_template_directory_uri() . '/assets/images/logo/logo.png'),
                ],
                'auth' => get_option('cpt_oauth'),
                'api' => [
                    'verify_purchase_code' => $server_url . '/verify/purchase-code',
                    'tokens_verify' => $server_url . '/tokens/verify',
                    'tokens_refresh' => $server_url . '/tokens/refresh',
                    'login' => $server_url . '/login',
                    'disconnect' => $server_url . '/disconnect',
                    'get_required_plugins' => $server_url . '/get/required-plugins',
                    'get_plugin_download_link' => $server_url . '/get/plugin-download-link',
                    'get_theme_download_link' => $server_url . '/get/theme-download-link',
                    'get_plugin' => $server_url . '/get/plugin',
                    'get_theme' => $server_url . '/get/theme',
                ],
                'cache' => [
                    CPT_DISMISS_THEME_INFO => get_transient(CPT_DISMISS_THEME_INFO),
                    CPT_DISMISS_REQUIRED_PLUGINS => get_transient(CPT_DISMISS_REQUIRED_PLUGINS),
                    CPT_REQUIRED_PLUGINS_OPTION => $result_required_plugins['data'],
                    CPT_THEME_OPTION => $result_theme['data'],
                    CPT_SERVER_REQUESTABLE => cpt_server_requestable(),
                ],
                'installed_plugins' => $installed_plugins,
                'active_plugins' => $active_plugins,
            ];
        }
        else{
            wp_enqueue_script('cpt-dismiss-js', CPT_URL . 'assets/js/admin/dismiss.js', ['jquery'], CMS_PORTAL_VERSION);
            $cms_portal_localizes = [
                'ajax_url' => admin_url('admin-ajax.php'),
            ];
        }

        wp_localize_script('jquery', 'cms_portal', $cms_portal_localizes);
    }

    public function admin_notice_introduction_theme()
    {
        $transient = get_transient(CPT_DISMISS_THEME_INFO);

        if (false !== $transient && CPT_CACHE_ALLOWED) {
            return;
        }

        $screen = get_current_screen();
        if ($screen->parent_file != 'index.php') {
            return;
        }

        $current_theme = wp_get_theme();
        if (is_child_theme()) {
            $current_theme = $current_theme->parent();
        }
        $cpt_dashboard_config = apply_filters('cpt_dashboard_config', []);
        $cpt_dashboard_config = array_merge([
            'documentation_link' => '#',
            'ticket_link' => '#',
            'video_tutorial_link' => '#',
            'demo_link' => '#',
            'rating_link' => 'https://themeforest.net/downloads',
        ], $cpt_dashboard_config);

        ?>
        <div class="cpt-container cpt-notice notice is-dismissible">
            <?php
            cpt_get_template_file_e('partials/theme-info.php', [
                'config' => $cpt_dashboard_config,
            ]);
            ?>
            <button type="button" class="cpt-notice-dismiss notice-dismiss" data-key="<?php echo esc_attr(CPT_DISMISS_THEME_INFO); ?>">
                <span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', CPT_TEXT_DOMAIN); ?></span>
            </button>
        </div>
        <?php
    }

    public function admin_notice_required_plugins()
    {
        $transient = get_transient(CPT_DISMISS_REQUIRED_PLUGINS);

        if (false !== $transient && CPT_CACHE_ALLOWED) {
            return;
        }

        $screen = get_current_screen();
        if ($screen->parent_file == 'plugins.php') {
            return;
        }

        $result = cpt_validate_required_plugins();

        if (!$result['need_install'] && !$result['need_activate'] && !$result['need_update']) {
            return;
        }

        $current_theme = wp_get_theme();
        if (is_child_theme()) {
            $current_theme = $current_theme->parent();
        }

        $screen = get_current_screen();
        if ($screen->parent_file == $current_theme->get('TextDomain')) {
            return;
        }

        ?>
        <div class="cpt-container notice notice-warning is-dismissible">
            <?php
            cpt_get_template_file_e('partials/validate-reuqired-plugins.php', [
                'validate_required_plugins_result' => $result,
            ]);
            ?>
            <button type="button" class="cpt-notice-dismiss notice-dismiss" data-key="<?php echo esc_attr(CPT_DISMISS_REQUIRED_PLUGINS); ?>">
                <span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', CPT_TEXT_DOMAIN); ?></span>
            </button>
        </div>
        <?php
    }

    public function request()
    {

        $remote = get_transient(CPT_SELF_CHECKING);

        if (false === $remote || !CPT_CACHE_ALLOWED) {

            $params = [
                'plugin_slug' => $this->plugin_slug,
            ];

            $request = wp_remote_post(cpt_get_server_url() . "/get/plugin", [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($params),
                'sslverify' => false,
            ]);
            $responseCode = wp_remote_retrieve_response_code( $request );
            if($responseCode !== 200){
                // $responseMessage = wp_remote_retrieve_response_message( $request );
                return false;
            }
            $body = @json_decode(wp_remote_retrieve_body($request));
            if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
                return false;
            }
            if (!isset($body->download_url) || empty($body->download_url)) {
                return false;
            }
            $remote = $body;

            set_transient(CPT_SELF_CHECKING, $remote, DAY_IN_SECONDS * 7);

        }

        return $remote;

    }

    function info($res, $action, $args)
    {
        // do nothing if you're not getting plugin information right now
        if ('plugin_information' !== $action) {
            return false;
        }

        // do nothing if it is not our plugin
        if ($this->plugin_slug !== $args->slug) {
            return false;
        }

        // get updates
        $remote = $this->request();

        if (!$remote) {
            return false;
        }

        $res = new stdClass();

        $res->name = $remote->name;
        $res->slug = $remote->slug;
        $res->version = $remote->version;
        $res->tested = $remote->tested;
        $res->requires = $remote->requires;
        $res->author = $remote->author;
        $res->author_profile = $remote->author_profile;
        $res->download_link = $remote->download_url;
        $res->trunk = $remote->download_url;
        $res->requires_php = $remote->requires_php;
        $res->last_updated = $remote->last_updated;

        $res->sections = array(
            'description' => $remote->sections->description,
            'installation' => $remote->sections->installation,
            'changelog' => $remote->sections->changelog,
        );

        if (!empty($remote->banners)) {
            $res->banners = array(
                'low' => $remote->banners->low,
                'high' => $remote->banners->high,
            );
        }

        return $res;

    }

    public function update($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }

        $remote = $this->request();

        if (
            $remote
            && version_compare(CMS_PORTAL_VERSION, $remote->version, '<')
            && version_compare($remote->requires, get_bloginfo('version'), '<')
            && version_compare($remote->requires_php, PHP_VERSION, '<')
        ) {
            $res = new stdClass();
            $res->slug = $this->plugin_slug;
            $res->plugin = $this->plugin_base_name; // swa-demo-bar/swa-demo-bar.php
            $res->new_version = $remote->version;
            $res->tested = $remote->tested;
            $res->package = $remote->download_url;

            $transient->response[$res->plugin] = $res;

        }

        return $transient;

    }

    public function purge($upgrader, $options)
    {

        if (
            CPT_CACHE_ALLOWED
            && 'update' === $options['action']
            && 'plugin' === $options['type']
        ) {
            // just clean the cache when new plugin version is installed
            delete_transient(CPT_SELF_CHECKING);
        }

    }

    public function disable_revslider_open_welcome_page()
    {
        delete_transient('_revslider_welcome_screen_activation_redirect');
    }

    public function disable_vc_open_welcome_page()
    {
        delete_transient('_vc_page_welcome_redirect');
    }

    public function disable_woo_variation_swatches_open_welcome_page()
    {
        delete_option('activate-woo-variation-swatches');
    }

    public function disable_newsletter_open_welcome_page()
    {
        delete_option('newsletter_show_welcome');
    }

    public function disable_booked_open_welcome_page()
    {
        delete_transient('_booked_welcome_screen_activation_redirect');
        delete_option('booked_welcome_screen');
    }

    public function disable_custom_post_type_ui_open_welcome_page()
    {
        delete_transient('cptui_activation_redirect');
    }

    public function disable_elementor_open_welcome_page()
    {
        delete_transient('elementor_activation_redirect');
    }
}

CMS_PORTAL::instance();