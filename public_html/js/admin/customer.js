
admin.customer = {
	rowClick : function(e){
		var trId = $(this).find('td:first-child').text();
        var title = $(this).find('td.tab-title').text();
        title = (title) ? title : 'Customer';
        
        
        if ($('#customer'+trId).length) {
            $('#customerTabs a[href=#customer'+trId+']').tab('show');
        } else {
            $('#customerTabs')
            .append('<li><a href="#customer'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
            $('#customerTabContent')
            .append('<div class="tab-pane" id="customer'+trId+'">Loading...</div>');
            
            $('#category'+trId).load('shop/customer/edit', {userId : trId},
                function (responseText, textStatus, req) {
                    
                    if (textStatus == "error") {
                        $('#customer'+trId).html(responseText);
                    }
            });
        
            $('#customerTabs a[href=#customer'+trId+']').tab('show');
        }
	}
};

$(document).ready(function(){
    
    /*$('#customerTabs').on('click', 'a', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('#customerTabs a:first').tab('show');
    customerTabs = $('#customerTabs a:first');
    
    $('#customerTabs').on('click', '.close', function(e){ 
    	$($(this).parent().attr('href')).remove();
    	$(this).parent().parent().remove();
    	customerTabs.tab('show');
    });*/
    
    $('#table-customer').dataGrid({
    	url : 'customer/list',
    	query: { sort : 'name' },
    	searchForm : $('#search-customer'),
    	paging : 'links',
    	columnSort: true,
    	//rowClick : admin.customer.rowClick
	});
    
});