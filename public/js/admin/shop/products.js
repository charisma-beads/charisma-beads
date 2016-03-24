var product = {
    productId : null,

    productOptions : function() {
        admin.ajaxWidgetPanel(
            $('#product-option').find('.product-option-list'),
            admin.basePath + '/admin/shop/product/option/option-list',
            {productId: product.productId}
        );
    },

    productImages : function() {
        admin.ajaxWidgetPanel(
            $('#product-image').find('.product-image-list'),
            admin.basePath + '/admin/shop/product/image/image-list',
            {productId: product.productId}
        );
    },

    bootboxDialog : function(options) {
        var defaultOptions = {
            show: false,
            message: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Loading',
            buttons: {
                main: {
                    label: "Close",
                    className: "btn-default"
                },
                save: {
                    label: "Save",
                    className: "btn-primary"
                }
            }
        };

        options = $.extend(true, {}, defaultOptions, typeof options == 'object' && options);

        return bootbox.dialog(options);
    },

    selectDialog : function (url, callbackUrl, title, callbackElement) {
        var modal = this.bootboxDialog({
            title: title,
            buttons: {
                save: {
                    callback: function () {
                        modal.find('.modal-content').loadingOverlay({
                            loadingText: 'Please wait while I update the database'
                        });

                        var response = admin.ajaxModalForm(modal, admin.basePath + url);

                        response.done(function (data) {
                            if ($.isPlainObject(data)) {
                                var el = callbackElement;
                                el.load(admin.basePath + callbackUrl, null, function () {
                                    el.val(data.rowId);
                                });
                            }
                            modal.find('.modal-content').loadingOverlay('remove');
                        });

                        return false;
                    }
                }
            }
        });

        modal.on('show.bs.modal', function () {
            $(this).find('.bootbox-body').load(admin.basePath + url);
        });
        modal.modal('show');
    },

    editButton : function(el, options) {

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

                        var response = admin.ajaxModalForm(modal, url);

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
                admin.addAlert(response.messages, response.status);
            },
            error: function (response) {
                admin.addAlert(response.error, 'danger');
            }
        });
        response.done(function(){
            $(el).modal('hide');
            $('.modal-backdrop').remove();
            callback();
        })
    }
};

$(document).ready(function () {
    $('textarea.editable-textarea').summernote({
        toolbar: [
            ['style', ['style', 'bold', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    $('#add-product-option-button').on('click', function (event) {
        event.preventDefault();
        product.editButton(this, {
            title : 'Add Product Option',
            callback : product.productOptions
        });
    });

    $('#add-product-image-button').on('click', function (event) {
        event.preventDefault();
        var el = $(this);
        var modal = product.bootboxDialog({
            title : 'Add Product Image',
            buttons : {
                main : {
                    callback : function() {
                        product.productImages()
                    }
                }
            }
        });

        modal.find('button[data-bb-handler=save]').remove();

        modal.on('show.bs.modal', function () {
            $(this).find('.bootbox-body').load(el.attr('href'), function () {
                $('#upload-form').append(
                    '<input type="hidden" name="productId" value="' + product.productId + '">'
                );
            });

        });

        modal.modal('show');
    });

    $('#product-option').on('click', '.edit-button', function (event) {
        event.preventDefault();
        product.editButton(this, {
            title : 'Edit Product Option',
            callback : product.productOptions
        });
    });

    $('#product-image').on('click', '.edit-button', function (event) {
        event.preventDefault();
        product.editButton(this, {
            title : 'Edit Product Image',
            callback : product.productImages
        });
    });

    $('button[name=add-size-button]').on('click', function(e){
        e.preventDefault();
        product.selectDialog('/admin/shop/product/size/add', '/admin/shop/product/size/size-list', 'Add Product Size', $('select[name=productSizeId]'));
    });

    $('button[name=add-weight-button]').on('click', function(e){
        e.preventDefault();
        product.selectDialog('/admin/shop/post/unit/add', '/admin/shop/post/unit/post-list', 'Add Product Weight', $('select[name=postUnitId]'));
    });

    $('#product-option').on('submit', 'form', function (event) {
        event.preventDefault();
        product.deleteButton($(this), product.productOptions);
    });

    $('#product-image').on('submit', 'form', function (event) {
        event.preventDefault();
        product.deleteButton($(this), product.productImages);
    });

    product.productImages();
    product.productOptions();
});