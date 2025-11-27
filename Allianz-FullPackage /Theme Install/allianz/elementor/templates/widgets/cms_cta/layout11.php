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
		'cms-heading cms-title empty-none',
		'text-'.$widget->get_setting('title_color','heading'),
		'pb-20'
	]
]);
// Text
$widget->add_render_attribute('text', [
	'class' => [
		'cms-desc',
		'font-600',
		'text-'.$widget->get_setting('text_color','heading'),
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
		'cms-hover-underline-2 cms-hover-move-icon-up',
		'd-inline-flex align-items-center gap-10',
		'font-700'
	],
	'href'	=> $url
]);
// Button
$btn_link = $widget->get_setting('btn_link','');
switch ($settings['btn_type']) {
	case 'page':
		$btn_page = !empty($btn_link) ? get_page_by_path($btn_link, OBJECT) : [];
		$btn_url  = !empty($btn_page) ? get_permalink($btn_page->ID) : '#';
		break;
	
	default:
		$btn_url = $widget->get_setting('btn_custom_link', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'btn_text', [
	'class' => [
		'btn',
		'btn-'.$widget->get_setting('btn_color','accent'),
		'text-'.$widget->get_setting('btn_text_color','white'),
		'btn-hover-'.$widget->get_setting('btn_color_hover','primary'),
		'text-hover-'.$widget->get_setting('btn_text_hover_color','white'),
		'mt-25',
		'cms-hover-move-icon-up'
	],
	'href'	=> $btn_url
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php // Banner
		allianz_elementor_image_render($settings,[
			'name'   => 'banner',
			'size'   => 'full',
			'before' => '<div class="cms-cta-banner mb-20">',
			'after'  => '</div>'
		]);
	?>
	<h2 <?php etc_print_html($widget->get_render_attribute_string('title')) ?>><?php etc_print_html($settings['title']); ?></h2>
	<span <?php etc_print_html($widget->get_render_attribute_string('text')) ?>><?php printf('%s&nbsp;', $settings['text']);?></span>
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
	<div class="clearfix"></div>
	<?php if(!empty($settings['btn_text'])): ?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'btn_text' ) ); ?>>
			<?php 
				// text
				echo esc_html( $settings['btn_text'] );
				// icon
				allianz_elementor_button_icon_render();
			?>
		</a>
	<?php endif; ?>
</div>