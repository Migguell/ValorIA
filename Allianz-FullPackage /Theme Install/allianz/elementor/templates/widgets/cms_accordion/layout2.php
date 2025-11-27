<?php
$html_id            = etc_get_element_id( $settings );
$active_section     = $widget->get_settings('active_section', 1);
$accordions         = $widget->get_settings('cms_accordion');
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-accordion',
		'cms-accordion-1',
		'cms-accordion-'.$settings['layout'],
		(!empty($settings['heading_text']) || !empty($settings['description_text'])) ? 'pt-55' : ''
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title font-600 empty-none',
		'text-'.$widget->get_setting('heading_color','heading')
	]
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pt-25 empty-none',
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
		'mt-25',
		'empty-none',
		'cms-hover-move-icon-up'
	],
	'href'	=> $url
]);
?>
<div <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></div>
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
	<?php if(!empty($settings['link1_text'])){ ?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'link1_text' ) ); ?>><?php
			// text
			echo esc_html( $settings['link1_text'] ); 
			// icon
			allianz_elementor_button_icon_render();
		?></a>
	<?php } ?>
</div>