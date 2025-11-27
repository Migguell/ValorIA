<?php
// Silence is Golden
add_filter('tco_cms-service_page_options_args', 'allianz_cms_service_options_args');
function allianz_cms_service_options_args(){
    $default       = true;
    $default_value = $default_on = $default_off = $default_width = '-1';
    $custom_opts   = true;

    $header     = include get_template_directory() . '/inc/post-type-options/args-page/header.php';
    $general = [
        'title' => esc_html__('General','allianz'),
        'sections' => [
            'icons'    => allianz_post_icon_opts(),
            'features' => allianz_post_feature_opts(),
        ]
    ];
    
    $args = [  
        'general'    => $general,
        'header'     => [
            'title' => esc_html__('Header', 'allianz'),
            'fields' => array_merge(
                [
                    'header_custom' => allianz_theme_on_off_opts([
                        'title'         => esc_html__('Custom Header','allianz'),
                        'default'       => false,
                        'default_value' => 'off'
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
                    ])
                ]
            )
        ]
    ];

    return $args;
}