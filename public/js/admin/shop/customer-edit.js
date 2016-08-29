
var customer = {
    customerId: null,

    updateAddressLists : function () {
        $.ajax({
            url: admin.basePath + '/admin/shop/customer/address/address-list',
            data: {customerId: customer.customerId},
            type: 'POST'
        }).done(function (data) {
            var billAd = $('select[name="billingAddressId"]');
            var delAd = $('select[name="deliveryAddressId"]');

            var billAdVal = billAd.val();
            var delAdVal = delAd.val();

            billAd.html(data);
            delAd.html(data);

            billAd.val(billAdVal);
            delAd.val(delAdVal);
        });
    },

    updateCountyList : function () {
        $('#countryId').change(function() {
            $.ajax({
                url : admin.basePath + '/admin/shop/country/province/country-province-list',
                data : {countryId : this.value},
                type : 'POST'
            }).done(function(data){
                $('#provinceId').html( data );
            });
        });
    },

    getCountryProvinces : function() {
        $('#countryId').change(function() {
            $.ajax({
                url : admin.basePath + '/admin/shop/country/province',
                data : {countryId : this.value},
                type : 'POST'
            }).done(function(data){
                $('#provinceId').html( data );
            });
        });
    },
    
    addressModel : function(el, options) {
        var url = $(el).attr('href').replace('-address', '');

        if (!url.contains('admin')) {
            url = url.replace('shop', 'admin/shop');
        }

        var modal = Shop.bootboxDialog({
            title : options.title,
            buttons : {
                save : {
                    label : 'Save',
                    className : 'btn btn-primary',
                    callback : function() {
                        modal.find('.modal-content').loadingOverlay({
                            loadingText: 'Please wait while I update the database'
                        });

                        var response = admin.ajaxModalForm(modal, url);

                        response.done(function (data) {
                            if ($.isPlainObject(data)) {
                                Shop.loadPanel('#customer-addresses .panel-body', admin.basePath + '/admin/shop/customer/address/list', {
                                    customerId: customer.customerId
                                });

                                customer.updateAddressLists();

                            }
                            modal.find('.modal-content').loadingOverlay('remove');
                        });

                        return false;
                    }
                }
            }
        });

        modal.on('show.bs.modal', function () {
            $(this).find('.bootbox-body').load(url, function(){
                $('#countryId').change(function() {
                    $.ajax({
                        url : admin.basePath + '/admin/shop/country/province/country-province-list',
                        data : {countryId : this.value},
                        type : 'POST'
                    }).done(function(data){
                        $('#provinceId').html( data );
                    });
                });
            });

        });

        modal.modal('show');
    }
    
};

$(document).ready(function () {
    Shop.loadPanel('#customer-addresses .panel-body', admin.basePath + '/admin/shop/customer/address/list', {
        customerId: customer.customerId
    });
    Shop.loadPanel('#customer-orders .panel-table', admin.basePath + '/admin/shop/order/order-list', {
        customerId: customer.customerId
    });

    $('#customer-addresses').on('click', '.edit-address-button', function (event) {
        event.preventDefault();
        customer.addressModel($(this), {
            title : 'Edit Address',
            callback : customer.updateAddressLists
        });
        
    });

    $('#add-address-button').on('click', function (event) {
        event.preventDefault();
        customer.addressModel($(this), {
            title : 'Add Address',
            callback : customer.updateAddressLists
        });
    });

    $('#customer-addresses').on('submit', 'form', function (event) {
        event.preventDefault();
        var url = $(this).attr('action').replace('-address', '');
        var params = $(this).serialize() + '&submit=delete';
        var el = $(this).parent().parent().parent();

        if (!url.contains('admin')) {
            url = url.replace('shop', 'admin/shop');
        }

        console.log(url);

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

        response.done(function(data){
            $(el).modal('hide');
            $('.modal-backdrop').remove();
            Shop.loadPanel('#customer-addresses .panel-body', admin.basePath + '/admin/shop/customer/address/list', {
                customerId: customer.customerId
            });
            customer.updateAddressLists();
        })
    });
});
