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
		'cms-title text-16 font-600',
		'text-'.$widget->get_setting('title_color','heading'),
		'pb-20'
	]
]);
// Text
$widget->add_render_attribute('text', [
	'class' => [
		'cms-desc',
		'text-'.$widget->get_setting('text_color','body'),
		!empty($settings['text']) ? '' : 'pb-100 pb-tablet-0 mb-35'
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
		'cms-link circle ml-n30 z-top',
		'bg-'.$widget->get_setting('link_color','accent'),
		'bg-hover-'.$widget->get_setting('link_color_hover','accent'),
		'text-white text-hover-white text-42',
		'cms-hover-move-icon-up',
		'd-inline-flex align-items-center justify-content-center'
	],
	'href'	=> $url,
	'title' => $settings['link_text'],
	'style' => 'width:160px; height:160px;'
]);
// Experience
$widget->add_inline_editing_attributes( 'experience_text' );
$widget->add_inline_editing_attributes( 'experience_number' );
$widget->add_render_attribute('experience_text', [
	'class' => 'experience-text'
]);
$widget->add_render_attribute('experience_number', [
	'class' => 'experience-number'
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html($widget->get_render_attribute_string('title')) ?>><?php etc_print_html($settings['title']); ?></div>
	<div <?php etc_print_html($widget->get_render_attribute_string('text')) ?>><?php printf('%s', $settings['text']);?></div>
	<div class="d-flex flex-nowrap justify-content-<?php echo esc_attr($settings['align']); ?>">
		<?php 
			allianz_circle_text([
				'class'			 => 'cms-gradient-primary-bt2',
				'dimensions' => 160,
				'fill' 			 => 'transparent',
				'space'			 => 10,
				'color'			 => 'white',
				'text'			 => $settings['experience_text'],
				'before'		 => '<div class="cms-gradient-render"></div>',
				'after'	     => '<div class="experience-number absolute center text-white text-25 heading font-500 bg-accent lh-60 mw-60 p-lr-10 cms-radius-30 z-top">'.$settings['experience_number'].'</div>',
				// Svg
				'svg_class' => 'z-top2 relative text-35 font-500 rotate--80'
			]);
		?>
		<?php if(!empty($settings['link_text'])): ?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text' ) ); ?>><?php allianz_elementor_svg_hover_icon_render(['icon'=>'alternate-move']);?></a>
		<?php endif; ?>
	</div>
</div>