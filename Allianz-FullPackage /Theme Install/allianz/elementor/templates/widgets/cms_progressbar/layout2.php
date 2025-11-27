<?php
$progressbar_list = $widget->get_setting('progressbar_list', []);
$background_class = allianz_nice_class([
	'cms-eprogress-bar',
	'cms-eprogress-bar-'.$settings['layout'],
	'p-tb-130 p-lr-110 p-tb-tablet-50 p-lr-mobile-20 p-lr-smobile-10',
	'd-flex justify-content-end',
	'text-center',
	'overflow-hidden'
]);
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-eprogress--bar',
		'p-tb-50 p-lr-70 p-lr-mobile-20 p-lr-smobile-20',
		'cms-radius-8 bg-white-04',
		'relative z-top'
	]
]);

// wrap inner
$widget->add_render_attribute('wrap-inner', [
	'class' => [
		'cms-eprogress---bar',
		'd-flex gap-40 gap-mobile-20 justify-content-center'
	]
]);
ob_start();
// Shadow
allianz_elementor_image_render($settings,[
	'name'      => 'shadow',
	'size'      => 'full',
	'img_class' => 'cms-eprogress-shadow absolute top-right'
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php 
	// Title
	if(!empty($settings['etitle'])){
	?>
		<div class="cms-etitle text-20 font-600 text-heading lh-115 pb-15"><?php 
			etc_print_html($settings['etitle']);
		?></div>
	<?php } ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('wrap-inner')) ?>><?php
	// Progress
	foreach ( $progressbar_list as $key => $progressbar ):
		$max = $progressbar['percent']['size'];
		$duration = $widget->get_setting('duration',['size'=>2000])['size'];
		$_id = $progressbar['_id'];
		$progressbar_color = !empty($progressbar['progressbar_color']) ? $progressbar['progressbar_color'] : $widget->get_setting('progressbar_color','accent');
		// Progress Title
		$title_key = $widget->get_repeater_setting_key( 'title', 'progressbar_list', $key );
		$widget->add_inline_editing_attributes( $title_key );
		$widget->add_render_attribute( $title_key, [
			'class'=>[
				'cms-progress-bar-title',
				'absolute bottom w-100',
				'pb-35',
				'font-700 text-'.$widget->get_setting('title_color', 'white'),
			]
		]);
		// Progress Number
		$progressbar_number = $widget->get_repeater_setting_key('number', 'progressbar_list', $key);
		$widget->add_render_attribute($progressbar_number, [
			'class' => [
				'cms-progress-bar-number'
			],
			'data-max'       => $max,
			'data-to-value'  => $max,
			'data-duration'  => $duration,
			'data-delimiter' => '',
		]);
		// Progress Number Title
		$progressbar_number_title = $widget->get_repeater_setting_key('number-title','progressbar_list', $key);
		$widget->add_render_attribute($progressbar_number_title, [
			'class' => [
				'cms-progress-bar-number-wrap font-600 text-25',
				'text-'.$widget->get_setting('title_color', 'white')
			]
		]);
		// Progress Bar Wrap
		$progress_bar_wrap_key = $widget->get_repeater_setting_key( 'wrapper', 'progressbar_list', $key );
		$widget->add_render_attribute( $progress_bar_wrap_key, [
			'class'         => [
				'cms-progress-wrap',
				'relative',
				'bg-'.$widget->get_setting('progress_color','primary'),
			],
			'role'          => 'progressbar',
			'aria-valuemin' => '0',
			'aria-valuemax' => '100',
			'aria-valuenow' => $max,
			'style'					=> [
				'height:'.$widget->get_setting('progress_height', ['size' => 195])['size'].'px;'
			]
		] );

		// Progress Bar
		$progress_bar_key = $widget->get_repeater_setting_key( 'progress_bar', 'progressbar_list', $key );
		$widget->add_render_attribute( $progress_bar_key, [
			'class'      => [
				'cms-progress-bar',
				'cms-progress-bar-h',
				'absolute bottom w-100',
				'bg-'.$progressbar_color,
				'elementor-repeater-item-' . $_id,
			],
			'data-max'       => $max,
			'data-to-value'  => $max,
			'data-duration'  => $duration,
			'data-delimiter' => '',
			'data-delimiter' => '',
			'style'					 => [
				'transition-duration:'.$duration.'ms;'
			]
		] );
		?>
		<div class="cms-progress-bar-wrap">
      <div <?php etc_print_html( $widget->get_render_attribute_string( $progress_bar_wrap_key ) ); ?>>
        <div <?php etc_print_html( $widget->get_render_attribute_string( $progress_bar_key ) ); ?>></div>
	        <div <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>>
	        	<h3 <?php etc_print_html($widget->get_render_attribute_string($progressbar_number_title)); ?>>
	        		<span <?php etc_print_html( $widget->get_render_attribute_string( $progressbar_number ) ); ?>></span>%</h3>
		        	<?php if ( ! empty( $progressbar['title'] ) ) { 
		        		etc_print_html( $progressbar['title'] ); 
		        	} ?>
	        </div>
      </div>
    </div>
	<?php endforeach; 
	?></div>
</div>
<?php 
	$progressbar = ob_get_clean();
	// Output
	allianz_elementor_image_render($settings,[
		'name'                => 'background',
		'size'								=> 'full',
		'as_background'       => true,
		'as_background_class' => $background_class,
		'aspect_ratio'			  => false,
		'content'							=> $progressbar
	]);
?>