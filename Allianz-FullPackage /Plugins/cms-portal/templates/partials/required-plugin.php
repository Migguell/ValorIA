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

$plugin_data = [];
foreach ($required_plugins['external_plugins'] as $_plugin_data) {
    if ($_plugin_data['slug'] == $plugin_slug) {
        $plugin_data = $_plugin_data;
        $type = 'external';
        break;
    }
}
foreach ($required_plugins['internal_plugins'] as $_plugin_data) {
    if ($_plugin_data['slug'] == $plugin_slug) {
        $plugin_data = $_plugin_data;
        $type = 'internal';
        break;
    }
}
?>

<?php if ($type == 'external'): ?>
    <div id="<?php echo esc_attr($plugin_data['slug']); ?>" class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3>
                            <span><?php echo esc_html($plugin_data['name']); ?></span>
                        </h3>
                    </div>
                    <div class="col-md-4">
                        <?php if (isset($installed_plugins[$plugin_data['slug']])): ?>
                            <?php if (!in_array($plugin_data['slug'], $active_plugins)): ?>
                                <button type="button"
                                        class="button button-primary activate-plugin float-right"
                                        data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                        data-plugin-slug="<?php echo esc_attr($plugin_data['slug']); ?>">
                                    <?php esc_html_e('Activate', CPT_TEXT_DOMAIN); ?>
                                </button>
                            <?php endif; ?>
                        <?php else: ?>
                            <button type="button"
                                    class="button install-plugin float-right"
                                    data-type="external"
                                    data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                    data-plugin-slug="<?php echo esc_attr($plugin_data['slug']); ?>">
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
                    <?php if (isset($installed_plugins[$plugin_data['slug']]) && version_compare($plugin_data['version'], $installed_plugins[$plugin_data['slug']]['Version'], '>')): ?>
                        <small class="cpt-version"><?php echo esc_html($installed_plugins[$plugin_data['slug']]['Version']); ?></small>
                        <span> → </span>
                        <small class="cpt-version"><?php echo esc_html($plugin_data['version']); ?></small>
                        <button type="button"
                                class="button button-primary update-plugin float-right"
                                data-type="external"
                                data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                data-plugin-slug="<?php echo esc_attr($plugin_data['slug']); ?>">
                            <?php esc_html_e('Update', CPT_TEXT_DOMAIN); ?>
                        </button>
                    <?php else: ?>
                        <small class="cpt-version"><?php echo esc_html($plugin_data['version']); ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php elseif ($type == 'internal'): ?>
    <div id="<?php echo esc_attr($plugin_data['slug']); ?>" class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3>
                            <span><?php echo esc_html($plugin_data['name']); ?></span>
                        </h3>
                    </div>
                    <div class="col-md-4">
                        <?php if (isset($installed_plugins[$plugin_data['slug']])): ?>
                            <?php if (!in_array($plugin_data['slug'], $active_plugins)): ?>
                                <button type="button"
                                        class="button button-primary activate-plugin float-right"
                                        data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                        data-plugin-slug="<?php echo esc_attr($plugin_data['slug']); ?>">
                                    <?php esc_html_e('Activate', CPT_TEXT_DOMAIN); ?>
                                </button>
                            <?php endif; ?>
                        <?php else: ?>
                            <button type="button"
                                    class="button install-plugin float-right"
                                    data-type="internal"
                                    data-nonce="<?php echo wp_create_nonce('updates'); ?>"
                                    data-plugin-slug="<?php echo esc_attr($plugin_data['slug']); ?>">
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
                    <?php if (isset($installed_plugins[$plugin_data['slug']]) && version_compare($plugin_data['version'], $installed_plugins[$plugin_data['slug']]['Version'], '>')): ?>
                        <small class="cpt-version"><?php echo esc_html($installed_plugins[$plugin_data['slug']]['Version']); ?></small>
                        <span> → </span>
                        <small class="cpt-version"><?php echo esc_html($plugin_data['version']); ?></small>
                        <button type="button"
                                class="button button-primary update-plugin float-right"
                                data-type="internal"
                                data-nonce="<?php echo wp_create_nonce('update-plugin-' . $plugin_data['slug']); ?>"
                                data-plugin-slug="<?php echo esc_attr($plugin_data['slug']); ?>">
                            <?php esc_html_e('Update', CPT_TEXT_DOMAIN); ?>
                        </button>
                    <?php else: ?>
                        <small class="cpt-version"><?php echo esc_html($plugin_data['version']); ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>