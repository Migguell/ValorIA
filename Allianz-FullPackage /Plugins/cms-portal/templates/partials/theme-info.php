<?php
$current_theme = wp_get_theme();
if (is_child_theme()) {
    $current_theme = $current_theme->parent();
}
$theme_name = $current_theme->get('Name');
$theme_desc = $current_theme->get('Description');
$theme_version = $current_theme->get('Version');
$theme_author = $current_theme->get('Author');
$theme_author_uri = $current_theme->get('AuthorURI');
$theme_screenshot = $current_theme->get_screenshot();
$theme_logo = get_template_directory_uri() . '/assets/images/logo/logo.png';
?>
<div class="d-flex border rounded bg-white shadow-sm no-gutters overflow-hidden p-4">
    <div class="px-2 cpt-theme-logo col-auto">
        <div class="mb-3">
            <img src="<?php echo esc_attr($theme_logo) ?>" alt="<?php echo esc_attr($theme_name) ?>"
                 style="max-width: 200px;">
        </div>
        <?php if (isset($theme) && isset($theme['slug']) && version_compare($theme['version'], $theme_version, '>')): ?>
            <span class="cpt-theme-version">
                <span class="cpt-version"><?php echo esc_html($theme_version); ?></span>
                <span> → </span>
                <span class="cpt-version"><?php echo esc_html($theme['version']); ?></span>
                <button type="button" class="button button-primary update-theme ml-3"
                        data-nonce="<?php echo wp_create_nonce('updates'); ?>"><?php esc_html_e('Update', CPT_TEXT_DOMAIN); ?></button>
            </span>
        <?php else: ?>
            <span class="cpt-theme-version">
                <small class="cpt-version"><?php echo esc_html($theme_version); ?></small>
            </span>
        <?php endif; ?>
    </div>
    <div class="pr-2 pl-5 col">
        <div class="row align-items-center">
            <div class="col-md-4">
                <span class="cpt-theme-author">
                    <?php echo esc_html__('By', CPT_TEXT_DOMAIN) ?>
                    <a href="<?php echo esc_attr($theme_author_uri); ?>"><?php echo esc_html($theme_author); ?></a>
                </span>
            </div>
            <div class="col-md-8">
                <div class="cpt-rating-theme text-right">
                    <span><?php echo esc_html__("If you see someone without a smile, give them ", CPT_TEXT_DOMAIN); ?></span>
                    <a href="<?php echo esc_attr($config['rating_link']) ?>" class="give-5-stars">
                        <!-- <i class="fas fa-star ld ld-bounce-in infinite"></i>
                        <i class="fas fa-star ld ld-bounce-in infinite"></i>
                        <i class="fas fa-star ld ld-bounce-in infinite"></i>
                        <i class="fas fa-star ld ld-bounce-in infinite"></i>
                        <i class="fas fa-star ld ld-bounce-in infinite"></i> -->
                        <?php
                            cpt_svg_e('star');
                            cpt_svg_e('star');
                            cpt_svg_e('star');
                            cpt_svg_e('star');
                            cpt_svg_e('star');
                        ?>
                    </a>
                    <span><?php echo esc_html__("of yours", CPT_TEXT_DOMAIN); ?></span>
                </div>
            </div>
        </div>
        <hr class="my-3">
        <div class="cpt-theme-description">
            <?php echo esc_html($theme_desc); ?>
        </div>
        <hr class="my-3">
        <div class="row">
            <div class="col-md-8">
                <div class="cpt-theme-support">
                    <a href="<?php echo esc_attr($config['demo_link']) ?>" target="_blank" class="button mr-3">
                        <span><?php echo esc_html__('Live Demo', CPT_TEXT_DOMAIN); ?></span>
                        <?php cpt_svg_e('desktop'); ?>
                    </a>
                    <a href="<?php echo esc_attr($config['ticket_link']) ?>" target="_blank" class="button mr-3">
                        <span><?php echo esc_html__('Need Support?', CPT_TEXT_DOMAIN); ?></span>
                        <?php cpt_svg_e('paper-plane'); ?>
                    </a>
                    <a href="<?php echo esc_attr($config['video_tutorial_link']) ?>" target="_blank"
                       class="button mr-3">
                        <span><?php echo esc_html__('Video Tutorial', CPT_TEXT_DOMAIN); ?></span>
                        <?php cpt_svg_e('video'); ?>
                    </a>
                    <a href="<?php echo esc_attr($config['documentation_link']) ?>" target="_blank" class="button mr-3">
                        <span><?php echo esc_html__('Documentation', CPT_TEXT_DOMAIN); ?></span>
                        <?php cpt_svg_e('book'); ?>
                    </a>
                </div>
            </div>
            <?php if (!is_child_theme()): ?>
                <div class="col-md-4 text-right">
                    <a href="<?php echo esc_attr(admin_url('theme-install.php')) ?>" class="button button-primary">
                        <span><?php echo esc_html__('Upload Child Theme', CPT_TEXT_DOMAIN); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>