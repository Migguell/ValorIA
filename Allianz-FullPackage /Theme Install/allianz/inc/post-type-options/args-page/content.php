<?php
// Silence is golden.
$args = [
    'title'  => esc_html__('Content', 'allianz'),
    'fields' => [
        'general' => [
            'title'  => esc_html__('General', 'allianz'),
            'fields' => [
                'content_width' => allianz_theme_content_width_opts([
                    'default'       => $default,
                    'default_value' => $default_value
                ])
            ]
        ]
    ]
];
return $args;