<?php
/**
 * Template part for displaying the primary menu of the site
 */
$args = wp_parse_args($args, [
	'before'     => '',
	'after'      => '',
	'menu'       => '',
	'depth'      => 0,
	'menu_class' => ''
]);

$menu_classes = ['cms-primary-menu'];
$menu_classes[] = isset($args['custom_menu_class']) ? $args['custom_menu_class'] : '';
$menu_classes[] = !empty($args['menu_class']) ? $args['menu_class'] : 'cms-primary-menu-dropdown';

printf('%s', $args['before']);
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => '',
			'menu'					 => $args['menu'],		
			'menu_id'        => 'mastmenu',
			'menu_class'     => allianz_nice_class($menu_classes),
			'walker'         => class_exists('Elementor_Theme_Core') ?  new Allianz_Mega_Menu_Walker : ''
		) );
	} else { 
		$menu_classes[] = 'primary-menu-not-set';
		printf(
	        '<ul class="%1$s"><li><a href="%2$s">%3$s</a></li></ul>',
	        allianz_nice_class($menu_classes),
	        esc_url( admin_url( 'nav-menus.php' ) ),
	        esc_html__( 'Create New Menu', 'allianz' )
	    );
	}
printf('%s', $args['after']);