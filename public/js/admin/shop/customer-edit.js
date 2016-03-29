
var customer = {
    customerId: null,

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
    }

};

$(document).ready(function () {
    
});
