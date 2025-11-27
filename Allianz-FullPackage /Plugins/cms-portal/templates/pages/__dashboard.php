<?php
$current_theme = wp_get_theme();
if (is_child_theme()) {
    $current_theme = $current_theme->parent();
}
$theme_name = $current_theme->get('Name');
?>
<div class="cpt-container">
    <div class="row">
        <div class="col-md-12">
            <div class="cpt-admin-top-bar-wrapper">
                <div class="cpt-admin-top-bar">
                    <div class="cpt-admin-top-bar-brand">
                        <div class="cpt-admin-top-bar-brand-heading">
                            <div class="cpt-admin-top-bar-brand-headng-logo">

                            </div>
                            <h1 class="cpt-admin-top-bar-brand-heading-title"><?php echo esc_html($theme_name); ?></h1>
                        </div>
                    </div>
                    <div class="cpt-admin-top-bar-menu">
                        <div id="open-login-form" class="cpt-admin-top-bar-menu-item">
                            <i class="fas fa-user" style="
                                font-size: 18px;
                                margin-right: 5px;
                            "></i>
                            <h1 class="cpt-admin-top-bar-menu-item-title"><?php echo esc_html($customer['display_name']); ?></h1>
                        </div>
                        <div id="login-form" class="popup-dropdown">
                            <div class="arrow-up"></div>
                            <div class="popup-dropdown-body">
                                <ul class="user-actions">
                                    <li class="user-actions-item">
                                        <?php cpt_svg_e('book'); ?>
                                        <a href="<?php echo esc_attr($config['documentation_link']) ?>"
                                           target="_blank"><?php esc_html_e('Documents', CPT_TEXT_DOMAIN) ?></a>
                                    </li>
                                    <li class="user-actions-item">
                                        <?php cpt_svg_e('video'); ?>
                                        <a href="<?php echo esc_attr($config['video_tutorial_link']) ?>"
                                           target="_blank"><?php esc_html_e('Tutorials', CPT_TEXT_DOMAIN) ?></a>
                                    </li>
                                    <li class="user-actions-item">
                                        <?php cpt_svg_e('paper-plane'); ?>
                                        <a href="<?php echo esc_attr($config['ticket_link']) ?>"
                                           target="_blank"><?php esc_html_e('Submit Ticket', CPT_TEXT_DOMAIN) ?></a>
                                    </li>
                                    <li class="user-actions-item">
                                        <?php cpt_svg_e('right-from-bracket'); ?>
                                        <a data-action="log-out"
                                           href="#"><?php esc_html_e('Log Out', CPT_TEXT_DOMAIN) ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-5"></div>
    <?php
    cpt_get_template_file_e('partials/theme-info.php', [
        'config' => $config,
        'theme' => $theme,
    ]);
    ?>
    <div class="pb-5"></div>
    <?php
    cpt_get_template_file_e('partials/required-plugins.php');
    ?>
</div>