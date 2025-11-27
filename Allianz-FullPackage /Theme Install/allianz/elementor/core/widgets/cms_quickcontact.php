<?php
use Elementor\Controls_Manager;

if (!function_exists('allianz_widget_cms_quickcontact_register_controls')) {
    add_action('etc_widget_cms_quickcontact_register_controls', 'allianz_widget_cms_quickcontact_register_controls', 10, 1);
    function allianz_widget_cms_quickcontact_register_controls($widget)
    {
        // Layout Settings
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__( 'Layout', 'allianz' ),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );
            $widget->add_responsive_control(
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
                            'icon'  => 'eicon-text-align-justify',
                        ],
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/2.jpg'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/3.jpg'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/4.webp'
                        ],
                        '5' => [
                            'label' => esc_html__( 'Layout 5', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/5.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();

        // Title Section Start
        $widget->start_controls_section(
            'title_section',
            [
                'label'     => esc_html__('Title', 'allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1','2','3','4']
                ]
            ]
        );
            $widget->add_control(
                'title',
                [
    				'label'       => '',
    				'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Quick Contact',  
    				'placeholder' => esc_html__('Enter your title', 'allianz')
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'     => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Desc Section Start
        $widget->start_controls_section(
            'desc_section',
            [
                'label' => esc_html__('Description', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1','3']
                ]
            ]
        );
            $widget->add_control(
                'desc',
                [
                    'label'       => '',
                    'default'     => 'If you have any questions or need help, feel free to contact with our team.',
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__('Enter your text', 'allianz')
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'desc_color',
                'label'     => esc_html__( 'Description Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        
        // Email Section Start
        $widget->start_controls_section(
            'email_section',
            [
                'label' => esc_html__('Email', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1','2','4','5']
                ]
            ]
        );
            $widget->add_control(
                'email_title',
                [
                    'label'       => esc_html__('Email Title','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Email:'  
                ]
            );
            $widget->add_control(
                'email',
                [
    				'label'       => '',
    				'type'        => Controls_Manager::TEXTAREA,
    				'default'     => 'allianz@7oroof.com',
                    'placeholder' => 'allianz@7oroof.com'
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_email_color',
                'label'     => esc_html__( 'Icon Email Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-email .cms-icon-color' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'email_color',
                'label'     => esc_html__( 'Email Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-email' => 'color: {{VALUE}};',
                ]
            ]);
             allianz_elementor_colors_opts($widget,[
                'name'     => 'email_color_hover',
                'label'     => esc_html__( 'Email Hover Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-email:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Phone Section Start
        $widget->start_controls_section(
            'phone_section',
            [
                'label' => esc_html__('Phone Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'   => [
                    'layout'  => ['1','2','4','5']
                ]
            ]
        );
            $widget->add_control(
                'phone_title',
                [
                    'label'       => esc_html__('Phone Title','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Phone:',
                    'label_block' => false
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
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_phone_color',
                'label' => esc_html__('Icon Phone Color', 'allianz'),
                'selector' => [
                    '{{WRAPPER}} .cms-phone .cms-icon-color' => 'color: {{VALUE}};'
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'phone_color',
                'label' => esc_html__('Phone Color', 'allianz'),
                'selector' => [
                    '{{WRAPPER}} .cms-phone' => 'color: {{VALUE}};'
                ],
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'phone_color_hover',
                'label' => esc_html__('Phone Hover Color', 'allianz'),
                'selector' => [
                    '{{WRAPPER}} .cms-phone:hover' => 'color: {{VALUE}};'
                ],
            ]);
        $widget->end_controls_section();
        // Time Section Start
        $widget->start_controls_section(
            'time_section',
            [
                'label' => esc_html__('Time Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'=> [
                    'layout' => ['1', '4','5']
                ]
            ]
        );
            $widget->add_control(
                'time_title',
                [
                    'label'       => esc_html__('Time Title','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Mon - Fri:',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'time',
                [
                    'label'       => esc_html__('Time','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '8AM - 5PM',
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'exclude_time',
                [
                    'label'       => esc_html__('Exclude Time','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '*Excludes Holidays',
                    'label_block' => false,
                    'condition'   => [
                        'layout' => ['4']
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_time_color',
                'label' => esc_html__('Icon Time Color', 'allianz'),
                'selector' => [
                    '{{WRAPPER}} .cms-time .cms-icon-color' => 'color: {{VALUE}};',
                ],
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
        // Address Section Start
        $widget->start_controls_section(
            'address_section',
            [
                'label' => esc_html__('Address', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1','2','4','5']
                ]
            ]
        );
            $widget->add_control(
                'address_title',
                [
                    'label'       => esc_html__('Address Title','allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Location',
                    'label_block' => false  
                ]
            );
            $widget->add_control(
                'address',
                [
                    'label'       => '',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '2307 Beverley Rd Brooklyn, New York 11226 United States.',
                    'placeholder' => esc_html__('Enter your address', 'allianz')
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
        $widget->end_controls_section();
        // Style Section
        $widget->start_controls_section(
            'show_hide_title_section',
            [
                'label' => esc_html__('Title Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
	        allianz_add_hidden_device_controls($widget, [
                'prefix' => 'title_',
            ]);
        $widget->end_controls_section(); 
    }
}
