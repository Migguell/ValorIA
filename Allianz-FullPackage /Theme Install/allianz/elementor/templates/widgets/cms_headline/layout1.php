<?php
$headlines = $widget->get_setting('headlines', []);
if(empty($headlines)) return;

// Arrows
$arrows = $widget->get_setting('arrows');
$arrows_type = $widget->get_setting('arrows_type', 'icon');
$arrows_icon_size = ($arrows_type === 'icon') ? 12 : 12; 
$arrows_classes = [
    'cms-carousel-button in',
    'arrow-'.$arrows_type,
    'hover',
    allianz_add_hidden_device_controls_render($settings, 'arrows_')
];
if($arrows_type == 'button'){
   $arrows_classes[] = 'bg-black-1 bg-hover-black-1'; 
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

// attribute
$widget->add_render_attribute('wrap', [
    'class' => [
        'cms-headlines',
        'cms-headlines-'.$settings['layout']
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="cms-carousel swiper">
        <div class="swiper-wrapper">
            <?php
            foreach ($headlines as $key => $headline) {
                $item_key = $widget->get_repeater_setting_key( 'link', 'cms_headline_item_key', $key );
                $widget->add_render_attribute( $item_key,[
                    'class' => [
                        'swiper-slide',
                        'headline-item',
                        'text-'.$widget->get_setting('color', 'body'),
                        'text-hover-'.$widget->get_setting('color_hover', 'accent')
                    ]
                ]);
                ?>
                <div <?php etc_print_html($widget->get_render_attribute_string( $item_key )); ?>><?php
                    echo esc_html($headline['text']);
                ?></div>
            <?php } ?>
        </div>
    </div>
    <?php if ($arrows == 'yes') : ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('arrows-prev')); ?>>
            <?php
                allianz_elementor_icon_render($settings['arrow_prev_icon'],['library' => 'cmsi','value' => 'cmsi-chevron-left'],['aria-hidden' => 'true', 'class' => 'cms-carousel-button-icon rtl-flip', 'icon_size'=> $arrows_icon_size ]);
                // hover
                allianz_elementor_icon_render($settings['arrow_prev_icon_hover'],[],['aria-hidden' => 'true', 'class' => 'cms-carousel-button-icon hover rtl-flip', 'icon_size'=> $arrows_icon_size ]);
            ?>
        </div>
        <div <?php etc_print_html($widget->get_render_attribute_string('arrows-next')); ?>>
            <?php
                allianz_elementor_icon_render($settings['arrow_next_icon'],['library' => 'cmsi','value' => 'cmsi-chevron-right'],['aria-hidden' => 'true', 'class' => 'cms-carousel-button-icon rtl-flip', 'icon_size'=> $arrows_icon_size ]);
                // hover
                allianz_elementor_icon_render($settings['arrow_next_icon_hover'],[],['aria-hidden' => 'true', 'class' => 'cms-carousel-button-icon hover rtl-flip', 'icon_size'=> $arrows_icon_size ]);
            ?>
        </div>
    <?php endif; ?>
    <?php if ($dots == 'yes') : ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('dots')); ?>></div>
    <?php endif ?>
</div>