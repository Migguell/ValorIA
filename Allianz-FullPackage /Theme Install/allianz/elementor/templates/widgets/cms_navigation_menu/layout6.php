<?php
// Wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$widget->get_setting('layout','6')
	]
]);
//Link
$page_link = $widget->get_setting('page_link','');
switch ($settings['link_type']) {
	case 'page':
		$page = !empty($page_link) ? get_page_by_path($page_link, OBJECT) : [];
		$url  = !empty($page) ? get_permalink($page->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('custom_link', ['url' => '#'])['url'];
		break;
}
if($url != ''){
	$tag = 'a';
} else {
	$tag = 'div';
}
// Title
$widget->add_inline_editing_attributes( 'title', 'none' );
$widget->add_render_attribute( 'title', [
	'class' => [
		'cms-title',
		'text-'.$widget->get_setting('title_color', 'heading'),
		'text-17 font-600'
	],
	'href' => $url
]);

// Menu
$menu = $widget->get_setting('menu','');
$link_class = implode(' ', array_filter([
	'text-'.$widget->get_setting('link_color','link'),
	'text-hover-'.$widget->get_setting('link_color_hover','link')
]));
if ( ! empty( $menu ) ) : ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
		<<?php etc_print_html($tag.' '. $widget->get_render_attribute_string( 'title' ) ); ?>>
			<?php echo etc_print_html( $settings['title'] ); ?>
		</<?php etc_print_html($tag);?>>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'walker'          => '',
				'container'		  => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => 'cms-dropdown-mega',
				'link_class'	  => $link_class,
				'depth'           => 1
			)); 
		?>
	</div>
<?php  endif;  ?>