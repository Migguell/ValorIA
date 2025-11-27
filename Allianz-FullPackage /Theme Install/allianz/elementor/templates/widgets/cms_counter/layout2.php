<?php
$counters = $widget->get_setting('counters', []);
if(empty($counters)) return;
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','accent'),
		'pb-20 mt-n7',
		'text-16 font-700',
		'empty-none'
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'text-22 lh-1375',
		'pb-25 mt-n7'
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold font-700 empty-none',
		'text-'.$widget->get_setting('description_bold_color','heading'),
		'pb-25'
	])
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc empty-none',
		'text-'.$widget->get_setting('description_color','body')
	])
]);
// Signature
$widget->add_render_attribute('signature-wrap',[
	'class' => [
		'cms-signature relative',
		'd-inline-flex',
		'mt-10 pt-20 pb-55 pr-40'
	]
]);
//
$widget->add_inline_editing_attributes( 'sname' );
$widget->add_render_attribute('sname', [
	'class' => [
		'sname',
		'text-17 font-700',
		'text-'.$widget->get_setting('heading_color','heading'),
	]
]);
//
$widget->add_inline_editing_attributes( 'sposition' );
$widget->add_render_attribute('sposition', [
	'class' => [
		'sposition',
		'text-14 pt-5',
		'text-'.$widget->get_setting('heading_color','heading')
	]
]);
// Button
$btn_link = $widget->get_setting('btn_link','');
switch ($settings['btn_type']) {
	case 'page':
		$btn_page = !empty($btn_link) ? get_page_by_path($btn_link, OBJECT) : [];
		$btn_url  = !empty($btn_page) ? get_permalink($btn_page->ID) : '#';
		break;
	
	default:
		$btn_url = $widget->get_setting('btn_custom_link', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'btn_text', [
	'class' => [
		'btn btn-space-30',
		'btn-'.$widget->get_setting('btn_color','accent'),
		'text-'.$widget->get_setting('btn_text_color','white'),
		'btn-hover-'.$widget->get_setting('btn_color_hover','accent'),
		'text-hover-'.$widget->get_setting('btn_text_hover_color','white'),
		'mt-40',
		'cms-hover-move-icon-up'
	],
	'href'	=> $btn_url
]);

// Items
$widget->add_render_attribute( 'counter-item',[
	'class' => [
		'counter-item',
		'd-flex gutter-0 pt-27 pb-23',
		($settings['layout_mode'] === 'carousel') ? 'swiper-slide' : 'bdr-b-1',
		'hover-icon-bounce'
	]
]);
// Number
$widget->add_render_attribute('counter--number',[
	'class' => [
		'cms-counter-numbers text-25 cms-heading d-flex lh-1',
		'text-'.$widget->get_setting('number_color','primary')
	]
]);
$widget->add_render_attribute('icon', [
	'class' => [
		'cms-icon cms-counter-icon empty-none flex-auto',
		'text-'.$widget->get_setting('icon_color','primary')
	]
]);
// Title
$widget->add_inline_editing_attributes( 'title');
$widget->add_render_attribute('title', [
	'class' => [
		'cms-counter-title text-18 font-600',
		'text-'.$widget->get_setting('title_color','heading')
	]
]);
// Description
$widget->add_inline_editing_attributes( 'description');
$widget->add_render_attribute('description', [
	'class' => [
		'cms-counter-desc text-14 pt-15',
		'text-'.$widget->get_setting('desc_color','body')
	]
]);
// Layout mode setting
// Carousel Settings
$widget->add_render_attribute('carousel-settings',[
    'class' => [
    	'cms-ecounter',
    	'cms-ecounter-'.$widget->get_setting('layout', '1'),
        'cms-carousel swiper',
    ]
]);
// Grid Settings
$widget->add_render_attribute('grid-settings',[
    'class' => [
    	'cms-ecounter',
    	'cms-ecounter-'.$widget->get_setting('layout', '1'),
        'cms-counter-grid',
        'd-flex',
        allianz_elementor_get_grid_columns($widget, $settings, ['prefix_class' => 'flex-col-'])
    ]
]);
?>
<div class="d-flex gutter">
	<div class="cms-counter-banner col-6 col-mobile-extra-4 col-mobile-12"><?php
		ob_start();
			allianz_elementor_image_render($settings,[
				'name'        => 'banner_bg',
				'custom_size' => ['width' => 180, 'height' => 266],
				'img_class'   => 'absolute bottom-right mr-n110 mb-n110'	
			]);
		$banner_content = ob_get_clean();
		allianz_elementor_image_render($settings,[
			'name'                => 'banner',
			'custom_size'         => ['width' => 290, 'height' => 390],
			'img_class'			  => 'relative z-top',
			'before'			  => '<div class="cms-sticky"><div class="cms-ebanner-square-1 relative d-inline-block">',
			'after'				  => $banner_content.'</div></div>'
		]);
	?></div>
	<div class="cms-counter-content col-6 col-mobile-extra-8 col-mobile-12 relative z-top">
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
		<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
		<?php // Signature ?>
		<div <?php etc_print_html($widget->get_render_attribute_string('signature-wrap')); ?>>
			<?php 
				allianz_elementor_image_render($settings, [
					'name'        => 'simage',
					'size'        => 'full',
					'custom_size' => ['width' => 106, 'height'=> 78],
					'img_class'		=> 'absolute top-right'
				]);
			?>
			<div class="cms--signature">
				<div <?php etc_print_html($widget->get_render_attribute_string('sname')); ?>><?php echo nl2br($settings['sname']); ?></div>
				<div <?php etc_print_html($widget->get_render_attribute_string('sposition')); ?>><?php echo nl2br($settings['sposition']); ?></div>
			</div>
		</div>
		<?php
		// Start Counter 
			switch ($settings['layout_mode']) {
				case 'carousel':
			?>
			<div <?php etc_print_html($widget->get_render_attribute_string('carousel-settings')); ?>>
				<div class="swiper-wrapper">
			<?php
				break;
				default:
			?>
			<div <?php etc_print_html($widget->get_render_attribute_string('grid-settings')); ?>>
			<?php
				break;
			}
			// Start Item
			$count = 0;
			foreach ($counters as $key => $counter) {
				$count ++;
				$counter['icon_image_size'] = $settings['icon_image_size']; // fix image size
				$counter['icon_image_custom_dimension'] = $settings['icon_image_custom_dimension']; // fix image size
				$data_counter     = $widget->get_repeater_setting_key( 'counter-number', 'cms_counter', $key );
			    $widget->add_render_attribute( $data_counter, [
			        'class'          => [
			        	'cms-counter-number elementor-counter-number',
			        	'text-'.$widget->get_setting('number_color','primary')
			        ],
			        'data-duration'  => $counter['duration'],
			        'data-to-value'  => $counter['ending_number'],
			        'data-delimiter' => !empty($counter['thousand_separator_char']) ? $counter['thousand_separator_char'] : '',
			    ] );
			    // Link
				$page_link = $counter['page_link'];
				switch ($counter['link_type']) {
					case 'page':
						$page = !empty($page_link) ? get_page_by_path($page_link, OBJECT) : [];
						$url  = !empty($page) ? get_permalink($page->ID) : '#';
						break;
					
					default:
						$url = $counter['custom_link']['url'];
						break;
				}
				$link_key = $widget->get_repeater_setting_key('link_key', 'cms_counter', $key);
				$widget->add_render_attribute( $link_key, [
					'class' => [
						'cms-link',
						'cms-hover-underline',
						'pt-20 font-600'
					],
					'href'	=> $url,
					//'title' => $counter['link_text']
				]);
			?>
			<div <?php etc_print_html($widget->get_render_attribute_string('counter-item')); ?>>
				<div class="col-4 col-tablet-auto d-flex gap-30">
					<div <?php etc_print_html($widget->get_render_attribute_string('counter--number')) ?>>
					    <span class="prefix"><?php echo esc_html( $counter['prefix'] ); ?></span>
					    <span <?php etc_print_html( $widget->get_render_attribute_string( $data_counter ) ); ?>><?php echo esc_html( $counter['starting_number'] ); ?></span>
					    <span class="suffix"><?php echo esc_html( $counter['suffix'] ); ?></span>
					</div>
					<?php
					    // Counter Icon
						allianz_elementor_icon_image_render($widget, $counter, [
							'name'	  	  => 'counter_icon',
							'size'        => 25,
							'color'       => 'primary',
							'color_hover' => 'primary',
							'class'       => '',
							'before'      => '<div '.$widget->get_render_attribute_string('icon').'>',
							'after'       => '</div>'
						]);
					?>
				</div>
				<div class="col-8 col-tablet-basic">
					<?php if ( $counter['title'] ) : ?>
					    <div <?php etc_print_html($widget->get_render_attribute_string( 'title')); ?>><?php echo nl2br( $counter['title'] ); ?></div>
					<?php endif;
					// Description
					if ( $counter['description'] ) : ?>
					    <div <?php etc_print_html($widget->get_render_attribute_string( 'description')); ?>><?php echo nl2br( $counter['description'] ); ?></div>
					<?php endif; 
					// Link
					if($counter['link_text']):
					?>
					<a <?php etc_print_html($widget->get_render_attribute_string($link_key)); ?>><?php etc_print_html($counter['link_text']); ?></a>
					<?php endif; ?>
				</div>
			</div>
			<?php
			} // end foreach

			switch ($settings['layout_mode']) {
				case 'carousel':
			?>
				</div>
				<?php if ($settings['arrows'] == 'yes') : ?>
		            <div class="cms-carousel-button-in-vert prev cms-carousel-button-prev">
		                <?php
		                $icon_settings = $widget->get_settings_for_display('arrow_prev_icon');
		                if (empty($icon_settings['value'])) {
		                    $icon_settings = [
								'library' => 'eicons',
								'value'   => 'eicon-chevron-left',
		                    ];
		                }
		                Icons_Manager::render_icon($icon_settings, ['aria-hidden' => 'true']);
		                ?>
		            </div>
		            <div class="cms-carousel-button-in-vert next cms-carousel-button-next">
		                <?php
		                $icon_settings = $widget->get_settings_for_display('arrow_next_icon');
		                if (empty($icon_settings['value'])) {
		                    $icon_settings = [
								'library' => 'eicons',
								'value'   => 'eicon-chevron-right',
		                    ];
		                }
		                Icons_Manager::render_icon($icon_settings, ['aria-hidden' => 'true']);
		                ?>
		            </div>
		        <?php endif ?>
		        <?php if ($settings['dots'] == 'yes') : ?>
		            <div class="cms-carousel-dots cms-carousel-dots-out"></div>
		        <?php endif ?>
			</div>
			<?php
				break;
				default:
			?>
			</div>
			<?php
				break;
			}
		// End Counter
		?>
		<?php if(!empty($settings['btn_text'])): ?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'btn_text' ) ); ?>>
				<?php 
					// text
					echo esc_html( $settings['btn_text'] );
					// icon
					allianz_elementor_button_icon_render();
				?>
			</a>
		<?php endif; ?>
	</div>
</div>

