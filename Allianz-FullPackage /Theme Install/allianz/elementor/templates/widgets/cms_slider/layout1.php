<?php
$default_align  = $widget->get_setting('content_align', 'start');
$cms_slides     = $widget->get_setting('cms_slides', []);
$arrows         = $widget->get_setting('arrows','');
$dots           = $widget->get_setting('dots','');
$autoplay_speed = $widget->get_setting('autoplay_speed',5000);
$divider_speed  = $widget->get_setting('autoplay_speed',5000)-300;
// Dots
$widget->add_render_attribute('dots', [
    'class' => [
        'cms-carousel-dots',
        'cms-carousel-dots-'.$settings['dots_type'],
        'cms-carousel-dots-in',
        'justify-content-center',
        'text-white',
        'cms-carousel-dots-white',
        'cms-carousel-dots-active-white'
    ]
]);
// Wrapper
$widget->add_render_attribute('wrap', [
    'class' => [
        'cms-eslider',
        'cms-eslider-'.$settings['layout'],
        'cms-eslider-xxx'.$settings['layout'],
        'cms-carousel', 'swiper'
    ]
]);
// Container
$widget->add_render_attribute('container', [
    'class' => [
        'container',
        'd-flex',
        'justify-content-'.$default_align,
        'text-'.$default_align
    ]
]);
// Description
$cms_slider_desc_classes = [
    'cms-slider-desc empty-none',
    allianz_add_hidden_device_controls_render($settings, 'desc_'),
    'text-15',
    'pt-125 pt-laptop-50 pt-tablet-15'
];
if($default_align === 'center'){
    $cms_slider_desc_classes[] = 'm-lr-auto';
}
// Buttons
$widget->add_render_attribute('buttons', [
    'class' => [
        'cms-slider-buttons d-flex align-items-center gap-30',
        'justify-content-'.$default_align,
        'pt-30',
        'empty-none'
    ]
]);

?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')) ?>>
    <div class="swiper-wrapper">
        <?php foreach ($cms_slides as $key => $cms_slide) { ?>
            <div class="cms-slider-item swiper-slide relative ">
                <?php if(empty($settings['overlay_image']['id'])): ?>
                    <span class="cms-shadow-multi absolute top-right z-top"></span>
                <?php endif; ?>
                <?php 
                    $cms_slide['lazy']       = false;
                    $cms_slide['image_size'] = 'full';
                    // image/video
                    switch($cms_slide['slide_type']){
                        case 'video':
                            // video
                            allianz_elementor_video_render($widget, $settings, ['url' => $cms_slide['video_url'], 'loop' => true, 'loop_key' => $key]);
                            break;
                        case 'img':
                            // image
                            allianz_elementor_image_render($cms_slide, [
                                'img_class' => 'cms-slider-img cms-slider-img-effect img-cover',
                                'duration'  => $autoplay_speed
                            ]);
                            break;
                    }
                    // Sub Title
                    $sub_title_key = $widget->get_repeater_setting_key('sub-title-key', 'cms_slider', $key);
                    $widget->add_render_attribute($sub_title_key, [
                        'class' => [
                            'cms-slider-subtitle text-line-2 mt-n8 empty-none',
                            'text-16 font-600 pb-20',
                            allianz_add_hidden_device_controls_render($settings, 'subtitle_')
                        ],
                        'data-cms-animation'       => 'subtitle_animation',
                        'data-cms-animation-delay' => 'subtitle_animation_delay'
                    ]);
                    // Title
                    $title_key = $widget->get_repeater_setting_key('title-key', 'cms_slider', $key);
                    $widget->add_render_attribute($title_key, [
                        'class' => [
                            'cms-slider-title heading text-white mt-n10 empty-none text-55 text-tablet-40 text-mobile-30',
                            allianz_add_hidden_device_controls_render($settings, 'title_')
                        ],
                        'data-cms-animation'       => 'title_animation',
                        'data-cms-animation-delay' => 'title_animation_delay'
                    ]);
                    // description_title
                    $desc_title_key = $widget->get_repeater_setting_key('desc-title-key', 'cms_slider', $key);
                    $widget->add_render_attribute($desc_title_key, [
                        'class' => [
                            'cms-slider-desc-title text-18 font-600',
                            'empty-none',
                            'relative',
                            'mb-20'
                        ]
                    ]);
                    // Description
                    $desc_key = $widget->get_repeater_setting_key('desc-key', 'cms_slider', $key);
                    $widget->add_render_attribute($desc_key, [
                        'class' => $cms_slider_desc_classes,
                        //'data-cms-animation'       => 'description_animation',
                        //'data-cms-animation-delay' => 'description_animation_delay'
                    ]);
                    $desc_key_text = $widget->get_repeater_setting_key('desc-key-text', 'cms_slider', $key);
                    $widget->add_render_attribute($desc_key_text, [
                        'class'                    => 'flex-basic text-line-2',
                        'data-cms-animation'       => 'description_animation',
                        'data-cms-animation-delay' => 'description_animation_delay'
                    ]);
                    // Primary Button
                    switch ($cms_slide['button_primary_type']) {
                        case 'page':
                            $button_primary_page = !empty($cms_slide['button_primary_page_link']) ? get_page_by_path($cms_slide['button_primary_page_link'], OBJECT) : [];
                            $button_primary_url  = !empty($button_primary_page) ? get_permalink($button_primary_page->ID) : '#';
                            break;
                        default:
                            $button_primary_url = $cms_slide['button_primary_link']['url'];
                            break;
                    }
                    $primary_btn_key = $widget->get_repeater_setting_key('primary-btn', 'cms_slider', $key);
                    $widget->add_render_attribute($primary_btn_key, [
                        'class' => [
                            'cms-slider-btn',
                            'mt-n75 ml-n30 ml-laptop-n0',
                            'cms-link-circle',
                            'text-white text-hover-white text-40',
                            'cms-hover-move-icon-up',
                            'd-flex align-items-center justify-content-center',
                            allianz_add_hidden_device_controls_render($settings, 'btn1_'),
                            'qodef-button qodef-layout--circle'
                        ],
                        'href'                     => $button_primary_url,
                        'data-title'               => $cms_slide['button_primary'],
                        'data-cms-animation'       => 'button_primary_animation',
                        'data-cms-animation-delay' => 'button_primary_animation_delay'
                    ]);
                    // Secondary Button
                    switch ($cms_slide['button_secondary_type']) {
                        case 'page':
                            $button_secondary_page = !empty($cms_slide['button_secondary_page_link']) ? get_page_by_path($cms_slide['button_secondary_page_link'], OBJECT) : [];
                            $button_secondary_url  = !empty($button_secondary_page) ? get_permalink($button_secondary_page->ID) : '#';
                            break;
                        default:
                            $button_secondary_url = $cms_slide['button_secondary_link']['url'];
                            break;
                    }
                    $secondary_btn_key = $widget->get_repeater_setting_key('secondary-btn', 'cms_slider', $key);
                    $widget->add_render_attribute($secondary_btn_key, [
                        'class' => [
                            'cms-slider-btn',
                            'btn btn-white text-hover-primary',
                            allianz_add_hidden_device_controls_render($settings, 'btn2_')
                        ],
                        'href'                     => $button_secondary_url,
                        'data-cms-animation'       => 'button_secondary_animation',
                        'data-cms-animation-delay' => 'button_secondary_animation_delay'
                    ]);
                ?>
                <div class="cms-slider-content cms-overlay d-flex align-items-center">
                    <div <?php etc_print_html($widget->get_render_attribute_string('container')); ?>>
                        <div class="cms-slider--content">
                            <div <?php etc_print_html($widget->get_render_attribute_string($sub_title_key)); ?>><?php etc_print_html($cms_slide['subtitle']); ?></div>
                            <h2 <?php etc_print_html($widget->get_render_attribute_string($title_key)); ?>><?php echo nl2br($cms_slide['title']); ?></h2>
                            <div <?php etc_print_html($widget->get_render_attribute_string('buttons')); ?>><?php
                            // Primary Button
                            if ( ! empty( $cms_slide['button_primary'] ) ) :   
                            ?>
                                <div class="cms-hover-move">
                                    <a <?php etc_print_html($widget->get_render_attribute_string($primary_btn_key)); ?>>
                                        <?php allianz_elementor_svg_hover_icon_render([
                                            'class' => 'rtl-flip'
                                        ]); ?>
                                    </a>
                                </div>
                            <?php endif;
                            // Secondary Button
                                if ( ! empty( $cms_slide['button_secondary'] ) ) :
                            ?>
                                <a <?php etc_print_html($widget->get_render_attribute_string($secondary_btn_key)); ?>>
                                    <?php 
                                    // text 
                                    etc_print_html( $cms_slide['button_secondary'] ); 
                                    // icon
                                    allianz_elementor_button_icon_render();
                                    ?>
                                </a>
                            <?php endif; 
                                // Video button
                                allianz_elementor_button_video_render($widget, $cms_slide, [
                                    'name'       => 'video_link',
                                    'icon_class' => 'cms-transition',
                                    'text'       => $cms_slide['video_text'],
                                    'layout'     => '1 btn btn-accent btn-hover-primary text-white text-hover-white gap-10',
                                    'class'      => allianz_add_hidden_device_controls_render($settings, 'btn_video_'),
                                    'echo'       => true,
                                    'loop'       => true,
                                    'loop_key'   => $key, 
                                    'attrs'      => [
                                        'data-cms-animation'       => 'button_video_animation',
                                        'data-cms-animation-delay' => 'button_video_animation_delay'
                                    ]
                                ]);
                            ?></div>
                            <div <?php etc_print_html($widget->get_render_attribute_string($desc_key)); ?>>
                                <div <?php etc_print_html($widget->get_render_attribute_string($desc_title_key)); ?>>
                                    <span class="cms-slider-desc--title pb-10 relative d-inline-block"><?php 
                                        etc_print_html($cms_slide['description_title']);
                                    ?></span>
                                    <span class="divider" style="--cms-divider-time:<?php etc_print_html($divider_speed); ?>ms"></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div <?php etc_print_html($widget->get_render_attribute_string($desc_key_text)); ?>><?php etc_print_html($cms_slide['description']); ?></div>
                                    <?php if ($arrows == 'yes') : ?>
                                    <div class="flex-auto d-flex gap-30 align-items-center">
                                        <div class="cms-carousel-button-hover-circle cms-carousel-button-prev white">
                                            <i class="allianz-icon-left-arrow rtl-flip"></i>
                                        </div>
                                        <div class="cms-carousel-button-hover-circle cms-carousel-button-next white">
                                            <i class="allianz-icon-right-arrow rtl-flip"></i>
                                        </div>
                                    </div>
                                    <?php endif ?>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php if ($dots == 'yes') : ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('dots')); ?>></div>
    <?php endif ?>
</div>