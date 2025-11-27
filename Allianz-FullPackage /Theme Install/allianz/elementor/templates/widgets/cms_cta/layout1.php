<?php
$widget->add_inline_editing_attributes( 'title' );
$widget->add_inline_editing_attributes( 'text' );
$widget->add_inline_editing_attributes( 'link_text' );
$default_align = 'center';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-cta',
		'cms-cta-'.$settings['layout'],
		'text-15',
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
		'text-'.$widget->get_setting('link_color','primary'),
		'text-hover-'.$widget->get_setting('link_color_hover','accent'),
		'font-600',
		'cms-hover-underline-2 cms-hover-move-icon-up',
		'd-inline-flex align-items-center gap-10'
	],
	'href'	=> $url
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<h2 <?php etc_print_html($widget->get_render_attribute_string('title')) ?>><?php 
		echo nl2br($settings['title']); 
	?></h2>
	<span <?php etc_print_html($widget->get_render_attribute_string('text')) ?>><?php 
		printf('%s&nbsp;', nl2br($settings['text']));
	?></span>
	<?php if(!empty($settings['link_text'])): ?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text' ) ); ?>>
			<?php 
				// text
				echo esc_html( $settings['link_text'] );
				// icon
				allianz_elementor_button_icon_render();
			?>
		</a>
	<?php endif; ?>
</div>