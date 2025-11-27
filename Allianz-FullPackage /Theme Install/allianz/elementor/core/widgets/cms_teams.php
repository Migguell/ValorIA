<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

if (!function_exists('allianz_widget_cms_teams_register_controls')) {
    add_action('etc_widget_cms_teams_register_controls', 'allianz_widget_cms_teams_register_controls', 10, 1);
    function allianz_widget_cms_teams_register_controls($widget)
    {
        // Layout Tab Start
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'allianz'),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $widget->add_control(
            'layout_mode',
            [
                'label' => esc_html__( 'Layout Mode', 'allianz' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'carousel' => esc_html__( 'Carousel', 'allianz' ),
                    'grid'     => esc_html__( 'Grid', 'allianz' ),
                ],
                'default' => 'carousel',
            ]
        );
        $widget->add_control(
            'layout',
            [
                'label'   => esc_html__( 'Templates', 'allianz' ),
                'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                'options' => [
                    '1' => [
                        'label' => esc_html__( 'Layout 1', 'allianz' ),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_teams/layout/1.webp'
                    ],
                    '2' => [
                        'label' => esc_html__( 'Layout 2', 'allianz' ),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_teams/layout/2.webp'
                    ],
                    '3' => [
                        'label' => esc_html__( 'Layout 3', 'allianz' ),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_teams/layout/3.webp'
                    ]
                ],
                'default'   => '1'
            ]
        );

        $widget->end_controls_section();
        // List Section Start
        $widget->start_controls_section(
            'list_section',
            [
                'label' => esc_html__('Teams Settings', 'allianz'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $repeater = new Repeater();
            $repeater->add_control(
                'image',
                [
                    'label'   => esc_html__('Image', 'allianz'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $repeater->add_control(
                'name',
                [
                    'label'   => esc_html__('Name', 'allianz'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_html__('Name', 'allianz'),
                ]
            );
            $repeater->add_control(
                'position',
                [
                    'label'   => esc_html__('Position', 'allianz'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_html__('Position', 'allianz'),
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label'       => esc_html__('Description', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'label_block' => true,
                    'class'       => 'fuckc cccc',  
                    'label_class'       => 'fuckc cccc'  
                ]
            );
            $repeater->add_control(
                'link',
                [
                    'label'       => esc_html__( 'Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                    'separator' => 'after',
                ]
            );
            for ($i = 1; $i <= 4; $i++) {
                $args = [
                    'label'       => esc_html__( "Social Icon", 'allianz' ), //{$i}
                    'type'        => Controls_Manager::ICONS,
                    'skin'        => 'inline',
                    'label_block' => false,
                ];
                $args_link = [
                    'label'       => esc_html__( "Social Link", 'allianz' ), //{$i}
                    'type'        => \Elementor\Controls_Manager::URL,
                    'placeholder' => 'https://your-link.com',
                    'options'     => [ 'url', 'is_external', 'nofollow' ],
                    'separator' => 'after',
                ];
                if($i == 1){
                    $args['default'] = [
                        'value'   => 'cmsi-facebook',
                        'library' => 'cmsi',
                    ];
                    $args_link['default'] = [
                        'url'         => 'https://www.facebook.com/cmssuperheroes',
                        'is_external' => true,
                        'nofollow'    => true,
                    ];
                }
                elseif($i == 2){
                    $args['default'] = [
                        'value'   => 'cmsi-twitter-circle',
                        'library' => 'cmsi',
                    ];
                    $args_link['default'] = [
                        'url'         => 'https://www.facebook.com/cmssuperheroes',
                        'is_external' => true,
                        'nofollow'    => true,
                    ];
                }
                elseif($i == 3){
                    $args['default'] = [
                        'value'   => 'cmsi-instagram',
                        'library' => 'cmsi',
                    ];
                    $args_link['default'] = [
                        'url'         => 'https://www.facebook.com/cmssuperheroes',
                        'is_external' => true,
                        'nofollow'    => true,
                    ];
                }
                elseif($i == 4){
                    $args['default'] = [
                        'value'   => 'cmsi-linkedin-circle',
                        'library' => 'cmsi',
                    ];
                    $args_link['default'] = [
                        'url'         => 'https://www.facebook.com/cmssuperheroes',
                        'is_external' => true,
                        'nofollow'    => true,
                    ];
                }
                $repeater->add_control(
                    "social_icon_{$i}",
                    $args
                );
                $repeater->add_control(
                    "social_link_{$i}",
                    $args_link
                );
            }
            $widget->add_control(
                'teams',
                [
                    'label' => esc_html__('Add member', 'allianz'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Name', 'allianz'),
                            'position' => esc_html__('Position', 'allianz'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Name', 'allianz'),
                            'position' => esc_html__('Position', 'allianz'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Name', 'allianz'),
                            'position' => esc_html__('Position', 'allianz'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                    ],
                    'title_field' => '{{{ name }}}',
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'image',
                    'label'   => esc_html__('Avatar Size','allianz'),
                    'default' => 'custom'
                ]
            );
        $widget->end_controls_section();
        // Headings
        $widget->start_controls_section(
            'heading_section',
            [
                'label' => esc_html__('Heading Settings', 'allianz'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout'      => ['1']
                ]
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
                    'label_block' => true,
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
            // Description
            $widget->add_control(
                'description_text',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour', 
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'rows'        => 10,
                    'show_label'  => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'description_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'description_text!' => ''
                ]
            ]);
            // Link 1
            $widget->add_control(
                'link1_text',
                [
                    'label'       => esc_html__( 'Link Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '',
                    'placeholder' => esc_html__( 'Click Here', 'allianz' ),
                    'separator'   => 'before'
                ]
            );
            $widget->add_control(
                'link1_type',
                [
                    'label'   => esc_html__('Link #1 Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'link1_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'link1_page',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'link1_text!' => '',
                        'link1_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'link1_custom',
                [
                    'label'       => esc_html__( 'Link Custom', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'link1_text!' => '',
                        'link1_type' => 'custom'
                    ]
                ]
            );
            // Link #1
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_color',
                'label'     => esc_html__( 'Link Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_bg_color',
                'label'     => esc_html__( 'Link Background Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'   => 'link1_color_hover',
                'label'  => esc_html__( 'Link Color Hover', 'allianz' ),
                'custom' => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_bg_hover_color',
                'label'     => esc_html__( 'Link Background Hover Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Quick Contact
        $widget->start_controls_section(
            'quickcontact_section',
            [
                'label' => esc_html__('Quick Contact Settings', 'allianz'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout'      => ['3']
                ]
            ]
        );
            // Heading
            $widget->add_control(
                'qc_heading_text',
                [
                    'label'       => esc_html__( 'Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true,
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'qc_heading_color',
                'label'    => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-heading, {{WRAPPER}} .cms-heading a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);
            // Description
            $widget->add_control(
                'qc_description_text',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour', 
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'rows'        => 10,
                    'show_label'  => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'qc_description_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'qc_description_text!' => ''
                ]
            ]);
            // Link 1
            $widget->add_control(
                'qc_link1_text',
                [
                    'label'       => esc_html__( 'Link Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '',
                    'placeholder' => esc_html__( 'Click Here', 'allianz' ),
                    'separator'   => 'before',
                    'label'       => true  
                ]
            );
            $widget->add_control(
                'qc_link1_type',
                [
                    'label'   => esc_html__('Link #1 Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'qc_link1_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'qc_link1_page',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'qc_link1_text!' => '',
                        'qc_link1_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'qc_link1_custom',
                [
                    'label'       => esc_html__( 'Link Custom', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'qc_link1_text!' => '',
                        'qc_link1_type' => 'custom'
                    ]
                ]
            );
            $widget->add_control(
                'qc_email',
                [
                    'label'       => esc_html__( 'Email', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Allianz@7oroof.com',
                    'label_block' => true
                ]
            );
            // Banner
            $widget->add_control(
                'banner',
                [
                    'label'   => esc_html__( 'Banner', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
        $widget->end_controls_section();
        // Carousel Settings
        allianz_elementor_carousel_settings($widget,[
            'condition' => [
                'layout_mode' => ['carousel']
            ]
        ]);
        // Grid Settings
        $widget->start_controls_section(
            'grid_section',
            [
                'label'     => esc_html__('Grid Settings', 'allianz'),
                'tab'       => Controls_Manager::TAB_SETTINGS,
                'condition' => [
                    'layout_mode' => 'grid'
                ]
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