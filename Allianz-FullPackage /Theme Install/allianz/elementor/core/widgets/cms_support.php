<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if (!function_exists('allianz_widget_cms_support_register_controls')) {
    add_action('etc_widget_cms_support_register_controls', 'allianz_widget_cms_support_register_controls', 10, 1);
    function allianz_widget_cms_support_register_controls($widget)
    {
        // Layout Settings
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__( 'Layout', 'allianz' ),
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_support/layout/1.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();

        // Title Section Start
        $widget->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__('Content', 'allianz'),
                'tab'       => Controls_Manager::TAB_CONTENT
            ]
        );
        $widget->add_control(
            'title',
            [
				'label'       => esc_html__('Title','allianz'),
				'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Enter your title',
				'placeholder' => esc_html__('Enter your title', 'allianz'),
            ]
        );
        $widget->add_control(
            'description',
            [
                'label'       =>  esc_html__('Description','allianz'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Enter your description',  
                'placeholder' => esc_html__('Enter your description', 'allianz')
            ]
        );
        $widget->add_control(
            'phone',
            [
                'label'       =>  esc_html__('Phone','allianz'),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => '02 01061245741'
            ]
        );
        $widget->add_control(
            'address',
            [
                'label'       =>  esc_html__('Address','allianz'),
                'label_block' => true,
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Brooklyn, New York, USA'
            ]
        );
        $widget->add_control(
            'time',
            [
                'label'       =>  esc_html__('Time (Mon-Fri)','allianz'),
                'label_block' => true,
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => '8:00 am - 7:00 pm',
                'condition'   => [
                    'layout' => ['2']
                ]
            ]
        );
        $widget->add_control(
            'email_text',
            [
                'label'       =>  esc_html__('Email Text','allianz'),
                'label_block' => true,
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Allianz@7oroof.com'
            ]
        );
        $widget->add_control(
            'email',
            [
                'label'       =>  esc_html__('Email Address','allianz'),
                'label_block' => false,
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Allianz@7oroof.com',
                'condition'   => [
                    'email_text!' => ''
                ]  
            ]
        );
        $widget->add_control(
            'btn_text',
            [
                'label'       => esc_html__( 'Button', 'allianz' ),
                'description' => esc_html__( 'Button Text', 'allianz' ),  
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Talk To An Expert', 'allianz' ),
                'placeholder' => esc_html__('Talk To An Expert', 'allianz' ),
                'label_block' => true  
            ]
        );
        $widget->add_control(
            'btn_type',
            [
                'label'   => esc_html__('Link Type', 'allianz'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'custom' => esc_html__('Custom', 'allianz'),
                    'page'   => esc_html__('Page', 'allianz'),
                ],
                'default' => 'custom',
                'condition' => [
                    'btn_text!' => ''
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
                    'btn_text!' => '',
                    'btn_type' => 'page'
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
                    'btn_text!' => '',
                    'btn_type' => 'custom'
                ]
            ]
        );
        $widget->end_controls_section();
        $widget->start_controls_section(
            'banner_section',
            [
                'label' => esc_html__('Banner Settings','allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $widget->add_control(
                'banner_gradient',
                [
                    'label'     => esc_html__( 'Gradient Style', 'allianz' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => allianz_elementor_gradient_opts(),
                    'default'   => '',
                    'separator' => 'before'
                ]
            );
            $widget->add_control(
                'banner',
                [
                    'label'   => esc_html__( 'Banner', 'allianz' ),
                    'type'    => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
            $widget->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'banner',
                    'label'   => esc_html__('Image Size','allianz'),
                    'default' => 'custom',
                    'condition' => [
                        'banner[url]!' => ''
                    ]
                ]
            );
        $widget->end_controls_section();
        // Style
        $widget->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings','allianz'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'info_color',
                'label'    => esc_html__( 'Phone/Address Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-sinfo' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'info_hover_color',
                'label'    => esc_html__( 'Phone/Address Hover Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-sinfo:hover' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'btn_bg_hover_color',
                'label'    => esc_html__( 'Button Background Hover Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .btn:hover' => 'background-color: {{VALUE}};',
                ]
            ]);
        $widget->end_controls_section();
    }
}
