<?php
/**
 * Helper functions for the theme
 *
 * @package Allianz
 */

/**
 * Check is Blog page
 * 
 * */

if(!function_exists('cms_is_blog')){
    function cms_is_blog(){
        if(!allianz_is_woocommerce() && ( is_home() || is_archive() || is_category() || is_tag() || is_author() || is_date() || is_post_type_archive() || is_tax() || is_search() ) ){
            return true;
        } else {
            return false;
        }
    }
}
/**
 * Check is Shop
 * 
 * */
if(!function_exists('cms_is_shop')){
    function cms_is_shop(){
        if(class_exists('WooCommerce')){
            if(is_shop()){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function allianz_body_classes($classes){
    //$classes[] = allianz_is_built_with_elementor() ? 'cms-is-elementor' : 'cms-not-elementor';
    //$classes[] = (allianz_get_opt('sidebar_on', 'off') === 'on') ? 'cms-has-sidebar' : 'cms-not-sidebar';
    //$classes[] = cms_is_blog() ? 'cms-blog-page' : '';
    $classes[] = 'cms-theme-cursor';
    $product_layout = allianz_get_opts('product_single_layout', 'single-product' ,'product_custom');
    $product_gallery = allianz_get_opts('product_gallery', 'slider' ,'product_custom');
    global $wp_query;
    $page = $wp_query->get( 'page' );
    if ( ! $page || $page < 2 ) {
        $page = $wp_query->get( 'paged' );
    }
    //unset($classes[0]);
    //unset($classes[1]);
    //unset($classes[2]);
    //unset($classes[3]);
    $classes[] = 'cms-heading-font-'.allianz_get_opts('heading_font','default');
    if(is_singular('product')){
        $classes[] = $product_layout;
        $classes[] = 'cms-product-gallery-'.$product_gallery;
    }
    if(is_404()){
        $classes[] = 'cms-404';
    }
    return $classes;
}
add_filter('body_class', 'allianz_body_classes');


function allianz_archive_title_remove_label($title){
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = get_the_author();
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    } elseif (is_home()) {
        $title = single_post_title('', false);
    }
    return $title;
}
add_filter('get_the_archive_title', 'allianz_archive_title_remove_label');
/**
 * Custom Post Type
 * 
 * **/
add_filter('cms_extra_post_types', 'allianz_add_posttype');
if(!function_exists('allianz_add_posttype')){
    function allianz_add_posttype($postypes){
        $portfolio      = allianz_get_opt('portfolio_slug', 'portfolio');
        $portfolio_name = allianz_get_opt(
            'portfolio_name',
            esc_attr__('Portfolio', 'allianz')
        );
        $postypes['portfolio'] = [
            'status'     => apply_filters('allianz_enable_portfolio', false),
            'item_name'  => $portfolio_name,
            'items_name' => $portfolio_name,
            'args' => [
                'menu_icon'          => 'dashicons-admin-post',
                'supports'           => ['title', 'thumbnail', 'editor','excerpt'],
                'public'             => true,
                'publicly_queryable' => true,
                'rewrite'            => [
                    'slug' => $portfolio,
                ],
            ],
            'labels' => [],
        ];
        // Service
        $postypes['cms-service'] = [
            'status'     => apply_filters('allianz_enable_service', false),
            'item_name'  => esc_html__('Service', 'allianz'),
            'items_name' => esc_html__('Services', 'allianz'),
            'args' => [
                'menu_icon'          => 'dashicons-admin-post',
                'supports'           => ['title', 'thumbnail', 'editor', 'excerpt'],
                'public'             => true,
                'publicly_queryable' => true,
                'rewrite'            => [
                    'slug' => apply_filters('allianz_cms_service_slug', 'service'),
                ],
            ],
            'labels' => [],
        ];
        // Industry
        $postypes['cms-industry'] = [
            'status'     => apply_filters('allianz_enable_industry', false),
            'item_name'  => esc_html__('Industry', 'allianz'),
            'items_name' => esc_html__('Industrys', 'allianz'),
            'args' => [
                'menu_icon'          => 'dashicons-admin-post',
                'supports'           => ['title', 'thumbnail', 'editor', 'excerpt'],
                'public'             => true,
                'publicly_queryable' => true,
                'rewrite'            => [
                    'slug' => apply_filters('allianz_cms_industry_slug', 'industry'),
                ],
            ],
            'labels' => [],
        ];
        // Case
        $postypes['cms-case'] = [
            'status'     => apply_filters('allianz_enable_case', false),
            'item_name'  => esc_html__('Case', 'allianz'),
            'items_name' => esc_html__('Cases', 'allianz'),
            'args' => [
                'menu_icon'          => 'dashicons-admin-post',
                'supports'           => ['title', 'thumbnail', 'editor', 'excerpt'],
                'public'             => true,
                'publicly_queryable' => true,
                'rewrite'            => [
                    'slug' => apply_filters('allianz_cms_case_slug', 'cases'),
                ],
            ],
            'labels' => [],
        ];
        // career
        $postypes['cms-career'] = [
            'status'     => apply_filters('allianz_enable_career', false),
            'item_name'  => esc_html__('Career', 'allianz'),
            'items_name' => esc_html__('Careers', 'allianz'),
            'args' => [
                'menu_icon'          => 'dashicons-admin-post',
                'supports'           => ['title', 'thumbnail', 'editor', 'excerpt'],
                'public'             => true,
                'publicly_queryable' => true,
                'rewrite'            => [
                    'slug' => apply_filters('allianz_cms_career_slug', 'career'),
                ],
            ],
            'labels' => [],
        ];
        // Side Nav
        $postypes['cms-sidenav'] = [
            'status'     => apply_filters('allianz_enable_sidenav', false),
            'item_name'  => esc_html__('Side Nav', 'allianz'),
            'items_name' => esc_html__('Side Navs', 'allianz'),
            'args'       => [
                'menu_icon'          => 'dashicons-editor-insertmore',
                'supports'           => ['title', 'editor', 'thumbnail'],
                'public'             => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true
            ],
            'labels' => []
        ];
        // Header Top
        $postypes['cms-header-top'] = [
            'status'     => apply_filters('allianz_enable_header_top', false),
            'item_name'  => esc_html__('Header Top', 'allianz'),
            'items_name' => esc_html__('Headers Top', 'allianz'),
            'args'       => [
                'menu_icon'          => 'dashicons-editor-insertmore',
                'supports'           => ['title', 'editor', 'thumbnail'],
                'public'             => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true
            ],
            'labels' => []
        ];
        // Footer
        $postypes['cms-footer'] = [
            'status'     => apply_filters('allianz_enable_footer', false),
            'item_name'  => esc_html__('Footer', 'allianz'),
            'items_name' => esc_html__('Footers', 'allianz'),
            'args'       => [
                'menu_icon'           => 'dashicons-editor-insertmore',
                'supports'            => ['title', 'editor', 'thumbnail'],
                'public'              => true,
                'publicly_queryable'  => true,
                'exclude_from_search' => true
            ],
            'labels' => []
        ];
        // Popup
        $postypes['cms-popup'] = [
            'status'     => apply_filters('allianz_enable_popup', false),
            'item_name'  => esc_html__('Pop Up', 'allianz'),
            'items_name' => esc_html__('Pop Ups', 'allianz'),
            'args'       => [
                'menu_icon'           => 'dashicons-editor-insertmore',
                'supports'            => ['title', 'editor', 'thumbnail'],
                'public'              => true,
                'publicly_queryable'  => true,
                'exclude_from_search' => true
            ],
            'labels' => []
        ];

        return $postypes;
    }
}
add_filter('cms_extra_taxonomies', 'allianz_add_tax');
if(!function_exists('allianz_add_tax')){
    function allianz_add_tax($taxonomies){
        $taxonomies['portfolio-category'] = [
            'status'      => apply_filters('allianz_enable_portfolio', false),
            'post_type'   => ['portfolio'],
            'taxonomy'    => esc_html__('Portfolio Category', 'allianz'),
            'taxonomies'  => esc_html__('Portfolio Categories', 'allianz'),
            'args'        => [],
            'labels'      => [],
        ];
        $taxonomies['service-category'] = [
            'status'      => apply_filters('allianz_enable_service', true),
            'post_type'   => ['cms-service'],
            'taxonomy'    => esc_html__('Service Category', 'allianz'),
            'taxonomies'  => esc_html__('Service Categories', 'allianz'),
            'args'        => [],
            'labels'      => [],
        ];
        $taxonomies['industry-category'] = [
            'status'      => apply_filters('allianz_enable_industry', true),
            'post_type'   => ['cms-industry'],
            'taxonomy'    => esc_html__('Industry Category', 'allianz'),
            'taxonomies'  => esc_html__('Industry Categories', 'allianz'),
            'args'        => [],
            'labels'      => [],
        ];
        $taxonomies['case-category'] = [
            'status'      => apply_filters('allianz_enable_case', true),
            'post_type'   => ['cms-case'],
            'taxonomy'    => esc_html__('Case Category', 'allianz'),
            'taxonomies'  => esc_html__('Case Categories', 'allianz'),
            'args'        => [],
            'labels'      => [],
        ];
        $taxonomies['career-category'] = [
            'status'      => apply_filters('allianz_enable_career', true),
            'post_type'   => ['cms-career'],
            'taxonomy'    => esc_html__('Career Category', 'allianz'),
            'taxonomies'  => esc_html__('Career Categories', 'allianz'),
            'args'        => [],
            'labels'      => [],
        ];
        return $taxonomies;
    }
}
/**
 * Pagination Ajax
 * **/
add_action('wp_ajax_allianz_get_pagination_html', 'allianz_get_pagination_html');
add_action('wp_ajax_nopriv_allianz_get_pagination_html', 'allianz_get_pagination_html');
if (!function_exists('allianz_get_pagination_html')) {
    function allianz_get_pagination_html()
    {
        try {
            if (!isset($_POST['query_vars'])) {
                throw new Exception(__('Something went wrong while requesting. Please try again!', 'allianz'));
            }
            $query = $_POST['query_vars'];
            if(isset($_POST['filter']) && !empty($_POST['filter'])){
                $query['tax_query'] = [
                    'relation'       => 'OR',
                ];
                $tmp = explode('|', $_POST['filter']);
                if (isset($tmp[0]) && isset($tmp[1])) {
                    $query['tax_query'][] = array(
                        'taxonomy' => $tmp[1],
                        'field' => 'slug',
                        'operator' => 'IN',
                        'terms' => array($tmp[0]),
                    );
                }
            }
            $query = new WP_Query($query);
            ob_start();
            allianz_posts_pagination($query, true);
            $html = ob_get_clean();
            wp_send_json(
                array(
                    'status' => true,
                    'message' => esc_html__('Load Successfully!', 'allianz'),
                    'data' => array(
                        'html' => $html,
                        'query_vars' => $_POST['query_vars'],
                        'post' => $query->have_posts()
                    ),
                )
            );
        } catch (Exception $e) {
            wp_send_json(array('status' => false, 'message' => $e->getMessage()));
        }
        die;
    }
}
add_action('wp_ajax_allianz_load_more_post_grid', 'allianz_load_more_post_grid');
add_action('wp_ajax_nopriv_allianz_load_more_post_grid', 'allianz_load_more_post_grid');
if(!function_exists('allianz_pagination_data')){
    add_filter('etc-pagination-data', 'allianz_pagination_data');
    function allianz_pagination_data() {
        return [
            'get_posts_action'      => 'allianz_load_more_post_grid',
            'get_pagination_action' => 'allianz_get_pagination_html',
        ];
    }
}
if (!function_exists('allianz_load_more_post_grid')) {
    function allianz_load_more_post_grid()
    {
        try {
            if (!isset($_POST['settings'])) {
                throw new Exception(__('Something went wrong while requesting. Please try again!', 'allianz'));
            }
            $settings = $_POST['settings'];
            set_query_var('paged', $settings['paged']);
            extract(etc_get_posts_of_grid($settings['posttype'], [
                'source' => isset($settings['source']) ? $settings['source'] : '',
                'orderby' => isset($settings['orderby']) ? $settings['orderby'] : 'date',
                'order' => isset($settings['order']) ? $settings['order'] : 'desc',
                'limit' => isset($settings['limit']) ? $settings['limit'] : '6',
                'post_ids' => '',
            ]));
            ob_start();
            allianz_get_post_grid($settings, $posts, $settings);
            $html = ob_get_clean();
            wp_send_json(
                array(
                    'status' => true,
                    'message' => esc_html__('Load Successfully!', 'allianz'),
                    'data' => array(
                        'html' => $html,
                        'paged' => $settings['paged'],
                        'posts' => $posts,
                        'max' => $max,
                    ),
                )
            );
        } catch (Exception $e) {
            wp_send_json(array('status' => false, 'message' => $e->getMessage()));
        }
        die;
    }
}

/**
 * @param string $str - String containing line breaks
 * @param string $tag - ul or ol
 * @param string $class - classes to add if required
 */
function allianz_nl2html($str,  $args = [])
{
    $args = wp_parse_args($args, [
        'item_before' => '<div>',
        'item_after'  => '</div>',
        'before'      => '',
        'after'       => ''
    ]);
    $bits = explode("\n", $str);

    if (empty($bits[0])) return;

    $newstring = [];
    foreach ($bits as $bit) {
        $newstring[] = $args['item_before'] . $bit . $args['item_after'];
    }
    return $args['before'] . implode('', $newstring) . $args['after'];
}

/**
 * ================================================
 * All function for Demo Data
 * 
 * @package CMS Theme
 * @subpackage Allianz
 * @since 1.0
 * ================================================
 * 
*/
/* Create Demo Data */
if(!function_exists('allianz_enable_export_mode')){
    function allianz_enable_export_mode() {
        return defined('DEV_MODE') && DEV_MODE == true ? true : false;
    }
}
add_filter('swa_ie_export_mode', 'allianz_enable_export_mode');
if (!function_exists('allianz_cpt_dev_mode')) {
    function allianz_cpt_dev_mode()
    {
        return defined('DEV_MODE') && DEV_MODE == true ? true : false;
    }
}
add_filter('cpt_dev_mode', 'allianz_cpt_dev_mode');
/**
 * Update custom post type edit with Elementor
 * **/
add_action('theme_core_ie_after_import', 'allianz_elementor_cpts');
add_action('after_switch_theme', 'allianz_elementor_cpts');
if (!function_exists('allianz_elementor_cpts')) {
    function allianz_elementor_cpts(){
        $default = (array)get_option('elementor_cpt_support');
        $cpt_support = array_merge(
            $default, 
            [
                //core
                'post',
                'page',
                'cms-footer',
                'cms-header-top',
                'cms-mega-menu',
                'portfolio',
                // theme
                'cms-career',
                'cms-case',
                'cms-industry',
                'cms-service',
                'cms-sidenav',
                // WooCommerce
                //'product'
            ]
        );
        update_option( 'elementor_cpt_support', $cpt_support );
    }
}
/**
 * Update Option TranslatePress
 * 
 * */
add_action('plugins_loaded', 'allianz_translatepress_configs');
add_action('activate_translatepress-multilingual/index.php', 'allianz_translatepress_configs');
add_action('theme_core_ie_after_import', 'allianz_translatepress_configs');
if(!function_exists('allianz_translatepress_configs')){
    function allianz_translatepress_configs(){
        $trp_settings = (array)get_option('trp_settings');
        $trp_settings['trp-ls-floater'] = 'no'; // Hide Floating language selection
        $trp_settings['trp-ls-show-poweredby'] = 'no'; // Hide "Powered by TranslatePress"
        update_option( 'trp_settings', $trp_settings );
    }
}

/*
 *  Dashboard Configurations
 */
if (!function_exists('allianz_cms_cpt_dashboard_config')) {
    function allianz_cms_cpt_dashboard_config()
    {
        return [
            'documentation_link'  => 'https://cmssuperheroes.gitbook.io/allianz-wordpress-theme/',
            'ticket_link'         => 'https://cmssuperheroes.ticksy.com/',
            'video_tutorial_link' => 'https://www.youtube.com/c/CMSSuperheroes',
            'demo_link'           => 'http://demo.cmssuperheroes.com/themeforest/allianz/',
        ];
    }
}
if (!function_exists('allianz_7oroof_cpt_dashboard_config')) {
    function allianz_7oroof_cpt_dashboard_config()
    {
        return [
            'documentation_link'  => 'https://7oroof-themes.gitbook.io/allianz-wordpress-theme/',
            'ticket_link'         => 'https://7oroofthemes.com/support/',
            'video_tutorial_link' => 'https://www.youtube.com/channel/UCR57ptzvmUEhJ_jIB7QQavg',
            'demo_link'           => 'https://7oroofthemes.com/allianz/',
        ];
    }
}
if (!function_exists('allianz_farost_cpt_dashboard_config')) {
    function allianz_cpt_dashboard_config()
    {
        return [
            'documentation_link'  => 'https://farost.gitbook.io/allianz-wordpress-theme',
            'ticket_link'         => 'mailto:farost.agency@gmail.com',
            'video_tutorial_link' => 'https://www.youtube.com/channel/UCR57ptzvmUEhJ_jIB7QQavg',
            'demo_link'           => 'http://demo.farost.net/allianz',
        ];
    }
}
add_filter('cpt_dashboard_config', 'allianz_7oroof_cpt_dashboard_config');
add_filter('cms_documentation_link', function(){ return 'https://7oroof-themes.gitbook.io/allianz-wordpress-theme/';});
add_filter('cms_ticket_link', function(){ return ['type' => 'url', 'link' => 'https://7oroofthemes.com/support/'];});
add_filter('cms_video_tutorial_link', function(){ return 'https://www.youtube.com/channel/UCR57ptzvmUEhJ_jIB7QQavg';});
/**
 * =========================
 * End Demo Data
 * =========================
 * */


// Add modal overlay
add_action('wp_footer', function(){echo '<div class="cms-modal-overlay cursor-close-white cms-transition"></div>';});
/* ------ Lazy loading ---- */
add_filter('wp_lazy_loading_enabled', '__return_true');
add_filter('wp_get_attachment_image_attributes', function($attr){ $attr['loading'] = 'lazy'; return $attr;});
