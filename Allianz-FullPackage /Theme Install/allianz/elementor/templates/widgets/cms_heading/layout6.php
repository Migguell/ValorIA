<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eheading',
		'cms-eheading-'.$widget->get_setting('layout'),
		'text-'.$widget->get_setting('align', $default_align)
	])
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','accent'),
		'pb-10 mt-n7',
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
		'lh-1375'
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold font-700 empty-none',
		'text-'.$widget->get_setting('description_bold_color','heading'),
		'text-26 text-mobile-extra-20 lh-13077',
		'pb-35 pb-tablet-25'
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
// Banner
$widget->add_render_attribute('banner', [
	'class' => [
		'd-flex gutter pt-30 pt-tablet-0 pb-35'
	],
	'style' => [
		'background-image:url('.allianz_elementor_image_src_render([
			'attachment_id'  => $settings['banner']['id'],
			'image_size_key' => 'banner',
			'echo'			     => false
		], $settings).');',
		'background-repeat:no-repeat;',
		'background-position: 20px calc(100% + 110px);'
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div class="d-flex gutter">
		<div class="col-6 col-tablet-extra-8 col-mobile-extra-12">
			<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
			<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
		</div>
	</div>
	<div <?php etc_print_html($widget->get_render_attribute_string('banner')); ?>>
		<div class="col-6 col-mobile-extra-12"><?php 
			// Banner
		?></div>
		<div class="col-6 col-mobile-extra-12">
			<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
			<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
		</div>
	</div>
</div>