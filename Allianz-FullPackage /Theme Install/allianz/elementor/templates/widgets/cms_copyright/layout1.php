<?php 
$current_year = date('Y');
$theme_name = get_bloginfo('name');
// wrap
$widget->add_inline_editing_attributes('copyright_text');
$widget->add_render_attribute('copyright_text',[
	'class' => [
		'cms-ecopyright cms-ecopyright-'.$widget->get_setting('layout','1'),
		'text-'.$widget->get_setting('text_color','body')
	]
]);
$link_color = 'text-'.$widget->get_setting('link_color','primary');
$link_color_hover = 'text-hover-'.$widget->get_setting('link_color_hover','accent');
$link_class = '<a class="'.$link_color.' '.$link_color_hover.' cms-hover-underline" href=';
?>
<div <?php etc_print_html($widget->get_render_attribute_string('copyright_text')); ?>>
<?php
	$copyright_text = $widget->get_settings('copyright_text', '&copy;[[year]] [[name]], All Rights Reserved. With Love by <a href="https://7oroofthemes.com/" target="_blank" rel="nofollow">7oroof.com</a>');
	$copyright_text = str_replace(['[[year]]','[[name]]'], [$current_year, $theme_name], $copyright_text);
	$copyright_text = str_replace('<a href=', $link_class, $copyright_text);
	etc_print_html($copyright_text); 
?>
</div>