$ = $ || jQuery;

var CMSAlert = function (config) {
    this.init(config);
    this.render();
};

CMSAlert.prototype = {
    message: '',
    type: '',

    init: function (config) {
        if (!this.isEmpty(config)) {
            $.extend(this, config);
        }
    },

    render: function () {
        var wrapper = $(".cms-alerts-wrapper");
        if (wrapper.length === 0) {
            wrapper = $('<div>');
            inner = $('<div>');
            wrapper.addClass("cms-alerts-wrapper");
            inner.addClass("cms-alerts-inner");
            wrapper.append(inner);
            $("body").append(wrapper);
        }

        if (!this.isEmpty(this.message)) {
            this.alert(this.message, this.type);
        }
    },

    alert: function (message, type) {
        let _this = this;
        if (_this.isEmpty(message)) {
            return false;
        }
        type = !_this.isEmpty(type) ? type : 'success';
        let inner = $(".cms-alerts-inner");
        if (inner.length === 0) {
            return false;
        }
        let arletId = 'alert-' + this.getTimestamp();

        inner.find('.cms-alert.first').removeClass('first');

        let alertEl = null;

        switch (type) {
            case "success":
                alertEl = $('<div id="' + arletId + '" class="cms-alert first cms-alert-success cms-alert-dismissible fade show" role="alert">\n' +
                    '  <strong>' + message + '\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>');
                inner.prepend(alertEl);
                break;
            case "danger":
                alertEl = $('<div id="' + arletId + '" class="cms-alert first cms-alert-danger cms-alert-dismissible fade show" role="alert">\n' +
                    '  <strong>' + message + '\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>');
                inner.prepend(alertEl);
                break;
            case "warning":
                alertEl = $('<div id="' + arletId + '" class="cms-alert first cms-alert-warning cms-alert-dismissible fade show" role="alert">\n' +
                    '  <strong>' + message + '\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>');
                inner.prepend(alertEl);
                break;
        }
        alertEl.find('.close').on('click', function () {
            alertEl.fadeOut();
        });
        setTimeout(function () {
            if (!_this.isEmpty(alertEl) && !$(alertEl).hasClass('first')) {
                $(alertEl).find('.close').trigger('click');
            }
        }, 3500);
    },

    getTimestamp: function () {
        return new Date().getTime();
    },

    isEmpty: function (val) {
        return typeof val === "undefined" || val === "" || val === null || (typeof val === "object" && $.isEmptyObject(val));
    },
};