/*!
 * summernote bootstrap css plugin
 * http://www.shaunfreeman.name/
 *
 * Released under the MIT license
 */
(function (factory) {
    /* global define */
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals: jQuery
        factory(window.jQuery);
    }
}(function ($) {

    // Extends plugins for adding bootstrap.
    //  - plugin is external module for customizing.
    $.extend($.summernote.plugins, {

        /**
         * @param {Object} context - context object has status of editor.
         */
        'bootstrap': function (context) {
            var self = this;

            // ui has renders to build ui elements.
            //  - you can create a button with `ui.button`
            var ui = $.summernote.ui;
            var dom = $.summernote.dom;
            var options = context.options;

            this.generateButton = function (tagList) {
                var returnArray = [];

                $.each(tagList, function (index, tag) {
                    returnArray[index] = ui.button({
                        contents: '<' + tag[0] + '>' + tag[0].charAt(0).toUpperCase() +'</' + tag[0] + '>',
                        tooltip: tag[1] + ' <' + tag[0] + '>',
                        className: 'note-text-tags-btn',
                        click: context.createInvokeHandler('bootstrap.formatInline', tag[0])
                    });
                });

                return returnArray;
            };

            context.memo('button.bootstrap-helper', function () {
                return ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<i class="fa fa-paint-brush"> B</i> ' + ui.icon(options.icons.caret, 'i'),
                        tooltip: "Bootstrap Text Styles",
                        data: {
                            toggle: 'dropdown'
                        },
                    }),
                    ui.dropdown({
                        className: 'dropdown-style scrollable-menu',
                        contents:
                        '<div class="list-group" style="margin: 0px; height: auto; max-height: 200px; min-width: 200px; max-width:300px; overflow-x: hidden;">' +
                        '<a href="#" data-trigger="styleBlock" class="list-group-item"><span class="lead">Lead</span></a>' +

                        '<a href="#" data-trigger="styleBlock" class="list-group-item"><span class="text-left">Left aligned text</span></a>' +
                        '<a href="#" data-trigger="styleBlock" class="list-group-item"><span class="text-center">Center aligned text</span></a>' +
                        '<a href="#" data-trigger="styleBlock" class="list-group-item"><span class="text-right">Right aligned text</span></a>' +
                        '<a href="#" data-trigger="styleBlock" class="list-group-item"><span class="text-justify">Justified text</span></a>' +
                        '<a href="#" data-trigger="styleBlock" class="list-group-item"><span class="text-nowrap">No wrap text</span></a>' +

                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="text-uppercase">Text Uppercased</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="text-lowercase">Text Lowercased</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="text-capitalize">Text Capitalized</span></a>' +

                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="text-muted">Text Muted</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="text-primary">Text Primary</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="text-success">Text Success</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="text-info">Text Info</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="text-warning">Text Warning</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="text-danger">Text Danager</span></a>' +

                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="bg-primary">Background Primary</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="bg-success">Background Success</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="bg-info">Background Info</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="bg-warning">Background Warning</span></a>' +
                        '<a href="#" data-trigger="formatSpan" class="list-group-item"><span class="bg-danger">Background Danager</span></a>' +
                        '</div>',
                        callback: function($dropdown) {
                            $dropdown.find('a').each(function () {
                                $(this).click(function (e) {
                                    e.preventDefault();
                                    var call = $(this).attr('data-trigger');
                                    var type =  $(this).children('span').attr('class');
                                    context.invoke('bootstrap.' + call, type);
                                });
                            });
                        }
                    })
                ]).render()
            });

            context.memo('button.bootstrap-inline', function () {
                return ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle bootstrap-inline',
                        contents: '<b><i class="fa fa-html5"> B</i></b> ' + ui.icon(options.icons.caret, 'i'),
                        tooltip: 'Bootstrap Inline Tags',
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown([
                        ui.buttonGroup({
                            className: 'note-bootstrap-inline',
                            children: self.generateButton([
                                ['del', 'Deleted text'],
                                ['ins', 'Inserted text'],
                                ['small', 'Small text'],
                                ['mark', 'Highlighted text']
                            ])
                        })
                    ])
                ]).render();
            });

            context.memo('button.bootstrap-code', function () {
                return ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle bootstrap-code',
                        contents: '<b><i class="fa fa-code"> B</i></b> ' + ui.icon(options.icons.caret, 'i'),
                        tooltip: 'Bootstrap Code Tags',
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown([
                        ui.buttonGroup({
                            className: 'note-bootstrap-code',
                            children: self.generateButton([
                                ['code', 'Inline code'],
                                ['kbd', 'User input'],
                                ['var', 'Variable'],
                                ['samp', 'Sample']
                            ])
                        })
                    ])
                ]).render();
            });

            context.memo('button.bootstrap-class-styles', function () {
                return ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle bootstrap-classes',
                        contents: '<b><i class="fa fa-css3"> B</i></b> ' + ui.icon(options.icons.caret, 'i'),
                        tooltip: 'Bootstrap Element Styles',
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        className: 'dropdown-style scrollable-menu',
                        contents:
                        '<div class="list-group" style="margin: 0; height: auto; max-height: 200px; min-width: 200px; max-width:300px; overflow-x: hidden;">' +
                        '<a href="#" data-trigger="styleBlock" class="list-group-item"><span class="pre-scrollable">Pre scrollable</span></a>' +
                        '<a href="#" data-trigger="styleBlockquote" class="list-group-item"><span class="blockquote-reverse">Blockquote reverse</span></a>' +
                        '<a href="#" data-trigger="styleImg" class="list-group-item"><span class="img-responsive">Image responsive</span></a>' +
                        '<a href="#" data-trigger="styleAlert" class="list-group-item"><span class="alert-success">Alert success</span></a>' +
                        '<a href="#" data-trigger="styleAlert" class="list-group-item"><span class="alert-info">Alert info</span></a>' +
                        '<a href="#" data-trigger="styleAlert" class="list-group-item"><span class="alert-warning">Alert warning</span></a>' +
                        '<a href="#" data-trigger="styleAlert" class="list-group-item"><span class="alert-danger">Alert danger</span></a>' +
                        '</div>',
                        callback: function($dropdown) {
                            $dropdown.find('a').each(function () {
                                $(this).click(function (e) {
                                    e.preventDefault();
                                    var call = $(this).attr('data-trigger');
                                    var type =  $(this).children('span').attr('class');
                                    context.invoke('bootstrap.' + call, type);
                                });
                            });
                        }
                    })
                ]).render();
            });

            this.styleAlert = function (classType) {
                var obj = this.getSelectionObject();

                if (obj.parentNode.parent().is('div.alert')) {
                    if (obj.parentNode.parent().is('div.' + classType)) {
                        obj.node.unwrap();
                    } else {
                        obj.parentNode.parent.attr('class', 'alert ' + classType);
                    }

                } else {
                    node = $('<div>').attr('class', 'alert ' + classType);
                    obj.parentNode.wrap(node[0]);
                }

                this.detach(obj);
            };

            this.styleBlockquote = function(classType) {
                var obj = this.getSelectionObject();

                if (obj.node.is('blockquote')) {
                    if (obj.node.hasClass(classType)) {
                        obj.node.removeClass(classType);
                    } else {
                        obj.node.addClass(classType);
                    }
                }

                this.detach(obj);
            };

            this.styleTarget = function(target, classType) {
                target = $(target);

                if (target.hasClass(classType)) {
                    target.removeClass(classType);
                } else {
                    target.addClass(classType);
                }

                context.invoke('editor.afterCommand');
            };

            this.styleImg = function(classType) {
                var target = context.invoke('editor.restoreTarget');

                if (dom.isImg(target)) {
                    this.styleTarget(target, classType);
                }
            };

            this.styleBlock = function (classType) {
                var obj = this.getSelectionObject();

                if (obj.parentNode.hasClass(classType)) {
                    obj.parentNode.removeClass(classType);
                } else {
                    obj.parentNode.addClass(classType);
                }

                this.detach(obj);
            };

            this.formatInline = function(tag) {
                var obj = this.getSelectionObject();

                if (obj.parentNode.is(tag)) {
                    obj.node.unwrap();
                } else {
                    if (obj.range.startOffset !== obj.range.endOffset) {
                        node = $('<' + tag + '>');
                        obj.range.surroundContents(node[0]);
                    }
                }

                this.detach(obj);
            };

            this.formatSpan = function(classType) {
                var obj = this.getSelectionObject();

                if (obj.parentNode.is('span')) {
                    if (obj.parentNode.is('span.' + classType)) {
                        obj.node.unwrap();
                    } else {
                        obj.parentNode.attr('class', classType);
                    }
                } else {
                    if (obj.range.startOffset !== obj.range.endOffset) {
                        var node = $('<span>').attr('class', classType);
                        obj.range.surroundContents(node[0]);
                    }
                }

                this.detach(obj);
            };

            this.initialize = function () {
                $('.note-bootstrap-inline').parent().addClass('bootstrap-tags-inline');
                $('.note-bootstrap-code').parent().addClass('bootstrap-tags-code');
            };

            this.getSelectionObject = function() {
                var selection = window.getSelection();
                var range = selection.getRangeAt(0);

                return {
                    selection : selection,
                    range : range,
                    parentNode : $(selection.focusNode.parentNode),
                    node : $(range.commonAncestorContainer)
                }
            };

            this.detach = function(obj) {
                obj.range.collapse(false);
                obj.range.detach();
                context.invoke('editor.afterCommand');
            };

            // This methods will be called when editor is destroyed by $('..').summernote('destroy');
            // You should remove elements on `initialize`.
            this.destroy = function () {
                //this.$panel.remove();
                //this.$panel = null;
            };
        }
    });
}));