<?php
/**
 * The template for displaying all single posts
 *
 * @package Allianz
 */
$sidebar_name = 'sidebar-post';

get_header();
	if(allianz_is_built_with_elementor()){
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	} else {
		allianz_content_has_sidebar_open($sidebar_name);
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content-single/content', get_post_format() );
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			}
		allianz_content_has_sidebar_close($sidebar_name);

		if(allianz_get_opt('sidebar_on', 'off') === 'on' && is_active_sidebar($sidebar_name)){ 
			$sidebar_pos = allianz_get_opt('sidebar_pos', 'order-last');
		?>
			<div id="cms-sidebar" class="<?php echo esc_attr($sidebar_pos); ?> flex-basic">
				<?php dynamic_sidebar($sidebar_name); ?>
			</div>
		<?php
		}
	}
get_footer();