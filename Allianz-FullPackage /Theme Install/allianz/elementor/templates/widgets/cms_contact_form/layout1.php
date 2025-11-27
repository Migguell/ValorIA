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
		'cms-bg-img cms-bg-cover'
	]
]);
if(!empty($settings['ctf7_bg']['id'])){
	$widget->add_render_attribute('wrap', [
		'class' => [
			'p-110 p-lr-tablet-50 p-lr-mobile-20'
		]
	]);
}
// title
$widget->add_inline_editing_attributes('ctf7_title');
$widget->add_render_attribute('ctf7_title',[
	'class' => [
		'cms-title cms-heading',
		'text-40 text-smobile-30',
		'text-'.$widget->get_setting('title_color','heading'),
		'mb-15',
		'empty-none',
		'bg-'.$settings['heading_bg_color'],
		'd-flex gap-10'
	]
]);
if(!empty($settings['heading_bg_color'])){
	$widget->add_render_attribute('ctf7_title',[
		'class' => 'p-40 p-lr-mobile-20'
	]);
}
// description
$widget->add_inline_editing_attributes('ctf7_description');
$widget->add_render_attribute('ctf7_description',[
	'class' => [
		'cms-desc',
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
	<h2 <?php etc_print_html($widget->get_render_attribute_string('ctf7_title'));?>><?php 
		// icon
		allianz_elementor_icon_render($settings['ctf7_title_icon'], [], [ 'aria-hidden' => 'true', 'class' => $icon_class, 'icon_color'=>$widget->get_setting('icon_color', 'heading'), 'icon_size' => 40 ] );
		// Text
		echo nl2br($settings['ctf7_title']); 
	?></h2>
	<div <?php etc_print_html($widget->get_render_attribute_string('ctf7_description')); ?>><?php 
		etc_print_html($settings['ctf7_description']);
	?></div>
	<?php echo do_shortcode('[contact-form-7 id="' . esc_attr($settings['ctf7_slug']) . '" '.$ctf7_title.' ]'); ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('ctf7_note')); ?>><?php 
		echo nl2br($settings['ctf7_note']); 
	?></div>
</div>