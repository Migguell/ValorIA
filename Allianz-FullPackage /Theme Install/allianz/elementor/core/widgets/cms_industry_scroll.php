<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (!function_exists('allianz_widget_cms_industry_scroll_register_controls')) {
    add_action('etc_widget_cms_industry_scroll_register_controls', 'allianz_widget_cms_industry_scroll_register_controls', 10, 1);
    function allianz_widget_cms_industry_scroll_register_controls($widget)
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
        // Heading Section Start
        $widget->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'banner',
                [
                    'label'   => esc_html__( 'Banner', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );

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
                    '{{WRAPPER}} .cms-heading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'heading_text!' => '' 
                ]
            ]);
        $widget->end_controls_section();
        // Source Section Start
        $post_term_options = etc_get_grid_term_options('cms-industry', ['industry-category']);
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
                'label'   => esc_html__('Order By', 'allianz'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'   => esc_html__('Date', 'allianz'),
                    'ID'     => esc_html__('ID', 'allianz'),
                    'author' => esc_html__('Author', 'allianz'),
                    'title'  => esc_html__('Title', 'allianz'),
                    'rand'   => esc_html__('Random', 'allianz'),
                ],
            ]
        );
        $widget->add_control(
            'order',
            [
                'label'   => esc_html__('Sort Order', 'allianz'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'desc' => esc_html__('Descending', 'allianz'),
                    'asc'  => esc_html__('Ascending', 'allianz'),
                ],
            ]
        );
        $widget->add_control(
            'limit',
            [
                'label'   => esc_html__('Total items', 'allianz'),
                'type'    => Controls_Manager::NUMBER,
                'default' => '6',
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
                    'separator'   => 'after',
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
        // Grid Section Start
        $widget->start_controls_section(
            'grid_section',
            [
                'label' => esc_html__('Grid Settings', 'allianz'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

            $widget->add_responsive_control(
                'col',
                [
                    'label'        => esc_html__('Columns', 'allianz'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => '',
                    'default_args' => [
                        'tablet' => '',
                        'mobile' => ''
                    ],
                    'options' => [
                        '' => esc_html__('Default', 'allianz'),
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '6' => '6',
                    ],
                    'separator' => 'after'
                ]
            );
        $widget->end_controls_section();
    }
}
