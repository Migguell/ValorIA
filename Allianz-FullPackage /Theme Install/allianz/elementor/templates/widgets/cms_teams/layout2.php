<?php
use Elementor\Group_Control_Image_Size;
use Elementor\Control_Media;
use Elementor\Icons_Manager;

$layout_mode = $widget->get_setting('layout_mode', 'carousel');
$teams       = $widget->get_setting('teams', []);
$arrows      = $widget->get_setting('arrows');
$dots        = $widget->get_setting('dots');

$thumbnail_custom_dimension = [
 'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 290,
 'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 305
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
        'cms-team-heading-wrap'
    ]
]);
if( $settings['layout_mode'] === 'carousel' ){
    $widget->add_render_attribute('heading-wrap', [
        'class' => ['mb-40'] // add space with heading
    ]);
}
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-heading empty-none',
        'text-'.$widget->get_setting('heading_color','heading'),
        'lh-1375',
        'mt-n10'
    ]
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
    'class' => array_filter([
        'cms-desc pt-20 empty-none',
        'text-'.$widget->get_setting('description_color','body')
    ])
]);
// Link 1
$link1_page = $widget->get_setting('link1_page','');
switch ($settings['link1_type']) {
    case 'page':
        $page = !empty($link1_page) ? get_page_by_path($link1_page, OBJECT) : [];
        $url  = !empty($page) ? get_permalink($page->ID) : '#';
        break;
    
    default:
        $url = $widget->get_setting('link1_custom', ['url' => '#'])['url'];
        break;
}
$widget->add_inline_editing_attributes( 'link1_text' );
$widget->add_render_attribute( 'link1_text', [
    'class' => [
        'text-'.$widget->get_setting('link1_color','accent'),
        //'bg-'.$widget->get_setting('link1_bg_color'),
        'text-hover-'.$widget->get_setting('link1_color_hover', 'accent'),
        //'bg-hover-'.$widget->get_setting('link1_bg_hover_color'),
        'mt-20',
        'empty-none',
        'd-flex align-items-center gap-10',
        'text-15 font-700',
        'cms-hover-underline-2 cms-hover-move-icon-up'
    ],
    'href'  => $url
]);
// team item Classes
$team_item_classes = [
    'cms-team-item',
    'cms-e-holder relative cms-hover-change hover-content-zoom-in',
    ($settings['layout_mode'] === 'carousel') ? 'cms-swiper-item swiper-slide' : ''
];
// Element Heading
ob_start();
if((!empty($settings['heading_text']) || !empty($settings['description_text']) || !empty($settings['link1_text']))){
?>
<div <?php etc_print_html($widget->get_render_attribute_string('heading-wrap')); ?>>
    <h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
    <div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
    <?php if(!empty($settings['link1_text'])){ ?>
        <a <?php etc_print_html( $widget->get_render_attribute_string( 'link1_text' ) ); ?>><?php
            // text
            echo esc_html( $settings['link1_text'] ); 
            // icon
            allianz_elementor_button_icon_render();
        ?></a>
    <?php } ?>
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
            <?php etc_print_html($element_heading); ?>
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
                        <div class="team-socials d-flex gap-10 lh-20 hover-content--zoom-in"><?php etc_print_html($socials_html); ?></div>
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
                    <div class="team-content pt-25 pb-20 d-flex align-items-center justify-content-between flex-nowrap">
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