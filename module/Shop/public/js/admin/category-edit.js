
var category = {
    productCategoryId : null,

    selectFile : function() {
        var modal = bootbox.dialog({
            title : 'Select Image',
            show : false,
            message: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Loading',
            buttons: {
                main: {
                    label: "Select",
                    className: "btn-primary",
                    callback: function() {
                        $('#product-category-image').val(
                            $('select[name=image-select]').val()
                        );
                    }
                }
            }
        });

        modal.on('show.bs.modal', function () {
            $(this).find('.bootbox-body').load(adminClass.basePath + '/admin/shop/category/category-image-select/id/' + category.productCategoryId);
        });

        modal.modal('show');
    },

    uploadFile : function() {
        var modal = bootbox.dialog({
            title : 'Upload Image',
            show : false,
            message: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Loading',
            buttons: {
                main: {
                    label: "Close",
                    className: "btn-default"
                }
            }
        });

        modal.on('show.bs.modal', function () {
            $(this).find('.bootbox-body').load(adminClass.basePath + '/admin/uploader/upload-form');
        });

        modal.on('hide.bs.modal', function () {
            if (adminClass.upload && adminClass.upload.status) {
                $('#product-category-image').val(adminClass.upload.image.name);
            }
        });
        modal.modal('show');
    }
};

$(document).ready(function() {
    $('#upload-category-image').on('click', function(e){
        e.preventDefault();
        category.uploadFile();
    });

    $('#list-category-image').on('click', function(e){
        e.preventDefault();
        category.selectFile();
    });
});
