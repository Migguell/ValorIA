<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if (!function_exists('allianz_widget_cms_instagram_register_controls')) {
    add_action('etc_widget_cms_instagram_register_controls', 'allianz_widget_cms_instagram_register_controls', 10, 1);
    function allianz_widget_cms_instagram_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_instagram/layout/1.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Gallery
        $widget->start_controls_section(
            'section_gallery',
            [
                'label' => esc_html__('Instagram Setting', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'user',
                [
                    'label'       => esc_html__( 'Instagram User', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'default'     => 'Allianz'
                ]
            );
            $widget->add_control(
                'user_link',
                [
                    'label'       => esc_html__( 'Instagram URL', 'allianz' ),
                    'type'        => \Elementor\Controls_Manager::URL,
                    'default'     => [
                        'url' => 'https://instagram.com/'
                    ],
                    'label_block' => false
                ]
            );
            $widget->add_control(
                'gallery',
                [
                    'label'   => esc_html__( 'Gallery Images', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::GALLERY
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'gallery',
                    'label'   => esc_html__('Image Size','allianz'),
                    'default' => 'custom'
                ]
            );
        $widget->end_controls_section();
        // Carousel Settings
        allianz_elementor_carousel_settings($widget);
    }
}
