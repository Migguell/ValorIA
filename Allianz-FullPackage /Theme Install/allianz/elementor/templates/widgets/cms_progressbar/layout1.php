<?php
$progressbar_list = $widget->get_setting('progressbar_list', []);
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-eprogress-bar',
		'cms-eprogress-bar-'.$settings['layout']
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php foreach ( $progressbar_list as $key => $progressbar ):
		$max = $progressbar['percent']['size'];
		$duration = $widget->get_setting('duration',['size'=>2000])['size'];

		// Progress Title
		$title_key = $widget->get_repeater_setting_key( 'title', 'progressbar_list', $key );
		$widget->add_inline_editing_attributes( $title_key );
		$widget->add_render_attribute( $title_key, [
			'class'=>[
				'cms-progress-bar',
				'cms-progress-bar-w',
				'cms-progress-bar-title',
				'font-700 text-'.$widget->get_setting('title_color', 'heading'),
				'text-nowrap',
				'pb-5',
				'd-flex justify-content-between flex-nowrap',
			],
			'data-max'       => $max,
			'data-to-value'  => $max,
			'data-duration'  => $duration,
			'data-delimiter' => '',
			'style'		 => [
				//'width:'.$progressbar['percent']['size'].'%;',
				'transition-duration:'.$duration.'ms;'
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
		// Progress Bar Wrap
		$progress_bar_wrap_key = $widget->get_repeater_setting_key( 'wrapper', 'progressbar_list', $key );
		$widget->add_render_attribute( $progress_bar_wrap_key, [
			'class'         => [
				'cms-progress-wrap',
				'bg-'.$widget->get_setting('progress_color','grey'),
			],
			'role'          => 'progressbar',
			'aria-valuemin' => '0',
			'aria-valuemax' => '100',
			'aria-valuenow' => $max,
		] );

		// Progress Bar
		$progress_bar_key = $widget->get_repeater_setting_key( 'progress_bar', 'progressbar_list', $key );
		$widget->add_render_attribute( $progress_bar_key, [
			'class'      => [
				'cms-progress-bar',
				'cms-progress-bar-w',
				'cms-progress--bar',
				'bg-'.$widget->get_setting('progressbar_color','accent')
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
			<?php if ( ! empty( $progressbar['title'] ) ) { ?>
        <div <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>>
        	<?php echo esc_html( $progressbar['title'] ); ?>
        	<span class="cms-progress-bar-number-wrap font-700"><span <?php etc_print_html( $widget->get_render_attribute_string( $progressbar_number ) ); ?>></span>%</span>
        </div>
			<?php } ?>
      <div <?php etc_print_html( $widget->get_render_attribute_string( $progress_bar_wrap_key ) ); ?>>
        <div <?php etc_print_html( $widget->get_render_attribute_string( $progress_bar_key ) ); ?>></div>
      </div>
    </div>
	<?php endforeach; ?>
</div>