<?php
// Silence is golden.
$args = [
    'title'    => esc_html__('Sidebar', 'allianz'),
    'sections' => [
        'general' => [
            'title' => esc_html__('General', 'allianz'),
            'fields' => [
                'sidebar_on' => allianz_theme_show_hide_opts([
                    'title'    => esc_html__('Show Sidebar', 'allianz'),
                    'subtitle' => esc_html__('Show/Hide sidebar on single post & archive page', 'allianz')
                ]),
                'sidebar_pos' => [
                    'type'    => Theme_Core_Options::BUTTON_SET_FIELD,
                    'title'   => esc_html__('Sidebar Position','allianz'),
                    'options' => [
                        'order-first' => esc_html__('Left','allianz'),
                        'order-last'  => esc_html__('Right','allianz')
                    ],
                    'default' => 'order-last',
                    'required' => [
                        'sidebar_on', '=', 'on'
                    ]
                ]
            ]
        ]
    ]
];
return $args;