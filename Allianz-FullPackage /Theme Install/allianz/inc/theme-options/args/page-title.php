<?php
// Silence is golden.
$fields_default = [
    'pagetitle' => allianz_theme_show_hide_opts([
        'title'         => esc_html__('Page Title', 'allianz'),
        'default'       => $default,
        'default_value' => $default_on,
        'required' => [
            'custom_ptitle',
            '=',
            'on'
        ]
    ]),
    'show_title' => allianz_theme_show_hide_opts([
        'title'         => esc_html__('Title', 'allianz'),
        'default'       => $default,
        'default_value' => $default_on,
        'required'      => [
            'pagetitle',
            '=',
            'on'
        ]
    ]),
    'show_breadcrumb' => allianz_theme_show_hide_opts([
        'title'         => esc_html__('Breadcrumbs', 'allianz'),
        'default'       => $default,
        'default_value' => $default_on,
        'required'      => [
            'pagetitle',
            '=',
            'on'
        ]
    ]),
    'ptitle_align'  => allianz_them_content_align_opts([
        'required'      => [
            'pagetitle',
            '=',
            'on'
        ]
    ]),
    'ptitle_heading' => [
        'type'     => Theme_Core_Options::HEADING_FIELD,
        'title'    => esc_html__('Background Settings', 'allianz'),
        'required' => [
            'pagetitle',
            '=',
            'on'
        ]
    ],
    'page_title_bg' => [
        'type'     => Theme_Core_Options::BACKGROUND_FIELD,
        'title'    => esc_html__('Background', 'allianz'),
        'subtitle' => esc_html__('Choose Background color and image', 'allianz'),
        'required' => [
            'pagetitle',
            '=',
            'on'
        ],
        'background-repeat'     => false,
        'background-size'       => false,
        'background-position'   => false,
        'background-attachment' => false
    ],
    'page_title_overlay' => [
        'type'     => Theme_Core_Options::RGBA_COLOR_FIELD,
        'title'    => esc_html__('Overlay Background Color', 'allianz'),
        'required' => [
            'pagetitle',
            '=',
            'on'
        ]
    ]
];
$fields = [];
if($custom_opts){
    $fields = [
        'custom_ptitle' => allianz_theme_on_off_opts([
            'title'         => esc_html__('Custom Page Title','allianz'),
            'default'       => false,
            'default_value' => 'off'
        ])
    ];
}
$args = [
    'title'  => esc_html__('Page Tile', 'allianz'),
    'fields' => $fields + $fields_default
];
return $args;