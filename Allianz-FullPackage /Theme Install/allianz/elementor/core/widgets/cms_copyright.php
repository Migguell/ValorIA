<?php
use Elementor\Controls_Manager;
use Elementor\Base_Data_Control;

if(!function_exists('allianz_widget_cms_copyright_register_controls')){
	add_action('etc_widget_cms_copyright_register_controls', 'allianz_widget_cms_copyright_register_controls', 10, 1);
	function allianz_widget_cms_copyright_register_controls($widget){
		// Layout Settings
		$widget->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__( 'Copyright', 'allianz' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
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
		                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_copyright/layout/1.jpg'
		                ]
		            ]
		        ]
			);
		$widget->end_controls_section();
		// Content Settings
		$widget->start_controls_section(
			'setting_section',
            [
            	'label'    => esc_html__('Settings', 'allianz'),
            	'tab'      => \Elementor\Controls_Manager::TAB_CONTENT
            ]
		);
		$widget->add_control(
			'copyright_text',
			[
				'label'       => esc_html__('Copyright Text', 'allianz'),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'description' => esc_html__('Use [[year]] variable to insert current year, [[name]] variable to insert site name.', 'allianz'),
				'label_block' => true,
				'default' => '&copy;[[year]] [[name]], All Rights Reserved. With Love by <a href="https://7oroofthemes.com/" target="_blank" rel="nofollow">7oroof.com</a>',
			]
		);
        
		$widget->end_controls_section();
		// Style
        $widget->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Style', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
        	$widget->add_responsive_control(
	            'align',
	            [
	                'label'        => esc_html__( 'Alignment', 'allianz' ),
	                'type'         => Controls_Manager::CHOOSE,
	                'responsive'   => true,
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
	                ],
	                'prefix_class' => 'text%s-'
	            ]
	        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'text_color',
                'label'     => esc_html__( 'Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'link_color',
                'label'     => esc_html__( 'Link Color', 'allianz' ),
                'selectors' => [
	                    '{{WRAPPER}} a' => 'color: {{VALUE}};',
	                ],
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'link_color_hover',
                'label'     => esc_html__( 'Link Color Hover', 'allianz' ),
                'selectors' => [
	                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
	                ],
            ]);
        $widget->end_controls_section();
	}
}
?>