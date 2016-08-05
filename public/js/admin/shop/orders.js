
var Orders = {
    customerId : null,

    productId : null,

    addProduct : function(data) {
        console.log(data);

        $.ajax({
            url: admin.basePath + '/admin/shop/order/create/add-line',
            data:  data,
            type: 'POST',
            success: function (response) {
                console.log(response);
                $('#table-postage').before(response);
            },
            error: function (response) {
                admin.addAlert(response.error, 'danger');
            }
        });
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
                        });

                        return false;
                    }
                }
            }
        });

        $('#product-form').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            Orders.addProduct(data);
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
                    minLength: 3
                },{
                    displayKey: 'sku',
                    source: pdata,
                    limit: 20,
                    templates: {
                        pending: function (data) {
                            return '<strong>Searching ...</strong>';
                        },
                        suggestion: function (data) {
                            return '<p><strong>' + data.sku +  '</strong> - ' + data.shortDescription + '</p>';
                        },
                        empty: function(data) {
                            return '<strong>Unable to find product using search query "' + data.query + '"</strong>';
                        }
                    }
                });

                productSearch.bind('typeahead:select', function(ev, suggestion) {
                    Orders.productId = suggestion.productId;
                });

                setTimeout(function(){
                    productSearch.focus();
                },500);



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
        });

        dialog.on('hide.bs.modal', function () {
            Orders.productId = null;
        });

        dialog.modal('show');
    }
};

$(document).ready(function () {

    if ($('.equal').length > 0) {
        $('.equal').matchHeight();
    }

    $('#add-order-line').on('click', function (e) {
        e.preventDefault();
        Orders.addOrderDigalog();
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
                    $('#order-create-button').attr('href', admin.basePath + '/admin/shop/order/create/add/customerId/' + suggestion.customerId);
                });
            });
        });

        dialog.modal('show');
    });
});
