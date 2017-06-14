
var Cart = {
    setupVoucherForm : function () {
        $('#voucher-code').on('submit', 'form', function (event) {
            event.preventDefault();

            var params = $(this).serialize();
            var el = $(this).parent();
            var url = $(this).attr('action');
            Cart.voucherCheck(el, url, params);
        });
    },

    voucherCheck : function (el, url, params) {
        $.ajax({
            url : shopBasePath + '/shop/add-voucher',
            data: params,
            type: 'POST',
            beforeSend : function() {
                $(el).html('<div class="text-center"><i class="fa fa-refresh fa-spin fa-3x"></i></div>');
            },
            success: function (response) {
                if ($.isPlainObject(response)) {
                    //if (response.success == true) {
                        $.ajax({
                            url : url,
                            type: 'GET',
                            success: function (response) {
                                $('#cart-content').html(response);
                                Cart.setupVoucherForm();
                            }
                        });
                    //}

                } else {
                    $(el).html(response);
                }
            }
        });
    }
};

$(document).ready(function() {

    if ($('#voucher-code')) {
        Cart.setupVoucherForm();
    }

});
