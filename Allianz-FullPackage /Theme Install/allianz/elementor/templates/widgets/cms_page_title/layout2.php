<?php
$default_align = $widget->get_setting('content_align', 'center');
// Wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-eptitle',
		'cms-eptitle-'.$widget->get_setting('layout','1'),
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
// Small Title 
$widget->add_render_attribute('small_title', [
	'class' => [
		'cms-small-title',
		'pb-10 w-100',
		'text-15 text-uppercase',
		'pt-5',
		'text-'.$widget->get_setting('small_title_color', 'white'),
		'ls-06',
		'empty-none'
	]
]);
// Title
$widget->add_render_attribute( 'title', [
	'class' => [
		'cms-title lh-11538',
		'text-65 text-tablet-50 text-mobile-30',
		'text-'.$widget->get_setting('title_color','white'),
		'w-100',
		'empty-none'
	]
]);
// Description
$widget->add_render_attribute( 'description', [
	'class' => [
		'cms-desc',
		'pt-20 w-100',
		'text-17',
		'text-'.$widget->get_setting('description_color', 'white'),
		'empty-none'
	]
]);
// Button
$page_link = $widget->get_setting('page_link','');
switch ($settings['link_type']) {
	case 'page':
		$page = !empty($page_link) ? get_page_by_path($page_link, OBJECT) : [];
		$url  = !empty($page) ? get_permalink($page->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('custom_link', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'link_text', [
	'class' => [
		'btn btn-lg empty-none',
		'btn-'.$widget->get_setting('btn1_color', 'white'),
		'text-'.$widget->get_setting('btn1_text_color', 'primary'),
		'btn-hover-'.$widget->get_setting('btn1_color_hover', 'white'),
		'text-hover-'.$widget->get_setting('btn1_text_color_hover', 'primary'),
		'cms-hover-move-icon-up'
	],
	'href'	=> $url
]);

// Button #2
$page2_link = $widget->get_setting('page2_link','');
switch ($settings['link2_type']) {
	case 'page':
		$page2 = !empty($page2_link) ? get_page_by_path($page2_link, OBJECT) : [];
		$url2  = !empty($page2) ? get_permalink($page2->ID) : '#';
		break;
	
	default:
		$url2 = $widget->get_setting('custom2_link', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'link2_text', [
	'class' => [
		'btn btn-lg empty-none',
		'btn-'.$widget->get_setting('btn2_color', 'primary'),
		'text-'.$widget->get_setting('btn2_text_color', 'white'),
		'btn-hover-'.$widget->get_setting('btn2_color_hover', 'primary'),
		'text-hover-'.$widget->get_setting('btn2_text_color_hover','white'),
		'cms-hover-move-icon-up'
	],
	'href'	=> $url2
]);

// Inline Edit
$widget->add_inline_editing_attributes( 'title', 'none' );
$widget->add_inline_editing_attributes( 'description' );
$widget->add_inline_editing_attributes( 'link_text' );
// CMS Content
$widget->add_render_attribute('cms--content',[
	'class' => [
		'cms--content d-flex',
		allianz_elementor_get_alignment_class($widget, $settings, [
            'name'         => 'content_align',
            'prefix_class' => 'justify-content-',
            'default'	   => $default_align	
        ])
	]
]);
// Buttons 
$widget->add_render_attribute('buttons',[
	'class' => [
		'd-flex align-items-center gap empty-none w-100',
		'pt-35',
		allianz_elementor_get_alignment_class($widget, $settings, [
            'name'         => 'content_align',
            'prefix_class' => 'justify-content-',
            'default'	   => $default_align	
        ])
	],
	'style' => '--cms-gap:30px;--cms-gap-tablet:30px;--cms-gap-mobile:20px;'
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
		<div <?php etc_print_html($widget->get_render_attribute_string('cms--content')); ?>>
			<div <?php etc_print_html($widget->get_render_attribute_string('small_title')); ?>><?php echo etc_print_html( $settings['small_title'] ); ?></div>
			<h1 <?php etc_print_html( $widget->get_render_attribute_string( 'title' ) ); ?>><?php echo etc_print_html( $widget->get_setting('title', get_the_title()) ); ?></h1>
			<div <?php etc_print_html( $widget->get_render_attribute_string( 'description' ) ); ?>><?php echo etc_print_html( $settings['description'] ); ?></div>
			<div <?php etc_print_html( $widget->get_render_attribute_string( 'buttons' ) ); ?>><?php 
				// Button #1
				if(!empty($settings['link_text'])){
				?><a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text' ) ); ?>><?php  
					// text
					echo esc_html( $settings['link_text'] );
					// icon
					allianz_elementor_button_icon_render();
				?></a><?php
				}
				if(!empty($settings['link2_text'] )){
				// Button #2 
				?><a <?php etc_print_html( $widget->get_render_attribute_string( 'link2_text' ) ); ?>><?php  
					// text
					echo esc_html( $settings['link2_text'] );
					// icon
					allianz_elementor_button_icon_render();
				?></a>
				<?php
				}
				// Video
				allianz_elementor_button_video_render($widget, $settings, [
					'name'        => 'video_link',
					'icon'        => $widget->get_setting('video_icon'),
					'icon_class'  => 'absolute center',
					'text'        => $widget->get_setting('video_text','How it works'),
					'layout'      => '1',
					'inner_class' => '',
					'echo'        => true
			    ])
			?></div>
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
</div>