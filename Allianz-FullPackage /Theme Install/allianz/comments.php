<?php
/**
 * The template for displaying comments.
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package Allianz
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
$post_comments_form_on = allianz_get_opt( 'post_comments_form_on', true );

if ( $post_comments_form_on ) : ?>
    <div id="comments" class="comments-area"><?php
		// You can start editing here -- including this comment!
		if ( have_comments() ) : ?>
            <div class="comment-list-wrap">
                <div class="comments-title text-26 font-600 text-heading">
					<?php
					$comment_count = get_comments_number();
					if ( 1 === intval( $comment_count ) ) {
						echo esc_html__( '1 Comment', 'allianz' );
					} else {
						echo esc_attr( $comment_count ) . ' ' . esc_html__( 'Comments', 'allianz' );
					}
					?>
                </div><!-- .comments-title -->
				<?php the_comments_navigation(); ?>

                <div class="comment-list">
					<?php
					wp_list_comments( array(
						'style'      => 'div',
						'short_ping' => true,
						'callback'   => 'allianz_comment_list',
						'max_depth'  => 3
					) );
					?>
                </div><!-- .comment-list -->

				<?php the_comments_navigation(); ?>
            </div>
			<?php if ( ! comments_open() ) : ?>
                <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'allianz' ); ?></p>
			<?php
			endif;
		endif; // Check for have_comments(). 
		comment_form( allianz_comment_form_args() );
	?></div>
<?php endif; ?>