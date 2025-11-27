<?php
$html_id            = etc_get_element_id( $settings );
$active_section     = $widget->get_settings('active_section', 1);
$accordions         = $widget->get_settings('cms_accordion');
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-accordion',
		'cms-accordion-'.$settings['layout'],
	]
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading text-16 font-600 pb-10',
		'text-'.$widget->get_setting('smallheading_color','accent'),
		'empty-none'
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-40 text-mobile-30 lh-1375',
		'text-'.$widget->get_setting('heading_color'),
		empty($settings['description_text']) ? 'pb-30' : 'pb-20'
	]
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pb-25 empty-none',
		'text-'.$widget->get_setting('description_color','body')
	])
]);
?>
<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php
		foreach ( $accordions as $key => $value ):
			$is_active = ( $key + 1 ) == $active_section;
			$_id        = isset( $value['_id'] ) ? $value['_id'] : '';
			$ac_title   = isset( $value['ac_title'] ) ? $value['ac_title'] : '';
			$ac_content = isset( $value['ac_content'] ) ? $value['ac_content'] : '';
			// Title Wrap
			$title_wrap_key = $widget->get_repeater_setting_key('ac_title_wrap', 'cms_accordion', $key);
			$widget->add_render_attribute($title_wrap_key, [
				'class' => [
					'cms-accordion-title',
					$is_active ? 'active' : '', 
					'd-flex gap-30 gap-smobile-10',
					'text-'.$widget->get_setting('title_color','heading'),
					'text-hover-'.$widget->get_setting('title_active_color','primary'),
					'text-active-'.$widget->get_setting('title_active_color','primary')
				],
				'data-target' => '#' . $_id . $html_id
			]);
			// Title
			$title_key = $widget->get_repeater_setting_key( 'ac_title', 'cms_accordion', $key );
			$widget->add_render_attribute( $title_key, [
				'class' => [ 
					'cms-accordion-title-text',
					'flex-basic',
					'text-20 font-600'
				],
			] );
			$widget->add_inline_editing_attributes($title_key);
			// Content
			$content_key = $widget->get_repeater_setting_key( 'ac_content', 'cms_accordion', $key );
			$widget->add_render_attribute( $content_key, [
				'id'    => $_id . $html_id,
				'class' => [ 
					'cms-accordion-content',
					'text-15 pt-10',
					'text-'.$widget->get_setting('content_color','body')
				],
			] );
			if ( $is_active ) {
				$widget->add_render_attribute( $content_key, 'style', 'display:block;' );
			}
			else{
				$widget->add_render_attribute( $content_key, 'style', 'display:none;' );
			}
			$widget->add_inline_editing_attributes($content_key);
		?>
		<div class="cms-accordion-item <?php echo esc_attr( $is_active ? 'active' : '' ); ?>">
		    <div <?php etc_print_html( $widget->get_render_attribute_string( $title_wrap_key ) ); ?>>
		    	<span <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php echo esc_html( $ac_title ); ?></span>
		    	<span class="cms-acc-icon rtl-flip"></span>
		    </div>
		    <div <?php etc_print_html( $widget->get_render_attribute_string( $content_key ) ); ?>>
				<?php echo wp_kses_post( nl2br( $ac_content ) ); ?>
			</div>
		</div>
	<?php
		endforeach;
	?>
</div>