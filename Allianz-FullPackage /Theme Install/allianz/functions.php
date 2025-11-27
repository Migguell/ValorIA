<?php
/**
 * Functions and definitions
 *
 * @package Allianz
 * 
 */
remove_action( 'plugins_loaded', '_wp_add_additional_image_sizes', 0 );
if ( ! function_exists( 'allianz_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function allianz_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'allianz', get_template_directory() . '/languages' );
		// Theme Support
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets'
			]
		);
		add_theme_support(
			'custom-logo',
			[
				'height'      => 100,
				'width'       => 350,
				'flex-height' => true,
				'flex-width'  => true,
			] 
		);
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'allianz' )
		) );
		
		/*
		 * WooCommerce.
		 */
		if ( apply_filters( 'allianz_add_woocommerce_support', true ) ) {
			add_theme_support(
				'woocommerce',
				apply_filters(
					'allianz_woocommerce_args',
					array(
						'single_image_width'            => 690,
						'thumbnail_image_width'         => 400,
						'gallery_thumbnail_image_width' => 110,
						'product_grid'                  => array(
							'default_columns' => 3,
							'default_rows'    => 3,
							'min_columns'     => 1,
							'max_columns'     => 5,
							'min_rows'        => 1,
						),
					)
				)
			);
			//add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-slider' );
			if(!class_exists('\Elementor\Plugin')){
				add_theme_support( 'wc-product-gallery-lightbox' );
			}
		}
	}
endif;
add_action( 'after_setup_theme', 'allianz_setup' );
/**
 *  Custom theme thumbnail size
 * https://developer.wordpress.org/reference/functions/add_image_size/#reserved-image-size-names
 * 
 **/
add_action( 'after_setup_theme', 'allianz_thumbnail_custom_sizes' );
if(!function_exists('allianz_thumbnail_custom_sizes')){
	function allianz_thumbnail_custom_sizes(){
		// Custom Thumbnail size
		//add_image_size( 'allianz-size', 220, 180, true ); // (cropped)
	}
}
/**
 *  Show custom size in list
 * https://developer.wordpress.org/reference/functions/add_image_size/#for-media-library-images-admin
 * 
 **/
add_filter( 'image_size_names_choose', 'allianz_image_size_names_choose' );
function allianz_image_size_names_choose( $sizes ) {
    return array_merge( $sizes, array(
        //'allianz-size' => __( 'Allianz Size', 'allianz'),
    ) );
}
// Primary Location
add_action( 'cms_locations', function ( $cms_locations ) {
	return $cms_locations;
} );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 */
function allianz_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'allianz_content_width', 1280 );
}
add_action( 'after_setup_theme', 'allianz_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function allianz_theme_scripts() {
	// Stella
	//wp_enqueue_script('allianz-stellar',get_template_directory_uri().'/assets/js/stellar.min.js',['jquery'],'0.6.2',true );
	// modernizr
    wp_enqueue_script('modernizr',get_template_directory_uri().'/assets/js/modernizr.js', [],'3.6.0', true );
    // Sticky
    wp_enqueue_script('sticky',get_template_directory_uri().'/assets/js/sticky.min.js', [],'1.3.0', true );
    // GSAP
    wp_enqueue_script('gsap',get_template_directory_uri().'/elementor/js/gsap/gsap.min.js',['jquery'],'3.12.5',true);
    wp_enqueue_script( 'gsap-scrolltrigger', get_template_directory_uri() .'/elementor/js/gsap/scrolltrigger.min.js', ['gsap' ], '3.12.5', true );
    wp_enqueue_script( 'gsap-scrolltoplugin', get_template_directory_uri() .'/elementor/js/gsap/scrolltoplugin.min.js', [ 'gsap' ], '3.2.5', true );
    wp_enqueue_script( 'cms-gsap', get_template_directory_uri() .'/elementor/js/gsap/cms-gsap.js', [ 'gsap' ],'1.0.0', true );
    // multiScroll
    wp_register_script( 'multiScroll', get_template_directory_uri() . '/elementor/js/multiscroll/jquery.multiscroll.min.js', [ 'jquery' ], '0.2.3', true );
    // jquery-parallax-scroll-js
    //wp_enqueue_script( 'jquery-parallax-scroll', get_template_directory_uri() . '/elementor/js/parallax-scroll/jquery.parallax-scroll.js', [ 'jquery' ],'1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'allianz_theme_scripts');

function allianz_scripts() {
	$theme = wp_get_theme( get_template() );
	$min = defined('DEV_MODE') && DEV_MODE == true ? '' : '.min';
	$allianz_css = [];
	if(class_exists('\Elementor\Plugin')){
		$allianz_css[] = 'elementor-frontend';
	}
	// Theme style
	wp_enqueue_style( 'allianz', get_template_directory_uri() . '/assets/css/theme.css', $allianz_css, $theme->get( 'Version' ) );
	wp_add_inline_style('allianz', allianz_inline_styles() );
	// theme font icon
	wp_enqueue_style( 'font-cmsi', get_template_directory_uri() . '/assets/fonts/font-cmsi/style.css', array(), $theme->get( 'Version' ) );
	// theme font icon
	wp_enqueue_style( 'font-allianz', get_template_directory_uri() . '/assets/fonts/font-theme/style.css', array('allianz'), $theme->get( 'Version' ) );
	// WP Comment
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	/* Theme JS */
	wp_enqueue_script( 'allianz-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $theme->get( 'Version' ), true );
	wp_localize_script( 'allianz-main', 'main_data', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	/*
	 * Elementor Widget JS
	 */
	// Elementor Custom
    wp_enqueue_script('cms-elementor-custom-js', get_template_directory_uri() . '/elementor/js/elementor-custom.js', [ 'jquery' ], $theme->get( 'Version' ), true);
	// CountDown
	wp_register_script( 'cms-countdown-config', get_template_directory_uri() . '/elementor/js/cms-countdown.js', ['jquery'], $theme->get( 'Version' ), true );
	// Counter Widget
	wp_register_script( 'cms-counter-widget-js', get_template_directory_uri() . '/elementor/js/cms-counter-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true  );
	// Counter Sticky Widget
	wp_register_script( 'cms-counter-sticky-widget-js', get_template_directory_uri() . '/elementor/js/cms-counter-sticky-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true  );
	// Clients List Widget
	wp_register_script( 'cms-clients-list-widget-js', get_template_directory_uri() . '/elementor/js/cms-clients-list-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true  );
	// Pie Charts Widget
	wp_register_script( 'cms-piecharts-widget-js', get_template_directory_uri() . '/elementor/js/cms-piecharts-widget.js', [ 'jquery' ], $theme->get( 'Version' ) , true );
	// CMS Post Carousel Widget
	wp_register_script( 'cms-post-carousel-widget-js', get_template_directory_uri() . '/elementor/js/cms-post-carousel-widget.js', [ 'jquery' ], $theme->get( 'Version' ) , true );
	// Galleries
    wp_register_script('cms-galleries', get_template_directory_uri() . '/elementor/js/cms-galleries.js', [ 'jquery' ], $theme->get( 'Version' ), true);
	// Google Maps Widget
	$api    = allianz_get_opt( 'gm_api_key', 'AIzaSyC08_qdlXXCWiFNVj02d-L2BDK5qr6ZnfM' );
	$api_js = "https://maps.googleapis.com/maps/api/js?sensor=false&key=" . $api;
	wp_register_script( 'maps-googleapis', $api_js, [], date( "Ymd" ) );
	wp_register_script( 'custom-gm-widget-js', get_template_directory_uri() . '/elementor/js/custom-gm-widget.js', [
		'maps-googleapis',
		'jquery'
	], $theme->get( 'Version' ), true );
	wp_register_script( 'cms-post-grid-widget-js', get_template_directory_uri() . '/elementor/js/cms-post-grid-widget.js', [
		'isotope',
		'jquery'
	], $theme->get( 'Version' ), true );
	wp_register_script( 'cms-toggle-widget-js', get_template_directory_uri() . '/elementor/js/cms-toggle-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true );
	wp_register_script( 'cms-accordion-widget-js', get_template_directory_uri() . '/elementor/js/cms-accordion-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true );
	wp_register_script( 'cms-alert-widget-js', get_template_directory_uri() . '/elementor/js/cms-alert-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true );
	wp_register_script( 'cms-tabs-widget-js', get_template_directory_uri() . '/elementor/js/cms-tabs-widget.js', [ 'jquery' ], $theme->get( 'Version' ), true );
	// Chartjs
    wp_register_script( 'chartjs', get_template_directory_uri() . '/elementor/js/chart.min.js', array( 'jquery' ), $theme->get( 'Version' ), true );
    wp_register_script( 'cms-chartjs', get_template_directory_uri() . '/elementor/js/cms-chart.js', array( 'chartjs' ), $theme->get( 'Version' ), true );
    // How it work
    wp_register_script( 'cms-howitwork', get_template_directory_uri() . '/elementor/js/cms-howitwork-widget.js', array( 'jquery' ), $theme->get( 'Version' ), true );
    // Video Player
    wp_register_script( 'youtube-iframe-api-js', 'https://www.youtube.com/iframe_api', array(), $theme->get( 'Version' ), true );
    wp_register_script( 'cms-video-widget-js', get_template_directory_uri() . '/elementor/js/cms-video-widget.js', [ 'jquery', 'youtube-iframe-api-js' ], $theme->get( 'Version' ) , true );
}
add_action( 'wp_enqueue_scripts', 'allianz_scripts' );

if(!function_exists('allianz_default_fonts')){
	function allianz_default_fonts(){
		$body_font    = str_replace(' ', '+',allianz_configs('body')['family']);
		$heading_font = str_replace(' ', '+',allianz_configs('heading')['family']);
	?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=<?php echo esc_html($body_font); ?>:ital,opsz,wght@0,9..40,100;0,9..40,200;0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;0,9..40,900;0,9..40,1000;1,9..40,100;1,9..40,200;1,9..40,300;1,9..40,400;1,9..40,500;1,9..40,600;1,9..40,700;1,9..40,800;1,9..40,900;1,9..40,1000&family=<?php echo esc_html($heading_font); ?>:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
	<?php
	}
}
add_action('wp_footer','allianz_default_fonts');
/**
 * Widgets
 * Just show widgets if it enable via theme option
 * **/
function allianz_widgets(){
    // Register Theme Sidebars
    if(class_exists('Theme_Core_Options')){
    	$all = apply_filters('allianz_register_sidebar_all_post_type', false);
    	if($all){
	        $all_post_type = allianz_all_post_types();
	        unset($all_post_type['product']);
	        foreach ($all_post_type as $key => $value) {
	            register_sidebar([
	                'name'          => sprintf( esc_html__( '%s Sidebar', 'allianz' ), $value ),
	                'id'            => 'sidebar-'.$key,
	                'description'   => sprintf(esc_html__( 'Add widgets here to show in %1$s archive page and single %2$s page', 'allianz' ), strtoupper(str_replace('-', ' ', $key)), $value),
	                'class'         => 'cms-post-type-widget',
	                'title_class'   => ''
	            ]);
	        }
	    } else {
	    	register_sidebar([
                'name'          => esc_html__( 'Blog Sidebar', 'allianz' ),
                'id'            => 'sidebar-post',
                'description'   => esc_html__( 'Add widgets here to show in Blog archive page and single post page', 'allianz' ),
                'class'         => 'cms-post-type-widget',
                'before_widget' => '<div id="%1$s" class="cms-widget %2$s">',
        		'after_widget'  => '</div>',
            ]);
	    }

        // WooCommerce Sidebar
        if(class_exists('WooCommerce')){
            register_sidebar([
                'name'          => esc_html__( 'Shop Sidebar', 'allianz' ),
                'id'            => 'sidebar-product',
                'description'   => esc_html__( 'Add widgets here to show in WooCommerce archive and single product page', 'allianz'),
                'class'         => 'cms-post-type-widget',
                'before_widget' => '<div id="%1$s" class="cms-shop-widget %2$s">',
        		'after_widget'  => '</div>',
            ]);
        }
    }
}
add_action( 'widgets_init', 'allianz_widgets', 11 );
/* Disable Widgets Block Editor */
add_filter( 'use_widgets_block_editor', '__return_false' );
/**
 * Change default widget title structure
*/
if(!function_exists('allianz_widgets_structure')){
    add_filter('widget_display_callback', 'allianz_widgets_structure');
    add_filter('register_sidebar_defaults', 'allianz_widgets_structure');
    function allianz_widgets_structure($args){
        $args = wp_parse_args($args, [
            'class'       => '',  
            'title_class' => ''
        ]);
        $widget_title_tag = 'div';
        $title_class = [
            'cms-wgtitle',
            'text-heading',
            isset($args['title_class']) ? $args['title_class'] : ''
        ];
        $args['before_title'] = '<div class="'.implode(' ', array_filter($title_class)).'">';
        $args['after_title'] = '</div>';
        return $args;
    }
}
/**
 * Remove Some CSS
 * 
*/
if(!function_exists('etc_remove_scripts')){
    add_action( 'wp_enqueue_scripts', 'etc_remove_scripts', 999 );
    add_action( 'wp_footer', 'etc_remove_styles', 999 );
    add_action( 'wp_header', 'etc_remove_styles', 999 );
    function etc_remove_scripts() {
        $default = ['isotope' ];
        $scripts  = apply_filters( 'etc_remove_scripts', $default );
        foreach ( $scripts as $script ) {
            wp_dequeue_script( $script );
            //wp_allianz_deregister_script( $script );
        }
    }
}
if(!function_exists('etc_remove_styles')){
    add_action( 'wp_enqueue_scripts', 'etc_remove_styles', 999 );
    add_action( 'wp_footer', 'etc_remove_styles', 999 );
    add_action( 'wp_header', 'etc_remove_styles', 999 );
    function etc_remove_styles() {
        $default = ['gglcptch', 'isotope' ];
        $styles  = apply_filters( 'etc_remove_styles', $default );
        foreach ( $styles as $style ) {
            wp_dequeue_style( $style );
            //wp_allianz_deregister_style( $style );
        }
    }
}
if(!function_exists('allianz_remove_styles')){
    add_filter('etc_remove_styles', 'allianz_remove_styles');
    function allianz_remove_styles($styles){
        $_styles = [
            // newsletter
            'newsletter',
            // elementor
            'elementor-frontend-legacy',
            // woo
            'woocommerce-smallscreen',
            'woocommerce-general',
            'woocommerce-layout',
            'wc-blocks-vendors-style',
            'wc-blocks-style',
            // theme core
            'oc-css',
            'etc-main-css',
            'progressbar-lib-css',
            'slick-css',
            'tco-main-css',
            // language switcher
            'trp-floater-language-switcher-style',
            'trp-language-switcher-style',
            // csh login
            'widget_style',
            'cshlg_layout_1',
            // WPC Smart Wishlist
            'woosw-frontend',
            // WPC Smart Quick View
            'woosq-frontend',
            // WPC Badge Management
            'wpcbm-frontend',
            // Pickup Store
            'wps_bootstrap',
			'wps_fontawesome',
			'store-styles',
        ];
        $styles = array_merge($styles, $_styles);
        return $styles;
    }
}

/**
 *  Add admin styles 
 * 
 * */
function allianz_admin_style() {
	$theme = wp_get_theme( get_template() );
	// theme font icon
    wp_enqueue_style( 'allianz-font-cmsi', get_template_directory_uri() . '/assets/fonts/font-cmsi/style.css', array(), $theme->get( 'Version' ) );
    wp_enqueue_style( 'allianz-font-theme', get_template_directory_uri() . '/assets/fonts/font-theme/style.css', array(), $theme->get( 'Version' ) );
	//admin
	wp_enqueue_style( 'allianz-admin-style', get_template_directory_uri() . '/assets/admin/admin.css' );
	// import demo
	wp_enqueue_style( 'allianz-get-started-css', get_template_directory_uri() . '/assets/admin/get-started.css' );
	wp_enqueue_script( 'allianz-get-started-js', get_template_directory_uri() . '/assets/admin/get-started.js', [ 'jquery' ], $theme->get( 'Version' ), true );
	wp_localize_script( 'allianz-get-started-js', 'main_data', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	// Widget Gallery
	wp_enqueue_script('cms-media-gallery-widget', get_template_directory_uri() . '/assets/admin/media-gallery-widget.js',  array( 'media-widgets' ) );
}
add_action( 'admin_enqueue_scripts', 'allianz_admin_style' );

/**
 * Check if is build with Elementor
 * 
 * **/
if(!function_exists('allianz_is_built_with_elementor')){
    function allianz_is_built_with_elementor(){
    	if(cms_is_blog() || is_404()) return false;
        if ( class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->documents->get( get_the_ID() )->is_built_with_elementor() ) {
            return true;
        } else {
            return false;
        }
    }
}
/**
 * Custom Elementor Editor
 * */
add_action( 'elementor/editor/before_enqueue_scripts', function() {
    wp_enqueue_style( 'allianz-elementor-custom-editor', get_template_directory_uri() . '/assets/admin/elementor-panel.css', array(), '1.0.0' );
});
add_action('elementor/preview/enqueue_styles',  function() {
	wp_enqueue_style( 'allianz-elementor-custom-editor', get_template_directory_uri() . '/assets/admin/elementor-panel.css', array(), '1.0.0' );
    wp_enqueue_style( 'allianz-elementor-custom-editor', get_template_directory_uri() . '/assets/admin/elementor-preview.css', array(), '1.0.0' );
});
/**
 * Font Icons
 * 
 * */
require_once get_template_directory() . '/assets/fonts/font-cmsi.php';
require_once get_template_directory() . '/assets/fonts/font-theme.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_template_directory() . '/inc/template-functions.php';
/**
 * Custom template tags for this theme.
 * 
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Theme Functions
 */
require_once get_template_directory() . '/inc/template-widgets.php';
require_once get_template_directory() . '/inc/theme-functions.php';

/**
 * Breadcrumb.
 */
require_once get_template_directory() . '/inc/classes/class-breadcrumb.php';

/**
 * Add Template Woocommerce
 */
if(!function_exists('allianz_is_woocommerce')){
	function allianz_is_woocommerce(){
		if(class_exists('WooCommerce') && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() )){
			return true;
		}
		return false;
	}
}
if ( class_exists( 'WooCommerce' ) ) {
	require_once( get_template_directory() . '/woocommerce/wc-function-hooks.php' );
}
/**
 * Contact Form 7
 * */
if(class_exists('WPCF7')){
	require_once( get_template_directory() . '/inc/extensions/cf7.php' );
}
/**
 * Translate Presss
 * */
if(class_exists('TRP_Translate_Press')){
	require_once( get_template_directory() . '/inc/extensions/translatepress.php' );
}
/**
 * TheNewsletter
 * */
if(class_exists('Newsletter')){
	require_once( get_template_directory() . '/inc/extensions/newsletter.php' );
}

/**
 * FOX - WooCommerce Currency Swithcher
 * 
 * */
if(class_exists('WOOCS_STARTER')){
	require_once( get_template_directory() . '/inc/extensions/woocs.php' );
}
/**
 * Theme Options
 */
require get_template_directory() . '/inc/theme-options/theme-options.php';

/**
 * Post Type Options
 */
// Page Options
require get_template_directory() . '/inc/post-type-options/page-options.php';
// Single Product Options
require get_template_directory() . '/inc/post-type-options/product-options.php';

// CMS Service Options
require get_template_directory() . '/inc/post-type-options/service-options.php';
// CMS Industry Options
require get_template_directory() . '/inc/post-type-options/industry-options.php';
// CMS Case Options
require get_template_directory() . '/inc/post-type-options/case-options.php';
// CMS Career Options
require get_template_directory() . '/inc/post-type-options/career-options.php';

/**
 * CSS Generator.
 */
if ( ! class_exists( 'CSS_Generator' ) ) {
	require_once get_template_directory() . '/inc/classes/class-css-generator.php';
}
/**
 * Contact Form 7
 * 
 * */
add_filter('wpcf7_autop_or_not', '__return_false');
/**
 * Enable Custom Post type
 * 
 * **/
// Portfolio
add_filter('allianz_enable_portfolio', 'allianz_enable_portfolio');
if(!function_exists('allianz_enable_portfolio')){
	function allianz_enable_portfolio(){
		return false;
	}
}
// Service
add_filter('allianz_enable_service', 'allianz_enable_service');
if(!function_exists('allianz_enable_service')){
	function allianz_enable_service(){
		return true;
	}
}
// Industry
add_filter('allianz_enable_industry', 'allianz_enable_industry');
if(!function_exists('allianz_enable_industry')){
	function allianz_enable_industry(){
		return true;
	}
}
// Case
add_filter('allianz_enable_case', 'allianz_enable_case');
if(!function_exists('allianz_enable_case')){
	function allianz_enable_case(){
		return true;
	}
}
// Career
add_filter('allianz_enable_career', 'allianz_enable_career');
if(!function_exists('allianz_enable_career')){
	function allianz_enable_career(){
		return true;
	}
}
// Header Top
add_filter('allianz_enable_header_top', 'allianz_enable_header_top');
if(!function_exists('allianz_enable_header_top')){
	function allianz_enable_header_top(){
		return true;
	}
}
// Footer
add_filter('allianz_enable_footer', 'allianz_enable_footer');
if(!function_exists('allianz_enable_footer')){
	function allianz_enable_footer(){
		return true;
	}
}
// Side Navigation
add_filter('allianz_enable_sidenav', 'allianz_enable_sidenav');
if(!function_exists('allianz_enable_sidenav')){
	function allianz_enable_sidenav(){
		return true;
	}
}
// Pop Up
add_filter('allianz_enable_popup', 'allianz_enable_popup');
if(!function_exists('allianz_enable_popup')){
	function allianz_enable_popup(){
		return true;
	}
}
/**
 * Enable mega menu
 **/
add_filter('cms_enable_megamenu', 'allianz_enable_megamenu');
if(!function_exists('allianz_enable_megamenu')){
    function allianz_enable_megamenu(){
        return true;
    }
}
/**
 * Mega menu Full Width
 * 
 * */
add_filter('cms_enable_megamenu_full_width', 'allianz_enable_megamenu_full_width');
if(!function_exists('allianz_enable_megamenu_full_width')){
	function allianz_enable_megamenu_full_width(){
		return true;
	}
}
add_filter('megamenu_full_width_opts', 'allianz_megamenu_full_width_opts');
if(!function_exists('allianz_megamenu_full_width_opts')){
	function allianz_megamenu_full_width_opts($opts){
		$opts[] = [
	        'name' => 'container',
	        'title' => esc_html__('Container', 'allianz')
	    ];
		return $opts;
	}
}
/* Enable onepage */
add_filter('cms_enable_onepage', 'allianz_enable_onepage');
if(!function_exists('allianz_enable_onepage')){
    function allianz_enable_onepage(){
        return false;
    }
}
/*
 * Get Started
 */
require_once get_template_directory() . '/inc/get-started.php';