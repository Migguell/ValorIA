<?php
$result = cpt_get_required_plugins();
$required_plugins = $result['data'];
if (empty($required_plugins)) {
    $required_plugins = [
        'external_plugins' => [],
        'internal_plugins' => [],
    ];
}
$installed_plugins = [];
$installed_plugins_data = get_plugins();
foreach ($installed_plugins_data as $installed_plugin_file => $installed_plugin_data) {
    $installed_plugin_file = explode('/', $installed_plugin_file);
    $installed_plugins[$installed_plugin_file[0]] = $installed_plugin_data;
}

$active_plugins = [];
$active_plugins_data = get_option('active_plugins');
foreach ($active_plugins_data as $active_plugin_file) {
    $active_plugin_file = explode('/', $active_plugin_file);
    $active_plugins[] = $active_plugin_file[0];
}
?>

<div class="row border rounded bg-white shadow-sm no-gutters overflow-hidden p-3">
    <div class="col">
        <div id="install-activate-plugins" style="display: none;">
            <button type="button" id="btn-install-activate-plugins" class="button button-primary">
                <?php esc_html_e('Install & Activate', CPT_TEXT_DOMAIN); ?>
            </button>
            <span class="ml-3" style="color: red;">*</span>
            <span class="font-italic" style="font-size: 16px;">
                <?php echo esc_html__('Please click here to Install and Activate all required plugins before install demo data', CPT_TEXT_DOMAIN); ?>
            </span>
        </div>
    </div>
    <?php if (class_exists('SWA_Import_Export') && (class_exists('Elementor_Theme_Core') || class_exists('CmssuperheroesCore'))): ?>
        <div class="text-right col-auto">
            <a href="<?php echo esc_url(admin_url('admin.php?page=swa-import')); ?>"
               class="button button-primary"><?php echo esc_html__('Go to Import Demo Data', CPT_TEXT_DOMAIN) ?></a>
        </div>
    <?php endif; ?>
</div>
<div class="pb-3"></div>
<div class="row">
    <?php
    foreach ($required_plugins['internal_plugins'] as $plugin_slug => $plugin_data) :
        $is_installed = isset($installed_plugins[$plugin_slug]);
        $is_active = in_array($plugin_slug, $active_plugins);
        $need_update = isset($installed_plugins[$plugin_slug]) && version_compare($plugin_data['version'], $installed_plugins[$plugin_slug]['Version'], '>');
        ?>
        <div id="<?php echo esc_attr($plugin_slug); ?>" class="cms-plugin <?php if ($is_installed) {
            if (!$is_active) {
                echo esc_attr('need-activate');
            }
        } else {
            echo esc_attr('need-install');
        } ?> <?php if ($need_update) {
            echo esc_attr('need-update');
        } ?> col-md-4 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3>
                                <span><?php echo esc_html($plugin_data['name']); ?></span>
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <?php if ($is_installed): ?>
                                <?php if (!$is_active) : ?>
                                    <button type="button"
                                            class="button button-primary activate-plugin float-right"
                                            data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                            data-plugin-slug="<?php echo esc_attr($plugin_slug); ?>">
                                        <?php esc_html_e('Activate', CPT_TEXT_DOMAIN); ?>
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <button type="button"
                                        class="button install-plugin float-right"
                                        data-type="internal"
                                        data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                        data-plugin-slug="<?php echo esc_attr($plugin_slug); ?>">
                                    <?php esc_html_e('Install', CPT_TEXT_DOMAIN); ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php echo esc_url(CPT_URL . 'assets/images/csh-plugin-logo.png'); ?>"
                                 alt="<?php echo esc_attr($plugin_data['name']); ?>" style="width: 100%;">
                        </div>
                        <div class="col-md-9">
                            <div class="desc column-description">
                                <p><?php echo $plugin_data['description'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="column-rating">
                        <?php if ($need_update): ?>
                            <small class="cpt-version"><?php echo esc_html($installed_plugins[$plugin_slug]['Version']); ?></small>
                            <span> → </span>
                            <small class="cpt-version"><?php echo esc_html($plugin_data['version']); ?></small>
                            <button type="button"
                                    class="button button-primary update-plugin float-right"
                                    data-type="internal"
                                    data-nonce="<?php echo wp_create_nonce('update-plugin-' . $plugin_slug); ?>"
                                    data-plugin-slug="<?php echo esc_attr($plugin_slug); ?>">
                                <?php esc_html_e('Update', CPT_TEXT_DOMAIN); ?>
                            </button>
                        <?php else: ?>
                            <small class="cpt-version"><?php echo esc_html($plugin_data['version']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    ?>
    <?php
    foreach ($required_plugins['external_plugins'] as $plugin_slug => $plugin_data) :
        $is_installed = isset($installed_plugins[$plugin_slug]);
        $is_active = in_array($plugin_slug, $active_plugins);
        $need_update = isset($installed_plugins[$plugin_slug]) && version_compare($plugin_data['version'], $installed_plugins[$plugin_slug]['Version'], '>');
        ?>
        <div id="<?php echo esc_attr($plugin_slug); ?>" class="cms-plugin <?php if ($is_installed) {
            if (!$is_active) {
                echo esc_attr('need-activate');
            }
        } else {
            echo esc_attr('need-install');
        } ?> <?php if ($need_update) {
            echo esc_attr('need-update');
        } ?> col-md-4 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3>
                                <span><?php echo esc_html($plugin_data['name']); ?></span>
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <?php if ($is_installed) : ?>
                                <?php if (!$is_active) : ?>
                                    <button type="button"
                                            class="button button-primary activate-plugin float-right"
                                            data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                            data-plugin-slug="<?php echo esc_attr($plugin_slug); ?>">
                                        <?php esc_html_e('Activate', CPT_TEXT_DOMAIN); ?>
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <button type="button"
                                        class="button install-plugin float-right"
                                        data-type="external"
                                        data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                        data-plugin-slug="<?php echo esc_attr($plugin_slug); ?>">
                                    <?php esc_html_e('Install', CPT_TEXT_DOMAIN); ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <?php if (isset($plugin_data['icons'])): ?>
                                <?php if (isset($plugin_data['icons']['default'])): ?>
                                    <img src="<?php echo esc_url($plugin_data['icons']['default']); ?>"
                                         alt="<?php echo esc_attr($plugin_data['name']); ?>" style="width: 100%;">
                                <?php elseif (isset($plugin_data['icons']['1x'])): ?>
                                    <img src="<?php echo esc_url($plugin_data['icons']['1x']); ?>"
                                         alt="<?php echo esc_attr($plugin_data['name']); ?>" style="width: 100%;">
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <div class="desc column-description">
                                <p><?php echo $plugin_data['description'] ?></p>
                                <p class="authors">
                                    <cite><?php esc_html_e('By ', CPT_TEXT_DOMAIN); ?><?php echo $plugin_data['author']; ?></cite>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="column-rating">
                        <?php if ($need_update): ?>
                            <small class="cpt-version"><?php echo esc_html($installed_plugins[$plugin_slug]['Version']); ?></small>
                            <span> → </span>
                            <small class="cpt-version"><?php echo esc_html($plugin_data['version']); ?></small>
                            <button type="button"
                                    class="button button-primary update-plugin float-right"
                                    data-type="external"
                                    data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                    data-plugin-slug="<?php echo esc_attr($plugin_slug); ?>">
                                <?php esc_html_e('Update', CPT_TEXT_DOMAIN); ?>
                            </button>
                        <?php else: ?>
                            <small class="cpt-version"><?php echo esc_html($plugin_data['version']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    ?>
</div>