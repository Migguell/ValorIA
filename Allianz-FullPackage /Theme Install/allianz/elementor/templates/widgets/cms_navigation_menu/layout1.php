<?php
// Wrap
$widget->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$widget->get_setting('layout','1')
	]
]);
// Title
$widget->add_inline_editing_attributes( 'title', 'none' );
$widget->add_render_attribute( 'title', [
	'class' => [
		'cms-title font-body font-600',
		'text-17',
		'text-'.$widget->get_setting('title_color', 'heading'),
		'mb-25'
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
		<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'title' ) ); ?>>
			<?php echo etc_print_html( $settings['title'] ); ?>
        </h2>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'walker'          => '',
				'container'		  => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => 'cms-navigation-menu cms-menu text-14',
				'link_class'	  => $link_class,		
				'depth'           => 1
			)); 
		?>
	</div>
<?php  endif;  ?>