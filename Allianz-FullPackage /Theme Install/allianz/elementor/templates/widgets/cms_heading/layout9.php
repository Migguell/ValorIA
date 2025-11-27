<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eheading',
		'cms-eheading-'.$widget->get_setting('layout'),
		'text-'.$widget->get_setting('align', $default_align)
	])
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'lh-1375',
		'mt-n10'
	]
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pt-20 empty-none',
		'text-'.$widget->get_setting('description_color','body')
	])
]);
// Link 1
$link1_page = $widget->get_setting('link1_page','');
switch ($settings['link1_type']) {
	case 'page':
		$page = !empty($link1_page) ? get_page_by_path($link1_page, OBJECT) : [];
		$url  = !empty($page) ? get_permalink($page->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('link1_custom', ['url' => '#'])['url'];
		break;
}
$widget->add_inline_editing_attributes( 'link1_text' );
$widget->add_render_attribute( 'link1_text', [
	'class' => [
		'btn btn-lg',
		'btn-'.$widget->get_setting('link1_bg_color','accent'),
		'text-'.$widget->get_setting('link1_color','white'),
		'btn-hover-'.$widget->get_setting('link1_bg_hover_color','accent'),
		'text-hover-'.$widget->get_setting('link1_color_hover', 'white'),
		'empty-none',
		'cms-hover-move-icon-up'
	],
	'href'	=> $url
]);
// Signature
$widget->add_render_attribute('signature-wrap',[
	'class' => [
		'cms-signature d-flex flex-nowrap gap-10 align-items-center',
		'justify-content-'.$widget->get_setting('align', $default_align),
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
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
	<div class="d-flex gap-30 pt-30 align-items-center">
		<?php if(!empty($settings['link1_text'])){ ?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'link1_text' ) ); ?>><?php
				// text
				echo esc_html( $settings['link1_text'] ); 
				// icon
				allianz_elementor_button_icon_render();
			?></a>
		<?php } ?>
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