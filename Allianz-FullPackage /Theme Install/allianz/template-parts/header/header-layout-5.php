<?php
/**
 * Template part for displaying default header layout
 */
$hide_sidebar_icon = allianz_get_opts( 'hide_sidebar_icon', 'off', 'header_custom' );
$header_sidenav_layout = allianz_get_opts('header_sidenav_layout', 'none', 'hide_sidebar_icon');
if ( !in_array($header_sidenav_layout, ['-1', '0', 'none', '']) && $hide_sidebar_icon == 'on' && apply_filters('allianz_enable_sidenav', false) ){
    $hide_mobile_nav = true;
} else {
    $hide_mobile_nav = false;
}
$show_menu_dropdown = ( in_array($header_sidenav_layout, ['-1', '0', 'none', '']) || $hide_sidebar_icon != 'on' || !apply_filters('allianz_enable_sidenav', false) );
?>
<header id="cms-header-wrap" class="site-header">
    <div id="cms-header" class="<?php echo allianz_header_classes(); ?>">
         <?php allianz_header_top(); ?>
        <div class="<?php echo allianz_header_container_classes('d-flex justify-content-between'); ?>">
            <?php 
            // logo
            get_template_part('template-parts/header/header-branding', '', [
                'before' => '<div class="site-branding flex-basic d-flex justify-content-start">',
                'after'  => '</div>',
                'menu'   => allianz_get_opts('dropdown_menu', '', 'header_custom')
            ]);
            ?>
            <?php
            // Navigation 
            if ( $show_menu_dropdown ){
                get_template_part('template-parts/header/header-menu', '',[
                    'before' => '<nav class="site-navigation site-navigation-dropdown justify-content-center flex-auto">', 
                    'after'  => '</nav>' 
                ]);
            }
            ?>
            <div class="<?php echo allianz_header_tools_classes(['class' => 'site-tools flex-basic d-flex justify-content-end align-items-center']); ?>">
                <?php
                // Button 01
                $btn_icon_1 = allianz_elementor_svg_hover_icon_render([
                    'class'  => 'rtl-flip',
                    'echo'   => false,
                    'before' => '<span class="order-last text-12">',
                    'after'  => '</span>'
                ]);
                allianz_header_button_render([
                    'wrap_class' => 'mr-10 mr-laptop-0', //cms-hidden-smobile
                    'class'      => 'h-btn1 btn btn-smd btn-primary-regular text-white btn-hover-accent text-hover-white cms-hover-move-icon-up',
                    'data'       => [
                        'default'     => 'btn-primary-regular+text-white',
                        'transparent' => (allianz_get_opts('header_transparent', 'off', 'header_custom') === 'on') ? 'btn-white+text-primary' : 'btn-secondary-regular+text-white'
                    ],
                    'icon'        => $btn_icon_1,
                    'icon_mobile' => '<span class="cmsi-email"></span>'
                ]);
                
                // Button 02
                allianz_header_button_render([
                    'name'  => 'h_btn2', 
                    'class' => 'h-btn2 btn btn-smd btn-accent-regular btn-hover-secondary-regular text-white text-hover-white',
                    'data'  => [
                        'default'     => 'btn-accent-regular btn-hover-secondary-regular text-white text-hover-white',
                        'transparent' => (allianz_get_opts('header_transparent', 'off', 'header_custom') === 'on') ? '' : ''
                    ],
                    'icon' => '<span class="cms-hidden-wide allianz-icon-up-right-arrow rtl-flip text-12"></span>'
                ]);
                // Phone
                allianz_header_phone_render2([
                    'class' => ''
                ]);
                // Mail
                allianz_header_mail_render(['class' => 'site-header-item menu-color']);
                // Login
                allianz_header_login();
                // Search icon
                allianz_header_search([
                    'class' => 'site-header-item menu-color',
                    'text' => ''
                ]);
                // Wishlist
                allianz_header_wishlist();
                // Compare
                allianz_header_compare();
                // Currency Switch
                allianz_header_woocs();
                // Language Switch
                allianz_header_language_switcher();
                // Cart icon
                allianz_header_cart();
                // Side Nav
                allianz_header_side_nav_render([
                    'class'       => 'site-header-item',
                    'mode'        => 'slide',
                    'slide'       => 'left',
                    'modal_width' => '100vw',
                    'modal_class' => 'bg-white align-items-start modal-no-space close-white',  
                    'title'       => '<span class="text-15 font-600">'.esc_html__('Menu','allianz').'</span>',
                    'close_text'  => 'Close'
                ]);
                // Mobile menu
                if ( $show_menu_dropdown ){
                    allianz_open_mobile_menu([
                        'hide_desktop' => $hide_mobile_nav
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
</header>