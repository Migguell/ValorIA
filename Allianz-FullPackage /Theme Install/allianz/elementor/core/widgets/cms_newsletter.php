<?php
if(!class_exists('Newsletter')) return;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if(!function_exists('allianz_widget_cms_newsletter_register_controls')){
	add_action('etc_widget_cms_newsletter_register_controls', 'allianz_widget_cms_newsletter_register_controls', 10, 1);
	function allianz_widget_cms_newsletter_register_controls($widget){
		// Layout Settings
		$widget->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__('Layout', 'allianz' ),
                'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
			]
		);
            $widget->add_responsive_control(
                'layout_mode',
                [
                    'label'        => esc_html__( 'Layout Mode', 'allianz' ),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => 'plain', 
                    'options'      => [
                        'plain' => esc_html__('Plain','allianz'),
                        'popup' => esc_html__('Popup','allianz')
                    ] 
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
					'label'   => esc_html__('Templates', 'allianz' ),
					'type'    => Elementor_Theme_Core::LAYOUT_CONTROL,
					'default' => '1',
					'options' => [
                        '1' => [
                            'label' => esc_html__( 'Layout 1', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_newsletter/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_newsletter/layout/2.jpg'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_newsletter/layout/3.jpg'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_newsletter/layout/4.jpg'
                        ]
                    ]
	            ]
			);
		$widget->end_controls_section();
        // Popup Setting
        $widget->start_controls_section(
            'popup_section',
            [
                'label' => esc_html__('Popup Settings', 'allianz' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition'   => [
                    'layout_mode' => ['popup']
                ]
            ]
        );
            $widget->add_control(
                'popup_title',
                [
                    'label'       => esc_html__('Popup Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Sign up for alerts, monthly insights, strategic business perspectives and exclusive content in your inbox.',
                    'placeholder' => esc_html__('Enter your text', 'allianz'),
                    'label_block' => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'popup_title_color',
                'label'     => esc_html__( 'Text Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-newsletter-popup' => 'color: {{VALUE}};',
                ]
            ]);
            $widget->add_control(
                'popup_btn_text',
                [
                    'label'       => esc_html__('Popup Button Text', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Subscribe',
                    'placeholder' => esc_html__('Subscribe', 'allianz'),
                    'label_block' => true
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'popup_btn_color',
                'label'     => esc_html__( 'Button Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .popup-btn' => 'background-color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'popup_btn_text_color',
                'label'     => esc_html__( 'Button Text Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .popup-btn' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'popup_btn_hover_color',
                'label'     => esc_html__( 'Button Hover Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .popup-btn:hover' => 'background-color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'popup_btn_hover_text_color',
                'label'     => esc_html__( 'Button Hover Text Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .popup-btn:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Heading Setting
        $widget->start_controls_section(
            'title_section',
            [
                'label' => esc_html__('Heading', 'allianz' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'small_title',
                [
                    'label'       => esc_html__('Small Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Small Heading',
                    'placeholder' => esc_html__('Enter your text', 'allianz'),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['3']
                    ]
                ]
            );
            $widget->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Newsletter',
                    'placeholder' => esc_html__('Enter your text', 'allianz'),
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'description',
                [
                    'label'       => esc_html__( 'Description', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__( 'Description', 'allianz' ),
                    'label_block' => true,
                    'default'     => 'Sign up for industry alerts, deals, news and insights from us.'
                ]
            );
        $widget->end_controls_section();
        // Form Settings
        $widget->start_controls_section(
        	'form_section',
            [
            	'label'    => esc_html__( 'Form Settings', 'allianz' ),
                'tab'      => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'layout_form',
                [
                    'label' => esc_html__('Newsletter Form Layout', 'allianz'),
                    'type'  => Controls_Manager::SELECT,
                    'options' => [
                        ''       => esc_html__('Default', 'allianz'),
                        'custom' => esc_html__('Custom', 'allianz')
                    ]
                ]
            );

            $widget->add_control(
                'form_id',
                [
                    'label' => esc_html__('Choose Form ID', 'allianz'),
                    'type'  => Controls_Manager::SELECT,
                    'options' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10'
                    ],
                    'default' => '1',
                    'condition' => [
                        'layout_form' => 'custom'
                    ],
                    'description' => sprintf(esc_html__('%sClick Here%s to add your custom form. More about its, please read %s Document here%s','allianz'), '<a href="' . esc_url( admin_url( 'admin.php?page=newsletter_subscription_forms' ) ) . '" target="_blank">','</a>', '<a href="'.esc_url('https://www.thenewsletterplugin.com/documentation/subscription/subscription-form-shortcodes/').'"  target="_blank">','</a>')
                ]
            );

        	$widget->add_control(
        		'show_name',
                [
                	'label'       => esc_html__( 'Show Field Name', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::SELECT,
                    'options'     => [
                        ''    =>  esc_html__('Default','allianz'),
                        'yes' =>  esc_html__('Yes','allianz'),
                        'no'  =>  esc_html__('No','allianz'),
                    ],
                    'condition' => [
                        'layout_form!' => 'custom'
                    ]
                ]
        	);
        	$widget->add_control(
        		'name_text',
                [
                	'label'       => esc_html__( 'Name Text', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => esc_html__( 'Enter placeholder text', 'allianz' ),
                    'label_block' => true,
                    'condition'   => [
                        'show_name' => ['','yes']
                    ],
                    'condition' => [
                        'layout_form' => ''
                    ]
                ]
        	);
        	$widget->add_control(
        		'email_text',
                [
                	'label'       => esc_html__( 'Email Text', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => esc_html__( 'Enter placeholder text', 'allianz' ),
                    'label_block' => true,
                    'condition' => [
                        'layout_form' => ''
                    ]
                ]
        	);
        	$widget->add_control(
        		'button_text',
                [
                	'label'       => esc_html__( 'Button Text', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => esc_html__( 'Enter button text', 'allianz' ),
                    'label_block' => true,
                    'condition' => [
                        'layout_form' => ''
                    ]
                ]
        	);
            // By subscribing, you accept the Privacy Policy
            $widget->add_control(
                'privacy_policy_page',
                [
                    'label'   => esc_html__('Privacy Policy Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'layout' => ['2','3','4'],
                    ],
                    'label_block' => true,
                    'separator' => 'before'
                ]
            );
            $widget->add_control(
                'privacy_policy_text',
                [
                    'label'       => esc_html__( 'Privacy Policy Description', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__('By subscribing, you accept the', 'allianz' ),
                    'default'     => 'By subscribing, you accept the',
                    'condition' => [
                        'layout' => ['2','3','4']
                    ]
                ]
            );
            $widget->add_control(
                'privacy_policy_link_text',
                [
                    'label'       => esc_html__( 'Privacy Policy Text', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'description' => esc_html__('Default is title of page', 'allianz' ),
                    'placeholder' => esc_html__('Privacy Policy', 'allianz' ),
                    'condition' => [
                        'layout' => ['2','3','4']
                    ]
                ]
            );
        $widget->end_controls_section();
        // Style
        $widget->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Style Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'small_title_color',
                'label'     => esc_html__( 'Small Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-small-title' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'     => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'desc_color',
                'label'     => esc_html__( 'Description Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
        // Background
        $widget->start_controls_section(
            'section_background',
            [
                'label' => esc_html__('Background','allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => ['2']
                ]
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'bg_color',
                'label'     => esc_html__( 'Background Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-newsletter' => 'background-color: {{VALUE}};',
                ]
            ]);
            $widget->add_control(
                'bg_image',
                [
                    'label'   => esc_html__( 'Background Image', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [],
                    'selectors' => [
                        '{{WRAPPER}} .cms-newsletter' => 'background-image:url("{{URL}}");'
                    ]
                ]
            );
        $widget->end_controls_section();
	}
}
?>