
window.addEvent('domready', function(){
    var ccHelpHeight = 400;
    var ccHelpWidth = 500;
    var ccHelpType = null;
    $$('.amexFields').setStyle('display', 'none');

    $('ccType').addEvent('change', function(){
        if (this.value == 'sm' || this.value == 's') {
            $$('.amexFields').setStyle('display', '');
        } else {
            $$('.amexFields').setStyle('display', 'none');
        }
    });
    
    var amex = $('ccType').get('value');
    
    if (amex == 'sm' || amex == 's') $$('.amexFields').setStyle('display', '');

    $$('.viewCCHelp').addEvent('click', function(event){
        event.stop();
        ccHelpType = this.rel;
        ccHelpMask.show();
    });

    $$('img.close').addEvent('click', function(){
        ccHelpMask.hide();
    });

    $$('input[name=billing]').addEvent('change', function(){
        if (this.value == 'new') {
            $('ccNewBillingAddress').setStyle('display', '');
        } else {
            $('ccNewBillingAddress').setStyle('display', 'none');
        }
    });
    
    if ($('billing-new').getProperty('checked')) $('ccNewBillingAddress').setStyle('display', '');

    var ccHelpMask = new Mask($(document.body), {
        hideOnClick: true,
        onShow: function() {
            var ccHelpTop = (window.getHeight()/2)-(ccHelpHeight/2) + window.getScrollTop();
            var ccHelpLeft = (window.getWidth()/2)-(ccHelpWidth/2);

            $(ccHelpType).setStyles({
                'position': 'absolute',
                'display': 'block',
                'top': ccHelpTop + 'px',
                'left': ccHelpLeft + 'px',
                'width': ccHelpWidth + 'px',
                'height': ccHelpHeight + 'px',
                'opacity': '1'
            });

        },
        onHide: function() {
            $(ccHelpType).setStyles({
                'display': 'none',
                'opacity': '0'
            });
        }
    });
});

