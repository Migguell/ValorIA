<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if (!function_exists('allianz_widget_cms_gallery_register_controls')) {
    add_action('etc_widget_cms_gallery_register_controls', 'allianz_widget_cms_gallery_register_controls', 10, 1);
    function allianz_widget_cms_gallery_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_gallery/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_gallery/layout/2.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Gallery
        $widget->start_controls_section(
            'section_gallery',
            [
                'label' => esc_html__('Gallery Image', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'gallery',
                [
                    'label'   => esc_html__( 'Add Images', 'allianz' ),
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
        // Settings
        $widget->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Settings','allianz'),
                'tab'   => Controls_Manager::TAB_SETTINGS
            ]
        );
            $widget->add_responsive_control(
                'col',
                [
                    'label'        => esc_html__('Columns', 'allianz'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => '',
                    'default_args' => [
                        'tablet' => '',
                        'mobile' => ''
                    ],
                    'options' => [
                        ''     => esc_html__('Default', 'allianz'),
                        '1'    => '1',
                        '2'    => '2',
                        '3'    => '3',
                        '4'    => '4',
                        '6'    => '6',
                        'auto' => esc_html__('Auto', 'allianz'),
                    ]
                ]
            );
            $widget->add_control(
                'gallery_rand',
                [
                    'label'   => esc_html__( 'Order By', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        ''     => esc_html__( 'Default', 'allianz' ),
                        'rand' => esc_html__( 'Random', 'allianz' ),
                    ],
                    'default' => '',
                ]
            );
            $widget->add_control(
                'gallery_show',
                [
                    'label'   => esc_html__( 'Number of item to show', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'default' => ''
                ]
            );
            $widget->add_control(
                'gallery_loadmore_show',
                [
                    'label'   => esc_html__( 'Number of item to show on load more', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'default' => ''
                ]
            );
            $widget->add_control(
                'load_more_text',
                [
                    'label'   => esc_html__( 'Load More Text', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::TEXT
                ]
            );
        $widget->end_controls_section();
    }
}
