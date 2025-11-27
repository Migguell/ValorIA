<?php
$default_align = 'start';
$testimonials = $widget->get_setting('testimonials', []);
$layout_mode = $widget->get_setting('layout_mode', 'grid');

// Arrows
$arrows = $widget->get_setting('arrows');
$arrows_type = $widget->get_setting('arrows_type', 'icon');
$arrows_icon_size = ($arrows_type === 'icon') ? 45 : 10;
$arrows_icon_class = 'cms-carousel-button cms-carousel-button-hover-circle';
$arrows_icon_prev_class = [
    $arrows_icon_class,
    'cms-carousel-button-prev',
    'text-'.$settings['arrows_color'],
    'text-hover-'.$settings['arrows_hover_color']
];
$widget->add_render_attribute('arrows-prev',[
    'class' => $arrows_icon_prev_class
]);
$arrows_icon_next_class = [
    $arrows_icon_class,
    'cms-carousel-button-next',
    'text-'.$settings['arrows_color'],
    'text-hover-'.$settings['arrows_hover_color']
];
$widget->add_render_attribute('arrows-next',[
    'class' => $arrows_icon_next_class
]);
// Dots
$dots = $widget->get_setting('dots');
$dots_type = $widget->get_setting('dots_type', 'bullets');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 76,
    'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 76
];
// Element Heading
$widget->add_render_attribute('heading-wrap', [
    'class' => array_filter([
        'cms-ettmn-heading',
        'text-'.$widget->get_setting('heading-align', $default_align),
        'pb-60 d-flex'
    ])
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
    'class' => [
        'cms-smallheading',
        'text-'.$widget->get_setting('smallheading_color','accent'),
        'text-16 font-700',
        'pb-10 mt-n7',
        'empty-none'
    ]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-heading empty-none',
        'text-'.$widget->get_setting('heading_color','heading'),
        'lh-1375'
    ]
]);
// Wrap
$widget->add_render_attribute('wrap', [
    'class' => [
        'cms-ettmn',
        'cms-ettmn-'.$widget->get_setting('layout_mode', $layout_mode),
        'cms-ettmn-'.$settings['layout'],
        'text-'.$default_align,
        'relative pr-30'
    ]
]);

if($layout_mode == 'grid'){
    $widget->add_render_attribute('wrap', [
        'class' => [
            'd-flex gutter',
            allianz_elementor_get_grid_columns($widget, $settings)
        ]
    ]);
}
// Description 
$widget->add_render_attribute('description',[
    'class' => [
       'cms-ttmn-desc font-600 text-26 lh-13077',
       'text-'.$widget->get_setting('desc_color','heading'),
       'mt-n7'
    ]
]);
// Author Name
$widget->add_render_attribute('ttmn-author',[
    'class' => [
        'cms-ttmn--name text-17 font-700 empty-none',
        'text-'.$widget->get_setting('author_color', 'heading')
    ]
]);
// Author Position
$widget->add_render_attribute('ttmn-author-pos',[
    'class' => [
        'cms-ttmn--pos text-14',
        'text-'.$widget->get_setting('author_pos_color', 'heading')
    ]
]);
// rated
$widget->add_render_attribute('ttmn-rate',[
    'class' => [
        'cms-star-rate relative',
        'text-'.$widget->get_setting('rate_color', 'accent')
    ]
]);
$widget->add_render_attribute('ttmn--rate',[
    'class' => [
        'cms-star-rated absolute',
        'text-'.$widget->get_setting('rate_color', 'accent')
    ]
]);
// Items
$widget->add_render_attribute('ttmn-item',[
    'class' => [
        'cms-ttmn-item'
    ]
]);
?>
<?php
if(!empty($settings['smallheading_text']) || !empty($settings['heading_text'])) {
?>
<div <?php etc_print_html($widget->get_render_attribute_string('heading-wrap')); ?>>
    <div class="col-6 col-tablet-8 col-mobile-extra-10 col-mobile-12">
        <div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
        <h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
    </div>
</div>
<?php } ?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <span class="absolute top-right text-130 text-grey opacity-01 allianz-icon-quote mt-n40 mr-n40"></span>
    <?php switch ($layout_mode) {
        case 'grid':
            $widget->add_render_attribute('ttmn-item', [
                'class' => 'cms-ttmn-grid-item'
            ]);
            break;
        
        default:
            $widget->add_render_attribute('ttmn-item', [
                'class' => 'cms-carousel-item swiper-slide'
            ]);
    ?>
        <div class="ttmn-carousel d-flex gutter relative z-top">
            <div class="main-ttmn col-6 col-tablet-12 order-last order-tablet-first">
                <div class="cms-carousel swiper">
                    <div class="swiper-wrapper">
    <?php
            break;
    } ?>
    
            <?php foreach ($testimonials as $key => $testimonial) {
                $testimonial['image_size'] = $settings['image_size'];
                $testimonial['image_custom_dimension'] = $thumbnail_custom_dimension;
                $rated = $testimonial['star_rated'];
            ?>
                <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-item')); ?>>
                    <div class="cms-ttmn--item">
                        <div <?php etc_print_html($widget->get_render_attribute_string('description')); ?>><?php 
                            etc_print_html($testimonial['description']); 
                        ?></div>
                        <?php if( $dots!=='yes' || ($dots=='yes' && $dots_type!=='custom') || $settings['layout_mode'] == 'grid'){ ?>
                            <div class="cms-ttmn-info pt-40 d-flex flex-nowrap gap-30 align-items-center pl-8 pb-8">
                                <?php
                                    allianz_elementor_image_render($testimonial,[
                                        'name'           => 'image',
                                        'image_size_key' => 'image',
                                        'img_class'      => 'cms-ttmn--img circle cms-img-stroke2',
                                        'custom_size'    => $thumbnail_custom_dimension,
                                        'before'         => '<div class="cms-ttmn-img flex-auto">',
                                        'after'          => '</div>'
                                    ]);
                                ?>
                                <div class="flex-basic">
                                    <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php echo esc_html($testimonial['name']); ?></div>
                                    <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php echo esc_html($testimonial['position']); ?></div>
                                    <?php if($rated != 0){ ?>
                                        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-rate')); ?>>
                                            <div <?php etc_print_html($widget->get_render_attribute_string('ttmn--rate')); ?> data-width="<?php echo esc_attr($rated);?>" style="width:<?php echo esc_attr($rated.'%');?>"></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
    <?php switch ($layout_mode) {
        case 'grid':
            // code...
            break;
        default:
            // code...
    ?>
                </div>
            </div>
            <div class="cms-carousel-nav-dots d-flex flex-nowrap gap-40 align-items-center mt-50">
                <?php // Arrows
                if ($arrows == 'yes') : ?>
                    <div class="cms-carousel-buttons flex-auto d-flex gap-30">
                        <div <?php etc_print_html($widget->get_render_attribute_string('arrows-prev')); ?>>
                            <?php
                                allianz_elementor_icon_render($settings['arrow_prev_icon'],['library' => 'allianz-icon','value'   => 'allianz-icon-left-arrow'],['aria-hidden' => 'true', 'class' => 'rtl-flip', 'icon_size'=>15]);
                            ?>
                        </div>
                        <div <?php etc_print_html($widget->get_render_attribute_string('arrows-next')); ?>>
                            <?php
                                allianz_elementor_icon_render($settings['arrow_next_icon'],['library' => 'allianz-icon','value'   => 'allianz-icon-right-arrow'],['aria-hidden' => 'true', 'class' => 'rtl-flip', 'icon_size'=>15]);
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($dots == 'yes' && $dots_type !== 'custom'){ ?>
                    <div class="flex-basic">
                        <div class="cms-carousel-dots cms-carousel-dots-<?php echo esc_attr($settings['dots_type']); ?> cms-carousel-dots-primary-regular cms-carousel-dots-active-accent-regular mt-0"></div>
                    </div>
                <?php } ?>
            </div>
        </div> <?php // Close .main-ttmn ?>
        <div class="cms-carousel-dots-html col-6 col-tablet-12">
            <div class="cms-sticky">
            <?php if ($dots == 'yes' && $dots_type == 'custom') { ?>
                <div class="cms-carousel-dots cms-carousel-dots-html mt-0 flex-auto flex-smobile-full">
                    <?php foreach ($testimonials as $key => $testimonial) {
                        $testimonial['image_size'] = $settings['image_size'];
                        $testimonial['image_custom_dimension'] = $thumbnail_custom_dimension;
                        ?>
                            <?php
                                allianz_elementor_image_render($testimonial,[
                                    'name'           => 'image',
                                    'image_size_key' => 'image',
                                    'img_class'      => 'cms-dots-img circle cms-img-stroke2-active',
                                    'custom_size'    => $thumbnail_custom_dimension
                                ]);
                            ?>
                    <?php } ?>
                </div>
                <div class="thumbs-slider swiper mt-35">
                    <div class="swiper-wrapper cms-carousel-dots-sync-<?php echo esc_attr($settings['element_id']); ?>">
                        <?php foreach ($testimonials as $key => $testimonial) {
                            $rated = $testimonial['star_rated'];
                            ?>
                            <div class="swiper-slide">
                                <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php echo esc_html($testimonial['name']); ?></div>
                                <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php echo esc_html($testimonial['position']); ?></div>
                                <?php if($rated != 0){ ?>
                                    <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-rate')); ?>>
                                        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn--rate')); ?> data-width="<?php echo esc_attr($rated);?>" style="width:<?php echo esc_attr($rated.'%');?>"></div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
    </div> <?php // Close .ttmn-carousel ?>
    <?php
            break;
    } ?>
</div>