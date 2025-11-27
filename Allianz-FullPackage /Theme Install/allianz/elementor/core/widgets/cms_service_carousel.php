<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if (!function_exists('allianz_widget_cms_service_carousel_register_controls')) {
    add_action('etc_widget_cms_service_carousel_register_controls', 'allianz_widget_cms_service_carousel_register_controls', 10, 1);
    function allianz_widget_cms_service_carousel_register_controls($widget)
    {
        // Layout Settings
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'allianz' ),
                'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
            ]
        );
            $widget->add_control(
                'layout',
                [
                    'label'   => esc_html__('Templates', 'allianz' ),
                    'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                    'default' => '1',
                    'options' => [
                        '1' => [
                            'label' => esc_html__( 'Layout 1', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/layout/3.webp'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/layout/4.webp'
                        ],
                        '5' => [
                            'label' => esc_html__( 'Layout 5', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/layout/5.webp'
                        ],
                        '6' => [
                            'label' => esc_html__( 'Layout 6', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/layout/6.webp'
                        ],
                        '7' => [
                            'label' => esc_html__( 'Layout 7', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/layout/7.webp'
                        ],
                        '8' => [
                            'label' => esc_html__( 'Layout 8', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/layout/8.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Heading Section Start
        $widget->start_controls_section(
            'heading_section',
            [
                'label' => esc_html__('Heading Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true,
                    'separator'   => 'after'
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'smallheading_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-smallheading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'smallheading_text!' => ''
                ]
            ]);
            $widget->add_control(
                'heading_text',
                [
                    'label'       => esc_html__( 'Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'heading_color',
                'label'    => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-heading, {{WRAPPER}} .cms-heading a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Source Section Start
        // Post term options
        $post_term_options = etc_get_grid_term_options('cms-service', ['service-category']);
        $widget->start_controls_section(
            'source_section',
            [
                'label' => esc_html__('Source Settings', 'allianz'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $widget->add_control(
            'source',
            [
                'label' => esc_html__('Select Categories', 'allianz'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $post_term_options,
            ]
        );
        $widget->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'allianz'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'allianz'),
                    'ID' => esc_html__('ID', 'allianz'),
                    'author' => esc_html__('Author', 'allianz'),
                    'title' => esc_html__('Title', 'allianz'),
                    'rand' => esc_html__('Random', 'allianz'),
                ],
            ]
        );
        $widget->add_control(
            'order',
            [
                'label' => esc_html__('Sort Order', 'allianz'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'desc' => esc_html__('Descending', 'allianz'),
                    'asc' => esc_html__('Ascending', 'allianz'),
                ],
            ]
        );
        $widget->add_control(
            'limit',
            [
                'label' => esc_html__('Total items', 'allianz'),
                'type' => Controls_Manager::NUMBER,
                'default' => '6',
            ]
        );
        $widget->end_controls_section();
        // View All Button
        $widget->start_controls_section(
            'view_all_section',
            [
                'label' => esc_html__('View All Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            // Button
            $widget->add_control(
                'btn_text',
                [
                    'label'       => esc_html__( 'View All Button', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'Check All Blog Posts', 'allianz' ),
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'link_type',
                [
                    'label'   => esc_html__('Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'btn_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'page_link',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'btn_text!' => '',
                        'link_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'link',
                [
                    'label'       => esc_html__( 'Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'btn_text!' => '',
                        'link_type' => 'custom'
                    ]
                ]
            );
        $widget->end_controls_section();
        // Display Section Start
        $widget->start_controls_section(
            'display_section',
            [
                'label' => esc_html__('Content Display', 'allianz'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'thumbnail',
                    'default' => 'custom',
                ]
            );
            $widget->add_control(
                'num_words',
                [
                    'label'       => esc_html__('Excerpt Length', 'allianz'),
                    'type'        => Controls_Manager::NUMBER,
                    'default'     => '',
                    'placeholder' => '25',
                    'separator'   => 'after',
                ]
            );

            $widget->add_control(
                'readmore_text',
                [
                    'label'       => esc_html__('Readmore Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Read More','allianz'),
                ]
            );
        $widget->end_controls_section();
        // Carousel Section Start
        allianz_elementor_carousel_settings($widget);
    }
}
