<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_business_consultant_register_controls')) {
    add_action('etc_widget_cms_business_consultant_register_controls', 'allianz_widget_cms_business_consultant_register_controls', 10, 1);
    function allianz_widget_cms_business_consultant_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_business_consultant/layout/1.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Banner
        $widget->start_controls_section(
            'section_banner',
            [
                'label' => esc_html__('Banner Settings', 'allianz'),
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
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'banner',
                    'label'   => esc_html__('Banner Size','allianz'),
                    'default' => 'custom',
                    'condition' => [
                        'banner[id]!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'banner_shadow',
                [
                    'label'     => esc_html__( 'Banner Shadow', 'allianz' ),
                    'type'      => Controls_Manager::MEDIA,
                    'default'   => [],
                    'condition' => [
                        'banner[id]!' => ''
                    ],
                    'skin'        => 'inline',
                    'label_block' => false
                ]
            );
            // Name
            $widget->add_control(
                'banner_name',
                [
                    'label'   => esc_html__( 'Banner Name', 'allianz' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Mike',
                    'condition' => [
                        'banner[id]!' => ''
                    ],
                ]
            );
            // Bio
            $widget->add_control(
                'banner_bio',
                [
                    'label'   => esc_html__( 'Banner Biographical', 'allianz' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Speak to me over the phone or submit details and we’ll be in touch shortly!',
                    'condition' => [
                        'banner[id]!' => ''
                    ],
                ]
            );
            // Link
            $widget->add_control(
                'banner_link_text',
                [
                    'label'       => esc_html__( 'Banner Link Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Contact Me',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'separator'   => 'before',
                    'condition' => [
                        'banner[id]!' => ''
                    ],
                ]
            );
            $widget->add_control(
                'banner_link_type',
                [
                    'label'   => esc_html__('Banner Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'banner[id]!' => '',
                        'banner_link_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'banner_link_page',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'banner[id]!' => '',
                        'banner_link_text!' => '',
                        'banner_link_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'banner_link_custom',
                [
                    'label'       => esc_html__( 'Link Custom', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'banner[id]!' => '',
                        'banner_link_text!' => '',
                        'banner_link_type' => 'custom'
                    ]
                ]
            );
        $widget->end_controls_section();
        // Content
        $widget->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
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
                    '{{WRAPPER}} .cms-heading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);
            // Description Bold
            $widget->add_control(
                'description_bold_text',
                [
                    'label'       => esc_html__( 'Description (Bold)', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since', 
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'rows'        => 10,
                    'show_label'  => true
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
            // Signature
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
                'semail',
                [
                    'label'       => esc_html__( 'Email', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Mike@7oroof.com',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'sphone',
                [
                    'label'       => esc_html__( 'Phone', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '+2 011 6114 5741',
                    'label_block' => false
                ]
            );
        $widget->end_controls_section();
        // Social
        $widget->start_controls_section(
            'social_section',
            [
                'label' => esc_html__('Socials Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $socials = new Repeater();
            $socials->add_control(
                'icon',
                [
                    'label'   => esc_html__( 'Icon', 'allianz' ),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'cmsi-star',
                        'library' => 'cmsi',
                    ]
                ]
            );
            $socials->add_control(
                'title',
                [
                    'label'   => esc_html__( 'Title', 'allianz' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Social Title',
                ]
            );
            $socials->add_control(
                'url',
                [
                    'label'   => esc_html__( 'Link', 'allianz' ),
                    'type'    => Controls_Manager::URL,
                    'default' => [
                        'is_external' => 'true'
                    ],
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                ]
            );
            $widget->add_control(
                'socials',
                [
                    'label'   => esc_html__('Socials Lists', 'allianz'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $socials->get_controls(),
                    'default' => [
                        [
                            'icon' => [
                                'value'   => 'cmsi-facebook',
                                'library' => 'cmsi',
                            ],
                            'title' => 'Facebook',
                            'url' => [
                                'is_external' => true,
                                'url' => 'https://facebook.com'
                            ]
                        ],
                        [
                            'icon' => [
                                'value'   => 'cmsi-twitter-circle',
                                'library' => 'cmsi',
                            ],
                            'title' => 'Twitter',
                            'url' => [
                                'is_external' => true,
                                'url' => 'https://twitter.com'
                            ]
                        ],
                        [
                            'icon' => [
                                'value'   => 'cmsi-linkedin-circle',
                                'library' => 'cmsi',
                            ],
                            'title' => 'LinkedIn',
                            'url' => [
                                'is_external' => true,
                                'url' => 'https://linkedin.com'
                            ]
                        ]
                    ],
                    'title_field' => '{{{ "<i class=\"" + icon.value + "\"></i>" + " " + title }}}'
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'social_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .social-item' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'social_color_hover',
                'label'     => esc_html__( 'Hover Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .social-item:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Experience
        $widget->start_controls_section('experience_section',[
            'label' => esc_html__('Experience Settings', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);
            $widget->add_control(
                'experience_title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'default'     => 'Experience',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $experience = new Repeater();
            $experience->add_control(
                'icon',
                [
                    'label'       => esc_html__( 'Icon', 'allianz' ),
                    'default'     => [
                        'library' => 'cmsi',
                        'value'   => 'cmsi-star' 
                    ],
                    'type'        => Controls_Manager::ICONS,
                    'skin'        => 'inline',
                    'label_block' => false
                ]
            );
            $experience->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'default'     => 'Your Title',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $experience->add_control(
                'description',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true
                ]
            );
            $experience->add_control(
                'time',
                [
                    'label'       => esc_html__( 'Time', 'allianz' ),
                    'default'     => 'Jan 2024',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'experiences',
                [
                    'label'   => esc_html__('Experience List', 'allianz'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $experience->get_controls(),
                    'default' => [
                        [
                            'icon'        => [
                                'library' => 'cmsi',
                                'value'   => 'cmsi-default' 
                            ],
                            'title'       => 'Market Research and Analysis',
                            'description' => 'Our research is more than just numbers. We don\'t stop at spreadsheets and site visits. Year over year, we get to know the people who make the company work.',
                            'time'        => 'Sep 2019  -  Sep 2023'  
                        ],
                        [
                            'icon'        => [
                                'library' => 'cmsi',
                                'value'   => 'cmsi-default' 
                            ],
                            'title'       => 'Business Strategy Development',
                            'description' => 'Our research is more than just numbers. We don\'t stop at spreadsheets and site visits. Year over year, we get to know the people who make the company work.',
                            'time'        => 'Aug 2016  -  Sep 2019'
                        ],
                        [
                            'icon'        => [
                                'library' => 'cmsi',
                                'value'   => 'cmsi-default' 
                            ],
                            'title'       => 'Tax Consultant',
                            'description' => 'Our research is more than just numbers. We don\'t stop at spreadsheets and site visits. Year over year, we get to know the people who make the company work.',
                            'time'        => 'Sep 2012  -  Aug 2016'      
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
        $widget->end_controls_section();
        // Education
        $widget->start_controls_section('education_section',[
            'label' => esc_html__('Education Settings', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);
            $widget->add_control(
                'education_title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'default'     => 'Education',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $education = new Repeater();
            $education->add_control(
                'small_title',
                [
                    'label'       => esc_html__( 'Small Title', 'allianz' ),
                    'default'     => [],
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $education->add_control(
                'time',
                [
                    'label'       => esc_html__( 'Time', 'allianz' ),
                    'default'     => 'Jan 2024',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $education->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'default'     => 'Your Title',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $education->add_control(
                'description',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'cms_education',
                [
                    'label'   => esc_html__('Education List', 'allianz'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $education->get_controls(),
                    'default' => [
                        [
                            'small_title' => 'Harvard University',
                            'time'        => '2006  -  2008',
                            'title'       => 'MBA Finance Course',
                            'description' => 'MBA in Finance is a 2 year post graduate program for candidates who are interested in the fields of marketing and financing.',
                        ],
                        [
                            'small_title' => 'The University of Sydney',
                            'time'        => '22002  -  2006',
                            'title'       => 'Bachelor of Commerce',
                            'description' => 'Domestic school-leaver applicants who satisfy course prerequisites and achieve this ATAR will be guaranteed a place.',
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
        $widget->end_controls_section();
        // Skill
        $widget->start_controls_section(
                'section_progressbar',
                [
                    'label' => esc_html__('Skill Settings', 'allianz'),
                    'tab'   => Controls_Manager::TAB_CONTENT
                ]
            );
            $widget->add_control(
                'skill_title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'default'     => 'Skill',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
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
                    'type'        => Controls_Manager::SLIDER,
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
                            'title' => 'Recruitment',
                            'percent' => [
                                'size' => 95,
                                'unit' => '%',
                            ],
                        ],
                        [
                            'title' => 'Time Management',
                            'percent' => [
                                'size' => 88,
                                'unit' => '%',
                            ],
                        ],
                        [
                            'title' => 'Team Building',
                            'percent' => [
                                'size' => 77,
                                'unit' => '%',
                            ],
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
        $widget->end_controls_section();
        // Testimonial
        $widget->start_controls_section(
            'ttmn_section',
            [
                'label'     => esc_html__('Testimonials', 'allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'ttmn_title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'default'     => 'Testimonials',
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $ttmns = new Repeater();
            $ttmns->add_control(
                'image',
                [
                    'label' => esc_html__('Avatar', 'allianz'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $ttmns->add_control(
                'name',
                [
                    'label' => esc_html__('Name', 'allianz'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Testimonial Name', 'allianz'),
                ]
            );

            $ttmns->add_control(
                'position',
                [
                    'label' => esc_html__('Position', 'allianz'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Testimonial Position', 'allianz'),
                ]
            );
            $ttmns->add_control(
                'description',
                [
                    'label' => esc_html__('Description', 'allianz'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__('Testimonial Description', 'allianz'),
                ]
            );

            $widget->add_control(
                'testimonials',
                [
                    'label' => esc_html__('Testimonials', 'allianz'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $ttmns->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => esc_html__('Testimonial Name', 'allianz'),
                            'position'    => esc_html__('Testimonial Position', 'allianz'),
                            'description' => esc_html__('#1 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'allianz'),
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => esc_html__('Testimonial Name #2', 'allianz'),
                            'position'    => esc_html__('Testimonial Position #2', 'allianz'),
                            'description' => esc_html__('#2 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'allianz'),
                        ],
                    ],
                    'title_field' => '{{{ name }}}',
                ]
            );
        $widget->end_controls_section();
        // Call to Actions
        $widget->start_controls_section(
            'cta_section',
            [
                'label' => esc_html__('Call to Action Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );  
            // Small Heading
            $widget->add_control(
                'cta_smallheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is small heading',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'cta_smallheading_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cta-smallheading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'cta_smallheading_text!' => ''
                ]
            ]);
            // Heading
            $widget->add_control(
                'cta_heading_text',
                [
                    'label'       => esc_html__( 'Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true,
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'cta_heading_color',
                'label'    => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cta-heading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'cta_heading_text!' => ''
                ]
            ]);
            // Description
            $widget->add_control(
                'cta_description_text',
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
                'name'     => 'cta_description_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cta-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'cta_description_text!' => ''
                ]
            ]);

            $widget->add_control(
                'cta_link_text',
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
                'cta_link_type',
                [
                    'label'   => esc_html__('Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'cta_link_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'cta_page_link',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'cta_link_text!' => '',
                        'cta_link_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'cta_custom_link',
                [
                    'label'       => esc_html__( 'Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'cta_link_text!' => '',
                        'cta_link_type' => 'custom'
                    ]
                ]
            );
        $widget->end_controls_section();
        // Testimonials Carousel Settings
        allianz_elementor_carousel_settings($widget, [
            'label' => esc_html__('Testimonials Settings', 'allianz')
        ]);
    }
}
