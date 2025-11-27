<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if (!function_exists('allianz_widget_cms_progressbar_register_controls')) {
    add_action('etc_widget_cms_progressbar_register_controls', 'allianz_widget_cms_progressbar_register_controls', 10, 1);
    function allianz_widget_cms_progressbar_register_controls($widget)
    {
        // Layout
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__( 'Layout', 'allianz' ),
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_progressbar/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_progressbar/layout/2.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Progressbar Section Start
        $widget->start_controls_section(
            'section_progressbar',
            [
                'label' => esc_html__('Progressbar Content', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

            $repeater = new Repeater();
            $repeater->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'default'     => esc_html__( 'My Skill', 'allianz' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
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
            allianz_elementor_colors_opts($repeater,[
                'name'     => 'progressbar_color',
                'label'    => esc_html__( 'Progress Bar Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.cms-progress-bar' => 'background-color: {{VALUE}};',
                ]
            ]);
            $widget->add_control(
                'progressbar_list',
                [
                    'label' => esc_html__('List', 'allianz'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'title' => esc_html__('My Skill', 'allianz'),
                            'percent' => [
                                'size' => 80,
                                'unit' => '%',
                            ],
                        ],
                        [
                            'title' => esc_html__('My Skill', 'allianz'),
                            'percent' => [
                                'size' => 90,
                                'unit' => '%',
                            ],
                        ],
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
        $widget->end_controls_section();
        // Content
        $widget->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__('Content Settings','allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2']
                ]    
            ]
        );
            $widget->add_control(
                'etitle',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' ),
                    'default'     => 'Personalized reports that help reveal chances in your practice.',
                    'label_block' => true,
                ]
            );
            $widget->add_control(
                'background',
                [
                    'label'   => esc_html__( 'Background', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
            $widget->add_control(
                'shadow',
                [
                    'label'   => esc_html__( 'Shadow', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => ''
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
            $widget->add_control(
                'progress_height',
                [
                    'label'       => esc_html__( 'Progress Height', 'allianz' ),
                    'type'        => Controls_Manager::SLIDER,
                    'default'     => [
                        'size' => 195,
                        'unit' => '',
                    ],
                    'range' => [
                        '' => [
                            'min' => 100,
                            'max' => 500,
                            'step' => 1
                        ]
                    ],
                    'description' => esc_html__('Progress Height','allianz')
                ]
            );
            $widget->add_control(
                'duration',
                [
                    'label'       => esc_html__( 'Duration', 'allianz' ),
                    'type'        => Controls_Manager::SLIDER,
                    'default'     => [
                        'size' => 2000,
                        'unit' => '',
                    ],
                    'range' => [
                        '' => [
                            'min' => 50,
                            'max' => 5000,
                            'step' => 10
                        ]
                    ],
                    'description' => esc_html__('Time in milisecond','allianz')
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'    => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-progress-bar-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cms-progress-bar-title > span' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'progress_color',
                'label'    => esc_html__( 'Progress Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-progress-bar' => 'background-color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'progressbar_color',
                'label'    => esc_html__( 'Progress Bar Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-progress-wrap' => 'background-color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
    }
}
