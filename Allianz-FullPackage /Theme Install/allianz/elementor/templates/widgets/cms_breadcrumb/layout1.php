<?php 
// Wrap
$widget->add_render_attribute('wrap',[
    'class' => [
        'cms-ebreadcrumb',
        'cms-breadcrumb',
        'cms-breadcrumb-'.$widget->get_setting('layout','1'),
        'd-flex',
        allianz_elementor_get_alignment_class($widget, $settings, [
            'name'         => 'align',
            'prefix_class' => 'justify-content-'
        ])
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <?php allianz_breadcrumb([
        'icon_home' => ''
    ]); ?>
</div>