<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 *
 */
class CPTMenuPage
{
    function __construct()
    {
        add_action('admin_menu', [$this, 'cpt_add_menu']);
//        add_action('admin_bar_menu', [$this, 'cms_add_admin_bar_menu'], 100);
    }

    public function cpt_add_menu()
    {
        $current_theme = wp_get_theme();
        if (is_child_theme()) {
            $current_theme = $current_theme->parent();
        }
        $theme_name = $current_theme->get('Name');
        $theme_text_domain = $current_theme->get('TextDomain');
        // <span class="update-plugins count-1"><span class="update-count">1</span></span>
        add_menu_page($theme_name, $theme_name, 'manage_options', $theme_text_domain, [
            $this,
            'cpt_add_dashboard_page'
        ], 'dashicons-admin-generic', 3);

        add_submenu_page($theme_text_domain, $theme_name, __('Dashboard', CPT_TEXT_DOMAIN), 'manage_options', $theme_text_domain, [
            $this,
            'cpt_add_dashboard_page'
        ], 0);
    }

    public function cpt_add_dashboard_page()
    {
        cpt_get_template_file_e('pages/dashboard.php');
    }

    public function cpt_add_plugins_page()
    {
        cpt_get_template_file_e('pages/plugins.php');
    }

    public function cpt_add_themes_page()
    {
        cpt_get_template_file_e('pages/themes.php');
    }
}