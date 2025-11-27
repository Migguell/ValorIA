<?php
$result = isset($validate_required_plugins_result) ? $validate_required_plugins_result : '';
if (empty($result)) {
    $result = cpt_validate_required_plugins();
}

$current_theme = wp_get_theme();
if (is_child_theme()) {
    $current_theme = $current_theme->parent();
}
$theme_name = $current_theme->get('Name');
$theme_logo = get_template_directory_uri() . '/assets/images/logo/logo.png';
?>

<div class="d-flex p-4">
    <div class="px-2 cpt-theme-logo">
        <div class="mb-3">
            <img src="<?php echo esc_attr($theme_logo) ?>" alt="<?php echo esc_attr($theme_name) ?>"
                 style="max-width: 200px;">
        </div>
    </div>
    <div class="pr-2 pl-5">
        <h3>
            <?php echo esc_html__('We recommend you to follow our required plugins for best experience.', CPT_TEXT_DOMAIN) ?>
        </h3>
        <h4 class="font-italic">
            <span style="color: red;">*</span>
            <?php
            if ($result['need_install'] && !$result['need_activate'] && !$result['need_update']) {
                echo esc_html__('Some required plugins need to install.', CPT_TEXT_DOMAIN);
            } elseif (!$result['need_install'] && $result['need_activate'] && !$result['need_update']) {
                echo esc_html__('Some required plugins need to activate.', CPT_TEXT_DOMAIN);
            } elseif (!$result['need_install'] && !$result['need_activate'] && $result['need_update']) {
                echo esc_html__('Some required plugins need to update.', CPT_TEXT_DOMAIN);
            } elseif ($result['need_install'] && $result['need_activate'] && !$result['need_update']) {
                echo esc_html__('Some required plugins need to install and activate.', CPT_TEXT_DOMAIN);
            } elseif ($result['need_install'] && !$result['need_activate'] && $result['need_update']) {
                echo esc_html__('Some required plugins need to install and update.', CPT_TEXT_DOMAIN);
            } elseif (!$result['need_install'] && $result['need_activate'] && $result['need_update']) {
                echo esc_html__('Some required plugins need to activate and update.', CPT_TEXT_DOMAIN);
            } else {
                echo esc_html__('Some required plugins need to install, activate and update.', CPT_TEXT_DOMAIN);
            }
            ?>
            <a href="<?php echo esc_url(admin_url("themes.php?page={$current_theme->get('TextDomain')}")); ?>">
                <?php echo esc_html__('Please go to this page.', CPT_TEXT_DOMAIN); ?>
            </a>
        </h4>
    </div>
</div>
