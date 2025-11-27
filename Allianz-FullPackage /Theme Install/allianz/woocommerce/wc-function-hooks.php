<?php
// https://woocommerce.com/document/image-sizes-theme-developers/
// Loop Products thumbnail 
add_filter('woocommerce_get_image_size_thumbnail', function($size){
    $size['width']  = 400;
    $size['height'] = 400;
    $size['crop']   = 1;
    return $size;
});
// Image Sizes - Single
add_filter( 'woocommerce_get_image_size_single', function ( $size ) {
    $size['width']  = 600;
    $size['height'] = 600;
    $size['crop']   = 1;
    return $size;
} );
// Gallery Image Thumb Sizes - Loop
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function ( $size ) {
    $size['width']  = 80;
    $size['height'] = 80;
    $size['crop']   = 1;
    return $size;
} );
add_filter('woocommerce_gallery_thumbnail_size', function($size){
    //$size['width']  = 40;
    //$size['height'] = 51;
    //$size['crop']   = 0;
    $size = [80, 80];
    //
    return $size;
});
/**
 * Loop Products
 * 
 * */
// remove shop title
add_filter('woocommerce_show_page_title', function (){ return false;});
// Wrap Result Count / Catalog Ordering in div
add_action('woocommerce_before_shop_loop', function() {echo '<div class="cms-result-order w-100 d-flex justify-content-between align-items-center">';}, 19);
add_action('woocommerce_before_shop_loop', function() {echo '</div>'; }, 31);

// wrap products content in a div
add_action('woocommerce_before_shop_loop_item', function(){ echo '<div class="cms-products-content relative cms-hover-show">'; }, -999999);
add_action('woocommerce_after_shop_loop_item', function(){ echo '</div>'; }, 999999);
// wrap products image in a div
add_action('woocommerce_before_shop_loop_item_title','allianz_woocommerce_before_shop_loop_item_title_open',-99999);
if(!function_exists('allianz_woocommerce_before_shop_loop_item_title_open')){
    function allianz_woocommerce_before_shop_loop_item_title_open(){
    // Open .cms-products-loop-thumbs
?>
    <div class="cms-products-loop-thumbs relative">
<?php
    }
}
add_action('woocommerce_before_shop_loop_item_title','allianz_woocommerce_before_shop_loop_item_title_close',99999);
if(!function_exists('allianz_woocommerce_before_shop_loop_item_title_close')){
    function allianz_woocommerce_before_shop_loop_item_title_close(){
        do_action('allianz_products_loop_thumb');
    ?>
    </div><?php // close .cms-products-loop-thumbs ?>
<?php 
    }
}

/**
 * add link overlay thumb image
 * */
add_action('allianz_products_loop_thumb', 'allianz_products_loop_thumb_link_overlay', 0);
if(!function_exists('allianz_products_loop_thumb_link_overlay')){
    function allianz_products_loop_thumb_link_overlay(){
    ?>
        <a href="<?php the_permalink() ?>" class="cms-overlay"></a>
    <?php
    }
}
/**
 * Loop Products
 * Product Thumbnail Hover
*/
if(!function_exists('allianz_woocommerce_get_product_thumbnail_second')){
    function allianz_woocommerce_get_product_thumbnail_second(){
        global $product;
        $gallery_ids = $product->get_gallery_image_ids();
        $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
        $product_id = $product->get_id();
        $second_thumb_class = 'cms-overlay cms-transition cms-hover--show';
        if(isset($gallery_ids['0'])){
            $second_thumb = wp_get_attachment_image($gallery_ids['0'], $image_size, false, ['class' => $second_thumb_class]);
        } else {
            $second_thumb = wp_get_attachment_image(get_post_thumbnail_id($product_id), $image_size, false, ['class' => $second_thumb_class]);
        }

        printf('%s',  $second_thumb );
    }
}
/**
 * Loop Products
 * Product Thumbnail
*/
if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
  /**
   * Get the product thumbnail for the loop.
   */
  function woocommerce_template_loop_product_thumbnail() {
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    // Second thumbnail
    echo allianz_woocommerce_get_product_thumbnail_second();
    // Main thumbnail
    echo woocommerce_get_product_thumbnail();
  }
}

// change loop add_to_cart position
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action('allianz_products_loop_thumb', 'woocommerce_template_loop_add_to_cart', 2);
// Change loop add_to_cart Classes
if(!function_exists('allianz_woocommerce_loop_add_to_cart_args')){
  add_filter('woocommerce_loop_add_to_cart_args', 'allianz_woocommerce_loop_add_to_cart_args');
  function allianz_woocommerce_loop_add_to_cart_args($args){
    global $product;
    $availability = $product->get_availability();
    $args['class'] = implode(
      ' ',
      array_filter(
        array(
            //'button',
            'cms-loop-atc',
            'btn btn-lg btn-accent text-white btn-hover-primary text-hover-white',
            'product_type_' . $product->get_type(),
            $availability['class'],
            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
            $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
        )
      )
    );
    return $args;
  }
}
// Change loop add_to_cart HTML
add_filter('woocommerce_loop_add_to_cart_link', 'allianz_woocommerce_loop_add_to_cart_link', 10, 3);
if(!function_exists('allianz_woocommerce_loop_add_to_cart_link')){
    function allianz_woocommerce_loop_add_to_cart_link($button, $product, $args){
        return sprintf(
            '<div class="cms-loop-addtocart cms-hover--show-bt absolute bottom p-lr-40 mb-40 p-lr-smobile-20 w-100 z-top"><a href="%1$s" data-quantity="%2$s" class="%3$s" %4$s>%5$s</a>%6$s</div>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : '' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            esc_html( $product->add_to_cart_text() ),
            // added to cart
            allianz_woocommerce_template_loop_added_to_cart([
                'class' => 'cms-loop-atc btn btn-lg btn-primary text-white btn-hover-accent text-hover-white'
            ])
        );
    }
}

/**
 * Loop Products
 * Custom Added to Cart button
 *
 *
**/

if(!function_exists('allianz_woocommerce_template_loop_added_to_cart')){
  function allianz_woocommerce_template_loop_added_to_cart($args = []){
    $args = wp_parse_args($args, [
      'layout' => 'text',
      'class'  => ''
    ]);
    $classes = [
      'added_to_cart',
      $args['class']
    ];
    ob_start();
    ?>
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="<?php echo allianz_nice_class($classes); ?>" title="<?php esc_attr_e('View Cart','allianz');?>"> 
        <?php 
        // text
        switch ($args['layout']) {
          case 'text':
            esc_html_e('View Cart','allianz');
            break;
        } 
        ?>
      </a>
    <?php
    $html =  ob_get_clean();
    return $html;
  }
}

// Move loop price / rating before title
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_title', 2);
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 3);
// Loop Product title
if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {

    /**
     * Show the product title in the product loop. By default this is an H2.
     */
    function woocommerce_template_loop_product_title() {
        echo '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . ' text-20 pt-25 font-body font-700"><a href="'.get_the_permalink().'">'. get_the_title() . '</a></h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

// Pagination
add_filter('woocommerce_pagination_args', 'allianz_woocommerce_pagination_args');
if(!function_exists('allianz_woocommerce_pagination_args')){
    function allianz_woocommerce_pagination_args($default){
        $html_prev = '<i class="allianz-icon-left-arrow rtl-flip"></i> '.esc_html__('Prev','allianz');
        $html_next = esc_html__('Next','allianz').' <i class="allianz-icon-right-arrow rtl-flip"></i>';
        $default = array_merge($default, [
            'prev_text' => $html_prev,
            'next_text' => $html_next,
            'type'      => 'plain',
        ]);
        return $default;
    }
}

/**
 * Single Product
 * All Custom for Single Product Layout
 * 
**/
/**
 * Single Product
 * Wrap Gallery & Summary in a DIV
 * 
*/
add_action('woocommerce_before_single_product_summary', 'allianz_woocommerce_before_single_product_summary', -9999999999);
function allianz_woocommerce_before_single_product_summary(){
    echo '<div class="cms-wrap-gallery-summary d-flex gutter-40 align-items-center">';
}
add_action('woocommerce_single_product_summary', 'allianz_woocommerce_single_product_summary', 9999999999);
function allianz_woocommerce_single_product_summary(){
    echo '</div>'; // Close .cms-wrap-gallery-summary
}
// Change sale position
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');
add_action('woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 99);

// Single Product Title
if(!function_exists('woocommerce_template_single_title')){
    function woocommerce_template_single_title(){
        the_title( '<h1 class="product_title font-body text-40 text-tablet-32 text-mobile-22 font-700">', '</h1>' );
    }
}
// Price HTML
add_filter('woocommerce_product_price_class', function(){ return 'cms-single-price price';});
// Rating HTMl
add_filter('woocommerce_product_get_rating_html','allianz_woocommerce_product_get_rating_html', 10, 3);
if(!function_exists('allianz_woocommerce_product_get_rating_html')){
    function allianz_woocommerce_product_get_rating_html($html, $rating, $count = 0 ){
        if ( 0 == $rating ) {
            /* translators: %s: rating */
            $label = sprintf( __( 'Rated %s out of 5', 'allianz' ), $rating );
            $html  = '<div class="star-rating no-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
        }
        return $html;
    }
}
// Review count & link 
remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary','woocommerce_template_single_rating', 11);
if ( ! function_exists( 'woocommerce_template_single_rating' ) ) {
    /**
     * Output the product rating.
     */
    function woocommerce_template_single_rating() {
        if ( !post_type_supports( 'product', 'comments' ) || ! wc_review_ratings_enabled() ) {
            return;
        }
        global $product;
        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();

        $review_url =  get_the_permalink($product->get_id()).'#reviews';

        //if ( $rating_count > 0 ) : 
            ?>
            <div class="woocommerce-product-rating">
                <?php echo wc_get_rating_html( $average, $rating_count ); // WPCS: XSS ok. ?>
                <?php if ( comments_open() ) : ?>
                    <?php //phpcs:disable ?>
                    <a href="<?php echo esc_attr($review_url); ?>" class="woocommerce-review-link" rel="nofollow"><?php printf( _n( '%s Review', '%s Reviews', $review_count, 'allianz' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?> / <?php esc_html_e('Add review','allianz'); ?></a>
                    <?php // phpcs:enable ?>
                <?php endif ?>
            </div>
        <?php 
        //endif;
    }
}

// Share
/**
 * <a class="g-social hover-effect d-none" title="<?php echo esc_attr__('Google Plus', 'allianz'); ?>" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="cmsi-google-plus-g"></i></a>
 * <a class="pin-social hover-effect d-none" title="<?php echo esc_attr__('Pinterest', 'allianz'); ?>" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(the_post_thumbnail_url('full')); ?>&media=&description=<?php the_title(); ?>"><i class="cmsi-pinterest"></i></a>
 * <a class="instagram-social hover-effect" title="<?php echo esc_attr__('Instagram', 'allianz'); ?>" target="_blank"
           href="https://www.instagram.com/"><i class="cmsi-instagram"></i></a>

  *<a class="tiktok-social hover-effect" title="<?php echo esc_attr__('Tiktok', 'allianz'); ?>" target="_blank"
           href="https://www.tiktok.com/"><i class="cmsi-tik-tok"></i></a>
 * 
*/
add_action('woocommerce_share', 'allianz_social_share_product');
function allianz_social_share_product(){ 
    $product_share = allianz_get_opts('product_share', 'off', 'product_custom');
    if($product_share === 'off') return;
    ?>
    <div class="cms-product-share">
        <a class="fb-social hover-effect" title="<?php echo esc_attr__('Facebook', 'allianz'); ?>" target="_blank"
           href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="cmsi-facebook-circle-alt"></i></a>
        <a class="tw-social hover-effect" title="<?php echo esc_attr__('Twitter', 'allianz'); ?>" target="_blank"
           href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="cmsi-twitter"></i></a>
        <a title="<?php echo esc_attr__('LinkedIn', 'allianz'); ?>" target="_blank"
               href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" 
               ><i class="cmsi-linkedin-circle"></i></a>
    </div>
    <?php
}

/**
 * Tabs
 * Remove tab heading
 * 
 * */
add_filter('woocommerce_product_description_heading','allianz_product_tab_heading');
add_filter('woocommerce_product_additional_information_heading','allianz_product_tab_heading');
if(!function_exists('allianz_product_tab_heading')){
    function allianz_product_tab_heading(){
        return false;
    }
}
// Product Nav
function allianz_product_nav(){
    global $post;
    $previous = (is_attachment()) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
    $next = get_adjacent_post(false, '', false);

    if (!$next && !$previous) {
        return;
    }
    ?>
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();
    if (!empty($next_post) || !empty($previous_post)) { ?>
        <div class="product-previous-next">
            <?php if (is_a($previous_post, 'WP_Post') && get_the_title($previous_post->ID) != '') { ?>
                <a class="nav-link-prev" href="<?php echo esc_url(get_permalink($previous_post->ID)); ?>"><i
                            class="cmsi-long-arrow-left"></i></a>
            <?php } ?>
            <?php if (is_a($next_post, 'WP_Post') && get_the_title($next_post->ID) != '') { ?>
                <a class="nav-link-next" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"><i
                            class="cmsi-long-arrow-right"></i></a>
            <?php } ?>
        </div>
    <?php }
}
// Product Comment
/**
 * Review callback function 
 * make it callback same as default blog review
*/
if(!function_exists('allianz_woocommerce_product_review_list_args')){
    add_filter('woocommerce_product_review_list_args', 'allianz_woocommerce_product_review_list_args');
    function allianz_woocommerce_product_review_list_args($args){
        $args['style']      = 'div';
        $args['short_ping'] = 'true';
        $args['callback']   = 'allianz_comment_list';
        return $args;
    }
}

remove_action('woocommerce_review_meta','woocommerce_review_display_meta', 10);
remove_action('woocommerce_review_comment_text','woocommerce_review_display_comment_text', 10);
/**
 * Comment form Args
*/
if(!function_exists('allianz_woocommerce_product_review_comment_form_args')){
    add_filter('woocommerce_product_review_comment_form_args', 'allianz_woocommerce_product_review_comment_form_args');
    function allianz_woocommerce_product_review_comment_form_args($comment_form){
        $comment_form = allianz_comment_form_args();
        return $comment_form;
    }
}
/**
 * Upsell, Cross Sell, Related
 * */
// related
add_filter('woocommerce_output_related_products_args', function($args){
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
});
// upsell
add_filter('woocommerce_upsells_columns', function(){ return 4;});
add_filter('woocommerce_upsells_total', function(){ return 4;});
// Cross sell
add_filter('woocommerce_cross_sells_columns' , function(){ return 4;});
add_filter('woocommerce_cross_sells_total' , function(){ return 4;});

/**
 * Quantity Form
 * 
**/
add_action( 'woocommerce_after_quantity_input_field', 'allianz_woocommerce_after_quantity_input_field' );
if(!function_exists('allianz_woocommerce_after_quantity_input_field')){
    function allianz_woocommerce_after_quantity_input_field(){
?>
    <span class="cms-qty-act cms-qty-up"></span>
    <span class="cms-qty-act cms-qty-down"></span>
<?php
    }
}

/**
 * Single Product Type
 * 
 * Grouped Product
 * 
 * **/
add_filter('woocommerce_grouped_product_list_column_label', 'allianz_woocommerce_grouped_product_list_column_label', 10, 2);
if(!function_exists('allianz_woocommerce_grouped_product_list_column_label')){
    function allianz_woocommerce_grouped_product_list_column_label($value, $grouped_product_child){
        ob_start();
    ?>
    <?php if($grouped_product_child->is_visible()) { ?>
        <a href="<?php echo esc_url( apply_filters( 'woocommerce_grouped_product_list_link', $grouped_product_child->get_permalink(), $grouped_product_child->get_id() ) );?>">
    <?php } ?>
        <span class="cms-pgrouped cms-pgrouped-<?php echo esc_attr(esc_attr( $grouped_product_child->get_id() )); ?> text-22 d-flex flex-nowrap gap-20 align-items-center"><?php
            echo sprintf('%s', $grouped_product_child->get_image('woosc-small'));
            echo sprintf('<span class="cms-pgrouped-title lh-1">%s</span>', $grouped_product_child->get_name() );
        ?>
        </span>
    <?php if($grouped_product_child->is_visible()) { ?>
        </a>
    <?php } ?>
    <?php
        $value = ob_get_clean();
        return $value;
    }
}
add_filter('woocommerce_grouped_product_list_column_price', 'allianz_woocommerce_grouped_product_list_column_price', 10, 2);
if(!function_exists('allianz_woocommerce_grouped_product_list_column_price')){
    function allianz_woocommerce_grouped_product_list_column_price($value, $grouped_product_child){
        $value = $grouped_product_child->get_price_html();
        return $value;
    }
}
/**
 * Single Product 
 * Added to Cart Message
 * 
 * */
add_filter('wc_add_to_cart_message_html', 'allianz_wc_add_to_cart_message_html', 10, 3);
if(!function_exists('allianz_wc_add_to_cart_message_html')){
    function allianz_wc_add_to_cart_message_html($message, $products, $show_qty ){
        $titles = array();
        $count  = 0;

        if ( ! is_array( $products ) ) {
            $products = array( $products => 1 );
            $show_qty = false;
        }

        if ( ! $show_qty ) {
            $products = array_fill_keys( array_keys( $products ), 1 );
        }

        foreach ( $products as $product_id => $qty ) {
            /* translators: %s: product name */
            $titles[] = apply_filters( 'woocommerce_add_to_cart_qty_html', ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ), $product_id ) . apply_filters( 'woocommerce_add_to_cart_item_name_in_quotes', sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'allianz' ), strip_tags( get_the_title( $product_id ) ) ), $product_id );
            $count   += $qty;
        }

        $titles = array_filter( $titles );
        /* translators: %s: product name */
        $added_text = sprintf( _n( '%s has been added to your cart.', '%s have been added to your cart.', $count, 'allianz' ), wc_format_list_of_items( $titles ) );

        // Output success messages.
        $wp_button_class = 'btn btn-primary text-white btn-hover-accent text-hover-white order-last cms-hover-move-icon-up';
        // icon
        ob_start();
            allianz_elementor_button_icon_render();
        $btn_icon = ob_get_clean();

        if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
            $message   = sprintf( '%s <a href="%s" tabindex="1" class="%s">%s%s</a>', 
                esc_html( $added_text ),
                esc_url( $return_to ), 
                esc_attr( $wp_button_class ), 
                esc_html__( 'Continue shopping', 'allianz' ),
                $btn_icon
            );
        } else {
            $message = sprintf( '%s <a href="%s" tabindex="1" class="%s">%s%s</a>', 
                esc_html( $added_text ),
                esc_url( wc_get_cart_url() ), 
                esc_attr( $wp_button_class ),
                esc_html__( 'View cart', 'allianz' ), 
                $btn_icon
            );
        }
        return $message;
    }
}

/**
 * Checkout Page
 * **/
add_action('woocommerce_checkout_before_order_review_heading', function(){echo '<div class="cms-orderreview-wrap"><div class="cms-orderreview cms-sticky">';}, -9999);
add_action('woocommerce_checkout_after_order_review', function(){echo '</div></div>';}, 9999);

/**
 * Checkout Page
 * custom Place Order button
 * 
 * */
add_filter('woocommerce_order_button_html', 'allianz_woocommerce_order_button_html');
if(!function_exists('allianz_woocommerce_order_button_html')){
    function allianz_woocommerce_order_button_html($button){
        // The text of the button
        $order_button_text = apply_filters( 'woocommerce_order_button_text', esc_html__( 'Place order', 'allianz' ) );
        // button
        $button = '<button type="submit" class="btn btn-primary text-white btn-hover-accent text-hover-white cms-hover-underline-bg' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) . '" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '"><span>' . esc_html( $order_button_text ) . '</span></button>';

        return $button;
    }
}

/**
 * Mini Cart
 * Change product thumbnail size
 * 
 * **/
function allianz_mini_cart_item_thumbnail( $thumb, $cart_item, $cart_item_key ) {
    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
    return $_product->get_image( apply_filters('allianz_widget_product_thumbnail_size', 'woocommerce_gallery_thumbnail') );
}
add_filter( 'woocommerce_cart_item_thumbnail', 'allianz_mini_cart_item_thumbnail', 10, 3 );
add_filter('allianz_widget_product_thumbnail_size', function(){ return 'woocommerce_gallery_thumbnail';});
/**
 * Mini Cart
 * 
 * */
if ( ! function_exists( 'woocommerce_widget_shopping_cart_button_view_cart' ) ) {

    /**
     * Output the view cart button.
     */
    function woocommerce_widget_shopping_cart_button_view_cart() {
        $wp_button_class = wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '';
        ob_start();
            allianz_elementor_button_icon_render();
        $icon = ob_get_clean();
        echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn btn-accent text-white btn-hover-accent text-hover-white btn-viewcart w-100 cms-hover-underline-bg cms-hover-move-icon-up"><span>' . esc_html__( 'View Cart & Checkout', 'allianz' ) .$icon.'</span></a>';
    }
}

if ( ! function_exists( 'woocommerce_widget_shopping_cart_proceed_to_checkout' ) ) {

    /**
     * Output the proceed to checkout button.
     */
    function woocommerce_widget_shopping_cart_proceed_to_checkout() {
        $wp_button_class = wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '';
        //echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-outline-accent text-accent btn-outline-hover-primary text-hover-primary btn-checkout w-100 cms-hover-underline-bg"><span>' . esc_html__( 'Checkout', 'allianz' ) . '</span></a>';
    }
}

if ( ! function_exists( 'woocommerce_widget_shopping_cart_subtotal' ) ) {
    /**
     * Output to view cart subtotal.
     *
     * @since 3.7.0
     */
    function woocommerce_widget_shopping_cart_subtotal() {
    ?>
        <div class="cms-mini-cart-subtotal d-flex justify-content-between text-20 font-600 text-primary">
            <div class="title"><?php echo esc_html__( 'Subtotal:', 'allianz' ) ?></div>
            <div class="total"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
        </div>
    <?php
    }
}