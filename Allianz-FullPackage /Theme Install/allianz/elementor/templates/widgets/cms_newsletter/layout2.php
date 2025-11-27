<?php
$default_align = 'center';
    // wrap
    $widget->add_render_attribute('wrap', [
        'class' => [
            'cms-newsletter',
            'cms-newsletter-'.$widget->get_setting('layout','2'),
            allianz_elementor_get_alignment_class($widget, $settings, ['name' => 'align','default' => $default_align]),
            'bg-'.$widget->get_setting('bg_color','white')
        ]
    ]);
    // title 
    $widget->add_inline_editing_attributes('title');
    $widget->add_render_attribute('title', [
        'class' => [
            'cms-title cms-heading',
            'empty-none',
            'text-'.$settings['title_color'],
            'mb-n3',
            'text-55 text-tablet-40 text-mobile-30'
        ]
    ]);
    // Desccription
    $widget->add_inline_editing_attributes('description');
    $widget->add_render_attribute('description', [
        'class' => [
            'cms-desc empty-none',
            'text-17',
            'text-'.$settings['desc_color']
        ]
    ]);
    // Privacy Policy
    $widget->add_render_attribute('privacy_policy_text_wrap', [
        'class' => [
            'cms-pp empty-none',
            'text-14',
            'text-grey',
            'pt-15'
        ]
    ]);
    // text
    $widget->add_inline_editing_attributes('privacy_policy_text');
    $widget->add_render_attribute('privacy_policy_text',[
        'class' => 'pp-text'
    ]);
    // link
    $page_link = $widget->get_setting('privacy_policy_page','');
    $page = !empty($page_link) ? get_page_by_path($page_link, OBJECT) : [];
    $url  = !empty($page) ? get_permalink($page->ID) : '#';
    $widget->add_render_attribute( 'privacy_policy_link_text', [
        'class' =>[
            'pp-link'
        ],
        'href'  => $url
    ]);

    // Form Fields
    $show_name = $widget->get_setting('show_name','no');
    // Shortcode
    $fields = '[newsletter_form button_label="'.$widget->get_setting('button_text',esc_html__('Subscribe','allianz')).'" class="cms-nlf-2 relative"]';
    if($show_name == 'yes'){
        $fields .= '[newsletter_field name="first_name" label="" placeholder="'.$widget->get_setting('name_text',esc_html__('Your Name','allianz')).'"]';
    }
    $fields .= '[newsletter_field name="email" label="" placeholder="'.$widget->get_setting('email_text',esc_html__('Your Email Address','allianz')).'"]';
    $fields .= '[/newsletter_form]';
    
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="cms--newsletter">
        <h2 <?php etc_print_html($widget->get_render_attribute_string('title')); ?>><?php 
            echo nl2br($settings['title']); 
        ?></h2>
        <div <?php etc_print_html($widget->get_render_attribute_string('description')); ?>><?php 
            echo wpautop($settings['description']); 
        ?></div>
        <div class="pt-30"><?php 
            switch ($settings['layout_form']) {
                case 'custom':
                    newsletter_form($settings['form_id']); 
                    break;
                
                default:
                    echo do_shortcode($fields); 
                    break;
            }
        ?></div>
        <div <?php etc_print_html($widget->get_render_attribute_string('privacy_policy_text_wrap')); ?>>
            <span <?php etc_print_html($widget->get_render_attribute_string('privacy_policy_text')); ?>><?php 
                // text
                etc_print_html($settings['privacy_policy_text']).'&nbsp;';
            ?></span>
            <?php 
                // link
                etc_print_html(
                    '<a '.$widget->get_render_attribute_string('privacy_policy_link_text').'>'.$widget->get_setting('privacy_policy_link_text', get_the_title($page->ID)).'</a>'
                );
            ?>
        </div>
    </div>
</div>