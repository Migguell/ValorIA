<?php
if(!class_exists('WooCommerce')) return;

add_filter('tco_product_page_options_args', 'allianz_product_options_args');
function allianz_product_options_args(){
    $default       = true;
    $default_value = $default_on = $default_off = $default_width = '-1';
    $custom_opts   = true;
    
    $general = [
        'title' => esc_html__('General','allianz'),
        'sections' => [
            'single' => allianz_single_product_opts([
                'default' => true
            ])
        ]
    ];
    $args = [  
        'general' => $general,
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