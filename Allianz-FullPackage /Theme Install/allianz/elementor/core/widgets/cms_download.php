<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_download_register_controls')) {
    add_action('etc_widget_cms_download_register_controls', 'allianz_widget_cms_download_register_controls', 10, 1);
    function allianz_widget_cms_download_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_download/layout/1.jpg'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Content Tab Start
        // List Section Start
        $widget->start_controls_section(
            'download_section',
            [
                'label' => esc_html__('Download List', 'allianz'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

            $repeater = new Repeater();
            $repeater->add_control(
                'name',
                [
                    'label' => esc_html__('Title', 'allianz'),
                    'type' => Controls_Manager::TEXT
                ]
            );

            $repeater->add_control(
                'link',
                [
                    'label'   => esc_html__( 'File URL', 'allianz' ),
                    'type'    => Controls_Manager::URL,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow'    => true,
                    ],
                    'description' => esc_html__(' Go to Dashboard -> Media -> Add New Media File -> Upload file -> Copy URL', 'allianz')
                ]
            );
            $widget->add_control(
                'title',
                [
                    'label'   => esc_html__('Title', 'allianz'),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => 'Download Brochure'
                ]
            );
            $widget->add_control(
                'download_lists',
                [
                    'label' => esc_html__('Download Lists', 'allianz'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            
                            'name' => 'Our Report 2023',
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'name' => 'Company Brochure',
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
    $widget->end_controls_section();
    }
}
