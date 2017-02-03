/*!
 * ApiGen 3.0dev - API documentation generator for PHP 5.3+
 *
 * Copyright (c) 2010-2011 David Grudl (http://davidgrudl.com)
 * Copyright (c) 2011-2012 Jaroslav Hanslík (https://github.com/kukulich)
 * Copyright (c) 2011-2012 Ondřej Nešpor (https://github.com/Andrewsville)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

$(function() {
    var $win = $(window);
    var $body = $('body');
    var $document = $(document);
    var $left = $('#left');
    var $right = $('#right');
    var $rightInner = $('#rightInner');
    var $groups = $('#groups');
    var $content = $('#content');

    // Hide deep packages and namespaces
    $('ul span', $groups).click(function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(this)
            .toggleClass('collapsed')
            .parent()
            .next('ul')
            .toggleClass('collapsed');
    }).click();

    $active = $('ul li.active', $groups);
    if ($active.length > 0) {
        // Open active
        $('> a > span', $active).click();
    } else {
        $main = $('> ul > li.main', $groups);
        if ($main.length > 0) {
            // Open first level of the main project
            $('> a > span', $main).click();
        } else {
            // Open first level of all
            $('> ul > li > a > span', $groups).click();
        }
    }

    /* Validate function */
    function validate(data, def) {
        return (data !== undefined) ? data : def;
    }

    // Window width without scrollbar
    $windowWidth = $win.width(),

        // Media Query fix (outerWidth -- scrollbar)
        // Media queries width include the scrollbar
        mqWidth = $win.outerWidth(true, true),

        // Detect Mobile Devices
        isMobileDevice = (( navigator.userAgent.match(/Android|webOS|iPhone|iPad|iPod|BlackBerry|Windows Phone|IEMobile|Opera Mini|Mobi/i) || (mqWidth < 767) ) ? true : false );

    // detect IE browsers
    var ie = (function(){
        var rv = 0,
            ua = window.navigator.userAgent,
            msie = ua.indexOf('MSIE '),
            trident = ua.indexOf('Trident/');

        if (msie > 0) {
            // IE 10 or older => return version number
            rv = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
        } else if (trident > 0) {
            // IE 11 (or newer) => return version number
            var rvNum = ua.indexOf('rv:');
            rv = parseInt(ua.substring(rvNum + 3, ua.indexOf('.', rvNum)), 10);
        }

        return ((rv > 0) ? rv : 0);
    }());

    // Responsive Menus
    $('#modal').on('show.bs.modal', function (event) {
        var modal = $(this);
        var button = $(event.relatedTarget);
        var id = button.attr('id');
        var contents, title;
        if (id == 'btn-menu') {
            title = 'Menu';
            contents = $('#cake-nav').html();
        }
        if (id == 'btn-nav') {
            title = 'Navigation';
            contents = $('#nav-cook').html();
        }
        if (id == 'btn-toc') {
            title = 'Class Navigation';
            contents = $('#class-nav').html();
        }

        modal.find('.modal-body').html(contents);
        modal.find('.modal-title-cookbook').text(title);

        // Bind click events for sub menus.
        modal.find('li').on('click', function() {
            var el = $(this),
                menu = el.find('.submenu, .megamenu');
            // No menu, bail
            if (menu.length == 0) {
                return;
            }
            menu.toggle();
            return false;
        });
    });

    /* ********************* Megamenu ********************* */
    var menu = $(".menu"),
        Megamenu = {
            desktopMenu: function() {

                menu.children("li").show(0);

                // Mobile touch for tablets > 768px
                if (isMobileDevice) {
                    menu.on("click touchstart","a", function(e){
                        if ($(this).attr('href') === '#') {
                            e.preventDefault();
                            e.stopPropagation();
                        }

                        var $this = $(this),
                            $sub = $this.siblings(".submenu, .megamenu");

                        $this.parent("li").siblings("li").find(".submenu, .megamenu").stop(true, true).fadeOut(300);

                        if ($sub.css("display") === "none") {
                            $sub.stop(true, true).fadeIn(300);
                        } else {
                            $sub.stop(true, true).fadeOut(300);
                            $this.siblings(".submenu").find(".submenu").stop(true, true).fadeOut(300);
                        }
                    });

                    $(document).on("click.menu touchstart.menu", function(e){
                        if ($(e.target).closest(menu).length === 0) {
                            menu.find(".submenu, .megamenu").fadeOut(300);
                        }
                    });

                    // Desktop hover effect
                } else {
                    menu.find('li').on({
                        "mouseenter": function() {
                            $(this).children(".submenu, .megamenu").stop(true, true).fadeIn(300);
                        },
                        "mouseleave": function() {
                            $(this).children(".submenu, .megamenu").stop(true, true).fadeOut(300);
                        }
                    });
                }
            },

            mobileMenu: function() {
                var children = menu.children("li"),
                    toggle = menu.children("li.toggle-menu");

                toggle.show(0).on("click", function(){

                    if ($children.is(":hidden")){
                        children.slideDown(300);
                    } else {
                        toggle.show(0);
                    }
                });

                // Click (touch) effect
                menu.find("li").not(".toggle-menu").each(function(){
                    var el = $(this);
                    if (el.children(".submenu, .megamenu").length) {
                        el.children("a").on("click", function(e){
                            if ($(this).attr('href') === '#') {
                                e.preventDefault();
                                e.stopPropagation();
                            }

                            var $sub = $(this).siblings(".submenu, .megamenu");

                            if ($sub.hasClass("open")) {
                                $sub.slideUp(300).removeClass("open");
                            } else {
                                $sub.slideDown(300).addClass("open");
                            }
                        });
                    }
                });
            },
            unbindEvents: function() {
                menu.find("li, a").off();
                $(document).off("click.menu touchstart.menu");
                menu.find(".submenu, .megamenu").hide(0);
            }
        }; // END Megamenu object

    if ($windowWidth < 768) {
        Megamenu.mobileMenu();
    } else {
        Megamenu.desktopMenu();
    }

    /* **************** Hide header on scroll down *************** */
    (function() {
        // Hide Header on on scroll down
        var didScroll;
        var lastScrollTop = 0;
        var delta = 5;
        var navbarHeight = $('header').outerHeight();

        $win.scroll(function(event){
            didScroll = true;
        });

        // Debounce the header toggling to ever 250ms
        var toggleHeader = function() {
            if (didScroll) {
                hasScrolled();
                didScroll = false;
            }
            setTimeout(toggleHeader, 250);
        };
        setTimeout(toggleHeader, 250);

        function hasScrolled() {
            var st = $win.scrollTop();

            // Make sure they scroll more than delta
            if (Math.abs(lastScrollTop - st) <= delta) {
                return;
            }

            // If they scrolled down and are past the navbar, add class .nav-up.
            // This is necessary so you never see what is "behind" the navbar.
            if (st > lastScrollTop && st > navbarHeight){
                // Scroll Down
                $('header').removeClass('nav-down').addClass('nav-up');
                // Scroll Up
            } else if (st + $(window).height() < $(document).height()) {
                $('header').removeClass('nav-up').addClass('nav-down');
            }
            lastScrollTop = st;
        }

        // If we're directly linking to a section, hide the nav.
        if (window.location.hash.length) {
            $('header').addClass('nav-up');
        }
    }());

    // Footer Tooltips
    $("[data-toggle='tooltip']").tooltip();

    // Search autocompletion
    var autocompleteFound = false;
    var autocompleteFiles = {'c': 'class', 'co': 'constant', 'f': 'function', 'm': 'class', 'mm': 'class', 'p': 'class', 'mp': 'class', 'cc': 'class'};

    var $search = $('.search input[name=q]');
    $search
        .autocomplete(ApiGen.elements, {
            matchContains: true,
            scrollHeight: 200,
            max: 20,
            formatItem: function(data) {
                return '<span>' + data[1].replace(/^(.+\\)(.+)$/, '<small>$1</small>$2') + '</span>';
            },
            formatMatch: function(data) {
                return data[1];
            },
            formatResult: function(data) {
                return data[1];
            },
            show: function(list) {
                var listWidth = list.width();
                var items = $('li span', list);
                var listLeft = parseInt(list.css('left'), 10);
                var maxWidth = Math.max.apply(null, items.map(function() {
                    return $(this).width();
                }));
                // Make the results wider, and shift left to accomodate new width.
                list
                    .width(Math.max(maxWidth, $search.innerWidth()))
                    .css('left', listLeft - Math.max(0, maxWidth - listWidth));
            }
        }).result(function(event, data) {
        autocompleteFound = true;
        var location = window.location.href.split('/');
        location.pop();
        var parts = data[1].split(/::|$/);
        var file = $.sprintf(ApiGen.config.templates[autocompleteFiles[data[0]]].filename, parts[0].replace(/\(\)/, '').replace(/[^\w]/g, '.'));
        if (parts[1]) {
            file += '#' + ('mm' === data[0] || 'mp' === data[0] ? 'm' : '') + parts[1].replace(/([\w]+)\(\)/, '_$1');
        }
        location.push(file);
        window.location = location.join('/');

        // Workaround for Opera bug
        $(this).closest('form').attr('action', location.join('/'));
    }).closest('form')
        .submit(function() {
            var query = $search.val();
            if ('' === query) {
                return false;
            }

            var label = $('#search input[name=more]').val();
            if (!autocompleteFound && label && -1 === query.indexOf('more:')) {
                $search.val(query + ' more:' + label);
            }

            return !autocompleteFound && '' !== $('#search input[name=cx]').val();
        });

    // Open details
    if (ApiGen.config.options.elementDetailsCollapsed) {
        $('tr', $content).filter(':has(.detailed)')
            .click(function() {
                var $this = $(this);
                $('.short', $this).hide();
                $('.detailed', $this).show();
            });
    }

    // Select selected lines
    var matches = window.location.hash.substr(1).match(/^\d+(?:-\d+)?(?:,\d+(?:-\d+)?)*$/);
    if (null !== matches) {
        var lists = matches[0].split(',');
        for (var i = 0; i < lists.length; i++) {
            var lines = lists[i].split('-');
            lines[1] = lines[1] || lines[0];
            for (var j = lines[0]; j <= lines[1]; j++) {
                $('#' + j).addClass('selected');
            }
        }

        var scrollToLineNumber = function() {
            console.log('plop');
            var offset = 0;
            var $header = $('header');
            if ($header.length > 0) {
                offset = $header.height() + parseInt($header.css('top'));
            }

            var $firstLine = $('#' + parseInt(matches[0]));
            if ($firstLine.length > 0) {
                $(document).scrollTop($firstLine.offset().top - offset);
            }
        };
        scrollToLineNumber();
        setTimeout(scrollToLineNumber, 400);
    }

    // Save selected lines
    var lastLine;
    $('a.l').click(function(event) {
        event.preventDefault();

        var $selectedLine = $(this).parent();
        var selectedLine = parseInt($selectedLine.attr('id'));

        if (event.shiftKey) {
            if (lastLine) {
                for (var i = Math.min(selectedLine, lastLine); i <= Math.max(selectedLine, lastLine); i++) {
                    $('#' + i).addClass('selected');
                }
            } else {
                $selectedLine.addClass('selected');
            }
        } else if (event.ctrlKey) {
            $selectedLine.toggleClass('selected');
        } else {
            var $selected = $('.l.selected')
                .not($selectedLine)
                .removeClass('selected');
            if ($selected.length > 0) {
                $selectedLine.addClass('selected');
            } else {
                $selectedLine.toggleClass('selected');
            }
        }

        lastLine = $selectedLine.hasClass('selected') ? selectedLine : null;

        // Update hash
        var lines = $('.l.selected')
            .map(function() {
                return parseInt($(this).attr('id'));
            })
            .get()
            .sort(function(a, b) {
                return a - b;
            });

        var hash = [];
        var list = [];
        for (var j = 0; j < lines.length; j++) {
            if (0 === j && j + 1 === lines.length) {
                hash.push(lines[j]);
            } else if (0 === j) {
                list[0] = lines[j];
            } else if (lines[j - 1] + 1 !== lines[j] && j + 1 === lines.length) {
                hash.push(list.join('-'));
                hash.push(lines[j]);
            } else if (lines[j - 1] + 1 !== lines[j]) {
                hash.push(list.join('-'));
                list = [lines[j]];
            } else if (j + 1 === lines.length) {
                list[1] = lines[j];
                hash.push(list.join('-'));
            } else {
                list[1] = lines[j];
            }
        }

        window.location.hash = hash.join(',');
    });

    // Focus support for versions menu.
    var dropdown = $('.dropdown');
    dropdown.find('> a').on('focus', function () {
        dropdown.find('ul').show();
    });
    dropdown.find('a').last().on('blur', function () {
        dropdown.find('ul').css('display', '');
    });
});
