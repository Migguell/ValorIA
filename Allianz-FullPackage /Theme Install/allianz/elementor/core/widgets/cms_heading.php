<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if (!function_exists('allianz_widget_cms_heading_register_controls')) {
    add_action('etc_widget_cms_heading_register_controls', 'allianz_widget_cms_heading_register_controls', 10, 1);
    function allianz_widget_cms_heading_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/3.webp'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/4.webp'
                        ],
                        '5' => [
                            'label' => esc_html__( 'Layout 5', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/5.webp'
                        ],
                        '6' => [
                            'label' => esc_html__( 'Layout 6', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/6.webp'
                        ],
                        '7' => [
                            'label' => esc_html__( 'Layout 7', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/7.webp'
                        ],
                        '8' => [
                            'label' => esc_html__( 'Layout 8', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/8.webp'
                        ],
                        '9' => [
                            'label' => esc_html__( 'Layout 9', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/9.webp'
                        ],
                        '10' => [
                            'label' => esc_html__( 'Layout 10', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/10.webp'
                        ],
                        '11' => [
                            'label' => esc_html__( 'Layout 11', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/11.webp'
                        ],
                        '12' => [
                            'label' => esc_html__( 'Layout 12', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/12.webp'
                        ],
                        '13' => [
                            'label' => esc_html__( 'Layout 13', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/13.webp'
                        ],
                        'all' => [
                            'label' => esc_html__( 'Layout all', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/all.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Content Tab Start

        // Heading Section Start
        $widget->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading Content', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            allianz_elementor_icon_image_settings($widget, [
                'name'  => 'heading_icon',
                'label' => esc_html__('Icon Settings','allianz'),
                'group' => false,
                'condition'   => [
                    'layout'  => ['all','10']  
                ]
            ]);
            // Small Heading
            $widget->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is small heading',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true,
                    'condition'   => [
                        'layout'  => ['all','1','2','3','4','5','6','7','10','12']  
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'smallheading_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-smallheading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout'             => ['all','1','2','3','4','5','6','7','10','12'],
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
                    'label_block' => true,
                    'condition'   => [
                        'layout'  => ['all','1','2','3','4','5','6','7','8','9','10','11','12','13']  
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'heading_color',
                'label'    => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-heading, {{WRAPPER}} .cms-heading a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout'        => ['all','1','2','3','4','5','6','7','8','9','10','11','12','13'],
                    'heading_text!' => ''
                ]
            ]);
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
                    'condition' => [
                        'layout' => ['all','3','6','7','10','13']
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'description_bold_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc-bold' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout'                 => ['all','3','6','7','10','13'],
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
                    'show_label'  => true,
                    'condition' => [
                        'layout' => ['all','2','3','6','7','9','10','11','12','13']
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'description_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout'            => ['all','2','3','6','7','9','10','11','12','13'],
                    'description_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Link 1
        $widget->start_controls_section('link1_section',[
            'label' => esc_html__('Link #1', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'layout' => ['all','2','5','9']
            ]
        ]);
            $widget->add_control(
                'link1_text',
                [
                    'label'       => esc_html__( 'Link #1 Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Discover More',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'separator' => 'before'
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
                'label'     => esc_html__( 'Link #1 Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_bg_color',
                'label'     => esc_html__( 'Link #1 Background Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => '',
                    'layout' => ['9']
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'   => 'link1_color_hover',
                'label'  => esc_html__( 'Link #1 Color Hover', 'allianz' ),
                'custom' => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_bg_hover_color',
                'label'     => esc_html__( 'Link #1 Background Hover Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => '',
                    'layout' => ['9']
                ]
            ]);
        $widget->end_controls_section();
        // Link 2
        $widget->start_controls_section('link2_section',[
            'label' => esc_html__('Link #2', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'layout' => ['all']
            ]
        ]);
            $widget->add_control(
                'link2_text',
                [
                    'label'       => esc_html__( 'Link Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Contact Us',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'separator'   => 'before'
                ]
            );
            $widget->add_control(
                'link2_type',
                [
                    'label'   => esc_html__('Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'link2_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'link2_page',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'link2_text!' => '',
                        'link2_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'link2_custom',
                [
                    'label'       => esc_html__( 'Link Custom', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'link2_text!' => '',
                        'link2_type' => 'custom'
                    ]
                ]
            );

            // Link #2
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link2_color',
                'label'     => esc_html__( 'Link#2 Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link2_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'   => 'link2_color_hover',
                'label'  => esc_html__( 'Link#2 Color Hover', 'allianz' ),
                'custom' => false,
                'condition' => [
                    'link2_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Experience 
        $widget->start_controls_section(
            'experience_section',
            [
                'label' => esc_html__('Experience Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['5','10']
                ]
            ]
        );  
            $widget->add_control(
                'experience_number',
                [
                    'label'       => esc_html__( 'Experience Number', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '29',
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'experience_text',
                [
                    'label'       => esc_html__( 'Experience Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Years Of Experience',
                    'label_block' => false
                ]
            ); 
            // icon
            allianz_elementor_icon_image_settings($widget, [
                'name'  => 'experience_icon',
                'label' => esc_html__('Icon Settings','allianz'),
                'group' => false
            ]);
            // background  
            $widget->add_control(
                'experience_bg',
                [
                    'label'       => esc_html__( 'Experience Background', 'allianz' ),
                    'type'        => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-bg-img' => '--cms-bg-img: url({{URL}})',
                    ]
                ]
            );
        $widget->end_controls_section();
        // Signature
        $widget->start_controls_section('signature_section',[
            'label' => esc_html__('Signature', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'layout' => ['all','9','10']
            ]
        ]);
            $widget->add_control(
                'savatar',
                [
                    'label'   => esc_html__( 'Avatar', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [],
                    'label_block' => false
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
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'sname',
                [
                    'label'       => esc_html__( 'Name', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Michael Brian',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'sposition',
                [
                    'label'       => esc_html__( 'Position', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'The Founder',
                    'label_block' => false
                ]
            );
        $widget->end_controls_section();
        // Progressbar Section Start
        $widget->start_controls_section(
                'section_progressbar',
                [
                    'label' => esc_html__('Progressbar Content', 'allianz'),
                    'tab'   => Controls_Manager::TAB_CONTENT,
                    'condition' => [
                        'layout' => ['all']
                    ]
                ]
            );

            $progressbar = new Repeater();

            $progressbar->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'default'     => esc_html__( 'My Skill', 'allianz' ),
                    'label_block' => true,
                ]
            );
            $progressbar->add_control(
                'percent',
                [
                    'label'       => esc_html__( 'Percentage', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::SLIDER,
                    'default'     => [
                        'size' => 80,
                        'unit' => '%',
                    ],
                    'label_block' => true,
                ]
            );

            $widget->add_control(
                'progressbar_list',
                [
                    'label'   => esc_html__('List', 'allianz'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $progressbar->get_controls(),
                    'default' => [
                        [
                            'title' => esc_html__('Fire Detection', 'allianz'),
                            'percent' => [
                                'size' => 95,
                                'unit' => '%',
                            ],
                        ],
                        [
                            'title' => esc_html__('Alarm Systems', 'allianz'),
                            'percent' => [
                                'size' => 88,
                                'unit' => '%',
                            ],
                        ],
                        [
                            'title' => esc_html__('CCTV & Video', 'allianz'),
                            'percent' => [
                                'size' => 99,
                                'unit' => '%',
                            ],
                        ],
                        [
                            'title' => esc_html__('Access control', 'allianz'),
                            'percent' => [
                                'size' => 85,
                                'unit' => '%',
                            ],
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
        $widget->end_controls_section();
        // Features
        $widget->start_controls_section('features_section',[
            'label' => esc_html__('Features Settings', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'layout'  => ['all','11']
            ]
        ]);
            
            $repeater = new Repeater();
            $repeater->add_control(
                'icon',
                [
                    'label'       => esc_html__( 'Icon', 'allianz' ),
                    'default'     => [],
                    'type'        => Controls_Manager::ICONS,
                    'skin'        => 'inline',
                    'label_block' => false,
                ]
            );
            $repeater->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'default'     => 'Your Title',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
            );
            $widget->add_control(
                'show_feature',
                [
                    'label'   => esc_html__('Show Feature', 'allianz'),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes'
                ]
            );
            $widget->add_responsive_control(
                'col',
                [
                    'label'        => esc_html__('Features Columns', 'allianz'),
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
                    ]
                ]
            );
            $widget->add_control(
                'cms_feature',
                [
                    'label'   => esc_html__('Features List', 'allianz'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'icon'        => [],
                            'title'       => 'Great Service & Low Cost',
                            'description' => 'If your business is looking for a reliable, cost effective general waste collection then you should cgoose us now! '
                        ],
                        [
                            'icon'        => [],
                            'title'       => 'Carbon Trust Certified ',
                            'description' => 'We will work with you to treat your trash in the best possible way for environment and to save our beloved planet.'
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                    'condition' => [
                        'show_feature' => 'yes'
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'feature_icon_color',
                'label'    => esc_html__( 'Icon Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .feature-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_feature' => 'yes'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'feature_title_color',
                'label'    => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .feature-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_feature' => 'yes'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'feature_desc_color',
                'label'    => esc_html__( 'Description Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .feature-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_feature' => 'yes'
                ]
            ]);
        $widget->end_controls_section();
        // Banner
        $widget->start_controls_section('banner_section',[
            'label'  => esc_html__('Banner Settings', 'allianz'),
            'tab'    => Controls_Manager::TAB_CONTENT
        ]);
            $widget->add_control(
                'banner_small',
                [
                    'label'   => esc_html__( 'Small Banner', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => ''
                    ],
                    'label_block' => false,
                    'condition' => [
                        'banner[url]!' => '',
                        'layout'       => ['all'] 
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
                        'layout' => ['all','6','12']
                    ]
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'banner',
                    'label'   => esc_html__('Banner Size','allianz'),
                    'default' => 'custom',
                    'condition' => [
                        'banner[url]!' => '',
                        'layout' => ['all','6','12']
                    ]
                ]
            );
            $widget->add_control(
                'banner_icon',
                [
                    'label'   => esc_html__( 'Icon', 'allianz' ),
                    'type'    => Controls_Manager::ICONS,
                    'skin'    => 'inline',  
                    'default' => [
                        'library' => 'cmsi',
                        'value'   => 'cmsi-star'
                    ],
                    'label_block' => false,
                    'condition' => [
                        'banner[url]!' => '',
                        'layout'       => ['all'] 
                    ]
                ]
            );
            $widget->add_control(
                'banner_title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Your Banner Title',
                    'label_block' => false,
                    'condition' => [
                        'banner[url]!' => '',
                        'layout'       => ['all','12'] 
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'banner_title_color',
                'label'    => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .banner-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'banner[url]!' => '',
                    'banner_title!' => '',
                    'layout'       => ['all','12'] 
                ]
            ]);
            $widget->add_control(
                'banner_desc',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Your Banner Description',
                    'label_block' => false,
                    'condition' => [
                        'banner[url]!' => '',
                        'layout'       => ['12'] 
                    ],
                    'separator' => 'before'
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'banner_desc_color',
                'label'    => esc_html__( 'Description Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .banner-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'banner[url]!' => '',
                    'banner_desc!' => '',
                    'layout'       => ['all','12'] 
                ]
            ]);
        $widget->end_controls_section();
        // video_player Section Start
        $widget->start_controls_section(
            'section_video_player',
            [
                'label' => esc_html__('Video Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['all']
                ]
            ]
        );
            $widget->add_control(
                'video_link',
                [
                    'label'       => esc_html__( 'Video URL', 'allianz' ),
                    'description' => esc_html__('Video url from  YouTube/Vimeo/Dailymotion','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'https://www.youtube.com/watch?v=iYf3OgEdGmo',
                    'dynamic'     => [
                        'active' => true
                    ]
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
                'video_text',
                [
                    'label'    => esc_html__( 'Video Text', 'allianz' ),
                    'type'     => Controls_Manager::TEXTAREA,
                    'default'  => 'Watch Video!',
                    'condition' => [
                        'video_link!' => ''
                    ],
                    'label_block' => false
                ]
            );
        $widget->end_controls_section();
        // Rating
        $widget->start_controls_section(
            'rate_section',
            [
                'label' => esc_html__('Rate Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['all']
                ]
            ]
        );  
            $widget->add_control(
                'star_rated',
                [
                    'label'       => esc_html__( 'Star', 'allianz' ),
                    'type'        => Controls_Manager::SELECT,
                    'options'     => [
                        '0'   => '0',
                        '20'  => '1',
                        '40'  => '2',
                        '60'  => '3',
                        '80'  => '4',
                        '100' => '5',
                    ],
                    'default' => '100'
                ]
            );    
            $widget->add_control(
                'percent',
                [
                    'label'       => esc_html__( 'Percentage', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '99.9%',
                    'placeholder' => '99.9%'
                ]
            );
            $widget->add_control(
                'percent_text',
                [
                    'label'       => esc_html__('Percentage Text', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Customer Satisfaction',
                    'placeholder' => 'Customer Satisfaction'
                ]
            );
            $widget->add_control(
                'percent_text2',
                [
                    'label'   => esc_html__('Other Text', 'allianz'),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => 'based on 750+ reviews of 6,154 Completed Projects, and 2,194 Happy Customers trust us.'
                ]
            );
        $widget->end_controls_section();
        // Testimonial
        $widget->start_controls_section(
            'ttmn_section',
            [
                'label'     => esc_html__('Testimonials', 'allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['all']
                ]
            ]
        );
            $repeater = new Repeater();
                $repeater->add_control(
                    'name',
                    [
                        'label' => esc_html__('Name', 'allianz'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Testimonial Name', 'allianz'),
                    ]
                );
                $repeater->add_control(
                    'position',
                    [
                        'label' => esc_html__('Position', 'allianz'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Testimonial Position', 'allianz'),
                    ]
                );
                $repeater->add_control(
                    'star_rated',
                    [
                        'label'       => esc_html__( 'Star', 'allianz' ),
                        'type'        => Controls_Manager::SELECT,
                        'options'     => [
                            '0'   => '0',
                            '20'  => '1',
                            '40'  => '2',
                            '60'  => '3',
                            '80'  => '4',
                            '100' => '5',
                        ],
                        'default' => '100'
                    ]
                );
                $repeater->add_control(
                    'description',
                    [
                        'label'   => esc_html__('Testimonial Text', 'allianz'),
                        'type'    => Controls_Manager::TEXTAREA,
                        'default' => esc_html__('Testimonial Text', 'allianz'),
                    ]
                );

            $widget->add_control(
                'testimonials',
                [
                    'label' => esc_html__('Testimonials', 'allianz'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'name'        => esc_html__('Sami Wade', 'allianz'),
                            'position'    => esc_html__('Promina Inc', 'allianz'),
                            'star_rated'  => '100',
                            'description' => 'I thank the technician who showed me a new view of what you can see with new cameras and I like it!',
                        ]
                    ],
                    'title_field' => '{{{ name }}}',
                ]
            );
        $widget->end_controls_section();
        // Style Content Alignment Start
        $widget->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content Alignment', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
                'align',
                [
                    'label'        => esc_html__( 'Alignment', 'allianz' ),
                    'type'         => Controls_Manager::CHOOSE,
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
            // background  
            $widget->add_control(
                'background',
                [
                    'label'       => esc_html__( 'Background', 'allianz' ),
                    'type'        => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => ''
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-ebg-img' => '--cms-ebg-img: url({{URL}})',
                    ],
                    'condition' => [
                        'layout' => ['10']
                    ]
                ]
            );
        $widget->end_controls_section();
        // Rate Style
        $widget->start_controls_section(
            'section_style_rate',
            [
                'label' => esc_html__('Rate Style', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => ['all']
                ]
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'star_color',
                'label'    => esc_html__( 'Star Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-star-rate' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'star_rated_color',
                'label'    => esc_html__( 'Star Rated Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-star-rated' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'rate_text_color',
                'label'    => esc_html__( 'Text Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-text' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
    }
}
