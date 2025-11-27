<?php
// Silence is golden.
$args = [
    'title' => esc_html__('General','allianz'),
    'sections' => [
        'colors' => [
            'title' => esc_html__('Colors', 'allianz'),
            'fields' => [
                'accent_color' => [
                    'type'        => Theme_Core_Options::COLOR_SET_FIELD,
                    'title'       => esc_html__('Accent Color', 'allianz'),
                    'options'     => allianz_color_list_opts('accent_color')
                ],
                'primary_color' => [
                    'type'        => Theme_Core_Options::COLOR_SET_FIELD,
                    'title'       => esc_html__('Primary Color', 'allianz'),
                    'options'     => allianz_color_list_opts('primary_color')
                ],
                'secondary_color' => [
                    'type'        => Theme_Core_Options::COLOR_SET_FIELD,
                    'title'       => esc_html__('Secondary Color', 'allianz'),
                    'options' => allianz_color_list_opts('secondary_color')
                ],
                'heading_color' => array(
                    'type'    => Theme_Core_Options::COLOR_SET_FIELD,
                    'title'   => esc_html__('Heading Color', 'allianz'),
                    'options' => allianz_color_list_opts('heading_color')
                ),
                'body_color' => array(
                    'type'    => Theme_Core_Options::COLOR_SET_FIELD,
                    'title'   => esc_html__('Body Color', 'allianz'),
                    'options' => [
                        'regular' => sprintf('%s (%s)', esc_html__('Default','allianz'), allianz_configs('body')['color'])
                    ]
                ),
                'link_color' => [
                    'type' => Theme_Core_Options::LINK_COLOR_FIELD,
                    'title' => esc_html__('Link Color', 'allianz')
                ]
            ]
        ],
        'typos' => allianz_typography_opts(),
        'tools' => [
            'title'  => esc_html__('Tools', 'allianz'),
            'fields' => [
                'show_page_loading' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Enable Page Loading', 'allianz'),
                    'subtitle' => esc_html__('Enable page loading effect when you load site.', 'allianz'),
                ],
                'back_totop_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Back to Top Button', 'allianz'),
                    'subtitle' => esc_html__('Show back to top button when scrolled down.', 'allianz'),
                    'default'  => 1,
                ],
                'dev_mode' => [
                    'type'        => Theme_Core_Options::SWITCH_FIELD,
                    'title'       => esc_html__('Dev Mode (not recommended)', 'allianz'),
                    'description' => esc_html__('no minimize , generate css over time...', 'allianz'),
                ],
            ],
        ]
    ]
];
return $args;