<div class="login-form-wrapper">
    <div class="login-form">
        <form>
            <input type="hidden" name="action" value="cpt_verify_purchase_code">
            <div style="min-width: 500px;">
                <div class="cpt-field-group">
                    <?php cpt_svg_e('user'); ?>
                    <div class="cpt-field">
                        <input type="text" name="username" id="username"
                               placeholder="<?php esc_html_e('Username', CPT_TEXT_DOMAIN) ?>">
                    </div>
                </div>
                <div class="cpt-field-group">
                    <?php cpt_svg_e('lock'); ?>
                    <div class="cpt-field">
                        <input type="Password" name="password" id="password"
                               placeholder="<?php esc_html_e('Password', CPT_TEXT_DOMAIN) ?>">
                    </div>
                </div>
            </div>
            <div class="cpt-field field-submit">
                <button type="button" class="button btn-login cpt-ext-right">
                    <?php esc_html_e('Login', CPT_TEXT_DOMAIN) ?>
                    <div class="cpt cpt-spin cpt-ring"></div>
                </button>
            </div>
        </form>
    </div>
</div>