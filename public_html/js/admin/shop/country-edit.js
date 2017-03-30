
var country = {
    countryId: null,

    provinces : function () {

        admin.ajaxWidgetPanel(
            $('#country-province').find('.country-province-list'),
            admin.basePath + '/admin/shop/country/province/list',
            {countryId: country.countryId}
        );
    }
}

$(document).ready(function() {

    $('#add-country-province-button').on('click', function (event) {
        event.preventDefault();
        Shop.addEditButton($(this), {
            title : 'Add Country province',
            callback : country.provinces
        });
    });

    $('#country-province').on('click', '.edit-button', function (event) {
        event.preventDefault();
        Shop.addEditButton($(this), {
            title : 'Edit Country province',
            callback : country.provinces
        });
    });

    $('#country-province').on('submit', 'form', function (event) {
        event.preventDefault();
        Shop.deleteButton($(this), country.provinces);
    });

    country.provinces();
});
