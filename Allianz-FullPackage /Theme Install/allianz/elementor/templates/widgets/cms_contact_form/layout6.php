<?php 
$ctf7_title = '';
if(empty($settings['ctf7_slug']) || $settings['ctf7_slug'] === ''){
	$ctf7_title =  'title="Contact form 1"';
}
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-ecf7',
		'cms-ecf7-'.$settings['layout'],
		'cms-ecf7-fields2 cms-ecf7-fields3',
		'cms-bg-img cms-bg-cover',
	]
]);
// title
$widget->add_inline_editing_attributes('ctf7_title');
$widget->add_render_attribute('ctf7_title',[
	'class' => [
		'cms-title',
		'font-600',
		'text-'.$widget->get_setting('title_color','heading'),
		'mb-60 mt-n10',
		'empty-none',
		'd-flex gap-10'
	]
]);
// description
$widget->add_inline_editing_attributes('ctf7_description');
$widget->add_render_attribute('ctf7_description',[
	'class' => [
		'cms-desc text-15',
		'text-'.$widget->get_setting('desc_color','body'),
		'pb-30',
		'empty-none'
	]
]);
// note
$widget->add_inline_editing_attributes('ctf7_note');
$widget->add_render_attribute('ctf7_note',[
	'class' => [
		'cms-note pt-30 font-italic',
		'text-'.$widget->get_setting('note_color','body'),
		'empty-none'
	]
]);
// icon
$icon_class = '';
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html($widget->get_render_attribute_string('ctf7_title'));?>><?php
		// Text
		echo nl2br($settings['ctf7_title']); 
	?></div>
	<div <?php etc_print_html($widget->get_render_attribute_string('ctf7_description')); ?>><?php 
		etc_print_html($settings['ctf7_description']);
	?></div>
	<?php echo do_shortcode('[contact-form-7 id="' . esc_attr($settings['ctf7_slug']) . '" '.$ctf7_title.' ]'); ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('ctf7_note')); ?>><?php 
		echo nl2br($settings['ctf7_note']); 
	?></div>
</div>