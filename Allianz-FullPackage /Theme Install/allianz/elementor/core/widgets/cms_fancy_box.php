<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_fancy_box_register_controls')) {
    add_action('etc_widget_cms_fancy_box_register_controls', 'allianz_widget_cms_fancy_box_register_controls', 10, 1);
    function allianz_widget_cms_fancy_box_register_controls($widget)
    {
        // Layout Section Start
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'allianz'),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );
            $widget->add_responsive_control(
                'text_align',
                [
                    'label'        => esc_html__( 'Text Alignment', 'allianz' ),
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
            allianz_elementor_responsive_flex_alignment($widget,[
                'name'  => 'item_align',
                'label' => esc_html__( 'Items Alignment', 'allianz' )
            ]);
            $widget->add_control(
                'layout',
                [
                    'label'   => esc_html__('Templates', 'allianz'),
                    'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                    'default' => '1',
                    'options' => [
                        '1' => [
                            'label' => esc_html__('Layout 1', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_fancy_box/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__('Layout 2', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_fancy_box/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__('Layout 3', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_fancy_box/layout/3.webp'
                        ],
                        '4' => [
                            'label' => esc_html__('Layout 4', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_fancy_box/layout/4.webp'
                        ],
                        '5' => [
                            'label' => esc_html__('Layout 5', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_fancy_box/layout/5.webp'
                        ],
                        '6' => [
                            'label' => esc_html__('Layout 6', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_fancy_box/layout/6.webp'
                        ],
                        '7' => [
                            'label' => esc_html__('Layout 7', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_fancy_box/layout/7.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Icon Section Start
        $widget->start_controls_section(
            'fancy_box_section',
            [
                'label' => esc_html__('Fancy Box', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $fancy_box = new Repeater();
            // icon
            allianz_elementor_icon_image_settings($fancy_box, ['group' => false, 'img_size' => false]);
            // title
            $fancy_box->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the heading', 'allianz'),
                    'placeholder' => esc_html__('Enter your title', 'allianz'),
                    'label_block' => true
                ]
            );
            $fancy_box->add_control(
                'description',
                [
                    'label'       => esc_html__('Description', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your description', 'allianz'),
                    'rows'        => 10,
                    'show_label'  => true
                ]
            );
            $fancy_box->add_control(
                'btn_text',
                [
                    'label'       => esc_html__('Link Settings', 'allianz'),
                    'description' => esc_html__('Link Text','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '',  
                    'label_block' => true
                ]
            );
            $fancy_box->add_control(
                'btn_link_type',
                [
                    'label'   => esc_html__('Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        //'btn_text!'     => ''
                    ]
                ]
            );
            $fancy_box->add_control(
                'btn_page_link',
                [
                    'label'     => esc_html__('Select Page', 'allianz'),
                    'type'      => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        //'btn_text!'     => '',
                        'btn_link_type' => 'page'
                    ]
                ]
            );
            $fancy_box->add_control(
                'btn_link',
                [
                    'label'     => esc_html__('Custom Link', 'allianz'),
                    'type'      => Controls_Manager::URL,
                    'condition' => [
                        //'btn_text!'     => '',
                        'btn_link_type' => 'custom'
                    ]
                ]
            );
            $widget->add_control(
                'fancy_box',
                [
                    'label'       => esc_html__('Fancy Box','allianz'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $fancy_box->get_controls(),
                    'title_field' => '{{title}}',
                    'default' => [
                        [
                            'icon_type' => 'icon',
                            'selected_icon'      => [
                                'library' => 'cmsi',
                                'value'   => 'cmsi-alert'  
                            ],
                            'title' => 'This is Heading'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Style Section Start
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            // Grid Columns
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
                        '5' => '5',
                        '6' => '6',
                    ]
                ]
            );
            // Icon
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_color',
                'label'     => esc_html__( 'Icon Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-icon' => 'color: {{VALUE}};'
                ]
            ]);
            // Title
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'    => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};'
                ],
                'separator' => 'before',
            ]);
            // Description
            allianz_elementor_colors_opts($widget,[
                'name'     => 'description_color',
                'label'    => esc_html__( 'Description Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};'
                ],
                'separator' => 'before',
            ]);
            // Button
            allianz_elementor_colors_opts($widget,[
                'name'     => 'btn_color',
                'label'    => esc_html__( 'Button Text Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-fancy-btn' => 'color: {{VALUE}};border-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'btn_hover_color',
                'label'    => esc_html__( 'Button Text Hover Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-fancy-btn:hover' => 'color: {{VALUE}};border-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'btn_bg_color',
                'label'    => esc_html__( 'Button Background Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-fancy-btn' => 'background-color: {{VALUE}};border-color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'layout' => ['x']
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'btn_bg_hover_color',
                'label'    => esc_html__( 'Button Background Hover Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-fancy-btn:hover' => 'background-color: {{VALUE}};border-color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'layout' => ['x']
                ]
            ]);
            // Background color
            allianz_elementor_colors_opts($widget,[
                'name'     => 'bg_color',
                'label'    => esc_html__( 'Background Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-fancybox' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'layout' => ['x']
                ]
            ]);
            // Background Hover color
            allianz_elementor_colors_opts($widget,[
                'name'     => 'bg_hover_color',
                'label'    => esc_html__( 'Background Hover Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-fancybox:hover' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'layout' => ['x']
                ]
            ]);
        $widget->end_controls_section();
    }
}
