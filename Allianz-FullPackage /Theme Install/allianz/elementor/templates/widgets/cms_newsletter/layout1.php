<?php
$default_align = 'start';
$form_id = 'cms-newsletter-'.$settings['element_id'];
// Modal
$widget->add_render_attribute('modal-btn-attrs',[
    'class'            => [
        'btn',
        'btn-'.$widget->get_setting('popup_btn_color', 'primary'),
        'text-'.$widget->get_setting('popup_btn_text_color', 'white'),
        'btn-hover-'.$widget->get_setting('popup_btn_hover_color', 'primary'),
        'text-hover-'.$widget->get_setting('popup_btn_hover_text_color', 'white'),
        'popup-btn',
        'cms-modal',
        'mt-30',
        'cms-hover-move-icon-up'
    ],
    'data-modal'       => '#'.$form_id,
    'data-modal-mode'  => "slide",
    'data-modal-slide' => "up", 
    'data-modal-class' => "center"
]);
// wrap
$widget->add_render_attribute('wrap', [
    'id'    => $form_id,
    'class' => [
        'cms-newsletter',
        'cms-newsletter-'.$settings['layout'],
        allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align','default' => $default_align])
    ]
]);
// Content
$widget->add_render_attribute('content', [
    'class' => [
        'cms-newsletter-content'
    ]
]);
switch ($settings['layout_mode']) {
    case 'popup':
        $widget->add_render_attribute('wrap', [
            'class' => [
                'cms-modal-html'
            ],
            'style'                      => [
                '--cms-modal-width:800px;',
                '--cms-modal-content-width:800px;'
            ]
        ]);
        $widget->add_render_attribute('content', [
            'class' => [
                'cms-modal-content',
                'bg-white'
            ]
        ]);
        break;
    default:
        break;
}
// title 
$widget->add_inline_editing_attributes('title');
$widget->add_render_attribute('title', [
    'class' => [
        'cms-title cms-heading',
        'text-17 empty-none',
        'text-'.$settings['title_color'],
        'pb-25'
    ]
]);
// Desccription
$widget->add_inline_editing_attributes('description');
$widget->add_render_attribute('description', [
    'class' => [
        'cms-desc empty-none',
        'text-14',
        'text-'.$widget->get_setting('desc_color','primary'),
        'pb-25'
    ]
]);
// Form Fields
$show_name = $widget->get_setting('show_name','no');
// Shortcode
$fields = '[newsletter_form button_label="'.$widget->get_setting('button_text',esc_html__('Subscribe','allianz')).'" class="cms-nlf-1 relative"]';
if($show_name == 'yes'){
    $fields .= '[newsletter_field name="first_name" label="" placeholder="'.$widget->get_setting('name_text',esc_html__('Your Name','allianz')).'"]';
}
$fields .= '[newsletter_field name="email" label="" placeholder="'.$widget->get_setting('email_text',esc_html__('Your Email Address','allianz')).'"]';
$fields .= '[/newsletter_form]';
?>
<div class="cms-newsletter-popup">
    <div class="cms-newsletter-popup-text font-700"><?php etc_print_html($settings['popup_title']); ?></div>
    <a <?php etc_print_html($widget->get_render_attribute_string('modal-btn-attrs')); ?>><?php 
        // text
        etc_print_html($settings['popup_btn_text']);
        // icon
        allianz_elementor_button_icon_render();
    ?></a>
</div>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div <?php etc_print_html($widget->get_render_attribute_string('content')); ?>>

        <h2 <?php etc_print_html($widget->get_render_attribute_string('title')); ?>><?php 
            echo nl2br($settings['title']); 
        ?></h2>
        <div <?php etc_print_html($widget->get_render_attribute_string('description')); ?>><?php 
            echo wpautop($settings['description']); 
        ?></div>
        <?php 
            switch ($settings['layout_form']) {
                case 'custom':
                    newsletter_form($settings['form_id']); 
                    break;
                
                default:
                    echo do_shortcode($fields); 
                    break;
            } 
        ?>
    </div>
    </div>