<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_testimonials_register_controls')) {
    add_action('etc_widget_cms_testimonials_register_controls', 'allianz_widget_cms_testimonials_register_controls', 10, 1);
    function allianz_widget_cms_testimonials_register_controls($widget)
    {
        // Layout Tab Start
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'allianz'),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $widget->add_control(
            'layout_mode',
            [
                'label'   => esc_html__( 'Layout Mode', 'allianz' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''         => esc_html__('Default','allianz'),
                    'grid'     => esc_html__('Grid','allianz'),
                    'carousel' => esc_html__('Carousel', 'allianz')
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
                        'label' => esc_html__( 'Layout 1', 'allianz' ),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonials/layout/1.webp'
                    ],
                    '2' => [
                        'label' => esc_html__( 'Layout 2', 'allianz' ),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonials/layout/2.webp'
                    ],
                    '3' => [
                        'label' => esc_html__( 'Layout 3', 'allianz' ),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonials/layout/3.webp'
                    ]
                ]
            ]
        );
        $widget->end_controls_section();
        // Testimonials
        $widget->start_controls_section(
            'list_section',
            [
                'label' => esc_html__('Testimonials', 'allianz'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $repeater = new Repeater();

            $repeater->add_control(
                'image',
                [
                    'label' => esc_html__('Avatar', 'allianz'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $repeater->add_control(
                'name',
                [
                    'label' => esc_html__('Name', 'allianz'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Testimonial Name', 'allianz'),
                ]
            );

            $repeater->add_control(
                'position',
                [
                    'label' => esc_html__('Position', 'allianz'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Testimonial Position', 'allianz'),
                ]
            );
            $repeater->add_control(
                'star_rated',
                [
                    'label'       => esc_html__( 'Star', 'allianz' ),
                    'type'        => Controls_Manager::SELECT,
                    'options'     => [
                        '0'   => '0',
                        '20'  => '1',
                        '40'  => '2',
                        '60'  => '3',
                        '80'  => '4',
                        '100' => '5',
                    ],
                    'default' => '0'
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label' => esc_html__('Description', 'allianz'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__('Testimonial Description', 'allianz'),
                ]
            );

            $widget->add_control(
                'testimonials',
                [
                    'label' => esc_html__('Testimonials', 'allianz'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => esc_html__('Testimonial Name', 'allianz'),
                            'position'    => esc_html__('Testimonial Position', 'allianz'),
                            'star_rated'  => '0',
                            'description' => esc_html__('#1 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'allianz'),
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => esc_html__('Testimonial Name #2', 'allianz'),
                            'position'    => esc_html__('Testimonial Position #2', 'allianz'),
                            'star_rated'  => '0',
                            'description' => esc_html__('#2 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'allianz'),
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => esc_html__('Testimonial Name #3', 'allianz'),
                            'position'    => esc_html__('Testimonial Position #3', 'allianz'),
                            'star_rated'  => '0',
                            'description' => esc_html__('#3 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'allianz'),
                        ],
                    ],
                    'title_field' => '{{{ name }}}',
                ]
            );
            $widget->add_control(
                'avatar_size_setting',
                [
                    'name'      => 'avatar_size_heading',
                    'label'     => esc_html__('Avatar Settings','allianz'),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before'
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'      => 'image',
                    'default'   => 'custom'
                ]
            );
        $widget->end_controls_section();
        // Heading Settings
        $widget->start_controls_section(
            'heading_section',
            [
                'label' => esc_html__('Heading Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        ); 
            $widget->add_control(
                'heading-align',
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
            $widget->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true,
                    
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
            $widget->add_control(
                'heading_text',
                [
                    'label'       => esc_html__( 'Heading', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
                    'label_block' => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'heading_color',
                'label'    => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-heading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);
        $widget->end_controls_section();
        // Carousel Settings
        allianz_elementor_carousel_settings($widget, ['condition' => ['layout_mode' => 'carousel']]);
        // Grid Settings
        allianz_elementor_grid_columns_settings($widget, ['condition' => ['layout_mode' => 'grid']]);
        // Style
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings','allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'desc_color',
                'label'    => esc_html__( 'Description Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-ttmn--text' => 'color: {{VALUE}};'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'author_color',
                'label'    => esc_html__( 'Author Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-ttmn--name' => 'color: {{VALUE}};'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'author_pos_color',
                'label'    => esc_html__( 'Position Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-ttmn--pos' => 'color: {{VALUE}};'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'rate_color',
                'label'    => esc_html__( 'Rate Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-star-rate' => 'color: {{VALUE}};'
                ]
            ]);
            $widget->add_control(
                'background_image',
                [
                    'label'   => esc_html__('Background Image', 'allianz'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [],
                    'condition' => [
                        'layout' => ['1', '2']
                    ]
                ]
            );
        $widget->end_controls_section();
    }
}
