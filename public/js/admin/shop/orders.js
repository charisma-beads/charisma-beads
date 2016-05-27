
var Orders = {
    customerId : null,

    loadCart : function() {
        admin.ajaxWidgetPanel(
            $('#order-lines'),
            admin.basePath + '/admin/shop/cart/view'
        );
    }
};

$(document).ready(function () {

});
