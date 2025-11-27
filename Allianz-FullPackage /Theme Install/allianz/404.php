<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Allianz
 */
$title_404_page    = allianz_get_opt( 'title_404_page' );
$content_404_page  = str_replace("\'","'", allianz_get_opt( 'content_404_page' ));
$btn_text_404_page = allianz_get_opt( 'btn_text_404_page' );
get_header(); ?>
    <h1 class="w-100 lh-1 text-accent">404</h1>
    <h3 class="w-100">
        <?php if ( ! empty( $title_404_page ) ) {
            printf( '%s', $title_404_page );
        } else {
            echo esc_html__( "Oops! That page can’t be found.", "allianz" );
        } ?>
    </h3>
    <div class="page-content w-100">
        <?php if ( ! empty( $content_404_page ) ) {
            printf( '%s', $content_404_page );
        } else {
            echo esc_html__( "The page requested couldn't be found. This could be a spelling error in the URL or a removed page.", "allianz" );
        } ?>
    </div>
    <div class="w-100">
        <a class="btn btn-accent text-white btn-hover-primary text-hover-white" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <i class="cmsi-arrow-left rtl-flip text-10"></i>
            <?php if ( ! empty( $btn_text_404_page ) ) {
                printf( '%s', $btn_text_404_page );
            } else {
                echo esc_html__( 'Back To Home', 'allianz' );
            } ?>
        </a>
    </div>
<?php
get_footer();
