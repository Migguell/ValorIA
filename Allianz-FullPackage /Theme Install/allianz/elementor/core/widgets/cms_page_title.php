<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if (!function_exists('allianz_widget_cms_page_title_register_controls')) {
    add_action('etc_widget_cms_page_title_register_controls', 'allianz_widget_cms_page_title_register_controls', 10, 1);
    function allianz_widget_cms_page_title_register_controls($widget)
    {
        // Layout Tab Start

        // Layout Section Start
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'allianz'),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );
            $widget->add_control('header_transparent', [
                'label'              => esc_html__('Header Transparent', 'allianz'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => '',
                'prefix_class'       => 'cms-eptitle-header-transparent-',
                'description'        => esc_html__('Add more top space when have Header Transparent','allianz')   
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__('Layout 2', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__('Layout 3', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/3.webp'
                        ],
                        '4' => [
                            'label' => esc_html__('Layout 4', 'allianz'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/4.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Icon Section Start
        $widget->start_controls_section(
            'page_title_section',
            [
                'label' => esc_html__('Content Setting', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout!' => ['4']
                ]
            ]
        );
            $widget->add_control(
                'small_title',
                [
                    'label'       => esc_html__('Small Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your small title', 'allianz'),
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your title', 'allianz'),
                    'label_block' => true,
                ]
            );
            $widget->add_control(
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
        $widget->end_controls_section();
        // Button
        $widget->start_controls_section(
            'section_btn',
            [
                'label' => esc_html__('Button Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'   => [
                    'layout' => ['1']
                ]
            ]
        );
            $widget->add_control(
                'link_text',
                [
                    'label'       => esc_html__('Button #1', 'allianz'),
                    'description' => esc_html__('Button Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'link_type',
                [
                    'label'   => esc_html__('Button Link Type', 'allianz'),
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
                    'multiple' => false,
                    'condition' => [
                        'link_text!'     => '',
                        'link_type' => 'page'
                    ],
                ]
            );
            $widget->add_control(
                'custom_link',
                [
                    'label'   => esc_html__('Button Link', 'allianz'),
                    'type'    => Controls_Manager::URL,
                    'condition' => [
                        'link_text!'     => '',
                        'link_type' => 'custom'
                    ]
                ]
            );
            // Button #2
            $widget->add_control(
                'link2_text',
                [
                    'label'       => esc_html__('Button #2', 'allianz'),
                    'description' => esc_html__('Button Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'link2_type',
                [
                    'label'   => esc_html__('Button Link Type', 'allianz'),
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
                'page2_link',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple' => false,
                    'condition' => [
                        'link2_text!'     => '',
                        'link2_type' => 'page'
                    ],
                ]
            );
            $widget->add_control(
                'custom2_link',
                [
                    'label'   => esc_html__('Button Link', 'allianz'),
                    'type'    => Controls_Manager::URL,
                    'condition' => [
                        'link2_text!'     => '',
                        'link2_type' => 'custom'
                    ]
                ]
            );
        $widget->end_controls_section();
        // Video
        $widget->start_controls_section(
            'section_video',
            [
                'label' => esc_html__('Video Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'   => [
                    'layout' => ['1']
                ]
            ]
        );
            $widget->add_control(
                'video_link',
                [
                    'label'       => esc_html__( 'Video URL', 'allianz' ),
                    'subtitle'    => esc_html__('Video url from  YouTube/Vimeo/Dailymotion','allianz'),
                    'description' => 'https://www.youtube.com/watch?v=iYf3OgEdGmo',
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'default'     => '',
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'video_icon',
                [
                    'label'   => esc_html__( 'Video Icon', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::ICONS,
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
                    'type'     => \Elementor\Controls_Manager::TEXTAREA,
                    'default'  => '',
                    'condition' => [
                        'video_link!' => ''
                    ],
                    'label_block' => false
                ]
            );
        $widget->end_controls_section();
        // Background 
        $widget->start_controls_section(
            'section_background',
            [
                'label' => esc_html__('Background Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $widget->add_control(
                'bg_image',
                [
                    'label'       => esc_html__('Background Image', 'allianz'),
                    'type'        => Controls_Manager::MEDIA,
                    'description' => esc_html__('Select image icon.', 'allianz'),
                    'default'     => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
            $widget->add_control(
                'bg_pos',
                [
                    'label'   => esc_html__('Background Position', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'top center'    => esc_html__('Top Center','allianz'),
                        'center center' => esc_html__('Center Center','allianz'),
                        'bottom center' => esc_html__('Bottom Center','allianz'),
                    ],
                    'default'      => 'top center'
                ]
            );
            $widget->add_control(
                'bg_overlay',
                [
                    'label'   => esc_html__('Overlay', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''  => esc_html__('None','allianz'),
                        '1' => esc_html__('Gradient #1','allianz'),
                    ],
                    'default'      => '1',
                    'prefix_class' => 'cms-eptitle-overlay-'
                ]
            );
            $widget->add_control(
                'shadow',
                [
                    'label'   => esc_html__( 'Shadow', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => ''
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-eptitle-overlay-shadow' => 'background-image:url({{URL}});'
                    ]
                ]
            );
        $widget->end_controls_section();
        // Breadcrumb 
        $widget->start_controls_section(
            'section_breadcrumb',
            [
                'label' => esc_html__('Breadcrumb Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $widget->add_control(
                'show_breadcrumb',
                [
                    'label'   => esc_html__('Show Breadcrumb','allianz'),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes'
                ]
            );
            $widget->add_control(
                'breadcrumb_style',
                [
                    'label'   => esc_html__('Breadcrumb Style','allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        '' => esc_html__('Default','allianz'),
                    ],
                    'separator' => 'before',
                    'condition' => [
                        'show_breadcrumb' => 'yes'
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'      => 'breadcrumb_color_hover',
                'label'     => esc_html__( 'Breadcrumb Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'show_breadcrumb' => 'yes'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'breadcrumb_text_color_hover',
                'label'     => esc_html__( 'Breadcrumbs Hover Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'show_breadcrumb' => 'yes'
                ]
            ]);
        $widget->end_controls_section();
        // Style Section Start
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_responsive_control(
                'content_align',
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
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'small_title_color',
                'label'    => esc_html__( 'Small Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-small-title' => 'color: {{VALUE}};'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'    => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'description_color',
                'label'    => esc_html__( 'Description Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn1_color',
                'label'     => esc_html__( 'Button #1 Color', 'allianz' ),
                'custom'    => false,
                'separator' => 'before'
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn1_text_color',
                'label'     => esc_html__( 'Button #1 Text Color', 'allianz' ),
                'custom'    => false
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn1_color_hover',
                'label'     => esc_html__( 'Button #1 Hover Color', 'allianz' ),
                'custom'    => false
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn1_text_color_hover',
                'label'     => esc_html__( 'Button #1 Text Hover Color', 'allianz' ),
                'custom'    => false
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn2_color',
                'label'     => esc_html__( 'Button #2 Color', 'allianz' ),
                'custom'    => false,
                'separator' => 'before'
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn2_text_color',
                'label'     => esc_html__( 'Button #2 Text Color', 'allianz' ),
                'custom'    => false,
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn2_color_hover',
                'label'     => esc_html__( 'Button #2 Hover Color', 'allianz' ),
                'custom'    => false
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'btn2_text_color_hover',
                'label'     => esc_html__( 'Button #2 Text Hover Color', 'allianz' ),
                'custom'    => false
            ]);
        $widget->end_controls_section();
    }
}
