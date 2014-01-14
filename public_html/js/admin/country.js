
admin.country = {
	rowClick : function(e){
		var trId = $(this).find('td:first-child').text();
        var title = $(this).find('td.tab-title').text();
        title = (title) ? title : 'Country';
        
        
        if ($('#country'+trId).length) {
            $('#countryTabs a[href=#country'+trId+']').tab('show');
        } else {
            $('#countryTabs')
            .append('<li><a href="#country'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
            $('#countryTabContent')
            .append('<div class="tab-pane" id="country'+trId+'">Loading...</div>');
            
            $('#country'+trId).load('shop/country/edit', {userId : trId},
                function (responseText, textStatus, req) {
                    
                    if (textStatus == "error") {
                        $('#country'+trId).html(responseText);
                    }
            });
        
            $('#countryTabs a[href=#country'+trId+']').tab('show');
        }
	}
};

$(document).ready(function(){
    
    /*$('#countryTabs').on('click', 'a', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('#countryTabs a:first').tab('show');
    countryTabs = $('#countryTabs a:first');
    
    $('#countryTabs').on('click', '.close', function(e){ 
    	$($(this).parent().attr('href')).remove();
    	$(this).parent().parent().remove();
    	countryTabs.tab('show');
    });*/
    
    $('#table-country').dataGrid({
    	url : 'country/list',
    	query: { sort : 'country' },
    	searchForm : $('#search-country'),
    	paging : 'links',
    	columnSort: true,
    	//rowClick : admin.country.rowClick
	});
    
});