
var customer = {
    createOrder : function () {
        $('#customer-list').on('click', '.create-order-button', function (e) {
            e.preventDefault();

            var newForm = jQuery('<form>', {
                'action': $(this).attr('href'),
                'method': 'POST'
            }).append(jQuery('<input>', {
                'name': 'customerId',
                'value': $(this).attr('id').replace('order-', ''),
                'type': 'hidden'
            }));

            newForm.appendTo('body').submit();
        });
    }
}

$(document).ready(function() {
    customer.createOrder();

    $( document ).ajaxComplete(function() {
        customer.createOrder();
    });
});
