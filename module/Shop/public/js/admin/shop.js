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
        adminClass.ajaxWidgetPanel($(el), url, options);
    },

    addEditButton : function(el, options) {

        var el = $(el);
        var url = el.attr('href');

        var modal = this.bootboxDialog({
            title : options.title,
            buttons : {
                save : {
                    callback : function() {

                        modal.find('.modal-content').loadingOverlay({
                            loadingText: 'Please wait while I update the database'
                        });

                        var response = adminClass.ajaxModalForm(modal, url);

                        response.done(function (data) {
                            if ($.isPlainObject(data)) {
                                options.callback();
                            }
                            modal.find('.modal-content').loadingOverlay('remove');
                        });

                        return false;
                    }
                }
            }
        });

        modal.on('show.bs.modal', function () {
            $(this).find('.bootbox-body').load(url);

        });

        modal.modal('show');
    },

    deleteButton : function (el, callback) {
        var url = $(el).attr('action');
        var params = $(el).serialize() + '&submit=delete';
        var el = $(el).parent().parent().parent();

        var response = $.ajax({
            url: url,
            data: params,
            type: 'POST',
            success: function (response) {
                adminClass.addAlert(response.messages, response.status);
            },
            error: function (response) {
                adminClass.addAlert(response.messages, 'danger');
            }
        });
        response.done(function(){
            $(el).modal('hide');
            $('.modal-backdrop').remove();
            callback();
        })
    }
};
