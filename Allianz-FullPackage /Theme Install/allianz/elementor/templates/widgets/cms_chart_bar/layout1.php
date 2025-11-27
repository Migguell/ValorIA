<?php
$widget->add_inline_editing_attributes( 'title' );
$widget->add_inline_editing_attributes( 'text' );
$widget->add_inline_editing_attributes( 'link_text' );
$widget->add_inline_editing_attributes( 'link2_text' );
$page_link = $widget->get_setting('page_link','');

$widget->add_render_attribute('title', [
	'class' => ['cms-heading text-24','empty-none']
]);
$widget->add_render_attribute('text', [
	'class' => ['cms-desc pt-15 pb-30','empty-none']
]);
//Button
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
		'btn btn-secondary text-white btn-hover-primary text-hover-white',
		'cms-hover-move-icon-up'
	],
	'href'	=> $url
]);
//Button2
$link2_page = $widget->get_setting('link2_page','');
switch ($settings['link2_type']) {
	case 'page':
		$page = !empty($link2_page) ? get_page_by_path($link2_page, OBJECT) : [];
		$url  = !empty($page) ? get_permalink($page->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('link2_custom', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'link2_text', [
	'class' => [
		'cms-link d-flex gap-10 align-items-center',
		'cms-hover-move-icon-up',
		'cms-hover-underline-2'
	],
	'href'	=> $url
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('title'));?>><?php echo nl2br($settings['title']) ?></div>
<div <?php etc_print_html($widget->get_render_attribute_string('text'));?>><?php echo nl2br($settings['text']) ?></div>
<?php if(!empty($settings['link_text']) || !empty($settings['link2_text'])){ ?>
<div class="cms-buttons d-flex gap-30 align-items-center pb-40 empty-none"><?php
	if(!empty($settings['link_text'])){
	?><a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text' ) ); ?>>
		<?php 
			// text
			echo esc_html( $settings['link_text'] );
			// icon
			allianz_elementor_button_icon_render();
		?>
	</a><?php 
	}
	if(!empty($settings['link2_text'])) {
	?>
	<a <?php etc_print_html( $widget->get_render_attribute_string( 'link2_text' ) ); ?>>
		<?php 
			// text
			echo esc_html( $settings['link2_text'] );
			// icon
			allianz_elementor_button_icon_render();
		?>
	</a><?php }
?></div>
<?php } 
	// Chart Render
	allianz_chart_bar_data_settings($widget, $settings, [
		'color3'	=> $widget->get_setting('chart3_color', allianz_configs('accent_color')['regular'])
	]); 
?>