<?php
/**
 * Add child styles.
 */
function allianz_child_enqueue_styles()
{
  wp_enqueue_style('allianz-child', get_stylesheet_directory_uri() . '/assets/css/child-theme.css', array('allianz'));
}
add_action('wp_enqueue_scripts', 'allianz_child_enqueue_styles', 10 , 99999);
/**
  * Set up Allianz Child Theme's textdomain.
  *
  * Declare textdomain for this child theme.
  * Translations can be added to the /languages/ directory.
  */
add_action( 'after_setup_theme', 'allianz_child_theme_setup' );
function allianz_child_theme_setup() {
    load_child_theme_textdomain( 'allianz-child', get_stylesheet_directory() . '/languages' );
}
/**
 * CMS Portal
 * child theme active
 *
*/
add_action('after_switch_theme', 'allianz_child_redirect_to_welcome_page');
function allianz_child_redirect_to_welcome_page()
{
    if (is_child_theme()) {
        $parent_theme = wp_get_theme()->parent();
        if (class_exists('CMS_PORTAL')) {
            wp_safe_redirect(admin_url("themes.php?page={$parent_theme->get('TextDomain')}"));
        } else {
            wp_safe_redirect(admin_url("themes.php?page={$parent_theme->get('TextDomain')}-welcome"));
        }
    }
}