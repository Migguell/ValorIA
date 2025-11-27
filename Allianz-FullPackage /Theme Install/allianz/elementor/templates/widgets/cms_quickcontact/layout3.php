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
			'text-22',
			'mb-25'
		]
	]);
	// Description
	$widget->add_inline_editing_attributes( 'desc', 'none' );
	$widget->add_render_attribute( 'desc', [
		'class' => [
			'cms-desc',
			'text-'.$widget->get_setting('desc_color','body')
		]
	]);
	$desc = $widget->get_setting('desc','');
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php if (!empty($widget->get_setting('title'))) { ?>
		<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'title' ) ); ?>><?php 
			echo etc_print_html( $widget->get_setting('title') ); 
		?></h2>
	<?php } ?>
	<?php if(!empty($desc)) { ?>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'desc' ) ); ?>><?php 
			echo nl2br( $desc ); 
		?></div>
	<?php } ?>
</div>