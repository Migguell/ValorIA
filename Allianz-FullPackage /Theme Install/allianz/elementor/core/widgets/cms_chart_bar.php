<?php
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_chart_bar_register_controls')) {
    add_action('etc_widget_cms_chart_bar_register_controls', 'allianz_widget_cms_chart_bar_register_controls', 10, 1);
    function allianz_widget_cms_chart_bar_register_controls($widget)
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_chart_bar/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_chart_bar/layout/2.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Content Section Start
        $widget->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__('Content Settings', 'allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1']
                ]
            ]
        );  
            $widget->add_control(
                'title',
                [
                    'label'       => esc_html__( 'Title', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Stats & Charts',
                    'placeholder' => esc_html__( 'Enter your title', 'allianz' )
                ]
            );      
            $widget->add_control(
                'text',
                [
                    'label'       => esc_html__( 'Content', 'allianz' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Our mix of company-owned and contractor assets allows us to retain optimal levels of control whilst expanding our reach to over 96% of towns in Australia. With 40 years of LTL experience, we are now a trusted LTL freight provider for shippers of all sizes and commodity types.',
                    'placeholder' => esc_html__( 'Enter your text', 'allianz' )
                ]
            ); 
            $widget->add_control(
                'link_text',
                [
                    'label'       => esc_html__( 'Link Settings', 'allianz' ),
                    'description' => esc_html__('Link Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '',
                    'placeholder' => esc_html__( 'Click here', 'allianz' ),
                    'label_block' => true
                ]
            );
            $widget->add_control(
                'link_type',
                [
                    'label'   => esc_html__('Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'link_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'page_link',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'link_text!' => '',
                        'link_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'custom_link',
                [
                    'label'       => esc_html__( 'Link', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'link_text!' => '',
                        'link_type' => 'custom'
                    ]
                ]
            );
            $widget->add_control(
                'link2_text',
                [
                    'label'       => esc_html__( 'Link #2 Settings', 'allianz' ),
                    'description' => esc_html__('Link Text', 'allianz'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '',
                    'placeholder' => esc_html__( 'Check All Services', 'allianz' ),
                    'separator' => 'before'
                ]
            );
            $widget->add_control(
                'link2_type',
                [
                    'label'   => esc_html__('Link Type', 'allianz'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'custom' => esc_html__('Custom', 'allianz'),
                        'page'   => esc_html__('Page', 'allianz'),
                    ],
                    'default' => 'custom',
                    'condition' => [
                        'link2_text!' => ''
                    ]
                ]
            );
            $widget->add_control(
                'link2_page',
                [
                    'label'   => esc_html__('Select Page', 'allianz'),
                    'type'    => Elementor_Theme_Core::POSTS_CONTROL,
                    'post_type' => [
                        'page'
                    ],
                    'multiple'  => false,
                    'condition' => [
                        'link2_text!' => '',
                        'link2_type' => 'page'
                    ]
                ]
            );
            $widget->add_control(
                'link2_custom',
                [
                    'label'       => esc_html__( 'Link Custom', 'allianz' ),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'allianz' ),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'link2_text!' => '',
                        'link2_type' => 'custom'
                    ]
                ]
            );
        $widget->end_controls_section();
        $widget->start_controls_section(
            'chart_section',
            [
                'label' => esc_html__('Chart Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $widget->add_control(
                'chart1_title',
                [
                    'label'   => esc_html__('Title #1', 'allianz'),
                    'type'    => Controls_Manager::TEXT
                ]
            );
            $widget->add_control(
                'chart1_color',
                [
                    'label'   => esc_html__('Color #1', 'allianz'),
                    'type'    => Controls_Manager::COLOR
                ]
            );
            $widget->add_control(
                'chart2_title',
                [
                    'label'   => esc_html__('Title #2', 'allianz'),
                    'type'    => Controls_Manager::TEXT
                ]
            );
            $widget->add_control(
                'chart2_color',
                [
                    'label'   => esc_html__('Color #2', 'allianz'),
                    'type'    => Controls_Manager::COLOR
                ]
            );
            $widget->add_control(
                'chart3_title',
                [
                    'label'   => esc_html__('Title #3', 'allianz'),
                    'type'    => Controls_Manager::TEXT
                ]
            );
            $widget->add_control(
                'chart3_color',
                [
                    'label'   => esc_html__('Color #3', 'allianz'),
                    'type'    => Controls_Manager::COLOR
                ]
            );
            // Chart Settings
            $chart = new Repeater();
            $chart->add_control(
                'chart_title',
                [
                    'label' => esc_html__('Group Title', 'allianz'),
                    'type' => Controls_Manager::TEXT
                ]
            );
            // chart item 1
            $chart->add_control(
                'chart1_value',
                [
                    'label' => esc_html__('Value', 'allianz'),
                    'type'  => Controls_Manager::TEXT
                ]
            );
            // chart item 2
            $chart->add_control(
                'chart2_value',
                [
                    'label' => esc_html__('Value', 'allianz'),
                    'type'  => Controls_Manager::TEXT
                ]
            );
            // chart item 3
            $chart->add_control(
                'chart3_value',
                [
                    'label' => esc_html__('Value', 'allianz'),
                    'type'  => Controls_Manager::TEXT
                ]
            );
            $widget->add_control(
                'cms_chart',
                [
                    'label'  => esc_html__( 'Chart Items', 'allianz' ),
                    'type'   => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $chart->get_controls(),
                    'default' => [
                        [
                            'chart_title'  => '2019',
                            'chart1_value' => 48,
                            'chart2_value' => 57,
                            'chart3_value' => 65,
                        ],
                        [
                            'chart_title'  => '2020',
                            'chart1_value' => 34,
                            'chart2_value' => 43,
                            'chart3_value' => 48,
                        ],
                        [
                            'chart_title'  => '2021',
                            'chart1_value' => 37,
                            'chart2_value' => 27,
                            'chart3_value' => 41,
                        ],
                        [
                            'chart_title'  => '2022',
                            'chart1_value' => 27,
                            'chart2_value' => 34,
                            'chart3_value' => 20,
                        ],
                        [
                            'chart_title'  => '2023',
                            'chart1_value' => 22,
                            'chart2_value' => 34,
                            'chart3_value' => 41,
                        ]
                    ],
                    'title_field' => '{{{ chart_title }}}',
                ]
            );
        $widget->end_controls_section();
        // Style
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'Style Settings', 'allianz' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
            $widget->add_control(
                'cms_chart_type',
                [
                    'label'   => esc_html__( 'Chart Type', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        ''          => __('Default','allianz'),
                        'line'      => __('Line','allianz'),
                        'bar'       => __('Vertical Bar','allianz')    
                    )
                ]
            );
            $widget->add_control(
                'cms_chart_dimensions',
                [
                    'label'        => esc_html__( 'Chart Width', 'allianz' ),
                    'type'         => \Elementor\Controls_Manager::SLIDER,
                    'control_type' => 'responsive',
                    'range' => [
                        'px' => [
                            'min' => 300,
                            'max' => 1280,
                        ]
                    ],
                    'default' => [
                        'size' => ''
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-charts-wrap' => 'max-width:{{SIZE}}px;' //max-height:{{SIZE}}px;
                    ]
                ]
            );
            $widget->add_control(
                'cms_chart_dimensions_h',
                [
                    'label'        => esc_html__( 'Chart Height', 'allianz' ),
                    'type'         => \Elementor\Controls_Manager::SLIDER,
                    'control_type' => 'responsive',
                    'range' => [
                        'px' => [
                            'min' => 300,
                            'max' => 1280,
                        ]
                    ],
                    'default' => [
                        'size' => 420
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-charts-bar' => 'min-height:{{SIZE}}px;' //max-height:{{SIZE}}px;
                    ]
                ]
            );
            $widget->add_control(
                'legend_display',
                [
                    'label'   => esc_html__( 'Show Legend', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        'true'  => __('Yes','allianz'),
                        'false' => __('No','allianz')
                    ),
                    'default' => 'false'
                ]
            );
            $widget->add_control(
                'legend_position',
                [
                    'label'   => esc_html__( 'Legend Position', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        'top'    => __('Top','allianz'),
                        'right'  => __('Right','allianz'),
                        'bottom' => __('Bottom','allianz'),
                        'left'   => __('Left','allianz')
                    ),
                    'default' => 'top',
                    'condition' => [
                        'legend_display' => 'true'
                    ]
                ]
            );
            $widget->add_control(
                'title_display',
                [
                    'label'   => esc_html__( 'Show Title', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        '1'  => __('Yes','allianz'),
                        '0' => __('No','allianz')
                    ),
                    'default' => '0'
                ]
            );
            $widget->add_control(
                'title_text',
                [
                    'label'   => esc_html__( 'Title', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => 'Your Title',
                    'condition' => [
                        'title_display' => '1'
                    ]
                ]
            );
            $widget->add_control(
                'title_position',
                [
                    'label'   => esc_html__( 'Title Position', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        'top'    => __('Top','allianz'),
                        'right'  => __('Right','allianz'),
                        'bottom' => __('Bottom','allianz'),
                        'left'   => __('Left','allianz')
                    ),
                    'default' => 'top',
                    'condition' => [
                        'title_display' => '1'
                    ]
                ]
            );
        $widget->end_controls_section();
    }
}