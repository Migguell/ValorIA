<?php
// Wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$widget->get_setting('layout','5'),
		'p-50 p-lr-tablet-extra-40 p-lr-tablet-30 p-lr-smobile-20',
		'cms-ebg-1'
	]
]);
// Title
$widget->add_inline_editing_attributes( 'title', 'none' );
$widget->add_render_attribute( 'title', [
	'class' => [
		'cms-title',
		'text-22 font-700',
		'pb-25 mt-n5 empty-none',
		'text-'.$widget->get_setting('title_color', 'heading'),
		'empty-none'
	]
]);
// Menu
$menu = $widget->get_setting('menu','');
$link_class = implode(' ', array_filter([
	'text-'.$widget->get_setting('link_color','link'),
	'text-hover-'.$widget->get_setting('link_color_hover','link')
]));
if ( ! empty( $menu ) ) : ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
		<div <?php etc_print_html( $widget->get_render_attribute_string( 'title' ) ); ?>><?php 
			echo etc_print_html( $settings['title'] ); 
		?></div>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'walker'          => '',
				'container'		  => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => 'cms-menu',
				'link_class'	  => $link_class,
				'depth'           => 1,
				'link_after'	  => '<span class="cms-menu-icon allianz-icon-up-right-arrow rtl-flip text-10"></span>'
			)); 
		?>
	</div>
<?php  endif;  ?>