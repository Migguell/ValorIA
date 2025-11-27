<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eheading',
		'cms-eheading-'.$widget->get_setting('layout'),
		'text-'.$widget->get_setting('align', $default_align),
		'd-flex gutter justify-content-between'
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
		'lh-1375',
		'mr-n20 mr-laptop-n0'
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold font-600 empty-none',
		'text-'.$widget->get_setting('description_bold_color','heading'),
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
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div class="col-6 col-tablet-extra-8 col-mobile-extra-12">
		<div class="cms-sticky">
			<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
			<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
		</div>
	</div>
	<div class="col-4 cms-hidden-min-laptop cms-hidden-mobile-extra"></div>
	<div class="col-4 cms-hidden-min-laptop cms-hidden-mobile-extra"></div>
	<div class="col-6 col-tablet-extra-8 col-mobile-extra-12 pt-320 pt-tablet-extra-20">
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
	</div>
</div>