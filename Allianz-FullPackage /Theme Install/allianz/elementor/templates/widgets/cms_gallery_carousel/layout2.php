<?php 
$randGallery = $widget->get_setting('gallery', []);
if(empty($randGallery)) return;

$thumbnail_custom_dimension = [
    'width'  => !empty($settings['gallery_custom_dimension']['width']) ? $settings['gallery_custom_dimension']['width'] : 400,
    'height' => !empty($settings['gallery_custom_dimension']['height']) ? $settings['gallery_custom_dimension']['height'] : 400
];

$arrows = $widget->get_setting('arrows');
$dots   = $widget->get_setting('dots');
// Wrap
$widget->add_render_attribute('wrap',[
    'class' => array_filter([
        'cms-carousel swiper',
        'cms-egallery',
        'cms-egallery-'.$widget->get_setting('layout','1'),
    ]),
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="swiper-wrapper">
        <?php 
            foreach ( $randGallery as $key => $value):
                $value['gallery_size'] = $settings['gallery_size'];
                $value['gallery_custom_dimension'] = $thumbnail_custom_dimension;
                $value['gallery'] = $value;
                $item_class = "cms-swiper-item swiper-slide";
            ?>
                <div class="<?php echo esc_attr($item_class); ?>">
                    <a data-elementor-lightbox-slideshow="<?php echo esc_attr($settings['element_id']);?>" class="grid-item-inner cms-galleries-light-box relative d-flex cms-gradient-hover-8" href="<?php echo esc_url(wp_get_attachment_image_url($value['id'], 'full')); ?>" title="<?php echo esc_attr(wp_get_attachment_caption($value['id']))?>">
                        <div class="cms-gradient-render"></div>
                        <?php 
                            allianz_elementor_image_render($value,[
                                'name'        => 'gallery',
                                'img_class'   => 'swiper-nav-vert img-cover',
                                'custom_size' => $thumbnail_custom_dimension,
                                'max_height'  => true  
                            ]);
                        ?>
                        <span class="cms-icon absolute center cmsi-plus cms-transition circle"></span>
                    </a>
                </div>
            <?php
            endforeach;
        ?>
    </div>
    <?php if ($arrows == 'yes') : ?>
    <div class="cms-carousel-button cms-carousel-button-prev prev in text-45 lh-1 text-white text-hover-accent pl-50 pl-tablet-20">
        <?php
            allianz_elementor_icon_render($settings['arrow_prev_icon'],['library' => 'cmsi','value'   => 'cmsi-arrow-prev'],['aria-hidden' => 'true', 'class' => 'rtl-flip', 'icon_size'=>45]);
        ?>
    </div>
    <div class="cms-carousel-button cms-carousel-button-next next in text-45 lh-1 text-white text-hover-accent pr-50 pr-tablet-20">
        <?php
            allianz_elementor_icon_render($settings['arrow_next_icon'],['library' => 'cmsi','value'   => 'cmsi-arrow-next'],['aria-hidden' => 'true', 'class' => 'rtl-flip', 'icon_size'=>45]);
        ?>
    </div>
    <?php endif ?>
    <?php if ($dots == 'yes') : ?>
        <div class="cms-carousel-dots cms-carousel-dots-primary-regular cms-carousel-dots-active-accent-regular cms-carousel-dots-<?php echo esc_attr($settings['dots_type']) ?> justify-content-center"></div>
    <?php endif ?>
</div>