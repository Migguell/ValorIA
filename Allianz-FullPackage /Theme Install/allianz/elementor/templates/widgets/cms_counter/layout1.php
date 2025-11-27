<?php
$counters = $widget->get_setting('counters', []);
if(empty($counters)) return;

use Elementor\Icons_Manager;
// Items
$widget->add_render_attribute( 'counter-item',[
	'class' => [
		'counter-item',
		'relative',
		($settings['layout_mode'] === 'carousel') ? 'swiper-slide' : '',
		'hover-icon-bounce'
	]
]);
// Number
$widget->add_render_attribute('counter--number',[
	'class' => [
		'cms-counter-numbers text-40 cms-heading d-flex lh-1',
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
		'cms-counter-title text-15',
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
        'd-flex gutter-80',
        allianz_elementor_get_grid_columns($widget, $settings, ['prefix_class' => 'flex-col-'])
    ]
]);
// Start layout 
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
		<div class="d-flex gap-30 pb-20">
			<div <?php etc_print_html($widget->get_render_attribute_string('counter--number')) ?>>
			    <span class="prefix"><?php echo esc_html( $counter['prefix'] ); ?></span>
			    <span <?php etc_print_html( $widget->get_render_attribute_string( $data_counter ) ); ?>><?php echo esc_html( $counter['starting_number'] ); ?></span>
			    <span class="suffix"><?php echo esc_html( $counter['suffix'] ); ?></span>
			</div>
			<?php
			    // Counter Icon
				allianz_elementor_icon_image_render($widget, $counter, [
					'name'	  	  => 'counter_icon',
					'size'        => 36,
					'color'       => 'primary',
					'color_hover' => 'primary',
					'class'       => '',
					'before'      => '<div '.$widget->get_render_attribute_string('icon').'>',
					'after'       => '</div>'
				]);
			?>
		</div>
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
?>

