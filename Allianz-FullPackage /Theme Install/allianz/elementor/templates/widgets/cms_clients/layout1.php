<?php
$default_align = 'center';
$clients = $widget->get_setting('clients', []);
if(empty($clients)) return;
// Arrows
$arrows = $widget->get_setting('arrows');
$arrows_type = $widget->get_setting('arrows_type', 'button');
$arrows_icon_size = ($arrows_type === 'icon') ? 45 : 10;
$arrows_classes = [
    'cms-carousel-button in',
    'arrow-'.$arrows_type,
    allianz_add_hidden_device_controls_render($settings, 'arrows_')
];
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
    'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 150,
    'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 60
];
// attribute
$widget->add_render_attribute('wrap', [
    'class' => [
        'cms-clients',
        'cms-clients-'.$settings['layout'],
        'relative'
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="cms-carousel swiper relative">
        <div class="swiper-wrapper">
            <?php
            foreach ($clients as $key => $client) {
                $client['image_size'] = $settings['image_size'];
                $client['image_custom_dimension'] = $thumbnail_custom_dimension;
                $client['link']['custom_attributes'] .= ',class|client-item swiper-slide';
                $client['link']['custom_attributes'] .= ',title|'.$client['name'];

                $link_key = $widget->get_repeater_setting_key( 'link', 'cms_client_link', $key );
                $widget->add_link_attributes( $link_key, $client['link'] );
                ?>
                <a <?php etc_print_html($widget->get_render_attribute_string( $link_key )); ?>><?php
                    allianz_elementor_image_render($client,[
                        'name'           => 'image',
                        'image_size_key' => 'image',
                        'img_class'      => 'swiper-nav-vert',
                        'custom_size'    => $thumbnail_custom_dimension,
                        'before'         => '',
                        'after'          => ''
                    ]);
                ?></a>
            <?php } ?>
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
                <?php foreach ($testimonials as $key => $testimonial) { 
                    $rated = $testimonial['star_rated'];
                    ?>
                    <div class="swiper-slide">
                        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-name')); ?>>
                            <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php echo esc_html($testimonial['name']); ?></div>
                            <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php echo esc_html($testimonial['position']); ?></div>
                        </div>
                        <?php if($rated != 0){ ?>
                            <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-rate')); ?>>
                                <div <?php etc_print_html($widget->get_render_attribute_string('ttmn--rate')); ?> data-width="<?php echo esc_attr($rated);?>" style="width:<?php echo esc_attr($rated.'%');?>"></div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('dots')); ?>></div>
    <?php } 
    endif; ?>
</div>