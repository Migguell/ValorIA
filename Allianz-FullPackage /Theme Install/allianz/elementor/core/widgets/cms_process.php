<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if (!function_exists('allianz_widget_cms_process_register_controls')) {
    add_action('etc_widget_cms_process_register_controls', 'allianz_widget_cms_process_register_controls', 10, 1);
    function allianz_widget_cms_process_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/2.webp'
                        ],
                        '-sticky' => [
                            'label' => esc_html__( 'Layout Sticky', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/1.webp'
                        ],
                        '-2' => [
                            'label' => esc_html__( 'Layout 2+', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/2.webp'
                        ],
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
                'group' => false,
                'type'  => ''
            ]);
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
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since', 
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'rows'        => 10,
                    'show_label'  => true,
                    'condition' => [
                        'layout' => ['1','-sticky']
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
                    'layout'                 => ['1','-sticky'],
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
                        'layout' => ['1','-sticky']
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
                    'layout'            => ['1','-sticky'],
                    'description_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Process Section Start
        $widget->start_controls_section(
                'section_process',
                [
                    'label' => esc_html__('Process Content', 'allianz'),
                    'tab'   => Controls_Manager::TAB_CONTENT
                ]
            );

            $process = new Repeater();
            // Banner
            $process->add_control(
                'banner',
                [
                    'label'       => esc_html__('Banner', 'allianz'),
                    'type'        => Controls_Manager::MEDIA,
                    'description' => esc_html__('Select image.', 'allianz'),
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
            // Icon
            allianz_elementor_icon_image_settings($process, [
                'group'            => false,
                'img_default_size' => 'custom'
            ]);
            // Title
            $process->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'default'     => esc_html__( 'My Skill', 'allianz' ),
                    'label_block' => true,
                ]
            );
            // Description
            $process->add_control(
                'desc',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA
                ]
            );

            $widget->add_control(
                'process_list',
                [
                    'label'   => esc_html__('Process List', 'allianz'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $process->get_controls(),
                    'default' => [
                        [
                            'title' => 'Acknowledge needs and objectives',
                            'desc'  => 'We prepare for your meeting by identifying key milestones or events that have happened since we last met. Then we review your portfolios to see if they’re well positioned to meet',
                        ],
                        [
                            'title' => 'Provide a comprehensive long term perspective',
                            'desc'  => 'We ascertain our client’s financial outlook to determine whether they should seek investments weighted toward preservation of capital, a balance of income and appreciation, or growth.',
                        ],
                        [
                            'title' => 'Establish confidence and discuss opportunities',
                            'desc'  => 'We will provide unique recommendationa in sensible investment choices that will help our clients meet their long term goals or fund their retirement income needs.',
                        ],
                    ],
                    'title_field' => '{{{ title }}}',
                    'condition'   => [
                        'layout' => ['1','-sticky']
                    ]
                ]
            );
            $process2 = new Repeater();
            // Icon
            allianz_elementor_icon_image_settings($process2, [
                'group'            => false,
                'img_default_size' => 'custom',
                'skin'             => 'inline'
            ]);
            // Title
            $process2->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'default'     => esc_html__( 'My Skill', 'allianz' ),
                    'label_block' => true,
                ]
            );
            // Description
            $process2->add_control(
                'desc',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA
                ]
            );
            // Banner
            $process2->add_control(
                'banner',
                [
                    'label'       => esc_html__('Banner', 'allianz'),
                    'type'        => Controls_Manager::MEDIA,
                    'description' => esc_html__('Select image.', 'allianz'),
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
            $widget->add_control(
                'process_list2',
                [
                    'label'   => esc_html__('Process List', 'allianz'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $process2->get_controls(),
                    'default' => [
                        [
                            'title' => 'Acknowledge needs and objectives',
                            'desc'  => 'We prepare for your meeting by identifying key milestones or events that have happened since we last met. Then we review your portfolios to see if they’re well positioned to meet',
                        ],
                        [
                            'title' => 'Provide a comprehensive long term perspective',
                            'desc'  => 'We ascertain our client’s financial outlook to determine whether they should seek investments weighted toward preservation of capital, a balance of income and appreciation, or growth.',
                        ],
                        [
                            'title' => 'Establish confidence and discuss opportunities',
                            'desc'  => 'We will provide unique recommendationa in sensible investment choices that will help our clients meet their long term goals or fund their retirement income needs.',
                        ],
                    ],
                    'title_field' => '{{{ title }}}',
                    'condition'   => [
                        'layout' => ['2', '-2']
                    ]
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
        $widget->end_controls_section();
    }
}
