<?php
$html_id            = etc_get_element_id( $settings );
$active_section     = $widget->get_settings('active_section', 1);
$accordions         = $widget->get_settings('cms_accordion_scroll',[]);
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-accordion-scroll',
		'cms-accordion-scroll-'.$settings['layout']
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php 
	$count = -1;
	foreach ( $accordions as $key => $value ):
		$count ++;
		$spacing_top = $count*117;
		$is_active          = ( $key + 1 ) == $active_section;
		$_id                = isset($value['_id']) ? $value['_id'] : '';
		$ac_title           = isset($value['ac_title']) ? $value['ac_title'] : '';
		$ac_content         = isset($value['ac_content']) ? $value['ac_content'] : '';
		$ac_icon            = isset($value['ac_icon']) ? $value['ac_icon'] : ['library'=>'','value'=>''];

		$ac_feature_icon_1  = isset($value['ac_feature_icon_1'])?$value['ac_feature_icon_1']:['library'=>'','value'=>''];
		$ac_feature_title_1 = isset($value['ac_feature_title_1'])?$value['ac_feature_title_1']:'';
		$ac_feature_desc_1  = isset($value['ac_feature_desc_1'])?$value['ac_feature_desc_1']:'';
		$ac_feature_icon_2  = isset($value['ac_feature_icon_2'])?$value['ac_feature_icon_2']:['library'=>'','value'=>''];
		$ac_feature_title_2 = isset($value['ac_feature_title_2'])?$value['ac_feature_title_2']:'';
		$ac_feature_desc_2  = isset($value['ac_feature_desc_2'])?$value['ac_feature_desc_2']:'';
		$ac_feature_icon_3  = isset($value['ac_feature_icon_3'])?$value['ac_feature_icon_3']:['library'=>'','value'=>''];
		$ac_feature_title_3 = isset($value['ac_feature_title_3'])?$value['ac_feature_title_3']:'';
		$ac_feature_desc_3  = isset($value['ac_feature_desc_3'])?$value['ac_feature_desc_3']:'';
		// Link 1
		$link1_page = $value['link1_page'];
		switch ($value['link1_type']) {
			case 'page':
				$page = !empty($link1_page) ? get_page_by_path($link1_page, OBJECT) : [];
				$url  = !empty($page) ? get_permalink($page->ID) : '#';
				break;
			
			default:
				$url = $value['link1_custom']['url'];
				break;
		}
		$link1_text        = $widget->get_repeater_setting_key( 'link1_text', 'cms_accordion_scroll', $key );
		$link1_color       = !empty($value['link1_color']) ? $value['link1_color'] : 'white';
		$link1_color_hover = !empty($value['link1_color_hover']) ? $value['link1_color_hover'] : 'white';
		$widget->add_render_attribute( $link1_text, [
			'class' => [
				'btn btn-lg',
				'btn-'.$link1_color,
				'btn-hover-'.$link1_color_hover
			],
			'href'	=> $url
		]);
		// Link 2
		$link2_page = $value['link2_page'];
		switch ($value['link2_type']) {
			case 'page':
				$page = !empty($link2_page) ? get_page_by_path($link2_page, OBJECT) : [];
				$url  = !empty($page) ? get_permalink($page->ID) : '#';
				break;
			
			default:
				$url = $value['link2_custom']['url'];
				break;
		}
		$link2_text = $widget->get_repeater_setting_key( 'link2_text', 'cms_accordion_scroll', $key );
		$link2_color       = !empty($value['link2_color']) ? $value['link2_color'] : 'white';
		$link2_color_hover = !empty($value['link2_color_hover']) ? $value['link2_color_hover'] : 'white';
		$widget->add_render_attribute( $link2_text, [
			'class' => [
				'btn btn-outline btn-lg',
				'btn-outline-'.$link2_color,
				'btn-outline-hover-'.$link2_color_hover,
				'text-'.$link2_color,
				'text-hover-'.$link2_color_hover
			],
			'href'	=> $url
		]);
		// Banner  & Counter
		$ac_bc_banner  = isset($value['ac_bc_banner']) ? $value['ac_bc_banner'] : [];
		$ac_bc_counter = isset($value['ac_bc_counter']) ? $value['ac_bc_counter'] : '';
		$ac_bc_desc    = isset($value['ac_bc_desc']) ? $value['ac_bc_desc'] : '';
		// Items
		$item_key = $widget->get_repeater_setting_key( 'ac_items', 'cms_accordion_scroll', $key );
		$widget->add_render_attribute($item_key, [
			'class' => [
				'cms-accs-item',
				//'relative cms-scroller-sticky',
				$is_active ? 'active' : '',
				!empty($value['bg_color']) ? 'bg-'.$value['bg_color'] : 'bg-primary',
				'hover-icon-bounce p-50 p-laptop-40 p-lr-tablet-20 cms-radius-8 mb-100',
				'cms-sticky cms-sticky-mousewheel',
				'overflow-hidden'
			],
			'data-offset' => $spacing_top,
			'style' => [
				'--cms-sticky-top:'.$spacing_top.'px;',
				(!empty($value['bg_color_custom']) && $value['bg_color'] =='custom') ? '--cms-bg-custom:'.$value['bg_color_custom'].';' : ''
			]
		]);
		// Items Inner
		$item_inner_key = $widget->get_repeater_setting_key( 'ac_items_inner', 'cms_accordion_scroll', $key );
		$widget->add_render_attribute($item_inner_key, [
			'class' => [
				'cms-accs--item',
				'cms-sticky--mousewheel'
			]
		]);
		// Title
		$title_key = $widget->get_repeater_setting_key( 'ac_title', 'cms_accordion_scroll', $key );
		$widget->add_render_attribute( $title_key, [
			'class' => [ 
				'cms-accs-title-text',
				'flex-basic',
				'text-'.$widget->get_setting('title_color','white'),
				'text-hover-'.$widget->get_setting('title_active_color','white'),
				'text-active-'.$widget->get_setting('title_active_color','white'),
				'text-22',
				'pb-60'
			],
		] );
		$widget->add_inline_editing_attributes($title_key);

		$content_key = $widget->get_repeater_setting_key( 'ac_content', 'cms_accordion_scroll', $key );
		$widget->add_render_attribute( $content_key, [
			'id'    => $_id . $html_id,
			'class' => [ 
				'cms-acc-content',
				'text-'.$widget->get_setting('content_color','body'),
				'd-flex gutter-40'
			],
		] );
		$widget->add_inline_editing_attributes($content_key);
	?>
	<div <?php etc_print_html( $widget->get_render_attribute_string( $item_key ) ); ?>>
		<div class="container">
			<h3 <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php 
	    	etc_print_html( $ac_title ); 
	    ?></h3>
		</div>
		<div <?php etc_print_html( $widget->get_render_attribute_string( $item_inner_key ) ); ?>>
			<div class="container">
				
			  <div <?php etc_print_html( $widget->get_render_attribute_string( $content_key ) ); ?>>
					<div class="col-6 col-mobile-extra-12">
				    <div class="d-flex gap-40">
				    	<?php
					    	allianz_elementor_icon_render($ac_icon, [], ['icon_size' => 68, 'icon_color' => 'white','icon_color_hover'=>'accent'], 'div');
				    	?>
				    	<div class="flex-basic">
				    		<div class="accs-desc"><?php
				    			etc_print_html($ac_content);
				    		?></div>
				    		<div class="ac-features text-15">
					    		<div class="ac-feature"><?php
					    			allianz_elementor_icon_render($ac_feature_icon_1, [], ['class'=>'ac-feature-icon', 'icon_size' => 48, 'icon_color' => 'white','icon_color_hover'=>'accent'], 'div');
					    			?>
					    			<div class="ac-feature-content">
					    			<?php
								  		etc_print_html('<div class="text-18 text-white pb-10">'.$ac_feature_title_1.'</div>');
								  		etc_print_html($ac_feature_desc_1);
						    		?></div>
						    	</div>
					    		<div class="ac-feature"><?php
					    			allianz_elementor_icon_render($ac_feature_icon_2, [], ['class'=>'ac-feature-icon', 'icon_size' => 48, 'icon_color' => 'white','icon_color_hover'=>'accent'], 'div');
							  		?>
					    			<div class="ac-feature-content">
					    			<?php
					    				etc_print_html('<div class="text-18 text-white pb-10">'.$ac_feature_title_2.'</div>');
								  		etc_print_html($ac_feature_desc_2);
						    		?></div>
						    	</div>
					    		<div class="ac-feature"><?php
					    			allianz_elementor_icon_render($ac_feature_icon_3, [], ['class'=>'ac-feature-icon', 'icon_size' => 48, 'icon_color' => 'white','icon_color_hover'=>'accent'], 'div');
					    			?>
					    			<div class="ac-feature-content">
					    			<?php
								  		etc_print_html('<div class="text-18 text-white pb-10">'.$ac_feature_title_3.'</div>');
								  		etc_print_html($ac_feature_desc_3);
						    		?></div>
						    	</div>
					    	</div>
					    	<div class="ac-buttons d-flex gap-40 pt-10">
					    		<a <?php etc_print_html( $widget->get_render_attribute_string( $link1_text ) ); ?>>
										<?php echo esc_html( $value['link1_text'] ); ?>
										<i class="cms-btn-icon allianz-icon-up-right-arrow rtl-flip text-12"></i>
									</a>
									<a <?php etc_print_html( $widget->get_render_attribute_string( $link2_text ) ); ?>>
										<?php echo esc_html( $value['link2_text'] ); ?>
									</a>
					    	</div>
				    	</div>
				    </div>
				 	</div>
					<div class="col-6 col-mobile-extra-12">
						<div class="inner pl-70 pl-tablet-extra-0"><?php 
			  			ob_start();
				  		?>
				  			<div class="ac-banner-counter-content absolute bottom-left mb-40 ml-40 pt-30 pb-25 p-lr-25 bg-white cms-radius-8 cms-shadow-3 text-14 text-center"><?php
				  				allianz_elementor_counter_chart_render($widget, $value, [
					  				'value' => $ac_bc_counter,
					  				'size'	=> 115,
					  				// Stroke BG
					  				'stroke_bg'   => 'border',
					  				'stroke_bg_w' => 3,
					  				// Stroke
					  				'stroke_w'	=> 3,
					  				//text
					  				'text_class' => 'cms-heading text-nowrap flex-nowrap',
					  				// wrap
					  				'wrap_class' => 'm-lr-auto mb-15'
					  			]);
									etc_print_html('<div class="content text-primary">'.$ac_bc_desc.'</div>');
				  			?></div>
				  		<?php
				  			
				  		$ac_bc_banner_content = ob_get_clean();
				  			allianz_elementor_image_render($value, [
									'name'           => 'ac_bc_banner',
									'image_size_key' => 'ac_bc_banner',
									'img_class'      => 'cms-radius-10',
									'custom_size'    => ['width' => 550, 'height' => 367],
									'before'				 => '<div class="ac-banner-counter relative">',
									'after'					 => $ac_bc_banner_content.'</div>'	
				  			]);    			
				  	?></div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>