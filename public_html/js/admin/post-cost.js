
admin.postCost = {
	rowClick : function(e){
		var trId = $(this).find('td:first-child').text();
        var title = $(this).find('td.tab-title').text();
        title = (title) ? title : 'Post Cost';
        
        
        if ($('#postCost'+trId).length) {
            $('#postCostTabs a[href=#postCost'+trId+']').tab('show');
        } else {
            $('#postCostTabs')
            .append('<li><a href="#postCostl'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
            $('#postCostTabContent')
            .append('<div class="tab-pane" id="postCost'+trId+'">Loading...</div>');
            
            $('#postCost'+trId).load('shop/post/cost/edit', {userId : trId},
                function (responseText, textStatus, req) {
                    
                    if (textStatus == "error") {
                        $('#postCost'+trId).html(responseText);
                    }
            });
        
            $('#postCostTabs a[href=#postCost'+trId+']').tab('show');
        }
	}
};

$(document).ready(function(){
    
    /*$('#postCostTabs').on('click', 'a', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('#postCostTabs a:first').tab('show');
    postCostTabs = $('#countryTabs a:first');
    
    $('#postCostTabs').on('click', '.close', function(e){ 
    	$($(this).parent().attr('href')).remove();
    	$(this).parent().parent().remove();
    	postCostTabs.tab('show');
    });*/
    
    $('#table-postCost').dataGrid({
    	url : 'cost/list',
    	query: { sort : 'postZoneId' },
    	searchForm : $('#search-postCost'),
    	paging : 'links',
    	columnSort: true,
    	//rowClick : admin.postLevel.rowClick
	});
    
});