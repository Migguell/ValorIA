<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if (!function_exists('allianz_widget_cms_accordion_scroll_register_controls')) {
    add_action('etc_widget_cms_accordion_scroll_register_controls', 'allianz_widget_cms_accordion_scroll_register_controls', 10, 1);
    function allianz_widget_cms_accordion_scroll_register_controls($widget)
    {
        // Layout Section Start
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'allianz'),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );
            $widget->add_control(
                'scroll_mode',
                [
                    'label'   => esc_html__( 'Scroll Mode', 'allianz' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'horizontal',
                    'options' => [
                        'horizontal' => esc_html__('Horizontal', 'allianz'),
                        'vertical'   => esc_html__('Vertical', 'allianz'),
                    ],
                    'condition' => [
                        'layout' => ['2']
                    ]
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
                            'label' => esc_html__( 'Layout 1 (just css sticky)', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion_scroll/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion_scroll/layout/1.webp'
                        ],
                        'stack' => [
                            'label' => esc_html__( 'Layout Stack', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion_scroll/layout/1.webp'
                        ],
                        '-sticky' => [
                            'label' => esc_html__( 'Layout Sticky', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion_scroll/layout/1.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // accordion Section Start
        $widget->start_controls_section(
            'section_cms_accordion_scroll',
            [
                'label' => esc_html__('Accordion Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'active_section',
                [
                    'label'     => esc_html__( 'Active section', 'allianz' ),
                    'type'      => Controls_Manager::NUMBER,
                    'default'   => '1',
                    'min'       => '0',
                    'max'       => '50',
                    'separator' => 'after',
                ]
            );
            $repeater = new Repeater();
            $repeater->add_control(
                'ac_title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Title',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => true
                ]
            );
            $repeater->add_control(
                'ac_content_heading',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'content_classes' => 'cms-panel-alert elementor-panel-alert-warning',
                    'raw'             => esc_html__( 'Content Settings', 'allianz' )
                ]
            );
            $repeater->add_control(
                'ac_icon',
                [
                    'label'       => esc_html__( 'Icon', 'allianz' ),
                    'type'        => Controls_Manager::ICONS,
                    'default'     => [
                        'library' => 'allianz-icon',
                        'value'   => 'allianz-icon-up-arrow-right'
                    ],
                    'skin'        => 'inline',
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'ac_content',
                [
                    'label'           => esc_html__('Description', 'allianz'),
                    'type'            => Controls_Manager::TEXTAREA,
                    'default'         => 'Item content. Click the edit button to change this text.',
                    'placeholder'     => esc_html__( 'Enter your content', 'allianz' ),
                    'label_block'     => false,
                    'content_classes' => 'fudckfuck'
                ]
            );
            $repeater->add_control(
                'feature_content_heading',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'content_classes' => 'cms-panel-alert elementor-panel-alert-warning',
                    'raw'             => esc_html__( 'Feature Settings', 'allianz' )
                ]
            );
            // Feature #1
            $repeater->add_control(
                'ac_feature_icon_1',
                [
                    'label'       => esc_html__( 'Feature #1 Icon', 'allianz' ),
                    'type'        => Controls_Manager::ICONS,
                    'default'     => [],
                    'skin'        => 'inline',
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'ac_feature_title_1',
                [
                    'label'       => esc_html__( 'Feature #1 Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Title',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'ac_feature_desc_1',
                [
                    'label'       => esc_html__( 'Feature #1 Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Title',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => false
                ]
            );
            // Feature #2
            $repeater->add_control(
                'ac_feature_icon_2',
                [
                    'label'       => esc_html__( 'Feature #2 Icon', 'allianz' ),
                    'type'        => Controls_Manager::ICONS,
                    'default'     => [],
                    'skin'        => 'inline',
                    'label_block' => false,
                    'separator'   => 'before'
                ]
            );
            $repeater->add_control(
                'ac_feature_title_2',
                [
                    'label'       => esc_html__( 'Feature #2 Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Title',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'ac_feature_desc_2',
                [
                    'label'       => esc_html__( 'Feature #2 Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Title',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => false
                ]
            );
            // Feature #3
            $repeater->add_control(
                'ac_feature_icon_3',
                [
                    'label'       => esc_html__( 'Feature #3 Icon', 'allianz' ),
                    'type'        => Controls_Manager::ICONS,
                    'default'     => [],
                    'skin'        => 'inline',
                    'label_block' => false,
                    'separator'   => 'before'
                ]
            );
            $repeater->add_control(
                'ac_feature_title_3',
                [
                    'label'       => esc_html__( 'Feature #3 Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Title',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'ac_feature_desc_3',
                [
                    'label'       => esc_html__( 'Feature #3 Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Title',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => false
                ]
            );
            // Link & Button
            $repeater->add_control(
                'btn_heading_1',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'content_classes' => 'cms-panel-alert elementor-panel-alert-warning',
                    'raw'             => esc_html__( 'Link #1', 'allianz' )
                ]
            );
            $repeater->add_control(
                'link1_text',
                [
                    'label'       => esc_html__( 'Link #1 Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Find Your Advisor',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'separator' => 'before'
                ]
            );
            $repeater->add_control(
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
            $repeater->add_control(
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
            $repeater->add_control(
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
            allianz_elementor_colors_opts($repeater,[
                'name'      => 'link1_color',
                'label'     => esc_html__( 'Link #1 Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($repeater,[
                'name'   => 'link1_color_hover',
                'label'  => esc_html__( 'Link #1 Color Hover', 'allianz' ),
                'custom' => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            // Link 2
            $repeater->add_control(
                'btn_heading_2',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'content_classes' => 'cms-panel-alert elementor-panel-alert-warning',
                    'raw'             => esc_html__( 'Link #2', 'allianz' )
                ]
            );
            $repeater->add_control(
                'link2_text',
                [
                    'label'       => esc_html__( 'Link Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Learn More',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'separator'   => 'before'
                ]
            );
            $repeater->add_control(
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
            $repeater->add_control(
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
            $repeater->add_control(
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
            allianz_elementor_colors_opts($repeater,[
                'name'      => 'link2_color',
                'label'     => esc_html__( 'Link#2 Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link2_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($repeater,[
                'name'   => 'link2_color_hover',
                'label'  => esc_html__( 'Link#2 Color Hover', 'allianz' ),
                'custom' => false,
                'condition' => [
                    'link2_text!' => ''
                ]
            ]);
            // Banner & Counter
            $repeater->add_control(
                'bc_heading',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'content_classes' => 'cms-panel-alert elementor-panel-alert-warning',
                    'raw'             => esc_html__( 'Banner & Counter', 'allianz' )
                ]
            );
            $repeater->add_control(
                'ac_bc_banner',
                [
                    'label'       => esc_html__( 'Banner', 'allianz' ),
                    'type'        => Controls_Manager::MEDIA,
                    'default'     => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'ac_bc_counter',
                [
                    'label'       => esc_html__( 'Counter Number', 'allianz' ),
                    'type'        => Controls_Manager::NUMBER,
                    'default'     => '50',
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'ac_bc_desc',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Maximum drawdown is a measure of downside risk over a given time period; it is the maximum loss.',
                    'label_block' => false
                ]
            );
            // Background Settings
            $repeater->add_control(
                'bg_section',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'content_classes' => 'cms-panel-alert elementor-panel-alert-warning',
                    'raw'             => esc_html__( 'Background Settings', 'allianz' )
                ]
            );
            allianz_elementor_colors_opts($repeater,[
                'name'     => 'bg_color',
                'label'    => esc_html__( 'Background Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};'
                ]
            ]);
            // Add Items
            $widget->add_control(
                'cms_accordion_scroll',
                [
                    'label'       => esc_html__('List', 'allianz'),
                    'label_block' => true,
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $repeater->get_controls(),
                    'default' => [
                        [
                            'ac_icon'          => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-up-right-arrow'
                            ], 
                            'ac_title'         => 'Financial Planning',
                            'ac_content'       => 'Financial planning is the process of taking a comprehensive look at your financial situation and building a specific financial plan to reach your goals. As a result, financial planning often delves into multiple areas of finance, including taxes, savings, retirement, your estate, insurance and more.',
                            //
                            'ac_feature_icon_1' => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-evaluation'
                            ],
                            'ac_feature_title_1' => 'Tax Planning',
                            'ac_feature_desc_1'  => 'Our financial planners help clients address certain tax issues and figure out how to maximize your tax refunds and minimize your tax liability.',
                            //
                            'ac_feature_icon_2'  => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-business-meeting'
                            ],
                            'ac_feature_title_2' => 'Retirement Planning',
                            'ac_feature_desc_2'  => 'We provide retirement planning services which will help you prepare for that day. Our consultants will make sure that you’ve saved enough money to live your lifestyle.',
                            //
                            'ac_feature_icon_3'  => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-goal'
                            ],
                            'ac_feature_title_3' => 'Investment Planning',
                            'ac_feature_desc_3'  => 'Our consultants will help you estimate your investment portfolio by mapping out how much you should be investing and in which types of investments.',
                            //
                            'ac_bc_counter' => '89',
                            'ac_bc_desc'    => 'Personalized business development reports that help reveal gaps & chances in your practice.',
                            //
                            'bg_color' => 'secondary-regular'
                        ],
                        [
                            'ac_icon'          => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-up-right-arrow'
                            ],
                            'ac_title'         => 'Wealth Management',
                            'ac_content'       => 'Wealth management is an investment advisory practice focused on serving the unique needs of wealthy individuals. The practice incorporates wide range of services, including financial planning and investment management, to manage significant amounts of wealth in a comprehensive fashion.',
                            'ac_feature_icon_1'  => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-advanced-training'
                            ],
                            'ac_feature_title_1' => 'Risk Management',
                            'ac_feature_desc_1'  => 'You can hire a financial advisor to help you manage your own wealth, especially if you don’t classify as a high net worth individual, no worries we will help you.',
                            //
                            'ac_feature_icon_2'  => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-consultant'
                            ],
                            'ac_feature_title_2' => 'Social Security Benefits',
                            'ac_feature_desc_2'  => 'The benefit is based on their spouse’s contributions to Social Security and is capped at 50% of their benefit amount at full retirement age.',
                            //
                            'ac_feature_icon_3'  => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-financial-profit'
                            ],
                            'ac_feature_title_3' => 'Estate Planning',
                            'ac_feature_desc_3'  => 'For the average individual contemplating estate planning for the first time, it’s not always clear which assets should be covered in a plan and how their distribution.',
                            //
                            'ac_bc_counter' => '62',
                            'ac_bc_desc'    => 'Multiple plan solutions make it easy to scale your practice and meet all our clients’ needs.',
                            //
                            'bg_color' => 'secondary-lighten'
                        ],
                        [
                            'ac_icon'          => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-up-right-arrow'
                            ],
                            'ac_title'         => 'Portfolio Consulting',
                            'ac_content'       => 'Customization, control and tax efficiency are important to many investors. That’s why we offer separately managed accounts for a diverse range of investment objectives. Learn how they can help you deliver more for your clients. Find unique customizable solutions for your portfolio from a range of',
                            'ac_feature_icon_1'  => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-advice'
                            ],
                            'ac_feature_title_1' => 'Portfolio Solutions',
                            'ac_feature_desc_1'  => 'Investments that seek to provide superior long term results, combined with an objective based approach, can be the foundation of your clients\' portfolios.',
                            //
                            'ac_feature_icon_2'  => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-strategy'
                            ],
                            'ac_feature_title_2' => 'Model Portfolio Returns',
                            'ac_feature_desc_2'  => 'Model portfolios offer multiple approaches to help clients pursue their investment objectives while freeing you to spend more time cultivating those relationships.',
                            //
                            'ac_feature_icon_3'  => [
                                'library' => 'allianz-icon',
                                'value'   => 'allianz-icon-advice1'
                            ],
                            'ac_feature_title_3' => 'Portfolio Analytics',
                            'ac_feature_desc_3'  => 'Our analyses examine diversification opportunities, objective risks, manager evaluations and stress testing, all from a team of dedicated supported consultants.',
                            //
                            'ac_bc_counter' => '23',
                            'ac_bc_desc'    => 'Maximum drawdown is a measure of downside risk over a given time period; it is the maximum loss.',
                            //
                            'bg_color' => 'secondary-lighten2'
                        ]
                    ],
                    'title_field' => '{{{ ac_title }}}',
                ]
            );
        $widget->end_controls_section(); // accordion Section End
        //  Style tab
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings','allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'    => esc_html__( 'Accordion Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-accordion-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_active_color',
                'label'    => esc_html__( 'Accordion Active Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-accordion-title:hover, {{WRAPPER}} .cms-accordion-title:active' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'content_color',
                'label'    => esc_html__( 'Accordion Content Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-accordion-content' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]);
        $widget->end_controls_section();
    }
}
