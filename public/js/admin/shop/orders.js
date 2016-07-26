
var Orders = {
    customerId : null,
};

$(document).ready(function () {
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
                            console.log(data);
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
                    $('#order-create-button').attr('href', admin.basePath + '/admin/shop/order/create/customerId/' + suggestion.customerId);
                });
            });
        });

        dialog.modal('show');
    });
});
