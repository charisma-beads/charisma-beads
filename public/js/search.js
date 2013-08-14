// ============================================================
// = Search                                                   =
// ============================================================

function loadMessage() {
	document.body.style.cursor = "wait";
	$('loadingDivWrap').set('html', "<div id='loadingDiv' class='loading' style='width:450px'><img src='/admin/images/snake_transparent.gif'/>&nbsp;&nbsp;Please wait while I search the database for you.</div>");
	
	var wTop = (window.getHeight()/2)-($('loadingDivWrap').getCoordinates().height/2) + window.getScrollTop();
	var wLeft = (window.getWidth()/2)-($('loadingDivWrap').getCoordinates().width/2);
	
	$('loadingDivWrap').setStyles({
		'top':  wTop + 'px',
  		'left': wLeft + 'px'
	});
}

function searchComplete() {
	$('loadingDivWrap').set('html', "<div id='loadedDiv' class='loaded'>Search complete..</div>");
	
	var wTop = (window.getHeight()/2)-($('loadingDivWrap').getCoordinates().height/2) + window.getScrollTop();
	var wLeft = (window.getWidth()/2)-($('loadingDivWrap').getCoordinates().width/2);
	
	$('loadingDivWrap').setStyles({
		'top':  wTop + 'px',
  		'left': wLeft + 'px'
	});
			
	setTimeout('loadOut()',2000);
	
	if (!Browser.Platform.ios && !Browser.Platform.android && !Browser.Platform.webos) {
		searchTips = new Tips($$('.Tips'), {
			onShow: function(tip, el){ tip.fade('in'); },
			onHide: function(tip, el){ tip.fade('out'); }
		});
	}
}

function loadOut() {
	$('loadingDivWrap').empty();
	document.body.style.cursor = "default";
}


function productSearch(s, np, id, Query, searchtype) {
	
	var searchQuery = Query;
	var searchType = searchtype;
	var searchId = id;
	var startPage = s;
	var numberPages = np;
	
	if (startPage != null) {
		startPage = 's=' + startPage;
	} else {
		startPage = '';
	}
	
	if (numberPages != null) {
		numberPages = '&np=' + numberPages;
	} else {
		numberPages = '';
	}	
	
	if (searchId == null && numberPages == '' && startPage == '') {
		searchId = 'search_id=' + $('search_id').value;
	} else {
		searchId = '&search_id=' + searchId;
	}
	
	if (searchQuery == null) {
		searchQuery = '&search_query=' + escape($('search_query').value);
	} else {
		searchQuery = '&search_query=' + escape(searchQuery);
	}
	
	if (searchType) {
		searchType = '&search_type=' + searchtype;
	}
	
	var url = '/shop/product_search.php?' + startPage + numberPages + searchId + searchQuery + searchType;
	
	var request = new Request.HTML({
		method: 'post',
        url: url,
  		update: $('productList'),
  		evalScripts: true,
		onRequest: function() {
			loadMessage();
		},
  		onComplete: function() {
			searchComplete();
  		}
	}).send().chain(function(){
	
		if (!Browser.Platform.ios && !Browser.Platform.android && !Browser.Platform.webos) {
        	miniShop.removeEvents();
			miniShop.setupEvents();
		}
		
		var scroll = new Fx.Scroll(window, {
			duration: 1500,
   			transition: Fx.Transitions.Quad.easeInOut
		});
	
		scroll.toElement('productList');

        new Fx.SmoothScroll();
	});
}


window.addEvent('domready', function(){
	if ($('searchForm')) {
		$('searchForm').addEvent('submit', function(event) {
			event.stop();
			var query = $('searchQuery').get('value');
			var id = $('search_id').get('value');
			var searchtype;

			if ($('search_part').getProperty('checked')) {
				searchtype = 'part';
			} else if ($('search_exact').getProperty('checked')) {
				searchtype = 'exact';
			} else {
				searchtype = 'all';
			}
			
			productSearch(null,null,id,query,searchtype);
		});
	}
});
