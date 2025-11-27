<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$search_field_placeholder = allianz_get_opt( 'search_field_placeholder', esc_html__('Search...','allianz') );
?>
<form role="search" method="get" class="search-form d-flex gap" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr( $search_field_placeholder );?>" value="<?php echo get_search_query(); ?>" name="s"  class="search-field" />
	<button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'allianz' ); ?>" class="search-submit"><i class="cmsi-search"></i></button>
	<input type="hidden" name="post_type" value="product" />
</form>