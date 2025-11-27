<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_video_player_register_controls')) {
    add_action('etc_widget_cms_video_player_register_controls', 'allianz_widget_cms_video_player_register_controls', 10, 1);
    function allianz_widget_cms_video_player_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/3.webp'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/4.webp'
                        ],
                        '5' => [
                            'label' => esc_html__( 'Layout 5', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/5.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Video Sections
        $widget->start_controls_section(
            'section_video_player',
            [
                'label' => esc_html__('Video Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $widget->add_control(
            'video_type',
            [
                'label' => esc_html__( 'Source', 'allianz' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__( 'YouTube', 'allianz' ),
                    // 'vimeo' => esc_html__( 'Vimeo', 'allianz' ),
                    // 'dailymotion' => esc_html__( 'Dailymotion', 'allianz' ),
                    // 'videopress' => esc_html__( 'VideoPress', 'allianz' ),
                    // 'hosted' => esc_html__( 'Self Hosted', 'allianz' ),
                ],
                'frontend_available' => true,
            ]
        );
        $widget->add_control(
            'lightbox',
            [
                'label'     => esc_html__( 'Lightbox', 'allianz' ),
                'type'      => Controls_Manager::SWITCHER,
                //'label_off' => esc_html__( 'Hide', 'allianz' ),
                //'label_on'  => esc_html__( 'Show', 'allianz' ),
                'default'   => 'yes',
                'frontend_available' => true,
            ]
        );
        $widget->add_control(
            'controls',
            [
                'label'     => esc_html__( 'Player Controls', 'allianz' ),
                'type'      => Controls_Manager::SWITCHER,
                //'label_off' => esc_html__( 'Hide', 'allianz' ),
                //'label_on'  => esc_html__( 'Show', 'allianz' ),
                'default'   => 'yes',
                'condition' => [
                    'lightbox!' => 'yes'
                ],
                'frontend_available' => true,
            ]
        );
        
        $widget->add_control(
            'video_link',
            [
                'label'    => esc_html__( 'Video URL', 'allianz' ),
                'subtitle' => esc_html__('Video url from  YouTube/Vimeo/Dailymotion','allianz'),
                'type'     => Controls_Manager::TEXTAREA,
                'default'  => 'https://www.youtube.com/watch?v=iYf3OgEdGmo',
                'dynamic' => [
                    'active' => true
                ],
                'label_block' => false,
                'ai' => [
                    'active' => false
                ],
                'frontend_available' => true
            ]
        );
        $widget->add_control(
            'video_icon',
            [
                'label'   => esc_html__( 'Video Icon', 'allianz' ),
                'type'    => Controls_Manager::ICONS,
                'skin'    => 'inline',
                'default' => [
                    'library' => 'cmsi',
                    'value'   => 'cmsi-play'
                ],
                'condition' => [
                    'video_link!' => ''
                ],
                'label_block' => false
            ]
        );
        $widget->add_control(
            'video_text_title',
            [
                'label'       => esc_html__( 'Watch Video Title', 'allianz' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => '',
                'label_block' => false,
                'condition'   => [
                    'layout' => ['2']
                ]
            ]
        );
        $widget->add_control(
            'video_text',
            [
                'label'    => esc_html__( 'Watch Video Text', 'allianz' ),
                'type'     => Controls_Manager::TEXTAREA,
                'default'  => '',
                'condition' => [
                    'video_link!' => ''
                ],
                'label_block' => false
            ]
        );
        $widget->add_control(
            'image',
            [
                'label'   => esc_html__( 'Video Banner', 'allianz' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ],
                'skin'  => 'inline',
                'condition' => [
                    'video_link!' => '',
                    'layout'      => ['1','2','4','5']  
                ]
            ]
        );
        $widget->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'image',
                'label'   => esc_html__('Banner Size','allianz'),
                'default' => 'custom',
                'condition' => [
                    'video_link!' => '',
                    'image[url]!' => '',
                    'layout'      => ['1','2','4','5']
                ],
                'frontend_available' => true,
            ]
        );
        $widget->end_controls_section();
        // Icon Sections
        allianz_elementor_icon_image_settings($widget, [
            'condition' => [
                'layout' => ['2']
            ]
        ]);
        // Content Sections
        $widget->start_controls_section(
            'section_content',
            [
                'label'     => esc_html__('Content Settings','allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2','3']
                ]
            ]
        );
            // Small Heading
            $widget->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is small heading',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true
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
            // Signature
            $widget->add_control(
                'sname',
                [
                    'label'       => esc_html__( 'Signature Name', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Michael Brian',
                    'label_block' => true,
                    'condition' => [
                        'layout' => ['3']
                    ]
                ]
            );
            $widget->add_control(
                'sposition',
                [
                    'label'       => esc_html__( 'Signature Position', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'The Founder',
                    'label_block' => false,
                    'condition' => [
                        'layout' => ['3']
                    ]
                ]
            );
            $widget->add_control(
                'simage',
                [
                    'label'   => esc_html__( 'Signature Image', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => get_template_directory_uri() . '/assets/images/signature.png'
                    ],
                    'label_block' => false,
                    'condition' => [
                        'layout' => ['3']
                    ]
                ]
            );
            // Description Bold
            $widget->add_control(
                'description_bold_text',
                [
                    'label'       => esc_html__( 'Description (Bold)', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since', 
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'rows'        => 10,
                    'show_label'  => true,
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'description_bold_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc-bold' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'description_bold_text!' => ''
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
            // Heading Button
            $widget->add_control(
                'heading_btn_text',
                [
                    'label'       => esc_html__( 'Button Settings', 'allianz' ),
                    'description' => esc_html__('Button Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'Click here', 'allianz' ),
                    'placeholder' => esc_html__( 'Click here', 'allianz' ),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['2']
                    ]
                ]
            );
            $widget->add_control(
                'heading_btn_type',
                [
                    'label'   => esc_html__('Button Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'layout' => ['2'],
                        'heading_btn_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'heading_btn_link',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'layout' => ['2'],
                        'heading_btn_text!' => '',
                        'heading_btn_type'  => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'heading_btn_custom_link',
                [
                    'label'       => esc_html__( 'Custom Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'layout' => ['2'],
                        'heading_btn_text!' => '',
                        'heading_btn_type'  => 'custom'
                    ]
                ]
            );
        $widget->end_controls_section();
        // Call to Action
        $widget->start_controls_section(
            'video_cta_section',
            [
                'label'     => esc_html__('Call to Action Settings','allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2']
                ]
            ]
        );
            allianz_elementor_icon_image_settings($widget, [
                'group' => false,
                'prefix'=> 'cta'
            ]);
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
            $widget->add_control(
                'cta_text',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Financial success depends on relying on a team of experts with in-depth knowledge and massive experience in business application solutions to guide you through the process and provides the necessary tools to reach the desired goal and exceed your expectations.<br/><br/>Find out about the ways to deal with debts if you are falling behind with daily bills, loan and repayments or other commitments. Get some free advice by speaking to one of our financial advisers over the phone! Just submit your details and we’ll be in touch shortly. ',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true
                ]
            );
            // Button
            $widget->add_control(
                'cta_btn_text',
                [
                    'label'       => esc_html__( 'Button Settings', 'allianz' ),
                    'description' => esc_html__('Button Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'Click here', 'allianz' ),
                    'placeholder' => esc_html__( 'Click here', 'allianz' ),
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'cta_btn_type',
                [
                    'label'   => esc_html__('Button Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'cta_btn_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'cta_btn_link',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'cta_btn_text!' => '',
                        'cta_btn_type'  => 'page'
                    ]
                ]
            );
            $widget->add_control(
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
        $widget->end_controls_section();
        // Call to Action #3
        $widget->start_controls_section(
            'video_cta_section_3',
            [
                'label'     => esc_html__('Call to Action Settings','allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['3']
                ]
            ]
        );
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
                'video_cta3', 
                [
                    'label'  => esc_html__('Call To Action', 'allianz'),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $cta3->get_controls(),
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
        // Style Tab
        $widget->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style Settings','allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'video_text_color',
                'label'    => esc_html__( 'Video Text Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-text' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]);
        $widget->end_controls_section();
        // Style
        $widget->start_controls_section(
            'cta_style_section',
            [
                'label' => esc_html__('Call to Action Style','allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            // Text
            allianz_elementor_colors_opts($widget,[
                'name'     => 'cta_title_color',
                'label'     => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cta-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]);
            // Text
            allianz_elementor_colors_opts($widget,[
                'name'     => 'cta_text_color',
                'label'     => esc_html__( 'Text Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cta-desc' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]);
            // Button
            allianz_elementor_colors_opts($widget,[
                'name'      => 'cta_btn_color',
                'label'     => esc_html__( 'Button Color', 'allianz' ),
                'custom'    => false,
                'separator' => 'before'
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'cta_btn_text_color',
                'label'     => esc_html__( 'Button Text Color', 'allianz' ),
                'separator' => 'before',
                'custom'    => false
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'   => 'cta_btn_color_hover',
                'label'  => esc_html__( 'Button Hover Color', 'allianz' ),
                'custom' => false
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'cta_btn_text_hover_color',
                'label'     => esc_html__( 'Button Text Hover Color', 'allianz' ),
                'separator' => 'before',
                'custom'    => false
            ]);
        $widget->end_controls_section();
        // Custom
        $widget->start_controls_section(
            'custom_section',
            [
                'label' => esc_html__('Custom Settings','allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            $widget->add_control(
                'css_classes',
                [
                    'label'       => esc_html__('CSS Classes', 'allianz' ),
                    'description' => esc_html__('Add custom class to make special style', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => false
                ]
            );
        $widget->end_controls_section();
    }
}
