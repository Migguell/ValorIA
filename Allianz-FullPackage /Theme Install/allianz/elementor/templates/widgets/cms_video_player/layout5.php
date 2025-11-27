<?php
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'relative',
		'cms-gradient-black-bt4',
		//'hover-remove-gradient',
		'overflow-hidden',
		$settings['css_classes']
	]
]);
// YT Video
$widget->add_render_attribute('yt-video',[
	'class'         => 'yt-video',
	'data-video-id' => $widget->get_setting('video-id', 'iYf3OgEdGmo'),
	'style'	=> 'width: 100%;height:800px;'
])
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
<?php 
	ob_start();
	?>
		<div class="cms-gradient-render cms-overlay"></div>
	<?php
		// Video play
	    allianz_elementor_button_video_render($widget, $settings, [
			'name'       => 'video_link',
			// icon
			'icon'       => $widget->get_setting('video_icon'),
			'icon_size'	 => 15,
			'icon_color' => $widget->get_setting('video_text_color', 'white'),
			'icon_class' => '',
			// text
			'text'       => $widget->get_setting('video_text', ''),
			'text_class' => 'cms-hover-underline text-15 text-'.$widget->get_setting('video_text_color', 'accent'),
			// other
			'layout'        => '1',
			'class'         => 'cms-btn-video-bg absolute center z-top d-inline-flex align-items-center justify-content-center',
			'inner_class'   => 'd-flex align-items-center justify-content-center',
			'content_class' => '',
			'echo'          => true,
			'default'       => true,
			'stroke'        => false,
			'stroke_opts'   => [
				'width'       => 232,
				'height'      => 232,
				'color'       => 'var(--cms-'.$widget->get_setting('video_text_color', 'white').')',
				'color_hover' => 'var(--cms-'.$widget->get_setting('video_text_color', 'accent').')'		
			]
	    ]);
	?>
		<div <?php etc_print_html($widget->get_render_attribute_string('yt-video')); ?>></div>
	<?php
	$banner_content = ob_get_clean();
  // Video Banner
	$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
    allianz_elementor_image_render($settings, [
		'custom_size'   => ['width' => 1550,'height' => 800],
		'img_class'     => 'img-cover',
		'before'        => '',
		'max_height'	=> true,
		'before'        => '',
		'as_background'	=> true,
		'content'		=> $banner_content
 	]);
?>
</div>

