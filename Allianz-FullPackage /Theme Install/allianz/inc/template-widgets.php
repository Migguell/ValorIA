<?php
/**
 * Widget Search
 * 
 * */
if(function_exists('etc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        etc_register_wp_widget( 'CMS_Search' );
    });

    class CMS_Search extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'cms_search',
                esc_html__( '*CMS Search', 'allianz' ),
                array(
                    'description'                 => esc_attr__( 'Shows search form.', 'allianz' ),
                    'customize_selective_refresh' => true,
                )
            );
        }

        /**
         * Outputs the HTML for this widget.
         *
         * @param array $args An array of standard parameters for widgets in this theme
         * @param array $instance An array of settings for this widget instance
         * @return void Echoes it's output
         **/
        function widget( $args, $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'     => '',
                'placeholder'    => esc_html__('Search....', 'allianz')
            ) );

            $title = empty( $instance['title'] ) ? '' : $instance['title'];
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $placeholder = empty( $instance['placeholder'] ) ? '' : $instance['placeholder'];

            printf( '%s', $args['before_widget']);

            if(!empty($title)){
                printf( '%s %s %s', $args['before_title'] , $title , $args['after_title']);
            }
            ?>
            <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="text" placeholder="<?php echo esc_attr( $placeholder );?>" name="s" class="cms-search-field"/>
                <button type="submit" class="search-submit"><i class="cmsi-search"></i></button>
            </form>
            <?php
            printf('%s', $args['after_widget']);
        }

        /**
         * Deals with the settings when they are saved by the admin. Here is
         * where any validation should be dealt with.
         *
         * @param array $new_instance An array of new settings as submitted by the admin
         * @param array $old_instance An array of the previous settings
         * @return array The validated and (if necessary) amended settings
         **/
        function update( $new_instance, $old_instance )
        {
            $instance                = $old_instance;
            $instance['title']       = sanitize_text_field( $new_instance['title'] );
            $instance['placeholder'] = sanitize_text_field( $new_instance['placeholder'] );
            return $instance;
        }

        /**
         * Displays the form for this widget on the Widgets page of the WP Admin area.
         *
         * @param array $instance An array of the current settings for this widget
         * @return void Echoes it's output
         **/
        function form( $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'         => esc_html__( 'Search', 'allianz' ),
                'placeholder'   => esc_html__( 'Search...', 'allianz' ),
            ) );

            $title     = $instance['title'] ? esc_attr( $instance['title'] ) : esc_html__( 'Search', 'allianz' );
            $placeholder     = $instance['placeholder'] ? esc_attr( $instance['placeholder'] ) : esc_html__( 'Search...', 'allianz' );
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'allianz' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'placeholder' ) ); ?>"><?php esc_html_e( 'Placeholder:', 'allianz' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'placeholder' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'placeholder' ) ); ?>" type="text" value="<?php echo esc_attr( $placeholder ); ?>" />
            </p>
            <?php
        }
    }
}
/**
 * Recent Posts widgets
 *
 * @package CMS Theme
 * @subpackage Allianz
 * @since 1.0
 * 
 */
if(function_exists('etc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        etc_register_wp_widget( 'CMS_Recent_Posts_Widget' );
    });

    class CMS_Recent_Posts_Widget extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'cms_recent_posts',
                esc_html__( '*CMS Recent Posts', 'allianz' ),
                array(
                    'description' => esc_attr__( 'Shows your most recent posts.', 'allianz' ),
                    'customize_selective_refresh' => true,
                )
            );
        }

        /**
         * Outputs the HTML for this widget.
         *
         * @param array $args An array of standard parameters for widgets in this theme
         * @param array $instance An array of settings for this widget instance
         * @return void Echoes it's output
         **/
        function widget( $args, $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'     => '',
                'number'    => 3,
                'post_type' => 'post',
                'post_in'   => '',
                'layout'    => '1',
            ) );

            $title = empty( $instance['title'] ) ? '' : $instance['title'];
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            printf( '%s', $args['before_widget']);

            if(!empty($title)){
                printf( '%s %s %s', $args['before_title'] , $title , $args['after_title']);
            }

            $number = absint( $instance['number'] );
            /*if ( $number <= 0 || $number > 10) {
                $number = 4;
            }*/
            $post_type = $instance['post_type'];
            $post_in   = $instance['post_in'];
            $layout    = $instance['layout'];
            $sticky = '';
            if($post_in == 'featured') {
                $sticky = get_option( 'sticky_posts' );
            }
            $r = new WP_Query( array(
                'post_type'           => $post_type,
                'posts_per_page'      => $number,
                'no_found_rows'       => true,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'post__in'            => $sticky,
                'post__not_in'        => array(get_the_ID())
            ) );

            if ( $r->have_posts() ) { ?>
                <div class="cms-posts layout-<?php echo esc_attr($layout);?>">
                    <?php while ( $r->have_posts() ) {
                        $r->the_post();
                        global $post;
                    ?>
                     <div class="cms-item d-flex gap-20 align-items-center">
                        <?php if(has_post_thumbnail()) { ?>
                            <div class="cms-thumb flex-auto"><?php allianz_the_post_thumbnail(['size' => 'thumbnail', 'class' => '']); ?></div>
                        <?php } ?>
                        <div class="cms-content flex-basic">
                            <?php 
                                printf(
                                    '<div class="cms-title text-16 font-600 text-line-2 lh-125"><a href="%1$s" title="%2$s">%3$s</a></div>',
                                    esc_url( get_permalink() ),
                                    esc_attr( get_the_title() ),
                                    get_the_title()
                                );
                                echo '<div class="cms--meta text-14 text-primary pt-5">'.get_the_date('M j, Y').'</div>';
                            ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            <?php }
            wp_reset_postdata();
            printf('%s', $args['after_widget']);
        }

        /**
         * Deals with the settings when they are saved by the admin. Here is
         * where any validation should be dealt with.
         *
         * @param array $new_instance An array of new settings as submitted by the admin
         * @param array $old_instance An array of the previous settings
         * @return array The validated and (if necessary) amended settings
         **/
        function update( $new_instance, $old_instance )
        {
            $instance              = $old_instance;
            $instance['title']     = sanitize_text_field( $new_instance['title'] );
            $instance['number']    = absint( $new_instance['number'] );
            $instance['post_type'] = $new_instance['post_type'];
            $instance['post_in']   = $new_instance['post_in'];
            $instance['layout']    = $new_instance['layout'];
            return $instance;
        }

        /**
         * Displays the form for this widget on the Widgets page of the WP Admin area.
         *
         * @param array $instance An array of the current settings for this widget
         * @return void Echoes it's output
         **/
        function form( $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'         => esc_html__( 'Recent Posts', 'allianz' ),
                'post_type'     => 'post',
                'post_in'       => 'recent',
                'layout'        => '1',
                'number'        => 3,
            ) );

            $title     = $instance['title'] ? esc_attr( $instance['title'] ) : esc_html__( 'Recent Posts', 'allianz' );
            $number    = absint( $instance['number'] );
            $post_type = isset($instance['post_type']) ? esc_attr($instance['post_type']) : '';
            $post_in   = isset($instance['post_in']) ? esc_attr($instance['post_in']) : '';
            $layout    = isset($instance['layout']) ? esc_attr($instance['layout']) : '1';

            $post_type_list = etc_get_post_type_options();
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'allianz' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('post_type')); ?>"><?php esc_html_e( 'Post Type', 'allianz' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id('post_type') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post_type') ); ?>">
                <?php 
                    foreach ($post_type_list as $key => $value) {
                    ?>
                        <option value="<?php echo esc_attr($key) ?>"<?php if( $post_type == $key ){ echo 'selected="selected"';} ?>><?php echo esc_html($value); ?></option>
                    <?php
                    }
                ?>
                </select>
            </p>
            <p><label for="<?php echo esc_url($this->get_field_id('post_in')); ?>"><?php esc_html_e( 'Post in', 'allianz' ); ?></label>
             <select class="widefat" id="<?php echo esc_attr( $this->get_field_id('post_in') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post_in') ); ?>">
                <option value="recent"<?php if( $post_in == 'recent' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Recent', 'allianz'); ?></option>
                <option value="featured"<?php if( $post_in == 'featured' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Featured', 'allianz'); ?></option>
             </select>
             </p>
              <p><label for="<?php echo esc_url($this->get_field_id('layout')); ?>"><?php esc_html_e( 'Layout', 'allianz' ); ?></label>
             <select class="widefat" id="<?php echo esc_attr( $this->get_field_id('layout') ); ?>" name="<?php echo esc_attr( $this->get_field_name('layout') ); ?>">
                <option value="1"<?php if( $layout == '1' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Default', 'allianz'); ?></option>
             </select>
             </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'allianz' ); ?></label>
                <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" />
            </p>

            <?php
        }
    }
}

if(function_exists('etc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        etc_register_wp_widget( 'CMS_Categories_Widget' );
    });
    class CMS_Categories_Widget extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'cms_categories',
                esc_html__( '*CMS Categories', 'allianz' ),
                array(
                    'description' => esc_attr__( 'A list or dropdown of categories.', 'allianz' ),
                    'customize_selective_refresh' => true,
                )
            );
        }

        function widget( $args, $instance )
        {
            static $first_dropdown = true;

            $default_title = esc_html__( 'Categories', 'allianz' );
            $title         = ! empty( $instance['title'] ) ? $instance['title'] : $default_title;

            /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $count        = ! empty( $instance['count'] ) ? '1' : '0';
            $hierarchical = ! empty( $instance['hierarchical'] ) ? '1' : '0';
            $dropdown     = ! empty( $instance['dropdown'] ) ? '1' : '0';
            $included_cateogries     = ! empty( $instance['included_cateogries'] ) ? $instance['included_cateogries'] : '';

            printf('%s', $args['before_widget']);

            if ( $title ) {
                printf('%s',  $args['before_title'] . $title . $args['after_title']);
            }

            $cat_args = array(
                'orderby'      => 'name',
                'show_count'   => $count,
                'hierarchical' => $hierarchical,
                'include'      => $included_cateogries,
                //'orderby' => 'term_order'
            );

            if ( $dropdown ) {
                printf( '<form action="%s" method="get">', esc_url( home_url() ) );
                    $dropdown_id    = ( $first_dropdown ) ? 'cat' : "{$this->id_base}-dropdown-{$this->number}";
                    $first_dropdown = false;
                    echo '<label class="screen-reader-text" for="' . esc_attr( $dropdown_id ) . '">' . $title . '</label>';
                    $cat_args['show_option_none'] = esc_html__( 'Select Category', 'allianz' );
                    $cat_args['id']               = $dropdown_id;
                    wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args, $instance ) );
                echo '</form>';
                ?>

                <script>
                /* <![CDATA[ */
                (function() {
                    var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );
                    function onCatChange() {
                        if ( dropdown.options[ dropdown.selectedIndex ].value > 0 ) {
                            dropdown.parentNode.submit();
                        }
                    }
                    dropdown.onchange = onCatChange;
                })();
                /* ]]> */
                </script>

            <?php
            } else {
                $format = current_theme_supports( 'html5', 'navigation-widgets' ) ? 'html5' : 'xhtml';

                /** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
                $format = apply_filters( 'navigation_widgets_format', $format );

                if ( 'html5' === $format ) {
                    // The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
                    $title      = trim( strip_tags( $title ) );
                    $aria_label = $title ? $title : $default_title;
                    echo '<nav aria-label="' . esc_attr( $aria_label ) . '">';
                }
            ?>
                <ul><?php
                        $cat_args['title_li'] = '';
                        wp_list_categories( apply_filters( 'widget_categories_args', $cat_args, $instance ) );
                ?></ul>

                <?php
                if ( 'html5' === $format ) {
                    echo '</nav>';
                }
            }

            printf('%s', $args['after_widget']);
        }

        function update( $new_instance, $old_instance )
        {
            $instance                 = $old_instance;
            $instance['title']        = sanitize_text_field( $new_instance['title'] );
            $instance['count']        = ! empty( $new_instance['count'] ) ? 1 : 0;
            $instance['hierarchical'] = ! empty( $new_instance['hierarchical'] ) ? 1 : 0;
            $instance['dropdown']     = ! empty( $new_instance['dropdown'] ) ? 1 : 0;
            $instance['included_cateogries']     = ! empty( $new_instance['included_cateogries'] ) ? $new_instance['included_cateogries'] : '';

            return $instance;
        }

        function form( $instance )
        {
            // Defaults.
            $instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );
            $count        = isset( $instance['count'] ) ? (bool) $instance['count'] : false;
            $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
            $dropdown     = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
            $included_cateogries     = isset( $instance['included_cateogries'] ) ? $instance['included_cateogries'] : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title', 'allianz' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            </p>

            <p>
                <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'dropdown' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'dropdown' )); ?>"<?php checked( $dropdown ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id( 'dropdown' )); ?>"><?php echo esc_html__( 'Display as dropdown', 'allianz' ); ?></label>
                <br />

                <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>"<?php checked( $count ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php echo esc_html__( 'Show post counts', 'allianz' ); ?></label>
                <br />

                <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hierarchical' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hierarchical' )); ?>"<?php checked( $hierarchical ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id( 'hierarchical' )); ?>"><?php echo esc_html__( 'Show hierarchy', 'allianz' ); ?></label>
            </p>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('included_cateogries')); ?>"><?php echo esc_html__( 'Included Categories', 'allianz' ); ?></label>
                <?php
                $cat_args = array(
                    'walker'       => new Allianz_Walker_CategoryDropdown,
                    'id'           => $this->get_field_id('included_cateogries'),
                    'name'         => $this->get_field_name('included_cateogries') . '[]',
                    'orderby'      => 'name',
                    'show_count'   => true,
                    'hierarchical' => true,
                    'hide_empty'   => false,
                    'multiple'     => true,
                    'selected'     => $included_cateogries,
                );
                wp_dropdown_categories($cat_args);
                ?>
            </p>
            <?php
        }
    }
}

/**
 * Widget Categories
 * Custom HTML output
*/
if(!function_exists('allianz_widget_categories_args')){
    add_filter('widget_categories_args', 'allianz_widget_categories_args');
    add_filter('woocommerce_product_categories_widget_args', 'allianz_widget_categories_args');
    //add_filter('widget_cms_taxonomies_args', 'allianz_widget_categories_args');
    function allianz_widget_categories_args($cat_args){
        $cat_args['walker'] = new Allianz_Categories_Walker_Dropdown;
        return $cat_args; 
    }
}

class Allianz_Walker_CategoryDropdown extends Walker {

    /**
     * What the class handles.
     *
     * @since 2.1.0
     * @var string
     *
     * @see Walker::$tree_type
     */
    public $tree_type = 'category';

    /**
     * Database fields to use.
     *
     * @since 2.1.0
     * @todo Decouple this
     * @var string[]
     *
     * @see Walker::$db_fields
     */
    public $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id',
    );

    /**
     * Starts the element output.
     *
     * @since 2.1.0
     * @since 5.9.0 Renamed `$category` to `$data_object` and `$id` to `$current_object_id`
     *              to match parent class for PHP 8 named parameter support.
     *
     * @see Walker::start_el()
     *
     * @param string  $output            Used to append additional content (passed by reference).
     * @param WP_Term $data_object       Category data object.
     * @param int     $depth             Depth of category. Used for padding.
     * @param array   $args              Uses 'selected', 'show_count', and 'value_field' keys, if they exist.
     *                                   See wp_dropdown_categories().
     * @param int     $current_object_id Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
        // Restores the more descriptive, specific name for use within this method.
        $category = $data_object;
        $pad      = str_repeat( '&nbsp;', $depth * 3 );

        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters( 'list_cats', $category->name, $category );

        if ( isset( $args['value_field'] ) && isset( $category->{$args['value_field']} ) ) {
            $value_field = $args['value_field'];
        } else {
            $value_field = 'term_id';
        }

        $output .= "\t<option class=\"level-$depth\" value=\"" . esc_attr( $category->{$value_field} ) . '"';

        // Type-juggling causes false matches, so we force everything to a string.

        $selected = $args['selected'];
        if(is_array($selected)){
            if (in_array((string) $category->{$value_field}, $selected)) {
                $output .= ' selected="selected"';
            }
        }
        else{
            if ( (string) $category->{$value_field} === (string) $args['selected'] ) {
                $output .= ' selected="selected"';
            }
        }
        
        $output .= '>';
        $output .= $pad . $cat_name;
        if ( $args['show_count'] ) {
            $output .= '&nbsp;&nbsp;(' . number_format_i18n( $category->count ) . ')';
        }
        $output .= "</option>\n";
    }
}

/**
 * Allianz_Categories_Walker_Tree
 *
 * @package CMS Theme
 * @subpackage Allianz
 * @since 1.0
 *
 */
class Allianz_Categories_Walker_Tree extends Walker_Category {
    /**
     * Starts the list before the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='cms-children cms-tree'>\n";
    }
    /**
     * Starts the element output.
     *
     * @since 2.1.0
     *
     * @see Walker::start_el()
     *
     * @param string $output   Used to append additional content (passed by reference).
     * @param object $category Category data object.
     * @param int    $depth    Optional. Depth of category in reference to parents. Default 0.
     * @param array  $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
     * @param int    $id       Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );
 
        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }
 
        $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filters the category description for display.
             *
             * @since 1.2.0
             *
             * @param string $description Category description.
             * @param object $category    Category object.
             */
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        }
 
        $link .= '>';

        if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
            $link .= '<span class="title">'.$cat_name.'</span>';
            if ( ! empty( $args['show_count'] ) ) {
                $link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
            }
        } else {
            $link .= '<span class="title">'.$cat_name.'</span>';
            if ( ! empty( $args['show_count'] ) ) {
                $link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
            }
        }

        $link .= '</a>';

        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
            $link .= ' ';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= '(';
            }
 
            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';
 
            if ( empty( $args['feed'] ) ) {
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s','allianz' ), $cat_name ) . '"';
            } else {
                $alt = ' alt="' . $args['feed'] . '"';
                $name = $args['feed'];
                $link .= empty( $args['title'] ) ? '' : $args['title'];
            }
 
            $link .= '>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= $name;
            } else {
                $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
            }
            $link .= '</a>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= ')';
            }
        }
        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $css_classes = array(
                'cms-item',
                'cms-menu-item'
            );
            if($args['has_children']){
                $css_classes[] =  'parents';
            }
            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );
 
                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-parent current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-ancestor current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }
 
            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'cms_tree_category_css_class', $css_classes, $category, $depth, $args ) );
 
            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
}
/**
 * Allianz_Categories_Walker_Dropdown
 *
 * @version 1.0
 * @package Allianz
 * @since   1.0
 *
 */
class Allianz_Categories_Walker_Dropdown extends Walker_Category {
    /**
     * Starts the list before the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='children cms-dropdown'>\n";
    }
    /**
     * Starts the element output.
     *
     * @since 2.1.0
     *
     * @see Walker::start_el()
     *
     * @param string $output   Used to append additional content (passed by reference).
     * @param object $category Category data object.
     * @param int    $depth    Optional. Depth of category in reference to parents. Default 0.
     * @param array  $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
     * @param int    $id       Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );
 
        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }
 
        $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filters the category description for display.
             *
             * @since 1.2.0
             *
             * @param string $description Category description.
             * @param object $category    Category object.
             */
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        }
 
        $link .= '>';

        if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
            $link .= '<span class="title">'.$cat_name.'</span>';
            if ( ! empty( $args['show_count'] ) ) {
                //$link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
            }
            $dropdown_arrow = '<span class="cms-menu-toggle"></span>';
        } else {
            $link .= '<span class="title">'.$cat_name.'</span>';
            if ( ! empty( $args['show_count'] ) ) {
                $link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
            }
            $dropdown_arrow = '';
        }

        $link .= $dropdown_arrow.'</a>';
        
        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
            $link .= ' ';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= '(';
            }
 
            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';
 
            if ( empty( $args['feed'] ) ) {
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s','allianz' ), $cat_name ) . '"';
            } else {
                $alt = ' alt="' . $args['feed'] . '"';
                $name = $args['feed'];
                $link .= empty( $args['title'] ) ? '' : $args['title'];
            }
 
            $link .= '>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= $name;
            } else {
                $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
            }
            $link .= '</a>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= ')';
            }
        }
        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $css_classes = array(
                'cms-list-item',
                'cms-widget-menu-item'
            );
            if($args['has_children']){
                $css_classes[] = 'parents';
            }
            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );
 
                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-parent current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-ancestor current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }
 
            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'cms_dropdown_category_css_class', $css_classes, $category, $depth, $args ) );
 
            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
}

/**
 * Widget Tag Cloud WP 
 * Change separator text, font size, ...
 * Hook filter: widget_tag_cloud_args, woocommerce_product_tag_cloud_widget_args
 * 
 * @package CMS Theme
 * @subpackage Allianz
 * @since 1.0
 * 
*/
if(!function_exists('allianz_widget_tag_cloud_args')){
    add_filter('widget_tag_cloud_args', 'allianz_widget_tag_cloud_args');
    add_filter('woocommerce_product_tag_cloud_widget_args', 'allianz_widget_tag_cloud_args');
    function allianz_widget_tag_cloud_args($args){
        $_args =[
            'smallest'  => '13',
            'largest'   => '13',
            'unit'      => 'px',
            'separator' => ''
        ];
        $args = wp_parse_args($args, $_args);
        return $args;
    }
}

if(!function_exists('allianz_wp_dropdown_cats')){
    add_filter('wp_dropdown_cats', 'allianz_wp_dropdown_cats', 10, 2);
    function allianz_wp_dropdown_cats($output, $parsed_args){
        $output = preg_replace('/<select([^>]*)>/', '<select$1 egrid-products-category-filter>', $output);
        if(isset($parsed_args['multiple']) && $parsed_args['multiple'] == true){
            $output = preg_replace('/<select([^>]*)>/', '<select$1 multiple>', $output);
        }

        return $output;
    }
}

/**
 * Widget API: Allianz_Widget_Media_Gallery class
 *
 * @package CMS Theme
 * @subpackage Allianz
 * @since 1.0.0
 */
if(function_exists('etc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        etc_register_wp_widget( 'Allianz_Widget_Media_Gallery' );
    });
    class Allianz_Widget_Media_Gallery extends WP_Widget_Media {
        /**
         * Constructor.
         *
         * @since 1.0.0
         */
        public function __construct() {
            parent::__construct(
                'cms_media_gallery',
                __( '*CMS Gallery', 'allianz' ),
                array(
                    'description' => __( 'Displays an image gallery.','allianz' ),
                    'mime_type'   => 'image',
                )
            );

            $this->l10n = array_merge(
                $this->l10n,
                array(
                    'no_media_selected' => __( 'No images selected', 'allianz' ),
                    'add_media'         => _x( 'Add Images', 'label for button in the gallery widget; should not be longer than ~13 characters long', 'allianz' ),
                    'replace_media'     => '',
                    'edit_media'        => _x( 'Edit Gallery', 'label for button in the gallery widget; should not be longer than ~13 characters long' , 'allianz'),
                )
            );
        }
        /**
         * Get schema for properties of a widget instance (item).
         *
         * @since 1.0.0
         *
         * @see WP_REST_Controller::get_item_schema()
         * @see WP_REST_Controller::get_additional_fields()
         * @link https://core.trac.wordpress.org/ticket/35574
         *
         * @return array Schema for properties.
         */
        public function get_instance_schema() {
            $schema = array(
                'title'          => array(
                    'type'                  => 'string',
                    'default'               => '',
                    'sanitize_callback'     => 'sanitize_text_field',
                    'description'           => __( 'Title for the widget', 'allianz' ),
                    'should_preview_update' => false,
                ),
                'custom_url'          => array(
                    'type'                  => 'string',
                    'default'               => '',
                    'sanitize_callback'     => 'sanitize_text_field',
                    'description'           => __( 'Custom URL', 'allianz' ),
                    'should_preview_update' => false,
                ),
                'image_size_w'          => array(
                    'type'                  => 'string',
                    'default'               => 90,
                    //'sanitize_callback'     => 'sanitize_text_field',
                    'description'           => __( 'Image Size Width', 'allianz' ),
                    //'should_preview_update' => false,
                ),
                'image_size_h'          => array(
                    'type'                  => 'string',
                    'default'               => 90,
                    //'sanitize_callback'     => 'sanitize_text_field',
                    'description'           => __( 'Image Size Height', 'allianz' ),
                    //'should_preview_update' => false,
                ),
                'ids'            => array(
                    'type'              => 'array',
                    'items'             => array(
                        'type' => 'integer',
                    ),
                    'default'           => array(),
                    'sanitize_callback' => 'wp_parse_id_list',
                ),
                'columns'        => array(
                    'type'    => 'integer',
                    'default' => 3,
                    'minimum' => 1,
                    'maximum' => 6,
                ),
                'size'           => array(
                    'type'    => 'string',
                    'enum'    => array_merge( get_intermediate_image_sizes()), // array( 'full', 'custom' ) 
                    'default' => 'thumbnail',
                ),
                'link_type'      => array(
                    'type'                  => 'string',
                    'enum'                  => array( 'none' ), //'post', 'file',
                    'default'               => 'none',
                    'media_prop'            => 'link',
                    'should_preview_update' => false,
                ),
                'orderby_random' => array(
                    'type'                  => 'boolean',
                    'default'               => false,
                    'media_prop'            => '_orderbyRandom',
                    'should_preview_update' => false,
                ),
            );

            /** This filter is documented in wp-includes/widgets/class-wp-widget-media.php */
            $schema = apply_filters( "widget_{$this->id_base}_instance_schema", $schema, $this );

            return $schema;
        }

        /**
         * Render the media on the frontend.
         *
         * @since 1.0.0
         *
         * @param array $instance Widget instance props.
         */
        public function render_media( $instance ) {
            $instance = array_merge( wp_list_pluck( $this->get_instance_schema(), 'default' ), $instance );
            $shortcode_atts = array_merge(
                $instance,
                array(
                    'link' => $instance['link_type'],
                )
            );
            // @codeCoverageIgnoreStart
            if ( $instance['orderby_random'] ) {
                $shortcode_atts['orderby'] = 'rand';
            }
            // @codeCoverageIgnoreEnd
            //echo gallery_shortcode( $shortcode_atts );
            // Custom layout
            $custom_image_size_w = !empty($instance['image_size_w']) && is_numeric($instance['image_size_w']) ? $instance['image_size_w'] : '';
            $custom_image_size_h = !empty($instance['image_size_h']) && is_numeric($instance['image_size_h']) ? $instance['image_size_h'] : $custom_image_size_w;
            $custom_image_size = [$custom_image_size_w, $custom_image_size_h];

            $image_size = (!empty($custom_image_size_w) || !empty($custom_image_size_h)) ? $custom_image_size : $instance['size'];
        ?>
            <div class="cms-wg-gallery d-flex flex-col-<?php echo esc_attr($instance['columns']); ?> gutter-10">
                <?php foreach ($instance['ids'] as $key => $id) {
                ?>
                    <a href="<?php echo esc_url($instance['custom_url']) ?>">
                        <?php echo wp_get_attachment_image($id, $image_size, false, ['loading' => 'lazy']); ?>
                    </a>
                <?php
                } ?>
            </div>
        <?php
        }

        /**
         * Loads the required media files for the media manager and scripts for media widgets.
         *
         * @since 1.0.0
         */
        public function enqueue_admin_scripts() {
            parent::enqueue_admin_scripts();

            $handle = 'cms-media-gallery-widget';
            wp_enqueue_script( $handle );

            $exported_schema = array();
            foreach ( $this->get_instance_schema() as $field => $field_schema ) {
                $exported_schema[ $field ] = wp_array_slice_assoc( $field_schema, array( 'type', 'default', 'enum', 'minimum', 'format', 'media_prop', 'should_preview_update', 'items' ) );
            }
            wp_add_inline_script(
                $handle,
                sprintf(
                    'wp.mediaWidgets.modelConstructors[ %s ].prototype.schema = %s;',
                    wp_json_encode( $this->id_base ),
                    wp_json_encode( $exported_schema )
                )
            );

            wp_add_inline_script(
                $handle,
                sprintf(
                    '
                        wp.mediaWidgets.controlConstructors[ %1$s ].prototype.mime_type = %2$s;
                        _.extend( wp.mediaWidgets.controlConstructors[ %1$s ].prototype.l10n, %3$s );
                    ',
                    wp_json_encode( $this->id_base ),
                    wp_json_encode( $this->widget_options['mime_type'] ),
                    wp_json_encode( $this->l10n )
                )
            );
        }
        /**
     * Render form template scripts.
     *
     * @since 4.9.0
     */
    public function render_control_template_scripts() {
        //parent::render_control_template_scripts();
        ?>
        <script type="text/html" id="tmpl-widget-media-<?php echo esc_attr( $this->id_base ); ?>-control">
            <# var elementIdPrefix = 'el' + String( Math.random() ) + '_' #>
            <p>
                <label for="{{ elementIdPrefix }}title"><?php esc_html_e( 'Title:', 'allianz' ); ?></label>
                <input id="{{ elementIdPrefix }}title" type="text" class="widefat title">
            </p>
            <p>
                <label for="{{ elementIdPrefix }}custom_url"><?php esc_html_e( 'Custom URL', 'allianz' ); ?></label>
                <input id="{{ elementIdPrefix }}custom_url" type="text" class="widefat custom_url">
            </p>
            <table>
                <tr><td colspan="2"><strong><?php esc_html_e( 'Image Size (Number Only!)', 'allianz' ); ?></strong></td></tr>
                <tr>
                    <td>
                        <?php // Image size Width ?>
                        <label for="{{ elementIdPrefix }}image_size_w"><?php esc_html_e( 'Width', 'allianz' ); ?></label>
                        <input id="{{ elementIdPrefix }}image_size_w" type="number" class="widefat image_size_w">
                        <?php // Image Size Height ?>
                    </td>
                    <td>
                        <label for="{{ elementIdPrefix }}image_size_h"><?php esc_html_e( 'Height', 'allianz' ); ?></label>
                        <input id="{{ elementIdPrefix }}image_size_h" type="number" class="widefat image_size_h">
                    </td>
                </tr>
            </table>
            <p></p>
            <div class="media-widget-preview <?php echo esc_attr( $this->id_base ); ?>">
                <div class="attachment-media-view">
                    <button type="button" class="select-media button-add-media not-selected">
                        <?php echo esc_html( $this->l10n['add_media'] ); ?>
                    </button>
                </div>
            </div>
            <p class="media-widget-buttons">
                <button type="button" class="button edit-media selected">
                    <?php echo esc_html( $this->l10n['edit_media'] ); ?>
                </button>
            <?php if ( ! empty( $this->l10n['replace_media'] ) ) : ?>
                <button type="button" class="button change-media select-media selected">
                    <?php echo esc_html( $this->l10n['replace_media'] ); ?>
                </button>
            <?php endif; ?>
            </p>
            <div class="media-widget-fields">
            </div>
        </script>
        <script type="text/html" id="tmpl-wp-media-widget-gallery-preview">
            <#
            var ids = _.filter( data.ids, function( id ) {
                return ( id in data.attachments );
            } );
            #>
            <# if ( ids.length ) { #>
                <ul class="gallery media-widget-gallery-preview" role="list">
                    <# _.each( ids, function( id, index ) { #>
                        <# var attachment = data.attachments[ id ]; #>
                        <# if ( index < 6 ) { #>
                            <li class="gallery-item">
                                <div class="gallery-icon">
                                    <img alt="{{ attachment.alt }}"
                                        <# if ( index === 5 && data.ids.length > 6 ) { #> aria-hidden="true" <# } #>
                                        <# if ( attachment.sizes.thumbnail ) { #>
                                            src="{{ attachment.sizes.thumbnail.url }}" width="{{ attachment.sizes.thumbnail.width }}" height="{{ attachment.sizes.thumbnail.height }}"
                                        <# } else { #>
                                            src="{{ attachment.url }}"
                                        <# } #>
                                        <# if ( ! attachment.alt && attachment.filename ) { #>
                                            aria-label="
                                            <?php
                                            echo esc_attr(
                                                sprintf(
                                                    /* translators: %s: The image file name. */
                                                    esc_html__( 'The current image has no alternative text. The file name is: %s' , 'allianz'),
                                                    '{{ attachment.filename }}'
                                                )
                                            );
                                            ?>
                                            "
                                        <# } #>
                                    />
                                    <# if ( index === 5 && data.ids.length > 6 ) { #>
                                    <div class="gallery-icon-placeholder">
                                        <p class="gallery-icon-placeholder-text" aria-label="
                                        <?php
                                            printf(
                                                /* translators: %s: The amount of additional, not visible images in the gallery widget preview. */
                                                __( 'Additional images added to this gallery: %s', 'allianz' ),
                                                '{{ data.ids.length - 5 }}'
                                            );
                                        ?>
                                        ">+{{ data.ids.length - 5 }}</p>
                                    </div>
                                    <# } #>
                                </div>
                            </li>
                        <# } #>
                    <# } ); #>
                </ul>
            <# } else { #>
                <div class="attachment-media-view">
                    <button type="button" class="placeholder button-add-media"><?php echo esc_html( $this->l10n['add_media'] ); ?></button>
                </div>
            <# } #>
        </script>
        <?php
        }
        protected function has_content( $instance ) {
            if ( ! empty( $instance['ids'] ) ) {
                $attachments = wp_parse_id_list( $instance['ids'] );
                foreach ( $attachments as $attachment ) {
                    if ( 'attachment' !== get_post_type( $attachment ) ) {
                        return false;
                    }
                }
                return true;
            }
            return false;
        }
    }
}
/**
 * Follow Us widgets
 *
 * @package CMS Theme
 * @subpackage Allianz
 * @since 1.0
 * 
 */
if(function_exists('etc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        etc_register_wp_widget( 'CMS_Follow_Us_Widget' );
    });

    class CMS_Follow_Us_Widget extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'cms_follow_us',
                esc_html__( '*CMS Follow Us', 'allianz' ),
                array(
                    'description' => esc_attr__( 'Shows your social networks.', 'allianz' ),
                    'customize_selective_refresh' => true,
                )
            );
        }

        /**
         * Outputs the HTML for this widget.
         *
         * @param array $args An array of standard parameters for widgets in this theme
         * @param array $instance An array of settings for this widget instance
         * @return void Echoes it's output
         **/
        function widget( $args, $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'   => '',
                'url1'    => 'https://facebook.com/cmssuperheroes',
                'icon1'   => 'cmsi-facebook',
                'url2'    => 'https://instagram.com/',
                'icon2'   => 'cmsi-instagram',
                'url3'    => 'https://tiktok.com/',
                'icon3'   => 'cmsi-tik-tok', 
                'url4'    => 'https://twitter.com/',
                'icon4'   => 'cmsi-twitter', 
                'url5'    => '',
                'icon5'   => '',
                'url6'    => '',
                'icon6'   => '', 
            ) );
            $title = empty( $instance['title'] ) ? '' : $instance['title'];
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            printf( '%s', $args['before_widget']);

            if(!empty($title)){
                printf( '%s %s %s', $args['before_title'] , $title , $args['after_title']);
            }
        ?>
        <div class="cms-wg-follow-us">
            <?php  if(!empty($instance['url1']) && !empty($instance['icon1'])){ ?>
                <a href="<?php echo esc_url($instance['url1']) ?>" target="_blank"><i class="<?php echo esc_attr($instance['icon1']); ?>"></i></a>
            <?php }
            if(!empty($instance['url2']) && !empty($instance['icon2'])){ ?>
                <a href="<?php echo esc_url($instance['url2']) ?>" target="_blank"><i class="<?php echo esc_attr($instance['icon2']); ?>"></i></a>
            <?php }
            if(!empty($instance['url3']) && !empty($instance['icon3'])){ ?>
                <a href="<?php echo esc_url($instance['url3']) ?>" target="_blank"><i class="<?php echo esc_attr($instance['icon3']); ?>"></i></a>
            <?php }
            if(!empty($instance['url4']) && !empty($instance['icon4'])){ ?>
                <a href="<?php echo esc_url($instance['url4']) ?>" target="_blank"><i class="<?php echo esc_attr($instance['icon4']); ?>"></i></a>
            <?php }
            if(!empty($instance['url5']) && !empty($instance['icon5'])){ ?>
                <a href="<?php echo esc_url($instance['url5']) ?>" target="_blank"><i class="<?php echo esc_attr($instance['icon5']); ?>"></i></a>
            <?php }
            if(!empty($instance['url6']) && !empty($instance['icon6'])){ ?>
                <a href="<?php echo esc_url($instance['url6']) ?>" target="_blank"><i class="<?php echo esc_attr($instance['icon6']); ?>"></i></a>
            <?php } ?>
        </div>
        <?php
            printf('%s', $args['after_widget']);
        }

        /**
         * Deals with the settings when they are saved by the admin. Here is
         * where any validation should be dealt with.
         *
         * @param array $new_instance An array of new settings as submitted by the admin
         * @param array $old_instance An array of the previous settings
         * @return array The validated and (if necessary) amended settings
         **/
        function update( $new_instance, $old_instance )
        {
            $instance          = $old_instance;
            $instance['title'] = sanitize_text_field( $new_instance['title'] );

            $instance['url1']  = $new_instance['url1'];
            $instance['icon1'] = $new_instance['icon1'];
            $instance['url2']  = $new_instance['url2'];
            $instance['icon2'] = $new_instance['icon2'];
            $instance['url3']  = $new_instance['url3'];
            $instance['icon3'] = $new_instance['icon3'];
            $instance['url4']  = $new_instance['url4'];
            $instance['icon4'] = $new_instance['icon4'];
            $instance['url5']  = $new_instance['url5'];
            $instance['icon5'] = $new_instance['icon5'];
            $instance['url6']  = $new_instance['url6'];
            $instance['icon6'] = $new_instance['icon6'];

            return $instance;
        }

        /**
         * Displays the form for this widget on the Widgets page of the WP Admin area.
         *
         * @param array $instance An array of the current settings for this widget
         * @return void Echoes it's output
         **/
        function form( $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'   => esc_html__( 'CMS Follow Us', 'allianz' ),
                'url1'    => 'https://facebook.com/cmssuperheroes',
                'icon1'   => 'cmsi-facebook',
                'url2'    => 'https://instagram.com/',
                'icon2'   => 'cmsi-instagram',
                'url3'    => 'https://tiktok.com/',
                'icon3'   => 'cmsi-tik-tok', 
                'url4'    => 'https://twitter.com/',
                'icon4'   => 'cmsi-twitter', 
                'url5'    => '',
                'icon5'   => '',
                'url6'    => '',
                'icon6'   => '', 
            ) );
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'allianz' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            </p>
            <?php for ($i=1; $i <= 6 ; $i++) { ?>
                <table>
                    <tr><td colspan="2"><strong><?php echo esc_html__('Network','allianz').' '.$i; ?></strong></td></tr>
                    <tr>
                        <td>
                            <label for="<?php echo esc_attr( $this->get_field_id( 'url'.$i ) ); ?>"><?php echo esc_html__( 'Url', 'allianz' ); ?></label>
                            <input class="" id="<?php echo esc_attr( $this->get_field_id( 'url'.$i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url'.$i ) ); ?>" type="text" value="<?php echo esc_attr( $instance['url'.$i]); ?>" />
                        </td>
                        <td>
                            <label for="<?php echo esc_attr( $this->get_field_id( 'icon'.$i ) ); ?>"><?php echo esc_html__( 'Icon', 'allianz' ); ?></label>
                            <input class="" id="<?php echo esc_attr( $this->get_field_id( 'icon'.$i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon'.$i ) ); ?>" type="text" value="<?php echo esc_attr( $instance['icon'.$i] ); ?>" />
                        </td>
                    </tr>
                </table>
                <?php
            }
        }
    }
}