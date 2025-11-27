<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_slider_register_controls')) {
    add_action('etc_widget_cms_slider_register_controls', 'allianz_widget_cms_slider_register_controls', 10, 1);
    function allianz_widget_cms_slider_register_controls($widget)
    {
        // Layout Tab Start
        $widget->start_controls_section('layout_section', [
            'label' => esc_html__('Layout', 'allianz'),
            'tab' => Controls_Manager::TAB_LAYOUT,
        ]);
            $widget->add_control('header_transparent', [
                'label'              => esc_html__('Header Transparent', 'allianz'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => '',
                'prefix_class'       => 'cms-eslider-header-transparent-',
                'description'        => esc_html__('Make arrows alignment middle when have Header Transparent','allianz')   
            ]);
            $widget->add_control('layout', [
                'label'   => esc_html__('Templates', 'allianz'),
                'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                'default' => '1',
                'options' => [
                    '1' => [
                        'label' => esc_html__('Layout 1', 'allianz'),
                        'image' => get_template_directory_uri().'/elementor/templates/widgets/cms_slider/layout/1.webp',
                    ],
                    '2' => [
                        'label' => esc_html__('Layout 2', 'allianz'),
                        'image' => get_template_directory_uri().'/elementor/templates/widgets/cms_slider/layout/2.webp',
                    ],
                    '3' => [
                        'label' => esc_html__('Layout 3', 'allianz'),
                        'image' => get_template_directory_uri().'/elementor/templates/widgets/cms_slider/layout/3.webp',
                    ],
                    '4' => [
                        'label' => esc_html__('Layout 4', 'allianz'),
                        'image' => get_template_directory_uri().'/elementor/templates/widgets/cms_slider/layout/4.webp',
                    ],
                    '5' => [
                        'label' => esc_html__('Layout 5', 'allianz'),
                        'image' => get_template_directory_uri().'/elementor/templates/widgets/cms_slider/layout/5.webp',
                    ]
                ]
            ]);
        $widget->end_controls_section();

        // Slider List Section Start
        $widget->start_controls_section('slider_list_section', [
            'label' => esc_html__('Slider List', 'allianz'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

            $repeater = new Repeater();
            $repeater->add_control(
                'slide_type',
                [
                    'label'       => esc_html__('Slide Type', 'allianz'),
                    'type'        => Controls_Manager::SELECT,
                    'label_block' => false,
                    'options'     => [
                        ''      => esc_html__('None','allianz'),
                        'img'   => esc_html__('Image','allianz'),
                        'video' => esc_html__('Video','allianz')
                    ],
                    'default'     => 'img',
                ]
            );
            $repeater->add_control(
                'image',
                [
                    'label'       => esc_html__('Slide Image', 'allianz'),
                    'type'        => Controls_Manager::MEDIA,
                    'label_block' => true,
                    'default'     => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'slide_type' => 'img'
                    ]
                ]
            );
            $repeater->add_control(
                'video_url',
                [
                    'label' => esc_html__( 'Video URL', 'allianz' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true
                    ],
                    'placeholder' => esc_html__( 'Enter your YouTube video url', 'allianz' ) . ' (YouTube)',
                    'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                    'label_block' => true,
                    'condition' => [
                        'slide_type' => 'video',
                    ],
                    'ai' => [
                        'active' => false,
                    ]
                ]
            );
            $repeater->add_control(
                'subtitle',
                [
                    'label'       => esc_html__('Small Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the subtitle', 'allianz'),
                    'placeholder' => esc_html__('Enter your subtitle', 'allianz'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the title', 'allianz'),
                    'placeholder' => esc_html__('Enter your title', 'allianz'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'description_title',
                [
                    'label'       => esc_html__('Description Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your Description Title', 'allianz'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label'       => esc_html__('Description', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the description', 'allianz'),
                    'placeholder' => esc_html__('Enter your description', 'allianz'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'button_primary',
                [
                    'label'       => esc_html__('Button Primary', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__('Button Primary', 'allianz'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'button_primary_type',
                [
                    'label'   => esc_html__('Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'button_primary!' => ''
                    ]
                ]
            );
            $repeater->add_control(
                'button_primary_page_link',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'    => false,
                    'label_block' => true,
                    'condition'   => [
                        'button_primary!'     => '',
                        'button_primary_type' => 'page'
                    ]
                ]
            );
            $repeater->add_control(
                'button_primary_link',
                [
                    'label'       => esc_html__( 'Custom Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'button_primary!'     => '',
                        'button_primary_type' => 'custom'
                    ]
                ]
            );
            // Button Secondary 
            $repeater->add_control(
                'button_secondary',
                [
                    'label'       => esc_html__('Button Secondary', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__('Button Secondary', 'allianz'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'button_secondary_type',
                [
                    'label'   => esc_html__('Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'button_secondary!' => ''
                    ]
                ]
            );
            $repeater->add_control(
                'button_secondary_page_link',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'    => false,
                    'label_block' => true,
                    'condition'   => [
                        'button_secondary!'     => '',
                        'button_secondary_type' => 'page'
                    ]
                ]
            );
            $repeater->add_control(
                'button_secondary_link',
                [
                    'label'       => esc_html__( 'Custom Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'button_secondary!'     => '',
                        'button_secondary_type' => 'custom'
                    ]
                ]
            );
            // Video  Button
            $repeater->add_control(
                'video_link',
                [
                    'label'       => esc_html__( 'Button Video', 'allianz' ),
                    'description' => esc_html__('Video url from  YouTube/Vimeo/Dailymotion.','allianz').' EX: https://www.youtube.com/watch?v=iYf3OgEdGmo',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'dynamic'     => [
                        'active' => true
                    ],
                    'label_block' => true
                ]
            );
            $repeater->add_control(
                'video_text',
                [
                    'label'       => '',
                    'description' => esc_html__('Text beside play icon','allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'How it works',
                    'condition'   => [
                        'video_link!' => ''
                    ],
                    'label_block' => true
                ]
            );
            // Start List
            $widget->add_control(
                'cms_slides',
                [
                    'label' => esc_html__('Slides', 'allianz'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'title'       => 'Smart Systems For Safe Future!',
                            'subtitle'    => '',
                            'description' => 'Not only will this reduce the probability of crime happening on your property, it will reduce or eliminate any liability that falls on you if you can show you have solid, well-designed commercial building security systems in place.',
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'title'       => 'Unique & Powerful Security Solutions',
                            'subtitle'    => '',
                            'description' => 'Not only will this reduce the probability of crime happening on your property, it will reduce or eliminate any liability that falls on you if you can show you have solid, well-designed commercial building security systems in place.',
                        ],
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
            // icon
            allianz_elementor_icon_image_settings($widget, [
                'name'     => 'desc_icon',
                'label'    => esc_html__('Description Icon', 'allianz'),
                'group'    => false, 
                'img_size' => false,
                'icon_default' => [
                    'library' => 'allianz-icon',
                    'value'   => 'allianz-icon-arrow-right-up'
                ],
                'label_block' => true,
                'condition'   => [
                    'layout' => ['4']
                ]
            ]);
        $widget->end_controls_section();
        // General Style Section Start
        $widget->start_controls_section(
            'general_style_section',
            [
                'label' => esc_html__('General', 'allianz'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
                'overlay_image',
                [
                    'label'       => esc_html__('Overlay Image', 'allianz'),
                    'type'        => Controls_Manager::MEDIA,
                    'label_block' => false,
                    'default'     => [
                        'url' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-slider-item:before' => 'background-image:url({{URL}});'
                    ]
                ]
            );
            $widget->add_control('overlay_style', [
                'label' => esc_html__('Overlay Style', 'allianz'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    ''  => esc_html__('None','allianz'),
                    '1' => 'Style 1',
                    '2' => 'Style 2',
                    '3' => 'Style 3',
                    '4' => 'Style 4',
                ],
                'default' => '1',
                'dynamic' => [
                    'active' => true
                ],
                'style_transfer' => true,
                'prefix_class'   => 'cms-eslider-overlay-'
            ]);
            $widget->add_responsive_control(
                'content_align',
                [
                    'label'        => esc_html__( 'Content Alignment', 'allianz' ),
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
                        ]
                    ]
                ]
            );
            $widget->add_responsive_control(
                'content_width',
                [
                    'label' => esc_html__('Content Width', 'allianz'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min'  => 300, 
                            'max'  => 1280,
                            'step' => 5
                        ]
                    ],
                    'selectors'    => [
                        '{{WRAPPER}} .cms-slider--content' => 'max-width: {{SIZE}}{{UNIT}};',
                    ]
                ]
            );
        $widget->end_controls_section();
        // Subtitle Style Section Start
        $widget->start_controls_section(
            'subtitle_style_section',
            [
                'label' => esc_html__('Subtitle', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
                'subtitle_animation',
                [
                    'label'              => esc_html__('Animation', 'allianz'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'subtitle_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'allianz'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 500,
                    'frontend_available' => true,
                ]
            );
            allianz_add_hidden_device_controls($widget, ['prefix' => 'subtitle_']);
        $widget->end_controls_section();
        // Subtitle Style Section End

        // Title Style Section Start
        $widget->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'allianz'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
                'title_animation',
                [
                    'label'              => esc_html__('Animation', 'allianz'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'title_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'allianz'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 600,
                    'frontend_available' => true,
                ]
            );
            allianz_add_hidden_device_controls($widget, ['prefix' => 'title_']);
        $widget->end_controls_section();
        // Title Style Section End

        // Description Style Section Start
        $widget->start_controls_section(
            'description_style_section',
            [
                'label' => esc_html__('Description', 'allianz'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_responsive_control(
                'desc_width',
                [
                    'label' => esc_html__('Width', 'allianz'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min'  => 300, 
                            'max'  => 1280,
                            'step' => 5
                        ]
                    ],
                    'selectors'    => [
                        '{{WRAPPER}} .cms-slider-desc' => 'max-width: {{SIZE}}{{UNIT}};',
                    ]
                ]
            );
            $widget->add_control(
                'description_animation',
                [
                    'label'              => esc_html__('Animation', 'allianz'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'description_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'allianz'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 700,
                    'frontend_available' => true,
                ]
            );
            allianz_add_hidden_device_controls($widget, ['prefix' => 'desc_']);
        $widget->end_controls_section();
        // Description Style Section End

        // Button Primary Style Section Start
        $widget->start_controls_section(
            'button_primary_style_section',
            [
                'label' => esc_html__('Button Primary', 'allianz'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'button_primary_animation',
            [
                'label'              => esc_html__('Animation', 'allianz'),
                'type'               => Controls_Manager::ANIMATION,
                'default'            => 'fadeInLeft',
                'frontend_available' => true,
            ]
        );

        $widget->add_control(
            'button_primary_animation_delay',
            [
                'label'              => esc_html__('Animation Delay', 'allianz'),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 50,
                'step'               => 50,
                'default'            => 800,
                'frontend_available' => true,
            ]
        );
        allianz_add_hidden_device_controls($widget, ['prefix' => 'btn1_']);
        $widget->end_controls_section();
        // Button Primary Style Section End

        // Button Secondary Style Section Start
        $widget->start_controls_section(
            'button_secondary_style_section',
            [
                'label' => esc_html__('Button Secondary', 'allianz'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'button_secondary_animation',
            [
                'label'              => esc_html__('Animation', 'allianz'),
                'type'               => Controls_Manager::ANIMATION,
                'default'            => 'fadeInLeft',
                'frontend_available' => true,
            ]
        );

        $widget->add_control(
            'button_secondary_animation_delay',
            [
                'label'              => esc_html__('Animation Delay', 'allianz'),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 50,
                'step'               => 50,
                'default'            => 900,
                'frontend_available' => true,
            ]
        );
        allianz_add_hidden_device_controls($widget, ['prefix' => 'btn2_']);
        $widget->end_controls_section();
        // Button Secondary Style Section End

        // Button Video Style Section Start
        $widget->start_controls_section(
            'button_video_style_section',
            [
                'label' => esc_html__('Button Video', 'allianz'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'button_video_animation',
            [
                'label'              => esc_html__('Animation', 'allianz'),
                'type'               => Controls_Manager::ANIMATION,
                'default'            => 'fadeInLeft',
                'frontend_available' => true,
            ]
        );

        $widget->add_control(
            'button_video_animation_delay',
            [
                'label'              => esc_html__('Animation Delay', 'allianz'),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 50,
                'step'               => 50,
                'default'            => 1000,
                'frontend_available' => true,
            ]
        );
        allianz_add_hidden_device_controls($widget, ['prefix' => 'btn_video_']);
        $widget->end_controls_section();
        // Carousel Settings
        $widget->start_controls_section(
            'carousel_section',
            [
                'label'     => esc_html__('Carousel Settings', 'allianz'),
                'tab'       => Controls_Manager::TAB_SETTINGS
            ]
        );
            $widget->add_responsive_control(
                'slides_height',
                [
                    'label'   => esc_html__( 'Slider Height', 'allianz' ),
                    'type'    => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '780',
                        'unit' => 'px' 
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-eslider' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'size_units' => [ 'px', 'vh'],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 2000,
                        ],
                        'vh' => [
                            'min' => 20,
                            'max' => 100,
                        ],
                    ],
                ]
            );
            $slides_to_show = range(1, 3);
            $slides_to_show = array_combine($slides_to_show, $slides_to_show);
            $widget->add_responsive_control(
                'slides_to_show',
                [
                    'label'   => esc_html__('Slides to Show', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                            '' => esc_html__('Default', 'allianz'),
                        ] + $slides_to_show,
                    'default'        => '1',
                    'tablet_default' => '1',
                    'mobile_default' => '1',
                    'frontend_available' => true
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
                    'frontend_available' => true
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
                        'size' => 30,
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
                    'label'              => esc_html__('Show Arrows', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'dots',
                [
                    'label'              => esc_html__('Show Dots', 'allianz'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'dots_type',
                [
                    'label'              => esc_html__('Dots Type', 'allianz'),
                    'type'               => Controls_Manager::SELECT,
                    'options'            => [
                        'progressbar'      => esc_html__('Progressbar','allianz'),
                        'bullets'          => esc_html__('Dots','allianz'),
                        'circle'           => esc_html__('Dots Circle','allianz'),
                        'number'           => esc_html__('Number','allianz'),
                        'fraction'         => esc_html__('Fraction (Current/Total)','allianz'),
                        'current-of-total' => esc_html__('Current of Total', 'allianz'),
                        'custom'           => esc_html__('Custom','allianz')
                    ],
                    'default'            => 'bullets',
                    'frontend_available' => true,
                    'condition' => [
                        'dots' => 'yes'
                    ]
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
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'frontend_available' => true,
                ]
            );

            $widget->add_control(
                'pause_on_hover',
                [
                    'label' => esc_html__('Pause on Hover', 'allianz'),
                    'type' => Controls_Manager::SWITCHER,
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
                    'type' => Controls_Manager::SWITCHER,
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
                    'type' => Controls_Manager::SWITCHER,
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
