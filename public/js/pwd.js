function checkpassword() 
{
	var pwd = $('password').get('value');
	var intstrength = 0;
			
	if (pwd.length > 3 && pwd.length < 6)
	{
		intstrength = (intstrength + 3);
	}
	else if (pwd.length > 5 && pwd.length < 9)
	{
		intstrength = (intstrength + 5);
	}
	else if (pwd.length > 7 && pwd.length < 13)
	{
		intstrength = (intstrength + 7);
	}
	else if (pwd.length > 12)
	{
		intstrength = (intstrength + 8);
	}
			
	if (pwd.match(/[a-z]/) && pwd.match(/[A-Z]/)) 
	{
		intstrength = (intstrength + 8);
	}
		
	if (pwd.match(/[0-9]/)) 
	{
		intstrength = (intstrength + 4);
	}
			
	if (pwd.match(/[\!\£\$\%\&\/\(\)\=\?\+\*\#\-\.\,\;\:\_]/))
	{
		intstrength = (intstrength + 10);
	}
			
	if (intstrength < 10) 
	{
		strverdict = "poor";
		$('passStrength').setStyle('color', 'red');
	}
	else if (intstrength > 9 && intstrength < 20) 
	{
		strverdict = "average";
		$('passStrength').setStyle('color', 'goldenrod');
	}
	else if (intstrength > 19) 
	{
		strverdict = "tough";
		$('passStrength').setStyle('color', 'green');
	}
			
	$('passStrength').set('html','score: ' + intstrength + '/30<br />verdict: ' + strverdict);
	
	$('bar').setStyle('width', intstrength);
	
}

window.addEvent('domready', function() {
	
	if ($('password')) {
		$('password').addEvents({
			'keyup': function() 
			{
				checkpassword();
			}
		});
	
		var scroll = new Fx.Scroll('password-text', {
			wait: false,
  			duration: 1500,
  			transition: Fx.Transitions.Quad.easeInOut
		});
		
		if ($('special')) {
			$('special').addEvent('click', function(event) {
				event = new Event(event).stop();
				scroll.toElement('special_characters');
			});
		}
	}
	
});