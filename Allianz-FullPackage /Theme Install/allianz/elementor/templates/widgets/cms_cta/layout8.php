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
		'text-15',
		allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align', 'default' => $default_align]),
		'empty-none',
		'cms-hover-icon-alternate'
	])
]);
// Title
$widget->add_render_attribute('title', [
	'class' => [
		'cms-heading cms-title',
		'text-'.$widget->get_setting('title_color','primary'),
		'text-hover-'.$widget->get_setting('link_color_hover','accent'),
		'text-90 text-tablet-50 text-mobile-30',
		'mt-n10 mb-n10',
		'cms-transition'
	]
]);
// Text
$widget->add_render_attribute('text', [
	'class' => [
		'cms-desc',
		'text-'.$widget->get_setting('text_color','body'),
		'pt-30',
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
		'text-'.$widget->get_setting('title_color','primary'),
		'text-hover-'.$widget->get_setting('link_color_hover','accent')
	],
	'href'	=> $url,
	'title' => $settings['link_text']
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php if(!empty($settings['link_text'])): ?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text' ) ); ?>>
	<?php endif; ?>
			<h2 <?php etc_print_html($widget->get_render_attribute_string('title')) ?>><?php
				// title
				echo nl2br($settings['title']); 
				// icon 
				allianz_elementor_svg_hover_icon_render([
					'icon'   => 'alternate',
					'class'  => '',
					'before' => '<span class="text-70 text-tablet-40 text-mobile-20">',
					'after'  => '</span>'
				]);
			?></h2>
			<div <?php etc_print_html($widget->get_render_attribute_string('text')) ?>><?php 
				echo nl2br($settings['text']);
			?></div>
	<?php if(!empty($settings['link_text'])): ?>
		</a>
	<?php endif; ?>
</div>