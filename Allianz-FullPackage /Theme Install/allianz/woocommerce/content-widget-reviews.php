<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-reviews.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

?>
<li>
	<?php do_action( 'woocommerce_widget_product_review_item_start', $args ); ?>
	<?php
	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	?>
	<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="d-flex gap-20 align-items-center">
		<div class="flex-auto"><?php printf('%s', $product->get_image(apply_filters('allianz_widget_product_thumbnail_size', 'woocommerce_gallery_thumbnail'))); ?></div>
		<div class="content flex-basic">
			<div class="product-title text-16 font-700 lh-1222"><?php echo wp_kses_post( $product->get_name() ); ?></div>
			<?php echo wc_get_rating_html( intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ) ); ?>
			<div class="reviewer text-12">
			<?php
				/* translators: %s: Comment author. */
				echo sprintf( esc_html__( 'by %s', 'allianz' ), get_comment_author( $comment->comment_ID ) );
			?>
			</div>
			<?php
			// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</div>
	</a>
	<?php do_action( 'woocommerce_widget_product_review_item_end', $args ); ?>
</li>
