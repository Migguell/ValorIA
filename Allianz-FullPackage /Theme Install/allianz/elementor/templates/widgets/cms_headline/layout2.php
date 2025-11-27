<?php
$headlines = $widget->get_setting('headlines', []);
if(empty($headlines)) return;
$headlines_item = [];
$headlines_item_separator = '';

if($settings['col_separator'] === 'yes');
$headlines_item_separator = '<div class="col-separator"></div>';
// attribute
$widget->add_render_attribute('wrap', [
    'class' => [
        'cms-headlines',
        'cms-headlines-'.$settings['layout'],
        'd-flex gutter-30',
        'justify-content-center align-items-center',
        allianz_elementor_get_grid_columns($widget, $settings, ['default' => 4])
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <?php
    foreach ($headlines as $key => $headline) {
        $item_key = $widget->get_repeater_setting_key( 'link', 'cms_headline_item_key', $key );
        $widget->add_render_attribute( $item_key,[
            'class' => [
                'headline-item',
                'text-'.$widget->get_setting('color', 'body'),
                'text-hover-'.$widget->get_setting('color_hover', 'accent')
            ]
        ]);
        ob_start();
        ?>
        <div <?php etc_print_html($widget->get_render_attribute_string( $item_key )); ?>><?php
            echo esc_html($headline['text']);
        ?></div>
    <?php 
        $headlines_item[] = ob_get_clean(); 
    } 
        echo implode( $headlines_item_separator, $headlines_item);
    ?>
</div>