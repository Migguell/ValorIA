<?php
$html_id            = etc_get_element_id( $settings );
$active_section     = $widget->get_settings('active_section', 1);
$accordions         = $widget->get_settings('cms_accordion_scroll',[]);
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-accordion-scroll',
		'cms-accordion-scroll-'.$settings['layout'],
		'cms-sticky-enable'
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php 
	$count = -1;
	$spacing = 134;
	
	foreach ( $accordions as $key => $value ):
		$count ++;
		$spacing_top = ($count*$spacing) + 10;
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
				'btn-hover-'.$link1_color_hover,
				'cms-hover-move-icon-up'
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
				'btn-hover-'.$link2_color_hover,
				'text-'.$link2_color,
				'text-hover-primary'
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
				'cms-sticky-item',
				'elementor-repeater-item-' . $value['_id'],
				$is_active ? 'active' : '',
				!empty($value['bg_color']) ? 'bg-'.$value['bg_color'] : 'bg-primary',
				'hover-icon-bounce pb-50 cms-radius-8',
				'cms-sticky',
				//'max-h100vh',
				//'mb-100',
				'cms-enable-scrollwheel'
			],
			'data-sticky-top' => $spacing_top,
			'style' => '--cms-sticky-top:'.$spacing_top.'px;',
		]);
		// Title
		$title_key = $widget->get_repeater_setting_key( 'ac_title', 'cms_accordion_scroll', $key );
		$widget->add_render_attribute( $title_key, [
			'class' => [ 
				'cms-accordion-title',
				'cms-sticky-title',
				'flex-basic',
				'text-'.$widget->get_setting('title_color','white'),
				'text-hover-'.$widget->get_setting('title_active_color','white'),
				'text-active-'.$widget->get_setting('title_active_color','white'),
				'text-22',
				'pt-50 pb-60'
			],
		]);	
		// Content
		$content_key = $widget->get_repeater_setting_key( 'ac_content', 'cms_accordion_scroll', $key );
		$widget->add_render_attribute( $content_key, [
			'id'    => $_id . $html_id,
			'class' => [ 
				'cms-sticky-content',
				'cms-scrollwheel',
				'text-'.$widget->get_setting('content_color','body'),
				'd-flex gutter0'
			],
			//'style' => '--cms-scrollwheel-height:calc(100% - '.$spacing.'px);'
		]);
	?>
	<div <?php etc_print_html( $widget->get_render_attribute_string( $item_key ) ); ?>>
		<div class="container overflow-hidden">
			<h3 <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php 
	    	etc_print_html( $ac_title ); 
	    ?></h3>
		  <div <?php etc_print_html( $widget->get_render_attribute_string( $content_key ) ); ?>>
				<div class="col-6 col-mobile-extra-12">
			    <div class="d-flex gap-40">
			    	<div class="flex-auto empty-none"><?php
				    	allianz_elementor_icon_render($ac_icon, [], ['icon_size' => 68, 'icon_color' => 'white','icon_color_hover'=>'accent', 'class' => 'cms-sticky cms-sticky-0'], 'div');
			    	?></div>
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
					    	<?php if(!empty($ac_feature_icon_3['value']) || !empty($ac_feature_title_3) || !empty($ac_feature_desc_3)){ ?>
					    		<div class="ac-feature"><?php
					    			allianz_elementor_icon_render($ac_feature_icon_3, [], ['class'=>'ac-feature-icon', 'icon_size' => 48, 'icon_color' => 'white','icon_color_hover'=>'accent'], 'div');
					    			?>
					    			<div class="ac-feature-content">
					    			<?php
								  		etc_print_html('<div class="text-18 text-white pb-10">'.$ac_feature_title_3.'</div>');
								  		etc_print_html($ac_feature_desc_3);
						    		?></div>
						    	</div>
						    <?php } ?>
				    	</div>
				    	<?php if(!empty($value['link1_text']) || !empty($value['link2_text'])){ ?>
					    	<div class="ac-buttons d-flex gap-40 pt-10">
					    		<?php if(!empty($value['link1_text'])) { ?>
						    		<a <?php etc_print_html( $widget->get_render_attribute_string( $link1_text ) ); ?>>
											<?php 
												// text
												echo esc_html( $value['link1_text'] ); 
												// icon
												allianz_elementor_button_icon_render();
											?>
										</a>
									<?php }
									if(!empty($value['link2_text'])) { ?>
										<a <?php etc_print_html( $widget->get_render_attribute_string( $link2_text ) ); ?>>
											<?php echo esc_html( $value['link2_text'] ); ?>
										</a>
									<?php } ?>
					    	</div>
					    <?php } ?>
			    	</div>
			    </div>
			 	</div>
				<div class="col-6 col-mobile-extra-12">
					<div class="inner pl-70 pl-tablet-extra-0 cms-sticky cms-sticky-0"><?php 
		  			ob_start();
			  		?>
			  			<div class="ac-banner-counter-content pt-30 pb-25 p-lr-25 bg-white cms-radius-8 cms-shadow-3 text-14 text-center"><?php
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
								'img_class'      => 'cms-radius-10 img-cover',
								'custom_size'    => ['width' => 550, 'height' => 367],
								'as_background'	 => true,
								'as_background_class' => 'pt-65 pb-40 pl-40 pl-smobile-20',
								'content'			   => $ac_bc_banner_content, 
								'before'				 => '',
								'after'					 => ''	
			  			]);    			
			  	?></div>
			  </div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>