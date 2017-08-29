function findAddressBrazil(zipInput, idCityInput, cityInput, stateInput, addressInput, neighborhoodInput ){
    var request = $.ajax({
        url: "https://viacep.com.br/ws/" + zipInput.val().replace(/\D/g,'') + "/json/",
        method: "POST",
        dataType: "jsonp"
    });

    request.done(function( msg ) {
        idCityInput.val(msg.ibge);
        cityInput.val(msg.localidade);
        console.log(msg.uf);
        stateInput.val(msg.uf);
        addressInput.val(msg.logradouro);
        neighborhoodInput.val(msg.bairro);
    });

    request.fail(function( jqXHR, textStatus ) {
        cityInput.val('Falha na busca da cidade');
    });

}

function returnAddressBrazil(zip){
    var request = $.ajax({
        url: "https://viacep.com.br/ws/" + zip + "/json/",
        method: "POST",
        dataType: "jsonp"
    });


    var indexedAddress;

    request.done(function( msg ) {

        indexedAddress["cityCode"] = msg.ibge;
        indexedAddress["cityName"] = msg.localidade;
        indexedAddress["state"] = msg.uf;
        indexedAddress["address"] = logradouro;
        indexedAddress["neighborhood"] = msg.bairro;
    });

}


//TODO: Terminar essa função
function image_url(entity, id, photo,size, alternate)
{

    if(size == undefined){
        size = '';
    }else{
        size = '_size'  + size;
    }

    if(alternate == undefined){
        alternate = "generic.png";
    }

    if(photo == undefined || photo == "") return "/img/system/" + alternate;
    var splitted = photo.split('.');
    photo = '/uploads/' + entity + '/' +  id + '/' + splitted[0] + size + '.' + splitted[1];


    return photo;
/*
    $.ajax({
        url: photo,
        error: function(){
            return "/img/system/" + alternate;
        },
        success: function(){
            console.log(photo);
            return photo;
        }


    }); */
}


function insertion_sort(list){
    var size = list.length;

    for(var i = 1; i < size; i++){
        var pivot = list[i];
        var j = i;
        while (j > 0 && list[j - 1] > pivot){
            list[j] = list[j - 1];
            j = j - 1;
        }
        list[j] = pivot;
    }
    return list;
}


function php_to_javascript_date(php_date){
    var match = php_date.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
    var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);

    return date;
}

function mark_as_read(){
    $(".notification-menu .content").on('click',function(){
        $.ajax({
            url: "/exam/get-next-question",
            type: "POST",
            data: {
                'question': next,

                'from-result': from_result
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {

            }
        });
    });
}
// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.
$(function(){

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });


    if($(".colorpicker-box").length) $(".colorpicker-box").colorpicker();
    if ( $.isFunction($.fn.select2) ) {
        $(".select2").select2();
    }
    if ( $.isFunction($.fn.datepicker) ) {
        $(".datepicker").datepicker({format: 'dd/mm/yyyy'});
    }

    if ( $.isFunction($.fn.wysihtml5) ) {
        if (!$("#comments-content").length) {

            $(".textarea").wysihtml5({
                toolbar:{
                    html: true,
                },
                parserRules: {
                    tags: {
                        strong: {},
                        em: {},
                        table: {
                            check_attributes: {
                                width: "any",
                                style: "any",
                                colspan: "any",
                            }
                        },
                        td: {
                            check_attributes: {
                                width: "any",
                                style: "any",
                                colspan: "any",
                            }
                        },
                        tr: {
                            check_attributes: {
                                width: "any",
                                style: "any",
                                colspan: "any",
                            }
                        },
                        th: {
                            check_attributes: {
                                width: "any",
                                style: "any",
                                colspan: "any",
                            }
                        },
                        img:{
                            check_attributes: {
                                src: "src",
                            }
                        }
                    },
                },
            });
        }
    }


    setRandom();

    $(".title-has-slug").blur(function(){
        var slug = convertToSlug(this.value);
        $(".slug-from-title").val(slug);
    });
    if ( $.isFunction($.fn.select2) ) {
        $(".selectCity").select2({
            ajax: {
                url: "/admin/cities/select/",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data.results
                    };
                },
                cache: false
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 3,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
    }
    function formatRepo (repo) {
        if (repo.loading) return repo.text;
        var markup = '<div class="clearfix">' +repo.name + '</div>' ;
        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.name;
    }





    if ( $.isFunction($.fn.select2) ) {
        $('.tags-select').select2({
            tags: true,
            minimumInputLength: 3,
            ajax: {
                type: 'POST',
                url: '/admin/tags/select',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {results: data};
                }
            }
        });

        createSelect('courses');
        createSelect('students');
        createSelect('users', '/admin/access/users/select');
    }



    $(".zip").on('blur', function (e) {
        findAddressBrazil($("#zip"), $("#city_id"), $("#city"), $("#state"), $("#address"),  $("#neighborhood"));
    });

    $(".zip").parent().parent().one('mouseover',function(){
        findAddressBrazil($("#zip"), $("#city_id"), $("#city"), $("#state"), $("#address"),  $("#neighborhood"));
    });


    $(".testCoupon").on('click', function (e) {
        if ($("#coupon_code").val() != ''){
            alert('Confirme o cupom de descontos informado antes de finalizar a compra. Para isso, clique em Ok.');
            return false;
        }
    });

    // Relativo a tabs
    //-----------------------------------------------------------------------------------------------------

    if($("#module-table").length) createModuleTable();

    /*
     Allows you to add data-method="METHOD to links to automatically inject a form with the method on click
     Example: <a href="{{route('customers.destroy', $customer->id)}}" data-method="delete" name="delete_item">Delete</a>
     Injects a form with that's fired on click of the link with a DELETE request.
     Good because you don't have to dirty your HTML with delete forms everywhere.
     */

    $(".cel").inputmask("(99) 999999999");
    $(".personal_id").inputmask("999.999.999-99");
    $(".company_id").inputmask("99.999.999/9999-99");
    $(".birthdate").inputmask("99/99/9999");
    $(".datemask").inputmask("99/99/9999");
    $(".zip").inputmask("99.999-999");
    $(".money").maskMoney({thousands:'.', decimal:',', affixesStay: false, allowZero: true});
    //$(".time").maskMoney({thousands:'',decimal:',',affixesStay: false, allowZero: true});
    $('[data-method]').append(function()
    {

        return "\n"+
            "<form action='"+$(this).attr('href')+"' method='POST' name='delete_item' style='display:none'>\n"+
            "   <input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
            "   <input type='hidden' name='_token' value='"+$('meta[name="_token"]').attr('content')+"'>\n"+
            "</form>\n"
    })
        .removeAttr('href')
        .attr('style','cursor:pointer;')
        .attr('onclick','$(this).find("form").submit();');

    /*
     Generic are you sure dialog
     */
    $('form[name=delete_item]').submit(function(){
        return confirm("Tem certeza que deseja excluir esse item?");
    });

    /*
     Bind all bootstrap tooltips
     */
    $("[data-toggle=\"tooltip\"]").tooltip();
    $("[data-toggle=\"popover\"]").popover();
    //This closes the popover when its clicked away from
    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
});

function convertToSlug(str)
{
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
    var to   = "aaaaaeeeeeiiiiooooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
}



//Função geradoras de select2. O primeiro parâmetro pode ser tanto um nome quanto um seletor do campo no qual aplicará o jquery.
//Caso um nome seja passado em selector, ele assumirá que o campo alvo possui a classe  nome-select
//Opcionalmente, uma rota pode ser passada
function createSelect(selector,route){
    var target_route;
    if(route == undefined){
        target_route = '/admin/' + selector + '/select';
    }else{
        target_route = route;
    }

    var $select_selector;

    if(selector instanceof jQuery){
        $select_selector = selector;

    }else{
        $select_selector = $('.' + selector + '-select');
    }


    $select_selector.select2({
        minimumInputLength: 3,
        ajax: {
            type: 'POST',
            url: target_route,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: function(params) {
                return {
                    term: params.term
                };
            },
            processResults: function(data) {
                return { results: data };
            }
        }
    });
}



function generateUUID() {
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
    });
    return uuid;
};


function setRandom(){
    $('#random_code').on('click',function(){
        $('[name="code"]').val(generateUUID());
    });
}


/*! AdminLTE app.js
 * ================
 * Main JS application file for AdminLTE v2. This file
 * should be included in all pages. It controls some layout
 * options and implements exclusive AdminLTE plugins.
 *
 * @Author  Almsaeed Studio
 * @Support <http://www.almsaeedstudio.com>
 * @Email   <support@almsaeedstudio.com>
 * @version 2.0.5
 * @license MIT <http://opensource.org/licenses/MIT>
 */

'use strict';

//Make sure jQuery has been loaded before app.js
if (typeof jQuery === "undefined") {
    throw new Error("AdminLTE requires jQuery");
}

/* AdminLTE
 *
 * @type Object
 * @description $.AdminLTE is the main object for the template's app.
 *              It's used for implementing functions and options related
 *              to the template. Keeping everything wrapped in an object
 *              prevents conflict with other plugins and is a better
 *              way to organize our code.
 */
$.AdminLTE = {};

/* --------------------
 * - AdminLTE Options -
 * --------------------
 * Modify these options to suit your implementation
 */
$.AdminLTE.options = {
    //Add slimscroll to navbar menus
    //This requires you to load the slimscroll plugin
    //in every page before app.js
    navbarMenuSlimscroll: true,
    navbarMenuSlimscrollWidth: "3px", //The width of the scroll bar
    navbarMenuHeight: "200px", //The height of the inner menu
    //Sidebar push menu toggle button selector
    sidebarToggleSelector: "[data-toggle='offcanvas']",
    //Activate sidebar push menu
    sidebarPushMenu: true,
    //Activate sidebar slimscroll if the fixed layout is set (requires SlimScroll Plugin)
    sidebarSlimScroll: true,
    //BoxRefresh Plugin
    enableBoxRefresh: true,
    //Bootstrap.js tooltip
    enableBSToppltip: true,
    BSTooltipSelector: "[data-toggle='tooltip']",
    //Enable Fast Click. Fastclick.js creates a more
    //native touch experience with touch devices. If you
    //choose to enable the plugin, make sure you load the script
    //before AdminLTE's app.js
    enableFastclick: true,
    //Box Widget Plugin. Enable this plugin
    //to allow boxes to be collapsed and/or removed
    enableBoxWidget: true,
    //Box Widget plugin options
    boxWidgetOptions: {
        boxWidgetIcons: {
            //The icon that triggers the collapse event
            collapse: 'fa fa-minus',
            //The icon that trigger the opening event
            open: 'fa fa-plus',
            //The icon that triggers the removing event
            remove: 'fa fa-times'
        },
        boxWidgetSelectors: {
            //Remove button selector
            remove: '[data-widget="remove"]',
            //Collapse button selector
            collapse: '[data-widget="collapse"]'
        }
    },
    //Direct Chat plugin options
    directChat: {
        //Enable direct chat by default
        enable: true,
        //The button to open and close the chat contacts pane
        contactToggleSelector: '[data-widget="chat-pane-toggle"]'
    },
    //Define the set of colors to use globally around the website
    colors: {
        lightBlue: "#3c8dbc",
        red: "#f56954",
        green: "#00a65a",
        aqua: "#00c0ef",
        yellow: "#f39c12",
        blue: "#0073b7",
        navy: "#001F3F",
        teal: "#39CCCC",
        olive: "#3D9970",
        lime: "#01FF70",
        orange: "#FF851B",
        fuchsia: "#F012BE",
        purple: "#8E24AA",
        maroon: "#D81B60",
        black: "#222222",
        gray: "#d2d6de"
    },
    //The standard screen sizes that bootstrap uses.
    //If you change these in the variables.less file, change
    //them here too.
    screenSizes: {
        xs: 480,
        sm: 768,
        md: 992,
        lg: 1200
    }
};

/* ------------------
 * - Implementation -
 * ------------------
 * The next block of code implements AdminLTE's
 * functions and plugins as specified by the
 * options above.
 */
$(function () {
    //Easy access to options
    var o = $.AdminLTE.options;

    //Set up the object
    _init();

    //Activate the layout maker
    $.AdminLTE.layout.activate();

    //Enable sidebar tree view controls
    $.AdminLTE.tree('.sidebar');

    //Add slimscroll to navbar dropdown
    if (o.navbarMenuSlimscroll && typeof $.fn.slimscroll != 'undefined') {
        $(".navbar .menu").slimscroll({
            height: "200px",
            alwaysVisible: false,
            size: "3px"
        }).css("width", "100%");
    }

    //Activate sidebar push menu
    if (o.sidebarPushMenu) {
        $.AdminLTE.pushMenu(o.sidebarToggleSelector);
    }

    //Activate Bootstrap tooltip
    if (o.enableBSToppltip) {
        $(o.BSTooltipSelector).tooltip();
    }

    //Activate box widget
    if (o.enableBoxWidget) {
        $.AdminLTE.boxWidget.activate();
    }

    //Activate fast click
    if (o.enableFastclick && typeof FastClick != 'undefined') {
        FastClick.attach(document.body);
    }

    //Activate direct chat widget
    if (o.directChat.enable) {
        $(o.directChat.contactToggleSelector).click(function () {
            var box = $(this).parents('.direct-chat').first();
            box.toggleClass('direct-chat-contacts-open');
        });
    }

    /*
     * INITIALIZE BUTTON TOGGLE
     * ------------------------
     */
    $('.btn-group[data-toggle="btn-toggle"]').each(function () {
        var group = $(this);
        $(this).find(".btn").click(function (e) {
            group.find(".btn.active").removeClass("active");
            $(this).addClass("active");
            e.preventDefault();
        });

    });
});

/* ----------------------------------
 * - Initialize the AdminLTE Object -
 * ----------------------------------
 * All AdminLTE functions are implemented below.
 */
function _init() {

    /* Layout
     * ======
     * Fixes the layout height in case min-height fails.
     *
     * @type Object
     * @usage $.AdminLTE.layout.activate()
     *        $.AdminLTE.layout.fix()
     *        $.AdminLTE.layout.fixSidebar()
     */
    $.AdminLTE.layout = {
        activate: function () {
            var _this = this;
            _this.fix();
            _this.fixSidebar();
            $(window, ".wrapper").resize(function () {
                _this.fix();
                _this.fixSidebar();
            });
        },
        fix: function () {
            //Get window height and the wrapper height
            var neg = $('.main-header').outerHeight() + $('.main-footer').outerHeight();
            var window_height = $(window).height();
            var sidebar_height = $(".sidebar").height();
            //Set the min-height of the content and sidebar based on the
            //the height of the document.
            if ($("body").hasClass("fixed")) {
                $(".content-wrapper, .right-side").css('min-height', window_height - $('.main-footer').outerHeight());
            } else {
                if (window_height >= sidebar_height) {
                    $(".content-wrapper, .right-side").css('min-height', window_height - neg);
                } else {
                    $(".content-wrapper, .right-side").css('min-height', sidebar_height);
                }
            }
        },
        fixSidebar: function () {
            //Make sure the body tag has the .fixed class
            if (!$("body").hasClass("fixed")) {
                if (typeof $.fn.slimScroll != 'undefined') {
                    $(".sidebar").slimScroll({destroy: true}).height("auto");
                }
                return;
            } else if (typeof $.fn.slimScroll == 'undefined' && console) {
                console.error("Error: the fixed layout requires the slimscroll plugin!");
            }
            //Enable slimscroll for fixed layout
            if ($.AdminLTE.options.sidebarSlimScroll) {
                if (typeof $.fn.slimScroll != 'undefined') {
                    //Distroy if it exists
                    $(".sidebar").slimScroll({destroy: true}).height("auto");
                    //Add slimscroll
                    $(".sidebar").slimscroll({
                        height: ($(window).height() - $(".main-header").height()) + "px",
                        color: "rgba(0,0,0,0.2)",
                        size: "3px"
                    });
                }
            }
        }
    };

    /* PushMenu()
     * ==========
     * Adds the push menu functionality to the sidebar.
     *
     * @type Function
     * @usage: $.AdminLTE.pushMenu("[data-toggle='offcanvas']")
     */
    $.AdminLTE.pushMenu = function (toggleBtn) {
        //Get the screen sizes
        var screenSizes = this.options.screenSizes;

        //Enable sidebar toggle
        $(toggleBtn).click(function (e) {
            e.preventDefault();

            //Enable sidebar push menu
            if ($(window).width() > (screenSizes.sm - 1)) {
                $("body").toggleClass('sidebar-collapse');
            }
            //Handle sidebar push menu for small screens
            else {
                if ($("body").hasClass('sidebar-open')) {
                    $("body").removeClass('sidebar-open');
                    $("body").removeClass('sidebar-collapse')
                } else {
                    $("body").addClass('sidebar-open');
                }
            }
        });

        $(".content-wrapper").click(function () {
            //Enable hide menu when clicking on the content-wrapper on small screens
            if ($(window).width() <= (screenSizes.sm - 1) && $("body").hasClass("sidebar-open")) {
                $("body").removeClass('sidebar-open');
            }
        });

    };

    /* Tree()
     * ======
     * Converts the sidebar into a multilevel
     * tree view menu.
     *
     * @type Function
     * @Usage: $.AdminLTE.tree('.sidebar')
     */
    $.AdminLTE.tree = function (menu) {
        var _this = this;

        $("li a", $(menu)).click(function (e) {
            //Get the clicked link and the next element
            var $this = $(this);
            var checkElement = $this.next();

            //Check if the next element is a menu and is visible
            if ((checkElement.is('.treeview-menu')) && (checkElement.is(':visible'))) {
                //Close the menu
                checkElement.slideUp('normal', function () {
                    checkElement.removeClass('menu-open');
                    //Fix the layout in case the sidebar stretches over the height of the window
                    //_this.layout.fix();
                });
                checkElement.parent("li").removeClass("active");
            }
            //If the menu is not visible
            else if ((checkElement.is('.treeview-menu')) && (!checkElement.is(':visible'))) {
                //Get the parent menu
                var parent = $this.parents('ul').first();
                //Close all open menus within the parent
                var ul = parent.find('ul:visible').slideUp('normal');
                //Remove the menu-open class from the parent
                ul.removeClass('menu-open');
                //Get the parent li
                var parent_li = $this.parent("li");

                //Open the target menu and add the menu-open class
                checkElement.slideDown('normal', function () {
                    //Add the class active to the parent li
                    checkElement.addClass('menu-open');
                    parent.find('li.active').removeClass('active');
                    parent_li.addClass('active');
                    //Fix the layout in case the sidebar stretches over the height of the window
                    _this.layout.fix();
                });
            }
            //if this isn't a link, prevent the page from being redirected
            if (checkElement.is('.treeview-menu')) {
                e.preventDefault();
            }
        });
    };

    /* BoxWidget
     * =========
     * BoxWidget is plugin to handle collapsing and
     * removing boxes from the screen.
     *
     * @type Object
     * @usage $.AdminLTE.boxWidget.activate()
     *        Set all of your option in the main $.AdminLTE.options object
     */
    $.AdminLTE.boxWidget = {
        activate: function () {
            var o = $.AdminLTE.options;
            var _this = this;
            //Listen for collapse event triggers
            $(o.boxWidgetOptions.boxWidgetSelectors.collapse).click(function (e) {
                e.preventDefault();
                _this.collapse($(this));
            });

            //Listen for remove event triggers
            $(o.boxWidgetOptions.boxWidgetSelectors.remove).click(function (e) {
                e.preventDefault();
                _this.remove($(this));
            });
        },
        collapse: function (element) {
            //Find the box parent
            var box = element.parents(".box").first();
            //Find the body and the footer
            var bf = box.find(".box-body, .box-footer");
            if (!box.hasClass("collapsed-box")) {
                //Convert minus into plus
                element.children(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
                bf.slideUp(300, function () {
                    box.addClass("collapsed-box");
                });
            } else {
                //Convert plus into minus
                element.children(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
                bf.slideDown(300, function () {
                    box.removeClass("collapsed-box");
                });
            }
        },
        remove: function (element) {
            //Find the box parent
            var box = element.parents(".box").first();
            box.slideUp();
        },
        options: $.AdminLTE.options.boxWidgetOptions
    };
}

/* ------------------
 * - Custom Plugins -
 * ------------------
 * All custom plugins are defined below.
 */

/*
 * BOX REFRESH BUTTON
 * ------------------
 * This is a custom plugin to use with the compenet BOX. It allows you to add
 * a refresh button to the box. It converts the box's state to a loading state.
 *
 * @type plugin
 * @usage $("#box-widget").boxRefresh( options );
 */
(function ($) {

    $.fn.boxRefresh = function (options) {

        // Render options
        var settings = $.extend({
            //Refressh button selector
            trigger: ".refresh-btn",
            //File source to be loaded (e.g: ajax/src.php)
            source: "",
            //Callbacks
            onLoadStart: function (box) {
            }, //Right after the button has been clicked
            onLoadDone: function (box) {
            } //When the source has been loaded

        }, options);

        //The overlay
        var overlay = $('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');

        return this.each(function () {
            //if a source is specified
            if (settings.source === "") {
                if (console) {
                    console.log("Please specify a source first - boxRefresh()");
                }
                return;
            }
            //the box
            var box = $(this);
            //the button
            var rBtn = box.find(settings.trigger).first();

            //On trigger click
            rBtn.click(function (e) {
                e.preventDefault();
                //Add loading overlay
                start(box);

                //Perform ajax call
                box.find(".box-body").load(settings.source, function () {
                    done(box);
                });
            });
        });

        function start(box) {
            //Add overlay and loading img
            box.append(overlay);

            settings.onLoadStart.call(box);
        }

        function done(box) {
            //Remove overlay and loading img
            box.find(overlay).remove();

            settings.onLoadDone.call(box);
        }

    };

})(jQuery);

/*
 * TODO LIST CUSTOM PLUGIN
 * -----------------------
 * This plugin depends on iCheck plugin for checkbox and radio inputs
 *
 * @type plugin
 * @usage $("#todo-widget").todolist( options );
 */
(function ($) {

    $.fn.todolist = function (options) {
        // Render options
        var settings = $.extend({
            //When the user checks the input
            onCheck: function (ele) {
            },
            //When the user unchecks the input
            onUncheck: function (ele) {
            }
        }, options);

        return this.each(function () {

            if (typeof $.fn.iCheck != 'undefined') {
                $('input', this).on('ifChecked', function (event) {
                    var ele = $(this).parents("li").first();
                    ele.toggleClass("done");
                    settings.onCheck.call(ele);
                });

                $('input', this).on('ifUnchecked', function (event) {
                    var ele = $(this).parents("li").first();
                    ele.toggleClass("done");
                    settings.onUncheck.call(ele);
                });
            } else {
                $('input', this).on('change', function (event) {
                    var ele = $(this).parents("li").first();
                    ele.toggleClass("done");
                    settings.onCheck.call(ele);
                });
            }
        });
    };
}(jQuery));

function modalGroupQuestionChangeSequence( group_question_id) {
    $("#group_question_id").val(group_question_id);
    $("#modalGroupQuestionChangeSequence").modal('toggle');
}



if($("#course").length > 0){
    add_course_teachers();
    $("#dynamic-flash").css("transition", "opacity 3s ease-in-out");
    $("#dynamic-flash").css("-moz-transition", "opacity 3s ease-in-out");
    $("#dynamic-flash").css("-webkit-transition", "opacity 3s ease-in-out");
    $("#dynamic-flash").css("-o-transition", "opacity 3s ease-in-out");
}



function add_course_teachers(){

    $(".remove-course-teacher").click(function(){

        $(this).parent().parent().css("display","none");
        $.ajax({
            type: "POST",
            url: "/admin/courses/remove-course-teacher",
            data: {
                "course": $("#course_id").val(),
                "teacher": $(this).parent().parent().find(".course-teachers-select").val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function(data){
                console.log($(this).parent().parent());
                $(this).parent().parent().remove();
                flash_success("Professor excluído com sucesso!");
            }

        });
    });




    $("#calculate-percentage-teacher").click(function(){
        $.ajax({
            type: "POST",
            url: "/admin/courses/totalizeTeachers",
            data: {
                "course": $("#course_id").val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function(data){

                $("#course-teachers").html(data);



                //$('#add-videos-' + lesson_id).html(data);
                //$('#add-videos-'+ selectedLesson).html(data);
                flash_success("Totalização concluida");
            }

        });
    });




    $("#save-course-teachers").click(function(){
        var teachers_map = {};
        var total_percentage = 0;
        $("[name |='course-teacher-name']").each(function(index){
            var teacher_id = $(this).val();
            var teacher_percentage = $(this).parent().parent().find(".course-teacher-percentage").val();
            teacher_percentage = teacher_percentage.replace(',','.');

            total_percentage += +teacher_percentage;

            teachers_map[teacher_id] = teacher_percentage;
        });

        if(total_percentage > 100){
            flash_danger("Soma das porcentagens superior a 100%");
            return;
        }


        $.ajax({
            type: "POST",
            url: "/admin/courses/updatecourseteachers",
            data: { "teachers": teachers_map,
                "course": $("#course_id").val()

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function(data){

                //$('#add-videos-' + lesson_id).html(data);
                //$('#add-videos-'+ selectedLesson).html(data);
                flash_success("Professores salvos com sucesso");
            }

        });
    });



    $(".add-course-teacher").off("click").on("click",function(){
        var newFormTeachers;
        var sizeDivsTeachers;
        var newFieldTeachers;
        var i = 0;

        // newFormTeachers = $(this).closest('.form-teachers').clone(true);


        newFormTeachers = $('.form-course-teachers').last().clone(true);




        console.log(newFormTeachers);

        $('.form-course-teachers').last().after(newFormTeachers);


        sizeDivsTeachers = $('#course-teachers-fields').children.length + i;
        newFieldTeachers = $('.form-course-teachers').last();
        $('[name|="course-teacher-name"]').last().attr('name','course-teacher-name-' + sizeDivsTeachers);
        $('[name|="course-teacher-name"]').last().attr('id','course-teacher-name-' + sizeDivsTeachers);
        newFieldTeachers.attr('name', 'course-teachers-name-' + sizeDivsTeachers);
        newFieldTeachers.val('');



        $("label[for=name]").last().text('Professor ' + sizeDivsTeachers);
        i++;





    });

}

function add_module_edit(){
    $(".edit-module").click(function(){

        if(!$(this).parent().hasClass("selected")){
            $(this).parent().click();
        }
        var target_id = $(this).data("target-id");
        var checkExist = setInterval(function() {


            if ($("#lessons").data("selected-module") == target_id) {
                $("#lessons-tab").click();
                clearInterval(checkExist);
            }
        }, 100);

    });
}

function createModuleTable(){
    $(".nav-tabs").on("click", "a", function(e){
        e.preventDefault();
        $(this).tab('show');
    })
        .on("click", "span", function () {
            var anchor = $(this).siblings('a');
            $(anchor.attr('href')).remove();
            $(this).parent().remove();
            $(".nav-tabs li").children('a').first().click();
        });


    var post = {};
    post.name = $(this).closest('.form-input').children('.form-control').val();

    var table = $('#module-table').DataTable({
        "initComplete": function(settings,json){
            add_module_edit();
            add_delete_module();
        },
        "processing": true,
        "columnDefs": [
            { "visible": false, "targets": [0,2] }
        ],
        "ajax": {
            "url": "/admin/courses/" + $("#course_id").val() + "/datatables",
            "type": "POST",
            "headers" : {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
        },
        "serverSide": true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.9/i18n/Portuguese-Brasil.json'
        },
    });



    $('.add-module').click(function(e) {
        e.preventDefault();

        var post = {};
        //post.name = $(this).closest('.form-input').children('.form-control').val();
        post.name = $(this).parent().find('input').val();
        post.course_id = $("#course_id").val();

        var parent_div =  $(this).parent();


        var newFormGroup = $(this).closest('.form-group').clone(true);




        $('#fields .form-group').last().after(newFormGroup);

        newField = $('#fields .form-control').last();
        newField.attr('name',  'module-name');
        newField.val('');
        newField.focus();

        $("label[for=name]").last().text('Nova disciplina');


        $.ajax({
            type: "POST",
            url: '/admin/courses/modules',
            data: { name: post.name,
                course_id : post.course_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function(data){
                try{
                    var newRow = $.parseJSON(data);

                    parent_div.remove();

                    table.draw(false);
                    add_module_edit();
                    add_delete_module();
                }catch(e){
                    if("error" in data){
                        flash_danger(data["error"]);
                    }
                }



            }
        });


    });







    $("[name|='module-name']").on('keypress',function(e){
        if(e.which == 13) {
            e.preventDefault();

            $(this).parent().next('.add-module').click();
        }

    });

    $("[name|='lesson-group']").children().on('keypress',function(e){
        if(e.which == 13) {
            e.preventDefault();
            $(this).next('.add-lesson').click();
        }

    });


    var tableLessons;
    var selectedModule;
    $('#module-table tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {

            $("#lessons-tab").not("[href='#lessons']").attr("data-toggle","tab");
            $("#lessons-tab").not("[href='#lessons']").attr("href","#lessons");
            $("#lessons-tab").not("[class='']").parent().attr("class","");


            table.$('tr.selected').removeClass('selected');


            if(tableLessons != null) {
                tableLessons.destroy();
            }
            $(this).addClass('selected');

            $(".dynamic-tab").remove();


            selectedModule = table.row( this ).data()[0];

            var nextTab = $('.nav-tabs li').size()+1;
            $('<li><a href="#edit-module-'+ table.row( this ).data()[0] + '" class="dynamic-tab module-editor" data-toggle="tab">Edição do Módulo '+table.row(this).data()[1]+'</a></li>').appendTo('.nav-tabs');

            //TODO: colocar conteúdo aqui
            $.ajax({
                type: "POST",
                url: '/admin/courses/editmodule',
                data: { module_id: selectedModule
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function(data){
                    var $appended = $('<div class="tab-pane" id="edit-module-'+ selectedModule + '">' + data + '</div>').appendTo('.tab-content');
                    var current_id = $appended.attr('id');


                    remove_changed_attribute( current_id);
                    change_watcher( current_id);

                    var just_id = current_id.substr(current_id.lastIndexOf("-")+1);

                    save_module(just_id,$appended.find("#save-module"));

                }
            });



            tableLessons = $('#lessons-table').DataTable({
                "processing": true,
                "columnDefs": [
                    { "visible": false, "targets": 0 }
                ],
                "initComplete": function(settings,json){
                    console.log("selected" + selectedModule);

                    add_delete_lesson();
                    $("#lessons-table").on('draw.dt',function() { console.log('enter'); add_delete_lesson(); });
                    $('.tags-select').select2({
                        tags: true,
                        minimumInputLength: 3,
                        ajax: {
                            type: 'POST',
                            url: '/admin/tags/select',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            data: function(params) {
                                return {
                                    term: params.term
                                };
                            },
                            processResults: function(data) {
                                return { results: data };
                            }
                        }
                    });
                },
                "ajax": {
                    "url": "/admin/courses/" + selectedModule + "/lessons",
                    "type": "POST",
                    "headers" : {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                },
                "serverSide": true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.9/i18n/Portuguese-Brasil.json'
                }
            });



            update_sequence("lesson-sequence",selectedModule);

            $("#lessons").data("selected-module",selectedModule);



            $('#lessons-table tbody').dblclick(function
                (){
                $(".nav-tabs li").children('a').last().click();
            })






        }
    } );

    var selectedLesson;
    $("#lessons-table").on( 'click', 'tr', function () {

        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            tableLessons.$('tr.selected').removeClass('selected');




            $(".dynamic-tab").remove();
            $(this).addClass('selected');
            selectedLesson = tableLessons.row( this ).data()[0];
            var nextTab = $('.nav-tabs li').size()+1;

            var lesson_name = tableLessons.row(this).data()[1];
            if(lesson_name == null || lesson_name == ''){
                lesson_name = tableLessons.row(this).data()[2];
            }


            add_new_tab('edit-lesson',lesson_name, "Edição ", "#edit-lesson");
            add_tab_content('/admin/courses/editlessons', {lesson_id: tableLessons.row(this).data()[0]},'edit-lesson',function() {
                $("#save-lesson").off('click').on('click',function(){
                    post_form(selectedLesson,"edit-lesson",'updatelesson');
                    $( "#lessons-table" ).DataTable().ajax.reload(function(){
                        add_delete_lesson();
                    });
                    $("#lessons-table").on('draw.dt',function() { add_delete_lesson(); });
                });

            });


            nextTab++;


            add_new_tab('video',lesson_name,'Vídeos',"#add-videos");
            add_tab_content('/admin/courses/editvideos', {lesson_id: tableLessons.row(this).data()[0]},'add-videos',function(){

                save_videos(selectedLesson, $("#save-videos"));

                $(".content-preview").click(function(){
                    $("#vimeoPreviewModal").modal('toggle');
                    var content = $(this).parent().parent().find(".content-url").val();
                    if(content.startsWith('vimeo:')){
                        content = 'https://player.vimeo.com/video/' + content.substring(6);
                    }

                    $("#vimeo-preview").attr('src',content);
                });
            });

            nextTab++;


            add_teachers(selectedLesson,lesson_name);

            nextTab++;

            add_material(selectedLesson,lesson_name);


        }
    } );






    $('.add-lesson').click(function(e) {
        e.preventDefault();

        var module_id = selectedModule;
        var name_input = $(this).parent().parent().find("[name|='lesson-name']").val();
        var sequence_input = $(this).parent().parent().find("[name|='lesson-sequence']").val();
        var duration_input =  $(this).parent().parent().find("[name|='lesson-name']").val();


        var parent_div =  $(this).parent().parent();

        $.ajax({
            type: "POST",
            url: '/admin/courses/addlessons',
            data: { module_id: module_id,
                title: name_input,
                sequence: sequence_input,
                duration: duration_input
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function(data){


                var new_div = parent_div.clone(true);

                clear_form_elements(new_div);

                var last_div = $(".lesson-fields").last();
                console.log("[name='" + new_div.attr('name') + "']");
                console.log(last_div.find("[name='lesson-sequence']").val());
                console.log(last_div);
                new_div.find("lesson-box [name|='lesson-sequence']").val(last_div.find("[name='lesson-sequence']").val());

                last_div.after(new_div);


                parent_div.remove();



                var newRow = $.parseJSON(data);


                tableLessons.draw(false);

            }
        });


    });



    $("#unblock-course").on('click',function() {
        verify_unblock();

    });

   // create_new_field_dynamic($("[name|='module-name']"),'module','Atividade',2);
}



function add_new_tab(id,name,type,link){
    var tab_id = '#' + id + "-tab";
    if($(tab_id).length <= 0)
    $('<li><a id="'+ tab_id + '" href="'+ link +'" class="dynamic-tab" data-toggle="tab">' + type + ' de '+name+'</a></li>').appendTo('.nav-tabs');
    else{
        $(tab_id).attr("href",link);
        $(tab_id).text(type + 'de ' + name);
    }

}

function add_tab_content(url,parameter_data,id,callback){
    var content_id = "#" + id;

    $.ajax({
        type: "POST",
        url: url,
        data: parameter_data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){

            if($(content_id).length <= 0) {

                var $appended = $('<div class="tab-pane" id="' + id + '">' + data + '</div>').appendTo('.tab-content');

                remove_changed_attribute($appended.attr('id'));
                change_watcher($appended.attr('id'));

            }else{
                $(content_id).html(data);
                remove_changed_attribute(content_id);
                change_watcher(content_id);
            }

            callback();


        }
    });
}


function add_delete_lesson(){
    $(".delete-lesson").off('click').click(function(){

        if(confirm("Tem certeza que deseja excluir esse item?")){
            $.ajax({
                "type": "POST",
                url: '/admin/courses/remove-lesson',
                data: { lesson: $(this).data("target-id")
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function(data) {
                    $( "#lessons-table" ).DataTable().ajax.reload(function(){

                        add_delete_lesson();
                    });

                    $("#lessons-table").on('draw.dt',function() { add_delete_lesson(); });
                    if(data == 'true') {
                        flash_success('Aula excluída com sucesso!')
                    }else if(data == 'full'){
                        flash_danger("Há alunos cursando essa aula.")
                    }else{
                        flash_danger("Não foi possível excluir a aula");
                    }
                }
            });

            // $("#module-table").

        }
    });
}


function remove_material(){
    $(".remove-material").on('click',function(){
        var removed_item = $(this);
        $.ajax({
           type: "POST",
            url: '/admin/courses/remove-material',
            data: { content: $(this).data('content')
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function(data){

                $(removed_item).parent().remove();
            }

        });
    });
}



function add_material(selectedLesson, lesson_name){


    add_new_tab('material',lesson_name, "Materiais ", "#add-material");
    add_tab_content('/admin/courses/material', {lesson_id: selectedLesson},'add-material',function() {

        $("#add-material").on('click',function(){

            $("#material-form").show();
        });

        remove_material();
        save_material();
    });

}

function save_material(){


    console.log('enter the submit');
    $("#material-form").submit(function(event){
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '/admin/courses/savematerial',
            type: 'POST',
            data: formData,
            success: function (data) {
                alert(data)
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            processData: false,
            contentType: false,
            success: function (result) {

                var li;
                if (result["extension"] == '.pdf') {
                    li = '<li class="fa fa-file-pdf-o">';
                } else if (result["extension"] == '.pps') {
                    li = '<li class="fa fa-file-powerpoint-o" >';
                } else if (result["extension"] == '.doc' || result["extension"] == '.docx') {
                    li = '<li class="fa fa-file-word-o" >';
                } else if (result["extension"] == '.png' || result["extension"] == '.jpg' || result["extension"] == 'jpeg') {
                    li = '<li class= "fa fa-file-image-o" >';
                } else {
                    li = '<li class="fa fa-file" >';
                }
                    li = li + '<a name="material-file"  data-id="'+ result['id']+'" data-url="'+result['url']+'" href="/'+ result['url'] +'">'+ result['choosen'] + '</a> <a type="button" class="fa fa-times remove-material" data-content="'+ result['id'] +'" style="color:red"></a></li>';


                $("#content-files").append(li + "<br/>");


                $("#material-name").val("");
                remove_material();
    }
        });

        return false;
    });

}



function add_teachers(selectedLesson, lesson_name){


    add_new_tab('teacher-percentage',lesson_name, "Professores ", "#add-teachers");
    add_tab_content('/admin/courses/editteachers', {lesson_id: selectedLesson},'add-teachers',function() {

            save_teachers(selectedLesson,$("#save-teachers"), $("[name|=teacher-name]"));

            $('.teachers-select').select2({
                width: 'resolve',
                minimumInputLength: 3,
                ajax: {
                    type: 'POST',
                    url: '/admin/teachers/select',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        return { results: data };
                    }
                }
            });



            $(".equal-divide").click(function(){
                equal_percentage(sizeDivsTeachers, $("[name|='teacher-percentage']"));
            });



        $(".remove-lesson-teacher").click(function(){

            $(this).parent().parent().css("display","none");
            $.ajax({
                type: "POST",
                url: "/admin/courses/remove-lesson-teacher",
                data: {
                    "lesson": selectedLesson,
                    "teacher": $(this).parent().parent().find(".teachers-select").val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function(data){
                    console.log($(this).parent().parent());
                    $(this).parent().parent().remove();
                    flash_success("Professor excluído com sucesso!");
                }

            });
        });

            var newFormTeachers;
            var sizeDivsTeachers;
            var newFieldTeachers;
            var i = 0;

            $(".add-teacher").off("click").on("click",function(){

                // newFormTeachers = $(this).closest('.form-teachers').clone(true);

                $('.teachers-select').last().select2("destroy");

                newFormTeachers = $('.form-teachers').last().clone(true);


                $('.teachers-select').last().select2({
                    width: 'resolve',
                    minimumInputLength: 3,
                    ajax: {
                        type: 'POST',
                        url: '/admin/teachers/select',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data: function(params) {
                            return {
                                term: params.term
                            };
                        },
                        processResults: function(data) {

                            return { results: data };
                        }
                    }
                });



                $('.form-teachers').last().after(newFormTeachers);


                sizeDivsTeachers = $('#teachers-fields').children.length + i;
                newFieldTeachers = $('.form-teachers').last();
                $('[name|="teacher-name"]').last().attr('name','teacher-name-' + sizeDivsTeachers);
                $('[name|="teacher-name"]').last().attr('id','teacher-name-' + sizeDivsTeachers);
                newFieldTeachers.attr('name', 'teachers-name-' + sizeDivsTeachers);
                newFieldTeachers.val('');



                $("label[for=name]").last().text('Professor ' + sizeDivsTeachers);
                i++;

                $('.teachers-select').last().select2({
                    width: 'resolve',
                    minimumInputLength: 3,
                    ajax: {
                        type: 'POST',
                        url: '/admin/teachers/select',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data: function(params) {
                            return {
                                term: params.term
                            };
                        },
                        processResults: function(data) {
                            return { results: data };
                        }
                    }
                });

            });

        });


}



function create_new_field_dynamic(field,portuguese_name,english_name, initial){
    var newFormGroup;
    var sizeDivs;
    var newField;
    var i = initial;


    field.one('change', function() {

        newFormGroup = $(this).closest('.form-group').clone(true);

        i = i + 1;


        $('#fields .form-group').last().after(newFormGroup);

        sizeDivs = $('#fields').children.length + i;
        newField = $('#fields .form-control').last();
        newField.attr('name', english_name + '-name-' + sizeDivs);
        newField.val('');

        $("label[for=name]").last().text(portuguese_name + ' ' + sizeDivs);
        create_new_field_dynamic(newField,'module','Atividade',2);
    });
}


function create_new_tab(title,tab_id, table, route, type ){

    $('<li><a href="#' + tab_id + '-'+ id + '" class="dynamic-tab" data-toggle="tab">' + title + ' ' + name +'</a></li>').appendTo('.nav-tabs');
}



function create_new_tab_from_view(title,tab_id, table, route){
    var id = table.row(this).data()[0];
    var name = table.row(this).data()[1];


    $('<li><a href="#' + tab_id + '-'+ id + '" class="dynamic-tab" data-toggle="tab">' + title + ' ' + name +'</a></li>').appendTo('.nav-tabs');
    $.ajax({
        type: "POST",
        url: '/admin/courses/' + route,
        data: { id: id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){
            $('<div class="tab-pane" id='+ tab_id + '-'+ id + '">' + data + '</div>').appendTo('.tab-content');
        }
    });

}

function create_new_table_tab(title,new_table_id, table,route){
    var id = table.row(this).data()[0];
    var new_data_table;
    new_data_table = $('#' + new_table_id).DataTable({
        "processing": true,
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
        "ajax": {
            "url": "/admin/courses/" + id + "/" + route,
            "type": "POST",
            "headers" : {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
        },
        "serverSide": true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.9/i18n/Portuguese-Brasil.json'
        }
    });

    return new_data_table;

}

function update_sequence(input_name,module_id){


    with_max_table_sequence(module_id, function(max){
        $("[name|='"+ input_name +"'").each(function(index){

            $(this).val(+max + (+index + 1));
        });
    });


}

function save_teachers(lesson_id,button,teachers){

        button.on('click',function(){

       var teachers_map = {};
        var total_percentage = 0;
        $("[name|='teacher-name']").each(function(index){
            var teacher_id = $(this).val();
            var teacher_percentage = $(this).parent().parent().find("[name|='teacher-percentage']").val();

            console.log($(this).parent().parent());
            total_percentage += +teacher_percentage;

            teachers_map[teacher_id] = teacher_percentage;
        });

            console.log($(this).parent().parent());
            console.log(total_percentage);
        if(total_percentage > 100){
            flash_danger("Soma das porcentagens superior a 100%");
            return;
        }


        $.ajax({
            type: "POST",
            url: "/admin/courses/updateteachers",
            data: { "teachers": teachers_map,
                "lesson_id": lesson_id

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function(data){


                //$('#add-videos-' + lesson_id).html(data);
                //$('#add-videos-'+ selectedLesson).html(data);
                flash_success("Professores salvos com sucesso");
        }

            });
        });

}


function save_videos(lesson_id,button){



    button.off('click').on('click',function(){


        console.log(lesson_id);
        console.log($("[name='video[]']"));
        var url_map = {};
        $("[name='video[]']").each(function(index){
            var sequence = $(this).data("sequence");
            url_map[Number(sequence)] = $(this).val();
        });

        console.log(url_map);

        $.ajax({
            type: "POST",
            url: "/admin/courses/updatevideos",
            data: { video: url_map,
                lesson_id: lesson_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function(data){
                //$('#add-videos-' + lesson_id).html(data);
                //$('#add-videos-'+ selectedLesson).html(data);
                flash_success("Vídeos salvos com sucesso");
                remove_changed_attribute("add-videos-");
            }

        });

    });
}


function save_module(module_id,button){

    button.off('click').on('click',function(){


         $.ajax({
         type: "POST",
         url: '/admin/courses/updatemodule',
         data: { module_id: module_id,
             module: $("[id='edit-module']").serialize(),
         },
         headers: {
         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
         },
         cache: false,
         success: function(data){
             if("error" in data){
                 flash_danger(data["error"]);
             }else {
                 flash_success(data["success"]);
             }
         },
             error: function(xhr){
                 if(xhr.status == 404){
                     flash_danger("Erro na comunicação com o servidor. Entre em contato com um administrador do sistema");
                 }else{
                     flash_danger("O sistema encontrou um erro de código " + xhr.status + ". Entre em contato com o suporte técnico informando o código de erro");
                 }
             }

         });
    });
}

function save_lesson(lesson_id){

}





function post_form(id,form_id,route, method_with_data) {
    $.ajax({
        type: "POST",
        url: '/admin/courses/' + route,
        data: {
            id: id,
            form: $("[id='" + form_id + "']").serialize(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function (data) {
            if("error" in data){
                flash_danger(data["error"]);
            }else {
                flash_success(data["success"]);
            }
            if(method_with_data !== undefined){
                method_with_data(data);
            }

            }
    });
}














function change_watcher(begin_with_id,event){



    $("[id^='"+ begin_with_id +"'] .form-control").not("[data-changed='true']").off('input').on("input",function(){
        $(this).attr("data-changed", "true");

        //var actualTab =   $("[href='#" +  $("[id^='"+ begin_with_id +"']").attr('id') + "'  ]") ;
        var actualTab = $("[href='#" + begin_with_id + "'");
        if(actualTab.text().indexOf(" {modificado} ") == -1){

            actualTab.text(actualTab.text() + " {modificado} ");
            if(event != undefined) event();

        }
    });
}



function remove_changed_attribute(begin_with_id){
    $("[id^='"+ begin_with_id +"'] .form-control [data-changed='true']").removeAttr("data-change");
    //var actualTab =   $("[href='#" +  $("[id^='"+ begin_with_id +"']").attr('id') + "'  ]") ;

    var actualTab = $("[href='#" + begin_with_id + "'");
    if(actualTab.text().indexOf(" {modificado} ") != -1){

        actualTab.text(actualTab.text().replace(" {modificado} ", ""));
    }

}

function is_changed(begin_with_id){
    var actualTab = $("[href='#" + begin_with_id + "'");
    if(actualTab.text().indexOf(" {modificado} ") != -1){
        return false;
    }
    return true;
}



function change_context_watcher(begin_with_id){

}


function equal_percentage(number,teacher_percentage){
    var percentage = 100 / number;
    percentage = percentage.toFixed(2);


    teacher_percentage.val(percentage);

}



function with_max_table_sequence(module_id,with_function){
    $.ajax({
        "type": "POST",
        url: '/admin/courses/maxsequence',
        data: { id: module_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data) {
            with_function(data);
        }
    });


}

function add_delete_module(){

    $(".delete-module").click(function(){

        if(confirm("Tem certeza que deseja excluir esse item?")){
            $.ajax({
                "type": "POST",
                url: '/admin/courses/remove-module',
                data: { module: $(this).data("target-id")
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function(data) {
                    $( "#module-table" ).DataTable().ajax.reload(function(){
                        add_module_edit();
                        add_delete_module();
                    });
                    if(data == 'true') {
                        flash_success('Disciplina excluída com sucesso!')
                    }else if(data == 'full'){
                        flash_danger("Há aulas associadas a essa disciplina.")
                    }else{
                        flash_danger("Não foi possível excluir a disciplina");
                    }
                }
            });

           // $("#module-table").

        }
    });
    /*
    $('[data-method]').append(function()
    {
        return "\n"+
            "<form action='"+$(this).attr('href')+"' method='POST' name='delete_item' style='display:none'>\n"+
            "   <input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
            "   <input type='hidden' name='_token' value='"+$('meta[name="_token"]').attr('content')+"'>\n"+
            "</form>\n"
    })
        .removeAttr('href')
        .attr('style','cursor:pointer;')
        .attr('onclick','$(this).find("form").submit();');
*/
    /*
     Generic are you sure dialog
     */
    /*
    $('form[name=delete_item]').submit(function(){
        return confirm("Tem certeza que deseja excluir esse item?");
    });
    */
}

function verify_unblock(){

    var course_id = $("#course_id").val();

    $.ajax({
        type: "POST",
        url: "/admin/courses/unblock",
        data: { 'course': course_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){

            if("error" in data){
                flash_danger(data["error"]);
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            }else {
                flash_success(data["success"]);

                $('.nav-tabs-custom').find('input, textarea, button, select').attr('disabled','disabled');
                $('html,body').animate({
                    scrollTop: 0
                }, 700);


            }
        }

    });


}

function clear_form_elements(selector) {
    selector.find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'text':
            case 'textarea':
            case 'file':
            case 'select-one':
            case 'select-multiple':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });
}




function flash_message(type,message){

    $("#dynamic-flash").css("opacity","1");
    $("#dynamic-flash").removeClass();
    $("#dynamic-flash").addClass("alert");
    $("#dynamic-flash").addClass(type);
    $("#dynamic-flash").html(message);
    setTimeout(function(){
        $("#dynamic-flash").css("opacity","0");
    },5000);

}

function flash_success(message){
    flash_message("alert-success",message);
}

function flash_warning(message){
    flash_message("alert-warning",message);
}
function flash_danger(message){
    flash_message("alert-danger",message);
}

function disable_tab(tab_selector){

    console.log(tab_selector);
    tab_selector.attr("data-toggle","");
   tab_selector.attr("href","#lessons");
    console.log(tab_selector.parent());
    tab_selector.parent().attr("class","disabled");


}

function enable_tab(tab_selector,target){
    tab_selector.attr("data-toggle","tab");
    tab_selector.attr("href",target);
    tab_selector.parent().attr("class","");

}


function disable_lesson_related_tabs(){
    disable_tab($("#video-tab"));
    disable_tab($("#teacher-percentage-tab"));
    disable_tab($("#edit-lesson-tab"));
    disable_tab($("#material-tab"));
}

function enable_lesson_related_tabs(selectedLesson){
    enable_tab($("#video-tab"),"#add-videos-" + selectedLesson);
    enable_tab($("#teacher-percentage-tab"), "#add-teachers-" + selectedLesson);
    enable_tab($("#edit-lesson-tab"),"#edit-lesson-" + selectedLesson);
    enable_tab($("#material-tab"),"#add-material-" + selectedLesson);



}


/*!
 * Chart.js
 * http://chartjs.org/
 * Version: 1.0.2
 *
 * Copyright 2015 Nick Downie
 * Released under the MIT license
 * https://github.com/nnnick/Chart.js/blob/master/LICENSE.md
 */
(function(){"use strict";var t=this,i=t.Chart,e=function(t){this.canvas=t.canvas,this.ctx=t;var i=function(t,i){return t["offset"+i]?t["offset"+i]:document.defaultView.getComputedStyle(t).getPropertyValue(i)},e=this.width=i(t.canvas,"Width"),n=this.height=i(t.canvas,"Height");t.canvas.width=e,t.canvas.height=n;var e=this.width=t.canvas.width,n=this.height=t.canvas.height;return this.aspectRatio=this.width/this.height,s.retinaScale(this),this};e.defaults={global:{animation:!0,animationSteps:60,animationEasing:"easeOutQuart",showScale:!0,scaleOverride:!1,scaleSteps:null,scaleStepWidth:null,scaleStartValue:null,scaleLineColor:"rgba(0,0,0,.1)",scaleLineWidth:1,scaleShowLabels:!0,scaleLabel:"<%=value%>",scaleIntegersOnly:!0,scaleBeginAtZero:!1,scaleFontFamily:"'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",scaleFontSize:12,scaleFontStyle:"normal",scaleFontColor:"#666",responsive:!1,maintainAspectRatio:!0,showTooltips:!0,customTooltips:!1,tooltipEvents:["mousemove","touchstart","touchmove","mouseout"],tooltipFillColor:"rgba(0,0,0,0.8)",tooltipFontFamily:"'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",tooltipFontSize:14,tooltipFontStyle:"normal",tooltipFontColor:"#fff",tooltipTitleFontFamily:"'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",tooltipTitleFontSize:14,tooltipTitleFontStyle:"bold",tooltipTitleFontColor:"#fff",tooltipYPadding:6,tooltipXPadding:6,tooltipCaretSize:8,tooltipCornerRadius:6,tooltipXOffset:10,tooltipTemplate:"<%if (label){%><%=label%>: <%}%><%= value %>",multiTooltipTemplate:"<%= value %>",multiTooltipKeyBackground:"#fff",onAnimationProgress:function(){},onAnimationComplete:function(){}}},e.types={};var s=e.helpers={},n=s.each=function(t,i,e){var s=Array.prototype.slice.call(arguments,3);if(t)if(t.length===+t.length){var n;for(n=0;n<t.length;n++)i.apply(e,[t[n],n].concat(s))}else for(var o in t)i.apply(e,[t[o],o].concat(s))},o=s.clone=function(t){var i={};return n(t,function(e,s){t.hasOwnProperty(s)&&(i[s]=e)}),i},a=s.extend=function(t){return n(Array.prototype.slice.call(arguments,1),function(i){n(i,function(e,s){i.hasOwnProperty(s)&&(t[s]=e)})}),t},h=s.merge=function(){var t=Array.prototype.slice.call(arguments,0);return t.unshift({}),a.apply(null,t)},l=s.indexOf=function(t,i){if(Array.prototype.indexOf)return t.indexOf(i);for(var e=0;e<t.length;e++)if(t[e]===i)return e;return-1},r=(s.where=function(t,i){var e=[];return s.each(t,function(t){i(t)&&e.push(t)}),e},s.findNextWhere=function(t,i,e){e||(e=-1);for(var s=e+1;s<t.length;s++){var n=t[s];if(i(n))return n}},s.findPreviousWhere=function(t,i,e){e||(e=t.length);for(var s=e-1;s>=0;s--){var n=t[s];if(i(n))return n}},s.inherits=function(t){var i=this,e=t&&t.hasOwnProperty("constructor")?t.constructor:function(){return i.apply(this,arguments)},s=function(){this.constructor=e};return s.prototype=i.prototype,e.prototype=new s,e.extend=r,t&&a(e.prototype,t),e.__super__=i.prototype,e}),c=s.noop=function(){},u=s.uid=function(){var t=0;return function(){return"chart-"+t++}}(),d=s.warn=function(t){window.console&&"function"==typeof window.console.warn&&console.warn(t)},p=s.amd="function"==typeof define&&define.amd,f=s.isNumber=function(t){return!isNaN(parseFloat(t))&&isFinite(t)},g=s.max=function(t){return Math.max.apply(Math,t)},m=s.min=function(t){return Math.min.apply(Math,t)},v=(s.cap=function(t,i,e){if(f(i)){if(t>i)return i}else if(f(e)&&e>t)return e;return t},s.getDecimalPlaces=function(t){return t%1!==0&&f(t)?t.toString().split(".")[1].length:0}),S=s.radians=function(t){return t*(Math.PI/180)},x=(s.getAngleFromPoint=function(t,i){var e=i.x-t.x,s=i.y-t.y,n=Math.sqrt(e*e+s*s),o=2*Math.PI+Math.atan2(s,e);return 0>e&&0>s&&(o+=2*Math.PI),{angle:o,distance:n}},s.aliasPixel=function(t){return t%2===0?0:.5}),y=(s.splineCurve=function(t,i,e,s){var n=Math.sqrt(Math.pow(i.x-t.x,2)+Math.pow(i.y-t.y,2)),o=Math.sqrt(Math.pow(e.x-i.x,2)+Math.pow(e.y-i.y,2)),a=s*n/(n+o),h=s*o/(n+o);return{inner:{x:i.x-a*(e.x-t.x),y:i.y-a*(e.y-t.y)},outer:{x:i.x+h*(e.x-t.x),y:i.y+h*(e.y-t.y)}}},s.calculateOrderOfMagnitude=function(t){return Math.floor(Math.log(t)/Math.LN10)}),C=(s.calculateScaleRange=function(t,i,e,s,n){var o=2,a=Math.floor(i/(1.5*e)),h=o>=a,l=g(t),r=m(t);l===r&&(l+=.5,r>=.5&&!s?r-=.5:l+=.5);for(var c=Math.abs(l-r),u=y(c),d=Math.ceil(l/(1*Math.pow(10,u)))*Math.pow(10,u),p=s?0:Math.floor(r/(1*Math.pow(10,u)))*Math.pow(10,u),f=d-p,v=Math.pow(10,u),S=Math.round(f/v);(S>a||a>2*S)&&!h;)if(S>a)v*=2,S=Math.round(f/v),S%1!==0&&(h=!0);else if(n&&u>=0){if(v/2%1!==0)break;v/=2,S=Math.round(f/v)}else v/=2,S=Math.round(f/v);return h&&(S=o,v=f/S),{steps:S,stepValue:v,min:p,max:p+S*v}},s.template=function(t,i){function e(t,i){var e=/\W/.test(t)?new Function("obj","var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('"+t.replace(/[\r\t\n]/g," ").split("<%").join("	").replace(/((^|%>)[^\t]*)'/g,"$1\r").replace(/\t=(.*?)%>/g,"',$1,'").split("	").join("');").split("%>").join("p.push('").split("\r").join("\\'")+"');}return p.join('');"):s[t]=s[t];return i?e(i):e}if(t instanceof Function)return t(i);var s={};return e(t,i)}),w=(s.generateLabels=function(t,i,e,s){var o=new Array(i);return labelTemplateString&&n(o,function(i,n){o[n]=C(t,{value:e+s*(n+1)})}),o},s.easingEffects={linear:function(t){return t},easeInQuad:function(t){return t*t},easeOutQuad:function(t){return-1*t*(t-2)},easeInOutQuad:function(t){return(t/=.5)<1?.5*t*t:-0.5*(--t*(t-2)-1)},easeInCubic:function(t){return t*t*t},easeOutCubic:function(t){return 1*((t=t/1-1)*t*t+1)},easeInOutCubic:function(t){return(t/=.5)<1?.5*t*t*t:.5*((t-=2)*t*t+2)},easeInQuart:function(t){return t*t*t*t},easeOutQuart:function(t){return-1*((t=t/1-1)*t*t*t-1)},easeInOutQuart:function(t){return(t/=.5)<1?.5*t*t*t*t:-0.5*((t-=2)*t*t*t-2)},easeInQuint:function(t){return 1*(t/=1)*t*t*t*t},easeOutQuint:function(t){return 1*((t=t/1-1)*t*t*t*t+1)},easeInOutQuint:function(t){return(t/=.5)<1?.5*t*t*t*t*t:.5*((t-=2)*t*t*t*t+2)},easeInSine:function(t){return-1*Math.cos(t/1*(Math.PI/2))+1},easeOutSine:function(t){return 1*Math.sin(t/1*(Math.PI/2))},easeInOutSine:function(t){return-0.5*(Math.cos(Math.PI*t/1)-1)},easeInExpo:function(t){return 0===t?1:1*Math.pow(2,10*(t/1-1))},easeOutExpo:function(t){return 1===t?1:1*(-Math.pow(2,-10*t/1)+1)},easeInOutExpo:function(t){return 0===t?0:1===t?1:(t/=.5)<1?.5*Math.pow(2,10*(t-1)):.5*(-Math.pow(2,-10*--t)+2)},easeInCirc:function(t){return t>=1?t:-1*(Math.sqrt(1-(t/=1)*t)-1)},easeOutCirc:function(t){return 1*Math.sqrt(1-(t=t/1-1)*t)},easeInOutCirc:function(t){return(t/=.5)<1?-0.5*(Math.sqrt(1-t*t)-1):.5*(Math.sqrt(1-(t-=2)*t)+1)},easeInElastic:function(t){var i=1.70158,e=0,s=1;return 0===t?0:1==(t/=1)?1:(e||(e=.3),s<Math.abs(1)?(s=1,i=e/4):i=e/(2*Math.PI)*Math.asin(1/s),-(s*Math.pow(2,10*(t-=1))*Math.sin(2*(1*t-i)*Math.PI/e)))},easeOutElastic:function(t){var i=1.70158,e=0,s=1;return 0===t?0:1==(t/=1)?1:(e||(e=.3),s<Math.abs(1)?(s=1,i=e/4):i=e/(2*Math.PI)*Math.asin(1/s),s*Math.pow(2,-10*t)*Math.sin(2*(1*t-i)*Math.PI/e)+1)},easeInOutElastic:function(t){var i=1.70158,e=0,s=1;return 0===t?0:2==(t/=.5)?1:(e||(e=.3*1.5),s<Math.abs(1)?(s=1,i=e/4):i=e/(2*Math.PI)*Math.asin(1/s),1>t?-.5*s*Math.pow(2,10*(t-=1))*Math.sin(2*(1*t-i)*Math.PI/e):s*Math.pow(2,-10*(t-=1))*Math.sin(2*(1*t-i)*Math.PI/e)*.5+1)},easeInBack:function(t){var i=1.70158;return 1*(t/=1)*t*((i+1)*t-i)},easeOutBack:function(t){var i=1.70158;return 1*((t=t/1-1)*t*((i+1)*t+i)+1)},easeInOutBack:function(t){var i=1.70158;return(t/=.5)<1?.5*t*t*(((i*=1.525)+1)*t-i):.5*((t-=2)*t*(((i*=1.525)+1)*t+i)+2)},easeInBounce:function(t){return 1-w.easeOutBounce(1-t)},easeOutBounce:function(t){return(t/=1)<1/2.75?7.5625*t*t:2/2.75>t?1*(7.5625*(t-=1.5/2.75)*t+.75):2.5/2.75>t?1*(7.5625*(t-=2.25/2.75)*t+.9375):1*(7.5625*(t-=2.625/2.75)*t+.984375)},easeInOutBounce:function(t){return.5>t?.5*w.easeInBounce(2*t):.5*w.easeOutBounce(2*t-1)+.5}}),b=s.requestAnimFrame=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(t){return window.setTimeout(t,1e3/60)}}(),P=s.cancelAnimFrame=function(){return window.cancelAnimationFrame||window.webkitCancelAnimationFrame||window.mozCancelAnimationFrame||window.oCancelAnimationFrame||window.msCancelAnimationFrame||function(t){return window.clearTimeout(t,1e3/60)}}(),L=(s.animationLoop=function(t,i,e,s,n,o){var a=0,h=w[e]||w.linear,l=function(){a++;var e=a/i,r=h(e);t.call(o,r,e,a),s.call(o,r,e),i>a?o.animationFrame=b(l):n.apply(o)};b(l)},s.getRelativePosition=function(t){var i,e,s=t.originalEvent||t,n=t.currentTarget||t.srcElement,o=n.getBoundingClientRect();return s.touches?(i=s.touches[0].clientX-o.left,e=s.touches[0].clientY-o.top):(i=s.clientX-o.left,e=s.clientY-o.top),{x:i,y:e}},s.addEvent=function(t,i,e){t.addEventListener?t.addEventListener(i,e):t.attachEvent?t.attachEvent("on"+i,e):t["on"+i]=e}),k=s.removeEvent=function(t,i,e){t.removeEventListener?t.removeEventListener(i,e,!1):t.detachEvent?t.detachEvent("on"+i,e):t["on"+i]=c},F=(s.bindEvents=function(t,i,e){t.events||(t.events={}),n(i,function(i){t.events[i]=function(){e.apply(t,arguments)},L(t.chart.canvas,i,t.events[i])})},s.unbindEvents=function(t,i){n(i,function(i,e){k(t.chart.canvas,e,i)})}),R=s.getMaximumWidth=function(t){var i=t.parentNode;return i.clientWidth},T=s.getMaximumHeight=function(t){var i=t.parentNode;return i.clientHeight},A=(s.getMaximumSize=s.getMaximumWidth,s.retinaScale=function(t){var i=t.ctx,e=t.canvas.width,s=t.canvas.height;window.devicePixelRatio&&(i.canvas.style.width=e+"px",i.canvas.style.height=s+"px",i.canvas.height=s*window.devicePixelRatio,i.canvas.width=e*window.devicePixelRatio,i.scale(window.devicePixelRatio,window.devicePixelRatio))}),M=s.clear=function(t){t.ctx.clearRect(0,0,t.width,t.height)},W=s.fontString=function(t,i,e){return i+" "+t+"px "+e},z=s.longestText=function(t,i,e){t.font=i;var s=0;return n(e,function(i){var e=t.measureText(i).width;s=e>s?e:s}),s},B=s.drawRoundedRectangle=function(t,i,e,s,n,o){t.beginPath(),t.moveTo(i+o,e),t.lineTo(i+s-o,e),t.quadraticCurveTo(i+s,e,i+s,e+o),t.lineTo(i+s,e+n-o),t.quadraticCurveTo(i+s,e+n,i+s-o,e+n),t.lineTo(i+o,e+n),t.quadraticCurveTo(i,e+n,i,e+n-o),t.lineTo(i,e+o),t.quadraticCurveTo(i,e,i+o,e),t.closePath()};e.instances={},e.Type=function(t,i,s){this.options=i,this.chart=s,this.id=u(),e.instances[this.id]=this,i.responsive&&this.resize(),this.initialize.call(this,t)},a(e.Type.prototype,{initialize:function(){return this},clear:function(){return M(this.chart),this},stop:function(){return P(this.animationFrame),this},resize:function(t){this.stop();var i=this.chart.canvas,e=R(this.chart.canvas),s=this.options.maintainAspectRatio?e/this.chart.aspectRatio:T(this.chart.canvas);return i.width=this.chart.width=e,i.height=this.chart.height=s,A(this.chart),"function"==typeof t&&t.apply(this,Array.prototype.slice.call(arguments,1)),this},reflow:c,render:function(t){return t&&this.reflow(),this.options.animation&&!t?s.animationLoop(this.draw,this.options.animationSteps,this.options.animationEasing,this.options.onAnimationProgress,this.options.onAnimationComplete,this):(this.draw(),this.options.onAnimationComplete.call(this)),this},generateLegend:function(){return C(this.options.legendTemplate,this)},destroy:function(){this.clear(),F(this,this.events);var t=this.chart.canvas;t.width=this.chart.width,t.height=this.chart.height,t.style.removeProperty?(t.style.removeProperty("width"),t.style.removeProperty("height")):(t.style.removeAttribute("width"),t.style.removeAttribute("height")),delete e.instances[this.id]},showTooltip:function(t,i){"undefined"==typeof this.activeElements&&(this.activeElements=[]);var o=function(t){var i=!1;return t.length!==this.activeElements.length?i=!0:(n(t,function(t,e){t!==this.activeElements[e]&&(i=!0)},this),i)}.call(this,t);if(o||i){if(this.activeElements=t,this.draw(),this.options.customTooltips&&this.options.customTooltips(!1),t.length>0)if(this.datasets&&this.datasets.length>1){for(var a,h,r=this.datasets.length-1;r>=0&&(a=this.datasets[r].points||this.datasets[r].bars||this.datasets[r].segments,h=l(a,t[0]),-1===h);r--);var c=[],u=[],d=function(){var t,i,e,n,o,a=[],l=[],r=[];return s.each(this.datasets,function(i){t=i.points||i.bars||i.segments,t[h]&&t[h].hasValue()&&a.push(t[h])}),s.each(a,function(t){l.push(t.x),r.push(t.y),c.push(s.template(this.options.multiTooltipTemplate,t)),u.push({fill:t._saved.fillColor||t.fillColor,stroke:t._saved.strokeColor||t.strokeColor})},this),o=m(r),e=g(r),n=m(l),i=g(l),{x:n>this.chart.width/2?n:i,y:(o+e)/2}}.call(this,h);new e.MultiTooltip({x:d.x,y:d.y,xPadding:this.options.tooltipXPadding,yPadding:this.options.tooltipYPadding,xOffset:this.options.tooltipXOffset,fillColor:this.options.tooltipFillColor,textColor:this.options.tooltipFontColor,fontFamily:this.options.tooltipFontFamily,fontStyle:this.options.tooltipFontStyle,fontSize:this.options.tooltipFontSize,titleTextColor:this.options.tooltipTitleFontColor,titleFontFamily:this.options.tooltipTitleFontFamily,titleFontStyle:this.options.tooltipTitleFontStyle,titleFontSize:this.options.tooltipTitleFontSize,cornerRadius:this.options.tooltipCornerRadius,labels:c,legendColors:u,legendColorBackground:this.options.multiTooltipKeyBackground,title:t[0].label,chart:this.chart,ctx:this.chart.ctx,custom:this.options.customTooltips}).draw()}else n(t,function(t){var i=t.tooltipPosition();new e.Tooltip({x:Math.round(i.x),y:Math.round(i.y),xPadding:this.options.tooltipXPadding,yPadding:this.options.tooltipYPadding,fillColor:this.options.tooltipFillColor,textColor:this.options.tooltipFontColor,fontFamily:this.options.tooltipFontFamily,fontStyle:this.options.tooltipFontStyle,fontSize:this.options.tooltipFontSize,caretHeight:this.options.tooltipCaretSize,cornerRadius:this.options.tooltipCornerRadius,text:C(this.options.tooltipTemplate,t),chart:this.chart,custom:this.options.customTooltips}).draw()},this);return this}},toBase64Image:function(){return this.chart.canvas.toDataURL.apply(this.chart.canvas,arguments)}}),e.Type.extend=function(t){var i=this,s=function(){return i.apply(this,arguments)};if(s.prototype=o(i.prototype),a(s.prototype,t),s.extend=e.Type.extend,t.name||i.prototype.name){var n=t.name||i.prototype.name,l=e.defaults[i.prototype.name]?o(e.defaults[i.prototype.name]):{};e.defaults[n]=a(l,t.defaults),e.types[n]=s,e.prototype[n]=function(t,i){var o=h(e.defaults.global,e.defaults[n],i||{});return new s(t,o,this)}}else d("Name not provided for this chart, so it hasn't been registered");return i},e.Element=function(t){a(this,t),this.initialize.apply(this,arguments),this.save()},a(e.Element.prototype,{initialize:function(){},restore:function(t){return t?n(t,function(t){this[t]=this._saved[t]},this):a(this,this._saved),this},save:function(){return this._saved=o(this),delete this._saved._saved,this},update:function(t){return n(t,function(t,i){this._saved[i]=this[i],this[i]=t},this),this},transition:function(t,i){return n(t,function(t,e){this[e]=(t-this._saved[e])*i+this._saved[e]},this),this},tooltipPosition:function(){return{x:this.x,y:this.y}},hasValue:function(){return f(this.value)}}),e.Element.extend=r,e.Point=e.Element.extend({display:!0,inRange:function(t,i){var e=this.hitDetectionRadius+this.radius;return Math.pow(t-this.x,2)+Math.pow(i-this.y,2)<Math.pow(e,2)},draw:function(){if(this.display){var t=this.ctx;t.beginPath(),t.arc(this.x,this.y,this.radius,0,2*Math.PI),t.closePath(),t.strokeStyle=this.strokeColor,t.lineWidth=this.strokeWidth,t.fillStyle=this.fillColor,t.fill(),t.stroke()}}}),e.Arc=e.Element.extend({inRange:function(t,i){var e=s.getAngleFromPoint(this,{x:t,y:i}),n=e.angle>=this.startAngle&&e.angle<=this.endAngle,o=e.distance>=this.innerRadius&&e.distance<=this.outerRadius;return n&&o},tooltipPosition:function(){var t=this.startAngle+(this.endAngle-this.startAngle)/2,i=(this.outerRadius-this.innerRadius)/2+this.innerRadius;return{x:this.x+Math.cos(t)*i,y:this.y+Math.sin(t)*i}},draw:function(t){var i=this.ctx;i.beginPath(),i.arc(this.x,this.y,this.outerRadius,this.startAngle,this.endAngle),i.arc(this.x,this.y,this.innerRadius,this.endAngle,this.startAngle,!0),i.closePath(),i.strokeStyle=this.strokeColor,i.lineWidth=this.strokeWidth,i.fillStyle=this.fillColor,i.fill(),i.lineJoin="bevel",this.showStroke&&i.stroke()}}),e.Rectangle=e.Element.extend({draw:function(){var t=this.ctx,i=this.width/2,e=this.x-i,s=this.x+i,n=this.base-(this.base-this.y),o=this.strokeWidth/2;this.showStroke&&(e+=o,s-=o,n+=o),t.beginPath(),t.fillStyle=this.fillColor,t.strokeStyle=this.strokeColor,t.lineWidth=this.strokeWidth,t.moveTo(e,this.base),t.lineTo(e,n),t.lineTo(s,n),t.lineTo(s,this.base),t.fill(),this.showStroke&&t.stroke()},height:function(){return this.base-this.y},inRange:function(t,i){return t>=this.x-this.width/2&&t<=this.x+this.width/2&&i>=this.y&&i<=this.base}}),e.Tooltip=e.Element.extend({draw:function(){var t=this.chart.ctx;t.font=W(this.fontSize,this.fontStyle,this.fontFamily),this.xAlign="center",this.yAlign="above";var i=this.caretPadding=2,e=t.measureText(this.text).width+2*this.xPadding,s=this.fontSize+2*this.yPadding,n=s+this.caretHeight+i;this.x+e/2>this.chart.width?this.xAlign="left":this.x-e/2<0&&(this.xAlign="right"),this.y-n<0&&(this.yAlign="below");var o=this.x-e/2,a=this.y-n;if(t.fillStyle=this.fillColor,this.custom)this.custom(this);else{switch(this.yAlign){case"above":t.beginPath(),t.moveTo(this.x,this.y-i),t.lineTo(this.x+this.caretHeight,this.y-(i+this.caretHeight)),t.lineTo(this.x-this.caretHeight,this.y-(i+this.caretHeight)),t.closePath(),t.fill();break;case"below":a=this.y+i+this.caretHeight,t.beginPath(),t.moveTo(this.x,this.y+i),t.lineTo(this.x+this.caretHeight,this.y+i+this.caretHeight),t.lineTo(this.x-this.caretHeight,this.y+i+this.caretHeight),t.closePath(),t.fill()}switch(this.xAlign){case"left":o=this.x-e+(this.cornerRadius+this.caretHeight);break;case"right":o=this.x-(this.cornerRadius+this.caretHeight)}B(t,o,a,e,s,this.cornerRadius),t.fill(),t.fillStyle=this.textColor,t.textAlign="center",t.textBaseline="middle",t.fillText(this.text,o+e/2,a+s/2)}}}),e.MultiTooltip=e.Element.extend({initialize:function(){this.font=W(this.fontSize,this.fontStyle,this.fontFamily),this.titleFont=W(this.titleFontSize,this.titleFontStyle,this.titleFontFamily),this.height=this.labels.length*this.fontSize+(this.labels.length-1)*(this.fontSize/2)+2*this.yPadding+1.5*this.titleFontSize,this.ctx.font=this.titleFont;var t=this.ctx.measureText(this.title).width,i=z(this.ctx,this.font,this.labels)+this.fontSize+3,e=g([i,t]);this.width=e+2*this.xPadding;var s=this.height/2;this.y-s<0?this.y=s:this.y+s>this.chart.height&&(this.y=this.chart.height-s),this.x>this.chart.width/2?this.x-=this.xOffset+this.width:this.x+=this.xOffset},getLineHeight:function(t){var i=this.y-this.height/2+this.yPadding,e=t-1;return 0===t?i+this.titleFontSize/2:i+(1.5*this.fontSize*e+this.fontSize/2)+1.5*this.titleFontSize},draw:function(){if(this.custom)this.custom(this);else{B(this.ctx,this.x,this.y-this.height/2,this.width,this.height,this.cornerRadius);var t=this.ctx;t.fillStyle=this.fillColor,t.fill(),t.closePath(),t.textAlign="left",t.textBaseline="middle",t.fillStyle=this.titleTextColor,t.font=this.titleFont,t.fillText(this.title,this.x+this.xPadding,this.getLineHeight(0)),t.font=this.font,s.each(this.labels,function(i,e){t.fillStyle=this.textColor,t.fillText(i,this.x+this.xPadding+this.fontSize+3,this.getLineHeight(e+1)),t.fillStyle=this.legendColorBackground,t.fillRect(this.x+this.xPadding,this.getLineHeight(e+1)-this.fontSize/2,this.fontSize,this.fontSize),t.fillStyle=this.legendColors[e].fill,t.fillRect(this.x+this.xPadding,this.getLineHeight(e+1)-this.fontSize/2,this.fontSize,this.fontSize)},this)}}}),e.Scale=e.Element.extend({initialize:function(){this.fit()},buildYLabels:function(){this.yLabels=[];for(var t=v(this.stepValue),i=0;i<=this.steps;i++)this.yLabels.push(C(this.templateString,{value:(this.min+i*this.stepValue).toFixed(t)}));this.yLabelWidth=this.display&&this.showLabels?z(this.ctx,this.font,this.yLabels):0},addXLabel:function(t){this.xLabels.push(t),this.valuesCount++,this.fit()},removeXLabel:function(){this.xLabels.shift(),this.valuesCount--,this.fit()},fit:function(){this.startPoint=this.display?this.fontSize:0,this.endPoint=this.display?this.height-1.5*this.fontSize-5:this.height,this.startPoint+=this.padding,this.endPoint-=this.padding;var t,i=this.endPoint-this.startPoint;for(this.calculateYRange(i),this.buildYLabels(),this.calculateXLabelRotation();i>this.endPoint-this.startPoint;)i=this.endPoint-this.startPoint,t=this.yLabelWidth,this.calculateYRange(i),this.buildYLabels(),t<this.yLabelWidth&&this.calculateXLabelRotation()},calculateXLabelRotation:function(){this.ctx.font=this.font;var t,i,e=this.ctx.measureText(this.xLabels[0]).width,s=this.ctx.measureText(this.xLabels[this.xLabels.length-1]).width;if(this.xScalePaddingRight=s/2+3,this.xScalePaddingLeft=e/2>this.yLabelWidth+10?e/2:this.yLabelWidth+10,this.xLabelRotation=0,this.display){var n,o=z(this.ctx,this.font,this.xLabels);this.xLabelWidth=o;for(var a=Math.floor(this.calculateX(1)-this.calculateX(0))-6;this.xLabelWidth>a&&0===this.xLabelRotation||this.xLabelWidth>a&&this.xLabelRotation<=90&&this.xLabelRotation>0;)n=Math.cos(S(this.xLabelRotation)),t=n*e,i=n*s,t+this.fontSize/2>this.yLabelWidth+8&&(this.xScalePaddingLeft=t+this.fontSize/2),this.xScalePaddingRight=this.fontSize/2,this.xLabelRotation++,this.xLabelWidth=n*o;this.xLabelRotation>0&&(this.endPoint-=Math.sin(S(this.xLabelRotation))*o+3)}else this.xLabelWidth=0,this.xScalePaddingRight=this.padding,this.xScalePaddingLeft=this.padding},calculateYRange:c,drawingArea:function(){return this.startPoint-this.endPoint},calculateY:function(t){var i=this.drawingArea()/(this.min-this.max);return this.endPoint-i*(t-this.min)},calculateX:function(t){var i=(this.xLabelRotation>0,this.width-(this.xScalePaddingLeft+this.xScalePaddingRight)),e=i/Math.max(this.valuesCount-(this.offsetGridLines?0:1),1),s=e*t+this.xScalePaddingLeft;return this.offsetGridLines&&(s+=e/2),Math.round(s)},update:function(t){s.extend(this,t),this.fit()},draw:function(){var t=this.ctx,i=(this.endPoint-this.startPoint)/this.steps,e=Math.round(this.xScalePaddingLeft);this.display&&(t.fillStyle=this.textColor,t.font=this.font,n(this.yLabels,function(n,o){var a=this.endPoint-i*o,h=Math.round(a),l=this.showHorizontalLines;t.textAlign="right",t.textBaseline="middle",this.showLabels&&t.fillText(n,e-10,a),0!==o||l||(l=!0),l&&t.beginPath(),o>0?(t.lineWidth=this.gridLineWidth,t.strokeStyle=this.gridLineColor):(t.lineWidth=this.lineWidth,t.strokeStyle=this.lineColor),h+=s.aliasPixel(t.lineWidth),l&&(t.moveTo(e,h),t.lineTo(this.width,h),t.stroke(),t.closePath()),t.lineWidth=this.lineWidth,t.strokeStyle=this.lineColor,t.beginPath(),t.moveTo(e-5,h),t.lineTo(e,h),t.stroke(),t.closePath()},this),n(this.xLabels,function(i,e){var s=this.calculateX(e)+x(this.lineWidth),n=this.calculateX(e-(this.offsetGridLines?.5:0))+x(this.lineWidth),o=this.xLabelRotation>0,a=this.showVerticalLines;0!==e||a||(a=!0),a&&t.beginPath(),e>0?(t.lineWidth=this.gridLineWidth,t.strokeStyle=this.gridLineColor):(t.lineWidth=this.lineWidth,t.strokeStyle=this.lineColor),a&&(t.moveTo(n,this.endPoint),t.lineTo(n,this.startPoint-3),t.stroke(),t.closePath()),t.lineWidth=this.lineWidth,t.strokeStyle=this.lineColor,t.beginPath(),t.moveTo(n,this.endPoint),t.lineTo(n,this.endPoint+5),t.stroke(),t.closePath(),t.save(),t.translate(s,o?this.endPoint+12:this.endPoint+8),t.rotate(-1*S(this.xLabelRotation)),t.font=this.font,t.textAlign=o?"right":"center",t.textBaseline=o?"middle":"top",t.fillText(i,0,0),t.restore()},this))}}),e.RadialScale=e.Element.extend({initialize:function(){this.size=m([this.height,this.width]),this.drawingArea=this.display?this.size/2-(this.fontSize/2+this.backdropPaddingY):this.size/2},calculateCenterOffset:function(t){var i=this.drawingArea/(this.max-this.min);return(t-this.min)*i},update:function(){this.lineArc?this.drawingArea=this.display?this.size/2-(this.fontSize/2+this.backdropPaddingY):this.size/2:this.setScaleSize(),this.buildYLabels()},buildYLabels:function(){this.yLabels=[];for(var t=v(this.stepValue),i=0;i<=this.steps;i++)this.yLabels.push(C(this.templateString,{value:(this.min+i*this.stepValue).toFixed(t)}))},getCircumference:function(){return 2*Math.PI/this.valuesCount},setScaleSize:function(){var t,i,e,s,n,o,a,h,l,r,c,u,d=m([this.height/2-this.pointLabelFontSize-5,this.width/2]),p=this.width,g=0;for(this.ctx.font=W(this.pointLabelFontSize,this.pointLabelFontStyle,this.pointLabelFontFamily),i=0;i<this.valuesCount;i++)t=this.getPointPosition(i,d),e=this.ctx.measureText(C(this.templateString,{value:this.labels[i]})).width+5,0===i||i===this.valuesCount/2?(s=e/2,t.x+s>p&&(p=t.x+s,n=i),t.x-s<g&&(g=t.x-s,a=i)):i<this.valuesCount/2?t.x+e>p&&(p=t.x+e,n=i):i>this.valuesCount/2&&t.x-e<g&&(g=t.x-e,a=i);l=g,r=Math.ceil(p-this.width),o=this.getIndexAngle(n),h=this.getIndexAngle(a),c=r/Math.sin(o+Math.PI/2),u=l/Math.sin(h+Math.PI/2),c=f(c)?c:0,u=f(u)?u:0,this.drawingArea=d-(u+c)/2,this.setCenterPoint(u,c)},setCenterPoint:function(t,i){var e=this.width-i-this.drawingArea,s=t+this.drawingArea;this.xCenter=(s+e)/2,this.yCenter=this.height/2},getIndexAngle:function(t){var i=2*Math.PI/this.valuesCount;return t*i-Math.PI/2},getPointPosition:function(t,i){var e=this.getIndexAngle(t);return{x:Math.cos(e)*i+this.xCenter,y:Math.sin(e)*i+this.yCenter}},draw:function(){if(this.display){var t=this.ctx;if(n(this.yLabels,function(i,e){if(e>0){var s,n=e*(this.drawingArea/this.steps),o=this.yCenter-n;if(this.lineWidth>0)if(t.strokeStyle=this.lineColor,t.lineWidth=this.lineWidth,this.lineArc)t.beginPath(),t.arc(this.xCenter,this.yCenter,n,0,2*Math.PI),t.closePath(),t.stroke();else{t.beginPath();for(var a=0;a<this.valuesCount;a++)s=this.getPointPosition(a,this.calculateCenterOffset(this.min+e*this.stepValue)),0===a?t.moveTo(s.x,s.y):t.lineTo(s.x,s.y);t.closePath(),t.stroke()}if(this.showLabels){if(t.font=W(this.fontSize,this.fontStyle,this.fontFamily),this.showLabelBackdrop){var h=t.measureText(i).width;t.fillStyle=this.backdropColor,t.fillRect(this.xCenter-h/2-this.backdropPaddingX,o-this.fontSize/2-this.backdropPaddingY,h+2*this.backdropPaddingX,this.fontSize+2*this.backdropPaddingY)}t.textAlign="center",t.textBaseline="middle",t.fillStyle=this.fontColor,t.fillText(i,this.xCenter,o)}}},this),!this.lineArc){t.lineWidth=this.angleLineWidth,t.strokeStyle=this.angleLineColor;for(var i=this.valuesCount-1;i>=0;i--){if(this.angleLineWidth>0){var e=this.getPointPosition(i,this.calculateCenterOffset(this.max));t.beginPath(),t.moveTo(this.xCenter,this.yCenter),t.lineTo(e.x,e.y),t.stroke(),t.closePath()}var s=this.getPointPosition(i,this.calculateCenterOffset(this.max)+5);t.font=W(this.pointLabelFontSize,this.pointLabelFontStyle,this.pointLabelFontFamily),t.fillStyle=this.pointLabelFontColor;var o=this.labels.length,a=this.labels.length/2,h=a/2,l=h>i||i>o-h,r=i===h||i===o-h;t.textAlign=0===i?"center":i===a?"center":a>i?"left":"right",t.textBaseline=r?"middle":l?"bottom":"top",t.fillText(this.labels[i],s.x,s.y)}}}}}),s.addEvent(window,"resize",function(){var t;return function(){clearTimeout(t),t=setTimeout(function(){n(e.instances,function(t){t.options.responsive&&t.resize(t.render,!0)})},50)}}()),p?define(function(){return e}):"object"==typeof module&&module.exports&&(module.exports=e),t.Chart=e,e.noConflict=function(){return t.Chart=i,e}}).call(this),function(){"use strict";var t=this,i=t.Chart,e=i.helpers,s={scaleBeginAtZero:!0,scaleShowGridLines:!0,scaleGridLineColor:"rgba(0,0,0,.05)",scaleGridLineWidth:1,scaleShowHorizontalLines:!0,scaleShowVerticalLines:!0,barShowStroke:!0,barStrokeWidth:2,barValueSpacing:5,barDatasetSpacing:1,legendTemplate:'<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'};i.Type.extend({name:"Bar",defaults:s,initialize:function(t){var s=this.options;this.ScaleClass=i.Scale.extend({offsetGridLines:!0,calculateBarX:function(t,i,e){var n=this.calculateBaseWidth(),o=this.calculateX(e)-n/2,a=this.calculateBarWidth(t);return o+a*i+i*s.barDatasetSpacing+a/2},calculateBaseWidth:function(){return this.calculateX(1)-this.calculateX(0)-2*s.barValueSpacing},calculateBarWidth:function(t){var i=this.calculateBaseWidth()-(t-1)*s.barDatasetSpacing;return i/t}}),this.datasets=[],this.options.showTooltips&&e.bindEvents(this,this.options.tooltipEvents,function(t){var i="mouseout"!==t.type?this.getBarsAtEvent(t):[];this.eachBars(function(t){t.restore(["fillColor","strokeColor"])}),e.each(i,function(t){t.fillColor=t.highlightFill,t.strokeColor=t.highlightStroke}),this.showTooltip(i)}),this.BarClass=i.Rectangle.extend({strokeWidth:this.options.barStrokeWidth,showStroke:this.options.barShowStroke,ctx:this.chart.ctx}),e.each(t.datasets,function(i){var s={label:i.label||null,fillColor:i.fillColor,strokeColor:i.strokeColor,bars:[]};this.datasets.push(s),e.each(i.data,function(e,n){s.bars.push(new this.BarClass({value:e,label:t.labels[n],datasetLabel:i.label,strokeColor:i.strokeColor,fillColor:i.fillColor,highlightFill:i.highlightFill||i.fillColor,highlightStroke:i.highlightStroke||i.strokeColor}))},this)},this),this.buildScale(t.labels),this.BarClass.prototype.base=this.scale.endPoint,this.eachBars(function(t,i,s){e.extend(t,{width:this.scale.calculateBarWidth(this.datasets.length),x:this.scale.calculateBarX(this.datasets.length,s,i),y:this.scale.endPoint}),t.save()},this),this.render()},update:function(){this.scale.update(),e.each(this.activeElements,function(t){t.restore(["fillColor","strokeColor"])}),this.eachBars(function(t){t.save()}),this.render()},eachBars:function(t){e.each(this.datasets,function(i,s){e.each(i.bars,t,this,s)},this)},getBarsAtEvent:function(t){for(var i,s=[],n=e.getRelativePosition(t),o=function(t){s.push(t.bars[i])},a=0;a<this.datasets.length;a++)for(i=0;i<this.datasets[a].bars.length;i++)if(this.datasets[a].bars[i].inRange(n.x,n.y))return e.each(this.datasets,o),s;return s},buildScale:function(t){var i=this,s=function(){var t=[];return i.eachBars(function(i){t.push(i.value)}),t},n={templateString:this.options.scaleLabel,height:this.chart.height,width:this.chart.width,ctx:this.chart.ctx,textColor:this.options.scaleFontColor,fontSize:this.options.scaleFontSize,fontStyle:this.options.scaleFontStyle,fontFamily:this.options.scaleFontFamily,valuesCount:t.length,beginAtZero:this.options.scaleBeginAtZero,integersOnly:this.options.scaleIntegersOnly,calculateYRange:function(t){var i=e.calculateScaleRange(s(),t,this.fontSize,this.beginAtZero,this.integersOnly);e.extend(this,i)},xLabels:t,font:e.fontString(this.options.scaleFontSize,this.options.scaleFontStyle,this.options.scaleFontFamily),lineWidth:this.options.scaleLineWidth,lineColor:this.options.scaleLineColor,showHorizontalLines:this.options.scaleShowHorizontalLines,showVerticalLines:this.options.scaleShowVerticalLines,gridLineWidth:this.options.scaleShowGridLines?this.options.scaleGridLineWidth:0,gridLineColor:this.options.scaleShowGridLines?this.options.scaleGridLineColor:"rgba(0,0,0,0)",padding:this.options.showScale?0:this.options.barShowStroke?this.options.barStrokeWidth:0,showLabels:this.options.scaleShowLabels,display:this.options.showScale};this.options.scaleOverride&&e.extend(n,{calculateYRange:e.noop,steps:this.options.scaleSteps,stepValue:this.options.scaleStepWidth,min:this.options.scaleStartValue,max:this.options.scaleStartValue+this.options.scaleSteps*this.options.scaleStepWidth}),this.scale=new this.ScaleClass(n)},addData:function(t,i){e.each(t,function(t,e){this.datasets[e].bars.push(new this.BarClass({value:t,label:i,x:this.scale.calculateBarX(this.datasets.length,e,this.scale.valuesCount+1),y:this.scale.endPoint,width:this.scale.calculateBarWidth(this.datasets.length),base:this.scale.endPoint,strokeColor:this.datasets[e].strokeColor,fillColor:this.datasets[e].fillColor}))
},this),this.scale.addXLabel(i),this.update()},removeData:function(){this.scale.removeXLabel(),e.each(this.datasets,function(t){t.bars.shift()},this),this.update()},reflow:function(){e.extend(this.BarClass.prototype,{y:this.scale.endPoint,base:this.scale.endPoint});var t=e.extend({height:this.chart.height,width:this.chart.width});this.scale.update(t)},draw:function(t){var i=t||1;this.clear();this.chart.ctx;this.scale.draw(i),e.each(this.datasets,function(t,s){e.each(t.bars,function(t,e){t.hasValue()&&(t.base=this.scale.endPoint,t.transition({x:this.scale.calculateBarX(this.datasets.length,s,e),y:this.scale.calculateY(t.value),width:this.scale.calculateBarWidth(this.datasets.length)},i).draw())},this)},this)}})}.call(this),function(){"use strict";var t=this,i=t.Chart,e=i.helpers,s={segmentShowStroke:!0,segmentStrokeColor:"#fff",segmentStrokeWidth:2,percentageInnerCutout:50,animationSteps:100,animationEasing:"easeOutBounce",animateRotate:!0,animateScale:!1,legendTemplate:'<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'};i.Type.extend({name:"Doughnut",defaults:s,initialize:function(t){this.segments=[],this.outerRadius=(e.min([this.chart.width,this.chart.height])-this.options.segmentStrokeWidth/2)/2,this.SegmentArc=i.Arc.extend({ctx:this.chart.ctx,x:this.chart.width/2,y:this.chart.height/2}),this.options.showTooltips&&e.bindEvents(this,this.options.tooltipEvents,function(t){var i="mouseout"!==t.type?this.getSegmentsAtEvent(t):[];e.each(this.segments,function(t){t.restore(["fillColor"])}),e.each(i,function(t){t.fillColor=t.highlightColor}),this.showTooltip(i)}),this.calculateTotal(t),e.each(t,function(t,i){this.addData(t,i,!0)},this),this.render()},getSegmentsAtEvent:function(t){var i=[],s=e.getRelativePosition(t);return e.each(this.segments,function(t){t.inRange(s.x,s.y)&&i.push(t)},this),i},addData:function(t,i,e){var s=i||this.segments.length;this.segments.splice(s,0,new this.SegmentArc({value:t.value,outerRadius:this.options.animateScale?0:this.outerRadius,innerRadius:this.options.animateScale?0:this.outerRadius/100*this.options.percentageInnerCutout,fillColor:t.color,highlightColor:t.highlight||t.color,showStroke:this.options.segmentShowStroke,strokeWidth:this.options.segmentStrokeWidth,strokeColor:this.options.segmentStrokeColor,startAngle:1.5*Math.PI,circumference:this.options.animateRotate?0:this.calculateCircumference(t.value),label:t.label})),e||(this.reflow(),this.update())},calculateCircumference:function(t){return 2*Math.PI*(Math.abs(t)/this.total)},calculateTotal:function(t){this.total=0,e.each(t,function(t){this.total+=Math.abs(t.value)},this)},update:function(){this.calculateTotal(this.segments),e.each(this.activeElements,function(t){t.restore(["fillColor"])}),e.each(this.segments,function(t){t.save()}),this.render()},removeData:function(t){var i=e.isNumber(t)?t:this.segments.length-1;this.segments.splice(i,1),this.reflow(),this.update()},reflow:function(){e.extend(this.SegmentArc.prototype,{x:this.chart.width/2,y:this.chart.height/2}),this.outerRadius=(e.min([this.chart.width,this.chart.height])-this.options.segmentStrokeWidth/2)/2,e.each(this.segments,function(t){t.update({outerRadius:this.outerRadius,innerRadius:this.outerRadius/100*this.options.percentageInnerCutout})},this)},draw:function(t){var i=t?t:1;this.clear(),e.each(this.segments,function(t,e){t.transition({circumference:this.calculateCircumference(t.value),outerRadius:this.outerRadius,innerRadius:this.outerRadius/100*this.options.percentageInnerCutout},i),t.endAngle=t.startAngle+t.circumference,t.draw(),0===e&&(t.startAngle=1.5*Math.PI),e<this.segments.length-1&&(this.segments[e+1].startAngle=t.endAngle)},this)}}),i.types.Doughnut.extend({name:"Pie",defaults:e.merge(s,{percentageInnerCutout:0})})}.call(this),function(){"use strict";var t=this,i=t.Chart,e=i.helpers,s={scaleShowGridLines:!0,scaleGridLineColor:"rgba(0,0,0,.05)",scaleGridLineWidth:1,scaleShowHorizontalLines:!0,scaleShowVerticalLines:!0,bezierCurve:!0,bezierCurveTension:.4,pointDot:!0,pointDotRadius:4,pointDotStrokeWidth:1,pointHitDetectionRadius:20,datasetStroke:!0,datasetStrokeWidth:2,datasetFill:!0,legendTemplate:'<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].strokeColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'};i.Type.extend({name:"Line",defaults:s,initialize:function(t){this.PointClass=i.Point.extend({strokeWidth:this.options.pointDotStrokeWidth,radius:this.options.pointDotRadius,display:this.options.pointDot,hitDetectionRadius:this.options.pointHitDetectionRadius,ctx:this.chart.ctx,inRange:function(t){return Math.pow(t-this.x,2)<Math.pow(this.radius+this.hitDetectionRadius,2)}}),this.datasets=[],this.options.showTooltips&&e.bindEvents(this,this.options.tooltipEvents,function(t){var i="mouseout"!==t.type?this.getPointsAtEvent(t):[];this.eachPoints(function(t){t.restore(["fillColor","strokeColor"])}),e.each(i,function(t){t.fillColor=t.highlightFill,t.strokeColor=t.highlightStroke}),this.showTooltip(i)}),e.each(t.datasets,function(i){var s={label:i.label||null,fillColor:i.fillColor,strokeColor:i.strokeColor,pointColor:i.pointColor,pointStrokeColor:i.pointStrokeColor,points:[]};this.datasets.push(s),e.each(i.data,function(e,n){s.points.push(new this.PointClass({value:e,label:t.labels[n],datasetLabel:i.label,strokeColor:i.pointStrokeColor,fillColor:i.pointColor,highlightFill:i.pointHighlightFill||i.pointColor,highlightStroke:i.pointHighlightStroke||i.pointStrokeColor}))},this),this.buildScale(t.labels),this.eachPoints(function(t,i){e.extend(t,{x:this.scale.calculateX(i),y:this.scale.endPoint}),t.save()},this)},this),this.render()},update:function(){this.scale.update(),e.each(this.activeElements,function(t){t.restore(["fillColor","strokeColor"])}),this.eachPoints(function(t){t.save()}),this.render()},eachPoints:function(t){e.each(this.datasets,function(i){e.each(i.points,t,this)},this)},getPointsAtEvent:function(t){var i=[],s=e.getRelativePosition(t);return e.each(this.datasets,function(t){e.each(t.points,function(t){t.inRange(s.x,s.y)&&i.push(t)})},this),i},buildScale:function(t){var s=this,n=function(){var t=[];return s.eachPoints(function(i){t.push(i.value)}),t},o={templateString:this.options.scaleLabel,height:this.chart.height,width:this.chart.width,ctx:this.chart.ctx,textColor:this.options.scaleFontColor,fontSize:this.options.scaleFontSize,fontStyle:this.options.scaleFontStyle,fontFamily:this.options.scaleFontFamily,valuesCount:t.length,beginAtZero:this.options.scaleBeginAtZero,integersOnly:this.options.scaleIntegersOnly,calculateYRange:function(t){var i=e.calculateScaleRange(n(),t,this.fontSize,this.beginAtZero,this.integersOnly);e.extend(this,i)},xLabels:t,font:e.fontString(this.options.scaleFontSize,this.options.scaleFontStyle,this.options.scaleFontFamily),lineWidth:this.options.scaleLineWidth,lineColor:this.options.scaleLineColor,showHorizontalLines:this.options.scaleShowHorizontalLines,showVerticalLines:this.options.scaleShowVerticalLines,gridLineWidth:this.options.scaleShowGridLines?this.options.scaleGridLineWidth:0,gridLineColor:this.options.scaleShowGridLines?this.options.scaleGridLineColor:"rgba(0,0,0,0)",padding:this.options.showScale?0:this.options.pointDotRadius+this.options.pointDotStrokeWidth,showLabels:this.options.scaleShowLabels,display:this.options.showScale};this.options.scaleOverride&&e.extend(o,{calculateYRange:e.noop,steps:this.options.scaleSteps,stepValue:this.options.scaleStepWidth,min:this.options.scaleStartValue,max:this.options.scaleStartValue+this.options.scaleSteps*this.options.scaleStepWidth}),this.scale=new i.Scale(o)},addData:function(t,i){e.each(t,function(t,e){this.datasets[e].points.push(new this.PointClass({value:t,label:i,x:this.scale.calculateX(this.scale.valuesCount+1),y:this.scale.endPoint,strokeColor:this.datasets[e].pointStrokeColor,fillColor:this.datasets[e].pointColor}))},this),this.scale.addXLabel(i),this.update()},removeData:function(){this.scale.removeXLabel(),e.each(this.datasets,function(t){t.points.shift()},this),this.update()},reflow:function(){var t=e.extend({height:this.chart.height,width:this.chart.width});this.scale.update(t)},draw:function(t){var i=t||1;this.clear();var s=this.chart.ctx,n=function(t){return null!==t.value},o=function(t,i,s){return e.findNextWhere(i,n,s)||t},a=function(t,i,s){return e.findPreviousWhere(i,n,s)||t};this.scale.draw(i),e.each(this.datasets,function(t){var h=e.where(t.points,n);e.each(t.points,function(t,e){t.hasValue()&&t.transition({y:this.scale.calculateY(t.value),x:this.scale.calculateX(e)},i)},this),this.options.bezierCurve&&e.each(h,function(t,i){var s=i>0&&i<h.length-1?this.options.bezierCurveTension:0;t.controlPoints=e.splineCurve(a(t,h,i),t,o(t,h,i),s),t.controlPoints.outer.y>this.scale.endPoint?t.controlPoints.outer.y=this.scale.endPoint:t.controlPoints.outer.y<this.scale.startPoint&&(t.controlPoints.outer.y=this.scale.startPoint),t.controlPoints.inner.y>this.scale.endPoint?t.controlPoints.inner.y=this.scale.endPoint:t.controlPoints.inner.y<this.scale.startPoint&&(t.controlPoints.inner.y=this.scale.startPoint)},this),s.lineWidth=this.options.datasetStrokeWidth,s.strokeStyle=t.strokeColor,s.beginPath(),e.each(h,function(t,i){if(0===i)s.moveTo(t.x,t.y);else if(this.options.bezierCurve){var e=a(t,h,i);s.bezierCurveTo(e.controlPoints.outer.x,e.controlPoints.outer.y,t.controlPoints.inner.x,t.controlPoints.inner.y,t.x,t.y)}else s.lineTo(t.x,t.y)},this),s.stroke(),this.options.datasetFill&&h.length>0&&(s.lineTo(h[h.length-1].x,this.scale.endPoint),s.lineTo(h[0].x,this.scale.endPoint),s.fillStyle=t.fillColor,s.closePath(),s.fill()),e.each(h,function(t){t.draw()})},this)}})}.call(this),function(){"use strict";var t=this,i=t.Chart,e=i.helpers,s={scaleShowLabelBackdrop:!0,scaleBackdropColor:"rgba(255,255,255,0.75)",scaleBeginAtZero:!0,scaleBackdropPaddingY:2,scaleBackdropPaddingX:2,scaleShowLine:!0,segmentShowStroke:!0,segmentStrokeColor:"#fff",segmentStrokeWidth:2,animationSteps:100,animationEasing:"easeOutBounce",animateRotate:!0,animateScale:!1,legendTemplate:'<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'};i.Type.extend({name:"PolarArea",defaults:s,initialize:function(t){this.segments=[],this.SegmentArc=i.Arc.extend({showStroke:this.options.segmentShowStroke,strokeWidth:this.options.segmentStrokeWidth,strokeColor:this.options.segmentStrokeColor,ctx:this.chart.ctx,innerRadius:0,x:this.chart.width/2,y:this.chart.height/2}),this.scale=new i.RadialScale({display:this.options.showScale,fontStyle:this.options.scaleFontStyle,fontSize:this.options.scaleFontSize,fontFamily:this.options.scaleFontFamily,fontColor:this.options.scaleFontColor,showLabels:this.options.scaleShowLabels,showLabelBackdrop:this.options.scaleShowLabelBackdrop,backdropColor:this.options.scaleBackdropColor,backdropPaddingY:this.options.scaleBackdropPaddingY,backdropPaddingX:this.options.scaleBackdropPaddingX,lineWidth:this.options.scaleShowLine?this.options.scaleLineWidth:0,lineColor:this.options.scaleLineColor,lineArc:!0,width:this.chart.width,height:this.chart.height,xCenter:this.chart.width/2,yCenter:this.chart.height/2,ctx:this.chart.ctx,templateString:this.options.scaleLabel,valuesCount:t.length}),this.updateScaleRange(t),this.scale.update(),e.each(t,function(t,i){this.addData(t,i,!0)},this),this.options.showTooltips&&e.bindEvents(this,this.options.tooltipEvents,function(t){var i="mouseout"!==t.type?this.getSegmentsAtEvent(t):[];e.each(this.segments,function(t){t.restore(["fillColor"])}),e.each(i,function(t){t.fillColor=t.highlightColor}),this.showTooltip(i)}),this.render()},getSegmentsAtEvent:function(t){var i=[],s=e.getRelativePosition(t);return e.each(this.segments,function(t){t.inRange(s.x,s.y)&&i.push(t)},this),i},addData:function(t,i,e){var s=i||this.segments.length;this.segments.splice(s,0,new this.SegmentArc({fillColor:t.color,highlightColor:t.highlight||t.color,label:t.label,value:t.value,outerRadius:this.options.animateScale?0:this.scale.calculateCenterOffset(t.value),circumference:this.options.animateRotate?0:this.scale.getCircumference(),startAngle:1.5*Math.PI})),e||(this.reflow(),this.update())},removeData:function(t){var i=e.isNumber(t)?t:this.segments.length-1;this.segments.splice(i,1),this.reflow(),this.update()},calculateTotal:function(t){this.total=0,e.each(t,function(t){this.total+=t.value},this),this.scale.valuesCount=this.segments.length},updateScaleRange:function(t){var i=[];e.each(t,function(t){i.push(t.value)});var s=this.options.scaleOverride?{steps:this.options.scaleSteps,stepValue:this.options.scaleStepWidth,min:this.options.scaleStartValue,max:this.options.scaleStartValue+this.options.scaleSteps*this.options.scaleStepWidth}:e.calculateScaleRange(i,e.min([this.chart.width,this.chart.height])/2,this.options.scaleFontSize,this.options.scaleBeginAtZero,this.options.scaleIntegersOnly);e.extend(this.scale,s,{size:e.min([this.chart.width,this.chart.height]),xCenter:this.chart.width/2,yCenter:this.chart.height/2})},update:function(){this.calculateTotal(this.segments),e.each(this.segments,function(t){t.save()}),this.reflow(),this.render()},reflow:function(){e.extend(this.SegmentArc.prototype,{x:this.chart.width/2,y:this.chart.height/2}),this.updateScaleRange(this.segments),this.scale.update(),e.extend(this.scale,{xCenter:this.chart.width/2,yCenter:this.chart.height/2}),e.each(this.segments,function(t){t.update({outerRadius:this.scale.calculateCenterOffset(t.value)})},this)},draw:function(t){var i=t||1;this.clear(),e.each(this.segments,function(t,e){t.transition({circumference:this.scale.getCircumference(),outerRadius:this.scale.calculateCenterOffset(t.value)},i),t.endAngle=t.startAngle+t.circumference,0===e&&(t.startAngle=1.5*Math.PI),e<this.segments.length-1&&(this.segments[e+1].startAngle=t.endAngle),t.draw()},this),this.scale.draw()}})}.call(this),function(){"use strict";var t=this,i=t.Chart,e=i.helpers;i.Type.extend({name:"Radar",defaults:{scaleShowLine:!0,angleShowLineOut:!0,scaleShowLabels:!1,scaleBeginAtZero:!0,angleLineColor:"rgba(0,0,0,.1)",angleLineWidth:1,pointLabelFontFamily:"'Arial'",pointLabelFontStyle:"normal",pointLabelFontSize:10,pointLabelFontColor:"#666",pointDot:!0,pointDotRadius:3,pointDotStrokeWidth:1,pointHitDetectionRadius:20,datasetStroke:!0,datasetStrokeWidth:2,datasetFill:!0,legendTemplate:'<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].strokeColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'},initialize:function(t){this.PointClass=i.Point.extend({strokeWidth:this.options.pointDotStrokeWidth,radius:this.options.pointDotRadius,display:this.options.pointDot,hitDetectionRadius:this.options.pointHitDetectionRadius,ctx:this.chart.ctx}),this.datasets=[],this.buildScale(t),this.options.showTooltips&&e.bindEvents(this,this.options.tooltipEvents,function(t){var i="mouseout"!==t.type?this.getPointsAtEvent(t):[];this.eachPoints(function(t){t.restore(["fillColor","strokeColor"])}),e.each(i,function(t){t.fillColor=t.highlightFill,t.strokeColor=t.highlightStroke}),this.showTooltip(i)}),e.each(t.datasets,function(i){var s={label:i.label||null,fillColor:i.fillColor,strokeColor:i.strokeColor,pointColor:i.pointColor,pointStrokeColor:i.pointStrokeColor,points:[]};this.datasets.push(s),e.each(i.data,function(e,n){var o;this.scale.animation||(o=this.scale.getPointPosition(n,this.scale.calculateCenterOffset(e))),s.points.push(new this.PointClass({value:e,label:t.labels[n],datasetLabel:i.label,x:this.options.animation?this.scale.xCenter:o.x,y:this.options.animation?this.scale.yCenter:o.y,strokeColor:i.pointStrokeColor,fillColor:i.pointColor,highlightFill:i.pointHighlightFill||i.pointColor,highlightStroke:i.pointHighlightStroke||i.pointStrokeColor}))},this)},this),this.render()},eachPoints:function(t){e.each(this.datasets,function(i){e.each(i.points,t,this)},this)},getPointsAtEvent:function(t){var i=e.getRelativePosition(t),s=e.getAngleFromPoint({x:this.scale.xCenter,y:this.scale.yCenter},i),n=2*Math.PI/this.scale.valuesCount,o=Math.round((s.angle-1.5*Math.PI)/n),a=[];return(o>=this.scale.valuesCount||0>o)&&(o=0),s.distance<=this.scale.drawingArea&&e.each(this.datasets,function(t){a.push(t.points[o])}),a},buildScale:function(t){this.scale=new i.RadialScale({display:this.options.showScale,fontStyle:this.options.scaleFontStyle,fontSize:this.options.scaleFontSize,fontFamily:this.options.scaleFontFamily,fontColor:this.options.scaleFontColor,showLabels:this.options.scaleShowLabels,showLabelBackdrop:this.options.scaleShowLabelBackdrop,backdropColor:this.options.scaleBackdropColor,backdropPaddingY:this.options.scaleBackdropPaddingY,backdropPaddingX:this.options.scaleBackdropPaddingX,lineWidth:this.options.scaleShowLine?this.options.scaleLineWidth:0,lineColor:this.options.scaleLineColor,angleLineColor:this.options.angleLineColor,angleLineWidth:this.options.angleShowLineOut?this.options.angleLineWidth:0,pointLabelFontColor:this.options.pointLabelFontColor,pointLabelFontSize:this.options.pointLabelFontSize,pointLabelFontFamily:this.options.pointLabelFontFamily,pointLabelFontStyle:this.options.pointLabelFontStyle,height:this.chart.height,width:this.chart.width,xCenter:this.chart.width/2,yCenter:this.chart.height/2,ctx:this.chart.ctx,templateString:this.options.scaleLabel,labels:t.labels,valuesCount:t.datasets[0].data.length}),this.scale.setScaleSize(),this.updateScaleRange(t.datasets),this.scale.buildYLabels()},updateScaleRange:function(t){var i=function(){var i=[];return e.each(t,function(t){t.data?i=i.concat(t.data):e.each(t.points,function(t){i.push(t.value)})}),i}(),s=this.options.scaleOverride?{steps:this.options.scaleSteps,stepValue:this.options.scaleStepWidth,min:this.options.scaleStartValue,max:this.options.scaleStartValue+this.options.scaleSteps*this.options.scaleStepWidth}:e.calculateScaleRange(i,e.min([this.chart.width,this.chart.height])/2,this.options.scaleFontSize,this.options.scaleBeginAtZero,this.options.scaleIntegersOnly);e.extend(this.scale,s)},addData:function(t,i){this.scale.valuesCount++,e.each(t,function(t,e){var s=this.scale.getPointPosition(this.scale.valuesCount,this.scale.calculateCenterOffset(t));this.datasets[e].points.push(new this.PointClass({value:t,label:i,x:s.x,y:s.y,strokeColor:this.datasets[e].pointStrokeColor,fillColor:this.datasets[e].pointColor}))},this),this.scale.labels.push(i),this.reflow(),this.update()},removeData:function(){this.scale.valuesCount--,this.scale.labels.shift(),e.each(this.datasets,function(t){t.points.shift()},this),this.reflow(),this.update()},update:function(){this.eachPoints(function(t){t.save()}),this.reflow(),this.render()},reflow:function(){e.extend(this.scale,{width:this.chart.width,height:this.chart.height,size:e.min([this.chart.width,this.chart.height]),xCenter:this.chart.width/2,yCenter:this.chart.height/2}),this.updateScaleRange(this.datasets),this.scale.setScaleSize(),this.scale.buildYLabels()},draw:function(t){var i=t||1,s=this.chart.ctx;this.clear(),this.scale.draw(),e.each(this.datasets,function(t){e.each(t.points,function(t,e){t.hasValue()&&t.transition(this.scale.getPointPosition(e,this.scale.calculateCenterOffset(t.value)),i)},this),s.lineWidth=this.options.datasetStrokeWidth,s.strokeStyle=t.strokeColor,s.beginPath(),e.each(t.points,function(t,i){0===i?s.moveTo(t.x,t.y):s.lineTo(t.x,t.y)},this),s.closePath(),s.stroke(),s.fillStyle=t.fillColor,s.fill(),e.each(t.points,function(t){t.hasValue()&&t.draw()})},this)}})}.call(this);
Chart.defaults.global = {
    // Boolean - Whether to animate the chart
    animation: true,

    // Number - Number of animation steps
    animationSteps: 60,

    // String - Animation easing effect
    // Possible effects are:
    // [easeInOutQuart, linear, easeOutBounce, easeInBack, easeInOutQuad,
    //  easeOutQuart, easeOutQuad, easeInOutBounce, easeOutSine, easeInOutCubic,
    //  easeInExpo, easeInOutBack, easeInCirc, easeInOutElastic, easeOutBack,
    //  easeInQuad, easeInOutExpo, easeInQuart, easeOutQuint, easeInOutCirc,
    //  easeInSine, easeOutExpo, easeOutCirc, easeOutCubic, easeInQuint,
    //  easeInElastic, easeInOutSine, easeInOutQuint, easeInBounce,
    //  easeOutElastic, easeInCubic]
    animationEasing: "easeOutQuart",

    // Boolean - If we should show the scale at all
    showScale: true,

    // Boolean - If we want to override with a hard coded scale
    scaleOverride: false,

    // ** Required if scaleOverride is true **
    // Number - The number of steps in a hard coded scale
    scaleSteps: null,
    // Number - The value jump in the hard coded scale
    scaleStepWidth: null,
    // Number - The scale starting value
    scaleStartValue: null,

    // String - Colour of the scale line
    scaleLineColor: "rgba(0,0,0,.1)",

    // Number - Pixel width of the scale line
    scaleLineWidth: 1,

    // Boolean - Whether to show labels on the scale
    scaleShowLabels: true,

    // Interpolated JS string - can access value
    scaleLabel: "<%=value%>",

    // Boolean - Whether the scale should stick to integers, not floats even if drawing space is there
    scaleIntegersOnly: true,

    // Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero: false,

    // String - Scale label font declaration for the scale label
    scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

    // Number - Scale label font size in pixels
    scaleFontSize: 12,

    // String - Scale label font weight style
    scaleFontStyle: "normal",

    // String - Scale label font colour
    scaleFontColor: "#666",

    // Boolean - whether or not the chart should be responsive and resize when the browser does.
    responsive: true,

    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,

    // Boolean - Determines whether to draw tooltips on the canvas or not
    showTooltips: true,

    // Function - Determines whether to execute the customTooltips function instead of drawing the built in tooltips (See [Advanced - External Tooltips](#advanced-usage-custom-tooltips))
    customTooltips: false,

    // Array - Array of string names to attach tooltip events
    tooltipEvents: ["mousemove", "touchstart", "touchmove"],

    // String - Tooltip background colour
    tooltipFillColor: "rgba(0,0,0,0.8)",

    // String - Tooltip label font declaration for the scale label
    tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

    // Number - Tooltip label font size in pixels
    tooltipFontSize: 14,

    // String - Tooltip font weight style
    tooltipFontStyle: "normal",

    // String - Tooltip label font colour
    tooltipFontColor: "#fff",

    // String - Tooltip title font declaration for the scale label
    tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

    // Number - Tooltip title font size in pixels
    tooltipTitleFontSize: 14,

    // String - Tooltip title font weight style
    tooltipTitleFontStyle: "bold",

    // String - Tooltip title font colour
    tooltipTitleFontColor: "#fff",

    // Number - pixel width of padding around tooltip text
    tooltipYPadding: 6,

    // Number - pixel width of padding around tooltip text
    tooltipXPadding: 6,

    // Number - Size of the caret on the tooltip
    tooltipCaretSize: 8,

    // Number - Pixel radius of the tooltip border
    tooltipCornerRadius: 6,

    // Number - Pixel offset from point x to tooltip edge
    tooltipXOffset: 10,

    // String - Template string for single tooltips
    tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",

    // String - Template string for multiple tooltips
    multiTooltipTemplate: "<%= value %>",


    // Function - Will fire on animation progression.
    onAnimationProgress: function(){},

    // Function - Will fire on animation completion.
    onAnimationComplete: function(){}
}

if(document.getElementById("course-graph") != undefined) {
    var ctx = document.getElementById("course-graph").getContext("2d");
    var sales_ctx = document.getElementById("sales-graph").getContext("2d");

    ctx.canvas.width = 50;
    ctx.canvas.height = 50;
    //sales_ctx.canvas.width = 300;
    sales_ctx.canvas.height = 100;

    create_chart_by_time(sales_ctx, 'annual', 'courses', 0)
    create_pie_chart(ctx, 'courses');

}
function create_chart_by_time(selector, period, type, specific){
    console.log('creating');
    $.ajax({
    url: "/admin/courses/report",
        type: "POST",
        data: {
            period: period,
            type: type,
            specific: specific,
    },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
    cache: false,

        success: function(data){
            console.log(data);
            var data_keys = [];
            var data_values = [];

            $.each(data,function(key,value){
                data_keys.push(key);
                data_values.push(value);
            });




            var values = {
                labels: data_keys,
                datasets: [
                    {
                        label: 'Cursos vendidos',
                        fillColor: "rgba(60,60,60,0.2)",
                        strokeColor: "rgba(60,60,60,1)",
                        pointColor: "rgba(60,60,60,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,60,60,1)",
                        data: data_values
                    }]
            };
            console.log(values);


            var time_line_chart = new Chart(selector).Line(values,{
                bezierCurve: true,
                responsive: true
            });

        }
    });






}


function create_pie_chart(selector, type){
    console.log('creating');
    $.ajax({
        url: "/admin/courses/totalSales",
        type: "POST",
        data: {
            type: type
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,

        success: function(data){
            console.log(data);
            var total_data = [];
            var color = '';


            $.each(data,function(key,value){

                r = Math.floor(Math.random() * 200) + 50;
                console.log(r);
                g = Math.floor(Math.random() * 200) + 50;
                console.log(g);
                b = Math.floor(Math.random() * 200) + 50;
                console.log(b);
                color = 'rgb(' + r + ', ' + g + ', ' + b + ')';
                //data_keys.push(key);
                //data_values.push(value);
                console.log(value);
                total_data.push({
                    value: value,
                    label: key,
                    color: color
                });
            });

            console.log('finishing');
            console.log(total_data);


            //console.log(values);


            var time_line_chart = new Chart(selector).Pie(total_data,{

                animateRotate : true,
                legendTemplate:   "<table class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><tr><td><i class=\"fa fa-square\" style=\"color:<%=segments[i].fillColor%>; font-size: 3.0rem;\" ></i>&nbsp;&nbsp;<%if(segments[i].label){%><%=segments[i].label%><%}%></td></tr><%}%></table>"
            });

            console.log(time_line_chart.generateLegend())
            $("#course-legend").html(time_line_chart.generateLegend());

        }
    });




}









//# sourceMappingURL=backend.js.map
