window.addEvent('domready', function(){
	
	var selectBoxes = $$('select.selectBox');
	
	selectBoxes.each(function(element){
		$(element).addEvent('change', function(){
			this.getParent().submit();
		});
	});
	
});