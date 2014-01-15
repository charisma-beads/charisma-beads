
admin.postLevel = {
	rowClick : function(e){
		var trId = $(this).find('td:first-child').text();
        var title = $(this).find('td.tab-title').text();
        title = (title) ? title : 'Post Level';
        
        
        if ($('#postlevel'+trId).length) {
            $('#postlevelTabs a[href=#postLevel'+trId+']').tab('show');
        } else {
            $('#postLevelTabs')
            .append('<li><a href="#postLevel'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
            $('#postLevelTabContent')
            .append('<div class="tab-pane" id="country'+trId+'">Loading...</div>');
            
            $('#postLevel'+trId).load('shop/post/level/edit', {userId : trId},
                function (responseText, textStatus, req) {
                    
                    if (textStatus == "error") {
                        $('#postLevel'+trId).html(responseText);
                    }
            });
        
            $('#postLevelTabs a[href=#postLevel'+trId+']').tab('show');
        }
	}
};

$(document).ready(function(){
    
    /*$('#postLevelTabs').on('click', 'a', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('#postLevelTabs a:first').tab('show');
    postLevelTabs = $('#countryTabs a:first');
    
    $('#postLevelTabs').on('click', '.close', function(e){ 
    	$($(this).parent().attr('href')).remove();
    	$(this).parent().parent().remove();
    	postLevelTabs.tab('show');
    });*/
    
    $('#table-postLevel').dataGrid({
    	url : 'level/list',
    	query: { sort : 'postLevel' },
    	searchForm : $('#search-postLevel'),
    	paging : 'links',
    	columnSort: true,
    	//rowClick : admin.postLevel.rowClick
	});
    
});