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
		'empty-none'
	])
]);
// Title
$widget->add_render_attribute('title', [
	'class' => [
		'cms-heading cms-title',
		'text-'.$widget->get_setting('title_color','heading'),
		'pb-20'
	]
]);
// Text
$widget->add_render_attribute('text', [
	'class' => [
		'cms-desc',
		'text-'.$widget->get_setting('text_color','body'),
		'empty-none'
	]
]);
// Text Bold
$widget->add_render_attribute('text-bold', [
	'class' => [
		'cms-desc-bold',
		'text-'.$widget->get_setting('text_bold_color','heading'),
		'empty-none',
		'pt-30'
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
		'text-'.$widget->get_setting('link_color','accent'),
		'text-hover-'.$widget->get_setting('link_color_hover','accent'),
		'cms-hover-underline-2',
		'd-inline-flex align-items-center gap-10',
		'mt-30',
		'font-700 text-15'
	],
	'href'	=> $url
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<h2 <?php etc_print_html($widget->get_render_attribute_string('title')) ?>><?php etc_print_html($settings['title']); ?></h2>
	<div <?php etc_print_html($widget->get_render_attribute_string('text')) ?>><?php printf('%s&nbsp;', $settings['text']);?></div>
	<div <?php etc_print_html($widget->get_render_attribute_string('text-bold')) ?>><?php printf('%s&nbsp;', $settings['text_bold']);?></div>
	<?php if(!empty($settings['link_text'])): ?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text' ) ); ?>>
			<?php 
				// text
				echo esc_html( $settings['link_text'] );
			?><i class="allianz-icon-up-right-arrow rtl-flip text-12"></i>
		</a>
	<?php endif; ?>
</div>