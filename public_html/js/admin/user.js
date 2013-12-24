
admin.user = {
	rowClick : function(e){
		var trId = $(this).find('td:first-child').text();
        var title = $(this).find('td.tab-title').text();
        title = (title) ? title : 'User';
        
        
        if ($('#user'+trId).length) {
            $('#userTabs a[href=#user'+trId+']').tab('show');
        } else {
            $('#userTabs')
            .append('<li><a href="#user'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
            $('#userTabContent')
            .append('<div class="tab-pane" id="user'+trId+'">Loading...</div>');
            
            $('#user'+trId).load('user/edit', {userId : trId},
                function (responseText, textStatus, req) {
                    
                    if (textStatus == "error") {
                        $('#user'+trId).html(responseText);
                    }
            });
        
            $('#userTabs a[href=#user'+trId+']').tab('show');
        }
	}
};

$(document).ready(function(){
    
    /*$('#userTabs').on('click', 'a', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('#userTabs a:first').tab('show');
    userTabs = $('#userTabs a:first');
    
    $('#userTabs').on('click', '.close', function(e){ 
    	$($(this).parent().attr('href')).remove();
    	$(this).parent().parent().remove();
    	userTabs.tab('show');
    });*/
    
    $('#table-user').dataGrid({
    	url : 'user/list',
    	query: { sort : 'name' },
    	searchForm : $('#search-user'),
    	paging : 'links',
    	columnSort: true,
    	//rowClick : admin.user.rowClick
	});
    
});