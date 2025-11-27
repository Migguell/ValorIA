<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if (!function_exists('allianz_widget_cms_accordion_register_controls')) {
    add_action('etc_widget_cms_accordion_register_controls', 'allianz_widget_cms_accordion_register_controls', 10, 1);
    function allianz_widget_cms_accordion_register_controls($widget)
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
                'layout',
                [
                    'label'   => esc_html__( 'Templates', 'allianz' ),
                    'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
                    'default' => '1',
                    'options' => [
                        '1' => [
                            'label' => esc_html__( 'Layout 1', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion/layout/2.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // accordion Section Start
        $widget->start_controls_section(
            'section_cms_accordion',
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
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Title',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'ac_content',
                [
                    'label'       => esc_html__( 'Content', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'default'     => 'Item content. Click the edit button to change this text.',
                    'placeholder' => esc_html__( 'Enter your content', 'allianz' ),
                    'label_block' => true,
                ]
            );
            $widget->add_control(
                'cms_accordion',
                [
                    'label' => esc_html__('Accordion Lists', 'allianz'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'ac_title'   => 'Title',
                            'ac_content' => 'Item content. Click the edit button to change this text.',
                        ],
                        [
                            'ac_title'   => 'Title',
                            'ac_content' => 'Item content. Click the edit button to change this text.',
                        ],
                    ],
                    'title_field' => '{{{ ac_title }}}',
                ]
            );
        $widget->end_controls_section(); // accordion Section End
        // Heading Section Start
        $widget->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading Settings', 'allianz'),
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
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['1']
                    ]                    
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'smallheading_color',
                'label'     => esc_html__( 'Small Heading Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-smallheading' => 'color: {{VALUE}};',
                ],
                'separator'   => 'after',
                'condition'   => [
                    'smallheading_text!' => '',
                    'layout' => ['1']
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
                'label'    => esc_html__( 'Heading Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-heading' => 'color: {{VALUE}};',
                ],
                'separator'   => 'after'
            ]);
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
                'label'     => esc_html__( 'Description Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Button
        $widget->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
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
