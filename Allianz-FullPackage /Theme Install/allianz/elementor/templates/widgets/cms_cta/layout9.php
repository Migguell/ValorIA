<?php
// CTA Title
$widget->add_render_attribute('cta_title', [
	'class' => [
		'cta-title',
		'text-'.$widget->get_setting('cta_title_color','heading'),
		'lh-1375',
		'mt-n10'
	]
]);
// CTA Text
$widget->add_render_attribute('cta_text', [
	'class' => [
		'cta-desc',
		'text-'.$widget->get_setting('cta_text_color','body'),
		'empty-none',
		!empty($settings['cta_title']) ? 'pt-25' : ''
	]
]);
// CTA Button
$cta_9 = $widget->get_setting('cta_9',[]);
?>
<h2 <?php etc_print_html($widget->get_render_attribute_string('cta_title')) ?>><?php etc_print_html(nl2br($settings['cta_title'])); ?></h2>
<div <?php etc_print_html($widget->get_render_attribute_string('cta_text')) ?>><?php etc_print_html(nl2br($settings['cta_text'])); ?></div>
<div class="cms-cta-lists d-flex gap-20 mt-20 pt-30"><?php
	foreach ($cta_9 as $key => $cta) {
		switch ($cta['cta_btn_type']) {
			case 'custom':
				$cta_btn_url = $cta['cta_btn_custom_link']['url'];
				break;
			
			default:
				$cta_btn_page = !empty($cta['cta_btn_link']) ? get_page_by_path($cta['cta_btn_link'], OBJECT, 'cms-service') : [];
				$cta_btn_url  = !empty($cta_btn_page) ? get_permalink($cta_btn_page->ID) : '#';
				break;
		}
		$cta_key = $widget->get_repeater_setting_key( 'cta_key', 'cms_video', $key );
		$widget->add_render_attribute( $cta_key, [
			'class' => [
				'cta-item',
				'cms-backdrop',
				'bg-'.$widget->get_setting('cta_btn_color','white-04'),
				'text-'.$widget->get_setting('cta_btn_text_color','link'),
				'bg-hover-'.$widget->get_setting('cta_btn_color_hover','accent'),
				'text-hover-'.$widget->get_setting('cta_btn_text_hover_color','white'),
			],
			'href'	=> $cta_btn_url
		]);
	?>
		<a <?php etc_print_html($widget->get_render_attribute_string($cta_key)); ?>><?php
			etc_print_html($cta['cta_btn_text']);
		?></a>
	<?php } ?>
</div>