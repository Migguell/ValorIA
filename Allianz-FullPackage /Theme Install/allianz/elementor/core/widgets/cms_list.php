<?php 
use Elementor\Controls_Manager;
use Elementor\Repeater;
add_action('etc_widget_cms_list_register_controls', 'allianz_widget_cms_list_register_controls', 10, 1);
if (!function_exists('allianz_widget_cms_list_register_controls')) {
  function allianz_widget_cms_list_register_controls($widget){
  	
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
                      'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_list/layout/1.webp'
                  ]
              ]
          ]
      );
  	$widget->end_controls_section();
		// Lists 1
	  $widget->start_controls_section('list_section',[
	      'label' => esc_html__('List Settings', 'allianz'),
	      'tab'   => Controls_Manager::TAB_CONTENT,
	  ]);
  		$lists = new Repeater();
      $lists->add_control(
          'link_text',
          [
              'label'       => esc_html__( 'Title', 'allianz' ),
              'type'        => Controls_Manager::TEXT,
              'default'     => 'Discover More',
              'placeholder' => esc_html__( 'Enter your text', 'allianz' ),
              'separator' => 'before'
          ]
      );
      $lists->add_control(
          'link_type',
          [
              'label'   => esc_html__('Link Type', 'allianz'),
              'type'    => Controls_Manager::SELECT,
              'options' => [
									'custom'       => esc_html__('Custom', 'allianz'),
									'page'         => esc_html__('Page', 'allianz'),
									'cms-industry' => esc_html__('Industry', 'allianz'),
              ],
              'default' => 'custom',
              'condition' => [
                  'link_text!' => ''
              ]
          ]
      );
      $lists->add_control(
          'link_page',
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
      $lists->add_control(
        'link_industry',
        [
          'label'   => esc_html__('Select Industry', 'allianz'),
          'type'    => Elementor_Theme_Core::POSTS_CONTROL,
          'post_type' => [
              'cms-industry'
          ],
          'multiple'  => false,
          'condition' => [
            'link_text!' => '',
            'link_type'  => 'cms-industry'
          ]
        ]
      );
      $lists->add_control(
          'link_custom',
          [
              'label'       => esc_html__( 'Link Custom', 'allianz' ),
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
	    	'cms_lists',
	    	[
					'label' => esc_html__( 'CMS List #1', 'allianz' ),
					'type'  => Controls_Manager::REPEATER,
					'fields' => $lists->get_controls(),
	        'default' => [
	          [
							'link_text'     => 'Your Title #1',
							'link_type'     => 'custom',
							'link_page'     => '',
							'link_industry' => '',
							'link_custom'   => ['url' => '#'],
	          ],
	          [
							'link_text'     => 'Your Title #2',
							'link_type'     => 'custom',
							'link_page'     => '',
							'link_industry' => '',
							'link_custom'   => ['url' => '#'],
	          ],
	          [
							'link_text'     => 'Your Title #3',
							'link_type'     => 'custom',
							'link_page'     => '',
							'link_industry' => '',
							'link_custom'   => ['url' => '#'],
	          ],
	          [
							'link_text'     => 'Your Title #4',
							'link_type'     => 'custom',
							'link_page'     => '',
							'link_industry' => '',
							'link_custom'   => ['url' => '#'],
	          ]
	        ],
	        'title_field'	 => '{{link_text}}'
	    	]
    	);
    	// Lists 2
    	$widget->add_control(
	    	'cms_lists2',
	    	[
					'label' => esc_html__( 'CMS List #2', 'allianz' ),
					'type'  => Controls_Manager::REPEATER,
					'fields' => $lists->get_controls(),
	        'default' => [
	          [
							'link_text'     => 'Your Title #1',
							'link_type'     => 'custom',
							'link_page'     => '',
							'link_industry' => '',
							'link_custom'   => ['url' => '#'],
	          ],
	          [
							'link_text'     => 'Your Title #2',
							'link_type'     => 'custom',
							'link_page'     => '',
							'link_industry' => '',
							'link_custom'   => ['url' => '#'],
	          ],
	          [
							'link_text'     => 'Your Title #3',
							'link_type'     => 'custom',
							'link_page'     => '',
							'link_industry' => '',
							'link_custom'   => ['url' => '#'],
	          ],
	          [
							'link_text'     => 'Your Title #4',
							'link_type'     => 'custom',
							'link_page'     => '',
							'link_industry' => '',
							'link_custom'   => ['url' => '#'],
	          ]
	        ],
	        'title_field' => '{{link_text}}'
	    	]
    	);
			// Link #1
	    allianz_elementor_colors_opts($widget,[
	        'name'      => 'link_color',
	        'label'     => esc_html__( 'Link Color', 'allianz' ),
	        'custom'    => false,
	    ]);
	    allianz_elementor_colors_opts($widget,[
	        'name'      => 'link_bg_color',
	        'label'     => esc_html__( 'Link Background Color', 'allianz' ),
	        'custom'    => false,
	    ]);
	    allianz_elementor_colors_opts($widget,[
	        'name'   => 'link_color_hover',
	        'label'  => esc_html__( 'Link Color Hover', 'allianz' ),
	        'custom' => false,
	    ]);
	    allianz_elementor_colors_opts($widget,[
	        'name'      => 'link_bg_hover_color',
	        'label'     => esc_html__( 'Link Background Hover Color', 'allianz' ),
	        'custom'    => false,
	    ]);
		$widget->end_controls_section();
		allianz_elementor_grid_columns_settings($widget);
	}
}
?>