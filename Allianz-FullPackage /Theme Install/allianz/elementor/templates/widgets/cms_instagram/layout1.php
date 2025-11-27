<?php 
$randGallery = $widget->get_setting('gallery', []);
if(empty($randGallery)) return;
// Global
$default_align = 'center';
// Arrows
$arrows = $widget->get_setting('arrows');
$arrows_type = $widget->get_setting('arrows_type', 'button');
$arrows_icon_size = ($arrows_type === 'icon') ? 45 : 10; 
$arrows_classes = [
    'cms-carousel-button in',
    'arrow-'.$arrows_type,
    allianz_add_hidden_device_controls_render($settings, 'arrows_')
];
if($arrows_type == 'icon'){
    $arrows_classes[] = 'text-white text-hover-accent';
} else {
    $arrows_classes[] = 'bg-primary text-white bg-hover-accent';
}
$widget->add_render_attribute('arrows-prev', [
    'class' => array_merge(['cms-carousel-button-prev prev'], $arrows_classes)
]);
$widget->add_render_attribute('arrows-next', [
    'class' => array_merge(['cms-carousel-button-next next'], $arrows_classes)
]);
// Dots
$dots = $widget->get_setting('dots');
$dots_type = $widget->get_setting('dots_type', 'bullets');
$widget->add_render_attribute('dots', [
    'class' => [
        'cms-carousel-dots',
        'cms-carousel-dots-'.$settings['dots_type'],
        'cms-carousel-dots-primary-regular',
        'cms-carousel-dots-active-accent-regular',
        'justify-content-center',
        allianz_add_hidden_device_controls_render($settings, 'dots_')
    ]
]);
// Media 
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['gallery_custom_dimension']['width']) ? $settings['gallery_custom_dimension']['width'] : 300,
    'height' => !empty($settings['gallery_custom_dimension']['height']) ? $settings['gallery_custom_dimension']['height'] : 380
];
$img_height = !empty($settings['gallery_custom_dimension']['height']) ? $settings['gallery_custom_dimension']['height'] : 380;
// Wrap
$widget->add_render_attribute('wrap',[
    'class' => array_filter([
        'cms-einstagram',
        'cms-einstagram-'.$settings['layout'],
        'text-'.$default_align,
        'p-tb-160 p-tb-tablet-100',
        'relative'
    ]),
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="heading absolute top-left pt-120 pt-tablet-0"><?php echo esc_html('&copy;'.$settings['user']); ?></div>
    <div class="cms-carousel swiper">
        <div class="swiper-wrapper align-items-center">
            <?php 
                $count = 0;
                foreach ( $randGallery as $key => $value):
                    $count ++ ;
                    if($count%2 === 0){
                        $thumbnail_custom_dimension['height'] = $img_height - 80;
                    } else {
                        $thumbnail_custom_dimension['height'] = $img_height + 80;
                    }
                    $value['gallery_size'] = $settings['gallery_size'];
                    $value['gallery_custom_dimension'] = $thumbnail_custom_dimension;
                    $value['gallery'] = $value;
                    $item_class = "cms-swiper-item swiper-slide hover-content-zoom-in";
                    // Link Attrs
                    $url = !empty($settings['user_link']) ? $settings['user_link'] : wp_get_attachment_image_url($value['id'], 'full');
                    $link_key = $widget->get_repeater_setting_key( 'link_key', 'cms_instagram', $key );
                    $widget->add_render_attribute( $link_key, [
                        'class' => [ 
                            'grid-item-inner relative d-flex align-items-center'
                        ],
                        'title'  => wp_get_attachment_caption($value['id']),
                        'href'   => $url,
                        'target' => '_blank'
                    ] );
                    if(!empty($settings['user'])) {
                        $widget->add_render_attribute( $link_key, [
                            'data-elementor-lightbox-slideshow' => $settings['element_id']
                        ]);
                    }
                ?>
                    <div class="<?php echo esc_attr($item_class); ?>">
                        <a <?php etc_print_html($widget->get_render_attribute_string($link_key)); ?>>
                            <?php 
                                allianz_elementor_image_render($value,[
                                    'name'        => 'gallery',
                                    'img_class'   => 'swiper-nav-vert img-cover',
                                    'custom_size' => $thumbnail_custom_dimension,
                                    'after'       => ''
                                ]);
                            ?>
                            <div class="hover-content--zoom-in cms-overlay">
                                <span class="cms-icon absolute center cmsi-instagram cms-transition text-20 bg-white d-block text-primary text-hover-accent"></span>
                            </div>
                        </a>
                    </div>
                <?php
                endforeach;
            ?>
        </div>
    </div>
    <?php if ($arrows == 'yes') : ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('arrows-prev')); ?>>
            <?php
                allianz_elementor_icon_render($settings['arrow_prev_icon'],['library' => 'cmsi','value'   => 'cmsi-arrow-left'],['aria-hidden' => 'true', 'class' => 'cms-carousel-button-icon rtl-flip', 'icon_size'=> $arrows_icon_size ]);
            ?>
        </div>
        <div <?php etc_print_html($widget->get_render_attribute_string('arrows-next')); ?>>
            <?php
                allianz_elementor_icon_render($settings['arrow_next_icon'],['library' => 'cmsi','value'   => 'cmsi-arrow-right'],['aria-hidden' => 'true', 'class' => 'cms-carousel-button-icon rtl-flip', 'icon_size'=> $arrows_icon_size ]);
            ?>
        </div>
    <?php endif ?>
    <?php if ($dots == 'yes') : 
        if($dots_type == 'custom'){
        ?>
        <div class="thumbs-slider swiper flex-basic flex-smobile-full pt-25">
            <div class="swiper-wrapper cms-carousel-dots-sync-<?php echo esc_attr($settings['element_id']); ?>">
                <?php foreach ($randGallery as $key => $value) { 
                    $value['gallery_size'] = $settings['gallery_size'];
                    $value['gallery_custom_dimension'] = ['width' => 40, 'height' => 40];
                    $value['gallery'] = $value;
                    allianz_elementor_image_render($value,[
                        'name'           => 'gallery',
                        'img_class'      => 'circle',
                        'image_size_key' => 'custom',
                        'custom_size'    => ['width' => 40, 'height' => 40]
                    ]);
                } ?>
            </div>
        </div>
    <?php } else { ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('dots')); ?>></div>
    <?php } 
    endif ; ?>
</div>