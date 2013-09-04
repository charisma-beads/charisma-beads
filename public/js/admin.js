
var admin = {
	
};

$(document).ready(function(){

    $("body").on({
        ajaxStart: function() { 
            $(this).addClass("loading"); 
        },
        ajaxStop: function() {
        	$('button[type=submit]').button('reset');
        	$('input[placeholder], textarea[placeholder]').placeholder();
            $(this).removeClass("loading");
        }    
    });

    $('input[placeholder], textarea[placeholder]').placeholder();
    
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
});
