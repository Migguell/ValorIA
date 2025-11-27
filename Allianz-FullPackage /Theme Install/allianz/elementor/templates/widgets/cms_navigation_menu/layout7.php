<?php
// Wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$setting['layout'],
		'text-42 text-smobile-20',
		'font-600'
	]
]);
// Menu
$menu = $widget->get_setting('menu','');
$link_class = implode(' ', array_filter([
	'text-'.$widget->get_setting('link_color','link'),
	'text-hover-'.$widget->get_setting('link_color_hover','accent')
]));
if ( ! empty( $menu ) ) : ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'walker'          => '',
				'container'       => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => '',
				'link_class'      => $link_class,
				'depth'           => 1
			)); 
		?>
	</div>
<?php  endif;  ?>