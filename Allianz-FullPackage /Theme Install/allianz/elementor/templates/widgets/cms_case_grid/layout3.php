<?php
$html_id     = etc_get_element_id($settings);
$tax         = array();
$source      = $widget->get_setting('source', '');
$orderby     = $widget->get_setting('orderby', 'date');
$order       = $widget->get_setting('order', 'desc');
$limit       = $widget->get_setting('limit', 6);
$layout_type = 'grid';
extract(etc_get_posts_of_grid('cms-case', [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], ['case-category']));

$thumbnail_size             = $widget->get_setting('thumbnail_size','custom');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['thumbnail_custom_dimension']['width']) ? $settings['thumbnail_custom_dimension']['width'] : 570,
    'height' => !empty($settings['thumbnail_custom_dimension']['height']) ? $settings['thumbnail_custom_dimension']['height'] : 380
];
$pagination_type            = $widget->get_setting('pagination_type', 'pagination');
$num_words                  = $widget->get_setting('num_words', 40);
$readmore_text              = $widget->get_setting('readmore_text', esc_html__('Read More','allianz'));

$posts_data = array(
    'posttype'                   => 'cms-case',
    'taxonomy'                   => 'case-category',
    //
    'startPage'                  => $paged,
    'maxPages'                   => $max,
    'total'                      => $total,
    'perpage'                    => $limit,
    'nextLink'                   => $next_link,
    'pagination_type'            => $pagination_type,
    //
    'layout'                     => $widget->get_setting('layout','1'),
    'source'                     => $source,
    'orderby'                    => $orderby,
    'order'                      => $order,
    'limit'                      => $limit,
    'thumbnail_size'             => $thumbnail_size,
    'thumbnail_custom_dimension' => $thumbnail_custom_dimension,
    'num_words'                  => $num_words,
    'readmore_text'              => $readmore_text,
    'item_class'                 => 'hover-image-zoom-in hover-show-excerpt'
);
// Wrap attributes
$widget->add_render_attribute('wrap',[
    'id'              => $html_id,
    'class'           => ['cms-post-grid', 'cms-grid', 'cms-grid-'.$settings['layout']],
    'data-layout'     => $layout_type,
    'data-start-page' => $paged,
    'data-max-pages'  => $max,
    'data-total'      => $total,
    'data-perpage'    => $limit,
    'data-next-link'  => $next_link
]);
// Content attributes
$widget->add_render_attribute('content',[
    'class' => [
        'cms-grid-content',
        'cms-grid-overlay',
        'd-flex gutter',
        allianz_elementor_get_grid_columns($widget, $settings, [
            'default' => '3',
            'tablet'  => '2' 
        ])
    ],
]);
// Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-heading lh-125 empty-none',
        'flex-basic',
        'mb-50 mb-mobile-extra-30'
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
        'cms-link',
        'cms-hover-underline',
        'd-flex align-items-center gap-5',
        'text-accent text-hover-accent',
        'font-700',
        'pb-5'
    ]),
    'href'  => $url
]);

?>
<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php 
    echo nl2br( $settings['heading_text'] ); 
?></h2>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <?php allianz_elementor_filter_render($widget, $settings, [
        'categories' => $categories
    ]); ?>

    <div <?php etc_print_html($widget->get_render_attribute_string('content')); ?>><?php
        allianz_get_post_grid($settings, $posts, $posts_data);
    ?></div>
    <?php if ($pagination_type == 'pagination') { ?>
        <div class="cms-grid-pagination" data-loadmore="<?php echo esc_attr(json_encode($posts_data)); ?>"
             data-query="<?php echo esc_attr(json_encode($args)); ?>"><?php 
                allianz_posts_pagination($query, true); 
        ?></div>
    <?php }
    if (!empty($next_link) && $pagination_type == 'loadmore') { ?>
        <div class="cms-load-more text-center" data-loadmore="<?php echo esc_attr(json_encode($posts_data)); ?>" data-query="<?php echo esc_attr(json_encode($args)); ?>">
            <span class="btn btn-outline text-primary text-hover-accent">
                <?php echo esc_html__('Load More', 'allianz') ?>
            </span>
        </div>
    <?php } 
    if($pagination_type == 'false'){
    ?>
        <div class="cms-grid-pagination d-none" data-loadmore="<?php echo esc_attr(json_encode($posts_data)); ?>"
             data-query="<?php echo esc_attr(json_encode($args)); ?>"><?php 
                allianz_posts_pagination($query, true); 
        ?></div>
    <?php
    }
    ?>
</div>
<?php if(!empty($settings['btn_text'])): ?>
<div class="text-center pt-33">
    <a <?php etc_print_html( $widget->get_render_attribute_string( 'btn_text' ) ); ?>>
        <?php 
            // text
            echo esc_html( $settings['btn_text'] );
        ?>
        <i class="allianz-icon-up-right-arrow text-13 rtl-flip"></i>
    </a>
</div>
<?php endif; ?>