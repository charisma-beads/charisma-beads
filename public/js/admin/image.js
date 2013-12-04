
admin.image = {
	rowClick : function(e){
		var trId = $(this).find('td:first-child').text();
        var title = $(this).find('td.tab-title').text();
        title = (title) ? title : 'Image';
        
        
        if ($('#image'+trId).length) {
            $('#imageTabs a[href=#image'+trId+']').tab('show');
        } else {
            $('#imageTabs')
            .append('<li><a href="#image'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
            $('#imageTabContent')
            .append('<div class="tab-pane" id="image'+trId+'">Loading...</div>');
            
            $('#image'+trId).load('shop/image/edit', {userId : trId},
                function (responseText, textStatus, req) {
                    
                    if (textStatus == "error") {
                        $('#image'+trId).html(responseText);
                    }
            });
        
            $('#imageTabs a[href=#image'+trId+']').tab('show');
        }
	}
};

$(document).ready(function(){
    
    /*$('#imageTabs').on('click', 'a', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('#imageTabs a:first').tab('show');
    imageTabs = $('#imageTabs a:first');
    
    $('#imageTabs').on('click', '.close', function(e){ 
    	$($(this).parent().attr('href')).remove();
    	$(this).parent().parent().remove();
    	imageTabs.tab('show');
    });*/
    
    $('#table-image').dataGrid({
    	url : 'image/list',
    	query: { sort : 'lft' },
    	searchForm : $('#search-image'),
    	paging : 'links',
    	columnSort: true,
    	//rowClick : admin.image.rowClick
	});
    
});