<?php
$widget->add_inline_editing_attributes( 'title' );
$widget->add_inline_editing_attributes( 'text' );
$widget->add_inline_editing_attributes( 'link_text' );
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-cta',
		'cms-cta-'.$settings['layout'],
		allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align', 'default' => $default_align]),
		'bg-accent cms-radius-8',
		'p-70 p-lr-mobile-20',
		'cms-hover-icon-alternate'
	])
]);
// Title
$widget->add_render_attribute('title', [
	'class' => [
		'cms-heading cms-title',
		'text-'.$widget->get_setting('title_color','white'),
		'lh-1375',
		'pb-25 mt-n5'
	]
]);
// Text
$widget->add_render_attribute('text', [
	'class' => [
		'cms-desc',
		'text-'.$widget->get_setting('text_color','white'),
		'empty-none'
	]
]);
// Link
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
		'text-'.$widget->get_setting('link_color','white'),
		'text-hover-'.$widget->get_setting('link_color_hover','white'),
		'mt-150 mt-mobile-30 d-inline-block cms-link-circle text-36',
		'cms-hover-move-icon-up',
		'z-top2',
		'd-flex align-items-center justify-content-center'
	],
	'href'	=> $url,
	'title' => $settings['link_text']
]);
$widget->add_render_attribute( 'link_text_overlay', [
	'class' => [
		'cms-overlay'
	],
	'href'	=> $url
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<h2 <?php etc_print_html($widget->get_render_attribute_string('title')) ?>><?php 
		echo nl2br($settings['title']); 
	?></h2>
	<div <?php etc_print_html($widget->get_render_attribute_string('text')) ?>><?php
		echo nl2br($settings['text']); 
	?></div>
	<?php if(!empty($settings['link_text'])): ?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text_overlay' ) ); ?>></a>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text' ) ); ?>>
			<?php
				// icon
				allianz_elementor_svg_hover_icon_render([
					'icon' => 'alternate-move',
					'class' => ''
				]);
			?>
		</a>
	<?php endif; ?>
</div>