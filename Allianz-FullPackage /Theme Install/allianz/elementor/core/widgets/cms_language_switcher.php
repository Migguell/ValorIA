<?php
use Elementor\Controls_Manager;

if(!function_exists('allianz_widget_cms_language_switcher_register_controls')){
	add_action('etc_widget_cms_language_switcher_register_controls', 'allianz_widget_cms_language_switcher_register_controls', 10, 1);
	function allianz_widget_cms_language_switcher_register_controls($widget){
		// Layout Settings
		$widget->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__('Layout', 'allianz' ),
                'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
			]
		);

			$widget->add_control(
				'layout',
                [
                	'label' => esc_html__('Templates', 'allianz' ),
	                'type' => Elementor_Theme_Core::LAYOUT_CONTROL,
	                'default' => '1',
	                'options' => [
                        '1' => [
                            'label' => esc_html__( 'Layout 1', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_language_switcher/layout/1.jpg'
                        ]
                    ]
	            ]
			);
		$widget->end_controls_section();
		// Settings
		$widget->start_controls_section(
			'setting_section',
            [
            	'label'    => esc_html__('Settings', 'allianz'),
                'tab'      => \Elementor\Controls_Manager::TAB_CONTENT
            ]
		);
			$widget->add_control(
				'show_flag',
                [
                 	'label'   => esc_html__('Show Flag','allianz'),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        ''    => esc_html__('Default','allianz'),
                        'yes' => esc_html__('Yes', 'allianz'),
                        'no'  => esc_html__('No', 'allianz')
                    ]
                ]
			);
			$widget->add_control(
				'show_name',
                [
                	'label'   => esc_html__('Show Name','allianz'),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        ''    => esc_html__('Default','allianz'),
                        'yes' => esc_html__('Yes', 'allianz'),
                        'no'  => esc_html__('No', 'allianz')
                    ]
                ]
			);
			$widget->add_control(
				'name_as',
                [
                	'label'   => esc_html__('Name As','allianz'),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        ''      => esc_html__('Default','allianz'),
                        'full'  => esc_html__('Full', 'allianz'),
                        'short' => esc_html__('Short', 'allianz')
                    ],
                    'condition' => [
                        'show_name' => ['yes']
                    ] 
                ]
			);
            $widget->add_control(
            	'dropdown_pos',
                [
                	'label'   => esc_html__('Dropdown Position','allianz'),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        ''       => esc_html__('Default','allianz'),
                        'top'    => esc_html__('Top', 'allianz'),
                        'bottom' => esc_html__('Bottom', 'allianz')
                    ]
                ]                
            );
		$widget->end_controls_section();
        // Style
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings','allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'color',
                'label'    => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .current-language' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'color_hover',
                'label'    => esc_html__( 'Color Hover & Active', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .current-language:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
	}
}
?>