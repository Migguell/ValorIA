<?php 
//wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-ebanner', 
		'cms-ebanner-'.$widget->get_setting('layout'),
		$settings['custom_class']
	]
]);
$attachment_id = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
<?php
	allianz_elementor_image_render($settings,[
		'name'                => 'banner',
		'attachment_id'				=> $attachment_id,
		'custom_size'         => ['width' => 620, 'height' => 500],
		'as_background'       => $settings['as_background'],
		'as_background_class' => 'w-100 '.$settings['bg_pos'],
		'max_height'       	  => $settings['max_height'],
		'aspect_ratio'		    => true 
	]);
?>
</div>