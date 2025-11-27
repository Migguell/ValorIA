<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!function_exists('allianz_widget_cms_breadcrumb_register_controls')) {
    add_action('etc_widget_cms_breadcrumb_register_controls', 'allianz_widget_cms_breadcrumb_register_controls', 10, 1);
    function allianz_widget_cms_breadcrumb_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_breadcrumb/layout/1.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();

        // Breadcrumb Start
        $widget->start_controls_section(
            'section_breadcrumb',
            [
                'label' => esc_html__('Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $widget->add_control(
            'breadcrumb_color',
            [
                'label'     => esc_html__( 'Breadcrumb Color', 'allianz' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cms-breadcrumb' => 'color: {{VALUE}};',
                ],
            ]
        );
        $widget->add_responsive_control(
            'align',
            [
                'label'        => esc_html__( 'Alignment', 'allianz' ),
                'type'         => \Elementor\Controls_Manager::CHOOSE,
                'options'      => [
                    'start'   => [
                        'title' => esc_html__( 'Start', 'allianz' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'allianz' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'end'  => [
                        'title' => esc_html__( 'End', 'allianz' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ]
            ]
        );
        $widget->end_controls_section(); // Breadcrumb End

        // Content Tab End

    }
}
