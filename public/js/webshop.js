// web shop js

window.addEvent('domready', function(){ 	
	if ($('read_terms')) {
		var fx = new Fx.Morph('read_terms', {duration:200, wait:false});

		$('read_terms').addEvent('mouseenter', function(){
			fx.start({
				'margin-left': 5,
				'color': '#f00'
			});
		});

		$('read_terms').addEvent('mouseleave', function(){
			fx.start({
				'margin-left': 0,
				'color': '#000'
			});
		});
	
		var termsSlide = new Fx.Slide('show_terms');
		
		termsSlide.toggle();
		
		$('read_terms').addEvent('click', function(e){
			e = new Event(e);
			termsSlide.toggle();
			e.stop();
		});
	}
	
	if($('paypal_form')) {
		window.addEvent('load', function(e){
			$('paypal_form').submit();
		});
	}
	
});

