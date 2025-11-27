<?php
// Silence is golden.
$args = [
    'title'    => esc_html__('Header', 'allianz'),
    'sections' => [
        'general' => [
            'title' => esc_html__('General', 'allianz'),
            'fields' => [
                'header_layout' => allianz_theme_header_layout_opts([
                    'default'       => $default,
                    'default_value' => $default_value
                ]),
                'dropdown_menu' => allianz_select_opts([
                    'title'         => esc_html__('Main Menu','allianz'),
                    'options'       => allianz_theme_menu_opts_list(),
                    'default_value' => 'primary'
                ]),
                'main_menu_color' => [
                    'type'  => Theme_Core_Options::LINK_COLOR_FIELD,
                    'title' => esc_html__('Menu Color', 'allianz')
                ],
                'header_height' => [
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Header Height', 'allianz'),
                    'subtitle' => esc_html__('Set height for your Header', 'allianz'),
                    'width'    => false
                ],
                'header_shadow' => allianz_theme_on_off_opts([
                    'title'         => esc_html__('Header Shadow', 'allianz'),
                    'subtitle'      => esc_html__('Add shadow at bottom of header','allianz'),
                    'default'       => $default,
                    'default_value' => 'on'
                ]),
                'extra' => [
                    'type'  => Theme_Core_Options::HEADING_FIELD,
                    'title' => esc_html__('Extra Settings', 'allianz')
                ],
                'header_sticky' => allianz_theme_on_off_opts([
                    'title'         => esc_html__('Header Sticky', 'allianz'),
                    'subtitle'      => esc_html__('Header will be sticked when applicable.', 'allianz')
                ]),
                'header_sticky_mode' => allianz_select_opts([
                    'title'         => esc_html__('Header Sticky Mode', 'allianz'),
                    'subtitle'      => esc_html__('Header will when:', 'allianz'),
                    'options'       => [
                        'srollup' => esc_html__('Scroll UP','allianz'),
                        'always'  => esc_html__('Always', 'allianz')  
                    ],
                    'default_value' => 'srollup',
                    'required' => [
                        'header_sticky', '=', 'on'
                    ]
                ]),
                'header_width' => allianz_theme_content_width_opts([
                    'title'         => esc_html__('Header Content Width', 'allianz'),
                    'default'       => $default,
                    'default_value' => $default_width
                ])
            ]
        ],
        'logo' => [
            'title'  => esc_html__('Logo', 'allianz'),
            'fields' => [
                'logo' => [
                    'type'  => Theme_Core_Options::MEDIA_FIELD,
                    'title' => esc_html__('Logo', 'allianz')
                ],
                'logo_maxh' => [
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Dimensions', 'allianz'),
                    'subtitle' => esc_html__('Enter number.', 'allianz')
                ],
                'logo_mobile' => [
                    'type'  => Theme_Core_Options::MEDIA_FIELD,
                    'title' => esc_html__('Logo Tablet & Mobile', 'allianz')
                ],
                'logo_maxh_sm' => [
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Tablet & Mobile Dimensions', 'allianz'),
                    'subtitle' => esc_html__('Enter number.', 'allianz')
                ],
            ],
        ],
        'header_ontop' => [
            'title' => esc_html__('Header Transparent', 'allianz'),
            'fields' => [
                'header_transparent' => allianz_theme_on_off_opts([
                    'title'         => esc_html__('Header Transparent', 'allianz'),
                    'subtitle'      => esc_html__('Header transparent use with background.', 'allianz'),
                    'default_value' => $default_off
                ]),
                'logo_light' => [
                    'type' => Theme_Core_Options::MEDIA_FIELD,
                    'title' => esc_html__('Logo', 'allianz')
                ],
                'logo_light_mobile' => [
                    'type'  => Theme_Core_Options::MEDIA_FIELD,
                    'title' => esc_html__('Logo Tablet & Mobile', 'allianz')
                ],
                'transparent_menu_color' => [
                    'type' => Theme_Core_Options::LINK_COLOR_FIELD,
                    'title' => esc_html__('Menu Color', 'allianz')
                ],
                'header_transparent_divider' => allianz_theme_on_off_opts([
                    'title'         => esc_html__('Divider', 'allianz'),
                    'subtitle'      => esc_html__('Add divider at bottom of header','allianz'),
                    'default'       => $default,
                    'default_value' => 'on'
                ])
            ]
        ],
        'attributes' => [
            'title' => esc_html__('Attributes','allianz'),
            'fields' => array_merge(
                [
                    'search_icon' => allianz_theme_on_off_opts([
                        'title'         => esc_html__('Search Icon', 'allianz'),
                        'default'       => $default,
                        'default_value' => $default_off
                    ]),
                    'cart_icon' => allianz_theme_on_off_opts([
                        'title'         => esc_html__('Cart Icon', 'allianz'),
                        'default'       => $default,
                        'default_value' => $default_off
                    ])
                ],
                allianz_woo_header_woocs_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                allianz_woo_header_wishlist_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                allianz_woo_header_compare_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                allianz_header_login_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                allianz_header_language_switcher_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                allianz_theme_phone_settings([
                    'default'       => $default,
                    'default_value' => $default_off 
                ]),
                allianz_theme_mail_settings([
                    'default'       => $default,
                    'default_value' => $default_off 
                ]),
                allianz_theme_button_settings([
                    'default'       => $default,
                    'default_value' => $default_off 
                ]),
                allianz_theme_button_settings([
                    'heading'       => esc_html__('Button Settings #2', 'allianz'),
                    'name'          => 'h_btn2',
                    'default'       => $default,
                    'default_value' => $default_off 
                ]),
                allianz_header_side_nav_opts([
                    'default'       => $default,
                    'default_value' => $default_off 
                ])
            )
        ]
    ]
];
return $args;