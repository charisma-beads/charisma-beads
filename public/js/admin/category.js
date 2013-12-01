
admin.category = {
	rowClick : function(e){
		var trId = $(this).find('td:first-child').text();
        var title = $(this).find('td.tab-title').text();
        title = (title) ? title : 'Category';
        
        
        if ($('#category'+trId).length) {
            $('#categoryTabs a[href=#cateory'+trId+']').tab('show');
        } else {
            $('#caegoryTabs')
            .append('<li><a href="#category'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
            $('#categoryTabContent')
            .append('<div class="tab-pane" id="user'+trId+'">Loading...</div>');
            
            $('#category'+trId).load('shop/category/edit', {userId : trId},
                function (responseText, textStatus, req) {
                    
                    if (textStatus == "error") {
                        $('#category'+trId).html(responseText);
                    }
            });
        
            $('#categoryTabs a[href=#category'+trId+']').tab('show');
        }
	}
};

$(document).ready(function(){
    
    /*$('#categoryTabs').on('click', 'a', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('#categoryTabs a:first').tab('show');
    categoryTabs = $('#categoryTabs a:first');
    
    $('#categoryTabs').on('click', '.close', function(e){ 
    	$($(this).parent().attr('href')).remove();
    	$(this).parent().parent().remove();
    	categoryTabs.tab('show');
    });*/
    
    $('#table-product').dataGrid({
    	url : 'category/list',
    	query: { sort : 'name' },
    	searchForm : $('#search-product'),
    	paging : 'links',
    	columnSort: true,
    	//rowClick : admin.category.rowClick
	});
    
});