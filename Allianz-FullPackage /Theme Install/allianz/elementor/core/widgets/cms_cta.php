<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_cta_register_controls')) {
    add_action('etc_widget_cms_cta_register_controls', 'allianz_widget_cms_cta_register_controls', 10, 1);
    function allianz_widget_cms_cta_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/3.webp'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/4.webp'
                        ],
                        '5' => [
                            'label' => esc_html__( 'Layout 5', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/5.webp'
                        ],
                        '6' => [
                            'label' => esc_html__( 'Layout 6', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/6.webp'
                        ],
                        '7' => [
                            'label' => esc_html__( 'Layout 7', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/7.webp'
                        ],
                        '8' => [
                            'label' => esc_html__( 'Layout 8', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/8.webp'
                        ],
                        '9' => [
                            'label' => esc_html__( 'Layout 9', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/9.webp'
                        ],
                        '10' => [
                            'label' => esc_html__( 'Layout 10', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/10.webp'
                        ],
                        '11' => [
                            'label' => esc_html__( 'Layout 11', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/11.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Content Section Start
        $widget->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout!' => ['9','10']
                ]
            ]
        );  
            $widget->add_control(
                'banner',
                [
                    'label'   => esc_html__( 'Banner', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'condition' => [
                        'layout' => ['11']
                    ],
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'     => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'title!' => ''
                ]
            ]);  
            // Text  
            $widget->add_control(
                'text',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Get free advice by speaking to one of our financial advisers over the phone or just submit your details and we’ll be in touch shortly!',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'text_color',
                'label'     => esc_html__( 'Text Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ],
                'separator' => 'after',
                'condition'   => [
                    'text!' => ''
                ]
            ]);
            // Text Bold
            $widget->add_control(
                'text_bold',
                [
                    'label'       => esc_html__( 'Description Bold', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Take control of your financial future and grow your wealth now!',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['2']
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'text_bold_color',
                'label'     => esc_html__( 'Text Bold Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc-bold' => 'color: {{VALUE}};',
                ],
                'separator' => 'after',
                'condition'   => [
                    'layout' => ['2'],
                    'text_bold!' => ''
                ]
            ]);
            $widget->add_control(
                'link_text',
                [
                    'label'       => esc_html__( 'Link Settings', 'allianz' ),
                    'description' => esc_html__('Link Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'Click here', 'allianz' ),
                    'placeholder' => esc_html__( 'Click here', 'allianz' ),
                    'label_block' => true,
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
                        'link_text!' => ''
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
                        'link_text!' => '',
                        'link_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'custom_link',
                [
                    'label'       => esc_html__( 'Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'link_text!' => '',
                        'link_type' => 'custom'
                    ]
                ]
            );
            // Button
            $widget->add_control(
                'btn_text',
                [
                    'label'       => esc_html__( 'Button Settings', 'allianz' ),
                    'description' => esc_html__('Button Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'Click here', 'allianz' ),
                    'placeholder' => esc_html__( 'Click here', 'allianz' ),
                    'label_block' => true,
                    'condition'   => [
                        'layout'  => ['3','5','11']
                    ]
                ]
            );
            $widget->add_control(
                'btn_type',
                [
                    'label'   => esc_html__('Button Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'layout'     => ['3','5','11'],
                        'btn_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'btn_link',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'layout'     => ['3','5','11'],
                        'btn_text!' => '',
                        'btn_type'  => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'btn_custom_link',
                [
                    'label'       => esc_html__( 'Custom Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'layout'     => ['3','5','11'],
                        'btn_text!' => '',
                        'btn_type'  => 'custom'
                    ]
                ]
            );
        $widget->end_controls_section();
        // Call to Action #9
        $widget->start_controls_section(
            'cta_section_9',
            [
                'label'     => esc_html__('Call to Action Settings','allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['9','10']
                ]
            ]
        );
            $widget->add_control(
                'cta_title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'cta_title_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'after',
                'condition' => [
                    'cta_title!' => ''
                ]
            ]);
            $widget->add_control(
                'cta_text',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'We’re here to help with any questions you have on your path to find financial security and our core beliefs central to investing success.',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'cta_text_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'cta_text!' => ''
                ]
            ]);
            // Button
            $cta3 = new Repeater();
                $cta3->add_control(
                    'cta_btn_text',
                    [
                        'label'       => esc_html__( 'Item', 'allianz' ),
                        'description' => esc_html__('Item Text', 'allianz'),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Click here', 'allianz' ),
                        'placeholder' => esc_html__( 'Click here', 'allianz' ),
                        'label_block' => true
                    ]
                );
                $cta3->add_control(
                    'cta_btn_type',
                    [
                        'label'   => esc_html__('Link Type', 'allianz'),
                        'type'    => Controls_Manager::SELECT,
                        'options' => [
                            'custom'      => esc_html__('Custom', 'allianz'),
                            'cms-service' => esc_html__('Service', 'allianz'),
                        ],
                        'default' => 'custom',
                        'condition' => [
                            'cta_btn_text!' => ''
                        ]
                    ]
                );
                $cta3->add_control(
                    'cta_btn_link',
                    [
                        'label'   => esc_html__('Select Service', 'allianz'),
                        'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                        'post_type' => [
                            'cms-service'
                        ],
                        'multiple'  => false,
                        'condition' => [
                            'cta_btn_text!' => '',
                            'cta_btn_type'  => 'cms-service'
                        ]
                    ]
                );
                $cta3->add_control(
                    'cta_btn_custom_link',
                    [
                        'label'       => esc_html__( 'Custom Link', 'allianz' ),
                        'type'        => Controls_Manager::URL,
                        'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                        'default'     => [
                            'url' => '#',
                        ],
                        'condition' => [
                            'cta_btn_text!' => '',
                            'cta_btn_type'  => 'custom'
                        ]
                    ]
                );

            $widget->add_control(
                'cta_9', 
                [
                    'label'       => esc_html__('Call To Actions', 'allianz'),
                    'label_block' => true,
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $cta3->get_controls(),
                    'title_field' => '{{{ cta_btn_text }}}',
                    'default'   => [
                        [
                            'cta_btn_text' => 'Process Optimization',
                        ],
                        [
                            'cta_btn_text' => 'Data Analytics',
                        ],
                        [
                            'cta_btn_text' => 'Risk Management',
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Style
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings','allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
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
            
            
            // Experience  
            $widget->add_control(
                'experience_text',
                [
                    'label'     => esc_html__( 'Experience Text', 'allianz' ),
                    'type'      => Controls_Manager::TEXTAREA,
                    'default'   => 'Years Of Experience',
                    'condition' => [
                        'layout' => ['7']
                    ]
                ]
            );    
            $widget->add_control(
                'experience_number',
                [
                    'label'       => esc_html__( 'Experience Number', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '29',
                    'condition' => [
                        'layout' => ['7']
                    ]
                ]
            );
            $widget->add_control(
                'experience_bg',
                [
                    'label'       => esc_html__( 'Experience Background', 'allianz' ),
                    'type'        => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-circle-text' => '--cms-bg-img: url({{URL}})',
                    ],
                    'condition' => [
                        'layout' => ['7']
                    ]
                ]
            );
            // Link
            allianz_elementor_colors_opts($widget,[
                'name'     => 'link_color',
                'label'     => esc_html__( 'Link Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-link' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'link_color_hover',
                'label'     => esc_html__( 'Link Color Hover', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-link:hover' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'link_border_color',
                'label'    => esc_html__( 'Link Border Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-link' => 'border-bottom-color: {{VALUE}};',
                ]
            ]);
            // Button
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn_color',
                'label'     => esc_html__( 'Button Color', 'allianz' ),
                'custom'    => false,
                'separator' => 'before'
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn_text_color',
                'label'     => esc_html__( 'Button Text Color', 'allianz' ),
                'separator' => 'before',
                'custom'    => false
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'   => 'btn_color_hover',
                'label'  => esc_html__( 'Button Hover Color', 'allianz' ),
                'custom' => false
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn_text_hover_color',
                'label'     => esc_html__( 'Button Text Hover Color', 'allianz' ),
                'separator' => 'before',
                'custom'    => false
            ]);
        $widget->end_controls_section();
    }
}
