
$(document).ready(function(){
	
	$(document).on({
        ajaxStart: function() { 
            $('#content').addClass("loading"); 
        },
        ajaxStop: function() {
        	$('button[type=submit]').button('reset');
        	//$('input[placeholder], textarea[placeholder]').placeholder();
            $('#content').removeClass("loading");
            Holder.run();
        }    
    });
	
	if(jQuery('body').hasClass('boxed')) {
		backgroundImageSwitch();
	}
	
	function backgroundImageSwitch() {
		var data_background = jQuery('body').attr('data-background');
		if(data_background) {
			jQuery.backstretch(data_background);
			jQuery('body').addClass('transparent'); // remove background color of boxed class
		}
	}
    
    $('.siteTip').tooltip({'placement': 'top'});

    //$('input[placeholder], textarea[placeholder]').placeholder();
    
    $('button[type=submit]').click(function(){
        $(this).button('loading');
        $('input').focus(function(){
        	$(this).button('reset');
        }.bind(this));
    });
    
    $('#showPassword').click(function(){
		var change = $(this).is(":checked") ? "text" : "password";
		document.getElementById('password').type = change;
	});
    
    $('.new-window').click(function(event) {
        event.preventDefault();
        window.open($(this).attr("href"), "popupWindow", "width=800,height=600,scrollbars=yes");
    });
    
});