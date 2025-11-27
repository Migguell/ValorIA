<?php
	if ( empty( $settings['map_address'] ) ) {
		return;
	}
	if ( 0 === absint( $settings['zoom']['size'] ) ) {
		$settings['zoom']['size'] = 10;
	}
	$api_key = allianz_get_opt('gm_api_key');;
	$map_params = [
		rawurlencode( $settings['map_address'] ),
		absint( $settings['zoom']['size'] ),
	];
	if ( $api_key ) {
		$map_params[] = $api_key;
		$map_url = 'https://www.google.com/maps/embed/v1/place?key=%3$s&q=%1$s&amp;zoom=%2$d';
	} else {
		$map_url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
	}
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-egmap',
		'cms-egmap-'.$settings['layout'],
		'relative'
	]
]);
// Container
$widget->add_render_attribute('overlay-box', [
	'class' => [
		'overlay-box',
		'bg-white cms-shadow-2',
		'p-70 p-tablet-40 p-lr-smobile-20'
	]
]);
// Title
$widget->add_inline_editing_attributes( 'title' );
$widget->add_render_attribute( 'title', [
	'class' => [
		'cms-title',
		'cms-heading',
		'empty-none',
		'mt-n7',
		'pb-10'
	]
]);
// Email
$widget->add_inline_editing_attributes( 'email', 'none' );
$email = $widget->get_setting('email', 'allianz@7oroof.com');
$widget->add_render_attribute( 'email', [
	'class' => [
		'cms-email',
		'text-19 cms-heading',
		'text-heading',
		'd-flex gap-20 align-items-center no-wrap text-ellipsis',
		'pb-10'
	],
	'href'   => 'mailto:'.$email,
	'target' => '_blank'
]);
// Phone
$widget->add_inline_editing_attributes( 'phone', 'none' );
$phone = $settings['phone'];
$phone_link = str_replace(' ', '', $phone);
$widget->add_render_attribute( 'phone',[ 
	'class' => [
		'cms-phone',
		'text-19 cms-heading',
		'text-heading',
		'd-flex gap-20 align-items-center no-wrap text-ellipsis',
		'pb-30'
	],
	'href'   => 'tel:'.$phone_link,
	'target' => '_blank'
]);
// Time
$icon_time_color = $widget->get_setting('icon_time_color', 'primary');
$time_color = $widget->get_setting('time_color', 'primary');
$time_color_hover = $widget->get_setting('time_color_hover', 'primary');
$widget->add_render_attribute( 'time-item', [
	'class' => [
		'cms-time-item',
		'd-flex align-items-center gap-10 justify-content-between',
		allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
		'cms-time',
		'text-'.$time_color,
		'text-hover-'.$time_color_hover,
		'text-15',
		'bdr-b-1 pb-10 mb-10'
	]
]);
$widget->add_render_attribute( 'time-item-end', [
	'class' => [
		'cms-time-item',
		'd-flex align-items-center gap-10 justify-content-between',
		allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
		'cms-time',
		'text-'.$time_color,
		'text-hover-'.$time_color_hover,
		'text-15'
	]
]);
// time icon
$widget->add_render_attribute( 'time-icon', [
	'class' => [
		'cms-icon',
		'cms-icon-color',
		'text-'.$icon_time_color,
		'cmsi-clock',
		'text-16'
	]
]);
// time title
$widget->add_inline_editing_attributes( 'time_title' );
$widget->add_render_attribute( 'time_title', [
	'class' => [
		'cms-time-title',
		'cms-icon-color',
		'text-'.$icon_time_color,
		allianz_add_hidden_device_controls_render($settings, 'title_')
	]
]);
// time
$widget->add_inline_editing_attributes( 'time' );
$widget->add_render_attribute( 'time', [
	'class' => [
		'cms-time-text',
		//allianz_add_hidden_device_controls_render($settings, 'title_')
	]
]);
// Adress
$icon_address_color = $widget->get_setting('icon_address_color', 'primary');
$address_color = $widget->get_setting('address_color', 'primary');
$address_color_hover = $widget->get_setting('address_color_hover', 'primary');
$widget->add_render_attribute( 'address-btn', [
	'class' => [
		'btn',
		'btn-primary',
		'text-white',
		'btn-hover-primary',
		'text-hover-white',
		'mt-30'
	],
	'href'   => vsprintf( $map_url, $map_params ),
	'target' => '_blank'
]);
$widget->add_render_attribute( 'address-item', [
	'class' => [
		'cms-add-item',
		allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
		'cms-address',
		'text-'.$address_color,
		'text-hover-'.$address_color_hover,
		'pb-25 d-block'
	],
	'href'   => vsprintf( $map_url, $map_params ),
	'target' => '_blank'
]);
// address icon
$widget->add_render_attribute( 'address-icon', [
	'class' => [
		'cms-icon',
		'cms-icon-color',
		'text-'.$icon_address_color,
		'cmsi-map-marker',
		'text-16'
	]
]);
// address title
$widget->add_inline_editing_attributes( 'address_title' );
$widget->add_render_attribute( 'address_title', [
	'class' => [
		'cms-address-title',
		'cms-icon-color',
		'text-'.$icon_address_color,
		allianz_add_hidden_device_controls_render($settings, 'title_')
	]
]);
// address
$widget->add_inline_editing_attributes( 'address' );
$widget->add_render_attribute( 'address', [
	'class' => [
		'cms-address-text',
		//allianz_add_hidden_device_controls_render($settings, 'title_')
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<iframe loading="lazy"
		src="<?php echo esc_url( vsprintf( $map_url, $map_params ) ); ?>"
		title="<?php echo esc_attr( $settings['map_address'] ); ?>"
		aria-label="<?php echo esc_attr( $settings['map_address'] ); ?>"
	></iframe>
	<div <?php etc_print_html($widget->get_render_attribute_string('overlay-box')); ?>>
		<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'title' ) ); ?>><?php 
			echo etc_print_html( $widget->get_setting('title') ); 
		?></h2>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'address-item' ) ); ?>>
			<span <?php etc_print_html($widget->get_render_attribute_string('address_title')); ?>><?php echo esc_html($settings['address_title']); ?></span>
			<span <?php etc_print_html($widget->get_render_attribute_string('address')); ?>><?php echo nl2br($settings['address']); ?></span>
		</a>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'time-item' ) ); ?>>
			<span <?php etc_print_html($widget->get_render_attribute_string('time_title')); ?>><?php echo esc_html($settings['time_title']); ?></span>
			<span <?php etc_print_html($widget->get_render_attribute_string('time')); ?>><?php echo esc_html($settings['time']); ?></span>
		</div>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'time-item' ) ); ?>>
			<span <?php etc_print_html($widget->get_render_attribute_string('time_title')); ?>><?php echo esc_html($settings['sat_title']); ?></span>
			<span <?php etc_print_html($widget->get_render_attribute_string('time')); ?>><?php echo esc_html($settings['sat_time']); ?></span>
		</div>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'time-item-end' ) ); ?>>
			<span <?php etc_print_html($widget->get_render_attribute_string('time_title')); ?>><?php echo esc_html($settings['sun_title']); ?></span>
			<span <?php etc_print_html($widget->get_render_attribute_string('time')); ?>><?php echo esc_html($settings['sun_time']); ?></span>
		</div>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'address-btn' ) ); ?>><?php 
			printf('%s', $widget->get_setting('direction_text', 'Get Directions'));
		?></a>
	</div>
</div>