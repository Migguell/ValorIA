(function($) {
    "use strict";

    $(document).ready(function() {
        checkBulkActionPlugins();
        loadPage();
    });

    $(document).on('click', '.btn-verify-purchase-code', function() {
        var _this = $(this);
        var email = $('#email').val();
        var name = $('#name').val();
        var purchase_code = $('#purchase-code').val();
        var _wpnonce = $('#verify-purchase-code-nonce').val();

        $.ajax({
            url: cms_portal.ajax_url,
            type: 'POST',
            beforeSend: function() {
                _this.addClass('running');
            },
            data: {
                action: 'cpt_verify_purchase_code',
                email: email,
                name: name,
                purchase_code: purchase_code,
                _wpnonce: _wpnonce,
            }
        }).done(function(res) {
            var alert = new CMSAlert();
            if (res.stt) {
                window.location.reload();
            } else {
                // alert.alert(res.msg, 'danger');
                $.ajax({
                    url: cms_portal.api.verify_purchase_code,
                    type: 'POST',
                    beforeSend: function() {
                        _this.addClass('running');
                    },
                    data: JSON.stringify({
                        host: cms_portal.host,
                        email: email,
                        name: name,
                        purchase_code: purchase_code,
                        theme_slug: cms_portal.current_theme.slug
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }).done(function(res) {
                    cms_portal.auth = res;
                    updateAuth();
                    loadPage();
                }).fail(function(res) {
                    var alert = new CMSAlert();
                    alert.alert(res.responseJSON.message, 'danger');
                }).always(function() {
                    _this.removeClass('running');
                });
            }
        }).fail(function(res) {

        }).always(function() {
            _this.removeClass('running');
        });

        return false;
    });

    $(document).on('click', '#open-login-form', function() {
        var form = $('#login-form');
        form.fadeToggle();

        return false;
    });

    $(document).on('click', '.btn-login', function() {
        var _this = $(this);
        var username = $('#username').val();
        var password = $('#password').val();

        $.ajax({
            url: cms_portal.api.login,
            type: 'POST',
            beforeSend: function() {
                _this.addClass('running');
            },
            data: JSON.stringify({
                username: username,
                password: password,
            }),
            headers: {
                'Content-Type': 'application/json',
            }
        }).done(function(res) {
            cms_portal.auth = res;
            updateAuth();
            loadPage();
        }).fail(function(res) {
            var alert = new CMSAlert();
            alert.alert(res.responseJSON.message, 'danger');
        }).always(function() {
            _this.removeClass('running');
        });

        return false;
    });

    $(document).on('click', '.user-actions-item a[data-action]', function() {
        var _this = $(this);
        var action = _this.data('action');

        switch (action) {
            case 'log-out':
                $.ajax({
                    url: cms_portal.api.disconnect,
                    type: 'POST',
                    beforeSend: function() {
                        _this.addClass('running');
                    },
                    data: JSON.stringify({
                        host: cms_portal.host,
                        theme_slug: cms_portal.current_theme.slug,
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + cms_portal.auth.access_token,
                    }
                }).done(function(res) {

                }).fail(function(res) {
                    var alert = new CMSAlert();
                    alert.alert(res.responseJSON.message, 'danger');
                }).always(function() {
                    _this.removeClass('running');
                });

                $.ajax({
                    url: cms_portal.ajax_url,
                    type: 'POST',
                    beforeSend: function() {
                        _this.addClass('running');
                    },
                    data: {
                        'action': 'cpt_log_out'
                    },
                }).done(function(res) {
                    var alert = new CMSAlert();
                    if (res.stt) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    } else {
                        alert.alert(res.msg, 'danger');
                    }
                }).fail(function(res) {

                }).always(function() {
                    _this.removeClass('running');
                });
                break;
        }

        return false;
    });

    $(document).on('click', '.download-plugin', function() {
        var _this = $(this);
        var type = _this.data('type');
        var _wpnonce = _this.data('nonce');
        var plugin_slug = _this.data('plugin-slug');
        var download_link = _this.data('download-link');
        window.location.assign(download_link);

        return false;
    });

    $(document).on('click', '.install-plugin', function() {
        var _this = $(this);
        var type = _this.data('type');
        var _wpnonce = _this.data('nonce');
        var plugin_slug = _this.data('plugin-slug');
        var download_link = _this.data('download-link');

        if (_this.hasClass('install-plugin')) {
            $.ajax({
                url: cms_portal.ajax_url,
                type: 'POST',
                beforeSend: function() {
                    _this.addClass('loading');
                    _this.text('Installing');
                },
                data: {
                    action: 'cpt_install_plugin',
                    type: type,
                    _wpnonce: _wpnonce,
                    plugin_slug: plugin_slug,
                    download_link: download_link,
                },
            }).done(function(res) {
                var alert = new CMSAlert();
                if (res.stt) {
                    cms_portal.installed_plugins = res.data;
                    loadRequiredPluginHtml(plugin_slug, '', type);
                    checkBulkActionPlugins();
                    alert.alert(res.msg, 'success');
                } else {
                    _this.text('Install');
                    alert.alert(res.msg, 'danger');
                }
            }).fail(function(res) {
                _this.text('Install');
            }).always(function() {
                _this.removeClass('loading');
            });
        }

        return false;
    });

    $(document).on('click', '.activate-plugin', function() {
        var _this = $(this);
        var type = _this.data('type');
        var _wpnonce = _this.data('nonce');
        var plugin_slug = _this.data('plugin-slug');

        if (_this.hasClass('activate-plugin')) {
            $.ajax({
                url: cms_portal.ajax_url,
                type: 'POST',
                beforeSend: function() {
                    _this.addClass('loading');
                    _this.text('Activating');
                },
                data: {
                    action: 'cpt_activate_plugin',
                    _wpnonce: _wpnonce,
                    plugin_slug: plugin_slug,
                },
            }).done(function(res) {
                var alert = new CMSAlert();
                if (res.stt) {
                    cms_portal.active_plugins = res.data;
                    loadRequiredPluginHtml(plugin_slug, '', type);
                    checkBulkActionPlugins();
                    alert.alert(res.msg, 'success');
                } else {
                    _this.text('Activate');
                    alert.alert(res.msg, 'danger');
                }
            }).fail(function(res) {
                _this.text('Activate');
            }).always(function() {
                _this.removeClass('loading');
            });
        }

        return false;
    });

    $(document).on('click', '.update-plugin', function() {
        var _this = $(this);
        var type = _this.data('type');
        var _wpnonce = _this.data('nonce');
        var plugin_slug = _this.data('plugin-slug');
        var download_link = _this.data('download-link');

        $.ajax({
            url: cms_portal.ajax_url,
            type: 'POST',
            beforeSend: function() {
                _this.addClass('loading');
                _this.text('Updating');
            },
            data: {
                action: 'cpt_update_plugin',
                type: type,
                _wpnonce: _wpnonce,
                plugin_slug: plugin_slug,
                download_link: download_link,
            },
        }).done(function(res) {
            var alert = new CMSAlert();
            if (res.stt || res.success) {
                cms_portal.installed_plugins = res.data;
                loadRequiredPluginHtml(plugin_slug, '', type);
                alert.alert(res.msg, 'success');
            } else {
                _this.text('Update');
                alert.alert(res.msg, 'danger');
            }
        }).fail(function(res) {
            _this.text('Update');
        }).always(function() {
            _this.removeClass('loading');
        });

        return false;
    });

    $(document).on('click', '.update-theme', function() {
        if (!confirm("Are you sure you want to update theme?")) {
            return false;
        }

        var _this = $(this);
        var _wpnonce = _this.data('nonce');

        $.ajax({
            url: cms_portal.api.get_theme_download_link,
            type: 'POST',
            beforeSend: function() {
                _this.addClass('loading');
                _this.text('Updating');
            },
            data: JSON.stringify({
                host: cms_portal.host,
                theme_slug: cms_portal.current_theme.slug,
            }),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + cms_portal.auth.access_token,
            }
        }).done(function(res) {
            $.ajax({
                url: cms_portal.ajax_url,
                type: 'POST',
                beforeSend: function() {
                    _this.addClass('loading');
                    _this.text('Updating');
                },
                data: {
                    action: 'cpt_update_theme',
                    _wpnonce: _wpnonce,
                    download_link: res.download_link,
                },
            }).done(function(res) {
                var alert = new CMSAlert();
                if (res.stt) {
                    alert.alert(res.msg, 'success');
                    _this.remove();
                } else {
                    _this.text('Update');
                    alert.alert(res.msg, 'danger');
                }
            }).fail(function(res) {
                _this.text('Update');
            }).always(function() {
                _this.removeClass('loading');
            });
        }).fail(function(res) {
            var alert = new CMSAlert();
            alert.alert(res.responseJSON.message, 'danger');
            _this.text('Update');
        }).always(function() {
            _this.removeClass('loading');
        });

        return false;
    });

    $(document).on('click', '.download-theme', function() {
        var _this = $(this);

        $.ajax({
            url: cms_portal.api.get_theme_download_link,
            type: 'POST',
            beforeSend: function() {
                _this.addClass('loading');
            },
            data: JSON.stringify({
                host: cms_portal.host,
                theme_slug: cms_portal.current_theme.slug,
            }),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + cms_portal.auth.access_token,
            }
        }).done(function(res) {
            window.location.assign(res.download_link);
        }).fail(function(res) {
            var alert = new CMSAlert();
            alert.alert(res.responseJSON.message, 'danger');
        }).always(function() {
            _this.removeClass('loading');
        });

        return false;
    });

    $(document).on('click', '#btn-install-activate-plugins', function() {
        var _this = $(this);
        if (!_this.hasClass('loading')) {
            _this.addClass('loading');

            waitFor(function() {
                var count = $('.install-plugin').length + $('.activate-plugin').length;
                var error = $('.install-error').length + $('.activate-error').length;
                return count == 0 || error > 0;
            }, function() {
                var error = $('.install-error').length + $('.activate-error').length;
                var alert = new CMSAlert();
                if (error > 0) {
                    alert.alert('An error occurred while Installing and Activating the required plugins. Please reload page and try again!', 'danger');
                    _this.removeClass('loading');
                } else {
                    alert.alert('Installation and Activation Completed', 'success');
                    $.ajax({
                        url: cms_portal.ajax_url,
                        type: 'POST',
                        beforeSend: function() {

                        },
                        data: {
                            action: 'cpt_can_import_demo',
                        },
                    }).done(function(res) {
                        if (res.stt) {
                            window.location.href = res.data;
                        } else {
                            window.location.reload();
                        }
                    }).fail(function(res) {

                    }).always(function() {
                        _this.removeClass('loading');
                    });
                }
            }, 'Wait for finish install & activate all plugins', 500);
            installAndActiveOneByOne();
        }

        return false;
    });

    function getTemplate(templateName) {
        return $('#' + templateName).html();
    }

    function isDevMode() {
        return cms_portal.dev_mode == 1 || cms_portal.dev_mode == true;
    }

    function isAuthenticated() {
        if (isEmpty(cms_portal.auth)) {
            return false;
        }

        return true;
    }

    function loadPage() {
        if (isAuthenticated()) {
            loadDashboardPage();
        } else {
            if (isDevMode()) {
                loadLoginPage();
            } else {
                loadVerifyPurchasedCodePage();
            }
        }
    }

    function loadVerifyPurchasedCodePage() {
        var rootEl = $('.cpt-container');
        rootEl.html('');
        var verifyPurchasedCodeTemplate = $('#cpt-verify-purchased-code-template').html();
        var verifyPurchasedCodeHtml = _.template(verifyPurchasedCodeTemplate)({

        });
        rootEl.html(verifyPurchasedCodeHtml);
    }

    function loadLoginPage() {
        var rootEl = $('.cpt-container');
        rootEl.html('');
        var loginTemplate = $('#cpt-login-template').html();
        var loginHtml = _.template(loginTemplate)({

        });
        rootEl.html(loginHtml);
    }

    function loadDashboardPage() {
        var rootEl = $('.cpt-container');
        rootEl.html('');
        rootEl.append(getAdminTopBarHtml());
        rootEl.append('<div class="pb-5"></div>');
        rootEl.append(getThemeInfoHtml());
        rootEl.append('<div class="pb-5"></div>');
        rootEl.append(getRequiredPluginsBarHtml());
        rootEl.append('<div class="pb-3"></div>');
        rootEl.append(getRequiredPluginsHtml());

        loadThemeInfo();
        loadRequiredPlugins();
    }

    function loadThemeInfo() {
        if (!isEmpty(cms_portal.cache['cpt-theme-option'])) {
            setTimeout(function() {
                $('.cms-theme-info').replaceWith(getThemeInfoHtml());
            }, 500);
        } else {
            $.ajax({
                url: cms_portal.api.get_theme,
                type: 'POST',
                beforeSend: function() {

                },
                data: JSON.stringify({
                    host: cms_portal.host,
                    theme_slug: cms_portal.current_theme.slug,
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + cms_portal.auth.access_token,
                }
            }).done(function(res) {
                cms_portal.cache['cpt-theme-option'] = res;
                $('.cms-theme-info').replaceWith(getThemeInfoHtml());
                updateThemeInfo(cms_portal.cache['cpt-theme-option']);
            }).fail(function(res) {
                var alert = new CMSAlert();
                alert.alert(res.responseJSON.message, 'danger');
            }).always(function() {

            });
        }
    }

    function updateThemeInfo(theme) {
        if (isEmpty(theme)) {
            theme = cms_portal.cache['cpt-theme-option'];
        }
        $.ajax({
            url: cms_portal.ajax_url,
            type: 'POST',
            beforeSend: function() {

            },
            data: {
                action: 'cpt_update_theme_info',
                theme: theme
            }
        }).done(function(res) {

        }).fail(function(res) {

        }).always(function() {

        });
    }

    function getThemeInfoHtml() {
        var template = $('#cpt-theme-info-template').html();
        var html = _.template(template)({
            current_theme: cms_portal.current_theme,
            theme: cms_portal.cache['cpt-theme-option']
        });
        return html;
    }

    function getAdminTopBarHtml() {
        var template = $('#cpt-admin-top-bar-template').html();
        var html = _.template(template)({
            current_theme: cms_portal.current_theme,
            customer: cms_portal.auth.user_data,
        });
        return html;
    }

    function loadRequiredPlugins() {
        if (!isEmpty(cms_portal.cache['cpt-required-plugins-option'])) {
            setTimeout(function() {
                // $('.cms-plugins').replaceWith(getRequiredPluginsHtml());
                loadRequiredPluginsHtml();
                setTimeout(function() {
                    checkBulkActionPlugins();
                }, 500);
            }, 500);
        } else {
            $.ajax({
                url: cms_portal.api.get_required_plugins,
                type: 'POST',
                beforeSend: function() {

                },
                data: JSON.stringify({
                    host: cms_portal.host,
                    theme_slug: cms_portal.current_theme.slug,
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + cms_portal.auth.access_token,
                }
            }).done(function(res) {
                cms_portal.cache['cpt-required-plugins-option'] = res;
                // $('.cms-plugins').replaceWith(getRequiredPluginsHtml());
                loadRequiredPluginsHtml();
                setTimeout(function() {
                    checkBulkActionPlugins();
                }, 500);
                updateRequiredPlugins(cms_portal.cache['cpt-required-plugins-option']);
            }).fail(function(res) {
                var alert = new CMSAlert();
                alert.alert(res.responseJSON.message, 'danger');
            }).always(function() {

            });
        }
    }

    function updateRequiredPlugins(requiredPlugins) {
        if (isEmpty(requiredPlugins)) {
            requiredPlugins = cms_portal.cache['cpt-required-plugins-option'];
        }
        $.ajax({
            url: cms_portal.ajax_url,
            type: 'POST',
            beforeSend: function() {

            },
            data: {
                action: 'cpt_update_required_plugins',
                required_plugins: requiredPlugins
            }
        }).done(function(res) {

        }).fail(function(res) {

        }).always(function() {

        });
    }

    function getRequiredPluginsHtml() {
        var template = $('#cpt-required-plugins-template').html();
        var html = _.template(template)({
            installed_plugins: cms_portal.installed_plugins,
            active_plugins: cms_portal.active_plugins,
            required_plugins: cms_portal.cache['cpt-required-plugins-option'],
        });
        return html;
    }

    function loadRequiredPluginsHtml() {
        var requiredPluginsContainer = $('.cms-plugins');
        requiredPluginsContainer.html('');
        $.each(cms_portal.cache['cpt-required-plugins-option'].internal_plugins, function(plugin_slug, plugin_data) {
            requiredPluginsContainer.append(getInternalRequiredPluginHtml(plugin_slug, plugin_data));
            // loadInternalRequiredPluginHtml(plugin_slug, plugin_data);
            loadRequiredPluginHtml(plugin_slug, plugin_data, 'internal');
        });
        $.each(cms_portal.cache['cpt-required-plugins-option'].external_plugins, function(plugin_slug, plugin_data) {
            // requiredPluginsContainer.append(getExternalRequiredPluginHtml(plugin_slug, plugin_data));
            // loadExternalRequiredPluginHtml(plugin_slug, plugin_data);
            loadRequiredPluginHtml(plugin_slug, plugin_data, 'external');
        });
    }

    function loadRequiredPluginHtml(plugin_slug, plugin_data, type) {
        if (isEmpty(plugin_slug)) return;
        if (type == 'internal') {
            if (isEmpty(plugin_data)) {
                plugin_data = cms_portal.cache['cpt-required-plugins-option'].internal_plugins[plugin_slug];
            }
            loadInternalRequiredPluginHtml(plugin_slug, plugin_data);
        } else if (type == 'external') {
            if (isEmpty(plugin_data)) {
                plugin_data = cms_portal.cache['cpt-required-plugins-option'].external_plugins[plugin_slug];
            }
            loadExternalRequiredPluginHtml(plugin_slug, plugin_data);
        }
    }

    function loadInternalRequiredPluginHtml(plugin_slug, plugin_data) {
        if (isEmpty(plugin_data.download_link)) {
            $.ajax({
                url: cms_portal.api.get_plugin_download_link,
                type: 'POST',
                beforeSend: function() {

                },
                data: JSON.stringify({
                    host: cms_portal.host,
                    theme_slug: cms_portal.current_theme.slug,
                    plugin_slug: plugin_slug,
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + cms_portal.auth.access_token,
                }
            }).done(function(res) {
                plugin_data.download_link = res.download_link;
                if ($('#' + plugin_slug).length > 0) {
                    $('#' + plugin_slug).replaceWith(getInternalRequiredPluginHtml(plugin_slug, plugin_data));
                } else {
                    $(getInternalRequiredPluginHtml(plugin_slug, plugin_data)).appendTo($('.cms-plugins'));
                }
            }).fail(function(res) {
                var alert = new CMSAlert();
                alert.alert(res.responseJSON.message, 'danger');
            }).always(function() {

            });
        } else {
            if ($('#' + plugin_slug).length > 0) {
                $('#' + plugin_slug).replaceWith(getInternalRequiredPluginHtml(plugin_slug, plugin_data));
            } else {
                $(getInternalRequiredPluginHtml(plugin_slug, plugin_data)).appendTo($('.cms-plugins'));
            }
        }
    }

    function getInternalRequiredPluginHtml(plugin_slug, plugin_data) {
        var template = $('#cpt-internal-required-plugin-template').html();
        var html = _.template(template)({
            installed_plugins: cms_portal.installed_plugins,
            active_plugins: cms_portal.active_plugins,
            plugin_slug: plugin_slug,
            plugin_data: plugin_data,
        });
        return html;
    }

    function loadExternalRequiredPluginHtml(plugin_slug, plugin_data) {
        if ($('#' + plugin_slug).length > 0) {
            $('#' + plugin_slug).replaceWith(getExternalRequiredPluginHtml(plugin_slug, plugin_data));
        } else {
            $(getExternalRequiredPluginHtml(plugin_slug, plugin_data)).appendTo($('.cms-plugins'));
        }
    }

    function getExternalRequiredPluginHtml(plugin_slug, plugin_data) {
        var template = $('#cpt-external-required-plugin-template').html();
        var html = _.template(template)({
            installed_plugins: cms_portal.installed_plugins,
            active_plugins: cms_portal.active_plugins,
            plugin_slug: plugin_slug,
            plugin_data: plugin_data,
        });
        return html;
    }

    function getRequiredPluginsBarHtml() {
        var template = $('#cpt-required-plugins-bar-template').html();
        var html = _.template(template)({

        });
        return html;
    }

    function updateAuth(oAuth) {
        if (!isEmpty(oAuth)) {
            cms_portal.auth = oAuth;
        }
        $.ajax({
            url: cms_portal.ajax_url,
            type: 'POST',
            beforeSend: function() {

            },
            data: {
                action: 'cpt_update_auth',
                oAuth: cms_portal.auth,
            },
        }).done(function(res) {

        }).fail(function(res) {

        }).always(function() {

        });
    }

    function checkBulkActionPlugins() {
        var needInstall = $('.need-install').length;
        var needActivate = $('.need-activate').length;
        var installAndActivateAllEl = $('#install-activate-plugins');
        if (needInstall > 0 || needActivate > 0) {
            installAndActivateAllEl.show();
        } else {
            installAndActivateAllEl.hide();
        }
    }

    function installAndActiveOneByOne() {
        var installPluginEls = $('.install-plugin');
        if (installPluginEls.length > 0) {
            var _this = $(installPluginEls[0]);
            var type = _this.data('type');
            var _wpnonce = _this.data('nonce');
            var plugin_slug = _this.data('plugin-slug');
            var download_link = _this.data('download-link');

            $.ajax({
                url: cms_portal.ajax_url,
                type: "POST",
                beforeSend: function() {
                    _this.addClass('loading');
                    _this.text('Installing');
                },
                data: {
                    action: 'cpt_install_plugin',
                    type: type,
                    _wpnonce: _wpnonce,
                    plugin_slug: plugin_slug,
                    download_link: download_link,
                },
            }).done(function(res) {
                var alert = new CMSAlert();
                if (res.stt) {
                    cms_portal.installed_plugins = res.data;
                    loadRequiredPluginHtml(plugin_slug, '', type);
                    checkBulkActionPlugins();
                    setTimeout(function() {
                        installAndActiveOneByOne();
                    }, 500);
                    alert.alert(res.msg, 'success');
                } else {
                    _this.text('Install');
                    alert.alert(res.msg, 'danger');
                    _this.addClass('install-error');
                }
            }).fail(function(res) {
                _this.text('Install');
                _this.addClass('install-error');
            }).always(function() {
                _this.removeClass('loading');
            });
        } else {
            var activatePluginEls = $('.activate-plugin');
            if (activatePluginEls.length > 0) {
                _this = $(activatePluginEls[0]);
                type = _this.data('type');
                _wpnonce = _this.data('nonce');
                plugin_slug = _this.data('plugin-slug');

                $.ajax({
                    url: cms_portal.ajax_url,
                    type: "POST",
                    beforeSend: function() {
                        _this.addClass('loading');
                        _this.text('Activating');
                    },
                    data: {
                        action: 'cpt_activate_plugin',
                        _wpnonce: _wpnonce,
                        plugin_slug: plugin_slug,
                    },
                }).done(function(res) {
                    var alert = new CMSAlert();
                    if (res.stt) {
                        cms_portal.active_plugins = res.data;
                        loadRequiredPluginHtml(plugin_slug, '', type);
                        checkBulkActionPlugins();
                        setTimeout(function() {
                            installAndActiveOneByOne();
                        }, 500);
                        alert.alert(res.msg, 'success');
                    } else {
                        _this.text('Activate');
                        alert.alert(res.msg, 'danger');
                        _this.addClass('activate-error');
                    }
                }).fail(function(res) {
                    _this.text('Activate');
                    _this.addClass('activate-error');
                }).always(function() {
                    _this.removeClass('loading');
                });
            }
        }
    }

    function isEmpty(val) {
        return typeof val === "undefined" || val === "" || val === null || (typeof val === "object" && $.isEmptyObject(val)) || ($.isArray(val) && val.lenght === 0);
    }

    function waitFor(condition, callback, message, time) {
        if (isEmpty(message)) {
            message = 'Timeout';
        }
        var cond = condition();
        if (cond) {
            callback();
        } else {
            setTimeout(function() {
                console.log(message);
                waitFor(condition, callback, message, time);
            }, time);
        }
    }
})(jQuery);

/**
 * Compares two version strings using the specified operator.
 * @param {string} v1 - The first version string (e.g., "1.2.3").
 * @param {string} v2 - The second version string (e.g., "1.2.4").
 * @param {string} [operator=">"] - The comparison operator: ">", "<", ">=", "<=", "==", "===" or "=".
 * @returns {boolean} True if the comparison is valid according to the operator, otherwise false.
 */
var versionCompare = function(v1, v2, operator) {
    operator = operator || '>';
    // vnum stores each numeric 
    // part of version 
    var vnum1 = 0,
        vnum2 = 0;

    // loop until both string are 
    // processed 
    for (var i = 0, j = 0;
        (i < v1.length || j < v2.length);) {
        // storing numeric part of 
        // version 1 in vnum1 
        while (i < v1.length && v1[i] != '.') {
            vnum1 = vnum1 * 10 + (v1[i] - '0');
            i++;
        }

        // storing numeric part of 
        // version 2 in vnum2 
        while (j < v2.length && v2[j] != '.') {
            vnum2 = vnum2 * 10 + (v2[j] - '0');
            j++;
        }

        // if (vnum1 > vnum2)
        //     return 1;
        // if (vnum2 > vnum1)
        //     return -1;

        if (operator === '>' || operator === '>=') {
            if (vnum1 > vnum2)
                return true;
            if (vnum1 < vnum2)
                return false;
        } else if (operator === '<' || operator === '<=') {
            if (vnum1 < vnum2)
                return true;
            if (vnum1 > vnum2)
                return false;
        } else if (operator === '===' || operator === '==' || operator === '=') {
            if(vnum1 != vnum2)
                return false;
        }

        // if equal, reset variables and 
        // go for next numeric part 
        vnum1 = vnum2 = 0;
        i++;
        j++;
    }
    if (operator === '===' || operator === '==' || operator === '=' || operator === '>=' || operator === '<=') {
        return true;
    }
    return false;
}