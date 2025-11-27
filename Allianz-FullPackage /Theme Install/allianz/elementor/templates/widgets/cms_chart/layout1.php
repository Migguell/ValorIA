<?php
$widget->add_inline_editing_attributes( 'title' );
$widget->add_inline_editing_attributes( 'text' );
$widget->add_inline_editing_attributes( 'link_text' );
$widget->add_inline_editing_attributes( 'link2_text' );
$page_link = $widget->get_setting('page_link','');

$widget->add_render_attribute('title', [
	'class' => ['cms-title text-26 text-heading font-600','empty-none']
]);
$widget->add_render_attribute('text', [
	'class' => ['cms-desc pt-15','empty-none']
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
		'cms-link',
		'cms-hover-move-icon-up',
		'cms-hover-underline-2'
	],
	'href'	=> $url
]);
// Chart 
$charts = $widget->get_settings('cms_chart');
$html_id = etc_get_element_id($settings);
?>
<div class="d-flex gutter">
	<div class="cms-chart-content col-6 col-mobile-12">
		<div <?php etc_print_html($widget->get_render_attribute_string('title'));?>><?php etc_print_html($settings['title']) ?></div>
		<div <?php etc_print_html($widget->get_render_attribute_string('text'));?>><?php echo nl2br($settings['text']) ?></div>
		<?php if(!empty($settings['link_text']) || !empty($settings['link2_text'])){ ?>
		<div class="cms-buttons d-flex align-items-center gap-30 pt-35">
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'link_text' ) ); ?>>
				<?php 
					// text
					echo esc_html( $settings['link_text'] );
					// icon
					allianz_elementor_button_icon_render();
				?>
			</a>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'link2_text' ) ); ?>>
				<?php 
					// text
					echo esc_html( $settings['link2_text'] );
					// icon
					allianz_elementor_button_icon_render();
				?>
			</a>
		</div>
		<?php } ?>
	</div>
	<div class="col-6 col-mobile-12">
		<div class="cms-charts-chart pl-30 cms-sticky">
			<?php allianz_chart_data_settings($widget, $settings); ?>
			<div class="cms-chart-items d-flex pt-25">
	            <?php foreach ($charts as $key => $value): 
	                $chart_setting_key = $widget->get_repeater_setting_key( 'chart_item', 'chart', $key );
	                $widget->add_render_attribute( $chart_setting_key, [
	                    'class' => 'd-inline-block circle',
	                    'style' => 'width: 10px; height: 10px;background-color:'.$value['chart_color']
	                ]);
	            ?>
	               <div class="cms-chart-item-title font-700 text-14 d-flex gap align-items-center flex-50 flex-tablet-extra-full" style="--cms-gap:15px;--cms-gap-tablet-extra:15px;--cms-gap-tablet:15px;"><span <?php $widget->print_render_attribute_string( $chart_setting_key );?>></span><?php etc_print_html($value['chart_main_title']); ?></div>
	            <?php endforeach; ?>
	        </div>
	    </div>
	</div>
</div>