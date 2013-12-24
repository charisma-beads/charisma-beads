window.addEvent('domready', function(){
	if ($('da_show')) {
		$('da_show').addEvent('click', function(){
			$('D_address').setStyle('display', 'block');
		});
	
		$('da_hide').addEvent('click', function(){
			$('D_address').setStyle('display', 'none');
		});
	}
	
	if ($('country_select')) {
		$('country_select').addEvent('change', function(event){
			this.form.submit();
		});
	}
});