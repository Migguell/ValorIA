<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

if (!function_exists('allianz_widget_cms_contact_form_register_controls')) {
    add_action('etc_widget_cms_contact_form_register_controls', 'allianz_widget_cms_contact_form_register_controls', 10, 1);
    function allianz_widget_cms_contact_form_register_controls($widget)
    {
        $cf7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');
        $contact_forms = array();
        if ($cf7) {
            foreach ($cf7 as $cform) {
                $contact_forms[$cform->ID] = $cform->post_title;
            }
        } else {
            $contact_forms[0] = esc_html__('No contact forms found', 'allianz');
        }
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_contact_form/layout/1.jpg'
                        ],
                        '2' => [
                            'label' => esc_html__( 'Layout 2', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_contact_form/layout/2.webp'
                        ],
                        '3' => [
                            'label' => esc_html__( 'Layout 3', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_contact_form/layout/3.webp'
                        ],
                        '4' => [
                            'label' => esc_html__( 'Layout 4', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_contact_form/layout/4.webp'
                        ],
                        '5' => [
                            'label' => esc_html__( 'Layout 5', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_contact_form/layout/5.webp'
                        ],
                        '6' => [
                            'label' => esc_html__( 'Layout 6', 'allianz' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_contact_form/layout/6.webp'
                        ]
                    ]
                ]
            );
        $widget->end_controls_section();
        // Source Section Start
        $widget->start_controls_section(
            'source_section',
            [
                'label' => esc_html__('Form Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $widget->add_control(
                'ctf7_popup_title',
                [
                    'label'       => esc_html__('Popup Field Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true,
                    'separator'   => 'before',
                    'condition'   => [
                        'layout' => ['2']
                    ]
                ]
            );
            $widget->add_control(
                'ctf7_slug',
                [
                    'label'       => esc_html__('Select Form', 'allianz'),
                    'type'        => Controls_Manager::SELECT,
                    'options'     => $contact_forms,
                    'label_block' => true,
                    'separator'   => 'before'
                ]
            );
            $widget->add_control(
                'ctf7_title_icon',
                [
                    'label'       => esc_html__('Form Title Icon', 'allianz'),
                    'type'        => Controls_Manager::ICONS,
                    'skin'        => 'inline',
                    'label_block' => true,
                ]
            );
            $widget->add_control(
                'ctf7_title',
                [
                    'label'       => esc_html__('Form Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
            );
            $widget->add_control(
                'ctf7_description',
                [
                    'label'   => esc_html__('Form Description', 'allianz'),
                    'type'    => Controls_Manager::TEXTAREA,
                    'show_label' => true,
                ]
            );
            $widget->add_control(
                'ctf7_note',
                [
                    'label'       => esc_html__('Form Note', 'allianz'),
                    'description' => esc_html__('Add your note after Submit button', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'show_label'  => true,
                ]
            );
            $widget->add_control(
                'ctf7_bg',
                [
                    'label'       => esc_html__('Background Image', 'allianz'),
                    'type'        => Controls_Manager::MEDIA,
                    'show_label'  => true,
                    'label_block' => false,
                    'selectors'   => [
                        '{{WRAPPER}} .cms-bg-img' => '--cms-bg-img: url({{URL}})',
                    ]
                ]
            );
        $widget->end_controls_section();
        // Form Banner
        $widget->start_controls_section(
            'banner_section',
            [
                'label' => esc_html__('Form Banner', 'allianz'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );  
            // Banner
            $widget->add_control(
                'banner',
                [
                    'label'   => esc_html__( 'Banner', 'allianz' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'skin'  => 'inline',
                    'label_block' => false,
                    'condition' => [
                        'layout' => ['3','4']
                    ]
                ]
            );
            // icon
            allianz_elementor_icon_image_settings($widget, [
                'name'     => 'ctf7_banner_icon',
                'group'    => false, 
                'img_size' => false,
                'icon_default' => [
                    'library' => 'allianz-icon',
                    'value'   => 'allianz-icon-arrow-right-up'
                ],
                'label_block' => false,
                'condition' => [
                    'layout' => ['3']
                ]
            ]);
            // counter
            $widget->add_control(
                'ctf7_banner_counter_total',
                [
                    'label'       => esc_html__('Total Value', 'allianz'),
                    'type'        => Controls_Manager::NUMBER,
                    'default'     => 30000,
                    'condition' => [
                        'layout' => ['4']
                    ]
                ]
            );
            $widget->add_control(
                'ctf7_banner_counter_total_color',
                [
                    'label'       => esc_html__('Your Value Color', 'allianz'),
                    'type'        => Controls_Manager::COLOR,
                    'default'     => 'rgba(255,255,255,0.5)',
                    'condition' => [
                        'layout' => ['4']
                    ]
                ]
            );
            $widget->add_control(
                'ctf7_banner_counter',
                [
                    'label'       => esc_html__('Your Value', 'allianz'),
                    'type'        => Controls_Manager::NUMBER,
                    'default'     => 6154,
                    'condition' => [
                        'layout' => ['4']
                    ]
                ]
            );
            $widget->add_control(
                'ctf7_banner_counter_color',
                [
                    'label'       => esc_html__('Your Value Color', 'allianz'),
                    'type'        => Controls_Manager::COLOR,
                    'default'     => '#fe5b2c',
                    'condition' => [
                        'layout' => ['4']
                    ]
                ]
            );
            // title
            $widget->add_control(
                'ctf7_banner_title',
                [
                    'label'       => esc_html__('Title', 'allianz'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Speak to one of our advisers and get free advice!' ,
                    'condition' => [
                        'layout' => ['3','4']
                    ]
                ]
            );
            $widget->add_control(
                'ctf7_banner_description',
                [
                    'label'      => esc_html__('Description', 'allianz'),
                    'type'       => Controls_Manager::TEXTAREA,
                    'default'    => 'Speak to one of our financial advisers over the phone or just submit your details and we’ll be in touch shortly!',
                    'condition' => [
                        'layout' => ['3']
                    ]
                ]
            );
            $features = new Repeater;
                $features->add_control(
                    'ctf7_banner_feature',
                    [
                        'label'   => esc_html__('Title', 'allianz'),
                        'type'    => Controls_Manager::TEXTAREA,
                        'show_label' => true,
                    ]
                );
            $widget->add_control(
                'ctf7_banner_features',
                [
                    'label'       => esc_html__('Features List', 'allianz'),
                    'type'        => Controls_Manager::REPEATER,
                    'label_block' => true,
                    'fields'      => $features->get_controls(),
                    'title_field' => '{{ctf7_banner_feature}}',
                    'default'     => [
                        [
                            'ctf7_banner_feature' => 'Diversity of ideas for investors funds!'
                        ],
                        [
                            'ctf7_banner_feature' => 'Helping in make smart financial decisions.'
                        ],
                        [
                            'ctf7_banner_feature' => 'No hidden fees, and no obligation'
                        ]
                    ],
                    'condition' => [
                        'layout' => ['3']
                    ]
                ]
            );
        $widget->end_controls_section();
        // Style
        $widget->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style Settings', 'allianz'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'ctf7_popup_title_color',
                'label'     => esc_html__( 'Pupup Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-ecf7-field-popup' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout' => ['2']
                ]
            ]);
            $widget->add_control(
                'popup_cursor_color',
                [
                    'label'     => esc_html__( 'Pupup Cursor Color', 'allianz' ),
                    'type'        => Controls_Manager::SELECT,
                    'options'   => [
                        ''      => esc_html__('Default', 'allianz'),
                        '-white' => esc_html__('White', 'allianz'),
                        '-black' => esc_html__('Black', 'allianz')
                    ],
                    'condition' => [
                        'layout' => ['2']
                    ]
                ]
            );
            allianz_elementor_colors_opts($widget,[
                'name'     => 'heading_bg_color',
                'label'     => esc_html__( 'Heading Background Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .banner-title' => 'background-color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'icon_color',
                'label'     => esc_html__( 'Icon Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-banner-icon' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'title_color',
                'label'     => esc_html__( 'Title Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'desc_color',
                'label'     => esc_html__( 'Description Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'note_color',
                'label'     => esc_html__( 'Note Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-note' => 'color: {{VALUE}};',
                ]
            ]);
            allianz_elementor_colors_opts($widget,[
                'name'     => 'bg_color',
                'label'     => esc_html__( 'Background Color', 'allianz' ),
                'selector' => [
                    '{{WRAPPER}} .cms-bg-img' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'layout' => ['5']
                ]
            ]);
        $widget->end_controls_section();
    }
}
