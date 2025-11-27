<?php
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'relative',
		'cms-gradient-black-bt',
		//'hover-image-move',
		//'hover-remove-gradient',
		'overflow-hidden',
		$settings['css_classes']
	]
]);
$btn_video_classes = 'cms-overlay justify-content-center';
if($settings['lightbox'] != 'yes'){
	$btn_video_classes .= ' cms-btn-video-bg';
}
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
<?php 
    // Video Banner
	$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
    allianz_elementor_image_render($settings, [
		'custom_size'   => ['width' => 1400,'height' => 800],
		'img_class'     => 'img-cover',
		'before'        => '',
		'max_height'	=> true,
		'before'		=> '<div class="cms-evideo-frame cms-overlay"><div class="yt-video" style="width:100%; height:100%;"></div></div>',
		'after'         => '<div class="cms-gradient-render cms-overlay"></div>'.allianz_elementor_button_video_render($widget, $settings, [
			'name'       => 'video_link',
			// icon
			'icon'       => $widget->get_setting('video_icon'),
			'icon_size'	 => 15,
			'icon_color' => $widget->get_setting('video_text_color', 'white'),
			'icon_class' => 'text-hover-white absolute center',
			// text
			'text'       => $widget->get_setting('video_text', ''),
			'text_class' => 'cms-transition absolute center cms-hover-underline text-15 text-uppercase ls-06 text-'.$widget->get_setting('video_text_color', 'white').' text-nowrap',
			// other
			'layout'        => '1',
			'class'         => $btn_video_classes,
			'inner_class'   => 'relative',
			'content_class' => '',
			'echo'          => false,
			'default'       => true,
			'stroke'        => false,
			'stroke_opts'   => [
				'width'       => 232,
				'height'      => 232,
				'color'       => 'var(--cms-'.$widget->get_setting('video_text_color', 'white').')',
				'color_hover' => 'var(--cms-'.$widget->get_setting('video_text_color', 'white').')'		
			]
	    ])
    ]);
?>
</div>
