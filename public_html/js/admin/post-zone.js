
admin.postZone = {
	rowClick : function(e){
		var trId = $(this).find('td:first-child').text();
        var title = $(this).find('td.tab-title').text();
        title = (title) ? title : 'Post Zone';
        
        
        if ($('#postZone'+trId).length) {
            $('#postZoneTabs a[href=#postZone'+trId+']').tab('show');
        } else {
            $('#postZoneTabs')
            .append('<li><a href="#postZone'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
            $('#postZoneTabContent')
            .append('<div class="tab-pane" id="country'+trId+'">Loading...</div>');
            
            $('#postZone'+trId).load('shop/post/zone/edit', {userId : trId},
                function (responseText, textStatus, req) {
                    
                    if (textStatus == "error") {
                        $('#postZone'+trId).html(responseText);
                    }
            });
        
            $('#postZoneTabs a[href=#postZone'+trId+']').tab('show');
        }
	}
};

$(document).ready(function(){
    
    /*$('#postZoneTabs').on('click', 'a', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('#postZoneTabs a:first').tab('show');
    postZoneTabs = $('#countryTabs a:first');
    
    $('#postZoneTabs').on('click', '.close', function(e){ 
    	$($(this).parent().attr('href')).remove();
    	$(this).parent().parent().remove();
    	postZoneTabs.tab('show');
    });*/
    
    $('#table-postZone').dataGrid({
    	url : 'zone/list',
    	query: { sort : 'zone' },
    	searchForm : $('#search-zone'),
    	paging : 'links',
    	columnSort: true,
    	//rowClick : admin.postZone.rowClick
	});
    
});