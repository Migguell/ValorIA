<?php
$current_theme = wp_get_theme();
if (is_child_theme()) {
    $current_theme = $current_theme->parent();
}
$theme_name = $current_theme->get('Name');
?>
<div class="login-form-wrapper">
    <div class="login-form">
        <div class="d-flex justify-content-between align-items-center">
            <div class="cpt-field-group-label">
                <p style="font-size: 20px; color: #000;">
                    <?php
                    printf(
                        esc_html__('Theme "%1$s" is invalid', CPT_TEXT_DOMAIN),
                        $theme_name
                    );
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>