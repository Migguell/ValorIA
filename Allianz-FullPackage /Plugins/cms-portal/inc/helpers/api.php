<?php
if (!function_exists('cpt_get_required_plugins')) {
    function cpt_get_required_plugins()
    {
        $required_plugins = get_transient(CPT_REQUIRED_PLUGINS_OPTION);
        if (false === $required_plugins || !CPT_CACHE_ALLOWED) {
            return [
                'stt' => false,
                'msg' => __('Fail!', CPT_TEXT_DOMAIN),
                'data' => [],
            ];
        }

        return [
            'stt' => true,
            'msg' => __('Successfully!', CPT_TEXT_DOMAIN),
            'data' => $required_plugins
        ];
    }
}

if (!function_exists('cpt_get_theme')) {
    function cpt_get_theme()
    {
        $theme = get_transient(CPT_THEME_OPTION);
        if (false === $theme || !CPT_CACHE_ALLOWED) {
            return [
                'stt' => false,
                'msg' => __('Fail!', CPT_TEXT_DOMAIN),
                'data' => []
            ];
        }
        
        return [
            'stt' => true,
            'msg' => __('Successfully!', CPT_TEXT_DOMAIN),
            'data' => $theme
        ];
    }
}

if (!function_exists('cpt_validate_required_plugins')) {
    function cpt_validate_required_plugins()
    {
        $result = cpt_get_required_plugins();
        $required_plugins = $result['data'];
        if (empty($required_plugins)) {
            $required_plugins = [
                'external_plugins' => [],
                'internal_plugins' => [],
            ];
        }
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

        $result = [
            'need_install' => false,
            'need_activate' => false,
            'need_update' => false,
        ];

        foreach ($required_plugins['external_plugins'] as $plugin_slug => $plugin_data) {
            $is_installed = isset($installed_plugins[$plugin_slug]);
            $is_active = in_array($plugin_slug, $active_plugins);
            $need_update = isset($installed_plugins[$plugin_slug]) && version_compare($plugin_data['version'], $installed_plugins[$plugin_slug]['Version'], '>');
            if (!$is_installed) {
                $result['need_install'] = true;
            } else {
                if (!$is_active) {
                    $result['need_activate'] = true;
                }
            }
        }

        foreach ($required_plugins['internal_plugins'] as $plugin_slug => $plugin_data) {
            $is_installed = isset($installed_plugins[$plugin_slug]);
            $is_active = in_array($plugin_slug, $active_plugins);
            $need_update = isset($installed_plugins[$plugin_slug]) && version_compare($plugin_data['version'], $installed_plugins[$plugin_slug]['Version'], '>');
            if (!$is_installed) {
                $result['need_install'] = true;
            } else {
                if (!$is_active) {
                    $result['need_activate'] = true;
                }
            }
            if ($need_update) {
                $result['need_update'] = true;
            }
        }

        return $result;
    }
}
?>