<?php
// Sources
$source    = $widget->get_setting('source',[]);
$orderby   = $widget->get_setting('orderby','date');
$order     = $widget->get_setting('order','desc');
$limit     = $widget->get_setting('limit', 5);

$tax = [];
foreach ($source as $category){
    $category_arr = explode('|', $category);
    $tax[] = $category_arr[0];
}
// Main Post Query
$main_posts = etc_get_posts_of_grid('post', [
    'post_type'                  => 'post',   
    'source'                     => $source,
    'orderby'                    => $orderby,
    'order'                      => $order,
    'limit'                      => '1',
    'tax'                        => $tax
]);
// Second Post Query
$second_posts = etc_get_posts_of_grid('post', 
    [
        'post_type' => 'post',   
        'source'    => $source,
        'orderby'   => $orderby,
        'order'     => $order,
        'limit'     => $limit - 1,
        'tax'       => $tax
    ], 
    [] , 
    [
        'offset'    => 1
    ]
);
// Wrap
$widget->add_render_attribute('wrap', [
    'class' => [
        'cms-eblog cms-eblog-'.$settings['layout'],
        'd-flex'
    ]
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
        'cms-hover-move-icon-up',
        'd-flex align-items-center gap-5',
        'text-accent text-hover-accent',
        'text-15 font-700',
        'pb-5'
    ]),
    'href'  => $url
]);
?>

<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php 
    echo nl2br( $settings['heading_text'] ); 
?></h2>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="cms-main-posts col-6 col-mobile-extra-12 p-tb-40 pr-mobile-extra-20 pr-40 pr-mobile-extra-0 hover-image-zoom-out">
        <div class="cms-sticky">
            <?php // Content
            foreach ($main_posts['posts'] as $post):
                allianz_elementor_post_thumbnail_render($settings, [
                    'post_id'       => $post->ID,
                    'custom_size'   => ['width' => 600, 'height' => 289],
                    'img_class'     => 'img-cover',
                    'as_background' => false,
                    'max_height'    => true,
                    'before'        => '<div class="cms-main-img relative overflow-hidden">',
                    'after'         => '<a href="'.esc_url(get_permalink( $post->ID )).'" class="cms-btn-readmore absolute bottom-right z-top"><span class="cms-btn-icon allianz-icon-up-right-arrow"></span><span class="cms-btn-text cms-transition end d-flex gap-5">'.esc_html__('Read More','allianz').'<span class="allianz-icon-up-right-arrow text-12"></span></span></a></div>'
                ]);
            ?>
                <div class="cms--content bg-white pt-25 pl-40 pl-smobile-20">
                    <div class="cms-post-meta d-flex gap-10 align-items-center text-13"><?php 
                        allianz_the_terms($post->ID, 'category', '<span class="separator small"></span>', 'text-primary text-hover-primary cms-hover-underline');
                    ?></div>
                    <h3 class="cms-heading pt-7 text-line-2 lh-1-308 font-body font-600 ls-03">
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a>
                    </h3>
                    <div class="post-date text-14 pt-17"><?php echo get_the_date('', $post->ID); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="cms-second-posts col-6 col-mobile-extra-12 p-tb-40 bdr-l-1">
        <?php // Content
            foreach ($second_posts['posts'] as $post):
        ?>
                <div class="cms-content d-flex gap-40 gap-tablet-10 gap-mobile-extra-40 gap-smobile-10 align-items-center hover-image-zoom-out pl-40 pl-mobile-extra-20">
                    <?php 
                        allianz_elementor_post_thumbnail_render($settings, [
                            'post_id'       => $post->ID,
                            'custom_size'   => ['width' => 270, 'height' => 180],
                            'img_class'     => 'img-cover',
                            'max_height'    => true,    
                            'before'        => '<div class="flex-auto flex-smobile-full overflow-hidden">',
                            'after'         => '</div>'
                        ]);
                    ?>
                    <div class="flex-basic flex-tablet-full flex-mobile-extra-basic flex-smobile-full">
                        <div class="cms-post-meta d-flex gap-10 align-items-center text-13 pb-10"><?php 
                            allianz_the_terms($post->ID, 'category', '<span class="separator small"></span>', 'text-primary text-hover-primary cms-hover-underline');
                        ?></div>
                        <h5 class="cms-heading text-20 text-line-3 lh-13 font-body font-600 ls-03">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a>
                        </h5>
                        <div class="post-date text-meta text-14 pt-10"><?php echo get_the_date('', $post->ID); ?></div>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
</div>
<?php if(!empty($settings['btn_text'])): ?>
<div class="text-center pt-33">
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