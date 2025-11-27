<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_social_icons_register_controls')) {
    add_action('etc_widget_cms_social_icons_register_controls', 'allianz_widget_cms_social_icons_register_controls', 10, 1);
    function allianz_widget_cms_social_icons_register_controls($widget)
    {
        // Layout
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'allianz'),
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_social_icons/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_social_icons/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_social_icons/layout/3.webp'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_social_icons/layout/4.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Heading Section Start
        $widget->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'   => [
                    'layout'  => ['2','3']  
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
                'name'     => 'heading_text_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-heading' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]);
        $widget->end_controls_section();
        // icon Section Start
        $widget->start_controls_section(
            'section_icon',
            [
                'label' => esc_html__('Icons', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

            $repeater = new Repeater();

            $repeater->add_control(
                'social_icon',
                [
                    'label'   => esc_html__( 'Icon', 'allianz' ),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'cmsi-star',
                        'library' => 'cmsi',
                    ]
                ]
            );

            $repeater->add_control(
                'title',
                [
                    'label'   => esc_html__( 'Title', 'allianz' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Social Title',
                ]
            );

            $repeater->add_control(
                'link',
                [
                    'label'   => esc_html__( 'Link', 'allianz' ),
                    'type'    => Controls_Manager::URL,
                    'default' => [
                        'is_external' => 'true'
                    ],
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                ]
            );

            $repeater->add_control(
                'item_icon_color',
                [
                    'label'   => esc_html__( 'Color', 'allianz' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'default' => esc_html__( 'Official Color', 'allianz' ),
                        'custom'  => esc_html__( 'Custom', 'allianz' ),
                    ],
                ]
            );

            $repeater->add_control(
                'item_icon_primary_color',
                [
                    'label' => esc_html__( 'Background Color', 'allianz' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' => [
                        'item_icon_color' => 'custom',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $repeater->add_control(
                'item_icon_secondary_color',
                [
                    'label' => esc_html__( 'Icon Color', 'allianz' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' => [
                        'item_icon_color' => 'custom',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .cms-icon' => 'color: {{VALUE}};',
                        '{{WRAPPER}} {{CURRENT_ITEM}} .cms-icon svg' => 'fill: {{VALUE}};',
                    ],
                ]
            );

            $widget->add_control(
                'icons',
                [
                    'label' => esc_html__('Icons', 'allianz'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'social_icon' => [
                                'value'   => 'cmsi-facebook',
                                'library' => 'cmsi',
                            ],
                            'title' => 'Facebook',
                            'link' => [
                                'is_external' => true,
                                'url' => 'https://facebook.com'
                            ]
                        ],
                        [
                            'social_icon' => [
                                'value'   => 'cmsi-twitter-circle',
                                'library' => 'cmsi',
                            ],
                            'title' => 'Twitter',
                            'link' => [
                                'is_external' => true,
                                'url' => 'https://twitter.com'
                            ]
                        ],
                        [
                            'social_icon' => [
                                'value'   => 'cmsi-linkedin-circle',
                                'library' => 'cmsi',
                            ],
                            'title' => 'LinkedIn',
                                'link' => [
                                    'is_external' => true,
                                    'url' => 'https://linkedin.com'
                                ]
                        ],
                    ],
                    'title_field' => '{{{ "<i class=\"" + social_icon.value + "\"></i>" + " " + title }}}',
                ]
            );
        $widget->end_controls_section();

        // Style Tab Start
        $widget->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_responsive_control(
                'align',
                [
                    'label'        => esc_html__( 'Alignment', 'allianz' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'responsive'   => true,
                    'options'      => [
                        'start'    => [
                            'title' => esc_html__( 'Left', 'allianz' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'  => [
                            'title' => esc_html__( 'Center', 'allianz' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'end'   => [
                            'title' => esc_html__( 'Right', 'allianz' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__( 'Justified', 'allianz' ),
                            'icon' => 'eicon-text-align-justify',
                        ]
                    ]
                ]
            );
            $widget->add_control(
                'gap',
                [
                    'label'        => esc_html__( 'Gap', 'allianz' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => [
                        ''     => esc_html__('Default','allianz'), 
                        'none' => 0, 
                        10     => 10, 
                        15     => 15,
                        20     => 20,
                        30     => 30,
                        40     => 40
                    ],
                    'default'      => '' 
                ]
            );
        $widget->end_controls_section();
        // Icons Style Section Start
        $widget->start_controls_section(
            'icons_style_section',
            [
                'label' => esc_html__('Icons', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-social-item .cms-icon' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Icons Style Section End

        // Icons Hover Style Section Start
        $widget->start_controls_section(
            'icons_hover_style_section',
            [
                'label' => esc_html__('Icons Hover', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_hover_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-social-item:hover .cms-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cms-social-item:hover svg' => 'fill: {{VALUE}};',
                ]
            ]);
            $widget->add_control(
                'hover_animation',
                [
                    'label' => esc_html__( 'Hover Animation', 'allianz' ),
                    'type' => Controls_Manager::HOVER_ANIMATION,
                ]
            );
        $widget->end_controls_section();
        // Icons Hover Style Section End

        // Icons Hover Style Section Start
        $widget->start_controls_section(
            'title_section',
            [
                'label' => esc_html__('Title', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
    			'show_title',
    			[
                    'label'        => esc_html__( 'Show Title', 'allianz' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     => esc_html__( 'Show', 'allianz' ),
                    'label_off'    => esc_html__( 'Hide', 'allianz' ),
                    'return_value' => 'yes',
                    'default'      => 'no',
    			]
    		);
            allianz_add_hidden_device_controls($widget, [
                'prefix'    => 'title_',
                'condition' => [
                    'show_title' => 'yes',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-social-item .cms-title' => 'color: {{VALUE}};'
                ],
                'separator' => 'before',
                'condition' => [
                    'show_title' => 'yes',
                ]
            ]);
        $widget->end_controls_section();
        // Icons Hover Style Section End
        // Style Tab End

    }
}