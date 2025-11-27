<?php
// Silence is golden.
$args = [
    'title'    => esc_html__('Content', 'allianz'),
    'sections' => [
        'general' => [
            'title' => esc_html__('General', 'allianz'),
            'fields' => [
                'content_width' => allianz_theme_content_width_opts(),
                'search_field_placeholder' => [
                    'type'        => Theme_Core_Options::TEXT_FIELD,
                    'title'       => esc_html__('Search Form - Text Placeholder', 'allianz'),
                    'description' => esc_html__('Default: Search Keywords...', 'allianz'),
                ]
            ]
        ],
        'archive' => [
            'title'  => esc_html__('Archive', 'allianz'),
            'fields' => [
                'archive_author_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Author', 'allianz'),
                    'subtitle' => esc_html__('Show author name on each post.', 'allianz'),
                    'default'  => 1,
                ],
                'archive_date_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Date', 'allianz'),
                    'subtitle' => esc_html__('Show date posted on each post.', 'allianz'),
                    'default'  => 1,
                ],
                'archive_categories_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Categories', 'allianz'),
                    'subtitle' => esc_html__('Show category names on each post.', 'allianz'),
                    'default'  => 1,
                ],
                'archive_comments_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Comments', 'allianz'),
                    'subtitle' => esc_html__('Show comments count on each post.', 'allianz'),
                    'default'  => 1,
                ]
            ],
        ],
        'single-post' => [
            'title'  => esc_html__('Single Post', 'allianz'),
            'fields' => [
                'post_author_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Author', 'allianz'),
                    'subtitle' => esc_html__('Show author name on single post.', 'allianz'),
                    'default'  => 1,
                ],
                'post_author_info_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Author Info', 'allianz'),
                    'subtitle' => esc_html__('Show author info on single post.', 'allianz'),
                ],
                'post_date_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Date', 'allianz'),
                    'subtitle' => esc_html__('Show date on single post.', 'allianz'),
                    'default'  => 1,
                ],
                'post_categories_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Categories', 'allianz'),
                    'subtitle' => esc_html__('Show category names on single post.', 'allianz'),
                    'default'  => 1,
                ],
                'post_tags_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Tags', 'allianz'),
                    'subtitle' => esc_html__('Show tag names on single post.', 'allianz'),
                    'default'  => 1,
                ],
                'post_comments_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Comments', 'allianz'),
                    'subtitle' => esc_html__('Show comments count on single post.', 'allianz'),
                    'default'  => 1,
                ],
                'post_social_share_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Social Share', 'allianz'),
                    'subtitle' => esc_html__('Show social share on single post.', 'allianz')
                ],
                'post_navigation_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Navigation', 'allianz'),
                    'subtitle' => esc_html__('Show navigation on single post.', 'allianz'),
                    'default'  => 1,
                ],
                'post_comments_form_on' => [
                    'type'     => Theme_Core_Options::SWITCH_FIELD,
                    'title'    => esc_html__('Comments Form', 'allianz'),
                    'subtitle' => esc_html__('Show comments form on single post.', 'allianz'),
                    'default'  => 1,
                ]
            ]
        ]
    ]
];
return $args;