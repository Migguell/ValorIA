<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_counter_register_controls')) {
    add_action('etc_widget_cms_counter_register_controls', 'allianz_widget_cms_counter_register_controls', 10, 1);
    function allianz_widget_cms_counter_register_controls($widget)
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
                'layout_mode',
                [
                    'label'   => esc_html__('Layout Mode', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'grid'     => esc_html__('Grid', 'allianz'),
                        'carousel' => esc_html__('Carousel', 'allianz')
                    ],
                    'default' => 'grid'
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_counter/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_counter/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_counter/layout/3.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Reapeater Counter
        $widget->start_controls_section(
            'section_counters',
            [
                'label' => esc_html__('Counters Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $repeater = new Repeater();

            $repeater->add_control(
                'starting_number',
                [
                    'label'   => esc_html__( 'Starting Number', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'default' => 1,
                ]
            );
            $repeater->add_control(
                'ending_number',
                [
                    'label'   => esc_html__( 'Ending Number', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'default' => 100,
                ]
            );
            $repeater->add_control(
                'prefix',
                [
                    'label'       => esc_html__( 'Number Prefix', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'default'     => '',
                    'placeholder' => '1',
                ]
            );
            $repeater->add_control(
                'suffix',
                [
                    'label'       => esc_html__( 'Number Suffix', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'default'     => '',
                    'placeholder' => '+',
                ]
            );
            $repeater->add_control(
                'duration',
                [
                    'label'   => esc_html__( 'Animation Duration', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'default' => 3000,
                    'min'     => 100,
                    'step'    => 100,
                ]
            );
            $repeater->add_control(
                'thousand_separator_char',
                [
                    'label'     => esc_html__( 'Separator', 'allianz' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => [
                        ''  => 'Default',
                        ',' => 'Comma',
                        '.' => 'Dot',
                        ' ' => 'Space',
                    ],
                    'default'   => '',
                ]
            );
            allianz_elementor_icon_image_settings($repeater, [
                'group' => false,
                'name'  => 'counter_icon',
                'type'  => '',
                // icon
                'icon_default' => [],
                //image
                'img_default_size' => 'custom'
            ]);
            $repeater->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                    'default'     => 'Counter',
                    'placeholder' => esc_html__( 'Enter your Title', 'allianz' ),
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                    'default'     => 'Turpis massa tincidunt dui ut. Sit amet nisl purus in mollis nunc. Id neque aliquam vestibulum morbi blandit cursus risus',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                ]
            );
            // Button
            $repeater->add_control(
                'link_text',
                [
                    'label'       => esc_html__( 'Link Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'Click here', 'allianz' ),
                    'placeholder' => esc_html__( 'Click here', 'allianz' )
                ]
            );
            $repeater->add_control(
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
            $repeater->add_control(
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
            $repeater->add_control(
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
                        'link_type'  => 'custom'
                    ]
                ]
            );

            // add counter item
            $widget->add_control(
                'counters',
                [
                    'label'  => esc_html__('Counters List', 'allianz'),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'starting_number' => '1',
                            'ending_number'   => '300',
                            'prefix'          => '',
                            'suffix'          => 'K',
                            'title'           => 'Qualified Employees Works With Us',
                        ],
                        [
                            'starting_number' => '1',
                            'ending_number'   => '99',
                            'prefix'          => '',
                            'suffix'          => '%',
                            'title'           => 'Geographical Coverage Waste Collection',
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
        $widget->end_controls_section();
        // Banner
        $widget->start_controls_section(
            'section_single_image',
            [
                'label' => esc_html__('Banner Image', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'   => [
                    'layout'  => ['2']  
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
                    ]
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'banner',
                    'label'   => esc_html__('Image Size','allianz'),
                    'default' => 'custom',
                    'condition' => [
                        'banner[id]!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'banner_bg',
                [
                    'label'   => esc_html__( 'Banner Background', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
        $widget->end_controls_section();
        // Heading Section Start
        $widget->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading Content', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'   => [
                    'layout'  => ['2']  
                ],
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
            // Description Bold
            $widget->add_control(
                'description_bold_text',
                [
                    'label'       => esc_html__( 'Description (Bold)', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'default'     => '', 
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
                'sname',
                [
                    'label'       => esc_html__( 'Signature Name', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Michael Brian',
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'sposition',
                [
                    'label'       => esc_html__( 'Signature Position', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'The Founder',
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
        $widget->end_controls_section();
        // Button Setting
        $widget->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2']
                ]
            ]
        );
            // Button
            $widget->add_control(
                'btn_text',
                [
                    'label'       => esc_html__( 'Button Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'Click here', 'allianz' ),
                    'placeholder' => esc_html__( 'Click here', 'allianz' ),
                    'label_block' => true
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
                        'btn_text!' => '',
                        'btn_type'  => 'custom'
                    ]
                ]
            );
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
        // Style Section Start
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Number', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'number_color',
                'label'    => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-counter-number' => 'color: {{VALUE}};'
                ]
            ]);
            $widget->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'number_typography',
                    'selector' => '{{WRAPPER}} .cms-counter-numbers',
                ]
            );
        $widget->end_controls_section();
        // Icon Section Start
        $widget->start_controls_section('icon_style',[
            'label' =>  esc_html__('Icon', 'allianz'),
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'icon_image',
                    'label'   => esc_html__('Image Size','allianz'),
                    'default' => 'custom'
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_color',
                'label'    => esc_html__( 'Icon Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-counter-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cms-counter-icon svg' => 'fill: {{VALUE}};'
                ]
            ]);
        $widget->end_controls_section();
        // Start Settings
        $widget->start_controls_section(
            'grid_settings_section',
            [
                'label' => esc_html__('Grid Settings','allianz'),
                'tab'   => Controls_Manager::TAB_SETTINGS,
                'condition' => [
                    'layout_mode' => ['grid']
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
                    ]
                ]
            );
        $widget->end_controls_section();
        // Carousel
        $widget->start_controls_section(
            'carousel_settings_section',
            [
                'label' => esc_html__('Carousel Settings','allianz'),
                'tab'   => Controls_Manager::TAB_SETTINGS,
                'condition' => [
                    'layout_mode' => ['carousel']
                ]
            ]
        );
            $slides_to_show = range(1, 10);
            $slides_to_show = array_combine($slides_to_show, $slides_to_show);
            $widget->add_responsive_control(
                'slides_to_show',
                [
                    'label' => esc_html__('Slides to Show', 'allianz'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                            '' => esc_html__('Default', 'allianz'),
                        ] + $slides_to_show,
                    'frontend_available' => true,
                ]
            );

            $widget->add_responsive_control(
                'slides_to_scroll',
                [
                    'label' => esc_html__('Slides to Scroll', 'allianz'),
                    'type' => Controls_Manager::SELECT,
                    'description' => esc_html__('Set how many slides are scrolled per swipe.', 'allianz'),
                    'options' => [
                            '' => esc_html__('Default', 'allianz'),
                        ] + $slides_to_show,
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_responsive_control(
                'space_between',
                [
                    'label' => esc_html__('Space Between', 'allianz'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 40,
                    ],
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'arrows',
                [
                    'label' => esc_html__('Show Arrows', 'allianz'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'dots',
                [
                    'label' => esc_html__('Show Dots', 'allianz'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'arrow_prev_icon',
                [
                    'label'            => esc_html__('Previous Arrow Icon', 'allianz'),
                    'type'             => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'skin'             => 'inline',
                    'label_block'      => false,
                    'skin_settings'    => [
                        'inline' => [
                            'none' => [
                                'label' => 'Default',
                                'icon' => 'eicon-chevron-left',
                            ],
                            'icon' => [
                                'icon' => 'eicon-star',
                            ],
                        ],
                    ],
                    'condition' => [
                        'arrows' => 'yes'
                    ],
                ]
            );

            $widget->add_control(
                'arrow_next_icon',
                [
                    'label'            => esc_html__('Next Arrow Icon', 'allianz'),
                    'type'             => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'skin'             => 'inline',
                    'label_block'      => false,
                    'skin_settings'    => [
                        'inline' => [
                            'none' => [
                                'label' => 'Default',
                                'icon' => 'eicon-chevron-right',
                            ],
                            'icon' => [
                                'icon' => 'eicon-star',
                            ],
                        ],
                    ],
                    'condition' => [
                        'arrows' => 'yes'
                    ],
                ]
            );

            $widget->add_control(
                'lazyload',
                [
                    'label' => esc_html__('Lazyload', 'allianz'),
                    'type' => Controls_Manager::SWITCHER,
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'autoplay',
                [
                    'label' => esc_html__('Autoplay', 'allianz'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'pause_on_hover',
                [
                    'label' => esc_html__('Pause on Hover', 'allianz'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'pause_on_interaction',
                [
                    'label' => esc_html__('Pause on Interaction', 'allianz'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'autoplay_speed',
                [
                    'label' => esc_html__('Autoplay Speed', 'allianz'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 5000,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'infinite',
                [
                    'label' => esc_html__('Infinite Loop', 'allianz'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'effect',
                [
                    'label' => esc_html__('Effect', 'allianz'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'slide',
                    'options' => [
                        'slide' => esc_html__('Slide', 'allianz'),
                        'fade' => esc_html__('Fade', 'allianz'),
                    ],
                    'condition' => [
                        'slides_to_show' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'speed',
                [
                    'label' => esc_html__('Animation Speed', 'allianz'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 500,
                    'render_type' => 'none',
                    'frontend_available' => true,
                ]
            );
        $widget->end_controls_section();
    }
}
