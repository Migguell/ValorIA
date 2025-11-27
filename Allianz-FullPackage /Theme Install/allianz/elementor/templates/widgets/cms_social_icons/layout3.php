<?php
use Elementor\Icons_Manager;

$icons = $widget->get_setting('icons', []);
$hover_animation = $widget->get_setting('hover_animation', '');
$class_animation = '';
if(!empty($hover_animation)){
	$class_animation = 'elementor-animation-' . $hover_animation;
}
$settings = $widget->get_settings_for_display();
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'text-13',
		'text-'.$widget->get_setting('heading_text_color'),
		allianz_elementor_get_alignment_class($widget, $settings, [
			'name' 		   => 'align',
			'prefix_class' => 'text-'
		])
	]
]);
//wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-social-icons',
		'cms-social-icons-'.$settings['layout'],
		'd-flex gap-'.$widget->get_setting('gap','15'),
		'text-20',
		allianz_elementor_get_alignment_class($widget, $settings, [
			'name' 		     => 'align',
			'prefix_class' => 'justify-content-'
		])
	]
]);
?>

<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></div>
	<?php
		foreach ( $icons as $key => $value ) {
			$_id = isset( $value['_id'] ) ? $value['_id'] : '';
			$social = '';
			if ( 'svg' !== $value['social_icon']['library'] ) {
				$social = explode( ' ', $value['social_icon']['value'], 2 );
				if ( empty( $social[1] ) ) {
					$social = '';
				} else {
					$social = str_replace( 'fa-', '', $social[1] );
				}
			}
			if ( 'svg' === $value['social_icon']['library'] ) {
				$social = get_post_meta( $value['social_icon']['value']['id'], '_wp_attachment_image_alt', true );
			}
			$link_key = $widget->get_repeater_setting_key( 'link', 'icons', $key );
			$widget->add_render_attribute( $link_key, 'class', [
					'cms-social-item d-flex align-items-center gap-10',
					'cms-animate-icon',
					$class_animation,
					'elementor-repeater-item-' . $_id,
					'text-'.$widget->get_setting('icon_color','accent'),
					'text-hover-'.$widget->get_setting('icon_hover_color', 'primary')
				] );

			$widget->add_link_attributes( $link_key, $value['link'] );

			$title_key = $widget->get_repeater_setting_key( 'title', 'icons', $key );
			$widget->add_render_attribute($title_key, [
				'class' => [
					'cms-title',
					'text-'.$widget->get_setting('title_color','primary'),
					allianz_add_hidden_device_controls_render($settings, 'title_')
				]
			]);
			$widget->add_inline_editing_attributes($title_key);
	?>
	<a <?php etc_print_html($widget->get_render_attribute_string( $link_key )); ?>>
		<?php Icons_Manager::render_icon( $value['social_icon'], [ 'aria-hidden' => 'true', 'class' => 'cms-icon text-20' ] ); ?>
		<?php if ( 'yes' === $settings['show_title'] ) { ?><span <?php etc_print_html($widget->get_render_attribute_string( $title_key )); ?>><?php echo esc_html($value['title']); ?></span><?php } ?>
	</a>
	<?php } ?>
</div>