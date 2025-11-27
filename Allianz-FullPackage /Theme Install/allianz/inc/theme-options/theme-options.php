<?php
if (class_exists('Theme_Core_Options')) {
    // Set Location of Theme Options Menu
    add_filter('tco_page_parent', 'allianz_tco_parent_page');
    function allianz_tco_parent_page()
    {
        $current_theme = wp_get_theme();
        if (is_child_theme()) {
            $current_theme = $current_theme->parent();
        }
        return $current_theme->get('TextDomain');
    }

    // Set Theme Options Name
    add_filter('tco_theme_options_name', 'allianz_tco_theme_options_name');
    add_filter('swa_ie_options_name', 'allianz_tco_theme_options_name');
    function allianz_tco_theme_options_name()
    {
        $opt_name = allianz_get_opt_name();
        return $opt_name;
    }

    add_filter('tco_theme_options_args', 'allianz_theme_options_args');

    function allianz_theme_options_args()
    {
        $default        = false;
        $default_value  = '1';
        $default_layout = '1';
        $default_on     = 'on';
        $default_off    = 'off';
        $default_width  = 'container';
        $custom_opts    = false;

        $general     = include get_template_directory() . '/inc/theme-options/args/general.php';
        $header_top  = include get_template_directory() . '/inc/theme-options/args/header-top.php';
        $header      = include get_template_directory() . '/inc/theme-options/args/header.php';
        $page_title  = include get_template_directory() . '/inc/theme-options/args/page-title.php';
        $content     = include get_template_directory() . '/inc/theme-options/args/content.php';
        $sidebar     = include get_template_directory() . '/inc/theme-options/args/sidebar.php';
        $shop        = include get_template_directory() . '/inc/theme-options/args/shop.php';
        $footer      = include get_template_directory() . '/inc/theme-options/args/footer.php';
        $api         = include get_template_directory() . '/inc/theme-options/args/api.php';
        $page_404    = include get_template_directory() . '/inc/theme-options/args/404-page.php';
        $popup       = include get_template_directory() . '/inc/theme-options/args/popup.php';

        $args = [
            'general'     => $general,
            'header_top'  => $header_top,
            'header'      => $header,
            'page-title'  => $page_title,
            'content'     => $content,
            'sidebar'     => $sidebar,  
            'footer'      => $footer,
            '404-page'    => $page_404,
        ];
        if(class_exists('WooCommerce')){
            $args['shop'] =  $shop;
        }
        $args['popup'] = $popup;
        $args['api'] = $api;

        return $args;
    }
}
/**
 * Color list from theme configs
 * 
 * **/
function allianz_color_list_opts($name = []){
    $colors = (array) allianz_configs($name);
    $opts = [];
    foreach ($colors as $key => $value) {
       //$opts[$key] = sprintf('%1$s (%2$s) %3$s ', ucfirst($key), $value, '<div class="label-desc">('.esc_html__('Default:','allianz').' '.$value.')</div>');
        $opts[$key] = sprintf('%1$s %2$s', ucfirst($key), '<div class="label-desc">'.esc_html__('Default:','allianz').' '.$value.'</div>');
    }
    return $opts;
}
/**
 * Get post thumbnail as image options
 * @return array
 *
*/
function allianz_list_post_thumbnail($post_type = 'post', $default = false, $args = []){
    $layouts = [];
    if($default){
        $layouts['-1'] = get_template_directory_uri() . '/assets/images/default-opt/default.jpg';
        $layouts['none'] = get_template_directory_uri() . '/assets/images/default-opt/none.jpg';
    }
    $layouts = array_unique($layouts + $args);
    $posts = get_posts(array('post_type' => $post_type,'posts_per_page' => '-1'));
    
    foreach($posts as $post){
        $layouts[$post->ID] = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'full');
    }
    return $layouts;
}
/**
 * Typography
**/
if(!function_exists('allianz_typography_opts')){
    function allianz_typography_opts($args = []){
        $default = [
            'body_font' => [
                'type'        => Theme_Core_Options::SELECT_FIELD,
                'title'       => esc_html__('Body Font', 'allianz'),
                'options'     => [
                    'default' => esc_html__('Default', 'allianz'),
                    'custom'  => esc_html__('Custom', 'allianz'),
                ],
                'default'     => 'default'
            ],
            'body_font_typo' => [
                'type'     => Theme_Core_Options::TYPOGRAPHY_FIELD,
                'title'    => esc_html__('Body Custom Font', 'allianz'),
                'subtitle' => esc_html__('This will be the default font of your website.', 'allianz'),
                'required' => [
                    'body_font',
                    '=',
                    'custom'
                ],
                'font_backup'  => false,
                'font_subsets' => false,
                'font_style'   => true, 
                'line_height'  => false,
                'font_size'    => false,
                'color'        => false,
                'output'       => [
                    //'body'
                ]
            ],
            'heading_font' => [
                'type'    => Theme_Core_Options::SELECT_FIELD,
                'title'   => esc_html__('Heading Default Font', 'allianz'),
                'options' => [
                    'default' => esc_html__('Default', 'allianz'),
                    'custom'  => esc_html__('Custom', 'allianz'),
                ],
                'default' => 'default'
            ],
            'heading_font_typo' => [
                'type'     => Theme_Core_Options::TYPOGRAPHY_FIELD,
                'title'    => esc_html__('Heading', 'allianz'),
                'subtitle' => esc_html__('This will be the default font for all Heading tags of your website.', 'allianz'),
                'output'   => [
                    //'h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6,.heading, .cms-heading'
                ],
                'required' => [
                    'heading_font',
                    '=',
                    'custom',
                ],
                'font_backup'  => false,
                'font_subsets' => false,
                'font_style'   => true,
                'line_height'  => false,
                'font_size'    => false,
                'color'        => false,    
            ]
        ];
        return [
            'title'  => esc_html__('Typographys', 'allianz'),
            'fields' => array_merge($default, $args)
        ];
    }
}
if(!function_exists('allianz_general_advanced_opts')){
    function allianz_general_advanced_opts($args = []){
        $default = [
            /*'btn_style' => [
                'type'        => Theme_Core_Options::SELECT_FIELD,
                'title'       => esc_html__('Button Style', 'allianz'),
                'options'     => [
                    'btn-style-default' => esc_html__('Default', 'allianz'),
                    'btn-style-rounded' => esc_html__('Rounded', 'allianz'),
                    'btn-style-rounded5' => esc_html__('Rounded (5px)', 'allianz'),
                ],
                'default' => 'btn-style-default'
            ]*/
        ];
        return [
            'title'  => esc_html__('Advanced', 'allianz'),
            'fields' => array_merge($default, $args)
        ];
    }
}
/**
 * ON/ OFF option
 * 
 * */
function allianz_theme_on_off_opts($args = []){
    $args = wp_parse_args($args, [
        'default'       => false,
        'default_value' => 'off',
        'title'         => esc_html__('On/Off', 'allianz'),
        'subtitle'      => '',
        'required'      => ''
    ]);
    $opts = [
        'on' => esc_html__('On', 'allianz'),
        'off' => esc_html__('Off', 'allianz'),
    ];
    if($args['default']) {
        $opts['-1'] = esc_html__('Default','allianz');
        $args['default_value'] = '-1';
    }
    return [
        'type'     => Theme_Core_Options::BUTTON_SET_FIELD,
        'title'    => $args['title'],
        'subtitle' => $args['subtitle'],
        'options'  => $opts,
        'default'  => $args['default_value'],
        'required' => $args['required']
    ];
}
/**
 * Show/ Hide option
 * 
 * */
function allianz_theme_show_hide_opts($args = []){
    $args = wp_parse_args($args, [
        'default'       => false,
        'default_value' => 'off',
        'title'         => esc_html__('Show/Hide', 'allianz'),
        'subtitle'      => '',
        'required'      => ''    
    ]);
    $opts = [
        'on' => esc_html__('Show', 'allianz'),
        'off' => esc_html__('Hide', 'allianz'),
    ];
    if($args['default']) {
        $opts['-1'] = esc_html__('Default','allianz');
        $args['default_value'] = '-1';
    }
    return [
        'type'     => Theme_Core_Options::BUTTON_SET_FIELD,
        'title'    => $args['title'],
        'subtitle' => $args['subtitle'],
        'options'  => $opts,
        'default'  => $args['default_value'],
        'required' => $args['required']
    ];
}
/**
 * Select Options
 * 
 * */
if(!function_exists('allianz_select_opts')){
    function allianz_select_opts($args = []){
        $args = wp_parse_args($args, [
            'title'         => 'Your title',
            'subtitle'      => '',
            'description'   => '',
            'default'       => false,
            'default_value' => 'opt1',
            'options'       => [
                'opt1'  => __('Options #1', 'allianz'),
                'opt2'  => __('Options #2', 'allianz')
            ],
            'required' => []
        ]);
        if($args['default']){
            $args['default_value'] = '0';
            $options = array_merge(
                [
                    '0' => __('Theme Default','allianz')
                ],
                $args['options']
            );
        } else {
            $options = $args['options'];
        }
        return [
            'title'         => $args['title'],
            'subtitle'      => $args['subtitle'],
            'description'   => $args['description'],
            'type'          => Theme_Core_Options::SELECT_FIELD,
            'options'       => $options,
            'default'       => $args['default_value'],
            'required'      => $args['required']
        ];
    }
}
/**
 * Content Width
 * 
 * */
function allianz_theme_content_width_opts($args = []){
    $args = wp_parse_args($args, [
        'default'       => false,
        'default_value' => 'container',
        'title'         => esc_html__('Content Width','allianz'),
        'subtitle'      => '',
        'required'      => ''
    ]);
    $opts = [
        'container'       => esc_html__('Container', 'allianz'),
        'container-wide'  => esc_html__('Container Wide', 'allianz'),
        'container-fluid' => esc_html__('Container Fluid', 'allianz'),
        'container--full'  => esc_html__('Container Full', 'allianz')
    ];
    if($args['default']) {
        $opts['-1'] = esc_html__('Default','allianz');
        $args['default_value'] = '-1';
    }
    return [
        'type'     => Theme_Core_Options::BUTTON_SET_FIELD,
        'title'    => $args['title'],
        'subtitle' => $args['subtitle'],
        'options'  => $opts,
        'default'  => $args['default_value'],
        'required' => $args['required']
    ];
}
function allianz_theme_content_width_render($args = []){
    $args = wp_parse_args($args, [
        'name'    => '',
        'default' => 'container'
    ]);
    $settings = allianz_get_opts($args['name'], $agrs['default']);
    if(!empty($settings)) return $args['prefix'].$settings;
}
/**
 * Content Alignment
 * **/
function allianz_them_content_align_opts($args = []){
    $args = wp_parse_args($args, [
        'default'       => false,
        'default_value' => '',
        'title'         => esc_html__('Content Alignment','allianz'),
        'subtitle'      => '',
        'required'      => ''
    ]);
    $opts = [
        'start'  => esc_html__('Start', 'allianz'),
        'center' => esc_html__('Center', 'allianz'),
        'end'    => esc_html__('End', 'allianz'),
    ];
    if($args['default']) {
        $opts['-1'] = esc_html__('Default','allianz');
        $args['default_value'] = '-1';
    }
    return [
        'type'     => Theme_Core_Options::BUTTON_SET_FIELD,
        'title'    => $args['title'],
        'subtitle' => $args['subtitle'],
        'options'  => $opts,
        'default'  => $args['default_value'],
        'required' => $args['required']
    ];
}
function allianz_them_content_align_render($args = []){
    $args = wp_parse_args($args, [
        'name'    => '',
        'prefix'  => 'text-',
        'default' => 'start'
    ]);
    $settings = allianz_get_opts($args['name'], $agrs['default']);
    if(!empty($settings)) return $args['prefix'].$settings;
}
/**
 * Menu options
 * 
 * */
if(!function_exists('allianz_theme_menu_opts_list')){
    function allianz_theme_menu_opts_list(){
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        $custom_menus = [
            'primary' => esc_html__('Primary Menu','allianz')
        ];
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            foreach ( $menus as $single_menu ) {
                if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
                    $custom_menus[ $single_menu->slug ] = $single_menu->name;
                }
            }
        }
        return $custom_menus;
    }
}
/**
 * Button Settings
 * 
 * **/
if(!function_exists('allianz_theme_button_settings')){
    function allianz_theme_button_settings($args = []){
        $args = wp_parse_args($args, [
            'name'          => 'h_btn',
            'heading'       => esc_html__('Button Settings','allianz'),  
            'default'       => false,
            'default_value' => 'off'
        ]);
        return [
            $args['name'].'_heading' => [
                'type' => Theme_Core_Options::HEADING_FIELD,
                'title' => $args['heading'],
            ],
            $args['name'].'_on' => allianz_theme_on_off_opts([
                'default'       => $args['default'],    
                'default_value' => $args['default_value'],
                'title'         => esc_html__('Show/Hide Button', 'allianz')
            ]),
            $args['name'].'_text' => [
                'type' => Theme_Core_Options::TEXT_FIELD,
                'title' => esc_html__('Button Text', 'allianz'),
                'required' => [
                    $args['name'].'_on',
                    '=',
                    'on'
                ],
            ],
            $args['name'].'_link_type' => [
                'type' => Theme_Core_Options::BUTTON_SET_FIELD,
                'title' => esc_html__('Button Link Type', 'allianz'),
                'options' => [
                    'page' => esc_html__('Page', 'allianz'),
                    'custom' => esc_html__('Custom', 'allianz'),
                ],
                'default' => 'page',
                'required' => [
                    $args['name'].'_on',
                    '=',
                    'on'
                ],
            ],
            $args['name'].'_link' => [
                'type' => Theme_Core_Options::SELECT_FIELD,
                'title' => esc_html__('Page Link', 'allianz'),
                'args' => [
                    'post_type' => 'page',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
                'select2' => true,
                'required' => [
                    $args['name'].'_link_type',
                    '=',
                    'page'
                ],
            ],
            $args['name'].'_link_custom' => [
                'type' => Theme_Core_Options::TEXT_FIELD,
                'title' => esc_html__('Custom Link', 'allianz'),
                'required' => [
                    $args['name'].'_link_type',
                    '=',
                    'custom'
                ],
            ],
            $args['name'].'_target' => [
                'type' => Theme_Core_Options::BUTTON_SET_FIELD,
                'title' => esc_html__('Button Target', 'allianz'),
                'options' => [
                    '_self' => esc_html__('Self', 'allianz'),
                    '_blank' => esc_html__('Blank', 'allianz'),
                ],
                'default' => '_self',
                'required' => [
                    $args['name'].'_on',
                    '=',
                    'on'
                ],
            ]
        ];
    }
}
/**
 * Phone Settings
 * **/
if(!function_exists('allianz_theme_phone_settings')){
    function allianz_theme_phone_settings($args = []){
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off'
        ]);
        return [
            'show_phone'.$args['name'] => [
                'type'  => Theme_Core_Options::HEADING_FIELD,
                'title' => esc_html__('Phone', 'allianz').' '.$args['name'],
            ],
            'h_phone'.$args['name'].'_on' => allianz_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Phone', 'allianz').' '.$args['name']
            ]),
            'h_phone'.$args['name'].'_text' => [
                'type'        => Theme_Core_Options::TEXT_FIELD,
                'title'       => esc_html__('Phone Text', 'allianz'),
                'placeholder' => 'Need assistance?',
                'required'    => [
                    'h_phone'.$args['name'].'_on',
                    '=',
                    'on'
                ]
            ],
            'h_phone'.$args['name'].'_number' => [
                'type'        => Theme_Core_Options::TEXT_FIELD,
                'title'       => esc_html__('Phone Number', 'allianz'),
                'placeholder' => '+2 0106124541',
                'required'    => [
                    'h_phone'.$args['name'].'_on',
                    '=',
                    'on'
                ]
            ]
        ];
    }
}
/**
 * Mail Settings
 * **/
if(!function_exists('allianz_theme_mail_settings')){
    function allianz_theme_mail_settings($args = []){
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off'
        ]);
        return [
            'show_mail'.$args['name'] => [
                'type'  => Theme_Core_Options::HEADING_FIELD,
                'title' => esc_html__('Mail', 'allianz').' '.$args['name'],
            ],
            'h_mail'.$args['name'].'_on' => allianz_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Mail', 'allianz').' '.$args['name']
            ]),
            'h_mail'.$args['name'].'_text' => [
                'type'        => Theme_Core_Options::TEXT_FIELD,
                'title'       => esc_html__('Your Email', 'allianz'),
                'placeholder' => 'allianz@7oroof.com',
                'required'    => [
                    'h_mail'.$args['name'].'_on',
                    '=',
                    'on'
                ]
            ]
        ];
    }
}
// WooCS Currency Switcher
if(!function_exists('allianz_woo_header_woocs_opts')){
    function allianz_woo_header_woocs_opts($args = []){
        if(!class_exists('WOOCS_STARTER')) return [];
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => []
        ]);
        return [
            'show_woocs'.$args['name'] => [
                'type'  => Theme_Core_Options::HEADING_FIELD,
                'title' => esc_html__('Currency Switcher', 'allianz').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_woocs'.$args['name'].'_on' => allianz_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Currency Switcher', 'allianz').' '.$args['name'],
                'required' => $args['required']
            ])
        ];
    }
}
// WPC Smart Wishlist
if(!function_exists('allianz_woo_header_wishlist_opts')){
    function allianz_woo_header_wishlist_opts($args = []){
        if(!class_exists('WPCleverWoosw')) return [];
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => []
        ]);
        return [
            'show_wishlist'.$args['name'] => [
                'type'  => Theme_Core_Options::HEADING_FIELD,
                'title' => esc_html__('Wishlist', 'allianz').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_wishlist'.$args['name'].'_on' => allianz_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Wishlist', 'allianz').' '.$args['name'],
                'required' => $args['required']
            ])
        ];
    }
}
// WPC Smart Compare
if(!function_exists('allianz_woo_header_compare_opts')){
    function allianz_woo_header_compare_opts($args = []){
        if(!class_exists('WPCleverWoosc')) return [];
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => []
        ]);
        return [
            'show_compare'.$args['name'] => [
                'type'  => Theme_Core_Options::HEADING_FIELD,
                'title' => esc_html__('Compare', 'allianz').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_compare'.$args['name'].'_on' => allianz_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Compare', 'allianz').' '.$args['name'],
                'required' => $args['required']
            ])
        ];
    }
}
/** 
 * Login
 * */
if(!function_exists('allianz_header_login_opts')){
    function allianz_header_login_opts($args = []){
        if(!function_exists('cshlg_link_to_login')) return [];
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => []
        ]);
        return [
            'show_login'.$args['name'] => [
                'type'  => Theme_Core_Options::HEADING_FIELD,
                'title' => esc_html__('Login', 'allianz').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_login'.$args['name'].'_on' => allianz_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Login', 'allianz'),
                'required' => $args['required']
            ])
        ];
    }
}
/**
 * Language Switcher
 * */
if(!function_exists('allianz_header_language_switcher_opts')){
    function allianz_header_language_switcher_opts($args = []){
        if(!class_exists('TRP_Translate_Press') ) return array();
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => [] 
        ]);
        return [
            'show_language'.$args['name'] => [
                'type'  => Theme_Core_Options::HEADING_FIELD,
                'title' => esc_html__('Language Switcher', 'allianz').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_language'.$args['name'].'_on' => allianz_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Language Switcher', 'allianz'),
                'required' => $args['required']
            ])
        ];
    }
}
/**
 * Header layout 
 * 
 * */
if(!function_exists('allianz_theme_header_layout_opts')){
    function allianz_theme_header_layout_opts($args = []){
        $args = wp_parse_args($args, [
            'default'       => false,
            'default_value' => '1',
            'required'      => ''
        ]);
        $header_layout = [];
        if($args['default']){
            $header_layout['-1'] = get_template_directory_uri() . '/assets/images/default-opt/default.jpg';
            $header_layout['none'] = get_template_directory_uri() . '/assets/images/default-opt/none.jpg';
        }
        // Theme Layout
        $layouts = [
            '1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
            '2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
            '3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
            '4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
            '5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
            '6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
        ];
        return [
            'type'     => Theme_Core_Options::IMAGE_SELECT_FIELD,
            'title'    => esc_html__('Layout', 'allianz'),
            'subtitle' => esc_html__('Select a layout for header.', 'allianz'),
            'options'  => array_unique ($header_layout + $layouts),
            'default'  => $args['default_value'],
            'required' => $args['required']
        ];
    }
}
/**
 * Header Side Nav Options
**/
if(!function_exists('allianz_header_side_nav_opts')){
    function allianz_header_side_nav_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'        => '',
            'default_value'  => '',
            'default_layout' => '',
            'required'       => []
        ]);
        if($args['default']){
            $args['default_value'] = '-1';
        }
        if(!apply_filters('allianz_enable_sidenav', false)) return array();
        
        return [
            'hide_sidebar_icon_heading' => [
                'type'     => Theme_Core_Options::HEADING_FIELD,
                'title'    => esc_html__('Hidden Sidebar Settings','allianz'),
                'required' => $args['required']
            ],
            'hide_sidebar_icon' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Hidden Sidebar', 'allianz'),
                'default'       => $args['default'],
                'default_value' => $args['default_value'],
                'required'      => $args['required']
            ]),
            'header_sidenav_layout' => [
                'type'        => Theme_Core_Options::IMAGE_SELECT_FIELD,
                'title'       => esc_html__('Hidden Sidebar Layout', 'allianz'),
                'subtitle'    => esc_html__('Select a layout for upper side nav area.', 'allianz'),
                'description' => sprintf(esc_html__('%sClick Here%s to add your custom side nav layout.','allianz'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=cms-sidenav' ) ) . '" target="_blank">','</a>'),
                'placeholder' => esc_html__('Default','allianz'),
                'options'     => allianz_list_post_thumbnail('cms-sidenav', $args['default']),
                'default'     => $args['default_layout'],
                'required' => [
                    'hide_sidebar_icon', "=", 'on'
                ]
            ]
        ];
    }
}
/**
 * Header TOp Options
**/
if(!function_exists('allianz_header_top_opts')){
    function allianz_header_top_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'        => false,
            'default_value'  => '1',
            'default_on'     => 'off',
            'custom'         => false   
        ]);
        if($args['default']){
            $args['default_value'] = '-1';
        }
        $custom_fields = [];
        if($args['custom']){
            $custom_fields['header_top_custom'] = allianz_theme_on_off_opts([
                'title'         => esc_html__('Custom Header Top','allianz'),
                'default'       => false
            ]);
        }
        $default_fields = [
            'header_top_layout' => array(
                'type'        => Theme_Core_Options::IMAGE_SELECT_FIELD,
                'title'       => esc_html__('Layout', 'allianz'),
                'subtitle'    => esc_html__('Select a layout for upper footer area.', 'allianz'),
                'description' => sprintf(esc_html__('%sClick Here%s to add your custom header top layout.','allianz'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=cms-header-top' ) ) . '" target="_blank">','</a>'),
                'placeholder' => esc_html__('Default','allianz'),
                'options'     => allianz_list_post_thumbnail('cms-header-top', $args['default'], [
                    'none' => get_template_directory_uri() . '/assets/images/default-opt/none.jpg'
                ]),
                'default'     => $args['default_value'],
                'required' => [
                    'header_top_custom', "=", 'on'
                ]
            )
        ];
        // Return
        return [
            'title'      => esc_html__('Header Top', 'allianz'),
            'fields'     => $custom_fields + $default_fields
        ];
    }
}
/**
 * Footer Options
**/
if(!function_exists('allianz_footer_opts')){
    function allianz_footer_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'        => false,
            'default_value'  => '1',
            'default_on'     => 'off',
            'custom'         => false   
        ]);
        if($args['default']){
            $args['default_value'] = '-1';
        }
        $custom_fields = [];
        if($args['custom']){
            $custom_fields['footer_custom'] = allianz_theme_on_off_opts([
                'title'         => esc_html__('Custom Footer','allianz'),
                'default'       => false
            ]);
        }
        $default_fields = [
            'footer_layout' => array(
                'type'        => Theme_Core_Options::IMAGE_SELECT_FIELD,
                'title'       => esc_html__('Layout', 'allianz'),
                'subtitle'    => esc_html__('Select a layout for upper footer area.', 'allianz'),
                'description' => sprintf(esc_html__('%sClick Here%s to add your custom footer layout.','allianz'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=cms-footer' ) ) . '" target="_blank">','</a>'),
                'placeholder' => esc_html__('Default','allianz'),
                'options'     => allianz_list_post_thumbnail('cms-footer', $args['default'], [
                    '1' => get_template_directory_uri() . '/assets/images/footer-layout/default.png'
                ]),
                'default'     => $args['default_value'],
                'required' => [
                    'footer_custom', "=", 'on'
                ]
            ),
            'footer_fixed' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Footer Fixed', 'allianz'),
                'subtitle'      => esc_html__('Make footer fixed at bottom?', 'allianz'),
                'default'       => $args['default'],
                'default_value' => $args['default_on'], 
                'required' => [
                    'footer_custom', "=", 'on'
                ]
            ])
        ];
        // Return
        return [
            'title'      => esc_html__('Footer', 'allianz'),
            'fields'     => $custom_fields + $default_fields
        ];
    }
}
/**
 * WooCommerce Options
 * ====================
 * 
 * */
/**
 * Single Product Options
 * **/
if(!function_exists('allianz_single_product_opts')){
    function allianz_single_product_opts($args = []){
        $args = wp_parse_args($args, [
            'default'      => false
        ]);
        if($args['default']){
            $custom_opts = [
                'product_custom' => allianz_theme_on_off_opts([
                    'title'         => esc_html__('Custom Product','allianz'),
                    'default'       => false,
                    'default_value' => 'off'
                ])
            ];
            $required = [
                'product_custom',
                '=',
                'on'
            ];
            $on_off_default = true;
            $product_single_layout_default = 'df';
            $product_single_gallery_default = 'df';
        } else {
            $custom_opts = [];
            $required = '';
            $on_off_default = false;
            $product_single_layout_default = 'single-product';
            $product_single_gallery_default = 'slider';
        }

        
        return array(
            'title'      => esc_html__('Single Products', 'allianz'),
            'fields'     => array_merge(
                $custom_opts,
                array(
                    'product_layout_and_content' => [
                        'type'     => Theme_Core_Options::HEADING_FIELD,
                        'title'    => esc_html__('Layout & Content', 'allianz'),
                        'required' => $required
                    ],
                    // Page title background
                    'product_page_title_bg' => [
                        'type'     => Theme_Core_Options::BACKGROUND_FIELD,
                        'title'    => esc_html__('Page Title Background', 'allianz'),
                        'subtitle' => esc_html__('Choose Background color and image', 'allianz'),
                        'required' => [
                            'pagetitle',
                            '=',
                            'on'
                        ],
                        'background-repeat'     => false,
                        'background-size'       => false,
                        'background-position'   => false,
                        'background-attachment' => false,
                    ],
                    // Product share
                    'product_share' => allianz_theme_on_off_opts([
                        'title'         => esc_html__('Share', 'allianz'),
                        'default'       => $on_off_default,
                        'default_value' => 'off',
                        'required'      => $required
                    ])
                )
            )
        );
    }
}
/**
 * Pop Ups Options
**/
if(!function_exists('allianz_popup_opts')){
    function allianz_popup_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'        => false,
            'default_value'  => '0',
            'default_on'     => 'off',
            'custom'         => false ,
            'animate_value'  => 'cms-fadeInUp',
            'position_value' => 'align-items-end' 
        ]);
        if($args['default']){
            $args['default_value'] = '-1';
            $args['animate_value'] = $args['position_value'] = '-1';
        }
        $custom_fields = [];
        if($args['custom']){
            $custom_fields['popup_custom'] = allianz_theme_on_off_opts([
                'title'         => esc_html__('Custom Pop Up','allianz'),
                'default'       => false
            ]);
        }
        $default_fields = [
            'popup_layout' => array(
                'type'        => Theme_Core_Options::IMAGE_SELECT_FIELD,
                'title'       => esc_html__('Layout', 'allianz'),
                'subtitle'    => esc_html__('Select a layout for upper Pop-Up area.', 'allianz'),
                'description' => sprintf(esc_html__('%sClick Here%s to add your custom popup layout.','allianz'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=cms-popup' ) ) . '" target="_blank">','</a>'),
                'placeholder' => esc_html__('Default','allianz'),
                'options'     => allianz_list_post_thumbnail('cms-popup', $args['default'], [
                    '0' => get_template_directory_uri() . '/assets/images/default-opt/none.jpg'
                ]),
                'default'     => $args['default_value'],
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ),
            'hide_popup' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Show Hide popup option','allianz'),
                'default'       => false,
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ]),
            'popup_animate'    => allianz_select_opts([
                'title'         => esc_html__('Animation Style', 'allianz'),
                'default'       => $args['default'],
                'default_value' => $args['animate_value'],
                'options'       => [
                    'cms-fadeInUp'    => esc_html__('Fade In Up','allianz'),
                    'cms-fadeInLeft'  => esc_html__('Fade In Left','allianz'), 
                    'cms-fadeInRight' => esc_html__('Fade In Right','allianz')
                ],
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ]),
            'popup_position'   => allianz_select_opts([
                'title'         => esc_html__('Position', 'allianz'),
                'default'       => $args['default'],
                'default_value' => $args['position_value'],
                'options'       => [
                    'align-items-start'                         => esc_html__('Top - Start','allianz'),
                    'align-items-start justify-content-end'     => esc_html__('Top - End','allianz'), 
                    'align-items-center'                        => esc_html__('Center - Start','allianz'),
                    'align-items-center justify-content-center' => esc_html__('Center - Center','allianz'),
                    'align-items-center justify-content-end'    => esc_html__('Center - End','allianz'),
                    'align-items-end'                           => esc_html__('Bottom - Start','allianz'),
                    'align-items-end justify-content-end'       => esc_html__('Bottom - End','allianz'), 
                ],
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ]),
            'popup_max_w' => [
                'type'     => 'dimensions',
                'title'    => esc_html__('Popup Width', 'allianz'),
                'subtitle' => esc_html__('Enter number.', 'allianz'),
                'height'   => false,
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ]
        ];
        // Return
        return [
            'title'      => esc_html__('Pop Up', 'allianz'),
            'fields'     => $custom_fields + $default_fields
        ];
    }
}