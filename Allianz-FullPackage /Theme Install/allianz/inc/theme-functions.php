<?php 
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Shapes;

function allianz_logical_dimensions_inline_start(){
    $dimensions = is_rtl() ? '{{RIGHT}}{{UNIT}}' : '{{LEFT}}{{UNIT}}';
    return $dimensions;
}
function allianz_logical_dimensions_inline_end(){
    $dimensions =  is_rtl() ? '{{LEFT}}{{UNIT}}' : '{{RIGHT}}{{UNIT}}';
    return $dimensions;
}

function allianz_nice_class($classes = []){
    $classes = (array) $classes;
    return implode(' ', array_filter($classes));
}
/**
 * Create the rating interface.
 * 
 * 
*/
if(!function_exists('allianz_comment_rating_fields')){
    function allianz_comment_rating_fields ($args =[]) {
        $args = wp_parse_args($args, [
            'echo'  => true,
            'class' => ''
        ]);
        $show_rating = allianz_get_opts('post_comments_rating_on', '0', 'on');
        if('1' != $show_rating || !is_singular('post')) return;
        ob_start();
    ?>
        <div class="cms-comment-form-rating cms-comment-form-fields-wrap <?php echo esc_attr($args['class']); ?>">
            <div  class="comment-form-field">
                <?php echo esc_html__('Your Rating','allianz');?><span class="required text-red">*</span>
            </div>
            <div class="comment-form-field comments-rating">
                <span class="rating-container stars">
                    <?php for ( $i = 5; $i >= 1; $i-- ) : ?>
                        <input type="radio" id="rating-<?php echo esc_attr($i);?>" class="star-<?php echo esc_attr($i);?>" name="rating" value="<?php echo esc_attr($i);?>" />
                        <label for="rating-<?php echo esc_attr($i);?>"><span class="d-none"><?php echo esc_html($i);?></span></label>
                    <?php endfor; ?>
                    <input type="radio" id="rating-0" class="star-cb-clear star-0" name="rating" value="0" /><label for="rating-0"><span class="d-none">0</span></label>
                </span>
                </div>
            </div>
        <?php
        if($args['echo']){
            printf('%s', ob_get_clean() );
        } else {
            return ob_get_clean();
        }
    }
}
if(!function_exists('allianz_woocommerce_comment_rating_fields')){
    function allianz_woocommerce_comment_rating_fields($args =[]){
        $args = wp_parse_args($args, [
            'echo' => true,
            'class' => ''
        ]);
        $rating = '';
        if(!function_exists('wc_review_ratings_enabled')) return;
        if (wc_review_ratings_enabled() && is_singular('product') ) {
            $rating .= '<div class="cms-comment-form-rating cms-comment-form-fields-wrap '.esc_attr($args['class']).'">';
                $rating .= '<div class="comment-form-field">' . esc_html__( 'Your rating', 'allianz' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required text-red">*</span>' : '' ) . '</div>';
                $rating .= '<div class="comment-form-field comments-rating">';
                    $rating .= '<select name="rating" id="rating" required>
                        <option value="">' . esc_html__( 'Rate&hellip;', 'allianz' ) . '</option>
                        <option value="5">' . esc_html__( 'Perfect', 'allianz' ) . '</option>
                        <option value="4">' . esc_html__( 'Good', 'allianz' ) . '</option>
                        <option value="3">' . esc_html__( 'Average', 'allianz' ) . '</option>
                        <option value="2">' . esc_html__( 'Not that bad', 'allianz' ) . '</option>
                        <option value="1">' . esc_html__( 'Very poor', 'allianz' ) . '</option>
                    </select>';
                $rating .= '</div>';
            $rating .= '</div>';
        }
        if($args['echo']){
            printf('%s', $rating);
        } else {
            return $rating;
        }
    }
}
// add rating to after comment form fields
add_filter('comment_form_fields', 'allianz_comment_rating_default_fields' );
if(!function_exists('allianz_comment_rating_default_fields')){
    function allianz_comment_rating_default_fields ($fields) {
        //$fields_rating = [];
        ob_start();
            allianz_comment_rating_fields();
            allianz_woocommerce_comment_rating_fields();
        $rating = ob_get_clean();
        //$fields_rating['rating'] = ob_get_clean();
        //$fields = array_merge($fields_rating, $fields);
        $fields['comment'] = $rating.$fields['comment'];
        return $fields;
    }
}

//Save the new meta added by theme  submitted by the user.
add_action( 'comment_post', 'allianz_comment_rating_save_comment_meta' );
if(!function_exists('allianz_comment_rating_save_comment_meta')){
    function allianz_comment_rating_save_comment_meta( $comment_id ) {
        $rating = $address = '';
        // rating
        if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
        $rating = intval( $_POST['rating'] );
        // address
        if ( ( isset( $_POST['address'] ) ) && ( '' !== $_POST['address'] ) )
        $address = $_POST['address'];
        add_comment_meta( $comment_id, 'rating', $rating );
        add_comment_meta( $comment_id, 'address', $address );
    }
}
// Make the rating required.
add_filter( 'preprocess_comment', 'allianz_comment_rating_require_rating' );
if(!function_exists('allianz_comment_rating_require_rating')){
    
    function allianz_comment_rating_require_rating( $commentdata ) {
        $show_rating = allianz_get_opt('post_comments_rating_on','0');
        if('1' !== $show_rating) return $commentdata;

        if ( ! is_admin() && ( ! isset( $_POST['rating'] ) || 0 === intval( $_POST['rating'] ) ) )
        wp_die( esc_html__( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.','allianz' ) );
        return $commentdata;
    }
}

//Display the rating on a submitted comment.
if(!function_exists('allianz_comment_rating_display_rating')){
    //add_filter( 'comment_text', 'allianz_comment_rating_display_rating');
    function allianz_comment_rating_display_rating( $comment_text ){
        if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
            $stars = '<div class="stars">';
            for ( $i = 1; $i <= $rating; $i++ ) {
                $stars .= '<span class="rating-icon cms-rating-icon-filled"></span>';
            }
            $stars .= '</div>';
            $comment_text = $comment_text . $stars;
            return $comment_text;
        } else {
            return $comment_text;
        }
    }
}

//Get the average rating of a post.
if(!function_exists('allianz_comment_rating_get_average_ratings')){
    function allianz_comment_rating_get_average_ratings( $id ) {
        $comments = get_approved_comments( $id );
        if ( $comments ) {
            $i = 0;
            $total = 0;
            foreach( $comments as $comment ){
                $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
                if( isset( $rate ) && '' !== $rate ) {
                    $i++;
                    $total += $rate;
                }
            }

            if ( 0 === $i ) {
                return false;
            } else {
                return round( $total / $i, 1 );
            }
        } else {
            return false;
        }
    }
}
// Display the star average rating only
if(!function_exists('allianz_comment_rating_display_average')){
    function allianz_comment_rating_display_average($args = []) {

        global $post;

        if ( false === allianz_comment_rating_get_average_ratings( $post->ID ) ) {
            return false;
        }
        $args = wp_parse_args($args, [
            'width' => 20,
            'class' => ''
        ]);
        $stars   = '';
        $average = allianz_comment_rating_get_average_ratings( $post->ID );

        for ( $i = 1; $i <= $average + 1; $i++ ) {
            
            $width = intval( $i - $average > 0 ? $args['width'] - ( ( $i - $average ) * $args['width'] ) : $args['width'] );

            if ( 0 === $width ) {
                continue;
            }
            $stars .= '<span style="overflow:hidden; width:' . $width . 'px" class="rating-icon cms-rating-icon-filled"></span>';

            if ( $i - $average > 0 ) {
                $stars .= '<span style="overflow:hidden; position:relative; left:-' . ($width - 1) .'px;" class="cms-rating-icon cms-rating-icon-empty"></span>';
            }
        }
        $classes = ['cms-average-rating cms-average-rating-star', $args['class']];
        $custom_content  = '<div class="'.implode(' ', $classes).'">' . $stars .'</div>';
        return $custom_content;
    }
}

//Display the average rating above the content.
if(!function_exists('allianz_comment_rating_display_average_rating')){
    //add_filter( 'the_content', 'allianz_comment_rating_display_average_rating' );
    function allianz_comment_rating_display_average_rating( $content ) {

        global $post;

        if ( false === allianz_comment_rating_get_average_ratings( $post->ID ) ) {
            return $content;
        }
        
        $stars   = '';
        $average = allianz_comment_rating_get_average_ratings( $post->ID );

        for ( $i = 1; $i <= $average + 1; $i++ ) {
            
            $width = intval( $i - $average > 0 ? 20 - ( ( $i - $average ) * 20 ) : 20 );

            if ( 0 === $width ) {
                continue;
            }

            $stars .= '<span style="overflow:hidden; width:' . $width . 'px" class="rating-icon cms-rating-icon-filled"></span>';

            if ( $i - $average > 0 ) {
                $stars .= '<span style="overflow:hidden; position:relative; left:-' . $width .'px;" class="rating-icon cms-rating-icon-empty"></span>';
            }
        }
        
        $custom_content  = '<div class="average-rating">This post\'s average rating is: ' . $average .' ' . $stars .'</div>';
        $custom_content .= $content;
        return $custom_content;
    }
}
if(!function_exists('allianz_comment_rating_display_feedback')){
    function allianz_comment_rating_display_feedback($args=[]){
        $args = wp_parse_args($args,[
            'id'        => get_the_ID(),
            'mode'      => 'good', //bad
            'good_text' => esc_html__('positive feedback', 'allianz'),
            'bad_text'  => esc_html__('negative feedback', 'allianz'),
            'good_icon' => 'icofont-simple-smile',
            'bad_icon'  => 'icofont-sad'
        ]);
        $comments = get_approved_comments( $args['id'] );
        if ( $comments ) {
            $i = 0;
            $total = 0;
            $good_rate = $bad_rate = 0;
            foreach( $comments as $comment ){
                $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
                if( isset( $rate ) && '' !== $rate ) {
                    $i++;
                    $total += $rate;
                }
                if(isset($rate) && $rate > 3){
                    $good_rate ++;
                }
                if(isset($rate) && $rate <= 3){
                    $bad_rate ++;
                }
            }

            if ( 0 === $i ) {
                return false;
            } else {
                //return  $total .' good:'.$good_rate.' bad:'.$bad_rate ;
                if($args['mode'] == 'good'){
                    return '<span class="cms-rating-good text-accent text-17 '.$args['good_icon'].'"></span> <span class="cms-rating-percent text-accent font-700">'.number_format_i18n( $good_rate*100 / $i, 2 ).'%</span> '.$args['good_text'];
                } else {
                    return '<span class="cms-rating-bad text-accent text-17 '.$args['bad_icon'].'"></span> <span class="cms-rating-percent text-accent font-700">'.number_format_i18n( $bad_rate*100 / $i, 2 ).'%</span> '.$args['bad_text'];
                }
            }
        } else {
            return false;
        }
    }
}
// Display the address on a submitted comment.
if(!function_exists('allianz_comment_display_address')){
    //add_filter( 'comment_text', 'allianz_comment_rating_display_rating');
    function allianz_comment_display_address(){
        $address =  get_comment_meta( get_comment_ID(), 'address', true ) ;
        if(empty($address)) return;
        ?>
            <div class="cms-comment-address"><?php echo esc_html($address); ?></div>
        <?php
    }
}
/**
 * Update Wordpress Configs
 * Change thumbnail size
 * Size list
 * https://developer.wordpress.org/reference/functions/add_image_size/#reserved-image-size-names
 * 
 * */
add_action('after_switch_theme', 'allianz_thumbnail_size');
if(!function_exists('allianz_thumbnail_size')){
    function allianz_thumbnail_size(){
        /* Change default image thumbnail sizes in wordpress */
        $thumbnail_size = array(
            // Large
            'large_size_w'        => '840',
            'large_size_h'        => '561',
            'large_crop'          => 1, 
            // Medium Large
            'medium_large_size_w' => '770',
            'medium_large_size_h' => '514',
            'medium_large_crop'   => 1, 
            // Medium
            'medium_size_w'       => '570',
            'medium_size_h'       => '380',
            'medium_crop'         => 1, 
            // thumbnail
            'thumbnail_size_w'    => '80',
            'thumbnail_size_h'    => '80',
            'thumbnail_crop'      => 1,
            /**
             * thumb
             * default no custom
             * Allianz use for special products layout
             * 
             */
            'thumb_size_w'    => '570',
            'thumb_size_h'    => '472',
            'thumb_crop'      => 1,
        );
        foreach ($thumbnail_size as $option => $value) {
            if (get_option($option, '') != $value)
                update_option($option, $value);
        }
    }
}
add_filter( 'image_size_names_choose', 'allianz_thumbnail_size_custom' );
function allianz_thumbnail_size_custom( $sizes ) {
    return array_merge( $sizes, array(
        'medium_large' => esc_html__('Medium Large','allianz'),
    ) );
}
/**
 * Elementor Gradient Options
 * */
if(!function_exists('allianz_elementor_gradient_opts')){
    function allianz_elementor_gradient_opts(){
        return array(
            ''             => esc_html__('Default', 'allianz' ),
            'accent-tb'    => esc_html__('Accent - Top to Bottom','allianz'),
            'accent-bt'    => esc_html__('Accent - Botom to Top','allianz'),
            'accent-bt2'   => esc_html__('Accent - Botom to Top #2','allianz'),
            'secondary-tb' => esc_html__('Secondary - Top to Bottom ','allianz'),
            'secondary-bt' => esc_html__('Secondary - Bottom to Top','allianz'),
            'primary-tb'   => esc_html__('Primary - Top to Bottom','allianz'),
            'primary-bt'   => esc_html__('Primary - Bottom to Top','allianz'),
            'primary-bt2'   => esc_html__('Primary - Bottom to Top #2','allianz'),
            'black-bt'     => esc_html__('Black - Bottom to Top','allianz'),
            'black-bt2'    => esc_html__('Black - Bottom to Top #2','allianz'),
            'black-bt3'    => esc_html__('Black - Bottom to Top #3','allianz'),
            'black-bt4'    => esc_html__('Black - Bottom to Top #4','allianz'),
            'grey-tb'      => esc_html__('Grey - Top to Bottom','allianz'),
            'grey-bt2'     => esc_html__('Grey - Bottom to Top','allianz'),
            'grey-bt'      => esc_html__('Grey & Accent - Bottom to Top','allianz'),
            'none'         => esc_html__('None','allianz')
        );
    }
}
/**
 * Custom Elementor Row
 * Columns Presets
 * 
 * **/
if(!function_exists('allianz_custom_section_presets')){
    add_filter('etc-custom-section/custom-presets', 'allianz_custom_section_presets');
    function allianz_custom_section_presets(){
        return [
            2 => [
                [
                    'preset' => ['100', '100']
                ],
                [
                    'preset' => ['auto', 'basic']
                ],
                [
                    'preset' => ['basic', 'auto']
                ]
            ],
            3 => [
                [
                    'preset' => ['50', '50', '100']
                ],
                [
                    'preset' => ['100', '50', '50']
                ],
                [
                    'preset' => ['50', '100', '50']
                ],
                [
                    'preset' => ['100', '33', '66']
                ],
                [
                    'preset' => ['100', '66', '33']
                ],
                [
                    'preset' => ['100', '58', '42']
                ]
            ],
            4 => [
                [
                    'preset' => ['100', '33', '33', '33']
                ],
                [
                    'preset' => ['66', '100', '33', '66']
                ],
                [
                    'preset' => ['50', '100', '33', '66']
                ],
                [
                    'preset' => ['100', '50', '50', '100']
                ]
            ],
            5 => [
                [
                    'preset' => ['25', '25', '25', '25', '100']
                ],
                [
                    'preset' => ['66', '100', '33', '33', '33']
                ],
                [
                    'preset' => ['50', '100', '33', '33', '33']
                ],
                [
                    'preset' => ['100', '25', '25', '25', '25']
                ],
                [
                    'preset' => ['100', '33', '33', '33', '100']
                ]
            ],
            6 => [
                [
                    'preset' => ['50', '100', '33', '33', '33', '50']
                ],
                [
                    'preset' => ['100', '25', '25', '25', '25', '100']
                ],
                [
                    'preset' => ['100', '20', '20', '20', '20', '20']
                ],
                [
                    'preset' => ['100', '25', '16', '16', '16', '25']
                ]
            ]
        ];
    }
}
// Add custom field to section
if(!function_exists('allianz_custom_section_params')){
    add_filter('etc-custom-section/custom-params', 'allianz_custom_section_params'); 
    function allianz_custom_section_params(){
        return array(
            'sections' => array(
                // add more
                array(
                    'name'     => 'cms_custom_layout',
                    'label'    => esc_html__( 'Allianz Custom Settings', 'allianz' ),
                    'tab'      => Controls_Manager::TAB_LAYOUT,
                    'controls' => array_merge(
                        array(
                            // make section full content with a space on start / end
                            array(
                                'name'         => 'full_content_with_space',
                                'label'        => esc_html__( 'Full Content with space from?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'prefix_class' => 'cms-full-content-with-space-',
                                'options'      => array(
                                    'none'       => esc_html__( 'None', 'allianz' ),
                                    'start'      => esc_html__( 'Start', 'allianz' ),
                                    'end'        => esc_html__( 'End', 'allianz' ),
                                    'start-wide' => esc_html__( 'Start (Container Wide)', 'allianz' ),
                                    'end-wide'   => esc_html__( 'End (Container Wide)', 'allianz' ),
                                    'both-30'    => esc_html__( 'Container Fluid', 'allianz' ),
                                    'both-45'    => esc_html__( 'Container Fluid #2', 'allianz' ),
                                ),
                                'default'      => 'none',
                                'condition' => [
                                    'layout' => 'full_width'
                                ]
                            ),
                            array(
                                'name'         => 'horiz_align',
                                'label'        => esc_html__( 'Horizontal Align', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'prefix_class' => 'cms-esection-horiz-align-',
                                'options'      => array(
                                    ''        => esc_html__('Default', 'allianz' ),
                                    'start'   => esc_html__('Start','allianz'),
                                    'end'     => esc_html__('End','allianz'),
                                    'center'  => esc_html__('Center', 'allianz' ),
                                    'between' => esc_html__('Between', 'allianz' )
                                ),
                                'default' => '',
                                'separator' => 'before'
                            ),
                            array(
                                'name'         => 'boxed_bg',
                                'label'        => esc_html__( 'Boxed Background?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'prefix_class' => 'cms-boxed-bg-',
                                'options'      => array(
                                    ''           => esc_html__( 'None', 'allianz' ),
                                    'both'       => esc_html__('Both','allianz'),
                                    'both-large' => esc_html__('Both Large','allianz'),
                                    'both-wide'  => esc_html__('Both Wide','allianz'),
                                    'both-wide2' => esc_html__('Both Wide #2','allianz'),
                                    'start'      => esc_html__( 'Start', 'allianz' ),
                                    'end'        => esc_html__( 'End', 'allianz' ),
                                    'start-wide' => esc_html__( 'Start Wide', 'allianz' ),
                                    'end-wide'   => esc_html__( 'End Wide', 'allianz' ),
                                ),
                                'default' => '',
                                'separator' => 'before'
                            ),
                            array(
                                'name'         => 'show_edge',
                                'label'        => esc_html__( 'Show Edge on?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'options'      => array(
                                    'no'         => esc_html__( 'No', 'allianz' ),
                                    'top-left'   => esc_html__( 'Top Left', 'allianz' ),
                                    'top-right'  => esc_html__( 'Top Right', 'allianz' ),
                                    'bot-left'   => esc_html__( 'Bottom Left', 'allianz' ),
                                    'bot-right'  => esc_html__( 'Bottom Right', 'allianz' ),
                                    'bot-left2'  => esc_html__( 'Bottom Left #2', 'allianz' ),
                                    'bot-right2' => esc_html__( 'Bottom Right #2', 'allianz' ),
                                ),
                                'default'   => 'no',
                                'separator' => 'before'
                            ),
                            array(
                                'name'         => 'edge_ontop',
                                'label'        => esc_html__( 'On Front?', 'allianz' ),
                                'type'         => Controls_Manager::SWITCHER,
                                'prefix_class' => 'cms-edge-front-',
                                'condition' => [
                                    'show_edge!' => 'no'
                                ]
                            ),
                            array(
                                'name'         => 'edge_size',
                                'label'        => esc_html__( 'Edge size?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'prefix_class' => 'cms-edge-size-',
                                'options'      => array(
                                    'small'  => esc_html__( 'Small', 'allianz' ),
                                    'medium' => esc_html__( 'Medium', 'allianz' ),
                                    'large'  => esc_html__( 'Large', 'allianz' )
                                ),
                                'default'   => 'medium',
                                'condition' => [
                                    'show_edge!' => 'no'
                                ]
                            ),
                            array(
                                'name'         => 'edge_color',
                                'label'        => esc_html__( 'Edge color?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                //'prefix_class' => 'cms-edge-',
                                'options'      => array(
                                    'accent'    => esc_html__( 'Accent', 'allianz' ),
                                    'primary'   => esc_html__( 'Primary', 'allianz' ),
                                    'secondary' => esc_html__( 'Secondary', 'allianz' ),
                                    'white'     => esc_html__( 'White', 'allianz' ),
                                    'grey'      => esc_html__( 'Grey', 'allianz' ).' (#f3f5fa)',
                                    'grey2'     => esc_html__( 'Grey #2', 'allianz' ).' (#fbfcfd)',
                                    'grey3'     => esc_html__( 'Grey #3', 'allianz' ).' (#edf0f8)'
                                ),
                                'default' => 'white',
                                'condition' => [
                                    'show_edge!' => 'no'
                                ]
                            ),
                            array(
                                'name'         => 'edge2_color',
                                'label'        => esc_html__( 'Edge #2 color?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'options'      => array(
                                    'accent'    => esc_html__( 'Accent', 'allianz' ),
                                    'primary'   => esc_html__( 'Primary', 'allianz' ),
                                    'secondary' => esc_html__( 'Secondary', 'allianz' ),
                                    'white'     => esc_html__( 'White', 'allianz' ),
                                    'grey'      => esc_html__( 'Grey', 'allianz' ).' (#f3f5fa)',
                                    'grey2'     => esc_html__( 'Grey #2', 'allianz' ).' (#fbfcfd)',
                                    'grey3'     => esc_html__( 'Grey #3', 'allianz' ).' (#edf0f8)'
                                ),
                                'default' => 'secondary',
                                'condition' => [
                                    'show_edge!' => 'no'
                                ]
                            ),
                            array(
                                'name'         => 'edge3_color',
                                'label'        => esc_html__( 'Edge #3 color?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'options'      => array(
                                    'accent'    => esc_html__( 'Accent', 'allianz' ),
                                    'primary'   => esc_html__( 'Primary', 'allianz' ),
                                    'secondary' => esc_html__( 'Secondary', 'allianz' ),
                                    'white'     => esc_html__( 'White', 'allianz' ),
                                    'grey'      => esc_html__( 'Grey', 'allianz' ).' (#f3f5fa)',
                                    'grey2'     => esc_html__( 'Grey #2', 'allianz' ).' (#fbfcfd)',
                                    'grey3'     => esc_html__( 'Grey #3', 'allianz' ).' (#edf0f8)'
                                ),
                                'default' => 'accent',
                                'condition' => [
                                    'show_edge!' => 'no'
                                ]
                            ),
                            array(
                                'name'         => 'show_gradient',
                                'label'        => esc_html__( 'Gradient Style', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'prefix_class' => 'cms-gradient-',
                                'options'      => allianz_elementor_gradient_opts(),
                                'default'      => '',
                                'separator'    => 'before'
                            ),
                            array(
                                'name'         => 'show_banner',
                                'label'        => esc_html__( 'Show Banner?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'prefix_class' => 'cms-section-banner-',
                                'options'      => array(
                                    'no'  => esc_html__( 'No', 'allianz' ),
                                    'yes' => esc_html__( 'Yes', 'allianz' )
                                ),
                                'default'   => 'no',
                                'separator' => 'before',
                                'dynamic' => [
                                    'active' => true
                                ]
                            ),
                            array(
                                'name'         => 'banner',
                                'label'        => esc_html__( 'Banner', 'allianz' ),
                                'type'         => Controls_Manager::MEDIA,
                                'condition'    => [
                                    'show_banner' => 'yes'
                                ],
                                'default' => [
                                    'id' => '',
                                    'url' => Utils::get_placeholder_image_src()
                                ],
                                'selectors' => [
                                    '{{WRAPPER}}.cms-section-banner-yes > .cms-section-banner' => 'background-image:url({{URL}});',
                                    '{{WRAPPER}} .cms-section-banner-yes' => 'background-image:url({{URL}});' 
                                ]
                            ),
                            array(
                                'name'         => 'banner_style',
                                'label'        => esc_html__( 'Banner Style', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'options'      => [
                                    '' => esc_html__('Default','allianz'),
                                    '1' => esc_html__('Style 01','allianz')
                                ],
                                'condition'    => [
                                    'show_banner' => 'yes'
                                ],
                                'default' => ''
                            ),
                            array(
                                'name'         => 'banner_gradient',
                                'label'        => esc_html__( 'Banner Overlay Gradient', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'options'      => allianz_elementor_gradient_opts(),
                                'default'      => '2',
                                'condition'    => [
                                    'show_banner' => 'yes'
                                ],
                                'dynamic' => [
                                    'active' => true
                                ]
                            ),
                            array(
                                'name'         => 'show_corner',
                                'label'        => esc_html__( 'Show Corner?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'options'      => array(
                                    'no'         => esc_html__( 'No', 'allianz' ),
                                    'top-left'   => esc_html__( 'Top Left', 'allianz' ),
                                    'top-right'  => esc_html__( 'Top Right', 'allianz' ),
                                    'bot-left'   => esc_html__( 'Bottom Left', 'allianz' ),
                                    'bot-right'  => esc_html__( 'Bottom Right', 'allianz' )
                                ),
                                'default'   => 'no',
                                'separator' => 'before'
                            ),
                            array(
                                'name'         => 'corner_color',
                                'label'        => esc_html__( 'Corner color?', 'allianz' ),
                                'type'         => Controls_Manager::SELECT,
                                'options'      => array(
                                    'accent'    => esc_html__( 'Accent', 'allianz' ),
                                    'primary'   => esc_html__( 'Primary', 'allianz' ),
                                    'secondary' => esc_html__( 'Secondary', 'allianz' )
                                ),
                                'default'   => 'accent',
                                'condition' => [
                                    'show_corner!' => 'no'
                                ]
                            )
                        )
                    )
                )
            )
        );
    }
}
// add html to before row settings
if(!function_exists('allianz_before_row_custom_html_setting')){
    add_filter('etc-custom-section/before-elementor-row-settings-html', 'allianz_before_row_custom_html_setting', 10 , 2);
    function allianz_before_row_custom_html_setting( $html, $settings){
        $html .= '<div class="cms-gradient-render"></div>';
        // Section Banner
        $html .= '<div class="cms-section-banner cms-section-banner-{{ settings.show_banner }} cms-gradient-{{ settings.banner_gradient }} cms-section-banner-style-{{settings.banner_style}} relative"><div class="cms-gradient-render"></div></div>';
        // Section Edge
        ob_start();
        ?>
            <#  if ( settings.show_corner != 'no' ) { #>
                <div class="cms-section-corner cms-section-corner-{{settings.show_corner}} cms-section-corner-{{settings.corner_color}} bg-{{settings.corner_color}} absolute {{settings.show_corner}}"></div>
            <# } #>
            <#  if ( settings.show_edge != 'no' ) { #>
            <div class="cms-section-edge cms-section-edge-{{ settings.show_edge }} cms-section-edge-{{ settings.edge_size }} absolute {{ settings.show_edge }}">
                <#  if ( settings.show_edge == 'top-left' ) { #>
                    <svg class="cms-edge-tl cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-{{settings.edge_color}}" d="M180,0.456H0V151"/>
                      <path data-name="secondary" class="fill-{{settings.edge2_color}} cms_floating_image_image" data-speed="1.0" d="M180,0L0,151V316L180,164V0Z"/>
                      <path data-name="accent" class="fill-{{settings.edge3_color}} cms_floating_image_image" data-speed="2.0" d="M90,34L0.142,109.378v82.37L90,115.868V34Z"/>
                    </svg>
                <# } #>
                <#  if ( settings.show_edge == 'top-right' ) { #>
                    <svg class="cms-edge-tr cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-{{settings.edge_color}}" d="M0,0.458H180V151"/>
                      <path data-name="secondary" class="fill-{{settings.edge2_color}} cms_floating_image_image" data-speed="1.0" d="M0,0L180,151V316L0,164V0Z"/>
                      <path data-name="accent" class="fill-{{settings.edge3_color}} cms_floating_image_image" data-speed="2.0" d="M90,34l89.858,75.381v82.369L90,115.87V34Z"/>
                    </svg>
                <# } #>
                <#  if ( settings.show_edge == 'bot-left' ) { #>
                    <svg class="cms-edge-bl cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-{{settings.edge_color}}" d="M180,315.539H0V165"/>
                      <path data-name="secondary" class="fill-{{settings.edge2_color}} cms_floating_image_image" data-speed="1.0" d="M180,316L0,165V0L180,152V316Z"/>
                      <path data-name="accent" class="fill-{{settings.edge3_color}} cms_floating_image_image" data-speed="2.0" d="M90,282L0.142,206.617V124.248L90,200.128V282Z"/>
                    </svg>
                <# } #>
                <#  if ( settings.show_edge == 'bot-right' ) { #>
                    <svg class="cms-edge-br cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-{{settings.edge_color}}" d="M0,315.538H180V165"/>
                      <path data-name="secondary" class="fill-{{settings.edge2_color}} cms_floating_image_image" data-speed="1.0" d="M0,316L180,165V0L0,152V316Z"/>
                      <path data-name="accent" class="fill-{{settings.edge3_color}} cms_floating_image_image" data-speed="2.0" d="M90,282l89.858-75.38V124.246L90,200.127V282Z"/>
                    </svg>
                <# } #>
                <#  if ( settings.show_edge == 'bot-left2' ) { #>
                    <svg class="cms-edge-bl2 cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 191.281">
                      <path data-name="white" class="fill-{{settings.edge_color}}" d="M180,315.539H0V165" transform="translate(0 -124.25)"/>
                      <path data-name="secondary" class="fill-{{settings.edge3_color}} cms_floating_image_image" data-speed="-2" d="M90,282L0.142,206.617v-82.37L90,200.127V282Z" transform="translate(0 -124.25)"/>
                    </svg>
                <# } #>
                <#  if ( settings.show_edge == 'bot-right2' ) { #>
                    <svg class="cms-edge-br2 cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 191.281">
                      <path data-name="white" class="fill-{{settings.edge_color}}" d="M0,315.54H180V165" transform="translate(0 -124.25)"/>
                      <path data-name="accent" class="fill-{{settings.edge3_color}} cms_floating_image_image" data-speed="-2" d="M90,282l89.858-75.382V124.249L90,200.128V282Z" transform="translate(0 -124.25)"/>
                    </svg>
                <# } #>
            </div>
            <# } #>
        <?php
        $html .= ob_get_clean();
        // Return
        return $html;
    }
}
// Custom HTML Elementor ROW (Frontend)
if(!function_exists('allianz_before_row_custom_html_render')){
    add_filter('etc-custom-section/before-elementor-row-render', 'allianz_before_row_custom_html_render', 11 , 2);
    function allianz_before_row_custom_html_render( $html, $settings){
        // Overlay Gradient
        if(isset($settings['show_gradient']) && $settings['show_gradient'] != ''){
            $html .= '<div class="cms-gradient-render"></div>';
        }
        // Section Banner
        if(isset($settings['show_banner']) && $settings['show_banner'] != 'no'){
            $html .= '<div class="cms-section-banner cms-section-banner-'.$settings['show_banner'].' cms-gradient-'.$settings['banner_gradient'].' cms-section-banner-style-'.$settings['banner_style'].' relative"><div class="cms-gradient-render"></div></div>';
        }
        // Section Edge
        ob_start ();
        if(isset($settings['show_corner']) && $settings['show_corner'] != 'no') { ?>
            <div class="cms-section-corner cms-section-corner-<?php echo esc_attr($settings['show_corner']);?> cms-section-corner-<?php echo esc_attr($settings['corner_color']);?> bg-<?php echo esc_attr($settings['corner_color']);?> absolute <?php echo esc_attr($settings['show_corner']);?>"></div>
        <?php }
        if(isset($settings['show_edge']) && $settings['show_edge'] != 'no') { ?>
            <div class="cms-section-edge cms-section-edge-<?php echo esc_attr($settings['show_edge']);?> cms-section-edge-<?php echo esc_attr($settings['edge_size']);?> absolute <?php echo esc_attr($settings['show_edge']); ?> rtl-flip">
                <?php if($settings['show_edge'] == 'top-left'){ ?>
                    <svg class="cms-edge-tl cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-<?php echo esc_attr($settings['edge_color']); ?>" d="M180,0.456H0V151"/>
                      <path data-name="secondary" class="fill-<?php echo esc_attr($settings['edge2_color']); ?> cms_floating_image_image" data-speed="0.8" d="M180,0L0,151V316L180,164V0Z"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($settings['edge3_color']); ?> cms_floating_image_image" data-speed="1.2" d="M90,34L0.142,109.378v82.37L90,115.868V34Z"/>
                    </svg>
                <?php } elseif ($settings['show_edge'] == 'top-right') { ?>
                    <svg class="cms-edge-tr cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-<?php echo esc_attr($settings['edge_color']); ?>" d="M0,0.458H180V151"/>
                      <path data-name="secondary" class="fill-<?php echo esc_attr($settings['edge2_color']); ?> cms_floating_image_image" data-speed="0.8" d="M0,0L180,151V316L0,164V0Z"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($settings['edge3_color']); ?> cms_floating_image_image" data-speed="1.2" d="M90,34l89.858,75.381v82.369L90,115.87V34Z"/>
                    </svg>
                <?php } elseif ($settings['show_edge'] == 'bot-left') { ?>
                    <svg class="cms-edge-bl cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-<?php echo esc_attr($settings['edge_color']); ?>" d="M180,315.539H0V165"/>
                      <path data-name="secondary" class="fill-<?php echo esc_attr($settings['edge2_color']); ?> cms_floating_image_image" data-speed="0.8" d="M180,316L0,165V0L180,152V316Z"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($settings['edge3_color']); ?> cms_floating_image_image" data-speed="1.2" d="M90,282L0.142,206.617V124.248L90,200.128V282Z"/>
                    </svg>
                <?php } elseif ($settings['show_edge'] == 'bot-right') { ?>
                    <svg class="cms-edge-br cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-<?php echo esc_attr($settings['edge_color']); ?>" d="M0,315.538H180V165"/>
                      <path data-name="secondary" class="fill-<?php echo esc_attr($settings['edge2_color']); ?> cms_floating_image_image" data-speed="0.8" d="M0,316L180,165V0L0,152V316Z"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($settings['edge3_color']); ?> cms_floating_image_image" data-speed="1.2" d="M90,282l89.858-75.38V124.246L90,200.127V282Z"/>
                    </svg>
                <?php } elseif ($settings['show_edge'] == 'bot-left2') { ?>
                    <svg class="cms-edge-bl2 cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 191.281">
                      <path data-name="white" class="fill-<?php echo esc_attr($settings['edge_color']); ?>" d="M180,315.539H0V165" transform="translate(0 -124.25)"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($settings['edge3_color']); ?> cms_floating_image_image" data-speed="-2" d="M90,282L0.142,206.617v-82.37L90,200.127V282Z" transform="translate(0 -124.25)"/>
                    </svg>
                <?php } elseif ($settings['show_edge'] == 'bot-right2') { ?>
                    <svg class="cms-edge-br2 cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 191.281">
                      <path data-name="white" class="fill-<?php echo esc_attr($settings['edge_color']); ?>" d="M0,315.54H180V165" transform="translate(0 -124.25)"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($settings['edge3_color']); ?> cms_floating_image_image" data-speed="-2" d="M90,282l89.858-75.382V124.249L90,200.128V282Z" transform="translate(0 -124.25)"/>
                    </svg>
                <?php } ?>
            </div>
        <?php }
        $html .= ob_get_clean();
        
        // Return
        return $html;
    }
}
/**
 * Custom Elementor Column
 * Add options horizontal element
 * 
 * **/
if(!function_exists('allianz_custom_column_params')){
    add_filter('etc-custom-column/custom-params', 'allianz_custom_column_params');
    function allianz_custom_column_params(){
        return array(
            'sections' => array(
                array(
                    'name'     => 'custom_section',
                    'label'    => esc_html__( 'Custom Settings', 'allianz' ),
                    'tab'      => Controls_Manager::TAB_LAYOUT,
                    'controls' => array(
                        array(
                            'name'    => 'element_display',
                            'label'   => esc_html__( 'Element Display Settings', 'allianz' ),
                            'type'    => Controls_Manager::SELECT,
                            'options' => array(
                                ''           => __( 'Default', 'allianz' ),
                                'vert'   => __( 'Vertical', 'allianz' ),
                                'horiz' => __( 'Horizontal', 'allianz' ),
                            ),
                            //'control_type' => 'responsive',
                            'label_block'  => true, 
                            'default'      => '',
                            'prefix_class' => 'cms-column-'
                        ),
                        array(
                            'name' => 'element_display_gap',
                            'label'   => esc_html__( 'Element Gap', 'allianz' ),
                            'type'    => Controls_Manager::SELECT,
                            'options' => array(
                                '10' => '10',
                                '20' => '20',
                                '30' => '30',
                                '40' => '40'
                            ),
                            'label_block'  => true, 
                            'default'      => '40',
                            'prefix_class' => 'gap-',
                            'condition'    => [
                                'element_display' => ['horiz']
                            ]
                        ),
                        array(
                            'name'         => 'show_gradient',
                            'label'        => esc_html__( 'Gradient Style', 'allianz' ),
                            'type'         => Controls_Manager::SELECT,
                            'prefix_class' => 'cms-gradient-',
                            'options'      => allianz_elementor_gradient_opts(),
                            'default' => '',
                            'separator' => 'before'
                        )
                    )
                )
            )
        );
    }
}
/**
 * Custom Elementor Container
 * */
if(!function_exists('allianz_custom_container_register_controls')){
    add_action('etc-custom-container-register-controls', 'allianz_custom_container_register_controls');
    function allianz_custom_container_register_controls($container){
        // Overwrite Default Option
        $container->start_controls_section(
            'cms_section_layout_container',
            [
                'label' => esc_html__( 'Custom Container', 'allianz' ),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
            $container->add_control(
                'content_width',
                [
                    'label'   => esc_html__( 'Content Width', 'allianz' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'boxed',
                    'options' => [
                        'boxed'            => esc_html__( 'Boxed', 'allianz' ),
                        'boxed-wide'       => esc_html__( 'Boxed Wide (No Container)', 'allianz' ),
                        'boxed-wide-con'   => esc_html__( 'Boxed Wide (Has Container)', 'allianz' ),
                        'full'             => esc_html__( 'Full Width', 'allianz' ),
                        'full-nospace'     => esc_html__( 'Full Width - No Space', 'allianz' ),
                        'full-space-start' => esc_html__( 'Full Width - Space Start', 'allianz' ),
                        'full-space-end'   => esc_html__( 'Full Width - Space End', 'allianz' ),
                    ],
                    'render_type'        => 'template',
                    'prefix_class'       => 'e-con-',
                    'frontend_available' => true,
                ],
                [
                    'overwrite' => true
                ]
            );
            $container->add_control(
                'container_width',
                [
                    'label'   => esc_html__( 'Container Width', 'allianz' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        ''           => esc_html__( 'Default', 'allianz' ),
                        'boxed-wide' => esc_html__( 'Boxed Wide', 'allianz' ),
                    ],
                    'render_type'        => 'template',
                    'prefix_class'       => 'cms-econ-',
                    'frontend_available' => true,
                ]
            );
        $container->end_controls_section();
        // Custom Background
        $container->start_controls_section(
            'container_bg',
            [
                'label' => esc_html__( 'Custom Background', 'allianz' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $container->add_control(
                'bg_parallax',
                [
                    'label'        => esc_html__( 'Parallax', 'allianz' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'prefix_class' => 'cms-parallax-'
                ]
            );
            $container->add_control(
                'bg_parallax_speed',
                [
                    'label'   => esc_html__( 'Parallax Speed', 'allianz' ),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => 0.5,
                    'min'     => 0,
                    'max'     => 2,
                    'condition' => [
                        'bg_parallax' => 'yes'
                    ],
                    'attrs' => [
                        'data-stellar-background-ratio' => '{{VALUE}}'
                    ] 
                ]
            );
        $container->end_controls_section();
        // Custom Overlay
        $container->start_controls_section(
            'container_overlay',
            [
                'label' => esc_html__( 'Custom Overlay', 'allianz' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $container->add_control(
                'cms_overlay_overflow',
                [
                    'label'        => esc_html__( 'Overflow', 'allianz' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => [
                        ''                => esc_html__('Default','allianz'),
                        'overflow-hidden' => esc_html__('Hidden','allianz')
                    ],
                    //'prefix_class' => 'cms-gradient-'
                ]
            );
            $container->add_control(
                'cms_gradient',
                [
                    'label'        => esc_html__( 'Gradient Overlay', 'allianz' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => allianz_elementor_gradient_opts(),
                    //'prefix_class' => 'cms-gradient-'
                ]
            );
            $container->add_control(
                'cms_shadow',
                [
                    'label'        => esc_html__( 'Shadow Overlay', 'allianz' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => [
                        ''  => esc_html__('None', 'allianz'),
                        '1' => esc_html__('Style 1', 'allianz'),
                        '2' => esc_html__('Style 2', 'allianz'),
                        '4' => esc_html__('Style 4', 'allianz'),
                        '7' => esc_html__('Style 7', 'allianz')
                    ],
                    //'prefix_class' => 'cms-shadow-overlay-'
                ]
            );
            $container->add_control(
                'cms_shape_top',
                [
                    'label'        => esc_html__( 'Shape Top', 'allianz' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => [
                        ''           => esc_html__('None', 'allianz'),
                        'cms-line'   => esc_html__('Line', 'allianz'),
                        'cms-line-2' => esc_html__('Line 2', 'allianz')
                    ],
                    //'prefix_class' => 'cms-shape-top cms-shape-'
                ]
            );
            $container->add_control(
                'cms_shape_top_color',
                [
                    'label'        => esc_html__( 'Shape Top Color', 'allianz' ),
                    'type'         => Controls_Manager::COLOR,
                    'selectors'  => [
                        '{{WRAPPER}}' => '--cms-shape-top-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'cms_shape_top!' => ''
                    ]
                ]
            );
            $container->add_control(
                'cms_shape_top_negative',
                [
                    'label'        => esc_html__( 'Shape Top Invert', 'allianz' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'condition' => [
                        'cms_shape_top!' => ''
                    ]
                ]
            );
            $container->add_responsive_control(
                'cms_shape_top_margin',
                [
                    'label'      => esc_html__( 'Shape Top Margin', 'allianz' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px'],
                    'selectors'  => [
                        '{{WRAPPER}}' => '--cms-shape-top-margin-block-start: {{TOP}}{{UNIT}}; --cms-shape-top-margin-block-end: {{BOTTOM}}{{UNIT}}; --cms-shape-top-margin-inline-start:'.allianz_logical_dimensions_inline_start().'; --cms-shape-top-margin-inline-end: '.allianz_logical_dimensions_inline_end().';'
                    ],
                    'condition' => [
                        'cms_shape_top!' => ''
                    ]
                ]
            );
            $container->add_control(
                'cms_shape_bottom',
                [
                    'label'        => esc_html__( 'Shape Bottom', 'allianz' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => [
                        ''           => esc_html__('None', 'allianz'),
                        'cms-line'   => esc_html__('Line', 'allianz'),
                        'cms-line-2' => esc_html__('Line 2', 'allianz')
                    ],
                    //'prefix_class' => 'cms-shape-bottom cms-shape-',
                    'separator'    => 'top'
                ]
            );
            $container->add_control(
                'cms_shape_bottom_color',
                [
                    'label'        => esc_html__( 'Shape Bottom Color', 'allianz' ),
                    'type'         => Controls_Manager::COLOR,
                    'selectors'  => [
                        '{{WRAPPER}}' => '--cms-shape-bottom-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'cms_shape_bottom!' => ''
                    ]
                ]
            );
            $container->add_control(
                'cms_shape_bottom_negative',
                [
                    'label'        => esc_html__( 'Shape Bottom Invert', 'allianz' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'condition' => [
                        'cms_shape_bottom!' => ''
                    ]
                ]
            );
            $container->add_responsive_control(
                'cms_shape_bottom_margin',
                [
                    'label'      => esc_html__( 'Shape Bottom Margin', 'allianz' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px'],
                    'selectors'  => [
                        '{{WRAPPER}}' => '--cms-shape-bottom-margin-block-start: {{TOP}}{{UNIT}}; --cms-shape-bottom-margin-block-end: {{BOTTOM}}{{UNIT}}; --cms-shape-bottom-margin-inline-start:'.allianz_logical_dimensions_inline_start().'; --cms-shape-bottom-margin-inline-end: '.allianz_logical_dimensions_inline_end().';'
                    ],
                    'condition' => [
                        'cms_shape_bottom!' => ''
                    ]
                ]
            );
        $container->end_controls_section();
    }
}
// Add custom attribute to container / section
if(!function_exists('allianz_elementor_section_custom_attributes')){
    add_action( 'elementor/element/after_add_attributes', 'allianz_elementor_section_custom_attributes' );
    function allianz_elementor_section_custom_attributes( \Elementor\Element_Base $element ) {
        if('container' === $element->get_name()){
            $element->add_render_attribute( '_wrapper', [
                'data-sticky-container' => ''
            ]);
            if ( 'yes' == $element->get_settings( 'bg_parallax' ) ) {
                $element->add_render_attribute( '_wrapper', [
                    'class'                         => 'cms-bg-parallax',
                    'data-stellar-background-ratio' => $element->get_settings('bg_parallax_speed')
                ] ) ;
            }
            if ( !in_array($element->get_settings( 'cms_gradient' ), ['','none']) ) {
                $element->add_render_attribute( '_wrapper', [
                    //'class' => 'cms-gradient-'.$element->get_settings( 'cms_gradient' ),
                ] );
            }
        }
    }
}
// Add custom html to Container - Backend Editor
// etc-custom-container/before-elementor-editor-container
// etc-custom-container/after-elementor-editor-container
add_filter('etc-custom-container/before-elementor-editor-container', 'allianz_before_elementor_editor_container', 10 , 2);
if(!function_exists('allianz_before_elementor_editor_container')){
    function allianz_before_elementor_editor_container($settings){
    ?>
        <#  if ( '' !== settings.cms_gradient || '' !== settings.cms_shape || '' !== settings.cms_shape_top || '' !== settings.cms_shape_bottom) { #>
            <div class="cms-container-overlay cms-gradient-{{settings.cms_gradient}}">
                <div class="cms-container--overlay cms-sticky {{settings.cms_overlay_overflow}}" style="--cms-sticky-top:0;">
        <# } #>
            <#  if ( '' !== settings.cms_gradient ) { #>
                <div class="cms-gradient-render cms-egradient-render"></div>
            <# } #>
            <#  if ( '' !== settings.cms_shadow ) { #>
                <div class="cms-econ-shadow cms-econ-shadow-{{settings.cms_shadow}}"><div class="shadow-1"></div><div class="shadow-2"></div><div class="shadow-3"></div></div>
            <# } #>
            <#  if ( '' !== settings.cms_shape_top ) { #>
               <div class="cms-shape-top cms-shape-top-{{settings.cms_shape}}" data-negative="{{settings.cms_shape_top_negative}}">
                <#  if ( 'cms-line' === settings.cms_shape_top ) { #>
                    <?php allianz_elementor_shape_line(); ?>
                <# } #>  
                <#  if ( 'cms-line-2' === settings.cms_shape_top ) { #>
                    <?php allianz_elementor_shape_line2(); ?>
                <# } #>  
               </div>
            <# } #>
            <#  if ( '' !== settings.cms_shape_bottom ) { #>
                <div class="cms-shape-bottom cms-shape-bottom-{{settings.cms_shape}}" data-negative="{{settings.cms_shape_bottom_negative}}">
                <#  if ( 'cms-line' === settings.cms_shape_bottom ) { #>
                    <?php allianz_elementor_shape_line(); ?>
                <# } #>  
                <#  if ( 'cms-line-2' === settings.cms_shape_bottom ) { #>
                    <?php allianz_elementor_shape_line2(); ?>
                <# } #>
                </div>
            <# } #>
        <#  if ( '' !== settings.cms_gradient || '' !== settings.cms_shape || '' !== settings.cms_shape_top || '' !== settings.cms_shape_bottom) { #>
                </div>
            </div>
        <# } #>
    <?php
    }
}
// Custom HTML Elementor Container (Frontend)
// etc-custom-container/before-elementor-container
// etc-custom-container/after-elementor-container
add_filter('etc-custom-container/before-elementor-container', 'allianz_before_elementor_container', 11 , 2);
if(!function_exists('allianz_before_elementor_container')){
    function allianz_before_elementor_container( $html, $settings){
        if(
            isset($settings['cms_gradient']) && !in_array($settings['cms_gradient'], ['','none'])
         || isset($settings['cms_shadow']) && !in_array($settings['cms_shadow'], ['','none'])
         || isset($settings['cms_shape_top']) && !in_array($settings['cms_shape_top'], ['','none'])
         || isset($settings['cms_shape_bottom']) && !in_array($settings['cms_shape_bottom'], ['','none'])
        ){
            $html .= '<div class="cms-container-overlay cms-gradient-'.$settings['cms_gradient'].'"><div class="cms-container--overlay cms-sticky '.$settings['cms_overlay_overflow'].'" style="--cms-sticky-top:0;">';
        }
            // Overlay Gradient
            if(isset($settings['cms_gradient']) && !in_array($settings['cms_gradient'], ['','none']) ){
                $html .= '<div class="cms-gradient-render cms-egradient-render"></div>';
            }
            // Shadow overlay
            if(isset($settings['cms_shadow']) && !in_array($settings['cms_shadow'], ['','none']) ){
                $html .= '<div class="cms-econ-shadow cms-econ-shadow-'.$settings['cms_shadow'].'"><div class="shape-1"></div><div class="shape-2"></div><div class="shape-3"></div></div>';
            }
            // Shape top
            if(isset($settings['cms_shape_top']) && !in_array($settings['cms_shape_top'], ['','none']) ){
                $html .= allianz_render_shape_divider($settings, 'top');
            }
            // Shape Bottom
            if(isset($settings['cms_shape_bottom']) && !in_array($settings['cms_shape_bottom'], ['','none']) ){
                $html .= allianz_render_shape_divider($settings, 'bottom');
            }
        if(
            isset($settings['cms_gradient']) && !in_array($settings['cms_gradient'], ['','none'])
         || isset($settings['cms_shadow']) && !in_array($settings['cms_shadow'], ['','none'])
         || isset($settings['cms_shape_top']) && !in_array($settings['cms_shape_top'], ['','none'])
         || isset($settings['cms_shape_bottom']) && !in_array($settings['cms_shape_bottom'], ['','none'])
        ){
            $html .= '</div></div>';
        }
        // Return
        return $html;
    }
}

function allianz_render_shape_divider( $settings, $side = 'top', $echo = false) {
    $base_setting_key = "cms_shape_$side";
    $negative = ! empty( $settings[ $base_setting_key . '_negative' ] );
    $shape_path = Shapes::get_shape_path( $settings[ $base_setting_key ], $negative );
    if ( ! is_file( $shape_path ) || ! is_readable( $shape_path ) ) {
        return;
    }
    ob_start();
    ?>
    <div class="cms-shape-<?php echo esc_attr( $side ); ?> cms-shape-<?php echo esc_attr( $side ); ?>-<?php echo esc_attr($settings[ $base_setting_key ]); ?>" data-negative="<?php
        Utils::print_unescaped_internal_string( $negative ? 'true' : 'false' );
    ?>">
        <?php
        // PHPCS - The file content is being read from a strict file path structure.
        //echo Utils::file_cms____get_contents( $shape_path ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        ?>
    </div>
    <?php
    if($echo){
        echo ob_get_clean();
    } else {
        return ob_get_clean();
    }
}

// Custom Elementor Shape 
if(!function_exists('allianz_elementor_shapes')){
    add_filter('elementor/shapes/additional_shapes', 'allianz_elementor_shapes');
    function allianz_elementor_shapes($shapes){
        $shapes = [
            'cms-waves' => [
                'title'        => __( 'CMS Waves', 'allianz' ),
                'has_negative' => true,
                'url'          => get_template_directory_uri().'/assets/svg/cms-waves.svg',
                'path'         => get_template_directory().'/assets/svg/cms-waves.svg'
            ],
            'cms-line' => [
                'title'        => __( 'CMS Line', 'allianz' ),
                'has_negative' => true,
                'url'          => get_template_directory_uri().'/assets/svg/cms-line.svg',
                'path'         => get_template_directory().'/assets/svg/cms-line.svg'
            ],
            'cms-line-2' => [
                'title'        => __( 'CMS Line 2', 'allianz' ),
                'has_negative' => true,
                'url'          => get_template_directory_uri().'/assets/svg/cms-line-2.svg',
                'path'         => get_template_directory().'/assets/svg/cms-line-2.svg'
            ]
        ];
        return $shapes;
    }
}

/**
 *  Filter add svg icon to image content
 * 
*/
add_filter('elementor/extended_allowed_html_tags/image', function () {
    $image = \Elementor\Utils::EXTENDED_ALLOWED_HTML_TAGS['image'];
    $svg = \Elementor\Utils::EXTENDED_ALLOWED_HTML_TAGS['svg'];
    return array_merge($image, $svg);
});
// Change html tag for Elementor image render
if(!function_exists('allianz_elementor_image_size_get_attachment_image_html')){
    add_filter('elementor/image_size/get_attachment_image_html','allianz_elementor_image_size_get_attachment_image_html', 10, 4);
    function allianz_elementor_image_size_get_attachment_image_html($html, $settings, $image_size_key, $image_key){
        // Check variation for custom
        $settings['attachment_id'] = isset($settings['attachment_id']) ? $settings['attachment_id'] : '';
        $settings['as_background'] = isset($settings['as_background']) ? $settings['as_background'] : false;
        if($settings['as_background'] === true) $settings['as_background'] = 'yes';
        $settings['as_background_class'] = isset($settings['as_background_class']) ? $settings['as_background_class'] : '';
        $settings['max_height'] = isset($settings['max_height']) ? $settings['max_height'] : false;
        $settings['min_height'] = isset($settings['min_height']) ? $settings['min_height'] : false;
        $settings['lazy'] = isset($settings['lazy']) ? $settings['lazy'] : false;
        $settings['duration'] = isset($settings['duration']) ? $settings['duration'] : '';
        // \Elementor\Group_Control_Image_Size::print_attachment_image_html( $settings, $args['image_size_key'], $args['name'] )
        //
        if ( ! $image_key ) {
            $image_key = $image_size_key;
        }
        $image = $settings[ $image_key ];
        if ( ! isset($settings[ $image_size_key . '_size' ]) || empty($settings[ $image_size_key . '_size' ]) ) {
            $settings[ $image_size_key . '_size' ] = $settings['size'];
        }
        // Lazy attribute
        $lazy_attr = '';
        if($settings['lazy']) $lazy_attr = ' loading="lazy"';

        $size = $settings[ $image_size_key . '_size' ];

        $image_class = $overlay_class = ['cms-lazy lazy-loading'];
        $image_class[] = isset($settings['img_class']) ? $settings['img_class'] : '';
        $image_class[] = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '';
        $image_class = implode(' ', array_filter($image_class));
        $overlay_class = implode(' ', array_filter($overlay_class));
        $html = '';
        // If is the new version - with image size.
        $image_sizes = get_intermediate_image_sizes();
        $image_sizes[] = 'full';

        if ( ! empty( $image['id'] ) && ! wp_attachment_is_image( $image['id'] ) ) {
            $image['id'] = '';
        }
        $is_static_render_mode = \Elementor\Plugin::$instance->frontend->is_static_render_mode();
        // On static mode don't use WP responsive images.
        if ( ! empty($image['id']) ) {
            $image_bg = wp_get_attachment_image_src( $image['id'], 'full');
        } else {
            $image_bg = [Utils::get_placeholder_image_src()];
        }
        // overlay background
        if($settings['as_background'] == 'overlay'){
            $settings['min_height'] = true;
            $overlay_class .= ' relative '.$settings['img_class'];
            $image_class .= ' cms-overlay img-cover';
        }
        // as background
        if($settings['as_background'] == 'yes' ){
            $overlay_class .= ' cms-bg-cover '.$settings['as_background_class'];
        }
        // Render
        if ( ! empty( $image['id'] ) && in_array( $size, $image_sizes ) && ! $is_static_render_mode ) {
            // image attributes
            $image_attr = wp_get_attachment_image_src( $image['id'], $size);
            $image_attr['style'] = $image_overlay_style = '';
            // if have max-height style
            if($settings['max_height']){
                $image_attr['style'] .= 'max-height:'.$image_attr[2].'px;';
                $image_overlay_style .= 'max-height:'.$image_attr[2].'px;';
            }
            if($settings['min_height']){
                $image_attr['style'] .= 'min-height:'.$image_attr[2].'px;';
                $image_overlay_style .= 'min-height:'.$image_attr[2].'px;';
            }
            // As background style
            if($settings['as_background']){
                $image_attr['style'] .= '--cms-bg-lazyload:url('.$image_bg[0].');background-image:var(--cms-bg-lazyload-loaded);';
                if($settings['aspect_ratio']){
                    $image_attr['style'] .= 'aspect-ratio:'.$image_attr[1].'/'.$image_attr[2].';';
                }
            }
            // As Background Fix 
            $as_backgound_fix = '<div style="aspect-ratio:'.$image_attr[1].'/'.$image_attr[2].';max-width:'.$image_attr[1].'px; max-height:'.$image_attr[2].'px;"></div>';
            // image html
            $image_html_attrs = [ 'class'=> $image_class, 'loading' => 'lazy'];
            $image_html_attrs['data-duration'] =  $settings['duration'];
            $image_html_attrs['style'] =  $image_attr['style'];

            $image_html = wp_get_attachment_image( $image['id'], $size, false, $image_html_attrs);
            switch ($settings['as_background']) {
                case 'overlay':
                        $html = sprintf(
                            '<div class="%s" style="%s" data-as-background="%s">%s%s</div>',
                            $overlay_class,
                            $image_overlay_style,
                            $settings['as_background'],
                            $image_html,
                            $settings['content']
                        );
                        break;
                case 'yes' :
                    $html = sprintf(
                        '<div class="%s" style="%s" data-as-background="%s">%s%s</div>',
                        $overlay_class,
                        $image_attr['style'],
                        $settings['as_background'],
                        empty($settings['content']) ? $as_backgound_fix : '',
                        $settings['content']
                    );
                break;
                default:
                    $html = $image_html;
                break;
            }
        } else {
            $custom_dimension = isset($settings[ $image_key . '_custom_dimension' ]) ? $settings[ $image_key . '_custom_dimension' ] : ['width' => get_option('large_size_w'), 'height' => get_option('large_size_h')];
            $custom_dimension =  wp_parse_args($custom_dimension, ['width'=>'','height' => '']);
            $image_src = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $image['id'], $image_size_key, $settings );
            if ( ! $image_src && isset( $image['url'] ) ) {
                $image_src = $image['url'];
            }

            if ( ! empty( $image_src ) ) {
                $image_class_html = ! empty( $image_class ) ? ' class="' . $image_class . '"' : '';
                $image_style = $image_overlay_style = $data_bg = '';
                
                if($settings['as_background']){
                    $data_bg = '';
                    $image_style .= '--cms-bg-lazyload:url('.$image_bg[0].');background-image:var(--cms-bg-lazyload-loaded);';
                    
                    if($settings['aspect_ratio']){
                        $image_style .= 'aspect-ratio:'.$custom_dimension['width'].'/'.$custom_dimension['height'].';';
                    }
                }
                
                // if have max-height style
                $max_height = $min_height = '';
                if($settings['max_height']){
                    $max_height = 'max-height:'.$custom_dimension['height'].'px;';
                    $image_style .= $max_height;
                    $image_overlay_style .= $max_height;
                }
                if($settings['min_height']){
                    $min_height = 'min-height:'.$custom_dimension['height'].'px;';
                    $image_style .= $min_height;
                    $image_overlay_style .= $min_height;
                }

                if(!empty($image_style)) $image_style = ' style="'.$image_style.'"';
                if(!empty($image_overlay_style)) $image_overlay_style = ' style="'.$image_overlay_style.'"';

                // As Background Fix 
                //$as_backgound_fix = '<div style="aspect-ratio:'.$custom_dimension['width'].'/'.$custom_dimension['height'].';max-width:'.$custom_dimension['width'].'px;max-height:'.$custom_dimension['height'].'px;"></div>';
                $as_backgound_fix = sprintf( '<img width="%s" height="%s" src="%s" class="%s" alt="%s" fetchpriority="high" loading="lazy" />', 
                    $custom_dimension['width'],
                    $custom_dimension['height'],
                    esc_attr( $image_src ), 
                    'as-bg-fix cms-lazy', 
                    \Elementor\Control_Media::get_image_alt( $image )
                );
                // Render
                switch ($settings['as_background']) {
                    case 'overlay':
                        $image = sprintf( '<img width="%s" height="%s" src="%s" class="%s" alt="%s" loading="lazy" />', 
                            $custom_dimension['width'],
                            $custom_dimension['height'],
                            esc_attr( $image_src ), 
                            $image_class, 
                            \Elementor\Control_Media::get_image_alt( $image )
                        );
                        $html = sprintf(
                            '<div class="%1$s" %2$s data-as-background="%3$s">%4$s%5$s</div>',
                            $overlay_class,
                            $image_overlay_style,
                            $settings['as_background'],
                            $image,
                            $settings['content']
                        );
                        break;
                    case 'yes' :
                        $html = sprintf(
                            '<div class="%1$s"%2$s data-as-background="%3$s">%4$s%5$s</div>',
                            $overlay_class,
                            $image_style,
                            $settings['as_background'],
                            empty($settings['content']) ? $as_backgound_fix : '',
                            $settings['content']
                        );
                        break;
                    default:
                        $html = sprintf( '<img width="%1$s" height="%2$s" src="%3$s" alt="%4$s" %5$s%6$s%7$s />', 
                            $custom_dimension['width'],
                            $custom_dimension['height'],
                            esc_attr( $image_src ),
                            \Elementor\Control_Media::get_image_alt( $image ),
                            $image_class_html,
                            $lazy_attr,
                            $image_style
                        );
                        break;
                }
            }
        }
        return $html;
    }
}
// Elementor Image Render
if(!function_exists('allianz_elementor_image_render')){
    function allianz_elementor_image_render( $settings = [], $args = []){
        if(!class_exists('\Elementor\Plugin') || !class_exists('Elementor_Theme_Core')) return;
        $args = wp_parse_args($args, [
            'name'                => 'image',
            'attachment_id'       => '',
            'size'                => 'medium',
            'image_size_key'      => '',
            'img_class'           => '',
            'duration'            => '',
            'custom_size'         => ['width' => get_option('medium_size_w'), 'height' => get_option('medium_size_h')],
            'max_height'          => false,
            'min_height'          => false,
            'as_background'       => false,
            'as_background_class' => '',
            'lazy'                => true,
            'content'             => '',   
            'before'              => '',
            'after'               => '',
            'edge'                => [],
            'attrs'               => [],
            'aspect_ratio'        => false  
        ]);
        $args['edge'] = wp_parse_args($args['edge'], [
            'show_edge'      => 'no', // top-left/top-right/bot-left/bot-right/bot-left2/bot-right2
            'edge_color'     => 'white',
            'edge2_color'    => 'secondary',
            'edge3_color'    => 'accent',
            'edge_speed'     => '0',
            'edge2_speed'    => '0',
            'edge3_speed'    => '1.0',
            'class'          => ''
        ]);

        if(empty($args['image_size_key'])) $args['image_size_key'] = $args['name'];
        // image by attachment ID
        if(in_array($args['attachment_id'], ['','0', '-1'])){
            $attachment_url = Utils::get_placeholder_image_src();
        } else {
            $attachment_url = wp_get_attachment_image_url($args['attachment_id'], 'full');
        }
        if(!empty($args['attachment_id']) || $args['attachment_id'] == '0'  || $args['attachment_id'] == '-1'){
            $settings[$args['name']] = [
                'id'  => $args['attachment_id'],
                'url' => $attachment_url
            ];
        }
        $settings['img_class'] = $args['img_class'];
        $settings['duration'] = $args['duration'];
        $settings['aspect_ratio'] = $args['aspect_ratio'];
        
        if(!isset($settings[$args['name'].'_custom_dimension'])){
            $settings[$args['name'].'_custom_dimension'] = $args['custom_size'];
        } else {
            $settings[$args['name'].'_custom_dimension']['width'] = !empty($settings[$args['name'].'_custom_dimension']['width']) ? $settings[$args['name'].'_custom_dimension']['width'] : $args['custom_size']['width'];
            
            $settings[$args['name'].'_custom_dimension']['height'] = !empty($settings[$args['name'].'_custom_dimension']['height']) ? $settings[$args['name'].'_custom_dimension']['height'] : $args['custom_size']['height'];
        }
        // as Background
        $settings['as_background'] = $args['as_background'];
        $settings['as_background_class'] = $args['as_background_class'];
        $settings['content'] = $args['content'];
        // set min/max height
        $settings['min_height'] = $args['min_height'];
        $settings['max_height'] = $args['max_height'];
        //
        $settings['size'] = $args['size'];
        $settings['lazy'] = $args['lazy'];
        $settings['attrs'] = $args['attrs'];
        // classes
        $edge_classes = [
            'cms-edge',
            'cms-edge-'.$args['edge']['show_edge'],
            'absolute',
            $args['edge']['show_edge'],
            'rtl-flip',
            $args['edge']['class']
        ];
        // Edge
        ob_start ();
        if($args['edge']['show_edge'] != 'no') { ?>
            <div class="<?php echo allianz_nice_class($edge_classes); ?>">
                <?php if($args['edge']['show_edge'] == 'top-left'){ ?>
                    <svg class="cms-edge-tl cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-<?php echo esc_attr($args['edge']['edge_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge_speed']);?>" d="M180,0.456H0V151"/>
                      <path data-name="secondary" class="fill-<?php echo esc_attr($args['edge']['edge2_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge2_speed']);?>" d="M180,0L0,151V316L180,164V0Z"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($args['edge']['edge3_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge3_speed']);?>" d="M90,34L0.142,109.378v82.37L90,115.868V34Z"/>
                    </svg>
                <?php } elseif ($args['edge']['show_edge'] == 'top-right') { ?>
                    <svg class="cms-edge-tr cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-<?php echo esc_attr($args['edge']['edge_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge_speed']);?>" d="M0,0.458H180V151"/>
                      <path data-name="secondary" class="fill-<?php echo esc_attr($args['edge']['edge2_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge2_speed']);?>" d="M0,0L180,151V316L0,164V0Z"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($args['edge']['edge3_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge3_speed']);?>" d="M90,34l89.858,75.381v82.369L90,115.87V34Z"/>
                    </svg>
                <?php } elseif ($args['edge']['show_edge'] == 'bot-left') { ?>
                    <svg class="cms-edge-bl cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-<?php echo esc_attr($args['edge']['edge_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge_speed']);?>"  d="M180,315.539H0V165"/>
                      <path data-name="secondary" class="fill-<?php echo esc_attr($args['edge']['edge2_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge2_speed']);?>" d="M180,316L0,165V0L180,152V316Z"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($args['edge']['edge3_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge3_speed']);?>" d="M90,282L0.142,206.617V124.248L90,200.128V282Z"/>
                    </svg>
                <?php } elseif ($args['edge']['show_edge'] == 'bot-right') { ?>
                    <svg class="cms-edge-br cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 316">
                      <path data-name="white" class="fill-<?php echo esc_attr($args['edge']['edge_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge_speed']);?>"  d="M0,315.538H180V165"/>
                      <path data-name="secondary" class="fill-<?php echo esc_attr($args['edge']['edge2_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge2_speed']);?>" d="M0,316L180,165V0L0,152V316Z"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($args['edge']['edge3_color']); ?> cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge3_speed']);?>" d="M90,282l89.858-75.38V124.246L90,200.127V282Z"/>
                    </svg>
                <?php } elseif ($args['edge']['show_edge'] == 'bot-left2') { ?>
                    <svg class="cms-edge-bl2 cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 191.281">
                      <path data-name="white" class="fill-<?php echo esc_attr($args['edge']['edge_color']); ?>cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge_speed']);?>" d="M180,315.539H0V165" transform="translate(0 -124.25)"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($args['edge']['edge3_color']); ?>" data-speed="<?php echo esc_attr($args['edge']['edge3_speed']);?>" d="M90,282L0.142,206.617v-82.37L90,200.127V282Z" transform="translate(0 -124.25)"/>
                    </svg>
                <?php } elseif ($args['edge']['show_edge'] == 'bot-right2') { ?>
                    <svg class="cms-edge-br2 cms_floating_image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 191.281">
                      <path data-name="white" class="fill-<?php echo esc_attr($args['edge']['edge_color']); ?>cms_floating_image_image" data-speed="<?php echo esc_attr($args['edge']['edge_speed']);?>" d="M0,315.54H180V165" transform="translate(0 -124.25)"/>
                      <path data-name="accent" class="fill-<?php echo esc_attr($args['edge']['edge3_color']); ?>" data-speed="<?php echo esc_attr($args['edge']['edge3_speed']);?>" d="M90,282l89.858-75.382V124.249L90,200.128V282Z" transform="translate(0 -124.25)"/>
                    </svg>
                <?php } ?>
            </div>
        <?php }
        $edge = ob_get_clean();
        if(empty($settings[$args['name']]['url'])) return;
        printf('%s', $args['before']);
            // Print image
            \Elementor\Group_Control_Image_Size::print_attachment_image_html( $settings, $args['image_size_key'], $args['name'] );
            // Print Edge
            printf('%s', $edge);
        printf('%s', $args['after']);
    }
}
// Elementor Image Src Render
if(!function_exists('allianz_elementor_image_src_render')){
    function allianz_elementor_image_src_render($args = [], $settings = []){
        $args = wp_parse_args($args, [
            'attachment_id'  => '',
            'image_size_key' => '',
            'default'        => true,
            'echo'           => true
        ]);
        
        $settings[$args['image_size_key'].'_size'] = isset($settings[$args['image_size_key'].'_size']) ? $settings[$args['image_size_key'].'_size'] : 'full';

        $image_src = Group_Control_Image_Size::get_attachment_image_src($args['attachment_id'], $args['image_size_key'], $settings);
        if(empty($image_src) && $args['default']){
            $image_src = Utils::get_placeholder_image_src();
        }
        if(empty($image_src)) return false;
        
        if($args['echo']){
            printf('%s', $image_src);
        } else {
            return $image_src;
        }
    }
}
// Elementor Button Video Render
if(!function_exists('allianz_elementor_button_video_stroke')){
    function allianz_elementor_button_video_stroke($args = []){
        $args = wp_parse_args($args, [
            'width'       => 232,
            'height'      => 232,
            'color'       => 'var(--cms-primary)',
            'color_hover' => 'var(--cms-accent)',
            'class'       => '' 
        ]);
        $classes = ['cms-video-play-stroke', $args['class']];
    ?>
        <svg class="<?php echo allianz_nice_class($classes); ?>" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="<?php echo esc_attr($args['width']).'px'; ?>" height="<?php echo esc_attr($args['height'].'px'); ?>" viewBox="0 0 300 300" style="enable-background:new 0 0 300 300;" xml:space="preserve">
            <circle class="cms-stroke-1" fill="none" stroke="<?php echo esc_attr($args['color']); ?>" cx="150" cy="150" r="149"></circle>
            <circle class="cms-stroke-2" fill="none" stroke="<?php echo esc_attr($args['color_hover']) ?>" cx="150" cy="150" r="149"></circle>
        </svg>
    <?php
    }
}
// Video Render
if(!function_exists('allianz_elementor_video_render')){
    function allianz_elementor_video_render($args = []){
        $args = wp_parse_args($args, [
            'url' => ''
        ]);
        if(empty($args['url'])) return;
        $video_url    = $args['url'];
        $embed_params = [
            'loop'           => '1',
            'controls'       => '0',
            'mute'           => '1',
            'rel'            => '0',
            'modestbranding' => '0',
            'playsinline'    => '1',
            'autoplay'       => '1'   
        ];
        $embed_options = [];
        $url = \Elementor\Embed::get_embed_url( $video_url, $embed_params, $embed_options );
    ?>
        <div class="elementor-video"></div>
        <iframe src="<?php etc_print_html($url); ?>" frameborder="0" allowfullscreen="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" style="width: 100%;height: 100%;" ></iframe>
    <?php
    }
}
// Button Video Lightbox
if(!function_exists('allianz_elementor_button_video_render')){
    function allianz_elementor_button_video_render($widget = [], $settings = [], $args = []){
        $args = wp_parse_args($args, [
            'name'       => 'video_link',
            'layout'     => '1',
            // text
            'text'       => '',
            'text_class' => 'flex-basic',
            //icon
            'icon'       => ['library' => 'cmsi', 'value' => 'cmsi-play'],
            'icon_class' => 'flex-auto',
            'icon_size'  => '20',
            'icon_color' => '',
            //class
            'class'         => '',
            'inner_class'   => '',
            'content_class' => 'd-flex gap-10 align-items-center',
            'echo'          => true,
            'attrs'         => [],
            'loop'          => false,
            'loop_key'      => '',
            // stroke 
            'stroke'      => false,
            'stroke_opts' => [
                'width'  => 232,
                'height' => 232
            ],
            // html
            'before'    => '',
            'after'     => ''
        ]);
        if(empty($settings[$args['name']])) return;

        $lightbox_id = 'cms-lightbox-'.$widget->get_setting('element_id');
        $video_url = $settings['video_link'];
        $embed_params = [
            'loop'           => '0',
            'controls'       => '1',
            'autoplay'       => '1',
            'mute'           => '1',
            'rel'            => '0',
            'modestbranding' => '0'
        ];
        $embed_options = [];
        $lightbox_options = [
            'type'         => 'video',
            'videoType'    => 'youtube',
            'url'          => \Elementor\Embed::get_embed_url( $video_url, $embed_params, $embed_options ),
            'modalOptions' => [
                'id'                       => $lightbox_id,
                'entranceAnimation'        => '',
                'entranceAnimation_tablet' => '',
                'entranceAnimation_mobile' => '',
                'videoAspectRatio'         => 169
            ]
        ];

        if(!$args['loop']){
            $video_key = 'video-attrs';
            if($settings['lightbox'] == 'yes'){
                $widget->add_render_attribute($video_key, [
                    'data-elementor-open-lightbox' => 'yes',
                    'data-elementor-lightbox'      => wp_json_encode( $lightbox_options )
                ]);
            }
            $widget->add_render_attribute($video_key, [
                'class' => implode(' ', array_filter([
                    'cms-btn-video', 
                    'layout-'.$args['layout'], 
                    $args['class'], 
                    'cms-transition'
                ])),
            ]);
            $widget->add_render_attribute($video_key, $args['attrs']);
        } else {
            $video_key = $widget->get_repeater_setting_key( 'video_key', 'cms_video', $args['loop_key'] );
            $widget->add_render_attribute($video_key, [
                'class' => allianz_nice_class([
                    'cms-btn-video', 
                    'layout-'.$args['layout'], 
                    $args['class'], 
                    'cms-transition'
                ]),
                'data-elementor-open-lightbox' => 'yes',
                'data-elementor-lightbox'      => wp_json_encode( $lightbox_options )
            ]);
            $widget->add_render_attribute($video_key, $args['attrs']);
        }
        // inner
        $video_inner_key = 'video-inner-key';
        $widget->add_render_attribute($video_inner_key, [
            'class' => allianz_nice_class([
                'cms-btn--video',
                'cms-hover-backdrop-psedure',
                $args['inner_class']
            ])
        ]);
        // content class
        $video_content_classe = ['cms-btn-video-content z-top', $args['content_class']];

        if($args['stroke']){
            $widget->add_render_attribute($video_key, [
                'class' => 'has-stroke'
            ]);
            //
            $widget->add_render_attribute($video_inner_key, [
                'style' => 'width:'.$args['stroke_opts']['width'].'px;height:'.$args['stroke_opts']['height'].'px;'
            ]);
            //
            $video_content_classe[] = 'absolute center';
        }
        ob_start();
            printf('%s', $args['before']);
        ?>
            <div <?php etc_print_html($widget->get_render_attribute_string($video_key)); ?>>
                <div <?php etc_print_html($widget->get_render_attribute_string($video_inner_key)); ?>>
                    <?php 
                        if($args['stroke']){
                            allianz_elementor_button_video_stroke($args['stroke_opts']);
                        }
                    ?>
                    <div class="<?php echo allianz_nice_class($video_content_classe); ?>">
                        <?php allianz_elementor_icon_render($args['icon'], [], [
                            'arial-hidden' => "true", 
                            'class'        => ['cms-play-icon cms-icon', 'cms-transition', $args['icon_class']], 
                            'icon_size'    => $args['icon_size'], 
                            'icon_color'   => $args['icon_color'] 
                        ]); ?>
                        <span class="cms-text empty-none <?php echo esc_attr($args['text_class']); ?>"><?php etc_print_html($args['text']) ?></span>
                    </div>
                </div>
            </div>
        <?php
            printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
// Elementor Post Image Render
if(!function_exists('allianz_elementor_post_thumbnail_render')){
    function allianz_elementor_post_thumbnail_render( $settings = [], $args = []){
        if(!class_exists('\Elementor\Plugin') || !class_exists('Elementor_Theme_Core')) return;
        $args = wp_parse_args($args, [
            'post_id'        => '',
            'image_size_key' => 'thumbnail',
            'size'           => 'custom',
            'custom_size'    => ['width' => get_option('medium_size_w'), 'height' => get_option('medium_size_h')],
            'lazy'           => true,
            'as_background'  => false,
            'max_height'     => false,   
            'min_height'     => false,
            'img_class'      => '',
            'content'        => '',
            'before'         => '',
            'after'          => ''
        ]);

        $settings['img_class']  = $args['img_class'];
        $settings['min_height'] = $args['min_height'];
        $settings['max_height'] = $args['max_height'];
        $settings['size']       = $args['size'];
        $settings['lazy']       = $args['lazy'];
        // as Background
        $settings['as_background'] = $args['as_background'];
        $settings['content'] = $args['content'];
        
        // post thumbnail or placeholder image
        $settings[$args['image_size_key']] = [
            'id'  => get_post_thumbnail_id($args['post_id']),
            'url' => !empty(get_the_post_thumbnail_url($args['post_id'])) ? get_the_post_thumbnail_url($args['post_id']) : \Elementor\Utils::get_placeholder_image_src()
        ];
        $settings[$args['image_size_key'].'_size'] = isset($settings[$args['image_size_key'].'_size']) ? $settings[$args['image_size_key'].'_size'] : $args['size'];

        if(!isset($settings[$args['image_size_key'].'_custom_dimension'])){
            $settings[$args['image_size_key'].'_custom_dimension'] = $args['custom_size'];
        } else {
            $settings[$args['image_size_key'].'_custom_dimension']['width'] = !empty($settings[$args['image_size_key'].'_custom_dimension']['width']) ? $settings[$args['image_size_key'].'_custom_dimension']['width'] : $args['custom_size']['width'];
            
            $settings[$args['image_size_key'].'_custom_dimension']['height'] = !empty($settings[$args['image_size_key'].'_custom_dimension']['height']) ? $settings[$args['image_size_key'].'_custom_dimension']['height'] : $args['custom_size']['height'];
        }
        printf('%s', $args['before']);
        // Print image
        \Elementor\Group_Control_Image_Size::print_attachment_image_html( $settings, $args['image_size_key'], $args['image_size_key'] );
        printf('%s', $args['after']);
    }
}
// Elementor Build Post Layout 
if(!function_exists('allianz_get_post_grid')){
    function allianz_get_post_grid($settings = [], $posts = [], $posts_data = [], $args = []){
        if(empty($posts) || !is_array($posts) || empty($posts_data) || !is_array($posts_data)){
            return false;
        }
        extract($posts_data); 
        // Start build post item 
        $count = 0;
        // Custom content
        if(!empty($posts_data['grid_custom_content'])){
        ?>
            <div class="<?php echo implode(' ', array_filter(['cms-item-custom-content pr-110 pr-tablet-extra-0'])); ?>">
                <?php etc_print_html($posts_data['grid_custom_content']); ?>
            </div>
        <?php
        }
        foreach ($posts as $post):
            $count ++;
            ?>
            <div class="<?php echo implode(' ', array_filter(['cms-item',$posts_data['item_class'], 'item-'.$count])); ?>">
                <?php switch ($settings['layout']) {
                    case '10':
                ?>
                <div class="cms--item bg-white cms-shadow-2 cms-hover-shadow-1 cms-transition overflow-hidden pt-50 pb-40 p-lr-50 p-lr-smobile-20">
                    <?php
                        // Career Info
                        allianz_post_career_render([
                            'id'    => $post->ID,
                            'class' => 'mb-20'
                        ]);
                    ?>
                    <?php /* Post Title */ ?>
                    <h4 class="cms-heading text-22 text-line-2 lh-13 font-body font-600"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a></h4>
                    <?php /* Post Excerpt */ ?>
                    <div class="post-excerpt text-line-4 empty-none text-15 cms-transition pt-20"><?php 
                        echo wp_trim_words($post->post_excerpt, $posts_data['num_words'], '&hellip;');
                    ?></div>
                    <?php /* Post Read More */ ?>
                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-link cms-hover-underline-3 cms-hover-move-icon-up d-inline-flex gap-10 align-items-center text-15 font-700 text-accent text-hover-accent pt-60 mb-n10" title="<?php etc_print_html($posts_data['readmore_text']); ?>"><?php
                        // text
                        etc_print_html($posts_data['readmore_text']); 
                        // icon
                        allianz_elementor_button_icon_render([
                            'icon'   => 'arrow-right-hover-up'
                        ]);
                    ?></a>
                </div>
                <?php
                    break;
                    case '9':
                ?>
                    <div class="cms--item cms-hover-show-readmore cms-hover-icon-alternate hover-image-zoom-in">
                        <?php 
                        // Post readmore
                        ob_start(); 
                        ?>
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-readmore text-white text-hover-white absolute center zoom-out cms-hover-move-icon-up text-12 circle bg-accent d-flex align-items-center justify-content-center" title="<?php etc_print_html($posts_data['readmore_text']); ?>"><?php
                                allianz_elementor_svg_hover_icon_render();
                            ?></a>
                        <?php
                        $readmore = ob_get_clean();
                        // Post Image
                        allianz_elementor_post_thumbnail_render($settings, [
                            'post_id'     => $post->ID,
                            'custom_size' => $posts_data['thumbnail_custom_dimension'],
                            'img_class'   => 'img-cover swiper-nav-vert',
                            'before'      => '<div class="relative"><a href="'.esc_url(get_permalink( $post->ID )).'" class="cms-post-thumbnail overflow-hidden d-block mb-15">',
                            'after'       => '</a>'.$readmore.'</div>'
                        ]);
                        /* Post category */
                        allianz_the_terms($post->ID, $posts_data['taxonomy'], '<span class="separator">|</span>', 'text-primary text-hover-accent', [
                            'before' => '<div class="post-cat cms-transition d-flex gap-10 text-13 pb-15 text-primary">',
                            'after'  => '</div>'  
                        ]);
                        ?>
                        <?php /* Post Title */ ?>
                        <h5 class="post-title text-20 text-line-3 lh-13 font-body font-600 mt-n5">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php 
                                echo get_the_title($post->ID); 
                            ?></a>
                        </h5>   
                    </div>
                <?php
                    break;
                    case '8':
                ?>
                    <div class="cms--item bg-white-04 bg-hover-white cms-hover-show-readmore text-hover-body cms-transition p-50 pb-40 p-lr-tablet-extra-40 p-lr-mobile-20 cms-hover-change relative overflow-hidden cms-backdrop"><?php
                        // Post Icon
                        allianz_post_icon_render([
                            'id'               => $post->ID,
                            'class'            => 'd-inline-flex align-items-center justify-content-center cms-radius-8 mb-70 cms-gradient-inner-grow',     
                            'before'           => '',
                            'after'            => '',
                            'wrap_before'      => '',
                            'wrap_after'       => '',
                            'icon_class'       => 'relative z-top',
                            'icon_color'       => 'white',
                            'icon_color_hover' => 'white',
                            'size'             => 48  
                        ]);
                    ?>
                        <?php /* Post Title */ ?>
                        <h5 class="cms-heading text-22 text-line-2 lh-13 font-body font-600 text-on-hover-primary text-white text-hover-accent mt-n5"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a></h5>
                        <?php /* Post Excerpt */ ?>
                        <div class="post-excerpt text-line-6 empty-none text-15 pt-20 pb-3 cms-transition text-white text-on-hover"><?php 
                            echo wp_trim_words($post->post_excerpt, $posts_data['num_words'], '');
                        ?></div>
                        <?php /* Post category */ ?>
                        <?php 
                            allianz_the_terms($post->ID, $posts_data['taxonomy'], '', 'text-white text-on-hover-primary text-hover-white bg-hover-accent bdr-1 bdr-white bdr-on-hover-primary bdr-hover-accent-regular cms-radius-4 p-tb-3 p-lr-10', [
                                'before' => '<div class="post-cat cms-transition d-flex gap-5 text-13 pt-40 mt-30 bdr-t-1 bdr-white bdr-on-hover-border">',
                                'after'  => '</div>'  
                            ]);
                        ?>
                        <?php /* Post Read More */ ?>
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-readmore cms-readmore-icon text-white text-hover-white bg-primary absolute top-right cms-hover-move-icon-up text-12" title="<?php etc_print_html($posts_data['readmore_text']); ?>"><?php allianz_elementor_svg_hover_icon_render(['class' => 'rtl-flip']); ?></a>
                    </div>
                <?php
                    break;
                    case '7':
                ?>
                    <div class="cms--item cms-hover-show-readmore cms-hover-hide hover-image-zoom-in">
                        <?php 
                        // Post Image
                        allianz_elementor_post_thumbnail_render($settings, [
                            'post_id'     => $post->ID,
                            'custom_size' => $posts_data['thumbnail_custom_dimension'],
                            'img_class'   => 'img-cover swiper-nav-vert',
                            'before'      => '<a href="'.esc_url(get_permalink( $post->ID )).'" class="cms-post-thumbnail overflow-hidden d-block mb-30">',
                            'after'       => '</a>'  
                        ]);
                        ?>
                        <div class="d-flex gap-20 flex-nowrap flex-tablet-wrap justify-content-between relative">
                            <?php /* Post Title */ ?>
                            <h5 class="post-title text-20 text-line-3 lh-13 font-body font-600 mt-n5">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php 
                                    echo get_the_title($post->ID); 
                                ?></a>
                            </h5>
                            <div class="flex-auto flex-tablet-100 order-tablet-first relative">
                                <?php 
                                    /* Post category */
                                    allianz_the_terms($post->ID, $posts_data['taxonomy'], '', 'text-primary text-hover-white bg-white bg-hover-accent bdr-1 bdr-primary-regular bdr-hover-accent-regular cms-radius-4 p-tb-3 p-lr-10', [
                                        'before' => '<div class="post-cat cms-transition d-flex gap-5 text-13 hide-on-hover">',
                                        'after'  => '</div>'  
                                    ]);
                                ?>
                                <?php /* Post Read More */ ?>
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-readmore text-primary text-hover-accent absolute top-right in-bot-up cms-hover-move-icon-up text-40" title="<?php etc_print_html($posts_data['readmore_text']); ?>"><?php
                                    allianz_elementor_svg_hover_icon_render();
                                ?></a>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                    case '6':
                ?>
                    <div class="cms--item bg-grey bg-hover-accent bg-on-hover text-hover-white cms-transition p-50 p-lr-tablet-extra-40 p-lr-mobile-20 relative cms-hover-show-readmore hover-icon-bounce">
                        <?php
                            // Post Icon
                            allianz_post_icon_render([
                                'id'          => $post->ID,
                                'class'       => 'mb-30',     
                                'before'      => '',
                                'after'       => '',
                                'wrap_before' => '',
                                'wrap_after'  => '',
                                'icon_class'  => 'cms-icon',
                                'icon_color'  => 'primary text-on-hover',
                                'size'        => 68,
                                'echo'        => true  
                            ]);
                        ?>
                        <?php /* Post Title */ ?>
                        <h5 class="cms-heading text-22 text-line-2 lh-13 font-body font-600 mt-n5 text-on-hover pb-55"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="text-hover-primary"><?php echo get_the_title($post->ID); ?></a></h5>
                        <?php 
                            /* Post category */ 
                            allianz_the_terms($post->ID, $posts_data['taxonomy'], ', ', 'text-accent text-hover-white text-on-hover-primary', [
                                'before' => '<div class="post-cat text-accent text-on-hover-primary text-15 font-600 text-line-1">',
                                'after'  => '</div>'  
                            ]);
                        ?>
                        <?php /* Post Excerpt */ ?>
                        <div class="post-excerpt text-line-5 empty-none text-15 pt-20 mb-40"><?php 
                            echo wp_trim_words($post->post_excerpt, $posts_data['num_words'], '');
                        ?></div>
                        <?php /* Post Read More */ ?>
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-readmore-icon text-white text-hover-white bg-accent bg-hover-primary bg-on-hover-primary absolute bottom-left cms-hover-move-icon-up text-12" title="<?php etc_print_html($posts_data['readmore_text']); ?>"><?php allianz_elementor_svg_hover_icon_render(['class' => 'rtl-flip']); ?></a>
                    </div>
                <?php
                    break;
                    case '5':
                ?>
                    <div class="cms--item bg-white bg-hover-grey cms-transition p-50 p-lr-tablet-extra-40 p-lr-mobile-20 relative cms-hover-show-readmore">
                        <?php
                            // Post Icon
                            allianz_post_icon_render([
                                'id'          => $post->ID,
                                'class'       => 'mb-60',     
                                'before'      => '',
                                'after'       => '',
                                'wrap_before' => '',
                                'wrap_after'  => '',
                                'icon_class'  => '',
                                'icon_color'  => 'primary',
                                'size'        => 68,
                                'echo'        => true  
                            ]);
                        ?>
                        <?php /* Post Title */ ?>
                        <h5 class="cms-heading text-22 text-line-2 lh-13 font-body font-600 mt-n5"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a></h5>
                        <?php /* Post Excerpt */ ?>
                        <div class="post-excerpt text-line-6 empty-none text-15 pt-20 mb-n7 cms-transition"><?php 
                            echo wp_trim_words($post->post_excerpt, $posts_data['num_words'], '');
                        ?></div>
                        <?php /* Post Read More */ ?>
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-readmore cms-readmore-icon text-white text-hover-white bg-primary absolute top-right cms-hover-move-icon-up text-12" title="<?php etc_print_html($posts_data['readmore_text']); ?>"><?php allianz_elementor_svg_hover_icon_render(['class' => 'rtl-flip']); ?></a>
                    </div>
                <?php
                    break;
                    case '4x':
                ?>
                    <div class="cms--item bg-white cms-shadow-6 cms-hover-shadow-4 cms-transition p-50 p-lr-tablet-extra-40 p-lr-mobile-20 cms-e-holder relative cms-hover-show-readmore cms-hover-bg-shadow-1 cms-transition overflow-hidden">
                        <?php
                            //allianz_hover_gradient_holder();
                        ?>
                        <div class="relative z-top overflow-hidden">
                            <?php
                                // Post Icon
                                allianz_post_icon_render([
                                    'id'          => $post->ID,
                                    'class'       => 'mb-40',     
                                    'before'      => '',
                                    'after'       => '',
                                    'wrap_before' => '',
                                    'wrap_after'  => '',
                                    'icon_class'  => '',
                                    'icon_color'  => 'primary',
                                    'size'        => '96',
                                    'echo'        => true  
                                ]);
                            ?>
                            <?php /* Post Title */ ?>
                            <h5 class="cms-heading text-22 text-line-2 lh-13 font-body font-600 ls-03 mt-n5"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a></h5>
                            <?php /* Post Excerpt */ ?>
                            <div class="post-excerpt text-line-6 empty-none text-15 pt-20 mb-60 cms-transition"><?php 
                                echo wp_trim_words($post->post_excerpt, $posts_data['num_words'], '');
                            ?></div>
                            <?php /* Post Read More */ ?>
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-readmore text-accent text-hover-accent absolute bottom-left text-mixed cms-hover-icon-alternate" title="<?php etc_print_html($posts_data['readmore_text']); ?>"><?php 
                                allianz_elementor_button_icon_render([
                                    'icon'   => 'alternate',
                                    'before' => '<span class="text-55 rtl-flip text-mixed">',
                                    'after'  => '</span>'
                                ]);
                             ?></a>
                            <?php /* Post category */ ?>
                            <?php 
                                allianz_the_terms($post->ID, $posts_data['taxonomy'], '', 'text-primary text-hover-white bg-white bg-hover-accent bdr-1 bdr-primary-regular bdr-hover-accent-regular cms-radius-4 p-tb-3 p-lr-10', [
                                    'before' => '<div class="post-cat cms-transition d-flex gap-5 text-13 pt-3">',
                                    'after'  => '</div>'  
                                ]);
                            ?>
                        </div>
                    </div>
                <?php
                    break;
                    case '4':
                ?>
                    <div class="cms--item bg-white cms-shadow-6 cms-hover-shadow-4 cms-transition p-50 p-lr-tablet-extra-40 p-lr-mobile-20 cms-e-holder relative cms-hover-show-readmore">
                        <?php
                            allianz_hover_gradient_holder();
                        ?>
                        <div class="relative z-top overflow-hidden">
                            <?php
                                // Post Icon
                                allianz_post_icon_render([
                                    'id'          => $post->ID,
                                    'class'       => 'mb-40',     
                                    'before'      => '',
                                    'after'       => '',
                                    'wrap_before' => '',
                                    'wrap_after'  => '',
                                    'icon_class'  => '',
                                    'icon_color'  => 'primary',
                                    'size'        => '96',
                                    'echo'        => true  
                                ]);
                            ?>
                            <?php /* Post Title */ ?>
                            <h5 class="cms-heading text-22 text-line-2 lh-13 font-body font-600 ls-03 mt-n5"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a></h5>
                            <?php /* Post Excerpt */ ?>
                            <div class="post-excerpt text-line-6 empty-none text-15 pt-20 mb-60 cms-transition"><?php 
                                echo wp_trim_words($post->post_excerpt, $posts_data['num_words'], '');
                            ?></div>
                            <?php /* Post Read More */ ?>
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-readmore text-accent text-hover-accent absolute bottom-left text-mixed" title="<?php etc_print_html($posts_data['readmore_text']); ?>"><span class="allianz-icon-up-right-arrow text-55 rtl-flip"></span></a>
                            <?php /* Post category */ ?>
                            <?php 
                                allianz_the_terms($post->ID, $posts_data['taxonomy'], '', 'text-primary text-hover-white bg-white bg-hover-accent bdr-1 bdr-primary-regular bdr-hover-accent-regular cms-radius-4 p-tb-3 p-lr-10', [
                                    'before' => '<div class="post-cat cms-transition d-flex gap-5 text-13 pt-3">',
                                    'after'  => '</div>'  
                                ]);
                            ?>
                        </div>
                    </div>
                <?php
                    break;
                    case '3':
                ?>
                    <div class="cms--item bg-white cms-shadow-1 cms-hover-shadow-2 cms-transition p-50 p-lr-tablet-extra-40 p-lr-mobile-20"><?php
                        // Post Icon
                        allianz_post_icon_render([
                            'id'          => $post->ID,
                            'class'       => 'mb-40',     
                            'before'      => '',
                            'after'       => '',
                            'wrap_before' => '',
                            'wrap_after'  => '',
                            'icon_class'  => '',
                            'icon_color'  => 'accent',
                            'size'        => '48',
                            'echo'        => true  
                        ]);
                    ?>
                        <?php /* Post Title */ ?>
                        <h5 class="cms-heading text-22 text-line-2 lh-13 font-body font-600 ls-03 mt-n5"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a></h5>
                        <?php /* Post Excerpt */ ?>
                        <div class="post-excerpt text-line-7 empty-none text-15 pt-20 cms-transition"><?php 
                            echo wp_trim_words($post->post_excerpt, $posts_data['num_words'], '');
                        ?></div>
                        <?php /* Post Read More */ ?>
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-readmore pt-70 pb-40 mb-n47" data-title="<?php etc_print_html($posts_data['readmore_text']); ?>">
                            <span class="cms-hover-underline-3 cms-hover-move-icon-up d-inline-flex gap-10 align-items-center text-15 font-700 text-accent text-hover-accent"><?php
                            // text
                            etc_print_html($posts_data['readmore_text']); 
                            // icon
                            allianz_elementor_button_icon_render([
                                'icon'   => 'arrow-right-hover-up'
                            ]);
                        ?></span></a>
                    </div>
                <?php
                    break;
                    case '2':
                ?>
                    <div class="cms--item bg-white cms-shadow-2 mt-50 hover-image-zoom-out"><?php
                        // Post category
                        ob_start();
                    ?>
                        <div class="cms-post-meta-2 d-flex gap-5 align-items-center text-13 absolute top-right mt-20 m-lr-20"><?php 
                            allianz_the_terms($post->ID, $posts_data['taxonomy'], '', 'text-primary text-hover-primary cms-hover-underline', [
                                'before_term' => '<span class="cms--term cms-hover-backdrop cms-transition">',
                                'after_term'  => '</span>'  
                            ]);
                        ?></div>
                    <?php
                        $post_category = ob_get_clean();
                        // Post Readmore
                        ob_start();
                    ?>
                        <a href="<?php echo get_permalink( $post->ID );?>" class="cms-btn-readmore absolute bottom-left z-top ml-10 cms-hover-move-icon-up">
                            <span class="cms-btn-icon allianz-icon-up-right-arrow"></span>
                            <span class="cms-btn-text cms-transition start d-flex gap-5"><?php 
                                // text 
                                echo esc_html($posts_data['readmore_text']);
                                // icon
                                allianz_elementor_button_icon_render();
                            ?></span>
                        </a>
                    <?php
                        $post_readmore = ob_get_clean();
                        // Post Image
                        allianz_elementor_post_thumbnail_render($settings, [
                            'post_id'     => $post->ID,
                            'custom_size' => $posts_data['thumbnail_custom_dimension'],
                            'img_class'   => 'img-cover swiper-nav-vert', 
                            'max_height'  => true,
                            'before'      => '<div class="cms-post-thumbnail ml-40 ml-tablet-extra-40 ml-mobile-20 relative overflow-hidden"><div class="cms-post--thumbnail relative overflow-hidden ml-10">',
                            'after'       => $post_category.'</div>'.$post_readmore.'</div>'  
                        ]);
                    ?>
                        <div class="cms--item-content bg-white pb-45 p-lr-50 p-lr-tablet-extra-40 p-lr-mobile-20 relative overflow-hidden cms-transition">
                            <?php /* Post Title */ ?>
                            <h5 class="cms-heading text-20 text-line-2 lh-13 font-body font-600 ls-03 mt-n5"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a></h5>
                            <?php /* Post Excerpt */ ?>
                            <div class="post-excerpt text-line-3 empty-none text-15 pt-20 cms-transition"><?php 
                                echo wp_trim_words($post->post_excerpt, $posts_data['num_words'], '&hellip;');
                            ?></div>
                        </div>
                    </div>
                <?php
                        break;
                    default:
                ?>
                <div class="cms--item bg-white cms-shadow-1 cms-hover-shadow-2 cms-transition overflow-hidden"><?php
                    // Post Image
                    allianz_elementor_post_thumbnail_render($settings, [
                        'post_id'     => $post->ID,
                        'custom_size' => $posts_data['thumbnail_custom_dimension'],
                        'img_class'   => 'img-cover swiper-nav-vert', 
                        'max_height'  => true,
                        'before'      => '<a href="'.esc_url(get_permalink( $post->ID )).'" class="cms-post-thumbnail overflow-hidden">',
                        'after'       => '</a>'  
                    ]);
                    ?>
                    <div class="cms--item-content bg-white p-tb-35 p-lr-50 p-lr-tablet-extra-40 p-lr-mobile-20 relative overflow-hidden cms-transition">
                        <?php /* Post Meta */ ?>
                        <div class="cms-post-meta d-flex gap-10 align-items-center text-13 pb-10"><?php 
                            allianz_the_terms($post->ID, $posts_data['taxonomy'], '<span class="separator small"></span>', 'text-primary text-hover-primary cms-hover-underline');
                        ?></div>
                        <div class="cms--item--content relative cms-transition pb-50">
                            <?php /* Post Title */ ?>
                            <h5 class="cms-heading text-20 text-line-3 lh-13 font-body font-600 ls-03"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a></h5>
                            <?php /* Post Excerpt */ ?>
                            <div class="post-excerpt absolute top-left w-100 text-line-6 empty-none text-15 cms-transition"><?php 
                                echo wp_trim_words($post->post_excerpt, $posts_data['num_words'], '&hellip;');
                            ?></div>
                        </div>
                        <?php /* Post Date */ ?>
                        <div class="post-date text-meta text-14 pt-10"><?php echo get_the_date('', $post->ID); ?></div>
                        <?php /* Post Read More */ ?>
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-readmore absolute bottom-right" title="<?php etc_print_html($posts_data['readmore_text']); ?>"><span class="allianz-icon-up-right-arrow"></span></a>
                    </div>
                </div>
                <?php
                    break;
                } ?>
            </div>
        <?php
        endforeach;
    }
}

/**
 * Elementor SVG icon render
 * 
 * */
if(!function_exists('allianz_elementor_svg_hover_icon_render')){
    function allianz_elementor_svg_hover_icon_render($args=[]){
        $args = wp_parse_args($args, [
            'icon'   => 'up-arrow-right',
            'class'  => '',
            'color1' => 'currentColor',
            'color2' => 'currentColor',
            'echo'   => true,
            'before' => '',
            'after'  => ''   
        ]);
        ob_start();
        printf('%s', $args['before']);
        switch ($args['icon']) {
            case 'up-arrow-right':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z" fill="<?php echo esc_attr($args['color1']) ?>"/>
                </g>
                <g class="cms-hover-move-2">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z" fill="<?php echo esc_attr($args['color2']) ?>"/>
                </g>
            </svg>
        <?php
                break;
            case 'alternate':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" xmlns="http://www.w3.org/2000/svg" width="101.7" height="101.7" viewBox="0 0 101.7 101.7"><g fill="none" stroke="currentColor" stroke-width="6">
                <path d="m.7 101 100-100"></path>
                <path d="M.7 1h100" stroke-width="9">
                </path><path d="M100.7 1v100" stroke-width="9"></path>
            </g></svg>
        <?php
                break;
            case 'alternate-move':
        ?>
            <svg class="<?php echo implode(' ', ['alternate-move', $args['class']]); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" xmlns="http://www.w3.org/2000/svg" width="101.7" height="101.7" viewBox="0 0 101.7 101.7">
                <g class="cms-hover-move-1" fill="none" stroke="currentColor" stroke-width="6">
                    <path d="m.7 101 100-100"></path>
                    <path d="M.7 1h100" stroke-width="9"></path>
                    <path d="M100.7 1v100" stroke-width="9"></path>
                </g>
                <g class="cms-hover-move-2" fill="none" stroke="currentColor" stroke-width="6">
                    <path d="m.7 101 100-100"></path>
                    <path d="M.7 1h100" stroke-width="9"></path>
                    <path d="M100.7 1v100" stroke-width="9"></path>
                </g>
            </svg>
        <?php
                break;
            case 'chevron-right':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                    <path d="m45.414 30.586-24-24c-.78-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l22.585 22.586-22.585 22.586c-.781.781-.781 2.047 0 2.828.39.391.902.586 1.414.586s1.024-.195 1.414-.586l24-24c.781-.781.781-2.047 0-2.828z" fill="<?php echo esc_attr($args['color1']) ?>"/>
                </g>
                <g class="cms-hover-move-2">
                    <path d="m45.414 30.586-24-24c-.78-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l22.585 22.586-22.585 22.586c-.781.781-.781 2.047 0 2.828.39.391.902.586 1.414.586s1.024-.195 1.414-.586l24-24c.781-.781.781-2.047 0-2.828z" fill="<?php echo esc_attr($args['color2']) ?>"/>
                </g>
            </svg>
        <?php
                break;
            case 'arrow-up-hover-right':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                    <path d="m45.414 30.586-24-24c-.78-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l22.585 22.586-22.585 22.586c-.781.781-.781 2.047 0 2.828.39.391.902.586 1.414.586s1.024-.195 1.414-.586l24-24c.781-.781.781-2.047 0-2.828z"/>
                </g>
                <g class="cms-hover-move-2">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z"/>
                </g>
            </svg>
        <?php
                break;
            case 'arrow-right-hover-up':
        ?>
            <svg class="<?php echo esc_attr($args['class']); ?>" fill="<?php echo esc_attr($args['color1']) ?>" fill-hover="<?php echo esc_attr($args['color2']) ?>" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                <g class="cms-hover-move-1">
                    <path d="m56 6h-48c-1.104 0-2 .896-2 2s.896 2 2 2h43.171l-44.585 44.586c-.781.781-.781 2.047 0 2.828.391.391.902.586 1.414.586s1.024-.195 1.414-.586l44.586-44.586v43.172c0 1.104.896 2 2 2s2-.896 2-2v-48c0-1.104-.896-2-2-2z"/>
                </g>
                <g class="cms-hover-move-3">
                    <path d="m45.414 30.586-24-24c-.78-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l22.585 22.586-22.585 22.586c-.781.781-.781 2.047 0 2.828.39.391.902.586 1.414.586s1.024-.195 1.414-.586l24-24c.781-.781.781-2.047 0-2.828z"/>
                </g>
            </svg>
        <?php
                break;
            default:
                // code...
                break;
        }
        printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
if(!function_exists('allianz_elementor_button_icon_render')){
    function allianz_elementor_button_icon_render($args = []){
        $args = wp_parse_args($args, [
            'icon'   => 'up-arrow-right',
            'class'  => 'rtl-flip',
            'color1' => 'currentColor',
            'color2' => 'currentColor',
            'before' => '<span class="btn-icon text-12 lh-1 pt-2">',
            'after'  => '</span>',
            'echo'   => true
        ]);
        allianz_elementor_svg_hover_icon_render($args);
    }
}
/**
 * Custom Post 
 * 
 * */
/**
 * Icon 
*/
if(!function_exists('allianz_post_icon_opts')){
    function allianz_post_icon_opts($args = []){
        $args = wp_parse_args($args, [
            'title'   => __('Choose your icon', 'allianz'),
            'default' => ''
        ]);
        return [
            'title'  => esc_html__('Icon', 'allianz'),
            'fields' => [
                'icon' => [
                    'type'        => Theme_Core_Options::ICON_PICKER_FIELD,
                    'title'       => $args['title'],
                    'default'     => $args['default']  
                ]
            ]
        ];
    }
}
/**
 * Render Icon
*/
if(!function_exists('allianz_post_icon_render')){
    function allianz_post_icon_render($args = []){
        $args = wp_parse_args($args, [
            'id'          => get_the_ID(),
            'class'       => '',     
            'before'      => '',
            'after'       => '',
            'wrap_before' => '',
            'wrap_after'  => '',
            'icon_class'  => '',
            'icon_color'  => 'accent',
            'size'        => '64',
            'echo'        => true    
        ]);
        $icon = allianz_get_post_format_value($args['id'], 'icon', '');
        
        if(empty($icon)) return;
        
        $_icon = '<i class="'.implode(' ',array_filter([$icon,'cms-post--icon','cms-transition','d-block', $args['icon_class'], 'text-'.$args['icon_color'],'text-'.$args['size']])).'"></i>';

        ob_start();
        printf('%s', $args['wrap_before']);
        ?>
            <div class="<?php echo implode(' ',array_filter(['cms-post-icon', $args['class']]));?>"><?php 
                printf('%1$s %2$s %3$s', $args['before'], $_icon, $args['after'] ); 
            ?></div>
        <?php
        printf('%s', $args['wrap_after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
/**
 * Post Features 
*/
if(!function_exists('allianz_post_feature_opts')){
    function allianz_post_feature_opts($args = []){
        return [
            'title'  => esc_html__('Features', 'allianz'),
            'fields' => [
                'features' => [
                    'type'        => Theme_Core_Options::REPEATER_FIELD,
                    'title'       => __('Add your feature', 'allianz'),
                    'fields' => [
                        'text' => [
                            'type' => Theme_Core_Options::TEXT_FIELD,
                            'title' => __('Your feature','allianz')
                        ]
                    ],
                    'title_field' => 'text'
                ]
            ]
        ];
    }
}
if(!function_exists('allianz_post_feature_render')){
    function allianz_post_feature_render($args = []){
        $args = wp_parse_args($args, [
            'id'         => get_the_ID(),
            'name'       => 'features',
            'before'     => '<div class="cms-post-feature text-secondary font-700 text-15">',
            'after'      => '</div>',
            'icon'       => 'cmsi-check text-10',
            'icon_class' => 'text-secondary-lighten',
            'item_class' => 'cms-list-item',
            'echo'       => true
        ]);
        $features = allianz_get_post_format_value($args['id'], $args['name']);
        if(empty( $features)) return;
        ob_start();
            printf('%s', $args['before']);
                foreach ($features as $feature) {
                    $_icon = (isset($feature['icon']) && !empty($feature['icon'])) ? $feature['icon'] : $args['icon'];
                    $icon = !empty($_icon) ? '<div class="'.allianz_nice_class(['flex-auto cms-list-icon', $args['icon_class'], $_icon]).'"></div>' : '';
                    printf('<div class="%s d-flex gap-15">%s<div class="flex-basic">%s</div></div>',$args['item_class'],$icon,$feature['text']);
                }
            printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else  {
            return ob_get_clean();
        }
    }
}
/**
 * Career Opts 
*/
if(!function_exists('allianz_post_career_opts')){
    function allianz_post_career_opts($args = []){
        return [
            'title'  => esc_html__('General', 'allianz'),
            'fields' => [
                'job_type' => [
                    'type'        => Theme_Core_Options::TEXT_FIELD,
                    'title'       => __('Job Type', 'allianz')
                ],
                'job_address' => [
                    'type'        => Theme_Core_Options::TEXT_FIELD,
                    'title'       => __('Job Address', 'allianz')
                ],
                'job_salary' => [
                    'type'        => Theme_Core_Options::TEXT_FIELD,
                    'title'       => __('Job Salary', 'allianz')
                ]
            ]
        ];
    }
}
if(!function_exists('allianz_post_career_render')){
    function allianz_post_career_render($args = []){
        $args = wp_parse_args($args, [
            'id'    => null,
            'class' => ''
        ]);
        if(!$args['id']) return;
        $job_type   = allianz_get_post_format_value($args['id'], 'job_type', '');
        $job_add    = allianz_get_post_format_value($args['id'], 'job_address', '');
        $job_salary = allianz_get_post_format_value($args['id'], 'job_salary', '');

        $classes = ['cms-job-details d-flex gap-15', $args['class']];
    ?>
    <div class="<?php echo implode(' ', array_filter($classes)); ?>">
        <div class="job-type empty-none"><?php echo esc_html($job_type); ?></div>
        <div class="job-add empty-none"><?php echo esc_html($job_add); ?></div>
        <div class="job-sallary empty-none"><?php echo esc_html($job_salary); ?></div>
    </div>
    <?php
    }
}
if(!function_exists('allianz_chart_data_settings')){
    function allianz_chart_data_settings($widget, $settings, $args = []){
        $args = wp_parse_args($args, [
            'name'            => 'cms_chart',
            'chart_container' => 'cms-charts',
            'wrap_class'      => '',  
            'class'           => '',
            'chart_type'      => 'doughnut',
            'custom_data'     => ''  
        ]);
        $charts = $widget->get_settings($args['name']);
        $chart_title = $chart_main_title = $chart_value = $chart_color = [];
        foreach ($charts as $key => $value) {
            $chart_title[] = $value['chart_title'];
            $chart_main_title[] = $value['chart_main_title'];
            $chart_value[] = $value['chart_value'];
            $chart_color[] = $value['chart_color'];
        }
        // Chart Wrap
        $widget->add_render_attribute('charts-wrap', [
            'class' => [
                'cms-charts-wrap',
                $args['wrap_class']
            ]
        ]);
        // Chart Settings   
        $opts = [
            'type'            => $widget->get_setting('cms_chart_type', $args['chart_type']),   
            'labels'          => $chart_title,
            'value'           => $chart_value,
            'colors'          => $chart_color,
            'legend_display'  => $settings['legend_display'],
            'legend_position' => $settings['legend_position'],
            'title_display'   => $settings['title_display'],
            'title_position'  => $settings['title_position'],
            'title_text'      => $widget->get_setting('title_text','CMS Charts')
        ];

        if(!empty($args['custom_data'])){
            $opts = $args['custom_data'];
        }

        $widget->add_render_attribute( 'cms-chart-settings', [
            'id'            => etc_get_element_id($settings),
            'class'         => allianz_nice_class( implode( ' ', [$args['chart_container'], $args['class']] ) ),
            'data-settings' => wp_json_encode($opts)
        ]);
    ?>
        <div <?php etc_print_html($widget->get_render_attribute_string( 'charts-wrap' )); ?>>
            <canvas <?php etc_print_html($widget->get_render_attribute_string( 'cms-chart-settings' )); ?>></canvas>
        </div>
    <?php
    }
}
if(!function_exists('allianz_chart_bar_data_settings')){
    function allianz_chart_bar_data_settings($widget, $settings, $args = []){
        $args = wp_parse_args($args, [
            'name'            => 'cms_chart',
            'chart_container' => 'cms-charts-bar',
            'wrap_class'      => '',  
            'class'           => '',
            'chart_type'      => 'bar',
            'title1'          => $widget->get_setting('chart1_title','Title #1'),
            'color1'          => $widget->get_setting('chart1_color','#616161'),
            'title2'          => $widget->get_setting('chart2_title','Title #2'),
            'color2'          => $widget->get_setting('chart2_color','#161616'),
            'title3'          => $widget->get_setting('chart3_title','Title #3'),
            'color3'          => $widget->get_setting('chart3_color','#fe5b2c'),
        ]);
        $charts = $widget->get_settings($args['name']);
        $chart_title = $chart_value = $chart_color = $chart_datasets = $charts_databar = [];
        foreach ($charts as $key => $value) {
            $charts_databar[] = [
                'x'      => $value['chart_title'],
                'val1'   => $value['chart1_value'],
                'val2'   => $value['chart2_value'], 
                'val3'   => $value['chart3_value']];
        }
        foreach ($charts as $key => $value) {
            $key ++;
            $chart_title[] = $value['chart_title'];
            if(isset($value['chart'.$key.'_value']) && !empty($value['chart'.$key.'_value'])){
                $chart_datasets[] = [
                    'label'           => $args['title'.$key],
                    'data'            => array_filter($charts_databar),
                    'backgroundColor' => $args['color'.$key],
                    'borderColor'     => $args['color'.$key],
                    'parsing'         => [
                        'yAxisKey' => 'val'.$key
                    ],
                    'barThickness'    => 22,
                    'maxBarThickness' => 15,
                ];
            }
        }
        // Chart Wrap
        $widget->add_render_attribute('charts-wrap', [
            'class' => [
                'cms-charts-wrap',
                $args['wrap_class']
            ]
        ]);
        // Chart Settings   
        $opts = [
            'type'            => $widget->get_setting('cms_chart_type', $args['chart_type']),
            //'labels'          => $chart_title,
            //'value'           => $chart_value,
            //'colors'          => $chart_color,
            'datasets'        => $chart_datasets,
            'legend_display'  => $settings['legend_display'],
            'legend_position' => $settings['legend_position'],
            'title_display'   => $widget->get_setting('title_display', false),
            'title_position'  => $widget->get_setting('title_position','top'),
            'title_text'      => $widget->get_setting('title_text','CMS Charts')
        ];
        $widget->add_render_attribute( 'cms-chart-settings', [
            'id'            => etc_get_element_id($settings),
            'class'         => implode( ' ', array_filter([$args['chart_container'], $args['class']]) ),
            'data-settings' => wp_json_encode($opts)
        ]);
    ?>
        <div <?php etc_print_html($widget->get_render_attribute_string( 'charts-wrap' )); ?>>
            <canvas <?php etc_print_html($widget->get_render_attribute_string( 'cms-chart-settings' )); ?>></canvas>
        </div>
    <?php
    }
}
// Hover Gradient
function allianz_hover_gradient_holder($args = []){
    $args = wp_parse_args($args, [
        'echo' => true
    ]);
    ob_start();
?>
    <span class="cms-e-gradient-holder cms-overlay">
        <span class="cms-e-gradient cms-overlay">
            <span class="cms-e-gradient-dot-1"></span>
            <span class="cms-e-gradient-dot-2"></span>
        </span>
    </span>
<?php
    if($args['echo']){
        echo ob_get_clean();
    } else {
        return ob_get_clean();
    }
}

function allianz_elementor_shape_line(){
?>
<svg xmlns="http://www.w3.org/2000/svg" width="1798" height="404" viewBox="0 0 1798 404" class="cms-svg-line">
  <path class="cms-svg--line elementor-shape-fill" d="M1797.57,0.423c1.03-.761.3-0.57-2.68,1.286l-1.93,1.633Zm-20.62,11.634c-3.44,2.307-7.35,5.069-4.87,3.993,3.31-2.449,4.24-2.827,7.78-5.5,2.98-1.863,5.32-3.073,4.89-2.641,1.01-.732,4.72-2.759,6.21-3.953a158.493,158.493,0,0,0-14.1,8.462C1775.7,13.016,1776.73,12.274,1776.95,12.057ZM1467.93,161.663l2.09-.741C1469.45,161.111,1468.73,161.367,1467.93,161.663Zm-204.8,57.561a18.451,18.451,0,0,0,2.32-.555A16.708,16.708,0,0,0,1263.13,219.224Zm-35.9,5.648,2.12-.286C1228.53,224.669,1227.72,224.768,1227.23,224.872Zm240.7-63.209c-1.78.649-3.59,1.226-5.39,1.822A41.952,41.952,0,0,0,1467.93,161.663ZM1736.55,36.939c1.03-.615,1.87-1.145,2.63-1.642-0.84.5-1.65,0.99-2.5,1.493A0.7,0.7,0,0,1,1736.55,36.939Zm-181.64,89.394,1.59-.68q0.675-.363,1.26-0.713Zm65.42-30.172a7.851,7.851,0,0,0-2.34,1.637,29.425,29.425,0,0,1,3.1-1.738A1,1,0,0,0,1620.33,96.161Zm101.5-52.433,1.75-1.023C1723.13,42.971,1722.36,43.42,1721.83,43.727ZM1507.28,146.1a2.8,2.8,0,0,0-.65.134A1.589,1.589,0,0,0,1507.28,146.1ZM55.411,340.644c0.023-.059-0.044-0.01-0.047-0.038C55.1,340.933,55.029,341.043,55.411,340.644ZM0.435,403.327l0.642-.966a0.432,0.432,0,0,0-.011-0.312Zm1160.725-171.2,0.3-.019C1163.2,231.915,1162.21,232.009,1161.16,232.128ZM592.449,258.251c2.267-2.654.571-.378-0.771,1.606s-2.4,3.62.829-.5C591.792,260.052,597.933,251.511,592.449,258.251ZM1734.92,37.837c-0.85.489-1.7,0.987-2.56,1.484C1733.52,38.645,1734.31,38.19,1734.92,37.837ZM592.507,259.36h0l0.684-.836C592.909,258.871,592.749,259.064,592.507,259.36Zm416.283-33.907c0.29,0.125.88,0.3,1.49,0.478A9.034,9.034,0,0,0,1008.79,225.453Zm113.4,9.236-2.82.029Zm-170.046-25.76c-1.41-.6-1.873-0.837-3.829-1.581l0.573,0.278C949.608,207.868,950.548,208.226,952.144,208.929Zm-56.529-24.873,1.026,0.5,1.815,0.74Zm-694.225,40.1c-1.222.588-1.974,0.967-2.587,1.221C199.74,225.093,192.084,229.927,201.39,224.158ZM1736.43,36.79a9.355,9.355,0,0,1-1.51,1.046c0.61-.361,1.19-0.708,1.76-1.046C1736.82,36.657,1736.83,36.6,1736.43,36.79ZM948.768,210.428c-1.535-.607-3.03-1.278-4.515-1.962l-4.472-2.028c1.249,0.572,2.685,1.228,4.207,1.922S947.12,209.786,948.768,210.428ZM625.628,126.67l-2.238-.175C624.25,126.586,625.043,126.653,625.628,126.67Zm287.577,67.884c-1.552-.815-3.221-1.628-4.955-2.443-0.382-.139-0.815-0.308-1.076-0.381ZM198.783,225.387a0.048,0.048,0,0,1,.02-0.008A0.048,0.048,0,0,0,198.783,225.387ZM145.73,262.024c3.709-2.826,4.6-3.465,4.641-3.706,0.061-.217-0.647.072,0.085-0.6,9-6.56,4.391-2.724,7.609-4.735,2.807-2.051,5.205-3.98,7.5-5.668s4.436-3.221,6.6-4.656c0.362-.154,1.215-0.692.283,0.04,1.479-1.095,3.352-2.4,5.437-3.826s4.37-2.985,6.761-4.451c4.746-2.989,9.613-6.068,13.13-8.531a9.253,9.253,0,0,1,1.006-.5c-1.292.548-1.591,0.469-1.433,0.18l2.526-1.63,2.254-1.391a21.881,21.881,0,0,1,3.251-1.762,29.884,29.884,0,0,0-3.338,2.177l3.726-2.319c3.623-1.63-5.1,3.142-4.941,3.405,3.649-2.229,7.6-4.645,11.337-6.931s7.257-4.46,10.2-5.917c0.712-.127-2.683,1.65-5.157,3.186-2.5,1.491-4.2,2.51-.338.466l-8.836,4.973c7.016-3.349-5.341,3.063,1.153.07,5.8-3.283,8.952-5.281,12.2-7.1s6.5-3.63,12.376-6.738c2.53-1.623-1.028.175,1.5-1.449a105.038,105.038,0,0,1,9.337-4.854c2.27-1.053,3.852-1.7,5.291-2.285a88.824,88.824,0,0,0,11.292-5.393,87.64,87.64,0,0,1,13.344-6.627l-2.883,1.816c5.886-2.65,7.5-3.563,9.191-4.478,1.679-.949,3.5-1.763,9.817-4.2-2.154,1.081-9.328,4-7.5,3.308,8.244-3,5.628-2.6,11.86-5.16l1.445-.154,9.734-4.067,10.233-3.9,10.5-4c1.757-.7,3.553-1.3,5.357-1.892l5.415-1.8c-0.764.376-3.2,1.3,0.223,0.321l14.047-4.642,1.8-.585,1.826-.511,3.664-1.023,7.352-2.028,7.325-2c2.437-.633,4.827-1.381,7.252-1.88l14.057-3.17,6.8-1.983c1.6-.378,3-0.553,1.286-0.073,3.519-.8,3.622-0.759,3.228-0.807-0.387-.015-1.241.026,0.447-0.374,4.028-.811,5.368-0.841,2.834-0.239,6.224-1.34,15.085-3.313,24.082-5.033,9.044-1.448,18.191-2.825,24.852-3.644l-2.574.5c5.169-.754,8.088-1.222,10.9-1.747a92.468,92.468,0,0,1,10.381-1.391l-1.842.272c22.565-2.519,47.553-5.045,64.881-5.37,3.263-.727,22.442-0.778,23.884-1.4l7.2,0.088c1.759,0.062,3.08.109,4.566,0.16l5.556,0.136,10.157,0.316c4.858,0.224,7.267-.271,13.283.007l0.128,0.378c2.726,0.006,5.453.022,8.177,0.117l4.3,0.759c1.877,0.111,3.747.287,5.622,0.428a21.951,21.951,0,0,1-4.389-.7c2.2,0.17,4.632.4,7.05,0.652,2.416,0.269,4.806.631,6.932,0.933s3.97,0.667,5.3.915a16.286,16.286,0,0,1,2.19.5c6.861,0.982,13.712,2.109,20.454,3.7-0.491.063-3.866-.777-6.588-1.2,5.46,0.983,5.91,1.278,6.268,1.441,0.347,0.212.609,0.283,5.536,1.48-1.29-.441.767-0.017,1.01-0.027,1.214,0.365,2.791.91,4.614,1.518,0.913,0.3,1.886.623,2.9,0.96l3.124,1.139c2.164,0.734,4.347,1.7,6.533,2.555,1.086,0.444,2.129.956,3.168,1.413s2.053,0.9,2.984,1.4c-0.519-.172-1.028-0.361-1.563-0.5,1.706,0.852,3.412,1.758,5.129,2.686,1.658,1.022,3.42,1.932,5.04,3.082a64.9,64.9,0,0,1,9.5,7.475A45.387,45.387,0,0,1,721.4,176.884c-0.8-2.9-1.083-4.041-.877-3.891a16.209,16.209,0,0,1,1.526,4.016l0.084,2.021c0.962,3.08-1.014-5.1.7,1.286,0.527,3.146.405,4.233,0.286,4.061a4.194,4.194,0,0,1-.268-1.078c-0.127-.594-0.295-1.385-0.483-2.271l0.334,1.884c0.092,0.632.134,1.271,0.2,1.906s0.138,1.272.182,1.911l0.052,1.922c-0.112.451-.191-1.349-0.344-1.809,0.063,0.782.095,2,.072,3.458-0.137,1.456-.172,3.154-0.479,4.876-0.417,3.466-1.349,7.022-1.7,9.29l-0.216.393a100.19,100.19,0,0,1-7.639,19.045,138.59,138.59,0,0,1-9.522,15.625c0.133,0.428-3.1,4.874-5.516,8.321-3.225,4.052-6.833,8.166-10.753,12.348-3.9,4.2-8.125,8.461-12.617,12.8-6.239,6.184-1.661,1.976-4.4,4.833-0.636.268-9.952,8.585-5.264,4.107-5.6,5-9.269,8.085-13.351,11.445-4.1,3.339-8.586,7-16.289,12.522,1.766-1.061,3.691-2.355,2.772-1.575-1.4,1-3.03,2.093-4.267,2.881s-2.113,1.228-1.945,1.035l0.741-.523c-8.7,6.063-19.548,12.179-30.667,15.472a54.484,54.484,0,0,1-8.282,1.712,29.727,29.727,0,0,1-7.828-.113,15.635,15.635,0,0,1-6.439-2.484,13.077,13.077,0,0,1-4.056-4.539l0.449,0.741a18.524,18.524,0,0,1-2.45-7.763,35.584,35.584,0,0,1,.243-8.5c0.192-.974.322-1.631,0.4-2.047a2.343,2.343,0,0,1,.162-0.591,2.016,2.016,0,0,1-.045.406c-0.033.25-.077,0.593-0.123,0.953-0.185,1.436-.4,3.109.218,0.261a57.788,57.788,0,0,1,3.446-12.2,89.74,89.74,0,0,1,4.7-9.96,178.544,178.544,0,0,1,11.536-18.041c3.935-4.576,10.7-12.842,18.605-20.826a201,201,0,0,1,23.332-20.578l-0.868.42c3.155-2.8,4.107-3.022,6.587-4.885-0.449.135-3.747,2.625-1.738,0.942,28.34-21.66,62.666-39.809,98.044-48.809,3.243-.771,5.308-1.335,6.842-1.8s2.555-.737,3.674-1.085a65.412,65.412,0,0,1,13.313-2.359l-4.674,1.069a180.141,180.141,0,0,1,40.8-2.27,237.923,237.923,0,0,1,40.1,5.9c-1.555-.28-1.622-0.188-4.133-0.781,1.344,0.381,3.264.9,5.4,1.427l3.309,0.808,3.323,0.885,5.638,1.448a15.591,15.591,0,0,0,2.439.568c3.934,1.238.851,0.485,3.242,1.344,2.656,0.891,6,1.982,9.058,2.906,3.038,0.98,5.748,1.916,7.1,2.55a19.783,19.783,0,0,1-2.488-.776c3.519,1.02,15.917,6.092,12.777,4.5,9.2,3.8,17.667,7.13,24.876,10.488,4.9,1.738,15.522,7.1,17.238,7.308-0.875.2,15.761,7.606,21.651,9.921-2.036-.65,5.046,2.229,2.65,1.5,6.725,2.716,12.915,5.125,11.843,4.375,3.1,1.213,6.259,2.323,9.348,3.353,3.1,1.008,6.09,2.058,9,2.72a148.012,148.012,0,0,1,14.384,4.134c20.971,4.784,40.711,7.281,59.891,9.067-0.77.738-21.18-2.4-20.44-1.712,9.11,1.006,16.28,1.839,23.48,2.174,3.59,0.25,7.17.5,10.99,0.76s7.88,0.348,12.4.607c4.69,0.279-2.67.118-4.26,0.14l13.48,0.5c4.42,0.117,8.78.087,13.07,0.142l6.39,0.048c2.11,0.015,4.21.044,6.3-.049q6.255-.195,12.34-0.457a8.1,8.1,0,0,1-1.12.107l-2.33.131c3.2-.1,7.45-0.119,7.08-0.354l-3.12.15c-2.56-.112.61-0.382,4.49-0.649,3.89-.2,8.47-0.738,8.75-0.814-5.39,1.023,16.02-.763,7.46.631,2.1-.17,4.73-0.442,4.24-0.577,3.13-.135,4.13-0.1.97,0.275,5.73-.37,7.56-0.666,9.26-0.905s3.27-.438,8.44-0.9c-0.02.122-2.11,0.355-3.17,0.591,2.61-.351,5.23-0.7,8.29-1.05,3.05-.375,6.56-0.624,10.92-1.144-0.52.135,0.51,0.106-2.09,0.414,7.48-.91,13.85-1.822,20.39-2.724,3.28-.41,6.58-1,10.1-1.536s7.23-1.087,11.33-1.635c-4.75,1.223,5.59-.653,6.53-0.34,2.93-.482,5.84-1.091,8.75-1.63l-3.55.4c7.68-1.338,14.4-2.846,21.02-3.857l-5.67,1.179,7.19-1.3,7.14-1.481c-2.71.476-5.41,1.011-8.13,1.438,7.69-1.725-.93-0.371,9.25-2.288-2.05.461,7.64-1.538,11.67-2.084l-0.03.007c3.75-.908,7.61-1.789,13.24-3.008,1.49-.194-1.07.75-0.1,0.628,3.63-1.212,17.77-4.164,22.37-5.623-1.54.448-1.57,0.7-1.05,0.625,1.02-.326,2.03-0.69,3.03-1.052,3.52-.795,4.04-0.878,3.52-0.552,10.53-2.619-3.48.3,9.07-2.637-0.98.273-.5,0.2-2.53,0.761,6.28-1.547,12.34-3.08,18.24-4.7,5.88-1.69,11.63-3.342,17.37-4.87,3.5-.511-9.97,2.9-6,2.187,8.24-2.362,16.78-4.788,25.14-7.545,8.4-2.64,16.73-5.261,24.64-7.748l-2.95.92c1.99-1.325,11.82-3.566,19.7-6.474-1.94.687-2.45,1.178-1.94,0.936,10.86-3.35,21.93-7.646,38.08-13.568l-1.95.866c6.39-2.007,16.55-6.05,23.35-8.512,1.95-.912,5.82-2.352,3.39-1.683,10.63-3.422,20.41-7.6,29.93-11.582q7.125-2.981,14.08-5.881c4.62-1.986,9.21-3.889,13.83-5.656-2.17.932-5.13,2.348-3.4,1.609l15.43-6.764a49.464,49.464,0,0,0-5.43,1.909c1.89-.989,6.21-2.975,10.05-4.617-6.9,3.122.26,0.436,3.28-.82-0.53.149,0.45-.4,0.17-0.363,8.21-3.177,1.11-1.118,12.19-5.766l-0.52.395c4.07-1.921,7.76-3.8,12.19-5.764,1.97-.538-4.29,2.108-4.46,2.475,3.09-1.412,6.09-2.935,9.03-4.385s5.78-2.937,8.63-4.108c-2.58,1.312-6.31,3.151-8.91,4.415,6.24-2.489,6.88-2.956,11.42-5.036l-0.45.2,10.48-4.813-2.69,1.172c7.32-4.44,15.63-7.529,25.61-13.249-9.74,5.472-1.52,1.1-2.12,1.805,2.67-1.226,6.7-3.127,5.61-2.465,4.72-2.7,8.2-3.862,14.85-7.681,0.36-.05,5.19-2.6,4.23-1.786,6.24-3.3-1.57.592-1.12,0.171,9.48-5.34,22.86-11.467,36.43-19.248,11.7-6.727,13.69-8.28,24.54-14.508,3.79-1.882-2.82,2.045-2.82,2.045,6.03-3.179,10.56-5.587,16.03-8.968-1.08.739,0.12,0.144,1.88-.724,4.45-2.608,2.77-2.1,8.74-5.353-0.95.7-2.14,1.628-4.22,2.986,5.18-3.167,10.3-6.3,15.67-9.574,1.54-.66-3.13,2.168-4.98,3.393,6.07-3.612,15.75-9.327,17.42-10.795l-3.94,2.249c2.2-1.346,1.28-.448-0.32.588-5.1,3.256-7.61,4.282-7.96,4.353l3.83-2.308c-4.32,1.713-15.5,9.106-23.32,13.591l3-2.315-7.79,4.991c-1.76.873-3.07,1.3,0.75-.992-5.7,3.04-4.9,2.964-9.87,5.437-0.56.258-.33,0.1,0.16-0.188l-5.45,3.185c1.03-.691-1.09.2,2.34-1.612-10.05,5.23-15.8,9.169-19.72,10.9l0.82-.486c-6.83,3.894-7.14,4.111-6.98,4.172s0.76-.086-4.35,2.855l-7.44,2.906-1.2,1.044c-1.44.746-4.29,2.218-3.83,1.812-5.22,3.037.98-.339-2,1.5-3.53,1.674-8.27,4.22-12.36,6.384-4.1,2.13-7.59,3.811-8.5,3.957-2.38,1.505,6.77-3.16-.59.753-2.41.508-8.56,4.42-15.06,7.363,1.81-1.272,7.92-4.15,1.42-1.207-3.61,2.4-12.42,6.185-17.84,8.8-0.06.513-11.72,5.795-20.76,10.272,0.25-.232-4.02,1.851-9.52,4.252s-12.13,5.326-16.43,7.212l0.22-.18a55.951,55.951,0,0,1-6.51,3.338c-3.2,1.491-7,3.251-10.24,4.645,0.15-.364,1.29-0.916,4.73-2.582-2.01.926-4.06,1.753-6.08,2.636-1.38.744-3.25,1.626-7.18,3.361l1.4-.957c-4.05,1.743-8.1,3.577-12.44,5.509s-8.98,4.013-14.3,5.988c-0.48.523,8.7-2.587-2.36,2.091-0.47.014-.99-0.083,1.9-1.32-0.95.405-3.35,1.5-5.3,2.209l4.34-2.051c-4.84,1.819-2.42,1.226-6.26,2.748-0.02-.25-2.9.986-2.42,0.591,0.96-.415,3.38-1.258,4.81-1.935-4.34,1.7-9.62,3.679-11.41,4.208,0.43-.027.12,0.3-3.03,1.6-8.18,3.308-2.9.879-7.73,2.661-1.93.909-7.26,2.742-7.27,3.125a26.024,26.024,0,0,1-3.88,1.19c-4.22,1.761-19.92,7.589-14.98,6.121l1.1-.391c-0.2.082-.44,0.178-0.69,0.278l0.03-.012-0.03.012c-1.74.7-3.49,1.414-5.27,2.08q-2.685.963-5.4,1.94-5.46,1.894-10.97,3.81c-7.33,2.513-14.64,5.058-21.69,7.383l-0.02-.12c-8.38,2.879-18.69,6.3-24.66,8.418-2.5.763-5.98,1.595-4.95,1.135-6.45,2.058-7.14,2.407-16.56,5.07,6.46-2.181-2.3.51,6.64-2.177-8.46,2.427-10.38,2.968-19.4,5.774,3.01-1.157-6.49,1.415-10.49,2.629l5.99-1.451c-4.51,1.308-8.48,2.389-12.51,3.49l2.07-.993c-8.71,2.276-16.56,4.325-23.86,6.39-3.65,1.014-7.17,1.985-10.63,2.865s-6.87,1.522-10.25,2.1c-4.58,1.333,9.57-1.984,5.5-.719-8.09,1.792-16.63,3.155-19.16,3.731-2.77.57-4.79,1.063-6.46,1.455s-2.96.718-4.27,1.063c-2.63.687-5.32,1.4-11.15,2.5,1.51-.161,2.99-0.073-5.68,1.816a48.079,48.079,0,0,1-7.48,1.118c-0.87-.012-0.07-0.3,2.49-0.834a16.01,16.01,0,0,1,2.82-.487c2.61-.581,6.04-1.338,2.8-0.838l-1.03.352c-4.04.771-15.28,2.663-12.68,1.992-6.14,1.214-2.6.69,1.99-.037-5.26.815-9.34,1.53-13.47,2.26l-6.37,1.121c-2.23.395-4.63,0.687-7.34,1.067,1.73-.177,3.34-0.245,1.63.006-15.9,2.169-6.95,1.3-17.7,2.947-3.07.345-2.54,0.136-2.6,0.063a2.578,2.578,0,0,0-1.04.079c-0.84.11-2.35,0.309-5.06,0.663-6.66.644-1.45-.207,1.17-0.636-4.94.725-9.56,1.231-13.67,1.632-4.1.384-7.67,0.754-10.51,0.935,1.74-.178,3.48-0.394,5.21-0.657-3.11.477-5.67,0.629-8.28,0.883l3.02,0.016a53.52,53.52,0,0,1-5.63.333c-3.15.47,2.47,0.254-3.79,1.071-4.11.2-12.45,1.321-13.9,0.97,12.89-.924-1.45-0.222,9.44-1.236-2.1.234-4.66,0.461-7.74,0.687-0.47,0,.43-0.115,1.26-0.214-12.35.471-5.64,0.781-18.43,1.543,1.61-.308-2.99-0.229-5.07-0.061,5.15-.31,2.49.233-2.24,0.626-8.22.051-8.93,0.359-13.23,0.453l4.91-.052c-1.65.256-5.76,0.338-11.49,0.555-0.5-.152,5.2-0.251,3.15-0.27-1.59.135-3.28,0.2-5.06,0.235-1.79,0-3.67-.087-5.62-0.152-3.91-.143-8.12-0.3-12.56-0.21-4.11-.175-0.39-0.4-3.99-0.528-9.94-.139-10.74-0.756-21.17-0.981,1.49,0.209,2.37.3,1.96,0.336s-2.13.052-5.8-.145c1.43,0.088,2.85.231,4.28,0.274l4.3,0.137,8.57,0.275-11.02-.067c5.17,0.231,10.93.3,14.03,0.484-5.25,0-4.71-.045-2.24.3-7.07-.775-14.08-0.228-22.23-1.316l0.3-.686c-3.06-.33-5.95-0.586-8.82-0.806l-4.31-.325-4.35-.465-9.33-1.01c-1.65-.2-3.38-0.4-5.18-0.615-1.79-.287-3.66-0.624-5.63-0.975l5.05,0.979c-2.16-.081-9.74-1.61-14.87-2.361,0.26-.077-0.41-0.271-1.4-0.511-0.5-.115-1.08-0.248-1.68-0.383-0.58-.163-1.18-0.327-1.71-0.476,0.23,0.229-11.416-2.515-12.944-2.365-1.148-.317-2.307-0.587-3.444-0.94l-3.4-1.094c-6.2-1.78-9.807-2.537-13.328-3.4-3.482-.984-6.916-1.946-12.79-3.958,3.63,0.945-1.656-1,6.276,1.462-3.922-1.317-7.433-2.54-7.552-2.408-2.218-.953-10.76-3.988-14.209-5.6a43.157,43.157,0,0,1-6.524-2.509c-0.445-.252.064-0.1,0.064-0.1-0.066.105-6.725-2.841-3.116-.932-11.358-5.936-32.606-14.691-42.671-19.526-8.39-3.463-18.59-7.427-26.378-10.139a4.209,4.209,0,0,1,1.523.451A57.416,57.416,0,0,0,862.854,172c-0.948-.23-1.941-0.476-3.459-0.937-1.526-.435-3.588-1.048-6.66-2.06-6.211-2.309,6.63,1.822,2.732.473-1.466-1.37-15.022-4.343-23.465-6.541l2.08,0.384c-6.474-1.668-16.025-2.988-26.859-4.147,0,0,.535-0.022.075-0.111-1.868-.064-4.147-0.181-6.677-0.332l-8.2-.215c-2.882-.067-5.86.06-8.769,0.07-2.909.033-5.745,0.3-8.358,0.417,3.236-.458,4.746-0.387,2.743-0.6-2.348.132-2,.24-2.23,0.381a3.559,3.559,0,0,1-1.2.242l-1.692.162-2.822.315-6.153.322a31.223,31.223,0,0,1-4.554.259l4.382-.637,4.408-.426c-1.14,0-2.424.07-3.782,0.179s-2.775.372-4.2,0.586c-2.846.479-5.716,0.893-8,1.357l0.554-.3c-3.334.657-5.839,1.179-7.945,1.64l-5.49,1.51-2.653.733c-0.931.238-1.914,0.521-3,.876-2.175.679-4.8,1.471-8.3,2.486l1.487-.287c-3.733,1.38-5.294,1.953-6.9,2.388-0.8.232-1.6,0.46-2.664,0.813l-1.823.636c-0.686.277-1.463,0.618-2.371,1.02l-2.4.439-4.829,2.034c-1.945.839-4.12,1.928-6.441,3-4.672,2.091-9.615,4.806-13.816,6.91,2.311-1.327,5.892-3.3,9.7-5.25,3.867-1.817,7.869-3.805,11-5.174-2.431.942-6.437,2.836-10.191,4.519-3.731,1.734-7.061,3.577-8.237,4.256,1.858-.974,4.176-2.253,6.064-3.109q-4.171,2.382-9.74,5.3c-3.62,2.115-7.755,4.321-12.234,6.916,0.28-.434-1.037.2-3.277,1.451-1.112.64-2.464,1.415-3.967,2.28s-3.142,1.844-4.807,2.919c-6.73,4.194-14.2,9.4-17.417,11.375-14.564,11.143-28.748,22.558-42.812,38.81,5.493-5.3-4.068,4.759-2.6,4.265-3.114,3.885-4.222,5.431-4.548,5.742-3.139,3.936-6.119,8.011-8.885,12.243-1.026,1.479-.442.443,0.353-0.927a30.989,30.989,0,0,0,1.673-2.881c-1.53,2.277-2.382,3.705-2.971,4.587s-0.853,1.263-1.061,1.541a23.15,23.15,0,0,0-2.484,3.838c0.959-1.182-1.6,3.489-4.115,9.273,1.267-2.678,2.594-5.317,4.068-7.866-3.34,6.917-4.544,10.027-5.8,13.148-0.323.777-.606,1.573-0.888,2.444s-0.6,1.8-.866,2.9a38.346,38.346,0,0,0-1.3,8.958,42.578,42.578,0,0,1,.314-5.028,42.094,42.094,0,0,0-.5,8.3,22.289,22.289,0,0,0,3.145,10.736,15.634,15.634,0,0,0,9.153,6.6,22.681,22.681,0,0,0,8.28.645c1.432-.023,3.372.045-0.231,0.338a48.726,48.726,0,0,0,14.754-3.142,100.412,100.412,0,0,0,13.88-6.392,249.145,249.145,0,0,0,22.579-14.412l-1.051.989c2.832-2.1,4.734-3.9,8.335-6.445-0.135.2-1.016,1,.285,0.021l4.548-3.846c2.042-1.746,4.346-3.717,6.163-5.175l-2.926,2.706a222.709,222.709,0,0,0,17.06-15.313c4.723-4.734,9.042-9.34,14.2-15.06,0.181,0.194,2.76-2.338,5.793-5.7s6.488-7.566,8.67-10.465l-0.091.248a135.016,135.016,0,0,0,15-24.63,100.31,100.31,0,0,0,4.816-12.608,71.145,71.145,0,0,0,2.835-14,48.234,48.234,0,0,0,.281-12.215,45.061,45.061,0,0,0-4.659-15.577,52.141,52.141,0,0,0-10.655-14.086,75.723,75.723,0,0,0-13.194-9.861c1.3,0.823,1.134.846,0.265,0.445l-4.035-2.006a78.379,78.379,0,0,0-7.346-3.454c-2.375-.928-4.11-1.628-3.678-1.717l1.54,0.637a33.454,33.454,0,0,0-3.3-1.6c-1.4-.562-3.059-1.184-4.835-1.834-1.792-.6-3.717-1.188-5.634-1.792l-5.67-1.568c-0.452.1-.9,0.183-1.35,0.3-9.345-2.873-22-5.021-33.586-6.228-11.6-1.251-22.124-1.674-27.411-2.352-4.7-.022-10.516-0.246-15.171-0.118l0.256-.336c-13.01-.223-19.516-0.241-35.577.433l3.267-.357a80.736,80.736,0,0,0-10.14.913c-2.756.4-5.426,0.741-9.592,1.038l-2.541-.345c-15.773,1.007-31.758,2.012-47.234,4.171a11.61,11.61,0,0,1,3.234-.6c-3.7.415-10.86,1.108-16.742,1.834s-10.493,1.4-9.108,1.579c-0.253-.542-16.148,2.368-24.557,3.818l1.26-.53-7.516,1.61c-2.159.52-4.673,1.07-9.6,2.091-2.348.413-2.1,0.136,1.024-.385-7.832,1.349-6.015,1.495-15.5,3.163l3.479-.894A71,71,0,0,0,399.56,142c-4.968,1.323-15.1,3.513-16.348,3.5-0.513.217-1.843,0.645-3.633,1.147s-4,1.224-6.334,1.818c-0.656.066,1.014-.477,1.854-0.75-6.608,1.743-11.475,3.215-15.828,4.529l-6.3,1.877c-2.051.674-4.129,1.326-6.389,1.973a5.321,5.321,0,0,0-1.57.3l7.262-2.35c2.228-.7,4.251-1.211,5.9-1.687,3.315-.926,5.226-1.453,4.835-1.33-0.083-.3-8.551,2.034-1.945-0.269-6.779,1.961-18.039,6.3-26.223,8.788-0.4.1-.8,0.2-1.11,0.248l0.831-.305c-1.888.58-3.56,1.155-5.127,1.719-2.606.813-4.226,1.436-6.694,2.318-1.036.11-9.494,3.35-13.606,4.85,0.459,0.19-4.935,2.119.2,0.524a36.213,36.213,0,0,1,3.486-1.34c0.613-.239,1.334-0.519,1.738-0.678l-0.27.131,10.2-3.777c-3.186,1.355-6.522,2.736-11.126,4.232l-5.535,2.617c-2.915.751-7,2.329-10.613,3.619-3.6,1.311-6.7,2.437-7.5,2.609-3.058,1.344-6.452,2.661-9.812,4.232s-6.788,3.16-10.074,4.69-6.415,3.026-9.189,4.38c-2.754,1.4-5.107,2.745-6.922,3.809a34.4,34.4,0,0,1-5.3,2.324c1.934-1.034,4.273-2.186,5.295-2.795-3.363,1.764-8.391,4.282-12.756,6.509-2.2,1.083-4.159,2.23-5.694,3.113a25.984,25.984,0,0,0-2.96,1.875c-8.509,4.371,4.538-2.914-6.993,3.4l1.5-.964c-2.887,1.459-5.623,2.883-8.25,4.281-2.584,1.473-5.052,2.932-7.459,4.367-2.4,1.45-4.738,2.868-7.062,4.275-2.308,1.43-4.634,2.791-6.882,4.319-4.536,2.991-9.147,6.022-14.172,9.208-5.006,3.214-10.284,6.8-16.387,10.573,1.682-1.058,2.522-1.588,2.9-1.753-6.909,4.366-13.581,9.3-20.407,14.108l-2.55,1.822-2.5,1.9-5.007,3.8c-3.322,2.558-6.718,5.031-9.982,7.666-6.527,5.27-13.135,10.419-19.443,15.805-3.166,2.677-6.4,5.248-9.486,7.94l-9.266,7.933A156.671,156.671,0,0,0,79.5,314.035l-1.706,1.084c-2.25,2.261-4.409,4.618-6.615,6.92-2.372,2.421-4.7,4.566-6.917,6.734-2.246,2.145-4.452,4.251-6.739,6.433-2.312,2.16-4.622,4.482-7.091,7.044s-5.122,5.339-7.889,8.628l1.674-1.47c-2.091,2.266-5.383,5.871-8.035,8.842-2.628,2.993-4.683,5.291-4.449,4.812a28.022,28.022,0,0,1-2.828,3.413l-0.265.02c-3.183,3.923-6.4,7.814-9.489,11.807-3.783,4.488-3.6,4.046-3.885,4.095-0.253.073-.99,0.622-6.258,7.395-1.924,2.545-4.542,6.26-6.434,9.146S-0.517,403.864.21,402.9a42.45,42.45,0,0,1,4.173-5.337c-1.108,1.6-2.227,3.18-3.306,4.8-0.078.59-.61,1.89-0.095,1.593s2.051-2.184,6.451-7.779c1.865-2.73,3.821-5.4,5.752-8.094l2.2-2.339q-2.608,3.265-5.123,6.6c3.067-3.615,4.784-6.085,6.749-8.823a38.846,38.846,0,0,0,2.854-3.042c1.927-2.621,3.829-5.265,5.818-7.842,0.932-.759-2.5,3.61,1.829-1.3,2.77-3.642-3.211,3.022,1.564-2.848,3.286-3.447,2.56-2.238,6.073-6.575,0.626-.493-0.086.455-1.5,2.155,1.586-1.911,3.712-4.416,5.7-6.638s3.766-4.239,4.522-5.285c0.9-.858,2.037-2.075,3.276-3.376s2.574-2.69,3.788-3.957c2.426-2.541,4.4-4.568,4.423-4.207,0.958-1.242,5.848-6.512,9.035-9.78-2.7,3.2.271,0.126,3.887-3.376,3.631-3.488,7.817-7.5,7.259-6.493,4.025-4.712,16.084-15.409,24.137-22.791-0.429.438-1.269,1.3-2.01,1.916,4.638-4.038,6.088-5.093,9.2-7.532,0.312-.849,7.54-7.137,11.369-10.616,6.185-4.344-3.238,3.275-1.1,2.152-0.556-.077,10-8.459,7.79-7.114a67.1,67.1,0,0,1,6.533-4.534c0.413-1.114,4.214-3.32,7.8-6.5,6.841-4.785,2.033-.868,9.265-6.5,1.829-1.19,1.114-.562-0.058.362ZM337.684,160.8l0,0.007-4.276,1.409Zm17.447-5.611c-2.161.56-4.779,1.5-7.582,2.386-0.646.088-.021-0.242,1.735-0.806C348.363,157.181,352.467,155.825,355.131,155.191Zm-37.547,10.146a29.41,29.41,0,0,1,4.051-1.4l-4.763,1.8c-0.076.038-.232,0.117-0.308,0.157A7.258,7.258,0,0,1,317.584,165.337Zm-4.756,2.223-1.117.437,1.655-.529,0.93-.455Zm1157.562-6.768-0.37.13c0.31-.1.59-0.193,0.78-0.243ZM605.311,125.276l-0.021-.085-1.6-.011Zm959.149-1.429a12.814,12.814,0,0,0,1.25-.469C1565.65,123.382,1565.11,123.59,1564.46,123.847Zm39.74-18.137,5.62-2.553C1607.39,104.262,1605.61,105.067,1604.2,105.71Zm30.31-14.458a2.794,2.794,0,0,0,.52-0.423c-0.02.01-.04,0.018-0.06,0.027ZM1124.56,236.881l-1.3.049C1120.22,237.076,1122.29,237,1124.56,236.881Zm157.51-20.18-4.97,1.169C1279.88,217.335,1282.03,216.905,1282.07,216.7Zm-332.3-5.861a0.123,0.123,0,0,0,.019,0l-1.021-.414Zm320.08,8.488c2.79-.5,5.1-0.978,7.25-1.458C1274.82,218.306,1272.14,218.815,1269.85,219.328ZM1762.48,21.955c0.47-.263.94-0.535,1.4-0.813a0.235,0.235,0,0,1,.14-0.147Zm1.54-.96,1.51-.965C1764.83,20.457,1764.22,20.831,1764.02,20.995Zm4.7-3-3.19,2.032C1766.65,19.353,1768.04,18.525,1768.72,18ZM1723.88,44.01l-0.39.353A1.062,1.062,0,0,0,1723.88,44.01Zm-11.8,6.572c2.83-1.535,7.2-3.687,11.1-5.931l0.31-.288C1721.73,45.546,1714.65,48.921,1712.08,50.582ZM1661.7,75.905l10.05-5.192c-1.81.808-4.19,1.866,0.34-.563C1659.3,76.46,1674.83,69.035,1661.7,75.905Zm-31.42,15.606c5.41-2.784-.14-0.137.11-0.349C1627,93,1626.18,93.446,1630.28,91.511Zm-234.91,94.443,0.49-.471C1391.39,186.89,1395.85,185.609,1395.37,185.954Zm-46.11,15.038,4.44-1.045,2.02-.855ZM1320.98,206l1.97-.546c-2.51.656-5.01,1.4-7.55,1.985C1317.27,207.008,1319.12,206.487,1320.98,206ZM905.851,188.1l1.15,0.908C909.931,190.22,910.718,190.086,905.851,188.1ZM726.882,167.423A35.686,35.686,0,0,0,722.3,168.7c-1.855.6-3.836,1.3-5.318,1.908l5.672-1.851C724.377,168.185,725.868,167.719,726.882,167.423Zm-72.82-39.307c1.222,0.22,2.454.389,3.669,0.651-2.289-.489-4.6-0.886-6.891-1.333Z"/>
</svg>
<?php
}
function allianz_elementor_shape_line2(){
?>
<svg xmlns="http://www.w3.org/2000/svg" width="1600" height="1030" viewBox="0 0 1600 1030" class="cms-svg-line">
  <path class="cms-svg--line elementor-shape-fill" d="M0.618,979.836c-1.292.917-.545,0.424,3.084-2.023l2.535-1.8Zm24.949-15.643c4.437-2.607,9.6-5.545,6.621-4.044L27.2,963.042c-1.41.822-2.833,1.721-5.166,3.168-3.785,2.211-6.552,3.941-5.945,3.518-1.289.861-5.778,3.6-7.705,4.96,2.39-1.551,5.158-3.219,8.078-5.076s6.133-3.676,9.345-5.652C27.211,963.158,25.876,963.985,25.567,964.193ZM433.49,984.821l-2.36-1.418C431.769,983.8,432.575,984.29,433.49,984.821ZM684.267,995.15a16.212,16.212,0,0,0-2.531,1.582A14.8,14.8,0,0,0,684.267,995.15Zm38.111-24.938-2.134,1.649A21.8,21.8,0,0,0,722.378,970.212ZM433.49,984.821q3.029,1.827,6.014,3.717C440.027,988.626,436.467,986.558,433.49,984.821ZM78.783,938.74L75.2,940.17l3.372-1.316ZM326.3,939.347l-2.057-.623c-0.62-.131-1.207-0.239-1.764-0.329ZM238.738,921.5a12.962,12.962,0,0,0,3.536-.11c-1.151,0-2.648-.076-4.419-0.22A1.422,1.422,0,0,0,238.738,921.5ZM98.108,933.123c-0.808.233-1.608,0.491-2.406,0.758C96.323,933.671,97.376,933.334,98.108,933.123Zm288.17,28.62a3.248,3.248,0,0,0,.68.479A1.845,1.845,0,0,0,386.278,961.743ZM1496.61,0.009c-0.08.016,0.03,0.024,0,.036C1497.14,0.021,1497.3.005,1496.61,0.009Zm102.98,12.974-1.39-.385a1.788,1.788,0,0,0-.31-0.049ZM773.811,904.716c-0.071.147-.1,0.2-0.164,0.335C772.8,907.1,773.3,905.949,773.811,904.716ZM971.3,267.442c-4.289.212-.812-0.161,2.138-0.334,2.948-.193,5.358-0.362-1.117-0.206C973.519,266.868,960.606,268.046,971.3,267.442ZM80.982,937.977l3.473-1.222ZM972.319,266.9v0c-0.446.01-.892,0.022-1.336,0.049C971.536,266.918,971.847,266.913,972.319,266.9ZM793.836,715.7a16.634,16.634,0,0,0-.063,1.966A8.379,8.379,0,0,0,793.836,715.7Zm-5.382,142.15,0.882-3.432C788.964,855.77,788.687,856.876,788.454,857.846ZM784.28,642.383c-0.217-1.9-.232-2.556-0.653-5.136,0,0.244.019,0.484,0.042,0.8A37.508,37.508,0,0,1,784.28,642.383ZM774.335,566.2c0.018,0.407.041,0.946,0.061,1.419,0.1,0.754.208,1.637,0.306,2.414ZM1279.21,74.757c1.39-.971,2.29-1.532,3.01-1.948C1281.11,73.329,1289.89,66.138,1279.21,74.757ZM78.854,938.819a20.456,20.456,0,0,1,2.128-.842c-0.832.3-1.637,0.567-2.406,0.877C78.376,938.958,78.339,939,78.854,938.819ZM779.725,639.844l-1.541-12.112C778.586,631.121,779.153,635.524,779.725,639.844Zm527.885-96.41c-0.49-.045-0.98-0.068-1.46-0.132l-1.45-.229,1.58,0.27C1306.77,543.389,1307.23,543.416,1307.61,543.434ZM773.39,591.788c-0.091-2.189-.291-4.494-0.506-6.875-0.1-.5-0.2-1.069-0.3-1.393ZM1282.24,72.795a0.061,0.061,0,0,1-.02.014A0.061,0.061,0,0,0,1282.24,72.795Zm68.27-42.914c-10.64,4.888-4.8,2.7-6.92,4.013-6.23,3.129-7.71,3.791-8.17,3.9-0.48.094,0.05-.388-2.12,0.607-7.69,4.129-13.2,7.956-18.77,11.295-0.45.189-1.53,0.84-.34-0.042-1.89,1.322-4.28,2.886-6.93,4.618-2.59,1.808-5.51,3.692-8.36,5.74s-5.77,4.094-8.39,6.189c-1.31,1.039-2.59,2.045-3.8,3s-2.28,1.941-3.29,2.826a11.974,11.974,0,0,1-1.18.773c1.53-.879,1.9-0.832,1.75-0.457-2.02,1.655-3.89,3.2-5.39,4.554a27.348,27.348,0,0,1-3.6,2.885,37.5,37.5,0,0,0,3.63-3.414l-4.07,3.674c-4.08,2.826,5.55-5.016,5.36-5.257-4.07,3.484-8.37,7.358-12.32,11.15-2.02,1.853-3.89,3.742-5.67,5.477s-3.47,3.319-4.91,4.77c-1.69.735,13.69-13.4,5.46-6.185l2.33-2.158,2.38-2.1,4.77-4.18c-3.86,2.951-2.42,1.671-.91.317,0.74-.685,1.54-1.347,1.68-1.536s-0.4.082-2.19,1.427c-6.31,5.5-9.59,8.84-12.93,12.113-1.62,1.68-3.25,3.358-5.19,5.367q-0.735.748-1.53,1.566c-0.52.561-1.06,1.149-1.63,1.769-1.14,1.232-2.41,2.591-3.83,4.119-2.33,2.961,1.16-.623-1.16,2.337-1.99,2.191-3.54,4.169-4.94,5.817s-2.58,3.023-3.63,4.19c-2.1,2.328-3.53,3.917-4.83,5.359s-2.5,2.727-3.99,4.547c-0.74.919-1.59,1.935-2.49,3.232s-1.92,2.826-3.1,4.661c-1.15,1.95-1.83,3.381-3.16,5.563-1.27,2.217-3.08,5.255-6.59,10.37l1.75-3.9c-1.1,1.7-1.99,3.107-2.73,4.291-0.72,1.188-1.23,2.2-1.68,3.026-0.89,1.675-1.39,2.746-1.92,3.832-1.03,2.183-2.28,4.339-6.34,11.784,0.59-1.393,2.02-4.237,3.15-6.466,1.21-2.187,2.13-3.755,1.47-2.716a51.094,51.094,0,0,0-3.02,5.167c-0.63,1.226-.99,2.045-1.3,2.8a59.417,59.417,0,0,1-2.96,6.515l-1.26,1.336a285.17,285.17,0,0,0-18.65,52.014c0.09-1.064.75-4.281-.56,0-1.58,5.82-2.76,11.942-4.1,18.117-0.58,3.1-1.07,6.248-1.63,9.388-0.25,1.574-.58,3.139-0.78,4.724l-0.61,4.75c-0.2,1.583-.41,3.163-0.62,4.741l-0.3,2.365-0.2,2.367c-0.28,3.153-.55,6.287-0.82,9.384-0.21,3.1-.29,6.176-0.44,9.2-0.06,1.511-.13,3.012-0.19,4.5v4.414c0.24,2.965.42,5.928,0.7,8.88,0.12,2.061.01,3.841-.24,1.61,0.37,9.068.36,0.451,0.84,4.788,0.36,5.138.13,6.823-.23,3.57,0.14,2,.46,4.189.77,6.543s0.64,4.865.98,7.485c0.37,2.617.91,5.318,1.36,8.089,0.49,2.764.89,5.6,1.55,8.4,0.59,2.809,1.18,5.624,1.77,8.4,0.26,1.392.61,2.753,0.95,4.1s0.67,2.676,1,3.981c0.67,2.608,1.2,5.152,1.87,7.508s1.28,4.576,1.82,6.612l-1.09-3.1c0.89,3.155,1.67,5.6,2.38,7.676,0.77,2.056,1.52,3.725,2.21,5.377,1.44,3.286,2.61,6.534,4.73,12.22l-0.95-2.128c1.31,3.3,2.64,6.648,3.98,10.013q2.25,4.944,4.52,9.924l1.13,2.483,1.25,2.425c0.83,1.616,1.65,3.227,2.48,4.833s1.64,3.205,2.46,4.8q1.32,2.334,2.62,4.637c0.87,1.534,1.74,3.056,2.59,4.565,0.87,1.5,1.66,3.028,2.59,4.451,1.79,2.888,3.54,5.711,5.24,8.446,1.63,2.776,3.46,5.3,5.09,7.808,1.65,2.5,3.23,4.886,4.72,7.15,1.54,1.431,5.66,7.129,9.78,12.459,1.06,1.315,2.1,2.617,3.08,3.841,1,1.2,1.96,2.32,2.8,3.29a19.214,19.214,0,0,0,3.45,3.454c5.16,6.258,7.1,8.419,9.57,11.209,1.23,1.4,2.69,2.882,4.79,5.079,1.09,1.066,2.35,2.3,3.85,3.769,1.56,1.414,3.31,3.114,5.51,4.972,1.16,1,2.21,1.843,3.24,2.581s1.98,1.456,3.02,2.126,2.11,1.385,3.32,2.18c1.25,0.752,2.56,1.68,4.2,2.658l-0.07.45a81.531,81.531,0,0,0,9.26,4.667l2.43,1.356,2.52,1.228q1.725,0.572,3.48,1.056c1.19,0.261,2.36.6,3.58,0.756-0.36-.067-0.72-0.137-1.08-0.206q-0.54-.144-1.05-0.285c-0.68-.193-1.33-0.363-1.86-0.548-1.05-.393-1.7-0.671-1.47-0.659a40.865,40.865,0,0,0,8.91,1.835,26.491,26.491,0,0,0,9.09-.7,22.244,22.244,0,0,0,6.52-2.94c0.74-.518,1.32-0.982,1.74-1.282,0.41-.317.62-0.527,0.67-0.53a23.615,23.615,0,0,0,4.15-5.539,31.28,31.28,0,0,0,2.62-6.272,48.714,48.714,0,0,0,1.94-13.188,21.58,21.58,0,0,1-.02,3.187c-0.05.815-.15,1.72-0.23,2.644-0.1.924-.26,1.859-0.38,2.742,0.13-.888.24-1.674,0.34-2.371,0.07-.7.13-1.309,0.18-1.843,0.13-1.066.14-1.829,0.19-2.383a10.343,10.343,0,0,1,.2-1.64,6.858,6.858,0,0,0,.13-1.421,45.173,45.173,0,0,0-.24-5.921c0.04,1.738-.27-0.924-0.36-1.21a84.371,84.371,0,0,0-2.13-14.129,122.641,122.641,0,0,0-5.3-16.71c0.31,0.618.64,1.233,0.94,1.858-6.75-18.319-18.13-36.951-32.09-53.64,4.86,6.112,3.49,4.895-.56-0.02l-1.44-2.112c-2.78-3.033,4.22,5.139-1.38-1.174-5.21-6.209-3.3-4.353-.22-0.854l-3.23-3.729-3.3-3.663a17.017,17.017,0,0,1,1.71,1.609c-2.76-2.958-11.17-12.858-15.49-16.818l-0.33-.449c-7.52-7.829-13.29-13.221-18.67-18.277-2.74-2.468-5.4-4.854-8.18-7.361-1.42-1.225-2.87-2.481-4.39-3.791s-3.09-2.681-4.8-4.078c-0.4-.067-5.64-4.572-9.89-7.689a423.279,423.279,0,0,0-34.86-25.225c-9.35-5.787-2.8-1.59-7.03-4.137-0.58-.6-14.03-8.568-7.01-4.516-2-1.218-3.87-2.261-5.6-3.238s-3.33-1.882-4.85-2.744c-3.09-1.649-5.86-3.162-8.79-4.694-2.96-1.473-6.02-3.11-9.75-4.869-1.86-.887-3.87-1.844-6.08-2.9-2.24-1-4.68-2.105-7.39-3.321,2.32,1.125,4.95,2.351,3.56,1.777-3.91-1.8-8.94-4.019-8.34-3.846l1.05,0.434c-12.28-5.177-26.62-10.772-40.68-15.122a312.917,312.917,0,0,0-38.15-9.6l1.17,0.22c-1.8-.371-3.62-0.661-5.42-0.975s-3.62-.639-5.43-0.913c-3.64-.524-7.26-1.111-10.91-1.521-10.04-1.36,6.04.663-1.38-.431-11.8-1.375-21.17-2.043-30.03-2.443a257.886,257.886,0,0,0-26.988.1,227,227,0,0,0-34.975,3.405,308.311,308.311,0,0,0-38.086,9.147l1.185-.19c-2.506.859-4.016,1.4-5.384,1.812s-2.587.739-4.426,1.4c0.559-.091,5.483-1.755,2.4-0.585a218.747,218.747,0,0,0-60.319,32.916,163.757,163.757,0,0,0-13.267,11.5l-3.144,3.081-1.572,1.541a21.952,21.952,0,0,0-1.527,1.584l-5.868,6.564A165.591,165.591,0,0,0,788.582,366.8a63.574,63.574,0,0,0-5.355,12.761c-0.436,1.416-1.063,2.9-1.86,5.351-0.421,1.216-.941,2.65-1.6,4.4l-1.105,2.872c-0.4,1.048-.753,2.214-1.193,3.471l0.657-2.965,0.8-2.926c-0.343,1.011-.718,2.014-1.038,3.036l-0.9,3.085q-0.912,3.085-1.829,6.184c-0.553,2.079-1.04,4.181-1.57,6.274-0.5,2.1-1.095,4.183-1.482,6.312-0.842,4.242-1.813,8.472-2.434,12.762l-1.049,6.416-0.809,6.443a332.715,332.715,0,0,0-2.234,51.016,35.1,35.1,0,0,1-.32-5.278c-0.267,3.514-.066,10,0.13,15.628,0.163,2.809.34,5.4,0.5,7.3a17,17,0,0,0,.384,3.121c0.231,5.164-.245,1.213-0.234,4.4,0.121,7.048,1.738,17.572,1.624,21.328a19.81,19.81,0,0,1-.425-3.237c0.524,4.556,1.882,21.26,1.956,16.844,0.992,12.413,2.79,23.635,3.7,33.516,1.342,6.349,2.416,21.146,3.493,23.073-0.958-.769,2.207,21.681,3.65,29.409-0.6-2.57.637,6.8-.122,3.8,1.2,8.878,2.4,17,2.643,15.39,1.114,16.49,4.919,32.807,4.573,42.187,1.63,13.185,2.971,25.9,4,38.309,1,12.407,1.611,24.506,1.881,36.44-0.431-.425-0.617-7.015-0.794-13.371-0.3-6.352-.584-12.471-1.046-11.933,0.7,11.292,1.281,20.2,1.482,29.1,0.048,2.225.1,4.447,0.145,6.705,0.011,2.259-.029,4.552-0.057,6.919-0.011,4.735-.3,9.749-0.652,15.345-0.443,5.789-.222-3.317-0.287-5.279-0.667,22.588-4.175,43.422-8.575,62.946-0.052-.07.332-2.2,0.732-4.2-0.783,3.875-2.473,8.829-1.913,8.523l0.931-3.734c1.133-2.961.427,0.9-.613,5.608-0.918,4.742-2.637,10.184-2.553,10.588,0.238-1.7-.055-1.369-0.6-0.1-0.271.635-.605,1.509-0.966,2.485s-0.742,2.058-1.2,3.08c-1.736,4.122-3.32,7.74-2.121,2.5-0.865,2.441-1.857,5.551-1.372,5.108a20.72,20.72,0,0,1-.991,2.14,6.661,6.661,0,0,1-.579.988c-0.209.235-.047-0.427,0.6-2.267-2.811,6.458-3.545,8.629-4.347,10.585-0.849,1.932-1.635,3.717-4.614,9.385-0.144-.134.963-2.472,1.358-3.756l-0.989,2.233c-0.324.755-.675,1.507-1.081,2.247-0.783,1.5-1.61,3.05-2.523,4.713l-1.44,2.582q-0.383.669-.782,1.362l-0.9,1.367c-1.237,1.861-2.612,3.874-4.166,6.088,0.261-.612-0.578.332,1.233-2.335a226.6,226.6,0,0,1-15.282,20.216c-1.254,1.616-2.739,3.041-4.153,4.586L730.46,958.6c-1.559,1.551-3.277,3.029-5.016,4.613l-2.691,2.392c-0.913.814-1.849,1.643-2.881,2.4,4.113-4.466-5.617,4.116-6.94,4.169l-2.1,1.754-2.2,1.635-4.395,3.273,3.808-2.242c-1.961,1.391-3.843,2.772-5.673,4.133l-1.365,1.015-1.4.932-2.751,1.836c-1.817,1.211-3.6,2.394-5.383,3.537l-1.333.85-1.375.761-2.753,1.47c2.025-1.267,4.086-2.47,6.016-3.883l-1.9,1.22c-0.642.39-1.3,0.749-1.954,1.125l-3.918,2.234-3.919,2.234-1.96,1.118c-0.662.358-1.341,0.682-2.01,1.026,1.566-.68,3.07-1.478,4.577-2.272l4.534-2.365c-4.159,2.556-3.817,2.647-3.843,2.856a1.784,1.784,0,0,1-.933.729c-0.406.244-.989,0.577-1.825,1.04-0.849.436-1.973,0.96-3.427,1.652,1.155-.614-1.015.454-4.063,1.9-1.524.724-3.268,1.544-4.924,2.294-1.666.73-3.279,1.32-4.472,1.74l0.029-.02c-2.137,1.08-4.288,2.21-6.768,3.34-2.494,1.09-5.285,2.24-8.632,3.5-1.813.45,1.078-1.35-.1-1.05a49.369,49.369,0,0,1-5.142,2.24c-2.263.89-4.93,1.94-7.691,2.84-1.374.46-2.757,0.93-4.1,1.39s-2.652.92-3.892,1.29c-2.468.78-4.589,1.5-5.977,2.08,1.869-.71,1.859-1.12,1.21-1.02-1.219.53-2.43,1.1-3.671,1.56-4.378.93-5.028,1.01-4.4,0.53-1.626.41-2.781,0.7-3.588,0.91-0.81.19-1.265,0.32-1.49,0.4-0.451.18,0.017,0.19,0.408,0.21,0.782,0.04,1.244.1-6.606,1.56,1.217-.3.618-0.25,3.153-0.87-3.916.85-7.811,1.41-11.628,2.11-1.916.3-3.828,0.54-5.723,0.82-0.948.13-1.893,0.27-2.835,0.4l-2.831.3a156.692,156.692,0,0,1-22.3,1c-1.082-.21-0.818-0.31.105-0.35,0.922-.02,2.5-0.04,4.069-0.09,3.128-.08,6.173-0.14,3.689-0.41a198.693,198.693,0,0,1-32.31-1.45c-2.706-.29-5.372-0.81-8.043-1.23-2.662-.47-5.292-1.04-7.906-1.59-5.2-1.25-10.3-2.6-15.15-4.27,1.208,0.41,2.4.86,3.621,1.24a12.219,12.219,0,0,1-3.683-.81c-1.653-.52-3.673-1.26-5.878-2.18-4.447-1.74-9.624-4.15-14.486-5.99,2.368,0.93,3.282.8,2.607,0.64a389.332,389.332,0,0,1-44.465-23.064l2.4,1.169c-3.511-2.264-8.243-5.062-13.111-7.785s-9.869-5.379-13.854-7.485c-2.482-1.024-7.075-3.356-4.426-1.658a290.243,290.243,0,0,0-36.247-16.829c-5.976-2.367-11.9-4.58-17.777-6.741l-17.456-6.469c2.8,0.909,6.707,2.1,4.492,1.324-6.645-2.2-13.325-4.291-20.054-6.209,1.488,0.816,2.588.95,6.707,2.542-1.3-.307-3.366-0.862-5.744-1.5-2.37-.661-5.045-1.408-7.547-2.1,9.126,2.376.078-.556-3.805-1.822,0.633,0.276-.745.022-0.44,0.211-5.214-1.705-5.7-1.672-6.678-1.72-0.984-.03-2.43-0.257-9.653-2.184l0.81,0.018c-2.733-.608-5.365-1.155-8.06-1.672l-8.385-1.7c-2.382-.849,5.873,1.01,6.3.839-8.3-1.758-16.526-2.649-24.035-4.225l6.118,0.935,6.107,1.022-4.955-1.151c-1.336-.28-2.416-0.487-3.431-0.675-2.032-.365-3.8-0.69-6.869-1.165l0.6,0.1c-4.723-.8-9.463-1.493-14.21-2.146l3.617,0.572c-10.631-.486-21.509-2.3-35.821-2.425,13.894,0.242,2.309-.17,3.387-0.464-3.64-.337-9.195-0.535-7.609-0.607-6.764.063-11.3-.452-20.838,0.085-0.43-.089-7.233.227-5.717-0.079-4.4.191-3.871,0.274-2.345,0.218a35.4,35.4,0,0,1,3.694.044c-13.506.758-31.878,1.518-51.007,5.443-4.136.74-7.393,1.511-10.223,2.13-2.835.6-5.2,1.259-7.539,1.836l-3.528.891-3.748,1.041-4.287,1.17c-1.551.424-3.222,0.951-5.091,1.494-5.083,1.345,4.066-1.441,4.066-1.441L99.6,932.192l-2.719.774-2.631.835c-1.74.561-3.465,1.118-5.231,1.686s-3.539,1.25-5.424,1.914c1.511-.586-0.08-0.081-2.4.659-3.033,1.048-3.988,1.559-5.224,2.047-1.22.529-2.71,1.066-6.651,2.6,1.309-.637,3.025-1.361,5.889-2.541-1.759.7-3.522,1.363-5.265,2.086l-5.215,2.226c-3.507,1.44-6.946,3.122-10.518,4.717-1.93.77,4.256-2.053,6.75-3.24-2,.909-4.3,1.955-6.662,3.027s-4.728,2.289-6.952,3.36l-3.167,1.559-2.7,1.43c-1.616.862-2.834,1.52-3.424,1.857l5.029-2.555c-2.844,1.477-1.51.667,0.579-.443,6.732-3.393,9.8-4.719,10.219-4.817-1.692.766-3.345,1.618-5.019,2.421l13.445-6.031c2.9-1.212,5.935-2.535,8.923-3.759,3.009-1.169,5.934-2.328,8.566-3.3l-4.285,1.89c3.544-1.467,7.153-2.761,10.75-4.1,2.335-.734,3.964-1.13-1.254.718l7.064-2.312c1.558-.5,2.962-1.024,6.3-1.914a1.4,1.4,0,1,1-.263.128l7.523-2.245c-1.462.486,1.312-.148-3.335,1.133,3.388-.961,6.481-1.7,9.259-2.432,2.772-.751,5.271-1.327,7.5-1.864,4.444-1.116,7.863-1.794,10.485-2.2l-1.15.253c4.776-1.029,7.312-1.4,8.6-1.694,1.3-.263,1.372-0.316,1.3-0.349s-0.3-.045.389-0.227c0.346-.091.922-0.224,1.861-0.425l4.06-.726,4.932-.388,4.94-.26,1.873-.52a35.168,35.168,0,0,1,5.253-.409c7.448-.942-1.286,0,3.031-0.622,4.846-.324,11.518-0.824,17.265-1.09,5.747-.237,10.56-0.346,11.657-0.067,1.74-.133-0.581-0.173-2.043-0.189-0.73,0-1.246,0-.932-0.032s1.458-.1,4.05-0.152c2.956,0.533,11.985-.187,20.842.49-2.734.213-11.114-.257-2.264,0.339a93.821,93.821,0,0,1,11.557.437l13.1,1.283c0.4-.471,16.2,1.452,28.581,3.462-0.406.019,5.411,1.024,12.718,2.518s16.08,3.564,21.718,5.054l-0.355,0a65.279,65.279,0,0,1,8.907,1.844l6.756,1.781,6.728,1.874c-0.419.2-1.972-.1-6.568-1.277,2.634,0.769,5.281,1.488,7.9,2.3,1.907,0.4,4.4,1.027,9.508,2.6l-2.1-.237c10.44,3.3,21.117,6.462,34.152,11.866,0.89-.079-10.066-5.122,3.952.066,0.434,0.41.806,0.961-2.855-.4,1.2,0.45,4.308,1.518,6.661,2.578l-5.669-1.882c5.9,2.547,3.242.946,7.98,2.941-0.215.252,3.428,1.663,2.648,1.616-1.221-.48-4.089-1.838-5.953-2.476,5.34,2.244,11.7,5.176,13.708,6.351-0.391-.363.179-0.41,4.065,1.289,9.983,4.527,3.253,1.91,8.976,4.754,2.5,0.919,8.673,4.2,9.053,3.846a27.7,27.7,0,0,1,4.337,2.592c2.576,1.185,8.461,4.216,12.969,6.628s7.688,4.114,5.037,2.307l-1.252-.742c0.24,0.127.524,0.278,0.82,0.433l-0.04-.023,0.04,0.023c4.119,2.16,8.245,4.5,12.333,6.978s8.208,5.032,12.38,7.475a238.788,238.788,0,0,0,25.311,13.287l-0.1.15c2.528,1.13,5.245,2.22,7.97,3.35,1.377,0.53,2.761,1.07,4.136,1.6,1.371,0.55,2.748,1.05,4.113,1.51,1.361,0.48,2.7.94,4,1.39,1.314,0.41,2.59.8,3.811,1.18,2.435,0.78,4.71,1.31,6.627,1.78,1.563,0.48,3.415,1.02,4.693,1.47s1.984,0.76,1.278.7c2.056,0.52,3.682.8,5.127,1.09,1.447,0.27,2.712.54,4.1,0.79,2.789,0.47,6.01,1.15,12.06,2.12-4.242-.44-3.527-0.27-3.192-0.19a4.415,4.415,0,1,1-.455-0.06c-0.692-.11-2.156-0.3-5.025-0.86,2.7,0.57,4.9.9,6.846,1.23,0.973,0.16,1.884.31,2.766,0.45,0.888,0.11,1.747.21,2.613,0.32,1.734,0.18,3.49.41,5.563,0.51,2.073,0.08,4.45.21,7.413,0.19-2.025.2,0.042,0.41,3.282,0.57,3.24,0.24,7.648.07,10.272-.01-2.585-.09-5.165-0.15-7.74-0.28,2.947-.04,5.709-0.08,8.389-0.12,2.678-.13,5.273-0.25,7.889-0.37l-2.789.81a147.753,147.753,0,0,0,30.707-4.29c2.309-.58,4.6-1.06,6.812-1.67s4.406-1.18,6.573-1.73,4.276-1.18,6.4-1.7,4.23-1.03,6.321-1.55c2.762-1.16-.168-0.25-3.194.59-3.047.78-6.165,1.58-3.682,0.57,1.251-.34,2.509-0.68,3.758-1.01,1.243-.36,2.479-0.71,3.691-1.06,2.434-.67,4.774-1.32,6.9-1.9,4.22-1.28,7.615-2.26,9.142-2.82a85.006,85.006,0,0,0,12.647-5.59c2.99-1.65,6.1-3.19,12.788-6.43-1.817.62-3.7,0.81,6.117-4.29,9.069-4.94,11.631-5.292,6-1.92a14.633,14.633,0,0,1-3.2,1.622c-0.722.429-1.5,0.889-2.207,1.308-0.722.387-1.369,0.739-1.8,0.993-0.87.508-.893,0.624,1.014-0.166,0.363-.275.733-0.537,1.09-0.823,2.31-1.143,6.586-3.463,9.944-5.249,0.837-.452,1.629-0.847,2.294-1.226s1.22-.711,1.638-0.939c0.835-.457,1.1-0.534.439,0,6.537-4.4,2.627-2.138-2.362.852,2.868-1.7,5.407-3.245,7.783-4.716l3.464-2.166,3.229-2.3,6.617-4.713c2.273-1.71,4.634-3.641,7.368-5.73-1.8,1.261-3.549,2.287-1.851.93,1.984-1.552,3.6-2.777,4.862-3.836,1.228-1.1,2.164-1.95,2.893-2.629a32.962,32.962,0,0,0,2.543-2.553c0.463-.534.767-0.942,1.581-1.79,0.4-.437.967-0.934,1.663-1.7s1.608-1.715,2.791-2.939c2.848-2.625,2.53-1.974,2.668-1.913a2.4,2.4,0,0,0,1.01-.844l1.617-1.667c0.7-.778,1.54-1.821,2.644-3.139,5.712-6.167,1.679-.911-0.376,1.762,1.977-2.455,3.942-4.773,5.854-6.961,1.8-2.282,3.517-4.451,5.169-6.466,0.814-1.016,1.646-1.969,2.378-2.936s1.408-1.921,2.068-2.823c1.321-1.8,2.519-3.452,3.548-4.932l-3.562,5.618c1.067-1.682,2.057-3.195,3.013-4.631l1.408-2.112,1.273-2.137c-0.8.992-1.547,2.015-2.425,2.95,0.583-.781,1.072-1.579,1.519-2.309l1.21-1.933a5.9,5.9,0,0,1,1.228-1.682c1.765-3.61-2.284,2.2,1.379-4.838,1.338-2.207,3.068-5.743,4.678-8.859,0.841-1.54,1.444-3.078,2.055-4.251a11.382,11.382,0,0,1,1.418-2.39c-3.412,7.378-3.232,6.968-2.655,6.4,0.539-.584,1.265-1.434-1.875,4.724,1.146-2.409,2.731-5.249,4.347-8.8,0.309-.5-0.1.561-0.506,1.548,1.745-3.5,2.761-5.682,3.4-7.212a19.621,19.621,0,0,0,1.051-3.36c0.217-.918.424-1.858,0.943-3.507,0.49-1.659,1.441-3.974,2.656-7.819-0.294,2.07,1.855-3.324,2.611-5.856-1.031,3.092-1.425,3.781-1.36,2.978a18.894,18.894,0,0,1,.419-2.2c0.234-1.033.594-2.312,0.9-3.773,1.526-4.93,2.264-7.641,2.728-9.781,0.415-2.153.658-3.713,1.288-6.338l-1.534,5.967a40.929,40.929,0,0,1,.9-5.232l0.881-4.031c0.347-1.483.582-3.135,0.906-4.9,0.417-.543-1.052,6.432-0.418,3.95,0.212-1.99.569-4.08,1.011-6.27,0.422-2.193,1.026-4.471,1.444-6.881,0.46-2.4.941-4.9,1.383-7.5,0.469-2.589.69-5.295,0.923-8.062,0.831-5.089.745-.419,1.425-4.9,0.253-6.238.7-9.586,1.036-13.028,0.155-1.721.313-3.463,0.449-5.593s0.288-4.652.233-7.929c-0.576,3.758-.473,4.412-0.736-4.8,0.006,7.164-.229,14.331-0.584,21.5,0.1-2.3.033-4.61,0.049-6.912l-0.011-6.9c-0.162,3.236-.262,6.655-0.35,9.752-0.029,1.549-.1,3.014-0.2,4.335s-0.179,2.5-.279,3.462c0.128-6.583.2-5.894-.462-2.834,0.176-1.1.346-2.195,0.449-3.3s0.169-2.209.227-3.319c0.115-2.22.168-4.461,0.215-6.743s-0.017-4.61.027-7c0.014-2.394.139-4.855,0.259-7.414l1.208,0.324c0.126-3.856.149-7.5,0.109-11.108-0.116-3.6-.287-7.17-0.469-10.879-0.234-3.7-.478-7.551-0.742-11.721s-0.593-8.651-.817-13.647l0.194,6.427a69.555,69.555,0,0,1-.747-7.953c-0.257-3.549-.518-7.574-0.863-10.791,0.453,0.565.219-3.473,0.209-6.247-0.133.18-.447-3.465-0.881-7.367-0.459-3.9-1.007-8.06-1.484-8.921-0.124-2.976-.314-5.944-0.477-8.918-1.652-16.048-3.248-18.143-5.094-33.522,1.012,4.574.374-2.445,1.989,7.814-0.647-5.134-1.2-9.752-1.467-9.8-0.158-3.028-2.395-14.149-2.69-18.906a56.25,56.25,0,0,1-1.689-8.547c-0.011-.638.185,0,0.185,0-0.185,0-1.473-8.97-1.193-3.89-0.5-7.966-2.029-18.987-3.473-29.757s-2.806-21.293-3.1-28.231c-0.729-5.59-1.417-11.764-2.1-17.809-0.607-6.051-1.253-11.97-1.637-17.07a4.422,4.422,0,0,1,.293,1.95,87.093,87.093,0,0,0-1.221-11.577,83.872,83.872,0,0,1-1.07-13.06c0.162-8.218.706,8.5,0.664,3.383,0.5-1.141.246-5.971-.123-11.872a181.035,181.035,0,0,1-.239-18.277l0.07,2.611c0.088-2.061.1-4.347,0.078-6.828,0.006-2.482.013-5.159,0.021-8q0-2.131.008-4.381,0.072-2.245.147-4.6c0.115-3.133.211-6.4,0.56-9.751,0,0,.037.66,0.151,0.092,0.073-2.3.162-5.122,0.388-8.249,0.284-3.118.617-6.553,0.989-10.1,0.516-3.531,1.048-7.177,1.569-10.743,0.681-3.541,1.346-7,1.958-10.184-0.433,4.037-.972,5.813-0.1,3.486,0.548-2.848.309-2.468,0.207-2.795-0.126-.334-0.031-1.358,1.329-7.006,0.271-.9.624-2.084,1.006-3.362,0.407-1.269.9-2.62,1.344-3.9a37.052,37.052,0,0,1,2.083-5.234l-1.569,5.224c-0.5,1.748-1.1,3.467-1.5,5.245,0.438-1.33.987-2.816,1.491-4.411s1-3.293,1.489-5c0.447-1.719,1.042-3.394,1.585-5s1.076-3.125,1.584-4.468l-0.035.77,0.983-2.775,0.991-2.412c0.613-1.521,1.153-2.865,1.648-4.094s0.89-2.371,1.378-3.4l1.381-3.031c0.459-1,.921-2.007,1.415-3.084,0.517-1.066.988-2.246,1.7-3.457,0.687-1.226,1.444-2.578,2.3-4.113q0.653-1.147,1.389-2.439c0.25-.429.5-0.879,0.772-1.33l0.9-1.36-1.159,1.466c5.021-8.481,4.644-6.814,10.321-14.817,0.748-.671,1.446-1.379,2.226-2.014l4.142-4.958c0.854-.989,1.7-2.114,2.719-3.178l3.178-3.317,3.353-3.492c1.161-1.152,2.387-2.253,3.574-3.375s2.4-2.193,3.6-3.213,2.337-2.043,3.475-2.955l-4.512,4.082c-1.74,1.561-3.571,3.391-5.5,5.194l-5.451,5.711c-0.864.943-1.78,1.791-2.518,2.728l-2.149,2.6,1.826-2.1c0.345-.39.686-0.816,1.078-1.223l1.229-1.242c1.679-1.71,3.522-3.584,5.3-5.391s3.627-3.4,5.077-4.8c1.485-1.363,2.692-2.4,3.287-2.993-0.971.858-2.076,1.818-3.154,2.8-1.063,1-2.132,1.987-3.1,2.818a147.871,147.871,0,0,1,24.2-19.506c-0.691,1.022,6.271-3.611,14.911-8.239,1.082-.575,2.171-1.184,3.288-1.754l3.374-1.677c2.229-1.145,4.491-2.139,6.594-3.091,2.093-.976,4.1-1.752,5.823-2.447s3.2-1.25,4.316-1.586c20.976-8.6,42.944-13.74,69.192-16.641-4.684.28-2.771,0.039,0.113-.273,2.888-.275,6.741-0.643,5.913-0.821,6.149-.472,8.5-0.621,9.051-0.6,6.229-.181,12.459-0.284,18.685-0.1,4.425,0.18-5.862.034-5.294,0.206,13.485,0.081,5.658.158,14.566,0.522-0.908-.109.27-0.137,2.63-0.086,2.35,0.122,5.91.249,9.73,0.59-1.79-.2-3.59-0.317-5.39-0.454s-3.6-.294-5.4-0.387c9.42,0.318,13.48.828,17.55,1.264,2.03,0.259,4.06.519,6.77,0.821l4.64,0.592c1.77,0.23,3.8.44,6.15,0.794-1.98-.279-3.98-0.474-5.97-0.686,4.85,0.528,13.74,1.906,22.55,3.6,8.82,1.637,17.51,3.792,22.18,4.811,1.66,0.5,3.83,1.2-.32.1,11.28,2.95,23.69,6.77,35.28,10.994,11.59,4.2,22.35,8.8,30.53,12.718l-1.65-.651c1.99,0.87,3.7,1.677,5.55,2.532,1.83,0.875,3.82,1.754,6.22,3.049-0.27-.095-1.61-0.717.19,0.2,1.03,0.513,3.62,1.8,6.59,3.28,2.94,1.559,6.27,3.3,8.77,4.729-1.44-.79-2.92-1.513-4.37-2.271,9.95,5.5,17.5,9.891,24.52,14.276,3.54,2.133,6.89,4.369,10.41,6.624,1.75,1.141,3.49,2.364,5.32,3.6s3.71,2.522,5.63,3.936a17.725,17.725,0,0,0,2.25,1.85c1.44,1.1,3.46,2.6,5.65,4.336,4.44,3.394,9.65,7.626,13.11,10.442l-0.26-.168c10.24,8.4,18.62,15.909,26.63,23.45,8,7.558,15.65,15.147,23.91,24.223,1.27,1.421,2.7,3.134,4.33,5.035,1.61,1.913,3.46,3.968,5.33,6.269,1.89,2.284,3.91,4.725,6.02,7.272q1.53,1.936,3.12,3.95,1.545,2.046,3.13,4.147a197.845,197.845,0,0,1,11.69,17.853,158.421,158.421,0,0,1,8.93,17.841c-1.45-3.425.6,0.4,2.25,4.407,0.99,2.682,2.44,6.356,3.38,9.333,1,2.96,1.54,5.191,1.24,4.8l-0.55-1.959c0.41,2.12,1.38,6,2.2,10.511a87.5,87.5,0,0,1,1.48,14.187c0.2,0.494.42,0.991,0.59,1.493a60.613,60.613,0,0,1-1.09,9.416,36.734,36.734,0,0,1-3.29,9.641,23.865,23.865,0,0,1-2.9,4.294,21.226,21.226,0,0,1-1.79,1.873l-1,.816a6.954,6.954,0,0,1-1.04.758,18.068,18.068,0,0,1-4.61,2.245,19.538,19.538,0,0,1-2.5.605c-0.42.07-.84,0.154-1.26,0.213l-1.28.095a30.01,30.01,0,0,1-9.94-1.158,52.858,52.858,0,0,1-8.65-3.309,61.234,61.234,0,0,1-11.69-7.424,144.977,144.977,0,0,1-14.63-11.506l0.5-.09c-5.83-5.469-9.93-9.871-14.28-14.675-4.32-4.827-8.88-10.092-15.04-17.879l2.77,2.972c-0.87-1.1-1.68-2.08-2.43-2.976-0.74-.912-1.41-1.745-2.06-2.513-1.3-1.538-2.47-2.833-3.63-4.107s-2.3-2.525-3.55-3.975c-1.23-1.464-2.47-3.19-3.95-5.313l-1.2-2.95c-10.98-16.187-20-33.81-28.27-51.222,0.23,0.246.66,0.684,1.99,3.549-2-4.139-5.17-12.434-7.76-19.261-2.41-6.9-4.43-12.28-4.37-10.55,0.27-.212-1.14-5.035-3.06-11.06-0.51-1.5-.91-3.108-1.36-4.733s-0.91-3.272-1.35-4.888-0.89-3.2-1.31-4.7c-0.35-1.514-.68-2.943-0.98-4.226l0.81,1.5c-1.19-4.292-1.85-6.508-2.54-9.167-0.61-2.674-1.15-5.811-2.21-11.951-0.21-1.462-.14-2.122-0.05-1.92a25.3,25.3,0,0,1,.53,3.2c-0.35-2.432-.5-4.133-0.68-5.486s-0.34-2.363-.52-3.439-0.36-2.216-.56-3.831c-0.1-.809-0.23-1.732-0.31-2.83-0.05-1.1-.11-2.37-0.18-3.859l0.6,4.406c-0.31-5.043-.48-7.363-0.68-9.114-0.16-1.753-.48-2.93-0.67-5.712-0.08-1.59-.13-3.586-0.16-5.71,0-1.061-.01-2.154-0.02-3.243v-1.628c0.03-.539.06-1.072,0.08-1.595a70.819,70.819,0,0,1,.77-8.5c-0.32-1.373-.23-6.923.34-12.866,0.22-.787.17,1.387,0.14,2.479,0.22-2.1.31-4.08,0.56-5.928,0.22-1.853.43-3.594,0.62-5.248,0.38-3.309.61-6.283,1.07-9.059,0.41-2.785.79-5.409,1.22-8.048,0.19-1.324.5-2.632,0.8-3.97s0.64-2.7,1.01-4.108a5.937,5.937,0,0,0,.69-1.859c-0.69,3.284-1.41,6.4-1.96,9.228-0.48,2.845-.91,5.387-1.26,7.484s-0.67,3.746-.81,4.818a7.3,7.3,0,0,1-.18,1.3c0.31,0.035,2.24-10.606,1.42-2.033,0.99-8.6,2.96-23.4,6.16-33.5a13.95,13.95,0,0,1,.5-1.309l-0.23,1.07c0.34-1.171.6-2.3,0.91-3.357s0.6-2.08.87-3.072c1.07-3.2,1.76-5.222,2.72-8.309a63.248,63.248,0,0,0,2.71-6.835c0.61-1.7,1.27-3.529,1.88-5.246,0.69-1.689,1.34-3.27,1.85-4.519-0.61.236,2.16-6.282-.73-0.3a44.185,44.185,0,0,1-1.69,4.3c-0.3.757-.59,1.67-0.76,2.181,0.03-.1.06-0.228,0.09-0.363-0.6,1.672-1.29,3.6-2.05,5.726-0.73,2.135-1.66,4.432-2.38,6.963a66.619,66.619,0,0,1,1.91-6.445c0.77-2.274,1.67-4.729,2.81-7.5,0.75-2.686,1.64-5.63,2.16-7.286,0.88-1.642,1.82-3.725,2.96-5.863,1.12-2.137,2.31-4.389,3.42-6.49a75.538,75.538,0,0,1,4.89-8.5c0.93-1.842,1.9-3.766,2.89-5.74,1.01-1.967,2.18-3.912,3.29-5.915,1.13-1.994,2.26-4.007,3.39-6.009,1.22-1.955,2.42-3.9,3.6-5.8s2.32-3.774,3.43-5.57c1.17-1.756,2.29-3.445,3.35-5.036,2.11-3.186,3.85-6.058,5.32-8.213a39.711,39.711,0,0,1,4.66-5.456c-1.59,2.2-3.56,4.757-4.36,5.994,5.33-7.754,17.44-21.692,18.67-23.61,4.1-4.291,3.07-2.97,2.38-2.09-0.34.44-.6,0.769-0.09,0.234,0.25-.271.7-0.755,1.43-1.546s1.71-1.912,3.15-3.358l-1.42,1.69c11.42-11.226,20.82-20.21,31.08-28.933a223.341,223.341,0,0,1,36.99-25.772c-2.14,1.216-3.21,1.825-3.69,2.014a340.473,340.473,0,0,1,55.72-26.91,318.159,318.159,0,0,1,59.42-15.862l11.28-1.877c2.56-.473,4.58-0.794,8.01-1.342l2.48-.02,5.88-.816,5.9-.719c8.38-.826,15.69-1.057,23.53-1.178,7.86-.1,16.26-0.093,26.93.1l-2.75-.214c3.83,0.105,9.89.361,14.83,0.68s8.76,0.67,8.12.669c0.78,0.032,2.51.107,5.49,0.432l0.22,0.1q9.375,0.831,18.71,2.1c7.21,1.086,6.63,1.111,6.89,1.191a19.047,19.047,0,0,0,2.07.412c1.62,0.291,4.52.761,9.75,1.754,3.89,0.724,9.41,1.841,13.57,2.824,4.16,0.962,6.96,1.778,5.53,1.355-3.07-.872-7.9-2.02-8.13-2.109,2.35,0.538,4.7,1.111,7.03,1.733,0.65,0.119,2.32.562,1.69,0.334s-3.54-1.191-12.2-3.234q-6.06-1.335-12.16-2.424l-3.92-.8q5.145,0.909,10.25,1.967c-5.78-1.265-9.49-1.866-13.65-2.52-0.97-.207-2.68-0.537-5.11-0.929q-6.03-.853-12.09-1.481c-1.45-.269,5.44.5-2.66-0.552-5.68-.541,5.41.8-3.98-0.17-5.89-.7-4.16-0.658-11.11-1.153-0.97-.152.5-0.07,3.26,0.141-6.18-.511-16.38-1.154-19.58-1.106-3.09-.219-8.32-0.365-12.71-0.427-4.38-.044-7.92-0.051-7.62-0.2-1.95.064-10.92,0.4-16.61,0.709,5.19-.411-0.14-0.252-6.42.12s-13.51,1.05-12.16.677c-3.83.552-10.75,1.326-18.38,2.449-7.63,1.1-15.96,2.557-22.61,4.114,0.74-.192,2.19-0.57,3.38-0.788-7.55,1.482-9.76,1.875-14.6,2.9a65.36,65.36,0,0,1-7.32,2.317c-1.87.566-3.92,1.182-5.88,1.772l-5.33,1.772a14.591,14.591,0,0,1-3.07.657,9.573,9.573,0,0,1,1.93-.812c2.11-.759,5.01-1.743,3.53-1.519a7.566,7.566,0,0,1-2.16.858c-0.7.229-1.51,0.5-2.37,0.78l-2.66.919c-1.78.613-3.47,1.2-4.52,1.589-1.05.409-1.46,0.617-.68,0.425-6.9,2.115-5.92,1.885-9.53,2.83a16.184,16.184,0,0,1-4.19,1.9c-2.11.817-4.77,1.871-7.48,3.154a66.082,66.082,0,0,1-6.3,2.3,16.069,16.069,0,0,0-1.76.683c-0.96.435-2.46,1.149-5.05,2.393C1341.32,34.351,1350.51,29.881,1350.51,29.881ZM1178.19,230.537v0c0.58-2.277,1.08-4.219,1.4-5.459C1179.3,226.213,1178.9,227.788,1178.19,230.537Zm-4.94,22.4c0.26-1.372.46-2.929,0.83-4.568,0.35-1.641.73-3.391,1.12-5.189,0.33-.751.32,0.137-0.18,2.388C1175.2,244.321,1173.87,249.565,1173.25,252.933Zm15.73-45.662a31.155,31.155,0,0,1-1.91,4.928c0.56-1.6,1.21-3.471,2.07-5.926,0.03-.1.07-0.316,0.09-0.42A8.027,8.027,0,0,1,1188.98,207.271Zm1.62-6.293c0.18-.484.29-0.752,0.53-1.383-0.31.666-.63,1.294-0.91,1.949-0.1.43-.2,0.87-0.29,1.252C1190.16,202.184,1190.36,201.537,1190.6,200.978ZM430.715,983.159l0.415,0.244c-0.339-.212-0.65-0.407-0.847-0.553C430.552,983.028,430.545,983.04,430.715,983.159Zm852.7-449.051,0.02-.1c-0.59-.34-1.19-0.662-1.75-1.029C1282.23,533.381,1282.83,533.735,1283.41,534.108ZM315.168,934.182c-0.222-.1-0.669-0.254-1.57-0.529C313.661,933.7,314.341,933.918,315.168,934.182ZM262,922.713c-2.532-.415-5.059-0.869-7.6-1.224C257.7,921.97,260.083,922.423,262,922.713Zm-41.6-4.458a4.14,4.14,0,0,0-.825.1l0.082,0.007Zm563.549-58.511c0.118-.545.235-1.081,0.339-1.562C785.034,854.507,784.5,857,783.951,859.744ZM662.029,1003.76c1.865-.95,3.725-1.84,5.635-2.9-1.57.78-3,1.4-4.022,1.88A3.59,3.59,0,0,0,662.029,1003.76ZM779.893,641.172a0.119,0.119,0,0,0,.012.022c-0.062-.469-0.117-0.881-0.18-1.35ZM675.875,996.813c-3.2,1.448-5.807,2.767-8.211,4.047C670.256,999.621,673.318,998.176,675.875,996.813Zm-631.3-43.252c-0.609.282-1.2,0.609-1.8,0.912a0.633,0.633,0,0,1-.2.128C43.242,954.257,43.9,953.886,44.574,953.561Zm-2,1.04L40.6,955.649C41.509,955.173,42.3,954.762,42.575,954.6Zm-6.141,3.248,4.163-2.2C39.151,956.4,37.366,957.326,36.434,957.849Zm59.5-24.833,0.583-.263A2.428,2.428,0,0,0,95.932,933.016Zm16.2-4.566-7.026,1.766c-2.618.728-5.424,1.523-8.108,2.328l-0.483.209c1.244-.435,4.234-1.249,7.359-2.116S110.308,929.016,112.132,928.45Zm69.459-9.019-7.024.328-7.016.484c2.462-.079,5.693-0.171-0.679.326,8.847-.492,7.929-0.483,7.1-0.519C173.141,920.038,172.387,919.862,181.591,919.431Zm43.564,0.721c-7.541-.391.077,0.183-0.328,0.234C229.607,920.643,230.768,920.7,225.155,920.152ZM519.89,1024.66l-0.86.31C524.793,1026.16,519.126,1024.8,519.89,1024.66Zm60.079,1.41c-1.88.07-3.756,0.17-5.638,0.13l-2.652.61,4.151-.3C577.213,1026.41,578.59,1026.22,579.969,1026.07Zm35.755-2.52-2.477.7c3.161-.86,6.332-1.67,9.443-2.69l-3.464,1.06ZM776.4,579.706l-0.351,1.818C776.627,585.421,777.367,586.16,776.4,579.706Zm21.387-222.662c0.744-1,2.065-2.78,3.409-4.764s2.727-4.166,3.889-5.756c-1.619,1.98-2.971,4.147-4.263,5.976C799.556,354.349,798.446,355.925,797.782,357.044ZM1331.13,521.859c0.17-.72.27-1.458,0.38-2.193s0.22-1.469.28-2.214a42.475,42.475,0,0,1-1.73,8.174C1330.45,524.385,1330.85,523.143,1331.13,521.859Z"/>
</svg>
<?php
}
?>