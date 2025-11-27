<?php
// Silence is Golden
add_filter('tco_page_page_options_args', 'allianz_page_options_args');
function allianz_page_options_args(){
    $default       = true;
    $default_value = $default_on = $default_off = $default_width = '-1';
    $custom_opts   = true;

    $header_top = include get_template_directory() . '/inc/theme-options/args/header-top.php';
    $header     = include get_template_directory() . '/inc/post-type-options/args-page/header.php';
    $page_title = include get_template_directory() . '/inc/theme-options/args/page-title.php';
    $footer     = include get_template_directory() . '/inc/theme-options/args/footer.php';
    $popup      = include get_template_directory() . '/inc/theme-options/args/popup.php';

    $general = [
        'title' => esc_html__('General','allianz'),
        'sections' => [
            'colors' => [
                'title' => esc_html__('Colors', 'allianz'),
                'fields' => [
                    'color_custom' => allianz_theme_on_off_opts([
                        'title'         => esc_html__('Custom Color','allianz'),
                        'default'       => false,
                        'default_value' => 'off'
                    ]),
                    'accent_color' => [
                        'type'        => Theme_Core_Options::COLOR_SET_FIELD,
                        'title'       => esc_html__('Accent Color', 'allianz'),
                        'options'     => allianz_color_list_opts('accent_color'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ],
                    'primary_color' => [
                        'type'        => Theme_Core_Options::COLOR_SET_FIELD,
                        'title'       => esc_html__('Primary Color', 'allianz'),
                        'options'     => allianz_color_list_opts('primary_color'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ],
                    'secondary_color' => [
                        'type'        => Theme_Core_Options::COLOR_SET_FIELD,
                        'title'       => esc_html__('Secondary Color', 'allianz'),
                        'options' => allianz_color_list_opts('secondary_color'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ],
                    'heading_color' => array(
                        'type'    => Theme_Core_Options::COLOR_SET_FIELD,
                        'title'   => esc_html__('Heading Color', 'allianz'),
                        'options' => allianz_color_list_opts('heading_color'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ),
                    'body_color' => array(
                        'type'    => Theme_Core_Options::COLOR_SET_FIELD,
                        'title'   => esc_html__('Body Color', 'allianz'),
                        'options' => [
                            'regular' => sprintf('%s (%s)', esc_html__('Default','allianz'), allianz_configs('body')['color'])
                        ],
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ),
                    'link_color' => [
                        'type' => Theme_Core_Options::LINK_COLOR_FIELD,
                        'title' => esc_html__('Link Color', 'allianz'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ]
                ]
            ],
            'typos'    => allianz_typography_opts(),
            'advanced' => allianz_general_advanced_opts()
        ]
    ];

    $content = [
        'title'  => esc_html__('Content', 'allianz'),
        'fields' => [
            'content_width' => allianz_theme_content_width_opts([
                'default'       => $default,
                'default_value' => $default_value
            ])
        ]
    ];

    $args = [  
        'general'    => $general,
        'header-top' => $header_top,
        'header'     => $header,
        'page-title' => $page_title,
        'content'    => $content,
        'footer'     => $footer,
        'popup'     => $popup,
    ];

    return $args;
}