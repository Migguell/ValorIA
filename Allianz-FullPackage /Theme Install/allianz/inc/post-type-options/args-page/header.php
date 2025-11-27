<?php
// Silence is golden.
$args = [
    'title' => esc_html__('Header', 'allianz'),
    'fields' => array_merge(
        [
            'header_custom' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Custom Header','allianz'),
                'default'       => false,
                'default_value' => 'off'
            ]),
            'header_layout' => allianz_theme_header_layout_opts([
                'default'       => $default,
                'default_value' => $default_value,
                'required'      => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'dropdown_menu' => allianz_select_opts([
                'title'         => esc_html__('Main Menu','allianz'),
                'options'       => allianz_theme_menu_opts_list(),
                'default'       => $default,
                'default_value' => $default_value,
                'required'      => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'header_height' => [
                'type'     => 'dimensions',
                'title'    => esc_html__('Header Height', 'allianz'),
                'subtitle' => esc_html__('Set height for your Header', 'allianz'),
                'width'    => false,
                'required'      => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'header_width' => allianz_theme_content_width_opts([
                'title'         => esc_html__('Header Width', 'allianz'),
                'default'       => $default,
                'default_value' => $default_width,
                'required'      => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'header_shadow' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Header Shadow', 'allianz'),
                'subtitle'      => esc_html__('Add shadow at bottom of header','allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => ['header_custom','=','on']
            ]),
            'main_menu_color' => [
                'type'     => Theme_Core_Options::LINK_COLOR_FIELD,
                'title'    => esc_html__('Menu Color', 'allianz'),
                'required' => ['header_custom','=','on']
            ],
            'header_sticky' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Header Sticky', 'allianz'),
                'subtitle'      => esc_html__('Header will be sticked when applicable.', 'allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'header_sticky_mode' => allianz_select_opts([
                'title'         => esc_html__('Header Sticky Mode', 'allianz'),
                'subtitle'      => esc_html__('Header will when:', 'allianz'),
                'options'       => [
                    'srollup' => esc_html__('Scroll UP','allianz'),
                    'always'  => esc_html__('Always', 'allianz')  
                ],
                'default'       => true,
                'default_value' => '0',
                'required' => [
                    'header_sticky', '=', 'on'
                ]
            ]),
            'header_transparent' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Header Transparent', 'allianz'),
                'subtitle'      => esc_html__('Header transparent use with background.', 'allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'header_transparent_divider' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Divider', 'allianz'),
                'subtitle'      => esc_html__('Add divider at bottom of header','allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_transparent',
                    '=',
                    'on'
                ]
            ]),
            'transparent_menu_color' => [
                'type'        => Theme_Core_Options::LINK_COLOR_FIELD,
                'title'       => esc_html__('Menu Color', 'allianz'),
                'description' => esc_html__('Header Transparent Menu Color','allianz'),
                'required'    => ['header_transparent', '=', 'on']
            ],
            'custom_logo' => [
                'type'  => Theme_Core_Options::HEADING_FIELD,
                'title' => esc_html__('Logo Settings', 'allianz'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo' => [
                'type'  => Theme_Core_Options::MEDIA_FIELD,
                'title' => esc_html__('Logo', 'allianz'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo_maxh' => [
                'type'     => 'dimensions',
                'title'    => esc_html__('Logo Dimensions', 'allianz'),
                'subtitle' => esc_html__('Enter number.', 'allianz'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo_mobile' => [
                'type'  => Theme_Core_Options::MEDIA_FIELD,
                'title' => esc_html__('Logo Tablet & Mobile', 'allianz'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo_maxh_sm' => [
                'type'     => 'dimensions',
                'title'    => esc_html__('Logo Tablet & Mobile Dimensions', 'allianz'),
                'subtitle' => esc_html__('Enter number.', 'allianz'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],

            'logo_light' => [
                'type' => Theme_Core_Options::MEDIA_FIELD,
                'title' => esc_html__('Logo - Header Transparent', 'allianz'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo_light_mobile' => [
                'type'  => Theme_Core_Options::MEDIA_FIELD,
                'title' => esc_html__('Logo Tablet & Mobile - Header Transparent', 'allianz'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'custom_attribute' => [
                'type'  => Theme_Core_Options::HEADING_FIELD,
                'title' => esc_html__('Attributes Settings', 'allianz'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'search_icon' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Search Icon', 'allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'cart_icon' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Cart Icon', 'allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'h_mail_on' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Show/Hide Email', 'allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'h_phone_on' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Show/Hide Phone', 'allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'h_btn_on' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Show/Hide Button', 'allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'h_btn2_on' => allianz_theme_on_off_opts([
                'title'         => esc_html__('Show/Hide Button #2', 'allianz'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ])
        ],
        allianz_woo_header_woocs_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        allianz_woo_header_wishlist_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        allianz_woo_header_compare_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        allianz_header_login_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        allianz_header_language_switcher_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        allianz_header_side_nav_opts([
            'default'       => true,
            'default_value' => '-1', 
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ])
    )
];
return $args;