<?php
use Elementor\Controls_Manager;

if (!function_exists('allianz_widget_cms_navigation_menu_register_controls')) {
    add_action('etc_widget_cms_navigation_menu_register_controls', 'allianz_widget_cms_navigation_menu_register_controls', 10, 1);
    function allianz_widget_cms_navigation_menu_register_controls($widget)
    {
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            foreach ( $menus as $single_menu ) {
                if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
                    $custom_menus[ $single_menu->slug ] = $single_menu->name;
                }
            }
        } else {
            $custom_menus = '';
        }
        // Layout Settings
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__( 'Layout', 'allianz' ),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );
            $widget->add_control(
                'layout',
                [
                    'label'   => esc_html__( 'Templates', 'allianz' ),
                    'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                    'default' => '1',
                    'options' => [
                        '1' => [
                            'label' => esc_html__( 'Layout 1', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/2.jpg'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/3.jpg'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/4.jpg'
                        ],
                        '5' => [
                            'label' => esc_html__( 'Layout 5', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/5.jpg'
                        ],
                        '6' => [
                            'label' => esc_html__( 'Mega Menu', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/6.jpg'
                        ],
                        '7' => [
                            'label' => esc_html__( 'Side Nav', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/7.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();

        // Menu Section Start
        $widget->start_controls_section(
            'navigation_menu_section',
            [
                'label' => esc_html__('Navigation Menu', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $widget->add_control(
            'menu',
            [
                'label'   => esc_html__( 'Select Menu', 'allianz' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $custom_menus,
            ]
        );
        $widget->add_control(
            'title',
            [
                'label'       => esc_html__('Title', 'allianz'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your title', 'allianz'),
                'label_block' => true,
                'condition'   => [
                    'menu!'  => '',
                    'layout' => ['1','5','6']
                ]
            ]
        );
            $widget->add_control(
                'link_type',
                [
                    'label'   => esc_html__('Title Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'page',
                    'condition' => [
                        'menu!'  => '',
                        'layout' => ['6'],
                        'title!' => ''
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
                        'menu!'  => '',
                        'layout' => ['6'],
                        'title!' => '',
                        'link_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'custom_link',
                [
                    'label'       => esc_html__( 'Custom Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'menu!'  => '',
                        'layout' => ['6'],
                        'title!' => '',
                        'link_type' => 'custom'
                    ]
                ]
            );
            allianz_elementor_responsive_flex_alignment($widget, [
                'condition' => [
                    'menu!' => '',
                ]
            ]);
        $widget->end_controls_section();

        $widget->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu!'  => '',
                    'layout' => ['1','5','6']
                ]
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section(); // Style Sub Heading Style End
        // Link
        $widget->start_controls_section(
            'section_style_link',
            [
                'label' => esc_html__('Link', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu!'  => '',
                    'layout!' => ['5','6']
                ]
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'link_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-menu a:not(:hover)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cms-menu-horz li:after' => 'background-color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'link_color_hover',
                'label'     => esc_html__( 'Color on Hover & Active', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-menu a:hover, {{WRAPPER}} .cms-menu li.current-menu-item > a' => 'color: {{VALUE}};'
                ]
            ]);
        $widget->end_controls_section(); // Style Sub Heading Style End
    }
}
