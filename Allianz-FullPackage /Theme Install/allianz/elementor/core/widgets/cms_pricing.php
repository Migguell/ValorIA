<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if (!function_exists('allianz_widget_cms_pricing_register_controls')) {
    add_action('etc_widget_cms_pricing_register_controls', 'allianz_widget_cms_pricing_register_controls', 10, 1);
    function allianz_widget_cms_pricing_register_controls($widget)
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
                'actived',
                [
                    'label' => esc_html__('Actived?','allianz'),
                    'type'  => Controls_Manager::SWITCHER,
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_pricing/layout/1.webp'
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
            $widget->add_control(
                'badge_text',
                [
                    'label'       => esc_html__( 'Badge Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'BEST VALUE',
                    'label_block' => false,
                    'separator'   => 'after'
                ]
            );
            $widget->add_control(
                'price',
                [
                    'label'       => esc_html__( 'Price', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '$150',
                    'label_block' => true,
                    'separator'   => false,
                    'dynamic'     => [
                        'active' => true,
                    ]
                ]
            );
            $widget->add_control(
                'price_pack',
                [
                    'label'       => esc_html__( 'Price Pack', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '/Mo',
                    'label_block' => false,
                    'separator'   => 'after',
                    'dynamic'     => [
                        'active' => true,
                    ],
                    'condition' => [
                        'price!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'cms_icon',
                [
                    'label'            => esc_html__( 'Icon', 'allianz' ),
                    'type'             => Controls_Manager::ICONS,
                    'default'          => [
                        'value'   => 'cmsi-star',
                        'library' => 'cmsi',
                    ],
                ]
            );
            $widget->add_control(
                'subheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__( 'Enter your small title', 'allianz' ),
                    'label_block' => true,
                    'dynamic' => [
                        'active' => true,
                    ]
                ]
            );
            $widget->add_control(
                'heading_text',
                [
                    'label'       => esc_html__( 'Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__( 'Starter Plan', 'allianz' ),
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'description_text_bold',
                [
                    'label'       => esc_html__( 'Description (Bold)', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__( 'Enter your description', 'allianz' ),
                    'rows'        => 10,
                    'show_label'  => true,
                    'separator' => 'before'
                ]
            );
            $widget->add_control(
                'description_text',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__( 'Enter your description', 'allianz' ),
                    'rows'        => 10,
                    'show_label'  => true,
                    'separator' => 'before'
                ]
            );
        $widget->end_controls_section();
        // Link 1
        $widget->start_controls_section('link1_section',[
            'label' => esc_html__('Link #1', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT
        ]);
            $widget->add_control(
                'link1_text',
                [
                    'label'       => esc_html__( 'Link Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Get Started Now',
                    'placeholder' => esc_html__( 'Get Started Now', 'allianz' ),
                    'separator'   => 'before'
                ]
            );
            $widget->add_control(
                'link1_type',
                [
                    'label'   => esc_html__('Link Type', 'allianz'),
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
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_color',
                'label'     => esc_html__('Link Color', 'allianz'),
                'custom'    => false,
                'default'   => 'accent',
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_hover',
                'label'     => esc_html__('Link Color', 'allianz'),
                'custom'    => false,
                'default'   => 'primary',
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Link 2
        $widget->start_controls_section('link2_section',[
            'label' => esc_html__('Link #2', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);
            $widget->add_control(
                'link2_text',
                [
                    'label'       => esc_html__( 'Link Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '',
                    'placeholder' => esc_html__( 'Contact Us', 'allianz' ),
                    'separator' => 'before'
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
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link2_color',
                'label'     => esc_html__('Link Color', 'allianz'),
                'custom'    => false,
                'default'   => 'white',
                'condition' => [
                    'link2_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link2_hover',
                'label'     => esc_html__('Link Color', 'allianz'),
                'custom'    => false,
                'default'   => 'white',
                'condition' => [
                    'link2_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Features
        $widget->start_controls_section('features_section',[
            'label' => esc_html__('Features Settings', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT
        ]);
            $repeater = new Repeater();
            $repeater->add_control(
                'icon',
                [
                    'label'       => esc_html__( 'Icon', 'allianz' ),
                    'default'     => [
                        'library'   => 'cmsi',
                        'value'     => 'cmsi-check-thin'
                    ],
                    'type'        => Controls_Manager::ICONS,
                    'skin'        => 'inline',
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'default'     => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true,
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
                            'icon'  => [
                                'library'   => 'cmsi',
                                'value'     => 'cmsi-check-thin'
                            ],
                            'title' => 'Enterprise Network Video Recorders',
                        ],
                        [
                            'icon'  => [
                                'library'   => 'cmsi',
                                'value'     => 'cmsi-check-thin'
                            ],
                            'title' => 'Intelligent video technology storage',
                        ],
                        [
                            'icon'  => [
                                'library'   => 'cmsi',
                                'value'     => 'cmsi-check-thin'
                            ],
                            'title' => 'Streaming over network or Internet',
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'feature_text_color',
                'label'    => esc_html__( 'Text Color', 'allianz' ),
                'custom'   => false 
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'feature_icon_color',
                'label'    => esc_html__( 'Icon Color', 'allianz' ),
                'custom'   => false 
            ]);
        $widget->end_controls_section();
        // Banner
        $widget->start_controls_section('banner_section',[
            'label' => esc_html__('Banner', 'allianz'),
            'tab'   => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'layout' => ['2']
            ]
        ]);
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
                        'banner[url]!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'banner_gradient',
                [
                    'label'        => esc_html__( 'Gradient Style', 'allianz' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => allianz_elementor_gradient_opts(),
                    'default'   => '',
                    'separator' => 'before',
                    'condition' => [
                        'banner[url]!' => ''
                    ]
                ]
            );
        $widget->end_controls_section();
    }
}
