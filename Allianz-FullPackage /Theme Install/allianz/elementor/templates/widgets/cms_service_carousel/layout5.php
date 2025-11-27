<?php
use Elementor\Icons_Manager;

$settings['num_words'] = !empty($settings['num_words']) ? $settings['num_words'] : 30;
$settings['readmore_text'] = !empty($settings['readmore_text']) ? $settings['readmore_text'] : esc_html__('Read More','allianz');

$html_id  = etc_get_element_id($settings);
$source   = $widget->get_setting('source', '');
$orderby  = $widget->get_setting('orderby', 'date');
$order    = $widget->get_setting('order', 'desc');
$limit    = $widget->get_setting('limit', 6);
extract(etc_get_posts_of_grid( 'cms-service', [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], ['service-category']));

$arrows = $widget->get_setting('arrows');
$dots   = $widget->get_setting('dots');

$title_tag = $widget->get_setting('title_tag', 'h3');

$thumbnail_size             = $widget->get_setting('thumbnail_size', 'custom');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['thumbnail_custom_dimension']['width']) ? $settings['thumbnail_custom_dimension']['width'] : 570,
    'height' => !empty($settings['thumbnail_custom_dimension']['height']) ? $settings['thumbnail_custom_dimension']['height']: 380
];
$num_words                  = $widget->get_setting('num_words', 40);
$readmore_text              = $widget->get_setting('readmore_text', esc_html__('Read More','allianz'));

$posts_data = array(
    'posttype'                   => 'cms-service',
    'taxonomy'                   => 'service-category',

    'layout'                     => $settings['layout'],
    'source'                     => $source,
    'orderby'                    => $orderby,
    'order'                      => $order,
    'limit'                      => $limit,
    'thumbnail_size'             => $thumbnail_size,
    'thumbnail_custom_dimension' => $thumbnail_custom_dimension,
    'num_words'                  => $num_words,
    'readmore_text'              => $readmore_text,
    'item_class'                 => 'cms-swiper-item swiper-slide relative cms-hover-icon-bounce'
);
// Wrap attributes
$widget->add_render_attribute('wrap',[
    'id'              => $html_id,
    'class'           => ['cms-post-carousel', 'cms-grid', 'cms-grid-'.$settings['layout']],
]);
// Heading wrap
$widget->add_render_attribute('heading-wrap',[
    'class' => [
        'cms-heading-wrap',
        'col-6 col-tablet-extra-8',
        'col-mobile-10',
        'col-smobile-12'
    ]
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
    'class' => [
        'cms-smallheading empty-none text-16 font-600 pb-25 mt-n7',
        'text-'.$widget->get_setting('smallheading_color','accent'),
    ]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-heading empty-none mt-n7 lh-1375',
        'text-'.$widget->get_setting('heading_color'),
    ]
]);
// Carousel buttons
$widget->add_render_attribute('cms-carousel-buttons', [
    'class' => [
        'cms-carousel-buttons',
        'col-6 col-tablet-extra-4',
        'col-mobile-2 col-smobile-12',
        'd-flex justify-content-end gap-30'
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="d-flex gutter align-items-end justify-content-between pb-50">
        <div <?php etc_print_html($widget->get_render_attribute_string('heading-wrap')); ?>>
            <div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
            <h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
        </div>
        <?php if ($arrows == 'yes') : ?>
            <div class="cms-carousel-buttons flex-auto d-flex justify-content-end gap-30">
                <div class="cms-carousel-button-hover-circle cms-carousel-button-prev ">
                    <?php
                        allianz_elementor_icon_render($settings['arrow_prev_icon'],['library' => 'allianz-icon','value'   => 'allianz-icon-left-arrow'],['aria-hidden' => 'true', 'class' => 'rtl-flip', 'icon_size'=>15]);
                    ?>
                </div>
                <div class="cms-carousel-button-hover-circle cms-carousel-button-next">
                    <?php
                        allianz_elementor_icon_render($settings['arrow_next_icon'],['library' => 'allianz-icon','value'   => 'allianz-icon-right-arrow'],['aria-hidden' => 'true', 'class' => 'rtl-flip', 'icon_size'=>15]);
                    ?>
                </div>
            </div>
        <?php  endif; ?>
    </div>
    <div class="cms-carousel swiper">
        <div class="swiper-wrapper">
            <?php
                allianz_get_post_grid($settings, $posts, $posts_data);
            ?>
        </div>
    </div>
    <?php
        if ($dots == 'yes') : ?>
        <div class="cms-carousel-dots cms-carousel-dots-<?php echo esc_attr($settings['dots_type']); ?> justify-content-center"></div>
    <?php endif ?>
</div>