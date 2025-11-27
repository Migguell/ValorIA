<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eheading',
		'cms-eheading-'.$widget->get_setting('layout'),
		'text-'.$widget->get_setting('align', $default_align),
		'd-flex gutter'
	])
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','accent-darken'),
		'pb-10 mt-n7',
		'text-16 font-700',
		'empty-none'
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'lh-1375'
	]
]);
// Link 1
$link1_page = $widget->get_setting('link1_page','');
switch ($settings['link1_type']) {
	case 'page':
		$page = !empty($link1_page) ? get_page_by_path($link1_page, OBJECT) : [];
		$url  = !empty($page) ? get_permalink($page->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('link1_custom', ['url' => '#'])['url'];
		break;
}
$widget->add_inline_editing_attributes( 'link1_text' );
$widget->add_render_attribute( 'link1_text', [
	'class' => [
		'cms-link circle ml-n30 z-top',
		'bg-'.$widget->get_setting('link1_color','accent'),
		'bg-hover-'.$widget->get_setting('link1_color_hover', 'primary'),
		'text-white text-hover-white text-36',
		'empty-none',
		'cms-hover-move-icon-up',
		'd-flex align-items-center justify-content-center'
	],
	'href'	=> $url,
	'title' => $settings['link1_text']
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
	<div class="col-7 col-mobile-extra-12">
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
		<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
	</div>
	<div class="col-5 col-mobile-extra-12 d-flex align-items-center justify-content-end">
		<?php 
			allianz_circle_text([
				'class'			 => 'cms-gradient-primary-bt2 cms-bg-img',
				'dimensions' => 160,
				'fill' 			 => 'transparent',
				'space'			 => 10,
				'color'			 => 'white',
				'text'			 => $settings['experience_text'],
				'before'		 => '<div class="cms-gradient-render"></div>',
				'after'	     => '<div class="experience-number absolute center text-white text-25 heading font-500 bg-accent lh-60 mw-60 p-lr-10 cms-radius-30 z-top">'.$settings['experience_number'].'</div>',
				// Svg
				'svg_class' => 'z-top2 relative text-35 font-500 cms-rotate--85'
			]);
		?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'link1_text' ) ); ?>><?php allianz_elementor_svg_hover_icon_render();?></a>
	</div>
</div>