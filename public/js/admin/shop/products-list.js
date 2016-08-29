

$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
        html: true,
        placement: 'left'
    });

    $('input[name=discontinued]').on('click', function () {
        $('#table-product').dataGrid('doSearch');
    });

    $('input[name=disabled]').on('click', function () {
        $('#table-product').dataGrid('doSearch');
    });

    $('select[name=productCategoryId]').on('change', function () {
        $('#table-product').dataGrid('doSearch');
    });

    $('#product-list-link').on('click', function(e){
        e.preventDefault();

        var productList = bootbox.dialog({
            title: 'Product List Download',
            message: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Loading',
            show: false,
            buttons: {
                main: {
                    label: 'Close',
                    className: 'btn-default'
                },
                list: {
                    label: 'Download List',
                    className: 'btn-primary',
                    callback: function() {
                        var cat = productList.find('select').val();
                        var errorCount = 0;
                        var response = $.ajax({
                            url: admin.basePath + '/admin/shop/report/product-list',
                            data:  $('#product-report').serialize(),
                            type: 'POST',
                            beforeSend: function() {
                                productList.find('.modal-content').loadingOverlay({
                                    loadingText: 'Please wait while I prepare your report'
                                });
                            },
                            success: function (response) {
                                var message;
                                if (response.status == 'success') {
                                    message = '<h5>Please click on link below to download your report</h5>'
                                        + '<a href="' + response.url + '" target="_blank">' + response.report + '</a>';
                                } else {
                                    message = '<h5 class="text-danger">Error!</h5><span class="text-danger">' + response.message + '</span>';
                                }
                                productList.find('.bootbox-body').html(message);
                                productList.find('button[data-bb-handler=list]').remove();
                                productList.find('.modal-content').loadingOverlay('remove');
                            },
                            error: function (response) {
                                admin.addAlert(response.error, 'danger');
                            }
                        });

                        return false;
                    }
                }
            }
        });

        productList.on('show.bs.modal', function () {
            $(this).find('.bootbox-body').load(admin.basePath + '/admin/shop/report');
        });

        productList.modal('show');
    });
});
