<?php 
$randGallery = $widget->get_setting('gallery', []);
if ($settings['gallery_rand'] == 'rand'){
    shuffle($randGallery);
}
$gallery_show = $widget->get_setting('gallery_show', '5');
$gallery_loadmore_show = $widget->get_setting('gallery_loadmore_show', '5');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['gallery_custom_dimension']['width']) ? $settings['gallery_custom_dimension']['width'] : 38,
    'height' => !empty($settings['gallery_custom_dimension']['height']) ? $settings['gallery_custom_dimension']['height'] : 24
];
// Wrap
$widget->add_render_attribute('wrap',[
    'class' => array_filter([
        'cms-egallery',
        'cms-egallery-'.$settings['layout'],
    ]),
    'data-show' => $gallery_show,
    'data-loadmore' => $gallery_loadmore_show
]);
// Inner
$widget->add_render_attribute('inner', [
    'class' => [
        'cms-images-light-box d-flex gap-5',
        allianz_elementor_get_grid_columns($widget, $settings, [
            'default'      => 'auto',
            'smobile'      => 'auto' 
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
            	<?php 
                    allianz_elementor_image_render($value,[
						'name'        => 'gallery',
						'img_class'   => '',
						'custom_size' => $thumbnail_custom_dimension,
					]);
                ?>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <?php if(count($randGallery) > $gallery_show): ?>
        <div class="text-center pt-40">
            <a href="#" class="cms-gallery-load btn"><?php etc_print_html($widget->get_setting('load_more_text', 'Load More')); ?></a>
        </div>
    <?php endif; ?>
</div>