<?php 
$cms_lists = $widget->get_setting('cms_lists',[]);
$cms_lists2 = $widget->get_setting('cms_lists2',[]);
// wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-elists',
		'cms-elists-'.$settings['layout'],
		'd-flex gutter',
		allianz_elementor_get_grid_columns($widget, $settings, ['default' => '2', 'mobile' => '1']),
		'text-18 font-600'
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div class="cms-list cms-list-col1">
		<?php
		// Column #1
		if(!empty($cms_lists)){
			foreach ($cms_lists as $key => $list) {
				$link_text     = $list['link_text'];
				$link_type     = $list['link_type'];
				$link_page     = $list['link_page'];
				$link_industry = $list['link_industry'];
				$link_custom   = $list['link_custom'];
				// get URL
				switch ($link_type) {
					case 'page':
						$page = !empty($link_page) ? get_page_by_path($link_page, OBJECT) : [];
						$url  = !empty($page) ? get_permalink($page->ID) : '#';
						break;
					case 'cms-industry':
						$page_industry = !empty($link_industry) ? get_page_by_path($link_industry, OBJECT, 'cms-industry') : [];
						$url  = !empty($page_industry) ? get_permalink($page_industry->ID) : '#';
						break;
					default:
						$url = $list['link_custom']['url'];
						break;
				}
				$list_key = $widget->get_repeater_setting_key( 'list_key', 'cms_list', $key );
				$widget->add_render_attribute( $list_key, [
					'class' => [
						'list--item',
						'text-'.$widget->get_setting('link_color','link'),
						'text-hover-'.$widget->get_setting('link_color_hover','accent'),
						'd-flex justify-content-between flex-nowrap',
						'cms-hover-show-readmore',
						'overflow-hidden'
					],
					'href'	=> $url
				]);
				// link icon
				$link_icon_key = $widget->get_repeater_setting_key( 'link_icon_key', 'cms_list', $key );
				$widget->add_render_attribute($link_icon_key, [
					'class' => [
						'cms-readmore cms-readmore-icon in-right cms-hover-move-icon-up text-12',
						'text-white text-hover-white',
						'bg-'.$widget->get_setting('link_bg_color','accent'),
						'bg-hover-'.$widget->get_setting('link_bg_hover_color','accent'),
						'align-self-end'
					]
				]);
			?>
				<a <?php etc_print_html($widget->get_render_attribute_string($list_key)); ?>><?php
					// text
					etc_print_html($link_text);
					// icon
					allianz_elementor_button_icon_render([
						'before' => '<span '.$widget->get_render_attribute_string($link_icon_key).'>',
						'after'	 => '</span>'
					]);
				?></a>
			<?php } ?>
		</div>
	<?php }
	if(!empty($cms_lists2)){
	?>
		<div class="cms-list cms-list-col2">
			<?php
			// Column #2
			foreach ($cms_lists2 as $key => $list) {
				$link_text     = $list['link_text'];
				$link_type     = $list['link_type'];
				$link_page     = $list['link_page'];
				$link_industry = $list['link_industry'];
				$link_custom   = $list['link_custom'];
				// get URL
				switch ($link_type) {
					case 'page':
						$page = !empty($link_page) ? get_page_by_path($link_page, OBJECT) : [];
						$url  = !empty($page) ? get_permalink($page->ID) : '#';
						break;
					case 'cms-industry':
						$page_industry = !empty($link_industry) ? get_page_by_path($link_industry, OBJECT, 'cms-industry') : [];
						$url  = !empty($page_industry) ? get_permalink($page_industry->ID) : '#';
						break;
					default:
						$url = $list['link_custom']['url'];
						break;
				}
				$list_key2 = $widget->get_repeater_setting_key( 'list_key2', 'cms_list', $key );
				$widget->add_render_attribute( $list_key2, [
					'class' => [
						'list--item',
						'text-'.$widget->get_setting('link_color','link'),
						'text-hover-'.$widget->get_setting('link_color_hover','accent'),
						'd-flex justify-content-between flex-nowrap',
						'cms-hover-show-readmore',
						'overflow-hidden'
					],
					'href'	=> $url
				]);
				// link icon
				$link_icon_key = $widget->get_repeater_setting_key( 'link_icon_key', 'cms_list', $key );
				$widget->add_render_attribute($link_icon_key, [
					'class' => [
						'cms-readmore cms-readmore-icon in-right cms-hover-move-icon-up text-12',
						'text-white text-hover-white',
						'bg-'.$widget->get_setting('link_bg_color','accent'),
						'bg-hover-'.$widget->get_setting('link_bg_hover_color','accent'),
						'align-self-end'
					]
				]);
			?>
				<a <?php etc_print_html($widget->get_render_attribute_string($list_key2)); ?>><?php
					// text
					etc_print_html($link_text);
					// icon
					allianz_elementor_button_icon_render([
						'before' => '<span '.$widget->get_render_attribute_string($link_icon_key).'>',
						'after'	 => '</span>'
					]);
				?></a>
			<?php } ?>
		</div>
	<?php } ?>
</div>