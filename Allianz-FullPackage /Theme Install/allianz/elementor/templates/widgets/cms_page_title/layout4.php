<?php
$default_align = $widget->get_setting('content_align', 'center');
// Wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-eptitle',
		'cms-eptitle-'.$settings['layout'],
		'relative z-top',
		allianz_elementor_get_alignment_class($widget, $settings, [
            'name'         => 'content_align',
            'prefix_class' => 'text-',
            'default'	   => $default_align	
        ])
	]
]);
// Container
$widget->add_render_attribute('container',[
	'class' => [
		'cms-content container',
		allianz_elementor_get_alignment_class($widget, $settings, [
            'name'         => 'content_align',
            'prefix_class' => 'text-',
            'default'	   => $default_align	
        ]),
		'd-flex',
        allianz_elementor_get_alignment_class($widget, $settings, [
            'name'         => 'content_align',
            'prefix_class' => 'justify-content-',
            'default'	   => $default_align	
        ])
	]
]);
// Breadcrumb
$breadcrumb_classes = [
	'text-'.$widget->get_setting('breadcrumb_color_hover', 'white'),
	'text-hover-'.$widget->get_setting('breadcrumb_text_color_hover','white'),
	'justify-content-'.$default_align
];
$breadcrumb_link_classes = [
	'text-'.$widget->get_setting('breadcrumb_color_hover', 'white'),
	'text-hover-'.$widget->get_setting('breadcrumb_text_color_hover','white'),
];
// Render Background Image
$ptitle_bg_url = !empty($settings['bg_image']['url']) ? $settings['bg_image']['url'] : get_the_post_thumbnail_url();
$widget->add_render_attribute('background', [
	'class'                         => [
		'cms-eptitle-overlay cms-overlay',
		'cms-bg-parallax',
		'cms-lazy'
	],
	'style' => '--cms-bg-lazyload:url('.$ptitle_bg_url.');background-image:var(--cms-bg-lazyload-loaded);background-position:'.$settings['bg_pos'].';'
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('background')); ?>><div class="cms-eptitle-overlay-shadow cms-overlay rtl-flip"></div></div>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html($widget->get_render_attribute_string('container')); ?>>
		<?php allianz_breadcrumb([
			'show'       => $settings['show_breadcrumb'],
			'icon_home'  => '',
			'class'      => allianz_nice_class($breadcrumb_classes),
			'link_class' => allianz_nice_class($breadcrumb_link_classes),
			'before'     => '',
			'after'      => ''
		]); ?>
	</div>
</div>