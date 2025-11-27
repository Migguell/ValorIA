<?php
use Elementor\Group_Control_Image_Size;
use Elementor\Control_Media;
use Elementor\Icons_Manager;

$layout_mode = $widget->get_setting('layout_mode', 'carousel');
$teams       = $widget->get_setting('teams', []);
$arrows      = $widget->get_setting('arrows');
$dots        = $widget->get_setting('dots');

$thumbnail_custom_dimension = [
 'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 400,
 'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 420
];
// wrap
$widget->add_render_attribute('wrap', [
    'class' => [
        'cms-eteam',
        'cms-eteam-'.$settings['layout'],
        'relative'
    ]
]);

// Grid Wrap
$widget->add_render_attribute('grid-wrap',[
    'class' => [
        'cms-team-grid',
        'd-flex gutter',
        allianz_elementor_get_grid_columns($widget, $settings, [
            'default' => '3',
            'tablet'  => '2' 
        ])
    ]
]);
// Heading wrap
$widget->add_render_attribute('heading-wrap',[
    'class' => [
        'cms-team-qc-wrap',
        'order-tablet-first'
    ]
]);
if( $settings['layout_mode'] === 'carousel' ){
    $widget->add_render_attribute('heading-wrap', [
        'class' => ['mb-40'] // add space with heading
    ]);
}
// Large Heading
$widget->add_inline_editing_attributes( 'qc_heading_text', 'none' );
$widget->add_render_attribute( 'qc_heading_text', [
    'class' => [
        'cms-heading empty-none',
        'text-24 text-white',
        'lh-14167',
        'mt-n10'
    ]
]);
// Description
$widget->add_inline_editing_attributes( 'qc_description_text' );
$widget->add_render_attribute( 'qc_description_text', [
    'class' => array_filter([
        'cms-desc pt-20 empty-none',
        'text-white'
    ])
]);
// Link 1
$link1_page = $widget->get_setting('qc_link1_page','');
switch ($settings['qc_link1_type']) {
    case 'page':
        $page = !empty($link1_page) ? get_page_by_path($link1_page, OBJECT) : [];
        $url  = !empty($page) ? get_permalink($page->ID) : '#';
        break;
    
    default:
        $url = $widget->get_setting('qc_link1_custom', ['url' => '#'])['url'];
        break;
}
$widget->add_inline_editing_attributes( 'qc_link1_text' );
$widget->add_render_attribute( 'qc_link1_text', [
    'class' => [
        'btn btn-lg',
        'text-primary',
        'bg-white',
        'text-hover-primary',
        'bg-hover-white',
        'mt-80',
        'cms-hover-move-icon-up'
    ],
    'href'  => $url
]);
// team item Classes
$team_item_classes = [
    'cms-team-item',
    'cms-e-holder relative cms-hover-change',
    ($settings['layout_mode'] === 'carousel') ? 'cms-swiper-item swiper-slide' : ''
];
// QQuick Contact
ob_start();
?>
    <div class="cms-gradient-render overflow-hidden"></div>
    <div class="cms-team-qc-content relative z-top p-50 p-lr-smobile-20 text-white">
        <h3 <?php etc_print_html( $widget->get_render_attribute_string( 'qc_heading_text' ) ); ?>><?php echo nl2br( $settings['qc_heading_text'] ); ?></h3>
        <div <?php etc_print_html( $widget->get_render_attribute_string( 'qc_description_text' ) ); ?>><?php echo nl2br( $settings['qc_description_text'] ); ?></div>
        <?php if(!empty($settings['qc_link1_text'])){ ?>
            <a <?php etc_print_html( $widget->get_render_attribute_string( 'qc_link1_text' ) ); ?>><?php
                // text
                echo esc_html( $settings['qc_link1_text'] ); 
                // icon
                allianz_elementor_button_icon_render();
            ?></a>
            <div class="clearfix"></div>
        <?php } ?>
        <a class="pt-25 cms-hover-underline text-white text-hover-white d-flex align-items-center gap-10 flex-nowrap font-700" href="mailto:<?php echo esc_url($settings['qc_email']) ?>" target="_blank"><span class="cmsi-email text-16"></span><?php echo esc_html($settings['qc_email']) ?></a>
    </div>
<?php
$banner_content = ob_get_clean();
// render quick contact
ob_start();
if((!empty($settings['qc_heading_text']) || !empty($settings['qc_description_text']) || !empty($settings['qc_link1_text']))){
?>
<div <?php etc_print_html($widget->get_render_attribute_string('heading-wrap')); ?>>
    <?php 
        allianz_elementor_image_render($settings, [
            'name'                => 'banner',
            'size'                => 'custom',  
            'img_class'           => 'img-cover',
            'custom_size'         => ['width' => 400, 'height' => 521],
            'before'              => '',
            'after'               => '',
            'as_background'       => true,
            'as_background_class' => 'cms-team-qc--wrap relative cms-gradient-accent-bt2 overflow-hidden',
            'content'             => $banner_content
        ]);
    ?>
</div>
<?php
}
$element_heading = ob_get_clean();
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <?php switch ($settings['layout_mode']) {
        case 'grid':
    ?>
        <div <?php etc_print_html($widget->get_render_attribute_string('grid-wrap')) ?>>
    <?php
            break;
        
        default:
    ?>
        <div class="cms-carousel swiper">
            <?php etc_print_html($element_heading); ?>
            <div class="swiper-wrapper">
    <?php
            break;
    } ?>
    
            <?php
            foreach ($teams as $key => $team) {
                $item_key = $widget->get_repeater_setting_key( 'ite,', 'cms_team', $key );
                $widget->add_render_attribute( $item_key,[
                    'class' => $team_item_classes
                ]);

                // link
                $link_key = $widget->get_repeater_setting_key( 'link', 'cms_team', $key );
                $widget->add_render_attribute( $link_key, 'class', 'team-name d-block relative' );
                $widget->add_link_attributes( $link_key, $team['link'] );

                ob_start();
                    for ($i = 1; $i <= 4; $i++) {
                        $social_icon = isset($team["social_icon_{$i}"]) ? $team["social_icon_{$i}"] : null;
                        $social_link = isset($team["social_link_{$i}"]) ? $team["social_link_{$i}"] : null;
                        if($social_icon && !empty($social_icon['value']) && $social_link){
                            if ( ! empty( $social_link['url'] ) ) {
                                $social_link_key = $widget->get_repeater_setting_key( "social_link_{$i}", 'cms_team', $key );
                                $widget->add_link_attributes( $social_link_key, $social_link );
                                $widget->add_render_attribute( $social_link_key, 'class', 'team-social text-primary text-hover-primary text-on-hover-accent' );
                                ?>
                                    <a <?php etc_print_html($widget->get_render_attribute_string( $social_link_key )); ?>>
                                        <?php
                                            allianz_elementor_icon_render( $social_icon, [], [ 'aria-hidden' => 'true','icon_size' => '20' ]);
                                        ?>
                                    </a>
                                <?php
                            }
                        }
                    }
                $socials_html = ob_get_clean();
                if(!empty($socials_html)){
                    $_socials_html = ob_start();
                    ?>
                        <div class="team-socials d-flex gap-10 lh-20"><?php etc_print_html($socials_html); ?></div>
                    <?php
                    $_socials_html = ob_get_clean();
                } else {
                    $_socials_html = '';
                }
                ?>
                <div <?php etc_print_html($widget->get_render_attribute_string( $item_key )); ?>>
                    <?php 
                        $team['image_size'] = $widget->get_setting('image_size');
                        $team['image_custom_dimension'] = $thumbnail_custom_dimension;
                        allianz_elementor_image_render($team,[
                            'name'           => 'image',
                            'image_size_key' => 'image',
                            'img_class'      => 'swiper-nav-vert w-100',
                            'custom_size'    => $thumbnail_custom_dimension,
                            'max_height'     => false,
                            'before'         => '<a '.$widget->get_render_attribute_string( $link_key ).'>',
                            'after'          => allianz_hover_gradient_holder(['echo' => false]).'</a>'
                        ]);
                    ?>
                    <div class="team-content pt-25 pb-20 p-lr-30 p-lr-smobile-20 bg-grey d-flex gap-20 align-items-center justify-content-between">
                        <div class="team--content">
                            <h4 class="team-heading font-body font-600 text-22">
                                <a <?php etc_print_html($widget->get_render_attribute_string( $link_key )); ?>>
                                    <?php echo esc_html($team['name']); ?>
                                </a>
                            </h4>
                            <div class="team-position empty-none text-15 pt-5 text-primary-lighten"><?php etc_print_html($team['position']); ?></div>
                            <div class="team-desc empty-none pt-15 text-15"><?php etc_print_html($team['description']); ?></div>
                        </div>
                        <?php etc_print_html($_socials_html); ?>
                    </div>
                </div>
                <?php
            }
            ?>
    <?php switch ($settings['layout_mode']) {
        case 'grid':
        // close .cms-grid
    ?>
        <?php etc_print_html($element_heading); ?>
        </div>
    <?php
            break;
        
        default:
        // close .cms-carouse .swiper-wrapper
    ?>
                </div>
            </div>
        <?php if ($arrows == 'yes') : ?>
            <div class="cms-carousel-button-prev cms-carousel-button arrow-button in prev">
                <i aria-hidden="true" class="cms-carousel-button-icon allianz-icon-left-arrow1 rtl-flip"></i>
            </div>
            <div class="cms-carousel-button-next cms-carousel-button arrow-button in next">
                <i aria-hidden="true" class="cms-carousel-button-icon allianz-icon-right-arrow1 rtl-flip"></i>
            </div>
        <?php endif ?>
        <?php if ($dots == 'yes') : ?>
            <div class="cms-carousel-dots cms-carousel-dots-<?php echo esc_attr($settings['dots_type']) ?> justify-content-center"></div>
        <?php endif ?>
    <?php
            break;
    } ?>
</div>