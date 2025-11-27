<?php
/**
 * Search Form
 */
$search_field_placeholder = allianz_get_opt( 'search_field_placeholder', esc_html__('What are you looking for?','allianz') );
?>
<form role="search" method="get" class="search-form d-flex gap" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" placeholder="<?php echo esc_attr( $search_field_placeholder );?>" name="s" class="search-field"/>
    <button type="submit" class="search-submit"><i class="cmsi-search"></i></button>
</form>