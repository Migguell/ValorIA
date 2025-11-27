<?php 
$default_align = 'center';
//wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-epf', 
		'cms-epf-'.$widget->get_setting('layout'),
		'text-'.$default_align
	]
]);
$attachment_id = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
<?php
	/* Post category */
  allianz_the_terms('', allianz_post_taxonomy_category(), '', 'text-primary text-hover-white bg-white bg-hover-accent bdr-1 bdr-primary-regular bdr-hover-accent-regular cms-radius-4 p-tb-3 p-lr-10', [
      'before' => '<div class="post-cat text-13 mb-20 gap-5 d-flex justify-content-'.$default_align.'">',
      'after'  => '</div>'  
  ]);
  // Post Title
  the_title('<div class="cms-title text-36 text-heading font-600 lh-1222 m-lr-auto mb-40">','</div>');
	// Post Feature Image
	if($settings['show_image'] === 'yes'){
		allianz_elementor_image_render($settings,[
			'name'                => 'banner',
			'attachment_id'				=> $attachment_id,
			'custom_size'         => ['width' => 840, 'height' => 570]
		]);
	}
?>
</div>