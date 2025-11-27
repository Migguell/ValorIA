<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if (!function_exists('allianz_widget_cms_post_feature_register_controls')) {
    add_action('etc_widget_cms_post_feature_register_controls', 'allianz_widget_cms_post_feature_register_controls', 10, 1);
    function allianz_widget_cms_post_feature_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_post_feature/layout/1.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Content
        $widget->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $widget->add_control(
                'show_cat',
                [
                    'label'   => esc_html__( 'Show Category', 'allianz' ),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes'
                ]
            );
            $widget->add_control(
                'show_title',
                [
                    'label'   => esc_html__( 'Show Post Title', 'allianz' ),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes'
                ]
            );
            $widget->add_control(
                'show_image',
                [
                    'label'       => esc_html__( 'Show Feature Image', 'allianz' ),
                    'description' => '',
                    'type'        => Controls_Manager::SWITCHER,
                    'default'     => 'yes'
                ]
            );
            $widget->add_control(
                'banner',
                [
                    'label'   => esc_html__( 'Replace Feature Image?', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [],
                    'condition' => [
                        'show_image' => 'yes'
                    ]
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'banner',
                    'label'   => esc_html__('Image Size','allianz'),
                    'default' => 'large',
                    'condition' => [
                        'show_image' => 'yes'
                    ]
                ]
            );
        $widget->end_controls_section();
    }
}
