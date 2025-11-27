<?php
	// Wrap 
	$widget->add_render_attribute('wrap',[
		'class' => [
			'cms-eqc',
			'cms-eqc-'.$settings['layout'],
			allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align'])
		]
	]);
	// Title
	$widget->add_inline_editing_attributes( 'title', 'Quick Contact' );
	$widget->add_render_attribute( 'title', [
		'class' => [
			'cms-title',
			'text-'.$widget->get_setting('title_color','heading'),
			'text-20 font-600 pb-15'
		]
	]);
	// Email
		$icon_email_color = $widget->get_setting('icon_email_color', 'primary');
		$email_color = $widget->get_setting('email_color', 'primary');
		$email_color_hover = $widget->get_setting('email_color_hover', 'accent');
		$widget->add_render_attribute( 'email-item', [
			'class' => [
				'cms-eqc-item',
				'd-flex align-items-center gap-10',
				allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
				'cms-email',
				'text-'.$email_color,
				'text-hover-'.$email_color_hover,
				'text-14'
			],
			'href'   => 'mailto:'.$settings['email'],
			'target' => '_blank'
		]);
		// email icon
		$widget->add_render_attribute( 'email-icon', [
			'class' => [
				'cms-icon',
				'cms-icon-color',
				'text-'.$icon_email_color,
				'cmsi-email',
				'text-16'
			]
		]);
		// email title
		$widget->add_inline_editing_attributes( 'email_title' );
		$widget->add_render_attribute( 'email_title', [
			'class' => [
				'cms-email-title',
				'cms-icon-color',
				'text-'.$icon_email_color,
				allianz_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
		// email
		$widget->add_inline_editing_attributes( 'email' );
		$widget->add_render_attribute( 'email', [
			'class' => [
				'cms-email-text',
				//allianz_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
	// Phone
	$icon_phone_color = $widget->get_setting('icon_phone_color', 'primary');
	$phone_color = $widget->get_setting('phone_color', 'primary');
	$phone_color_hover = $widget->get_setting('phone_color_hover', 'accent');
	$phone_link  = str_replace(' ', '', $settings['phone']);
	$widget->add_render_attribute( 'phone-item',[ 
		'class' => [
			'cms-eqc-item',
			'd-flex align-items-center gap-10',
			allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
			'cms-phone',
			'text-'.$phone_color,
			'text-hover-'.$phone_color_hover,
			'text-14'
		],
		'href' => 'tel:'.$phone_link
	]);
		// phone icon
		$widget->add_render_attribute( 'phone-icon', [
			'class' => [
				'cms-icon',
				'cms-icon-color',
				'text-'.$icon_phone_color,
				'cmsi-phone-alt'
			]
		]);
		// phone title
		$widget->add_inline_editing_attributes('phone_title');
		$widget->add_render_attribute( 'phone_title',[ 
			'class' => [
				'cms-phone-title',
				'cms-icon-color',
				'text-'.$icon_phone_color,
				allianz_add_hidden_device_controls_render($settings, 'title_'),
				'empty-none'
			]
		]);
		// phone number
		$widget->add_inline_editing_attributes('phone');
		$widget->add_render_attribute( 'phone',[ 
			'class' => [
				'cms-phone-text',
				//allianz_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
	// Time
		$icon_time_color = $widget->get_setting('icon_time_color', 'primary');
		$time_color = $widget->get_setting('time_color', 'primary');
		$time_color_hover = $widget->get_setting('time_color_hover', 'accent');
		$widget->add_render_attribute( 'time-item', [
			'class' => [
				'cms-eqc-item',
				allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
				'cms-time',
				'text-'.$time_color,
				'text-hover-'.$time_color_hover,
				'text-14',
				'pt-35'
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
				allianz_add_hidden_device_controls_render($settings, 'title_'),
				'text-20 font-600 pb-15'
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
		$address_color_hover = $widget->get_setting('address_color_hover', 'accent');

		$address     = $settings['address'];
		$map_zoom    = 14;
		$map_api_key = allianz_get_opt('gm_api_key');
		$map_params  = [
		    rawurlencode( $address ),
		    absint( $map_zoom )
		];
		$map_url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;iwloc=near';
		
		$widget->add_render_attribute( 'address-item', [
			'class' => [
				'cms-eqc-item',
				allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-']),
				'cms-address',
				'text-'.$address_color,
				'text-hover-'.$address_color_hover,
				'd-block pt-35'
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
				'text-20 font-600 pb-15',
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
				'text-14'
				//allianz_add_hidden_device_controls_render($settings, 'title_')
			]
		]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php if (!empty($widget->get_setting('title'))) { ?>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'title' ) ); ?>><?php 
			echo etc_print_html( $widget->get_setting('title') ); 
		?></div>
	<?php } 
	// Email
	if(!empty($settings['email'])){
	?>
	<a <?php etc_print_html( $widget->get_render_attribute_string( 'email-item' ) ); ?>>
		<span <?php etc_print_html($widget->get_render_attribute_string('email_title')); ?>><?php echo esc_html($settings['email_title']); ?></span>
		<span <?php etc_print_html($widget->get_render_attribute_string('email')); ?>><?php echo esc_html($settings['email']); ?></span>
	</a>
	<?php }
	// Phone
	if(!empty($settings['phone'])) { ?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'phone-item' ) ); ?>>
			<span <?php etc_print_html($widget->get_render_attribute_string('phone_title')); ?>><?php echo esc_html($settings['phone_title']); ?></span>
			<span <?php etc_print_html($widget->get_render_attribute_string('phone')); ?>><?php echo esc_html($settings['phone']); ?></span>
		</a>
	<?php }
	// Address
	if(!empty($address)) { ?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'address-item' ) ); ?>>
			<div <?php etc_print_html($widget->get_render_attribute_string('address_title')); ?>><?php echo esc_html($settings['address_title']); ?></div>
			<div <?php etc_print_html($widget->get_render_attribute_string('address')); ?>><?php echo nl2br($settings['address']); ?></div>
		</a>
	<?php }
	// Time
	if(!empty($settings['time'])){
	?>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'time-item' ) ); ?>>
		<div <?php etc_print_html($widget->get_render_attribute_string('time_title')); ?>><?php echo esc_html($settings['time_title']); ?></div>
		<div <?php etc_print_html($widget->get_render_attribute_string('time')); ?>><?php echo esc_html($settings['time']); ?></div>
		<div class="exclude-time text-red empty-none w-100"><?php etc_print_html($settings['exclude_time']); ?></div>
	</div>
	<?php } ?>
</div>