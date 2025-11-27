<div class="login-form-wrapper">
    <div class="login-form">
        <form>
            <input type="hidden" name="action" value="cpt_verify_purchase_code">
            <div style="min-width: 500px;">
                <div class="cpt-field-group">
                    <?php cpt_svg_e('envelope'); ?>
                    <div class="cpt-field">
                        <input type="text" name="email" id="email"
                               placeholder="<?php esc_html_e('Email', CPT_TEXT_DOMAIN) ?>">
                    </div>
                </div>
                <div class="cpt-field-group">
                    <?php cpt_svg_e('address-card'); ?>
                    <div class="cpt-field">
                        <input type="text" name="name" id="name"
                               placeholder="<?php esc_html_e('Name', CPT_TEXT_DOMAIN) ?>">
                    </div>
                </div>
                <div class="cpt-field-group required-field">
                    <?php cpt_svg_e('user-tag'); ?>
                    <div class="cpt-field">
                        <input type="text" name="purchase_code" id="purchase-code"
                               placeholder="<?php esc_html_e('Purchase Code', CPT_TEXT_DOMAIN) ?>">
                    </div>
                </div>
            </div>
            <div class="cpt-field field-submit">
                <button type="button" class="button btn-verify-purchase-code cpt-ext-right">
                    <?php esc_html_e('Verify', CPT_TEXT_DOMAIN) ?>
                    <div class="cpt cpt-spin cpt-ring"></div>
                </button>
            </div>
        </form>
    </div>
</div>