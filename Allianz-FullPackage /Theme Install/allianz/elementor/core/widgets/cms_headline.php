<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_headline_register_controls')) {
    add_action('etc_widget_cms_headline_register_controls', 'allianz_widget_cms_headline_register_controls', 10, 1);
    function allianz_widget_cms_headline_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_headline/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_headline/layout/2.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // List Section Start
        $widget->start_controls_section(
            'list_section',
            [
                'label' => esc_html__('List', 'allianz'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $repeater = new Repeater();
            $repeater->add_control(
                'text',
                [
                    'label'       => esc_html__('Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Enter your headline text',
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'headlines',
                [
                    'label'   => esc_html__('Headlines', 'allianz'),
                    'type'    => \Elementor\Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'text' => 'Free shipping on US orders $100+ & Free exchanges',
                        ],
                        [
                            'text' => 'Delivery time 2-3 working days',
                        ],
                        [
                            'text' => 'Free exchanges & free returns',
                        ]
                    ],
                    'title_field' => '{{{ text }}}',
                ]
            );
        $widget->end_controls_section();
        // Carousel Settings
        allianz_elementor_carousel_settings($widget, [
            'hover_icon' => true, 
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        // Grid Settings
        allianz_elementor_grid_columns_settings($widget, [
            'condition' => [
                'layout' => ['2']
            ]
        ]);
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
                    '{{WRAPPER}} .headline-item' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'color_hover',
                'label'    => esc_html__( 'Color Hover & Active', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .headline-item:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
    }
}
?>