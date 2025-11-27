<?php 
$ctf7_title = '';
if(empty($settings['ctf7_slug']) || $settings['ctf7_slug'] === ''){
	$ctf7_title =  'title="Contact form 1"';
}
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-ecf7',
		'cms-ecf7-'.$settings['layout'],
		'cms-ecf7-fields2',
		'd-flex gutter-0',
		'cms-hover-icon-alternate'
	]
]);
if(!empty($settings['ctf7_bg']['id'])){
	$widget->add_render_attribute('wrap', [
		'class' => [
			'cms-bg-img cms-bg-cover',
			'p-110 p-lr-tablet-50 p-lr-mobile-20'
		]
	]);
}
// title
$widget->add_inline_editing_attributes('ctf7_title');
$widget->add_render_attribute('ctf7_title',[
	'class' => [
		'cms-title cms-heading',
		'text-40 text-smobile-30',
		'text-'.$widget->get_setting('title_color','heading'),
		'mb-15',
		'empty-none',
		'bg-'.$settings['heading_bg_color'],
		'd-flex gap-10'
	]
]);
if(!empty($settings['heading_bg_color'])){
	$widget->add_render_attribute('ctf7_title',[
		'class' => 'p-40 p-lr-mobile-20'
	]);
}
// description
$widget->add_inline_editing_attributes('ctf7_description');
$widget->add_render_attribute('ctf7_description',[
	'class' => [
		'cms-desc',
		'text-'.$widget->get_setting('desc_color','heading'),
		'text-26 font-600 lh-13077',
		'mt-n7 pb-40',
		'empty-none'
	]
]);
// note
$widget->add_inline_editing_attributes('ctf7_note');
$widget->add_render_attribute('ctf7_note',[
	'class' => [
		'cms-note pt-30 font-italic',
		'text-'.$widget->get_setting('note_color','body'),
		'empty-none'
	]
]);
// icon
$icon_class = '';
$banner_icon_class = '';
// Banner
$widget->add_render_attribute('banner',[
	'class' => [
		'col-5 col-mobile-extra-12'
	]
]);
$widget->add_render_attribute('banner-inner',[
	'class' => [
		'relative cms-gradient-accent-bt2',
		'cms-radius-8',
		'text-white',
		'h-100',
		'p-50 pl-tablet-20 pl-mobile-extra-50 p-lr-smobile-20',
		'mr-n20 mr-mobile-extra-n0'
	],
	'style' => [
		'background-image:url('.allianz_elementor_image_src_render([
			'attachment_id'  => $settings['banner']['id'],
			'image_size_key' => 'banner',
			'echo'			 => false
		], $settings).');',
		'background-repeat:no-repeat;',
		'background-position: center;',
		'background-size:cover;'
	]
]);
$widget->add_render_attribute('banner-title',[
	'class' => [
		'cms-banner-title',
		'text-white',
		'lh-1375'
	]
]);
$widget->add_render_attribute('banner-desc',[
	'class' => [
		'cms-banner-desc',
		'pt-20'
	]
]);
$banner_features = $widget->get_setting('ctf7_banner_features',[]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html($widget->get_render_attribute_string('banner')); ?>>
		<div <?php etc_print_html($widget->get_render_attribute_string('banner-inner')); ?>>
			<div class="cms-gradient-render mr-n20 mr-mobile-extra-n0"></div>
			<div class="relative z-top h-100 d-flex justify-content-between flex-column">
				<?php 
					// icon
					allianz_elementor_icon_image_render($widget, $settings, [
						'name'        => 'ctf7_banner_icon',
						'size'        => 160,
						'color'       => 'white',
						'color_hover' => 'white',
						'img_size'    => false,
						'class'       => 'text-end mb-25 mt-n15'
					]);
				?>
				<div class="align-self-end">
					<h2 <?php etc_print_html($widget->get_render_attribute_string('banner-title'));?>><?php 
						// Text
						etc_print_html($settings['ctf7_banner_title']); 
					?></h2>
					<div <?php etc_print_html($widget->get_render_attribute_string('banner-desc')); ?>><?php
						etc_print_html($settings['ctf7_banner_description']);
					?></div>
					<div class="cms-banner-features pt-25 mb-n20"><?php 
						foreach ($banner_features as $key => $feature) {
					?>
						<div class="feature-item font-600 d-flex gap-20">
							<span class="cmsi cmsi-check pt-5"></span>
							<span class="flex-basic"><?php etc_print_html($feature['ctf7_banner_feature']); ?></span>
						</div>
					<?php
						}
					?></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-7 col-mobile-extra-12 z-top">
		<div class="bg-white cms-shadow-2 cms-radius-8 p-50 p-lr-smobile-20 ml-20 ml-mobile-extra-0">
			<h2 <?php etc_print_html($widget->get_render_attribute_string('ctf7_title'));?>><?php 
				// icon
				allianz_elementor_icon_render($settings['ctf7_title_icon'], [], [ 'aria-hidden' => 'true', 'class' => $icon_class, 'icon_color'=>$widget->get_setting('icon_color', 'heading'), 'icon_size' => 40 ] );
				// Text
				echo nl2br($settings['ctf7_title']); 
			?></h2>
			<div <?php etc_print_html($widget->get_render_attribute_string('ctf7_description')); ?>><?php 
				etc_print_html($settings['ctf7_description']);
			?></div>
			<?php echo do_shortcode('[contact-form-7 id="' . esc_attr($settings['ctf7_slug']) . '" '.$ctf7_title.' ]'); ?>
			<div <?php etc_print_html($widget->get_render_attribute_string('ctf7_note')); ?>><?php 
				echo nl2br($settings['ctf7_note']); 
			?></div>
		</div>
	</div>
</div>