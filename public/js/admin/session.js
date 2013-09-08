
$(document).ready(function(){
    
    $('#table-session').dataGrid({
    	url : 'session/list',
    	query: { sort : 'id' },
    	paging : 'links',
    	columnSort: true
	});
    
});