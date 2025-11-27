<?php
use Elementor\Controls_Manager;
use Elementor\Control_Date_Time;

if (!function_exists('allianz_widget_cms_countdown_register_controls')) {
    add_action('etc_widget_cms_countdown_register_controls', 'allianz_widget_cms_countdown_register_controls', 10, 1);
    function allianz_widget_cms_countdown_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_countdown/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_countdown/layout/2.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Countdown Section Start
        $widget->start_controls_section(
            'section_countdown',
            [
                'label' => esc_html__('Countdown', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $widget->add_control(
            'date',
            [
                'label'       => esc_html__( 'Date', 'allianz' ),
                'type'        => Controls_Manager::DATE_TIME,
                'label_block' => true,
                'description' => esc_html__( 'Set date count down (Date format: yy/mm/dd)', 'allianz' ),
            ]
        );
        $widget->end_controls_section(); // Countdown Section End
    }
}
