<?php
use Elementor\Controls_Manager;
if (!function_exists('allianz_widget_cms_google_map_register_controls')) {
    add_action('etc_widget_cms_google_map_register_controls', 'allianz_widget_cms_google_map_register_controls', 10, 1);
    function allianz_widget_cms_google_map_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_google_map/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_google_map/layout/2.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Content Tab Start
        $widget->start_controls_section(
            'map_section',
            [
                'label' => esc_html__('Map Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $default_address = esc_html__( 'The Great Kings Building Management 2307 Beverley Road, Brooklyn, NY 145784', 'allianz' );
            $widget->add_control(
                'address_title',
                [
                    'label'       => esc_html__('Address Title','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Our new store now:',
                    'label_block' => false  
                ]
            );
            $widget->add_control(
                'map_address',
                [
                    'label'   => esc_html__( 'Address', 'allianz' ),
                    'type'    => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true
                    ],
                    'placeholder' => $default_address,
                    'default'     => $default_address,
                    'label_block' => true,
                ]
            );
            $widget->add_control(
                'zoom',
                [
                    'label' => esc_html__( 'Zoom', 'allianz' ),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 15,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 20,
                        ],
                    ],
                    'separator' => 'before',
                ]
            );
            $widget->add_responsive_control(
                'height',
                [
                    'label' => esc_html__( 'Height', 'allianz' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 40,
                            'max' => 1440,
                        ]
                    ],
                    'size_units' => [ 'px' ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-egmap' => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} iframe' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'default' => [
                        'size' => 620,
                    ]
                ]
            );
            $widget->add_control(
                'view',
                [
                    'label'   => esc_html__( 'View', 'allianz' ),
                    'type'    => Controls_Manager::HIDDEN,
                    'default' => 'traditional',
                ]
            );
            
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_address_color',
                'label'     => esc_html__( 'Icon Address Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-address .cms-icon-color' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'address_color',
                'label'     => esc_html__( 'Address Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-address' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'address_color_hover',
                'label'     => esc_html__( 'Address Hover Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-address:hover' => 'color: {{VALUE}};',
                ]
            ]);
            $widget->add_control(
                'direction_text',
                [
                    'label'       => esc_html__('Button Text','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Get Directions',
                    'label_block' => false  
                ]
            );
        $widget->end_controls_section();
        // Content
        $widget->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2']
                ]
            ]
        );
            $widget->add_control(
                'title',
                [
                    'label'       => '',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'London Office',  
                    'placeholder' => esc_html__('Enter your title', 'allianz')
                ]
            );
            $widget->add_control(
                'address',
                [
                    'label'       => '',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'The Great Kings Building Management 2307 Beverley Road, Brooklyn, NY 145784',
                    'placeholder' => esc_html__('Enter your address', 'allianz')
                ]
            );
            $widget->add_control(
                'email',
                [
                    'label'       => '',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'allianz@cmshero.com',
                    'placeholder' => 'allianz@cmshero.com'
                ]
            );
            $widget->add_control(
                'phone',
                [
                    'label'       => esc_html__('Phone Number','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '02 01061245741',
                    'placeholder' => '02 01061245741'
                ]
            );
        $widget->end_controls_section();
        // Time Section Start
        $widget->start_controls_section(
            'time_section',
            [
                'label' => esc_html__('Time Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'=> [
                    'layout' => ['2']
                ]
            ]
        );
            $widget->add_control(
                'time_title',
                [
                    'label'       => esc_html__('Week Days','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Week Days',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'time',
                [
                    'label'       => esc_html__('Time','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '09.00 - 24:00',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'sat_title',
                [
                    'label'       => esc_html__('Saturday','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Saturday',
                    'label_block' => false,
                    'separator'   => 'before'
                ]
            );
            $widget->add_control(
                'sat_time',
                [
                    'label'       => esc_html__('Saturday Time','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '08:00 - 03.00',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'sun_title',
                [
                    'label'       => esc_html__('Sunday','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Sunday',
                    'label_block' => false,
                    'separator'   => 'before'
                ]
            );
            $widget->add_control(
                'sun_time',
                [
                    'label'       => esc_html__('Sunday Time','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Day off',
                    'label_block' => false
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_time_color',
                'label' => esc_html__('Icon Time Color', 'allianz'),
                'selector' => [
                    '{{WRAPPER}} .cms-time .cms-icon-color' => 'color: {{VALUE}};',
                ],
                'separator'   => 'before'
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'time_color',
                'label' => esc_html__('Time Color', 'allianz'),
                'selector' => [
                    '{{WRAPPER}} .cms-time' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'time_color_hover',
                'label' => esc_html__('Time Hover Color', 'allianz'),
                'selector' => [
                    '{{WRAPPER}} .cms-time:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Style Section
        $widget->start_controls_section(
            'show_hide_title_section',
            [
                'label'     => esc_html__('Title Settings', 'allianz'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => ['2']
                ]
            ]
        );
            allianz_add_hidden_device_controls($widget, [
                'prefix' => 'title_',
            ]);
        $widget->end_controls_section(); 
    }
}
