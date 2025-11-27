<?php
    // wrap
    $widget->add_render_attribute('wrap', [
        'class' => [
            'cms-newsletter',
            'cms-newsletter-'.$widget->get_setting('layout'),
            'd-flex gutter align-items-center'
        ]
    ]);
    // small title 
    $widget->add_inline_editing_attributes('small_title');
    $widget->add_render_attribute('small_title', [
        'class' => [
            'cms-smalltitle',
            'empty-none',
            'text-15 text-'.$widget->get_setting('small_title_color','primary'),
            'text-uppercase ls-06'
        ]
    ]);
    // title 
    $widget->add_inline_editing_attributes('title');
    $widget->add_render_attribute('title', [
        'class' => [
            'cms-title cms-heading lh-1-1',
            'text-55 text-tablet-45 text-smobile-40',
            'text-'.$settings['title_color'],
            'empty-none'
        ]
    ]);
    // Desccription
    $widget->add_inline_editing_attributes('description');
    $widget->add_render_attribute('description', [
        'class' => [
            'cms-desc empty-none',
            'text-15',
            'text-'.$widget->get_setting('desc_color','body')
        ]
    ]);
    // Privacy Policy
    $widget->add_render_attribute('privacy_policy_text_wrap', [
        'class' => [
            'cms-pp empty-none',
            'text-14',
            'text-'.$widget->get_setting('desc_color','grey3'),
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
            'pp-link',
            'text-'.$settings['desc_color']
        ],
        'href'  => $url
    ]);

    // Form Fields
    $show_name = $widget->get_setting('show_name','no');
    // Shortcode
    $fields = '[newsletter_form button_label="'.$widget->get_setting('button_text',esc_html__('Subscribe','allianz')).'" class="cms-nlf-2 relative mt-10"]';
    if($show_name == 'yes'){
        $fields .= '[newsletter_field name="first_name" label="" placeholder="'.$widget->get_setting('name_text',esc_html__('Your Name','allianz')).'"]';
    }
    $fields .= '[newsletter_field name="email" label="" placeholder="'.$widget->get_setting('email_text',esc_html__('Your Email Address','allianz')).'"]';
    $fields .= '[/newsletter_form]';
    
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="col-5 col-tablet-6 col-mobile-extra-12">
        <div <?php etc_print_html($widget->get_render_attribute_string('small_title')); ?>><?php 
            echo nl2br($settings['small_title']); 
        ?></div>
        <h2 <?php etc_print_html($widget->get_render_attribute_string('title')); ?>><?php 
            echo nl2br($settings['title']); 
        ?></h2>
        <div <?php etc_print_html($widget->get_render_attribute_string('description')); ?>><?php 
            echo wpautop($settings['description']); 
        ?></div>
    </div>
    <div class="col-7 col-tablet-6 col-mobile-extra-12">
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
        <div <?php etc_print_html($widget->get_render_attribute_string('privacy_policy_text_wrap')); ?>>
            <span <?php etc_print_html($widget->get_render_attribute_string('privacy_policy_text')); ?>><?php 
                // text
                etc_print_html($settings['privacy_policy_text']).'&nbsp;';
            ?></span>
            <?php 
                // link
            if(!empty($page->ID)){
                etc_print_html(
                    '<a '.$widget->get_render_attribute_string('privacy_policy_link_text').'>'.$widget->get_setting('privacy_policy_link_text', get_the_title($page->ID)).'</a>'
                );
            }
            ?>
        </div>
    </div>
</div>