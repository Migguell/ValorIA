<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eheading',
		'cms-eheading-'.$widget->get_setting('layout'),
		'text-'.$widget->get_setting('align', $default_align),
		'empty-none'
	])
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'text-26 text-mobile-20 lh-1375 font-600',
		'empty-none',
		'pb-15'
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold font-700 empty-none',
		'text-'.$widget->get_setting('description_bold_color','heading'),
		'pb-25',
		'empty-none'
	])
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc empty-none',
		'text-'.$widget->get_setting('description_color','body'),
		'empty-none'
	])
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></div>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
</div>