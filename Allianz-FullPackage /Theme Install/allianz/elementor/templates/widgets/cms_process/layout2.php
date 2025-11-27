<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eprocess',
		'cms-eprocess-'.$settings['layout'],
		'text-'.$widget->get_setting('align', $default_align),
	])
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','accent'),
		'pb-10 mt-n7',
		'text-16 font-600',
		'empty-none'
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'lh-1375',
		'pb-75'
	]
]);
// Process
$process = $widget->get_setting('process_list2', []);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php 
		// Heading icon
		allianz_elementor_icon_image_render($widget, $settings,[
		'class' => 'mb-40',
		'size'  => 64,
		// image
		'img_default_size' => 'custom'
	]); ?>

	<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
	<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
	<div class="cms-swiper-vertical swiper">
		<div class="cms-swiper-wrapper swiper-wrapper">
			<?php 
				// Process Item
				foreach($process as $key => $_process){ 
			?>
				<div class="cms-process-item cms-swiper-slide swiper-slide hover-icon-bounce">
					<?php 
						// Icon/ Image
						allianz_elementor_icon_image_render($widget, $_process, [
							'size'        => 48,
							'color'       => 'primary',
							'color_hover' => 'accent',
							'icon_class'	=> 'cms-icon',
							//
							'class'	 => '',
							'before' => '<div class="process-icon-img mb-30">',
							'after'	 => '</div>'
						]);
					?>
					<div class="cms-title text-22 lh-12727 font-600 text-primary mt-n7 pb-8"><?php etc_print_html($_process['title']); ?></div>
					<div class="cms-desc text-15"><?php etc_print_html($_process['desc']); ?></div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>