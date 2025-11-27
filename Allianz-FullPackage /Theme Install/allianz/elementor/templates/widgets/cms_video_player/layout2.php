<?php
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'd-flex gutter-40',
		$settings['css_classes']
	]
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','accent'),
		'mt-n7 pb-10',
		'text-16 font-600',
		'empty-none'
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'lh-1375',
		'mr-n30 mr-laptop-0',
		'pb-50 pb-mobile-extra-20'
	]
]);
// Heading Button
$heading_btn_link = $widget->get_setting('heading_btn_link','');
switch ($settings['heading_btn_type']) {
	case 'page':
		$heading_btn_page = !empty($heading_btn_link) ? get_page_by_path($heading_btn_link, OBJECT) : [];
		$heading_btn_url  = !empty($heading_btn_page) ? get_permalink($heading_btn_page->ID) : '#';
		break;
	
	default:
		$heading_btn_url = $widget->get_setting('heading_btn_custom_link', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'heading_btn_text', [
	'class' => [
		'text-68',
		'text-primary',
		'text-hover-primary',
		'lh-1',
		'mb-20 order-last order-mobile-extra-first',
		'cms-hover-icon-alternate'
	],
	'href'	=> $heading_btn_url,
	'title' => $settings['heading_btn_text']
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold font-700 empty-none',
		'text-'.$widget->get_setting('description_bold_color','heading'),
		'pt-5'
	])
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pt-25 empty-none',
		'text-'.$widget->get_setting('description_color','body'),
		'pb-45'
	])
]);
// Call to action
// CTA Title
$widget->add_render_attribute('cta_title', [
	'class' => [
		'cta-title',
		'text-'.$widget->get_setting('cta_title_color','heading'),
		'font-600 text-17 lh-1353',
	]
]);
// CTA Text
$widget->add_render_attribute('cta_text', [
	'class' => [
		'cta-desc',
		'text-'.$widget->get_setting('cta_text_color','body'),
		'lh-1588 pr-40 pr-laptop-0',
		'empty-none'
	]
]);
// CTA Button
$cta_btn_link = $widget->get_setting('cta_btn_link','');
switch ($settings['cta_btn_type']) {
	case 'page':
		$cta_btn_page = !empty($cta_btn_link) ? get_page_by_path($cta_btn_link, OBJECT) : [];
		$cta_btn_url  = !empty($cta_btn_page) ? get_permalink($cta_btn_page->ID) : '#';
		break;
	
	default:
		$cta_btn_url = $widget->get_setting('cta_btn_custom_link', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'cta_btn_text', [
	'class' => [
		'btn btn-space-30',
		'btn-'.$widget->get_setting('cta_btn_color','accent'),
		'text-'.$widget->get_setting('cta_btn_text_color','white'),
		'btn-hover-'.$widget->get_setting('cta_btn_color_hover','accent'),
		'text-hover-'.$widget->get_setting('cta_btn_text_hover_color','white'),
		'mt-25',
		'cms-hover-move-icon-up'
	],
	'href'	=> $cta_btn_url
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div class="col-6 col-mobile-extra-12">
		<div class="cms-sticky d-flex flex-column">
			<?php 
				// Icon
				allianz_elementor_icon_image_render($widget, $settings, [
					'size'        => 68,
					'color'       => 'primary',
					'color_hover' => 'primary',
					'class'       => 'rtl-flip d-inline-block',
					'before'      => '<div class="mb-20 order-last order-mobile-extra-first">',
					'after'       => '</div>'
				]);
				// Heading Button
				if(!empty($settings['heading_btn_text'])){
				?>
				<a <?php etc_print_html($widget->get_render_attribute_string('heading_btn_text')); ?>>
					<?php allianz_elementor_svg_hover_icon_render([
							'icon'  => 'alternate',
			        'class' => 'rtl-flip'
			    ]); ?>
				</a>
				<?php
				}
			?>
			<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
			<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
		</div>
	</div>
	<div class="col-6 col-mobile-extra-12 pt-320 pt-mobile-extra-20">
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
		<?php
		// Video title
		ob_start();
		?>
		<div class="video-text-title absolute bottom-right mb-40 mr-80 bg-white empty-none text-17 font-600 cms-radius-tlbl-5 text-primary lh-1412"><?php 
			etc_print_html($settings['video_text_title']); 
		?></div>
		<?php
		$video_text_title = ob_get_clean();
	    // Video Banner
		$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
	    allianz_elementor_image_render($settings, [
			'custom_size'   => ['width' => 620,'height' => 413],
			'img_class'     => 'img-cover',
			'before'        => '',
			'max_height'	=> true,
			'before'		=> '<div class="cms-evideo-banner relative">',
			'after'         => '<div class="cms-gradient-render cms-overlay"></div>'.allianz_elementor_button_video_render($widget, $settings, [
				'name'       => 'video_link',
				// icon
				'icon'       => $widget->get_setting('video_icon'),
				'icon_size'	 => 14,
				'icon_color' => $widget->get_setting('video_text_color', 'primary'),
				'icon_class' => 'text-hover-primary',
				// text
				'text'       => $widget->get_setting('video_text','Watch video'),
				'text_class' => 'text-'.$widget->get_setting('video_text_color', 'primary'),
				'content_class' => 'd-flex gap-10 align-items-center justify-content-center',
				// other
				'layout'      => '2',
				'class'       => 'cms-overlay',
				'inner_class' => 'absolute top-right mt-40 mr-40 bg-white text-15 font-600 cms-radius-tltr-5 cms-polygon-br-36',
				'echo'        => false,
				'default'     => true,
				'stroke'      => false
		    ]).$video_text_title.'</div>'
	    ]);
	    // Call to Action
	    ?>
		<div class="cms-evideo-cta d-flex gutter-50 gutter-laptop-40 pt-30">
			<div class="cms-evideo-cta-text col-8 col-laptop-7 col-tablet-6 col-mobile-extra-12">
				<div <?php etc_print_html($widget->get_render_attribute_string('cta_text')) ?>><?php 
					etc_print_html($settings['cta_text']);
				?></div>
			</div>
			<div class="cms-evideo-cta-cta col-4 col-laptop-5 col-tablet-6 col-mobile-extra-12">
				<div class="cms-evideo-cta-sticky cms-sticky">
					<?php
						// icon
						allianz_elementor_icon_image_render($widget, $settings, [
							'prefix'	  => 'cta',
							'size'        => 18,
							'color'       => 'primary',
							'color_hover' => 'primary',
							'class'       => 'circle',
							'before'      => '<div class="cta-icon mb-25 circle d-flex align-items-center justify-content-center">',
							'after'       => '</div>'
						]);
					?>
					<div <?php etc_print_html($widget->get_render_attribute_string('cta_title')) ?>><?php 
						etc_print_html($settings['cta_title']); 
					?></div>
					<?php if(!empty($settings['cta_btn_text'])): ?>
						<a <?php etc_print_html( $widget->get_render_attribute_string( 'cta_btn_text' ) ); ?>>
							<?php 
								// text
								echo esc_html( $settings['cta_btn_text'] );
								// icon
								allianz_elementor_button_icon_render();
							?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
