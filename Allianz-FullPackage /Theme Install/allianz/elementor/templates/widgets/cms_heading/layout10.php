<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eheading',
		'cms-eheading-'.$widget->get_setting('layout'),
		'text-'.$widget->get_setting('align', $default_align),
		'cms-radius-tr-8 bg-grey',
		'cms-ebg-img bg-br'
	])
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','heading'),
		'text-17 font-600',
		'empty-none',
		'd-flex flex-nowrap gap-30 align-items-center'
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'lh-1375',
		'mt-n10'
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold font-600 empty-none',
		'text-'.$widget->get_setting('description_bold_color','heading'),
		'pb-25 mt-n7'
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
		'cms-signature d-flex flex-nowrap gap-10 align-items-center',
		'justify-content-'.$widget->get_setting('align', $default_align),
		'pt-15'
	]
]);
$savatar_class = allianz_nice_class(['savatar', 'circle']);
//
$widget->add_inline_editing_attributes( 'sname' );
$widget->add_render_attribute('sname', [
	'class' => [
		'sname',
		'text-heading text-17 font-600',
		'text-nowrap'
	]
]);
//
$widget->add_inline_editing_attributes( 'sposition' );
$widget->add_render_attribute('sposition', [
	'class' => [
		'sposition',
		'text-14 text-heading',
	]
]);
// Experience
$widget->add_inline_editing_attributes( 'experience_text' );
$widget->add_render_attribute('experience_text', [
	'class' => [
		'experience-text',
		'cms-bg-img',
		'text-17 font-600 text-primary',
		'empty-none',
		'bdr-1 bdr-primary-regular bdr-hover-accent-regular cms-radius-8 cms-transition',
		'pt-40 p-lr-40 pb-35',
		'hover-icon-bounce'
	]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php
		// Icon
		allianz_elementor_icon_image_render($widget, $settings, [
			'name'				=> 'heading_icon',
			'size'        => 18,
			'color'       => 'white',
			'color_hover' => 'white',
			'class'       => 'rtl-flip d-inline-block bg-accent p-tb-26 p-lr-15',
			'before'      => '',
			'after'       => ''
		]);
		// text
		echo nl2br( $settings['smallheading_text'] ); 
	?></div>
	<div class="p-tb-110 p-tb-tablet-40 pl-50 p-lr-mobile-20 pr-220 pr-tablet-extra-50">
		<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
		<div class="d-flex gap-60 gap-tablet-extra-40 gap-mobile-20 flex-nowrap flex-smobile-wrap align-items-start pt-40">
			<?php  // Experience ?>
			<div <?php etc_print_html($widget->get_render_attribute_string('experience_text')); ?>><?php
				// Icon
				allianz_elementor_icon_image_render($widget, $settings, [
					'name'				=> 'experience_icon',
					'size'        => 68,
					'color'       => 'accent',
					'color_hover' => 'accent',
					'class'       => 'rtl-flip mb-30 cms-icon d-block',
					'before'      => '',
					'after'       => ''
				]);
				// text
				etc_print_html($settings['experience_number'].' '.$settings['experience_text']);
			?></div>
			<div class="flex-basic flex-smobile-100">
				<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
				<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
				<?php // Signature ?>
				<div <?php etc_print_html($widget->get_render_attribute_string('signature-wrap')); ?>>
					<?php allianz_elementor_image_render($settings, [
						'name'        => 'savatar',
						'size'		  => 'custom',
						'custom_size' => ['width' => 56, 'height' => 56],
						'img_class'   => $savatar_class,
						'before'      => '<div class="savatars circle outline-1">',
						'after'       => '</div>'
					]); ?>
					<div class="stext flex-auto relative pl-50">
						<?php 
							allianz_elementor_image_render($settings, [
								'name'        => 'simage',
								'size'        => 'custom',
								'custom_size' => ['width' => 106, 'height'=> 78]
							]);
						?>
						<div class="cms--signature absolute center-left">
							<div <?php etc_print_html($widget->get_render_attribute_string('sname')); ?>><?php echo nl2br($settings['sname']); ?></div>
							<div <?php etc_print_html($widget->get_render_attribute_string('sposition')); ?>><?php echo nl2br($settings['sposition']); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>