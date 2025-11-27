<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_banner_register_controls')) {
    add_action('etc_widget_cms_banner_register_controls', 'allianz_widget_cms_banner_register_controls', 10, 1);
    function allianz_widget_cms_banner_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_banner/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_banner/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_banner/layout/3.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Banner
        $widget->start_controls_section(
            'section_single_image',
            [
                'label' => esc_html__('Banner Image', 'allianz'),
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
                    'label'   => esc_html__('Image Size','allianz'),
                    'default' => 'custom',
                    //'exclude' => ['thumbnail','trp-custom-language-flag','woocommerce_gallery_thumbnail']
                ]
            );
            $widget->add_control(
                'small_banner',
                [
                    'label'   => esc_html__( 'Small Banner', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'condition' => [
                        'layout' => ['6','7']
                    ]
                ]
            );
            $widget->add_control(
                'small_banner2',
                [
                    'label'   => esc_html__( 'Small Banner #2', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'condition' => [
                        'layout' => ['6','7']
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
                'condition' => [
                    'layout' => ['2','3','4','5']
                ]
            ]
        );
            $widget->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is small heading',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true,
                    'condition' => [
                        'layout' => ['3','4','5']
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
                    'layout' => ['3','4','5'],
                    'smallheading_text!' => ''
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
                    '{{WRAPPER}} .cms-heading, {{WRAPPER}} .cms-heading a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);
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
                        'layout' => ['3','4','5']
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
                    'layout' => ['3','4','5'],
                    'description_text!' => ''
                ]
            ]);
            // Link #1
            $widget->add_control(
                'link1_text',
                [
                    'label'       => esc_html__( 'Link #1 Text', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Click Here',
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
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_text_color',
                'label'     => esc_html__( 'Link #1 Text Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_color',
                'label'     => esc_html__( 'Link #1 Background Color', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'      => 'link1_text_color_hover',
                'label'     => esc_html__( 'Link #1 Text Color Hover', 'allianz' ),
                'custom'    => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'   => 'link1_color_hover',
                'label'  => esc_html__( 'Link #1 Background Color Hover', 'allianz' ),
                'custom' => false,
                'condition' => [
                    'link1_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Style Settings
        $widget->start_controls_section(
            'style_section',
            [
                'label'     => esc_html__('Banner Settings','allianz'),
                'tab'       => Controls_Manager::TAB_SETTINGS,
                'condition' => [
                    'layout' => ['1','3']
                ]
            ]
        );
            $widget->add_control(
                'as_background',
                [
                    'label'       => esc_html__('As Background', 'allianz'),
                    'description' => esc_html__('Make your banner show as background', 'allianz'),
                    'type'        => Controls_Manager::SWITCHER,
                    'return_value'=> 'yes' 
                ]
            );
            $widget->add_control(
                'bg_pos',
                [
                    'label'       => esc_html__('Background Position', 'allianz'),
                    'type'        => Controls_Manager::SELECT,
                    'options'     => [
                        ''              => esc_html__('Default', 'allianz'),
                        'bg-center'     => esc_html__('Center', 'allianz'),
                        'bg-top-center' => esc_html__('Top Center', 'allianz')
                    ],
                    'condition' => [
                        'as_background' => ['yes']
                    ]
                ]
            );
            $widget->add_control(
                'max_height',
                [
                    'label'       => esc_html__('Max Height', 'allianz'),
                    'description' => esc_html__('Add image max-height', 'allianz'),
                    'type'        => Controls_Manager::SWITCHER,
                    'return_value'=> 'yes' 
                ]
            );
            $widget->add_control(
                'custom_class',
                [
                    'label'       => esc_html__('CSS Classes', 'allianz'),
                    'description' => esc_html__('Add custom css class', 'allianz'),
                    'type'        => Controls_Manager::TEXT
                ]
            );
        $widget->end_controls_section();
    }
}
