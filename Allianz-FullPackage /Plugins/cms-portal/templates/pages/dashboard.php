<div class="cpt-container">
</div>

<script type="text/template" id="cpt-verify-purchased-code-template">
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
					<input type="hidden" name="verify_purchase_code_nonce" id="verify-purchase-code-nonce" value="<?php echo wp_create_nonce('cpt_verify_purchase_code'); ?>">
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
</script>

<script type="text/template" id="cpt-login-template">
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
</script>

<script type="text/template" id="cpt-theme-info-template">
	<div class="d-flex border rounded bg-white shadow-sm no-gutters overflow-hidden p-4 cms-theme-info">
	    <div class="px-2 cpt-theme-logo col-auto">
	        <div class="mb-3">
	            <img src="<%= current_theme.logo %>" alt="<%= current_theme.name %>"
	                 style="max-width: 200px;">
	        </div>
	        <% if(!_.isEmpty(theme) && !_.isEmpty(theme.slug) && versionCompare(theme['version'], current_theme.version, '>')){ %>
	            <span class="cpt-theme-version">
	                <span class="cpt-version"><%= current_theme.version %></span>
	                <span> → </span>
	                <span class="cpt-version"><%= theme['version'] %></span>
	                <% if(cms_portal.cache['cpt-server-requestable'] != -1){ %>
	                	<button type="button" class="button button-primary update-theme ml-3" data-nonce="<?php echo wp_create_nonce('update-theme'); ?>"><?php esc_html_e('Update', CPT_TEXT_DOMAIN); ?></button>
                    <% } else { %>
                    	<a href="#" class="button button-primary download-theme ml-3"><?php esc_html_e('Download', CPT_TEXT_DOMAIN); ?></a>
                    <% } %>
	            </span>
	        <% } else { %>
	            <span class="cpt-theme-version">
	                <small class="cpt-version"><%= current_theme.version %></small>
	            </span>
	        <% } %>
	    </div>
	    <div class="pr-2 pl-5 col">
	        <div class="row align-items-center">
	            <div class="col-md-4">
	                <span class="cpt-theme-author">
	                    <?php echo esc_html__('By', CPT_TEXT_DOMAIN) ?>
	                    <a href="<%= current_theme.author_uri %>"><%= current_theme.author %></a>
	                </span>
	            </div>
	            <div class="col-md-8">
	                <div class="cpt-rating-theme text-right">
	                    <span><?php echo esc_html__("If you see someone without a smile, give them ", CPT_TEXT_DOMAIN); ?></span>
	                    <a href="<%= cms_portal.dashboard_config.rating_link %>" class="give-5-stars">
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
	            <%= current_theme.description %>
	        </div>
	        <hr class="my-3">
	        <div class="row">
	            <div class="col-md-8">
	                <div class="cpt-theme-support">
	                    <a href="<%= cms_portal.dashboard_config.demo_link %>" target="_blank" class="button mr-3">
	                        <span><?php echo esc_html__('Live Demo', CPT_TEXT_DOMAIN); ?></span>
	                        <?php cpt_svg_e('desktop'); ?>
	                    </a>
	                    <a href="<%= cms_portal.dashboard_config.ticket_link %>" target="_blank" class="button mr-3">
	                        <span><?php echo esc_html__('Need Support?', CPT_TEXT_DOMAIN); ?></span>
	                        <?php cpt_svg_e('paper-plane'); ?>
	                    </a>
	                    <a href="<%= cms_portal.dashboard_config.video_tutorial_link %>" target="_blank"
	                       class="button mr-3">
	                        <span><?php echo esc_html__('Video Tutorial', CPT_TEXT_DOMAIN); ?></span>
	                        <?php cpt_svg_e('video'); ?>
	                    </a>
	                    <a href="<%= cms_portal.dashboard_config.documentation_link %>" target="_blank" class="button mr-3">
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
</script>

<script type="text/template" id="cpt-admin-top-bar-template">
	<div class="row">
        <div class="col-md-12">
            <div class="cpt-admin-top-bar-wrapper">
                <div class="cpt-admin-top-bar">
                    <div class="cpt-admin-top-bar-brand">
                        <div class="cpt-admin-top-bar-brand-heading">
                            <div class="cpt-admin-top-bar-brand-headng-logo">

                            </div>
                            <h1 class="cpt-admin-top-bar-brand-heading-title"><%= current_theme.name %></h1>
                        </div>
                    </div>
                    <div class="cpt-admin-top-bar-menu">
                        <div id="open-login-form" class="cpt-admin-top-bar-menu-item">
                            <?php cpt_svg_e('user'); ?>
                            <h1 class="cpt-admin-top-bar-menu-item-title"><%= customer.display_name %></h1>
                        </div>
                        <div id="login-form" class="popup-dropdown">
                            <div class="arrow-up"></div>
                            <div class="popup-dropdown-body">
                                <ul class="user-actions">
                                    <li class="user-actions-item">
                                        <?php cpt_svg_e('book'); ?>
                                        <a href="<%= cms_portal.dashboard_config.documentation_link %>"
                                           target="_blank"><?php esc_html_e('Documents', CPT_TEXT_DOMAIN) ?></a>
                                    </li>
                                    <li class="user-actions-item">
                                        <?php cpt_svg_e('video'); ?>
                                        <a href="<%= cms_portal.dashboard_config.video_tutorial_link %>"
                                           target="_blank"><?php esc_html_e('Tutorials', CPT_TEXT_DOMAIN) ?></a>
                                    </li>
                                    <li class="user-actions-item">
                                        <?php cpt_svg_e('paper-plane'); ?>
                                        <a href="<%= cms_portal.dashboard_config.ticket_link %>"
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
</script>

<script type="text/template" id="cpt-required-plugins-bar-template">
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
</script>

<script type="text/template" id="cpt-required-plugins-template">
	<div class="row cms-plugins">

    </div>
</script>

<script type="text/template" id="cpt-internal-required-plugin-template">
	<%
		var is_installed = !_.isEmpty(installed_plugins[plugin_slug]);
		var is_active = _.indexOf(active_plugins, plugin_slug) != -1;
		var need_update = is_installed && versionCompare(plugin_data.version, installed_plugins[plugin_slug].Version, '>');
	%>
	<div id="<%= plugin_slug %>" class="cms-plugin <% if(is_installed && !is_active){ print('need-activate'); } else { print('need-install'); } %> <% if(need_update){ print('need-update'); } %> col-md-4 mb-3">
		<div class="card">
			<div class="card-header">
				<div class="row align-items-center">
                    <div class="col-md-8">
                        <h3>
                            <span><%= plugin_data.name %></span>
                        </h3>
                    </div>
                    <div class="col-md-4">
                    	<%
                    		if(is_installed){
                    			if(!is_active){
                    				%>
                    					<button type="button"
                                            class="button button-primary activate-plugin float-right"
                                            data-type="internal"
                                            data-nonce="<?php echo wp_create_nonce('activate-plugin'); ?>"
                                            data-plugin-slug="<%= plugin_slug %>">
	                                        <?php esc_html_e('Activate', CPT_TEXT_DOMAIN); ?>
	                                    </button>
                    				<%
                    			}
                    		}
                    		else{
                    			if(cms_portal.cache['cpt-server-requestable'] != -1){
                    				%>
	                    				<button type="button"
		                                    class="button install-plugin float-right"
		                                    data-type="internal"
		                                    data-nonce="<?php echo wp_create_nonce('install-plugin'); ?>"
		                                    data-plugin-slug="<%= plugin_slug %>"
		                                    data-download-link="<%= plugin_data.download_link %>">
		                                	<?php esc_html_e('Install', CPT_TEXT_DOMAIN); ?>
		                                </button>
                    				<%
                    			}
                    			else{
                    				%>
	                    				<button type="button"
		                                    class="button download-plugin float-right"
		                                    data-type="internal"
		                                    data-nonce="<?php echo wp_create_nonce('updates'); ?>"
		                                    data-plugin-slug="<%= plugin_slug %>"
		                                    data-download-link="<%= plugin_data.download_link %>">
		                                	<?php esc_html_e('Download', CPT_TEXT_DOMAIN); ?>
		                                </button>
                    				<%
                    			}
                    		}
                    	%>
                    </div>
                </div>
			</div>
			<div class="card-body">
				<div class="row">
                    <div class="col-md-3">
                        <img src="<?php echo esc_url(CPT_URL . 'assets/images/csh-plugin-logo.png'); ?>"
                     alt="<%= plugin_data.name %>" style="width: 100%;">
                    </div>
                    <div class="col-md-9">
                        <div class="desc column-description">
                            <p><%= plugin_data.description %></p>
                            <p class="authors">
                                <cite><?php esc_html_e('By ', CPT_TEXT_DOMAIN); ?><%= plugin_data.author %></cite>
                            </p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="card-footer">
				<div class="column-rating">
                    <% if(need_update){ %>
                        <small class="cpt-version"><%= installed_plugins[plugin_slug].Version %></small>
                        <span> → </span>
                        <small class="cpt-version"><%= plugin_data.version %></small>
                        <% if(cms_portal.cache['cpt-server-requestable'] != -1) %>
	                        <button type="button"
	                            class="button button-primary update-plugin float-right"
	                            data-type="internal"
	                            data-nonce="<?php echo wp_create_nonce('update-plugin'); ?>"
	                            data-plugin-slug="<%= plugin_slug %>"
	                            data-download-link="<%= plugin_data.download_link %>">
	                            <?php esc_html_e('Update', CPT_TEXT_DOMAIN); ?>
	                        </button>
                        <% else { %>
	                        <button type="button"
	                            class="button download-plugin float-right"
	                            data-type="internal"
	                            data-nonce="<?php echo wp_create_nonce('updates'); ?>"
	                            data-plugin-slug="<%= plugin_slug %>"
	                            data-download-link="<%= plugin_data.download_link %>">
	                        	<?php esc_html_e('Download', CPT_TEXT_DOMAIN); ?>
	                        </button>
                        <% } %>
                    <% } else { %>
                        <small class="cpt-version"><%= plugin_data.version %></small>
                    <% } %>
                </div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="cpt-external-required-plugin-template">
	<%
		var is_installed = !_.isEmpty(installed_plugins[plugin_slug]);
		var is_active = _.indexOf(active_plugins, plugin_slug) != -1;
		var need_update = is_installed && versionCompare(plugin_data.version, installed_plugins[plugin_slug].Version, '>');
	%>
	<div id="<%= plugin_slug %>" class="cms-plugin <% if(is_installed && !is_active){ print('need-activate'); } else { print('need-install'); } %> <% if(need_update){ print('need-update'); } %> col-md-4 mb-3">
		<div class="card">
			<div class="card-header">
				<div class="row align-items-center">
                    <div class="col-md-8">
                        <h3>
                            <span><%= plugin_data.name %></span>
                        </h3>
                    </div>
                    <div class="col-md-4">
                    	<%
                    		if(is_installed){
                    			if(!is_active){
                    				%>
                    					<button type="button"
                                            class="button button-primary activate-plugin float-right"
                                            data-type="external"
                                            data-nonce="<?php echo wp_create_nonce('activate-plugin'); ?>"
                                            data-plugin-slug="<%= plugin_slug %>">
	                                        <?php esc_html_e('Activate', CPT_TEXT_DOMAIN); ?>
	                                    </button>
                    				<%
                    			}
                    		}
                    		else{
                		%>
                				<button type="button"
                                    class="button install-plugin float-right"
                                    data-type="external"
                                    data-nonce="<?php echo wp_create_nonce('install-plugin'); ?>"
                                    data-plugin-slug="<%= plugin_slug %>">
                                	<?php esc_html_e('Install', CPT_TEXT_DOMAIN); ?>
                                </button>
                		<%
                    		}
                    	%>
                    </div>
                </div>
			</div>
			<div class="card-body">
				<div class="row">
                    <div class="col-md-3">
                        <%
                        	if(!_.isEmpty(plugin_data.icons)){
                        		if(!_.isEmpty(plugin_data.icons.default)){
                            		%>
                            			<img src="<%= plugin_data.icons.default %>"
                                     alt="<%= plugin_data.name %>" style="width: 100%;">
                            		<%
                        		}
                        		else if(!_.isEmpty(plugin_data.icons['1x'])){
                        			%>
                            			<img src="<%= plugin_data.icons['1x'] %>"
                                     alt="<%= plugin_data.name %>" style="width: 100%;">
                            		<%
                        		}
                        	}
                		%>
                    </div>
                    <div class="col-md-9">
                        <div class="desc column-description">
                            <p><%= plugin_data.description %></p>
                            <p class="authors">
                                <cite><?php esc_html_e('By ', CPT_TEXT_DOMAIN); ?><%= plugin_data.author %></cite>
                            </p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="card-footer">
				<div class="column-rating">
                    <% if(need_update){ %>
                        <small class="cpt-version"><%= installed_plugins[plugin_slug].Version %></small>
                        <span> → </span>
                        <small class="cpt-version"><%= plugin_data.version %></small>
                        <button type="button"
                            class="button button-primary update-plugin float-right"
                            data-type="external"
                            data-nonce="<?php echo wp_create_nonce('update-plugin'); ?>"
                            data-plugin-slug="<%= plugin_slug %>">
                            <?php esc_html_e('Update', CPT_TEXT_DOMAIN); ?>
                        </button>
                    <% } else { %>
                        <small class="cpt-version"><%= plugin_data.version %></small>
                    <% } %>
                </div>
			</div>
		</div>
	</div>
</script>