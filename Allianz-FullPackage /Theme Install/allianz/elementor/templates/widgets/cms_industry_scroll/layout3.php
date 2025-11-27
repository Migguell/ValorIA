<?php
$html_id     = etc_get_element_id($settings);
$tax         = array();
$source      = $widget->get_setting('source', '');
$orderby     = $widget->get_setting('orderby', 'date');
$order       = $widget->get_setting('order', 'desc');
$limit       = $widget->get_setting('limit', 6);
$layout_type = 'grid';
extract(etc_get_posts_of_grid('cms-industry', [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], ['industry-category']));

$thumbnail_size             = $widget->get_setting('thumbnail_size','custom');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['thumbnail_custom_dimension']['width']) ? $settings['thumbnail_custom_dimension']['width'] : 570,
    'height' => !empty($settings['thumbnail_custom_dimension']['height']) ? $settings['thumbnail_custom_dimension']['height'] : 380
];
$pagination_type            = $widget->get_setting('pagination_type', 'pagination');
$num_words                  = $widget->get_setting('num_words', 40);
$readmore_text              = $widget->get_setting('readmore_text', esc_html__('Explore More','allianz'));

$posts_data = array(
    'posttype'                   => 'cms-industry',
    'taxonomy'                   => 'industry-category',
    //
    'startPage'                  => $paged,
    'maxPages'                   => $max,
    'total'                      => $total,
    'perpage'                    => $limit,
    'nextLink'                   => $next_link,
    'pagination_type'            => $pagination_type,
    //
    'layout'                     => $settings['layout'],
    'source'                     => $source,
    'orderby'                    => $orderby,
    'order'                      => $order,
    'limit'                      => $limit,
    'thumbnail_size'             => $thumbnail_size,
    'thumbnail_custom_dimension' => $thumbnail_custom_dimension,
    'num_words'                  => $num_words,
    'readmore_text'              => $readmore_text,
    'item_class'                 => 'hover-image-zoom-in hover-show-excerpt cms-scroll-item cms-transition'
);
// Wrap attributes
$banner_url = allianz_elementor_image_src_render([
    'attachment_id' => $settings['banner']['id'],
    'echo'          => false
]);
$widget->add_render_attribute('wrap',[
    'id'              => $html_id,
    'class'           => [
        'cms-post-grid', 
        'cms-grid', 
        'cms-grid-'.$settings['layout'],
        'cms-horizontal-scroll',
        'h-tablet-extra-100vh',
        'd-flex flex-column justify-content-between'
    ],
    'style' => 'background-image:url('.$banner_url.');'
]);
// Content attributes
$widget->add_render_attribute('content',[
    'class' => [
        'cms-scroll-content',
        'drag-cursor',
        'container',
        'd-flex gutter gutter-10 flex-nowrap flex-tablet-wrap',
        allianz_elementor_get_grid_columns($widget, $settings, [
            'default' => '3',
            'tablet'  => '2' 
        ]),
        'pt-20 pb-40'
    ],
]);
// Heading wrap
$widget->add_render_attribute('heading-wrap1',[
    'class' => [
        'cms-heading-wrap',
        'pb-50',
        'cms-hidden-min-tablet'
    ]
]);
$widget->add_render_attribute('heading-wrap2',[
    'class' => [
        'cms-heading-wrap',
        'col-6 col-tablet-12'
    ]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-heading empty-none',
        'text-22',
        'text-'.$widget->get_setting('heading_color'),
        'pt-35 bdr-t-1'
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('heading-wrap1')); ?>>
    <h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
</div>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="container pb-195 cms-hidden-tablet">
        <div class="d-flex gutter gutter-tablet-0">
            <div class="col-6 col-tablet-12 cms-hidden-tablet"></div>
            <div <?php etc_print_html($widget->get_render_attribute_string('heading-wrap2')); ?>>
                <h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
            </div>
        </div>
    </div>
    <div <?php etc_print_html($widget->get_render_attribute_string('content')); ?>><?php
        allianz_get_post_grid($settings, $posts, $posts_data);
    ?></div>
</div>