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
		'cms-desc empty-none',
		'text-'.$widget->get_setting('description_color','body'),
		'pt-30'
	])
]);
// Feature
$features = $widget->get_setting('cms_feature', []);
$widget->add_render_attribute('features-wrap', [
	'class' => [
		'cms-heading-features pt-35 d-flex',
		allianz_elementor_get_grid_columns($widget, $settings, ['prefix_class' => 'flex-col-', 'default' => '1']),
		'gutter gutter-30',
		'cms-lists-1'
	]
]);
$widget->add_render_attribute('features-item',[
	'class' => [
		'feature-item cms-list',
		'd-flex flex-nowrap gap-15'
	]
]);
// Feature title
$widget->add_render_attribute('feature-title', [
	'class' => [
		'feature-title text-17 font-600',
		'text-'.$widget->get_setting('feature_title_color','heading')
	]
]);
// Feature Desc
$widget->add_render_attribute('feature-desc', [
	'class' => [
		'feature-desc text-15',
		'text-'.$widget->get_setting('feature_desc_color','body'),
		'pt-5 empty-none'
	]
]);
// Feature icon
$feature_icon_args = [ 
	'aria-hidden' => 'true', 
	'class'       => 'feature-item-icon pt-7',
	'icon_size'   => 12,
	'icon_color'  => $widget->get_setting('feature_icon_color','accent')
];
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
	<?php 
	// Feature
	if($settings['show_feature'] == 'yes'): ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('features-wrap')); ?>>
		<?php 
		foreach ( $features as $key => $cms_feature ):
		?>
      <div <?php etc_print_html($widget->get_render_attribute_string('features-item')); ?>>
          <?php 
          	allianz_elementor_icon_render($cms_feature['icon'], ['library' => 'cmsi','value'=>'cmsi-check'], $feature_icon_args);
          ?>
          <div class="feature-item-content cms-list-content">
	        	<div <?php etc_print_html( $widget->get_render_attribute_string('feature-title') ); ?>><?php echo esc_html( $cms_feature['title'] ) ?></div>
	        	<div <?php etc_print_html( $widget->get_render_attribute_string('feature-desc') ); ?>><?php
	        		echo nl2br($cms_feature['description']);
	        	?></div>
	        </div>
      </div>
		<?php endforeach;?>
	</div>
	<?php endif; ?>
</div>