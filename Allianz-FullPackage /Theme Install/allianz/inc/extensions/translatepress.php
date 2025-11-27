<?php
/**
 * Change flags folder path for certain languages.
 *
 * Add the language codes you wish to replace in the list below.
 * Make sure you place your desired flags in a folder called "flags" next to this file.
 * Make sure the file names for the flags  are identical with the ones in the original folder located at 'plugins/translatepress/assets/images/flags/'.
 * If you wish to change the file names, use filter trp_flag_file_name .
 *
 * @package CMS Theme
 * @subpackage Allianz
 * @since 1.0
 * 
 */
add_filter( 'trp_flags_path', 'allianz_trpc_flags_path', 10, 2 );
function allianz_trpc_flags_path( $original_flags_path,  $language_code ){
	// only change the folder path for the following languages:
	$languages_with_custom_flags = array( 'en_US', 'es_ES', 'ar_AR', 'ar' );

	if ( in_array( $language_code, $languages_with_custom_flags ) ) {
		return  get_template_directory_uri() . '/assets/images/language-flags/' ;
	} else {
		return $original_flags_path;
	}
}

/**
 * Language list
 * 
 * IMPORTANT! You need to have data-no-translation on the wrapper with the links or 
 * TranslatePress will automatically translate them in a secondary language.
 * */
function cms_language_switcher($args = []){
    $args = wp_parse_args($args, [
        'class'          => '',
        'item_class'     => '',
        'link_class'     => '',   
        'sub_link_class' => '',   
        'show_flag'      => 'yes',
        'show_name'      => 'yes',
        'name_as'        => 'full', // short 
        'dropdown_pos'   => 'bottom'
    ]);
    $languages = trp_custom_language_switcher();
    global $TRP_LANGUAGE;

    $classes = ['cms-ls', 'cms-dropdown', 'dropdown-'.$args['dropdown_pos'], 'cms-touchedside', $args['class']];
    $item_classes = ['cms-ls-item', $args['item_class']];
    $link_classes = ['cms-ls-link','current-language', $args['link_class']];
    $sub_link_classes = ['cms-ls-link', $args['sub_link_class']];
    $flag_class = ['cms-lflag'];
    $text_class =['cms-lname'];
?>  
    <ul class="<?php echo implode(' ', array_filter($classes)); ?>" data-no-translation>
        <li class="<?php echo implode(' ', array_filter($item_classes)) ?>">
            <?php 
                foreach ($languages as $name => $item){
                    if($item['language_code'] === $TRP_LANGUAGE) {
            ?>
                    <a href="<?php echo esc_url($item['current_page_url']);?>" onclick="event.preventDefault()" class="<?php echo implode(' ', array_filter($link_classes)); ?>">
                        <?php if($args['show_flag'] === 'yes'){ 
                            $flag_class[] = 'pr-tablet-0';
                            ?>
                            <img src="<?php echo esc_url($item['flag_link']); ?>" title="<?php echo esc_attr($item['language_name']); ?>" alt="<?php echo esc_attr($item['language_name']); ?>" class="<?php echo implode(' ', array_filter($flag_class)); ?>" />
                        <?php } 
                            if($args['show_name'] === 'yes'){
                                if($args['show_name'] === 'yes' && $args['show_flag'] === 'yes'){
                                    $text_class[] = 'cms-hidden-max-tablet';
                                }
                        ?>
                            <span class="<?php echo implode(' ', array_filter($text_class)); ?>">
                                <?php 
                                    switch ($args['name_as']) {
                                        case 'short':
                                            echo esc_html($item['short_language_name']);
                                            break;
                                        
                                        default:
                                            echo esc_html($item['language_name']);
                                            break;
                                    }
                                ?>
                            </span>
                        <?php } ?>
                        <span class="cmsi-chevron-down text-10"></span>
                    </a>
                <?php
                }
            }
            if(count($languages)>1){
            ?>
            <ul class="dropdown cms--touchedside">
                <?php foreach ($languages as $name => $item){
                    if($item['language_code'] != $TRP_LANGUAGE) { 
                    ?>
                        <li class="<?php echo implode(' ', array_filter($item_classes)); ?>"> 
                            <a href="<?php echo esc_url($item['current_page_url']);?>" class="<?php echo implode(' ', array_filter($sub_link_classes)); ?>">
                                <?php //if($args['show_flag'] === 'yes'){ ?>
                                    <img src="<?php echo esc_url($item['flag_link']); ?>" title="<?php echo esc_attr($item['language_name']); ?>" alt="<?php echo esc_attr($item['language_name']); ?>" class="<?php echo implode(' ', array_filter($flag_class)); ?>" />
                                <?php //} 
                                    //if($args['show_name'] === 'yes'){
                                ?>
                                    <span class="cms-lname">
                                        <?php 
                                            switch ($args['name_as']) {
                                                case 'short':
                                                    echo esc_html($item['short_language_name']);
                                                    break;
                                                
                                                default:
                                                    echo esc_html($item['language_name']);
                                                    break;
                                            }
                                        ?>
                                    </span>
                                <?php //} ?>
                            </a>
                        </li>
                <?php } 
                } ?>
            </ul>
            <?php } ?>
        </li>
    </ul>
<?php
}
// Change currency based on Language 
if(class_exists('WOOCS_STARTER')){
    //add_filter('wp_head', 'allianz_woosc_base_on_language');
    function allianz_woosc_base_on_language() {
        $lang = get_locale();
        global $WOOCS;
        switch ($lang) {
            case 'bg_BG':
                $WOOCS->set_currency('BGN');
                break;
            case 'en_GB':
                $WOOCS->set_currency('EUR');
                break;
            case 'ar':
                $WOOCS->set_currency('AED');
                break;
            default:
                $WOOCS->set_currency('USD');
                break;
        }
    }
}