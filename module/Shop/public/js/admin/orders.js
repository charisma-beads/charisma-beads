
var Orders = {
    customerId : null,

    productId : null,

    addProduct : function(data, dialog) {
        var orderId = $('input[name=orderId]').val();
        data = data + '&id=' + orderId;
        $.ajax({
            url: admin.basePath + '/admin/shop/order/create/add-line',
            data:  data,
            type: 'POST',
            success: function (response) {
                $('#order-lines table').replaceWith(response);
                dialog.modal('hide');
            },
            error: function (response) {
                admin.addAlert(response.error, 'danger');
            }
        });
    },

    addVoucherDialog : function() {
        var orderId = $('input[name=orderId]').val();

        var dialog = Shop.bootboxDialog({
            title: 'Voucher Code',
            buttons: {
                submit: {
                    label : 'Check Voucher',
                    callback : function() {

                        $.ajax({
                            url: admin.basePath + '/admin/shop/voucher/add-voucher/id/' + orderId,
                            data: {'code': $('input[name=code]').val()},
                            type: 'POST',
                            success: function (response) {
                                if ($.isPlainObject(response)) {
                                    if (response.success) {
                                        dialog.modal('hide');
                                        $('#order-lines table').load(
                                            admin.basePath + '/admin/shop/order/create/reload/id/' + orderId,
                                            function() {
                                                if (response.discount == 0) {
                                                    el = $('#table-discount td:last-child')
                                                    discount = el.html().replace ( /[^\d.]/g, '' );

                                                    if (discount == '0.00') {
                                                        setTimeout(Orders.addVoucherDialog,500)
                                                    }

                                                }
                                            }
                                        );
                                    }
                                } else{
                                    dialog.find('.modal-body').html(response);
                                }
                            }
                        });

                        return false;
                    }
                }
            }

        });

        dialog.on('show.bs.modal', function () {
            var el = $(this);
            /*el.find('.modal-content').loadingOverlay({
                loadingText: 'Please wait while I load the form.'
            });*/

            el.find('.modal-body').load(
                admin.basePath + '/admin/shop/voucher/add-voucher/id/' + orderId
            )
        });

        dialog.modal('show');
    },

    productDialog : function(html, productId) {
        var dialog = Shop.bootboxDialog({
            title: 'Product Information',
            message : html,
            buttons: {
                refresh : {
                    label: "Refresh",
                    className: "btn-info",
                    callback : function() {
                        dialog.find('.modal-content').loadingOverlay({
                            loadingText: 'Please wait while I load your product'
                        });

                        $.ajax({
                            url : admin.basePath + '/admin/shop/product/get/id/' + productId,
                            type : 'GET'
                        }).done(function(data){
                            dialog.find('.modal-body').html(data);
                            dialog.find('.modal-content').loadingOverlay('remove');

                            $('#product-form').on('submit', function(e) {
                                e.preventDefault();
                                var data = $(this).serialize();
                                Orders.addProduct(data, dialog);
                            });
                        });

                        return false;
                    }
                }
            }
        });

        $('#product-form').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            Orders.addProduct(data, dialog);
        });

        dialog.modal('show');
    },

    addOrderDigalog : function() {
        var dialog = Shop.bootboxDialog({
            title: 'Search Products',
        });

        dialog.on('show.bs.modal', function () {
            var el = $(this);
            el.find('.modal-body').load(admin.basePath + '/admin/shop/product/search',null, function (){

                $('#add-product-button').prop('disabled', true);

                var pdata = new Bloodhound({
                    datumTokenizer: function (d) {
                        return Bloodhound.tokenizers.whitespace(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: admin.basePath + '/admin/shop/product/search/%QUERY',
                        wildcard: '%QUERY',
                        filter: function (data) {
                            return $.map(data.results, function (item) {
                                return item;
                            });
                        }
                    }
                });

                var productSearch = $('.typeahead').typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 2
                },{
                    displayKey: 'sku',
                    source: pdata,
                    limit: 9999,
                    templates: {
                        pending: function (data) {
                            return '<strong>Searching ...</strong>';
                        },
                        suggestion: function (data) {
                            var outOfStock = false;

                            if (data.quantity == '0') {
                                var outOfStock = true;
                            }
                            var htmlString = '<p><strong>' + data.sku +  '</strong> - ' + data.shortDescription;
                            if (outOfStock == true) {
                                htmlString += ' <strong>(Out of Stock)</strong>';
                            }
                            htmlString += '</p>';
                            return htmlString;
                        },
                        empty: function(data) {
                            return '<strong>Unable to find product using search query "' + data.query + '"</strong>';
                        },
                        header: function (data) {
                            return '<h4 class="text-center"><strong>' + data.suggestions.length + '</strong> Results</h4>';
                        }
                    }
                });

                productSearch.bind('typeahead:select', function(ev, suggestion) {
                    Orders.productId = suggestion.productId;
                    $('#add-product-button').prop('disabled', false);
                    $('#add-product-button').on('click', function (e) {
                        e.preventDefault();
                        el.find('.modal-content').loadingOverlay({
                            loadingText: 'Please wait while I load your product'
                        });

                        $.ajax({
                            url : admin.basePath + '/admin/shop/product/get/id/' + Orders.productId,
                            type : 'GET'
                        }).done(function(data){
                            Orders.productDialog(data, Orders.productId);
                            el.find('.modal-content').loadingOverlay('remove');
                            dialog.modal('hide');
                        });
                    });
                });

                setTimeout(function(){
                    productSearch.focus();
                },500);

            });
        });

        dialog.on('hide.bs.modal', function () {
            Orders.productId = null;
        });

        dialog.modal('show');
    },

    statusSelect : function () {

        $('#order-list').on('change', '.order-status-select', function (e) {
            e.preventDefault();
            var orderNumber = $(this).next().val();
            var orderStatusId = $(this).val();
            $.ajax({
                    url: admin.basePath + '/admin/shop/order/update-status',
            data: {
                'orderStatusId': orderStatusId,
                    'orderNumber': orderNumber
            },
            type: 'POST',
                success: function (json) {
                if (json.success) {
                    admin.addAlert('Updated order status to order no: ' + orderNumber, 'success');
                } else {
                    admin.addAlert('Failed to update order status due to database error', 'danger');
                }
            },
            error: function (response) {
                admin.addAlert(response.responseText, 'danger');
            }
        });
    });
    }
};

$(document).ready(function () {

    if ($('.equal').length > 0) {
        $('.equal').matchHeight();
    }

    Orders.statusSelect();

    /*$('#order-list').on('click', 'a.edit-order', function (e) {
        e.preventDefault();
        var lineId = $(this).attr('id').replace('delete-line-', '');
        console.log(lineId);

        $.ajax({
            url: admin.basePath + '/admin/shop/order/create/remove-line',
            data:  {
                lineId : lineId
            },
            type: 'POST',
            success: function (response) {
                $('#order-lines table').replaceWith(response);
            },
            error: function (response) {
                admin.addAlert(response.error, 'danger');
            }
        });
    });*/

    $('#add-order-line').on('click', function (e) {
        e.preventDefault();
        Orders.addOrderDigalog();
    });

    $('#add-voucher').on('click', function (e) {
        e.preventDefault();
        Orders.addVoucherDialog();
    });

    $('#order-list').on('click', 'a.paypal-payment-lookup', function (e) {
        e.preventDefault();

        var url = $(this).attr('href');

        var dialog = bootbox.dialog({
            title: "PayPal Payment Lookup",
            show: false,
            size: 'large',
            message: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Loading',
            buttons: {
                primary: {
                    label: "Close",
                    className: "btn-primary"
                }
            }
        });

        dialog.on('show.bs.modal', function () {
            $(this).find('.modal-body').load(url);
        });
        dialog.modal('show');
    });

    $('#order-add').on('click', function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        var dialog = Shop.bootboxDialog({
            title: 'Search Customers',
        });

        dialog.on('show.bs.modal', function () {
            $(this).find('.bootbox-body').load(url, null, function () {
                $('[data-toggle="tooltip"], .btn-tooltip').tooltip();
                var cdata = new Bloodhound({
                    datumTokenizer: function (d) {
                        return Bloodhound.tokenizers.whitespace(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    prefetch: {
                        ttl: 3600000,
                        url: admin.basePath + '/admin/shop/customer/auto-complete',
                        filter: function (data) {
                            return $.map(data.results, function (item) {
                                return {
                                    name: item.firstname + ' ' + item.lastname,
                                    customerId: item.customerId
                                };
                            });
                        }
                    }
                });

                $('.typeahead').typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 3
                },{
                    displayKey: 'name',
                    source: cdata,
                    limit: 20,
                    templates: {
                        pending: function (data) {
                            return '<strong>Searching ...</strong>';
                        },
                        suggestion: function (data) {
                            return '<p><strong>' + data.name +  '</strong> - ' + data.customerId + '</p>';
                        },
                    }
                });

                $('.typeahead').bind('typeahead:select', function(ev, suggestion) {
                    $('#customerId').val(suggestion.customerId);

                    $('#order-create-button').on('click', function (event) {
                        event.preventDefault();
                        $('#order-create-form').submit();
                    });
                });
            });
        });

        dialog.modal('show');
    });

    $('#form-order input[name=collect_instore]').on('click', function(e){
        var orderId = $('input[name=orderId]').val();

        $.ajax({
            url: admin.basePath + '/admin/shop/order/create/instore/id/' + orderId,
            data:  {

            },
            type: 'POST',
            success: function (response) {
                $('#order-lines table').replaceWith(response);
            },
            error: function (response) {
                admin.addAlert(response.error, 'danger');
            }
        });

    });

    $('#order-lines').on('click', 'a.delete-line', function (e) {
        e.preventDefault();
        var lineId = $(this).attr('id').replace('delete-line-', '');
        var aLink = $(this).attr('data-href');

        $.ajax({
            url: aLink,
            data:  {
                lineId : lineId
            },
            type: 'POST',
            success: function (response) {
                $('#order-lines table').replaceWith(response);
            },
            error: function (response) {
                admin.addAlert(response.error, 'danger');
            }
        });
    });
});
