<?php
//
$titles = allianz_get_page_titles();
ob_start();
if ( $titles['title'] ) {
	printf( '<h1 class="title">%s</h1>', wp_kses_post( $titles['title'] ) );
}
$titles_html = ob_get_clean();

$breadcrumb_align = 'start';

$classes = [$args['class']];

if ( (cms_is_blog() || is_singular(['post'])) && $args['show_breadcrumb'] == 'on' ) { 
    $classes[] = 'single-post';
}
// Shop
if(allianz_is_woocommerce()){
    $classes[] = 'cms-ptitle-woo';
}
// single product
if(is_singular('product')){
    $classes[] = 'cms-ptitle-product';
}
?>
<?php if ((cms_is_blog() || is_singular(['post'])) && $args['show_breadcrumb'] == 'on') { ?>
    <div id="cms-ptitle" class="<?php echo allianz_nice_class($classes); ?>">
        <div class="<?php echo esc_attr($args['container']); ?> relative z-top">
			<?php allianz_breadcrumb([
                'icon_home' => '',
                'class'     => 'cms-breadcrumb-1 justify-content-'.$breadcrumb_align]
            ); ?>
        </div>
    </div>
<?php } elseif (is_singular(['product']) && $args['show_breadcrumb'] == 'on') { ?>
    <div id="cms-ptitle" class="<?php echo allianz_nice_class($classes); ?>">
        <?php printf('%s', $args['shadow']); ?>
        <div class="<?php echo esc_attr($args['container']); ?> relative z-top">
            <?php allianz_breadcrumb([
                'icon_home' => '',
                'class'     => 'justify-content-'.$breadcrumb_align]
            ); ?>
        </div>
    </div>
<?php } else { ?>
    <div id="cms-ptitle" class="<?php echo allianz_nice_class($classes); ?>" data-stellar-background-ratio="0.5">
        <?php printf('%s', $args['shadow']); ?>
		<div class="<?php echo esc_attr($args['container']); ?> relative z-top">
			<?php if ($args['show_title'] == 'on') printf( '%s', wp_kses_post( $titles_html ) ); ?>
			<?php if ($args['show_breadcrumb'] == 'on') allianz_breadcrumb(['class' => 'justify-content-'.$args['ptitle_align']]); ?>
        </div>
    </div>
<?php } ?>