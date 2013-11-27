
admin.product = {
	rowClick : function(e){
		var trId = $(this).find('td:first-child').text();
        var title = $(this).find('td.tab-title').text();
        title = (title) ? title : 'Product';
        
        
        if ($('#product'+trId).length) {
            $('#productTabs a[href=#product'+trId+']').tab('show');
        } else {
            $('#productTabs')
            .append('<li><a href="#product'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
            $('#productTabContent')
            .append('<div class="tab-pane" id="user'+trId+'">Loading...</div>');
            
            $('#product'+trId).load('shop/product/edit', {userId : trId},
                function (responseText, textStatus, req) {
                    
                    if (textStatus == "error") {
                        $('#product'+trId).html(responseText);
                    }
            });
        
            $('#productTabs a[href=#user'+trId+']').tab('show');
        }
	}
};

$(document).ready(function(){
    
    /*$('#productTabs').on('click', 'a', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('#productTabs a:first').tab('show');
    userTabs = $('#productTabs a:first');
    
    $('#productTabs').on('click', '.close', function(e){ 
    	$($(this).parent().attr('href')).remove();
    	$(this).parent().parent().remove();
    	productTabs.tab('show');
    });*/
    
    $('#table-product').dataGrid({
    	url : 'product/list',
    	query: { sort : 'name' },
    	searchForm : $('#search-product'),
    	paging : 'links',
    	columnSort: true,
    	//rowClick : admin.product.rowClick
	});
    
});