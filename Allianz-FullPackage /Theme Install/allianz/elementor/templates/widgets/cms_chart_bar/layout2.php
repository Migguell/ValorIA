<?php
	// Chart Render
	allianz_chart_bar_data_settings($widget, $settings,[
		'wrap_class' => 'p-tb-80 p-lr-90 p-lr-mobile-40 p-lr-smobile-20 bdr-20 bdr-grey cms-radius-8',
		'color3'	=> $widget->get_setting('chart3_color', allianz_configs('accent_color')['regular'])
	]);
?>