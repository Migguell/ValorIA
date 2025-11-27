<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_clients_register_controls')) {
    add_action('etc_widget_cms_clients_register_controls', 'allianz_widget_cms_clients_register_controls', 10, 1);
    function allianz_widget_cms_clients_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_clients/layout/1.jpg'
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
                'image',
                [
                    'label' => esc_html__('Image', 'allianz'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $repeater->add_control(
                'name',
                [
                    'label' => esc_html__('Name', 'allianz'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Client Name', 'allianz'),
                ]
            );

            $repeater->add_control(
                'link',
                [
                    'label'   => esc_html__( 'Link', 'allianz' ),
                    'type'    => Controls_Manager::URL,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow'    => true,
                    ],
                ]
            );

            $widget->add_control(
                'clients',
                [
                    'label' => esc_html__('Clients', 'allianz'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'allianz'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'allianz'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'allianz'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'allianz'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'allianz'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'allianz'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ]
                    ],
                    'title_field' => '{{{ name }}}',
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'image',
                    'default' => 'full',
                ]
            );
        $widget->end_controls_section();
        // Carousel Settings
        allianz_elementor_carousel_settings($widget);
        // Style Settings
         $widget->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style Settings', 'allianz'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
                'opacity',
                [
                    'label' => esc_html__('Opacity', 'allianz'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max'  => 1,
                            'min'  => 0.01,
                            'step' => 0.01,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .client-item:not(:hover) > img' => 'opacity:{{SIZE}};'
                    ]
                ]
            );
        $widget->end_controls_section();
    }
}
