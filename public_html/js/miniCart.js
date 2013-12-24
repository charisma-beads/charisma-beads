/* 
 * miniCart.js
 * 
 * Copyright (c) 2010 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 * 
 * This file is part of Charisma-Beads.
 * 
 * Charisma-Beads is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Charisma-Beads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Charisma-Beads.  If not, see <http ://www.gnu.org/licenses/>.
 */

var miniCart = new Class({

    Implements: [Options, Events, Chain],
    
    options: {
		cartWidth: 600,
		cartHeight: 435,
        cartElement: 'mini_cart',
        cartElementTop: 5,
        cartScrollEffect: false,
        containerEffects: {
            duration: 400,
            transition: 'sine:in',
            wait:false
        },
        cartButtons: '.cart_buttons',
        dragElements: '.item',
        checkoutClass: '.checkout',
        viewCartClass: '.view_cart',
        emptyCartClass: '.empty_cart',
        cartLinks: 'shopping_links',
        productList: 'productList',
        miniCartUrl: 'mini_cart.php',
        checkoutUrl: 'checkout.php'
    },

    initialize: function(options) {
        
        this.setOptions(options);
        this.checkout = this.options.checkoutUrl.toURI();

        this.drop = $(this.options.cartElement);
        this.setupEvents();

        this.miniCartContainer();
        this.setUpCartButtons();

        this.alertBox = new AscModal(null, null, {
            addCloseBtn: true
        });

        this.mask = new Mask($(document.body), {
            hideOnClick: true,
            onShow: function() {
                $('mini_cart_containter').setStyles({
                    'display': 'block',
                    'top': this.cartTop + 'px',
                    'left': this.cartLeft + 'px',
                    'opacity': '1'
                });
                this.request(this.options.miniCartUrl+'?action=view');
            }.bind(this),
            onHide: function() {
                $('mini_cart_containter').setStyles({
                    'display': 'none',
                    'opacity': '0'
                });
                this.cartContents.empty();
            }.bind(this)
        });

        document.body.addEvent('contextmenu',function(e) {
            e.stop();
        });
        
        window.addEvent('scroll', function(){
            this.miniCartScrollEffect();
        }.bind(this));
    },

    miniCartContainer: function() {

		this.container = new Element('div', {
			'id': 'mini_cart_containter'
		}).inject(document.body);

		imageSuffix = (Browser.ie6) ? 'gif' : 'png';
        
        this.closeButton = new Element('div').inject(this.container);

        this.closeImage = new Asset.image('/images/close.' + imageSuffix, {
			'id': 'miniCartClose',
			'title': 'Shop Tip',
            'rel' : 'Close Mini Cart',
			'class': 'Tips',
            'events': {
				'click': function() {
					this.hide();
				}.bind(this)
			}
		}).inject(this.closeButton);

		this.cartContents = new Element('div', {
			'id': 'mini_cart_contents'
		}).inject(this.container);

        this.cartControls = new Element('div', {
			'id': 'mini_cart_controls'
		}).inject(this.container);

		this.checkoutButton = new Element('div', {
			'class': 'button',
			'styles': {
				'display': 'inline'
			},
			'events': {
				'click': function(){
                    this.checkout.go();
                }.bind(this)
			}
		}).set('text', 'Check Out').inject(this.cartControls);

		this.emptyCartButton = new Element('div', {
			'class': 'button',
			'styles': {
				'display': 'inline'
			},
			'events': {
				'click': function(){
                    this.request(this.options.miniCartUrl+'?action=empty', this.cartContents);
                }.bind(this)
			}
		}).set('text', 'Empty Cart').inject(this.cartControls);

		this.updateCartButton = new Element('div', {
			'class': 'button',
			'styles': {
				'display': 'inline'
			},
			'events': {
				'click': function() {
                    var inputs = this.cartContents.getElements('input');
                    var items = $H({});
                    inputs.each(function(item){
                        var itemPid = item.get('name');
                        var itemQty = item.get('value');
                        items.set(itemPid, itemQty);
                    });
                    this.request(this.options.miniCartUrl+'?action=update', items.toQueryString());
				}.bind(this)
			}
		}).set('text', 'Update Cart').inject(this.cartControls);

		this.closeCartButton = new Element('div', {
			'class': 'button',
			'styles': {
				'display': 'inline'
			},
			'events': {
				'click': this.hide.bind(this)
			}
		}).set('text', 'Close Window').inject(this.cartControls);
	},

    setUpCartButtons: function() {
		$$('.view_cart').addEvent('click', function(event){
			event.stop();
			this.show();
		}.bind(this));
        
        $$('.empty_cart').addEvent('click', function(event){
			event.stop();
			this.request(this.options.miniCartUrl+'?action=empty');
		}.bind(this));
	},

    show: function() {
		// calculate middle of window
		this.cartTop = (window.getHeight()/2)-(this.options.cartHeight/2) + window.getScrollTop();
		this.cartLeft = (window.getWidth()/2)-(this.options.cartWidth/2);

        this.mask.show();
	},

    hide: function() {
        this.mask.hide();
    },

    request: function(url, data) {
        //JSON

        new Request.JSON({
            method: 'post',
            url: url,
            data: data,
            onSuccess: function(j) {
                switch(j.type) {
                    case 'add':
                        $('cart_drop').set('html', j.miniCart);
                        this.addItem(j);
                        break;
                    case 'view':
                        this.cartContents.set('html', j.cart);
                        break;
                    case 'empty':
                        $('cart_drop').set('html', j.miniCart);
                        this.cartContents.set('html', j.cart);
                        this.updateStock(j.stock);
                        break;
                    case 'update':
                        $('cart_drop').set('html', j.miniCart);
                        this.cartContents.set('html', j.cart);
                        this.updateStock(j.stock);
                        break;
                    case 'remove':
                        $('cart_drop').set('html', j.miniCart);
                        this.cartContents.set('html', j.cart);
                        this.updateStock(j.stock);
                        break;
                }
                this.setupTips();
                this.setupCartEvents();
			}.bind(this)
        }).send();
    },

    addItem: function(j) {
        if ($(this.options.cartLinks).getStyle('display') == 'none') {
            $(this.options.cartLinks).setStyle('display', '');
        }

        if (j.added == true) {
            this.alertBox.set_contents('You have added ' + j.stock.itemName + ' x 1 to your shopping cart.', 'i');
            this.alertBox.show();
            this.clearAddItemAlert.delay(3000, this);
        }
        
        this.updateStock(j.stock);
    },

    updateStock: function(stock) {
        switch(typeOf(stock)) {
            case 'object':
                if(stock.itemQty > -1) this.updateElement(stock);
                break;
            case 'array':
                stock.each(function(item){
                    if(item.itemQty > -1) this.updateElement(item);
                },this);
                break;
        }
    },

    updateElement: function(item) {
        if ($('pid'+item.itemPid+'Qty')) {
            if (item.itemQty == 0) {
                item.itemQty = 'Out Of Stock';
                $('pid'+item.itemPid).set('mask', {'class': 'productMask'});
                $('pid'+item.itemPid).mask();
            }
            if (item.itemQty > 0) $('pid'+item.itemPid).unmask();
            $('pid'+item.itemPid+'Qty').set("text", item.itemQty);
        }
    },

	clearAddItemAlert: function() {
		this.alertBox.hide();
	},

    getElementUrl: function(el) {
        url = el.get('href').toURI();
        return this.options.miniCartUrl + '?' + url.get('query');
    },

    setupCartEvents: function() {
        this.cartContents.addEvents({
            'click:relay(a.removeItem)': function(event, clicked){
                event.stop();
                this.cartContents.removeEvent('click:relay(a.removeItem)');
                this.tips.detach(this.tips.tip);
                this.request(this.getElementUrl(clicked));
            }.bind(this)
        });
    },

    setupEvents: function() {
        document.id(this.options.productList).addEvents({
            'click:relay(a.cart_buttons)': function(event, clicked) {
                event.stop();
                this.request(this.getElementUrl(clicked));
            }.bind(this),
            'mousedown:relay(img.item)': function(event, mousedown) {
                event.stop();
                this.dragDrop(event, mousedown);
            }.bind(this)
        });
    },

    dragDrop: function(event, mousedown) {
        this.coords = mousedown.getCoordinates();

        var itemClone = mousedown.clone()
            .setStyles(Object.merge(this.coords, {'opacity': 0.7, 'position': 'absolute'}))
            .inject(document.body);

        var drag = itemClone.makeDraggable({
            droppables: this.drop,

            onCancel: function(element){
                element.dispose();
            },

            onDrop: function(element, droppable){
                if (!droppable) {
                    var cloneFx = new Fx.Morph(element);
                    cloneFx.start(this.coords).chain(function(){
                        element.dispose();
                    });
                } else {
                    element.dispose();
                    var parentLink = mousedown.getParent();
                    if (parentLink){
                        this.request(this.getElementUrl(parentLink));
                    }
                    droppable.highlight('#7389ae', '#fffacd');
                }
            }.bind(this),

            onEnter: function(element, droppable){
                droppable.tween('background-color', '#98b5c1');
            },

            onLeave: function(element, droppable){
                droppable.tween('background-color', '#fffacd');
            }
        });

        drag.start(event);
    },

    setupTips: function() {
        this.tips = new Tips($$('.Tips'), {
            onShow: function(tip){ tip.fade('in'); },
            onHide: function(tip){ tip.fade('out'); },
            onDetach: function(tip){ tip.fade('out'); }
        });
    },

    removeEvents: function() {
        document.id(this.options.productList).removeEvents(
            'click:relay(a.cart_buttons)'
        );
        document.id(this.options.productList).removeEvents(
            'mousedown:relay(img.item)'
        );
    },

    miniCartScrollEffect: function() {
		var sTop = window.getScrollTop();

		if (typeOf(this.options.cartScrollEffect) == 'object') {
			var sMiniCart = new Fx.Tween($(this.options.cartElement), this.options.cartScrollEffect);
			sMiniCart.start('top', sTop + this.options.cartElementTop);
		} else {
			$(this.options.cartElement).setStyle('top', (sTop + this.options.cartElementTop) + 'px');
		}
	}
});

window.addEvent('domready', function(){
	if(document.id('productList') && !Browser.Platform.ios && !Browser.Platform.android && !Browser.Platform.webos) miniShop = new miniCart();
});
