<?php
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'relative',
		$settings['css_classes']
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>><?php 
    // Video Banner
	$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
    allianz_elementor_image_render($settings, [
		'custom_size'         => ['width' => 730,'height' => 492],
		'img_class'           => '',
		'before'              => '',
		'max_height'          => true,
		'min_height'          => true,
		'as_background'       => 'yes',
		'as_background_class' => 'center',
		'content'             => '',
		'after'			      => allianz_elementor_button_video_render($widget, $settings, [
			'name'       => 'video_link',
			// icon
			'icon'       => $widget->get_setting('video_icon'),
			'icon_size'	 => 15,
			'icon_color' => $widget->get_setting('video_text_color', 'white'),
			'icon_class' => 'text-hover-white absolute center',
			// text
			'text'       => $widget->get_setting('video_text', ''),
			'text_class' => 'cms-transition absolute center cms-hover-underline text-15 text-'.$widget->get_setting('video_text_color', 'white').' text-nowrap',
			// other
			'layout'        => '1',
			'class'         => 'cms-overlay',
			'inner_class'   => 'absolute top-left z-top mt-40 ml-40 size-70',
			'content_class' => '',
			'echo'          => false,
			'default'       => true,
			'stroke'        => false,
			'stroke_opts'   => [
				'width'       => 80,
				'height'      => 80,
				'color'       => 'var(--cms-'.$widget->get_setting('video_text_color', 'white').')',
				'color_hover' => 'var(--cms-'.$widget->get_setting('video_text_color', 'white').')'		
			]
	    ])		
    ]);
?></div>
