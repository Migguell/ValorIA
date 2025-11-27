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
		'pb-10'
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold font-700 empty-none',
		'text-'.$widget->get_setting('description_bold_color','heading'),
		'pt-5 pb-25'
	])
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc empty-none',
		'text-'.$widget->get_setting('description_color','body')
	])
]);
// Signature
$widget->add_render_attribute('signature-wrap',[
	'class' => [
		'cms-signature relative',
		'd-inline-flex',
		'pt-20 pb-110 pr-40'
	]
]);
//
$widget->add_inline_editing_attributes( 'sname' );
$widget->add_render_attribute('sname', [
	'class' => [
		'sname',
		'cms-title text-17 font-700',
		'text-'.$widget->get_setting('heading_color','heading'),
	]
]);
//
$widget->add_inline_editing_attributes( 'sposition' );
$widget->add_render_attribute('sposition', [
	'class' => [
		'sposition',
		'text-14 pt-5',
		'text-'.$widget->get_setting('description_color','body')
	]
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
$video_cta3 = $widget->get_setting('video_cta3',[]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php 
		allianz_elementor_button_video_render($widget, $settings, [
			'name'       => 'video_link',
			// icon
			'icon'       => $widget->get_setting('video_icon'),
			'icon_size'	 => 14,
			'icon_color' => $widget->get_setting('video_text_color', 'primary'),
			'icon_class' => 'lh-1',
			// text
			'text'       => $widget->get_setting('video_text',''),
			'text_class' => 'text-'.$widget->get_setting('video_text_color', 'primary'),
			'content_class' => '',
			// other
			'layout'      => '1',
			'class'       => 'relative justify-content-center lh-1',
			'inner_class' => 'd-flex align-items-center justify-content-center',
			'echo'        => true,
			'default'     => true,
			'stroke'      => false,
			//
			'before'			=> '<div class="col-6 col-tablet-extra-4 col-mobile-extra-12"><div class="cms-sticky d-flex justify-content-end justify-content-mobile-extra-start align-items-end pr-70 pr-tablet-0 pt-40"><img src="'.get_template_directory_uri().'/assets/images/arrow-video.webp" class="cms-btn-video-arrow" />',
			'after'			  => '</div></div>'
    ]);
	?>
	<div class="col-6 col-tablet-extra-8 col-mobile-extra-12">
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
		<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
		<?php // Signature ?>
		<div <?php etc_print_html($widget->get_render_attribute_string('signature-wrap')); ?>>
			<?php 
				allianz_elementor_image_render($settings, [
					'name'        => 'simage',
					'size'        => 'full',
					'custom_size' => ['width' => 106, 'height'=> 78],
					'img_class'		=> 'absolute top-right'
				]);
			?>
			<div class="cms--signature">
				<div <?php etc_print_html($widget->get_render_attribute_string('sname')); ?>><?php echo nl2br($settings['sname']); ?></div>
				<div <?php etc_print_html($widget->get_render_attribute_string('sposition')); ?>><?php echo nl2br($settings['sposition']); ?></div>
			</div>
		</div>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
		<?php // Call to Action ?>
		<div class="cms-evideo-cta cms-cta-lists d-flex gap-20 mt-20 pt-30"><?php
			foreach ($video_cta3 as $key => $cta) {
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
	</div>
</div>
