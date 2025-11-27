<?php
use Elementor\Icons_Manager;
$default_align = $widget->get_setting('text_align', 'center');
$fancy_boxs = $widget->get_setting('fancy_box', []);
// Wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-fancyboxs-'.$settings['layout'],
		'd-flex gutter',
		allianz_elementor_get_grid_columns($widget, $settings, ['default' => '3', 'tablet' => '2']),
		allianz_elementor_get_alignment_class($widget, $settings, [
			'name'         => 'item_align',
			'prefix_class' => 'justify-content-',
			'default'      => $default_align,
		]),
		allianz_elementor_get_alignment_class($widget, $settings, [
			'name'    => 'text_align',
			'default' => $default_align
		])
	]
]);
// Icons
$icon_classes = allianz_nice_class([
	''
]);
//Title
//$widget->add_inline_editing_attributes('title');
$widget->add_render_attribute( 'title', [
	'class' => [
		'cms-title text-22 font-600 mt-n8',
		'text-'.$widget->get_setting('title_color','heading')
	]
]);
// Description
//$widget->add_inline_editing_attributes( 'description' );
$widget->add_render_attribute( 'description', [
	'class' => [
		'cms-desc',
		'text-'.$widget->get_setting('description_color','body'),
		'lh-1-533',
		'text-16',
		'pt-15',
		'empty-none'
	]
]);
// Output HTMl
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php foreach ($fancy_boxs as $key => $fancy_box) { 
		//
		$page_link = $fancy_box['btn_page_link'];
		switch ($fancy_box['btn_link_type']) {
			case 'page':
				$page = !empty($page_link) ? get_page_by_path($page_link, OBJECT) : [];
				$url  = !empty($page) ? get_permalink($page->ID) : '';
				break;
			
			default:
				$url = $fancy_box['btn_link']['url'];
				break;
		}
		// Item
		$item_key = $widget->get_repeater_setting_key( 'item', 'cms_fancy_box', $key );
		$widget->add_render_attribute( $item_key, [
			'class' => array_filter([
				'cms-fancybox',
				'cms-fancybox-'.$settings['layout'],
				'cms-transition',
				'cms-hover-change'
			])
		]);
		// Link
		$btn_key = $widget->get_repeater_setting_key( 'btn', 'cms_fancy_box', $key );
		$widget->add_render_attribute( $btn_key, [
			'class' => array_filter([
				'cms-link',
				'cms-hover-underline'
			]),
			'href'	=> $url
		]);
	?>
	<div class="fancy-box-item relative">
		<div <?php etc_print_html($widget->get_render_attribute_string($item_key)); ?>>
			<?php
				// Icon
				allianz_elementor_icon_image_render($widget, $fancy_box, [
					'size'        => 48,
					'color'       => $widget->get_setting('icon_color', 'heading'),
					'color_hover' => $widget->get_setting('icon_color_hover', 'accent'),
					'img_size'    => ['width' => 230, 'height' => 157],
					'icon_tag'	  => 'span',
					'class'			  => $icon_classes,
					'before'			=> '<div class="cms-icon mb-40 p-45 p-lr-smobile-20 bg-grey bg-on-hover-accent cms-transition w-100">',
					'after'			  => '</div>' 
				]);
			?>
			<div class="p-lr-40 p-lr-smobile-20">
				<div <?php etc_print_html( $widget->get_render_attribute_string( 'title' ) ); ?>><?php echo nl2br( $fancy_box['title'] ); ?></div>
			 	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description' ) ); ?>><?php echo wpautop( $fancy_box['description'] ); ?></div>
				<?php 
					// When have btn_text
					if ( ! empty( $fancy_box['btn_text'] ) ) : ?>
			        <a <?php etc_print_html( $widget->get_render_attribute_string( $btn_key ) ); ?>><?php echo esc_attr( $fancy_box['btn_text'] ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>