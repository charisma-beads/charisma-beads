window.addEvent('domready', function() {
    
    if (!Browser.Platform.ios && !Browser.Platform.android && !Browser.Platform.webos) {
		tips = new Tips($$('.Tips'), {
			onShow: function(tip){ tip.fade('in'); },
			onHide: function(tip){ tip.fade('out'); }
		});
	}

	new Fx.SmoothScroll();
	
    var obj = new Swiff('/template/logo.swf', {
        id: 'logo',
        container: 'flashLogo',
        width: 85,
        height: 100,
        params: {
            play: true,
            loop: true,
            wMode: 'transparent',
            bgcolor: '#fff'
        }
    });
	
	if (window.ie && (!window.ie7 || !window.ie8)) iepngfix();
	
	if($('admin_login')) {
		$('admin_login').set('html', '<a href="">admin</a>');
		$('admin_login').addEvent('click', function(e) {
			e.stop();
			var loc = $('admin_login').get('rel');
			window.location = '/admin';
		});
		
	}

	window.addEvent('scroll', function(){
		var sTop = window.getScrollTop();
		$('mini_cart').setStyle('top', sTop + 5 + 'px');
	});
});

