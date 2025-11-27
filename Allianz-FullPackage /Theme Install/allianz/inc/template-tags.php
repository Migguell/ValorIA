<?php
/**
 * Custom template tags for this theme.
 *
 * @package Allianz
 */

/**
 * Page loading.
 **/
function allianz_page_loading(){
    $page_loading = allianz_get_opt('show_page_loading', false);
    if ($page_loading) { ?>
        <section id="cms-loadding" class="cms-loader">
            <div class="loading-spinner">
                <div class="cms-bounce1"></div>
                <div class="cms-bounce2"></div>
                <div class="cms-bounce3"></div>
            </div>
        </section>
    <?php }
}
/**
 * Header Top
 * 
 * **/
if(!function_exists('allianz_header_top')){
    function allianz_header_top($args = []){
        if(is_singular('cms-header-top') || is_singular('cms-footer')  || is_singular('cms-mega-menu') ) return;
        $args = wp_parse_args($args, []);
        $header_top_layout = allianz_get_opts('header_top_layout', '', 'header_top_custom');
        $cms_post = get_post($header_top_layout);
        if(in_array($header_top_layout, ['-1', '0', 'none', ''])) return;
        if (!is_wp_error($cms_post) && $cms_post->ID == $header_top_layout && class_exists('Elementor_Theme_Core') && class_exists('\Elementor\Plugin')){
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $header_top_layout );
            if(empty($content)){
                $content = $cms_post->post_content;
            }
        } else {
            $content = $cms_post->post_content;
        }
    ?>
    <div id="cms-header-top" class="cms-header-top <?php echo esc_attr($cms_post->post_name); ?> empty-none"><?php 
        printf('%s', $content); 
    ?></div>
    <?php
    }
}
/**
 * Header layout.
 **/
function allianz_header_layout(){
    $header_layout = allianz_get_opts('header_layout', '1', 'header_custom');
    if ($header_layout == '0' || is_singular('cms-header-top') || is_singular('cms-footer')  || is_singular('cms-mega-menu')) return;
    get_template_part('template-parts/header/header-layout', $header_layout);
}
/**
 * Header
 * Header Class
 * **/
if(!function_exists('allianz_header_classes')){
    function allianz_header_classes($class = ''){
        $classes = [
            'cms-header',
            'header-layout-'.allianz_get_opts('header_layout','1', 'header_custom'),
            'sticky-'.allianz_get_opts( 'header_sticky', 'off', 'header_custom'),
            'sticky-'.allianz_get_opts( 'header_sticky_mode', 'off', 'header_sticky'),
            'transparent-'.allianz_get_opts( 'header_transparent', 'off', 'header_custom'),
            $class
        ];

        if(allianz_get_opts( 'header_shadow', 'off', 'header_custom') === 'off'){
            $classes[] = 'no-shadow';
        }
        if( (is_singular() || cms_is_shop()) && allianz_get_opts( 'header_transparent', 'off', 'header_custom') === 'on'){
            $classes[] = 'header-transparent';
        }
        if( (is_singular() || cms_is_shop()) && allianz_get_opts( 'header_transparent_divider', 'off', 'header_custom') === 'on'){
            $classes[] = 'header-transparent-divider';
        }

        return implode(' ', array_filter($classes));
    }
}
/**
 * Header Container class 
 * 
 * **/
if(!function_exists('allianz_header_container_classes')){
    function allianz_header_container_classes($class = ''){
        $classes = [
            'cms-header-main',
            allianz_get_opts( 'header_width', 'container', 'header_custom'),
            $class
        ];
        return implode(' ', array_filter($classes));
    }
}
/**
 * Header Search 
 * 
 * */
if(!function_exists('allianz_header_search')){
    function allianz_header_search($args = []){
        $args = wp_parse_args($args, [
            'class'               => 'site-header-item menu-color',
            'echo'                => true,
            'icon'                => 'cmsi-search',
            'text'                => '',
            'modal-mode'          => 'slide',
            'modal-slide'         => 'top',
            'modal-width'         => '100vw',
            'modal-class'         => '',
            'modal-overlay-class' => 'transparent',
            'modal-hidden'        => '#cms-header-wrap',
            'placeholder'         => '',
            'before'              => '',
            'after'               => ''  
        ]);
        $search_on = allianz_get_opts('search_icon', 'off', 'header_custom');
        if($search_on != 'on') return;
        add_action('wp_footer', 'allianz_search_popup');
        $classes = ['site-header-search cms-modal', $args['class']];
        $icon_classes = ['header-icon  search-toggle', $args['icon']];
    ob_start();
    printf('%s', $args['before']);
?>
    <div class="<?php echo implode(' ', array_filter($classes)); ?>" data-modal="#cms-modal-search" data-focus=".cms-search-popup-input" data-modal-mode="<?php echo esc_attr($args['modal-mode']); ?>" data-modal-slide="<?php echo esc_attr($args['modal-slide']); ?>" data-modal-width="<?php echo esc_attr($args['modal-width']); ?>" data-modal-class="<?php echo esc_attr($args['modal-class']); ?>" <?php if(!empty($args['placeholder'])): ?>data-modal-placeholder="<?php echo esc_attr($args['placeholder']); ?>"<?php endif; ?> data-overlay-class="<?php echo esc_attr($args['modal-overlay-class']); ?>" data-modal-hidden="<?php echo esc_attr($args['modal-hidden']); ?>"><i class="<?php echo allianz_nice_class($icon_classes); ?>"></i><?php printf('%s', $args['text']); ?></div>
<?php
    printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
/**
 * Header Search Popup
 */
function allianz_search_popup(){ 
    $placeholder = allianz_get_opt('search_field_placeholder', esc_html__('Type Words Then Enter...', 'allianz'));
    ?>
    <div id="cms-modal-search" class="cms-modal-html cms-modal-search bg-black-03 d-flex justify-content-between align-items-center flex-nowrap text-white">
        <div class="cms-modal-content" style="--cms-modal-content-width: auto;">
            <form role="search" method="get" class="search-popup relative d-flex flex-nowrap" action="<?php echo esc_url(home_url('/')); ?>">
                <button type="submit" class="cms-search-popup-submit"><i class="cmsi-search"></i></button>
                <input type="text" placeholder="<?php echo esc_attr($placeholder); ?>" name="s" class="cms-search-popup-input"/>
            </form>
        </div>
        <i class="cms-modal--close cms-close cmsi-remove text-15"></i>
    </div>
<?php }
/**
 * Header Cart
 * 
 * */
if(!function_exists('allianz_header_cart')){
    function allianz_header_cart($args = []){
        $args = wp_parse_args($args, [
            'class'    => '',
            'echo'     => true,
            'icon'     => 'allianz-icon-cart',
            'text'     => '', 
            'position' => 'dropdown' // dropdown , modal
        ]);
        $cart_on = allianz_get_opts('cart_icon', 'off', 'header_custom');
        if(!class_exists('Woocommerce') || ($cart_on != 'on' && !is_singular('product')) ) return;
        $classes  =['site-header-item site-header-cart menu-color', $args['class']];
        switch ($args['position']) {
            case 'modal':
                $classes[] = 'cms-modal';
                add_action('wp_footer', 'allianz_cart_content');
                break;
            
            default:
                $classes[] = 'cms-touchedside';
                add_action('allianz_cart_dropdown', 'allianz_cart_content_dropdown');
                break;
        }

        $icon_classes = ['header-icon cart-icon', $args['icon']];
    ob_start();
?>
    <div class="<?php  echo implode(' ', array_filter($classes)); ?>" data-modal="#cms-modal-cart" data-modal-mode="slide" data-modal-slide="right" data-modal-class="bg-white">
        <?php if(!empty($args['text'])) printf('%s', $args['text']); ?>
        <div class="relative cms-cart-icon cms-counter-icon">
            <i class="<?php echo allianz_nice_class($icon_classes); ?>"></i>
            <span class="cart-counter cart_total cms-count" data-count="<?php echo WC()->cart->cart_contents_count; ?>"><?php echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'allianz' ), WC()->cart->cart_contents_count ); ?></span>
        </div>
        <?php do_action('allianz_cart_dropdown'); ?>
    </div>
<?php
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
/**
 * Header Cart
 * Update cart count
 * 
 * */
if(!function_exists('allianz_woocommerce_add_to_cart_fragments')){
    add_filter('woocommerce_add_to_cart_fragments', 'allianz_woocommerce_add_to_cart_fragments', 10, 1 );
    function allianz_woocommerce_add_to_cart_fragments( $fragments ) {
        if(!class_exists('WooCommerce')) return;
        ob_start();
        ?><span class="cart-counter cart_total cms-count" data-count="<?php echo WC()->cart->cart_contents_count;?>">
            <?php echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'allianz' ), WC()->cart->cart_contents_count ); ?>
        </span>
        <?php
        $fragments['.cart_total'] = ob_get_clean();
        $fragments['.cms-fix-cart-empty'] = '';
        return $fragments;
    }
}

/**
 * 
 * Cart Content
 * 
 */
function allianz_cart_content(){
    if (!class_exists('Woocommerce')) return;
?>
    <div id="cms-modal-cart" class="cms-modal-html cms-modal-slide cms-modal-cart cms-shadow-1">
        <span class="cms-modal-close cms-close cmsi-remove"></span>
        <h2 class="cms-cart-title text-30 w-100 p-lr-40 p-lr-mobile-20 pt-25"><?php echo esc_html__('Shopping Cart','allianz'); ?></h2>
        <div class="cms-modal-content">
            <div class="widget_shopping_cart cms-mousewheel cms-mini-cart-modal">
                <div class="widget_shopping_cart_content">
                    <?php  woocommerce_mini_cart(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
}

function allianz_cart_content_dropdown(){
    if (!class_exists('Woocommerce')) return;
?>
    <div class="cms-header-cart-dropdown cms--touchedside overflow-hidden">
        <div class="widget_shopping_cart cms-mousewheel">
            <div class="widget_shopping_cart_content"><?php 
                woocommerce_mini_cart(); 
            ?></div>
        </div>
    </div>
<?php
}

/**
 * Header Phone
 * */
if(!function_exists('allianz_header_phone_render')){
    function allianz_header_phone_render($args = []){
        $args = wp_parse_args($args, [
            'name'  => '',
            'class' => 'btn btn-outline btn-sm',
            'icon'  => 'cmsi-phone-alt',
            'data'  => [
                'default'     => 'btn-1',
                'transparent' => 'btn-white-25'
            ],
            'style' => ''
        ]);
        $phone_text = allianz_get_opt('h_phone'.$args['name'].'_text', '');
        $phone_number = allianz_get_opt('h_phone'.$args['name'].'_number', '');
        if(allianz_get_opts('h_phone'.$args['name'].'_on', 'off', 'header_custom') !== 'on' || empty($phone_number) ) return;
        $tel = str_ireplace(' ', '', $phone_number); // remove space for link

        $classes = ['h-btn', $args['class'], $args['style']];
    ?>
        <div class="site-header-item site-header-button site-header-phone d-flex">
            <a class="<?php echo implode(' ', array_filter($classes)); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>' href="tel:<?php echo esc_attr($tel);?>"><?php 
                if(!empty($args['icon'])) echo '<i class="phone-icon '.esc_attr($args['icon']).'"></i>';
                printf('<span class="cms-hidden-laptop lh-1"><span class="phone-text d-block pb-5 empty-none">%s</span>%s</span>', $phone_text, $phone_number);
            ?></a>
        </div>
    <?php
    }
}
if(!function_exists('allianz_header_phone_render2')){
    function allianz_header_phone_render2($args = []){
        $args = wp_parse_args($args, [
            'name'  => '',
            'class' => '',
            'icon'  => 'cmsi-phone-alt',
            'data'  => [
                'default'     => '',
                'transparent' => ''
            ],
            'style' => ''
        ]);
        $phone_text = allianz_get_opt('h_phone'.$args['name'].'_text', '');
        $phone_number = allianz_get_opt('h_phone'.$args['name'].'_number', '');
        if(allianz_get_opts('h_phone'.$args['name'].'_on', 'off', 'header_custom') !== 'on' || empty($phone_number) ) return;
        $tel = str_ireplace(' ', '', $phone_number); // remove space for link

        $classes = ['d-flex gap-20 align-items-center', $args['class'], $args['style']];
    ?>
        <div class="site-header-item site-header-phone site-header-phone-2 d-flex">
            <a class="<?php echo implode(' ', array_filter($classes)); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>' href="tel:<?php echo esc_attr($tel);?>"><?php 
                if(!empty($args['icon'])) echo '<i class="phone-icon '.esc_attr($args['icon']).'"></i>';
                printf('<span class="cms-hidden-laptop lh-1 font-700"><span class="phone-text d-block pb-10 empty-none">%s</span>%s</span>', $phone_text, $phone_number);
            ?></a>
        </div>
    <?php
    }
}
if(!function_exists('allianz_header_phone_render3')){
    function allianz_header_phone_render3($args = []){
        $args = wp_parse_args($args, [
            'name'  => '',
            'class' => '',
            'icon'  => 'cmsi-phone-alt'
        ]);
        $phone_text = allianz_get_opt('h_phone'.$args['name'].'_text', '');
        $phone_number = allianz_get_opt('h_phone'.$args['name'].'_number', '');
        if(allianz_get_opts('h_phone'.$args['name'].'_on', 'off', 'header_custom') !== 'on' || empty($phone_number) ) return;
        $tel = str_ireplace(' ', '', $phone_number); // remove space for link

        $classes = ['d-flex gap-20 align-items-center', $args['class']];
    ?>
        <a class="<?php echo implode(' ', array_filter($classes)); ?>" href="tel:<?php echo esc_attr($tel);?>"><?php 
            if(!empty($args['icon'])) echo '<i class="phone-icon '.esc_attr($args['icon']).'"></i>';
            printf('%s', $phone_number);
        ?></a>
    <?php
    }
}
/**
 * Header Mail
 * */
if(!function_exists('allianz_header_mail_render')){
    function allianz_header_mail_render($args = []){
        $args = wp_parse_args($args, [
            'name'  => '',
            'class' => '',
            'icon'  => 'cmsi-email'
        ]);
        $email = allianz_get_opt('h_mail'.$args['name'].'_text', '');
        if(allianz_get_opts('h_mail'.$args['name'].'_on', 'off', 'header_custom') !== 'on' || empty($email) ) return;
        $classes = ['d-flex gap-20 align-items-center', $args['class']];
    ?>
        <a class="<?php echo implode(' ', array_filter($classes)); ?>" href="mailto:<?php echo esc_attr($email);?>"><?php 
            if(!empty($args['icon'])) echo '<i class="mail-icon '.esc_attr($args['icon']).'"></i>';
            printf('%s', $email);
        ?></a>
    <?php
    }
}
/**
 * Header Button
 * */
if(!function_exists('allianz_header_button_render')){
    function allianz_header_button_render($args = []){
        $args = wp_parse_args($args, [
            'name'       => 'h_btn',
            'wrap_class' => '',
            'class'      => 'btn btn-outline btn-sm',
            'text_class' => '',
            'icon'       => '',
            'icon_mobile' => '',
            'icon_mobile_class' => '',
            'data'       => [
                'default'     => '',
                'transparent' => ''
            ],
            'before' => '',
            'after'  => ''
        ]);
        $h_btn_text        = allianz_get_opt( $args['name'].'_text' );
        if(allianz_get_opts($args['name'].'_on', 'off', 'header_custom') !== 'on' || empty($h_btn_text)) return;

        $h_btn_link_type   = allianz_get_opt( $args['name'].'_link_type', 'page' );
        $h_btn_link        = allianz_get_opt( $args['name'].'_link' );
        $h_btn_link_custom = allianz_get_opt( $args['name'].'_link_custom' );
        $h_btn_target      = allianz_get_opt( $args['name'].'_target', '_self' );
        if ( $h_btn_link_type == 'page' ) {
            $h_btn_url = get_permalink( $h_btn_link );
        } else {
            $h_btn_url = $h_btn_link_custom;
        }

        $attrs = [
            'class'        => $args['class'],
            'data-classes' => $args['data']
        ];
        $wrap_classes = ['site-header-item site-header-button', $args['wrap_class']];

        $desktop_class = allianz_nice_class(['h-btn', $args['class']]);
        if(!empty($args['icon_mobile'])){
            $desktop_class .= ' cms-hidden-mobile-menu';
        }
        $mobile_class = allianz_nice_class(['header-icon', 'menu-color', $args['icon_mobile_class'], 'cms-hidden-desktop-menu', 'lh-1']);

        printf('%s', $args['before']);
    ?>
    <div class="<?php echo allianz_nice_class($wrap_classes); ?>">
        <a class="<?php echo esc_attr($desktop_class); ?>" data-classes=<?php echo wp_json_encode($args['data']); ?> href="<?php echo esc_url( $h_btn_url ); ?>" target="<?php echo esc_attr( $h_btn_target ); ?>">
            <?php printf( '<span class="%1$s">%2$s</span>%3$s',$args['text_class'], $h_btn_text, $args['icon'] ); ?>        
        </a>
        <?php if(!empty($args['icon_mobile'])): ?>
            <a class="<?php echo esc_attr($mobile_class); ?>" href="<?php echo esc_url( $h_btn_url ); ?>" target="<?php echo esc_attr( $h_btn_target ); ?>"><?php printf('%s', $args['icon_mobile']); ?></a>
        <?php endif; ?>
    </div>
    <?php
    printf('%s', $args['after']);
    }
}

/***
 * Header Wishlist
 */
if(!function_exists('allianz_is_wishlist_page')){
    function allianz_is_wishlist_page(){
        if(!class_exists('WPCleverWoosw')) {
            return false;
        } else {
            $woosw_settings = wp_parse_args(get_option('woosw_settings'), [
                'page_id' => ''
            ]); 
            $wpcsw_page   = $woosw_settings['page_id']; // Wishlist page
            $current_page = get_the_ID(); // current page
            if(!empty($wpcsw_page) && $wpcsw_page == $current_page){
                return true;
            } else {
                return false;
            }
        }
    }
}
if(!function_exists('allianz_header_wishlist')){
    function allianz_header_wishlist($args=[]){
        if(!class_exists('WPcleverWoosw')) return;
        $args = wp_parse_args($args,[
            'name'           => '',
            'class'          => '',
            'text'           => '',
            'icon'           => 'allianz-icon-heart',
            'before'         => '',
            'after'          => '',
            'link_class'     => 'menu-color',
            'count_color'    => '',
            'count_bg_color' => ''
        ]);
        if(allianz_get_opts('h_wishlist'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;

        $css_class = ['cms-header-wishlist relative', $args['class']];
        if(!allianz_is_wishlist_page()) {
            $css_class[] = 'woosw-menu';
            $url = WPcleverWoosw::get_url();
        } else {
            $url = '#';
        }
        $link_classes = ['cms-wishlist relative cms-counter-icon', $args['link_class']];
        $count_classes = ['header-count wishlist-count cms-count', $args['count_color'], $args['count_bg_color']];
        $icon_classes = ['wishlist-icon header-icon', $args['icon']];
        printf('%s', $args['before']);
    ?>
        <div class="<?php echo allianz_nice_class($css_class); ?>">
            <a class="<?php echo allianz_nice_class($link_classes); ?>" href="<?php echo esc_url( $url ); ?>">
                <?php printf('%s', $args['text']);?>
                <span class="<?php echo allianz_nice_class($icon_classes);?>" data-count="<?php echo WPcleverWoosw::get_count(); ?>"></span>
                <span class="<?php echo allianz_nice_class($count_classes); ?>"><?php echo WPcleverWoosw::get_count(); ?></span>
            </a>
        </div>
    <?php
        printf('%s', $args['after']);
    }
}
// Header Compare
if(!function_exists('allianz_header_compare')){
    function allianz_header_compare($args=[]){
        if(!class_exists('WPCleverWoosc')) return;
        $args = wp_parse_args($args,[
            'name'           => '',
            'class'          => '',
            'text'           => '',
            'icon'           => 'allianz-icon-explore',
            'before'         => '',
            'after'          => '',
            'count_color'    => '',
            'count_bg_color' => ''
        ]);
        if(allianz_get_opts('h_compare'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;

        $css_class = ['cms-header-compare woosc-menu relative', $args['class']];
        $count_classes = ['header-count compare-count cms-count', $args['count_color'], $args['count_bg_color']];
        $icon_classes = ['compare-icon header-icon', $args['icon']];
        printf('%s', $args['before']);
    ?>
        <div class="<?php echo allianz_nice_class($css_class); ?>">
            <a class="cms-compare menu-color cms-counter-icon" href="<?php echo esc_url( WPcleverWoosc::get_url() ); ?>">
                <?php printf('%s', $args['text']);?>
                <span class="<?php echo allianz_nice_class($icon_classes);?>" data-count="<?php echo WPcleverWoosc::get_count(); ?>"></span>
                <span class="<?php echo allianz_nice_class($count_classes); ?>"><?php echo WPcleverWoosc::get_count(); ?></span>
            </a>
        </div>
    <?php
        printf('%s', $args['after']);
    }
}
// Header Currency Switch
if(!function_exists('allianz_header_woocs')){
    function allianz_header_woocs($args = []){
        if(!class_exists('WOOCS_STARTER')) return;
        $args = wp_parse_args($args, [
            'name'             => '',
            'before'           => '',
            'after'            => '',
            'class'            => '',
            'item_class'       => '',
            'link_class'       => 'menu-color',
            'sub_link_class'   => '',           
            'show_flags'       => 'no',
            'show_money_signs' => 'no',
            'show_text'        => 'yes',
            'text_as'          => 'description', // value: name / description
        ]);
        if(allianz_get_opts('h_woocs'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;

        printf('%s', $args['before']);
            allianz_woocs_currency_switcher([
                'class'            => $args['class'],
                'item_class'       => $args['item_class'],
                'link_class'       => $args['link_class'],
                'sub_link_class'   => $args['sub_link_class'],           
                'show_flags'       => $args['show_flags'],
                'show_money_signs' => $args['show_money_signs'],
                'show_text'        => $args['show_text'],
                'text_as'          => $args['text_as'],
            ]);
        printf('%s', $args['after']);
    }
}
// Header Login 
if(!function_exists('allianz_header_login')){
    function allianz_header_login($args=[]){
        if(!function_exists('cshlg_link_to_login')) return;
        $args = wp_parse_args($args, [
            'name'          => '',
            'class'         => '',
            'icon'          => 'allianz-icon-user1',
            'before'        => '',
            'after'         => '',
            'link_class'    => '',
            'show_text'     => true,
            'login_text'    => esc_html__('Login', 'allianz'),
            'loggedin_text' => esc_html__('Account','allianz')
        ]);
        if(allianz_get_opts('h_login'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;
        $css_class = ['cms-header-login', $args['class']];
        $link_classes = [
            'menu-color cms-transition', 
            $args['link_class']
        ];

        if(is_user_logged_in()) {
            $text = $args['loggedin_text'];
            if(class_exists('WooCommerce')){
                $url = get_permalink( get_option('woocommerce_myaccount_page_id') );
            } else {
                $url = get_edit_user_link();
            }
            $link_classes[] = '';
        } else {
            $text = $args['login_text'];
            $url = '#csh-login-wrap';
            $link_classes[] = 'cms-modal';
            //$link_classes[] = 'go_to_login_link';
        }
        $icon_classes = ['header-icon', $args['icon'], 'cms-hidden-min-mobile-extra'];
        //
        printf('%s', $args['before']);
    ?>
        <div class="<?php echo allianz_nice_class($css_class);?>">
            <a href="<?php echo esc_url($url); ?>" class="<?php echo allianz_nice_class($link_classes);?>" data-modal="<?php echo esc_url($url); ?>" data-modal-mode="fade" data-modal-class="center" data-modal-slide="center">
                <span class="cms-hidden-mobile"><?php printf('%s', $text);?></span>
                <span class="<?php echo allianz_nice_class($icon_classes);?>"></span>
            </a>
        </div>
    <?php
        printf('%s', $args['after']);
    }
}
/**
 * Language Switcher
*/
if(!function_exists('allianz_header_language_switcher')){
    function allianz_header_language_switcher($args = []){
        if(!class_exists('TRP_Translate_Press')) return;
        $args = wp_parse_args($args, [
            'name'           => '',
            'before'         => '',
            'after'          => '',
            // config
            'class'          => '',
            'item_class'     => '',
            'link_class'     => '',
            'sub_link_class' => '',
            'show_flag'      => 'no',
            'show_name'      => 'yes',
            'name_as'        => 'full', // short 
        ]);
        if(allianz_get_opts('h_language'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;

        printf('%s', $args['before']); 
            cms_language_switcher([
                'class'          => $args['class'],
                'item_class'     => $args['item_class'],
                'link_class'     => $args['link_class'],
                'sub_link_class' => $args['sub_link_class'],
                'show_flag'      => $args['show_flag'],
                'show_name'      => $args['show_name'],
                'name_as'        => $args['name_as'] 
            ]);
        printf('%s', $args['after']);
    }
}
/**
 * Header
 * Side Nav
 * */
if(!function_exists('allianz_header_side_nav_render')){
    function allianz_header_side_nav_render($args = []){
        $hide_sidebar_icon = allianz_get_opts( 'hide_sidebar_icon', 'off', 'header_custom' );
        $header_sidenav_layout = allianz_get_opts('header_sidenav_layout', 'none', 'hide_sidebar_icon');
        if ( in_array($header_sidenav_layout, ['-1', '0', 'none', '']) || $hide_sidebar_icon != 'on' || !apply_filters('allianz_enable_sidenav', false) ) return;
        $args = wp_parse_args($args, [
            'title'       => '',
            'class'       => '',
            'mode'        => 'slide',
            'slide'       => 'right',
            'modal_width' => '400px',
            'modal_class' => 'bg-white',
            'close_text'  => ''  
        ]);
        $classes = array_filter(['site-side-navs cms-modal d-flex gap-20', $args['class'], 'cms-hidden-mobile-menu']);
    ?>
        <div class="<?php echo allianz_nice_class($classes); ?>" data-modal="#cms-side-nav" data-modal-mode="<?php echo esc_attr($args['mode']); ?>" data-modal-slide="<?php echo esc_attr($args['slide']); ?>" data-modal-class="<?php echo esc_attr($args['modal_class']); ?>" data-modal-width="<?php echo esc_attr($args['modal_width']); ?>" data-close-text="<?php echo esc_attr($args['close_text']); ?>">
            <?php printf('%s', $args['title']); ?>
            <div class="site-side-nav"><span></span></div>
        </div>
    <?php
    }
}
add_action('wp_footer', 'allianz_header_side_nav_content_render');
if(!function_exists('allianz_header_side_nav_content_render')){
    function allianz_header_side_nav_content_render($args = []){
        $hide_sidebar_icon = allianz_get_opts( 'hide_sidebar_icon', 'off', 'header_custom' );
        if ( $hide_sidebar_icon !='on' || !apply_filters('allianz_enable_sidenav', false) ) return;
        $header_sidenav_layout = allianz_get_opts('header_sidenav_layout', 'none', 'hide_sidebar_icon');
        if(in_array($header_sidenav_layout, ['-1', '0', 'none', ''])) return;
        $cms_post = get_post($header_sidenav_layout);
        if (!is_wp_error($cms_post) && $cms_post->ID == $header_sidenav_layout && class_exists('Elementor_Theme_Core') && class_exists('\Elementor\Plugin')){
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $header_sidenav_layout );
            if(empty($content)){
                $content = $cms_post->post_content;
            }
        } else {
            $content = $cms_post->post_content;
        }
        ?>
            <div id="cms-side-nav" class="cms-modal-html cms-modal-sidenav">
                <span class="cms-modal-close cms-close"><span class="cmsi-remove"></span></span>
                <div class="cms-modal-content">
                    <div class="cms-sidenav-content cms-mousewheel">
                        <div class="cms-sidenav--content">
                            <?php printf('%s', $content);  ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}
/**
 * Header Open Mobile Menu
 * 
 * */
if(!function_exists('allianz_open_mobile_menu')){
    function allianz_open_mobile_menu($args = []){
        $args = wp_parse_args($args, [
            'class'        => '',
            'hide_desktop' => true
        ]);
        $classes = [
            'main-menu-mobile',
            $args['class']
        ];
        if($args['hide_desktop']) $classes[] = 'cms-hidden-desktop-menu';
    ?>
        <div id="main-menu-mobile" class="<?php echo allianz_nice_class($classes); ?>">
            <span class="btn-nav-mobile open-menu">
                <span></span>
            </span>
        </div>
    <?php
    }
}
/**
 * Header Tools Classes
 * 
 * */
if(!function_exists('allianz_header_tools_classes')){
    function allianz_header_tools_classes($args = []){
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
        $h_btn_text   = allianz_get_opt( 'h_btn_text' );
        $h_btn2_text  = allianz_get_opt( 'h_btn2_text' );
        $phone_number = allianz_get_opt( 'h_phone_number' );
        $h_btn_on     = $h_btn2_on = $h_phone_on = 'off';
        if(allianz_get_opts('h_btn_on', 'off', 'header_custom') == 'on' && !empty($h_btn_text)){
            $h_btn_on = 'on';
        }
        if(allianz_get_opts('h_btn2_on', 'off', 'header_custom') == 'on' && !empty($h_btn2_text)){
            $h_btn2_on = 'on';
        };
        if(allianz_get_opts('h_phone_on', 'off', 'header_custom') == 'on' && !empty($phone_number) ){
            $h_phone_on = 'on';
        };
        $search_on         = allianz_get_opts('search_icon', 'off', 'header_custom');
        $cart_on           = allianz_get_opts('cart_icon', 'off', 'header_custom');
        $hide_sidebar_icon = allianz_get_opts( 'hide_sidebar_icon', 'off', 'header_custom' );
        $header_sidenav_layout = allianz_get_opts('header_sidenav_layout', 'none', 'hide_sidebar_icon');
        $show_mobile_nav = ($hide_sidebar_icon == 'off' || ($hide_sidebar_icon == 'on' && !in_array($header_sidenav_layout, ['-1', '0', 'none', ''])) || !apply_filters('allianz_enable_sidenav', false) );

        if($search_on == 'on' || $cart_on == 'on' || $hide_sidebar_icon == 'on' || $h_btn_on == 'on' || $h_btn2_on == 'on' || $h_phone_on == 'on' || $show_mobile_nav){
            $classes[] = 'has-tools';
        } else {
            $classes[] = 'cms-hidden-min-desktop';
        }
        $classes[] = $args['class'];

        return allianz_nice_class($classes);
    }
}
/**
 * Header
 * Mega Menu
 * */
add_filter('cms_megamenu_render', 'allianz_cms_megamenu_render');
if(!function_exists('allianz_cms_megamenu_render')){
    function allianz_cms_megamenu_render($content, $before, $after){
        $before = $after = '';
        return $before.$content.$after;
    }
}
/**
 * Page title layout
 **/
function allianz_page_title_layout($args = []){
    // remove page title on some custom post type
    if( (is_singular() && in_array(get_post_type(), ['cms-service', 'cms-industry', 'cms-case', 'cms-career', 'cms-popup', 'cms-sidenav'])) ) return;
    $header_transparent = $shadow_overlay = '';
    $container = 'container-fluid';
    if((is_singular() || cms_is_shop()) && allianz_get_opts('header_transparent', 'off', 'header_custom') == 'on'){
        $header_transparent = 'ptitle-header-transparent';
    }
    if(allianz_is_woocommerce()){
        $container = 'container';
        $shadow_overlay = '<div class="cms-ptitle-overlay-shadow cms-overlay rtl-flip"></div>';
    }
    $args = wp_parse_args($args, [
        'show'            => allianz_get_opts('pagetitle', 'on', 'custom_ptitle'),
        'layout'          => allianz_get_opts('ptitle_layout', '', 'custom_ptitle'),
        'show_title'      => allianz_get_opts('show_title', 'on', 'custom_ptitle'),
        'show_breadcrumb' => allianz_get_opts('show_breadcrumb', 'on', 'custom_ptitle'),
        'ptitle_align'    => allianz_get_opts('ptitle_align', 'center', 'custom_ptitle'),
        'container'       => $container, //allianz_get_opts('content_width', 'container-wide', 'on'),
        'class'           => '',
        'shadow'          => $shadow_overlay  
    ]);
    // Configs
    $ptitle_bg = allianz_get_opts('page_title_bg', ['background-color' => '#999', 'background-image' => ''], 'custom_ptitle');
    $args['class'] = implode(' ', array_filter([
        'cms-ptitle',
        'text-'.$args['ptitle_align'],
        !empty($ptitle_bg['background-image']) ? 'bg-img-custom' : '',
        $header_transparent,
        $args['class']
    ]));
    if($args['show'] === 'off' || is_404() || is_singular('cms-header-top') || is_singular('cms-footer')  || is_singular('cms-mega-menu')) return;
    get_template_part('template-parts/page-title', $args['layout'], $args);
}
/**
 * Get page title and description.
 *
 * @return array Contains 'title'
 */
function allianz_get_page_titles(){
    $title = '';

    // Default titles
    if (!is_archive()) {
        // Posts page view
        if (is_home()) {
            // Only available if posts page is set.
            if (
                !is_front_page() &&
                ($page_for_posts = get_option('page_for_posts'))
            ) {
                $title = get_post_meta($page_for_posts, 'custom_title', true);
                if (empty($title)) {
                    $title = get_the_title($page_for_posts);
                }
            }
            if (is_front_page()) {
                $title = esc_html__('Blog', 'allianz');
            }
        }
        // Single page view
        elseif (is_page()) {
            $title = get_post_meta(get_the_ID(), 'custom_title', true);
            if (!$title) {
                $title = get_the_title();
            }
        } elseif (is_404()) {
            $title = esc_html__('404', 'allianz');
        } elseif (is_search()) {
            $title = esc_html__('Search results', 'allianz');
        } else {
            $title = get_post_meta(get_the_ID(), 'custom_title', true);
            if (!$title) {
                $title = get_the_title();
            }
        }
    } elseif (is_author()) {
        $title = esc_html__('Author:', 'allianz') . ' ' . get_the_author();
    }
    // Author
    else {
        $title = get_the_archive_title();
        if (class_exists('WooCommerce') && is_shop()) {
            $title = esc_html__('Our Shop', 'allianz');
        }
    }

    return [
        'title' => $title,
    ];
}
/**
 * Prints HTML for breadcrumbs.
 */
function allianz_breadcrumb($args= []){
    if (!class_exists('CMS_Breadcrumb')) {
        return;
    }

    $breadcrumb = new CMS_Breadcrumb();
    $entries = $breadcrumb->get_entries();
    $args = wp_parse_args($args, [
        'show'      => 'yes',
        'icon_home' => '',
        'class'     => '',
        'link_class'=> '',
        'before'    => '',
        'after'     => ''
    ]);

    if (empty($entries) || $args['show'] !== 'yes') {
        return;
    }
    $link_class = allianz_nice_class(['breadcrumb-entry', $args['link_class']]);
    ob_start();

    foreach ($entries as $key => $entry) {
        $entry = wp_parse_args($entry, array(
            'label' => '',
            'url' => ''
        ));

        if (empty($entry['label'])) {
            continue;
        }

        echo '<li>';
        if (!empty($entry['url'])) {
            printf(
                '<a class="%1$s" href="%2$s">%3$s%4$s</a>',
                $link_class,
                esc_url($entry['url']),
                $key === 0 ?  $args['icon_home'] : '',
                esc_attr($entry['label'])
            );
        } else {
            printf('<span class="breadcrumb-entry" >%s</span>', esc_html($entry['label']));
        }

        echo '</li>';
    }

    $output = ob_get_clean();

    if ($output) {
        printf('%s', $args['before']);
            printf('<ul class="%1$s">%2$s</ul>',implode(' ', array_filter(['cms-breadcrumb unstyled', $args['class']])), $output);
        printf('%s', $args['after']);
    }
}
/**
 * Main Content 
 * 
 * **/
if(!function_exists('allianz_show_sidebar')){
    function allianz_show_sidebar($sidebar=''){
        $sidebar_on = allianz_get_opt('sidebar_on','off');
        if(empty($sidebar)){
            if(allianz_is_woocommerce()){
                $sidebar_name = 'sidebar-product';
            } else {
                $sidebar_name = 'sidebar-post';
            }
        } else {
            $sidebar_name = $sidebar;
        }
        /*$show_sidebar = ($sidebar_on === 'on' && is_active_sidebar($sidebar_name) && !in_array(get_post_type(), [
            'page',
            'portfolio',
            'cms-footer',
            'cms-header-top',
            'cms-service',
            'cms-industry', 
            'cms-case',
            'cms-porfolio',
            'cms-career'
        ]));*/
        $show_sidebar = ($sidebar_on === 'on' && is_active_sidebar($sidebar_name));
        return $show_sidebar;
    }
}
if(!function_exists('allianz_main_content_classes')){
    function allianz_main_content_classes($args = []){
        $args = wp_parse_args($args, [
            'class' => '',
            'sidebar' => ''
        ]);
        $classes = [
            'cms-main',
            $args['class']
        ];
        if(allianz_is_built_with_elementor()){
            $classes[] = 'is-elementor';
        } else {
            $classes[] = allianz_get_opts('content_width', 'container', 'on');
            if(allianz_is_woocommerce()){
                if(allianz_show_sidebar($args['sidebar']) && !is_singular('product') ){
                    $classes[] = 'cms-main-sidebar cms-woo-sidebar d-flex justify-content-center';
                } else {
                    $classes[] = 'cms-woo-content';
                }
            } elseif(allianz_show_sidebar($args['sidebar'])){
                $classes[] = 'cms-main-sidebar d-flex justify-content-center';
            } else {
                $classes[] = 'no-sidebar';
            }
        }
        $classes = apply_filters('allianz_main_content_classes', $classes);
        
        echo implode(' ', array_filter($classes));
    }
}
function allianz_content_has_sidebar_open($sidebar=''){
    if(!allianz_show_sidebar($sidebar)) return;
    ?>
    <div class="cms-main-content">
    <?php
}
function allianz_content_has_sidebar_close($sidebar=''){
    if(!allianz_show_sidebar($sidebar)) return;
    ?>
    </div>
    <?php
}

/**
 * Footer layout
 **/
function allianz_footer(){
    if(is_singular('cms-header-top') || is_singular('cms-footer')  || is_singular('cms-mega-menu') || is_singular('cms-sidenav')) return;
    //get_template_part('template-parts/footer-layout','');
    $footer_layout = allianz_get_opts('footer_layout', '1', 'footer_custom');

    switch ($footer_layout){
        case 'none':
            break;
        case '1':
            allianz_footer_copyright();
            break;
        default : 
            allianz_footer_elementor_builder();
            break;
    }
}
/*
 * Footer css class
*/
if(!function_exists('allianz_footer_css_class')){
    function allianz_footer_css_class($args = []){
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
        $footer_layout = allianz_get_opts( 'footer_layout', '1' );
        $footer_fixed = allianz_get_opts('footer_fixed', '0');
        $css_classes = [
            'cms-footer',
            'relative'
        ];
        if(!in_array($footer_layout, ['-1', '0', '1', 'none'])) {
            $css_classes[] = 'cms-footer-elementor';
        } else {
            $css_classes[] = allianz_get_opts('content_width', 'container', 'on');
        }

        if($footer_fixed == '1') $css_classes[] = 'cms-footer-fixed';
        echo implode(' ', array_filter($css_classes));
    }
}
if(!function_exists('allianz_default_copyright_text')){
    function allianz_default_copyright_text($text = '', $args = []){
        $args = wp_parse_args($args, [
            'link_color'       => '',
            'link_hover_color' => ''
        ]);
        if(!empty($text)){
            $default_copyright_text = $text;
        } else {
            $default_copyright_text = sprintf( esc_html__('&copy;%s %s, All Rights Reserved. With Love by %s ','allianz'), date('Y') , get_bloginfo('name'), '<a href="'.esc_url('https://7oroofthemes.com/').'" target="_blank" rel="nofollow" class="'.$args['link_color'].' '.$args['link_hover_color'].'">'.esc_html__('7oroof.com','allianz').'</a>');
        }
        return $default_copyright_text;
    }
}
if(!function_exists('allianz_footer_copyright')){
    function allianz_footer_copyright($args = []){
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
        $classes = ['cms-copyright-text cms-footer-copyright', $args['class']];

        if(is_404()) $classes[] = 'text-center';
    ?>
    <div class="<?php echo implode(' ', array_filter($classes));?>">
        <?php echo allianz_default_copyright_text(); ?>
    </div>
    <?php
    }
}
/**
* Footer elementor builder
*
*/
if(!function_exists('allianz_footer_elementor_builder')){
    function allianz_footer_elementor_builder(){
        if(!class_exists('Elementor\Plugin') || !class_exists('Elementor_Theme_Core')) return;
        $footer_layout = allianz_get_opts('footer_layout', '1', 'footer_custom');
        if(in_array($footer_layout, ['-1', '0', '1', 'none'])) return;
        $cms_post = get_post($footer_layout);
        if (!is_wp_error($cms_post) && $cms_post->ID == $footer_layout){
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $footer_layout );
            if(!empty($content)){
                etc_print_html($content);
            } else {
            ?>
            <div class="<?php etc_print_html(allianz_get_opts('content_width', 'container', 'on'));  ?> cms-copyright-text cms-footer-copyright">
                <?php etc_print_html($cms_post->post_content); ?>
            </div>
            <?php 
            }
        }
    }
}


/**
 * Popup Content
 * 
 * **/
add_action('wp_footer', 'allianz_popup_content_render');
if(!function_exists('allianz_popup_content_render')){
    function allianz_popup_content_render($args = []){

        $args = wp_parse_args($args, [
            'hide_popup' => allianz_get_opts('hide_popup', 'off', 'popup_custom'),
            'animate'    => allianz_get_opts('popup_animate', 'cms-fadeInUp', 'popup_custom'),
            'position'   => allianz_get_opts('popup_position', 'align-items-end', 'popup_custom')
        ]);
        if(!class_exists('Elementor\Plugin') || !class_exists('Elementor_Theme_Core')) return;
        $popup_layout = allianz_get_opts('popup_layout', '1', 'popup_custom');
        if(in_array($popup_layout, ['-1', '0', '1', 'none'])) return;
        $cms_post = get_post($popup_layout);

        $popup_classes = [
            'cms-sp cms-sp-holder cms-sp-prevent-session cms-overlay fixed d-flex',
            'p-40 p-lr-smobile-20',
            $args['position']
        ];
        $popup_inner_classes = [
            'cms-sp-inner p-60 p-tablet-40 p-mobile-30 p-lr-smobile-10 bg-white relative',
            $args['animate'],
            'cms-transition'
        ];
    ?>
        <div id="cms-subscribe-popup" class="<?php echo allianz_nice_class($popup_classes); ?>">
            <div class="<?php echo allianz_nice_class($popup_inner_classes); ?>">
                <a href="javascript:void(0)" class="cms-sp-close absolute top-right p-35 p-mobile-30 p-smobile-20 text-hover-red"><svg x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
                    <line fill="none" stroke="currentColor" stroke-miterlimit="10" x1="15.384" y1="4.994" x2="4.918" y2="15.459"></line>
                    <line fill="none" stroke="currentColor" stroke-miterlimit="10" x1="4.918" y1="4.994" x2="15.384" y2="15.459"></line>
                </svg></a>
                <div class="cms-sp-content-container">
                    <div class="cms-sp-content-inner"><?php 
                        if (!is_wp_error($cms_post) && $cms_post->ID == $popup_layout){
                            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $popup_layout );
                            if(!empty($content)){
                                etc_print_html($content);
                            } else {
                                etc_print_html($cms_post->post_content);
                            }
                        }
                    ?></div>
                    <?php if($args['hide_popup'] === 'on'){ ?>
                        <div class="cms-sp-prevent pt-15">
                            <div class="cms-sp-prevent-inner d-flex gap-10 align-items-center font-400 text-15">
                                <input class="cms-sp-prevent-input" type="checkbox" name="cms-sp-prevent-input" id="cms-sp-prevent-input">
                                <label for="cms-sp-prevent-input font-400" class="cms-sp-prevent-label">Disable This Pop-up</label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php
    }
}


/**
 * Post Term
 * 
 *  */
if(!function_exists('allianz_get_the_term_list')){
    function allianz_get_the_term_list( $post_id, $taxonomy, $sep = '', $class = '', $args = [] ) {
        $args = wp_parse_args($args, [
            'before_term' => '',
            'after_term'  => ''
        ]);
        $terms = get_the_terms( $post_id, $taxonomy );
        
        if ( is_wp_error( $terms ) ) {
            return $terms;
        }
     
        if ( empty( $terms ) ) {
            return false;
        }
     
        $links = array();
     
        foreach ( $terms as $term ) {
            $link = get_term_link( $term, $taxonomy );
            if ( is_wp_error( $link ) ) {
                return $link;
            }
            $links[] = $args['before_term'].'<a href="' . esc_url( $link ) . '" class="'.allianz_nice_class(['cms-term', $class]).'">' . $term->name . '</a>'.$args['after_term'];
        }
     
        /**
         * Filters the term links for a given taxonomy.
         *
         * The dynamic portion of the hook name, `$taxonomy`, refers
         * to the taxonomy slug.
         *
         * Possible hook names include:
         *
         *  - `term_links-category`
         *  - `term_links-post_tag`
         *  - `term_links-post_format`
         *
         * @since 2.5.0
         *
         * @param string[] $links An array of term links.
         */
        $term_links = apply_filters( "cms_term_links-{$taxonomy}", $links );  // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
     
        return implode( $sep, $term_links );
    }
}
if(!function_exists('allianz_the_terms')){
    function allianz_the_terms( $post_id, $taxonomy, $sep = ', ', $class = '', $args = []) {
        $args = wp_parse_args($args, [
            'before'      => '',
            'after'       => '',
            'before_term' => '',
            'after_term'  => ''  
        ]);
        $term_list = allianz_get_the_term_list( $post_id, $taxonomy, $sep, $class, $args);
        if ( is_wp_error( $term_list ) ) {
            return false;
        }
     
        /**
         * Filters the list of terms to display.
         *
         * @since 2.9.0
         *
         * @param string $term_list List of terms to display.
         * @param string $taxonomy  The taxonomy name.
         * @param string $sep       String to use between the terms.
         * @param string $class     CSS class to use in the terms.
         */
        printf ('%s', $args['before']);
            echo apply_filters( 'allianz_the_terms', $term_list, $taxonomy, $sep, $class );
        printf ('%s', $args['after']);
    }
}

/**
 * Post Title
 * 
 * */
if(!function_exists('allianz_entry_title')){
    function allianz_entry_title($args= []){
        $args=wp_parse_args($args, [
            'class' => ''
        ]);
        $classes = array_filter(['cms-post-title', $args['class']]);
    ?>
        <h2 class="<?php echo implode(' ', $classes); ?>">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php if ( is_sticky() ) { ?>
                    <i class="cmsi-thumbtack"></i>
                <?php } ?>
                <?php the_title(); ?>
            </a>
        </h2>
    <?php
    }
}
if(!function_exists('allianz_entry_single_title')){
    function allianz_entry_single_title($args = []){
        $args  = wp_parse_args($args, [
            'class' => ''
        ]);
        $classes = ['cms-post-title cms-post-single-title', $args['class'], 'empty-none'];
    ?>
        <h2 class="<?php echo allianz_nice_class($classes); ?>"><?php 
            the_title(); 
        ?></h2>
    <?php
    }
}

/**
 * Post Thumbnail
 * 
 * */
if(!function_exists('allianz_entry_thumbnail')){
    function allianz_entry_thumbnail($args = []){
        if ( !has_post_thumbnail() ) return;
        $args = wp_parse_args($args, [
            'class'     => '',
            'size'      => 'medium',
            'img_class' => '',
            'content'   => ''
        ]);
        $classes      = allianz_nice_class(['cms-post-thumbnail', 'relative', $args['class']]);
        $opt_prefix   = is_singular('post')?'post_':'archive_';
    ?>
        <div class="<?php echo esc_attr($classes); ?>"><?php
            allianz_the_post_thumbnail([
                'size'    => $args['size'],
                'class'   => $args['img_class']
            ]);
            printf('%s', $args['content']);
        ?></div>
    <?php
    }
}
if(!function_exists('allianz_the_post_thumbnail')){
    function allianz_the_post_thumbnail($args = []){
        $args = wp_parse_args($args, [
            'size'    => 'medium',
            'class'   => ''
        ]);
        echo wp_get_attachment_image(get_post_thumbnail_id(), $args['size'], false, ['class' => $args['class'], 'loading' => 'lazy']);
    }
}
/**
 * Get excerpt
 * The excerpt with custom length.
 * @return string      
 */
function allianz_get_the_excerpt($length = 55, $post = null){
    $post = get_post($post);

    if (empty($post) || 0 >= $length) {
        return '';
    }

    if (post_password_required($post)) {
        return esc_html__('Post password required.', 'allianz');
    }

    $content = apply_filters(
        'the_content',
        strip_shortcodes($post->post_content)
    );
    $content = str_replace(']]>', ']]&gt;', $content);

    $excerpt_more = apply_filters('allianz_excerpt_more', '&hellip;');
    $excerpt = wp_trim_words($content, $length, $excerpt_more);

    return $excerpt;
}
/**
* Print post excerpt based on length.
*
* @param integer $length
*/
if (!function_exists('allianz_entry_excerpt')) :
    function allianz_entry_excerpt($args)
    {
        $args = wp_parse_args($args, [
            'length' => 55,
            'class' => ''
        ]);
        $cms_the_excerpt = get_the_excerpt();
        $classes = ['cms-excerpt', $args['class']];
    ?>
    <div class="<?php echo allianz_nice_class($classes); ?>"><?php
        if (!empty($cms_the_excerpt)) {
            echo esc_html($cms_the_excerpt);
        } else {
            echo wp_kses_post(allianz_get_the_excerpt($args['length']));
        }
    ?></div>
    <?php
    }
endif;
/**
 * Post Page Link
 * */
function allianz_entry_link_pages(){
    wp_link_pages(array(
        'before'      => '<div class="cms-page-links d-flex pt-20">',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
    ));
}
/**
 * Post Readmore
 * */
if(!function_exists('allianz_entry_readmore')){
    function allianz_entry_readmore(){
    ?>
        <div class="cms-readmore">
            <a class="btn btn-lg btn-primary btn-hover-primary text-white text-hover-white cms-hover-move-icon-up" href="<?php echo esc_url( get_permalink() ); ?>"><?php 
                echo esc_html__( 'Read More', 'allianz' ); 
                allianz_elementor_button_icon_render();
            ?></a>
        </div>
    <?php
    }
}
/**
 * Prints post meta
 */
if (!function_exists('allianz_post_meta')) :
    function allianz_post_meta($args = [])
    {
        $args = wp_parse_args($args, [
            'opt_prefix' => 'archive_',
            'class'      => '',
            'gap'        => '',
            'tax'        => 'category'
        ]);
        $classes = ['cms-post-meta', $args['class'], 'd-flex align-items-center'];
        if(!empty($args['gap'])) $classes[] = 'gap-'.$args['gap'];
        $author_on     = (bool) allianz_get_opt($args['opt_prefix'].'author_on', true);
        $categories_on = (bool) allianz_get_opt($args['opt_prefix'].'categories_on', true);
        $date_on       = (bool) allianz_get_opt($args['opt_prefix'].'date_on', true);
        $comments_on   = (bool) allianz_get_opt($args['opt_prefix'].'comments_on', false);

        $metas = [];
        if ($author_on || $comments_on || $categories_on || $date_on) : ?>
            <div class="<?php echo implode(' ', array_filter($classes)); ?>">
                <?php
                if ($categories_on ) : ?>
                    <div class="meta-item category empty-none"><?php allianz_the_terms(get_the_ID(), $args['tax'], ', ', ''); ?></div>
                <?php endif;
                if ($author_on) : ?>
                    <div class="separator"></div>
                    <div class="meta-item author">
                        <?php allianz_the_author_posts_link([
                            'text'       => '',
                            'link_class' => ''
                        ]); ?>
                    </div>
                <?php endif;
                if ($comments_on) : ?>
                    <div class="separator"></div>
                    <div class="meta-item comment"><?php allianz_comment_number(['link_class' => '']); ?></div>
                <?php endif; 
                 if ($date_on ) : ?>
                    <div class="meta-item date text-14"><?php echo get_the_date(); ?></div>
                <?php endif;
                ?>
            </div>
        <?php endif;
    }
endif;
/**
 * Author Post link
 * 
 * */
if(!function_exists('allianz_the_author_posts_link')){
    function allianz_the_author_posts_link($args = []){
        $args = wp_parse_args($args, [
            'id'         => '',   
            'text'       => '',
            'link_class' => '',
            'object'     => ''
        ]);
        if(! is_object($args['object'])){
            global $authordata;
            if ( ! is_object( $authordata ) ) {
                return '';
            }
            $user_id = $authordata->ID;
        } else {
            $user_id = $args['object']->post_author;
        }

        

        $link = sprintf(
            '%1$s<a href="%2$s" title="%3$s" class="%4$s" rel="author">%5$s</a>',
            $args['text'],
            esc_url( get_author_posts_url( $user_id , get_the_author_meta('user_nicename',$user_id ) ) ),
            /* translators: %s: Author's display name. */
            esc_attr( sprintf( esc_html__( 'Posts by %s', 'allianz' ), get_the_author_meta('display_name', $user_id ) ) ),
            $args['link_class'],
            get_the_author_meta('display_name', $user_id )
        );
        echo apply_filters( 'allianz_the_author_posts_link', $link );
    }
}
/**
 * Post Comment Count
 * */
if(!function_exists('allianz_comments_link')){
    function allianz_comment_number($args=[]){
        $args = wp_parse_args($args, [
            'title_class' => 'text-body text-hover-secondary-lighten',
            'link_class'  => ''  
        ]);
        $number = get_comments_number();
        switch ($number) {
            case '1':
                $html = '<span class="'.$args['title_class'].'">'.esc_html__('Comment','allianz').':&nbsp;</span>'.number_format_i18n($number);
                break;
            default:
                $html = '<span class="'.$args['title_class'].'">'.esc_html__('Comments','allianz').':&nbsp;</span>'.number_format_i18n($number);
                break;
        }
    ?>
        <a href="<?php the_permalink(); ?>" class="<?php echo esc_attr($args['link_class']); ?>"><?php printf('%s', $html);?></a>
    <?php
    }
}
/**
 * Prints tag list
 */
if (!function_exists('allianz_entry_tagged_in')){
    function allianz_entry_tagged_in($args = []) {
        $show_tag  = (bool)allianz_get_opt('post_tags_on', true);
        $tags_list = get_the_tag_list('', ', ');
        if (!$tags_list || !$show_tag) return;
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
    ?>
        <div class="<?php echo implode(' ', array_filter(['cms-post-tags', $args['class']])) ?>">
            <div class="tagcloud">
                <?php printf('%2$s', '', $tags_list); ?>
            </div>
        </div>
    <?php 
    }
}

/**
 * List socials share for post.
 * 
 * 
 */
function allianz_socials_share_default($args = []) {
    $args = wp_parse_args($args, [
        'class' => '',
        'show'  => false,
        'title' => ''
    ]);
    if(!$args['show']) return;
    $img_url = get_the_post_thumbnail_url();
    ?>
    <div class="<?php echo implode(' ', array_filter(['cms-post-share', $args['class']])) ?>">
        <?php if(!empty($args['title'])){ ?>
            <div class="share-title"><?php echo sprintf('%s', $args['title']); ?></div>
        <?php } ?>
        <div class="d-flex align-items-center gap-10 lh-1">
            <a title="<?php echo esc_attr__('Facebook', 'allianz'); ?>" target="_blank"
               href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" 
               ><i class="cmsi-facebook"></i></a>
            <a title="<?php echo esc_attr__('Twitter', 'allianz'); ?>" target="_blank"
               href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" 
               ><i class="cmsi-twitter-circle"></i></a>
            <a title="<?php echo esc_attr__('LinkedIn', 'allianz'); ?>" target="_blank"
               href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" 
               ><i class="cmsi-linkedin-circle"></i></a>
        </div>
    </div>
    <?php
}
function allianz_social_share_pinterest(){
?>
    <a title="<?php echo esc_attr__('Pinterest', 'allianz'); ?>" target="_blank"
               href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_url($img_url); ?>&description=<?php the_title(); ?>%20" 
               class="cmsi-pinterest d-none"></a>
<?php
}

/* Author Social */
function allianz_get_user_social(){
    $user_facebook = get_user_meta(get_the_author_meta('ID'), 'user_facebook', true);
    $user_twitter = get_user_meta(get_the_author_meta('ID'), 'user_twitter', true);
    $user_linkedin = get_user_meta(get_the_author_meta('ID'), 'user_linkedin', true);
    $user_skype = get_user_meta(get_the_author_meta('ID'), 'user_skype', true);
    $user_youtube = get_user_meta(get_the_author_meta('ID'), 'user_youtube', true);
    $user_vimeo = get_user_meta(get_the_author_meta('ID'), 'user_vimeo', true);
    $user_tumblr = get_user_meta(get_the_author_meta('ID'), 'user_tumblr', true);
    $user_rss = get_user_meta(get_the_author_meta('ID'), 'user_rss', true);
    $user_pinterest = get_user_meta(get_the_author_meta('ID'), 'user_pinterest', true);
    $user_instagram = get_user_meta(get_the_author_meta('ID'), 'user_instagram', true);
    $user_yelp = get_user_meta(get_the_author_meta('ID'), 'user_yelp', true);
    $user_tiktok = get_user_meta(get_the_author_meta('ID'), 'user_tiktok', true);

    ?>
    <div class="user-social unstyled d-flex gap-10">
        <?php if (!empty($user_facebook)) { ?>
            <a href="<?php echo esc_url($user_facebook); ?>" class="cmsi-facebook"></a>
        <?php } ?>
        <?php if (!empty($user_instagram)) { ?>
            <a href="<?php echo esc_url($user_instagram); ?>" class="cmsi-instagram"></a>
        <?php } ?>
        <?php if (!empty($user_tiktok)) { ?>
            <a href="<?php echo esc_url($user_tiktok); ?>" class="cmsi-tik-tok"></a>
        <?php } ?>
        <?php if (!empty($user_twitter)) { ?>
            <a href="<?php echo esc_url($user_twitter); ?>" class="cmsi-twitter-circle"></a>
        <?php } ?>
        <?php if (!empty($user_linkedin)) { ?>
            <a href="<?php echo esc_url($user_linkedin); ?>" class="cmsi-linkedin-circle"></a>
        <?php } ?>
        <?php if (!empty($user_rss)) { ?>
            <a href="<?php echo esc_url($user_rss); ?>" class="cmsi-rss"></a>
        <?php } ?>
        <?php if (!empty($user_skype)) { ?>
            <a href="<?php echo esc_url($user_skype); ?>" class="cmsi-skype"></a>
        <?php } ?>
        <?php if (!empty($user_pinterest)) { ?>
            <a href="<?php echo esc_url($user_pinterest); ?>" class="cmsi-pinterest"></a>
        <?php } ?>
        <?php if (!empty($user_vimeo)) { ?>
            <a href="<?php echo esc_url($user_vimeo); ?>" class="cmsi-vimeo-v"></a>
        <?php } ?>
        <?php if (!empty($user_youtube)) { ?>
            <a href="<?php echo esc_url($user_youtube); ?>" class="cmsi-youtube"></a>
        <?php } ?>
        <?php if (!empty($user_yelp)) { ?>
            <a href="<?php echo esc_url($user_yelp); ?>" class="cmsi-yelp"></a>
        <?php } ?>
        <?php if (!empty($user_tumblr)) { ?>
            <a href="<?php echo esc_url($user_tumblr); ?>" class="cmsi-tumblr"></a>
        <?php } ?>

    </div> <?php
}
/**
 * Prints posts pagination based on query
 *
 * @param WP_Query $query Custom query, if left blank, this will use global query ( current query )
 *
 * @return void
 */
/* Filter function to be used with number_format_i18n filter hook */
if( ! function_exists( 'allianz_number_format_i18n_zero_prefix' ) ) {
    function allianz_number_format_i18n_zero_prefix( $format ) {
        $number = intval( $format );
        if( intval( $number / 10 ) > 0 ) {
            return $format;
        }
        return '0' . $format;
    }
}
if(!function_exists('allianz_posts_pagination')){
    function allianz_posts_pagination($query = null, $ajax = false){
        if ($ajax) {
            add_filter('paginate_links', 'allianz_ajax_paginate_links');
        }

        $classes = array();

        if (empty($query)) {
            $query = $GLOBALS['wp_query'];
        }

        if (empty($query->max_num_pages) || !is_numeric($query->max_num_pages) || $query->max_num_pages < 2) {
            return;
        }

        $paged = $query->get('paged', '');

        if (!$paged && is_front_page() && !is_home()) {
            $paged = $query->get('page', '');
        }

        $paged = $paged ? intval($paged) : 1;

        $pagenum_link = html_entity_decode(get_pagenum_link());
        $query_args = array();
        $url_parts = explode('?', $pagenum_link);

        if (isset($url_parts[1])) {
            wp_parse_str($url_parts[1], $query_args);
        }

        $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
        $pagenum_link = trailingslashit($pagenum_link) . '%_%';

        $html_prev = '<i class="allianz-icon-left-arrow rtl-flip"></i> '.esc_html__('Prev','allianz');
        $html_next = esc_html__('Next','allianz').' <i class="allianz-icon-right-arrow rtl-flip"></i>';
        $paginate_links_args = array(
            'base'      => $pagenum_link,
            'total'     => $query->max_num_pages,
            'current'   => $paged,
            'mid_size'  => 1,
            'add_args'  => array_map('urlencode', $query_args),
            'prev_text' => $html_prev,
            'next_text' => $html_next
        );
        if ($ajax) {
            $paginate_links_args['format'] = '?page=%#%';
        }
        $links = paginate_links($paginate_links_args);
        if ($links):
        ?>
            <nav class="navigation posts-pagination <?php echo esc_attr($ajax ? 'ajax' : ''); ?>">
                <div class="posts-page-links d-flex align-items-center">
                    <?php
                        printf('%s', $links);
                    ?>
                </div>
            </nav>
        <?php
        endif;
    }
}

/**
 * Single Post
 * 
 * Display navigation to next/previous post when applicable.
 */
function allianz_post_nav_default(){
    if(!allianz_get_opt('post_navigation_on', true)) return;
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

    if (!empty($next_post) || !empty($previous_post)) {
        ?>
        <div class="cms-nav-links d-flex gap justify-content-between" style="--cms-gap:40px;">
            <?php if (is_a($previous_post, 'WP_Post') && get_the_title($previous_post->ID) != '') {
                $prev_img_id = get_post_thumbnail_id($previous_post->ID);
                $prev_img_url = wp_get_attachment_image_src($prev_img_id, 'thumbnail');
                ?>
                <a class="nav-item nav-post-prev d-flex gap-10 align-items-center" href="<?php echo esc_url(get_permalink($previous_post->ID)); ?>">
                    <span class="allianz-icon-up-right-arrow flip"></span>
                    <span><?php echo esc_html__('Prev Post', 'allianz'); ?></span>
                </a>
            <?php } else { echo  '<span></span>';} ?>
            <?php if (is_a($next_post, 'WP_Post') && get_the_title($next_post->ID) != '') {
                $next_img_id = get_post_thumbnail_id($next_post->ID);
                $next_img_url = wp_get_attachment_image_src($next_img_id, 'thumbnail');
                ?>
                <a class="nav-item nav-post-next d-flex gap-10 align-items-center" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
                    <span><?php echo esc_html__('Next Post', 'allianz'); ?></span>
                    <span class="allianz-icon-up-right-arrow rtl-flip"></span>
                </a>
            <?php } ?>
        </div>
    <?php }
}
/**
 * Single Post Comments
 * 
 * Custom Comment List
 * 
*/
function allianz_comment_list($comment, $args, $depth){
    $add_below = 'comment'; 
    $comment_classes = [empty($args['has_children'])?'':'parent'];
    ?>
    <div id="comment-<?php comment_ID(); ?>" <?php comment_class(implode(' ', array_filter($comment_classes)));?> >
        <div class="d-flex gap" style="--cms-gap-mobile:20px;">
            <div class="comment-avatar flex-auto"><?php if ($args['avatar_size'] != 0) {
                echo get_avatar($comment, 80, '', '', ['class' => 'cms-radius-10']);
            } ?></div>
            <div class="comment-content flex-basic flex-mobile-auto">
                <div class="comment-heading d-flex gap-10 align-items-center mt-n8">
                    <div class="comment-name font-700 text-18 text-heading">
                        <?php printf('%s', get_comment_author_link()); ?>
                    </div>
                    <div class="comment-meta text-13 text-heading">
                        <?php echo get_comment_date() . ' - ' . get_comment_time(); ?>
                    </div>
                </div>
                <div class="comment-text text-15 text-heading"><?php 
                    if(is_singular('product')){
                        woocommerce_review_display_rating();
                        echo '<div class="pb-15 clearfix"></div>';
                    }
                    //
                    comment_text();
                ?></div>
                <div class="comment-reply">
                    <?php comment_reply_link(
                          array_merge($args, [
                              'add_below' => $add_below,
                              'depth'     => $depth,
                              'max_depth' => $args['max_depth']
                          ])
                      ); ?>
                </div>
            </div>
        </div>

<?php }
/**
 * Single Post Comments
 * 
 * Comment Form
 * Move comment field to bottom
 * 
 * **/
add_filter( 'comment_form_fields', 'allianz_comment_field_to_bottom' );
function allianz_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    unset( $fields['cookies'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

/**
 * Single Post Comments
 * 
 * Comment Form
 * Comment form fields
**/
if(!function_exists('allianz_comment_form_args')){
    function allianz_comment_form_args($args = []){
        $args = wp_parse_args($args, []);
        global $post;
        $post_id       = $post->ID;
        $commenter     = wp_get_current_commenter();
        $user          = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';
        if ( ! isset( $args['format'] ) ) {
            $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
        }

        $req   = get_option( 'require_name_email' );
        $html5 = 'html5' === $args['format'];

        // Define attributes in HTML5 or XHTML syntax.
        $required_attribute = ( $html5 ? ' required' : ' required="required"' );
        $checked_attribute  = ( $html5 ? ' checked' : ' checked="checked"' );

        // Identify required fields visually and create a message about the indicator.
        $required_indicator = ' *';//' ' . wp_required_field_indicator();
        $required_text      = ' ' . wp_required_field_message();

        $comment_note_before = sprintf(
            '<p class="comment-notes">%s%s</p>',
            sprintf(
                '<span id="email-notes">%s</span>',
                __( 'Your email address will not be published.', 'allianz' )
            ),
            $required_text
        );
        $submit_icon = '<span class="btn-icon text-12 pt-2"><svg class="" fill="currentColor" fill-hover="currentColor" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z" fill="currentColor"/>
                </g>
                <g class="cms-hover-move-2">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z" fill="currentColor"/>
                </g>
            </svg></span>';
        $cms_comment_fields = array(
            'id_form'              => 'commentform',
            'class_form'              => 'comment-form cms-ecf7-fields2',
            'title_reply_before'   => '<div id="reply-title" class="comment-reply-title text-22 text-heading font-600">',
            'title_reply_after'   => '</div>'.$comment_note_before,
            'title_reply'          => is_singular('product') ? esc_attr__('Add A Review','allianz') : esc_attr__( 'Leave A Reply', 'allianz'),
            'title_reply_to'       => is_singular('product') ? esc_attr__('Leave A Review To','allianz').'%s' : esc_attr__('Leave A Reply To','allianz').'%s',
            'cancel_reply_link'    => is_singular('product') ? esc_attr__( 'Cancel Review', 'allianz') : esc_attr__( 'Cancel Reply', 'allianz'),
            'id_submit'            => 'submit',
            'class_submit'         => 'btn-cmt-submit btn-lg cms-hover-move-icon-up',
            'label_submit'         => is_singular('product') ? esc_attr__('Submit Review','allianz') : esc_attr__('Submit Comment','allianz'),
            'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">%4$s'.$submit_icon.'</button>',
            'comment_notes_before' => '',
            'fields'               => [
                'open'   => '<div class="d-flex gutter-40">',    
                'author' => sprintf(
                    '<div class="comment-form-author col-4 col-mobile-12">%s%s</div>',
                    sprintf(
                        '<label for="author">%s</label>',
                        esc_html__( 'Your Name','allianz' )
                    ),
                    sprintf(
                        '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245" autocomplete="name"%s placeholder="%s%s"/>',
                        esc_attr( $commenter['comment_author'] ),
                        ( $req ? $required_attribute : '' ),
                        __( 'Mahmoud Adel', 'allianz' ),
                        ( $req ? $required_indicator : '' )
                    )
                ),
                'email'  => sprintf(
                    '<div class="comment-form-email col-4 col-mobile-12">%s%s</div>',
                    sprintf(
                        '<label for="email">%s</label>',
                        esc_html__( 'Email Address','allianz' )
                    ),
                    sprintf(
                        '<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email"%s placeholder="%s%s" />',
                        ( $html5 ? 'type="email"' : 'type="text"' ),
                        esc_attr( $commenter['comment_author_email'] ),
                        ( $req ? $required_attribute : '' ),
                        __( 'Name@Allianz.com', 'allianz' ),
                        ( $req ? $required_indicator : '' )
                    )
                ),
                'url'    => sprintf(
                    '<div class="comment-form-url col-4 col-mobile-12">%s%s</div>',
                    sprintf(
                        '<label for="url">%s</label>',
                        esc_html__( 'Website','allianz' )
                    ),
                    sprintf(
                        '<input id="url" name="url" %s value="%s" size="30" maxlength="200" autocomplete="url" placeholder="%s"/>',
                        ( $html5 ? 'type="url"' : 'type="text"' ),
                        esc_attr( $commenter['comment_author_url'] ),
                        esc_html__('www.allainz.co','allianz')
                    )
                ),
                'close' => '</div>'
            ],
            'comment_field' => sprintf(
                '<div class="comment-form-comment mb-30 mt-35">%1$s%2$s%3$s%4$s</div>',
                do_action('allianz_before_comment_field'),
                sprintf(
                    '<label for="comment">%s%s</label>',
                    is_singular('product') ? esc_html__( 'Review', 'allianz' ) : esc_html__( 'Comment', 'allianz' ),
                    $required_indicator
                ),
                sprintf('<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" %s placeholder="%s%s"></textarea>',
                    $required_attribute,
                    '',//is_singular('product') ? esc_html__( 'Your Review', 'allianz' ) : esc_html__( 'Your Comment', 'allianz' ),
                    '',//$required_indicator
                ),
                do_action('allianz_after_comment_field')
            )
        );
        return $cms_comment_fields;
    }
}
/**
 * Single Post Comments
 * 
 * Comment Form
 * Comment reply link
**/
add_filter( 'comment_reply_link', 'allianz_comment_reply_link_class' );
if(!function_exists('allianz_comment_reply_link_class')){
    function allianz_comment_reply_link_class( $class ) {
        $class = str_replace( "class='comment-reply-link", "class='comment-reply-link cms-link", $class );
        return $class;
    }
}


/**
 * Get category taxomomy name by post type
 * 
 * */
function allianz_post_taxonomy_category(){
    switch (get_post_type()) {
        case 'cms-industry':
            return 'industry-category';
            break;
        case 'cms-service':
            return 'service-category';
            break;
        case 'cms-case':
            return 'case-category';
            break;
        case 'cms-career':
            return 'career-category';
            break;
        default:
            return 'category';
            break;
    }
}

/**
 * 
 *  Allianz Theme Configs
 * 
*/
if (!function_exists('allianz_configs')) {
    function allianz_configs($value)
    {
        // accent color 
        $accent_color   = apply_filters('allianz_accent_color', [
            'regular' => '#fe5b2c',
            'darken'  => '#f84619',
            'lighten' => '#fc651c'
        ]);
        // primary color
        $primary_color   = apply_filters('allianz_primary_color', [
            'regular'  => '#222222',
            'lighten'  => '#282828',
            'darken'   => '#010101'
        ]);
        // secondary
        $secondary_color = apply_filters('allianz_secondary_color', [
            'regular'  => '#1b1a1a',
            'lighten'  => '#161616',
            'lighten2' => '#272626'
        ]);
        // logo
        $logo_w       = '141';
        $logo_h       = '49';
        $logo_w_sm    = '33';
        $logo_h_sm    = '49';
        $menu_color = ['regular' => $primary_color['regular'], 'hover' => $primary_color['regular'], 'active' => $primary_color['regular']];
        $transparent_menu_color = ['regular' => '#ffffff', 'hover' => '#ffffff', 'active' => '#ffffff'];
        $header_height = '100';
        $header_width = '320';

        // body typo
        $body_font    = apply_filters('allianz_body_font','DM Sans');
        $body_color   = apply_filters('allianz_body_color',[
            'regular' => '#9b9b9b'
        ]);
        // heading typo
        $heading_font    = apply_filters('allianz_heading_font', 'Unbounded');
        $heading_color   = apply_filters('allianz_heading_color', [
            'regular' => '#1b1a1a', //$primary_color['regular']
            'lighten' => '#282828', //$primary_color['regular']
        ]);
        // Buttons
        $btn_font     = apply_filters('allianz_btn_font', 'Yantramanav');
        // Link
        $link_color = [
            'regular' => $primary_color['regular'], 
            'hover'   => $accent_color['regular'], 
            'active'  => $accent_color['regular']
        ];
        // Meta
        $meta_color = apply_filters('allianz_meta_color', $primary_color['lighten']);

        $accent_color_cf = [];
        foreach ($accent_color as $key => $accent_color_value) {
            $accent_color_cf[$key] =  allianz_get_opts('accent_color', $accent_color, 'color_custom')[$key];
        }
        $primary_color_cf = [];
        foreach ($primary_color as $key => $primary_color_value) {
            $primary_color_cf[$key] =  allianz_get_opts('primary_color', $primary_color, 'color_custom')[$key];
        }
        $secondary_color_cf = [];
        foreach ($secondary_color as $key => $secondary_color_value) {
            $secondary_color_cf[$key] =  allianz_get_opts('secondary_color', $secondary_color, 'color_custom')[$key];
        }

        $heading_color_cf = [];
        foreach ($heading_color as $key => $heading_color_value) {
            $heading_color_cf[$key] =  allianz_get_opts('heading_color', $heading_color, 'color_custom')[$key];
        }
        $configs = [
            // color
            'accent_color'    => $accent_color_cf,
            'primary_color'   => $primary_color_cf,
            'secondary_color' => $secondary_color_cf,
            'heading_color'   => $heading_color_cf,
            'link_color' => [
                'regular' => allianz_get_opts('link_color', $link_color, 'color_custom')['regular'],
                'hover'   => allianz_get_opts('link_color', $link_color, 'color_custom')['hover'],
                'active'  => allianz_get_opts('link_color', $link_color, 'color_custom')['active'],
            ],
            // body typo
            'body' => [
                'bg'          => '#fff',
                'family'      => allianz_get_opts('body_font_typo', ['font_family' => $body_font])['font_family'],
                'size'        => '17px',
                'weight'      => substr(allianz_get_opts('body_font_typo', ['font_style' => '400normal'])['font_style'], 0, 3),
                'style'       => substr(allianz_get_opts('body_font_typo', ['font_style' => '400normal'])['font_style'], 3),
                'color'       => allianz_get_opts('body_color', $body_color, 'color_custom')['regular'],
                'line-height' => 1.533,
            ],
            // Heading typo
            'heading' => [
                'family'      => allianz_get_opts('heading_font_typo', ['font_family' => $heading_font],'on')['font_family'],
                'weight'      => substr(allianz_get_opts('heading_font_typo', ['font_style' => '500normal'],'on')['font_style'], 0, 3),
                'style'       => substr(allianz_get_opts('heading_font_typo', ['font_style' => '500normal'],'on')['font_style'], 3),
                'line-height' => 1.1
            ],
            // Meta
            'meta'  => [
                'color' => allianz_get_opts('meta_color', $meta_color)
            ],
            // Header 
            'header'    => [
                'height' => allianz_get_opts('header_height', ['height' => $header_height], 'header_custom')['height'].'px'
            ],
            // logo
            'logo'  => [
                'width'     => allianz_get_opts('logo_maxh',['width' => $logo_w, 'height' => $logo_h], 'header_custom')['width'],
                'height'    => allianz_get_opts('logo_maxh',['width' => $logo_w, 'height' => $logo_h], 'header_custom')['height'],
                'width-mobile'  => allianz_get_opts('logo_maxh_sm',['width' => $logo_w_sm, 'height' => $logo_h_sm],'header_custom')['width'],
                'height-mobile' => allianz_get_opts('logo_maxh_sm',['width' => $logo_w_sm, 'height' => $logo_h_sm],'header_custom')['height']
            ],
            // menu color
            'menu_color' => [
                'regular' => allianz_get_opts('main_menu_color', $menu_color, 'header_custom')['regular'],
                'hover'   => allianz_get_opts('main_menu_color', $menu_color, 'header_custom')['hover'],
                'active'  => allianz_get_opts('main_menu_color', $menu_color, 'header_custom')['active'],
            ],
            // transparent menu color
            'transparent_menu_color' => [
                'regular' => allianz_get_opts('transparent_menu_color', $transparent_menu_color, 'header_custom')['regular'],
                'hover'   => allianz_get_opts('transparent_menu_color', $transparent_menu_color, 'header_custom')['hover'],
                'active'  => allianz_get_opts('transparent_menu_color', $transparent_menu_color, 'header_custom')['active'],
            ],
            // Dropdown

            // Page title
            'ptitle'  => [
                'color'      => '#fff',
                'bg-color'   => allianz_get_opts('page_title_bg', ['background-color' => '#1b1a1a', 'background-image' => ''], 'custom_ptitle')['background-color'],
                'bg-image'   => 'url('.allianz_get_opts('page_title_bg', ['background-color' => '#1b1a1a', 'background-image' => ''], 'custom_ptitle')['background-image'].')',
                'bg-overlay' => allianz_get_opts('page_title_overlay', 'rgba(var(--cms-primary-rgb), 0.25)', 'custom_ptitle')
            ],
            // Single Product
            'product_ptitle' => [
                'bg-color'   => allianz_get_opts('product_page_title_bg', ['background-color' => '#1b1a1a', 'background-image' => ''])['background-color'],
                'bg-image'   => 'url('.allianz_get_opts('product_page_title_bg', ['background-color' => '#1b1a1a', 'background-image' => ''])['background-image'].')',
            ]
        ];
        return $configs[$value];
    }
}
if(!function_exists('allianz_theme_colors')){
    function allianz_theme_colors($args = []){
        $args = wp_parse_args($args, [
            'custom' => true
        ]);
        $colors = [
            'accent'    => allianz_configs('accent_color'),
            'primary'   => allianz_configs('primary_color'),
            'secondary' => allianz_configs('secondary_color'),
            'heading'   => allianz_configs('heading_color')
        ];
        $others = [
            'link' => allianz_configs('link_color'),
            'body' => ['color' => allianz_configs('body')['color']],
            'menu' => allianz_configs('menu_color')
        ];

        $customs = apply_filters('allianz_elementor_theme_custom_colors', []);

        $opts = ['' => esc_html__('Default','allianz')];
        foreach ($colors as $key => $value) {
            if(is_array($value)){
                foreach ($value as $_key => $_value) {
                    $opts[$key.'-'.$_key] = $key.' '.$_key.'('.$_value.')';
                }
            } else {
                $opts[$key] = $key.'('.$value.')';
            }
        }
        $opts['white']  = esc_html__('White','allianz');

        if($args['custom']){
            $customs['custom'] = esc_html__('Custom','allianz');
        }
        return array_merge($opts, $customs);
    }
}
if(!function_exists('allianz_theme_custom_colors')){
    function allianz_theme_custom_colors(){
        $color = [
            'grey'  => [
                'title' => esc_html__('Grey', 'allianz') .'(#f9f9f9)',
                'color' => '#f9f9f9'
            ],
            'grey2' => [
                'title' => esc_html__('Grey #2', 'allianz').'(#f3f2ed)',
                'color' => '#f3f2ed',
            ],
            'grey3' => [
                'title' => esc_html__('Grey #3', 'allianz').'(#d6d6d6)',
                'color' => '#d6d6d6',
            ],
            'red'   => [
                'title' => esc_html__('Red', 'allianz'),
                'color' => '#ff0000'
            ]
        ];
        return apply_filters('allianz_theme_custom_colors', $color);
    }
}
add_filter('allianz_elementor_theme_custom_colors', 'allianz_elementor_theme_custom_colors');
if(!function_exists('allianz_elementor_theme_custom_colors')){
    function allianz_elementor_theme_custom_colors(){
        $colors = allianz_theme_custom_colors();
        $_colors = [];
        foreach ($colors as $key => $color) {
            $_colors[$key] = $color['title'];
        }
        return $_colors;
    }
}

if (!function_exists('allianz_hex_to_rgb')) {
    function allianz_hex_to_rgb($color)
    {

        $default = '0,0,0';

        //Return default if no color provided
        if (empty($color))
            return $default;

        //Sanitize $color if "#" is provided 
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        $output = implode(",", $rgb);

        //Return rgb(a) color string
        return $output;
    }
}

if (!function_exists('allianz_inline_styles')) {
    function allianz_inline_styles()
    {
        ob_start();
        // CSS Variable
        $accent_colors          = allianz_configs('accent_color');
        $primary_colors         = allianz_configs('primary_color');
        $secondary_colors       = allianz_configs('secondary_color');
        // Global
        $body                   = allianz_configs('body');
        $heading                = allianz_configs('heading');
        $heading_colors         = allianz_configs('heading_color');
        $meta                   = allianz_configs('meta');
        $link_color             = allianz_configs('link_color');
        // Header
        $header                 = allianz_configs('header');
        $logo                   = allianz_configs('logo');
        $menu_color             = allianz_configs('menu_color');
        $transparent_menu_color = allianz_configs('transparent_menu_color');
        // Page Title
        $ptitle                 = allianz_configs('ptitle');
        // Custom Color
        $customs_colors = allianz_theme_custom_colors();
        // Single product
        $product_ptitle                 = allianz_configs('product_ptitle');
        echo ':root{';
            // color rgb
            foreach ($accent_colors as $key => $value) {
                printf('--cms-accent-%1$s-rgb: %2$s;', str_replace('#', '', $key), allianz_hex_to_rgb($value));
            }
            foreach ($primary_colors as $key => $value) {
                printf('--cms-primary-%1$s-rgb: %2$s;', str_replace('#', '', $key), allianz_hex_to_rgb($value));
            }
            foreach ($secondary_colors as $key => $value) {
                printf('--cms-secondary-%1$s-rgb: %2$s;', str_replace('#', '', $key), allianz_hex_to_rgb($value));
            }
            foreach ($heading_colors as $key => $value) {
                printf('--cms-heading-%1$s-rgb: %2$s;', str_replace('#', '', $key), allianz_hex_to_rgb($value));
            }
            // color hex
            foreach ($accent_colors as $key => $value) {
                printf('--cms-accent-%1$s: %2$s;', str_replace('#', '', $key), $value);
            }
            foreach ($primary_colors as $key => $value) {
                printf('--cms-primary-%1$s: %2$s;', str_replace('#', '', $key), $value);
            }
            foreach ($secondary_colors as $key => $value) {
                printf('--cms-secondary-%1$s: %2$s;', str_replace('#', '', $key), $value);
            }
            foreach ($heading_colors as $key => $value) {
                printf('--cms-heading-%1$s: %2$s;', str_replace('#', '', $key), $value);
            }
            // Body
            foreach ($body as $key => $value) {
                if($key === 'family') $value = '\''.$value.'\', sans-serif';
                printf('--cms-body-%1$s: %2$s;', $key, $value);
            }
            // Heading
            foreach ($heading as $key => $value) {
                if($key === 'family') $value = '\''.$value.'\', sans-serif';
                printf('--cms-heading-%1$s: %2$s;', $key, $value);
            }
            // meta
            foreach ($meta as $key => $value) {
                printf('--cms-meta-%1$s: %2$s;', $key, $value);
            }
            // link color
            foreach ($link_color as $color => $value) {
                printf('--cms-link-%1$s-color: %2$s;', $color, $value);
            }
            // Header
            foreach ($header as $key => $value) {
                printf('--cms-header-%1$s: %2$s;', $key, $value);
            }
            // Logo
            foreach ($logo as $key => $value) {
                printf('--cms-logo-%1$s: %2$s;', $key, $value.'px');
            }
            // Menu color
            foreach ($menu_color as $color => $value) {
                printf('--cms-menu-%1$s: %2$s;', $color, $value);
            }
            // Menu color rgb
            foreach ($menu_color as $color => $value) {
                printf('--cms-menu-%1$s-rgb: %2$s;', str_replace('#', '', $color), allianz_hex_to_rgb($value));
            }
            // Transparent Menu color
            foreach ($transparent_menu_color as $color => $value) {
                printf('--cms-menu-transparent-%1$s: %2$s;', $color, $value);
            }
            // Transparent Menu color rgb
            foreach ($transparent_menu_color as $color => $value) {
                printf('--cms-menu-transparent-%1$s-rgb: %2$s;', str_replace('#', '', $color), allianz_hex_to_rgb($value));
            }
            // Page title
            foreach ($ptitle as $key => $value) {
                printf('--cms-ptitle-%1$s: %2$s;', $key, $value);
            }
            // Custom Color
            foreach ($customs_colors as $key => $value) {
                printf('--cms-%1$s: %2$s;', $key, $value['color']);
            }
            // Product
            foreach ($product_ptitle as $key => $value) {
                printf('--cms-product-ptitle-%1$s: %2$s;', $key, $value);
            }
            // Popup
            printf('--cms-popup-max-width:'.allianz_get_opts('popup_max_w', ['width' => 620], 'popup_custom')['width'].'px;');
        echo '}';
        return ob_get_clean();
    }
}
// end function for inline style

/**
 * Render Attributes
 * 
 * */
if(!function_exists('allianz_render_attrs')){
    function allianz_render_attrs($attrs = []){
        if(!is_array($attrs) || empty($attrs)) return;
        $atts = [];
        foreach ($attrs as $key => $attr) {
            $atts[] = $key.'="'.implode(' ', array_filter((array)$attr)).'"';
        }
        echo implode(' ', array_filter($atts));
    }
}

/**
 * Theme Options
 * 
 * **/
/**
 * Get Page List
 * @return array
 */
if (!function_exists('allianz_list_page')) {
    function allianz_list_page($default = [])
    {
        $page_list = array();
        if (!empty($default))
            $page_list[$default['value']] = $default['label'];
        $pages = get_pages(array('hierarchical' => 0, 'posts_per_page' => '-1'));
        foreach ($pages as $page) {
            $page_list[$page->ID] = $page->post_title;
        }
        return $page_list;
    }
}

/**
 * Get Post List
 * @return array
 */
if (!function_exists('allianz_list_post')) {
    function allianz_list_post($post_type = 'post', $default = false)
    {
        $post_list = array();
        if ($default) {
            $post_list['none'] = esc_html__('None', 'allianz');
            $post_list['-1'] = esc_html__('Default', 'allianz');
        }
        $posts = get_posts(array('post_type' => $post_type, 'posts_per_page' => '-1'));
        foreach ($posts as $post) {
            $post_list[$post->ID] = $post->post_title;
        }
        return $post_list;
    }
}

/**
 * Get theme option based on its id.
 *
 * @param string $opt_id Required. the option id.
 * @param mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function allianz_get_opt($opt_id, $default = false){
    $opt_name = allianz_get_opt_name();
    if (empty($opt_name)) {
        return $default;
    }
    global ${$opt_name};
    if (!isset(${$opt_name}) || !isset(${$opt_name}[$opt_id])) {
        $options = get_option($opt_name);
    } else {
        $options = ${$opt_name};
    }
    if (
        !isset($options) ||
        !isset($options[$opt_id]) ||
        $options[$opt_id] === ''
    ) {
        return $default;
    }
    if (is_array($options[$opt_id]) && is_array($default)) {
        foreach ($options[$opt_id] as $key => $value) {
            if (isset($default[$key]) && $value === '') {
                $options[$opt_id][$key] = $default[$key];
            }
        }
    }
    return $options[$opt_id];
}

/**
 * Get theme option based on its id.
 *
 * @param string $opt_id Required. the option id.
 * @param mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function allianz_get_page_opt($opt_id, $default = false){
    $page_opt_name = allianz_get_page_opt_name();
    if (empty($page_opt_name)) {
        return $default;
    }
    $id = get_the_ID();
    if (!is_archive() && is_home()) {
        if (!is_front_page()) {
            $page_for_posts = get_option('page_for_posts');
            $id = $page_for_posts;
        }
    }

    // Get page option for Shop Page
    if (class_exists('WooCommerce') && is_shop()) {
        $id = get_option('woocommerce_shop_page_id');
    }

    return $options = !empty($id)
        ? get_post_meta(intval($id), $opt_id, true)
        : $default;
}

/**
 *
 * Get post format values.
 *
 * @param $post_format_key
 * @param bool $default
 *
 * @return bool|mixed
 */
function allianz_get_post_format_value( $id = null, $post_format_key = '', $default = '' ) {
    global $post;
    if ( $id === null ) {
        $id = $post->ID;
    }

    return $value = ( ! empty( $id ) && '' !== get_post_meta( $id, $post_format_key, true ) ) ? get_post_meta( $id, $post_format_key, true ) : $default;
}

/**
 * Get option based on its id.
 * get option of theme and page
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 * @return mixed
 */
function allianz_get_opts($opt_id, $default = false, $dependency = ''){
    $theme_opt = allianz_get_opt($opt_id, $default);
    $_dependency = allianz_get_page_opt($dependency);
    if($dependency === 'on' || $_dependency === 'on'){
        $page_opt = allianz_get_page_opt($opt_id, $theme_opt);
        if ($page_opt !== null && $page_opt !== '' && $page_opt !== '-1' && $page_opt !== '0') {
        //if (!in_array($page_opt, [null,'','-1', 0]) ) {
            if (is_array($page_opt) && is_array($theme_opt)) {
                foreach ($page_opt as $key => $value) {
                    foreach ($theme_opt as $key => $value) {
                        if (empty($page_opt[$key]) || $page_opt[$key] === 'px') {
                            $page_opt[$key] = $theme_opt[$key];
                        }
                    }
                }
            }
            $theme_opt = $page_opt;
        }
    }
    return $theme_opt;
}

/**
 * Get opt_name for options instance args and for
 * getting option value.
 *
 * @return string
 */
function allianz_get_opt_name_default(){
    return apply_filters('allianz_opt_name', 'cms_theme_options');
}
function allianz_get_opt_name(){
    if (isset($_POST['opt_name']) && !empty($_POST['opt_name'])) {
        return $_POST['opt_name'];
    }
    $opt_name = allianz_get_opt_name_default();
    if (defined('ICL_LANGUAGE_CODE')) {
        if (ICL_LANGUAGE_CODE != 'all' && !empty(ICL_LANGUAGE_CODE)) {
            $opt_name = $opt_name . '_' . ICL_LANGUAGE_CODE;
        }
    }

    return $opt_name;
}

/**
 * Get opt_name for options instance args and for
 * getting option value.
 *
 * @return string
 */
function allianz_get_page_opt_name(){
    return apply_filters('allianz_page_opt_name', 'cms_page_options');
}

/**
 * Get opt_name for options instance args and for
 * getting option value.
 *
 * @return string
 */
function allianz_get_post_opt_name(){
    return apply_filters('allianz_post_opt_name', 'allianz_post_options');
}
/*====== End Theme Option ==========*/
/**
 * Elementor
 * All function for Elementor
 * 
 * **/

/**
 * Ajax Pagination
 * Use in Element Post Grid/Blog
 * 
 * */
if (!function_exists('allianz_ajax_paginate_links')) {
    function allianz_ajax_paginate_links($link)
    {
        $parts = parse_url($link);
        parse_str($parts['query'], $query);
        if (isset($query['page']) && !empty($query['page'])) {
            return '#' . $query['page'];
        } else {
            return '#1';
        }
    }
}

/**
 * Custom WP Menu
 * 
 * */
// add class to link
add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    $atts['class'] = 'cms-menu-link';
    if(isset($args->link_class) && !empty($args->link_class)){
        $atts['class'] .= ' '.$args->link_class;
    }
    return $atts;
}, 10, 3);

// Custom Menu title
add_filter('nav_menu_item_title', 'allianz_nav_menu_item_title', 10, 2);
function allianz_nav_menu_item_title($title){
    $title = '<span class="menu-title title">'.$title.'</span>';
    return $title;
}
/**
 *  Menu type Category
 *  add post count to menu title
*/
add_filter('the_title', 'allianz_menu_item_category_count', 10, 2);
function allianz_menu_item_category_count($title, $post_ID)
{
    if( 'nav_menu_item' == get_post_type($post_ID) )
    {
        if( 'taxonomy' == get_post_meta($post_ID, '_menu_item_type', true) && 'category' == get_post_meta($post_ID, '_menu_item_object', true) )
        {
            $category = get_category( get_post_meta($post_ID, '_menu_item_object_id', true) );
            $title .= sprintf('<span class="count">%d</span>', $category->count);
            //$title .= '<span class="arrow cmsi-arrow-circle-right rtl-flip text-26"></span>';
        }
    }
    return $title;
}
/**
 * Mega Menu
 * 
 * **/
class Allianz_Mega_Menu_Walker extends Walker_Nav_Menu
{
    private $item;

    /**
     * Starts the list before the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $sub_menu_class = isset($args->sub_menu_class) ? $args->sub_menu_class : '';
        $sub_menu_classes = implode(' ', array_filter(['sub-menu',$sub_menu_class]));
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"$sub_menu_classes\">\n";
    }

    /**
     * @see Walker::start_el()
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $item_html = '';
        $megamenu = apply_filters('cms_enable_megamenu', false);

        if ('[divider]' === $item->title) {
            $output .= '<li class="menu-item-divider"></li>';
            return;
        }

        $extra_menu_custom = apply_filters("cms_menu_edit", array());
        foreach ($extra_menu_custom as $key => $f) {
            $val = get_post_meta($item->ID, '_menu_item_' . $key, true);
            if (!empty($val)) {
                $item->classes[] = $val;
            }
        }
        // children/toggle icon 
        //if($depth != 1 && ($args->walker->has_children || (!empty($item->cms_megaprofile) && $megamenu)) )
        if($args->walker->has_children || (!empty($item->cms_megaprofile) && $megamenu) )
        {
            $args->old_link_after = $args->link_after;
            $args->link_after = '<span class="main-menu-toggle"></span>' . $args->link_after ;
        }
        // megamenu
        if (!empty($item->cms_megaprofile) && $megamenu) {
            $item->classes[] = 'megamenu';
            $item->classes[] = 'menu-item-has-children';
        }
        switch ($item->cms_megaprofile_full) {
            case '0':
                break;
            case '1':
                $item->classes[] = 'megamenu-full';
                break;
            default:
                $item->classes[] = 'megamenu-'.$item->cms_megaprofile_full;
                break;
        }

        if (!empty($item->cms_icon)) {
            $item->classes[] = 'has-icon';
            $icon_class = [
                'menu-icon',
                'order-'.$item->cms_icon_position,
                $item->cms_icon,
                $args->icon_class
            ];
            $item->title .= '<i class="' . implode(' ', array_filter($icon_class)) . '"></i>';
        }
        // Sub Menu
        parent::start_el($item_html, $item, $depth, $args, $id);
        // Link before
        if (isset($args->old_link_before)) {
            $args->link_before = $args->old_link_before;
            $args->old_link_before = '';
        }
        // link after
        if (isset($args->old_link_after)) {
            $args->link_after = $args->old_link_after;
            $args->old_link_after = '';
        }
        // mega menu
        if (!empty($item->cms_megaprofile)) {
            //$output = '';
            $megamenu_class = ['sub-menu sub-megamenu'];
            switch ($item->cms_megaprofile_full) {
                case '0':
                    $megamenu_class[] = 'cms-megamenu-auto';
                    break;
                case '1':
                    $megamenu_class[] = 'cms-megamenu-full';
                    break;
                default:
                    $megamenu_class[] = 'cms-megamenu-'.$item->cms_megaprofile_full;
                    break;
            }
            $megamenu_class = apply_filters('cms_megamenu_classes', $megamenu_class );
            $item_html .= '<div class="'.implode(' ', array_filter($megamenu_class)).'">';
                $item_html .= $this->get_megamenu($item->cms_megaprofile);
            $item_html .= '</div>';
        }

        $output .= $item_html;
    }

    public function get_megamenu($id)
    {
        $content = class_exists('\Elementor\Plugin') ? \Elementor\Plugin::$instance->frontend->get_builder_content( $id ) : '';
        $megamenu = apply_filters('cms_enable_megamenu', false);
        if ($megamenu && !empty($content))
            return  $content;
        else
            return false;
    }
}

/**
 * Menu Toggle
 * 
 */
class Allianz_Toggle_Menu_Walker extends Walker_Nav_Menu
{
    private $item;

    /**
     * Starts the list before the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $sub_menu_class = isset($args->sub_menu_class) ? $args->sub_menu_class : '';
        $sub_menu_classes = implode(' ', array_filter(['sub-menu','sub-menu-toggle',$sub_menu_class]));
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"$sub_menu_classes\">\n";
    }

    /**
     * @see Walker::start_el()
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $item_html = '';
        $megamenu = apply_filters('cms_enable_megamenu', false);

        if ('[divider]' === $item->title) {
            $output .= '<li class="menu-item-divider"></li>';
            return;
        }

        $extra_menu_custom = apply_filters("cms_menu_edit", array());
        foreach ($extra_menu_custom as $key => $f) {
            $val = get_post_meta($item->ID, '_menu_item_' . $key, true);
            if (!empty($val)) {
                $item->classes[] = $val;
            }
        }

        // children/toggle icon 
        //if($depth != 1 && ($args->walker->has_children || (!empty($item->cms_megaprofile) && $megamenu)))
        if($args->walker->has_children || (!empty($item->cms_megaprofile) && $megamenu))
        {
            $args->old_link_after = $args->link_after;
            $args->link_after = '<span class="main-menu-toggle"></span>' . $args->link_after ;
        }
        // megamenu
        if (!empty($item->cms_megaprofile) && $megamenu) {
            $item->classes[] = 'megamenu';
            $item->classes[] = 'menu-item-has-children';
        }

        if (!empty($item->cms_icon)) {
            $item->classes[] = 'has-icon';
            $icon_class = [
                'menu-icon',
                'order-'.$item->cms_icon_position,
                $item->cms_icon,
                $args->icon_class
            ];
            $item->title .= '<i class="' . implode(' ', array_filter($icon_class)) . '"></i>';
        }

        parent::start_el($item_html, $item, $depth, $args, $id);

        if (isset($args->old_link_before)) {

            $args->link_before = $args->old_link_before;
            $args->old_link_before = '';
        }

        if (isset($args->old_link_after)) {
            $args->link_after = $args->old_link_after;
            $args->old_link_after = '';
        }

        if (!empty($item->cms_megaprofile)) {
            $item_html .= $this->get_megamenu($item->cms_megaprofile);
        }

        $output .= $item_html;
    }

    public function get_megamenu($id)
    {
        $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $id );
        $megamenu = apply_filters('cms_enable_megamenu', false);
        if ($megamenu)
            return '<ul class="sub-menu sub-megamenu sub-menu-toggle"><li>' . $content . '</li></ul>';
        else
            return false;
    }
}

/**
 * Custom Media Fields
 * Add custom video url foreach image
 * 
**/
add_filter( 'attachment_fields_to_edit', 'allianz_attachment_field_video', null, 2 );
function allianz_attachment_field_video( $form_fields, $post ) {
    $form_fields['allianz_image_video'] = array(
        'label' => esc_html__('Video Link','allianz'),
        'input' => 'textarea',
        'value' => get_post_meta( $post->ID, 'allianz_image_video', true ),
        'helps' => esc_html__( 'Youtube/Vimeo video URL','allianz' ),
    );
    return $form_fields;
}
// Save value
add_filter( 'attachment_fields_to_save', 'allianz_attachment_field_video_save', 1, 2 );
function allianz_attachment_field_video_save( $post, $attachment ) {
    if( isset( $attachment['allianz_image_video'] ) )
        update_post_meta( $post['ID'], 'allianz_image_video', $attachment['allianz_image_video'] );
    return $post;
}
// Get value
function allianz_get_attachment_field_video($attacment_ID = null){
    $allianz_image_video = get_post_meta($attacment_ID, 'allianz_image_video', true);
    return $allianz_image_video;
}

/**
 * Custom wp_kses_post
 * 
 * **/
function allianz_wp_kses_allowed_html( $allowedposttags, $context ) {
    if ( $context === 'post' ) {
        $allowedposttags['svg']  = array(
            'xmlns'      => true,
            'viewbox'    => true,
            'class'      => true,
            'fill'       => true,  
            'fill-hover' => true,  
        );
        $allowedposttags['g'] = array(
            'class' => true
        );
        $allowedposttags['path'] = array(
            'd'     => true,
            'fill'  => true,
            'class' => true,
        );
    }
    return $allowedposttags;
}
add_filter( 'wp_kses_allowed_html', 'allianz_wp_kses_allowed_html', 10, 2 );