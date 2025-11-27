<?php
/**
 * The template for displaying the footer.
 *
 * @package Allianz
 */
$back_totop_on = allianz_get_opt( 'back_totop_on', true );
?>
</main>
<footer id="cms-footer" class="<?php allianz_footer_css_class(); ?>"><?php 
    allianz_footer(); 
?></footer>
<?php if ( isset( $back_totop_on ) && $back_totop_on ) : ?>
    <a href="#" class="scroll-top"><i class="cmsi-long-arrow-up"></i></a>
<?php endif; ?>
<div id="cms-theme-cursor"></div>
<?php wp_footer(); ?>
</body>
</html>
