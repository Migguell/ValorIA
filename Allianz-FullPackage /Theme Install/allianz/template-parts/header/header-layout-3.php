<?php
/**
 * Template part for displaying default header layout
 */
?>
<header id="cms-header-wrap" class="site-header">
    <div id="cms-header" class="<?php echo allianz_header_classes(); ?>">
         <?php allianz_header_top(); ?>
        <div class="<?php echo allianz_header_container_classes('d-flex flex-nowrap gap-30 justify-content-between'); ?>">
            <?php 
            // logo
            get_template_part('template-parts/header/header-branding', '', [
                'before' => '<div class="site-branding flex-auto d-flex justify-content-start">',
                'after'  => '</div>',
            ]);
            ?>
            <div class="cms-header-nav-tools flex-auto d-flex gap-30 pl-50 pl-tablet-20 cms-hover-backdrop-psedure">
                <?php 
                // Navigation 
                get_template_part('template-parts/header/header-menu', '',[
                    'before'            => '<nav class="site-navigation site-navigation-dropdown flex-basic">', 
                    'after'             => '</nav>',
                    'custom_menu_class' => 'cms-menu-line-title',
                    'menu'   => allianz_get_opts('dropdown_menu', '', 'header_custom')
                ]);
                ?>
                <div class="<?php echo allianz_header_tools_classes(['class' => 'site-tools flex-auto d-flex gap-20 justify-content-end align-items-center relative']); ?>">
                    <?php
                    // Search icon
                    allianz_header_search([
                        'class' => 'site-header-item menu-color',
                        'text' => ''
                    ]);
                    // Login
                    allianz_header_login();
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
                        'class' => 'menu-color',
                        
                    ]);
                    // Mail
                    allianz_header_mail_render(['class' => 'site-header-item menu-color']);
                    // Side Nav
                    allianz_header_side_nav_render([
                        'class' => 'site-header-item'
                    ]);
                    // Mobile menu
                    allianz_open_mobile_menu();
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>