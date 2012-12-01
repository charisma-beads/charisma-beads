function tinyBrowser (field_name, url, type, win) {

	var cmsURL = "/admin/includes/tinymce/jscripts/tiny_mce/plugins/tinybrowser/tinybrowser.php";
	if (cmsURL.indexOf("?") < 0) {
		cmsURL = cmsURL + "?type=" + type;
	} else {
		cmsURL = cmsURL + "&type=" + type;
	}

	tinyMCE.activeEditor.windowManager.open(
 		{
			file : cmsURL,
 			title : "My File Browser",
			width : 700, 
			height : 450,
			resizable : "yes",
			scrollbars : "yes",
			inline : "yes",
			close_previous : "no"
		},
		{
			window : win,
			input : field_name
		}
	);
 	return false;
}

tinyMCE.init({
			
	mode : "textareas",
	theme : "advanced",
	relative_urls : false,
 	remove_script_host : false,
 	document_base_url : "http://www.charismabeads.co.uk/",
	file_browser_callback : "tinyBrowser",
	force_br_newlines : true,
	width: '100%',
	height: '400',

	plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
 
	// Theme options
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak"

});
