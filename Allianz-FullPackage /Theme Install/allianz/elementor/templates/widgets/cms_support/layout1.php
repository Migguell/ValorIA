<?php 
	// Title
	$widget->add_inline_editing_attributes('title');
	$widget->add_render_attribute('title',[
		'class' => 'cms-title text-24 lh-14167 text-white empty-none pb-25 mt-n7'
	]);
	// Description
	$widget->add_inline_editing_attributes('description');
	$widget->add_render_attribute('description',[
		'class' => 'cms-desc text-white empty-none'
	]);
	// Button
	$page_link = $widget->get_setting('page_link','');
	switch ($settings['btn_type']) {
		case 'page':
			$page = !empty($page_link) ? get_page_by_path($page_link, OBJECT) : [];
			$url  = !empty($page) ? get_permalink($page->ID) : '#';
			break;
		
		default:
			$url = $widget->get_setting('custom_link', ['url' => '#'])['url'];
			break;
	}
	$widget->add_inline_editing_attributes('btn_text');
	$widget->add_render_attribute( 'btn_text', [
		'class' => [
			'btn btn-lg',
			'btn-white',
			'btn-hover-'.$widget->get_setting('btn_bg_hover_color','white'),
			'mt-80'
		],
		'href'	=> $url
	]);
	// Phone
	$widget->add_inline_editing_attributes('phone');
	$widget->add_render_attribute( 'phone', [
		'href'   => 'tel:'.$settings['phone'],
		'target' => '_blank',
		'class'  => [
			'cms-sinfo',
			'cms-sphone',
			'font-600',
			'text-17',
			'd-flex gap-10 align-items-center',
			'text-'.$widget->get_setting('info_color','white'),
			'text-hover-'.$widget->get_setting('info_hover_color','white'),
			'cms-hover-underline',
			'empty-none'
		]
	]);
	// Address
	$address     = $widget->get_setting('address', '2307 Beverley Rd Brooklyn, New York 11226 U.S');
	$map_zoom    = 14;
	$map_api_key = allianz_get_opt('gm_api_key');
	$map_params  = [
	    rawurlencode( $address ),
	    absint( $map_zoom )
	];
	$map_url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;iwloc=near';

	$widget->add_inline_editing_attributes('address');
	$widget->add_render_attribute( 'address', [
		'href'   => $map_url,
		'target' => '_blank',
		'class'  => [
			'cms-sinfo',
			'cms-saddress',
			'font-600',
			'text-17',
			'd-flex gap-10 align-items-center',
			'text-'.$widget->get_setting('info_color','white'),
			'text-hover-'.$widget->get_setting('info_hover_color','white'),
			'cms-hover-underline',
			'empty-none'
		]
	]);
	// Email
	$email_text = $settings['email_text'];
	$email = $settings['email'];
	$widget->add_render_attribute( 'email', [
		'href'   => 'mailto:'.$email,
		'target' => '_blank',
		'class'  => [
			'cms-sinfo',
			'cms-semail',
			'font-600',
			'text-17',
			'd-flex gap-10 align-items-center',
			'text-'.$widget->get_setting('info_color','white'),
			'text-hover-'.$widget->get_setting('info_hover_color','white'),
			'cms-hover-underline',
			'empty-none'
		]
	]);
?>
<div class="cms-esupport-1">
	<?php
	// HTML 
		allianz_elementor_image_render($settings, [
			'name'        => 'banner',
			'img_class'   => 'img-cover',
			'custom_size' => ['width' => 370, 'height' => 485],
			'before'      => '<div class="cms-overlay cms-gradient-'.$widget->get_setting('banner_gradient','accent-bt2').' overflow-hidden">',
			'after'       => '<div class="cms-gradient-render overflow-hidden"></div></div>'
		]);
	?>
	<div class="cms-content relative z-top p-50 p-lr-tablet-extra-40 p-lr-tablet-30 p-lr-smobile-20 cms-shadow-1">
		<h3 <?php etc_print_html($widget->get_render_attribute_string('title')); ?>><?php etc_print_html($settings['title']); ?></h3>
		<div <?php etc_print_html($widget->get_render_attribute_string('description')); ?>><?php etc_print_html($settings['description']); ?></div>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'btn_text' ) ); ?>>
			<?php
				// text
				echo esc_html( $settings['btn_text'] );
			?>
			<span class="allianz-icon-up-right-arrow text-12 rtl-flip" aria-hidden="true"></span>
		</a>
		<div class="cms-esupport-ct pt-25 mb-n7">
			<?php 
			// Email
			if(!empty($settings['email_text'])): ?><a <?php etc_print_html( $widget->get_render_attribute_string( 'email' ) ); ?>><i class="cmsi-email text-15 rtl-flip flex-auto"></i><span class="flex-basic"><?php etc_print_html($settings['email_text']); ?></span></a>
			<?php endif;
			// Phone
			if(!empty($settings['phone'])){
			?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'phone' ) ); ?>><i class="cmsi-phone-alt text-15 rtl-flip flex-auto"></i><span class="flex-basic"><?php etc_print_html($settings['phone']); ?></span></a>
			<?php 
			}
			// Address
			if(!empty($settings['address'])): ?>
				<a <?php etc_print_html( $widget->get_render_attribute_string( 'address' ) ); ?>><i class="cmsi-map-marker text-20 flex-auto"></i><span class="flex-basic"><?php etc_print_html($settings['address']); ?></span></a>
			<?php endif; ?>
		</div>
	</div>
</div>