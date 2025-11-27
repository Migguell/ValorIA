<?php 
// Feature
$features = $widget->get_setting('cms_feature', []);
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-epricing',
		'cms-epricing-'.$settings['layout'],
		'p-50 p-lr-tablet-30 p-lr-smobile-20 relative z-top',
		'cms-hover-show-readmore',
		'cms-transition',
		'bg-hover-grey',
		'overflow-hidden', 
		$settings['actived'] == 'yes' ? 'active' : ''
	]
]);
// Link 1
$link1_page = $widget->get_setting('link1_page','');
switch ($settings['link1_type']) {
	case 'page':
		$page1 = !empty($link1_page) ? get_page_by_path($link1_page, OBJECT) : [];
		$url  = !empty($page1) ? get_permalink($page1->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('link1_custom', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'link1_text', [
	'class' => [
		'cms-readmore',
		'cms-readmore-icon',
		'absolute top-right',
		'text-white',
		'btn-'.$widget->get_setting('link1_color','primary'),
		'text-hover-white',
		'btn-hover-'.$widget->get_setting('link1_hover','primary'),
		'cms-hover-move-icon-up'
	],
	'href'	=> $url,
	'title' => $settings['link1_text']
]);
// Link 2
$link2_page = $widget->get_setting('link2_page','');
switch ($settings['link2_type']) {
	case 'page':
		$page2 = !empty($link2_page) ? get_page_by_path($link2_page, OBJECT) : [];
		$url  = !empty($page2) ? get_permalink($page2->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('link2_custom', ['url' => '#'])['url'];
		break;
}
$widget->add_render_attribute( 'link2-attrs', [
	'class' => [
		'btn btn-lg',
		'text-primary',
		'btn-outline-'.$widget->get_setting('link2_color','primary'),
		'text-hover-primary',
		'btn-outline-hover-'.$widget->get_setting('link2_hover','primary'),
		'w-100',
		'justify-content-between',
		'cms-hover-move-icon-up'
	],
	'href'	=> $url
]);

?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php 
		// Icon
		allianz_elementor_icon_render($settings['cms_icon'],[],['class' => 'cms-pricing-icon', 'icon_color' => 'accent', 'icon_size' => 68] );
	?>
	<div class="cms-smallheading text-16 font-600 pb-30 mt-n7 pl-smobile-20 empty-none"><?php etc_print_html($settings['subheading_text']) ?></div>
	<div class="cms-title text-heading text-22 font-600 mt-n7 pl-smobile-20 empty-none"><?php etc_print_html($settings['heading_text']) ?></div>
	<div class="cms-desc text-15 pt-15 empty-none font-600 text-heading"><?php etc_print_html($settings['description_text_bold']) ?></div>
	<div class="cms-desc text-15 pt-15 empty-none"><?php etc_print_html($settings['description_text']) ?></div>
	<div class="cms-pricing-features pt-40 empty-none text-14 text-<?php echo esc_attr($widget->get_setting('feature_text_color', 'primary')) ?>">
		<?php 
			foreach ( $features as $key => $cms_feature ):
				$title_key = $widget->get_repeater_setting_key( 'title', 'cms_list', $key );
				$widget->add_render_attribute($title_key, [
					'class' => [
						'flex-basic',
						'feature-title'
					]
				]);
				$widget->add_inline_editing_attributes( $title_key, 'none' );
			?>
		        <div class="cms-list d-flex gap-15">
		            <?php 
		            	\Elementor\Icons_Manager::render_icon( $cms_feature['icon'], [ 'aria-hidden' => 'true', 'class' => 'cms-icon flex-auto pt-5 text-10 text-'.$widget->get_setting('feature_icon_color', 'accent') ] ); 
		            ?>
		            <span <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php echo esc_html( $cms_feature['title'] ) ?></span>
		        </div>
			<?php endforeach;
		?>
	</div>
	<div class="cms-pricing-buttons d-flex gap-30 mt-40 empty-none"><?php 
		if(!empty($settings['link2_text'])){ 
			?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'link2-attrs' ) ); ?>>
			<?php // text
				echo esc_html( $settings['link2_text'] );
				// icon
				allianz_elementor_button_icon_render(); ?>
		</a>
		<?php }
	 ?></div>
	<?php if(!empty($settings['price'])) { ?>
		<div class="cms-heading font-500 lh-1 pt-40 mb-n5 d-flex align-items-end empty-none">
			<span class="text-25"><?php etc_print_html($settings['price']); ?></span>
			<span class="text-14"><?php etc_print_html($settings['price_pack']); ?></span>
		</div>
	<?php } ?>
	<?php // Ribbon 
	if(!empty($settings['badge_text'])){
	?>
		<div class="cms-ribbon accent absolute top left empty-none"><span class="main"><?php etc_print_html($settings['badge_text']); ?></span></div>
	<?php } 
	// Link 1
	if(!empty($settings['link1_text'])) { ?>
		<a <?php etc_print_html( $widget->get_render_attribute_string( 'link1_text' ) ); ?>>
			<?php 
				// text
				//echo esc_html( $settings['link1_text'] );
				// icon
				allianz_elementor_button_icon_render();
			?>
		</a>
	<?php }
	?>
</div>