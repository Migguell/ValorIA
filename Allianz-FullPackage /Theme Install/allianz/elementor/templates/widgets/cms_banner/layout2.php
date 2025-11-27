<?php
//wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-ebanner', 
		'cms-ebanner-'.$widget->get_setting('layout'),
		'cms-hover-icon-alternate',
		$settings['custom_class']
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading h2 empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'text-hover-'.$widget->get_setting('link1_text_color_hover', 'accent'),
		'text-90 text-tablet-extra-60 text-mobile-40',
		'lh-1167',
		'pb-80 pb-mobile-40',
		'cms-hover-icon-alternate',
		'd-block'
	]
]);
// Buttons
$widget->add_render_attribute('buttons',[
	'class' => [
		'cms-ebanner-buttons d-flex gap pt-30'
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
		'text-'.$widget->get_setting('link1_text_color','inherit'),
		'text-hover-'.$widget->get_setting('link1_text_color_hover', 'inherit'),
		'text-68 text-tablet-40 text-mobile-30'
	],
	//'href' => $url
]);
$widget->add_render_attribute( 'heading_text', [
	'href' => $url
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<a <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>>
		<?php echo etc_print_html( $settings['heading_text'] ); ?>
		<span <?php etc_print_html( $widget->get_render_attribute_string( 'link1_text' ) ); ?>>
			<?php allianz_elementor_svg_hover_icon_render([
				'icon' => 'alternate'
			]); ?>
		</span>
	</a>
	<?php
		// Banner
		$attachment_id = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
		allianz_elementor_image_render($settings,[
			'name'          => 'banner',
			'attachment_id' => $attachment_id,
			'size'          => 'banner',
			'custom_size'   => ['width' => 290, 'height' => 379],
			'before'        => '<div class="cms-banner text-end"><div class="cms-ebanner-square-2">',
			'after'         => '</div></div>'
		]);
	?>
</div>