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
		'mt-n7 pb-20',
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
		'mt-n10'
	]
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pt-30 empty-none',
		'text-'.$widget->get_setting('description_color','body')
	])
]);
// Banner Title
$widget->add_render_attribute('banner-title', [
	'class' => [
		'banner-title font-600 text-'.$widget->get_setting('banner_title_color', 'primary'),
		'mt-40',
		'empty-none'
	]
]);
// Banner Description
$widget->add_render_attribute('banner-desc', [
	'class' => [
		'banner-desc text-'.$widget->get_setting('banner_desc_color', 'body'),
		'empty-none pt-25'
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
	<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
	<?php 
	// Banner
	allianz_elementor_image_render($settings,[
		'name'                => 'banner',
		'custom_size'         => ['width' => 510, 'height' => 340],
		'img_class'								=> 'mt-40'
	]);
	?>
	<div <?php etc_print_html($widget->get_render_attribute_string('banner-title')); ?>><?php 
		echo nl2br($settings['banner_title'])
	?></div>
	<div <?php etc_print_html($widget->get_render_attribute_string('banner-desc')); ?>><?php 
		echo nl2br($settings['banner_desc'])
	?></div>
</div>