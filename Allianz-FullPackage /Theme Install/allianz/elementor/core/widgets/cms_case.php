<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
if (!function_exists('allianz_widget_cms_case_register_controls')) {
    add_action('etc_widget_cms_case_register_controls', 'allianz_widget_cms_case_register_controls', 10, 1);
    function allianz_widget_cms_case_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_blog/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_blog/layout/2.webp'
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
            // Heading
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
        $widget->end_controls_section();
        // Heading Section Start
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
                    'default'     => '',
                    'placeholder' => esc_html__( 'Check All Blog Posts', 'allianz' ),
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
        // Source Section Start
        $post_term_options = etc_get_grid_term_options('cms-case', ['case-category']);
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
                'type'    => Controls_Manager::NUMBER
            ]
        );
        $widget->end_controls_section();
    }
}
