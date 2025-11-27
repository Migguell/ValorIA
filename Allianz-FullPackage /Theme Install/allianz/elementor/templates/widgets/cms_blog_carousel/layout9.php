<?php
use Elementor\Icons_Manager;

$settings['num_words'] = !empty($settings['num_words']) ? $settings['num_words'] : 30;
$settings['readmore_text'] = !empty($settings['readmore_text']) ? $settings['readmore_text'] : esc_html__('Read More','allianz');

$html_id  = etc_get_element_id($settings);
$source   = $widget->get_setting('source', '');
$orderby  = $widget->get_setting('orderby', 'date');
$order    = $widget->get_setting('order', 'desc');
$limit    = $widget->get_setting('limit', 6);
extract(etc_get_posts_of_grid( 'post', [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], ['category']));

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
    'posttype'                   => 'post',
    'taxonomy'                   => 'category',

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
        'col-6 col-laptop-8',
        'col-mobile-extra-12'
    ]
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
    'class' => [
        'cms-smallheading empty-none text-16 font-600 pb-20 mt-n7',
        'text-'.$widget->get_setting('smallheading_color','accent'),
    ]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-heading empty-none mt-n7',
        'text-'.$widget->get_setting('heading_color'),
        'lh-1375'
    ]
]);
//Button
$page_link = $widget->get_setting('page_link','');
switch ($settings['link_type']) {
    case 'page':
        $page = !empty($page_link) ? get_page_by_path($page_link, OBJECT) : [];
        $url  = !empty($page) ? get_permalink($page->ID) : '#';
        break;
    
    default:
        $url = $widget->get_setting('link', ['url' => '#'])['url'];
        break;
}
$widget->add_inline_editing_attributes( 'btn_text' );
$widget->add_render_attribute( 'btn_text', [
    'class' => array_filter([
        'flex-auto',
        'cms-link',
        'cms-hover-underline-2 cms-hover-move-icon-up',
        'd-flex align-items-center gap-5',
        'text-primary text-hover-primary',
        'text-15 font-600',
        'pb-5'
    ]),
    'href'  => $url
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="d-flex flex-nowrap flex-tablet-wrap gutter align-items-center justify-content-between pb-50">
        <div <?php etc_print_html($widget->get_render_attribute_string('heading-wrap')); ?>>
            <div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
            <h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
        </div>
        <?php if ($arrows == 'yes') : ?>
        <div class="flex-auto col-mobile-extra-12">
            <div class="cms-carousel-buttons d-flex justify-content-end gap-30">
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
    <?php endif;
    // View all
    if(!empty($settings['btn_text'])): ?>
    <div class="text-center pt-30">
        <a <?php etc_print_html( $widget->get_render_attribute_string( 'btn_text' ) ); ?>>
            <?php 
                // text
                echo esc_html( $settings['btn_text'] );
                // icon
                allianz_elementor_button_icon_render();
            ?>
        </a>
    </div>
    <?php endif; ?>
</div>