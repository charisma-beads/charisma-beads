
var adminClass = {
    basePath : '/',
    
    addAlert : function(message, type)
    {
        $('#alerts').append(
            '<div class="alert alert-' + type + ' fade in">' +
            '<button type="button" class="close" data-dismiss="alert">' +
            '&times;</button>' + message + '</div>'
        );
        $(".alert").alert();
        setTimeout('$(".alert").alert("close")',5000);
    },

    ajaxModalForm : function(el, url)
    {
        response = $.ajax({
            url: url,
            data:  $(el).find('form').serialize(),
            type: 'POST',
            success: function (response) {
                if ($.isPlainObject(response)) {
                    adminClass.addAlert(response.messages, response.status);
                    $(el).modal('hide');
                    return response;
                } else {
                    $(el).find('.modal-body').html(response);
                }
            },
            error: function (response) {
                adminClass.addAlert(response.error, 'danger');
                $(el).modal('hide');
            }
        });

        return response;
    },

    ajaxWidgetPanel : function(el, url, data)
    {
        $(el).load(url, data, function(responseText, textStatus) {
            if (textStatus == "error") {
                $(el).css('padding', '10px');
                $(el).html(responseText);
            }
        });
    },

    tinyMceFileBrowser : function(callback, value, meta, url, baseUrl) {
        var dialog = bootbox.dialog({
            title: "File Uploader",
            show: false,
            message: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Loading',
            buttons: {
                main: {
                    label: "Close",
                    className: "btn-default"
                }
            }
        });
        dialog.css('z-index', '1000000');
        dialog.on('show.bs.modal', function () {
            $(this).find('.modal-body').load(url);
        });
        dialog.on('hide.bs.modal', function (e) {
            $(this).find('.modal-body').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;Loading');

            if (adminClass.upload && adminClass.upload.status) {
                var imagePath = baseUrl;
                // Provide file and text for the link dialog
                /*if (meta.filetype == 'file') {
                 callback(admin.upload.image.name);
                 }*/

                // Provide image and alt text for the image dialog
                if (meta.filetype == 'image') {
                    callback(imagePath + adminClass.upload.image.name);
                }

                // Provide alternative source and posted for the media dialog
                /*if (meta.filetype == 'media') {
                 callback(admin.upload.image.name);
                 }*/
            }
        });
        dialog.modal('show');
    }
};

$(document).ready(function(){

    //Form Submit for IE Browser
    $('button[type=\'submit\']').on('click', function() {
        $("form[id*='form-']").submit();
    });

    // Highlight any found errors
    $('.text-danger').each(function() {
        var element = $(this).parent().parent();

        if (element.hasClass('form-group')) {
            element.addClass('has-error');
        }
    });

    // Set last page opened on the menu
    $('.menu a[href]').on('click', function() {
        sessionStorage.setItem('menu', $(this).attr('href'));
    });

    if (!sessionStorage.getItem('menu')) {
        $('.menu #dashboard').addClass('active');
    } else {
        // Sets active and open to selected page in the left column menu.
        $('.menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active open');
    }

    if (localStorage.getItem('column-left') == 'active') {
        $('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

        $('#column-left').addClass('active');

        // Slide Down Menu
        $('.menu li.active').has('ul').children('ul').addClass('collapse in');
        $('.menu li').not('.active').has('ul').children('ul').addClass('collapse');
    } else {
        $('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

        $('.menu li li.active').has('ul').children('ul').addClass('collapse in');
        $('.menu li li').not('.active').has('ul').children('ul').addClass('collapse');
    }

    // Menu button
    $('#button-menu').on('click', function() {
        // Checks if the left column is active or not.
        if ($('#column-left').hasClass('active')) {
            localStorage.setItem('column-left', '');

            $('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

            $('#column-left').removeClass('active');

            $('.menu > li > ul').removeClass('in collapse');
            $('.menu > li > ul').removeAttr('style');
        } else {
            localStorage.setItem('column-left', 'active');

            $('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

            $('#column-left').addClass('active');

            // Add the slide down to open menu items
            $('.menu li.open').has('ul').children('ul').addClass('collapse in');
            $('.menu li').not('.open').has('ul').children('ul').addClass('collapse');
        }
    });

    // Menu
    $('.menu').find('li').has('ul').children('a').on('click', function() {
        if ($('#column-left').hasClass('active')) {
            $(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
            $(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
        } else if (!$(this).parent().parent().is('#menu')) {
            $(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
            $(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
        }
    });

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

    $('[data-toggle="tooltip"], .btn-tooltip').tooltip();
});
