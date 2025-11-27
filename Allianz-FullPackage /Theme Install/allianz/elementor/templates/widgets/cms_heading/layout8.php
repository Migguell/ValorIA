<?php
$default_align = 'start';
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-eheading',
		'cms-eheading-'.$widget->get_setting('layout'),
		'text-'.$widget->get_setting('align', $default_align),
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'text-22 lh-14545',
		'bdr-t-1 pt-35'
	]
]);
?>
<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
