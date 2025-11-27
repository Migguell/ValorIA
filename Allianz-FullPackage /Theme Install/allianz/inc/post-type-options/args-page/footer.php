<?php
// Silence is golden.
$args = [
    'title' => esc_html__('Footer', 'allianz'),
    'fields' => [
        'custom_footer' => [
            'type' => Theme_Core_Options::SWITCH_FIELD,
            'title' => esc_html__('Custom Layout', 'allianz'),
        ],
        'footer_layout_custom' => [
            'type' => Theme_Core_Options::SELECT_FIELD,
            'title' => esc_html__('Layout', 'allianz'),
            'description' => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.', 'allianz'), '<a href="' . esc_url(admin_url('edit.php?post_type=footer')) . '">', '</a>'),
            'options' => allianz_list_post('footer'),
            'default' => '',
            'required' => [
                'custom_footer',
                '=',
                '1'
            ],
        ],
    ]
];

return $args;