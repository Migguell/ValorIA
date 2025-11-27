<?php
// Silence is golden.
$args = [
    'title' => esc_html__('Api', 'allianz'),
    'fields' => [
        'gm_api_key' => [
            'type'        => Theme_Core_Options::TEXT_FIELD,
            'title'       => esc_html__('Google Maps API Key', 'allianz'),
            'subtitle'    => esc_html__('Register a Google Maps Api key then put it in here.', 'allianz'),
            'description' => 'AIzaSyC08_qdlXXCWiFNVj02d-L2BDK5qr6ZnfM',
            'default'     => '',
        ]
    ]
];
return $args;