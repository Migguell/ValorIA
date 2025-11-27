<?php
// Silence is golden.
$args = [
    'title' => esc_html__('404 Page', 'allianz'),
    'fields' => [
        'title_404_page' => [
            'type' => Theme_Core_Options::TEXTAREA_FIELD,
            'title' => esc_html__('Title', 'allianz'),
        ],
        'content_404_page' => [
            'type' => Theme_Core_Options::TEXTAREA_FIELD,
            'title' => esc_html__('Content', 'allianz'),
        ],
        'btn_text_404_page' => [
            'type' => Theme_Core_Options::TEXT_FIELD,
            'title' => esc_html__('Button Text', 'allianz'),
            'description' => esc_html__('Default: Take me go back home', 'allianz'),
        ],
    ],
];
return $args;