String.prototype.contains = function(str) {
    return this.indexOf(str) != -1;
};

var Shop = {
    bootboxDialog : function(options) {
        var defaultOptions = {
            show: false,
            message: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Loading',
            buttons: {
                main: {
                    label: "Close",
                    className: "btn-default"
                }
            }
        };

        options = $.extend(true, {}, defaultOptions, typeof options == 'object' && options);

        return bootbox.dialog(options);
    },

    loadPanel : function(el, url, options) {
        admin.ajaxWidgetPanel($(el), url, options);
    }
};
