window.addEvent('domready', function() {
    
	tips = new Tips($$('.Tips'), {
		onShow: function(tip){ tip.fade('in'); },
		onHide: function(tip){ tip.fade('out'); }
	});

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
});

window.addEvent('load', function(){
	if ($('map')) {
	//Latitude = 51.9526, Longitude = -0.2651
	var pcplusCoords = new GLatLng(51.9526, -0.2651);
	var UKcentreCoords = new GLatLng(51.9526, -0.2651);
	var defaultZoomLevel = 18;
	
	// this is called by the body 'onload' event handler

	function initialisePage()
	{
		var map = new GMap2(document.getElementById("map"));
	
		map.setCenter(UKcentreCoords, defaultZoomLevel);
	
		// list other types
		map.setMapType(G_HYBRID_MAP);
	
		// first add standard controls
		map.addControl(new GMapTypeControl());
		map.addControl(new GOverviewMapControl(), new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(32, 32)));
		map.addControl(new GScaleControl(), new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(210, 8)));
			
		// add pc-plus tabbed marker
			
		var tab1Html = '<img src="/template/charisma.gif" alt="Charisma Beads Ltd" />';		
		var tab2Html = '<div id="address"><p>Charisma Beads Ltd</p><p>Unit 2F, 80/81 Walsworth Road</p><p>Hitchin</p><p>Hertfordshire</p><p>SG4 9SX</p><p>01462 454054</p></div>';
		
		var tabs = [
			new GInfoWindowTab("info", tab1Html),
			new GInfoWindowTab("contact", tab2Html)
		];
			
			
		// add pc-plus custom marker
		map.addOverlay(createCustomMarker(pcplusCoords, tabs));
	
		// add custom controls
		map.addControl(new ZoomControl());
		map.addControl(new HomeControl());
	/*			
		GEvent.addListener(map, "click",
			function(overlay, point)
			{
				GLog.write('Point clicked:' + point.toString());
			});
	*/		
	} 	
	
	function createCustomMarker(point, tabs)
	{
		
		var icon = new GIcon();
		
		icon.image = "/images/marker.png";
		icon.shadow = "/images/shadow.png";
		
		icon.iconSize = new GSize(20, 34);
		icon.shadowSize = new GSize(37, 34);
		
		icon.iconAnchor = new GPoint(16, 32);
		icon.infoWindowAnchor = new GPoint(16, 16);
			
		var marker = new GMarker(point, icon);
		GEvent.addListener(marker, "click", function()
		{
			marker.openInfoWindowTabsHtml(tabs);
		});	
	
		return marker;
	}
	
	function ZoomControl()
	{
	}
	
	ZoomControl.prototype = new GControl();
	ZoomControl.prototype.initialize = function(map)
	{
		var container = document.createElement("div");
		
		var zoomInDiv = document.createElement("div");
		var zoomInImgSrc = '/images/zoom_in.gif';
		this.setButtonStyle_(zoomInDiv, zoomInImgSrc);
		container.appendChild(zoomInDiv);
		GEvent.addDomListener(zoomInDiv, "click",
			function()
			{
	//			GLog.write('zoom-in clicked');
				map.zoomIn();
			} );
		
		var zoomOutDiv = document.createElement("div");
		var zoomOutImgSrc = '/images/zoom_out.gif';
		this.setButtonStyle_(zoomOutDiv, zoomOutImgSrc);
		container.appendChild(zoomOutDiv);
		GEvent.addDomListener(zoomOutDiv, "click",
			function()
			{
	//			GLog.write('zoom-out clicked');
				map.zoomOut();
			} );
		
		map.getContainer().appendChild(container);
		return container;
	}
	
	ZoomControl.prototype.getDefaultPosition = function()
	{
	return new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(8, 40));
	}
	
	
	ZoomControl.prototype.setButtonStyle_ = function(button, imgsrc)
	{
		var image = document.createElement("img");
		image.src = imgsrc;
		button.appendChild(image);
		button.style.backgroundColor = "#f1f1f1";
		button.style.border = "1px solid black";
		button.style.padding = "2px";
		button.style.marginBottom = "3px";
		button.style.cursor = "pointer";
	}
	
	function HomeControl()
	{
	}
	
	HomeControl.prototype = new GControl();
	
	HomeControl.prototype.initialize = function(map)
	{
		var container = document.createElement("div");
		var homeDiv = document.createElement("div");
		this.setButtonStyle_(homeDiv);
		container.appendChild(homeDiv);
	
		GEvent.addDomListener(homeDiv, "click", function()
		{
	//		GLog.write('home clicked');		
			map.setZoom(defaultZoomLevel);
			map.panTo(UKcentreCoords);
		});
		
		map.getContainer().appendChild(container);
		return container;
	}
	
	
	HomeControl.prototype.getDefaultPosition = function()
	{
		return new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(8, 8));
	}
	
	
	HomeControl.prototype.setButtonStyle_ = function(button)
	{
		var image = document.createElement("img");
		image.src = "/images/home-control.png";
		button.appendChild(image);
		
		button.style.backgroundColor = "#f1f1f1";
		button.style.border = "1px solid black";
		button.style.padding = "2px";
		button.style.marginBottom = "3px";
		button.style.textAlign = "center";
		button.style.cursor = "pointer";
	}
	
	initialisePage();
	}
});

window.addEvent('unload', function(){
	GUnload();
});
