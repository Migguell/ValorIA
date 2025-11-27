<?php 
$randGallery = $widget->get_setting('gallery', []);
if ($settings['gallery_rand'] == 'rand'){
    shuffle($randGallery);
}
$gallery_show = $widget->get_setting('gallery_show', 6);
$gallery_loadmore_show = $widget->get_setting('gallery_loadmore_show', 6);
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['gallery_custom_dimension']['width']) ? $settings['gallery_custom_dimension']['width'] : 400,
    'height' => !empty($settings['gallery_custom_dimension']['height']) ? $settings['gallery_custom_dimension']['height'] : 400
];
// Wrap
$widget->add_render_attribute('wrap',[
    'class' => array_filter([
        'cms-egallery',
        'cms-egallery-'.$widget->get_setting('layout','1'),
    ]),
    'data-show'     => $gallery_show,
    'data-loadmore' => $gallery_loadmore_show
]);
// Inner
$widget->add_render_attribute('inner', [
    'class' => [
        'cms-images-light-box d-flex gutter gutter-mobile-20',
        allianz_elementor_get_grid_columns($widget, $settings, [
            'default' => 3
        ]),
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div <?php etc_print_html($widget->get_render_attribute_string('inner')); ?>>
        <?php
        foreach ( $randGallery as $key => $value):
        	$value['gallery_size'] = $settings['gallery_size'];
        	$value['gallery_custom_dimension'] = $thumbnail_custom_dimension;
        	$value['gallery'] = $value;
            $item_class = "cms-gallery-item";
            ?>
            <div class="<?php echo esc_attr($item_class); ?>">
                <a data-elementor-lightbox-slideshow="<?php echo esc_attr($settings['element_id']);?>" class="grid-item-inner cms-galleries-light-box relative d-flex overflow-hidden" href="<?php echo esc_url(wp_get_attachment_image_url($value['id'], 'full')); ?>" title="<?php echo esc_attr(wp_get_attachment_caption($value['id']))?>">
                	<?php 
                        allianz_elementor_image_render($value,[
							'name'        => 'gallery',
							'img_class'   => 'img-cover',
							'custom_size' => $thumbnail_custom_dimension,
						]);
                    ?>
                    <span class="cms-icon absolute center cmsi-plus cms-transition"></span>
                </a>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <?php if(count($randGallery) > $widget->get_setting('gallery_show', '6')): ?>
        <div class="text-center pt-40">
            <a href="#" class="cms-gallery-load btn btn-lg btn-grey3 btn-hover-accent"><?php etc_print_html($widget->get_setting('load_more_text', 'Load More')); ?></a>
        </div>
    <?php endif; ?>
</div>