window.addEvent('domready', function(){
	if ($('select_all')) {
		$('select_all').addEvent('click', function(event){
			var event = new Event(event).stop();
					
			$$('input').filterByAttribute('type', '=', 'checkbox').each(function(item){
				item.checked = true;
			});
		
		});
	}
});