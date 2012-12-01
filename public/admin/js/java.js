function SwitchMenu(obj, Elem) {
	if(document.getElementById) {
		var el = document.getElementById(obj);
		var ar = document.getElementById(Elem).getElementsByTagName("DIV");
		
		if(el.style.display == "none") {
			for (var i=0; i<ar.length; i++) {
				if (ar[i].style.visibility="hidden") {
					ar[i].style.visibility="";
				}
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		} else {
			el.style.display = "none";
		}
	}
}
function ChangeClass(menu, newClass) { 
	 if (document.getElementById) { 
	 	document.getElementById(menu).className = newClass;
	 }
} 

function ShowTip(ToolTip, ToolTipWidth, ToolTipHeight) {
	if (document.getElementById) {
		ToolTipObj = document.getElementById('tt' + ToolTip);
		ToolTipBodyObj = document.getElementById('ttb' + ToolTip);
		
		if (document.all) {
				
			if (ToolTipObj.style.visibility="hidden") {
				ToolTipObj.style.visibility="";
				ToolTipObj.style.display="none";
			}
				
			x = ((document.body.clientWidth - ToolTipWidth)/2) + document.body.scrollLeft;
			y = ((document.body.clientHeight - (ToolTipHeight + 20))/2) + document.body.scrollTop;
			ToolTipBodyObj.style.width = ToolTipWidth;
			ToolTipBodyObj.style.height = ToolTipHeight;
			ToolTipObj.style.pixelTop = y;
			ToolTipObj.style.pixelLeft = x;
			ToolTipObj.style.filter="revealTrans(Duration=2,Transition=5)";
			ToolTipObj.filters.revealTrans.Apply();
			ToolTipObj.style.display="block";
			ToolTipObj.filters.revealTrans.Play();

			
		} else {
			x = ((window.innerWidth - ToolTipWidth)/2) + window.pageXOffset;
			y = ((window.innerHeight - (ToolTipHeight + 23))/2) + window.pageYOffset;
			ToolTipBodyObj.style.width = ToolTipWidth + "px";
			ToolTipBodyObj.style.height = ToolTipHeight + "px";
			ToolTipObj.style.width = ToolTipWidth + 16 + "px";
			ToolTipObj.style.height = ToolTipHeight + 30 + "px";
			ToolTipObj.style.top = y + "px";
			ToolTipObj.style.left = x + "px";
			ToolTipObj.style.display="block";
		} 
		
	}
	
}

function HideTip(ToolTip) {
	if (document.getElementById) {
		ToolTipObj = document.getElementById("tt" + ToolTip);
	} 
	
	if (document.all) {
		ToolTipObj.style.filter="revealTrans(Duration=2,Transition=4)";
		ToolTipObj.filters.revealTrans.Apply();
		ToolTipObj.style.visibility="hidden";
		ToolTipObj.filters.revealTrans.Play();
	} else {
		ToolTipObj.style.display="none";
	}
} 

function show(which){
	if (!document.getElementById) {
		return;
	}
	if (which.style.display=="none") {
		which.style.display="";
	}
} 

function hide(which){
	if (!document.getElementById) {
		return;
	}
	if (which.style.display=="") {
		which.style.display="none";
	}
} 

function NewWindow(page,pagename,w,h,scroll) {
	if (w == null) {
		w = screen.width - 50;
	}
	if (h == null) {
		h = screen.height - 100;
	}
	
	var winl = (screen.width-w)/2;
  	var wint = (screen.height-h)/2;
  	var settings  ='height='+h+',';
    settings +='width='+w+',';
    settings +='top='+wint+',';
    settings +='left='+winl+',';
    settings +='scrollbars='+scroll+',';
    settings +='resizable=no';
	settings +='location=no';
	settings +='toolbars=no';
	settings +='directories=no';
	settings +='status=no';
	settings +='menubar=no';
	settings +='copyhistory=no';
	 
  	win=window.open(page,pagename,settings);
  	if(parseInt(navigator.appVersion) >= 4) {
  		win.window.focus();
	}
}

function pageLoaded(){
	$('loading').setStyle('display', 'none');
}

window.addEvent('load', function(){
	setTimeout('pageLoaded()',1000);
	
});