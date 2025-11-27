<?php
use Elementor\Controls_Manager;
use \Elementor\Icons_Manager;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
// Register Elementor Widgets through plugin core
if (!function_exists('allianz_elementor_register_widgets')) {
    add_filter('etc_register_widgets', 'allianz_elementor_register_widgets');
    function allianz_elementor_register_widgets($widgets)
    {
        $widgets = [
            [ // Cms Accordion
                'name'       => 'cms_accordion',
                'title'      => esc_html__('CMS Accordion', 'allianz'),
                'icon'       => 'eicon-accordion',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => array(
                    'cms-accordion-widget-js',
                ),
                'keywords' => [
                    'allianz', 'cms accordion', 'accordion'
                ]
            ],
            [ // Cms Accordion Scroll
                'name'       => 'cms_accordion_scroll',
                'title'      => esc_html__('CMS Accordion Scroll', 'allianz'),
                'icon'       => 'eicon-accordion',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => array(
                    'gsap',
                    'gsap-scrolltrigger',
                    'gsap-scrolltoplugin',
                    'cms-gsap',
                    'perfect-scrollbar',
                    'jquery-numerator',
                    'cms-counter-widget-js'
                ),
                'keywords' => [
                    'allianz','cms', 'accordion', 'scroll', 'cms accordion scroll', 'accordion scroll'
                ]
            ],
            [ // Cms Banner
                'name'       => 'cms_banner',
                'title'      => esc_html__('CMS Banner', 'allianz'),
                'icon'       => 'eicon-banner',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'banner', 'image'
                ]
            ],
            [ // Cms Blog
                'name'       => 'cms_blog',
                'title'      => esc_html__('CMS Blog', 'allianz'),
                'icon'       => 'eicon-posts-group',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'blog', 'cms blog'
                ]
            ],
            [ // Cms Blog Grid
                'name'       => 'cms_blog_grid',
                'title'      => esc_html__('CMS Blog Grid', 'allianz'),
                'icon'       => 'eicon-posts-grid',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'imagesloaded',
                    'isotope',
                    'cms-post-grid-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'blog', 'post', 'grid'
                ]
            ],
            [ // Cms Blog Carousel
                'name'       => 'cms_blog_carousel',
                'title'      => esc_html__('CMS Blog Carousel', 'allianz'),
                'icon'       => 'eicon-posts-carousel',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'blog', 'post', 'carousel'
                ]
            ],
            [ // Cms Breadcrumb
                'name'       => 'cms_breadcrumb',
                'title'      => esc_html__('CMS Breadcrumb', 'allianz'),
                'icon'       => 'eicon-ellipsis-h',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'breadcrumb'
                ]
            ],
            [ // CMS Chart
                'name'       => 'cms_chart',
                'title'      => esc_html__('CMS Chart', 'allianz'),
                'icon'       => 'eicon-circle-o',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms chart', 'chart', 'chartjs'
                ],
                'scripts'    => array(
                    'chartjs',
                    'cms-chartjs'
                )
            ],
            [ // CMS Bar Chart
                'name'       => 'cms_chart_bar',
                'title'      => esc_html__('CMS Bar Chart', 'allianz'),
                'icon'       => 'eicon-skill-bar',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms chart', 'chart', 'chartjs'
                ],
                'scripts'    => array(
                    'chartjs',
                    'cms-chartjs'
                )
            ],
            [ // Cms Clients Carousel
                'name'       => 'cms_clients',
                'title'      => esc_html__('CMS Clients', 'allianz'),
                'icon'       => 'eicon-person',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'cms', 'allianz', 'client', 'clients', 'carousel'
                ]
            ],
            [ // Cms Copyright
                'name'       => 'cms_copyright',
                'title'      => esc_html__('CMS Copyright', 'allianz'),
                'icon'       => 'eicon-menu-bar',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms copyright', 'copyright'
                ]
            ],
            [ // Cms Countdown
                'name'       => 'cms_countdown',
                'title'      => esc_html__('CMS Countdown', 'allianz'),
                'icon'       => 'eicon-countdown',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'cms-countdown-config'
                ],
                'keywords'   => [
                    'allianz', 'cms countdown', 'countdown'
                ]
            ],
            [ // Cms Counter
                'name'       => 'cms_counter',
                'title'      => esc_html__('CMS Counter', 'allianz'),
                'icon'       => 'eicon-counter-circle',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => array(
                    'jquery-numerator',
                    'cms-counter-widget-js',
                    'swiper',
                    'cms-post-carousel-widget-js'
                ),
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'cms counter', 'counter'
                ]
            ],
            [ // Cms Call to Action
                'name'       => 'cms_cta',
                'title'      => esc_html__('CMS Call To Action', 'allianz'),
                'icon'       => 'eicon-image-rollover',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz call to action', 'cms', 'call to action', 'call', 'action'
                ]
            ],
            [ // Cms Download
                'name'       => 'cms_download',
                'title'      => esc_html__('CMS Download', 'allianz'),
                'icon'       => 'eicon-download',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [],
                'styles'     => [],
                'keywords'   => [
                    'allianz', 'download'
                ]
            ],
            [ // Cms Fancy Box
                'name'       => 'cms_fancy_box',
                'title'      => esc_html__('CMS Fancy Box', 'allianz'),
                'icon'       => 'eicon-icon-box',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [],
                'styles'     => [],
                'keywords'   => [
                    'allianz', 'fancy-box', 'fancy', 'box'
                ]
            ],
            [ // CMS Gallery
                'name'       => 'cms_gallery',
                'title'      => esc_html__('CMS Gallery', 'allianz'),
                'icon'       => 'eicon-gallery-grid',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms gallery', 'gallery', 'image',
                ],
                'scripts' => [
                    'cms-galleries'
                ]
            ],
            [ // CMS Gallery Slider
                'name'       => 'cms_gallery_carousel',
                'title'      => esc_html__('CMS Gallery Carousel', 'allianz'),
                'icon'       => 'eicon-gallery-grid',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms gallery','cms gallery gallery', 'gallery gallery','gallery', 'image',
                ],
                'scripts' => [
                    'swiper',
                    'cms-post-carousel-widget-js'
                ],
                'styles' => [
                    'swiper'
                ],
            ],
            [ // CMS Google Map
                'name'       => 'cms_google_map',
                'title'      => esc_html__('CMS Google Map', 'allianz'),
                'icon'       => 'eicon-google-maps',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms map', 'cms', 'map'
                ]
            ],
            [ // Cms Heading
                'name'       => 'cms_heading',
                'title'      => esc_html__('CMS Heading', 'allianz'),
                'icon'       => 'eicon-heading',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'heading', 'custom heading'
                ],
                'scripts'    => [
                    'jquery-numerator'
                ]
            ],
            [ // Cms Headlines News
                'name'       => 'cms_headline',
                'title'      => esc_html__('CMS Headlines News', 'allianz'),
                'icon'       => 'eicon-animated-headline',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'headline', 'custom headline'
                ],
                'scripts' => [
                    'swiper',
                    'cms-post-carousel-widget-js'
                ],
                'styles' => [
                    'swiper'
                ],
            ],
            [ // Cms Instagram
                'name'       => 'cms_instagram',
                'title'      => esc_html__('CMS Instagram', 'allianz'),
                'icon'       => 'eicon-instargram',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js'
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords'   => [
                    'allianz', 'cms instagram', 'instagram'
                ]
            ],
            [ // Cms List
                'name'       => 'cms_list',
                'title'      => esc_html__('CMS List', 'allianz'),
                'icon'       => 'eicon-editor-list-ul',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [],
                'keywords'   => [
                    'allianz', 'cms list', 'list'
                ]
            ],
            [ // Cms Navigation Menu
                'name'       => 'cms_navigation_menu',
                'title'      => esc_html__('CMS Menu', 'allianz'),
                'icon'       => 'eicon-menu-bar',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms navigation menu', 'menu'
                ]
            ],
            [ // Cms Page Title
                'name'       => 'cms_page_title',
                'title'      => esc_html__('CMS Page Title', 'allianz'),
                'icon'       => 'eicon-archive-title',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms page title', 'page title', 'title'
                ]
            ],
            [ // Cms Post Feature
                'name'       => 'cms_post_feature',
                'title'      => esc_html__('CMS Post Feature', 'allianz'),
                'icon'       => 'eicon-featured-image',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms post feature', 'post title', 'title'
                ]
            ],
            [ // Cms Pricing
                'name'       => 'cms_pricing',
                'title'      => esc_html__('CMS Pricing', 'allianz'),
                'icon'       => 'eicon-price-table',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'cms pricing', 'pricing', 'price'
                ]
            ],
            [ // Cms Process
                'name'       => 'cms_process',
                'title'      => esc_html__('CMS Process', 'allianz'),
                'icon'       => 'eicon-archive-title',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms process', 'process'
                ],
                'scripts'   => [
                    'gsap',
                    'gsap-scrolltrigger',
                    'gsap-scrolltoplugin',
                    'cms-gsap'
                ]
            ],
            [ // Cms Progress Bar
                'name'       => 'cms_progressbar',
                'title'      => esc_html__('CMS Progress Bar', 'allianz'),
                'icon'       => 'eicon-skill-bar',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'jquery-numerator',
                    //'cms-progressbar-widget-js',
                ],
                'keywords' => [
                    'allianz', 'cms progressbar', 'progress bar'
                ]
            ],
            [ // CMS Quick Contact
                'name'       => 'cms_quickcontact',
                'title'      => esc_html__('CMS Quick Contact', 'allianz'),
                'icon'       => 'eicon-mail',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms quick contact', 'quick', 'contact',
                ]
            ],
            [ // Cms Slider
                'name'       => 'cms_slider',
                'title'      => esc_html__('CMS Slider', 'allianz'),
                'icon'       => 'eicon-slides',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'cms slider', 'slider'
                ]
            ],
            [ // CMS Socials Icons
                'name'       => 'cms_social_icons',
                'title'      => esc_html__('CMS Socials Icon', 'allianz'),
                'icon'       => 'eicon-social-icons',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms social', 'icon', 'social icon',
                ]
            ],
            [ // CMS Support
                'name'       => 'cms_support',
                'title'      => esc_html__('CMS Support', 'allianz'),
                'icon'       => 'eicon-person',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords'   => [
                    'allianz', 'cms support', 'support', 'hel', 'call center'
                ]
            ],
            [ // Cms Teams (Grid + Carousel)
                'name'       => 'cms_teams',
                'title'      => esc_html__('CMS Teams', 'allianz'),
                'icon'       => 'eicon-user-circle-o',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'cms', 'allianz', 'team', 'teams', 'grid', 'carousel'
                ]
            ],
            [ // Cms Testimonial Carousel
                'name'       => 'cms_testimonials',
                'title'      => esc_html__('CMS Testimonials', 'allianz'),
                'icon'       => 'eicon-testimonial',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'cms', 'allianz', 'testimonial', 'testimonials', 'carousel'
                ]
            ],
            [ // Cms Video
                'name'       => 'cms_video_player',
                'title'      => esc_html__('CMS Video Player', 'allianz'),
                'icon'       => 'eicon-play',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'youtube-iframe-api-js',
                    'cms-video-widget-js',
                ],
                'keywords'   => [
                    'allianz', 'cms video player', 'video'
                ]
            ],
            [ // CMS Business Consultant - just for Allianz
                'name'       => 'cms_business_consultant',
                'title'      => esc_html__('CMS Business Consultant', 'allianz'),
                'icon'       => 'eicon-user',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                    'jquery-numerator'
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords'   => [
                    'allianz', 'cms Business Consultant', 'Business Consultant'
                ]
            ]
        ];
        if(apply_filters('allianz_enable_service', false)){
            $widgets[] = [ // Cms Service
                'name'       => 'cms_service',
                'title'      => esc_html__('CMS Service', 'allianz'),
                'icon'       => 'eicon-posts-group',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [],
                'keywords' => [
                    'allianz', 'service'
                ]
            ];
            $widgets[] = [ // Cms Service Grid
                'name'       => 'cms_service_grid',
                'title'      => esc_html__('CMS Service Grid', 'allianz'),
                'icon'       => 'eicon-posts-grid',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'cms-post-grid-widget-js',
                ],
                'keywords' => [
                    'allianz', 'service', 'grid'
                ]
            ];
            $widgets[] = [ // Cms Service Carousel
                'name'       => 'cms_service_carousel',
                'title'      => esc_html__('CMS Service Carousel', 'allianz'),
                'icon'       => 'eicon-posts-carousel',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'service', 'carousel'
                ]
            ];
        }
        if(apply_filters('allianz_enable_industry', false)){
            $widgets[] = [ // Cms Industry
                'name'       => 'cms_industry',
                'title'      => esc_html__('CMS Industry', 'allianz'),
                'icon'       => 'eicon-posts-group',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [],
                'keywords' => [
                    'allianz', 'industry'
                ]
            ];
            $widgets[] = [ // Cms Industry Grid
                'name'       => 'cms_industry_grid',
                'title'      => esc_html__('CMS Industry Grid', 'allianz'),
                'icon'       => 'eicon-posts-grid',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'cms-post-grid-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'industry', 'grid'
                ]
            ];
            $widgets[] = [ // Cms Industry Carousel
                'name'       => 'cms_industry_carousel',
                'title'      => esc_html__('CMS Industry Carousel', 'allianz'),
                'icon'       => 'eicon-posts-carousel',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'industry', 'carousel'
                ]
            ];
            $widgets[] = [ // Cms Industry Scroll
                'name'       => 'cms_industry_scroll',
                'title'      => esc_html__('CMS Industry Scroll', 'allianz'),
                'icon'       => 'eicon-posts-carousel',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'gsap',
                    'gsap-scrolltrigger',
                    'cms-gsap',
                ],
                'keywords' => [
                    'allianz', 'industry', 'scroll'
                ]
            ];
        }
        if(apply_filters('allianz_enable_case', false)){
            $widgets[] = [ // Cms Case
                'name'       => 'cms_case',
                'title'      => esc_html__('CMS Case', 'allianz'),
                'icon'       => 'eicon-posts-group',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'keywords' => [
                    'allianz', 'case', 'grid'
                ]
            ];
            $widgets[] = [ // Cms Case Grid
                'name'       => 'cms_case_grid',
                'title'      => esc_html__('CMS Case Grid', 'allianz'),
                'icon'       => 'eicon-posts-grid',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'cms-post-grid-widget-js',
                ],
                'keywords' => [
                    'allianz', 'case', 'grid'
                ]
            ];
            $widgets[] = [ // Cms Case Carousel
                'name'       => 'cms_case_carousel',
                'title'      => esc_html__('CMS Case Carousel', 'allianz'),
                'icon'       => 'eicon-posts-carousel',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'case', 'carousel'
                ]
            ];
        }
        if(apply_filters('allianz_enable_career', false)){
            $widgets[] = [ // Cms Career Grid
                'name'       => 'cms_career_grid',
                'title'      => esc_html__('CMS Career Grid', 'allianz'),
                'icon'       => 'eicon-posts-grid',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'imagesloaded',
                    'isotope',
                    'cms-post-grid-widget-js',
                ],
                'keywords' => [
                    'allianz', 'career', 'grid'
                ]
            ];
            $widgets[] = [ // Cms Career Carousel
                'name'       => 'cms_career_carousel',
                'title'      => esc_html__('CMS Career Carousel', 'allianz'),
                'icon'       => 'eicon-posts-carousel',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'swiper',
                    'cms-post-carousel-widget-js',
                ],
                'styles' => [
                    'swiper'
                ],
                'keywords' => [
                    'allianz', 'career', 'carousel'
                ]
            ];
        }
        // Contact Form 7
        if (class_exists('WPCF7')) {
            $widgets[] = [
                'name'       => 'cms_contact_form',
                'title'      => esc_html__('CMS Contact Form 7', 'allianz'),
                'icon'       => 'eicon-form-horizontal',
                'categories' => array(Elementor_Theme_Core::ETC_CATEGORY_NAME),
                'scripts'    => [
                    'jquery-numerator',
                    'cms-counter-widget-js',
                    'chartjs',
                    'cms-chartjs'
                ],
                'styles'     => [],
                'keywords'   => [
                    'cms', 'allianz', 'contact-form', 'form', 'contact'
                ]
            ];
        }
        // Newsletter
        if(class_exists('Newsletter')){
            $widgets[] = [
                'name'       => 'cms_newsletter',
                'title'      => esc_html__( 'CMS Newsletter', 'allianz' ),
                'icon'       => 'eicon-mail',
                'categories' => array( Elementor_Theme_Core::ETC_CATEGORY_NAME ),
                'keywords'   => [
                    'cms', 'allianz', 'newsletter'
                ]
            ];
        }
        // Language Swicther
        if(class_exists('TRP_Translate_Press')){
            $widgets[] = [
                'name'       => 'cms_language_switcher',
                'title'      => esc_html__( 'CMS Language Switcher', 'allianz' ),
                'icon'       => 'eicon-exchange',
                'categories' => array( Elementor_Theme_Core::ETC_CATEGORY_NAME ),
                'keywords'   => [
                    'cms', 'allianz', 'language', 'language switcher'
                ]
            ];
        }
        return $widgets;
    }
}
if(!function_exists('allianz_add_hidden_device_controls')){
    function allianz_add_hidden_device_controls($widget = [], $args = []) {
        $args = wp_parse_args($args, [
            'prefix'    => 'cms_',
            'condition' => []
        ]);
        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

        foreach ( $active_devices as $breakpoint_key ) {
            $label = 'desktop' === $breakpoint_key ? esc_html__( 'Desktop', 'allianz' ) : $active_breakpoints[ $breakpoint_key ]->get_label();

            $widget->add_control(
                $args['prefix'].'hide_' . $breakpoint_key,
                [
                    /* translators: %s: Device name. */
                    'label'        => sprintf( __( 'Hide On %s', 'allianz' ), $label ),
                    'type'         => Controls_Manager::SWITCHER,
                    'default'      => '',
                    //'prefix_class' => 'elementor-',
                    'label_on'     => esc_html__( 'Hide', 'allianz' ),
                    'label_off'    => esc_html__( 'Show', 'allianz' ),
                    //'return_value' => 'hidden-' . $breakpoint_key,
                    'condition' => $args['condition']
                ]
            );
        }
    }
}
if(!function_exists('allianz_add_hidden_device_controls_render')){
    function allianz_add_hidden_device_controls_render($settings = [], $prefix = ''){
        $active_devices     = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
        $hidden             = [];
        foreach ($active_devices as $device) {
            $hidden[] = ($settings[$prefix.'hide_'.$device] === 'yes') ? 'cms-hidden-'.$device : '';
        }
        return implode(' ',array_filter($hidden));
    }
}
// Display Alignment
if(!function_exists('allianz_elementor_reponsive_flex_alignment')){
    function allianz_elementor_responsive_flex_alignment($widget = [], $args = []){
        $args = wp_parse_args($args, [
            'name'      => 'align',
            'condition' => [],
            'label'     => esc_html__( 'Alignment', 'allianz' )
        ]);
        return $widget->add_responsive_control(
            $args['name'],
            [
                'label'        => $args['label'],
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'start'    => [
                        'title' => esc_html__( 'Left', 'allianz' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__( 'Center', 'allianz' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'end'   => [
                        'title' => esc_html__( 'Right', 'allianz' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'between' => [
                        'title' => esc_html__( 'Between', 'allianz' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'condition' => $args['condition']
            ]
        );
    }
}
// Alignment Class
if(!function_exists('allianz_elementor_get_alignment_class')){
    function allianz_elementor_get_alignment_class($widget = [], $settings = [], $args = []){
        $args = wp_parse_args($args, [
            'name'         => '',
            'default'      => '',
            'prefix_class' => 'text-',
            'desktop'      => '',
            'widescreen'   => '', 
            'laptop'       => '',
            'tablet_extra' => '',
            'tablet'       => '',
            'mobile_extra' => '',
            'mobile'       => '',
            'smobile'      => '' 
        ]);
        
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $align_class = [];
        if(!empty($settings[$args['name']]) || !empty($args['default'])){
            $align_class[] = $args['prefix_class'].$widget->get_setting($args['name'], $args['default']);
        }
        // Align Class
        foreach ( $active_devices as $key => $breakpoint_key ) {
            $breakpoint_key_class =  str_replace('_','-',$breakpoint_key);

            $setting_breakpoint_key = $widget->get_setting($args['name'].'_' . $breakpoint_key, $args[$breakpoint_key]);

            if($breakpoint_key !== 'desktop' && !empty($setting_breakpoint_key) ){
                //$align_class[] = $args['prefix_class'].$breakpoint_key_class.'-'.$settings[$args['name'].'_' . $breakpoint_key];
                $align_class[] = $args['prefix_class'].$breakpoint_key_class.'-'.$setting_breakpoint_key;
            }
        }
        // remove duplicate value
        $align_class = array_values(array_unique($align_class));
        
        // return
        return allianz_nice_class($align_class);
    }
}

// Grid Columns
if(!function_exists('allianz_elementor_grid_columns_settings')){
    function allianz_elementor_grid_columns_settings($widget, $args=[]){
        $args = wp_parse_args($args, [
            'name'      => 'col',
            'label'     => esc_html__('Grid Settings', 'allianz'),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'separator' => 'after',
            'condition' => []
        ]);
        $widget->start_controls_section(
            $args['name'].'_grid_section',
            [
                'label'     => $args['label'],
                'tab'       => $args['tab'],
                'condition' => $args['condition']
            ]
        );

            $widget->add_responsive_control(
                $args['name'],
                [
                    'label'        => esc_html__('Columns', 'allianz'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => '',
                    'default_args' => [
                        'tablet' => '',
                        'mobile' => ''
                    ],
                    'options' => [
                        ''     => esc_html__('Default', 'allianz'),
                        '1'    => '1',
                        '2'    => '2',
                        '3'    => '3',
                        '4'    => '4',
                        '5'    => '5',
                        '6'    => '6',
                        'auto' => esc_html__('Auto','allianz'),
                    ],
                    'separator' => $args['separator']
                ]
            );
            $widget->add_control(
                'col_separator',
                [
                    'label'        => esc_html__('Add separator?','allianz'),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes'
                ]
            );
        $widget->end_controls_section();
    }
}
if(!function_exists('allianz_elementor_get_grid_columns')){
    function allianz_elementor_get_grid_columns($widget = [], $settings = [], $args = []){
        $args = wp_parse_args($args, [
            'name'         => 'col',
            'prefix_class' => 'flex-col-',
            'default'      => '',
            'widescreen'   => '', 
            'desktop'      => '',
            'laptop'       => '',
            'tablet_extra' => '',
            'tablet'       => '',
            'mobile_extra' => '',
            'mobile'       => '',
            'smobile'      => '1'
        ]); 
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [ 'reverse' => true ] );
        $align_class = [];
        if(!empty($settings[$args['name']]) || !empty($args['default']) ){
            $class = (isset($settings[$args['name']]) && !empty($settings[$args['name']])) ? $settings[$args['name']] : $args['default'];
            $align_class[] = $args['prefix_class'].$class;
        }
        // Align Class
        foreach ( $active_devices as $key => $breakpoint_key ) {
            $breakpoint_key_class =  str_replace('_','-',$breakpoint_key);
            $setting_breakpoint_key = (isset($settings[$args['name'].'_' . $breakpoint_key]) && !empty($settings[$args['name'].'_' . $breakpoint_key])) ? $settings[$args['name'].'_' . $breakpoint_key] : $args[$breakpoint_key];

            if($breakpoint_key !== 'desktop' && !empty($setting_breakpoint_key) ){
                $align_class[] = $args['prefix_class'].$breakpoint_key_class.'-'.$setting_breakpoint_key;
            }
        }
        $align_class[] = 'flex-col-smobile-'.$args['smobile'];
        $align_class[] = 'flex-col-separator-'.$widget->get_setting('col_separator', 'no');
        // remove duplicate value
        $align_class = array_values(array_unique($align_class));
        
        // return
        return allianz_nice_class($align_class);
    }
}

if(!function_exists('allianz_elementor_colors_opts')){
    function allianz_elementor_colors_opts($widget=[],$args = []){
        $args = wp_parse_args($args, [
            'name'      => '',
            'selector'  => [],
            'label'     => esc_html__('Color', 'allianz'),
            'separator' => '',
            'condition' => [],
            'custom'    => true    
        ]);
        $widget->add_control(
            $args['name'],
            [
                'label'     => $args['label'],
                'type'      => Controls_Manager::SELECT,
                'options'   => allianz_theme_colors(['custom' => $args['custom']]),
                'default'   => '',
                'separator' => $args['separator'],
                'condition' => $args['condition']
            ]
        );
        if($args['custom']){
            $widget->add_control(
                $args['name'].'_custom',
                [
                    'label'     => $args['label'].' '.esc_html__( 'Custom', 'allianz' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => $args['selector'],
                    'condition' => array_merge(
                        $args['condition'],
                        [
                            $args['name'] => 'custom'
                        ]
                    )
                ]
            );
        }
    }
}
// Carousel Setting
if(!function_exists('allianz_elementor_carousel_settings')){
    function allianz_elementor_carousel_settings($widget, $args = []){
        $args = wp_parse_args($args, [
            'label'     => esc_html__('Carousel Settings', 'allianz'),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'condition' => [],
            'hover_icon'=> false
        ]);
        $widget->start_controls_section(
            'carousel_section',
            [
                'label'     => $args['label'],
                'tab'       => $args['tab'],
                'condition' => $args['condition']
            ]
        );
            $widget->add_control(
                'item_shadow',
                [
                    'label'     => esc_html__('Item Shadow?', 'allianz'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => [
                        'yes' => esc_html__('Yes', 'allianz'),
                        'no'   => esc_html__('No', 'allianz')
                    ],
                    'default' => 'no',
                    'dynamic' => [
                        'active' => true
                    ],
                    'style_transfer' => true,
                    'prefix_class' => 'cms-carousel-item-shadow-',

                ]
            );
            $widget->add_control(
                'content_width',
                [
                    'label'     => esc_html__('Content Width', 'allianz'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => [
                        ''             => esc_html__('Default', 'allianz'),
                        'start'        => esc_html__('Full to Start', 'allianz'),
                        'end'          => esc_html__('Full to End', 'allianz'),
                        'start-medium' => esc_html__('Full to Start (Medium [usedxxx])', 'allianz'),
                        'end-medium'   => esc_html__('Full to End (Medium [usedxxx])', 'allianz'),
                        'start-large'  => esc_html__('Full to Start (Large)', 'allianz'),
                        'end-large'    => esc_html__('Full to End (Large)', 'allianz'),
                        'start-mlarge' => esc_html__('Full to Start (Medium Large)', 'allianz'),
                        'end-mlarge'   => esc_html__('Full to End (Medium Large)', 'allianz'),
                        'start-xlarge' => esc_html__('Full to Start (Extra Large)', 'allianz'),
                        'end-xlarge'   => esc_html__('Full to End (Extra Large)', 'allianz'),
                        'both'         => esc_html__('Full to Both', 'allianz')
                    ],
                    'prefix_class' => 'cms-swiper-full-',
                    'separator'    => 'after'
                ]
            );
            
            $slides_to_show = range(1, 10);
            $slides_to_show = array_combine($slides_to_show, $slides_to_show);
            $widget->add_responsive_control(
                'slides_to_show',
                [
                    'label'   => esc_html__('Slides to Show', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                            '' => esc_html__('Default', 'allianz'),
                            //'auto' => esc_html__('Auto', 'allianz'),
                        ] + $slides_to_show,
                    'frontend_available' => true,
                ]
            );

            $widget->add_responsive_control(
                'slides_to_scroll',
                [
                    'label'       => esc_html__('Slides to Scroll', 'allianz'),
                    'type'        => Controls_Manager::SELECT,
                    'description' => esc_html__('Set how many slides are scrolled per swipe.', 'allianz'),
                    'options'     => [
                            '' => esc_html__('Default', 'allianz'),
                        ] + $slides_to_show,
                    'condition' => [
                        'slides_to_show!' => ['auto','1'],
                    ],
                    'frontend_available' => true,
                ]
            );
            $widget->add_responsive_control(
                'space_between',
                [
                    'label' => esc_html__('Space Between', 'allianz'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 40,
                    ],
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'drag-cursor',
                [
                    'label'              => esc_html__('Drag Cursor', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'frontend_available' => false,
                    'return_value'       => 'drag-cursor'
                ]
            );
            $widget->add_control(
                'lazyload',
                [
                    'label'              => esc_html__('Lazyload', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'autoplay',
                [
                    'label'              => esc_html__('Autoplay', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'pause_on_hover',
                [
                    'label'              => esc_html__('Pause on Hover', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'autoplay' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'pause_on_interaction',
                [
                    'label'              => esc_html__('Pause on Interaction', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'autoplay' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'autoplay_speed',
                [
                    'label'     => esc_html__('Autoplay Speed', 'allianz'),
                    'type'      => Controls_Manager::NUMBER,
                    'default'   => 5000,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'infinite',
                [
                    'label'              => esc_html__('Infinite Loop', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'effect',
                [
                    'label'   => esc_html__('Effect', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'slide',
                    'options' => [
                        'slide' => esc_html__('Slide', 'allianz'),
                        'fade'  => esc_html__('Fade', 'allianz'),
                    ],
                    'condition' => [
                        'slides_to_show' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'speed',
                [
                    'label'              => esc_html__('Animation Speed', 'allianz'),
                    'type'               => Controls_Manager::NUMBER,
                    'default'            => 500,
                    'render_type'        => 'none',
                    'frontend_available' => true
                ]
            );
            $widget->add_control(
                'arrows',
                [
                    'label'              => esc_html__('Show Arrows', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'label_block'        => true
                ]
            );
            $widget->add_control(
                'arrows_type',
                [
                    'label'   => esc_html__('Arrows Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''       => esc_html__('Default','allianz'),
                        'button' => esc_html__('Button','allianz'),
                        'icon'   => esc_html__('Icon','allianz')
                    ],
                    'label_block' => false,
                    'condition'   => [
                        'arrows' => 'yes'
                    ]
                ]
            );
            
            $widget->add_control(
                'arrow_prev_icon',
                [
                    'label'            => esc_html__('Previous Arrow Icon', 'allianz'),
                    'type'             => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'skin'             => 'inline',
                    'label_block'      => false,
                    'skin_settings'    => [
                        'inline' => [
                            'none' => [
                                'label' => 'Default',
                                'icon'  => 'cmsi-chevron-left',
                            ],
                            'icon' => [
                                'icon' => 'cmsi-chevron-left',
                            ]
                        ]
                    ],
                    'condition' => [
                        'arrows' => 'yes'
                    ],
                ]
            );
            if($args['hover_icon']){
                $widget->add_control(
                    'arrow_prev_icon_hover',
                    [
                        'label'            => esc_html__('Previous Arrow Icon Hover', 'allianz'),
                        'type'             => Controls_Manager::ICONS,
                        'skin'             => 'inline',
                        'label_block'      => false,
                        'skin_settings'    => [
                            'inline' => [
                                'none' => [
                                    'label' => 'Default',
                                    'icon'  => 'cmsi-arrow-left',
                                ],
                                'icon' => [
                                    'icon' => 'cmsi-arrow-left',
                                ]
                            ]
                        ],
                        'condition' => [
                            'arrows' => 'yes'
                        ]
                    ]
                );
            }
            $widget->add_control(
                'arrow_next_icon',
                [
                    'label'            => esc_html__('Next Arrow Icon', 'allianz'),
                    'type'             => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'skin'             => 'inline',
                    'label_block'      => false,
                    'skin_settings'    => [
                        'inline' => [
                            'none' => [
                                'label' => 'Default',
                                'icon'  => 'cmsi-chevron-right',
                            ],
                            'icon' => [
                                'icon' => 'cmsi-chevron-right',
                            ],
                        ],
                    ],
                    'condition' => [
                        'arrows' => 'yes'
                    ],
                ]
            );
            if($args['hover_icon']){
                $widget->add_control(
                    'arrow_next_icon_hover',
                    [
                        'label'            => esc_html__('Next Arrow Icon Hover', 'allianz'),
                        'type'             => Controls_Manager::ICONS,
                        'skin'             => 'inline',
                        'label_block'      => false,
                        'skin_settings'    => [
                            'inline' => [
                                'none' => [
                                    'label' => 'Default',
                                    'icon'  => 'cmsi-arrow-right',
                                ],
                                'icon' => [
                                    'icon' => 'cmsi-arrow-right',
                                ],
                            ],
                        ],
                        'condition' => [
                            'arrows' => 'yes'
                        ]
                    ]
                );
            }

            $widget->add_control(
                'arrows_size',
                [
                    'label' => esc_html__('Arrow Size', 'allianz'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 20,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-carousel-button' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'arrows' => 'yes',
                    ],
                ]
            );
            $widget->add_control(
                'arrows_icon_size',
                [
                    'label' => esc_html__('Arrow Icon Size', 'allianz'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 60,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-carousel-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .cms-carousel-button-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'arrows' => 'yes',
                    ],
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'arrows_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-carousel-button,' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cms-carousel-button svg' => 'fill: {{VALUE}};'
                ],
                'condition' => [
                    'arrows' => 'yes'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'arrows_hover_color',
                'label'     => esc_html__( 'Hover/Active Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-carousel-button:hover,' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cms-carousel-button:hover svg' => 'fill: {{VALUE}};'
                ],
                'condition' => [
                    'arrows' => 'yes'
                ]
            ]);
            allianz_add_hidden_device_controls($widget, [
                'prefix'    => 'arrows_',
                'condition' => [
                    'arrows' => 'yes'
                ]
            ]);
            // Dots
            $widget->add_control(
                'dots',
                [
                    'label'              => esc_html__('Show Dots', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'label_block'        => true
                ]
            );
            $widget->add_control(
                'dots_type',
                [
                    'label'              => esc_html__('Dots Type', 'allianz'),
                    'type'               => Controls_Manager::SELECT,
                    'options'            => [
                        'progressbar'      => esc_html__('Progressbar','allianz'),
                        'bullets'          => esc_html__('Bullets','allianz'),
                        'circle'           => esc_html__('Dots Circle','allianz'),
                        'number'           => esc_html__('Number','allianz'),
                        'fraction'         => esc_html__('Fraction (Current/Total)','allianz'),
                        'current-of-total' => esc_html__('Current of Total', 'allianz'),
                        'custom'           => esc_html__('Custom','allianz'),
                    ],
                    'default'            => 'bullets',
                    'frontend_available' => true,
                    'condition' => [
                        'dots' => 'yes'
                    ]
                ]
            );
            $widget->add_control( // This option need for make custom html dots
                'number_of_dots',
                [
                    'label'              => esc_html__('Number of Dots', 'allianz'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 1,
                    'max'                => 6,
                    'default'            => 1,
                    'frontend_available' => true,
                    'condition'          => [
                        'dots' => 'yes',
                        'dots_type' => 'custom'
                    ],
                ]
            );
            $widget->add_control(
                'dots_size',
                [
                    'label' => esc_html__('Size', 'allianz'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 5,
                            'max' => 10,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'dots'       => 'yes',
                        'dots_type!' => 'custom'
                    ],
                ]
            );
            $widget->add_control(
                'dots_inactive_color',
                [
                    'label' => esc_html__('Color', 'allianz'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // The opacity property will override the default inactive dot color which is opacity 0.2.
                        '{{WRAPPER}} .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)' => 'background: {{VALUE}}; opacity: 1',
                    ],
                    'condition' => [
                        'dots'       => 'yes',
                        'dots_type!' => 'custom'
                    ],
                ]
            );

            $widget->add_control(
                'dots_color',
                [
                    'label' => esc_html__('Active Color', 'allianz'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};',
                    ],
                    'condition' => [
                        'dots'       => 'yes',
                        'dots_type!' => 'custom'
                    ],
                ]
            );
            allianz_add_hidden_device_controls($widget, [
                'prefix'    => 'dots_',
                'condition' => [
                    'dots'       => 'yes',
                    'dots_type!' => 'custom'
                ]
            ]);
        $widget->end_controls_section();
    }
}
if(!function_exists('allianz_elementor_swipper_wrapper_classes_render')){
    function allianz_elementor_swipper_wrapper_classes_render($widget, $settings){
        $widget->add_render_attribute('swiper-wrapper', [
            'class' => [
                'swiper-wrapper',
                $settings['drag-cursor']
            ]
        ]);
        etc_print_html($widget->get_render_attribute_string('swiper-wrapper'));
    }
}
// Filter Settings
if(!function_exists('allianz_elementor_filter_settings')){
    function allianz_elementor_filter_settings($widget = []){
        $widget->add_control(
            'filter',
            [
                'label'   => esc_html__('Enable Filter', 'allianz'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'true'  => esc_html__('Enable', 'allianz'),
                    'false' => esc_html__('Disable', 'allianz'),
                ],
                'default' => 'false',
            ]
        );
        $widget->add_control(
            'filter_default_title',
            [
                'label'     => esc_html__('Filter Default Title', 'allianz'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('All', 'allianz'),
                'condition' => [
                    'filter' => 'true',
                ],
            ]
        );
        $widget->add_control(
            'filter_alignment',
            [
                'label'   => esc_html__('Filter Alignment', 'allianz'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'center' => esc_html__('Center', 'allianz'),
                    'start'  => esc_html__('Start', 'allianz'),
                    'end'    => esc_html__('End', 'allianz'),
                ],
                'default'   => 'center',
                'condition' => [
                    'filter' => 'true',
                ],
            ]
        );
        allianz_elementor_colors_opts($widget, [
            'name'      => 'filter_color',
            'label'     =>  esc_html__('Filter Color', 'allianz'),
            'condition' => [
                'filter' => 'true',
            ],
            'selector' => [
                '{{WRAPPER}} .filter-item.text-custom:not(:hover):not(.active)' => 'color:{{VALUE}};'
            ]
        ]);
        allianz_elementor_colors_opts($widget, [
            'name'      => 'filter_color_hover',
            'label'     =>  esc_html__('Filter Color Hover', 'allianz'),
            'condition' => [
                'filter' => 'true',
            ],
            'separator' => 'after',
            'selector' => [
                '{{WRAPPER}} .filter-item.text-hover-custom:hover' => 'color:{{VALUE}};',
                '{{WRAPPER}} .filter-item.text-hover-custom.active' => 'color:{{VALUE}};'
            ]
        ]);
    }
}
// Filter Render 
if(!function_exists('allianz_elementor_filter_render')){
    function allianz_elementor_filter_render($widget = [], $settings = [], $args = []){
        $args = wp_parse_args($args, [
            'categories' => ''
        ]);
        $filter               = $widget->get_setting('filter', 'false');
        $filter_default_title = $widget->get_setting('filter_default_title', 'All');
        $filter_alignment     = $widget->get_setting('filter_alignment', 'center');
        $filter_color         = $widget->get_setting('filter_color', 'primary');
        $filter_color_hover   = $widget->get_setting('filter_color_hover', 'accent-regular');
        // item attribute
        $widget->add_render_attribute('filter',[
            'class' => [
                'grid-filter-wrap',
                'd-flex justify-content-'.$filter_alignment
            ],
            'style' => '--cms-filter-color:'.$filter_color.';--cms-filter-color-hover:'.$filter_color_hover.';'
        ]);
        $widget->add_render_attribute('filter-item',[
            'class' => [
                'filter-item active',
                'text-'.$filter_color,
                'text-hover-'.$filter_color_hover,
                'text-active-'.$filter_color_hover,
                'cms-hover-underline'
            ],
            'data-filter' => '*'
        ]);
        if ($filter == "true"): ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('filter')); ?>>
            <span <?php etc_print_html($widget->get_render_attribute_string('filter-item')); ?>><span class="filter--item" data-hover="<?php echo esc_attr($filter_default_title); ?>"><?php echo esc_html($filter_default_title); ?></span></span>
            <?php foreach ($args['categories'] as $key => $category): 
                $category_arr = explode('|', $category);
                $tax[] = $category_arr[1];
                $term = get_term_by('slug', $category_arr[0], $category_arr[1]);

                $item_key = $widget->get_repeater_setting_key( 'item', 'filter', $key );
                $widget->add_render_attribute( $item_key, [
                    'class' => [
                        'filter-item',
                        'text-'.$filter_color,
                        'text-hover-'.$filter_color_hover,
                        'text-active-'.$filter_color_hover,
                        'cms-hover-underline'
                    ],
                    'data-filter' => $category
                ]);
            ?>
                <span <?php etc_print_html($widget->get_render_attribute_string($item_key)); ?>>
                    <span class="filter--item" data-hover="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></span>
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif;
    }
}
// Render circle text 
if(!function_exists('allianz_circle_text')){
    function allianz_circle_text($args = []){
        $args = wp_parse_args($args, [
            'class'            => '',
            'dimensions'       => 140,
            'background_color' => 'transparent',
            'background_img'   => '',
            'fill'             => 'transparent',
            'space'            => '', 
            'color'            => 'accent',
            'text'             => '',
            'echo'             => true,
            'before'           => '',
            'after'            => '',
            // 
            'svg_class'        => 'cms-spin text-30',
        ]);

        $text             = $args['text'];
        $background_color = $args['background_color'];
        $background_img   = $args['background_img'];
        $fill             = $args['fill'];
        $color            = $args['color'];
        $dimensions       = $args['dimensions'];

        $classes = ['cms-circle-text relative circle overflow-hidden', 'bg-'.$args['background_color'], $args['class']];

        ob_start();
    ?>
    <div class="<?php echo allianz_nice_class($classes); ?>" style="width:<?php echo esc_attr($dimensions);?>px; height: <?php echo esc_attr($dimensions);?>px; background-image: var(--cms-bg-img); padding:<?php echo esc_attr($args['space']).'px'; ?>">
        <?php printf('%s', $args['before']); ?>
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 300 300" enable-background="new 0 0 300 300" xml:space="preserve" class="<?php echo esc_attr($args['svg_class']) ?>">
            <defs>
                <path id="cms-criclePath" d=" M 150, 150 m -120, 0 a 120,120 0 0,1 240,0 a 120,120 0 0,1 -240,0 "/>
            </defs>
            <circle cx="150" cy="150" r="150" fill="<?php echo esc_attr($fill);?>"/>
            <g>
                <use xlink:href="#cms-criclePath" fill="none"/>
                <text fill="<?php echo esc_attr($color);?>">
                    <textPath xlink:href="#cms-criclePath"><?php echo esc_html($text); ?></textPath>
                </text>
            </g>
        </svg>
        <?php printf('%s', $args['after']); ?>
    </div>
    <?php
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
// Elementor default Icon
if(!function_exists('allianz_elementor_icon_default')){
    function allianz_elementor_icon_default($icon = ['value' => '', 'library' => ''], $default = ['value' => '', 'library']){
        if(empty($icon['value'])) $icon = $default;
        return $icon;
    }
}
if(!function_exists('allianz_elementor_icon_render')){
    function allianz_elementor_icon_render($icon=[], $default=[], $attrs=[], $tag = 'i', $before = '', $after = ''){
        $attrs = wp_parse_args($attrs, [
            'icon_size'        => '',
            'icon_color'       => '',
            'icon_color_hover' => '',
            'class'            => ''
        ]);
        $attrs['class'] = is_string($attrs['class']) ?  explode(' ', $attrs['class']) : $attrs['class'];
        $style = '';
        // before
        printf('%s', $before);
        if($icon['library'] === 'svg') {
            $classes = array_unique(array_merge([
                    'cms-eicon-uploaded-svg',
                    !empty($attrs['icon_size']) ? 'text-'.$attrs['icon_size'] : '',
                    !empty($attrs['icon_color']) ? 'text-'.$attrs['icon_color']: '',
                    !empty($attrs['icon_color_hover']) ? 'text-hover-'.$attrs['icon_color_hover'] : '',
                    'lh-0' 
                ],
                $attrs['class']
            ));
            $attrs['class'] = $classes;
            $attrs['data-size'] = $attrs['icon_size'];

            unset($attrs['icon_size']);
            unset($attrs['icon_color']);
            unset($attrs['icon_color_hover']);
        ?>
            <<?php etc_print_html($tag.' '.\Elementor\Utils::render_html_attributes( $attrs ));?> ><?php 
                Icons_Manager::render_icon( $icon, $attrs, $tag );
            ?></<?php etc_print_html($tag) ?>>
        <?php } else {
            $attrs['class'] = array_merge(
                (array)$attrs['class'],
                [
                    !empty($attrs['icon_size']) ? 'text-'.$attrs['icon_size'] : '',
                    !empty($attrs['icon_color']) ? 'text-'.$attrs['icon_color'] : '',
                    !empty($attrs['icon_color_hover']) ? 'text-hover-'.$attrs['icon_color_hover'] : ''
                ]
            );
            unset($attrs['icon_size']);
            unset($attrs['icon_color']);
            unset($attrs['icon_color_hover']);
            Icons_Manager::render_icon( allianz_elementor_icon_default($icon, $default), $attrs, $tag ); 
        }
        printf('%s', $after);
    }
}
// Icon & Image Settings 
if(!function_exists('allianz_elementor_icon_image_settings')){
    function allianz_elementor_icon_image_settings($widget, $args = []){
        $args = wp_parse_args($args, [
            // Group
            'label'     => esc_html__('Icon/Image Settings', 'allianz'),
            'tab'       => Controls_Manager::TAB_CONTENT,
            'condition' => [],
            'conditions' => [],
            'group'     => true,
            'skin'      => 'inline',
            //
            'prefix'   => '',
            'name'     => 'icon_img',
            'type'     => 'icon', 
            // icon
            'icon_label'   => __('Choose Icon','allianz'),
            'icon_default' => [
                'library' => 'cmsi',
                'value'   => 'cmsi-alert'  
            ],
            // image
            'img_label'        => __('Choose Image','allianz'),
            'img_default'      => [],
            'img_size'         => true, 
            'img_default_size' => 'thumbnail',
        ]);
        if(!empty($args['conditions'])){
            $condition_tag = 'conditions';
            $condition_value = $args['conditions'];
            $condition_relation_icon = array_merge(
                [
                    $args['prefix'].$args['name'].'_type' => 'icon'
                ],
                $args['conditions']
            );
            $condition_relation_img = array_merge(
                [
                    $args['prefix'].$args['name'].'_type' => 'image',
                ],
                $args['conditions']
            );
            $condition_relation_img_size = array_merge(
                [
                    $args['prefix'].$args['name'].'_type'        => 'image',
                    $args['prefix'].$args['name'].'_image[url]!' => '',
                ],
                $args['conditions']
            );
        } else {
            $condition_tag = 'condition';
            $condition_value = $args['condition'];
            $condition_relation_icon = array_merge(
                [
                    $args['prefix'].$args['name'].'_type' => 'icon'
                ],
                $args['condition']
            );
            $condition_relation_img = array_merge(
                [
                    $args['prefix'].$args['name'].'_type' => 'image',
                ],
                $args['condition']
            );
            $condition_relation_img_size = array_merge(
                [
                    $args['prefix'].$args['name'].'_type'        => 'image',
                    $args['prefix'].$args['name'].'_image[url]!' => '',
                ],
                $args['condition']
            );
        }
        if($args['group']){
            $widget->start_controls_section(
                $args['prefix'].'icon_img_section',
                [
                    'label'        => $args['label'],
                    'tab'          => $args['tab'],
                    $condition_tag => $condition_value
                ]
            );
        }
            $widget->add_control(
                $args['prefix'].$args['name'].'_type',
                [
                    'label'   => esc_html__('Icon Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'icon'  => esc_html__('Icon','allianz'),
                        'image' => esc_html__('Image','allianz'),
                        ''      => esc_html__('None','allianz'),
                    ],
                    'default' => $args['type'],
                    $condition_tag => $condition_value
                ]
            );
            $widget->add_control(
                $args['prefix'].$args['name'].'_icon',
                [
                    'label'     => $args['icon_label'],
                    'type'      => Controls_Manager::ICONS,
                    $condition_tag => $condition_relation_icon,
                    'default'     => $args['icon_default'],
                    'skin'        => $args['skin'],
                    'label_block' => false
                ]
            );
            $widget->add_control(
                $args['prefix'].$args['name'].'_image',
                [
                    'label'       => $args['img_label'],
                    'type'        => Controls_Manager::MEDIA,
                    $condition_tag => $condition_relation_img,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'skin'        => $args['skin'],
                    'label_block' => false
                ]
            );
            if($args['img_size']){
                $widget->add_group_control(
                    Group_Control_Image_Size::get_type(),
                    [
                        'name'         => $args['prefix'].$args['name'].'_image',
                        'label'        => esc_html__('Image Size','allianz'),
                        'default'      => $args['img_default_size'],
                        $condition_tag => $condition_relation_img_size,
                    ]
                );
            }
        if($args['group']){
            $widget->end_controls_section();
        }
    }
}
// Icon & Image Render
if(!function_exists('allianz_elementor_icon_image_render')){
    function allianz_elementor_icon_image_render($widget = [], $settings = [], $args = [], $data = []){
        $args = wp_parse_args($args,[
            'prefix'      => '',
            'name'        => 'icon_img',
            'size'        => 64,
            'color'       => 'accent',
            'color_hover' => 'accent',
            // icon
            'icon_tag'    => 'div',
            // image
            'img_size'   => true,
            // default
            'class'      => '',
            'before'     => '',
            'after'      => '',
            'echo'       => true,
        ]);
        if(!empty($data)){
            $settings = $data;
        }
        $icon_type = $settings[$args['prefix'].$args['name'].'_type'];
        // Render Icon / Image
        switch ($icon_type) {
            case 'image':
                allianz_elementor_image_render( $settings, [
                    'name'           => $args['prefix'].$args['name'].'_image',
                    'image_size_key' => $args['prefix'].$args['name'].'_image',
                    'img_class'      => $args['class'], 
                    'custom_size'    => ['width' => $args['size'], 'height' => $args['size']],
                    'before'         => $args['before'],
                    'after'          => $args['after']  
                ]);
                break;
            case 'icon':
                allianz_elementor_icon_render($settings[$args['prefix'].$args['name'].'_icon'], [], [
                    'aria-hidden'      => 'true', 
                    'class'            => $args['class'], 
                    'icon_size'        => $args['size'], 
                    'icon_color'       => $args['color'], 
                    'icon_color_hover' => $args['color_hover']  
                ], $args['icon_tag'], $args['before'], $args['after']);
                break;
        }
    }
}
/**
 * Elementor Taxonomies List
 * */
if(!function_exists('allianz_elementor_taxonomies_list')){
    function allianz_elementor_taxonomies_list($args = []){
        $args = wp_parse_args($args, [
            'custom'  => false,
            'default' => true
        ]);
        $_taxonomies = get_taxonomies( array( 'show_tagcloud' => true ), 'object' );
        unset($_taxonomies['elementor_library_category']);
        unset($_taxonomies['wpc_group_badge']);
        unset($_taxonomies['wpc-badge-group']);
        unset($_taxonomies['link_category']);
        $taxonomies = [];
        if(!$args['default']){
            $taxonomies[] = esc_html__('Default','allianz');
        }
        foreach ( $_taxonomies as $key => $tax ) :
            $taxonomies[$key] = esc_html( $tax->labels->name );
        endforeach;
        if($args['custom']){
            $taxonomies['custom'] = esc_html__('Custom', 'allianz');
        }
        return $taxonomies;
    }
}
/**
 * 
 * Elemenor Taxonomies List Settings
 * */
if(!function_exists('allianz_elementor_taxonomies_settings')){
    function allianz_elementor_taxonomies_settings($widget=[], $args = []){
        $args = wp_parse_args($args, [
            'prefix'    => '',
            'label'     => esc_html__('Taxonomy', 'allianz'),
            'tab'       => Controls_Manager::TAB_CONTENT,
            'default'   => '',
            'condition' => [],
            'custom'    => false,
            'multiple'  => true
        ]);
        $widget->start_controls_section(
             $args['prefix'].'_taxonomy_section',
            [
                'label'     => $args['label'].' '.esc_html__('Settings','allianz'),
                'tab'       => $args['tab'],
                'condition' => $args['condition']
            ]
        );
            $widget->add_control(
                $args['prefix'].'_taxonomy',
                [
                    'type'     => Controls_Manager::SELECT,
                    'label'    => $args['label'],
                    'options'  => allianz_elementor_taxonomies_list(['custom' => $args['custom']]),
                    'default'  => $args['default']
                ]
            );
            allianz_elementor_term_by_taxonomy_settings($widget, [
                'prefix'    => $args['prefix'],
                'custom'    => $args['custom'],
                'multiple'  => $args['multiple']   
            ]);
            
        $widget->end_controls_section();
    }
}
/**
 * 
 * Elemenor Term list by Taxonomy
 * */
if(!function_exists('allianz_elementor_term_by_taxonomy_settings')){
    function allianz_elementor_term_by_taxonomy_settings($widget=[],$args = []){
        $args = wp_parse_args($args, [
            'prefix'           => '',
            'custom_condition' => [],
            'multiple'         => true
        ]);
        $_taxonomies = get_taxonomies( array( 'show_tagcloud' => true ), 'object' );       
        unset($_taxonomies['elementor_library_category']);
        foreach ($_taxonomies as $tax) {
            $widget->add_control(
                $args['prefix'].'term_'.$tax->name,
                [
                    'label'     => sprintf(esc_html__( 'Select Term of %s', 'allianz' ), $tax->labels->name),
                    'type'      => Controls_Manager::SELECT2,
                    'multiple'  => $args['multiple'],
                    'options'   => allianz_elementor_term_by_taxonomy($tax->name),
                    'condition' => array_merge(
                        [
                            $args['prefix'].'_taxonomy' => [$tax->name]
                        ],
                        $args['custom_condition']
                    ),
                    'label_block' => true
                ]
            );
        }
    }
}
if(!function_exists('allianz_elementor_term_by_taxonomy')){
    function allianz_elementor_term_by_taxonomy($tax = '')
    {
        $term_list = array();
        $terms = get_terms(
            array(
                'taxonomy'   => $tax,
                'hide_empty' => true,
                'orderby'    => 'include'
            )
        );
        foreach ($terms as $term) {
            //$term_list[$term->slug . '|' . $tax] = $term->name;
            $term_list[$term->term_id] = $term->name;
        }
        return $term_list;
    }
}
// Elementor Counter Chart
if(!function_exists('allianz_elementor_counter_chart_settings')){
    function allianz_elementor_counter_chart_settings($widget){

    }
}
if(!function_exists('allianz_elementor_counter_chart_render')){
    function allianz_elementor_counter_chart_render($widget= [], $settings= [], $args = []){
        $args = wp_parse_args($args, [
            'value'           => 30,
            'value_separator' => ',',
            'suffix'          => '%',
            'prefix'          => '',
            'duration'        => 3000,
            // stroke
            'stroke'         => 'accent',
            'stroke_w'       => 2,
            'stroke_linecap' => 'inherit',
            'stroke_bg'      => 'primary',
            'stroke_bg_w'    => 2,
            //
            'size'           => 150,
            // text
            'text_size'      => 25,
            'text_color'     => 'primary',
            'text_class'     => '',
            // wrap
            'wrap_class'     => ''       
        ]);
        $wrap_classes = ['cms-counter-charts relative', $args['wrap_class']];
        $text_classes = ['cms-counter-chart-text','absolute center','d-flex', 'text-'.$args['text_size'], 'text-'.$args['text_color'], $args['text_class']];
    ?>
    <div class="<?php echo allianz_nice_class($wrap_classes); ?>" style="width: <?php echo esc_attr($args['size']); ?>px;height: <?php echo esc_attr($args['size']); ?>px;">
        <svg viewBox="0 0 36 36" class="cms-counter-chart">
            <path 
                class="cms-counter-chart-bar-bg stroke-<?php etc_print_html($args['stroke_bg']); ?>" 
                fill="none"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831",
                style="stroke-width:<?php etc_print_html($args['stroke_bg_w']); ?>;"
            />
            <path 
                class="cms-counter-chart-bar stroke-<?php etc_print_html($args['stroke']); ?>"
                fill="none"
                stroke-dasharray="<?php etc_print_html($args['value']) ?>, 100"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" 
                style="stroke-width:<?php etc_print_html($args['stroke_w']); ?>;stroke-linecap:<?php etc_print_html($args['stroke_linecap']); ?>;animation-duration:<?php etc_print_html($args['duration']).'ms;'; ?>"
            />
            <text x="18" y="20.35" class="cms-counter-chart-percentage d-none">
                <?php etc_print_html($args['prefix'].$args['value'].$args['suffix']); ?>
            </text>
        </svg>
        <div class="<?php echo allianz_nice_class($text_classes); ?>">
            <?php etc_print_html('<span class="cms-counter-chart--prefix empty-none">'.$args['prefix'].'</span>'); ?>
            <?php etc_print_html('<span class="cms-counter-chart--percentage cms-counter-number empty-none" data-duration="'.$args['duration'].'" data-to-value="'.$args['value'].'" data-delimiter="'.$args['value_separator'].'">1</span>'); ?>
            <?php etc_print_html('<span class="cms-counter-chart--suffix empty-none">'.$args['suffix'].'</span>'); ?>
        </div>
    </div>
    <?php
    }
}

// Scan files to register controls for each new custom widget
$files = scandir(get_template_directory() . '/elementor/core/widgets');
foreach ($files as $file) {
    $pos = strrpos($file, ".php");
    if ($pos !== false) {
        require_once get_template_directory() . '/elementor/core/widgets/' . $file;
    }
}
/**
 * Extra Elementor Icons
 */
if (!function_exists('allianz_register_custom_icon_library')) {
    add_filter('elementor/icons_manager/native', 'allianz_register_custom_icon_library');
    function allianz_register_custom_icon_library($tabs)
    {
        $custom_tabs = [
            'cmsi_icon' => [
                'name'          => 'cmsi-icon',
                'label'         => esc_html__('CMS Icons', 'allianz'),
                'url'           => get_template_directory_uri() . '/assets/fonts/font-cmsi/style.css',
                'enqueue'       => [],
                'prefix'        => 'cmsi-',
                'displayPrefix' => '',
                'labelIcon'     => 'cmsi-arrow-circle-right',
                'ver'           => '1.0.0',
                'fetchJson'     => get_template_directory_uri() . '/assets/fonts/font-cmsi.js',
                'native'        => true,
            ],
            'cmsi_allianz' => [
                'name'          => 'cmsi-allianz',
                'label'         => esc_html__('CMS Allianz', 'allianz'),
                'url'           => get_template_directory_uri() . '/assets/fonts/font-theme/style.css',
                'enqueue'       => [],
                'prefix'        => 'allianz-icon-',
                'displayPrefix' => '',
                'labelIcon'     => 'allianz-icon-default',
                'ver'           => '1.0.0',
                'fetchJson'     => get_template_directory_uri() . '/assets/fonts/font-theme.js',
                'native'        => true,
            ]
        ];
        $tabs = array_merge($custom_tabs, $tabs);
        return $tabs;
    }
}