<?php 
	cms_language_switcher([
		'class'          => '',
        'item_class'     => '',
        'link_class'     => 'text-'.$widget->get_setting('color','primary').' text-hover-'.$widget->get_setting('color_hover','accent'),   
        'sub_link_class' => '',   
        'show_flag'      => $widget->get_setting('show_flag','no'),
        'show_name'      => $widget->get_setting('show_name','yes'),
        'name_as'        => $widget->get_setting('name_as', 'full'), // short,
        'dropdown_pos'   => $widget->get_setting('dropdown_pos','bottom')
	]);
?>