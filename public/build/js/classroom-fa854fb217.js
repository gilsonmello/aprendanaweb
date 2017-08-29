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

            $(".textarea").wysihtml5();
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


/**
 * Created by ambiente on 09/03/16.
 */


console.log('calling notify');
add_read_notify();

function add_read_notify(){
$(".notification-item").click(function(){
    console.log('clicado');
    $.ajax({
        url: "/notification/read-notification",
        type: "POST",
        data: { 'notification': $(this).data('notification-id')
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){
            console.log('Comentário lido');
        }
    });
});
}


/* Modernizr 2.6.2 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-cssanimations-csstransitions-touch-shiv-cssclasses-prefixed-teststyles-testprop-testallprops-prefixes-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function z(a){j.cssText=a}function A(a,b){return z(m.join(a+";")+(b||""))}function B(a,b){return typeof a===b}function C(a,b){return!!~(""+a).indexOf(b)}function D(a,b){for(var d in a){var e=a[d];if(!C(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function E(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:B(f,"function")?f.bind(d||b):f}return!1}function F(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+o.join(d+" ")+d).split(" ");return B(b,"string")||B(b,"undefined")?D(e,b):(e=(a+" "+p.join(d+" ")+d).split(" "),E(e,b,c))}var d="2.6.2",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m=" -webkit- -moz- -o- -ms- ".split(" "),n="Webkit Moz O ms",o=n.split(" "),p=n.toLowerCase().split(" "),q={},r={},s={},t=[],u=t.slice,v,w=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},x={}.hasOwnProperty,y;!B(x,"undefined")&&!B(x.call,"undefined")?y=function(a,b){return x.call(a,b)}:y=function(a,b){return b in a&&B(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=u.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(u.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(u.call(arguments)))};return e}),q.touch=function(){var c;return"ontouchstart"in a||a.DocumentTouch&&b instanceof DocumentTouch?c=!0:w(["@media (",m.join("touch-enabled),("),h,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(a){c=a.offsetTop===9}),c},q.cssanimations=function(){return F("animationName")},q.csstransitions=function(){return F("transition")};for(var G in q)y(q,G)&&(v=G.toLowerCase(),e[v]=q[G](),t.push((e[v]?"":"no-")+v));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)y(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},z(""),i=k=null,function(a,b){function k(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function l(){var a=r.elements;return typeof a=="string"?a.split(" "):a}function m(a){var b=i[a[g]];return b||(b={},h++,a[g]=h,i[h]=b),b}function n(a,c,f){c||(c=b);if(j)return c.createElement(a);f||(f=m(c));var g;return f.cache[a]?g=f.cache[a].cloneNode():e.test(a)?g=(f.cache[a]=f.createElem(a)).cloneNode():g=f.createElem(a),g.canHaveChildren&&!d.test(a)?f.frag.appendChild(g):g}function o(a,c){a||(a=b);if(j)return a.createDocumentFragment();c=c||m(a);var d=c.frag.cloneNode(),e=0,f=l(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function p(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return r.shivMethods?n(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+l().join().replace(/\w+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(r,b.frag)}function q(a){a||(a=b);var c=m(a);return r.shivCSS&&!f&&!c.hasCSS&&(c.hasCSS=!!k(a,"article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}")),j||p(a,c),a}var c=a.html5||{},d=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,e=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,f,g="_html5shiv",h=0,i={},j;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",f="hidden"in a,j=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){f=!0,j=!0}})();var r={elements:c.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:c.shivCSS!==!1,supportsUnknownElements:j,shivMethods:c.shivMethods!==!1,type:"default",shivDocument:q,createElement:n,createDocumentFragment:o};a.html5=r,q(b)}(this,b),e._version=d,e._prefixes=m,e._domPrefixes=p,e._cssomPrefixes=o,e.testProp=function(a){return D([a])},e.testAllProps=F,e.testStyles=w,e.prefixed=function(a,b,c){return b?F(a,b,c):F(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+t.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};
/*! jQuery UI - v1.10.4 - 2014-07-22
* http://jqueryui.com
* Includes: jquery.ui.core.js, jquery.ui.widget.js, jquery.ui.mouse.js, jquery.ui.draggable.js, jquery.ui.droppable.js, jquery.ui.resizable.js, jquery.ui.sortable.js, jquery.ui.button.js, jquery.ui.slider.js, jquery.ui.spinner.js
* Copyright 2014 jQuery Foundation and other contributors; Licensed MIT */

(function( $, undefined ) {

var uuid = 0,
	runiqueId = /^ui-id-\d+$/;

// $.ui might exist from components with no dependencies, e.g., $.ui.position
$.ui = $.ui || {};

$.extend( $.ui, {
	version: "1.10.4",

	keyCode: {
		BACKSPACE: 8,
		COMMA: 188,
		DELETE: 46,
		DOWN: 40,
		END: 35,
		ENTER: 13,
		ESCAPE: 27,
		HOME: 36,
		LEFT: 37,
		NUMPAD_ADD: 107,
		NUMPAD_DECIMAL: 110,
		NUMPAD_DIVIDE: 111,
		NUMPAD_ENTER: 108,
		NUMPAD_MULTIPLY: 106,
		NUMPAD_SUBTRACT: 109,
		PAGE_DOWN: 34,
		PAGE_UP: 33,
		PERIOD: 190,
		RIGHT: 39,
		SPACE: 32,
		TAB: 9,
		UP: 38
	}
});

// plugins
$.fn.extend({
	focus: (function( orig ) {
		return function( delay, fn ) {
			return typeof delay === "number" ?
				this.each(function() {
					var elem = this;
					setTimeout(function() {
						$( elem ).focus();
						if ( fn ) {
							fn.call( elem );
						}
					}, delay );
				}) :
				orig.apply( this, arguments );
		};
	})( $.fn.focus ),

	scrollParent: function() {
		var scrollParent;
		if (($.ui.ie && (/(static|relative)/).test(this.css("position"))) || (/absolute/).test(this.css("position"))) {
			scrollParent = this.parents().filter(function() {
				return (/(relative|absolute|fixed)/).test($.css(this,"position")) && (/(auto|scroll)/).test($.css(this,"overflow")+$.css(this,"overflow-y")+$.css(this,"overflow-x"));
			}).eq(0);
		} else {
			scrollParent = this.parents().filter(function() {
				return (/(auto|scroll)/).test($.css(this,"overflow")+$.css(this,"overflow-y")+$.css(this,"overflow-x"));
			}).eq(0);
		}

		return (/fixed/).test(this.css("position")) || !scrollParent.length ? $(document) : scrollParent;
	},

	zIndex: function( zIndex ) {
		if ( zIndex !== undefined ) {
			return this.css( "zIndex", zIndex );
		}

		if ( this.length ) {
			var elem = $( this[ 0 ] ), position, value;
			while ( elem.length && elem[ 0 ] !== document ) {
				// Ignore z-index if position is set to a value where z-index is ignored by the browser
				// This makes behavior of this function consistent across browsers
				// WebKit always returns auto if the element is positioned
				position = elem.css( "position" );
				if ( position === "absolute" || position === "relative" || position === "fixed" ) {
					// IE returns 0 when zIndex is not specified
					// other browsers return a string
					// we ignore the case of nested elements with an explicit value of 0
					// <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
					value = parseInt( elem.css( "zIndex" ), 10 );
					if ( !isNaN( value ) && value !== 0 ) {
						return value;
					}
				}
				elem = elem.parent();
			}
		}

		return 0;
	},

	uniqueId: function() {
		return this.each(function() {
			if ( !this.id ) {
				this.id = "ui-id-" + (++uuid);
			}
		});
	},

	removeUniqueId: function() {
		return this.each(function() {
			if ( runiqueId.test( this.id ) ) {
				$( this ).removeAttr( "id" );
			}
		});
	}
});

// selectors
function focusable( element, isTabIndexNotNaN ) {
	var map, mapName, img,
		nodeName = element.nodeName.toLowerCase();
	if ( "area" === nodeName ) {
		map = element.parentNode;
		mapName = map.name;
		if ( !element.href || !mapName || map.nodeName.toLowerCase() !== "map" ) {
			return false;
		}
		img = $( "img[usemap=#" + mapName + "]" )[0];
		return !!img && visible( img );
	}
	return ( /input|select|textarea|button|object/.test( nodeName ) ?
		!element.disabled :
		"a" === nodeName ?
			element.href || isTabIndexNotNaN :
			isTabIndexNotNaN) &&
		// the element and all of its ancestors must be visible
		visible( element );
}

function visible( element ) {
	return $.expr.filters.visible( element ) &&
		!$( element ).parents().addBack().filter(function() {
			return $.css( this, "visibility" ) === "hidden";
		}).length;
}

$.extend( $.expr[ ":" ], {
	data: $.expr.createPseudo ?
		$.expr.createPseudo(function( dataName ) {
			return function( elem ) {
				return !!$.data( elem, dataName );
			};
		}) :
		// support: jQuery <1.8
		function( elem, i, match ) {
			return !!$.data( elem, match[ 3 ] );
		},

	focusable: function( element ) {
		return focusable( element, !isNaN( $.attr( element, "tabindex" ) ) );
	},

	tabbable: function( element ) {
		var tabIndex = $.attr( element, "tabindex" ),
			isTabIndexNaN = isNaN( tabIndex );
		return ( isTabIndexNaN || tabIndex >= 0 ) && focusable( element, !isTabIndexNaN );
	}
});

// support: jQuery <1.8
if ( !$( "<a>" ).outerWidth( 1 ).jquery ) {
	$.each( [ "Width", "Height" ], function( i, name ) {
		var side = name === "Width" ? [ "Left", "Right" ] : [ "Top", "Bottom" ],
			type = name.toLowerCase(),
			orig = {
				innerWidth: $.fn.innerWidth,
				innerHeight: $.fn.innerHeight,
				outerWidth: $.fn.outerWidth,
				outerHeight: $.fn.outerHeight
			};

		function reduce( elem, size, border, margin ) {
			$.each( side, function() {
				size -= parseFloat( $.css( elem, "padding" + this ) ) || 0;
				if ( border ) {
					size -= parseFloat( $.css( elem, "border" + this + "Width" ) ) || 0;
				}
				if ( margin ) {
					size -= parseFloat( $.css( elem, "margin" + this ) ) || 0;
				}
			});
			return size;
		}

		$.fn[ "inner" + name ] = function( size ) {
			if ( size === undefined ) {
				return orig[ "inner" + name ].call( this );
			}

			return this.each(function() {
				$( this ).css( type, reduce( this, size ) + "px" );
			});
		};

		$.fn[ "outer" + name] = function( size, margin ) {
			if ( typeof size !== "number" ) {
				return orig[ "outer" + name ].call( this, size );
			}

			return this.each(function() {
				$( this).css( type, reduce( this, size, true, margin ) + "px" );
			});
		};
	});
}

// support: jQuery <1.8
if ( !$.fn.addBack ) {
	$.fn.addBack = function( selector ) {
		return this.add( selector == null ?
			this.prevObject : this.prevObject.filter( selector )
		);
	};
}

// support: jQuery 1.6.1, 1.6.2 (http://bugs.jquery.com/ticket/9413)
if ( $( "<a>" ).data( "a-b", "a" ).removeData( "a-b" ).data( "a-b" ) ) {
	$.fn.removeData = (function( removeData ) {
		return function( key ) {
			if ( arguments.length ) {
				return removeData.call( this, $.camelCase( key ) );
			} else {
				return removeData.call( this );
			}
		};
	})( $.fn.removeData );
}





// deprecated
$.ui.ie = !!/msie [\w.]+/.exec( navigator.userAgent.toLowerCase() );

$.support.selectstart = "onselectstart" in document.createElement( "div" );
$.fn.extend({
	disableSelection: function() {
		return this.bind( ( $.support.selectstart ? "selectstart" : "mousedown" ) +
			".ui-disableSelection", function( event ) {
				event.preventDefault();
			});
	},

	enableSelection: function() {
		return this.unbind( ".ui-disableSelection" );
	}
});

$.extend( $.ui, {
	// $.ui.plugin is deprecated. Use $.widget() extensions instead.
	plugin: {
		add: function( module, option, set ) {
			var i,
				proto = $.ui[ module ].prototype;
			for ( i in set ) {
				proto.plugins[ i ] = proto.plugins[ i ] || [];
				proto.plugins[ i ].push( [ option, set[ i ] ] );
			}
		},
		call: function( instance, name, args ) {
			var i,
				set = instance.plugins[ name ];
			if ( !set || !instance.element[ 0 ].parentNode || instance.element[ 0 ].parentNode.nodeType === 11 ) {
				return;
			}

			for ( i = 0; i < set.length; i++ ) {
				if ( instance.options[ set[ i ][ 0 ] ] ) {
					set[ i ][ 1 ].apply( instance.element, args );
				}
			}
		}
	},

	// only used by resizable
	hasScroll: function( el, a ) {

		//If overflow is hidden, the element might have extra content, but the user wants to hide it
		if ( $( el ).css( "overflow" ) === "hidden") {
			return false;
		}

		var scroll = ( a && a === "left" ) ? "scrollLeft" : "scrollTop",
			has = false;

		if ( el[ scroll ] > 0 ) {
			return true;
		}

		// TODO: determine which cases actually cause this to happen
		// if the element doesn't have the scroll set, see if it's possible to
		// set the scroll
		el[ scroll ] = 1;
		has = ( el[ scroll ] > 0 );
		el[ scroll ] = 0;
		return has;
	}
});

})( jQuery );
(function( $, undefined ) {

var uuid = 0,
	slice = Array.prototype.slice,
	_cleanData = $.cleanData;
$.cleanData = function( elems ) {
	for ( var i = 0, elem; (elem = elems[i]) != null; i++ ) {
		try {
			$( elem ).triggerHandler( "remove" );
		// http://bugs.jquery.com/ticket/8235
		} catch( e ) {}
	}
	_cleanData( elems );
};

$.widget = function( name, base, prototype ) {
	var fullName, existingConstructor, constructor, basePrototype,
		// proxiedPrototype allows the provided prototype to remain unmodified
		// so that it can be used as a mixin for multiple widgets (#8876)
		proxiedPrototype = {},
		namespace = name.split( "." )[ 0 ];

	name = name.split( "." )[ 1 ];
	fullName = namespace + "-" + name;

	if ( !prototype ) {
		prototype = base;
		base = $.Widget;
	}

	// create selector for plugin
	$.expr[ ":" ][ fullName.toLowerCase() ] = function( elem ) {
		return !!$.data( elem, fullName );
	};

	$[ namespace ] = $[ namespace ] || {};
	existingConstructor = $[ namespace ][ name ];
	constructor = $[ namespace ][ name ] = function( options, element ) {
		// allow instantiation without "new" keyword
		if ( !this._createWidget ) {
			return new constructor( options, element );
		}

		// allow instantiation without initializing for simple inheritance
		// must use "new" keyword (the code above always passes args)
		if ( arguments.length ) {
			this._createWidget( options, element );
		}
	};
	// extend with the existing constructor to carry over any static properties
	$.extend( constructor, existingConstructor, {
		version: prototype.version,
		// copy the object used to create the prototype in case we need to
		// redefine the widget later
		_proto: $.extend( {}, prototype ),
		// track widgets that inherit from this widget in case this widget is
		// redefined after a widget inherits from it
		_childConstructors: []
	});

	basePrototype = new base();
	// we need to make the options hash a property directly on the new instance
	// otherwise we'll modify the options hash on the prototype that we're
	// inheriting from
	basePrototype.options = $.widget.extend( {}, basePrototype.options );
	$.each( prototype, function( prop, value ) {
		if ( !$.isFunction( value ) ) {
			proxiedPrototype[ prop ] = value;
			return;
		}
		proxiedPrototype[ prop ] = (function() {
			var _super = function() {
					return base.prototype[ prop ].apply( this, arguments );
				},
				_superApply = function( args ) {
					return base.prototype[ prop ].apply( this, args );
				};
			return function() {
				var __super = this._super,
					__superApply = this._superApply,
					returnValue;

				this._super = _super;
				this._superApply = _superApply;

				returnValue = value.apply( this, arguments );

				this._super = __super;
				this._superApply = __superApply;

				return returnValue;
			};
		})();
	});
	constructor.prototype = $.widget.extend( basePrototype, {
		// TODO: remove support for widgetEventPrefix
		// always use the name + a colon as the prefix, e.g., draggable:start
		// don't prefix for widgets that aren't DOM-based
		widgetEventPrefix: existingConstructor ? (basePrototype.widgetEventPrefix || name) : name
	}, proxiedPrototype, {
		constructor: constructor,
		namespace: namespace,
		widgetName: name,
		widgetFullName: fullName
	});

	// If this widget is being redefined then we need to find all widgets that
	// are inheriting from it and redefine all of them so that they inherit from
	// the new version of this widget. We're essentially trying to replace one
	// level in the prototype chain.
	if ( existingConstructor ) {
		$.each( existingConstructor._childConstructors, function( i, child ) {
			var childPrototype = child.prototype;

			// redefine the child widget using the same prototype that was
			// originally used, but inherit from the new version of the base
			$.widget( childPrototype.namespace + "." + childPrototype.widgetName, constructor, child._proto );
		});
		// remove the list of existing child constructors from the old constructor
		// so the old child constructors can be garbage collected
		delete existingConstructor._childConstructors;
	} else {
		base._childConstructors.push( constructor );
	}

	$.widget.bridge( name, constructor );
};

$.widget.extend = function( target ) {
	var input = slice.call( arguments, 1 ),
		inputIndex = 0,
		inputLength = input.length,
		key,
		value;
	for ( ; inputIndex < inputLength; inputIndex++ ) {
		for ( key in input[ inputIndex ] ) {
			value = input[ inputIndex ][ key ];
			if ( input[ inputIndex ].hasOwnProperty( key ) && value !== undefined ) {
				// Clone objects
				if ( $.isPlainObject( value ) ) {
					target[ key ] = $.isPlainObject( target[ key ] ) ?
						$.widget.extend( {}, target[ key ], value ) :
						// Don't extend strings, arrays, etc. with objects
						$.widget.extend( {}, value );
				// Copy everything else by reference
				} else {
					target[ key ] = value;
				}
			}
		}
	}
	return target;
};

$.widget.bridge = function( name, object ) {
	var fullName = object.prototype.widgetFullName || name;
	$.fn[ name ] = function( options ) {
		var isMethodCall = typeof options === "string",
			args = slice.call( arguments, 1 ),
			returnValue = this;

		// allow multiple hashes to be passed on init
		options = !isMethodCall && args.length ?
			$.widget.extend.apply( null, [ options ].concat(args) ) :
			options;

		if ( isMethodCall ) {
			this.each(function() {
				var methodValue,
					instance = $.data( this, fullName );
				if ( !instance ) {
					return $.error( "cannot call methods on " + name + " prior to initialization; " +
						"attempted to call method '" + options + "'" );
				}
				if ( !$.isFunction( instance[options] ) || options.charAt( 0 ) === "_" ) {
					return $.error( "no such method '" + options + "' for " + name + " widget instance" );
				}
				methodValue = instance[ options ].apply( instance, args );
				if ( methodValue !== instance && methodValue !== undefined ) {
					returnValue = methodValue && methodValue.jquery ?
						returnValue.pushStack( methodValue.get() ) :
						methodValue;
					return false;
				}
			});
		} else {
			this.each(function() {
				var instance = $.data( this, fullName );
				if ( instance ) {
					instance.option( options || {} )._init();
				} else {
					$.data( this, fullName, new object( options, this ) );
				}
			});
		}

		return returnValue;
	};
};

$.Widget = function( /* options, element */ ) {};
$.Widget._childConstructors = [];

$.Widget.prototype = {
	widgetName: "widget",
	widgetEventPrefix: "",
	defaultElement: "<div>",
	options: {
		disabled: false,

		// callbacks
		create: null
	},
	_createWidget: function( options, element ) {
		element = $( element || this.defaultElement || this )[ 0 ];
		this.element = $( element );
		this.uuid = uuid++;
		this.eventNamespace = "." + this.widgetName + this.uuid;
		this.options = $.widget.extend( {},
			this.options,
			this._getCreateOptions(),
			options );

		this.bindings = $();
		this.hoverable = $();
		this.focusable = $();

		if ( element !== this ) {
			$.data( element, this.widgetFullName, this );
			this._on( true, this.element, {
				remove: function( event ) {
					if ( event.target === element ) {
						this.destroy();
					}
				}
			});
			this.document = $( element.style ?
				// element within the document
				element.ownerDocument :
				// element is window or document
				element.document || element );
			this.window = $( this.document[0].defaultView || this.document[0].parentWindow );
		}

		this._create();
		this._trigger( "create", null, this._getCreateEventData() );
		this._init();
	},
	_getCreateOptions: $.noop,
	_getCreateEventData: $.noop,
	_create: $.noop,
	_init: $.noop,

	destroy: function() {
		this._destroy();
		// we can probably remove the unbind calls in 2.0
		// all event bindings should go through this._on()
		this.element
			.unbind( this.eventNamespace )
			// 1.9 BC for #7810
			// TODO remove dual storage
			.removeData( this.widgetName )
			.removeData( this.widgetFullName )
			// support: jquery <1.6.3
			// http://bugs.jquery.com/ticket/9413
			.removeData( $.camelCase( this.widgetFullName ) );
		this.widget()
			.unbind( this.eventNamespace )
			.removeAttr( "aria-disabled" )
			.removeClass(
				this.widgetFullName + "-disabled " +
				"ui-state-disabled" );

		// clean up events and states
		this.bindings.unbind( this.eventNamespace );
		this.hoverable.removeClass( "ui-state-hover" );
		this.focusable.removeClass( "ui-state-focus" );
	},
	_destroy: $.noop,

	widget: function() {
		return this.element;
	},

	option: function( key, value ) {
		var options = key,
			parts,
			curOption,
			i;

		if ( arguments.length === 0 ) {
			// don't return a reference to the internal hash
			return $.widget.extend( {}, this.options );
		}

		if ( typeof key === "string" ) {
			// handle nested keys, e.g., "foo.bar" => { foo: { bar: ___ } }
			options = {};
			parts = key.split( "." );
			key = parts.shift();
			if ( parts.length ) {
				curOption = options[ key ] = $.widget.extend( {}, this.options[ key ] );
				for ( i = 0; i < parts.length - 1; i++ ) {
					curOption[ parts[ i ] ] = curOption[ parts[ i ] ] || {};
					curOption = curOption[ parts[ i ] ];
				}
				key = parts.pop();
				if ( arguments.length === 1 ) {
					return curOption[ key ] === undefined ? null : curOption[ key ];
				}
				curOption[ key ] = value;
			} else {
				if ( arguments.length === 1 ) {
					return this.options[ key ] === undefined ? null : this.options[ key ];
				}
				options[ key ] = value;
			}
		}

		this._setOptions( options );

		return this;
	},
	_setOptions: function( options ) {
		var key;

		for ( key in options ) {
			this._setOption( key, options[ key ] );
		}

		return this;
	},
	_setOption: function( key, value ) {
		this.options[ key ] = value;

		if ( key === "disabled" ) {
			this.widget()
				.toggleClass( this.widgetFullName + "-disabled ui-state-disabled", !!value )
				.attr( "aria-disabled", value );
			this.hoverable.removeClass( "ui-state-hover" );
			this.focusable.removeClass( "ui-state-focus" );
		}

		return this;
	},

	enable: function() {
		return this._setOption( "disabled", false );
	},
	disable: function() {
		return this._setOption( "disabled", true );
	},

	_on: function( suppressDisabledCheck, element, handlers ) {
		var delegateElement,
			instance = this;

		// no suppressDisabledCheck flag, shuffle arguments
		if ( typeof suppressDisabledCheck !== "boolean" ) {
			handlers = element;
			element = suppressDisabledCheck;
			suppressDisabledCheck = false;
		}

		// no element argument, shuffle and use this.element
		if ( !handlers ) {
			handlers = element;
			element = this.element;
			delegateElement = this.widget();
		} else {
			// accept selectors, DOM elements
			element = delegateElement = $( element );
			this.bindings = this.bindings.add( element );
		}

		$.each( handlers, function( event, handler ) {
			function handlerProxy() {
				// allow widgets to customize the disabled handling
				// - disabled as an array instead of boolean
				// - disabled class as method for disabling individual parts
				if ( !suppressDisabledCheck &&
						( instance.options.disabled === true ||
							$( this ).hasClass( "ui-state-disabled" ) ) ) {
					return;
				}
				return ( typeof handler === "string" ? instance[ handler ] : handler )
					.apply( instance, arguments );
			}

			// copy the guid so direct unbinding works
			if ( typeof handler !== "string" ) {
				handlerProxy.guid = handler.guid =
					handler.guid || handlerProxy.guid || $.guid++;
			}

			var match = event.match( /^(\w+)\s*(.*)$/ ),
				eventName = match[1] + instance.eventNamespace,
				selector = match[2];
			if ( selector ) {
				delegateElement.delegate( selector, eventName, handlerProxy );
			} else {
				element.bind( eventName, handlerProxy );
			}
		});
	},

	_off: function( element, eventName ) {
		eventName = (eventName || "").split( " " ).join( this.eventNamespace + " " ) + this.eventNamespace;
		element.unbind( eventName ).undelegate( eventName );
	},

	_delay: function( handler, delay ) {
		function handlerProxy() {
			return ( typeof handler === "string" ? instance[ handler ] : handler )
				.apply( instance, arguments );
		}
		var instance = this;
		return setTimeout( handlerProxy, delay || 0 );
	},

	_hoverable: function( element ) {
		this.hoverable = this.hoverable.add( element );
		this._on( element, {
			mouseenter: function( event ) {
				$( event.currentTarget ).addClass( "ui-state-hover" );
			},
			mouseleave: function( event ) {
				$( event.currentTarget ).removeClass( "ui-state-hover" );
			}
		});
	},

	_focusable: function( element ) {
		this.focusable = this.focusable.add( element );
		this._on( element, {
			focusin: function( event ) {
				$( event.currentTarget ).addClass( "ui-state-focus" );
			},
			focusout: function( event ) {
				$( event.currentTarget ).removeClass( "ui-state-focus" );
			}
		});
	},

	_trigger: function( type, event, data ) {
		var prop, orig,
			callback = this.options[ type ];

		data = data || {};
		event = $.Event( event );
		event.type = ( type === this.widgetEventPrefix ?
			type :
			this.widgetEventPrefix + type ).toLowerCase();
		// the original event may come from any element
		// so we need to reset the target on the new event
		event.target = this.element[ 0 ];

		// copy original event properties over to the new event
		orig = event.originalEvent;
		if ( orig ) {
			for ( prop in orig ) {
				if ( !( prop in event ) ) {
					event[ prop ] = orig[ prop ];
				}
			}
		}

		this.element.trigger( event, data );
		return !( $.isFunction( callback ) &&
			callback.apply( this.element[0], [ event ].concat( data ) ) === false ||
			event.isDefaultPrevented() );
	}
};

$.each( { show: "fadeIn", hide: "fadeOut" }, function( method, defaultEffect ) {
	$.Widget.prototype[ "_" + method ] = function( element, options, callback ) {
		if ( typeof options === "string" ) {
			options = { effect: options };
		}
		var hasOptions,
			effectName = !options ?
				method :
				options === true || typeof options === "number" ?
					defaultEffect :
					options.effect || defaultEffect;
		options = options || {};
		if ( typeof options === "number" ) {
			options = { duration: options };
		}
		hasOptions = !$.isEmptyObject( options );
		options.complete = callback;
		if ( options.delay ) {
			element.delay( options.delay );
		}
		if ( hasOptions && $.effects && $.effects.effect[ effectName ] ) {
			element[ method ]( options );
		} else if ( effectName !== method && element[ effectName ] ) {
			element[ effectName ]( options.duration, options.easing, callback );
		} else {
			element.queue(function( next ) {
				$( this )[ method ]();
				if ( callback ) {
					callback.call( element[ 0 ] );
				}
				next();
			});
		}
	};
});

})( jQuery );
(function( $, undefined ) {

var mouseHandled = false;
$( document ).mouseup( function() {
	mouseHandled = false;
});

$.widget("ui.mouse", {
	version: "1.10.4",
	options: {
		cancel: "input,textarea,button,select,option",
		distance: 1,
		delay: 0
	},
	_mouseInit: function() {
		var that = this;

		this.element
			.bind("mousedown."+this.widgetName, function(event) {
				return that._mouseDown(event);
			})
			.bind("click."+this.widgetName, function(event) {
				if (true === $.data(event.target, that.widgetName + ".preventClickEvent")) {
					$.removeData(event.target, that.widgetName + ".preventClickEvent");
					event.stopImmediatePropagation();
					return false;
				}
			});

		this.started = false;
	},

	// TODO: make sure destroying one instance of mouse doesn't mess with
	// other instances of mouse
	_mouseDestroy: function() {
		this.element.unbind("."+this.widgetName);
		if ( this._mouseMoveDelegate ) {
			$(document)
				.unbind("mousemove."+this.widgetName, this._mouseMoveDelegate)
				.unbind("mouseup."+this.widgetName, this._mouseUpDelegate);
		}
	},

	_mouseDown: function(event) {
		// don't let more than one widget handle mouseStart
		if( mouseHandled ) { return; }

		// we may have missed mouseup (out of window)
		(this._mouseStarted && this._mouseUp(event));

		this._mouseDownEvent = event;

		var that = this,
			btnIsLeft = (event.which === 1),
			// event.target.nodeName works around a bug in IE 8 with
			// disabled inputs (#7620)
			elIsCancel = (typeof this.options.cancel === "string" && event.target.nodeName ? $(event.target).closest(this.options.cancel).length : false);
		if (!btnIsLeft || elIsCancel || !this._mouseCapture(event)) {
			return true;
		}

		this.mouseDelayMet = !this.options.delay;
		if (!this.mouseDelayMet) {
			this._mouseDelayTimer = setTimeout(function() {
				that.mouseDelayMet = true;
			}, this.options.delay);
		}

		if (this._mouseDistanceMet(event) && this._mouseDelayMet(event)) {
			this._mouseStarted = (this._mouseStart(event) !== false);
			if (!this._mouseStarted) {
				event.preventDefault();
				return true;
			}
		}

		// Click event may never have fired (Gecko & Opera)
		if (true === $.data(event.target, this.widgetName + ".preventClickEvent")) {
			$.removeData(event.target, this.widgetName + ".preventClickEvent");
		}

		// these delegates are required to keep context
		this._mouseMoveDelegate = function(event) {
			return that._mouseMove(event);
		};
		this._mouseUpDelegate = function(event) {
			return that._mouseUp(event);
		};
		$(document)
			.bind("mousemove."+this.widgetName, this._mouseMoveDelegate)
			.bind("mouseup."+this.widgetName, this._mouseUpDelegate);

		event.preventDefault();

		mouseHandled = true;
		return true;
	},

	_mouseMove: function(event) {
		// IE mouseup check - mouseup happened when mouse was out of window
		if ($.ui.ie && ( !document.documentMode || document.documentMode < 9 ) && !event.button) {
			return this._mouseUp(event);
		}

		if (this._mouseStarted) {
			this._mouseDrag(event);
			return event.preventDefault();
		}

		if (this._mouseDistanceMet(event) && this._mouseDelayMet(event)) {
			this._mouseStarted =
				(this._mouseStart(this._mouseDownEvent, event) !== false);
			(this._mouseStarted ? this._mouseDrag(event) : this._mouseUp(event));
		}

		return !this._mouseStarted;
	},

	_mouseUp: function(event) {
		$(document)
			.unbind("mousemove."+this.widgetName, this._mouseMoveDelegate)
			.unbind("mouseup."+this.widgetName, this._mouseUpDelegate);

		if (this._mouseStarted) {
			this._mouseStarted = false;

			if (event.target === this._mouseDownEvent.target) {
				$.data(event.target, this.widgetName + ".preventClickEvent", true);
			}

			this._mouseStop(event);
		}

		return false;
	},

	_mouseDistanceMet: function(event) {
		return (Math.max(
				Math.abs(this._mouseDownEvent.pageX - event.pageX),
				Math.abs(this._mouseDownEvent.pageY - event.pageY)
			) >= this.options.distance
		);
	},

	_mouseDelayMet: function(/* event */) {
		return this.mouseDelayMet;
	},

	// These are placeholder methods, to be overriden by extending plugin
	_mouseStart: function(/* event */) {},
	_mouseDrag: function(/* event */) {},
	_mouseStop: function(/* event */) {},
	_mouseCapture: function(/* event */) { return true; }
});

})(jQuery);
(function( $, undefined ) {

$.widget("ui.draggable", $.ui.mouse, {
	version: "1.10.4",
	widgetEventPrefix: "drag",
	options: {
		addClasses: true,
		appendTo: "parent",
		axis: false,
		connectToSortable: false,
		containment: false,
		cursor: "auto",
		cursorAt: false,
		grid: false,
		handle: false,
		helper: "original",
		iframeFix: false,
		opacity: false,
		refreshPositions: false,
		revert: false,
		revertDuration: 500,
		scope: "default",
		scroll: true,
		scrollSensitivity: 20,
		scrollSpeed: 20,
		snap: false,
		snapMode: "both",
		snapTolerance: 20,
		stack: false,
		zIndex: false,

		// callbacks
		drag: null,
		start: null,
		stop: null
	},
	_create: function() {

		if (this.options.helper === "original" && !(/^(?:r|a|f)/).test(this.element.css("position"))) {
			this.element[0].style.position = "relative";
		}
		if (this.options.addClasses){
			this.element.addClass("ui-draggable");
		}
		if (this.options.disabled){
			this.element.addClass("ui-draggable-disabled");
		}

		this._mouseInit();

	},

	_destroy: function() {
		this.element.removeClass( "ui-draggable ui-draggable-dragging ui-draggable-disabled" );
		this._mouseDestroy();
	},

	_mouseCapture: function(event) {

		var o = this.options;

		// among others, prevent a drag on a resizable-handle
		if (this.helper || o.disabled || $(event.target).closest(".ui-resizable-handle").length > 0) {
			return false;
		}

		//Quit if we're not on a valid handle
		this.handle = this._getHandle(event);
		if (!this.handle) {
			return false;
		}

		$(o.iframeFix === true ? "iframe" : o.iframeFix).each(function() {
			$("<div class='ui-draggable-iframeFix' style='background: #fff;'></div>")
			.css({
				width: this.offsetWidth+"px", height: this.offsetHeight+"px",
				position: "absolute", opacity: "0.001", zIndex: 1000
			})
			.css($(this).offset())
			.appendTo("body");
		});

		return true;

	},

	_mouseStart: function(event) {

		var o = this.options;

		//Create and append the visible helper
		this.helper = this._createHelper(event);

		this.helper.addClass("ui-draggable-dragging");

		//Cache the helper size
		this._cacheHelperProportions();

		//If ddmanager is used for droppables, set the global draggable
		if($.ui.ddmanager) {
			$.ui.ddmanager.current = this;
		}

		/*
		 * - Position generation -
		 * This block generates everything position related - it's the core of draggables.
		 */

		//Cache the margins of the original element
		this._cacheMargins();

		//Store the helper's css position
		this.cssPosition = this.helper.css( "position" );
		this.scrollParent = this.helper.scrollParent();
		this.offsetParent = this.helper.offsetParent();
		this.offsetParentCssPosition = this.offsetParent.css( "position" );

		//The element's absolute position on the page minus margins
		this.offset = this.positionAbs = this.element.offset();
		this.offset = {
			top: this.offset.top - this.margins.top,
			left: this.offset.left - this.margins.left
		};

		//Reset scroll cache
		this.offset.scroll = false;

		$.extend(this.offset, {
			click: { //Where the click happened, relative to the element
				left: event.pageX - this.offset.left,
				top: event.pageY - this.offset.top
			},
			parent: this._getParentOffset(),
			relative: this._getRelativeOffset() //This is a relative to absolute position minus the actual position calculation - only used for relative positioned helper
		});

		//Generate the original position
		this.originalPosition = this.position = this._generatePosition(event);
		this.originalPageX = event.pageX;
		this.originalPageY = event.pageY;

		//Adjust the mouse offset relative to the helper if "cursorAt" is supplied
		(o.cursorAt && this._adjustOffsetFromHelper(o.cursorAt));

		//Set a containment if given in the options
		this._setContainment();

		//Trigger event + callbacks
		if(this._trigger("start", event) === false) {
			this._clear();
			return false;
		}

		//Recache the helper size
		this._cacheHelperProportions();

		//Prepare the droppable offsets
		if ($.ui.ddmanager && !o.dropBehaviour) {
			$.ui.ddmanager.prepareOffsets(this, event);
		}


		this._mouseDrag(event, true); //Execute the drag once - this causes the helper not to be visible before getting its correct position

		//If the ddmanager is used for droppables, inform the manager that dragging has started (see #5003)
		if ( $.ui.ddmanager ) {
			$.ui.ddmanager.dragStart(this, event);
		}

		return true;
	},

	_mouseDrag: function(event, noPropagation) {
		// reset any necessary cached properties (see #5009)
		if ( this.offsetParentCssPosition === "fixed" ) {
			this.offset.parent = this._getParentOffset();
		}

		//Compute the helpers position
		this.position = this._generatePosition(event);
		this.positionAbs = this._convertPositionTo("absolute");

		//Call plugins and callbacks and use the resulting position if something is returned
		if (!noPropagation) {
			var ui = this._uiHash();
			if(this._trigger("drag", event, ui) === false) {
				this._mouseUp({});
				return false;
			}
			this.position = ui.position;
		}

		if(!this.options.axis || this.options.axis !== "y") {
			this.helper[0].style.left = this.position.left+"px";
		}
		if(!this.options.axis || this.options.axis !== "x") {
			this.helper[0].style.top = this.position.top+"px";
		}
		if($.ui.ddmanager) {
			$.ui.ddmanager.drag(this, event);
		}

		return false;
	},

	_mouseStop: function(event) {

		//If we are using droppables, inform the manager about the drop
		var that = this,
			dropped = false;
		if ($.ui.ddmanager && !this.options.dropBehaviour) {
			dropped = $.ui.ddmanager.drop(this, event);
		}

		//if a drop comes from outside (a sortable)
		if(this.dropped) {
			dropped = this.dropped;
			this.dropped = false;
		}

		//if the original element is no longer in the DOM don't bother to continue (see #8269)
		if ( this.options.helper === "original" && !$.contains( this.element[ 0 ].ownerDocument, this.element[ 0 ] ) ) {
			return false;
		}

		if((this.options.revert === "invalid" && !dropped) || (this.options.revert === "valid" && dropped) || this.options.revert === true || ($.isFunction(this.options.revert) && this.options.revert.call(this.element, dropped))) {
			$(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function() {
				if(that._trigger("stop", event) !== false) {
					that._clear();
				}
			});
		} else {
			if(this._trigger("stop", event) !== false) {
				this._clear();
			}
		}

		return false;
	},

	_mouseUp: function(event) {
		//Remove frame helpers
		$("div.ui-draggable-iframeFix").each(function() {
			this.parentNode.removeChild(this);
		});

		//If the ddmanager is used for droppables, inform the manager that dragging has stopped (see #5003)
		if( $.ui.ddmanager ) {
			$.ui.ddmanager.dragStop(this, event);
		}

		return $.ui.mouse.prototype._mouseUp.call(this, event);
	},

	cancel: function() {

		if(this.helper.is(".ui-draggable-dragging")) {
			this._mouseUp({});
		} else {
			this._clear();
		}

		return this;

	},

	_getHandle: function(event) {
		return this.options.handle ?
			!!$( event.target ).closest( this.element.find( this.options.handle ) ).length :
			true;
	},

	_createHelper: function(event) {

		var o = this.options,
			helper = $.isFunction(o.helper) ? $(o.helper.apply(this.element[0], [event])) : (o.helper === "clone" ? this.element.clone().removeAttr("id") : this.element);

		if(!helper.parents("body").length) {
			helper.appendTo((o.appendTo === "parent" ? this.element[0].parentNode : o.appendTo));
		}

		if(helper[0] !== this.element[0] && !(/(fixed|absolute)/).test(helper.css("position"))) {
			helper.css("position", "absolute");
		}

		return helper;

	},

	_adjustOffsetFromHelper: function(obj) {
		if (typeof obj === "string") {
			obj = obj.split(" ");
		}
		if ($.isArray(obj)) {
			obj = {left: +obj[0], top: +obj[1] || 0};
		}
		if ("left" in obj) {
			this.offset.click.left = obj.left + this.margins.left;
		}
		if ("right" in obj) {
			this.offset.click.left = this.helperProportions.width - obj.right + this.margins.left;
		}
		if ("top" in obj) {
			this.offset.click.top = obj.top + this.margins.top;
		}
		if ("bottom" in obj) {
			this.offset.click.top = this.helperProportions.height - obj.bottom + this.margins.top;
		}
	},

	_getParentOffset: function() {

		//Get the offsetParent and cache its position
		var po = this.offsetParent.offset();

		// This is a special case where we need to modify a offset calculated on start, since the following happened:
		// 1. The position of the helper is absolute, so it's position is calculated based on the next positioned parent
		// 2. The actual offset parent is a child of the scroll parent, and the scroll parent isn't the document, which means that
		//    the scroll is included in the initial calculation of the offset of the parent, and never recalculated upon drag
		if(this.cssPosition === "absolute" && this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) {
			po.left += this.scrollParent.scrollLeft();
			po.top += this.scrollParent.scrollTop();
		}

		//This needs to be actually done for all browsers, since pageX/pageY includes this information
		//Ugly IE fix
		if((this.offsetParent[0] === document.body) ||
			(this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() === "html" && $.ui.ie)) {
			po = { top: 0, left: 0 };
		}

		return {
			top: po.top + (parseInt(this.offsetParent.css("borderTopWidth"),10) || 0),
			left: po.left + (parseInt(this.offsetParent.css("borderLeftWidth"),10) || 0)
		};

	},

	_getRelativeOffset: function() {

		if(this.cssPosition === "relative") {
			var p = this.element.position();
			return {
				top: p.top - (parseInt(this.helper.css("top"),10) || 0) + this.scrollParent.scrollTop(),
				left: p.left - (parseInt(this.helper.css("left"),10) || 0) + this.scrollParent.scrollLeft()
			};
		} else {
			return { top: 0, left: 0 };
		}

	},

	_cacheMargins: function() {
		this.margins = {
			left: (parseInt(this.element.css("marginLeft"),10) || 0),
			top: (parseInt(this.element.css("marginTop"),10) || 0),
			right: (parseInt(this.element.css("marginRight"),10) || 0),
			bottom: (parseInt(this.element.css("marginBottom"),10) || 0)
		};
	},

	_cacheHelperProportions: function() {
		this.helperProportions = {
			width: this.helper.outerWidth(),
			height: this.helper.outerHeight()
		};
	},

	_setContainment: function() {

		var over, c, ce,
			o = this.options;

		if ( !o.containment ) {
			this.containment = null;
			return;
		}

		if ( o.containment === "window" ) {
			this.containment = [
				$( window ).scrollLeft() - this.offset.relative.left - this.offset.parent.left,
				$( window ).scrollTop() - this.offset.relative.top - this.offset.parent.top,
				$( window ).scrollLeft() + $( window ).width() - this.helperProportions.width - this.margins.left,
				$( window ).scrollTop() + ( $( window ).height() || document.body.parentNode.scrollHeight ) - this.helperProportions.height - this.margins.top
			];
			return;
		}

		if ( o.containment === "document") {
			this.containment = [
				0,
				0,
				$( document ).width() - this.helperProportions.width - this.margins.left,
				( $( document ).height() || document.body.parentNode.scrollHeight ) - this.helperProportions.height - this.margins.top
			];
			return;
		}

		if ( o.containment.constructor === Array ) {
			this.containment = o.containment;
			return;
		}

		if ( o.containment === "parent" ) {
			o.containment = this.helper[ 0 ].parentNode;
		}

		c = $( o.containment );
		ce = c[ 0 ];

		if( !ce ) {
			return;
		}

		over = c.css( "overflow" ) !== "hidden";

		this.containment = [
			( parseInt( c.css( "borderLeftWidth" ), 10 ) || 0 ) + ( parseInt( c.css( "paddingLeft" ), 10 ) || 0 ),
			( parseInt( c.css( "borderTopWidth" ), 10 ) || 0 ) + ( parseInt( c.css( "paddingTop" ), 10 ) || 0 ) ,
			( over ? Math.max( ce.scrollWidth, ce.offsetWidth ) : ce.offsetWidth ) - ( parseInt( c.css( "borderRightWidth" ), 10 ) || 0 ) - ( parseInt( c.css( "paddingRight" ), 10 ) || 0 ) - this.helperProportions.width - this.margins.left - this.margins.right,
			( over ? Math.max( ce.scrollHeight, ce.offsetHeight ) : ce.offsetHeight ) - ( parseInt( c.css( "borderBottomWidth" ), 10 ) || 0 ) - ( parseInt( c.css( "paddingBottom" ), 10 ) || 0 ) - this.helperProportions.height - this.margins.top  - this.margins.bottom
		];
		this.relative_container = c;
	},

	_convertPositionTo: function(d, pos) {

		if(!pos) {
			pos = this.position;
		}

		var mod = d === "absolute" ? 1 : -1,
			scroll = this.cssPosition === "absolute" && !( this.scrollParent[ 0 ] !== document && $.contains( this.scrollParent[ 0 ], this.offsetParent[ 0 ] ) ) ? this.offsetParent : this.scrollParent;

		//Cache the scroll
		if (!this.offset.scroll) {
			this.offset.scroll = {top : scroll.scrollTop(), left : scroll.scrollLeft()};
		}

		return {
			top: (
				pos.top	+																// The absolute mouse position
				this.offset.relative.top * mod +										// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.top * mod -										// The offsetParent's offset without borders (offset + border)
				( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : this.offset.scroll.top ) * mod )
			),
			left: (
				pos.left +																// The absolute mouse position
				this.offset.relative.left * mod +										// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.left * mod	-										// The offsetParent's offset without borders (offset + border)
				( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : this.offset.scroll.left ) * mod )
			)
		};

	},

	_generatePosition: function(event) {

		var containment, co, top, left,
			o = this.options,
			scroll = this.cssPosition === "absolute" && !( this.scrollParent[ 0 ] !== document && $.contains( this.scrollParent[ 0 ], this.offsetParent[ 0 ] ) ) ? this.offsetParent : this.scrollParent,
			pageX = event.pageX,
			pageY = event.pageY;

		//Cache the scroll
		if (!this.offset.scroll) {
			this.offset.scroll = {top : scroll.scrollTop(), left : scroll.scrollLeft()};
		}

		/*
		 * - Position constraining -
		 * Constrain the position to a mix of grid, containment.
		 */

		// If we are not dragging yet, we won't check for options
		if ( this.originalPosition ) {
			if ( this.containment ) {
				if ( this.relative_container ){
					co = this.relative_container.offset();
					containment = [
						this.containment[ 0 ] + co.left,
						this.containment[ 1 ] + co.top,
						this.containment[ 2 ] + co.left,
						this.containment[ 3 ] + co.top
					];
				}
				else {
					containment = this.containment;
				}

				if(event.pageX - this.offset.click.left < containment[0]) {
					pageX = containment[0] + this.offset.click.left;
				}
				if(event.pageY - this.offset.click.top < containment[1]) {
					pageY = containment[1] + this.offset.click.top;
				}
				if(event.pageX - this.offset.click.left > containment[2]) {
					pageX = containment[2] + this.offset.click.left;
				}
				if(event.pageY - this.offset.click.top > containment[3]) {
					pageY = containment[3] + this.offset.click.top;
				}
			}

			if(o.grid) {
				//Check for grid elements set to 0 to prevent divide by 0 error causing invalid argument errors in IE (see ticket #6950)
				top = o.grid[1] ? this.originalPageY + Math.round((pageY - this.originalPageY) / o.grid[1]) * o.grid[1] : this.originalPageY;
				pageY = containment ? ((top - this.offset.click.top >= containment[1] || top - this.offset.click.top > containment[3]) ? top : ((top - this.offset.click.top >= containment[1]) ? top - o.grid[1] : top + o.grid[1])) : top;

				left = o.grid[0] ? this.originalPageX + Math.round((pageX - this.originalPageX) / o.grid[0]) * o.grid[0] : this.originalPageX;
				pageX = containment ? ((left - this.offset.click.left >= containment[0] || left - this.offset.click.left > containment[2]) ? left : ((left - this.offset.click.left >= containment[0]) ? left - o.grid[0] : left + o.grid[0])) : left;
			}

		}

		return {
			top: (
				pageY -																	// The absolute mouse position
				this.offset.click.top	-												// Click offset (relative to the element)
				this.offset.relative.top -												// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.top +												// The offsetParent's offset without borders (offset + border)
				( this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : this.offset.scroll.top )
			),
			left: (
				pageX -																	// The absolute mouse position
				this.offset.click.left -												// Click offset (relative to the element)
				this.offset.relative.left -												// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.left +												// The offsetParent's offset without borders (offset + border)
				( this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : this.offset.scroll.left )
			)
		};

	},

	_clear: function() {
		this.helper.removeClass("ui-draggable-dragging");
		if(this.helper[0] !== this.element[0] && !this.cancelHelperRemoval) {
			this.helper.remove();
		}
		this.helper = null;
		this.cancelHelperRemoval = false;
	},

	// From now on bulk stuff - mainly helpers

	_trigger: function(type, event, ui) {
		ui = ui || this._uiHash();
		$.ui.plugin.call(this, type, [event, ui]);
		//The absolute position has to be recalculated after plugins
		if(type === "drag") {
			this.positionAbs = this._convertPositionTo("absolute");
		}
		return $.Widget.prototype._trigger.call(this, type, event, ui);
	},

	plugins: {},

	_uiHash: function() {
		return {
			helper: this.helper,
			position: this.position,
			originalPosition: this.originalPosition,
			offset: this.positionAbs
		};
	}

});

$.ui.plugin.add("draggable", "connectToSortable", {
	start: function(event, ui) {

		var inst = $(this).data("ui-draggable"), o = inst.options,
			uiSortable = $.extend({}, ui, { item: inst.element });
		inst.sortables = [];
		$(o.connectToSortable).each(function() {
			var sortable = $.data(this, "ui-sortable");
			if (sortable && !sortable.options.disabled) {
				inst.sortables.push({
					instance: sortable,
					shouldRevert: sortable.options.revert
				});
				sortable.refreshPositions();	// Call the sortable's refreshPositions at drag start to refresh the containerCache since the sortable container cache is used in drag and needs to be up to date (this will ensure it's initialised as well as being kept in step with any changes that might have happened on the page).
				sortable._trigger("activate", event, uiSortable);
			}
		});

	},
	stop: function(event, ui) {

		//If we are still over the sortable, we fake the stop event of the sortable, but also remove helper
		var inst = $(this).data("ui-draggable"),
			uiSortable = $.extend({}, ui, { item: inst.element });

		$.each(inst.sortables, function() {
			if(this.instance.isOver) {

				this.instance.isOver = 0;

				inst.cancelHelperRemoval = true; //Don't remove the helper in the draggable instance
				this.instance.cancelHelperRemoval = false; //Remove it in the sortable instance (so sortable plugins like revert still work)

				//The sortable revert is supported, and we have to set a temporary dropped variable on the draggable to support revert: "valid/invalid"
				if(this.shouldRevert) {
					this.instance.options.revert = this.shouldRevert;
				}

				//Trigger the stop of the sortable
				this.instance._mouseStop(event);

				this.instance.options.helper = this.instance.options._helper;

				//If the helper has been the original item, restore properties in the sortable
				if(inst.options.helper === "original") {
					this.instance.currentItem.css({ top: "auto", left: "auto" });
				}

			} else {
				this.instance.cancelHelperRemoval = false; //Remove the helper in the sortable instance
				this.instance._trigger("deactivate", event, uiSortable);
			}

		});

	},
	drag: function(event, ui) {

		var inst = $(this).data("ui-draggable"), that = this;

		$.each(inst.sortables, function() {

			var innermostIntersecting = false,
				thisSortable = this;

			//Copy over some variables to allow calling the sortable's native _intersectsWith
			this.instance.positionAbs = inst.positionAbs;
			this.instance.helperProportions = inst.helperProportions;
			this.instance.offset.click = inst.offset.click;

			if(this.instance._intersectsWith(this.instance.containerCache)) {
				innermostIntersecting = true;
				$.each(inst.sortables, function () {
					this.instance.positionAbs = inst.positionAbs;
					this.instance.helperProportions = inst.helperProportions;
					this.instance.offset.click = inst.offset.click;
					if (this !== thisSortable &&
						this.instance._intersectsWith(this.instance.containerCache) &&
						$.contains(thisSortable.instance.element[0], this.instance.element[0])
					) {
						innermostIntersecting = false;
					}
					return innermostIntersecting;
				});
			}


			if(innermostIntersecting) {
				//If it intersects, we use a little isOver variable and set it once, so our move-in stuff gets fired only once
				if(!this.instance.isOver) {

					this.instance.isOver = 1;
					//Now we fake the start of dragging for the sortable instance,
					//by cloning the list group item, appending it to the sortable and using it as inst.currentItem
					//We can then fire the start event of the sortable with our passed browser event, and our own helper (so it doesn't create a new one)
					this.instance.currentItem = $(that).clone().removeAttr("id").appendTo(this.instance.element).data("ui-sortable-item", true);
					this.instance.options._helper = this.instance.options.helper; //Store helper option to later restore it
					this.instance.options.helper = function() { return ui.helper[0]; };

					event.target = this.instance.currentItem[0];
					this.instance._mouseCapture(event, true);
					this.instance._mouseStart(event, true, true);

					//Because the browser event is way off the new appended portlet, we modify a couple of variables to reflect the changes
					this.instance.offset.click.top = inst.offset.click.top;
					this.instance.offset.click.left = inst.offset.click.left;
					this.instance.offset.parent.left -= inst.offset.parent.left - this.instance.offset.parent.left;
					this.instance.offset.parent.top -= inst.offset.parent.top - this.instance.offset.parent.top;

					inst._trigger("toSortable", event);
					inst.dropped = this.instance.element; //draggable revert needs that
					//hack so receive/update callbacks work (mostly)
					inst.currentItem = inst.element;
					this.instance.fromOutside = inst;

				}

				//Provided we did all the previous steps, we can fire the drag event of the sortable on every draggable drag, when it intersects with the sortable
				if(this.instance.currentItem) {
					this.instance._mouseDrag(event);
				}

			} else {

				//If it doesn't intersect with the sortable, and it intersected before,
				//we fake the drag stop of the sortable, but make sure it doesn't remove the helper by using cancelHelperRemoval
				if(this.instance.isOver) {

					this.instance.isOver = 0;
					this.instance.cancelHelperRemoval = true;

					//Prevent reverting on this forced stop
					this.instance.options.revert = false;

					// The out event needs to be triggered independently
					this.instance._trigger("out", event, this.instance._uiHash(this.instance));

					this.instance._mouseStop(event, true);
					this.instance.options.helper = this.instance.options._helper;

					//Now we remove our currentItem, the list group clone again, and the placeholder, and animate the helper back to it's original size
					this.instance.currentItem.remove();
					if(this.instance.placeholder) {
						this.instance.placeholder.remove();
					}

					inst._trigger("fromSortable", event);
					inst.dropped = false; //draggable revert needs that
				}

			}

		});

	}
});

$.ui.plugin.add("draggable", "cursor", {
	start: function() {
		var t = $("body"), o = $(this).data("ui-draggable").options;
		if (t.css("cursor")) {
			o._cursor = t.css("cursor");
		}
		t.css("cursor", o.cursor);
	},
	stop: function() {
		var o = $(this).data("ui-draggable").options;
		if (o._cursor) {
			$("body").css("cursor", o._cursor);
		}
	}
});

$.ui.plugin.add("draggable", "opacity", {
	start: function(event, ui) {
		var t = $(ui.helper), o = $(this).data("ui-draggable").options;
		if(t.css("opacity")) {
			o._opacity = t.css("opacity");
		}
		t.css("opacity", o.opacity);
	},
	stop: function(event, ui) {
		var o = $(this).data("ui-draggable").options;
		if(o._opacity) {
			$(ui.helper).css("opacity", o._opacity);
		}
	}
});

$.ui.plugin.add("draggable", "scroll", {
	start: function() {
		var i = $(this).data("ui-draggable");
		if(i.scrollParent[0] !== document && i.scrollParent[0].tagName !== "HTML") {
			i.overflowOffset = i.scrollParent.offset();
		}
	},
	drag: function( event ) {

		var i = $(this).data("ui-draggable"), o = i.options, scrolled = false;

		if(i.scrollParent[0] !== document && i.scrollParent[0].tagName !== "HTML") {

			if(!o.axis || o.axis !== "x") {
				if((i.overflowOffset.top + i.scrollParent[0].offsetHeight) - event.pageY < o.scrollSensitivity) {
					i.scrollParent[0].scrollTop = scrolled = i.scrollParent[0].scrollTop + o.scrollSpeed;
				} else if(event.pageY - i.overflowOffset.top < o.scrollSensitivity) {
					i.scrollParent[0].scrollTop = scrolled = i.scrollParent[0].scrollTop - o.scrollSpeed;
				}
			}

			if(!o.axis || o.axis !== "y") {
				if((i.overflowOffset.left + i.scrollParent[0].offsetWidth) - event.pageX < o.scrollSensitivity) {
					i.scrollParent[0].scrollLeft = scrolled = i.scrollParent[0].scrollLeft + o.scrollSpeed;
				} else if(event.pageX - i.overflowOffset.left < o.scrollSensitivity) {
					i.scrollParent[0].scrollLeft = scrolled = i.scrollParent[0].scrollLeft - o.scrollSpeed;
				}
			}

		} else {

			if(!o.axis || o.axis !== "x") {
				if(event.pageY - $(document).scrollTop() < o.scrollSensitivity) {
					scrolled = $(document).scrollTop($(document).scrollTop() - o.scrollSpeed);
				} else if($(window).height() - (event.pageY - $(document).scrollTop()) < o.scrollSensitivity) {
					scrolled = $(document).scrollTop($(document).scrollTop() + o.scrollSpeed);
				}
			}

			if(!o.axis || o.axis !== "y") {
				if(event.pageX - $(document).scrollLeft() < o.scrollSensitivity) {
					scrolled = $(document).scrollLeft($(document).scrollLeft() - o.scrollSpeed);
				} else if($(window).width() - (event.pageX - $(document).scrollLeft()) < o.scrollSensitivity) {
					scrolled = $(document).scrollLeft($(document).scrollLeft() + o.scrollSpeed);
				}
			}

		}

		if(scrolled !== false && $.ui.ddmanager && !o.dropBehaviour) {
			$.ui.ddmanager.prepareOffsets(i, event);
		}

	}
});

$.ui.plugin.add("draggable", "snap", {
	start: function() {

		var i = $(this).data("ui-draggable"),
			o = i.options;

		i.snapElements = [];

		$(o.snap.constructor !== String ? ( o.snap.items || ":data(ui-draggable)" ) : o.snap).each(function() {
			var $t = $(this),
				$o = $t.offset();
			if(this !== i.element[0]) {
				i.snapElements.push({
					item: this,
					width: $t.outerWidth(), height: $t.outerHeight(),
					top: $o.top, left: $o.left
				});
			}
		});

	},
	drag: function(event, ui) {

		var ts, bs, ls, rs, l, r, t, b, i, first,
			inst = $(this).data("ui-draggable"),
			o = inst.options,
			d = o.snapTolerance,
			x1 = ui.offset.left, x2 = x1 + inst.helperProportions.width,
			y1 = ui.offset.top, y2 = y1 + inst.helperProportions.height;

		for (i = inst.snapElements.length - 1; i >= 0; i--){

			l = inst.snapElements[i].left;
			r = l + inst.snapElements[i].width;
			t = inst.snapElements[i].top;
			b = t + inst.snapElements[i].height;

			if ( x2 < l - d || x1 > r + d || y2 < t - d || y1 > b + d || !$.contains( inst.snapElements[ i ].item.ownerDocument, inst.snapElements[ i ].item ) ) {
				if(inst.snapElements[i].snapping) {
					(inst.options.snap.release && inst.options.snap.release.call(inst.element, event, $.extend(inst._uiHash(), { snapItem: inst.snapElements[i].item })));
				}
				inst.snapElements[i].snapping = false;
				continue;
			}

			if(o.snapMode !== "inner") {
				ts = Math.abs(t - y2) <= d;
				bs = Math.abs(b - y1) <= d;
				ls = Math.abs(l - x2) <= d;
				rs = Math.abs(r - x1) <= d;
				if(ts) {
					ui.position.top = inst._convertPositionTo("relative", { top: t - inst.helperProportions.height, left: 0 }).top - inst.margins.top;
				}
				if(bs) {
					ui.position.top = inst._convertPositionTo("relative", { top: b, left: 0 }).top - inst.margins.top;
				}
				if(ls) {
					ui.position.left = inst._convertPositionTo("relative", { top: 0, left: l - inst.helperProportions.width }).left - inst.margins.left;
				}
				if(rs) {
					ui.position.left = inst._convertPositionTo("relative", { top: 0, left: r }).left - inst.margins.left;
				}
			}

			first = (ts || bs || ls || rs);

			if(o.snapMode !== "outer") {
				ts = Math.abs(t - y1) <= d;
				bs = Math.abs(b - y2) <= d;
				ls = Math.abs(l - x1) <= d;
				rs = Math.abs(r - x2) <= d;
				if(ts) {
					ui.position.top = inst._convertPositionTo("relative", { top: t, left: 0 }).top - inst.margins.top;
				}
				if(bs) {
					ui.position.top = inst._convertPositionTo("relative", { top: b - inst.helperProportions.height, left: 0 }).top - inst.margins.top;
				}
				if(ls) {
					ui.position.left = inst._convertPositionTo("relative", { top: 0, left: l }).left - inst.margins.left;
				}
				if(rs) {
					ui.position.left = inst._convertPositionTo("relative", { top: 0, left: r - inst.helperProportions.width }).left - inst.margins.left;
				}
			}

			if(!inst.snapElements[i].snapping && (ts || bs || ls || rs || first)) {
				(inst.options.snap.snap && inst.options.snap.snap.call(inst.element, event, $.extend(inst._uiHash(), { snapItem: inst.snapElements[i].item })));
			}
			inst.snapElements[i].snapping = (ts || bs || ls || rs || first);

		}

	}
});

$.ui.plugin.add("draggable", "stack", {
	start: function() {
		var min,
			o = this.data("ui-draggable").options,
			group = $.makeArray($(o.stack)).sort(function(a,b) {
				return (parseInt($(a).css("zIndex"),10) || 0) - (parseInt($(b).css("zIndex"),10) || 0);
			});

		if (!group.length) { return; }

		min = parseInt($(group[0]).css("zIndex"), 10) || 0;
		$(group).each(function(i) {
			$(this).css("zIndex", min + i);
		});
		this.css("zIndex", (min + group.length));
	}
});

$.ui.plugin.add("draggable", "zIndex", {
	start: function(event, ui) {
		var t = $(ui.helper), o = $(this).data("ui-draggable").options;
		if(t.css("zIndex")) {
			o._zIndex = t.css("zIndex");
		}
		t.css("zIndex", o.zIndex);
	},
	stop: function(event, ui) {
		var o = $(this).data("ui-draggable").options;
		if(o._zIndex) {
			$(ui.helper).css("zIndex", o._zIndex);
		}
	}
});

})(jQuery);
(function( $, undefined ) {

function isOverAxis( x, reference, size ) {
	return ( x > reference ) && ( x < ( reference + size ) );
}

$.widget("ui.droppable", {
	version: "1.10.4",
	widgetEventPrefix: "drop",
	options: {
		accept: "*",
		activeClass: false,
		addClasses: true,
		greedy: false,
		hoverClass: false,
		scope: "default",
		tolerance: "intersect",

		// callbacks
		activate: null,
		deactivate: null,
		drop: null,
		out: null,
		over: null
	},
	_create: function() {

		var proportions,
			o = this.options,
			accept = o.accept;

		this.isover = false;
		this.isout = true;

		this.accept = $.isFunction(accept) ? accept : function(d) {
			return d.is(accept);
		};

		this.proportions = function( /* valueToWrite */ ) {
			if ( arguments.length ) {
				// Store the droppable's proportions
				proportions = arguments[ 0 ];
			} else {
				// Retrieve or derive the droppable's proportions
				return proportions ?
					proportions :
					proportions = {
						width: this.element[ 0 ].offsetWidth,
						height: this.element[ 0 ].offsetHeight
					};
			}
		};

		// Add the reference and positions to the manager
		$.ui.ddmanager.droppables[o.scope] = $.ui.ddmanager.droppables[o.scope] || [];
		$.ui.ddmanager.droppables[o.scope].push(this);

		(o.addClasses && this.element.addClass("ui-droppable"));

	},

	_destroy: function() {
		var i = 0,
			drop = $.ui.ddmanager.droppables[this.options.scope];

		for ( ; i < drop.length; i++ ) {
			if ( drop[i] === this ) {
				drop.splice(i, 1);
			}
		}

		this.element.removeClass("ui-droppable ui-droppable-disabled");
	},

	_setOption: function(key, value) {

		if(key === "accept") {
			this.accept = $.isFunction(value) ? value : function(d) {
				return d.is(value);
			};
		}
		$.Widget.prototype._setOption.apply(this, arguments);
	},

	_activate: function(event) {
		var draggable = $.ui.ddmanager.current;
		if(this.options.activeClass) {
			this.element.addClass(this.options.activeClass);
		}
		if(draggable){
			this._trigger("activate", event, this.ui(draggable));
		}
	},

	_deactivate: function(event) {
		var draggable = $.ui.ddmanager.current;
		if(this.options.activeClass) {
			this.element.removeClass(this.options.activeClass);
		}
		if(draggable){
			this._trigger("deactivate", event, this.ui(draggable));
		}
	},

	_over: function(event) {

		var draggable = $.ui.ddmanager.current;

		// Bail if draggable and droppable are same element
		if (!draggable || (draggable.currentItem || draggable.element)[0] === this.element[0]) {
			return;
		}

		if (this.accept.call(this.element[0],(draggable.currentItem || draggable.element))) {
			if(this.options.hoverClass) {
				this.element.addClass(this.options.hoverClass);
			}
			this._trigger("over", event, this.ui(draggable));
		}

	},

	_out: function(event) {

		var draggable = $.ui.ddmanager.current;

		// Bail if draggable and droppable are same element
		if (!draggable || (draggable.currentItem || draggable.element)[0] === this.element[0]) {
			return;
		}

		if (this.accept.call(this.element[0],(draggable.currentItem || draggable.element))) {
			if(this.options.hoverClass) {
				this.element.removeClass(this.options.hoverClass);
			}
			this._trigger("out", event, this.ui(draggable));
		}

	},

	_drop: function(event,custom) {

		var draggable = custom || $.ui.ddmanager.current,
			childrenIntersection = false;

		// Bail if draggable and droppable are same element
		if (!draggable || (draggable.currentItem || draggable.element)[0] === this.element[0]) {
			return false;
		}

		this.element.find(":data(ui-droppable)").not(".ui-draggable-dragging").each(function() {
			var inst = $.data(this, "ui-droppable");
			if(
				inst.options.greedy &&
				!inst.options.disabled &&
				inst.options.scope === draggable.options.scope &&
				inst.accept.call(inst.element[0], (draggable.currentItem || draggable.element)) &&
				$.ui.intersect(draggable, $.extend(inst, { offset: inst.element.offset() }), inst.options.tolerance)
			) { childrenIntersection = true; return false; }
		});
		if(childrenIntersection) {
			return false;
		}

		if(this.accept.call(this.element[0],(draggable.currentItem || draggable.element))) {
			if(this.options.activeClass) {
				this.element.removeClass(this.options.activeClass);
			}
			if(this.options.hoverClass) {
				this.element.removeClass(this.options.hoverClass);
			}
			this._trigger("drop", event, this.ui(draggable));
			return this.element;
		}

		return false;

	},

	ui: function(c) {
		return {
			draggable: (c.currentItem || c.element),
			helper: c.helper,
			position: c.position,
			offset: c.positionAbs
		};
	}

});

$.ui.intersect = function(draggable, droppable, toleranceMode) {

	if (!droppable.offset) {
		return false;
	}

	var draggableLeft, draggableTop,
		x1 = (draggable.positionAbs || draggable.position.absolute).left,
		y1 = (draggable.positionAbs || draggable.position.absolute).top,
		x2 = x1 + draggable.helperProportions.width,
		y2 = y1 + draggable.helperProportions.height,
		l = droppable.offset.left,
		t = droppable.offset.top,
		r = l + droppable.proportions().width,
		b = t + droppable.proportions().height;

	switch (toleranceMode) {
		case "fit":
			return (l <= x1 && x2 <= r && t <= y1 && y2 <= b);
		case "intersect":
			return (l < x1 + (draggable.helperProportions.width / 2) && // Right Half
				x2 - (draggable.helperProportions.width / 2) < r && // Left Half
				t < y1 + (draggable.helperProportions.height / 2) && // Bottom Half
				y2 - (draggable.helperProportions.height / 2) < b ); // Top Half
		case "pointer":
			draggableLeft = ((draggable.positionAbs || draggable.position.absolute).left + (draggable.clickOffset || draggable.offset.click).left);
			draggableTop = ((draggable.positionAbs || draggable.position.absolute).top + (draggable.clickOffset || draggable.offset.click).top);
			return isOverAxis( draggableTop, t, droppable.proportions().height ) && isOverAxis( draggableLeft, l, droppable.proportions().width );
		case "touch":
			return (
				(y1 >= t && y1 <= b) ||	// Top edge touching
				(y2 >= t && y2 <= b) ||	// Bottom edge touching
				(y1 < t && y2 > b)		// Surrounded vertically
			) && (
				(x1 >= l && x1 <= r) ||	// Left edge touching
				(x2 >= l && x2 <= r) ||	// Right edge touching
				(x1 < l && x2 > r)		// Surrounded horizontally
			);
		default:
			return false;
		}

};

/*
	This manager tracks offsets of draggables and droppables
*/
$.ui.ddmanager = {
	current: null,
	droppables: { "default": [] },
	prepareOffsets: function(t, event) {

		var i, j,
			m = $.ui.ddmanager.droppables[t.options.scope] || [],
			type = event ? event.type : null, // workaround for #2317
			list = (t.currentItem || t.element).find(":data(ui-droppable)").addBack();

		droppablesLoop: for (i = 0; i < m.length; i++) {

			//No disabled and non-accepted
			if(m[i].options.disabled || (t && !m[i].accept.call(m[i].element[0],(t.currentItem || t.element)))) {
				continue;
			}

			// Filter out elements in the current dragged item
			for (j=0; j < list.length; j++) {
				if(list[j] === m[i].element[0]) {
					m[i].proportions().height = 0;
					continue droppablesLoop;
				}
			}

			m[i].visible = m[i].element.css("display") !== "none";
			if(!m[i].visible) {
				continue;
			}

			//Activate the droppable if used directly from draggables
			if(type === "mousedown") {
				m[i]._activate.call(m[i], event);
			}

			m[ i ].offset = m[ i ].element.offset();
			m[ i ].proportions({ width: m[ i ].element[ 0 ].offsetWidth, height: m[ i ].element[ 0 ].offsetHeight });

		}

	},
	drop: function(draggable, event) {

		var dropped = false;
		// Create a copy of the droppables in case the list changes during the drop (#9116)
		$.each(($.ui.ddmanager.droppables[draggable.options.scope] || []).slice(), function() {

			if(!this.options) {
				return;
			}
			if (!this.options.disabled && this.visible && $.ui.intersect(draggable, this, this.options.tolerance)) {
				dropped = this._drop.call(this, event) || dropped;
			}

			if (!this.options.disabled && this.visible && this.accept.call(this.element[0],(draggable.currentItem || draggable.element))) {
				this.isout = true;
				this.isover = false;
				this._deactivate.call(this, event);
			}

		});
		return dropped;

	},
	dragStart: function( draggable, event ) {
		//Listen for scrolling so that if the dragging causes scrolling the position of the droppables can be recalculated (see #5003)
		draggable.element.parentsUntil( "body" ).bind( "scroll.droppable", function() {
			if( !draggable.options.refreshPositions ) {
				$.ui.ddmanager.prepareOffsets( draggable, event );
			}
		});
	},
	drag: function(draggable, event) {

		//If you have a highly dynamic page, you might try this option. It renders positions every time you move the mouse.
		if(draggable.options.refreshPositions) {
			$.ui.ddmanager.prepareOffsets(draggable, event);
		}

		//Run through all droppables and check their positions based on specific tolerance options
		$.each($.ui.ddmanager.droppables[draggable.options.scope] || [], function() {

			if(this.options.disabled || this.greedyChild || !this.visible) {
				return;
			}

			var parentInstance, scope, parent,
				intersects = $.ui.intersect(draggable, this, this.options.tolerance),
				c = !intersects && this.isover ? "isout" : (intersects && !this.isover ? "isover" : null);
			if(!c) {
				return;
			}

			if (this.options.greedy) {
				// find droppable parents with same scope
				scope = this.options.scope;
				parent = this.element.parents(":data(ui-droppable)").filter(function () {
					return $.data(this, "ui-droppable").options.scope === scope;
				});

				if (parent.length) {
					parentInstance = $.data(parent[0], "ui-droppable");
					parentInstance.greedyChild = (c === "isover");
				}
			}

			// we just moved into a greedy child
			if (parentInstance && c === "isover") {
				parentInstance.isover = false;
				parentInstance.isout = true;
				parentInstance._out.call(parentInstance, event);
			}

			this[c] = true;
			this[c === "isout" ? "isover" : "isout"] = false;
			this[c === "isover" ? "_over" : "_out"].call(this, event);

			// we just moved out of a greedy child
			if (parentInstance && c === "isout") {
				parentInstance.isout = false;
				parentInstance.isover = true;
				parentInstance._over.call(parentInstance, event);
			}
		});

	},
	dragStop: function( draggable, event ) {
		draggable.element.parentsUntil( "body" ).unbind( "scroll.droppable" );
		//Call prepareOffsets one final time since IE does not fire return scroll events when overflow was caused by drag (see #5003)
		if( !draggable.options.refreshPositions ) {
			$.ui.ddmanager.prepareOffsets( draggable, event );
		}
	}
};

})(jQuery);
(function( $, undefined ) {

function num(v) {
	return parseInt(v, 10) || 0;
}

function isNumber(value) {
	return !isNaN(parseInt(value, 10));
}

$.widget("ui.resizable", $.ui.mouse, {
	version: "1.10.4",
	widgetEventPrefix: "resize",
	options: {
		alsoResize: false,
		animate: false,
		animateDuration: "slow",
		animateEasing: "swing",
		aspectRatio: false,
		autoHide: false,
		containment: false,
		ghost: false,
		grid: false,
		handles: "e,s,se",
		helper: false,
		maxHeight: null,
		maxWidth: null,
		minHeight: 10,
		minWidth: 10,
		// See #7960
		zIndex: 90,

		// callbacks
		resize: null,
		start: null,
		stop: null
	},
	_create: function() {

		var n, i, handle, axis, hname,
			that = this,
			o = this.options;
		this.element.addClass("ui-resizable");

		$.extend(this, {
			_aspectRatio: !!(o.aspectRatio),
			aspectRatio: o.aspectRatio,
			originalElement: this.element,
			_proportionallyResizeElements: [],
			_helper: o.helper || o.ghost || o.animate ? o.helper || "ui-resizable-helper" : null
		});

		//Wrap the element if it cannot hold child nodes
		if(this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i)) {

			//Create a wrapper element and set the wrapper to the new current internal element
			this.element.wrap(
				$("<div class='ui-wrapper' style='overflow: hidden;'></div>").css({
					position: this.element.css("position"),
					width: this.element.outerWidth(),
					height: this.element.outerHeight(),
					top: this.element.css("top"),
					left: this.element.css("left")
				})
			);

			//Overwrite the original this.element
			this.element = this.element.parent().data(
				"ui-resizable", this.element.data("ui-resizable")
			);

			this.elementIsWrapper = true;

			//Move margins to the wrapper
			this.element.css({ marginLeft: this.originalElement.css("marginLeft"), marginTop: this.originalElement.css("marginTop"), marginRight: this.originalElement.css("marginRight"), marginBottom: this.originalElement.css("marginBottom") });
			this.originalElement.css({ marginLeft: 0, marginTop: 0, marginRight: 0, marginBottom: 0});

			//Prevent Safari textarea resize
			this.originalResizeStyle = this.originalElement.css("resize");
			this.originalElement.css("resize", "none");

			//Push the actual element to our proportionallyResize internal array
			this._proportionallyResizeElements.push(this.originalElement.css({ position: "static", zoom: 1, display: "block" }));

			// avoid IE jump (hard set the margin)
			this.originalElement.css({ margin: this.originalElement.css("margin") });

			// fix handlers offset
			this._proportionallyResize();

		}

		this.handles = o.handles || (!$(".ui-resizable-handle", this.element).length ? "e,s,se" : { n: ".ui-resizable-n", e: ".ui-resizable-e", s: ".ui-resizable-s", w: ".ui-resizable-w", se: ".ui-resizable-se", sw: ".ui-resizable-sw", ne: ".ui-resizable-ne", nw: ".ui-resizable-nw" });
		if(this.handles.constructor === String) {

			if ( this.handles === "all") {
				this.handles = "n,e,s,w,se,sw,ne,nw";
			}

			n = this.handles.split(",");
			this.handles = {};

			for(i = 0; i < n.length; i++) {

				handle = $.trim(n[i]);
				hname = "ui-resizable-"+handle;
				axis = $("<div class='ui-resizable-handle " + hname + "'></div>");

				// Apply zIndex to all handles - see #7960
				axis.css({ zIndex: o.zIndex });

				//TODO : What's going on here?
				if ("se" === handle) {
					axis.addClass("ui-icon ui-icon-gripsmall-diagonal-se");
				}

				//Insert into internal handles object and append to element
				this.handles[handle] = ".ui-resizable-"+handle;
				this.element.append(axis);
			}

		}

		this._renderAxis = function(target) {

			var i, axis, padPos, padWrapper;

			target = target || this.element;

			for(i in this.handles) {

				if(this.handles[i].constructor === String) {
					this.handles[i] = $(this.handles[i], this.element).show();
				}

				//Apply pad to wrapper element, needed to fix axis position (textarea, inputs, scrolls)
				if (this.elementIsWrapper && this.originalElement[0].nodeName.match(/textarea|input|select|button/i)) {

					axis = $(this.handles[i], this.element);

					//Checking the correct pad and border
					padWrapper = /sw|ne|nw|se|n|s/.test(i) ? axis.outerHeight() : axis.outerWidth();

					//The padding type i have to apply...
					padPos = [ "padding",
						/ne|nw|n/.test(i) ? "Top" :
						/se|sw|s/.test(i) ? "Bottom" :
						/^e$/.test(i) ? "Right" : "Left" ].join("");

					target.css(padPos, padWrapper);

					this._proportionallyResize();

				}

				//TODO: What's that good for? There's not anything to be executed left
				if(!$(this.handles[i]).length) {
					continue;
				}
			}
		};

		//TODO: make renderAxis a prototype function
		this._renderAxis(this.element);

		this._handles = $(".ui-resizable-handle", this.element)
			.disableSelection();

		//Matching axis name
		this._handles.mouseover(function() {
			if (!that.resizing) {
				if (this.className) {
					axis = this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i);
				}
				//Axis, default = se
				that.axis = axis && axis[1] ? axis[1] : "se";
			}
		});

		//If we want to auto hide the elements
		if (o.autoHide) {
			this._handles.hide();
			$(this.element)
				.addClass("ui-resizable-autohide")
				.mouseenter(function() {
					if (o.disabled) {
						return;
					}
					$(this).removeClass("ui-resizable-autohide");
					that._handles.show();
				})
				.mouseleave(function(){
					if (o.disabled) {
						return;
					}
					if (!that.resizing) {
						$(this).addClass("ui-resizable-autohide");
						that._handles.hide();
					}
				});
		}

		//Initialize the mouse interaction
		this._mouseInit();

	},

	_destroy: function() {

		this._mouseDestroy();

		var wrapper,
			_destroy = function(exp) {
				$(exp).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing")
					.removeData("resizable").removeData("ui-resizable").unbind(".resizable").find(".ui-resizable-handle").remove();
			};

		//TODO: Unwrap at same DOM position
		if (this.elementIsWrapper) {
			_destroy(this.element);
			wrapper = this.element;
			this.originalElement.css({
				position: wrapper.css("position"),
				width: wrapper.outerWidth(),
				height: wrapper.outerHeight(),
				top: wrapper.css("top"),
				left: wrapper.css("left")
			}).insertAfter( wrapper );
			wrapper.remove();
		}

		this.originalElement.css("resize", this.originalResizeStyle);
		_destroy(this.originalElement);

		return this;
	},

	_mouseCapture: function(event) {
		var i, handle,
			capture = false;

		for (i in this.handles) {
			handle = $(this.handles[i])[0];
			if (handle === event.target || $.contains(handle, event.target)) {
				capture = true;
			}
		}

		return !this.options.disabled && capture;
	},

	_mouseStart: function(event) {

		var curleft, curtop, cursor,
			o = this.options,
			iniPos = this.element.position(),
			el = this.element;

		this.resizing = true;

		// bugfix for http://dev.jquery.com/ticket/1749
		if ( (/absolute/).test( el.css("position") ) ) {
			el.css({ position: "absolute", top: el.css("top"), left: el.css("left") });
		} else if (el.is(".ui-draggable")) {
			el.css({ position: "absolute", top: iniPos.top, left: iniPos.left });
		}

		this._renderProxy();

		curleft = num(this.helper.css("left"));
		curtop = num(this.helper.css("top"));

		if (o.containment) {
			curleft += $(o.containment).scrollLeft() || 0;
			curtop += $(o.containment).scrollTop() || 0;
		}

		//Store needed variables
		this.offset = this.helper.offset();
		this.position = { left: curleft, top: curtop };
		this.size = this._helper ? { width: this.helper.width(), height: this.helper.height() } : { width: el.width(), height: el.height() };
		this.originalSize = this._helper ? { width: el.outerWidth(), height: el.outerHeight() } : { width: el.width(), height: el.height() };
		this.originalPosition = { left: curleft, top: curtop };
		this.sizeDiff = { width: el.outerWidth() - el.width(), height: el.outerHeight() - el.height() };
		this.originalMousePosition = { left: event.pageX, top: event.pageY };

		//Aspect Ratio
		this.aspectRatio = (typeof o.aspectRatio === "number") ? o.aspectRatio : ((this.originalSize.width / this.originalSize.height) || 1);

		cursor = $(".ui-resizable-" + this.axis).css("cursor");
		$("body").css("cursor", cursor === "auto" ? this.axis + "-resize" : cursor);

		el.addClass("ui-resizable-resizing");
		this._propagate("start", event);
		return true;
	},

	_mouseDrag: function(event) {

		//Increase performance, avoid regex
		var data,
			el = this.helper, props = {},
			smp = this.originalMousePosition,
			a = this.axis,
			prevTop = this.position.top,
			prevLeft = this.position.left,
			prevWidth = this.size.width,
			prevHeight = this.size.height,
			dx = (event.pageX-smp.left)||0,
			dy = (event.pageY-smp.top)||0,
			trigger = this._change[a];

		if (!trigger) {
			return false;
		}

		// Calculate the attrs that will be change
		data = trigger.apply(this, [event, dx, dy]);

		// Put this in the mouseDrag handler since the user can start pressing shift while resizing
		this._updateVirtualBoundaries(event.shiftKey);
		if (this._aspectRatio || event.shiftKey) {
			data = this._updateRatio(data, event);
		}

		data = this._respectSize(data, event);

		this._updateCache(data);

		// plugins callbacks need to be called first
		this._propagate("resize", event);

		if (this.position.top !== prevTop) {
			props.top = this.position.top + "px";
		}
		if (this.position.left !== prevLeft) {
			props.left = this.position.left + "px";
		}
		if (this.size.width !== prevWidth) {
			props.width = this.size.width + "px";
		}
		if (this.size.height !== prevHeight) {
			props.height = this.size.height + "px";
		}
		el.css(props);

		if (!this._helper && this._proportionallyResizeElements.length) {
			this._proportionallyResize();
		}

		// Call the user callback if the element was resized
		if ( ! $.isEmptyObject(props) ) {
			this._trigger("resize", event, this.ui());
		}

		return false;
	},

	_mouseStop: function(event) {

		this.resizing = false;
		var pr, ista, soffseth, soffsetw, s, left, top,
			o = this.options, that = this;

		if(this._helper) {

			pr = this._proportionallyResizeElements;
			ista = pr.length && (/textarea/i).test(pr[0].nodeName);
			soffseth = ista && $.ui.hasScroll(pr[0], "left") /* TODO - jump height */ ? 0 : that.sizeDiff.height;
			soffsetw = ista ? 0 : that.sizeDiff.width;

			s = { width: (that.helper.width()  - soffsetw), height: (that.helper.height() - soffseth) };
			left = (parseInt(that.element.css("left"), 10) + (that.position.left - that.originalPosition.left)) || null;
			top = (parseInt(that.element.css("top"), 10) + (that.position.top - that.originalPosition.top)) || null;

			if (!o.animate) {
				this.element.css($.extend(s, { top: top, left: left }));
			}

			that.helper.height(that.size.height);
			that.helper.width(that.size.width);

			if (this._helper && !o.animate) {
				this._proportionallyResize();
			}
		}

		$("body").css("cursor", "auto");

		this.element.removeClass("ui-resizable-resizing");

		this._propagate("stop", event);

		if (this._helper) {
			this.helper.remove();
		}

		return false;

	},

	_updateVirtualBoundaries: function(forceAspectRatio) {
		var pMinWidth, pMaxWidth, pMinHeight, pMaxHeight, b,
			o = this.options;

		b = {
			minWidth: isNumber(o.minWidth) ? o.minWidth : 0,
			maxWidth: isNumber(o.maxWidth) ? o.maxWidth : Infinity,
			minHeight: isNumber(o.minHeight) ? o.minHeight : 0,
			maxHeight: isNumber(o.maxHeight) ? o.maxHeight : Infinity
		};

		if(this._aspectRatio || forceAspectRatio) {
			// We want to create an enclosing box whose aspect ration is the requested one
			// First, compute the "projected" size for each dimension based on the aspect ratio and other dimension
			pMinWidth = b.minHeight * this.aspectRatio;
			pMinHeight = b.minWidth / this.aspectRatio;
			pMaxWidth = b.maxHeight * this.aspectRatio;
			pMaxHeight = b.maxWidth / this.aspectRatio;

			if(pMinWidth > b.minWidth) {
				b.minWidth = pMinWidth;
			}
			if(pMinHeight > b.minHeight) {
				b.minHeight = pMinHeight;
			}
			if(pMaxWidth < b.maxWidth) {
				b.maxWidth = pMaxWidth;
			}
			if(pMaxHeight < b.maxHeight) {
				b.maxHeight = pMaxHeight;
			}
		}
		this._vBoundaries = b;
	},

	_updateCache: function(data) {
		this.offset = this.helper.offset();
		if (isNumber(data.left)) {
			this.position.left = data.left;
		}
		if (isNumber(data.top)) {
			this.position.top = data.top;
		}
		if (isNumber(data.height)) {
			this.size.height = data.height;
		}
		if (isNumber(data.width)) {
			this.size.width = data.width;
		}
	},

	_updateRatio: function( data ) {

		var cpos = this.position,
			csize = this.size,
			a = this.axis;

		if (isNumber(data.height)) {
			data.width = (data.height * this.aspectRatio);
		} else if (isNumber(data.width)) {
			data.height = (data.width / this.aspectRatio);
		}

		if (a === "sw") {
			data.left = cpos.left + (csize.width - data.width);
			data.top = null;
		}
		if (a === "nw") {
			data.top = cpos.top + (csize.height - data.height);
			data.left = cpos.left + (csize.width - data.width);
		}

		return data;
	},

	_respectSize: function( data ) {

		var o = this._vBoundaries,
			a = this.axis,
			ismaxw = isNumber(data.width) && o.maxWidth && (o.maxWidth < data.width), ismaxh = isNumber(data.height) && o.maxHeight && (o.maxHeight < data.height),
			isminw = isNumber(data.width) && o.minWidth && (o.minWidth > data.width), isminh = isNumber(data.height) && o.minHeight && (o.minHeight > data.height),
			dw = this.originalPosition.left + this.originalSize.width,
			dh = this.position.top + this.size.height,
			cw = /sw|nw|w/.test(a), ch = /nw|ne|n/.test(a);
		if (isminw) {
			data.width = o.minWidth;
		}
		if (isminh) {
			data.height = o.minHeight;
		}
		if (ismaxw) {
			data.width = o.maxWidth;
		}
		if (ismaxh) {
			data.height = o.maxHeight;
		}

		if (isminw && cw) {
			data.left = dw - o.minWidth;
		}
		if (ismaxw && cw) {
			data.left = dw - o.maxWidth;
		}
		if (isminh && ch) {
			data.top = dh - o.minHeight;
		}
		if (ismaxh && ch) {
			data.top = dh - o.maxHeight;
		}

		// fixing jump error on top/left - bug #2330
		if (!data.width && !data.height && !data.left && data.top) {
			data.top = null;
		} else if (!data.width && !data.height && !data.top && data.left) {
			data.left = null;
		}

		return data;
	},

	_proportionallyResize: function() {

		if (!this._proportionallyResizeElements.length) {
			return;
		}

		var i, j, borders, paddings, prel,
			element = this.helper || this.element;

		for ( i=0; i < this._proportionallyResizeElements.length; i++) {

			prel = this._proportionallyResizeElements[i];

			if (!this.borderDif) {
				this.borderDif = [];
				borders = [prel.css("borderTopWidth"), prel.css("borderRightWidth"), prel.css("borderBottomWidth"), prel.css("borderLeftWidth")];
				paddings = [prel.css("paddingTop"), prel.css("paddingRight"), prel.css("paddingBottom"), prel.css("paddingLeft")];

				for ( j = 0; j < borders.length; j++ ) {
					this.borderDif[ j ] = ( parseInt( borders[ j ], 10 ) || 0 ) + ( parseInt( paddings[ j ], 10 ) || 0 );
				}
			}

			prel.css({
				height: (element.height() - this.borderDif[0] - this.borderDif[2]) || 0,
				width: (element.width() - this.borderDif[1] - this.borderDif[3]) || 0
			});

		}

	},

	_renderProxy: function() {

		var el = this.element, o = this.options;
		this.elementOffset = el.offset();

		if(this._helper) {

			this.helper = this.helper || $("<div style='overflow:hidden;'></div>");

			this.helper.addClass(this._helper).css({
				width: this.element.outerWidth() - 1,
				height: this.element.outerHeight() - 1,
				position: "absolute",
				left: this.elementOffset.left +"px",
				top: this.elementOffset.top +"px",
				zIndex: ++o.zIndex //TODO: Don't modify option
			});

			this.helper
				.appendTo("body")
				.disableSelection();

		} else {
			this.helper = this.element;
		}

	},

	_change: {
		e: function(event, dx) {
			return { width: this.originalSize.width + dx };
		},
		w: function(event, dx) {
			var cs = this.originalSize, sp = this.originalPosition;
			return { left: sp.left + dx, width: cs.width - dx };
		},
		n: function(event, dx, dy) {
			var cs = this.originalSize, sp = this.originalPosition;
			return { top: sp.top + dy, height: cs.height - dy };
		},
		s: function(event, dx, dy) {
			return { height: this.originalSize.height + dy };
		},
		se: function(event, dx, dy) {
			return $.extend(this._change.s.apply(this, arguments), this._change.e.apply(this, [event, dx, dy]));
		},
		sw: function(event, dx, dy) {
			return $.extend(this._change.s.apply(this, arguments), this._change.w.apply(this, [event, dx, dy]));
		},
		ne: function(event, dx, dy) {
			return $.extend(this._change.n.apply(this, arguments), this._change.e.apply(this, [event, dx, dy]));
		},
		nw: function(event, dx, dy) {
			return $.extend(this._change.n.apply(this, arguments), this._change.w.apply(this, [event, dx, dy]));
		}
	},

	_propagate: function(n, event) {
		$.ui.plugin.call(this, n, [event, this.ui()]);
		(n !== "resize" && this._trigger(n, event, this.ui()));
	},

	plugins: {},

	ui: function() {
		return {
			originalElement: this.originalElement,
			element: this.element,
			helper: this.helper,
			position: this.position,
			size: this.size,
			originalSize: this.originalSize,
			originalPosition: this.originalPosition
		};
	}

});

/*
 * Resizable Extensions
 */

$.ui.plugin.add("resizable", "animate", {

	stop: function( event ) {
		var that = $(this).data("ui-resizable"),
			o = that.options,
			pr = that._proportionallyResizeElements,
			ista = pr.length && (/textarea/i).test(pr[0].nodeName),
			soffseth = ista && $.ui.hasScroll(pr[0], "left") /* TODO - jump height */ ? 0 : that.sizeDiff.height,
			soffsetw = ista ? 0 : that.sizeDiff.width,
			style = { width: (that.size.width - soffsetw), height: (that.size.height - soffseth) },
			left = (parseInt(that.element.css("left"), 10) + (that.position.left - that.originalPosition.left)) || null,
			top = (parseInt(that.element.css("top"), 10) + (that.position.top - that.originalPosition.top)) || null;

		that.element.animate(
			$.extend(style, top && left ? { top: top, left: left } : {}), {
				duration: o.animateDuration,
				easing: o.animateEasing,
				step: function() {

					var data = {
						width: parseInt(that.element.css("width"), 10),
						height: parseInt(that.element.css("height"), 10),
						top: parseInt(that.element.css("top"), 10),
						left: parseInt(that.element.css("left"), 10)
					};

					if (pr && pr.length) {
						$(pr[0]).css({ width: data.width, height: data.height });
					}

					// propagating resize, and updating values for each animation step
					that._updateCache(data);
					that._propagate("resize", event);

				}
			}
		);
	}

});

$.ui.plugin.add("resizable", "containment", {

	start: function() {
		var element, p, co, ch, cw, width, height,
			that = $(this).data("ui-resizable"),
			o = that.options,
			el = that.element,
			oc = o.containment,
			ce = (oc instanceof $) ? oc.get(0) : (/parent/.test(oc)) ? el.parent().get(0) : oc;

		if (!ce) {
			return;
		}

		that.containerElement = $(ce);

		if (/document/.test(oc) || oc === document) {
			that.containerOffset = { left: 0, top: 0 };
			that.containerPosition = { left: 0, top: 0 };

			that.parentData = {
				element: $(document), left: 0, top: 0,
				width: $(document).width(), height: $(document).height() || document.body.parentNode.scrollHeight
			};
		}

		// i'm a node, so compute top, left, right, bottom
		else {
			element = $(ce);
			p = [];
			$([ "Top", "Right", "Left", "Bottom" ]).each(function(i, name) { p[i] = num(element.css("padding" + name)); });

			that.containerOffset = element.offset();
			that.containerPosition = element.position();
			that.containerSize = { height: (element.innerHeight() - p[3]), width: (element.innerWidth() - p[1]) };

			co = that.containerOffset;
			ch = that.containerSize.height;
			cw = that.containerSize.width;
			width = ($.ui.hasScroll(ce, "left") ? ce.scrollWidth : cw );
			height = ($.ui.hasScroll(ce) ? ce.scrollHeight : ch);

			that.parentData = {
				element: ce, left: co.left, top: co.top, width: width, height: height
			};
		}
	},

	resize: function( event ) {
		var woset, hoset, isParent, isOffsetRelative,
			that = $(this).data("ui-resizable"),
			o = that.options,
			co = that.containerOffset, cp = that.position,
			pRatio = that._aspectRatio || event.shiftKey,
			cop = { top:0, left:0 }, ce = that.containerElement;

		if (ce[0] !== document && (/static/).test(ce.css("position"))) {
			cop = co;
		}

		if (cp.left < (that._helper ? co.left : 0)) {
			that.size.width = that.size.width + (that._helper ? (that.position.left - co.left) : (that.position.left - cop.left));
			if (pRatio) {
				that.size.height = that.size.width / that.aspectRatio;
			}
			that.position.left = o.helper ? co.left : 0;
		}

		if (cp.top < (that._helper ? co.top : 0)) {
			that.size.height = that.size.height + (that._helper ? (that.position.top - co.top) : that.position.top);
			if (pRatio) {
				that.size.width = that.size.height * that.aspectRatio;
			}
			that.position.top = that._helper ? co.top : 0;
		}

		that.offset.left = that.parentData.left+that.position.left;
		that.offset.top = that.parentData.top+that.position.top;

		woset = Math.abs( (that._helper ? that.offset.left - cop.left : (that.offset.left - cop.left)) + that.sizeDiff.width );
		hoset = Math.abs( (that._helper ? that.offset.top - cop.top : (that.offset.top - co.top)) + that.sizeDiff.height );

		isParent = that.containerElement.get(0) === that.element.parent().get(0);
		isOffsetRelative = /relative|absolute/.test(that.containerElement.css("position"));

		if ( isParent && isOffsetRelative ) {
			woset -= Math.abs( that.parentData.left );
		}

		if (woset + that.size.width >= that.parentData.width) {
			that.size.width = that.parentData.width - woset;
			if (pRatio) {
				that.size.height = that.size.width / that.aspectRatio;
			}
		}

		if (hoset + that.size.height >= that.parentData.height) {
			that.size.height = that.parentData.height - hoset;
			if (pRatio) {
				that.size.width = that.size.height * that.aspectRatio;
			}
		}
	},

	stop: function(){
		var that = $(this).data("ui-resizable"),
			o = that.options,
			co = that.containerOffset,
			cop = that.containerPosition,
			ce = that.containerElement,
			helper = $(that.helper),
			ho = helper.offset(),
			w = helper.outerWidth() - that.sizeDiff.width,
			h = helper.outerHeight() - that.sizeDiff.height;

		if (that._helper && !o.animate && (/relative/).test(ce.css("position"))) {
			$(this).css({ left: ho.left - cop.left - co.left, width: w, height: h });
		}

		if (that._helper && !o.animate && (/static/).test(ce.css("position"))) {
			$(this).css({ left: ho.left - cop.left - co.left, width: w, height: h });
		}

	}
});

$.ui.plugin.add("resizable", "alsoResize", {

	start: function () {
		var that = $(this).data("ui-resizable"),
			o = that.options,
			_store = function (exp) {
				$(exp).each(function() {
					var el = $(this);
					el.data("ui-resizable-alsoresize", {
						width: parseInt(el.width(), 10), height: parseInt(el.height(), 10),
						left: parseInt(el.css("left"), 10), top: parseInt(el.css("top"), 10)
					});
				});
			};

		if (typeof(o.alsoResize) === "object" && !o.alsoResize.parentNode) {
			if (o.alsoResize.length) { o.alsoResize = o.alsoResize[0]; _store(o.alsoResize); }
			else { $.each(o.alsoResize, function (exp) { _store(exp); }); }
		}else{
			_store(o.alsoResize);
		}
	},

	resize: function (event, ui) {
		var that = $(this).data("ui-resizable"),
			o = that.options,
			os = that.originalSize,
			op = that.originalPosition,
			delta = {
				height: (that.size.height - os.height) || 0, width: (that.size.width - os.width) || 0,
				top: (that.position.top - op.top) || 0, left: (that.position.left - op.left) || 0
			},

			_alsoResize = function (exp, c) {
				$(exp).each(function() {
					var el = $(this), start = $(this).data("ui-resizable-alsoresize"), style = {},
						css = c && c.length ? c : el.parents(ui.originalElement[0]).length ? ["width", "height"] : ["width", "height", "top", "left"];

					$.each(css, function (i, prop) {
						var sum = (start[prop]||0) + (delta[prop]||0);
						if (sum && sum >= 0) {
							style[prop] = sum || null;
						}
					});

					el.css(style);
				});
			};

		if (typeof(o.alsoResize) === "object" && !o.alsoResize.nodeType) {
			$.each(o.alsoResize, function (exp, c) { _alsoResize(exp, c); });
		}else{
			_alsoResize(o.alsoResize);
		}
	},

	stop: function () {
		$(this).removeData("resizable-alsoresize");
	}
});

$.ui.plugin.add("resizable", "ghost", {

	start: function() {

		var that = $(this).data("ui-resizable"), o = that.options, cs = that.size;

		that.ghost = that.originalElement.clone();
		that.ghost
			.css({ opacity: 0.25, display: "block", position: "relative", height: cs.height, width: cs.width, margin: 0, left: 0, top: 0 })
			.addClass("ui-resizable-ghost")
			.addClass(typeof o.ghost === "string" ? o.ghost : "");

		that.ghost.appendTo(that.helper);

	},

	resize: function(){
		var that = $(this).data("ui-resizable");
		if (that.ghost) {
			that.ghost.css({ position: "relative", height: that.size.height, width: that.size.width });
		}
	},

	stop: function() {
		var that = $(this).data("ui-resizable");
		if (that.ghost && that.helper) {
			that.helper.get(0).removeChild(that.ghost.get(0));
		}
	}

});

$.ui.plugin.add("resizable", "grid", {

	resize: function() {
		var that = $(this).data("ui-resizable"),
			o = that.options,
			cs = that.size,
			os = that.originalSize,
			op = that.originalPosition,
			a = that.axis,
			grid = typeof o.grid === "number" ? [o.grid, o.grid] : o.grid,
			gridX = (grid[0]||1),
			gridY = (grid[1]||1),
			ox = Math.round((cs.width - os.width) / gridX) * gridX,
			oy = Math.round((cs.height - os.height) / gridY) * gridY,
			newWidth = os.width + ox,
			newHeight = os.height + oy,
			isMaxWidth = o.maxWidth && (o.maxWidth < newWidth),
			isMaxHeight = o.maxHeight && (o.maxHeight < newHeight),
			isMinWidth = o.minWidth && (o.minWidth > newWidth),
			isMinHeight = o.minHeight && (o.minHeight > newHeight);

		o.grid = grid;

		if (isMinWidth) {
			newWidth = newWidth + gridX;
		}
		if (isMinHeight) {
			newHeight = newHeight + gridY;
		}
		if (isMaxWidth) {
			newWidth = newWidth - gridX;
		}
		if (isMaxHeight) {
			newHeight = newHeight - gridY;
		}

		if (/^(se|s|e)$/.test(a)) {
			that.size.width = newWidth;
			that.size.height = newHeight;
		} else if (/^(ne)$/.test(a)) {
			that.size.width = newWidth;
			that.size.height = newHeight;
			that.position.top = op.top - oy;
		} else if (/^(sw)$/.test(a)) {
			that.size.width = newWidth;
			that.size.height = newHeight;
			that.position.left = op.left - ox;
		} else {
			if ( newHeight - gridY > 0 ) {
				that.size.height = newHeight;
				that.position.top = op.top - oy;
			} else {
				that.size.height = gridY;
				that.position.top = op.top + os.height - gridY;
			}
			if ( newWidth - gridX > 0 ) {
				that.size.width = newWidth;
				that.position.left = op.left - ox;
			} else {
				that.size.width = gridX;
				that.position.left = op.left + os.width - gridX;
			}
		}
	}

});

})(jQuery);
(function( $, undefined ) {

function isOverAxis( x, reference, size ) {
	return ( x > reference ) && ( x < ( reference + size ) );
}

function isFloating(item) {
	return (/left|right/).test(item.css("float")) || (/inline|table-cell/).test(item.css("display"));
}

$.widget("ui.sortable", $.ui.mouse, {
	version: "1.10.4",
	widgetEventPrefix: "sort",
	ready: false,
	options: {
		appendTo: "parent",
		axis: false,
		connectWith: false,
		containment: false,
		cursor: "auto",
		cursorAt: false,
		dropOnEmpty: true,
		forcePlaceholderSize: false,
		forceHelperSize: false,
		grid: false,
		handle: false,
		helper: "original",
		items: "> *",
		opacity: false,
		placeholder: false,
		revert: false,
		scroll: true,
		scrollSensitivity: 20,
		scrollSpeed: 20,
		scope: "default",
		tolerance: "intersect",
		zIndex: 1000,

		// callbacks
		activate: null,
		beforeStop: null,
		change: null,
		deactivate: null,
		out: null,
		over: null,
		receive: null,
		remove: null,
		sort: null,
		start: null,
		stop: null,
		update: null
	},
	_create: function() {

		var o = this.options;
		this.containerCache = {};
		this.element.addClass("ui-sortable");

		//Get the items
		this.refresh();

		//Let's determine if the items are being displayed horizontally
		this.floating = this.items.length ? o.axis === "x" || isFloating(this.items[0].item) : false;

		//Let's determine the parent's offset
		this.offset = this.element.offset();

		//Initialize mouse events for interaction
		this._mouseInit();

		//We're ready to go
		this.ready = true;

	},

	_destroy: function() {
		this.element
			.removeClass("ui-sortable ui-sortable-disabled");
		this._mouseDestroy();

		for ( var i = this.items.length - 1; i >= 0; i-- ) {
			this.items[i].item.removeData(this.widgetName + "-item");
		}

		return this;
	},

	_setOption: function(key, value){
		if ( key === "disabled" ) {
			this.options[ key ] = value;

			this.widget().toggleClass( "ui-sortable-disabled", !!value );
		} else {
			// Don't call widget base _setOption for disable as it adds ui-state-disabled class
			$.Widget.prototype._setOption.apply(this, arguments);
		}
	},

	_mouseCapture: function(event, overrideHandle) {
		var currentItem = null,
			validHandle = false,
			that = this;

		if (this.reverting) {
			return false;
		}

		if(this.options.disabled || this.options.type === "static") {
			return false;
		}

		//We have to refresh the items data once first
		this._refreshItems(event);

		//Find out if the clicked node (or one of its parents) is a actual item in this.items
		$(event.target).parents().each(function() {
			if($.data(this, that.widgetName + "-item") === that) {
				currentItem = $(this);
				return false;
			}
		});
		if($.data(event.target, that.widgetName + "-item") === that) {
			currentItem = $(event.target);
		}

		if(!currentItem) {
			return false;
		}
		if(this.options.handle && !overrideHandle) {
			$(this.options.handle, currentItem).find("*").addBack().each(function() {
				if(this === event.target) {
					validHandle = true;
				}
			});
			if(!validHandle) {
				return false;
			}
		}

		this.currentItem = currentItem;
		this._removeCurrentsFromItems();
		return true;

	},

	_mouseStart: function(event, overrideHandle, noActivation) {

		var i, body,
			o = this.options;

		this.currentContainer = this;

		//We only need to call refreshPositions, because the refreshItems call has been moved to mouseCapture
		this.refreshPositions();

		//Create and append the visible helper
		this.helper = this._createHelper(event);

		//Cache the helper size
		this._cacheHelperProportions();

		/*
		 * - Position generation -
		 * This block generates everything position related - it's the core of draggables.
		 */

		//Cache the margins of the original element
		this._cacheMargins();

		//Get the next scrolling parent
		this.scrollParent = this.helper.scrollParent();

		//The element's absolute position on the page minus margins
		this.offset = this.currentItem.offset();
		this.offset = {
			top: this.offset.top - this.margins.top,
			left: this.offset.left - this.margins.left
		};

		$.extend(this.offset, {
			click: { //Where the click happened, relative to the element
				left: event.pageX - this.offset.left,
				top: event.pageY - this.offset.top
			},
			parent: this._getParentOffset(),
			relative: this._getRelativeOffset() //This is a relative to absolute position minus the actual position calculation - only used for relative positioned helper
		});

		// Only after we got the offset, we can change the helper's position to absolute
		// TODO: Still need to figure out a way to make relative sorting possible
		this.helper.css("position", "absolute");
		this.cssPosition = this.helper.css("position");

		//Generate the original position
		this.originalPosition = this._generatePosition(event);
		this.originalPageX = event.pageX;
		this.originalPageY = event.pageY;

		//Adjust the mouse offset relative to the helper if "cursorAt" is supplied
		(o.cursorAt && this._adjustOffsetFromHelper(o.cursorAt));

		//Cache the former DOM position
		this.domPosition = { prev: this.currentItem.prev()[0], parent: this.currentItem.parent()[0] };

		//If the helper is not the original, hide the original so it's not playing any role during the drag, won't cause anything bad this way
		if(this.helper[0] !== this.currentItem[0]) {
			this.currentItem.hide();
		}

		//Create the placeholder
		this._createPlaceholder();

		//Set a containment if given in the options
		if(o.containment) {
			this._setContainment();
		}

		if( o.cursor && o.cursor !== "auto" ) { // cursor option
			body = this.document.find( "body" );

			// support: IE
			this.storedCursor = body.css( "cursor" );
			body.css( "cursor", o.cursor );

			this.storedStylesheet = $( "<style>*{ cursor: "+o.cursor+" !important; }</style>" ).appendTo( body );
		}

		if(o.opacity) { // opacity option
			if (this.helper.css("opacity")) {
				this._storedOpacity = this.helper.css("opacity");
			}
			this.helper.css("opacity", o.opacity);
		}

		if(o.zIndex) { // zIndex option
			if (this.helper.css("zIndex")) {
				this._storedZIndex = this.helper.css("zIndex");
			}
			this.helper.css("zIndex", o.zIndex);
		}

		//Prepare scrolling
		if(this.scrollParent[0] !== document && this.scrollParent[0].tagName !== "HTML") {
			this.overflowOffset = this.scrollParent.offset();
		}

		//Call callbacks
		this._trigger("start", event, this._uiHash());

		//Recache the helper size
		if(!this._preserveHelperProportions) {
			this._cacheHelperProportions();
		}


		//Post "activate" events to possible containers
		if( !noActivation ) {
			for ( i = this.containers.length - 1; i >= 0; i-- ) {
				this.containers[ i ]._trigger( "activate", event, this._uiHash( this ) );
			}
		}

		//Prepare possible droppables
		if($.ui.ddmanager) {
			$.ui.ddmanager.current = this;
		}

		if ($.ui.ddmanager && !o.dropBehaviour) {
			$.ui.ddmanager.prepareOffsets(this, event);
		}

		this.dragging = true;

		this.helper.addClass("ui-sortable-helper");
		this._mouseDrag(event); //Execute the drag once - this causes the helper not to be visible before getting its correct position
		return true;

	},

	_mouseDrag: function(event) {
		var i, item, itemElement, intersection,
			o = this.options,
			scrolled = false;

		//Compute the helpers position
		this.position = this._generatePosition(event);
		this.positionAbs = this._convertPositionTo("absolute");

		if (!this.lastPositionAbs) {
			this.lastPositionAbs = this.positionAbs;
		}

		//Do scrolling
		if(this.options.scroll) {
			if(this.scrollParent[0] !== document && this.scrollParent[0].tagName !== "HTML") {

				if((this.overflowOffset.top + this.scrollParent[0].offsetHeight) - event.pageY < o.scrollSensitivity) {
					this.scrollParent[0].scrollTop = scrolled = this.scrollParent[0].scrollTop + o.scrollSpeed;
				} else if(event.pageY - this.overflowOffset.top < o.scrollSensitivity) {
					this.scrollParent[0].scrollTop = scrolled = this.scrollParent[0].scrollTop - o.scrollSpeed;
				}

				if((this.overflowOffset.left + this.scrollParent[0].offsetWidth) - event.pageX < o.scrollSensitivity) {
					this.scrollParent[0].scrollLeft = scrolled = this.scrollParent[0].scrollLeft + o.scrollSpeed;
				} else if(event.pageX - this.overflowOffset.left < o.scrollSensitivity) {
					this.scrollParent[0].scrollLeft = scrolled = this.scrollParent[0].scrollLeft - o.scrollSpeed;
				}

			} else {

				if(event.pageY - $(document).scrollTop() < o.scrollSensitivity) {
					scrolled = $(document).scrollTop($(document).scrollTop() - o.scrollSpeed);
				} else if($(window).height() - (event.pageY - $(document).scrollTop()) < o.scrollSensitivity) {
					scrolled = $(document).scrollTop($(document).scrollTop() + o.scrollSpeed);
				}

				if(event.pageX - $(document).scrollLeft() < o.scrollSensitivity) {
					scrolled = $(document).scrollLeft($(document).scrollLeft() - o.scrollSpeed);
				} else if($(window).width() - (event.pageX - $(document).scrollLeft()) < o.scrollSensitivity) {
					scrolled = $(document).scrollLeft($(document).scrollLeft() + o.scrollSpeed);
				}

			}

			if(scrolled !== false && $.ui.ddmanager && !o.dropBehaviour) {
				$.ui.ddmanager.prepareOffsets(this, event);
			}
		}

		//Regenerate the absolute position used for position checks
		this.positionAbs = this._convertPositionTo("absolute");

		//Set the helper position
		if(!this.options.axis || this.options.axis !== "y") {
			this.helper[0].style.left = this.position.left+"px";
		}
		if(!this.options.axis || this.options.axis !== "x") {
			this.helper[0].style.top = this.position.top+"px";
		}

		//Rearrange
		for (i = this.items.length - 1; i >= 0; i--) {

			//Cache variables and intersection, continue if no intersection
			item = this.items[i];
			itemElement = item.item[0];
			intersection = this._intersectsWithPointer(item);
			if (!intersection) {
				continue;
			}

			// Only put the placeholder inside the current Container, skip all
			// items from other containers. This works because when moving
			// an item from one container to another the
			// currentContainer is switched before the placeholder is moved.
			//
			// Without this, moving items in "sub-sortables" can cause
			// the placeholder to jitter beetween the outer and inner container.
			if (item.instance !== this.currentContainer) {
				continue;
			}

			// cannot intersect with itself
			// no useless actions that have been done before
			// no action if the item moved is the parent of the item checked
			if (itemElement !== this.currentItem[0] &&
				this.placeholder[intersection === 1 ? "next" : "prev"]()[0] !== itemElement &&
				!$.contains(this.placeholder[0], itemElement) &&
				(this.options.type === "semi-dynamic" ? !$.contains(this.element[0], itemElement) : true)
			) {

				this.direction = intersection === 1 ? "down" : "up";

				if (this.options.tolerance === "pointer" || this._intersectsWithSides(item)) {
					this._rearrange(event, item);
				} else {
					break;
				}

				this._trigger("change", event, this._uiHash());
				break;
			}
		}

		//Post events to containers
		this._contactContainers(event);

		//Interconnect with droppables
		if($.ui.ddmanager) {
			$.ui.ddmanager.drag(this, event);
		}

		//Call callbacks
		this._trigger("sort", event, this._uiHash());

		this.lastPositionAbs = this.positionAbs;
		return false;

	},

	_mouseStop: function(event, noPropagation) {

		if(!event) {
			return;
		}

		//If we are using droppables, inform the manager about the drop
		if ($.ui.ddmanager && !this.options.dropBehaviour) {
			$.ui.ddmanager.drop(this, event);
		}

		if(this.options.revert) {
			var that = this,
				cur = this.placeholder.offset(),
				axis = this.options.axis,
				animation = {};

			if ( !axis || axis === "x" ) {
				animation.left = cur.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollLeft);
			}
			if ( !axis || axis === "y" ) {
				animation.top = cur.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollTop);
			}
			this.reverting = true;
			$(this.helper).animate( animation, parseInt(this.options.revert, 10) || 500, function() {
				that._clear(event);
			});
		} else {
			this._clear(event, noPropagation);
		}

		return false;

	},

	cancel: function() {

		if(this.dragging) {

			this._mouseUp({ target: null });

			if(this.options.helper === "original") {
				this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper");
			} else {
				this.currentItem.show();
			}

			//Post deactivating events to containers
			for (var i = this.containers.length - 1; i >= 0; i--){
				this.containers[i]._trigger("deactivate", null, this._uiHash(this));
				if(this.containers[i].containerCache.over) {
					this.containers[i]._trigger("out", null, this._uiHash(this));
					this.containers[i].containerCache.over = 0;
				}
			}

		}

		if (this.placeholder) {
			//$(this.placeholder[0]).remove(); would have been the jQuery way - unfortunately, it unbinds ALL events from the original node!
			if(this.placeholder[0].parentNode) {
				this.placeholder[0].parentNode.removeChild(this.placeholder[0]);
			}
			if(this.options.helper !== "original" && this.helper && this.helper[0].parentNode) {
				this.helper.remove();
			}

			$.extend(this, {
				helper: null,
				dragging: false,
				reverting: false,
				_noFinalSort: null
			});

			if(this.domPosition.prev) {
				$(this.domPosition.prev).after(this.currentItem);
			} else {
				$(this.domPosition.parent).prepend(this.currentItem);
			}
		}

		return this;

	},

	serialize: function(o) {

		var items = this._getItemsAsjQuery(o && o.connected),
			str = [];
		o = o || {};

		$(items).each(function() {
			var res = ($(o.item || this).attr(o.attribute || "id") || "").match(o.expression || (/(.+)[\-=_](.+)/));
			if (res) {
				str.push((o.key || res[1]+"[]")+"="+(o.key && o.expression ? res[1] : res[2]));
			}
		});

		if(!str.length && o.key) {
			str.push(o.key + "=");
		}

		return str.join("&");

	},

	toArray: function(o) {

		var items = this._getItemsAsjQuery(o && o.connected),
			ret = [];

		o = o || {};

		items.each(function() { ret.push($(o.item || this).attr(o.attribute || "id") || ""); });
		return ret;

	},

	/* Be careful with the following core functions */
	_intersectsWith: function(item) {

		var x1 = this.positionAbs.left,
			x2 = x1 + this.helperProportions.width,
			y1 = this.positionAbs.top,
			y2 = y1 + this.helperProportions.height,
			l = item.left,
			r = l + item.width,
			t = item.top,
			b = t + item.height,
			dyClick = this.offset.click.top,
			dxClick = this.offset.click.left,
			isOverElementHeight = ( this.options.axis === "x" ) || ( ( y1 + dyClick ) > t && ( y1 + dyClick ) < b ),
			isOverElementWidth = ( this.options.axis === "y" ) || ( ( x1 + dxClick ) > l && ( x1 + dxClick ) < r ),
			isOverElement = isOverElementHeight && isOverElementWidth;

		if ( this.options.tolerance === "pointer" ||
			this.options.forcePointerForContainers ||
			(this.options.tolerance !== "pointer" && this.helperProportions[this.floating ? "width" : "height"] > item[this.floating ? "width" : "height"])
		) {
			return isOverElement;
		} else {

			return (l < x1 + (this.helperProportions.width / 2) && // Right Half
				x2 - (this.helperProportions.width / 2) < r && // Left Half
				t < y1 + (this.helperProportions.height / 2) && // Bottom Half
				y2 - (this.helperProportions.height / 2) < b ); // Top Half

		}
	},

	_intersectsWithPointer: function(item) {

		var isOverElementHeight = (this.options.axis === "x") || isOverAxis(this.positionAbs.top + this.offset.click.top, item.top, item.height),
			isOverElementWidth = (this.options.axis === "y") || isOverAxis(this.positionAbs.left + this.offset.click.left, item.left, item.width),
			isOverElement = isOverElementHeight && isOverElementWidth,
			verticalDirection = this._getDragVerticalDirection(),
			horizontalDirection = this._getDragHorizontalDirection();

		if (!isOverElement) {
			return false;
		}

		return this.floating ?
			( ((horizontalDirection && horizontalDirection === "right") || verticalDirection === "down") ? 2 : 1 )
			: ( verticalDirection && (verticalDirection === "down" ? 2 : 1) );

	},

	_intersectsWithSides: function(item) {

		var isOverBottomHalf = isOverAxis(this.positionAbs.top + this.offset.click.top, item.top + (item.height/2), item.height),
			isOverRightHalf = isOverAxis(this.positionAbs.left + this.offset.click.left, item.left + (item.width/2), item.width),
			verticalDirection = this._getDragVerticalDirection(),
			horizontalDirection = this._getDragHorizontalDirection();

		if (this.floating && horizontalDirection) {
			return ((horizontalDirection === "right" && isOverRightHalf) || (horizontalDirection === "left" && !isOverRightHalf));
		} else {
			return verticalDirection && ((verticalDirection === "down" && isOverBottomHalf) || (verticalDirection === "up" && !isOverBottomHalf));
		}

	},

	_getDragVerticalDirection: function() {
		var delta = this.positionAbs.top - this.lastPositionAbs.top;
		return delta !== 0 && (delta > 0 ? "down" : "up");
	},

	_getDragHorizontalDirection: function() {
		var delta = this.positionAbs.left - this.lastPositionAbs.left;
		return delta !== 0 && (delta > 0 ? "right" : "left");
	},

	refresh: function(event) {
		this._refreshItems(event);
		this.refreshPositions();
		return this;
	},

	_connectWith: function() {
		var options = this.options;
		return options.connectWith.constructor === String ? [options.connectWith] : options.connectWith;
	},

	_getItemsAsjQuery: function(connected) {

		var i, j, cur, inst,
			items = [],
			queries = [],
			connectWith = this._connectWith();

		if(connectWith && connected) {
			for (i = connectWith.length - 1; i >= 0; i--){
				cur = $(connectWith[i]);
				for ( j = cur.length - 1; j >= 0; j--){
					inst = $.data(cur[j], this.widgetFullName);
					if(inst && inst !== this && !inst.options.disabled) {
						queries.push([$.isFunction(inst.options.items) ? inst.options.items.call(inst.element) : $(inst.options.items, inst.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), inst]);
					}
				}
			}
		}

		queries.push([$.isFunction(this.options.items) ? this.options.items.call(this.element, null, { options: this.options, item: this.currentItem }) : $(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]);

		function addItems() {
			items.push( this );
		}
		for (i = queries.length - 1; i >= 0; i--){
			queries[i][0].each( addItems );
		}

		return $(items);

	},

	_removeCurrentsFromItems: function() {

		var list = this.currentItem.find(":data(" + this.widgetName + "-item)");

		this.items = $.grep(this.items, function (item) {
			for (var j=0; j < list.length; j++) {
				if(list[j] === item.item[0]) {
					return false;
				}
			}
			return true;
		});

	},

	_refreshItems: function(event) {

		this.items = [];
		this.containers = [this];

		var i, j, cur, inst, targetData, _queries, item, queriesLength,
			items = this.items,
			queries = [[$.isFunction(this.options.items) ? this.options.items.call(this.element[0], event, { item: this.currentItem }) : $(this.options.items, this.element), this]],
			connectWith = this._connectWith();

		if(connectWith && this.ready) { //Shouldn't be run the first time through due to massive slow-down
			for (i = connectWith.length - 1; i >= 0; i--){
				cur = $(connectWith[i]);
				for (j = cur.length - 1; j >= 0; j--){
					inst = $.data(cur[j], this.widgetFullName);
					if(inst && inst !== this && !inst.options.disabled) {
						queries.push([$.isFunction(inst.options.items) ? inst.options.items.call(inst.element[0], event, { item: this.currentItem }) : $(inst.options.items, inst.element), inst]);
						this.containers.push(inst);
					}
				}
			}
		}

		for (i = queries.length - 1; i >= 0; i--) {
			targetData = queries[i][1];
			_queries = queries[i][0];

			for (j=0, queriesLength = _queries.length; j < queriesLength; j++) {
				item = $(_queries[j]);

				item.data(this.widgetName + "-item", targetData); // Data for target checking (mouse manager)

				items.push({
					item: item,
					instance: targetData,
					width: 0, height: 0,
					left: 0, top: 0
				});
			}
		}

	},

	refreshPositions: function(fast) {

		//This has to be redone because due to the item being moved out/into the offsetParent, the offsetParent's position will change
		if(this.offsetParent && this.helper) {
			this.offset.parent = this._getParentOffset();
		}

		var i, item, t, p;

		for (i = this.items.length - 1; i >= 0; i--){
			item = this.items[i];

			//We ignore calculating positions of all connected containers when we're not over them
			if(item.instance !== this.currentContainer && this.currentContainer && item.item[0] !== this.currentItem[0]) {
				continue;
			}

			t = this.options.toleranceElement ? $(this.options.toleranceElement, item.item) : item.item;

			if (!fast) {
				item.width = t.outerWidth();
				item.height = t.outerHeight();
			}

			p = t.offset();
			item.left = p.left;
			item.top = p.top;
		}

		if(this.options.custom && this.options.custom.refreshContainers) {
			this.options.custom.refreshContainers.call(this);
		} else {
			for (i = this.containers.length - 1; i >= 0; i--){
				p = this.containers[i].element.offset();
				this.containers[i].containerCache.left = p.left;
				this.containers[i].containerCache.top = p.top;
				this.containers[i].containerCache.width	= this.containers[i].element.outerWidth();
				this.containers[i].containerCache.height = this.containers[i].element.outerHeight();
			}
		}

		return this;
	},

	_createPlaceholder: function(that) {
		that = that || this;
		var className,
			o = that.options;

		if(!o.placeholder || o.placeholder.constructor === String) {
			className = o.placeholder;
			o.placeholder = {
				element: function() {

					var nodeName = that.currentItem[0].nodeName.toLowerCase(),
						element = $( "<" + nodeName + ">", that.document[0] )
							.addClass(className || that.currentItem[0].className+" ui-sortable-placeholder")
							.removeClass("ui-sortable-helper");

					if ( nodeName === "tr" ) {
						that.currentItem.children().each(function() {
							$( "<td>&#160;</td>", that.document[0] )
								.attr( "colspan", $( this ).attr( "colspan" ) || 1 )
								.appendTo( element );
						});
					} else if ( nodeName === "img" ) {
						element.attr( "src", that.currentItem.attr( "src" ) );
					}

					if ( !className ) {
						element.css( "visibility", "hidden" );
					}

					return element;
				},
				update: function(container, p) {

					// 1. If a className is set as 'placeholder option, we don't force sizes - the class is responsible for that
					// 2. The option 'forcePlaceholderSize can be enabled to force it even if a class name is specified
					if(className && !o.forcePlaceholderSize) {
						return;
					}

					//If the element doesn't have a actual height by itself (without styles coming from a stylesheet), it receives the inline height from the dragged item
					if(!p.height()) { p.height(that.currentItem.innerHeight() - parseInt(that.currentItem.css("paddingTop")||0, 10) - parseInt(that.currentItem.css("paddingBottom")||0, 10)); }
					if(!p.width()) { p.width(that.currentItem.innerWidth() - parseInt(that.currentItem.css("paddingLeft")||0, 10) - parseInt(that.currentItem.css("paddingRight")||0, 10)); }
				}
			};
		}

		//Create the placeholder
		that.placeholder = $(o.placeholder.element.call(that.element, that.currentItem));

		//Append it after the actual current item
		that.currentItem.after(that.placeholder);

		//Update the size of the placeholder (TODO: Logic to fuzzy, see line 316/317)
		o.placeholder.update(that, that.placeholder);

	},

	_contactContainers: function(event) {
		var i, j, dist, itemWithLeastDistance, posProperty, sizeProperty, base, cur, nearBottom, floating,
			innermostContainer = null,
			innermostIndex = null;

		// get innermost container that intersects with item
		for (i = this.containers.length - 1; i >= 0; i--) {

			// never consider a container that's located within the item itself
			if($.contains(this.currentItem[0], this.containers[i].element[0])) {
				continue;
			}

			if(this._intersectsWith(this.containers[i].containerCache)) {

				// if we've already found a container and it's more "inner" than this, then continue
				if(innermostContainer && $.contains(this.containers[i].element[0], innermostContainer.element[0])) {
					continue;
				}

				innermostContainer = this.containers[i];
				innermostIndex = i;

			} else {
				// container doesn't intersect. trigger "out" event if necessary
				if(this.containers[i].containerCache.over) {
					this.containers[i]._trigger("out", event, this._uiHash(this));
					this.containers[i].containerCache.over = 0;
				}
			}

		}

		// if no intersecting containers found, return
		if(!innermostContainer) {
			return;
		}

		// move the item into the container if it's not there already
		if(this.containers.length === 1) {
			if (!this.containers[innermostIndex].containerCache.over) {
				this.containers[innermostIndex]._trigger("over", event, this._uiHash(this));
				this.containers[innermostIndex].containerCache.over = 1;
			}
		} else {

			//When entering a new container, we will find the item with the least distance and append our item near it
			dist = 10000;
			itemWithLeastDistance = null;
			floating = innermostContainer.floating || isFloating(this.currentItem);
			posProperty = floating ? "left" : "top";
			sizeProperty = floating ? "width" : "height";
			base = this.positionAbs[posProperty] + this.offset.click[posProperty];
			for (j = this.items.length - 1; j >= 0; j--) {
				if(!$.contains(this.containers[innermostIndex].element[0], this.items[j].item[0])) {
					continue;
				}
				if(this.items[j].item[0] === this.currentItem[0]) {
					continue;
				}
				if (floating && !isOverAxis(this.positionAbs.top + this.offset.click.top, this.items[j].top, this.items[j].height)) {
					continue;
				}
				cur = this.items[j].item.offset()[posProperty];
				nearBottom = false;
				if(Math.abs(cur - base) > Math.abs(cur + this.items[j][sizeProperty] - base)){
					nearBottom = true;
					cur += this.items[j][sizeProperty];
				}

				if(Math.abs(cur - base) < dist) {
					dist = Math.abs(cur - base); itemWithLeastDistance = this.items[j];
					this.direction = nearBottom ? "up": "down";
				}
			}

			//Check if dropOnEmpty is enabled
			if(!itemWithLeastDistance && !this.options.dropOnEmpty) {
				return;
			}

			if(this.currentContainer === this.containers[innermostIndex]) {
				return;
			}

			itemWithLeastDistance ? this._rearrange(event, itemWithLeastDistance, null, true) : this._rearrange(event, null, this.containers[innermostIndex].element, true);
			this._trigger("change", event, this._uiHash());
			this.containers[innermostIndex]._trigger("change", event, this._uiHash(this));
			this.currentContainer = this.containers[innermostIndex];

			//Update the placeholder
			this.options.placeholder.update(this.currentContainer, this.placeholder);

			this.containers[innermostIndex]._trigger("over", event, this._uiHash(this));
			this.containers[innermostIndex].containerCache.over = 1;
		}


	},

	_createHelper: function(event) {

		var o = this.options,
			helper = $.isFunction(o.helper) ? $(o.helper.apply(this.element[0], [event, this.currentItem])) : (o.helper === "clone" ? this.currentItem.clone() : this.currentItem);

		//Add the helper to the DOM if that didn't happen already
		if(!helper.parents("body").length) {
			$(o.appendTo !== "parent" ? o.appendTo : this.currentItem[0].parentNode)[0].appendChild(helper[0]);
		}

		if(helper[0] === this.currentItem[0]) {
			this._storedCSS = { width: this.currentItem[0].style.width, height: this.currentItem[0].style.height, position: this.currentItem.css("position"), top: this.currentItem.css("top"), left: this.currentItem.css("left") };
		}

		if(!helper[0].style.width || o.forceHelperSize) {
			helper.width(this.currentItem.width());
		}
		if(!helper[0].style.height || o.forceHelperSize) {
			helper.height(this.currentItem.height());
		}

		return helper;

	},

	_adjustOffsetFromHelper: function(obj) {
		if (typeof obj === "string") {
			obj = obj.split(" ");
		}
		if ($.isArray(obj)) {
			obj = {left: +obj[0], top: +obj[1] || 0};
		}
		if ("left" in obj) {
			this.offset.click.left = obj.left + this.margins.left;
		}
		if ("right" in obj) {
			this.offset.click.left = this.helperProportions.width - obj.right + this.margins.left;
		}
		if ("top" in obj) {
			this.offset.click.top = obj.top + this.margins.top;
		}
		if ("bottom" in obj) {
			this.offset.click.top = this.helperProportions.height - obj.bottom + this.margins.top;
		}
	},

	_getParentOffset: function() {


		//Get the offsetParent and cache its position
		this.offsetParent = this.helper.offsetParent();
		var po = this.offsetParent.offset();

		// This is a special case where we need to modify a offset calculated on start, since the following happened:
		// 1. The position of the helper is absolute, so it's position is calculated based on the next positioned parent
		// 2. The actual offset parent is a child of the scroll parent, and the scroll parent isn't the document, which means that
		//    the scroll is included in the initial calculation of the offset of the parent, and never recalculated upon drag
		if(this.cssPosition === "absolute" && this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) {
			po.left += this.scrollParent.scrollLeft();
			po.top += this.scrollParent.scrollTop();
		}

		// This needs to be actually done for all browsers, since pageX/pageY includes this information
		// with an ugly IE fix
		if( this.offsetParent[0] === document.body || (this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() === "html" && $.ui.ie)) {
			po = { top: 0, left: 0 };
		}

		return {
			top: po.top + (parseInt(this.offsetParent.css("borderTopWidth"),10) || 0),
			left: po.left + (parseInt(this.offsetParent.css("borderLeftWidth"),10) || 0)
		};

	},

	_getRelativeOffset: function() {

		if(this.cssPosition === "relative") {
			var p = this.currentItem.position();
			return {
				top: p.top - (parseInt(this.helper.css("top"),10) || 0) + this.scrollParent.scrollTop(),
				left: p.left - (parseInt(this.helper.css("left"),10) || 0) + this.scrollParent.scrollLeft()
			};
		} else {
			return { top: 0, left: 0 };
		}

	},

	_cacheMargins: function() {
		this.margins = {
			left: (parseInt(this.currentItem.css("marginLeft"),10) || 0),
			top: (parseInt(this.currentItem.css("marginTop"),10) || 0)
		};
	},

	_cacheHelperProportions: function() {
		this.helperProportions = {
			width: this.helper.outerWidth(),
			height: this.helper.outerHeight()
		};
	},

	_setContainment: function() {

		var ce, co, over,
			o = this.options;
		if(o.containment === "parent") {
			o.containment = this.helper[0].parentNode;
		}
		if(o.containment === "document" || o.containment === "window") {
			this.containment = [
				0 - this.offset.relative.left - this.offset.parent.left,
				0 - this.offset.relative.top - this.offset.parent.top,
				$(o.containment === "document" ? document : window).width() - this.helperProportions.width - this.margins.left,
				($(o.containment === "document" ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top
			];
		}

		if(!(/^(document|window|parent)$/).test(o.containment)) {
			ce = $(o.containment)[0];
			co = $(o.containment).offset();
			over = ($(ce).css("overflow") !== "hidden");

			this.containment = [
				co.left + (parseInt($(ce).css("borderLeftWidth"),10) || 0) + (parseInt($(ce).css("paddingLeft"),10) || 0) - this.margins.left,
				co.top + (parseInt($(ce).css("borderTopWidth"),10) || 0) + (parseInt($(ce).css("paddingTop"),10) || 0) - this.margins.top,
				co.left+(over ? Math.max(ce.scrollWidth,ce.offsetWidth) : ce.offsetWidth) - (parseInt($(ce).css("borderLeftWidth"),10) || 0) - (parseInt($(ce).css("paddingRight"),10) || 0) - this.helperProportions.width - this.margins.left,
				co.top+(over ? Math.max(ce.scrollHeight,ce.offsetHeight) : ce.offsetHeight) - (parseInt($(ce).css("borderTopWidth"),10) || 0) - (parseInt($(ce).css("paddingBottom"),10) || 0) - this.helperProportions.height - this.margins.top
			];
		}

	},

	_convertPositionTo: function(d, pos) {

		if(!pos) {
			pos = this.position;
		}
		var mod = d === "absolute" ? 1 : -1,
			scroll = this.cssPosition === "absolute" && !(this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent,
			scrollIsRootNode = (/(html|body)/i).test(scroll[0].tagName);

		return {
			top: (
				pos.top	+																// The absolute mouse position
				this.offset.relative.top * mod +										// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.top * mod -											// The offsetParent's offset without borders (offset + border)
				( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : ( scrollIsRootNode ? 0 : scroll.scrollTop() ) ) * mod)
			),
			left: (
				pos.left +																// The absolute mouse position
				this.offset.relative.left * mod +										// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.left * mod	-										// The offsetParent's offset without borders (offset + border)
				( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : scrollIsRootNode ? 0 : scroll.scrollLeft() ) * mod)
			)
		};

	},

	_generatePosition: function(event) {

		var top, left,
			o = this.options,
			pageX = event.pageX,
			pageY = event.pageY,
			scroll = this.cssPosition === "absolute" && !(this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent, scrollIsRootNode = (/(html|body)/i).test(scroll[0].tagName);

		// This is another very weird special case that only happens for relative elements:
		// 1. If the css position is relative
		// 2. and the scroll parent is the document or similar to the offset parent
		// we have to refresh the relative offset during the scroll so there are no jumps
		if(this.cssPosition === "relative" && !(this.scrollParent[0] !== document && this.scrollParent[0] !== this.offsetParent[0])) {
			this.offset.relative = this._getRelativeOffset();
		}

		/*
		 * - Position constraining -
		 * Constrain the position to a mix of grid, containment.
		 */

		if(this.originalPosition) { //If we are not dragging yet, we won't check for options

			if(this.containment) {
				if(event.pageX - this.offset.click.left < this.containment[0]) {
					pageX = this.containment[0] + this.offset.click.left;
				}
				if(event.pageY - this.offset.click.top < this.containment[1]) {
					pageY = this.containment[1] + this.offset.click.top;
				}
				if(event.pageX - this.offset.click.left > this.containment[2]) {
					pageX = this.containment[2] + this.offset.click.left;
				}
				if(event.pageY - this.offset.click.top > this.containment[3]) {
					pageY = this.containment[3] + this.offset.click.top;
				}
			}

			if(o.grid) {
				top = this.originalPageY + Math.round((pageY - this.originalPageY) / o.grid[1]) * o.grid[1];
				pageY = this.containment ? ( (top - this.offset.click.top >= this.containment[1] && top - this.offset.click.top <= this.containment[3]) ? top : ((top - this.offset.click.top >= this.containment[1]) ? top - o.grid[1] : top + o.grid[1])) : top;

				left = this.originalPageX + Math.round((pageX - this.originalPageX) / o.grid[0]) * o.grid[0];
				pageX = this.containment ? ( (left - this.offset.click.left >= this.containment[0] && left - this.offset.click.left <= this.containment[2]) ? left : ((left - this.offset.click.left >= this.containment[0]) ? left - o.grid[0] : left + o.grid[0])) : left;
			}

		}

		return {
			top: (
				pageY -																// The absolute mouse position
				this.offset.click.top -													// Click offset (relative to the element)
				this.offset.relative.top	-											// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.top +												// The offsetParent's offset without borders (offset + border)
				( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : ( scrollIsRootNode ? 0 : scroll.scrollTop() ) ))
			),
			left: (
				pageX -																// The absolute mouse position
				this.offset.click.left -												// Click offset (relative to the element)
				this.offset.relative.left	-											// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.left +												// The offsetParent's offset without borders (offset + border)
				( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : scrollIsRootNode ? 0 : scroll.scrollLeft() ))
			)
		};

	},

	_rearrange: function(event, i, a, hardRefresh) {

		a ? a[0].appendChild(this.placeholder[0]) : i.item[0].parentNode.insertBefore(this.placeholder[0], (this.direction === "down" ? i.item[0] : i.item[0].nextSibling));

		//Various things done here to improve the performance:
		// 1. we create a setTimeout, that calls refreshPositions
		// 2. on the instance, we have a counter variable, that get's higher after every append
		// 3. on the local scope, we copy the counter variable, and check in the timeout, if it's still the same
		// 4. this lets only the last addition to the timeout stack through
		this.counter = this.counter ? ++this.counter : 1;
		var counter = this.counter;

		this._delay(function() {
			if(counter === this.counter) {
				this.refreshPositions(!hardRefresh); //Precompute after each DOM insertion, NOT on mousemove
			}
		});

	},

	_clear: function(event, noPropagation) {

		this.reverting = false;
		// We delay all events that have to be triggered to after the point where the placeholder has been removed and
		// everything else normalized again
		var i,
			delayedTriggers = [];

		// We first have to update the dom position of the actual currentItem
		// Note: don't do it if the current item is already removed (by a user), or it gets reappended (see #4088)
		if(!this._noFinalSort && this.currentItem.parent().length) {
			this.placeholder.before(this.currentItem);
		}
		this._noFinalSort = null;

		if(this.helper[0] === this.currentItem[0]) {
			for(i in this._storedCSS) {
				if(this._storedCSS[i] === "auto" || this._storedCSS[i] === "static") {
					this._storedCSS[i] = "";
				}
			}
			this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper");
		} else {
			this.currentItem.show();
		}

		if(this.fromOutside && !noPropagation) {
			delayedTriggers.push(function(event) { this._trigger("receive", event, this._uiHash(this.fromOutside)); });
		}
		if((this.fromOutside || this.domPosition.prev !== this.currentItem.prev().not(".ui-sortable-helper")[0] || this.domPosition.parent !== this.currentItem.parent()[0]) && !noPropagation) {
			delayedTriggers.push(function(event) { this._trigger("update", event, this._uiHash()); }); //Trigger update callback if the DOM position has changed
		}

		// Check if the items Container has Changed and trigger appropriate
		// events.
		if (this !== this.currentContainer) {
			if(!noPropagation) {
				delayedTriggers.push(function(event) { this._trigger("remove", event, this._uiHash()); });
				delayedTriggers.push((function(c) { return function(event) { c._trigger("receive", event, this._uiHash(this)); };  }).call(this, this.currentContainer));
				delayedTriggers.push((function(c) { return function(event) { c._trigger("update", event, this._uiHash(this));  }; }).call(this, this.currentContainer));
			}
		}


		//Post events to containers
		function delayEvent( type, instance, container ) {
			return function( event ) {
				container._trigger( type, event, instance._uiHash( instance ) );
			};
		}
		for (i = this.containers.length - 1; i >= 0; i--){
			if (!noPropagation) {
				delayedTriggers.push( delayEvent( "deactivate", this, this.containers[ i ] ) );
			}
			if(this.containers[i].containerCache.over) {
				delayedTriggers.push( delayEvent( "out", this, this.containers[ i ] ) );
				this.containers[i].containerCache.over = 0;
			}
		}

		//Do what was originally in plugins
		if ( this.storedCursor ) {
			this.document.find( "body" ).css( "cursor", this.storedCursor );
			this.storedStylesheet.remove();
		}
		if(this._storedOpacity) {
			this.helper.css("opacity", this._storedOpacity);
		}
		if(this._storedZIndex) {
			this.helper.css("zIndex", this._storedZIndex === "auto" ? "" : this._storedZIndex);
		}

		this.dragging = false;
		if(this.cancelHelperRemoval) {
			if(!noPropagation) {
				this._trigger("beforeStop", event, this._uiHash());
				for (i=0; i < delayedTriggers.length; i++) {
					delayedTriggers[i].call(this, event);
				} //Trigger all delayed events
				this._trigger("stop", event, this._uiHash());
			}

			this.fromOutside = false;
			return false;
		}

		if(!noPropagation) {
			this._trigger("beforeStop", event, this._uiHash());
		}

		//$(this.placeholder[0]).remove(); would have been the jQuery way - unfortunately, it unbinds ALL events from the original node!
		this.placeholder[0].parentNode.removeChild(this.placeholder[0]);

		if(this.helper[0] !== this.currentItem[0]) {
			this.helper.remove();
		}
		this.helper = null;

		if(!noPropagation) {
			for (i=0; i < delayedTriggers.length; i++) {
				delayedTriggers[i].call(this, event);
			} //Trigger all delayed events
			this._trigger("stop", event, this._uiHash());
		}

		this.fromOutside = false;
		return true;

	},

	_trigger: function() {
		if ($.Widget.prototype._trigger.apply(this, arguments) === false) {
			this.cancel();
		}
	},

	_uiHash: function(_inst) {
		var inst = _inst || this;
		return {
			helper: inst.helper,
			placeholder: inst.placeholder || $([]),
			position: inst.position,
			originalPosition: inst.originalPosition,
			offset: inst.positionAbs,
			item: inst.currentItem,
			sender: _inst ? _inst.element : null
		};
	}

});

})(jQuery);
(function( $, undefined ) {

var lastActive,
	baseClasses = "ui-button ui-widget ui-state-default ui-corner-all",
	typeClasses = "ui-button-icons-only ui-button-icon-only ui-button-text-icons ui-button-text-icon-primary ui-button-text-icon-secondary ui-button-text-only",
	formResetHandler = function() {
		var form = $( this );
		setTimeout(function() {
			form.find( ":ui-button" ).button( "refresh" );
		}, 1 );
	},
	radioGroup = function( radio ) {
		var name = radio.name,
			form = radio.form,
			radios = $( [] );
		if ( name ) {
			name = name.replace( /'/g, "\\'" );
			if ( form ) {
				radios = $( form ).find( "[name='" + name + "']" );
			} else {
				radios = $( "[name='" + name + "']", radio.ownerDocument )
					.filter(function() {
						return !this.form;
					});
			}
		}
		return radios;
	};

$.widget( "ui.button", {
	version: "1.10.4",
	defaultElement: "<button>",
	options: {
		disabled: null,
		text: true,
		label: null,
		icons: {
			primary: null,
			secondary: null
		}
	},
	_create: function() {
		this.element.closest( "form" )
			.unbind( "reset" + this.eventNamespace )
			.bind( "reset" + this.eventNamespace, formResetHandler );

		if ( typeof this.options.disabled !== "boolean" ) {
			this.options.disabled = !!this.element.prop( "disabled" );
		} else {
			this.element.prop( "disabled", this.options.disabled );
		}

		this._determineButtonType();
		this.hasTitle = !!this.buttonElement.attr( "title" );

		var that = this,
			options = this.options,
			toggleButton = this.type === "checkbox" || this.type === "radio",
			activeClass = !toggleButton ? "ui-state-active" : "";

		if ( options.label === null ) {
			options.label = (this.type === "input" ? this.buttonElement.val() : this.buttonElement.html());
		}

		this._hoverable( this.buttonElement );

		this.buttonElement
			.addClass( baseClasses )
			.attr( "role", "button" )
			.bind( "mouseenter" + this.eventNamespace, function() {
				if ( options.disabled ) {
					return;
				}
				if ( this === lastActive ) {
					$( this ).addClass( "ui-state-active" );
				}
			})
			.bind( "mouseleave" + this.eventNamespace, function() {
				if ( options.disabled ) {
					return;
				}
				$( this ).removeClass( activeClass );
			})
			.bind( "click" + this.eventNamespace, function( event ) {
				if ( options.disabled ) {
					event.preventDefault();
					event.stopImmediatePropagation();
				}
			});

		// Can't use _focusable() because the element that receives focus
		// and the element that gets the ui-state-focus class are different
		this._on({
			focus: function() {
				this.buttonElement.addClass( "ui-state-focus" );
			},
			blur: function() {
				this.buttonElement.removeClass( "ui-state-focus" );
			}
		});

		if ( toggleButton ) {
			this.element.bind( "change" + this.eventNamespace, function() {
				that.refresh();
			});
		}

		if ( this.type === "checkbox" ) {
			this.buttonElement.bind( "click" + this.eventNamespace, function() {
				if ( options.disabled ) {
					return false;
				}
			});
		} else if ( this.type === "radio" ) {
			this.buttonElement.bind( "click" + this.eventNamespace, function() {
				if ( options.disabled ) {
					return false;
				}
				$( this ).addClass( "ui-state-active" );
				that.buttonElement.attr( "aria-pressed", "true" );

				var radio = that.element[ 0 ];
				radioGroup( radio )
					.not( radio )
					.map(function() {
						return $( this ).button( "widget" )[ 0 ];
					})
					.removeClass( "ui-state-active" )
					.attr( "aria-pressed", "false" );
			});
		} else {
			this.buttonElement
				.bind( "mousedown" + this.eventNamespace, function() {
					if ( options.disabled ) {
						return false;
					}
					$( this ).addClass( "ui-state-active" );
					lastActive = this;
					that.document.one( "mouseup", function() {
						lastActive = null;
					});
				})
				.bind( "mouseup" + this.eventNamespace, function() {
					if ( options.disabled ) {
						return false;
					}
					$( this ).removeClass( "ui-state-active" );
				})
				.bind( "keydown" + this.eventNamespace, function(event) {
					if ( options.disabled ) {
						return false;
					}
					if ( event.keyCode === $.ui.keyCode.SPACE || event.keyCode === $.ui.keyCode.ENTER ) {
						$( this ).addClass( "ui-state-active" );
					}
				})
				// see #8559, we bind to blur here in case the button element loses
				// focus between keydown and keyup, it would be left in an "active" state
				.bind( "keyup" + this.eventNamespace + " blur" + this.eventNamespace, function() {
					$( this ).removeClass( "ui-state-active" );
				});

			if ( this.buttonElement.is("a") ) {
				this.buttonElement.keyup(function(event) {
					if ( event.keyCode === $.ui.keyCode.SPACE ) {
						// TODO pass through original event correctly (just as 2nd argument doesn't work)
						$( this ).click();
					}
				});
			}
		}

		// TODO: pull out $.Widget's handling for the disabled option into
		// $.Widget.prototype._setOptionDisabled so it's easy to proxy and can
		// be overridden by individual plugins
		this._setOption( "disabled", options.disabled );
		this._resetButton();
	},

	_determineButtonType: function() {
		var ancestor, labelSelector, checked;

		if ( this.element.is("[type=checkbox]") ) {
			this.type = "checkbox";
		} else if ( this.element.is("[type=radio]") ) {
			this.type = "radio";
		} else if ( this.element.is("input") ) {
			this.type = "input";
		} else {
			this.type = "button";
		}

		if ( this.type === "checkbox" || this.type === "radio" ) {
			// we don't search against the document in case the element
			// is disconnected from the DOM
			ancestor = this.element.parents().last();
			labelSelector = "label[for='" + this.element.attr("id") + "']";
			this.buttonElement = ancestor.find( labelSelector );
			if ( !this.buttonElement.length ) {
				ancestor = ancestor.length ? ancestor.siblings() : this.element.siblings();
				this.buttonElement = ancestor.filter( labelSelector );
				if ( !this.buttonElement.length ) {
					this.buttonElement = ancestor.find( labelSelector );
				}
			}
			this.element.addClass( "ui-helper-hidden-accessible" );

			checked = this.element.is( ":checked" );
			if ( checked ) {
				this.buttonElement.addClass( "ui-state-active" );
			}
			this.buttonElement.prop( "aria-pressed", checked );
		} else {
			this.buttonElement = this.element;
		}
	},

	widget: function() {
		return this.buttonElement;
	},

	_destroy: function() {
		this.element
			.removeClass( "ui-helper-hidden-accessible" );
		this.buttonElement
			.removeClass( baseClasses + " ui-state-active " + typeClasses )
			.removeAttr( "role" )
			.removeAttr( "aria-pressed" )
			.html( this.buttonElement.find(".ui-button-text").html() );

		if ( !this.hasTitle ) {
			this.buttonElement.removeAttr( "title" );
		}
	},

	_setOption: function( key, value ) {
		this._super( key, value );
		if ( key === "disabled" ) {
			this.element.prop( "disabled", !!value );
			if ( value ) {
				this.buttonElement.removeClass( "ui-state-focus" );
			}
			return;
		}
		this._resetButton();
	},

	refresh: function() {
		//See #8237 & #8828
		var isDisabled = this.element.is( "input, button" ) ? this.element.is( ":disabled" ) : this.element.hasClass( "ui-button-disabled" );

		if ( isDisabled !== this.options.disabled ) {
			this._setOption( "disabled", isDisabled );
		}
		if ( this.type === "radio" ) {
			radioGroup( this.element[0] ).each(function() {
				if ( $( this ).is( ":checked" ) ) {
					$( this ).button( "widget" )
						.addClass( "ui-state-active" )
						.attr( "aria-pressed", "true" );
				} else {
					$( this ).button( "widget" )
						.removeClass( "ui-state-active" )
						.attr( "aria-pressed", "false" );
				}
			});
		} else if ( this.type === "checkbox" ) {
			if ( this.element.is( ":checked" ) ) {
				this.buttonElement
					.addClass( "ui-state-active" )
					.attr( "aria-pressed", "true" );
			} else {
				this.buttonElement
					.removeClass( "ui-state-active" )
					.attr( "aria-pressed", "false" );
			}
		}
	},

	_resetButton: function() {
		if ( this.type === "input" ) {
			if ( this.options.label ) {
				this.element.val( this.options.label );
			}
			return;
		}
		var buttonElement = this.buttonElement.removeClass( typeClasses ),
			buttonText = $( "<span></span>", this.document[0] )
				.addClass( "ui-button-text" )
				.html( this.options.label )
				.appendTo( buttonElement.empty() )
				.text(),
			icons = this.options.icons,
			multipleIcons = icons.primary && icons.secondary,
			buttonClasses = [];

		if ( icons.primary || icons.secondary ) {
			if ( this.options.text ) {
				buttonClasses.push( "ui-button-text-icon" + ( multipleIcons ? "s" : ( icons.primary ? "-primary" : "-secondary" ) ) );
			}

			if ( icons.primary ) {
				buttonElement.prepend( "<span class='ui-button-icon-primary ui-icon " + icons.primary + "'></span>" );
			}

			if ( icons.secondary ) {
				buttonElement.append( "<span class='ui-button-icon-secondary ui-icon " + icons.secondary + "'></span>" );
			}

			if ( !this.options.text ) {
				buttonClasses.push( multipleIcons ? "ui-button-icons-only" : "ui-button-icon-only" );

				if ( !this.hasTitle ) {
					buttonElement.attr( "title", $.trim( buttonText ) );
				}
			}
		} else {
			buttonClasses.push( "ui-button-text-only" );
		}
		buttonElement.addClass( buttonClasses.join( " " ) );
	}
});

$.widget( "ui.buttonset", {
	version: "1.10.4",
	options: {
		items: "button, input[type=button], input[type=submit], input[type=reset], input[type=checkbox], input[type=radio], a, :data(ui-button)"
	},

	_create: function() {
		this.element.addClass( "ui-buttonset" );
	},

	_init: function() {
		this.refresh();
	},

	_setOption: function( key, value ) {
		if ( key === "disabled" ) {
			this.buttons.button( "option", key, value );
		}

		this._super( key, value );
	},

	refresh: function() {
		var rtl = this.element.css( "direction" ) === "rtl";

		this.buttons = this.element.find( this.options.items )
			.filter( ":ui-button" )
				.button( "refresh" )
			.end()
			.not( ":ui-button" )
				.button()
			.end()
			.map(function() {
				return $( this ).button( "widget" )[ 0 ];
			})
				.removeClass( "ui-corner-all ui-corner-left ui-corner-right" )
				.filter( ":first" )
					.addClass( rtl ? "ui-corner-right" : "ui-corner-left" )
				.end()
				.filter( ":last" )
					.addClass( rtl ? "ui-corner-left" : "ui-corner-right" )
				.end()
			.end();
	},

	_destroy: function() {
		this.element.removeClass( "ui-buttonset" );
		this.buttons
			.map(function() {
				return $( this ).button( "widget" )[ 0 ];
			})
				.removeClass( "ui-corner-left ui-corner-right" )
			.end()
			.button( "destroy" );
	}
});

}( jQuery ) );
(function( $, undefined ) {

// number of pages in a slider
// (how many times can you page up/down to go through the whole range)
var numPages = 5;

$.widget( "ui.slider", $.ui.mouse, {
	version: "1.10.4",
	widgetEventPrefix: "slide",

	options: {
		animate: false,
		distance: 0,
		max: 100,
		min: 0,
		orientation: "horizontal",
		range: false,
		step: 1,
		value: 0,
		values: null,

		// callbacks
		change: null,
		slide: null,
		start: null,
		stop: null
	},

	_create: function() {
		this._keySliding = false;
		this._mouseSliding = false;
		this._animateOff = true;
		this._handleIndex = null;
		this._detectOrientation();
		this._mouseInit();

		this.element
			.addClass( "ui-slider" +
				" ui-slider-" + this.orientation +
				" ui-widget" +
				" ui-widget-content" +
				" ui-corner-all");

		this._refresh();
		this._setOption( "disabled", this.options.disabled );

		this._animateOff = false;
	},

	_refresh: function() {
		this._createRange();
		this._createHandles();
		this._setupEvents();
		this._refreshValue();
	},

	_createHandles: function() {
		var i, handleCount,
			options = this.options,
			existingHandles = this.element.find( ".ui-slider-handle" ).addClass( "ui-state-default ui-corner-all" ),
			handle = "<a class='ui-slider-handle ui-state-default ui-corner-all' href='#'></a>",
			handles = [];

		handleCount = ( options.values && options.values.length ) || 1;

		if ( existingHandles.length > handleCount ) {
			existingHandles.slice( handleCount ).remove();
			existingHandles = existingHandles.slice( 0, handleCount );
		}

		for ( i = existingHandles.length; i < handleCount; i++ ) {
			handles.push( handle );
		}

		this.handles = existingHandles.add( $( handles.join( "" ) ).appendTo( this.element ) );

		this.handle = this.handles.eq( 0 );

		this.handles.each(function( i ) {
			$( this ).data( "ui-slider-handle-index", i );
		});
	},

	_createRange: function() {
		var options = this.options,
			classes = "";

		if ( options.range ) {
			if ( options.range === true ) {
				if ( !options.values ) {
					options.values = [ this._valueMin(), this._valueMin() ];
				} else if ( options.values.length && options.values.length !== 2 ) {
					options.values = [ options.values[0], options.values[0] ];
				} else if ( $.isArray( options.values ) ) {
					options.values = options.values.slice(0);
				}
			}

			if ( !this.range || !this.range.length ) {
				this.range = $( "<div></div>" )
					.appendTo( this.element );

				classes = "ui-slider-range" +
				// note: this isn't the most fittingly semantic framework class for this element,
				// but worked best visually with a variety of themes
				" ui-widget-header ui-corner-all";
			} else {
				this.range.removeClass( "ui-slider-range-min ui-slider-range-max" )
					// Handle range switching from true to min/max
					.css({
						"left": "",
						"bottom": ""
					});
			}

			this.range.addClass( classes +
				( ( options.range === "min" || options.range === "max" ) ? " ui-slider-range-" + options.range : "" ) );
		} else {
			if ( this.range ) {
				this.range.remove();
			}
			this.range = null;
		}
	},

	_setupEvents: function() {
		var elements = this.handles.add( this.range ).filter( "a" );
		this._off( elements );
		this._on( elements, this._handleEvents );
		this._hoverable( elements );
		this._focusable( elements );
	},

	_destroy: function() {
		this.handles.remove();
		if ( this.range ) {
			this.range.remove();
		}

		this.element
			.removeClass( "ui-slider" +
				" ui-slider-horizontal" +
				" ui-slider-vertical" +
				" ui-widget" +
				" ui-widget-content" +
				" ui-corner-all" );

		this._mouseDestroy();
	},

	_mouseCapture: function( event ) {
		var position, normValue, distance, closestHandle, index, allowed, offset, mouseOverHandle,
			that = this,
			o = this.options;

		if ( o.disabled ) {
			return false;
		}

		this.elementSize = {
			width: this.element.outerWidth(),
			height: this.element.outerHeight()
		};
		this.elementOffset = this.element.offset();

		position = { x: event.pageX, y: event.pageY };
		normValue = this._normValueFromMouse( position );
		distance = this._valueMax() - this._valueMin() + 1;
		this.handles.each(function( i ) {
			var thisDistance = Math.abs( normValue - that.values(i) );
			if (( distance > thisDistance ) ||
				( distance === thisDistance &&
					(i === that._lastChangedValue || that.values(i) === o.min ))) {
				distance = thisDistance;
				closestHandle = $( this );
				index = i;
			}
		});

		allowed = this._start( event, index );
		if ( allowed === false ) {
			return false;
		}
		this._mouseSliding = true;

		this._handleIndex = index;

		closestHandle
			.addClass( "ui-state-active" )
			.focus();

		offset = closestHandle.offset();
		mouseOverHandle = !$( event.target ).parents().addBack().is( ".ui-slider-handle" );
		this._clickOffset = mouseOverHandle ? { left: 0, top: 0 } : {
			left: event.pageX - offset.left - ( closestHandle.width() / 2 ),
			top: event.pageY - offset.top -
				( closestHandle.height() / 2 ) -
				( parseInt( closestHandle.css("borderTopWidth"), 10 ) || 0 ) -
				( parseInt( closestHandle.css("borderBottomWidth"), 10 ) || 0) +
				( parseInt( closestHandle.css("marginTop"), 10 ) || 0)
		};

		if ( !this.handles.hasClass( "ui-state-hover" ) ) {
			this._slide( event, index, normValue );
		}
		this._animateOff = true;
		return true;
	},

	_mouseStart: function() {
		return true;
	},

	_mouseDrag: function( event ) {
		var position = { x: event.pageX, y: event.pageY },
			normValue = this._normValueFromMouse( position );

		this._slide( event, this._handleIndex, normValue );

		return false;
	},

	_mouseStop: function( event ) {
		this.handles.removeClass( "ui-state-active" );
		this._mouseSliding = false;

		this._stop( event, this._handleIndex );
		this._change( event, this._handleIndex );

		this._handleIndex = null;
		this._clickOffset = null;
		this._animateOff = false;

		return false;
	},

	_detectOrientation: function() {
		this.orientation = ( this.options.orientation === "vertical" ) ? "vertical" : "horizontal";
	},

	_normValueFromMouse: function( position ) {
		var pixelTotal,
			pixelMouse,
			percentMouse,
			valueTotal,
			valueMouse;

		if ( this.orientation === "horizontal" ) {
			pixelTotal = this.elementSize.width;
			pixelMouse = position.x - this.elementOffset.left - ( this._clickOffset ? this._clickOffset.left : 0 );
		} else {
			pixelTotal = this.elementSize.height;
			pixelMouse = position.y - this.elementOffset.top - ( this._clickOffset ? this._clickOffset.top : 0 );
		}

		percentMouse = ( pixelMouse / pixelTotal );
		if ( percentMouse > 1 ) {
			percentMouse = 1;
		}
		if ( percentMouse < 0 ) {
			percentMouse = 0;
		}
		if ( this.orientation === "vertical" ) {
			percentMouse = 1 - percentMouse;
		}

		valueTotal = this._valueMax() - this._valueMin();
		valueMouse = this._valueMin() + percentMouse * valueTotal;

		return this._trimAlignValue( valueMouse );
	},

	_start: function( event, index ) {
		var uiHash = {
			handle: this.handles[ index ],
			value: this.value()
		};
		if ( this.options.values && this.options.values.length ) {
			uiHash.value = this.values( index );
			uiHash.values = this.values();
		}
		return this._trigger( "start", event, uiHash );
	},

	_slide: function( event, index, newVal ) {
		var otherVal,
			newValues,
			allowed;

		if ( this.options.values && this.options.values.length ) {
			otherVal = this.values( index ? 0 : 1 );

			if ( ( this.options.values.length === 2 && this.options.range === true ) &&
					( ( index === 0 && newVal > otherVal) || ( index === 1 && newVal < otherVal ) )
				) {
				newVal = otherVal;
			}

			if ( newVal !== this.values( index ) ) {
				newValues = this.values();
				newValues[ index ] = newVal;
				// A slide can be canceled by returning false from the slide callback
				allowed = this._trigger( "slide", event, {
					handle: this.handles[ index ],
					value: newVal,
					values: newValues
				} );
				otherVal = this.values( index ? 0 : 1 );
				if ( allowed !== false ) {
					this.values( index, newVal );
				}
			}
		} else {
			if ( newVal !== this.value() ) {
				// A slide can be canceled by returning false from the slide callback
				allowed = this._trigger( "slide", event, {
					handle: this.handles[ index ],
					value: newVal
				} );
				if ( allowed !== false ) {
					this.value( newVal );
				}
			}
		}
	},

	_stop: function( event, index ) {
		var uiHash = {
			handle: this.handles[ index ],
			value: this.value()
		};
		if ( this.options.values && this.options.values.length ) {
			uiHash.value = this.values( index );
			uiHash.values = this.values();
		}

		this._trigger( "stop", event, uiHash );
	},

	_change: function( event, index ) {
		if ( !this._keySliding && !this._mouseSliding ) {
			var uiHash = {
				handle: this.handles[ index ],
				value: this.value()
			};
			if ( this.options.values && this.options.values.length ) {
				uiHash.value = this.values( index );
				uiHash.values = this.values();
			}

			//store the last changed value index for reference when handles overlap
			this._lastChangedValue = index;

			this._trigger( "change", event, uiHash );
		}
	},

	value: function( newValue ) {
		if ( arguments.length ) {
			this.options.value = this._trimAlignValue( newValue );
			this._refreshValue();
			this._change( null, 0 );
			return;
		}

		return this._value();
	},

	values: function( index, newValue ) {
		var vals,
			newValues,
			i;

		if ( arguments.length > 1 ) {
			this.options.values[ index ] = this._trimAlignValue( newValue );
			this._refreshValue();
			this._change( null, index );
			return;
		}

		if ( arguments.length ) {
			if ( $.isArray( arguments[ 0 ] ) ) {
				vals = this.options.values;
				newValues = arguments[ 0 ];
				for ( i = 0; i < vals.length; i += 1 ) {
					vals[ i ] = this._trimAlignValue( newValues[ i ] );
					this._change( null, i );
				}
				this._refreshValue();
			} else {
				if ( this.options.values && this.options.values.length ) {
					return this._values( index );
				} else {
					return this.value();
				}
			}
		} else {
			return this._values();
		}
	},

	_setOption: function( key, value ) {
		var i,
			valsLength = 0;

		if ( key === "range" && this.options.range === true ) {
			if ( value === "min" ) {
				this.options.value = this._values( 0 );
				this.options.values = null;
			} else if ( value === "max" ) {
				this.options.value = this._values( this.options.values.length-1 );
				this.options.values = null;
			}
		}

		if ( $.isArray( this.options.values ) ) {
			valsLength = this.options.values.length;
		}

		$.Widget.prototype._setOption.apply( this, arguments );

		switch ( key ) {
			case "orientation":
				this._detectOrientation();
				this.element
					.removeClass( "ui-slider-horizontal ui-slider-vertical" )
					.addClass( "ui-slider-" + this.orientation );
				this._refreshValue();
				break;
			case "value":
				this._animateOff = true;
				this._refreshValue();
				this._change( null, 0 );
				this._animateOff = false;
				break;
			case "values":
				this._animateOff = true;
				this._refreshValue();
				for ( i = 0; i < valsLength; i += 1 ) {
					this._change( null, i );
				}
				this._animateOff = false;
				break;
			case "min":
			case "max":
				this._animateOff = true;
				this._refreshValue();
				this._animateOff = false;
				break;
			case "range":
				this._animateOff = true;
				this._refresh();
				this._animateOff = false;
				break;
		}
	},

	//internal value getter
	// _value() returns value trimmed by min and max, aligned by step
	_value: function() {
		var val = this.options.value;
		val = this._trimAlignValue( val );

		return val;
	},

	//internal values getter
	// _values() returns array of values trimmed by min and max, aligned by step
	// _values( index ) returns single value trimmed by min and max, aligned by step
	_values: function( index ) {
		var val,
			vals,
			i;

		if ( arguments.length ) {
			val = this.options.values[ index ];
			val = this._trimAlignValue( val );

			return val;
		} else if ( this.options.values && this.options.values.length ) {
			// .slice() creates a copy of the array
			// this copy gets trimmed by min and max and then returned
			vals = this.options.values.slice();
			for ( i = 0; i < vals.length; i+= 1) {
				vals[ i ] = this._trimAlignValue( vals[ i ] );
			}

			return vals;
		} else {
			return [];
		}
	},

	// returns the step-aligned value that val is closest to, between (inclusive) min and max
	_trimAlignValue: function( val ) {
		if ( val <= this._valueMin() ) {
			return this._valueMin();
		}
		if ( val >= this._valueMax() ) {
			return this._valueMax();
		}
		var step = ( this.options.step > 0 ) ? this.options.step : 1,
			valModStep = (val - this._valueMin()) % step,
			alignValue = val - valModStep;

		if ( Math.abs(valModStep) * 2 >= step ) {
			alignValue += ( valModStep > 0 ) ? step : ( -step );
		}

		// Since JavaScript has problems with large floats, round
		// the final value to 5 digits after the decimal point (see #4124)
		return parseFloat( alignValue.toFixed(5) );
	},

	_valueMin: function() {
		return this.options.min;
	},

	_valueMax: function() {
		return this.options.max;
	},

	_refreshValue: function() {
		var lastValPercent, valPercent, value, valueMin, valueMax,
			oRange = this.options.range,
			o = this.options,
			that = this,
			animate = ( !this._animateOff ) ? o.animate : false,
			_set = {};

		if ( this.options.values && this.options.values.length ) {
			this.handles.each(function( i ) {
				valPercent = ( that.values(i) - that._valueMin() ) / ( that._valueMax() - that._valueMin() ) * 100;
				_set[ that.orientation === "horizontal" ? "left" : "bottom" ] = valPercent + "%";
				$( this ).stop( 1, 1 )[ animate ? "animate" : "css" ]( _set, o.animate );
				if ( that.options.range === true ) {
					if ( that.orientation === "horizontal" ) {
						if ( i === 0 ) {
							that.range.stop( 1, 1 )[ animate ? "animate" : "css" ]( { left: valPercent + "%" }, o.animate );
						}
						if ( i === 1 ) {
							that.range[ animate ? "animate" : "css" ]( { width: ( valPercent - lastValPercent ) + "%" }, { queue: false, duration: o.animate } );
						}
					} else {
						if ( i === 0 ) {
							that.range.stop( 1, 1 )[ animate ? "animate" : "css" ]( { bottom: ( valPercent ) + "%" }, o.animate );
						}
						if ( i === 1 ) {
							that.range[ animate ? "animate" : "css" ]( { height: ( valPercent - lastValPercent ) + "%" }, { queue: false, duration: o.animate } );
						}
					}
				}
				lastValPercent = valPercent;
			});
		} else {
			value = this.value();
			valueMin = this._valueMin();
			valueMax = this._valueMax();
			valPercent = ( valueMax !== valueMin ) ?
					( value - valueMin ) / ( valueMax - valueMin ) * 100 :
					0;
			_set[ this.orientation === "horizontal" ? "left" : "bottom" ] = valPercent + "%";
			this.handle.stop( 1, 1 )[ animate ? "animate" : "css" ]( _set, o.animate );

			if ( oRange === "min" && this.orientation === "horizontal" ) {
				this.range.stop( 1, 1 )[ animate ? "animate" : "css" ]( { width: valPercent + "%" }, o.animate );
			}
			if ( oRange === "max" && this.orientation === "horizontal" ) {
				this.range[ animate ? "animate" : "css" ]( { width: ( 100 - valPercent ) + "%" }, { queue: false, duration: o.animate } );
			}
			if ( oRange === "min" && this.orientation === "vertical" ) {
				this.range.stop( 1, 1 )[ animate ? "animate" : "css" ]( { height: valPercent + "%" }, o.animate );
			}
			if ( oRange === "max" && this.orientation === "vertical" ) {
				this.range[ animate ? "animate" : "css" ]( { height: ( 100 - valPercent ) + "%" }, { queue: false, duration: o.animate } );
			}
		}
	},

	_handleEvents: {
		keydown: function( event ) {
			var allowed, curVal, newVal, step,
				index = $( event.target ).data( "ui-slider-handle-index" );

			switch ( event.keyCode ) {
				case $.ui.keyCode.HOME:
				case $.ui.keyCode.END:
				case $.ui.keyCode.PAGE_UP:
				case $.ui.keyCode.PAGE_DOWN:
				case $.ui.keyCode.UP:
				case $.ui.keyCode.RIGHT:
				case $.ui.keyCode.DOWN:
				case $.ui.keyCode.LEFT:
					event.preventDefault();
					if ( !this._keySliding ) {
						this._keySliding = true;
						$( event.target ).addClass( "ui-state-active" );
						allowed = this._start( event, index );
						if ( allowed === false ) {
							return;
						}
					}
					break;
			}

			step = this.options.step;
			if ( this.options.values && this.options.values.length ) {
				curVal = newVal = this.values( index );
			} else {
				curVal = newVal = this.value();
			}

			switch ( event.keyCode ) {
				case $.ui.keyCode.HOME:
					newVal = this._valueMin();
					break;
				case $.ui.keyCode.END:
					newVal = this._valueMax();
					break;
				case $.ui.keyCode.PAGE_UP:
					newVal = this._trimAlignValue( curVal + ( (this._valueMax() - this._valueMin()) / numPages ) );
					break;
				case $.ui.keyCode.PAGE_DOWN:
					newVal = this._trimAlignValue( curVal - ( (this._valueMax() - this._valueMin()) / numPages ) );
					break;
				case $.ui.keyCode.UP:
				case $.ui.keyCode.RIGHT:
					if ( curVal === this._valueMax() ) {
						return;
					}
					newVal = this._trimAlignValue( curVal + step );
					break;
				case $.ui.keyCode.DOWN:
				case $.ui.keyCode.LEFT:
					if ( curVal === this._valueMin() ) {
						return;
					}
					newVal = this._trimAlignValue( curVal - step );
					break;
			}

			this._slide( event, index, newVal );
		},
		click: function( event ) {
			event.preventDefault();
		},
		keyup: function( event ) {
			var index = $( event.target ).data( "ui-slider-handle-index" );

			if ( this._keySliding ) {
				this._keySliding = false;
				this._stop( event, index );
				this._change( event, index );
				$( event.target ).removeClass( "ui-state-active" );
			}
		}
	}

});

}(jQuery));
(function( $ ) {

function modifier( fn ) {
	return function() {
		var previous = this.element.val();
		fn.apply( this, arguments );
		this._refresh();
		if ( previous !== this.element.val() ) {
			this._trigger( "change" );
		}
	};
}

$.widget( "ui.spinner", {
	version: "1.10.4",
	defaultElement: "<input>",
	widgetEventPrefix: "spin",
	options: {
		culture: null,
		icons: {
			down: "ui-icon-triangle-1-s",
			up: "ui-icon-triangle-1-n"
		},
		incremental: true,
		max: null,
		min: null,
		numberFormat: null,
		page: 10,
		step: 1,

		change: null,
		spin: null,
		start: null,
		stop: null
	},

	_create: function() {
		// handle string values that need to be parsed
		this._setOption( "max", this.options.max );
		this._setOption( "min", this.options.min );
		this._setOption( "step", this.options.step );

		// Only format if there is a value, prevents the field from being marked
		// as invalid in Firefox, see #9573.
		if ( this.value() !== "" ) {
			// Format the value, but don't constrain.
			this._value( this.element.val(), true );
		}

		this._draw();
		this._on( this._events );
		this._refresh();

		// turning off autocomplete prevents the browser from remembering the
		// value when navigating through history, so we re-enable autocomplete
		// if the page is unloaded before the widget is destroyed. #7790
		this._on( this.window, {
			beforeunload: function() {
				this.element.removeAttr( "autocomplete" );
			}
		});
	},

	_getCreateOptions: function() {
		var options = {},
			element = this.element;

		$.each( [ "min", "max", "step" ], function( i, option ) {
			var value = element.attr( option );
			if ( value !== undefined && value.length ) {
				options[ option ] = value;
			}
		});

		return options;
	},

	_events: {
		keydown: function( event ) {
			if ( this._start( event ) && this._keydown( event ) ) {
				event.preventDefault();
			}
		},
		keyup: "_stop",
		focus: function() {
			this.previous = this.element.val();
		},
		blur: function( event ) {
			if ( this.cancelBlur ) {
				delete this.cancelBlur;
				return;
			}

			this._stop();
			this._refresh();
			if ( this.previous !== this.element.val() ) {
				this._trigger( "change", event );
			}
		},
		mousewheel: function( event, delta ) {
			if ( !delta ) {
				return;
			}
			if ( !this.spinning && !this._start( event ) ) {
				return false;
			}

			this._spin( (delta > 0 ? 1 : -1) * this.options.step, event );
			clearTimeout( this.mousewheelTimer );
			this.mousewheelTimer = this._delay(function() {
				if ( this.spinning ) {
					this._stop( event );
				}
			}, 100 );
			event.preventDefault();
		},
		"mousedown .ui-spinner-button": function( event ) {
			var previous;

			// We never want the buttons to have focus; whenever the user is
			// interacting with the spinner, the focus should be on the input.
			// If the input is focused then this.previous is properly set from
			// when the input first received focus. If the input is not focused
			// then we need to set this.previous based on the value before spinning.
			previous = this.element[0] === this.document[0].activeElement ?
				this.previous : this.element.val();
			function checkFocus() {
				var isActive = this.element[0] === this.document[0].activeElement;
				if ( !isActive ) {
					this.element.focus();
					this.previous = previous;
					// support: IE
					// IE sets focus asynchronously, so we need to check if focus
					// moved off of the input because the user clicked on the button.
					this._delay(function() {
						this.previous = previous;
					});
				}
			}

			// ensure focus is on (or stays on) the text field
			event.preventDefault();
			checkFocus.call( this );

			// support: IE
			// IE doesn't prevent moving focus even with event.preventDefault()
			// so we set a flag to know when we should ignore the blur event
			// and check (again) if focus moved off of the input.
			this.cancelBlur = true;
			this._delay(function() {
				delete this.cancelBlur;
				checkFocus.call( this );
			});

			if ( this._start( event ) === false ) {
				return;
			}

			this._repeat( null, $( event.currentTarget ).hasClass( "ui-spinner-up" ) ? 1 : -1, event );
		},
		"mouseup .ui-spinner-button": "_stop",
		"mouseenter .ui-spinner-button": function( event ) {
			// button will add ui-state-active if mouse was down while mouseleave and kept down
			if ( !$( event.currentTarget ).hasClass( "ui-state-active" ) ) {
				return;
			}

			if ( this._start( event ) === false ) {
				return false;
			}
			this._repeat( null, $( event.currentTarget ).hasClass( "ui-spinner-up" ) ? 1 : -1, event );
		},
		// TODO: do we really want to consider this a stop?
		// shouldn't we just stop the repeater and wait until mouseup before
		// we trigger the stop event?
		"mouseleave .ui-spinner-button": "_stop"
	},

	_draw: function() {
		var uiSpinner = this.uiSpinner = this.element
			.addClass( "ui-spinner-input" )
			.attr( "autocomplete", "off" )
			.wrap( this._uiSpinnerHtml() )
			.parent()
				// add buttons
				.append( this._buttonHtml() );

		this.element.attr( "role", "spinbutton" );

		// button bindings
		this.buttons = uiSpinner.find( ".ui-spinner-button" )
			.attr( "tabIndex", -1 )
			.button()
			.removeClass( "ui-corner-all" );

		// IE 6 doesn't understand height: 50% for the buttons
		// unless the wrapper has an explicit height
		if ( this.buttons.height() > Math.ceil( uiSpinner.height() * 0.5 ) &&
				uiSpinner.height() > 0 ) {
			uiSpinner.height( uiSpinner.height() );
		}

		// disable spinner if element was already disabled
		if ( this.options.disabled ) {
			this.disable();
		}
	},

	_keydown: function( event ) {
		var options = this.options,
			keyCode = $.ui.keyCode;

		switch ( event.keyCode ) {
		case keyCode.UP:
			this._repeat( null, 1, event );
			return true;
		case keyCode.DOWN:
			this._repeat( null, -1, event );
			return true;
		case keyCode.PAGE_UP:
			this._repeat( null, options.page, event );
			return true;
		case keyCode.PAGE_DOWN:
			this._repeat( null, -options.page, event );
			return true;
		}

		return false;
	},

	_uiSpinnerHtml: function() {
		return "<span class='ui-spinner ui-widget ui-widget-content ui-corner-all'></span>";
	},

	_buttonHtml: function() {
		return "" +
			"<a class='ui-spinner-button ui-spinner-up ui-corner-tr'>" +
				"<span class='ui-icon " + this.options.icons.up + "'>&#9650;</span>" +
			"</a>" +
			"<a class='ui-spinner-button ui-spinner-down ui-corner-br'>" +
				"<span class='ui-icon " + this.options.icons.down + "'>&#9660;</span>" +
			"</a>";
	},

	_start: function( event ) {
		if ( !this.spinning && this._trigger( "start", event ) === false ) {
			return false;
		}

		if ( !this.counter ) {
			this.counter = 1;
		}
		this.spinning = true;
		return true;
	},

	_repeat: function( i, steps, event ) {
		i = i || 500;

		clearTimeout( this.timer );
		this.timer = this._delay(function() {
			this._repeat( 40, steps, event );
		}, i );

		this._spin( steps * this.options.step, event );
	},

	_spin: function( step, event ) {
		var value = this.value() || 0;

		if ( !this.counter ) {
			this.counter = 1;
		}

		value = this._adjustValue( value + step * this._increment( this.counter ) );

		if ( !this.spinning || this._trigger( "spin", event, { value: value } ) !== false) {
			this._value( value );
			this.counter++;
		}
	},

	_increment: function( i ) {
		var incremental = this.options.incremental;

		if ( incremental ) {
			return $.isFunction( incremental ) ?
				incremental( i ) :
				Math.floor( i*i*i/50000 - i*i/500 + 17*i/200 + 1 );
		}

		return 1;
	},

	_precision: function() {
		var precision = this._precisionOf( this.options.step );
		if ( this.options.min !== null ) {
			precision = Math.max( precision, this._precisionOf( this.options.min ) );
		}
		return precision;
	},

	_precisionOf: function( num ) {
		var str = num.toString(),
			decimal = str.indexOf( "." );
		return decimal === -1 ? 0 : str.length - decimal - 1;
	},

	_adjustValue: function( value ) {
		var base, aboveMin,
			options = this.options;

		// make sure we're at a valid step
		// - find out where we are relative to the base (min or 0)
		base = options.min !== null ? options.min : 0;
		aboveMin = value - base;
		// - round to the nearest step
		aboveMin = Math.round(aboveMin / options.step) * options.step;
		// - rounding is based on 0, so adjust back to our base
		value = base + aboveMin;

		// fix precision from bad JS floating point math
		value = parseFloat( value.toFixed( this._precision() ) );

		// clamp the value
		if ( options.max !== null && value > options.max) {
			return options.max;
		}
		if ( options.min !== null && value < options.min ) {
			return options.min;
		}

		return value;
	},

	_stop: function( event ) {
		if ( !this.spinning ) {
			return;
		}

		clearTimeout( this.timer );
		clearTimeout( this.mousewheelTimer );
		this.counter = 0;
		this.spinning = false;
		this._trigger( "stop", event );
	},

	_setOption: function( key, value ) {
		if ( key === "culture" || key === "numberFormat" ) {
			var prevValue = this._parse( this.element.val() );
			this.options[ key ] = value;
			this.element.val( this._format( prevValue ) );
			return;
		}

		if ( key === "max" || key === "min" || key === "step" ) {
			if ( typeof value === "string" ) {
				value = this._parse( value );
			}
		}
		if ( key === "icons" ) {
			this.buttons.first().find( ".ui-icon" )
				.removeClass( this.options.icons.up )
				.addClass( value.up );
			this.buttons.last().find( ".ui-icon" )
				.removeClass( this.options.icons.down )
				.addClass( value.down );
		}

		this._super( key, value );

		if ( key === "disabled" ) {
			if ( value ) {
				this.element.prop( "disabled", true );
				this.buttons.button( "disable" );
			} else {
				this.element.prop( "disabled", false );
				this.buttons.button( "enable" );
			}
		}
	},

	_setOptions: modifier(function( options ) {
		this._super( options );
		this._value( this.element.val() );
	}),

	_parse: function( val ) {
		if ( typeof val === "string" && val !== "" ) {
			val = window.Globalize && this.options.numberFormat ?
				Globalize.parseFloat( val, 10, this.options.culture ) : +val;
		}
		return val === "" || isNaN( val ) ? null : val;
	},

	_format: function( value ) {
		if ( value === "" ) {
			return "";
		}
		return window.Globalize && this.options.numberFormat ?
			Globalize.format( value, this.options.numberFormat, this.options.culture ) :
			value;
	},

	_refresh: function() {
		this.element.attr({
			"aria-valuemin": this.options.min,
			"aria-valuemax": this.options.max,
			// TODO: what should we do with values that can't be parsed?
			"aria-valuenow": this._parse( this.element.val() )
		});
	},

	// update the value without triggering change
	_value: function( value, allowAny ) {
		var parsed;
		if ( value !== "" ) {
			parsed = this._parse( value );
			if ( parsed !== null ) {
				if ( !allowAny ) {
					parsed = this._adjustValue( parsed );
				}
				value = this._format( parsed );
			}
		}
		this.element.val( value );
		this._refresh();
	},

	_destroy: function() {
		this.element
			.removeClass( "ui-spinner-input" )
			.prop( "disabled", false )
			.removeAttr( "autocomplete" )
			.removeAttr( "role" )
			.removeAttr( "aria-valuemin" )
			.removeAttr( "aria-valuemax" )
			.removeAttr( "aria-valuenow" );
		this.uiSpinner.replaceWith( this.element );
	},

	stepUp: modifier(function( steps ) {
		this._stepUp( steps );
	}),
	_stepUp: function( steps ) {
		if ( this._start() ) {
			this._spin( (steps || 1) * this.options.step );
			this._stop();
		}
	},

	stepDown: modifier(function( steps ) {
		this._stepDown( steps );
	}),
	_stepDown: function( steps ) {
		if ( this._start() ) {
			this._spin( (steps || 1) * -this.options.step );
			this._stop();
		}
	},

	pageUp: modifier(function( pages ) {
		this._stepUp( (pages || 1) * this.options.page );
	}),

	pageDown: modifier(function( pages ) {
		this._stepDown( (pages || 1) * this.options.page );
	}),

	value: function( newVal ) {
		if ( !arguments.length ) {
			return this._parse( this.element.val() );
		}
		modifier( this._value ).call( this, newVal );
	},

	widget: function() {
		return this.uiSpinner;
	}
});

}( jQuery ) );

/*!
 * jQuery UI Touch Punch 0.2.3
 *
 * Copyright 2011–2014, Dave Furfero
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Depends:
 *  jquery.ui.widget.js
 *  jquery.ui.mouse.js
 */
(function ($) {

  // Detect touch support
  $.support.touch = 'ontouchend' in document;

  // Ignore browsers without touch support
  if (!$.support.touch) {
    return;
  }

  var mouseProto = $.ui.mouse.prototype,
      _mouseInit = mouseProto._mouseInit,
      _mouseDestroy = mouseProto._mouseDestroy,
      touchHandled;

  /**
   * Simulate a mouse event based on a corresponding touch event
   * @param {Object} event A touch event
   * @param {String} simulatedType The corresponding mouse event
   */
  function simulateMouseEvent (event, simulatedType) {

    // Ignore multi-touch events
    if (event.originalEvent.touches.length > 1) {
      return;
    }

    event.preventDefault();

    var touch = event.originalEvent.changedTouches[0],
        simulatedEvent = document.createEvent('MouseEvents');

    // Initialize the simulated mouse event using the touch event's coordinates
    simulatedEvent.initMouseEvent(
      simulatedType,    // type
      true,             // bubbles
      true,             // cancelable
      window,           // view
      1,                // detail
      touch.screenX,    // screenX
      touch.screenY,    // screenY
      touch.clientX,    // clientX
      touch.clientY,    // clientY
      false,            // ctrlKey
      false,            // altKey
      false,            // shiftKey
      false,            // metaKey
      0,                // button
      null              // relatedTarget
    );

    // Dispatch the simulated event to the target element
    event.target.dispatchEvent(simulatedEvent);
  }

  /**
   * Handle the jQuery UI widget's touchstart events
   * @param {Object} event The widget element's touchstart event
   */
  mouseProto._touchStart = function (event) {

    var self = this;

    // Ignore the event if another widget is already being handled
    if (touchHandled || !self._mouseCapture(event.originalEvent.changedTouches[0])) {
      return;
    }

    // Set the flag to prevent other widgets from inheriting the touch event
    touchHandled = true;

    // Track movement to determine if interaction was a click
    self._touchMoved = false;

    // Simulate the mouseover event
    simulateMouseEvent(event, 'mouseover');

    // Simulate the mousemove event
    simulateMouseEvent(event, 'mousemove');

    // Simulate the mousedown event
    simulateMouseEvent(event, 'mousedown');
  };

  /**
   * Handle the jQuery UI widget's touchmove events
   * @param {Object} event The document's touchmove event
   */
  mouseProto._touchMove = function (event) {

    // Ignore event if not handled
    if (!touchHandled) {
      return;
    }

    // Interaction was not a click
    this._touchMoved = true;

    // Simulate the mousemove event
    simulateMouseEvent(event, 'mousemove');
  };

  /**
   * Handle the jQuery UI widget's touchend events
   * @param {Object} event The document's touchend event
   */
  mouseProto._touchEnd = function (event) {

    // Ignore event if not handled
    if (!touchHandled) {
      return;
    }

    // Simulate the mouseup event
    simulateMouseEvent(event, 'mouseup');

    // Simulate the mouseout event
    simulateMouseEvent(event, 'mouseout');

    // If the touch interaction did not move, it should trigger a click
    if (!this._touchMoved) {

      // Simulate the click event
      simulateMouseEvent(event, 'click');
    }

    // Unset the flag to allow other widgets to inherit the touch event
    touchHandled = false;
  };

  /**
   * A duck punch of the $.ui.mouse _mouseInit method to support touch events.
   * This method extends the widget with bound touch event handlers that
   * translate touch events to mouse events and pass them to the widget's
   * original mouse event handling methods.
   */
  mouseProto._mouseInit = function () {

    var self = this;

    // Delegate the touch handlers to the widget's element
    self.element.bind({
      touchstart: $.proxy(self, '_touchStart'),
      touchmove: $.proxy(self, '_touchMove'),
      touchend: $.proxy(self, '_touchEnd')
    });

    // Call the original $.ui.mouse init method
    _mouseInit.call(self);
  };

  /**
   * Remove the touch event handlers
   */
  mouseProto._mouseDestroy = function () {

    var self = this;

    // Delegate the touch handlers to the widget's element
    self.element.unbind({
      touchstart: $.proxy(self, '_touchStart'),
      touchmove: $.proxy(self, '_touchMove'),
      touchend: $.proxy(self, '_touchEnd')
    });

    // Call the original $.ui.mouse destroy method
    _mouseDestroy.call(self);
  };

})(jQuery);
(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(iphone|ipad|ipod|android)/i.test(a)||/(iphone|ipad|ipod|android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);
/*! http://mths.be/placeholder v2.0.8 by @mathias */
;(function(window, document, $) {

	// Opera Mini v7 doesn’t support placeholder although its DOM seems to indicate so
	var isOperaMini = Object.prototype.toString.call(window.operamini) == '[object OperaMini]';
	var isInputSupported = 'placeholder' in document.createElement('input') && !isOperaMini;
	var isTextareaSupported = 'placeholder' in document.createElement('textarea') && !isOperaMini;
	var prototype = $.fn;
	var valHooks = $.valHooks;
	var propHooks = $.propHooks;
	var hooks;
	var placeholder;

	if (isInputSupported && isTextareaSupported) {

		placeholder = prototype.placeholder = function() {
			return this;
		};

		placeholder.input = placeholder.textarea = true;

	} else {

		placeholder = prototype.placeholder = function() {
			var $this = this;
			$this
				.filter((isInputSupported ? 'textarea' : ':input') + '[placeholder]')
				.not('.placeholder')
				.bind({
					'focus.placeholder': clearPlaceholder,
					'blur.placeholder': setPlaceholder
				})
				.data('placeholder-enabled', true)
				.trigger('blur.placeholder');
			return $this;
		};

		placeholder.input = isInputSupported;
		placeholder.textarea = isTextareaSupported;

		hooks = {
			'get': function(element) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value;
				}

				return $element.data('placeholder-enabled') && $element.hasClass('placeholder') ? '' : element.value;
			},
			'set': function(element, value) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value = value;
				}

				if (!$element.data('placeholder-enabled')) {
					return element.value = value;
				}
				if (value == '') {
					element.value = value;
					// Issue #56: Setting the placeholder causes problems if the element continues to have focus.
					if (element != safeActiveElement()) {
						// We can't use `triggerHandler` here because of dummy text/password inputs :(
						setPlaceholder.call(element);
					}
				} else if ($element.hasClass('placeholder')) {
					clearPlaceholder.call(element, true, value) || (element.value = value);
				} else {
					element.value = value;
				}
				// `set` can not return `undefined`; see http://jsapi.info/jquery/1.7.1/val#L2363
				return $element;
			}
		};

		if (!isInputSupported) {
			valHooks.input = hooks;
			propHooks.value = hooks;
		}
		if (!isTextareaSupported) {
			valHooks.textarea = hooks;
			propHooks.value = hooks;
		}

		$(function() {
			// Look for forms
			$(document).delegate('form', 'submit.placeholder', function() {
				// Clear the placeholder values so they don't get submitted
				var $inputs = $('.placeholder', this).each(clearPlaceholder);
				setTimeout(function() {
					$inputs.each(setPlaceholder);
				}, 10);
			});
		});

		// Clear placeholder values upon page reload
		$(window).bind('beforeunload.placeholder', function() {
			$('.placeholder').each(function() {
				this.value = '';
			});
		});

	}

	function args(elem) {
		// Return an object of element attributes
		var newAttrs = {};
		var rinlinejQuery = /^jQuery\d+$/;
		$.each(elem.attributes, function(i, attr) {
			if (attr.specified && !rinlinejQuery.test(attr.name)) {
				newAttrs[attr.name] = attr.value;
			}
		});
		return newAttrs;
	}

	function clearPlaceholder(event, value) {
		var input = this;
		var $input = $(input);
		if (input.value == $input.attr('placeholder') && $input.hasClass('placeholder')) {
			if ($input.data('placeholder-password')) {
				$input = $input.hide().next().show().attr('id', $input.removeAttr('id').data('placeholder-id'));
				// If `clearPlaceholder` was called from `$.valHooks.input.set`
				if (event === true) {
					return $input[0].value = value;
				}
				$input.focus();
			} else {
				input.value = '';
				$input.removeClass('placeholder');
				input == safeActiveElement() && input.select();
			}
		}
	}

	function setPlaceholder() {
		var $replacement;
		var input = this;
		var $input = $(input);
		var id = this.id;
		if (input.value == '') {
			if (input.type == 'password') {
				if (!$input.data('placeholder-textinput')) {
					try {
						$replacement = $input.clone().attr({ 'type': 'text' });
					} catch(e) {
						$replacement = $('<input>').attr($.extend(args(this), { 'type': 'text' }));
					}
					$replacement
						.removeAttr('name')
						.data({
							'placeholder-password': $input,
							'placeholder-id': id
						})
						.bind('focus.placeholder', clearPlaceholder);
					$input
						.data({
							'placeholder-textinput': $replacement,
							'placeholder-id': id
						})
						.before($replacement);
				}
				$input = $input.removeAttr('id').hide().prev().attr('id', id).show();
				// Note: `$input[0] != input` now!
			}
			$input.addClass('placeholder');
			$input[0].value = $input.attr('placeholder');
		} else {
			$input.removeClass('placeholder');
		}
	}

	function safeActiveElement() {
		// Avoid IE9 `document.activeElement` of death
		// https://github.com/mathiasbynens/jquery-placeholder/pull/99
		try {
			return document.activeElement;
		} catch (exception) {}
	}

}(this, document, jQuery));
/*
 * jQuery FlexSlider v2.5.0
 * Copyright 2012 WooThemes
 * Contributing Author: Tyler Smith
 */!function($){$.flexslider=function(e,t){var a=$(e);a.vars=$.extend({},$.flexslider.defaults,t);var n=a.vars.namespace,i=window.navigator&&window.navigator.msPointerEnabled&&window.MSGesture,s=("ontouchstart"in window||i||window.DocumentTouch&&document instanceof DocumentTouch)&&a.vars.touch,r="click touchend MSPointerUp keyup",o="",l,c="vertical"===a.vars.direction,d=a.vars.reverse,u=a.vars.itemWidth>0,v="fade"===a.vars.animation,p=""!==a.vars.asNavFor,m={},f=!0;$.data(e,"flexslider",a),m={init:function(){a.animating=!1,a.currentSlide=parseInt(a.vars.startAt?a.vars.startAt:0,10),isNaN(a.currentSlide)&&(a.currentSlide=0),a.animatingTo=a.currentSlide,a.atEnd=0===a.currentSlide||a.currentSlide===a.last,a.containerSelector=a.vars.selector.substr(0,a.vars.selector.search(" ")),a.slides=$(a.vars.selector,a),a.container=$(a.containerSelector,a),a.count=a.slides.length,a.syncExists=$(a.vars.sync).length>0,"slide"===a.vars.animation&&(a.vars.animation="swing"),a.prop=c?"top":"marginLeft",a.args={},a.manualPause=!1,a.stopped=!1,a.started=!1,a.startTimeout=null,a.transitions=!a.vars.video&&!v&&a.vars.useCSS&&function(){var e=document.createElement("div"),t=["perspectiveProperty","WebkitPerspective","MozPerspective","OPerspective","msPerspective"];for(var n in t)if(void 0!==e.style[t[n]])return a.pfx=t[n].replace("Perspective","").toLowerCase(),a.prop="-"+a.pfx+"-transform",!0;return!1}(),a.ensureAnimationEnd="",""!==a.vars.controlsContainer&&(a.controlsContainer=$(a.vars.controlsContainer).length>0&&$(a.vars.controlsContainer)),""!==a.vars.manualControls&&(a.manualControls=$(a.vars.manualControls).length>0&&$(a.vars.manualControls)),""!==a.vars.customDirectionNav&&(a.customDirectionNav=2===$(a.vars.customDirectionNav).length&&$(a.vars.customDirectionNav)),a.vars.randomize&&(a.slides.sort(function(){return Math.round(Math.random())-.5}),a.container.empty().append(a.slides)),a.doMath(),a.setup("init"),a.vars.controlNav&&m.controlNav.setup(),a.vars.directionNav&&m.directionNav.setup(),a.vars.keyboard&&(1===$(a.containerSelector).length||a.vars.multipleKeyboard)&&$(document).bind("keyup",function(e){var t=e.keyCode;if(!a.animating&&(39===t||37===t)){var n=39===t?a.getTarget("next"):37===t?a.getTarget("prev"):!1;a.flexAnimate(n,a.vars.pauseOnAction)}}),a.vars.mousewheel&&a.bind("mousewheel",function(e,t,n,i){e.preventDefault();var s=a.getTarget(0>t?"next":"prev");a.flexAnimate(s,a.vars.pauseOnAction)}),a.vars.pausePlay&&m.pausePlay.setup(),a.vars.slideshow&&a.vars.pauseInvisible&&m.pauseInvisible.init(),a.vars.slideshow&&(a.vars.pauseOnHover&&a.hover(function(){a.manualPlay||a.manualPause||a.pause()},function(){a.manualPause||a.manualPlay||a.stopped||a.play()}),a.vars.pauseInvisible&&m.pauseInvisible.isHidden()||(a.vars.initDelay>0?a.startTimeout=setTimeout(a.play,a.vars.initDelay):a.play())),p&&m.asNav.setup(),s&&a.vars.touch&&m.touch(),(!v||v&&a.vars.smoothHeight)&&$(window).bind("resize orientationchange focus",m.resize),a.find("img").attr("draggable","false"),setTimeout(function(){a.vars.start(a)},200)},asNav:{setup:function(){a.asNav=!0,a.animatingTo=Math.floor(a.currentSlide/a.move),a.currentItem=a.currentSlide,a.slides.removeClass(n+"active-slide").eq(a.currentItem).addClass(n+"active-slide"),i?(e._slider=a,a.slides.each(function(){var e=this;e._gesture=new MSGesture,e._gesture.target=e,e.addEventListener("MSPointerDown",function(e){e.preventDefault(),e.currentTarget._gesture&&e.currentTarget._gesture.addPointer(e.pointerId)},!1),e.addEventListener("MSGestureTap",function(e){e.preventDefault();var t=$(this),n=t.index();$(a.vars.asNavFor).data("flexslider").animating||t.hasClass("active")||(a.direction=a.currentItem<n?"next":"prev",a.flexAnimate(n,a.vars.pauseOnAction,!1,!0,!0))})})):a.slides.on(r,function(e){e.preventDefault();var t=$(this),i=t.index(),s=t.offset().left-$(a).scrollLeft();0>=s&&t.hasClass(n+"active-slide")?a.flexAnimate(a.getTarget("prev"),!0):$(a.vars.asNavFor).data("flexslider").animating||t.hasClass(n+"active-slide")||(a.direction=a.currentItem<i?"next":"prev",a.flexAnimate(i,a.vars.pauseOnAction,!1,!0,!0))})}},controlNav:{setup:function(){a.manualControls?m.controlNav.setupManual():m.controlNav.setupPaging()},setupPaging:function(){var e="thumbnails"===a.vars.controlNav?"control-thumbs":"control-paging",t=1,i,s;if(a.controlNavScaffold=$('<ol class="'+n+"control-nav "+n+e+'"></ol>'),a.pagingCount>1)for(var l=0;l<a.pagingCount;l++){if(s=a.slides.eq(l),i="thumbnails"===a.vars.controlNav?'<img src="'+s.attr("data-thumb")+'"/>':"<a>"+t+"</a>","thumbnails"===a.vars.controlNav&&!0===a.vars.thumbCaptions){var c=s.attr("data-thumbcaption");""!==c&&void 0!==c&&(i+='<span class="'+n+'caption">'+c+"</span>")}a.controlNavScaffold.append("<li>"+i+"</li>"),t++}a.controlsContainer?$(a.controlsContainer).append(a.controlNavScaffold):a.append(a.controlNavScaffold),m.controlNav.set(),m.controlNav.active(),a.controlNavScaffold.delegate("a, img",r,function(e){if(e.preventDefault(),""===o||o===e.type){var t=$(this),i=a.controlNav.index(t);t.hasClass(n+"active")||(a.direction=i>a.currentSlide?"next":"prev",a.flexAnimate(i,a.vars.pauseOnAction))}""===o&&(o=e.type),m.setToClearWatchedEvent()})},setupManual:function(){a.controlNav=a.manualControls,m.controlNav.active(),a.controlNav.bind(r,function(e){if(e.preventDefault(),""===o||o===e.type){var t=$(this),i=a.controlNav.index(t);t.hasClass(n+"active")||(a.direction=i>a.currentSlide?"next":"prev",a.flexAnimate(i,a.vars.pauseOnAction))}""===o&&(o=e.type),m.setToClearWatchedEvent()})},set:function(){var e="thumbnails"===a.vars.controlNav?"img":"a";a.controlNav=$("."+n+"control-nav li "+e,a.controlsContainer?a.controlsContainer:a)},active:function(){a.controlNav.removeClass(n+"active").eq(a.animatingTo).addClass(n+"active")},update:function(e,t){a.pagingCount>1&&"add"===e?a.controlNavScaffold.append($("<li><a>"+a.count+"</a></li>")):1===a.pagingCount?a.controlNavScaffold.find("li").remove():a.controlNav.eq(t).closest("li").remove(),m.controlNav.set(),a.pagingCount>1&&a.pagingCount!==a.controlNav.length?a.update(t,e):m.controlNav.active()}},directionNav:{setup:function(){var e=$('<ul class="'+n+'direction-nav"><li class="'+n+'nav-prev"><a class="'+n+'prev" href="#">'+a.vars.prevText+'</a></li><li class="'+n+'nav-next"><a class="'+n+'next" href="#">'+a.vars.nextText+"</a></li></ul>");a.customDirectionNav?a.directionNav=a.customDirectionNav:a.controlsContainer?($(a.controlsContainer).append(e),a.directionNav=$("."+n+"direction-nav li a",a.controlsContainer)):(a.append(e),a.directionNav=$("."+n+"direction-nav li a",a)),m.directionNav.update(),a.directionNav.bind(r,function(e){e.preventDefault();var t;(""===o||o===e.type)&&(t=a.getTarget($(this).hasClass(n+"next")?"next":"prev"),a.flexAnimate(t,a.vars.pauseOnAction)),""===o&&(o=e.type),m.setToClearWatchedEvent()})},update:function(){var e=n+"disabled";1===a.pagingCount?a.directionNav.addClass(e).attr("tabindex","-1"):a.vars.animationLoop?a.directionNav.removeClass(e).removeAttr("tabindex"):0===a.animatingTo?a.directionNav.removeClass(e).filter("."+n+"prev").addClass(e).attr("tabindex","-1"):a.animatingTo===a.last?a.directionNav.removeClass(e).filter("."+n+"next").addClass(e).attr("tabindex","-1"):a.directionNav.removeClass(e).removeAttr("tabindex")}},pausePlay:{setup:function(){var e=$('<div class="'+n+'pauseplay"><a></a></div>');a.controlsContainer?(a.controlsContainer.append(e),a.pausePlay=$("."+n+"pauseplay a",a.controlsContainer)):(a.append(e),a.pausePlay=$("."+n+"pauseplay a",a)),m.pausePlay.update(a.vars.slideshow?n+"pause":n+"play"),a.pausePlay.bind(r,function(e){e.preventDefault(),(""===o||o===e.type)&&($(this).hasClass(n+"pause")?(a.manualPause=!0,a.manualPlay=!1,a.pause()):(a.manualPause=!1,a.manualPlay=!0,a.play())),""===o&&(o=e.type),m.setToClearWatchedEvent()})},update:function(e){"play"===e?a.pausePlay.removeClass(n+"pause").addClass(n+"play").html(a.vars.playText):a.pausePlay.removeClass(n+"play").addClass(n+"pause").html(a.vars.pauseText)}},touch:function(){function t(t){t.stopPropagation(),a.animating?t.preventDefault():(a.pause(),e._gesture.addPointer(t.pointerId),w=0,p=c?a.h:a.w,f=Number(new Date),l=u&&d&&a.animatingTo===a.last?0:u&&d?a.limit-(a.itemW+a.vars.itemMargin)*a.move*a.animatingTo:u&&a.currentSlide===a.last?a.limit:u?(a.itemW+a.vars.itemMargin)*a.move*a.currentSlide:d?(a.last-a.currentSlide+a.cloneOffset)*p:(a.currentSlide+a.cloneOffset)*p)}function n(t){t.stopPropagation();var a=t.target._slider;if(a){var n=-t.translationX,i=-t.translationY;return w+=c?i:n,m=w,y=c?Math.abs(w)<Math.abs(-n):Math.abs(w)<Math.abs(-i),t.detail===t.MSGESTURE_FLAG_INERTIA?void setImmediate(function(){e._gesture.stop()}):void((!y||Number(new Date)-f>500)&&(t.preventDefault(),!v&&a.transitions&&(a.vars.animationLoop||(m=w/(0===a.currentSlide&&0>w||a.currentSlide===a.last&&w>0?Math.abs(w)/p+2:1)),a.setProps(l+m,"setTouch"))))}}function s(e){e.stopPropagation();var t=e.target._slider;if(t){if(t.animatingTo===t.currentSlide&&!y&&null!==m){var a=d?-m:m,n=t.getTarget(a>0?"next":"prev");t.canAdvance(n)&&(Number(new Date)-f<550&&Math.abs(a)>50||Math.abs(a)>p/2)?t.flexAnimate(n,t.vars.pauseOnAction):v||t.flexAnimate(t.currentSlide,t.vars.pauseOnAction,!0)}r=null,o=null,m=null,l=null,w=0}}var r,o,l,p,m,f,g,h,S,y=!1,x=0,b=0,w=0;i?(e.style.msTouchAction="none",e._gesture=new MSGesture,e._gesture.target=e,e.addEventListener("MSPointerDown",t,!1),e._slider=a,e.addEventListener("MSGestureChange",n,!1),e.addEventListener("MSGestureEnd",s,!1)):(g=function(t){a.animating?t.preventDefault():(window.navigator.msPointerEnabled||1===t.touches.length)&&(a.pause(),p=c?a.h:a.w,f=Number(new Date),x=t.touches[0].pageX,b=t.touches[0].pageY,l=u&&d&&a.animatingTo===a.last?0:u&&d?a.limit-(a.itemW+a.vars.itemMargin)*a.move*a.animatingTo:u&&a.currentSlide===a.last?a.limit:u?(a.itemW+a.vars.itemMargin)*a.move*a.currentSlide:d?(a.last-a.currentSlide+a.cloneOffset)*p:(a.currentSlide+a.cloneOffset)*p,r=c?b:x,o=c?x:b,e.addEventListener("touchmove",h,!1),e.addEventListener("touchend",S,!1))},h=function(e){x=e.touches[0].pageX,b=e.touches[0].pageY,m=c?r-b:r-x,y=c?Math.abs(m)<Math.abs(x-o):Math.abs(m)<Math.abs(b-o);var t=500;(!y||Number(new Date)-f>t)&&(e.preventDefault(),!v&&a.transitions&&(a.vars.animationLoop||(m/=0===a.currentSlide&&0>m||a.currentSlide===a.last&&m>0?Math.abs(m)/p+2:1),a.setProps(l+m,"setTouch")))},S=function(t){if(e.removeEventListener("touchmove",h,!1),a.animatingTo===a.currentSlide&&!y&&null!==m){var n=d?-m:m,i=a.getTarget(n>0?"next":"prev");a.canAdvance(i)&&(Number(new Date)-f<550&&Math.abs(n)>50||Math.abs(n)>p/2)?a.flexAnimate(i,a.vars.pauseOnAction):v||a.flexAnimate(a.currentSlide,a.vars.pauseOnAction,!0)}e.removeEventListener("touchend",S,!1),r=null,o=null,m=null,l=null},e.addEventListener("touchstart",g,!1))},resize:function(){!a.animating&&a.is(":visible")&&(u||a.doMath(),v?m.smoothHeight():u?(a.slides.width(a.computedW),a.update(a.pagingCount),a.setProps()):c?(a.viewport.height(a.h),a.setProps(a.h,"setTotal")):(a.vars.smoothHeight&&m.smoothHeight(),a.newSlides.width(a.computedW),a.setProps(a.computedW,"setTotal")))},smoothHeight:function(e){if(!c||v){var t=v?a:a.viewport;e?t.animate({height:a.slides.eq(a.animatingTo).height()},e):t.height(a.slides.eq(a.animatingTo).height())}},sync:function(e){var t=$(a.vars.sync).data("flexslider"),n=a.animatingTo;switch(e){case"animate":t.flexAnimate(n,a.vars.pauseOnAction,!1,!0);break;case"play":t.playing||t.asNav||t.play();break;case"pause":t.pause()}},uniqueID:function(e){return e.filter("[id]").add(e.find("[id]")).each(function(){var e=$(this);e.attr("id",e.attr("id")+"_clone")}),e},pauseInvisible:{visProp:null,init:function(){var e=m.pauseInvisible.getHiddenProp();if(e){var t=e.replace(/[H|h]idden/,"")+"visibilitychange";document.addEventListener(t,function(){m.pauseInvisible.isHidden()?a.startTimeout?clearTimeout(a.startTimeout):a.pause():a.started?a.play():a.vars.initDelay>0?setTimeout(a.play,a.vars.initDelay):a.play()})}},isHidden:function(){var e=m.pauseInvisible.getHiddenProp();return e?document[e]:!1},getHiddenProp:function(){var e=["webkit","moz","ms","o"];if("hidden"in document)return"hidden";for(var t=0;t<e.length;t++)if(e[t]+"Hidden"in document)return e[t]+"Hidden";return null}},setToClearWatchedEvent:function(){clearTimeout(l),l=setTimeout(function(){o=""},3e3)}},a.flexAnimate=function(e,t,i,r,o){if(a.vars.animationLoop||e===a.currentSlide||(a.direction=e>a.currentSlide?"next":"prev"),p&&1===a.pagingCount&&(a.direction=a.currentItem<e?"next":"prev"),!a.animating&&(a.canAdvance(e,o)||i)&&a.is(":visible")){if(p&&r){var l=$(a.vars.asNavFor).data("flexslider");if(a.atEnd=0===e||e===a.count-1,l.flexAnimate(e,!0,!1,!0,o),a.direction=a.currentItem<e?"next":"prev",l.direction=a.direction,Math.ceil((e+1)/a.visible)-1===a.currentSlide||0===e)return a.currentItem=e,a.slides.removeClass(n+"active-slide").eq(e).addClass(n+"active-slide"),!1;a.currentItem=e,a.slides.removeClass(n+"active-slide").eq(e).addClass(n+"active-slide"),e=Math.floor(e/a.visible)}if(a.animating=!0,a.animatingTo=e,t&&a.pause(),a.vars.before(a),a.syncExists&&!o&&m.sync("animate"),a.vars.controlNav&&m.controlNav.active(),u||a.slides.removeClass(n+"active-slide").eq(e).addClass(n+"active-slide"),a.atEnd=0===e||e===a.last,a.vars.directionNav&&m.directionNav.update(),e===a.last&&(a.vars.end(a),a.vars.animationLoop||a.pause()),v)s?(a.slides.eq(a.currentSlide).css({opacity:0,zIndex:1}),a.slides.eq(e).css({opacity:1,zIndex:2}),a.wrapup(f)):(a.slides.eq(a.currentSlide).css({zIndex:1}).animate({opacity:0},a.vars.animationSpeed,a.vars.easing),a.slides.eq(e).css({zIndex:2}).animate({opacity:1},a.vars.animationSpeed,a.vars.easing,a.wrapup));else{var f=c?a.slides.filter(":first").height():a.computedW,g,h,S;u?(g=a.vars.itemMargin,S=(a.itemW+g)*a.move*a.animatingTo,h=S>a.limit&&1!==a.visible?a.limit:S):h=0===a.currentSlide&&e===a.count-1&&a.vars.animationLoop&&"next"!==a.direction?d?(a.count+a.cloneOffset)*f:0:a.currentSlide===a.last&&0===e&&a.vars.animationLoop&&"prev"!==a.direction?d?0:(a.count+1)*f:d?(a.count-1-e+a.cloneOffset)*f:(e+a.cloneOffset)*f,a.setProps(h,"",a.vars.animationSpeed),a.transitions?(a.vars.animationLoop&&a.atEnd||(a.animating=!1,a.currentSlide=a.animatingTo),a.container.unbind("webkitTransitionEnd transitionend"),a.container.bind("webkitTransitionEnd transitionend",function(){clearTimeout(a.ensureAnimationEnd),a.wrapup(f)}),clearTimeout(a.ensureAnimationEnd),a.ensureAnimationEnd=setTimeout(function(){a.wrapup(f)},a.vars.animationSpeed+100)):a.container.animate(a.args,a.vars.animationSpeed,a.vars.easing,function(){a.wrapup(f)})}a.vars.smoothHeight&&m.smoothHeight(a.vars.animationSpeed)}},a.wrapup=function(e){v||u||(0===a.currentSlide&&a.animatingTo===a.last&&a.vars.animationLoop?a.setProps(e,"jumpEnd"):a.currentSlide===a.last&&0===a.animatingTo&&a.vars.animationLoop&&a.setProps(e,"jumpStart")),a.animating=!1,a.currentSlide=a.animatingTo,a.vars.after(a)},a.animateSlides=function(){!a.animating&&f&&a.flexAnimate(a.getTarget("next"))},a.pause=function(){clearInterval(a.animatedSlides),a.animatedSlides=null,a.playing=!1,a.vars.pausePlay&&m.pausePlay.update("play"),a.syncExists&&m.sync("pause")},a.play=function(){a.playing&&clearInterval(a.animatedSlides),a.animatedSlides=a.animatedSlides||setInterval(a.animateSlides,a.vars.slideshowSpeed),a.started=a.playing=!0,a.vars.pausePlay&&m.pausePlay.update("pause"),a.syncExists&&m.sync("play")},a.stop=function(){a.pause(),a.stopped=!0},a.canAdvance=function(e,t){var n=p?a.pagingCount-1:a.last;return t?!0:p&&a.currentItem===a.count-1&&0===e&&"prev"===a.direction?!0:p&&0===a.currentItem&&e===a.pagingCount-1&&"next"!==a.direction?!1:e!==a.currentSlide||p?a.vars.animationLoop?!0:a.atEnd&&0===a.currentSlide&&e===n&&"next"!==a.direction?!1:a.atEnd&&a.currentSlide===n&&0===e&&"next"===a.direction?!1:!0:!1},a.getTarget=function(e){return a.direction=e,"next"===e?a.currentSlide===a.last?0:a.currentSlide+1:0===a.currentSlide?a.last:a.currentSlide-1},a.setProps=function(e,t,n){var i=function(){var n=e?e:(a.itemW+a.vars.itemMargin)*a.move*a.animatingTo,i=function(){if(u)return"setTouch"===t?e:d&&a.animatingTo===a.last?0:d?a.limit-(a.itemW+a.vars.itemMargin)*a.move*a.animatingTo:a.animatingTo===a.last?a.limit:n;switch(t){case"setTotal":return d?(a.count-1-a.currentSlide+a.cloneOffset)*e:(a.currentSlide+a.cloneOffset)*e;case"setTouch":return d?e:e;case"jumpEnd":return d?e:a.count*e;case"jumpStart":return d?a.count*e:e;default:return e}}();return-1*i+"px"}();a.transitions&&(i=c?"translate3d(0,"+i+",0)":"translate3d("+i+",0,0)",n=void 0!==n?n/1e3+"s":"0s",a.container.css("-"+a.pfx+"-transition-duration",n),a.container.css("transition-duration",n)),a.args[a.prop]=i,(a.transitions||void 0===n)&&a.container.css(a.args),a.container.css("transform",i)},a.setup=function(e){if(v)a.slides.css({width:"100%","float":"left",marginRight:"-100%",position:"relative"}),"init"===e&&(s?a.slides.css({opacity:0,display:"block",webkitTransition:"opacity "+a.vars.animationSpeed/1e3+"s ease",zIndex:1}).eq(a.currentSlide).css({opacity:1,zIndex:2}):0==a.vars.fadeFirstSlide?a.slides.css({opacity:0,display:"block",zIndex:1}).eq(a.currentSlide).css({zIndex:2}).css({opacity:1}):a.slides.css({opacity:0,display:"block",zIndex:1}).eq(a.currentSlide).css({zIndex:2}).animate({opacity:1},a.vars.animationSpeed,a.vars.easing)),a.vars.smoothHeight&&m.smoothHeight();else{var t,i;"init"===e&&(a.viewport=$('<div class="'+n+'viewport"></div>').css({overflow:"hidden",position:"relative"}).appendTo(a).append(a.container),a.cloneCount=0,a.cloneOffset=0,d&&(i=$.makeArray(a.slides).reverse(),a.slides=$(i),a.container.empty().append(a.slides))),a.vars.animationLoop&&!u&&(a.cloneCount=2,a.cloneOffset=1,"init"!==e&&a.container.find(".clone").remove(),a.container.append(m.uniqueID(a.slides.first().clone().addClass("clone")).attr("aria-hidden","true")).prepend(m.uniqueID(a.slides.last().clone().addClass("clone")).attr("aria-hidden","true"))),a.newSlides=$(a.vars.selector,a),t=d?a.count-1-a.currentSlide+a.cloneOffset:a.currentSlide+a.cloneOffset,c&&!u?(a.container.height(200*(a.count+a.cloneCount)+"%").css("position","absolute").width("100%"),setTimeout(function(){a.newSlides.css({display:"block"}),a.doMath(),a.viewport.height(a.h),a.setProps(t*a.h,"init")},"init"===e?100:0)):(a.container.width(200*(a.count+a.cloneCount)+"%"),a.setProps(t*a.computedW,"init"),setTimeout(function(){a.doMath(),a.newSlides.css({width:a.computedW,"float":"left",display:"block"}),a.vars.smoothHeight&&m.smoothHeight()},"init"===e?100:0))}u||a.slides.removeClass(n+"active-slide").eq(a.currentSlide).addClass(n+"active-slide"),a.vars.init(a)},a.doMath=function(){var e=a.slides.first(),t=a.vars.itemMargin,n=a.vars.minItems,i=a.vars.maxItems;a.w=void 0===a.viewport?a.width():a.viewport.width(),a.h=e.height(),a.boxPadding=e.outerWidth()-e.width(),u?(a.itemT=a.vars.itemWidth+t,a.minW=n?n*a.itemT:a.w,a.maxW=i?i*a.itemT-t:a.w,a.itemW=a.minW>a.w?(a.w-t*(n-1))/n:a.maxW<a.w?(a.w-t*(i-1))/i:a.vars.itemWidth>a.w?a.w:a.vars.itemWidth,a.visible=Math.floor(a.w/a.itemW),a.move=a.vars.move>0&&a.vars.move<a.visible?a.vars.move:a.visible,a.pagingCount=Math.ceil((a.count-a.visible)/a.move+1),a.last=a.pagingCount-1,a.limit=1===a.pagingCount?0:a.vars.itemWidth>a.w?a.itemW*(a.count-1)+t*(a.count-1):(a.itemW+t)*a.count-a.w-t):(a.itemW=a.w,a.pagingCount=a.count,a.last=a.count-1),a.computedW=a.itemW-a.boxPadding},a.update=function(e,t){a.doMath(),u||(e<a.currentSlide?a.currentSlide+=1:e<=a.currentSlide&&0!==e&&(a.currentSlide-=1),a.animatingTo=a.currentSlide),a.vars.controlNav&&!a.manualControls&&("add"===t&&!u||a.pagingCount>a.controlNav.length?m.controlNav.update("add"):("remove"===t&&!u||a.pagingCount<a.controlNav.length)&&(u&&a.currentSlide>a.last&&(a.currentSlide-=1,a.animatingTo-=1),m.controlNav.update("remove",a.last))),a.vars.directionNav&&m.directionNav.update()},a.addSlide=function(e,t){var n=$(e);a.count+=1,a.last=a.count-1,c&&d?void 0!==t?a.slides.eq(a.count-t).after(n):a.container.prepend(n):void 0!==t?a.slides.eq(t).before(n):a.container.append(n),a.update(t,"add"),a.slides=$(a.vars.selector+":not(.clone)",a),a.setup(),a.vars.added(a)},a.removeSlide=function(e){var t=isNaN(e)?a.slides.index($(e)):e;a.count-=1,a.last=a.count-1,isNaN(e)?$(e,a.slides).remove():c&&d?a.slides.eq(a.last).remove():a.slides.eq(e).remove(),a.doMath(),a.update(t,"remove"),a.slides=$(a.vars.selector+":not(.clone)",a),a.setup(),a.vars.removed(a)},m.init()},$(window).blur(function(e){focused=!1}).focus(function(e){focused=!0}),$.flexslider.defaults={namespace:"flex-",selector:".slides > li",animation:"fade",easing:"swing",direction:"horizontal",reverse:!1,animationLoop:!0,smoothHeight:!1,startAt:0,slideshow:!0,slideshowSpeed:7e3,animationSpeed:600,initDelay:0,randomize:!1,fadeFirstSlide:!0,thumbCaptions:!1,pauseOnAction:!0,pauseOnHover:!1,pauseInvisible:!0,useCSS:!0,touch:!0,video:!1,controlNav:!0,directionNav:!0,prevText:"Previous",nextText:"Next",keyboard:!0,multipleKeyboard:!1,mousewheel:!1,pausePlay:!1,pauseText:"Pause",playText:"Play",controlsContainer:"",manualControls:"",customDirectionNav:"",sync:"",asNavFor:"",itemWidth:0,itemMargin:0,minItems:1,maxItems:0,move:0,allowOneSlide:!0,start:function(){},before:function(){},after:function(){},end:function(){},added:function(){},removed:function(){},init:function(){}},$.fn.flexslider=function(e){if(void 0===e&&(e={}),"object"==typeof e)return this.each(function(){var t=$(this),a=e.selector?e.selector:".slides > li",n=t.find(a);1===n.length&&e.allowOneSlide===!0||0===n.length?(n.fadeIn(400),e.start&&e.start(t)):void 0===t.data("flexslider")&&new $.flexslider(this,e)});var t=$(this).data("flexslider");switch(e){case"play":t.play();break;case"pause":t.pause();break;case"stop":t.stop();break;case"next":t.flexAnimate(t.getTarget("next"),!0);break;case"prev":case"previous":t.flexAnimate(t.getTarget("prev"),!0);break;default:"number"==typeof e&&t.flexAnimate(e,!0)}}}(jQuery);
/*! nanoScrollerJS - v0.8.0 - 2014
* http://jamesflorentino.github.com/nanoScrollerJS/
* Copyright (c) 2014 James Florentino; Licensed MIT */
(function($, window, document) {
  "use strict";
  var BROWSER_IS_IE7, BROWSER_SCROLLBAR_WIDTH, DOMSCROLL, DOWN, DRAG, KEYDOWN, KEYUP, MOUSEDOWN, MOUSEMOVE, MOUSEUP, MOUSEWHEEL, NanoScroll, PANEDOWN, RESIZE, SCROLL, SCROLLBAR, TOUCHMOVE, UP, WHEEL, cAF, defaults, getBrowserScrollbarWidth, hasTransform, isFFWithBuggyScrollbar, rAF, transform, _elementStyle, _prefixStyle, _vendor;
  defaults = {

    /**
      a classname for the pane element.
      @property paneClass
      @type String
      @default 'nano-pane'
     */
    paneClass: 'nano-pane',

    /**
      a classname for the slider element.
      @property sliderClass
      @type String
      @default 'nano-slider'
     */
    sliderClass: 'nano-slider',

    /**
      a classname for the content element.
      @property contentClass
      @type String
      @default 'nano-content'
     */
    contentClass: 'nano-content',

    /**
      a setting to enable native scrolling in iOS devices.
      @property iOSNativeScrolling
      @type Boolean
      @default false
     */
    iOSNativeScrolling: false,

    /**
      a setting to prevent the rest of the page being
      scrolled when user scrolls the `.content` element.
      @property preventPageScrolling
      @type Boolean
      @default false
     */
    preventPageScrolling: false,

    /**
      a setting to disable binding to the resize event.
      @property disableResize
      @type Boolean
      @default false
     */
    disableResize: false,

    /**
      a setting to make the scrollbar always visible.
      @property alwaysVisible
      @type Boolean
      @default false
     */
    alwaysVisible: false,

    /**
      a default timeout for the `flash()` method.
      @property flashDelay
      @type Number
      @default 1500
     */
    flashDelay: 1500,

    /**
      a minimum height for the `.slider` element.
      @property sliderMinHeight
      @type Number
      @default 20
     */
    sliderMinHeight: 20,

    /**
      a maximum height for the `.slider` element.
      @property sliderMaxHeight
      @type Number
      @default null
     */
    sliderMaxHeight: null,

    /**
      an alternate document context.
      @property documentContext
      @type Document
      @default null
     */
    documentContext: null,

    /**
      an alternate window context.
      @property windowContext
      @type Window
      @default null
     */
    windowContext: null
  };

  /**
    @property SCROLLBAR
    @type String
    @static
    @final
    @private
   */
  SCROLLBAR = 'scrollbar';

  /**
    @property SCROLL
    @type String
    @static
    @final
    @private
   */
  SCROLL = 'scroll';

  /**
    @property MOUSEDOWN
    @type String
    @final
    @private
   */
  MOUSEDOWN = 'mousedown';

  /**
    @property MOUSEMOVE
    @type String
    @static
    @final
    @private
   */
  MOUSEMOVE = 'mousemove';

  /**
    @property MOUSEWHEEL
    @type String
    @final
    @private
   */
  MOUSEWHEEL = 'mousewheel';

  /**
    @property MOUSEUP
    @type String
    @static
    @final
    @private
   */
  MOUSEUP = 'mouseup';

  /**
    @property RESIZE
    @type String
    @final
    @private
   */
  RESIZE = 'resize';

  /**
    @property DRAG
    @type String
    @static
    @final
    @private
   */
  DRAG = 'drag';

  /**
    @property UP
    @type String
    @static
    @final
    @private
   */
  UP = 'up';

  /**
    @property PANEDOWN
    @type String
    @static
    @final
    @private
   */
  PANEDOWN = 'panedown';

  /**
    @property DOMSCROLL
    @type String
    @static
    @final
    @private
   */
  DOMSCROLL = 'DOMMouseScroll';

  /**
    @property DOWN
    @type String
    @static
    @final
    @private
   */
  DOWN = 'down';

  /**
    @property WHEEL
    @type String
    @static
    @final
    @private
   */
  WHEEL = 'wheel';

  /**
    @property KEYDOWN
    @type String
    @static
    @final
    @private
   */
  KEYDOWN = 'keydown';

  /**
    @property KEYUP
    @type String
    @static
    @final
    @private
   */
  KEYUP = 'keyup';

  /**
    @property TOUCHMOVE
    @type String
    @static
    @final
    @private
   */
  TOUCHMOVE = 'touchmove';

  /**
    @property BROWSER_IS_IE7
    @type Boolean
    @static
    @final
    @private
   */
  BROWSER_IS_IE7 = window.navigator.appName === 'Microsoft Internet Explorer' && /msie 7./i.test(window.navigator.appVersion) && window.ActiveXObject;

  /**
    @property BROWSER_SCROLLBAR_WIDTH
    @type Number
    @static
    @default null
    @private
   */
  BROWSER_SCROLLBAR_WIDTH = null;
  rAF = window.requestAnimationFrame;
  cAF = window.cancelAnimationFrame;
  _elementStyle = document.createElement('div').style;
  _vendor = (function() {
    var i, transform, vendor, vendors, _i, _len;
    vendors = ['t', 'webkitT', 'MozT', 'msT', 'OT'];
    for (i = _i = 0, _len = vendors.length; _i < _len; i = ++_i) {
      vendor = vendors[i];
      transform = vendors[i] + 'ransform';
      if (transform in _elementStyle) {
        return vendors[i].substr(0, vendors[i].length - 1);
      }
    }
    return false;
  })();
  _prefixStyle = function(style) {
    if (_vendor === false) {
      return false;
    }
    if (_vendor === '') {
      return style;
    }
    return _vendor + style.charAt(0).toUpperCase() + style.substr(1);
  };
  transform = _prefixStyle('transform');
  hasTransform = transform !== false;

  /**
    Returns browser's native scrollbar width
    @method getBrowserScrollbarWidth
    @return {Number} the scrollbar width in pixels
    @static
    @private
   */
  getBrowserScrollbarWidth = function() {
    var outer, outerStyle, scrollbarWidth;
    outer = document.createElement('div');
    outerStyle = outer.style;
    outerStyle.position = 'absolute';
    outerStyle.width = '100px';
    outerStyle.height = '100px';
    outerStyle.overflow = SCROLL;
    outerStyle.top = '-9999px';
    document.body.appendChild(outer);
    scrollbarWidth = outer.offsetWidth - outer.clientWidth;
    document.body.removeChild(outer);
    return scrollbarWidth;
  };
  isFFWithBuggyScrollbar = function() {
    var isOSXFF, ua, version;
    ua = window.navigator.userAgent;
    isOSXFF = /(?=.+Mac OS X)(?=.+Firefox)/.test(ua);
    if (!isOSXFF) {
      return false;
    }
    version = /Firefox\/\d{2}\./.exec(ua);
    if (version) {
      version = version[0].replace(/\D+/g, '');
    }
    return isOSXFF && +version > 23;
  };

  /**
    @class NanoScroll
    @param element {HTMLElement|Node} the main element
    @param options {Object} nanoScroller's options
    @constructor
   */
  NanoScroll = (function() {
    function NanoScroll(el, options) {
      this.el = el;
      this.options = options;
      BROWSER_SCROLLBAR_WIDTH || (BROWSER_SCROLLBAR_WIDTH = getBrowserScrollbarWidth());
      this.$el = $(this.el);
      this.doc = $(this.options.documentContext || document);
      this.win = $(this.options.windowContext || window);
      this.$content = this.$el.children("." + options.contentClass);
      this.$content.attr('tabindex', this.options.tabIndex || 0);
      this.content = this.$content[0];
      this.previousPosition = 0;
      if (this.options.iOSNativeScrolling && (this.el.style.WebkitOverflowScrolling != null)) {
        this.nativeScrolling();
      } else {
        this.generate();
      }
      this.createEvents();
      this.addEvents();
      this.reset();
    }


    /**
      Prevents the rest of the page being scrolled
      when user scrolls the `.nano-content` element.
      @method preventScrolling
      @param event {Event}
      @param direction {String} Scroll direction (up or down)
      @private
     */

    NanoScroll.prototype.preventScrolling = function(e, direction) {
      if (!this.isActive) {
        return;
      }
      if (e.type === DOMSCROLL) {
        if (direction === DOWN && e.originalEvent.detail > 0 || direction === UP && e.originalEvent.detail < 0) {
          e.preventDefault();
        }
      } else if (e.type === MOUSEWHEEL) {
        if (!e.originalEvent || !e.originalEvent.wheelDelta) {
          return;
        }
        if (direction === DOWN && e.originalEvent.wheelDelta < 0 || direction === UP && e.originalEvent.wheelDelta > 0) {
          e.preventDefault();
        }
      }
    };


    /**
      Enable iOS native scrolling
      @method nativeScrolling
      @private
     */

    NanoScroll.prototype.nativeScrolling = function() {
      this.$content.css({
        WebkitOverflowScrolling: 'touch'
      });
      this.iOSNativeScrolling = true;
      this.isActive = true;
    };


    /**
      Updates those nanoScroller properties that
      are related to current scrollbar position.
      @method updateScrollValues
      @private
     */

    NanoScroll.prototype.updateScrollValues = function() {
      var content, direction;
      content = this.content;
      this.maxScrollTop = content.scrollHeight - content.clientHeight;
      this.prevScrollTop = this.contentScrollTop || 0;
      this.contentScrollTop = content.scrollTop;
      direction = this.contentScrollTop > this.previousPosition ? "down" : this.contentScrollTop < this.previousPosition ? "up" : "same";
      this.previousPosition = this.contentScrollTop;
      if (direction !== "same") {
        this.$el.trigger('update', {
          position: this.contentScrollTop,
          maximum: this.maxScrollTop,
          direction: direction
        });
      }
      if (!this.iOSNativeScrolling) {
        this.maxSliderTop = this.paneHeight - this.sliderHeight;
        this.sliderTop = this.maxScrollTop === 0 ? 0 : this.contentScrollTop * this.maxSliderTop / this.maxScrollTop;
      }
    };


    /**
      Updates CSS styles for current scroll position.
      Uses CSS 2d transfroms and `window.requestAnimationFrame` if available.
      @method setOnScrollStyles
      @private
     */

    NanoScroll.prototype.setOnScrollStyles = function() {
      var cssValue;
      if (hasTransform) {
        cssValue = {};
        cssValue[transform] = "translate(0, " + this.sliderTop + "px)";
      } else {
        cssValue = {
          top: this.sliderTop
        };
      }
      if (rAF) {
        if (!this.scrollRAF) {
          this.scrollRAF = rAF((function(_this) {
            return function() {
              _this.scrollRAF = null;
              _this.slider.css(cssValue);
            };
          })(this));
        }
      } else {
        this.slider.css(cssValue);
      }
    };


    /**
      Creates event related methods
      @method createEvents
      @private
     */

    NanoScroll.prototype.createEvents = function() {
      this.events = {
        down: (function(_this) {
          return function(e) {
            _this.isBeingDragged = true;
            _this.offsetY = e.pageY - _this.slider.offset().top;
            _this.pane.addClass('active');
            _this.doc.bind(MOUSEMOVE, _this.events[DRAG]).bind(MOUSEUP, _this.events[UP]);
            return false;
          };
        })(this),
        drag: (function(_this) {
          return function(e) {
            _this.sliderY = e.pageY - _this.$el.offset().top - _this.offsetY;
            _this.scroll();
            if (_this.contentScrollTop >= _this.maxScrollTop && _this.prevScrollTop !== _this.maxScrollTop) {
              _this.$el.trigger('scrollend');
            } else if (_this.contentScrollTop === 0 && _this.prevScrollTop !== 0) {
              _this.$el.trigger('scrolltop');
            }
            return false;
          };
        })(this),
        up: (function(_this) {
          return function(e) {
            _this.isBeingDragged = false;
            _this.pane.removeClass('active');
            _this.doc.unbind(MOUSEMOVE, _this.events[DRAG]).unbind(MOUSEUP, _this.events[UP]);
            return false;
          };
        })(this),
        resize: (function(_this) {
          return function(e) {
            _this.reset();
          };
        })(this),
        panedown: (function(_this) {
          return function(e) {
            _this.sliderY = (e.offsetY || e.originalEvent.layerY) - (_this.sliderHeight * 0.5);
            _this.scroll();
            _this.events.down(e);
            return false;
          };
        })(this),
        scroll: (function(_this) {
          return function(e) {
            _this.updateScrollValues();
            if (_this.isBeingDragged) {
              return;
            }
            if (!_this.iOSNativeScrolling) {
              _this.sliderY = _this.sliderTop;
              _this.setOnScrollStyles();
            }
            if (e == null) {
              return;
            }
            if (_this.contentScrollTop >= _this.maxScrollTop) {
              if (_this.options.preventPageScrolling) {
                _this.preventScrolling(e, DOWN);
              }
              if (_this.prevScrollTop !== _this.maxScrollTop) {
                _this.$el.trigger('scrollend');
              }
            } else if (_this.contentScrollTop === 0) {
              if (_this.options.preventPageScrolling) {
                _this.preventScrolling(e, UP);
              }
              if (_this.prevScrollTop !== 0) {
                _this.$el.trigger('scrolltop');
              }
            }
          };
        })(this),
        wheel: (function(_this) {
          return function(e) {
            var delta;
            if (e == null) {
              return;
            }
            delta = e.delta || e.wheelDelta || (e.originalEvent && e.originalEvent.wheelDelta) || -e.detail || (e.originalEvent && -e.originalEvent.detail);
            if (delta) {
              _this.sliderY += -delta / 3;
            }
            _this.scroll();
            return false;
          };
        })(this)
      };
    };


    /**
      Adds event listeners with jQuery.
      @method addEvents
      @private
     */

    NanoScroll.prototype.addEvents = function() {
      var events;
      this.removeEvents();
      events = this.events;
      if (!this.options.disableResize) {
        this.win.bind(RESIZE, events[RESIZE]);
      }
      if (!this.iOSNativeScrolling) {
        this.slider.bind(MOUSEDOWN, events[DOWN]);
        this.pane.bind(MOUSEDOWN, events[PANEDOWN]).bind("" + MOUSEWHEEL + " " + DOMSCROLL, events[WHEEL]);
      }
      this.$content.bind("" + SCROLL + " " + MOUSEWHEEL + " " + DOMSCROLL + " " + TOUCHMOVE, events[SCROLL]);
    };


    /**
      Removes event listeners with jQuery.
      @method removeEvents
      @private
     */

    NanoScroll.prototype.removeEvents = function() {
      var events;
      events = this.events;
      this.win.unbind(RESIZE, events[RESIZE]);
      if (!this.iOSNativeScrolling) {
        this.slider.unbind();
        this.pane.unbind();
      }
      this.$content.unbind("" + SCROLL + " " + MOUSEWHEEL + " " + DOMSCROLL + " " + TOUCHMOVE, events[SCROLL]);
    };


    /**
      Generates nanoScroller's scrollbar and elements for it.
      @method generate
      @chainable
      @private
     */

    NanoScroll.prototype.generate = function() {
      var contentClass, cssRule, currentPadding, options, pane, paneClass, sliderClass;
      options = this.options;
      paneClass = options.paneClass, sliderClass = options.sliderClass, contentClass = options.contentClass;
      if (!(pane = this.$el.children("." + paneClass)).length && !pane.children("." + sliderClass).length) {
        this.$el.append("<div class=\"" + paneClass + "\"><div class=\"" + sliderClass + "\" /></div>");
      }
      this.pane = this.$el.children("." + paneClass);
      this.slider = this.pane.find("." + sliderClass);
      if (BROWSER_SCROLLBAR_WIDTH === 0 && isFFWithBuggyScrollbar()) {
        currentPadding = window.getComputedStyle(this.content, null).getPropertyValue('padding-right').replace(/\D+/g, '');
        cssRule = {
          right: -14,
          paddingRight: +currentPadding + 14
        };
      } else if (BROWSER_SCROLLBAR_WIDTH) {
        cssRule = {
          right: -BROWSER_SCROLLBAR_WIDTH
        };
        this.$el.addClass('has-scrollbar');
      }
      if (cssRule != null) {
        this.$content.css(cssRule);
      }
      return this;
    };


    /**
      @method restore
      @private
     */

    NanoScroll.prototype.restore = function() {
      this.stopped = false;
      if (!this.iOSNativeScrolling) {
        this.pane.show();
      }
      this.addEvents();
    };


    /**
      Resets nanoScroller's scrollbar.
      @method reset
      @chainable
      @example
          $(".nano").nanoScroller();
     */

    NanoScroll.prototype.reset = function() {
      var content, contentHeight, contentPosition, contentStyle, contentStyleOverflowY, paneBottom, paneHeight, paneOuterHeight, paneTop, parentMaxHeight, right, sliderHeight;
      if (this.iOSNativeScrolling) {
        this.contentHeight = this.content.scrollHeight;
        return;
      }
      if (!this.$el.find("." + this.options.paneClass).length) {
        this.generate().stop();
      }
      if (this.stopped) {
        this.restore();
      }
      content = this.content;
      contentStyle = content.style;
      contentStyleOverflowY = contentStyle.overflowY;
      if (BROWSER_IS_IE7) {
        this.$content.css({
          height: this.$content.height()
        });
      }
      contentHeight = content.scrollHeight + BROWSER_SCROLLBAR_WIDTH;
      parentMaxHeight = parseInt(this.$el.css("max-height"), 10);
      if (parentMaxHeight > 0) {
        this.$el.height("");
        this.$el.height(content.scrollHeight > parentMaxHeight ? parentMaxHeight : content.scrollHeight);
      }
      paneHeight = this.pane.outerHeight(false);
      paneTop = parseInt(this.pane.css('top'), 10);
      paneBottom = parseInt(this.pane.css('bottom'), 10);
      paneOuterHeight = paneHeight + paneTop + paneBottom;
      sliderHeight = Math.round(paneOuterHeight / contentHeight * paneOuterHeight);
      if (sliderHeight < this.options.sliderMinHeight) {
        sliderHeight = this.options.sliderMinHeight;
      } else if ((this.options.sliderMaxHeight != null) && sliderHeight > this.options.sliderMaxHeight) {
        sliderHeight = this.options.sliderMaxHeight;
      }
      if (contentStyleOverflowY === SCROLL && contentStyle.overflowX !== SCROLL) {
        sliderHeight += BROWSER_SCROLLBAR_WIDTH;
      }
      this.maxSliderTop = paneOuterHeight - sliderHeight;
      this.contentHeight = contentHeight;
      this.paneHeight = paneHeight;
      this.paneOuterHeight = paneOuterHeight;
      this.sliderHeight = sliderHeight;
      this.slider.height(sliderHeight);
      this.events.scroll();
      this.pane.show();
      this.isActive = true;
      if ((content.scrollHeight === content.clientHeight) || (this.pane.outerHeight(true) >= content.scrollHeight && contentStyleOverflowY !== SCROLL)) {
        this.pane.hide();
        this.isActive = false;
      } else if (this.el.clientHeight === content.scrollHeight && contentStyleOverflowY === SCROLL) {
        this.slider.hide();
      } else {
        this.slider.show();
      }
      this.pane.css({
        opacity: (this.options.alwaysVisible ? 1 : ''),
        visibility: (this.options.alwaysVisible ? 'visible' : '')
      });
      contentPosition = this.$content.css('position');
      if (contentPosition === 'static' || contentPosition === 'relative') {
        right = parseInt(this.$content.css('right'), 10);
        if (right) {
          this.$content.css({
            right: '',
            marginRight: right
          });
        }
      }
      return this;
    };


    /**
      @method scroll
      @private
      @example
          $(".nano").nanoScroller({ scroll: 'top' });
     */

    NanoScroll.prototype.scroll = function() {
      if (!this.isActive) {
        return;
      }
      this.sliderY = Math.max(0, this.sliderY);
      this.sliderY = Math.min(this.maxSliderTop, this.sliderY);
      this.$content.scrollTop((this.paneHeight - this.contentHeight + BROWSER_SCROLLBAR_WIDTH) * this.sliderY / this.maxSliderTop * -1);
      if (!this.iOSNativeScrolling) {
        this.updateScrollValues();
        this.setOnScrollStyles();
      }
      return this;
    };


    /**
      Scroll at the bottom with an offset value
      @method scrollBottom
      @param offsetY {Number}
      @chainable
      @example
          $(".nano").nanoScroller({ scrollBottom: value });
     */

    NanoScroll.prototype.scrollBottom = function(offsetY) {
      if (!this.isActive) {
        return;
      }
      this.$content.scrollTop(this.contentHeight - this.$content.height() - offsetY).trigger(MOUSEWHEEL);
      this.stop().restore();
      return this;
    };


    /**
      Scroll at the top with an offset value
      @method scrollTop
      @param offsetY {Number}
      @chainable
      @example
          $(".nano").nanoScroller({ scrollTop: value });
     */

    NanoScroll.prototype.scrollTop = function(offsetY) {
      if (!this.isActive) {
        return;
      }
      this.$content.scrollTop(+offsetY).trigger(MOUSEWHEEL);
      this.stop().restore();
      return this;
    };


    /**
      Scroll to an element
      @method scrollTo
      @param node {Node} A node to scroll to.
      @chainable
      @example
          $(".nano").nanoScroller({ scrollTo: $('#a_node') });
     */

    NanoScroll.prototype.scrollTo = function(node) {
      if (!this.isActive) {
        return;
      }
      this.scrollTop(this.$el.find(node).get(0).offsetTop);
      return this;
    };


    /**
      To stop the operation.
      This option will tell the plugin to disable all event bindings and hide the gadget scrollbar from the UI.
      @method stop
      @chainable
      @example
          $(".nano").nanoScroller({ stop: true });
     */

    NanoScroll.prototype.stop = function() {
      if (cAF && this.scrollRAF) {
        cAF(this.scrollRAF);
        this.scrollRAF = null;
      }
      this.stopped = true;
      this.removeEvents();
      if (!this.iOSNativeScrolling) {
        this.pane.hide();
      }
      return this;
    };


    /**
      Destroys nanoScroller and restores browser's native scrollbar.
      @method destroy
      @chainable
      @example
          $(".nano").nanoScroller({ destroy: true });
     */

    NanoScroll.prototype.destroy = function() {
      if (!this.stopped) {
        this.stop();
      }
      if (!this.iOSNativeScrolling && this.pane.length) {
        this.pane.remove();
      }
      if (BROWSER_IS_IE7) {
        this.$content.height('');
      }
      this.$content.removeAttr('tabindex');
      if (this.$el.hasClass('has-scrollbar')) {
        this.$el.removeClass('has-scrollbar');
        this.$content.css({
          right: ''
        });
      }
      return this;
    };


    /**
      To flash the scrollbar gadget for an amount of time defined in plugin settings (defaults to 1,5s).
      Useful if you want to show the user (e.g. on pageload) that there is more content waiting for him.
      @method flash
      @chainable
      @example
          $(".nano").nanoScroller({ flash: true });
     */

    NanoScroll.prototype.flash = function() {
      if (this.iOSNativeScrolling) {
        return;
      }
      if (!this.isActive) {
        return;
      }
      this.reset();
      this.pane.addClass('flashed');
      setTimeout((function(_this) {
        return function() {
          _this.pane.removeClass('flashed');
        };
      })(this), this.options.flashDelay);
      return this;
    };

    return NanoScroll;

  })();
  $.fn.nanoScroller = function(settings) {
    return this.each(function() {
      var options, scrollbar;
      if (!(scrollbar = this.nanoscroller)) {
        options = $.extend({}, defaults, settings);
        this.nanoscroller = scrollbar = new NanoScroll(this, options);
      }
      if (settings && typeof settings === "object") {
        $.extend(scrollbar.options, settings);
        if (settings.scrollBottom != null) {
          return scrollbar.scrollBottom(settings.scrollBottom);
        }
        if (settings.scrollTop != null) {
          return scrollbar.scrollTop(settings.scrollTop);
        }
        if (settings.scrollTo) {
          return scrollbar.scrollTo(settings.scrollTo);
        }
        if (settings.scroll === 'bottom') {
          return scrollbar.scrollBottom(0);
        }
        if (settings.scroll === 'top') {
          return scrollbar.scrollTop(0);
        }
        if (settings.scroll && settings.scroll instanceof $) {
          return scrollbar.scrollTo(settings.scroll);
        }
        if (settings.stop) {
          return scrollbar.stop();
        }
        if (settings.destroy) {
          return scrollbar.destroy();
        }
        if (settings.flash) {
          return scrollbar.flash();
        }
      }
      return scrollbar.reset();
    });
  };
  $.fn.nanoScroller.Constructor = NanoScroll;
})(jQuery, window, document);

//# sourceMappingURL=jquery.nanoscroller.js.map
/*
 * jQuery.appear
 * https://github.com/bas2k/jquery.appear/
 * http://code.google.com/p/jquery-appear/
 * http://bas2k.ru/
 *
 * Copyright (c) 2009 Michael Hixson
 * Copyright (c) 2012-2014 Alexander Brovikov
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php)
 */
(function($) {
    $.fn.appear = function(fn, options) {

        var settings = $.extend({

            //arbitrary data to pass to fn
            data: undefined,

            //call fn only on the first appear?
            one: true,

            // X & Y accuracy
            accX: 0,
            accY: 0

        }, options);

        return this.each(function() {

            var t = $(this);

            //whether the element is currently visible
            t.appeared = false;

            if (!fn) {

                //trigger the custom event
                t.trigger('appear', settings.data);
                return;
            }

            var w = $(window);

            //fires the appear event when appropriate
            var check = function() {

                //is the element hidden?
                if (!t.is(':visible')) {

                    //it became hidden
                    t.appeared = false;
                    return;
                }

                //is the element inside the visible window?
                var a = w.scrollLeft();
                var b = w.scrollTop();
                var o = t.offset();
                var x = o.left;
                var y = o.top;

                var ax = settings.accX;
                var ay = settings.accY;
                var th = t.height();
                var wh = w.height();
                var tw = t.width();
                var ww = w.width();

                if (y + th + ay >= b &&
                    y <= b + wh + ay &&
                    x + tw + ax >= a &&
                    x <= a + ww + ax) {

                    //trigger the custom event
                    if (!t.appeared) t.trigger('appear', settings.data);

                } else {

                    //it scrolled out of view
                    t.appeared = false;
                }
            };

            //create a modified fn with some additional logic
            var modifiedFn = function() {

                //mark the element as visible
                t.appeared = true;

                //is this supposed to happen only once?
                if (settings.one) {

                    //remove the check
                    w.unbind('scroll', check);
                    var i = $.inArray(check, $.fn.appear.checks);
                    if (i >= 0) $.fn.appear.checks.splice(i, 1);
                }

                //trigger the original fn
                fn.apply(this, arguments);
            };

            //bind the modified fn to the element
            if (settings.one) t.one('appear', settings.data, modifiedFn);
            else t.bind('appear', settings.data, modifiedFn);

            //check whenever the window scrolls
            w.scroll(check);

            //check whenever the dom changes
            $.fn.appear.checks.push(check);

            //check now
            (check)();
        });
    };

    //keep a queue of appearance checks
    $.extend($.fn.appear, {

        checks: [],
        timeout: null,

        //process the queue
        checkAll: function() {
            var length = $.fn.appear.checks.length;
            if (length > 0) while (length--) ($.fn.appear.checks[length])();
        },

        //check the queue asynchronously
        run: function() {
            if ($.fn.appear.timeout) clearTimeout($.fn.appear.timeout);
            $.fn.appear.timeout = setTimeout($.fn.appear.checkAll, 20);
        }
    });

    //run checks when these methods are called
    $.each(['append', 'prepend', 'after', 'before', 'attr',
        'removeAttr', 'addClass', 'removeClass', 'toggleClass',
        'remove', 'css', 'show', 'hide'], function(i, n) {
        var old = $.fn[n];
        if (old) {
            $.fn[n] = function() {
                var r = old.apply(this, arguments);
                $.fn.appear.run();
                return r;
            }
        }
    });

})(jQuery);

//     jquery-comments.js 1.0.1

//     (c) 2015 Joona Tykkyläinen, Viima Solutions Oy
//     jquery-comments may be freely distributed under the MIT license.
//     For all details and documentation:
//     http://viima.github.io/jquery-comments/
!function(e){var t={$el:null,commentsById:{},currentSortKey:"",options:{profilePictureURL:"",spinnerIconURL:"",upvoteIconURL:"",replyIconURL:"",noCommentsIconURL:"",textareaPlaceholderText:"Add a comment",popularText:"Popular",newestText:"Newest",oldestText:"Oldest",sendText:"Send",replyText:"Reply",editText:"Edit",editedText:"Edited",youText:"You",saveText:"Save",deleteText:"Delete",viewAllRepliesText:"View all __replyCount__ replies",hideRepliesText:"Hide replies",noCommentsText:"No comments",textFormatter:function(e){return e},enableReplying:!0,enableEditing:!0,enableUpvoting:!0,enableDeleting:!0,enableDeletingCommentWithReplies:!0,highlightColor:"#337AB7",deleteButtonColor:"#C9302C",roundProfilePictures:!1,textareaRows:2,textareaRowsOnFocus:2,textareaMaxRows:5,maxRepliesVisible:2,fieldMappings:{id:"id",parent:"parent",created:"created",modified:"modified",content:"content",fullname:"fullname",profilePictureURL:"profile_picture_url",createdByAdmin:"created_by_admin",createdByCurrentUser:"created_by_current_user",upvoteCount:"upvote_count",userHasUpvoted:"user_has_upvoted"},getComments:function(e,t){e([])},postComment:function(e,t,n){t(e)},putComment:function(e,t,n){t(e)},deleteComment:function(e,t,n){t()},upvoteComment:function(e,t,n){t(e)},refresh:function(){},timeFormatter:function(e){return new Date(e).toLocaleDateString()}},events:{"keydown [contenteditable]":"saveOnKeydown","focus [contenteditable]":"saveEditableContent","keyup [contenteditable]":"checkEditableContentForChange","paste [contenteditable]":"checkEditableContentForChange","input [contenteditable]":"checkEditableContentForChange","blur [contenteditable]":"checkEditableContentForChange","click .navigation li":"navigationElementClicked","click .commenting-field.main .textarea":"showMainCommentingField","click .commenting-field.main .close":"hideMainCommentingField","click .commenting-field .textarea":"increaseTextareaHeight","change .commenting-field .textarea":"increaseTextareaHeight textareaContentChanged","click .commenting-field:not(.main) .close":"removeCommentingField","click .commenting-field .send.enabled":"postComment","click .commenting-field .update.enabled":"putComment","click .commenting-field .delete.enabled":"deleteComment","click li.comment ul.child-comments .toggle-all":"toggleReplies","click li.comment button.reply":"replyButtonClicked","click li.comment button.edit":"editButtonClicked","click li.comment button.upvote":"upvoteComment"},init:function(t,n){this.$el=e(n),this.$el.addClass("jquery-comments"),this.undelegateEvents(),this.delegateEvents(),function(e){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(e)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(e.substr(0,4))}(navigator.userAgent||navigator.vendor||window.opera),e.browser.mobile&&this.$el.addClass("mobile"),t.fieldMappings&&(t=e.extend({},t),e.extend(this.options.fieldMappings,t.fieldMappings),delete t.fieldMappings),e.extend(this.options,t),this.createCssDeclarations(),this.fetchDataAndRender()},delegateEvents:function(){this.bindEvents(!1)},undelegateEvents:function(){this.bindEvents(!0)},bindEvents:function(t){var n=t?"off":"on";for(var i in this.events){var a=i.split(" ")[0],o=i.split(" ").slice(1).join(" "),r=this.events[i].split(" ");for(var s in r)if(r.hasOwnProperty(s)){var l=this[r[s]];l=e.proxy(l,this),""==o?this.$el[n](a,l):this.$el[n](a,o,l)}}},fetchDataAndRender:function(){var t=this;this.$el.empty(),this.createHTML(),this.commentsById={};var n=function(n){var i=n.map(function(e){return t.createCommentModel(e)});t.sortComments(i,"oldest"),e(i).each(function(e,n){t.addCommentToDataModel(n)}),t.render()},i=function(){n([])};this.options.getComments(n,i)},createCommentModel:function(e){var t=this.applyInternalMappings(e);return t.childs=[],t},addCommentToDataModel:function(e){if(!(e.id in this.commentsById)&&(this.commentsById[e.id]=e,e.parent)){var t=this.getOutermostParent(e.parent);t.childs.push(e.id)}},updateCommentModel:function(t){e.extend(this.commentsById[t.id],t)},render:function(){var t=this;this.$el.find("#comment-list").remove();var n=e("<ul/>",{id:"comment-list"});this.currentSortKey=this.$el.find(".navigation li.active").data().sortKey;var i=[],a=[];e(this.getComments()).each(function(e,t){null==t.parent?i.push(t):a.push(t)}),this.sortComments(i,this.currentSortKey),i.reverse(),e(i).each(function(e,i){t.addComment(i,n)}),this.sortComments(a,"oldest"),e(a).each(function(e,i){t.addComment(i,n)}),this.$el.find("> .spinner").remove(),this.$el.find(".no-comments").before(n),this.options.refresh()},addComment:function(e,t){t=t||this.$el.find("#comment-list");var n=this.createCommentElement(e);if(e.parent){var i=t.find('.comment[data-id="'+e.parent+'"]'),a=i.parents(".comment").last();0==a.length&&(a=i);var o=a.find(".child-comments");o.append(n),this.updateToggleAllButton(a)}else t.prepend(n)},removeComment:function(t){var n=this,i=this.commentsById[t],a=this.getChildComments(i.id);if(e(a).each(function(e,t){n.removeComment(t.id)}),i.parent){var o=this.getOutermostParent(i.parent),r=o.childs.indexOf(i.id);o.childs.splice(r,1)}delete this.commentsById[t];var s=this.$el.find('li.comment[data-id="'+t+'"]'),l=s.parents("li.comment").last();s.remove(),this.updateToggleAllButton(l)},updateToggleAllButton:function(t){var n=t.find(".child-comments"),i=n.find(".comment"),a=n.find("li.toggle-all");i.removeClass("hidden-reply");var o=i.slice(0,-this.options.maxRepliesVisible);if(o.addClass("hidden-reply"),a.find("span.text").text()==this.options.textFormatter(this.options.hideRepliesText)&&o.addClass("visible"),i.length>this.options.maxRepliesVisible){if(!a.length){a=e("<li/>",{"class":"toggle-all highlight-font-bold"});var r=e("<span/>",{"class":"text"}),s=e("<span/>",{"class":"caret"});a.append(r).append(s),n.prepend(a)}this.setToggleAllButtonText(a,!1)}else a.remove()},sortComments:function(e,t){var n=this;e.sort("popularity"==t?function(e,t){var i=e.childs.length,a=t.childs.length;if(n.options.enableUpvoting&&(i+=e.upvoteCount,a+=t.upvoteCount),a!=i)return a-i;var o=new Date(e.created).getTime(),r=new Date(t.created).getTime();return r-o}:function(e,n){var i=new Date(e.created).getTime(),a=new Date(n.created).getTime();return"newest"==t?a-i:i-a})},sortAndReArrangeComments:function(t){var n=this.$el.find("#comment-list"),i=this.getComments().filter(function(e){return!e.parent});this.sortComments(i,t),e(i).each(function(e,t){var i=n.find("> li.comment[data-id="+t.id+"]");n.append(i)})},saveOnKeydown:function(t){if(13==t.keyCode&&(t.metaKey||t.ctrlKey)){var n=e(t.currentTarget);n.siblings(".control-row").find(".save").trigger("click"),t.stopPropagation(),t.preventDefault()}},saveEditableContent:function(t){var n=e(t.currentTarget);n.data("before",n.html())},checkEditableContentForChange:function(t){var n=e(t.currentTarget);n.data("before")!=n.html()&&(n.data("before",n.html()),n.trigger("change"))},navigationElementClicked:function(t){var n=e(t.currentTarget);n.siblings().removeClass("active"),n.addClass("active");var i=n.data().sortKey;this.sortAndReArrangeComments(i),this.currentSortKey=i},showMainCommentingField:function(t){var n=e(t.currentTarget);n.siblings(".control-row").show(),n.parent().find(".close").show(),n.focus()},hideMainCommentingField:function(t){var n=e(t.currentTarget),i=this.$el.find(".commenting-field.main .textarea"),a=this.$el.find(".commenting-field.main .control-row");this.clearTextarea(i),this.adjustTextareaHeight(i,!1),a.hide(),n.hide(),i.blur()},increaseTextareaHeight:function(t){var n=e(t.currentTarget);this.adjustTextareaHeight(n,!0)},textareaContentChanged:function(t){var n=e(t.currentTarget),i=this.getTextareaContent(n),a=n.siblings(".control-row").find(".save");if(!n.find(".reply-to-badge").length){var o=n.attr("data-comment");if(o){var r=n.parents("li.comment");if(r.length>1){var s=r.last().data("id");n.attr("data-parent",s)}}else{var s=n.parents("li.comment").last().data("id");n.attr("data-parent",s)}}var l=n.parents(".commenting-field").first();n[0].scrollHeight>n.outerHeight()?l.addClass("scrollable"):l.removeClass("scrollable");var d=!0;if(o=n.attr("data-comment")){var c,m=i!=this.commentsById[o].content;this.commentsById[o].parent&&(c=this.commentsById[o].parent.toString());var p=n.attr("data-parent")!=c;d=m||p}i.length&&d?a.addClass("enabled"):a.removeClass("enabled")},removeCommentingField:function(t){var n=e(t.currentTarget),i=n.siblings(".textarea");i.attr("data-comment")&&n.parents("li.comment").first().removeClass("edit");var a=n.parents(".commenting-field").first();a.remove()},postComment:function(t){var n=this,i=e(t.currentTarget),a=i.parents(".commenting-field").first(),o=a.find(".textarea");i.removeClass("enabled");var r=(new Date).toISOString(),s={id:"c"+(this.getComments().length+1),parent:o.attr("data-parent")||null,created:r,modified:r,content:this.getTextareaContent(o),fullname:this.options.textFormatter(this.options.youText),profilePictureURL:this.options.profilePictureURL,createdByCurrentUser:!0,upvoteCount:0,userHasUpvoted:!1};s=this.applyExternalMappings(s);var l=function(e){var t=n.createCommentModel(e);n.addCommentToDataModel(t),n.addComment(t),a.find(".close").trigger("click")},d=function(){i.addClass("enabled")};this.options.postComment(s,l,d)},putComment:function(t){var n=this,i=e(t.currentTarget),a=i.parents(".commenting-field").first(),o=a.find(".textarea");i.removeClass("enabled");var r=e.extend({},this.commentsById[o.attr("data-comment")]);e.extend(r,{parent:o.attr("data-parent")||null,content:this.getTextareaContent(o),modified:(new Date).getTime()}),r=this.applyExternalMappings(r);var s=function(e){var t=n.createCommentModel(e);delete t.childs,n.updateCommentModel(t),a.find(".close").trigger("click"),n.reRenderComment(t.id)},l=function(){i.addClass("enabled")};this.options.putComment(r,s,l)},deleteComment:function(t){var n=this,i=e(t.currentTarget),a=i.parents(".commenting-field").first().find(".textarea"),o=e.extend({},this.commentsById[a.attr("data-comment")]),r=o.id;i.removeClass("enabled"),o=this.applyExternalMappings(o);var s=function(){n.removeComment(r)},l=function(){i.addClass("enabled")};this.options.deleteComment(o,s,l)},toggleReplies:function(t){var n=e(t.currentTarget);n.siblings(".hidden-reply").toggleClass("visible"),this.setToggleAllButtonText(n,!0)},replyButtonClicked:function(t){var n=e(t.currentTarget),i=n.parents("li.comment").last(),a=n.parents(".comment").first().data().id,o=i.find(".child-comments > .commenting-field");o.length&&o.remove();var r=o.find(".textarea").attr("data-parent");if(r!=a){o=this.createCommentingFieldElement(a),i.find(".child-comments").append(o);var s=o.find(".textarea");this.moveCursorToEnd(s)}},editButtonClicked:function(t){var n=e(t.currentTarget),i=n.parents("li.comment").first(),a=i.data().model;i.addClass("edit");var o=this.createCommentingFieldElement(a.parent,a.id);i.find(".comment-wrapper").first().append(o);var r=o.find(".textarea");r.attr("data-comment",a.id),r.append(this.getTextareaContentAsEscapedHTML(a.content)),this.moveCursorToEnd(r)},upvoteComment:function(t){var n,i=this,a=e(t.currentTarget).parents("li.comment").first(),o=a.data().model,r=o.upvoteCount;n=o.userHasUpvoted?r-1:r+1,o.userHasUpvoted=!o.userHasUpvoted,o.upvoteCount=n,this.reRenderUpvotes(o.id);var s=e.extend({},o);s=this.applyExternalMappings(s);var l=function(e){var t=i.createCommentModel(e);i.updateCommentModel(t),i.reRenderUpvotes(t.id)},d=function(){o.userHasUpvoted=!o.userHasUpvoted,o.upvoteCount=r,i.reRenderUpvotes(o.id)};this.options.upvoteComment(s,l,d)},createHTML:function(){var t=this.createCommentingFieldElement();t.addClass("main"),this.$el.append(t);var n=t.find(".control-row");n.hide(),t.find(".close").hide(),this.$el.append(this.createNavigationElement());var i=e("<div/>",{"class":"spinner"}),a=e("<i/>",{"class":"fa fa-spinner fa-spin"});this.options.spinnerIconURL.length&&(a.css("background-image",'url("'+this.options.spinnerIconURL+'")'),a.addClass("image")),i.html(a),this.$el.append(i);var o=e("<div/>",{"class":"no-comments",text:this.options.textFormatter(this.options.noCommentsText)}),r=e("<i/>",{"class":"fa fa-comments fa-2x"});this.options.noCommentsIconURL.length&&(r.css("background-image",'url("'+this.options.noCommentsIconURL+'")'),r.addClass("image")),o.prepend(e("<br/>")).prepend(r),this.$el.append(o)},createProfilePictureElement:function(t){var n=e("<img/>",{src:t,"class":"profile-picture"+(this.options.roundProfilePictures?" round":"")});return n},createCommentingFieldElement:function(t,n){var i=e("<div/>",{"class":"commenting-field"}),a=this.createProfilePictureElement(this.options.profilePictureURL);a.addClass("by-current-user");var o=e("<div/>",{"class":"textarea-wrapper"}),r=e("<div/>",{"class":"control-row"}),s=e("<div/>",{"class":"textarea","data-placeholder":this.options.textFormatter(this.options.textareaPlaceholderText),contenteditable:!0});this.adjustTextareaHeight(s,!1);var l=e("<span/>",{"class":"close"}).append(e('<span class="left"/>')).append(e('<span class="right"/>'));if(n){var d=this.options.textFormatter(this.options.saveText);if(this.options.enableDeleting){var c=!0;if(this.options.enableDeletingCommentWithReplies||e(this.getComments()).each(function(e,t){t.parent==n&&(c=!1)}),c){var m=e("<span/>",{"class":"enabled delete",text:this.options.textFormatter(this.options.deleteText)}).css("background-color",this.options.deleteButtonColor);r.append(m)}}}else var d=this.options.textFormatter(this.options.sendText);var p=n?"update":"send",h=e("<span/>",{"class":p+" save highlight-background",text:d});if(r.prepend(h),o.append(l).append(s).append(r),i.append(a).append(o),t){s.attr("data-parent",t);var u=this.commentsById[t];if(u.parent){s.html("&nbsp;");var g=e("<input/>",{"class":"reply-to-badge highlight-font-bold",type:"button"}),f="@"+u.fullname;g.val(f),s.prepend(g)}}return i},createNavigationElement:function(){var t=e("<ul/>",{"class":"navigation"}),n=e("<li/>",{text:this.options.textFormatter(this.options.newestText),"data-sort-key":"newest"}),i=e("<li/>",{text:this.options.textFormatter(this.options.oldestText),"data-sort-key":"oldest"}),a=e("<li/>",{text:this.options.textFormatter(this.options.popularText),"data-sort-key":"popularity"});t.append(n).append(i);var o=this.options.enableReplying||this.options.enableUpvoting;return o&&t.append(a),t.children().first().addClass("active"),t},createCommentElement:function(t){var n=e("<li/>",{"data-id":t.id,"class":"comment"}).data("model",t);t.createdByCurrentUser&&n.addClass("by-current-user"),t.createdByAdmin&&n.addClass("by-admin");var i=e("<ul/>",{"class":"child-comments"}),a=this.createCommentWrapperElement(t);return n.append(a),null==t.parent&&n.append(i),n},createCommentWrapperElement:function(t){var n=e("<div/>",{"class":"comment-wrapper"}),i=this.createProfilePictureElement(t.profilePictureURL),a=e("<time/>",{text:this.options.timeFormatter(t.created),"data-original":t.created}),o=e("<div/>",{"class":"name",text:t.fullname});if(t.createdByAdmin&&o.addClass("highlight-font-bold"),t.parent){var r=this.commentsById[t.parent];if(r.parent){var s=e("<span/>",{"class":"reply-to",text:r.fullname}),l=e("<i/>",{"class":"fa fa-share"});this.options.replyIconURL.length&&(l.css("background-image",'url("'+this.options.replyIconURL+'")'),l.addClass("image")),s.prepend(l),o.append(s)}}var d=e("<div/>",{"class":"wrapper"}),c=e("<div/>",{"class":"content",text:t.content}).html(this.linkify(this.escape(t.content)));if(t.modified&&t.modified!=t.created){var m=this.options.timeFormatter(t.modified),p=e("<time/>",{"class":"edited",text:this.options.textFormatter(this.options.editedText)+" "+m,"data-original":t.modified});c.append(p)}var h=e("<span/>",{"class":"actions"}),u=e("<span/>",{"class":"separator",text:"·"}),g=e("<button/>",{"class":"action reply",text:this.options.textFormatter(this.options.replyText)}),f=e("<i/>",{"class":"fa fa-thumbs-up"});this.options.upvoteIconURL.length&&(f.css("background-image",'url("'+this.options.upvoteIconURL+'")'),f.addClass("image"));var v=this.createUpvoteElement(t),C=e("<button/>",{"class":"action edit",text:this.options.textFormatter(this.options.editText)});return this.options.enableReplying&&h.append(g),this.options.enableUpvoting&&h.append(v),this.options.enableEditing&&t.createdByCurrentUser&&h.append(C),h.children().each(function(t,n){e(n).is(":last-child")||e(n).after(u.clone())}),d.append(c),d.append(h),n.append(i).append(a).append(o).append(d),n},createUpvoteElement:function(t){var n=e("<i/>",{"class":"fa fa-thumbs-up"});this.options.upvoteIconURL.length&&(n.css("background-image",'url("'+this.options.upvoteIconURL+'")'),n.addClass("image"));var i=e("<button/>",{"class":"action upvote"+(t.userHasUpvoted?" highlight-font":"")}).append(e("<span/>",{text:t.upvoteCount,"class":"upvote-count"})).append(n);return i},reRenderComment:function(e){var t=this.commentsById[e],n=this.createCommentWrapperElement(t),i=this.$el.find('li.comment[data-id="'+t.id+'"]');i.find("> .comment-wrapper").replaceWith(n)},reRenderUpvotes:function(e){var t=this.commentsById[e],n=this.createUpvoteElement(t),i=this.$el.find('li.comment[data-id="'+t.id+'"]');i.find(".upvote").first().replaceWith(n)},createCssDeclarations:function(){e("head style.jquery-comments-css").remove(),this.createCss(".jquery-comments ul.navigation li.active:after {background: "+this.options.highlightColor+" !important;",0/0),this.createCss(".jquery-comments .highlight-background {background: "+this.options.highlightColor+" !important;",0/0),this.createCss(".jquery-comments .highlight-font {color: "+this.options.highlightColor+" !important;}"),this.createCss(".jquery-comments .highlight-font-bold {color: "+this.options.highlightColor+" !important;font-weight: bold;}")},createCss:function(t){var n=e("<style/>",{type:"text/css","class":"jquery-comments-css",text:t});e("head").append(n)},getComments:function(){var e=this;return Object.keys(this.commentsById).map(function(t){return e.commentsById[t]})},getChildComments:function(e){return this.getComments().filter(function(t){return t.parent==e})},getOutermostParent:function(e){var t=e;do{var n=this.commentsById[t];t=n.parent}while(null!=n.parent);return n},setToggleAllButtonText:function(e,t){var n=this,i=e.find("span.text"),a=e.find(".caret"),o=function(){var t=n.options.textFormatter(n.options.viewAllRepliesText),a=e.siblings(".comment").length;t=t.replace("__replyCount__",a),i.text(t)},r=this.options.textFormatter(this.options.hideRepliesText);t?(i.text()==r?o():i.text(r),a.toggleClass("up")):i.text()!=r&&o()},adjustTextareaHeight:function(t,n){var i=2.2,a=1.45,o=function(e){var n=i+(e-1)*a;t.css("height",n+"em")};t=e(t);var r=1==n?this.options.textareaRowsOnFocus:this.options.textareaRows;do{o(r),r++;var s=t[0].scrollHeight>t.outerHeight(),l=0==this.options.textareaMaxRows?!1:r>this.options.textareaMaxRows}while(s&&!l)},clearTextarea:function(e){e.empty().trigger("input")},getTextareaContent:function(t){var n=e("<pre/>").html(t.html());n.find("div, p, br").replaceWith(function(){return"\n"+this.innerHTML});var i=n.text().replace(/^\s+/g,"");return i},getTextareaContentAsEscapedHTML:function(e){var t=this.escape(e);return t.replace(/(?:\n)/g,"<br>")},moveCursorToEnd:function(t){if(t=e(t)[0],e(t).trigger("input"),e(t).scrollTop(t.scrollHeight),"undefined"!=typeof window.getSelection&&"undefined"!=typeof document.createRange){var n=document.createRange();n.selectNodeContents(t),n.collapse(!1);var i=window.getSelection();i.removeAllRanges(),i.addRange(n)}else if("undefined"!=typeof document.body.createTextRange){var a=document.body.createTextRange();a.moveToElementText(t),a.collapse(!1),a.select()}t.focus()},escape:function(t){return e("<pre/>").text(t).html()},linkify:function(e){var t,n,i,a;n=/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim,t=e.replace(n,'<a href="$1" target="_blank">$1</a>'),i=/(^|[^\/f])(www\.[\S]+(\b|$))/gim,t=t.replace(i,'$1<a href="http://$2" target="_blank">$2</a>'),a=/(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim,t=t.replace(a,'<a href="mailto:$1">$1</a>');var o=e.match(/<a href/g)||[];if(o.length>0){for(var r=e.split(/(<\/a>)/g),s=0;s<r.length;s++)null==r[s].match(/<a href/g)&&(r[s]=r[s].replace(n,'<a href="$1" target="_blank">$1</a>').replace(i,'$1<a href="http://$2" target="_blank">$2</a>').replace(a,'<a href="mailto:$1">$1</a>'));var l=r.join("");return l}return t},applyInternalMappings:function(e){var t={},n=this.options.fieldMappings;for(var i in n)n.hasOwnProperty(i)&&(t[n[i]]=i);return this.applyMappings(t,e)},applyExternalMappings:function(e){var t=this.options.fieldMappings;return this.applyMappings(t,e)},applyMappings:function(e,t){var n={};for(var i in t)if(i in e){var a=e[i];n[a]=t[i]}return n}};e.fn.comments=function(n){return this.each(function(){var i=Object.create(t);i.init(n||{},this),e.data(this,"comments",i)})}}(jQuery);
/**
* Bootstrap.js by @mdo and @fat, extended by @ArnoldDaniels.
* plugins: bootstrap-fileupload.js
* Copyright 2012 Twitter, Inc.
* http://www.apache.org/licenses/LICENSE-2.0.txt
*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match("\\.(gif|png|jpe?g)$"))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
"function"!==typeof Object.create&&(Object.create=function(f){function g(){}g.prototype=f;return new g});
(function(f,g,k){var l={init:function(a,b){this.$elem=f(b);this.options=f.extend({},f.fn.owlCarousel.options,this.$elem.data(),a);this.userOptions=a;this.loadContent()},loadContent:function(){function a(a){var d,e="";if("function"===typeof b.options.jsonSuccess)b.options.jsonSuccess.apply(this,[a]);else{for(d in a.owl)a.owl.hasOwnProperty(d)&&(e+=a.owl[d].item);b.$elem.html(e)}b.logIn()}var b=this,e;"function"===typeof b.options.beforeInit&&b.options.beforeInit.apply(this,[b.$elem]);"string"===typeof b.options.jsonPath?
(e=b.options.jsonPath,f.getJSON(e,a)):b.logIn()},logIn:function(){this.$elem.data("owl-originalStyles",this.$elem.attr("style"));this.$elem.data("owl-originalClasses",this.$elem.attr("class"));this.$elem.css({opacity:0});this.orignalItems=this.options.items;this.checkBrowser();this.wrapperWidth=0;this.checkVisible=null;this.setVars()},setVars:function(){if(0===this.$elem.children().length)return!1;this.baseClass();this.eventTypes();this.$userItems=this.$elem.children();this.itemsAmount=this.$userItems.length;
this.wrapItems();this.$owlItems=this.$elem.find(".owl-item");this.$owlWrapper=this.$elem.find(".owl-wrapper");this.playDirection="next";this.prevItem=0;this.prevArr=[0];this.currentItem=0;this.customEvents();this.onStartup()},onStartup:function(){this.updateItems();this.calculateAll();this.buildControls();this.updateControls();this.response();this.moveEvents();this.stopOnHover();this.owlStatus();!1!==this.options.transitionStyle&&this.transitionTypes(this.options.transitionStyle);!0===this.options.autoPlay&&
(this.options.autoPlay=5E3);this.play();this.$elem.find(".owl-wrapper").css("display","block");this.$elem.is(":visible")?this.$elem.css("opacity",1):this.watchVisibility();this.onstartup=!1;this.eachMoveUpdate();"function"===typeof this.options.afterInit&&this.options.afterInit.apply(this,[this.$elem])},eachMoveUpdate:function(){!0===this.options.lazyLoad&&this.lazyLoad();!0===this.options.autoHeight&&this.autoHeight();this.onVisibleItems();"function"===typeof this.options.afterAction&&this.options.afterAction.apply(this,
[this.$elem])},updateVars:function(){"function"===typeof this.options.beforeUpdate&&this.options.beforeUpdate.apply(this,[this.$elem]);this.watchVisibility();this.updateItems();this.calculateAll();this.updatePosition();this.updateControls();this.eachMoveUpdate();"function"===typeof this.options.afterUpdate&&this.options.afterUpdate.apply(this,[this.$elem])},reload:function(){var a=this;g.setTimeout(function(){a.updateVars()},0)},watchVisibility:function(){var a=this;if(!1===a.$elem.is(":visible"))a.$elem.css({opacity:0}),
g.clearInterval(a.autoPlayInterval),g.clearInterval(a.checkVisible);else return!1;a.checkVisible=g.setInterval(function(){a.$elem.is(":visible")&&(a.reload(),a.$elem.animate({opacity:1},200),g.clearInterval(a.checkVisible))},500)},wrapItems:function(){this.$userItems.wrapAll('<div class="owl-wrapper">').wrap('<div class="owl-item"></div>');this.$elem.find(".owl-wrapper").wrap('<div class="owl-wrapper-outer">');this.wrapperOuter=this.$elem.find(".owl-wrapper-outer");this.$elem.css("display","block")},
baseClass:function(){var a=this.$elem.hasClass(this.options.baseClass),b=this.$elem.hasClass(this.options.theme);a||this.$elem.addClass(this.options.baseClass);b||this.$elem.addClass(this.options.theme)},updateItems:function(){var a,b;if(!1===this.options.responsive)return!1;if(!0===this.options.singleItem)return this.options.items=this.orignalItems=1,this.options.itemsCustom=!1,this.options.itemsDesktop=!1,this.options.itemsDesktopSmall=!1,this.options.itemsTablet=!1,this.options.itemsTabletSmall=
!1,this.options.itemsMobile=!1;a=f(this.options.responsiveBaseWidth).width();a>(this.options.itemsDesktop[0]||this.orignalItems)&&(this.options.items=this.orignalItems);if(!1!==this.options.itemsCustom)for(this.options.itemsCustom.sort(function(a,b){return a[0]-b[0]}),b=0;b<this.options.itemsCustom.length;b+=1)this.options.itemsCustom[b][0]<=a&&(this.options.items=this.options.itemsCustom[b][1]);else a<=this.options.itemsDesktop[0]&&!1!==this.options.itemsDesktop&&(this.options.items=this.options.itemsDesktop[1]),
a<=this.options.itemsDesktopSmall[0]&&!1!==this.options.itemsDesktopSmall&&(this.options.items=this.options.itemsDesktopSmall[1]),a<=this.options.itemsTablet[0]&&!1!==this.options.itemsTablet&&(this.options.items=this.options.itemsTablet[1]),a<=this.options.itemsTabletSmall[0]&&!1!==this.options.itemsTabletSmall&&(this.options.items=this.options.itemsTabletSmall[1]),a<=this.options.itemsMobile[0]&&!1!==this.options.itemsMobile&&(this.options.items=this.options.itemsMobile[1]);this.options.items>this.itemsAmount&&
!0===this.options.itemsScaleUp&&(this.options.items=this.itemsAmount)},response:function(){var a=this,b,e;if(!0!==a.options.responsive)return!1;e=f(g).width();a.resizer=function(){f(g).width()!==e&&(!1!==a.options.autoPlay&&g.clearInterval(a.autoPlayInterval),g.clearTimeout(b),b=g.setTimeout(function(){e=f(g).width();a.updateVars()},a.options.responsiveRefreshRate))};f(g).resize(a.resizer)},updatePosition:function(){this.jumpTo(this.currentItem);!1!==this.options.autoPlay&&this.checkAp()},appendItemsSizes:function(){var a=
this,b=0,e=a.itemsAmount-a.options.items;a.$owlItems.each(function(c){var d=f(this);d.css({width:a.itemWidth}).data("owl-item",Number(c));if(0===c%a.options.items||c===e)c>e||(b+=1);d.data("owl-roundPages",b)})},appendWrapperSizes:function(){this.$owlWrapper.css({width:this.$owlItems.length*this.itemWidth*2,left:0});this.appendItemsSizes()},calculateAll:function(){this.calculateWidth();this.appendWrapperSizes();this.loops();this.max()},calculateWidth:function(){this.itemWidth=Math.round(this.$elem.width()/
this.options.items)},max:function(){var a=-1*(this.itemsAmount*this.itemWidth-this.options.items*this.itemWidth);this.options.items>this.itemsAmount?this.maximumPixels=a=this.maximumItem=0:(this.maximumItem=this.itemsAmount-this.options.items,this.maximumPixels=a);return a},min:function(){return 0},loops:function(){var a=0,b=0,e,c;this.positionsInArray=[0];this.pagesInArray=[];for(e=0;e<this.itemsAmount;e+=1)b+=this.itemWidth,this.positionsInArray.push(-b),!0===this.options.scrollPerPage&&(c=f(this.$owlItems[e]),
c=c.data("owl-roundPages"),c!==a&&(this.pagesInArray[a]=this.positionsInArray[e],a=c))},buildControls:function(){if(!0===this.options.navigation||!0===this.options.pagination)this.owlControls=f('<div class="owl-controls"/>').toggleClass("clickable",!this.browser.isTouch).appendTo(this.$elem);!0===this.options.pagination&&this.buildPagination();!0===this.options.navigation&&this.buildButtons()},buildButtons:function(){var a=this,b=f('<div class="owl-buttons"/>');a.owlControls.append(b);a.buttonPrev=
f("<div/>",{"class":"owl-prev",html:a.options.navigationText[0]||""});a.buttonNext=f("<div/>",{"class":"owl-next",html:a.options.navigationText[1]||""});b.append(a.buttonPrev).append(a.buttonNext);b.on("touchstart.owlControls mousedown.owlControls",'div[class^="owl"]',function(a){a.preventDefault()});b.on("touchend.owlControls mouseup.owlControls",'div[class^="owl"]',function(b){b.preventDefault();f(this).hasClass("owl-next")?a.next():a.prev()})},buildPagination:function(){var a=this;a.paginationWrapper=
f('<div class="owl-pagination"/>');a.owlControls.append(a.paginationWrapper);a.paginationWrapper.on("touchend.owlControls mouseup.owlControls",".owl-page",function(b){b.preventDefault();Number(f(this).data("owl-page"))!==a.currentItem&&a.goTo(Number(f(this).data("owl-page")),!0)})},updatePagination:function(){var a,b,e,c,d,g;if(!1===this.options.pagination)return!1;this.paginationWrapper.html("");a=0;b=this.itemsAmount-this.itemsAmount%this.options.items;for(c=0;c<this.itemsAmount;c+=1)0===c%this.options.items&&
(a+=1,b===c&&(e=this.itemsAmount-this.options.items),d=f("<div/>",{"class":"owl-page"}),g=f("<span></span>",{text:!0===this.options.paginationNumbers?a:"","class":!0===this.options.paginationNumbers?"owl-numbers":""}),d.append(g),d.data("owl-page",b===c?e:c),d.data("owl-roundPages",a),this.paginationWrapper.append(d));this.checkPagination()},checkPagination:function(){var a=this;if(!1===a.options.pagination)return!1;a.paginationWrapper.find(".owl-page").each(function(){f(this).data("owl-roundPages")===
f(a.$owlItems[a.currentItem]).data("owl-roundPages")&&(a.paginationWrapper.find(".owl-page").removeClass("active"),f(this).addClass("active"))})},checkNavigation:function(){if(!1===this.options.navigation)return!1;!1===this.options.rewindNav&&(0===this.currentItem&&0===this.maximumItem?(this.buttonPrev.addClass("disabled"),this.buttonNext.addClass("disabled")):0===this.currentItem&&0!==this.maximumItem?(this.buttonPrev.addClass("disabled"),this.buttonNext.removeClass("disabled")):this.currentItem===
this.maximumItem?(this.buttonPrev.removeClass("disabled"),this.buttonNext.addClass("disabled")):0!==this.currentItem&&this.currentItem!==this.maximumItem&&(this.buttonPrev.removeClass("disabled"),this.buttonNext.removeClass("disabled")))},updateControls:function(){this.updatePagination();this.checkNavigation();this.owlControls&&(this.options.items>=this.itemsAmount?this.owlControls.hide():this.owlControls.show())},destroyControls:function(){this.owlControls&&this.owlControls.remove()},next:function(a){if(this.isTransition)return!1;
this.currentItem+=!0===this.options.scrollPerPage?this.options.items:1;if(this.currentItem>this.maximumItem+(!0===this.options.scrollPerPage?this.options.items-1:0))if(!0===this.options.rewindNav)this.currentItem=0,a="rewind";else return this.currentItem=this.maximumItem,!1;this.goTo(this.currentItem,a)},prev:function(a){if(this.isTransition)return!1;this.currentItem=!0===this.options.scrollPerPage&&0<this.currentItem&&this.currentItem<this.options.items?0:this.currentItem-(!0===this.options.scrollPerPage?
this.options.items:1);if(0>this.currentItem)if(!0===this.options.rewindNav)this.currentItem=this.maximumItem,a="rewind";else return this.currentItem=0,!1;this.goTo(this.currentItem,a)},goTo:function(a,b,e){var c=this;if(c.isTransition)return!1;"function"===typeof c.options.beforeMove&&c.options.beforeMove.apply(this,[c.$elem]);a>=c.maximumItem?a=c.maximumItem:0>=a&&(a=0);c.currentItem=c.owl.currentItem=a;if(!1!==c.options.transitionStyle&&"drag"!==e&&1===c.options.items&&!0===c.browser.support3d)return c.swapSpeed(0),
!0===c.browser.support3d?c.transition3d(c.positionsInArray[a]):c.css2slide(c.positionsInArray[a],1),c.afterGo(),c.singleItemTransition(),!1;a=c.positionsInArray[a];!0===c.browser.support3d?(c.isCss3Finish=!1,!0===b?(c.swapSpeed("paginationSpeed"),g.setTimeout(function(){c.isCss3Finish=!0},c.options.paginationSpeed)):"rewind"===b?(c.swapSpeed(c.options.rewindSpeed),g.setTimeout(function(){c.isCss3Finish=!0},c.options.rewindSpeed)):(c.swapSpeed("slideSpeed"),g.setTimeout(function(){c.isCss3Finish=!0},
c.options.slideSpeed)),c.transition3d(a)):!0===b?c.css2slide(a,c.options.paginationSpeed):"rewind"===b?c.css2slide(a,c.options.rewindSpeed):c.css2slide(a,c.options.slideSpeed);c.afterGo()},jumpTo:function(a){"function"===typeof this.options.beforeMove&&this.options.beforeMove.apply(this,[this.$elem]);a>=this.maximumItem||-1===a?a=this.maximumItem:0>=a&&(a=0);this.swapSpeed(0);!0===this.browser.support3d?this.transition3d(this.positionsInArray[a]):this.css2slide(this.positionsInArray[a],1);this.currentItem=
this.owl.currentItem=a;this.afterGo()},afterGo:function(){this.prevArr.push(this.currentItem);this.prevItem=this.owl.prevItem=this.prevArr[this.prevArr.length-2];this.prevArr.shift(0);this.prevItem!==this.currentItem&&(this.checkPagination(),this.checkNavigation(),this.eachMoveUpdate(),!1!==this.options.autoPlay&&this.checkAp());"function"===typeof this.options.afterMove&&this.prevItem!==this.currentItem&&this.options.afterMove.apply(this,[this.$elem])},stop:function(){this.apStatus="stop";g.clearInterval(this.autoPlayInterval)},
checkAp:function(){"stop"!==this.apStatus&&this.play()},play:function(){var a=this;a.apStatus="play";if(!1===a.options.autoPlay)return!1;g.clearInterval(a.autoPlayInterval);a.autoPlayInterval=g.setInterval(function(){a.next(!0)},a.options.autoPlay)},swapSpeed:function(a){"slideSpeed"===a?this.$owlWrapper.css(this.addCssSpeed(this.options.slideSpeed)):"paginationSpeed"===a?this.$owlWrapper.css(this.addCssSpeed(this.options.paginationSpeed)):"string"!==typeof a&&this.$owlWrapper.css(this.addCssSpeed(a))},
addCssSpeed:function(a){return{"-webkit-transition":"all "+a+"ms ease","-moz-transition":"all "+a+"ms ease","-o-transition":"all "+a+"ms ease",transition:"all "+a+"ms ease"}},removeTransition:function(){return{"-webkit-transition":"","-moz-transition":"","-o-transition":"",transition:""}},doTranslate:function(a){return{"-webkit-transform":"translate3d("+a+"px, 0px, 0px)","-moz-transform":"translate3d("+a+"px, 0px, 0px)","-o-transform":"translate3d("+a+"px, 0px, 0px)","-ms-transform":"translate3d("+
a+"px, 0px, 0px)",transform:"translate3d("+a+"px, 0px,0px)"}},transition3d:function(a){this.$owlWrapper.css(this.doTranslate(a))},css2move:function(a){this.$owlWrapper.css({left:a})},css2slide:function(a,b){var e=this;e.isCssFinish=!1;e.$owlWrapper.stop(!0,!0).animate({left:a},{duration:b||e.options.slideSpeed,complete:function(){e.isCssFinish=!0}})},checkBrowser:function(){var a=k.createElement("div");a.style.cssText="  -moz-transform:translate3d(0px, 0px, 0px); -ms-transform:translate3d(0px, 0px, 0px); -o-transform:translate3d(0px, 0px, 0px); -webkit-transform:translate3d(0px, 0px, 0px); transform:translate3d(0px, 0px, 0px)";
a=a.style.cssText.match(/translate3d\(0px, 0px, 0px\)/g);this.browser={support3d:null!==a&&1===a.length,isTouch:"ontouchstart"in g||g.navigator.msMaxTouchPoints}},moveEvents:function(){if(!1!==this.options.mouseDrag||!1!==this.options.touchDrag)this.gestures(),this.disabledEvents()},eventTypes:function(){var a=["s","e","x"];this.ev_types={};!0===this.options.mouseDrag&&!0===this.options.touchDrag?a=["touchstart.owl mousedown.owl","touchmove.owl mousemove.owl","touchend.owl touchcancel.owl mouseup.owl"]:
!1===this.options.mouseDrag&&!0===this.options.touchDrag?a=["touchstart.owl","touchmove.owl","touchend.owl touchcancel.owl"]:!0===this.options.mouseDrag&&!1===this.options.touchDrag&&(a=["mousedown.owl","mousemove.owl","mouseup.owl"]);this.ev_types.start=a[0];this.ev_types.move=a[1];this.ev_types.end=a[2]},disabledEvents:function(){this.$elem.on("dragstart.owl",function(a){a.preventDefault()});this.$elem.on("mousedown.disableTextSelect",function(a){return f(a.target).is("input, textarea, select, option")})},
gestures:function(){function a(a){if(void 0!==a.touches)return{x:a.touches[0].pageX,y:a.touches[0].pageY};if(void 0===a.touches){if(void 0!==a.pageX)return{x:a.pageX,y:a.pageY};if(void 0===a.pageX)return{x:a.clientX,y:a.clientY}}}function b(a){"on"===a?(f(k).on(d.ev_types.move,e),f(k).on(d.ev_types.end,c)):"off"===a&&(f(k).off(d.ev_types.move),f(k).off(d.ev_types.end))}function e(b){b=b.originalEvent||b||g.event;d.newPosX=a(b).x-h.offsetX;d.newPosY=a(b).y-h.offsetY;d.newRelativeX=d.newPosX-h.relativePos;
"function"===typeof d.options.startDragging&&!0!==h.dragging&&0!==d.newRelativeX&&(h.dragging=!0,d.options.startDragging.apply(d,[d.$elem]));(8<d.newRelativeX||-8>d.newRelativeX)&&!0===d.browser.isTouch&&(void 0!==b.preventDefault?b.preventDefault():b.returnValue=!1,h.sliding=!0);(10<d.newPosY||-10>d.newPosY)&&!1===h.sliding&&f(k).off("touchmove.owl");d.newPosX=Math.max(Math.min(d.newPosX,d.newRelativeX/5),d.maximumPixels+d.newRelativeX/5);!0===d.browser.support3d?d.transition3d(d.newPosX):d.css2move(d.newPosX)}
function c(a){a=a.originalEvent||a||g.event;var c;a.target=a.target||a.srcElement;h.dragging=!1;!0!==d.browser.isTouch&&d.$owlWrapper.removeClass("grabbing");d.dragDirection=0>d.newRelativeX?d.owl.dragDirection="left":d.owl.dragDirection="right";0!==d.newRelativeX&&(c=d.getNewPosition(),d.goTo(c,!1,"drag"),h.targetElement===a.target&&!0!==d.browser.isTouch&&(f(a.target).on("click.disable",function(a){a.stopImmediatePropagation();a.stopPropagation();a.preventDefault();f(a.target).off("click.disable")}),
a=f._data(a.target,"events").click,c=a.pop(),a.splice(0,0,c)));b("off")}var d=this,h={offsetX:0,offsetY:0,baseElWidth:0,relativePos:0,position:null,minSwipe:null,maxSwipe:null,sliding:null,dargging:null,targetElement:null};d.isCssFinish=!0;d.$elem.on(d.ev_types.start,".owl-wrapper",function(c){c=c.originalEvent||c||g.event;var e;if(3===c.which)return!1;if(!(d.itemsAmount<=d.options.items)){if(!1===d.isCssFinish&&!d.options.dragBeforeAnimFinish||!1===d.isCss3Finish&&!d.options.dragBeforeAnimFinish)return!1;
!1!==d.options.autoPlay&&g.clearInterval(d.autoPlayInterval);!0===d.browser.isTouch||d.$owlWrapper.hasClass("grabbing")||d.$owlWrapper.addClass("grabbing");d.newPosX=0;d.newRelativeX=0;f(this).css(d.removeTransition());e=f(this).position();h.relativePos=e.left;h.offsetX=a(c).x-e.left;h.offsetY=a(c).y-e.top;b("on");h.sliding=!1;h.targetElement=c.target||c.srcElement}})},getNewPosition:function(){var a=this.closestItem();a>this.maximumItem?a=this.currentItem=this.maximumItem:0<=this.newPosX&&(this.currentItem=
a=0);return a},closestItem:function(){var a=this,b=!0===a.options.scrollPerPage?a.pagesInArray:a.positionsInArray,e=a.newPosX,c=null;f.each(b,function(d,g){e-a.itemWidth/20>b[d+1]&&e-a.itemWidth/20<g&&"left"===a.moveDirection()?(c=g,a.currentItem=!0===a.options.scrollPerPage?f.inArray(c,a.positionsInArray):d):e+a.itemWidth/20<g&&e+a.itemWidth/20>(b[d+1]||b[d]-a.itemWidth)&&"right"===a.moveDirection()&&(!0===a.options.scrollPerPage?(c=b[d+1]||b[b.length-1],a.currentItem=f.inArray(c,a.positionsInArray)):
(c=b[d+1],a.currentItem=d+1))});return a.currentItem},moveDirection:function(){var a;0>this.newRelativeX?(a="right",this.playDirection="next"):(a="left",this.playDirection="prev");return a},customEvents:function(){var a=this;a.$elem.on("owl.next",function(){a.next()});a.$elem.on("owl.prev",function(){a.prev()});a.$elem.on("owl.play",function(b,e){a.options.autoPlay=e;a.play();a.hoverStatus="play"});a.$elem.on("owl.stop",function(){a.stop();a.hoverStatus="stop"});a.$elem.on("owl.goTo",function(b,e){a.goTo(e)});
a.$elem.on("owl.jumpTo",function(b,e){a.jumpTo(e)})},stopOnHover:function(){var a=this;!0===a.options.stopOnHover&&!0!==a.browser.isTouch&&!1!==a.options.autoPlay&&(a.$elem.on("mouseover",function(){a.stop()}),a.$elem.on("mouseout",function(){"stop"!==a.hoverStatus&&a.play()}))},lazyLoad:function(){var a,b,e,c,d;if(!1===this.options.lazyLoad)return!1;for(a=0;a<this.itemsAmount;a+=1)b=f(this.$owlItems[a]),"loaded"!==b.data("owl-loaded")&&(e=b.data("owl-item"),c=b.find(".lazyOwl"),"string"!==typeof c.data("src")?
b.data("owl-loaded","loaded"):(void 0===b.data("owl-loaded")&&(c.hide(),b.addClass("loading").data("owl-loaded","checked")),(d=!0===this.options.lazyFollow?e>=this.currentItem:!0)&&e<this.currentItem+this.options.items&&c.length&&this.lazyPreload(b,c)))},lazyPreload:function(a,b){function e(){a.data("owl-loaded","loaded").removeClass("loading");b.removeAttr("data-src");"fade"===d.options.lazyEffect?b.fadeIn(400):b.show();"function"===typeof d.options.afterLazyLoad&&d.options.afterLazyLoad.apply(this,
[d.$elem])}function c(){f+=1;d.completeImg(b.get(0))||!0===k?e():100>=f?g.setTimeout(c,100):e()}var d=this,f=0,k;"DIV"===b.prop("tagName")?(b.css("background-image","url("+b.data("src")+")"),k=!0):b[0].src=b.data("src");c()},autoHeight:function(){function a(){var a=f(e.$owlItems[e.currentItem]).height();e.wrapperOuter.css("height",a+"px");e.wrapperOuter.hasClass("autoHeight")||g.setTimeout(function(){e.wrapperOuter.addClass("autoHeight")},0)}function b(){d+=1;e.completeImg(c.get(0))?a():100>=d?g.setTimeout(b,
100):e.wrapperOuter.css("height","")}var e=this,c=f(e.$owlItems[e.currentItem]).find("img"),d;void 0!==c.get(0)?(d=0,b()):a()},completeImg:function(a){return!a.complete||"undefined"!==typeof a.naturalWidth&&0===a.naturalWidth?!1:!0},onVisibleItems:function(){var a;!0===this.options.addClassActive&&this.$owlItems.removeClass("active");this.visibleItems=[];for(a=this.currentItem;a<this.currentItem+this.options.items;a+=1)this.visibleItems.push(a),!0===this.options.addClassActive&&f(this.$owlItems[a]).addClass("active");
this.owl.visibleItems=this.visibleItems},transitionTypes:function(a){this.outClass="owl-"+a+"-out";this.inClass="owl-"+a+"-in"},singleItemTransition:function(){var a=this,b=a.outClass,e=a.inClass,c=a.$owlItems.eq(a.currentItem),d=a.$owlItems.eq(a.prevItem),f=Math.abs(a.positionsInArray[a.currentItem])+a.positionsInArray[a.prevItem],g=Math.abs(a.positionsInArray[a.currentItem])+a.itemWidth/2;a.isTransition=!0;a.$owlWrapper.addClass("owl-origin").css({"-webkit-transform-origin":g+"px","-moz-perspective-origin":g+
"px","perspective-origin":g+"px"});d.css({position:"relative",left:f+"px"}).addClass(b).on("webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend",function(){a.endPrev=!0;d.off("webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend");a.clearTransStyle(d,b)});c.addClass(e).on("webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend",function(){a.endCurrent=!0;c.off("webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend");a.clearTransStyle(c,e)})},clearTransStyle:function(a,
b){a.css({position:"",left:""}).removeClass(b);this.endPrev&&this.endCurrent&&(this.$owlWrapper.removeClass("owl-origin"),this.isTransition=this.endCurrent=this.endPrev=!1)},owlStatus:function(){this.owl={userOptions:this.userOptions,baseElement:this.$elem,userItems:this.$userItems,owlItems:this.$owlItems,currentItem:this.currentItem,prevItem:this.prevItem,visibleItems:this.visibleItems,isTouch:this.browser.isTouch,browser:this.browser,dragDirection:this.dragDirection}},clearEvents:function(){this.$elem.off(".owl owl mousedown.disableTextSelect");
f(k).off(".owl owl");f(g).off("resize",this.resizer)},unWrap:function(){0!==this.$elem.children().length&&(this.$owlWrapper.unwrap(),this.$userItems.unwrap().unwrap(),this.owlControls&&this.owlControls.remove());this.clearEvents();this.$elem.attr("style",this.$elem.data("owl-originalStyles")||"").attr("class",this.$elem.data("owl-originalClasses"))},destroy:function(){this.stop();g.clearInterval(this.checkVisible);this.unWrap();this.$elem.removeData()},reinit:function(a){a=f.extend({},this.userOptions,
a);this.unWrap();this.init(a,this.$elem)},addItem:function(a,b){var e;if(!a)return!1;if(0===this.$elem.children().length)return this.$elem.append(a),this.setVars(),!1;this.unWrap();e=void 0===b||-1===b?-1:b;e>=this.$userItems.length||-1===e?this.$userItems.eq(-1).after(a):this.$userItems.eq(e).before(a);this.setVars()},removeItem:function(a){if(0===this.$elem.children().length)return!1;a=void 0===a||-1===a?-1:a;this.unWrap();this.$userItems.eq(a).remove();this.setVars()}};f.fn.owlCarousel=function(a){return this.each(function(){if(!0===
f(this).data("owl-init"))return!1;f(this).data("owl-init",!0);var b=Object.create(l);b.init(a,this);f.data(this,"owlCarousel",b)})};f.fn.owlCarousel.options={items:5,itemsCustom:!1,itemsDesktop:[1199,4],itemsDesktopSmall:[979,3],itemsTablet:[768,2],itemsTabletSmall:!1,itemsMobile:[479,1],singleItem:!1,itemsScaleUp:!1,slideSpeed:200,paginationSpeed:800,rewindSpeed:1E3,autoPlay:!1,stopOnHover:!1,navigation:!1,navigationText:["prev","next"],rewindNav:!0,scrollPerPage:!1,pagination:!0,paginationNumbers:!1,
responsive:!0,responsiveRefreshRate:200,responsiveBaseWidth:g,baseClass:"owl-carousel",theme:"owl-theme",lazyLoad:!1,lazyFollow:!0,lazyEffect:"fade",autoHeight:!1,jsonPath:!1,jsonSuccess:!1,dragBeforeAnimFinish:!0,mouseDrag:!0,touchDrag:!0,addClassActive:!1,transitionStyle:!1,beforeUpdate:!1,afterUpdate:!1,beforeInit:!1,afterInit:!1,beforeMove:!1,afterMove:!1,afterAction:!1,startDragging:!1,afterLazyLoad:!1}})(jQuery,window,document);
/*! jsTree - v3.0.1 - 2014-06-02 - (MIT) */
(function(e){"use strict";"function"==typeof define&&define.amd?define(["../jquery"],e):"object"==typeof exports?e(require("jquery")):e(jQuery)})(function(e,t){"use strict";if(!e.jstree){var i=0,r=!1,n=!1,s=!1,a=[],d=e("script:last").attr("src"),o=document,l=o.createElement("LI"),c,h;l.setAttribute("role","treeitem"),c=o.createElement("I"),c.className="jstree-icon jstree-ocl",l.appendChild(c),c=o.createElement("A"),c.className="jstree-anchor",c.setAttribute("href","#"),h=o.createElement("I"),h.className="jstree-icon jstree-themeicon",c.appendChild(h),l.appendChild(c),c=h=null,e.jstree={version:"3.0.1",defaults:{plugins:[]},plugins:{},path:d&&-1!==d.indexOf("/")?d.replace(/\/[^\/]+$/,""):"",idregex:/[\\:&!^|()\[\]<>@*'+~#";.,=\- \/$]/g},e.jstree.create=function(t,r){var n=new e.jstree.core(++i),s=r;return r=e.extend(!0,{},e.jstree.defaults,r),s&&s.plugins&&(r.plugins=s.plugins),e.each(r.plugins,function(e,t){"core"!==e&&(n=n.plugin(t,r[t]))}),n.init(t,r),n},e.jstree.core=function(e){this._id=e,this._cnt=0,this._wrk=null,this._data={core:{themes:{name:!1,dots:!1,icons:!1},selected:[],last_error:{}}}},e.jstree.reference=function(i){var r=null,n=null;if(i&&i.id&&(i=i.id),!n||!n.length)try{n=e(i)}catch(s){}if(!n||!n.length)try{n=e("#"+i.replace(e.jstree.idregex,"\\$&"))}catch(s){}return n&&n.length&&(n=n.closest(".jstree")).length&&(n=n.data("jstree"))?r=n:e(".jstree").each(function(){var n=e(this).data("jstree");return n&&n._model.data[i]?(r=n,!1):t}),r},e.fn.jstree=function(i){var r="string"==typeof i,n=Array.prototype.slice.call(arguments,1),s=null;return this.each(function(){var a=e.jstree.reference(this),d=r&&a?a[i]:null;return s=r&&d?d.apply(a,n):null,a||r||i!==t&&!e.isPlainObject(i)||e(this).data("jstree",new e.jstree.create(this,i)),(a&&!r||i===!0)&&(s=a||!1),null!==s&&s!==t?!1:t}),null!==s&&s!==t?s:this},e.expr[":"].jstree=e.expr.createPseudo(function(i){return function(i){return e(i).hasClass("jstree")&&e(i).data("jstree")!==t}}),e.jstree.defaults.core={data:!1,strings:!1,check_callback:!1,error:e.noop,animation:200,multiple:!0,themes:{name:!1,url:!1,dir:!1,dots:!0,icons:!0,stripes:!1,variant:!1,responsive:!0},expand_selected_onload:!0,worker:!0},e.jstree.core.prototype={plugin:function(t,i){var r=e.jstree.plugins[t];return r?(this._data[t]={},r.prototype=this,new r(i,this)):this},init:function(t,i){this._model={data:{"#":{id:"#",parent:null,parents:[],children:[],children_d:[],state:{loaded:!1}}},changed:[],force_full_redraw:!1,redraw_timeout:!1,default_state:{loaded:!0,opened:!1,selected:!1,disabled:!1}},this.element=e(t).addClass("jstree jstree-"+this._id),this.settings=i,this.element.bind("destroyed",e.proxy(this.teardown,this)),this._data.core.ready=!1,this._data.core.loaded=!1,this._data.core.rtl="rtl"===this.element.css("direction"),this.element[this._data.core.rtl?"addClass":"removeClass"]("jstree-rtl"),this.element.attr("role","tree"),this.bind(),this.trigger("init"),this._data.core.original_container_html=this.element.find(" > ul > li").clone(!0),this._data.core.original_container_html.find("li").addBack().contents().filter(function(){return 3===this.nodeType&&(!this.nodeValue||/^\s+$/.test(this.nodeValue))}).remove(),this.element.html("<ul class='jstree-container-ul jstree-children'><li class='jstree-initial-node jstree-loading jstree-leaf jstree-last'><i class='jstree-icon jstree-ocl'></i><a class='jstree-anchor' href='#'><i class='jstree-icon jstree-themeicon-hidden'></i>"+this.get_string("Loading ...")+"</a></li></ul>"),this._data.core.li_height=this.get_container_ul().children("li:eq(0)").height()||24,this.trigger("loading"),this.load_node("#")},destroy:function(e){e||this.element.empty(),this.element.unbind("destroyed",this.teardown),this.teardown()},teardown:function(){this.unbind(),this.element.removeClass("jstree").removeData("jstree").find("[class^='jstree']").addBack().attr("class",function(){return this.className.replace(/jstree[^ ]*|$/gi,"")}),this.element=null},bind:function(){this.element.on("dblclick.jstree",function(){if(document.selection&&document.selection.empty)document.selection.empty();else if(window.getSelection){var e=window.getSelection();try{e.removeAllRanges(),e.collapse()}catch(t){}}}).on("click.jstree",".jstree-ocl",e.proxy(function(e){this.toggle_node(e.target)},this)).on("click.jstree",".jstree-anchor",e.proxy(function(t){t.preventDefault(),e(t.currentTarget).focus(),this.activate_node(t.currentTarget,t)},this)).on("keydown.jstree",".jstree-anchor",e.proxy(function(t){if("INPUT"===t.target.tagName)return!0;var i=null;switch(t.which){case 13:case 32:t.type="click",e(t.currentTarget).trigger(t);break;case 37:t.preventDefault(),this.is_open(t.currentTarget)?this.close_node(t.currentTarget):(i=this.get_prev_dom(t.currentTarget),i&&i.length&&i.children(".jstree-anchor").focus());break;case 38:t.preventDefault(),i=this.get_prev_dom(t.currentTarget),i&&i.length&&i.children(".jstree-anchor").focus();break;case 39:t.preventDefault(),this.is_closed(t.currentTarget)?this.open_node(t.currentTarget,function(e){this.get_node(e,!0).children(".jstree-anchor").focus()}):(i=this.get_next_dom(t.currentTarget),i&&i.length&&i.children(".jstree-anchor").focus());break;case 40:t.preventDefault(),i=this.get_next_dom(t.currentTarget),i&&i.length&&i.children(".jstree-anchor").focus();break;case 46:t.preventDefault(),i=this.get_node(t.currentTarget),i&&i.id&&"#"!==i.id&&(i=this.is_selected(i)?this.get_selected():i);break;case 113:t.preventDefault(),i=this.get_node(t.currentTarget);break;default:}},this)).on("load_node.jstree",e.proxy(function(t,i){if(i.status&&("#"!==i.node.id||this._data.core.loaded||(this._data.core.loaded=!0,this.trigger("loaded")),!this._data.core.ready&&!this.get_container_ul().find(".jstree-loading:eq(0)").length)){if(this._data.core.ready=!0,this._data.core.selected.length){if(this.settings.core.expand_selected_onload){var r=[],n,s;for(n=0,s=this._data.core.selected.length;s>n;n++)r=r.concat(this._model.data[this._data.core.selected[n]].parents);for(r=e.vakata.array_unique(r),n=0,s=r.length;s>n;n++)this.open_node(r[n],!1,0)}this.trigger("changed",{action:"ready",selected:this._data.core.selected})}setTimeout(e.proxy(function(){this.trigger("ready")},this),0)}},this)).on("init.jstree",e.proxy(function(){var e=this.settings.core.themes;this._data.core.themes.dots=e.dots,this._data.core.themes.stripes=e.stripes,this._data.core.themes.icons=e.icons,this.set_theme(e.name||"default",e.url),this.set_theme_variant(e.variant)},this)).on("loading.jstree",e.proxy(function(){this[this._data.core.themes.dots?"show_dots":"hide_dots"](),this[this._data.core.themes.icons?"show_icons":"hide_icons"](),this[this._data.core.themes.stripes?"show_stripes":"hide_stripes"]()},this)).on("focus.jstree",".jstree-anchor",e.proxy(function(t){this.element.find(".jstree-hovered").not(t.currentTarget).mouseleave(),e(t.currentTarget).mouseenter()},this)).on("mouseenter.jstree",".jstree-anchor",e.proxy(function(e){this.hover_node(e.currentTarget)},this)).on("mouseleave.jstree",".jstree-anchor",e.proxy(function(e){this.dehover_node(e.currentTarget)},this))},unbind:function(){this.element.off(".jstree"),e(document).off(".jstree-"+this._id)},trigger:function(e,t){t||(t={}),t.instance=this,this.element.triggerHandler(e.replace(".jstree","")+".jstree",t)},get_container:function(){return this.element},get_container_ul:function(){return this.element.children(".jstree-children:eq(0)")},get_string:function(t){var i=this.settings.core.strings;return e.isFunction(i)?i.call(this,t):i&&i[t]?i[t]:t},_firstChild:function(e){e=e?e.firstChild:null;while(null!==e&&1!==e.nodeType)e=e.nextSibling;return e},_nextSibling:function(e){e=e?e.nextSibling:null;while(null!==e&&1!==e.nodeType)e=e.nextSibling;return e},_previousSibling:function(e){e=e?e.previousSibling:null;while(null!==e&&1!==e.nodeType)e=e.previousSibling;return e},get_node:function(t,i){t&&t.id&&(t=t.id);var r;try{if(this._model.data[t])t=this._model.data[t];else if(((r=e(t,this.element)).length||(r=e("#"+t.replace(e.jstree.idregex,"\\$&"),this.element)).length)&&this._model.data[r.closest(".jstree-node").attr("id")])t=this._model.data[r.closest(".jstree-node").attr("id")];else{if(!(r=e(t,this.element)).length||!r.hasClass("jstree"))return!1;t=this._model.data["#"]}return i&&(t="#"===t.id?this.element:e("#"+t.id.replace(e.jstree.idregex,"\\$&"),this.element)),t}catch(n){return!1}},get_path:function(e,t,i){if(e=e.parents?e:this.get_node(e),!e||"#"===e.id||!e.parents)return!1;var r,n,s=[];for(s.push(i?e.id:e.text),r=0,n=e.parents.length;n>r;r++)s.push(i?e.parents[r]:this.get_text(e.parents[r]));return s=s.reverse().slice(1),t?s.join(t):s},get_next_dom:function(t,i){var r;return t=this.get_node(t,!0),t[0]===this.element[0]?(r=this._firstChild(this.get_container_ul()[0]),r?e(r):!1):t&&t.length?i?(r=this._nextSibling(t[0]),r?e(r):!1):t.hasClass("jstree-open")?(r=this._firstChild(t.children(".jstree-children")[0]),r?e(r):!1):null!==(r=this._nextSibling(t[0]))?e(r):t.parentsUntil(".jstree",".jstree-node").next(".jstree-node").eq(0):!1},get_prev_dom:function(t,i){var r;if(t=this.get_node(t,!0),t[0]===this.element[0])return r=this.get_container_ul()[0].lastChild,r?e(r):!1;if(!t||!t.length)return!1;if(i)return r=this._previousSibling(t[0]),r?e(r):!1;if(null!==(r=this._previousSibling(t[0]))){t=e(r);while(t.hasClass("jstree-open"))t=t.children(".jstree-children:eq(0)").children(".jstree-node:last");return t}return r=t[0].parentNode.parentNode,r&&r.className&&-1!==r.className.indexOf("jstree-node")?e(r):!1},get_parent:function(e){return e=this.get_node(e),e&&"#"!==e.id?e.parent:!1},get_children_dom:function(e){return e=this.get_node(e,!0),e[0]===this.element[0]?this.get_container_ul().children(".jstree-node"):e&&e.length?e.children(".jstree-children").children(".jstree-node"):!1},is_parent:function(e){return e=this.get_node(e),e&&(e.state.loaded===!1||e.children.length>0)},is_loaded:function(e){return e=this.get_node(e),e&&e.state.loaded},is_loading:function(e){return e=this.get_node(e),e&&e.state&&e.state.loading},is_open:function(e){return e=this.get_node(e),e&&e.state.opened},is_closed:function(e){return e=this.get_node(e),e&&this.is_parent(e)&&!e.state.opened},is_leaf:function(e){return!this.is_parent(e)},load_node:function(t,i){var r,n,s,a,d,o,l;if(e.isArray(t)){for(t=t.slice(),r=0,n=t.length;n>r;r++)this.load_node(t[r],i);return!0}if(t=this.get_node(t),!t)return i&&i.call(this,t,!1),!1;if(t.state.loaded){for(t.state.loaded=!1,s=0,a=t.children_d.length;a>s;s++){for(d=0,o=t.parents.length;o>d;d++)this._model.data[t.parents[d]].children_d=e.vakata.array_remove_item(this._model.data[t.parents[d]].children_d,t.children_d[s]);this._model.data[t.children_d[s]].state.selected&&(l=!0,this._data.core.selected=e.vakata.array_remove_item(this._data.core.selected,t.children_d[s])),delete this._model.data[t.children_d[s]]}t.children=[],t.children_d=[],l&&this.trigger("changed",{action:"load_node",node:t,selected:this._data.core.selected})}return t.state.loading=!0,this.get_node(t,!0).addClass("jstree-loading"),this._load_node(t,e.proxy(function(e){t=this._model.data[t.id],t.state.loading=!1,t.state.loaded=e;var r=this.get_node(t,!0);t.state.loaded&&!t.children.length&&r&&r.length&&!r.hasClass("jstree-leaf")&&r.removeClass("jstree-closed jstree-open").addClass("jstree-leaf"),r.removeClass("jstree-loading"),this.trigger("load_node",{node:t,status:e}),i&&i.call(this,t,e)},this)),!0},_load_nodes:function(e,t,i){var r=!0,n=function(){this._load_nodes(e,t,!0)},s=this._model.data,a,d;for(a=0,d=e.length;d>a;a++)!s[e[a]]||s[e[a]].state.loaded&&i||(this.is_loading(e[a])||this.load_node(e[a],n),r=!1);r&&(t.done||(t.call(this,e),t.done=!0))},_load_node:function(t,i){var r=this.settings.core.data,n;return r?e.isFunction(r)?r.call(this,t,e.proxy(function(r){r===!1&&i.call(this,!1),this["string"==typeof r?"_append_html_data":"_append_json_data"](t,"string"==typeof r?e(r):r,function(e){i.call(this,e)})},this)):"object"==typeof r?r.url?(r=e.extend(!0,{},r),e.isFunction(r.url)&&(r.url=r.url.call(this,t)),e.isFunction(r.data)&&(r.data=r.data.call(this,t)),e.ajax(r).done(e.proxy(function(r,n,s){var a=s.getResponseHeader("Content-Type");return-1!==a.indexOf("json")||"object"==typeof r?this._append_json_data(t,r,function(e){i.call(this,e)}):-1!==a.indexOf("html")||"string"==typeof r?this._append_html_data(t,e(r),function(e){i.call(this,e)}):(this._data.core.last_error={error:"ajax",plugin:"core",id:"core_04",reason:"Could not load node",data:JSON.stringify({id:t.id,xhr:s})},this.settings.core.error.call(this,this._data.core.last_error),i.call(this,!1))},this)).fail(e.proxy(function(e){i.call(this,!1),this._data.core.last_error={error:"ajax",plugin:"core",id:"core_04",reason:"Could not load node",data:JSON.stringify({id:t.id,xhr:e})},this.settings.core.error.call(this,this._data.core.last_error)},this))):(n=e.isArray(r)||e.isPlainObject(r)?JSON.parse(JSON.stringify(r)):r,"#"===t.id?this._append_json_data(t,n,function(e){i.call(this,e)}):(this._data.core.last_error={error:"nodata",plugin:"core",id:"core_05",reason:"Could not load node",data:JSON.stringify({id:t.id})},this.settings.core.error.call(this,this._data.core.last_error),i.call(this,!1))):"string"==typeof r?"#"===t.id?this._append_html_data(t,e(r),function(e){i.call(this,e)}):(this._data.core.last_error={error:"nodata",plugin:"core",id:"core_06",reason:"Could not load node",data:JSON.stringify({id:t.id})},this.settings.core.error.call(this,this._data.core.last_error),i.call(this,!1)):i.call(this,!1):"#"===t.id?this._append_html_data(t,this._data.core.original_container_html.clone(!0),function(e){i.call(this,e)}):i.call(this,!1)},_node_changed:function(e){e=this.get_node(e),e&&this._model.changed.push(e.id)},_append_html_data:function(t,i,r){t=this.get_node(t),t.children=[],t.children_d=[];var n=i.is("ul")?i.children():i,s=t.id,a=[],d=[],o=this._model.data,l=o[s],c=this._data.core.selected.length,h,_,u;for(n.each(e.proxy(function(t,i){h=this._parse_model_from_html(e(i),s,l.parents.concat()),h&&(a.push(h),d.push(h),o[h].children_d.length&&(d=d.concat(o[h].children_d)))},this)),l.children=a,l.children_d=d,_=0,u=l.parents.length;u>_;_++)o[l.parents[_]].children_d=o[l.parents[_]].children_d.concat(d);this.trigger("model",{nodes:d,parent:s}),"#"!==s?(this._node_changed(s),this.redraw()):(this.get_container_ul().children(".jstree-initial-node").remove(),this.redraw(!0)),this._data.core.selected.length!==c&&this.trigger("changed",{action:"model",selected:this._data.core.selected}),r.call(this,!0)},_append_json_data:function(t,i,r){t=this.get_node(t),t.children=[],t.children_d=[],i.d&&(i=i.d,"string"==typeof i&&(i=JSON.parse(i))),e.isArray(i)||(i=[i]);var n=null,s={df:this._model.default_state,dat:i,par:t.id,m:this._model.data,t_id:this._id,t_cnt:this._cnt,sel:this._data.core.selected},a=function(e,t){e.data&&(e=e.data);var i=e.dat,r=e.par,n=[],s=[],a=[],d=e.df,o=e.t_id,l=e.t_cnt,c=e.m,h=c[r],_=e.sel,u,g,f,p,m=function(e,i,r){r=r?r.concat():[],i&&r.unshift(i);var n=""+e.id,s,o,l,h,_={id:n,text:e.text||"",icon:e.icon!==t?e.icon:!0,parent:i,parents:r,children:e.children||[],children_d:e.children_d||[],data:e.data,state:{},li_attr:{id:!1},a_attr:{href:"#"},original:!1};for(s in d)d.hasOwnProperty(s)&&(_.state[s]=d[s]);if(e&&e.data&&e.data.jstree&&e.data.jstree.icon&&(_.icon=e.data.jstree.icon),e&&e.data&&(_.data=e.data,e.data.jstree))for(s in e.data.jstree)e.data.jstree.hasOwnProperty(s)&&(_.state[s]=e.data.jstree[s]);if(e&&"object"==typeof e.state)for(s in e.state)e.state.hasOwnProperty(s)&&(_.state[s]=e.state[s]);if(e&&"object"==typeof e.li_attr)for(s in e.li_attr)e.li_attr.hasOwnProperty(s)&&(_.li_attr[s]=e.li_attr[s]);if(_.li_attr.id||(_.li_attr.id=n),e&&"object"==typeof e.a_attr)for(s in e.a_attr)e.a_attr.hasOwnProperty(s)&&(_.a_attr[s]=e.a_attr[s]);for(e&&e.children&&e.children===!0&&(_.state.loaded=!1,_.children=[],_.children_d=[]),c[_.id]=_,s=0,o=_.children.length;o>s;s++)l=m(c[_.children[s]],_.id,r),h=c[l],_.children_d.push(l),h.children_d.length&&(_.children_d=_.children_d.concat(h.children_d));return delete e.data,delete e.children,c[_.id].original=e,_.state.selected&&a.push(_.id),_.id},v=function(e,i,r){r=r?r.concat():[],i&&r.unshift(i);var n=!1,s,h,_,u,g;do n="j"+o+"_"+ ++l;while(c[n]);g={id:!1,text:"string"==typeof e?e:"",icon:"object"==typeof e&&e.icon!==t?e.icon:!0,parent:i,parents:r,children:[],children_d:[],data:null,state:{},li_attr:{id:!1},a_attr:{href:"#"},original:!1};for(s in d)d.hasOwnProperty(s)&&(g.state[s]=d[s]);if(e&&e.id&&(g.id=""+e.id),e&&e.text&&(g.text=e.text),e&&e.data&&e.data.jstree&&e.data.jstree.icon&&(g.icon=e.data.jstree.icon),e&&e.data&&(g.data=e.data,e.data.jstree))for(s in e.data.jstree)e.data.jstree.hasOwnProperty(s)&&(g.state[s]=e.data.jstree[s]);if(e&&"object"==typeof e.state)for(s in e.state)e.state.hasOwnProperty(s)&&(g.state[s]=e.state[s]);if(e&&"object"==typeof e.li_attr)for(s in e.li_attr)e.li_attr.hasOwnProperty(s)&&(g.li_attr[s]=e.li_attr[s]);if(g.li_attr.id&&!g.id&&(g.id=""+g.li_attr.id),g.id||(g.id=n),g.li_attr.id||(g.li_attr.id=g.id),e&&"object"==typeof e.a_attr)for(s in e.a_attr)e.a_attr.hasOwnProperty(s)&&(g.a_attr[s]=e.a_attr[s]);if(e&&e.children&&e.children.length){for(s=0,h=e.children.length;h>s;s++)_=v(e.children[s],g.id,r),u=c[_],g.children.push(_),u.children_d.length&&(g.children_d=g.children_d.concat(u.children_d));g.children_d=g.children_d.concat(g.children)}return e&&e.children&&e.children===!0&&(g.state.loaded=!1,g.children=[],g.children_d=[]),delete e.data,delete e.children,g.original=e,c[g.id]=g,g.state.selected&&a.push(g.id),g.id};if(i.length&&i[0].id!==t&&i[0].parent!==t){for(g=0,f=i.length;f>g;g++)i[g].children||(i[g].children=[]),c[""+i[g].id]=i[g];for(g=0,f=i.length;f>g;g++)c[""+i[g].parent].children.push(""+i[g].id),h.children_d.push(""+i[g].id);for(g=0,f=h.children.length;f>g;g++)u=m(c[h.children[g]],r,h.parents.concat()),s.push(u),c[u].children_d.length&&(s=s.concat(c[u].children_d));p={cnt:l,mod:c,sel:_,par:r,dpc:s,add:a}}else{for(g=0,f=i.length;f>g;g++)u=v(i[g],r,h.parents.concat()),u&&(n.push(u),s.push(u),c[u].children_d.length&&(s=s.concat(c[u].children_d)));for(h.children=n,h.children_d=s,g=0,f=h.parents.length;f>g;g++)c[h.parents[g]].children_d=c[h.parents[g]].children_d.concat(s);p={cnt:l,mod:c,sel:_,par:r,dpc:s,add:a}}return p},d=function(t,i){if(this._cnt=t.cnt,this._model.data=t.mod,i){var n,s,a=t.add,d=t.sel,o=this._data.core.selected.slice(),l=this._model.data;if(d.length!==o.length||e.vakata.array_unique(d.concat(o)).length!==d.length){for(n=0,s=d.length;s>n;n++)-1===e.inArray(d[n],a)&&-1===e.inArray(d[n],o)&&(l[d[n]].state.selected=!1);for(n=0,s=o.length;s>n;n++)-1===e.inArray(o[n],d)&&(l[o[n]].state.selected=!0)}}t.add.length&&(this._data.core.selected=this._data.core.selected.concat(t.add)),this.trigger("model",{nodes:t.dpc,parent:t.par}),"#"!==t.par?(this._node_changed(t.par),this.redraw()):this.redraw(!0),t.add.length&&this.trigger("changed",{action:"model",selected:this._data.core.selected}),r.call(this,!0)};if(this.settings.core.worker&&window.Blob&&window.URL&&window.Worker)try{null===this._wrk&&(this._wrk=window.URL.createObjectURL(new window.Blob(["self.onmessage = "+(""+a).replace(/return ([^;}]+)[\s;}]+$/,"postMessage($1);}")],{type:"text/javascript"}))),n=new window.Worker(this._wrk),n.onmessage=e.proxy(function(e){d.call(this,e.data,!0)},this),n.postMessage(s)}catch(o){d.call(this,a(s),!1)}else d.call(this,a(s),!1)},_parse_model_from_html:function(i,r,n){n=n?[].concat(n):[],r&&n.unshift(r);var s,a,d=this._model.data,o={id:!1,text:!1,icon:!0,parent:r,parents:n,children:[],children_d:[],data:null,state:{},li_attr:{id:!1},a_attr:{href:"#"},original:!1},l,c,h;for(l in this._model.default_state)this._model.default_state.hasOwnProperty(l)&&(o.state[l]=this._model.default_state[l]);if(c=e.vakata.attributes(i,!0),e.each(c,function(i,r){return r=e.trim(r),r.length?(o.li_attr[i]=r,"id"===i&&(o.id=""+r),t):!0}),c=i.children("a").eq(0),c.length&&(c=e.vakata.attributes(c,!0),e.each(c,function(t,i){i=e.trim(i),i.length&&(o.a_attr[t]=i)})),c=i.children("a:eq(0)").length?i.children("a:eq(0)").clone():i.clone(),c.children("ins, i, ul").remove(),c=c.html(),c=e("<div />").html(c),o.text=c.html(),c=i.data(),o.data=c?e.extend(!0,{},c):null,o.state.opened=i.hasClass("jstree-open"),o.state.selected=i.children("a").hasClass("jstree-clicked"),o.state.disabled=i.children("a").hasClass("jstree-disabled"),o.data&&o.data.jstree)for(l in o.data.jstree)o.data.jstree.hasOwnProperty(l)&&(o.state[l]=o.data.jstree[l]);c=i.children("a").children(".jstree-themeicon"),c.length&&(o.icon=c.hasClass("jstree-themeicon-hidden")?!1:c.attr("rel")),o.state.icon&&(o.icon=o.state.icon),c=i.children("ul").children("li");do h="j"+this._id+"_"+ ++this._cnt;while(d[h]);return o.id=o.li_attr.id?""+o.li_attr.id:h,c.length?(c.each(e.proxy(function(t,i){s=this._parse_model_from_html(e(i),o.id,n),a=this._model.data[s],o.children.push(s),a.children_d.length&&(o.children_d=o.children_d.concat(a.children_d))},this)),o.children_d=o.children_d.concat(o.children)):i.hasClass("jstree-closed")&&(o.state.loaded=!1),o.li_attr["class"]&&(o.li_attr["class"]=o.li_attr["class"].replace("jstree-closed","").replace("jstree-open","")),o.a_attr["class"]&&(o.a_attr["class"]=o.a_attr["class"].replace("jstree-clicked","").replace("jstree-disabled","")),d[o.id]=o,o.state.selected&&this._data.core.selected.push(o.id),o.id},_parse_model_from_flat_json:function(e,i,r){r=r?r.concat():[],i&&r.unshift(i);var n=""+e.id,s=this._model.data,a=this._model.default_state,d,o,l,c,h={id:n,text:e.text||"",icon:e.icon!==t?e.icon:!0,parent:i,parents:r,children:e.children||[],children_d:e.children_d||[],data:e.data,state:{},li_attr:{id:!1},a_attr:{href:"#"},original:!1};for(d in a)a.hasOwnProperty(d)&&(h.state[d]=a[d]);if(e&&e.data&&e.data.jstree&&e.data.jstree.icon&&(h.icon=e.data.jstree.icon),e&&e.data&&(h.data=e.data,e.data.jstree))for(d in e.data.jstree)e.data.jstree.hasOwnProperty(d)&&(h.state[d]=e.data.jstree[d]);if(e&&"object"==typeof e.state)for(d in e.state)e.state.hasOwnProperty(d)&&(h.state[d]=e.state[d]);if(e&&"object"==typeof e.li_attr)for(d in e.li_attr)e.li_attr.hasOwnProperty(d)&&(h.li_attr[d]=e.li_attr[d]);if(h.li_attr.id||(h.li_attr.id=n),e&&"object"==typeof e.a_attr)for(d in e.a_attr)e.a_attr.hasOwnProperty(d)&&(h.a_attr[d]=e.a_attr[d]);for(e&&e.children&&e.children===!0&&(h.state.loaded=!1,h.children=[],h.children_d=[]),s[h.id]=h,d=0,o=h.children.length;o>d;d++)l=this._parse_model_from_flat_json(s[h.children[d]],h.id,r),c=s[l],h.children_d.push(l),c.children_d.length&&(h.children_d=h.children_d.concat(c.children_d));return delete e.data,delete e.children,s[h.id].original=e,h.state.selected&&this._data.core.selected.push(h.id),h.id},_parse_model_from_json:function(e,i,r){r=r?r.concat():[],i&&r.unshift(i);var n=!1,s,a,d,o,l=this._model.data,c=this._model.default_state,h;do n="j"+this._id+"_"+ ++this._cnt;while(l[n]);h={id:!1,text:"string"==typeof e?e:"",icon:"object"==typeof e&&e.icon!==t?e.icon:!0,parent:i,parents:r,children:[],children_d:[],data:null,state:{},li_attr:{id:!1},a_attr:{href:"#"},original:!1};for(s in c)c.hasOwnProperty(s)&&(h.state[s]=c[s]);if(e&&e.id&&(h.id=""+e.id),e&&e.text&&(h.text=e.text),e&&e.data&&e.data.jstree&&e.data.jstree.icon&&(h.icon=e.data.jstree.icon),e&&e.data&&(h.data=e.data,e.data.jstree))for(s in e.data.jstree)e.data.jstree.hasOwnProperty(s)&&(h.state[s]=e.data.jstree[s]);if(e&&"object"==typeof e.state)for(s in e.state)e.state.hasOwnProperty(s)&&(h.state[s]=e.state[s]);if(e&&"object"==typeof e.li_attr)for(s in e.li_attr)e.li_attr.hasOwnProperty(s)&&(h.li_attr[s]=e.li_attr[s]);if(h.li_attr.id&&!h.id&&(h.id=""+h.li_attr.id),h.id||(h.id=n),h.li_attr.id||(h.li_attr.id=h.id),e&&"object"==typeof e.a_attr)for(s in e.a_attr)e.a_attr.hasOwnProperty(s)&&(h.a_attr[s]=e.a_attr[s]);if(e&&e.children&&e.children.length){for(s=0,a=e.children.length;a>s;s++)d=this._parse_model_from_json(e.children[s],h.id,r),o=l[d],h.children.push(d),o.children_d.length&&(h.children_d=h.children_d.concat(o.children_d));h.children_d=h.children_d.concat(h.children)}return e&&e.children&&e.children===!0&&(h.state.loaded=!1,h.children=[],h.children_d=[]),delete e.data,delete e.children,h.original=e,l[h.id]=h,h.state.selected&&this._data.core.selected.push(h.id),h.id},_redraw:function(){var e=this._model.force_full_redraw?this._model.data["#"].children.concat([]):this._model.changed.concat([]),t=document.createElement("UL"),i,r,n;for(r=0,n=e.length;n>r;r++)i=this.redraw_node(e[r],!0,this._model.force_full_redraw),i&&this._model.force_full_redraw&&t.appendChild(i);this._model.force_full_redraw&&(t.className=this.get_container_ul()[0].className,this.element.empty().append(t)),this._model.force_full_redraw=!1,this._model.changed=[],this.trigger("redraw",{nodes:e})},redraw:function(e){e&&(this._model.force_full_redraw=!0),this._redraw()},redraw_node:function(t,i,r){var n=this.get_node(t),s=!1,a=!1,d=!1,o=!1,c=!1,h=!1,_="",u=document,g=this._model.data,f=!1,p=!1,m=null;if(!n)return!1;if("#"===n.id)return this.redraw(!0);if(i=i||0===n.children.length,t=document.querySelector?this.element[0].querySelector("#"+(-1!=="0123456789".indexOf(n.id[0])?"\\3"+n.id[0]+" "+n.id.substr(1).replace(e.jstree.idregex,"\\$&"):n.id.replace(e.jstree.idregex,"\\$&"))):document.getElementById(n.id))t=e(t),r||(s=t.parent().parent()[0],s===this.element[0]&&(s=null),a=t.index()),i||!n.children.length||t.children(".jstree-children").length||(i=!0),i||(d=t.children(".jstree-children")[0]),p=t.attr("aria-selected"),f=t.children(".jstree-anchor")[0]===document.activeElement,t.remove();else if(i=!0,!r){if(s="#"!==n.parent?e("#"+n.parent.replace(e.jstree.idregex,"\\$&"),this.element)[0]:null,!(null===s||s&&g[n.parent].state.opened))return!1;a=e.inArray(n.id,null===s?g["#"].children:g[n.parent].children)}t=l.cloneNode(!0),_="jstree-node ";for(o in n.li_attr)if(n.li_attr.hasOwnProperty(o)){if("id"===o)continue;"class"!==o?t.setAttribute(o,n.li_attr[o]):_+=n.li_attr[o]}p&&"false"!==p&&t.setAttribute("aria-selected",!0),n.state.loaded&&!n.children.length?_+=" jstree-leaf":(_+=n.state.opened&&n.state.loaded?" jstree-open":" jstree-closed",t.setAttribute("aria-expanded",n.state.opened&&n.state.loaded)),null!==n.parent&&g[n.parent].children[g[n.parent].children.length-1]===n.id&&(_+=" jstree-last"),t.id=n.id,t.className=_,_=(n.state.selected?" jstree-clicked":"")+(n.state.disabled?" jstree-disabled":"");for(c in n.a_attr)if(n.a_attr.hasOwnProperty(c)){if("href"===c&&"#"===n.a_attr[c])continue;"class"!==c?t.childNodes[1].setAttribute(c,n.a_attr[c]):_+=" "+n.a_attr[c]}if(_.length&&(t.childNodes[1].className="jstree-anchor "+_),(n.icon&&n.icon!==!0||n.icon===!1)&&(n.icon===!1?t.childNodes[1].childNodes[0].className+=" jstree-themeicon-hidden":-1===n.icon.indexOf("/")&&-1===n.icon.indexOf(".")?t.childNodes[1].childNodes[0].className+=" "+n.icon+" jstree-themeicon-custom":(t.childNodes[1].childNodes[0].style.backgroundImage="url("+n.icon+")",t.childNodes[1].childNodes[0].style.backgroundPosition="center center",t.childNodes[1].childNodes[0].style.backgroundSize="auto",t.childNodes[1].childNodes[0].className+=" jstree-themeicon-custom")),t.childNodes[1].innerHTML+=n.text,i&&n.children.length&&n.state.opened&&n.state.loaded){for(h=u.createElement("UL"),h.setAttribute("role","group"),h.className="jstree-children",o=0,c=n.children.length;c>o;o++)h.appendChild(this.redraw_node(n.children[o],i,!0));t.appendChild(h)}if(d&&t.appendChild(d),!r){for(s||(s=this.element[0]),o=0,c=s.childNodes.length;c>o;o++)if(s.childNodes[o]&&s.childNodes[o].className&&-1!==s.childNodes[o].className.indexOf("jstree-children")){m=s.childNodes[o];break}m||(m=u.createElement("UL"),m.setAttribute("role","group"),m.className="jstree-children",s.appendChild(m)),s=m,s.childNodes.length>a?s.insertBefore(t,s.childNodes[a]):s.appendChild(t),f&&t.childNodes[1].focus()}return n.state.opened&&!n.state.loaded&&(n.state.opened=!1,setTimeout(e.proxy(function(){this.open_node(n.id,!1,0)},this),0)),t},open_node:function(i,r,n){var s,a,d,o;if(e.isArray(i)){for(i=i.slice(),s=0,a=i.length;a>s;s++)this.open_node(i[s],r,n);return!0}if(i=this.get_node(i),!i||"#"===i.id)return!1;if(n=n===t?this.settings.core.animation:n,!this.is_closed(i))return r&&r.call(this,i,!1),!1;if(this.is_loaded(i))d=this.get_node(i,!0),o=this,d.length&&(i.children.length&&!this._firstChild(d.children(".jstree-children")[0])&&(i.state.opened=!0,this.redraw_node(i,!0),d=this.get_node(i,!0)),n?(this.trigger("before_open",{node:i}),d.children(".jstree-children").css("display","none").end().removeClass("jstree-closed").addClass("jstree-open").attr("aria-expanded",!0).children(".jstree-children").stop(!0,!0).slideDown(n,function(){this.style.display="",o.trigger("after_open",{node:i})})):(this.trigger("before_open",{node:i}),d[0].className=d[0].className.replace("jstree-closed","jstree-open"),d[0].setAttribute("aria-expanded",!0))),i.state.opened=!0,r&&r.call(this,i,!0),d.length||this.trigger("before_open",{node:i}),this.trigger("open_node",{node:i}),n&&d.length||this.trigger("after_open",{node:i});else{if(this.is_loading(i))return setTimeout(e.proxy(function(){this.open_node(i,r,n)},this),500);this.load_node(i,function(e,t){return t?this.open_node(e,r,n):r?r.call(this,e,!1):!1})}},_open_to:function(t){if(t=this.get_node(t),!t||"#"===t.id)return!1;var i,r,n=t.parents;for(i=0,r=n.length;r>i;i+=1)"#"!==i&&this.open_node(n[i],!1,0);return e("#"+t.id.replace(e.jstree.idregex,"\\$&"),this.element)},close_node:function(i,r){var n,s,a,d;if(e.isArray(i)){for(i=i.slice(),n=0,s=i.length;s>n;n++)this.close_node(i[n],r);return!0}return i=this.get_node(i),i&&"#"!==i.id?this.is_closed(i)?!1:(r=r===t?this.settings.core.animation:r,a=this,d=this.get_node(i,!0),d.length&&(r?d.children(".jstree-children").attr("style","display:block !important").end().removeClass("jstree-open").addClass("jstree-closed").attr("aria-expanded",!1).children(".jstree-children").stop(!0,!0).slideUp(r,function(){this.style.display="",d.children(".jstree-children").remove(),a.trigger("after_close",{node:i})}):(d[0].className=d[0].className.replace("jstree-open","jstree-closed"),d.attr("aria-expanded",!1).children(".jstree-children").remove())),i.state.opened=!1,this.trigger("close_node",{node:i}),r&&d.length||this.trigger("after_close",{node:i}),t):!1},toggle_node:function(i){var r,n;if(e.isArray(i)){for(i=i.slice(),r=0,n=i.length;n>r;r++)this.toggle_node(i[r]);return!0}return this.is_closed(i)?this.open_node(i):this.is_open(i)?this.close_node(i):t},open_all:function(e,t,i){if(e||(e="#"),e=this.get_node(e),!e)return!1;var r="#"===e.id?this.get_container_ul():this.get_node(e,!0),n,s,a;if(!r.length){for(n=0,s=e.children_d.length;s>n;n++)this.is_closed(this._model.data[e.children_d[n]])&&(this._model.data[e.children_d[n]].state.opened=!0);return this.trigger("open_all",{node:e})}i=i||r,a=this,r=this.is_closed(e)?r.find(".jstree-closed").addBack():r.find(".jstree-closed"),r.each(function(){a.open_node(this,function(e,r){r&&this.is_parent(e)&&this.open_all(e,t,i)},t||0)}),0===i.find(".jstree-closed").length&&this.trigger("open_all",{node:this.get_node(i)})},close_all:function(t,i){if(t||(t="#"),t=this.get_node(t),!t)return!1;var r="#"===t.id?this.get_container_ul():this.get_node(t,!0),n=this,s,a;if(!r.length){for(s=0,a=t.children_d.length;a>s;s++)this._model.data[t.children_d[s]].state.opened=!1;return this.trigger("close_all",{node:t})}r=this.is_open(t)?r.find(".jstree-open").addBack():r.find(".jstree-open"),e(r.get().reverse()).each(function(){n.close_node(this,i||0)}),this.trigger("close_all",{node:t})},is_disabled:function(e){return e=this.get_node(e),e&&e.state&&e.state.disabled},enable_node:function(i){var r,n;if(e.isArray(i)){for(i=i.slice(),r=0,n=i.length;n>r;r++)this.enable_node(i[r]);return!0}return i=this.get_node(i),i&&"#"!==i.id?(i.state.disabled=!1,this.get_node(i,!0).children(".jstree-anchor").removeClass("jstree-disabled"),this.trigger("enable_node",{node:i}),t):!1},disable_node:function(i){var r,n;
if(e.isArray(i)){for(i=i.slice(),r=0,n=i.length;n>r;r++)this.disable_node(i[r]);return!0}return i=this.get_node(i),i&&"#"!==i.id?(i.state.disabled=!0,this.get_node(i,!0).children(".jstree-anchor").addClass("jstree-disabled"),this.trigger("disable_node",{node:i}),t):!1},activate_node:function(e,i){if(this.is_disabled(e))return!1;if(this._data.core.last_clicked=this._data.core.last_clicked&&this._data.core.last_clicked.id!==t?this.get_node(this._data.core.last_clicked.id):null,this._data.core.last_clicked&&!this._data.core.last_clicked.state.selected&&(this._data.core.last_clicked=null),!this._data.core.last_clicked&&this._data.core.selected.length&&(this._data.core.last_clicked=this.get_node(this._data.core.selected[this._data.core.selected.length-1])),this.settings.core.multiple&&(i.metaKey||i.ctrlKey||i.shiftKey)&&(!i.shiftKey||this._data.core.last_clicked&&this.get_parent(e)&&this.get_parent(e)===this._data.core.last_clicked.parent))if(i.shiftKey){var r=this.get_node(e).id,n=this._data.core.last_clicked.id,s=this.get_node(this._data.core.last_clicked.parent).children,a=!1,d,o;for(d=0,o=s.length;o>d;d+=1)s[d]===r&&(a=!a),s[d]===n&&(a=!a),a||s[d]===r||s[d]===n?this.select_node(s[d],!1,!1,i):this.deselect_node(s[d],!1,!1,i)}else this.is_selected(e)?this.deselect_node(e,!1,!1,i):this.select_node(e,!1,!1,i);else!this.settings.core.multiple&&(i.metaKey||i.ctrlKey||i.shiftKey)&&this.is_selected(e)?this.deselect_node(e,!1,!1,i):(this.deselect_all(!0),this.select_node(e,!1,!1,i),this._data.core.last_clicked=this.get_node(e));this.trigger("activate_node",{node:this.get_node(e)})},hover_node:function(e){if(e=this.get_node(e,!0),!e||!e.length||e.children(".jstree-hovered").length)return!1;var t=this.element.find(".jstree-hovered"),i=this.element;t&&t.length&&this.dehover_node(t),e.children(".jstree-anchor").addClass("jstree-hovered"),this.trigger("hover_node",{node:this.get_node(e)}),setTimeout(function(){i.attr("aria-activedescendant",e[0].id),e.attr("aria-selected",!0)},0)},dehover_node:function(e){return e=this.get_node(e,!0),e&&e.length&&e.children(".jstree-hovered").length?(e.attr("aria-selected",!1).children(".jstree-anchor").removeClass("jstree-hovered"),this.trigger("dehover_node",{node:this.get_node(e)}),t):!1},select_node:function(i,r,n,s){var a,d,o,l;if(e.isArray(i)){for(i=i.slice(),d=0,o=i.length;o>d;d++)this.select_node(i[d],r,n,s);return!0}return i=this.get_node(i),i&&"#"!==i.id?(a=this.get_node(i,!0),i.state.selected||(i.state.selected=!0,this._data.core.selected.push(i.id),n||(a=this._open_to(i)),a&&a.length&&a.children(".jstree-anchor").addClass("jstree-clicked"),this.trigger("select_node",{node:i,selected:this._data.core.selected,event:s}),r||this.trigger("changed",{action:"select_node",node:i,selected:this._data.core.selected,event:s})),t):!1},deselect_node:function(i,r,n){var s,a,d;if(e.isArray(i)){for(i=i.slice(),s=0,a=i.length;a>s;s++)this.deselect_node(i[s],r,n);return!0}return i=this.get_node(i),i&&"#"!==i.id?(d=this.get_node(i,!0),i.state.selected&&(i.state.selected=!1,this._data.core.selected=e.vakata.array_remove_item(this._data.core.selected,i.id),d.length&&d.children(".jstree-anchor").removeClass("jstree-clicked"),this.trigger("deselect_node",{node:i,selected:this._data.core.selected,event:n}),r||this.trigger("changed",{action:"deselect_node",node:i,selected:this._data.core.selected,event:n})),t):!1},select_all:function(e){var t=this._data.core.selected.concat([]),i,r;for(this._data.core.selected=this._model.data["#"].children_d.concat(),i=0,r=this._data.core.selected.length;r>i;i++)this._model.data[this._data.core.selected[i]]&&(this._model.data[this._data.core.selected[i]].state.selected=!0);this.redraw(!0),this.trigger("select_all",{selected:this._data.core.selected}),e||this.trigger("changed",{action:"select_all",selected:this._data.core.selected,old_selection:t})},deselect_all:function(e){var t=this._data.core.selected.concat([]),i,r;for(i=0,r=this._data.core.selected.length;r>i;i++)this._model.data[this._data.core.selected[i]]&&(this._model.data[this._data.core.selected[i]].state.selected=!1);this._data.core.selected=[],this.element.find(".jstree-clicked").removeClass("jstree-clicked"),this.trigger("deselect_all",{selected:this._data.core.selected,node:t}),e||this.trigger("changed",{action:"deselect_all",selected:this._data.core.selected,old_selection:t})},is_selected:function(e){return e=this.get_node(e),e&&"#"!==e.id?e.state.selected:!1},get_selected:function(t){return t?e.map(this._data.core.selected,e.proxy(function(e){return this.get_node(e)},this)):this._data.core.selected},get_top_selected:function(t){var i=this.get_selected(!0),r={},n,s,a,d;for(n=0,s=i.length;s>n;n++)r[i[n].id]=i[n];for(n=0,s=i.length;s>n;n++)for(a=0,d=i[n].children_d.length;d>a;a++)r[i[n].children_d[a]]&&delete r[i[n].children_d[a]];i=[];for(n in r)r.hasOwnProperty(n)&&i.push(n);return t?e.map(i,e.proxy(function(e){return this.get_node(e)},this)):i},get_bottom_selected:function(t){var i=this.get_selected(!0),r=[],n,s;for(n=0,s=i.length;s>n;n++)i[n].children.length||r.push(i[n].id);return t?e.map(r,e.proxy(function(e){return this.get_node(e)},this)):r},get_state:function(){var e={core:{open:[],scroll:{left:this.element.scrollLeft(),top:this.element.scrollTop()},selected:[]}},t;for(t in this._model.data)this._model.data.hasOwnProperty(t)&&"#"!==t&&(this._model.data[t].state.opened&&e.core.open.push(t),this._model.data[t].state.selected&&e.core.selected.push(t));return e},set_state:function(i,r){if(i){if(i.core){var n,s,a,d;if(i.core.open)return e.isArray(i.core.open)?(n=!0,s=!1,a=this,e.each(i.core.open.concat([]),function(t,d){s=a.get_node(d),s&&(a.is_loaded(d)?(a.is_closed(d)&&a.open_node(d,!1,0),i&&i.core&&i.core.open&&e.vakata.array_remove_item(i.core.open,d)):(a.is_loading(d)||a.open_node(d,e.proxy(function(t,n){!n&&i&&i.core&&i.core.open&&e.vakata.array_remove_item(i.core.open,t.id),this.set_state(i,r)},a),0),n=!1))}),n&&(delete i.core.open,this.set_state(i,r)),!1):(delete i.core.open,this.set_state(i,r),!1);if(i.core.scroll)return i.core.scroll&&i.core.scroll.left!==t&&this.element.scrollLeft(i.core.scroll.left),i.core.scroll&&i.core.scroll.top!==t&&this.element.scrollTop(i.core.scroll.top),delete i.core.scroll,this.set_state(i,r),!1;if(i.core.selected)return d=this,this.deselect_all(),e.each(i.core.selected,function(e,t){d.select_node(t)}),delete i.core.selected,this.set_state(i,r),!1;if(e.isEmptyObject(i.core))return delete i.core,this.set_state(i,r),!1}return e.isEmptyObject(i)?(i=null,r&&r.call(this),this.trigger("set_state"),!1):!0}return!1},refresh:function(t){this._data.core.state=this.get_state(),this._cnt=0,this._model.data={"#":{id:"#",parent:null,parents:[],children:[],children_d:[],state:{loaded:!1}}};var i=this.get_container_ul()[0].className;t||this.element.html("<ul class='"+i+"'><"+"li class='jstree-initial-node jstree-loading jstree-leaf jstree-last'><i class='jstree-icon jstree-ocl'></i><"+"a class='jstree-anchor' href='#'><i class='jstree-icon jstree-themeicon-hidden'></i>"+this.get_string("Loading ...")+"</a></li></ul>"),this.load_node("#",function(t,r){r&&(this.get_container_ul()[0].className=i,this.set_state(e.extend(!0,{},this._data.core.state),function(){this.trigger("refresh")})),this._data.core.state=null})},refresh_node:function(t){if(t=this.get_node(t),!t||"#"===t.id)return!1;var i=[],r=this._data.core.selected.concat([]);t.state.opened===!0&&i.push(t.id),this.get_node(t,!0).find(".jstree-open").each(function(){i.push(this.id)}),this._load_nodes(i,e.proxy(function(e){this.open_node(e,!1,0),this.select_node(this._data.core.selected),this.trigger("refresh_node",{node:t,nodes:e})},this))},set_id:function(t,i){if(t=this.get_node(t),!t||"#"===t.id)return!1;var r,n,s=this._model.data;for(i=""+i,s[t.parent].children[e.inArray(t.id,s[t.parent].children)]=i,r=0,n=t.parents.length;n>r;r++)s[t.parents[r]].children_d[e.inArray(t.id,s[t.parents[r]].children_d)]=i;for(r=0,n=t.children.length;n>r;r++)s[t.children[r]].parent=i;for(r=0,n=t.children_d.length;n>r;r++)s[t.children_d[r]].parents[e.inArray(t.id,s[t.children_d[r]].parents)]=i;return r=e.inArray(t.id,this._data.core.selected),-1!==r&&(this._data.core.selected[r]=i),r=this.get_node(t.id,!0),r&&r.attr("id",i),delete s[t.id],t.id=i,s[i]=t,!0},get_text:function(e){return e=this.get_node(e),e&&"#"!==e.id?e.text:!1},set_text:function(t,i){var r,n,s,a;if(e.isArray(t)){for(t=t.slice(),r=0,n=t.length;n>r;r++)this.set_text(t[r],i);return!0}return t=this.get_node(t),t&&"#"!==t.id?(t.text=i,s=this.get_node(t,!0),s.length&&(s=s.children(".jstree-anchor:eq(0)"),a=s.children("I").clone(),s.html(i).prepend(a),this.trigger("set_text",{obj:t,text:i})),!0):!1},get_json:function(e,t,i){if(e=this.get_node(e||"#"),!e)return!1;t&&t.flat&&!i&&(i=[]);var r={id:e.id,text:e.text,icon:this.get_icon(e),li_attr:e.li_attr,a_attr:e.a_attr,state:{},data:t&&t.no_data?!1:e.data},n,s;if(t&&t.flat?r.parent=e.parent:r.children=[],!t||!t.no_state)for(n in e.state)e.state.hasOwnProperty(n)&&(r.state[n]=e.state[n]);if(t&&t.no_id&&(delete r.id,r.li_attr&&r.li_attr.id&&delete r.li_attr.id),t&&t.flat&&"#"!==e.id&&i.push(r),!t||!t.no_children)for(n=0,s=e.children.length;s>n;n++)t&&t.flat?this.get_json(e.children[n],t,i):r.children.push(this.get_json(e.children[n],t));return t&&t.flat?i:"#"===e.id?r.children:r},create_node:function(i,r,n,s,a){if(null===i&&(i="#"),i=this.get_node(i),!i)return!1;if(n=n===t?"last":n,!(""+n).match(/^(before|after)$/)&&!a&&!this.is_loaded(i))return this.load_node(i,function(){this.create_node(i,r,n,s,!0)});r||(r={text:this.get_string("New node")}),r.text===t&&(r.text=this.get_string("New node"));var d,o,l,c;switch("#"===i.id&&("before"===n&&(n="first"),"after"===n&&(n="last")),n){case"before":d=this.get_node(i.parent),n=e.inArray(i.id,d.children),i=d;break;case"after":d=this.get_node(i.parent),n=e.inArray(i.id,d.children)+1,i=d;break;case"inside":case"first":n=0;break;case"last":n=i.children.length;break;default:n||(n=0)}if(n>i.children.length&&(n=i.children.length),r.id||(r.id=!0),!this.check("create_node",r,i,n))return this.settings.core.error.call(this,this._data.core.last_error),!1;if(r.id===!0&&delete r.id,r=this._parse_model_from_json(r,i.id,i.parents.concat()),!r)return!1;for(d=this.get_node(r),o=[],o.push(r),o=o.concat(d.children_d),this.trigger("model",{nodes:o,parent:i.id}),i.children_d=i.children_d.concat(o),l=0,c=i.parents.length;c>l;l++)this._model.data[i.parents[l]].children_d=this._model.data[i.parents[l]].children_d.concat(o);for(r=d,d=[],l=0,c=i.children.length;c>l;l++)d[l>=n?l+1:l]=i.children[l];return d[n]=r.id,i.children=d,this.redraw_node(i,!0),s&&s.call(this,this.get_node(r)),this.trigger("create_node",{node:this.get_node(r),parent:i.id,position:n}),r.id},rename_node:function(t,i){var r,n,s;if(e.isArray(t)){for(t=t.slice(),r=0,n=t.length;n>r;r++)this.rename_node(t[r],i);return!0}return t=this.get_node(t),t&&"#"!==t.id?(s=t.text,this.check("rename_node",t,this.get_parent(t),i)?(this.set_text(t,i),this.trigger("rename_node",{node:t,text:i,old:s}),!0):(this.settings.core.error.call(this,this._data.core.last_error),!1)):!1},delete_node:function(t){var i,r,n,s,a,d,o,l,c,h;if(e.isArray(t)){for(t=t.slice(),i=0,r=t.length;r>i;i++)this.delete_node(t[i]);return!0}if(t=this.get_node(t),!t||"#"===t.id)return!1;if(n=this.get_node(t.parent),s=e.inArray(t.id,n.children),h=!1,!this.check("delete_node",t,n,s))return this.settings.core.error.call(this,this._data.core.last_error),!1;for(-1!==s&&(n.children=e.vakata.array_remove(n.children,s)),a=t.children_d.concat([]),a.push(t.id),l=0,c=a.length;c>l;l++){for(d=0,o=t.parents.length;o>d;d++)s=e.inArray(a[l],this._model.data[t.parents[d]].children_d),-1!==s&&(this._model.data[t.parents[d]].children_d=e.vakata.array_remove(this._model.data[t.parents[d]].children_d,s));this._model.data[a[l]].state.selected&&(h=!0,s=e.inArray(a[l],this._data.core.selected),-1!==s&&(this._data.core.selected=e.vakata.array_remove(this._data.core.selected,s)))}for(this.trigger("delete_node",{node:t,parent:n.id}),h&&this.trigger("changed",{action:"delete_node",node:t,selected:this._data.core.selected,parent:n.id}),l=0,c=a.length;c>l;l++)delete this._model.data[a[l]];return this.redraw_node(n,!0),!0},check:function(t,i,r,n,s){i=i&&i.id?i:this.get_node(i),r=r&&r.id?r:this.get_node(r);var a=t.match(/^move_node|copy_node|create_node$/i)?r:i,d=this.settings.core.check_callback;return"move_node"!==t&&"copy_node"!==t||s&&s.is_multi||i.id!==r.id&&e.inArray(i.id,r.children)!==n&&-1===e.inArray(r.id,i.children_d)?(a&&a.data&&(a=a.data),a&&a.functions&&(a.functions[t]===!1||a.functions[t]===!0)?(a.functions[t]===!1&&(this._data.core.last_error={error:"check",plugin:"core",id:"core_02",reason:"Node data prevents function: "+t,data:JSON.stringify({chk:t,pos:n,obj:i&&i.id?i.id:!1,par:r&&r.id?r.id:!1})}),a.functions[t]):d===!1||e.isFunction(d)&&d.call(this,t,i,r,n,s)===!1||d&&d[t]===!1?(this._data.core.last_error={error:"check",plugin:"core",id:"core_03",reason:"User config for core.check_callback prevents function: "+t,data:JSON.stringify({chk:t,pos:n,obj:i&&i.id?i.id:!1,par:r&&r.id?r.id:!1})},!1):!0):(this._data.core.last_error={error:"check",plugin:"core",id:"core_01",reason:"Moving parent inside child",data:JSON.stringify({chk:t,pos:n,obj:i&&i.id?i.id:!1,par:r&&r.id?r.id:!1})},!1)},last_error:function(){return this._data.core.last_error},move_node:function(i,r,n,s,a){var d,o,l,c,h,_,u,g,f,p,m,v,j,y;if(e.isArray(i)){for(i=i.reverse().slice(),d=0,o=i.length;o>d;d++)this.move_node(i[d],r,n,s,a);return!0}if(i=i&&i.id?i:this.get_node(i),r=this.get_node(r),n=n===t?0:n,!r||!i||"#"===i.id)return!1;if(!(""+n).match(/^(before|after)$/)&&!a&&!this.is_loaded(r))return this.load_node(r,function(){this.move_node(i,r,n,s,!0)});if(l=""+(i.parent||"#"),h=(""+n).match(/^(before|after)$/)&&"#"!==r.id?this.get_node(r.parent):r,_=i.instance?i.instance:this._model.data[i.id]?this:e.jstree.reference(i.id),u=!_||!_._id||this._id!==_._id,c=_&&_._id&&l&&_._model.data[l]&&_._model.data[l].children?e.inArray(i.id,_._model.data[l].children):-1,u)return this.copy_node(i,r,n,s,a)?(_&&_.delete_node(i),!0):!1;switch("#"===h.id&&("before"===n&&(n="first"),"after"===n&&(n="last")),n){case"before":n=e.inArray(r.id,h.children);break;case"after":n=e.inArray(r.id,h.children)+1;break;case"inside":case"first":n=0;break;case"last":n=h.children.length;break;default:n||(n=0)}if(n>h.children.length&&(n=h.children.length),!this.check("move_node",i,h,n,{core:!0,is_multi:_&&_._id&&_._id!==this._id,is_foreign:!_||!_._id}))return this.settings.core.error.call(this,this._data.core.last_error),!1;if(i.parent===h.id){for(g=h.children.concat(),f=e.inArray(i.id,g),-1!==f&&(g=e.vakata.array_remove(g,f),n>f&&n--),f=[],p=0,m=g.length;m>p;p++)f[p>=n?p+1:p]=g[p];f[n]=i.id,h.children=f,this._node_changed(h.id),this.redraw("#"===h.id)}else{for(f=i.children_d.concat(),f.push(i.id),p=0,m=i.parents.length;m>p;p++){for(g=[],y=_._model.data[i.parents[p]].children_d,v=0,j=y.length;j>v;v++)-1===e.inArray(y[v],f)&&g.push(y[v]);_._model.data[i.parents[p]].children_d=g}for(_._model.data[l].children=e.vakata.array_remove_item(_._model.data[l].children,i.id),p=0,m=h.parents.length;m>p;p++)this._model.data[h.parents[p]].children_d=this._model.data[h.parents[p]].children_d.concat(f);for(g=[],p=0,m=h.children.length;m>p;p++)g[p>=n?p+1:p]=h.children[p];for(g[n]=i.id,h.children=g,h.children_d.push(i.id),h.children_d=h.children_d.concat(i.children_d),i.parent=h.id,f=h.parents.concat(),f.unshift(h.id),y=i.parents.length,i.parents=f,f=f.concat(),p=0,m=i.children_d.length;m>p;p++)this._model.data[i.children_d[p]].parents=this._model.data[i.children_d[p]].parents.slice(0,-1*y),Array.prototype.push.apply(this._model.data[i.children_d[p]].parents,f);this._node_changed(l),this._node_changed(h.id),this.redraw("#"===l||"#"===h.id)}return s&&s.call(this,i,h,n),this.trigger("move_node",{node:i,parent:h.id,position:n,old_parent:l,old_position:c,is_multi:_&&_._id&&_._id!==this._id,is_foreign:!_||!_._id,old_instance:_,new_instance:this}),!0},copy_node:function(i,r,n,s,a){var d,o,l,c,h,_,u,g,f,p,m;if(e.isArray(i)){for(i=i.reverse().slice(),d=0,o=i.length;o>d;d++)this.copy_node(i[d],r,n,s,a);return!0}if(i=i&&i.id?i:this.get_node(i),r=this.get_node(r),n=n===t?0:n,!r||!i||"#"===i.id)return!1;if(!(""+n).match(/^(before|after)$/)&&!a&&!this.is_loaded(r))return this.load_node(r,function(){this.copy_node(i,r,n,s,!0)});switch(g=""+(i.parent||"#"),f=(""+n).match(/^(before|after)$/)&&"#"!==r.id?this.get_node(r.parent):r,p=i.instance?i.instance:this._model.data[i.id]?this:e.jstree.reference(i.id),m=!p||!p._id||this._id!==p._id,"#"===f.id&&("before"===n&&(n="first"),"after"===n&&(n="last")),n){case"before":n=e.inArray(r.id,f.children);break;case"after":n=e.inArray(r.id,f.children)+1;break;case"inside":case"first":n=0;break;case"last":n=f.children.length;break;default:n||(n=0)}if(n>f.children.length&&(n=f.children.length),!this.check("copy_node",i,f,n,{core:!0,is_multi:p&&p._id&&p._id!==this._id,is_foreign:!p||!p._id}))return this.settings.core.error.call(this,this._data.core.last_error),!1;if(u=p?p.get_json(i,{no_id:!0,no_data:!0,no_state:!0}):i,!u)return!1;if(u.id===!0&&delete u.id,u=this._parse_model_from_json(u,f.id,f.parents.concat()),!u)return!1;for(c=this.get_node(u),i&&i.state&&i.state.loaded===!1&&(c.state.loaded=!1),l=[],l.push(u),l=l.concat(c.children_d),this.trigger("model",{nodes:l,parent:f.id}),h=0,_=f.parents.length;_>h;h++)this._model.data[f.parents[h]].children_d=this._model.data[f.parents[h]].children_d.concat(l);for(l=[],h=0,_=f.children.length;_>h;h++)l[h>=n?h+1:h]=f.children[h];return l[n]=c.id,f.children=l,f.children_d.push(c.id),f.children_d=f.children_d.concat(c.children_d),this._node_changed(f.id),this.redraw("#"===f.id),s&&s.call(this,c,f,n),this.trigger("copy_node",{node:c,original:i,parent:f.id,position:n,old_parent:g,old_position:p&&p._id&&g&&p._model.data[g]&&p._model.data[g].children?e.inArray(i.id,p._model.data[g].children):-1,is_multi:p&&p._id&&p._id!==this._id,is_foreign:!p||!p._id,old_instance:p,new_instance:this}),c.id},cut:function(i){if(i||(i=this._data.core.selected.concat()),e.isArray(i)||(i=[i]),!i.length)return!1;var a=[],d,o,l;for(o=0,l=i.length;l>o;o++)d=this.get_node(i[o]),d&&d.id&&"#"!==d.id&&a.push(d);return a.length?(r=a,s=this,n="move_node",this.trigger("cut",{node:i}),t):!1},copy:function(i){if(i||(i=this._data.core.selected.concat()),e.isArray(i)||(i=[i]),!i.length)return!1;var a=[],d,o,l;for(o=0,l=i.length;l>o;o++)d=this.get_node(i[o]),d&&d.id&&"#"!==d.id&&a.push(d);return a.length?(r=a,s=this,n="copy_node",this.trigger("copy",{node:i}),t):!1},get_buffer:function(){return{mode:n,node:r,inst:s}},can_paste:function(){return n!==!1&&r!==!1},paste:function(e,i){return e=this.get_node(e),e&&n&&n.match(/^(copy_node|move_node)$/)&&r?(this[n](r,e,i)&&this.trigger("paste",{parent:e.id,node:r,mode:n}),r=!1,n=!1,s=!1,t):!1},edit:function(i,r){if(i=this._open_to(i),!i||!i.length)return!1;if(this.settings.core.check_callback===!1)return this._data.core.last_error={error:"check",plugin:"core",id:"core_07",reason:"Could not edit node because of check_callback"},this.settings.core.error.call(this,this._data.core.last_error),!1;var n=this._data.core.rtl,s=this.element.width(),a=i.children(".jstree-anchor"),d=e("<span>"),o="string"==typeof r?r:this.get_text(i),l=e("<div />",{css:{position:"absolute",top:"-200px",left:n?"0px":"-1000px",visibility:"hidden"}}).appendTo("body"),c=e("<input />",{value:o,"class":"jstree-rename-input",css:{padding:"0",border:"1px solid silver","box-sizing":"border-box",display:"inline-block",height:this._data.core.li_height+"px",lineHeight:this._data.core.li_height+"px",width:"150px"},blur:e.proxy(function(){var e=d.children(".jstree-rename-input"),t=e.val();""===t&&(t=o),l.remove(),d.replaceWith(a),d.remove(),this.set_text(i,o),this.rename_node(i,t)===!1&&this.set_text(i,o)},this),keydown:function(e){var t=e.which;27===t&&(this.value=o),(27===t||13===t||37===t||38===t||39===t||40===t||32===t)&&e.stopImmediatePropagation(),(27===t||13===t)&&(e.preventDefault(),this.blur())},click:function(e){e.stopImmediatePropagation()},mousedown:function(e){e.stopImmediatePropagation()},keyup:function(e){c.width(Math.min(l.text("pW"+this.value).width(),s))},keypress:function(e){return 13===e.which?!1:t}}),h={fontFamily:a.css("fontFamily")||"",fontSize:a.css("fontSize")||"",fontWeight:a.css("fontWeight")||"",fontStyle:a.css("fontStyle")||"",fontStretch:a.css("fontStretch")||"",fontVariant:a.css("fontVariant")||"",letterSpacing:a.css("letterSpacing")||"",wordSpacing:a.css("wordSpacing")||""};this.set_text(i,""),d.attr("class",a.attr("class")).append(a.contents().clone()).append(c),a.replaceWith(d),l.css(h),c.css(h).width(Math.min(l.text("pW"+c[0].value).width(),s))[0].select()},set_theme:function(t,i){if(!t)return!1;if(i===!0){var r=this.settings.core.themes.dir;r||(r=e.jstree.path+"/themes"),i=r+"/"+t+"/style.css"}i&&-1===e.inArray(i,a)&&(e("head").append('<link rel="stylesheet" href="'+i+'" type="text/css" />'),a.push(i)),this._data.core.themes.name&&this.element.removeClass("jstree-"+this._data.core.themes.name),this._data.core.themes.name=t,this.element.addClass("jstree-"+t),this.element[this.settings.core.themes.responsive?"addClass":"removeClass"]("jstree-"+t+"-responsive"),this.trigger("set_theme",{theme:t})},get_theme:function(){return this._data.core.themes.name},set_theme_variant:function(e){this._data.core.themes.variant&&this.element.removeClass("jstree-"+this._data.core.themes.name+"-"+this._data.core.themes.variant),this._data.core.themes.variant=e,e&&this.element.addClass("jstree-"+this._data.core.themes.name+"-"+this._data.core.themes.variant)},get_theme_variant:function(){return this._data.core.themes.variant},show_stripes:function(){this._data.core.themes.stripes=!0,this.get_container_ul().addClass("jstree-striped")},hide_stripes:function(){this._data.core.themes.stripes=!1,this.get_container_ul().removeClass("jstree-striped")},toggle_stripes:function(){this._data.core.themes.stripes?this.hide_stripes():this.show_stripes()},show_dots:function(){this._data.core.themes.dots=!0,this.get_container_ul().removeClass("jstree-no-dots")},hide_dots:function(){this._data.core.themes.dots=!1,this.get_container_ul().addClass("jstree-no-dots")},toggle_dots:function(){this._data.core.themes.dots?this.hide_dots():this.show_dots()},show_icons:function(){this._data.core.themes.icons=!0,this.get_container_ul().removeClass("jstree-no-icons")},hide_icons:function(){this._data.core.themes.icons=!1,this.get_container_ul().addClass("jstree-no-icons")},toggle_icons:function(){this._data.core.themes.icons?this.hide_icons():this.show_icons()},set_icon:function(t,i){var r,n,s,a;if(e.isArray(t)){for(t=t.slice(),r=0,n=t.length;n>r;r++)this.set_icon(t[r],i);return!0}return t=this.get_node(t),t&&"#"!==t.id?(a=t.icon,t.icon=i,s=this.get_node(t,!0).children(".jstree-anchor").children(".jstree-themeicon"),i===!1?this.hide_icon(t):i===!0?s.removeClass("jstree-themeicon-custom "+a).css("background","").removeAttr("rel"):-1===i.indexOf("/")&&-1===i.indexOf(".")?(s.removeClass(a).css("background",""),s.addClass(i+" jstree-themeicon-custom").attr("rel",i)):(s.removeClass(a).css("background",""),s.addClass("jstree-themeicon-custom").css("background","url('"+i+"') center center no-repeat").attr("rel",i)),!0):!1},get_icon:function(e){return e=this.get_node(e),e&&"#"!==e.id?e.icon:!1},hide_icon:function(t){var i,r;if(e.isArray(t)){for(t=t.slice(),i=0,r=t.length;r>i;i++)this.hide_icon(t[i]);return!0}return t=this.get_node(t),t&&"#"!==t?(t.icon=!1,this.get_node(t,!0).children(".jstree-anchor").children(".jstree-themeicon").addClass("jstree-themeicon-hidden"),!0):!1},show_icon:function(t){var i,r,n;if(e.isArray(t)){for(t=t.slice(),i=0,r=t.length;r>i;i++)this.show_icon(t[i]);return!0}return t=this.get_node(t),t&&"#"!==t?(n=this.get_node(t,!0),t.icon=n.length?n.children(".jstree-anchor").children(".jstree-themeicon").attr("rel"):!0,t.icon||(t.icon=!0),n.children(".jstree-anchor").children(".jstree-themeicon").removeClass("jstree-themeicon-hidden"),!0):!1}},e.vakata={},e.vakata.attributes=function(t,i){t=e(t)[0];var r=i?{}:[];return t&&t.attributes&&e.each(t.attributes,function(t,n){-1===e.inArray(n.nodeName.toLowerCase(),["style","contenteditable","hasfocus","tabindex"])&&null!==n.nodeValue&&""!==e.trim(n.nodeValue)&&(i?r[n.nodeName]=n.nodeValue:r.push(n.nodeName))}),r},e.vakata.array_unique=function(e){var t=[],i,r,n;for(i=0,n=e.length;n>i;i++){for(r=0;i>=r;r++)if(e[i]===e[r])break;r===i&&t.push(e[i])}return t},e.vakata.array_remove=function(e,t,i){var r=e.slice((i||t)+1||e.length);return e.length=0>t?e.length+t:t,e.push.apply(e,r),e},e.vakata.array_remove_item=function(t,i){var r=e.inArray(i,t);return-1!==r?e.vakata.array_remove(t,r):t};var _=document.createElement("I");_.className="jstree-icon jstree-checkbox",e.jstree.defaults.checkbox={visible:!0,three_state:!0,whole_node:!0,keep_selected_style:!0},e.jstree.plugins.checkbox=function(t,i){this.bind=function(){i.bind.call(this),this._data.checkbox.uto=!1,this.element.on("init.jstree",e.proxy(function(){this._data.checkbox.visible=this.settings.checkbox.visible,this.settings.checkbox.keep_selected_style||this.element.addClass("jstree-checkbox-no-clicked")},this)).on("loading.jstree",e.proxy(function(){this[this._data.checkbox.visible?"show_checkboxes":"hide_checkboxes"]()},this)),this.settings.checkbox.three_state&&this.element.on("changed.jstree move_node.jstree copy_node.jstree redraw.jstree open_node.jstree",e.proxy(function(){this._data.checkbox.uto&&clearTimeout(this._data.checkbox.uto),this._data.checkbox.uto=setTimeout(e.proxy(this._undetermined,this),50)},this)).on("model.jstree",e.proxy(function(t,i){var r=this._model.data,n=r[i.parent],s=i.nodes,a=[],d,o,l,c,h,_;if(n.state.selected){for(o=0,l=s.length;l>o;o++)r[s[o]].state.selected=!0;this._data.core.selected=this._data.core.selected.concat(s)}else for(o=0,l=s.length;l>o;o++)if(r[s[o]].state.selected){for(c=0,h=r[s[o]].children_d.length;h>c;c++)r[r[s[o]].children_d[c]].state.selected=!0;this._data.core.selected=this._data.core.selected.concat(r[s[o]].children_d)}for(o=0,l=n.children_d.length;l>o;o++)r[n.children_d[o]].children.length||a.push(r[n.children_d[o]].parent);for(a=e.vakata.array_unique(a),c=0,h=a.length;h>c;c++){n=r[a[c]];while(n&&"#"!==n.id){for(d=0,o=0,l=n.children.length;l>o;o++)d+=r[n.children[o]].state.selected;if(d!==l)break;n.state.selected=!0,this._data.core.selected.push(n.id),_=this.get_node(n,!0),_&&_.length&&_.children(".jstree-anchor").addClass("jstree-clicked"),n=this.get_node(n.parent)}}this._data.core.selected=e.vakata.array_unique(this._data.core.selected)},this)).on("select_node.jstree",e.proxy(function(t,i){var r=i.node,n=this._model.data,s=this.get_node(r.parent),a=this.get_node(r,!0),d,o,l,c;for(this._data.core.selected=e.vakata.array_unique(this._data.core.selected.concat(r.children_d)),d=0,o=r.children_d.length;o>d;d++)c=n[r.children_d[d]],c.state.selected=!0,c&&c.original&&c.original.state&&c.original.state.undetermined&&(c.original.state.undetermined=!1);while(s&&"#"!==s.id){for(l=0,d=0,o=s.children.length;o>d;d++)l+=n[s.children[d]].state.selected;if(l!==o)break;s.state.selected=!0,this._data.core.selected.push(s.id),c=this.get_node(s,!0),c&&c.length&&c.children(".jstree-anchor").addClass("jstree-clicked"),s=this.get_node(s.parent)}a.length&&a.find(".jstree-anchor").addClass("jstree-clicked")},this)).on("deselect_all.jstree",e.proxy(function(e,t){var i=this.get_node("#"),r=this._model.data,n,s,a;for(n=0,s=i.children_d.length;s>n;n++)a=r[i.children_d[n]],a&&a.original&&a.original.state&&a.original.state.undetermined&&(a.original.state.undetermined=!1)},this)).on("deselect_node.jstree",e.proxy(function(t,i){var r=i.node,n=this.get_node(r,!0),s,a,d;for(r&&r.original&&r.original.state&&r.original.state.undetermined&&(r.original.state.undetermined=!1),s=0,a=r.children_d.length;a>s;s++)d=this._model.data[r.children_d[s]],d.state.selected=!1,d&&d.original&&d.original.state&&d.original.state.undetermined&&(d.original.state.undetermined=!1);for(s=0,a=r.parents.length;a>s;s++)d=this._model.data[r.parents[s]],d.state.selected=!1,d&&d.original&&d.original.state&&d.original.state.undetermined&&(d.original.state.undetermined=!1),d=this.get_node(r.parents[s],!0),d&&d.length&&d.children(".jstree-anchor").removeClass("jstree-clicked");for(d=[],s=0,a=this._data.core.selected.length;a>s;s++)-1===e.inArray(this._data.core.selected[s],r.children_d)&&-1===e.inArray(this._data.core.selected[s],r.parents)&&d.push(this._data.core.selected[s]);this._data.core.selected=e.vakata.array_unique(d),n.length&&n.find(".jstree-anchor").removeClass("jstree-clicked")},this)).on("delete_node.jstree",e.proxy(function(e,t){var i=this.get_node(t.parent),r=this._model.data,n,s,a,d;while(i&&"#"!==i.id){for(a=0,n=0,s=i.children.length;s>n;n++)a+=r[i.children[n]].state.selected;if(a!==s)break;i.state.selected=!0,this._data.core.selected.push(i.id),d=this.get_node(i,!0),d&&d.length&&d.children(".jstree-anchor").addClass("jstree-clicked"),i=this.get_node(i.parent)}},this)).on("move_node.jstree",e.proxy(function(t,i){var r=i.is_multi,n=i.old_parent,s=this.get_node(i.parent),a=this._model.data,d,o,l,c,h;if(!r){d=this.get_node(n);while(d&&"#"!==d.id){for(o=0,l=0,c=d.children.length;c>l;l++)o+=a[d.children[l]].state.selected;if(o!==c)break;d.state.selected=!0,this._data.core.selected.push(d.id),h=this.get_node(d,!0),h&&h.length&&h.children(".jstree-anchor").addClass("jstree-clicked"),d=this.get_node(d.parent)}}d=s;while(d&&"#"!==d.id){for(o=0,l=0,c=d.children.length;c>l;l++)o+=a[d.children[l]].state.selected;if(o===c)d.state.selected||(d.state.selected=!0,this._data.core.selected.push(d.id),h=this.get_node(d,!0),h&&h.length&&h.children(".jstree-anchor").addClass("jstree-clicked"));else{if(!d.state.selected)break;d.state.selected=!1,this._data.core.selected=e.vakata.array_remove_item(this._data.core.selected,d.id),h=this.get_node(d,!0),h&&h.length&&h.children(".jstree-anchor").removeClass("jstree-clicked")}d=this.get_node(d.parent)}},this))},this._undetermined=function(){var t,i,r=this._model.data,n=this._data.core.selected,s=[],a=this;for(t=0,i=n.length;i>t;t++)r[n[t]]&&r[n[t]].parents&&(s=s.concat(r[n[t]].parents));for(this.element.find(".jstree-closed").not(":has(.jstree-children)").each(function(){var e=a.get_node(this),n;if(e.state.loaded)for(t=0,i=e.children_d.length;i>t;t++)n=r[e.children_d[t]],!n.state.loaded&&n.original&&n.original.state&&n.original.state.undetermined&&n.original.state.undetermined===!0&&(s.push(n.id),s=s.concat(n.parents));else e.original&&e.original.state&&e.original.state.undetermined&&e.original.state.undetermined===!0&&(s.push(e.id),s=s.concat(e.parents))}),s=e.vakata.array_unique(s),s=e.vakata.array_remove_item(s,"#"),this.element.find(".jstree-undetermined").removeClass("jstree-undetermined"),t=0,i=s.length;i>t;t++)r[s[t]].state.selected||(n=this.get_node(s[t],!0),n&&n.length&&n.children(".jstree-anchor").children(".jstree-checkbox").addClass("jstree-undetermined"))},this.redraw_node=function(t,r,n){if(t=i.redraw_node.call(this,t,r,n)){var s,a,d=null;for(s=0,a=t.childNodes.length;a>s;s++)if(t.childNodes[s]&&t.childNodes[s].className&&-1!==t.childNodes[s].className.indexOf("jstree-anchor")){d=t.childNodes[s];break}d&&d.insertBefore(_.cloneNode(!1),d.childNodes[0])}return!n&&this.settings.checkbox.three_state&&(this._data.checkbox.uto&&clearTimeout(this._data.checkbox.uto),this._data.checkbox.uto=setTimeout(e.proxy(this._undetermined,this),50)),t},this.activate_node=function(t,r){return(this.settings.checkbox.whole_node||e(r.target).hasClass("jstree-checkbox"))&&(r.ctrlKey=!0),i.activate_node.call(this,t,r)},this.show_checkboxes=function(){this._data.core.themes.checkboxes=!0,this.get_container_ul().removeClass("jstree-no-checkboxes")},this.hide_checkboxes=function(){this._data.core.themes.checkboxes=!1,this.get_container_ul().addClass("jstree-no-checkboxes")},this.toggle_checkboxes=function(){this._data.core.themes.checkboxes?this.hide_checkboxes():this.show_checkboxes()
}},e.jstree.defaults.contextmenu={select_node:!0,show_at_node:!0,items:function(t,i){return{create:{separator_before:!1,separator_after:!0,_disabled:!1,label:"Create",action:function(t){var i=e.jstree.reference(t.reference),r=i.get_node(t.reference);i.create_node(r,{},"last",function(e){setTimeout(function(){i.edit(e)},0)})}},rename:{separator_before:!1,separator_after:!1,_disabled:!1,label:"Rename",action:function(t){var i=e.jstree.reference(t.reference),r=i.get_node(t.reference);i.edit(r)}},remove:{separator_before:!1,icon:!1,separator_after:!1,_disabled:!1,label:"Delete",action:function(t){var i=e.jstree.reference(t.reference),r=i.get_node(t.reference);i.is_selected(r)?i.delete_node(i.get_selected()):i.delete_node(r)}},ccp:{separator_before:!0,icon:!1,separator_after:!1,label:"Edit",action:!1,submenu:{cut:{separator_before:!1,separator_after:!1,label:"Cut",action:function(t){var i=e.jstree.reference(t.reference),r=i.get_node(t.reference);i.is_selected(r)?i.cut(i.get_selected()):i.cut(r)}},copy:{separator_before:!1,icon:!1,separator_after:!1,label:"Copy",action:function(t){var i=e.jstree.reference(t.reference),r=i.get_node(t.reference);i.is_selected(r)?i.copy(i.get_selected()):i.copy(r)}},paste:{separator_before:!1,icon:!1,_disabled:function(t){return!e.jstree.reference(t.reference).can_paste()},separator_after:!1,label:"Paste",action:function(t){var i=e.jstree.reference(t.reference),r=i.get_node(t.reference);i.paste(r)}}}}}}},e.jstree.plugins.contextmenu=function(i,r){this.bind=function(){r.bind.call(this);var t=0;this.element.on("contextmenu.jstree",".jstree-anchor",e.proxy(function(e){e.preventDefault(),t=e.ctrlKey?e.timeStamp:0,this.is_loading(e.currentTarget)||this.show_contextmenu(e.currentTarget,e.pageX,e.pageY,e)},this)).on("click.jstree",".jstree-anchor",e.proxy(function(i){this._data.contextmenu.visible&&(!t||i.timeStamp-t>250)&&e.vakata.context.hide()},this)),e(document).on("context_hide.vakata",e.proxy(function(){this._data.contextmenu.visible=!1},this))},this.teardown=function(){this._data.contextmenu.visible&&e.vakata.context.hide(),r.teardown.call(this)},this.show_contextmenu=function(i,r,n,s){if(i=this.get_node(i),!i||"#"===i.id)return!1;var a=this.settings.contextmenu,d=this.get_node(i,!0),o=d.children(".jstree-anchor"),l=!1,c=!1;(a.show_at_node||r===t||n===t)&&(l=o.offset(),r=l.left,n=l.top+this._data.core.li_height),this.settings.contextmenu.select_node&&!this.is_selected(i)&&this.activate_node(i,s),c=a.items,e.isFunction(c)&&(c=c.call(this,i,e.proxy(function(e){this._show_contextmenu(i,r,n,e)},this))),e.isPlainObject(c)&&this._show_contextmenu(i,r,n,c)},this._show_contextmenu=function(t,i,r,n){var s=this.get_node(t,!0),a=s.children(".jstree-anchor");e(document).one("context_show.vakata",e.proxy(function(t,i){var r="jstree-contextmenu jstree-"+this.get_theme()+"-contextmenu";e(i.element).addClass(r)},this)),this._data.contextmenu.visible=!0,e.vakata.context.show(a,{x:i,y:r},n),this.trigger("show_contextmenu",{node:t,x:i,y:r})}},function(e){var i=!1,r={element:!1,reference:!1,position_x:0,position_y:0,items:[],html:"",is_visible:!1};e.vakata.context={settings:{hide_onmouseleave:0,icons:!0},_trigger:function(t){e(document).triggerHandler("context_"+t+".vakata",{reference:r.reference,element:r.element,position:{x:r.position_x,y:r.position_y}})},_execute:function(t){return t=r.items[t],t&&(!t._disabled||e.isFunction(t._disabled)&&!t._disabled({item:t,reference:r.reference,element:r.element}))&&t.action?t.action.call(null,{item:t,reference:r.reference,element:r.element,position:{x:r.position_x,y:r.position_y}}):!1},_parse:function(i,n){if(!i)return!1;n||(r.html="",r.items=[]);var s="",a=!1,d;return n&&(s+="<ul>"),e.each(i,function(i,n){return n?(r.items.push(n),!a&&n.separator_before&&(s+="<li class='vakata-context-separator'><a href='#' "+(e.vakata.context.settings.icons?"":'style="margin-left:0px;"')+">&#160;<"+"/a><"+"/li>"),a=!1,s+="<li class='"+(n._class||"")+(n._disabled===!0||e.isFunction(n._disabled)&&n._disabled({item:n,reference:r.reference,element:r.element})?" vakata-contextmenu-disabled ":"")+"' "+(n.shortcut?" data-shortcut='"+n.shortcut+"' ":"")+">",s+="<a href='#' rel='"+(r.items.length-1)+"'>",e.vakata.context.settings.icons&&(s+="<i ",n.icon&&(s+=-1!==n.icon.indexOf("/")||-1!==n.icon.indexOf(".")?" style='background:url(\""+n.icon+"\") center center no-repeat' ":" class='"+n.icon+"' "),s+="></i><span class='vakata-contextmenu-sep'>&#160;</span>"),s+=(e.isFunction(n.label)?n.label({item:i,reference:r.reference,element:r.element}):n.label)+(n.shortcut?' <span class="vakata-contextmenu-shortcut vakata-contextmenu-shortcut-'+n.shortcut+'">'+(n.shortcut_label||"")+"</span>":"")+"<"+"/a>",n.submenu&&(d=e.vakata.context._parse(n.submenu,!0),d&&(s+=d)),s+="</li>",n.separator_after&&(s+="<li class='vakata-context-separator'><a href='#' "+(e.vakata.context.settings.icons?"":'style="margin-left:0px;"')+">&#160;<"+"/a><"+"/li>",a=!0),t):!0}),s=s.replace(/<li class\='vakata-context-separator'\><\/li\>$/,""),n&&(s+="</ul>"),n||(r.html=s,e.vakata.context._trigger("parse")),s.length>10?s:!1},_show_submenu:function(t){if(t=e(t),t.length&&t.children("ul").length){var r=t.children("ul"),n=t.offset().left+t.outerWidth(),s=t.offset().top,a=r.width(),d=r.height(),o=e(window).width()+e(window).scrollLeft(),l=e(window).height()+e(window).scrollTop();i?t[0>n-(a+10+t.outerWidth())?"addClass":"removeClass"]("vakata-context-left"):t[n+a+10>o?"addClass":"removeClass"]("vakata-context-right"),s+d+10>l&&r.css("bottom","-1px"),r.show()}},show:function(t,n,s){var a,d,o,l,c,h,_,u,g=!0;switch(r.element&&r.element.length&&r.element.width(""),g){case!n&&!t:return!1;case!!n&&!!t:r.reference=t,r.position_x=n.x,r.position_y=n.y;break;case!n&&!!t:r.reference=t,a=t.offset(),r.position_x=a.left+t.outerHeight(),r.position_y=a.top;break;case!!n&&!t:r.position_x=n.x,r.position_y=n.y}t&&!s&&e(t).data("vakata_contextmenu")&&(s=e(t).data("vakata_contextmenu")),e.vakata.context._parse(s)&&r.element.html(r.html),r.items.length&&(d=r.element,o=r.position_x,l=r.position_y,c=d.width(),h=d.height(),_=e(window).width()+e(window).scrollLeft(),u=e(window).height()+e(window).scrollTop(),i&&(o-=d.outerWidth(),e(window).scrollLeft()+20>o&&(o=e(window).scrollLeft()+20)),o+c+20>_&&(o=_-(c+20)),l+h+20>u&&(l=u-(h+20)),r.element.css({left:o,top:l}).show().find("a:eq(0)").focus().parent().addClass("vakata-context-hover"),r.is_visible=!0,e.vakata.context._trigger("show"))},hide:function(){r.is_visible&&(r.element.hide().find("ul").hide().end().find(":focus").blur(),r.is_visible=!1,e.vakata.context._trigger("hide"))}},e(function(){i="rtl"===e("body").css("direction");var t=!1;r.element=e("<ul class='vakata-context'></ul>"),r.element.on("mouseenter","li",function(i){i.stopImmediatePropagation(),e.contains(this,i.relatedTarget)||(t&&clearTimeout(t),r.element.find(".vakata-context-hover").removeClass("vakata-context-hover").end(),e(this).siblings().find("ul").hide().end().end().parentsUntil(".vakata-context","li").addBack().addClass("vakata-context-hover"),e.vakata.context._show_submenu(this))}).on("mouseleave","li",function(t){e.contains(this,t.relatedTarget)||e(this).find(".vakata-context-hover").addBack().removeClass("vakata-context-hover")}).on("mouseleave",function(i){e(this).find(".vakata-context-hover").removeClass("vakata-context-hover"),e.vakata.context.settings.hide_onmouseleave&&(t=setTimeout(function(t){return function(){e.vakata.context.hide()}}(this),e.vakata.context.settings.hide_onmouseleave))}).on("click","a",function(e){e.preventDefault()}).on("mouseup","a",function(t){e(this).blur().parent().hasClass("vakata-context-disabled")||e.vakata.context._execute(e(this).attr("rel"))===!1||e.vakata.context.hide()}).on("keydown","a",function(t){var i=null;switch(t.which){case 13:case 32:t.type="mouseup",t.preventDefault(),e(t.currentTarget).trigger(t);break;case 37:r.is_visible&&(r.element.find(".vakata-context-hover").last().parents("li:eq(0)").find("ul").hide().find(".vakata-context-hover").removeClass("vakata-context-hover").end().end().children("a").focus(),t.stopImmediatePropagation(),t.preventDefault());break;case 38:r.is_visible&&(i=r.element.find("ul:visible").addBack().last().children(".vakata-context-hover").removeClass("vakata-context-hover").prevAll("li:not(.vakata-context-separator)").first(),i.length||(i=r.element.find("ul:visible").addBack().last().children("li:not(.vakata-context-separator)").last()),i.addClass("vakata-context-hover").children("a").focus(),t.stopImmediatePropagation(),t.preventDefault());break;case 39:r.is_visible&&(r.element.find(".vakata-context-hover").last().children("ul").show().children("li:not(.vakata-context-separator)").removeClass("vakata-context-hover").first().addClass("vakata-context-hover").children("a").focus(),t.stopImmediatePropagation(),t.preventDefault());break;case 40:r.is_visible&&(i=r.element.find("ul:visible").addBack().last().children(".vakata-context-hover").removeClass("vakata-context-hover").nextAll("li:not(.vakata-context-separator)").first(),i.length||(i=r.element.find("ul:visible").addBack().last().children("li:not(.vakata-context-separator)").first()),i.addClass("vakata-context-hover").children("a").focus(),t.stopImmediatePropagation(),t.preventDefault());break;case 27:e.vakata.context.hide(),t.preventDefault();break;default:}}).on("keydown",function(e){e.preventDefault();var t=r.element.find(".vakata-contextmenu-shortcut-"+e.which).parent();t.parent().not(".vakata-context-disabled")&&t.mouseup()}).appendTo("body"),e(document).on("mousedown",function(t){r.is_visible&&!e.contains(r.element[0],t.target)&&e.vakata.context.hide()}).on("context_show.vakata",function(e,t){r.element.find("li:has(ul)").children("a").addClass("vakata-context-parent"),i&&r.element.addClass("vakata-context-rtl").css("direction","rtl"),r.element.find("ul").hide().end()})})}(e),e.jstree.defaults.dnd={copy:!0,open_timeout:500,is_draggable:!0,check_while_dragging:!0,always_copy:!1,inside_pos:0},e.jstree.plugins.dnd=function(i,r){this.bind=function(){r.bind.call(this),this.element.on("mousedown.jstree touchstart.jstree",".jstree-anchor",e.proxy(function(i){var r=this.get_node(i.target),n=this.is_selected(r)?this.get_selected().length:1;return r&&r.id&&"#"!==r.id&&(1===i.which||"touchstart"===i.type)&&(this.settings.dnd.is_draggable===!0||e.isFunction(this.settings.dnd.is_draggable)&&this.settings.dnd.is_draggable.call(this,n>1?this.get_selected(!0):[r]))?(this.element.trigger("mousedown.jstree"),e.vakata.dnd.start(i,{jstree:!0,origin:this,obj:this.get_node(r,!0),nodes:n>1?this.get_selected():[r.id]},'<div id="jstree-dnd" class="jstree-'+this.get_theme()+'"><i class="jstree-icon jstree-er"></i>'+(n>1?n+" "+this.get_string("nodes"):this.get_text(i.currentTarget,!0))+'<ins class="jstree-copy" style="display:none;">+</ins></div>')):t},this))}},e(function(){var i=!1,r=!1,n=!1,s=e('<div id="jstree-marker">&#160;</div>').hide().appendTo("body");e(document).bind("dnd_start.vakata",function(e,t){i=!1}).bind("dnd_move.vakata",function(a,d){if(n&&clearTimeout(n),d.data.jstree&&(!d.event.target.id||"jstree-marker"!==d.event.target.id)){var o=e.jstree.reference(d.event.target),l=!1,c=!1,h=!1,_,u,g,f,p,m,v,j,y,x,k,b,w,C;if(o&&o._data&&o._data.dnd)if(s.attr("class","jstree-"+o.get_theme()),d.helper.children().attr("class","jstree-"+o.get_theme()).find(".jstree-copy:eq(0)")[d.data.origin&&(d.data.origin.settings.dnd.always_copy||d.data.origin.settings.dnd.copy&&(d.event.metaKey||d.event.ctrlKey))?"show":"hide"](),d.event.target!==o.element[0]&&d.event.target!==o.get_container_ul()[0]||0!==o.get_container_ul().children().length){if(l=e(d.event.target).closest(".jstree-anchor"),l&&l.length&&l.parent().is(".jstree-closed, .jstree-open, .jstree-leaf")&&(c=l.offset(),h=d.event.pageY-c.top,g=l.height(),m=g/3>h?["b","i","a"]:h>g-g/3?["a","i","b"]:h>g/2?["i","a","b"]:["i","b","a"],e.each(m,function(a,h){switch(h){case"b":_=c.left-6,u=c.top-5,f=o.get_parent(l),p=l.parent().index();break;case"i":w=o.settings.dnd.inside_pos,C=o.get_node(l.parent()),_=c.left-2,u=c.top-5+g/2+1,f=C.id,p="first"===w?0:"last"===w?C.children.length:Math.min(w,C.children.length);break;case"a":_=c.left-6,u=c.top-5+g,f=o.get_parent(l),p=l.parent().index()+1}for(v=!0,j=0,y=d.data.nodes.length;y>j;j++)if(x=d.data.origin&&(d.data.origin.settings.dnd.always_copy||d.data.origin.settings.dnd.copy&&(d.event.metaKey||d.event.ctrlKey))?"copy_node":"move_node",k=p,"move_node"===x&&"a"===h&&d.data.origin&&d.data.origin===o&&f===o.get_parent(d.data.nodes[j])&&(b=o.get_node(f),k>e.inArray(d.data.nodes[j],b.children)&&(k-=1)),v=v&&(o&&o.settings&&o.settings.dnd&&o.settings.dnd.check_while_dragging===!1||o.check(x,d.data.origin&&d.data.origin!==o?d.data.origin.get_node(d.data.nodes[j]):d.data.nodes[j],f,k,{dnd:!0,ref:o.get_node(l.parent()),pos:h,is_multi:d.data.origin&&d.data.origin!==o,is_foreign:!d.data.origin})),!v){o&&o.last_error&&(r=o.last_error());break}return v?("i"===h&&l.parent().is(".jstree-closed")&&o.settings.dnd.open_timeout&&(n=setTimeout(function(e,t){return function(){e.open_node(t)}}(o,l),o.settings.dnd.open_timeout)),i={ins:o,par:f,pos:"i"!==h||"last"!==w||0!==p||o.is_loaded(C)?p:"last"},s.css({left:_+"px",top:u+"px"}).show(),d.helper.find(".jstree-icon:eq(0)").removeClass("jstree-er").addClass("jstree-ok"),r={},m=!0,!1):t}),m===!0))return}else{for(v=!0,j=0,y=d.data.nodes.length;y>j;j++)if(v=v&&o.check(d.data.origin&&(d.data.origin.settings.dnd.always_copy||d.data.origin.settings.dnd.copy&&(d.event.metaKey||d.event.ctrlKey))?"copy_node":"move_node",d.data.origin&&d.data.origin!==o?d.data.origin.get_node(d.data.nodes[j]):d.data.nodes[j],"#","last",{dnd:!0,ref:o.get_node("#"),pos:"i",is_multi:d.data.origin&&d.data.origin!==o,is_foreign:!d.data.origin}),!v)break;if(v)return i={ins:o,par:"#",pos:"last"},s.hide(),d.helper.find(".jstree-icon:eq(0)").removeClass("jstree-er").addClass("jstree-ok"),t}i=!1,d.helper.find(".jstree-icon").removeClass("jstree-ok").addClass("jstree-er"),s.hide()}}).bind("dnd_scroll.vakata",function(e,t){t.data.jstree&&(s.hide(),i=!1,t.helper.find(".jstree-icon:eq(0)").removeClass("jstree-ok").addClass("jstree-er"))}).bind("dnd_stop.vakata",function(t,a){if(n&&clearTimeout(n),a.data.jstree){s.hide();var d,o,l=[];if(i){for(d=0,o=a.data.nodes.length;o>d;d++)l[d]=a.data.origin?a.data.origin.get_node(a.data.nodes[d]):a.data.nodes[d],a.data.origin&&(l[d].instance=a.data.origin);i.ins[a.data.origin&&(a.data.origin.settings.dnd.always_copy||a.data.origin.settings.dnd.copy&&(a.event.metaKey||a.event.ctrlKey))?"copy_node":"move_node"](l,i.par,i.pos)}else d=e(a.event.target).closest(".jstree"),d.length&&r&&r.error&&"check"===r.error&&(d=d.jstree(!0),d&&d.settings.core.error.call(this,r))}}).bind("keyup keydown",function(t,i){i=e.vakata.dnd._get(),i.data&&i.data.jstree&&i.helper.find(".jstree-copy:eq(0)")[i.data.origin&&(i.data.origin.settings.dnd.always_copy||i.data.origin.settings.dnd.copy&&(t.metaKey||t.ctrlKey))?"show":"hide"]()})}),function(e){var i={element:!1,is_down:!1,is_drag:!1,helper:!1,helper_w:0,data:!1,init_x:0,init_y:0,scroll_l:0,scroll_t:0,scroll_e:!1,scroll_i:!1};e.vakata.dnd={settings:{scroll_speed:10,scroll_proximity:20,helper_left:5,helper_top:10,threshold:5},_trigger:function(t,i){var r=e.vakata.dnd._get();r.event=i,e(document).triggerHandler("dnd_"+t+".vakata",r)},_get:function(){return{data:i.data,element:i.element,helper:i.helper}},_clean:function(){i.helper&&i.helper.remove(),i.scroll_i&&(clearInterval(i.scroll_i),i.scroll_i=!1),i={element:!1,is_down:!1,is_drag:!1,helper:!1,helper_w:0,data:!1,init_x:0,init_y:0,scroll_l:0,scroll_t:0,scroll_e:!1,scroll_i:!1},e(document).off("mousemove touchmove",e.vakata.dnd.drag),e(document).off("mouseup touchend",e.vakata.dnd.stop)},_scroll:function(t){if(!i.scroll_e||!i.scroll_l&&!i.scroll_t)return i.scroll_i&&(clearInterval(i.scroll_i),i.scroll_i=!1),!1;if(!i.scroll_i)return i.scroll_i=setInterval(e.vakata.dnd._scroll,100),!1;if(t===!0)return!1;var r=i.scroll_e.scrollTop(),n=i.scroll_e.scrollLeft();i.scroll_e.scrollTop(r+i.scroll_t*e.vakata.dnd.settings.scroll_speed),i.scroll_e.scrollLeft(n+i.scroll_l*e.vakata.dnd.settings.scroll_speed),(r!==i.scroll_e.scrollTop()||n!==i.scroll_e.scrollLeft())&&e.vakata.dnd._trigger("scroll",i.scroll_e)},start:function(t,r,n){"touchstart"===t.type&&t.originalEvent&&t.originalEvent.changedTouches&&t.originalEvent.changedTouches[0]&&(t.pageX=t.originalEvent.changedTouches[0].pageX,t.pageY=t.originalEvent.changedTouches[0].pageY,t.target=document.elementFromPoint(t.originalEvent.changedTouches[0].pageX-window.pageXOffset,t.originalEvent.changedTouches[0].pageY-window.pageYOffset)),i.is_drag&&e.vakata.dnd.stop({});try{t.currentTarget.unselectable="on",t.currentTarget.onselectstart=function(){return!1},t.currentTarget.style&&(t.currentTarget.style.MozUserSelect="none")}catch(s){}return i.init_x=t.pageX,i.init_y=t.pageY,i.data=r,i.is_down=!0,i.element=t.currentTarget,n!==!1&&(i.helper=e("<div id='vakata-dnd'></div>").html(n).css({display:"block",margin:"0",padding:"0",position:"absolute",top:"-2000px",lineHeight:"16px",zIndex:"10000"})),e(document).bind("mousemove touchmove",e.vakata.dnd.drag),e(document).bind("mouseup touchend",e.vakata.dnd.stop),!1},drag:function(r){if("touchmove"===r.type&&r.originalEvent&&r.originalEvent.changedTouches&&r.originalEvent.changedTouches[0]&&(r.pageX=r.originalEvent.changedTouches[0].pageX,r.pageY=r.originalEvent.changedTouches[0].pageY,r.target=document.elementFromPoint(r.originalEvent.changedTouches[0].pageX-window.pageXOffset,r.originalEvent.changedTouches[0].pageY-window.pageYOffset)),i.is_down){if(!i.is_drag){if(!(Math.abs(r.pageX-i.init_x)>e.vakata.dnd.settings.threshold||Math.abs(r.pageY-i.init_y)>e.vakata.dnd.settings.threshold))return;i.helper&&(i.helper.appendTo("body"),i.helper_w=i.helper.outerWidth()),i.is_drag=!0,e.vakata.dnd._trigger("start",r)}var n=!1,s=!1,a=!1,d=!1,o=!1,l=!1,c=!1,h=!1,_=!1,u=!1;i.scroll_t=0,i.scroll_l=0,i.scroll_e=!1,e(e(r.target).parentsUntil("body").addBack().get().reverse()).filter(function(){return/^auto|scroll$/.test(e(this).css("overflow"))&&(this.scrollHeight>this.offsetHeight||this.scrollWidth>this.offsetWidth)}).each(function(){var n=e(this),s=n.offset();return this.scrollHeight>this.offsetHeight&&(s.top+n.height()-r.pageY<e.vakata.dnd.settings.scroll_proximity&&(i.scroll_t=1),r.pageY-s.top<e.vakata.dnd.settings.scroll_proximity&&(i.scroll_t=-1)),this.scrollWidth>this.offsetWidth&&(s.left+n.width()-r.pageX<e.vakata.dnd.settings.scroll_proximity&&(i.scroll_l=1),r.pageX-s.left<e.vakata.dnd.settings.scroll_proximity&&(i.scroll_l=-1)),i.scroll_t||i.scroll_l?(i.scroll_e=e(this),!1):t}),i.scroll_e||(n=e(document),s=e(window),a=n.height(),d=s.height(),o=n.width(),l=s.width(),c=n.scrollTop(),h=n.scrollLeft(),a>d&&r.pageY-c<e.vakata.dnd.settings.scroll_proximity&&(i.scroll_t=-1),a>d&&d-(r.pageY-c)<e.vakata.dnd.settings.scroll_proximity&&(i.scroll_t=1),o>l&&r.pageX-h<e.vakata.dnd.settings.scroll_proximity&&(i.scroll_l=-1),o>l&&l-(r.pageX-h)<e.vakata.dnd.settings.scroll_proximity&&(i.scroll_l=1),(i.scroll_t||i.scroll_l)&&(i.scroll_e=n)),i.scroll_e&&e.vakata.dnd._scroll(!0),i.helper&&(_=parseInt(r.pageY+e.vakata.dnd.settings.helper_top,10),u=parseInt(r.pageX+e.vakata.dnd.settings.helper_left,10),a&&_+25>a&&(_=a-50),o&&u+i.helper_w>o&&(u=o-(i.helper_w+2)),i.helper.css({left:u+"px",top:_+"px"})),e.vakata.dnd._trigger("move",r)}},stop:function(t){"touchend"===t.type&&t.originalEvent&&t.originalEvent.changedTouches&&t.originalEvent.changedTouches[0]&&(t.pageX=t.originalEvent.changedTouches[0].pageX,t.pageY=t.originalEvent.changedTouches[0].pageY,t.target=document.elementFromPoint(t.originalEvent.changedTouches[0].pageX-window.pageXOffset,t.originalEvent.changedTouches[0].pageY-window.pageYOffset)),i.is_drag&&e.vakata.dnd._trigger("stop",t),e.vakata.dnd._clean()}}}(jQuery),e.jstree.defaults.search={ajax:!1,fuzzy:!0,case_sensitive:!1,show_only_matches:!1,close_opened_onclear:!0,search_leaves_only:!1},e.jstree.plugins.search=function(i,r){this.bind=function(){r.bind.call(this),this._data.search.str="",this._data.search.dom=e(),this._data.search.res=[],this._data.search.opn=[],this.element.on("before_open.jstree",e.proxy(function(t,i){var r,n,s,a=this._data.search.res,d=[],o=e();if(a&&a.length&&(this._data.search.dom=e(this.element[0].querySelectorAll("#"+e.map(a,function(t){return-1!=="0123456789".indexOf(t[0])?"\\3"+t[0]+" "+t.substr(1).replace(e.jstree.idregex,"\\$&"):t.replace(e.jstree.idregex,"\\$&")}).join(", #"))),this._data.search.dom.children(".jstree-anchor").addClass("jstree-search"),this.settings.search.show_only_matches&&this._data.search.res.length)){for(r=0,n=a.length;n>r;r++)d=d.concat(this.get_node(a[r]).parents);d=e.vakata.array_remove_item(e.vakata.array_unique(d),"#"),o=d.length?e(this.element[0].querySelectorAll("#"+e.map(d,function(t){return-1!=="0123456789".indexOf(t[0])?"\\3"+t[0]+" "+t.substr(1).replace(e.jstree.idregex,"\\$&"):t.replace(e.jstree.idregex,"\\$&")}).join(", #"))):e(),this.element.find(".jstree-node").hide().filter(".jstree-last").filter(function(){return this.nextSibling}).removeClass("jstree-last"),o=o.add(this._data.search.dom),o.parentsUntil(".jstree").addBack().show().filter(".jstree-children").each(function(){e(this).children(".jstree-node:visible").eq(-1).addClass("jstree-last")})}},this)),this.settings.search.show_only_matches&&this.element.on("search.jstree",function(t,i){i.nodes.length&&(e(this).find(".jstree-node").hide().filter(".jstree-last").filter(function(){return this.nextSibling}).removeClass("jstree-last"),i.nodes.parentsUntil(".jstree").addBack().show().filter(".jstree-children").each(function(){e(this).children(".jstree-node:visible").eq(-1).addClass("jstree-last")}))}).on("clear_search.jstree",function(t,i){i.nodes.length&&e(this).find(".jstree-node").css("display","").filter(".jstree-last").filter(function(){return this.nextSibling}).removeClass("jstree-last")})},this.search=function(i,r){if(i===!1||""===e.trim(i))return this.clear_search();var n=this.settings.search,s=n.ajax?n.ajax:!1,a=null,d=[],o=[],l,c;return this._data.search.res.length&&this.clear_search(),r||s===!1?(this._data.search.str=i,this._data.search.dom=e(),this._data.search.res=[],this._data.search.opn=[],a=new e.vakata.search(i,!0,{caseSensitive:n.case_sensitive,fuzzy:n.fuzzy}),e.each(this._model.data,function(e,t){t.text&&a.search(t.text).isMatch&&(!n.search_leaves_only||t.state.loaded&&0===t.children.length)&&(d.push(e),o=o.concat(t.parents))}),d.length&&(o=e.vakata.array_unique(o),this._search_open(o),this._data.search.dom=e(this.element[0].querySelectorAll("#"+e.map(d,function(t){return-1!=="0123456789".indexOf(t[0])?"\\3"+t[0]+" "+t.substr(1).replace(e.jstree.idregex,"\\$&"):t.replace(e.jstree.idregex,"\\$&")}).join(", #"))),this._data.search.res=d,this._data.search.dom.children(".jstree-anchor").addClass("jstree-search")),this.trigger("search",{nodes:this._data.search.dom,str:i,res:this._data.search.res}),t):e.isFunction(s)?s.call(this,i,e.proxy(function(t){t&&t.d&&(t=t.d),this._load_nodes(e.isArray(t)?t:[],function(){this.search(i,!0)})},this)):(s=e.extend({},s),s.data||(s.data={}),s.data.str=i,e.ajax(s).fail(e.proxy(function(){this._data.core.last_error={error:"ajax",plugin:"search",id:"search_01",reason:"Could not load search parents",data:JSON.stringify(s)},this.settings.core.error.call(this,this._data.core.last_error)},this)).done(e.proxy(function(t){t&&t.d&&(t=t.d),this._load_nodes(e.isArray(t)?t:[],function(){this.search(i,!0)},!0)},this)))},this.clear_search=function(){this._data.search.dom.children(".jstree-anchor").removeClass("jstree-search"),this.settings.search.close_opened_onclear&&this.close_node(this._data.search.opn,0),this.trigger("clear_search",{nodes:this._data.search.dom,str:this._data.search.str,res:this._data.search.res}),this._data.search.str="",this._data.search.res=[],this._data.search.opn=[],this._data.search.dom=e()},this._search_open=function(t){var i=this;e.each(t.concat([]),function(r,n){if("#"===n)return!0;try{n=e("#"+n.replace(e.jstree.idregex,"\\$&"),i.element)}catch(s){}n&&n.length&&i.is_closed(n)&&(i._data.search.opn.push(n[0].id),i.open_node(n,function(){i._search_open(t)},0))})}},function(e){e.vakata.search=function(e,t,i){i=i||{},i.fuzzy!==!1&&(i.fuzzy=!0),e=i.caseSensitive?e:e.toLowerCase();var r=i.location||0,n=i.distance||100,s=i.threshold||.6,a=e.length,d,o,l,c;return a>32&&(i.fuzzy=!1),i.fuzzy&&(d=1<<a-1,o=function(){var t={},i=0;for(i=0;a>i;i++)t[e.charAt(i)]=0;for(i=0;a>i;i++)t[e.charAt(i)]|=1<<a-i-1;return t}(),l=function(e,t){var i=e/a,s=Math.abs(r-t);return n?i+s/n:s?1:i}),c=function(t){if(t=i.caseSensitive?t:t.toLowerCase(),e===t||-1!==t.indexOf(e))return{isMatch:!0,score:0};if(!i.fuzzy)return{isMatch:!1,score:1};var n,c,h=t.length,_=s,u=t.indexOf(e,r),g,f,p=a+h,m,v,j,y,x,k=1,b=[];for(-1!==u&&(_=Math.min(l(0,u),_),u=t.lastIndexOf(e,r+a),-1!==u&&(_=Math.min(l(0,u),_))),u=-1,n=0;a>n;n++){g=0,f=p;while(f>g)_>=l(n,r+f)?g=f:p=f,f=Math.floor((p-g)/2+g);for(p=f,v=Math.max(1,r-f+1),j=Math.min(r+f,h)+a,y=Array(j+2),y[j+1]=(1<<n)-1,c=j;c>=v;c--)if(x=o[t.charAt(c-1)],y[c]=0===n?(1|y[c+1]<<1)&x:(1|y[c+1]<<1)&x|(1|(m[c+1]|m[c])<<1)|m[c+1],y[c]&d&&(k=l(n,c-1),_>=k)){if(_=k,u=c-1,b.push(u),!(u>r))break;v=Math.max(1,2*r-u)}if(l(n+1,r)>_)break;m=y}return{isMatch:u>=0,score:k}},t===!0?{search:c}:c(t)}}(jQuery),e.jstree.defaults.sort=function(e,t){return this.get_text(e)>this.get_text(t)?1:-1},e.jstree.plugins.sort=function(t,i){this.bind=function(){i.bind.call(this),this.element.on("model.jstree",e.proxy(function(e,t){this.sort(t.parent,!0)},this)).on("rename_node.jstree create_node.jstree",e.proxy(function(e,t){this.sort(t.parent||t.node.parent,!1),this.redraw_node(t.parent||t.node.parent,!0)},this)).on("move_node.jstree copy_node.jstree",e.proxy(function(e,t){this.sort(t.parent,!1),this.redraw_node(t.parent,!0)},this))},this.sort=function(t,i){var r,n;if(t=this.get_node(t),t&&t.children&&t.children.length&&(t.children.sort(e.proxy(this.settings.sort,this)),i))for(r=0,n=t.children_d.length;n>r;r++)this.sort(t.children_d[r],!1)}};var u=!1;e.jstree.defaults.state={key:"jstree",events:"changed.jstree open_node.jstree close_node.jstree",ttl:!1,filter:!1},e.jstree.plugins.state=function(t,i){this.bind=function(){i.bind.call(this);var t=e.proxy(function(){this.element.on(this.settings.state.events,e.proxy(function(){u&&clearTimeout(u),u=setTimeout(e.proxy(function(){this.save_state()},this),100)},this))},this);this.element.on("ready.jstree",e.proxy(function(e,i){this.element.one("restore_state.jstree",t),this.restore_state()||t()},this))},this.save_state=function(){var t={state:this.get_state(),ttl:this.settings.state.ttl,sec:+new Date};e.vakata.storage.set(this.settings.state.key,JSON.stringify(t))},this.restore_state=function(){var t=e.vakata.storage.get(this.settings.state.key);if(t)try{t=JSON.parse(t)}catch(i){return!1}return t&&t.ttl&&t.sec&&+new Date-t.sec>t.ttl?!1:(t&&t.state&&(t=t.state),t&&e.isFunction(this.settings.state.filter)&&(t=this.settings.state.filter.call(this,t)),t?(this.element.one("set_state.jstree",function(i,r){r.instance.trigger("restore_state",{state:e.extend(!0,{},t)})}),this.set_state(t),!0):!1)},this.clear_state=function(){return e.vakata.storage.del(this.settings.state.key)}},function(e,t){e.vakata.storage={set:function(e,t){return window.localStorage.setItem(e,t)},get:function(e){return window.localStorage.getItem(e)},del:function(e){return window.localStorage.removeItem(e)}}}(jQuery),e.jstree.defaults.types={"#":{},"default":{}},e.jstree.plugins.types=function(i,r){this.init=function(e,i){var n,s;if(i&&i.types&&i.types["default"])for(n in i.types)if("default"!==n&&"#"!==n&&i.types.hasOwnProperty(n))for(s in i.types["default"])i.types["default"].hasOwnProperty(s)&&i.types[n][s]===t&&(i.types[n][s]=i.types["default"][s]);r.init.call(this,e,i),this._model.data["#"].type="#"},this.refresh=function(e){r.refresh.call(this,e),this._model.data["#"].type="#"},this.bind=function(){this.element.on("model.jstree",e.proxy(function(e,i){var r=this._model.data,n=i.nodes,s=this.settings.types,a,d,o="default";for(a=0,d=n.length;d>a;a++)o="default",r[n[a]].original&&r[n[a]].original.type&&s[r[n[a]].original.type]&&(o=r[n[a]].original.type),r[n[a]].data&&r[n[a]].data.jstree&&r[n[a]].data.jstree.type&&s[r[n[a]].data.jstree.type]&&(o=r[n[a]].data.jstree.type),r[n[a]].type=o,r[n[a]].icon===!0&&s[o].icon!==t&&(r[n[a]].icon=s[o].icon)},this)),r.bind.call(this)},this.get_json=function(t,i,n){var s,a,d=this._model.data,o=i?e.extend(!0,{},i,{no_id:!1}):{},l=r.get_json.call(this,t,o,n);if(l===!1)return!1;if(e.isArray(l))for(s=0,a=l.length;a>s;s++)l[s].type=l[s].id&&d[l[s].id]&&d[l[s].id].type?d[l[s].id].type:"default",i&&i.no_id&&(delete l[s].id,l[s].li_attr&&l[s].li_attr.id&&delete l[s].li_attr.id);else l.type=l.id&&d[l.id]&&d[l.id].type?d[l.id].type:"default",i&&i.no_id&&(l=this._delete_ids(l));return l},this._delete_ids=function(t){if(e.isArray(t)){for(var i=0,r=t.length;r>i;i++)t[i]=this._delete_ids(t[i]);return t}return delete t.id,t.li_attr&&t.li_attr.id&&delete t.li_attr.id,t.children&&e.isArray(t.children)&&(t.children=this._delete_ids(t.children)),t},this.check=function(i,n,s,a,d){if(r.check.call(this,i,n,s,a,d)===!1)return!1;n=n&&n.id?n:this.get_node(n),s=s&&s.id?s:this.get_node(s);var o=n&&n.id?e.jstree.reference(n.id):null,l,c,h,_;switch(o=o&&o._model&&o._model.data?o._model.data:null,i){case"create_node":case"move_node":case"copy_node":if("move_node"!==i||-1===e.inArray(n.id,s.children)){if(l=this.get_rules(s),l.max_children!==t&&-1!==l.max_children&&l.max_children===s.children.length)return this._data.core.last_error={error:"check",plugin:"types",id:"types_01",reason:"max_children prevents function: "+i,data:JSON.stringify({chk:i,pos:a,obj:n&&n.id?n.id:!1,par:s&&s.id?s.id:!1})},!1;if(l.valid_children!==t&&-1!==l.valid_children&&-1===e.inArray(n.type,l.valid_children))return this._data.core.last_error={error:"check",plugin:"types",id:"types_02",reason:"valid_children prevents function: "+i,data:JSON.stringify({chk:i,pos:a,obj:n&&n.id?n.id:!1,par:s&&s.id?s.id:!1})},!1;if(o&&n.children_d&&n.parents){for(c=0,h=0,_=n.children_d.length;_>h;h++)c=Math.max(c,o[n.children_d[h]].parents.length);c=c-n.parents.length+1}(0>=c||c===t)&&(c=1);do{if(l.max_depth!==t&&-1!==l.max_depth&&c>l.max_depth)return this._data.core.last_error={error:"check",plugin:"types",id:"types_03",reason:"max_depth prevents function: "+i,data:JSON.stringify({chk:i,pos:a,obj:n&&n.id?n.id:!1,par:s&&s.id?s.id:!1})},!1;s=this.get_node(s.parent),l=this.get_rules(s),c++}while(s)}}return!0},this.get_rules=function(e){if(e=this.get_node(e),!e)return!1;var i=this.get_type(e,!0);return i.max_depth===t&&(i.max_depth=-1),i.max_children===t&&(i.max_children=-1),i.valid_children===t&&(i.valid_children=-1),i},this.get_type=function(t,i){return t=this.get_node(t),t?i?e.extend({type:t.type},this.settings.types[t.type]):t.type:!1},this.set_type=function(i,r){var n,s,a,d,o;if(e.isArray(i)){for(i=i.slice(),s=0,a=i.length;a>s;s++)this.set_type(i[s],r);return!0}return n=this.settings.types,i=this.get_node(i),n[r]&&i?(d=i.type,o=this.get_icon(i),i.type=r,(o===!0||n[d]&&n[d].icon&&o===n[d].icon)&&this.set_icon(i,n[r].icon!==t?n[r].icon:!0),!0):!1}},e.jstree.plugins.unique=function(i,r){this.check=function(t,i,n,s,a){if(r.check.call(this,t,i,n,s,a)===!1)return!1;if(i=i&&i.id?i:this.get_node(i),n=n&&n.id?n:this.get_node(n),!n||!n.children)return!0;var d="rename_node"===t?s:i.text,o=[],l=this._model.data,c,h;for(c=0,h=n.children.length;h>c;c++)o.push(l[n.children[c]].text);switch(t){case"delete_node":return!0;case"rename_node":return c=-1===e.inArray(d,o)||i.text&&i.text===d,c||(this._data.core.last_error={error:"check",plugin:"unique",id:"unique_01",reason:"Child with name "+d+" already exists. Preventing: "+t,data:JSON.stringify({chk:t,pos:s,obj:i&&i.id?i.id:!1,par:n&&n.id?n.id:!1})}),c;case"create_node":return c=-1===e.inArray(d,o),c||(this._data.core.last_error={error:"check",plugin:"unique",id:"unique_04",reason:"Child with name "+d+" already exists. Preventing: "+t,data:JSON.stringify({chk:t,pos:s,obj:i&&i.id?i.id:!1,par:n&&n.id?n.id:!1})}),c;
case"copy_node":return c=-1===e.inArray(d,o),c||(this._data.core.last_error={error:"check",plugin:"unique",id:"unique_02",reason:"Child with name "+d+" already exists. Preventing: "+t,data:JSON.stringify({chk:t,pos:s,obj:i&&i.id?i.id:!1,par:n&&n.id?n.id:!1})}),c;case"move_node":return c=i.parent===n.id||-1===e.inArray(d,o),c||(this._data.core.last_error={error:"check",plugin:"unique",id:"unique_03",reason:"Child with name "+d+" already exists. Preventing: "+t,data:JSON.stringify({chk:t,pos:s,obj:i&&i.id?i.id:!1,par:n&&n.id?n.id:!1})}),c}return!0},this.create_node=function(i,n,s,a,d){if(!n||n.text===t){if(null===i&&(i="#"),i=this.get_node(i),!i)return r.create_node.call(this,i,n,s,a,d);if(s=s===t?"last":s,!(""+s).match(/^(before|after)$/)&&!d&&!this.is_loaded(i))return r.create_node.call(this,i,n,s,a,d);n||(n={});var o,l,c,h,_,u=this._model.data;for(l=o=this.get_string("New node"),c=[],h=0,_=i.children.length;_>h;h++)c.push(u[i.children[h]].text);h=1;while(-1!==e.inArray(l,c))l=o+" ("+ ++h+")";n.text=l}return r.create_node.call(this,i,n,s,a,d)}};var g=document.createElement("DIV");g.setAttribute("unselectable","on"),g.className="jstree-wholerow",g.innerHTML="&#160;",e.jstree.plugins.wholerow=function(t,i){this.bind=function(){i.bind.call(this),this.element.on("ready.jstree set_state.jstree",e.proxy(function(){this.hide_dots()},this)).on("init.jstree loading.jstree ready.jstree",e.proxy(function(){g.style.height=this._data.core.li_height+"px",this.get_container_ul().addClass("jstree-wholerow-ul")},this)).on("deselect_all.jstree",e.proxy(function(e,t){this.element.find(".jstree-wholerow-clicked").removeClass("jstree-wholerow-clicked")},this)).on("changed.jstree",e.proxy(function(e,t){this.element.find(".jstree-wholerow-clicked").removeClass("jstree-wholerow-clicked");var i=!1,r,n;for(r=0,n=t.selected.length;n>r;r++)i=this.get_node(t.selected[r],!0),i&&i.length&&i.children(".jstree-wholerow").addClass("jstree-wholerow-clicked")},this)).on("open_node.jstree",e.proxy(function(e,t){this.get_node(t.node,!0).find(".jstree-clicked").parent().children(".jstree-wholerow").addClass("jstree-wholerow-clicked")},this)).on("hover_node.jstree dehover_node.jstree",e.proxy(function(e,t){this.get_node(t.node,!0).children(".jstree-wholerow")["hover_node"===e.type?"addClass":"removeClass"]("jstree-wholerow-hovered")},this)).on("contextmenu.jstree",".jstree-wholerow",e.proxy(function(t){t.preventDefault();var i=e.Event("contextmenu",{metaKey:t.metaKey,ctrlKey:t.ctrlKey,altKey:t.altKey,shiftKey:t.shiftKey,pageX:t.pageX,pageY:t.pageY});e(t.currentTarget).closest(".jstree-node").children(".jstree-anchor:eq(0)").trigger(i)},this)).on("click.jstree",".jstree-wholerow",function(t){t.stopImmediatePropagation();var i=e.Event("click",{metaKey:t.metaKey,ctrlKey:t.ctrlKey,altKey:t.altKey,shiftKey:t.shiftKey});e(t.currentTarget).closest(".jstree-node").children(".jstree-anchor:eq(0)").trigger(i).focus()}).on("click.jstree",".jstree-leaf > .jstree-ocl",e.proxy(function(t){t.stopImmediatePropagation();var i=e.Event("click",{metaKey:t.metaKey,ctrlKey:t.ctrlKey,altKey:t.altKey,shiftKey:t.shiftKey});e(t.currentTarget).closest(".jstree-node").children(".jstree-anchor:eq(0)").trigger(i).focus()},this)).on("mouseover.jstree",".jstree-wholerow, .jstree-icon",e.proxy(function(e){return e.stopImmediatePropagation(),this.hover_node(e.currentTarget),!1},this)).on("mouseleave.jstree",".jstree-node",e.proxy(function(e){this.dehover_node(e.currentTarget)},this))},this.teardown=function(){this.settings.wholerow&&this.element.find(".jstree-wholerow").remove(),i.teardown.call(this)},this.redraw_node=function(t,r,n){if(t=i.redraw_node.call(this,t,r,n)){var s=g.cloneNode(!0);-1!==e.inArray(t.id,this._data.core.selected)&&(s.className+=" jstree-wholerow-clicked"),t.insertBefore(s,t.childNodes[0])}return t}}}});
window.theme = {};

// Navigation
(function( $ ) {

	'use strict';

	var $items = $( '.nav-main li.nav-parent' );

	function expand( li ) {
		li.children( 'ul.nav-children' ).slideDown( 'fast', function() {
			li.addClass( 'nav-expanded' );
			$(this).css( 'display', '' );
			ensureVisible( li );
		});
	}

	function collapse( li ) {
		li.children('ul.nav-children' ).slideUp( 'fast', function() {
			$(this).css( 'display', '' );
			li.removeClass( 'nav-expanded' );
		});
	}

	function ensureVisible( li ) {
		var scroller = li.offsetParent();
		if ( !scroller.get(0) ) {
			return false;
		}

		var top = li.position().top;
		if ( top < 0 ) {
			scroller.animate({
				scrollTop: scroller.scrollTop() + top
			}, 'fast');
		}
	}

	$items.find('> a').on('click', function() {
		var prev = $( this ).closest('ul.nav').find('> li.nav-expanded' ),
			next = $( this ).closest('li');

		if ( prev.get( 0 ) !== next.get( 0 ) ) {
			collapse( prev );
			expand( next );
		} else {
			collapse( prev );
		}
	});

}).apply( this, [ jQuery ]);

// Skeleton
(function(theme, $) {

	'use strict';

	theme = theme || {};

	var $body		= $( 'body' ),
		$html		= $( 'html' ),
		$window		= $( window ),
		isAndroid	= navigator.userAgent.toLowerCase().indexOf('android') > -1;

	// mobile devices with fixed has a lot of issues when focus inputs and others...
	if ( typeof $.browser !== 'undefined' && $.browser.mobile && $html.hasClass('fixed') ) {
		$html.removeClass( 'fixed' ).addClass( 'scroll' );
	}

	var Skeleton = {

		options: {
			sidebars: {
				menu: '#content-menu',
				left: '#sidebar-left',
				right: '#sidebar-right'
			}
		},

		customScroll: ( !Modernizr.overflowscrolling && !isAndroid && $.fn.nanoScroller !== 'undefined'),

		initialize: function() {
			this
				.setVars()
				.build()
				.events();
		},

		setVars: function() {
			this.sidebars = {};

			this.sidebars.left = {
				$el: $( this.options.sidebars.left )
			};

			this.sidebars.right = {
				$el: $( this.options.sidebars.right ),
				isOpened: $html.hasClass( 'sidebar-right-opened' )
			};

			this.sidebars.menu = {
				$el: $( this.options.sidebars.menu ),
				isOpened: $html.hasClass( 'inner-menu-opened' )
			};

			return this;
		},

		build: function() {

			if ( typeof $.browser !== 'undefined' && $.browser.mobile ) {
				$html.addClass( 'mobile-device' );
			} else {
				$html.addClass( 'no-mobile-device' );
			}

			$html.addClass( 'custom-scroll' );
			if ( this.customScroll ) {
				this.buildSidebarLeft();
				this.buildContentMenu();
			}

			this.buildSidebarRight();

			return this;
		},

		events: function() {
			if ( this.customScroll ) {
				this.eventsSidebarLeft();
			}

			this.eventsSidebarRight();
			this.eventsContentMenu();

			if ( typeof $.browser !== 'undefined' && !this.customScroll && isAndroid ) {
				this.fixScroll();
			}

			return this;
		},

		fixScroll: function() {
			var _self = this;

			$window
				.on( 'sidebar-left-opened sidebar-right-toggle', function( e, data ) {
					_self.preventBodyScrollToggle( data.added );
				});
		},

		buildSidebarLeft: function() {
			this.sidebars.left.$nano = this.sidebars.left.$el.find( '.nano' );


			this.sidebars.left.$nano.nanoScroller({
				alwaysVisible: true,
				preventPageScrolling: true
			});

			return this;
		},

		eventsSidebarLeft: function() {

			var $nano = this.sidebars.left.$nano;

			var updateNanoScroll = function() {
				if ( $.support.transition ) {
					$nano.nanoScroller();
					$nano
						.one('bsTransitionEnd', updateNanoScroll)
						.emulateTransitionEnd(150)
				} else {
					updateNanoScroll();
				}
			};

			this.sidebars.left.$el
				.on( 'click', function() {
					updateNanoScroll();
				});

			$nano
				.on( 'mouseenter', function() {
					if ( $html.hasClass( 'sidebar-left-collapsed' ) ) {
						$nano.nanoScroller();
					}
				})
				.on( 'mouseleave', function() {
					if ( $html.hasClass( 'sidebar-left-collapsed' ) ) {
						$nano.nanoScroller();
					}
				});

			return this;
		},

		buildSidebarRight: function() {
			this.sidebars.right.isOpened = $html.hasClass( 'sidebar-right-opened' );

			if ( this.customScroll ) {
				this.sidebars.right.$nano = this.sidebars.right.$el.find( '.nano' );

				this.sidebars.right.$nano.nanoScroller({
					alwaysVisible: true,
					preventPageScrolling: true
				});
			}

			return this;
		},

		eventsSidebarRight: function() {
			var _self = this;

			var open = function() {
				if ( _self.sidebars.right.isOpened ) {
					return close();
				}

				_self.sidebars.right.isOpened = true;

				$html.addClass( 'sidebar-right-opened' );

				$window.trigger( 'sidebar-right-toggle', {
					added: true,
					removed: false
				});

				$html.on( 'click.close-right-sidebar', function(e) {
					e.stopPropagation();
					close(e);
				});
			};

			var close = function(e) {
				if ( !!e && !!e.target && ($(e.target).closest( '.sidebar-right' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
					e.preventDefault();
					return false;
				}

				$html.removeClass( 'sidebar-right-opened' );
				$html.off( 'click.close-right-sidebar' );

				$window.trigger( 'sidebar-right-toggle', {
					added: false,
					removed: true
				});

				_self.sidebars.right.isOpened = false;
			};

			var bind = function() {
				$('[data-open="sidebar-right"]').on('click', function(e) {
					var $el = $(this);
					e.stopPropagation();

					if ( $el.is('a') )
						e.preventDefault();

					open();
				});
			};

			this.sidebars.right.$el.find( '.mobile-close' )
				.on( 'click', function( e ) {
					e.preventDefault();
					$html.trigger( 'click.close-right-sidebar' );
				});

			bind();

			return this;
		},

		buildContentMenu: function() {
			if ( !$html.hasClass( 'fixed' ) ) {
				return false;
			}

			this.sidebars.menu.$nano = this.sidebars.menu.$el.find( '.nano' );

			this.sidebars.menu.$nano.nanoScroller({
				alwaysVisible: true,
				preventPageScrolling: true
			});

			return this;
		},

		eventsContentMenu: function() {
			var _self = this;

			var open = function() {
				if ( _self.sidebars.menu.isOpened ) {
					return close();
				}

				_self.sidebars.menu.isOpened = true;

				$html.addClass( 'inner-menu-opened' );

				$window.trigger( 'inner-menu-toggle', {
					added: true,
					removed: false
				});

				$html.on( 'click.close-inner-menu', function(e) {

					close(e);
				});

			};

			var close = function(e) {
				if ( !!e && !!e.target && !$(e.target).closest( '.inner-menu-collapse' ).get(0) && ($(e.target).closest( '.inner-menu' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
					return false;
				}

				e.stopPropagation();

				$html.removeClass( 'inner-menu-opened' );
				$html.off( 'click.close-inner-menu' );

				$window.trigger( 'inner-menu-toggle', {
					added: false,
					removed: true
				});

				_self.sidebars.menu.isOpened = false;
			};

			var bind = function() {
				$('[data-open="inner-menu"]').on('click', function(e) {
					var $el = $(this);
					e.stopPropagation();

					if ( $el.is('a') )
						e.preventDefault();

					open();
				});
			};

			bind();

			/* Nano Scroll */
			if ( $html.hasClass( 'fixed' ) ) {
				var $nano = this.sidebars.menu.$nano;

				var updateNanoScroll = function() {
					if ( $.support.transition ) {
						$nano.nanoScroller();
						$nano
							.one('bsTransitionEnd', updateNanoScroll)
							.emulateTransitionEnd(150)
					} else {
						updateNanoScroll();
					}
				};

				this.sidebars.menu.$el
					.on( 'click', function() {
						updateNanoScroll();
					});
			}

			return this;
		},

		preventBodyScrollToggle: function( shouldPrevent, $el ) {
			setTimeout(function() {
				if ( shouldPrevent ) {
					$body
						.data( 'scrollTop', $body.get(0).scrollTop )
						.css({
							position: 'fixed',
							top: $body.get(0).scrollTop * -1
						})
				} else {
					$body
						.css({
							position: '',
							top: ''
						})
						.scrollTop( $body.data( 'scrollTop' ) );
				}
			}, 150);
		}

	};

	// expose to scope
	$.extend(theme, {
		Skeleton: Skeleton
	});

}).apply(this, [ window.theme, jQuery ]);

// Base
(function(theme, $) {

	'use strict';

	theme = theme || {};

	theme.Skeleton.initialize();

}).apply(this, [ window.theme, jQuery ]);

/*
Name: 			Theme Admin Extension
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

window.theme = {};

// Mailbox
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__mailbox';

	var capitalizeString = function( str ) {
    	return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	}

	var Mailbox = function($wrapper) {
		return this.initialize($wrapper);
	};

	Mailbox.prototype = {
		initialize: function($wrapper) {
			if ( $wrapper.data( instanceName ) ) {
				return this;
			}

			this.$wrapper = $wrapper;

			this
				.setVars()
				.setData()
				.build()
				.events();

			return this;
		},

		setVars: function() {
			this.view = capitalizeString( this.$wrapper.data( 'mailbox-view' ) || "" );

			return this;
		},

		setData: function() {
			this.$wrapper.data(instanceName, this);

			return this;
		},

		build: function() {

			if ( typeof this[ 'build' + this.view ] === 'function' ) {
				this[ 'build' + this.view ].call( this );
			}


			return this;
		},

		events: function() {
			if ( typeof this[ 'events' + this.view ] === 'function' ) {
				this[ 'events' + this.view ].call( this );
			}

			return this;
		},

		buildFolder: function() {
			this.$wrapper.find('.mailbox-email-list .nano').nanoScroller({
				alwaysVisible: true,
				preventPageScrolling: true
			});
		},

		buildEmail: function() {
			this.buildComposer();
		},

		buildCompose: function() {
			this.buildComposer();
		},

		buildComposer: function() {
			this.$wrapper.find( '#compose-field' ).summernote({
				height: 250,
				toolbar: [
					['style', ['style']],
					['font', ['bold', 'italic', 'underline', 'clear']],
					['fontname', ['fontname']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					['table', ['table']],
					['insert', ['link', 'picture', 'video']],
					['view', ['fullscreen']],
					['help', ['help']]
				]
			});
		},

		eventsCompose: function() {
			var $composer,
				$contentBody,
				$html,
				$innerBody;

			$composer		= $( '.note-editable' );
			$contentBody	= $( '.content-body' );
			$html			= $( 'html' );
			$innerBody		= $( '.inner-body' );

			var adjustComposeSize = function() {
				var composerHeight,
					composerTop,
					contentBodyPaddingBottom,
					innerBodyHeight,
					viewportHeight,
					viewportWidth;


				contentBodyPaddingBottom	= parseInt( $contentBody.css('paddingBottom'), 10 ) || 0;
				viewportHeight				= Math.max( document.documentElement.clientHeight, window.innerHeight || 0 );
				viewportWidth				= Math.max( document.documentElement.clientWidth, window.innerWidth || 0 );

				$composer.css( 'height', '' );

				if ( viewportWidth < 767 || $html.hasClass('mobile-device') ) {
					composerTop	   = $composer.offset().top;
					composerHeight = viewportHeight - composerTop;
				} else {
					if ( $html.hasClass( 'fixed' ) ) {
						composerTop	= $composer.offset().top;
					} else {
						composerTop	= $composer.position().top;
					}
					composerHeight = $innerBody.outerHeight() - composerTop;
				}

				composerHeight -= contentBodyPaddingBottom;

				$composer.css({
					height: composerHeight
				});
			};

			var timer;
			$(window)
				.on( 'resize orientationchange sidebar-left-toggle mailbox-recalc', function() {
					clearTimeout( timer );
					timer = setTimeout(function() {
						adjustComposeSize();
					}, 100);
				});

			adjustComposeSize();
		}
	};

	// expose to scope
	$.extend(theme, {
		Mailbox: Mailbox
	});

	// jquery plugin
	$.fn.themeMailbox = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new Mailbox($this);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Lock Screen
(function( $ ) {

	'use strict';

	var LockScreen = {

		initialize: function() {
			this.$body = $( 'body' );

			this
				.build()
				.events();
		},

		build: function() {
			var lockHTML,
				userinfo;

			userinfo = this.getUserInfo();
			this.lockHTML = this.buildTemplate( userinfo );

			this.$lock        = this.$body.children( '#LockScreenInline' );
			this.$userPicture = this.$lock.find( '#LockUserPicture' );
			this.$userName    = this.$lock.find( '#LockUserName' );
			this.$userEmail   = this.$lock.find( '#LockUserEmail' );

			return this;
		},

		events: function() {
			var _self = this;

			this.$body.find( '[data-lock-screen="true"]' ).on( 'click', function( e ) {
				e.preventDefault();

				_self.show();
			});

			return this;
		},

		formEvents: function( $form ) {
			var _self = this;

			$form.on( 'submit', function( e ) {
				e.preventDefault();

				_self.hide();
			});
		},

		show: function() {
			var _self = this,
				userinfo = this.getUserInfo();

			this.$userPicture.attr( 'src', userinfo.picture );
			this.$userName.text( userinfo.username );
			this.$userEmail.text( userinfo.email );

			this.$body.addClass( 'show-lock-screen' );

			$.magnificPopup.open({
				items: {
					src: this.lockHTML,
					type: 'inline'
				},
				modal: true,
				mainClass: 'mfp-lock-screen',
				callbacks: {
					change: function() {
						_self.formEvents( this.content.find( 'form' ) );
					}
				}
			});
		},

		hide: function() {
			$.magnificPopup.close();
		},

		getUserInfo: function() {
			var $info,
				picture,
				name,
				email;

			// always search in case something is changed through ajax
			$info    = $( '#userbox' );
			picture  = $info.find( '.profile-picture img' ).attr( 'data-lock-picture' );
			name     = $info.find( '.profile-info' ).attr( 'data-lock-name' );
			email    = $info.find( '.profile-info' ).attr( 'data-lock-email' );

			return {
				picture: picture,
				username: name,
				email: email
			};
		},

		buildTemplate: function( userinfo ) {
			return [
					'<section id="LockScreenInline" class="body-sign body-locked body-locked-inline">',
						'<div class="center-sign">',
							'<div class="panel panel-sign">',
								'<div class="panel-body">',
									'<form>',
										'<div class="current-user text-center">',
											'<img id="LockUserPicture" src="{{picture}}" alt="John Doe" class="img-circle user-image" />',
											'<h2 id="LockUserName" class="user-name text-dark m-none">{{username}}</h2>',
											'<p  id="LockUserEmail" class="user-email m-none">{{email}}</p>',
										'</div>',
										'<div class="form-group mb-lg">',
											'<div class="input-group input-group-icon">',
												'<input id="pwd" name="pwd" type="password" class="form-control input-lg" placeholder="Password" />',
												'<span class="input-group-addon">',
													'<span class="icon icon-lg">',
														'<i class="fa fa-lock"></i>',
													'</span>',
												'</span>',
											'</div>',
										'</div>',

										'<div class="row">',
											'<div class="col-xs-6">',
												'<p class="mt-xs mb-none">',
													'<a href="#">Not John Doe?</a>',
												'</p>',
											'</div>',
											'<div class="col-xs-6 text-right">',
												'<button type="submit" class="btn btn-primary">Unlock</button>',
											'</div>',
										'</div>',
									'</form>',
								'</div>',
							'</div>',
						'</div>',
					'</section>'
				]
				.join( '' )
				.replace( /\{\{picture\}\}/, userinfo.picture )
				.replace( /\{\{username\}\}/, userinfo.username )
				.replace( /\{\{email\}\}/, userinfo.email );
		}

	};

	this.LockScreen = LockScreen;

	$(function() {
		LockScreen.initialize();
	});

}).apply(this, [ jQuery ]);

// Panels
(function( $ ) {

	$(function() {
		$('.panel')
			.on( 'click', '.panel-actions a.fa-caret-up', function( e ) {
				e.preventDefault();

				var $this,
					$panel;

				$this = $( this );
				$panel = $this.closest( '.panel' );

				$this
					.removeClass( 'fa-caret-up' )
					.addClass( 'fa-caret-down' );

				$panel.find('.panel-body, .panel-footer').slideDown( 200 );
			})
			.on( 'click', '.panel-actions a.fa-caret-down', function( e ) {
				e.preventDefault();

				var $this,
					$panel;

				$this = $( this );
				$panel = $this.closest( '.panel' );

				$this
					.removeClass( 'fa-caret-down' )
					.addClass( 'fa-caret-up' );

				$panel.find('.panel-body, .panel-footer').slideUp( 200 );
			})
			.on( 'click', '.panel-actions a.fa-times', function( e ) {
				e.preventDefault();

				var $panel,
					$row;

				$panel = $(this).closest('.panel');

				if ( !!( $panel.parent('div').attr('class') || '' ).match( /col-(xs|sm|md|lg)/g ) && $panel.siblings().length === 0 ) {
					$row = $panel.closest('.row');
					$panel.parent('div').remove();
					if ( $row.children().length === 0 ) {
						$row.remove();
					}
				} else {
					$panel.remove();
				}
			});
	});

})( jQuery );

// Bootstrap Toggle
(function( $ ) {

	'use strict';

	var $window = $( window );

	var toggleClass = function( $el ) {
		if ( !!$el.data('toggleClassBinded') ) {
			return false;
		}

		var $target,
			className,
			eventName;

		$target = $( $el.attr('data-target') );
		className = $el.attr('data-toggle-class');
		eventName = $el.attr('data-fire-event');


		$el.on('click.toggleClass', function(e) {
			e.preventDefault();
			$target.toggleClass( className );

			var hasClass = $target.hasClass( className );

			if ( !!eventName ) {
				$window.trigger( eventName, {
					added: hasClass,
					removed: !hasClass
				});
			}
		});

		$el.data('toggleClassBinded', true);

		return true;
	};

	$(function() {
		$('[data-toggle-class][data-target]').each(function() {
			toggleClass( $(this) );
		});
	});

}).apply( this, [ jQuery ]);

// Form to Object
(function( $ ) {

	'use strict';

	$.fn.formToObject = function() {
		var arrayData,
			objectData;

		arrayData	= this.serializeArray();
		objectData	= {};

		$.each( arrayData, function() {
			var value;

			if (this.value != null) {
				value = this.value;
			} else {
				value = '';
			}

			if (objectData[this.name] != null) {
				if (!objectData[this.name].push) {
					objectData[this.name] = [objectData[this.name]];
				}

				objectData[this.name].push(value);
			} else {
				objectData[this.name] = value;
			}
		});

		return objectData;
	};

})( jQuery );

// Codemirror
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__codemirror';

	var PluginCodeMirror = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginCodeMirror.defaults = {
		lineNumbers: true,
		styleActiveLine: true,
		matchBrackets: true,
		theme: 'monokai'
	};

	PluginCodeMirror.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginCodeMirror.defaults, opts );

			return this;
		},

		build: function() {
			CodeMirror.fromTextArea( this.$el.get(0), this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginCodeMirror: PluginCodeMirror
	});

	// jquery plugin
	$.fn.themePluginCodeMirror = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginCodeMirror($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Colorpicker
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__colorpicker';

	var PluginColorPicker = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginColorPicker.defaults = {
	};

	PluginColorPicker.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginColorPicker.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.colorpicker( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginColorPicker: PluginColorPicker
	});

	// jquery plugin
	$.fn.themePluginColorPicker = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginColorPicker($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Datepicker
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__datepicker';

	var PluginDatePicker = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginDatePicker.defaults = {
	};

	PluginDatePicker.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setVars()
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setVars: function() {
			this.skin = this.$el.data( 'plugin-skin' );

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginDatePicker.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.datepicker( this.options );

			if ( !!this.skin ) {
				this.$el.data('datepicker').picker.addClass( 'datepicker-' + this.skin );
			}

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginDatePicker: PluginDatePicker
	});

	// jquery plugin
	$.fn.themePluginDatePicker = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginDatePicker($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// iosSwitcher
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__IOS7Switch';

	var PluginIOS7Switch = function($el) {
		return this.initialize($el);
	};

	PluginIOS7Switch.prototype = {
		initialize: function($el) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		build: function() {
			var switcher = new Switch( this.$el.get(0) );

			$( switcher.el ).on( 'click', function( e ) {
				e.preventDefault();
				switcher.toggle();
			});

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginIOS7Switch: PluginIOS7Switch
	});

	// jquery plugin
	$.fn.themePluginIOS7Switch = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginIOS7Switch($this);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Markdown
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__markdownEditor';

	var PluginMarkdownEditor = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMarkdownEditor.defaults = {
		iconlibrary: 'fa'
	};

	PluginMarkdownEditor.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginMarkdownEditor.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.markdown( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMarkdownEditor: PluginMarkdownEditor
	});

	// jquery plugin
	$.fn.themePluginMarkdownEditor = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMarkdownEditor($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Masked Input
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__maskedInput';

	var PluginMaskedInput = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMaskedInput.defaults = {
	};

	PluginMaskedInput.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginMaskedInput.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.mask( this.$el.data('input-mask'), this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMaskedInput: PluginMaskedInput
	});

	// jquery plugin
	$.fn.themePluginMaskedInput = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMaskedInput($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// MaxLength
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__maxlength';

	var PluginMaxLength = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMaxLength.defaults = {
		alwaysShow: true,
		placement: 'bottom-left',
		warningClass: 'label label-success bottom-left',
		limitReachedClass: 'label label-danger bottom-left'
	};

	PluginMaxLength.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginMaxLength.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.maxlength( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMaxLength: PluginMaxLength
	});

	// jquery plugin
	$.fn.themePluginMaxLength = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMaxLength($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// MultiSelect
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__multiselect';

	var PluginMultiSelect = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMultiSelect.defaults = {
		templates: {
			filter: '<div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div>'
		}
	};

	PluginMultiSelect.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginMultiSelect.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.multiselect( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMultiSelect: PluginMultiSelect
	});

	// jquery plugin
	$.fn.themePluginMultiSelect = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMultiSelect($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Select2
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__select2';

	var PluginSelect2 = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginSelect2.defaults = {
	};

	PluginSelect2.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginSelect2.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.select2( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginSelect2: PluginSelect2
	});

	// jquery plugin
	$.fn.themePluginSelect2 = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginSelect2($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Spinner
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__spinner';

	var PluginSpinner = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginSpinner.defaults = {
	};

	PluginSpinner.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginSpinner.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.spinner( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginSpinner: PluginSpinner
	});

	// jquery plugin
	$.fn.themePluginSpinner = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginSpinner($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// SummerNote
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__summernote';

	var PluginSummerNote = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginSummerNote.defaults = {
		onfocus: function() {
			$( this ).closest( '.note-editor' ).addClass( 'active' );
		},
		onblur: function() {
			$( this ).closest( '.note-editor' ).removeClass( 'active' );
		}
	};

	PluginSummerNote.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginSummerNote.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.summernote( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginSummerNote: PluginSummerNote
	});

	// jquery plugin
	$.fn.themePluginSummerNote = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginSummerNote($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// TextArea AutoSize
(function(theme, $) {

	theme = theme || {};

	var initialized = false;
	var instanceName = '__textareaAutosize';

	var PluginTextAreaAutoSize = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginTextAreaAutoSize.defaults = {
	};

	PluginTextAreaAutoSize.prototype = {
		initialize: function($el, opts) {
			if (initialized) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginTextAreaAutoSize.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.autosize( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginTextAreaAutoSize: PluginTextAreaAutoSize
	});

	// jquery plugin
	$.fn.themePluginTextAreaAutoSize = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginTextAreaAutoSize($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// TimePicker
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__timepicker';

	var PluginTimePicker = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginTimePicker.defaults = {
		disableMousewheel: true
	};

	PluginTimePicker.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginTimePicker.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.timepicker( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginTimePicker: PluginTimePicker
	});

	// jquery plugin
	$.fn.themePluginTimePicker = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginTimePicker($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Map Builder
(function( theme, $ ) {

	'use strict';

	// prevent undefined var
	theme = theme || {};

	// internal var to check if reached limit
	var timeouts = 0;

	// instance
	var instanceName = '__gmapbuilder';

	// private
	var roundNumber = function( number, precision ) {
		if( precision < 0 ) {
			precision = 0;
		} else if( precision > 10 ) {
			precision = 10;
		}
		var a = [ 1, 10, 100, 1000, 10000, 100000, 1000000, 10000000, 100000000, 1000000000, 10000000000 ];

		return Math.round( number * a[ precision ] ) / a[ precision ];
	};

	// definition
	var GMapBuilder = function( $wrapper, opts ) {
		return this.initialize( $wrapper, opts );
	};

	GMapBuilder.defaults = {
		mapSelector: '#gmap',

		markers: {
			modal: '#MarkerModal',
			list: '#MarkersList',
			removeAll: '#MarkerRemoveAll'
		},

		previewModal: '#ModalPreview',
		getCodeModal: '#ModalGetCode',

		mapOptions: {
			center: {
				lat: -38.908133,
				lng: -13.692628
			},
			panControl: true,
			zoom: 3
		}
	};

	GMapBuilder.prototype = {

		markers: [],

		initialize: function( $wrapper, opts ) {
			this.$wrapper = $wrapper;

			this
				.setData()
				.setOptions( opts )
				.setVars()
				.build()
				.events();

			return this;
		},

		setData: function() {
			this.$wrapper.data( instanceName, this );

			return this;
		},

		setOptions: function( opts ) {
			this.options = $.extend( true, {}, GMapBuilder.defaults, opts );

			return this;
		},

		setVars: function() {
			this.$mapContainer		= this.$wrapper.find( this.options.mapSelector );

			this.$previewModal		= $( this.options.previewModal );
			this.$getCodeModal		= $( this.options.getCodeModal );

			this.marker				= {};
			this.marker.$modal  	= $( this.options.markers.modal );
			this.marker.$form		= this.marker.$modal.find( 'form' );
			this.marker.$list		= $( this.options.markers.list );
			this.marker.$removeAll	= $( this.options.markers.removeAll );

			return this;
		},

		build: function() {
			var _self = this;

			if ( !!window.SnazzyThemes ) {
				var themeOpts = [];

				$.each( window.SnazzyThemes, function( i, theme ) {
					themeOpts.push( $('<option value="' + theme.id + '">' + theme.name + '</option>').data( 'json', theme.json ) );
				});

				this.$wrapper.find( '[data-builder-field="maptheme"]' ).append( themeOpts );
			}

			this.geocoder = new google.maps.Geocoder();

			google.maps.event.addDomListener( window, 'load', function() {
				_self.options.mapOptions.center = new google.maps.LatLng( _self.options.mapOptions.center.lat, _self.options.mapOptions.center.lng );

				_self.map = new google.maps.Map( _self.$mapContainer.get(0), _self.options.mapOptions );

				_self
					.updateControl( 'latlng' )
					.updateControl( 'zoomlevel' );

				_self.mapEvents();
			});

			return this;
		},

		events: function() {
			var _self = this;

			this.$wrapper.find( '[data-builder-field]' ).each(function() {
				var $this = $( this ),
					field,
					value;

				field = $this.data( 'builder-field' );

				$this.on( 'change', function() {

					if ( $this.is( 'select' ) ) {
						value = $this.children( 'option:selected' ).val().toLowerCase();
					} else {
						value = $this.val().toLowerCase();
					}

					_self.updateMap( field, value );
				});

			});

			this.marker.$form.on( 'submit', function( e ) {
				e.preventDefault();

				_self.saveMarker( _self.marker.$form.formToObject() );
			});

			this.marker.$removeAll.on( 'click', function( e ) {
				e.preventDefault();
				_self.removeAllMarkers();
			});

			// preview events
			this.$previewModal.on( 'shown.bs.modal', function() {
				_self.preview();
			});

			this.$previewModal.on( 'hidden.bs.modal', function() {
				_self.$previewModal.find( 'iframe' ).get(0).contentWindow.document.body.innerHTML = '';
			});

			// get code events
			this.$getCodeModal.on( 'shown.bs.modal', function() {
				_self.getCode();
			});

			return this;
		},

		// MAP FUNCTIONS
		// -----------------------------------------------------------------------------
		mapEvents: function() {
			var _self = this;

			google.maps.event.addDomListener( _self.map, 'resize', function() {
				google.maps.event.trigger( _self.map, 'resize' );
			});

			google.maps.event.addListener( this.map, 'center_changed', function() {
				var coords = _self.map.getCenter();
				_self.updateControl( 'latlng', {
					lat: roundNumber( coords.lat(), 6 ),
					lng: roundNumber( coords.lng(), 6 )
				});
			});

			google.maps.event.addListener( this.map, 'zoom_changed', function() {
				_self.updateControl( 'zoomlevel', _self.map.getZoom() );
			});

			google.maps.event.addListener( this.map, 'maptypeid_changed', function() {
				_self.updateControl( 'maptype', _self.map.getMapTypeId() );
			});

			return this;
		},

		updateMap: function( prop, value ) {
			var updateFn;

			updateFn = this.updateMapProperty[ prop ];

			if ( $.isFunction( updateFn ) ) {
				updateFn.apply( this, [ value ] );
			} else {
				console.info( 'missing update function for', prop );
			}

			return this;
		},

		updateMapProperty: {

			latlng: function() {
				var lat,
					lng;

				lat = this.$wrapper.find('[data-builder-field][name="latitude"]').val();
				lng = this.$wrapper.find('[data-builder-field][name="longitude"]').val();

				if ( lat.length > 0 && lng.length > 0 ) {
					this.map.setCenter( new google.maps.LatLng( lat, lng ) );
				}

				return this;
			},

			zoomlevel: function( value ) {
				var value = arguments[ 0 ];

				this.map.setZoom( parseInt( value, 10 ) );

				return this;
			},

			maptypecontrol: function( value ) {
				var options;

				options	= {};

				if ( value === 'false' ){
					options.mapTypeControl = false;
				} else {
					options = {
						mapTypeControl: true,
						mapTypeControlOptions: {
							style: google.maps.MapTypeControlStyle[ value.toUpperCase() ]
						}
					};
				}

				this.map.setOptions( options );

				return this;
			},

			zoomcontrol: function( value ) {
				var options;

				options	= {};

				if ( value === 'false' ){
					options.zoomControl = false;
				} else {
					options = {
						zoomControl: true,
						zoomControlOptions: {
							style: google.maps.ZoomControlStyle[ value.toUpperCase() ]
						}
					};
				}

				this.map.setOptions( options );

				return this;
			},

			scalecontrol: function( value ) {
				var options;

				options	= {};

				options.scaleControl = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			streetviewcontrol: function( value ) {
				var options;

				options	= {};

				options.streetViewControl = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			pancontrol: function( value ) {
				var options;

				options	= {};

				options.panControl = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			overviewcontrol: function( value ) {
				var options;

				options	= {};

				if ( value === 'false' ){
					options.overviewMapControl = false;
				} else {
					options = {
						overviewMapControl: true,
						overviewMapControlOptions: {
							opened: value === 'opened'
						}
					};
				}

				this.map.setOptions( options );

				return this;
			},

			draggablecontrol: function( value ) {
				var options;

				options	= {};

				options.draggable = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			clicktozoomcontrol: function( value ) {
				var options;

				options	= {};

				options.disableDoubleClickZoom = value === 'false';

				this.map.setOptions( options );

				return this;
			},

			scrollwheelcontrol: function( value ) {
				var options;

				options	= {};

				options.scrollwheel = value !== 'false';

				this.map.setOptions( options );

				return this;
			},

			maptype: function( value ) {
				var options,
					mapStyles,
					mapType;

				mapStyles = this.$wrapper.find( '[data-builder-field="maptheme"]' ).children( 'option' ).filter( ':selected' ).data( 'json' );
				mapType =  google.maps.MapTypeId[ value.toUpperCase() ];

				options	= {
					mapTypeId: mapType
				};

				if ( $.inArray( google.maps.MapTypeId[ value.toUpperCase() ], [ 'terrain', 'roadmap' ]) > -1 && !!mapStyles ) {
					options.styles = eval( mapStyles );
				} else {
					options.styles = false;
					this.updateControl( 'maptheme' );
				}

				this.map.setOptions( options );
			},

			maptheme: function( value ) {
				var json,
					mapType,
					options;

				mapType = google.maps.MapTypeId[ this.map.getMapTypeId() === 'terrain' ? 'TERRAIN' : 'ROADMAP' ];
				options = {};
				json = this.$wrapper.find( '[data-builder-field="maptheme"]' ).children( 'option' ).filter( ':selected' ).data( 'json' );

				if ( !json ) {
					options = {
						mapTypeId: mapType,
						styles: false
					};
				} else {
					options = {
						mapTypeId: mapType,
						styles: eval( json )
					};
				}

				this.map.setOptions( options );
			}

		},

		// CONTROLS FUNCTIONS
		// -----------------------------------------------------------------------------
		updateControl: function( prop ) {
			var updateFn;

			updateFn = this.updateControlValue[ prop ];

			if ( $.isFunction( updateFn ) ) {
				updateFn.apply( this );
			} else {
				console.info( 'missing update function for', prop );
			}

			return this;
		},

		updateControlValue: {

			latlng: function() {
				var center = this.map.getCenter();

				this.$wrapper.find('[data-builder-field][name="latitude"]').val( roundNumber( center.lat() , 6 ) );
				this.$wrapper.find('[data-builder-field][name="longitude"]').val( roundNumber( center.lng() , 6 ) );
			},

			zoomlevel: function() {
				var $control,
					level;

				level = this.map.getZoom();

				$control = this.$wrapper.find('[data-builder-field="zoomlevel"]');

				$control
					.children( 'option[value="' + level + '"]' )
					.prop( 'selected', true );

				if ( $control.hasClass( 'select2-offscreen' ) ) {
					$control.select2( 'val', level );
				}
			},

			maptype: function() {
				var $control,
					mapType;

				mapType = this.map.getMapTypeId();
				$control = this.$wrapper.find('[data-builder-field="maptype"]');

				$control
					.children( 'option[value="' + mapType + '"]' )
					.prop( 'selected', true );

				if ( $control.hasClass( 'select2-offscreen' ) ) {
					$control.select2( 'val', mapType );
				}
			},

			maptheme: function() {
				var $control;

				$control = this.$wrapper.find('[data-builder-field="maptheme"]');

				$control
					.children( 'option[value="false"]' )
					.prop( 'selected', true );

				if ( $control.hasClass( 'select2-offscreen' ) ) {
					$control.select2( 'val', 'false' );
				}
			}

		},

		// MARKERS FUNCTIONS
		// -----------------------------------------------------------------------------
		editMarker: function( marker ) {
			this.currentMarker = marker;

			this.marker.$form
				.find( '#MarkerLocation' ).val( marker.location );

			this.marker.$form
				.find( '#MarkerTitle' ).val( marker.title );

			this.marker.$form
				.find( '#MarkerDescription' ).val( marker.description );

			this.marker.$modal.modal( 'show' );
		},

		removeMarker: function( marker ) {
			var i;

			marker._instance.setMap( null );
			marker._$html.remove();

			for( i = 0; i < this.markers.length; i++ ) {
				if ( marker === this.markers[ i ] ) {
					this.markers.splice( i, 1 );
					break;
				}
			}

			if ( this.markers.length === 0 ) {
				this.marker.$list.addClass( 'hidden' );
			}
		},

		saveMarker: function( marker ) {
			this._geocode( marker );
		},

		removeAllMarkers: function() {
			var i = 0,
				l,
				marker;

			l = this.markers.length;

			for( ; i < l; i++ ) {
				marker = this.markers[ i ];

				marker._instance.setMap( null );
				marker._$html.remove();
			}

			this.markers = [];
			this.marker.$list.addClass( 'hidden' );
		},

		_geocode: function( marker ) {
			var _self = this,
				status;

			this.geocoder.geocode({ address: marker.location }, function( response, status ) {
				_self._onGeocodeResult( marker, response, status );
			});
		},

		_onGeocodeResult: function( marker, response, status ) {
			var result;

			if ( !response || status !== google.maps.GeocoderStatus.OK ) {
				if ( status == google.maps.GeocoderStatus.ZERO_RESULTS ) {
					// show notification
				} else {
					timeouts++;
					if ( timeouts > 3 ) {
						// show notification reached limit of requests
					}
				}
			} else {
				timeouts = 0;

				if ( this.currentMarker ) {
					this.removeMarker( this.currentMarker );
					this.currentMarker = null;
				}

				// grab first result of the list
				result = response[ 0 ];

				// get lat & lng and set to marker
				marker.lat = Math.round( result.geometry.location.lat() * 1000000 ) / 1000000;
				marker.lng = Math.round( result.geometry.location.lng() * 1000000 ) / 1000000;

				var opts = {
					position: new google.maps.LatLng( marker.lat, marker.lng ),
					map: this.map
				};

				if ( marker.title.length > 0 ) {
					opts.title = marker.title;
				}

				if ( marker.description.length > 0 ) {
					opts.desc = marker.description;
				}

				marker.position = opts.position;
				marker._instance = new google.maps.Marker( opts );

				if ( !!marker.title || !!marker.description  ) {
					this._bindMarkerClick( marker );
				}

				this.markers.push( marker );

				// append to markers list
				this._appendMarkerToList( marker );

				// hide modal and reset form
				this.marker.$form.get(0).reset();
				this.marker.$modal.modal( 'hide' );
			}
		},

		_appendMarkerToList: function( marker ) {
			var _self = this,
				html;

			html = [
				'<li>',
					'<p>{location}</p>',
					'<a href="#" class="location-action location-center"><i class="fa fa-map-marker"></i></a>',
					'<a href="#" class="location-action location-edit"><i class="fa fa-edit"></i></a>',
					'<a href="#" class="location-action location-remove text-danger"><i class="fa fa-times"></i></a>',
				'</li>'
			].join('');

			html = html.replace( /\{location\}/, !!marker.title ? marker.title : marker.location );

			marker._$html = $( html );

			// events
			marker._$html.find( '.location-center' )
				.on( 'click', function( e ) {
					_self.map.setCenter( marker.position );
				});

			marker._$html.find( '.location-remove' )
				.on( 'click', function( e ) {
					e.preventDefault();
					_self.removeMarker( marker );
				});

			marker._$html.find( '.location-edit' )
				.on( 'click', function( e ) {
					e.preventDefault();
					_self.editMarker( marker );
				});

			this.marker.$list
				.append( marker._$html )
				.removeClass( 'hidden' );
		},

		_bindMarkerClick: function( marker ) {
			var _self = this,
				html;

			html = [
				'<div style="background-color: #FFF; color: #000; padding: 5px; width: 150px;">',
					'{title}',
					'{description}',
				'</div>'
			].join('');

			html = html.replace(/\{title\}/, !!marker.title ?  ("<h4>" + marker.title + "</h4>") : "" );
			html = html.replace(/\{description\}/, !!marker.description ?  ("<p>" + marker.description + "</p>") : "" );

			marker._infoWindow = new google.maps.InfoWindow({ content: html });

			google.maps.event.addListener( marker._instance, 'click', function() {

				if ( marker._infoWindow.isOpened ) {
					marker._infoWindow.close();
					marker._infoWindow.isOpened = false;
				} else {
					marker._infoWindow.open( _self.map, this );
					marker._infoWindow.isOpened = true;
				}

			});
		},

		preview: function() {
			var customScript,
				googleScript,
				iframe,
				previewHtml;

			previewHtml = [
				'<style>',
					'html, body { margin: 0; padding: 0; }',
				'</style>',
				'<div id="' + this.$wrapper.find('[data-builder-field="mapid"]').val() + '" style="width: 100%; height: 100%;"></div>'
			];

			iframe = this.$previewModal.find( 'iframe' ).get(0).contentWindow.document;

			iframe.body.innerHTML = previewHtml.join('');

			customScript = iframe.createElement( 'script' );
			customScript.type = 'text/javascript';
			customScript.text = "window.initialize = function() { " + this.generate() + " init(); }; ";
			iframe.body.appendChild( customScript );

			googleScript = iframe.createElement( 'script' );
			googleScript.type = 'text/javascript';
			googleScript.text = 'function loadScript() { var script = document.createElement("script"); script.type = "text/javascript"; script.src = "http://maps.googleapis.com/maps/api/js?key=&sensor=&callback=initialize"; document.body.appendChild(script); } loadScript()';
			iframe.body.appendChild( googleScript );
		},

		getCode: function() {
			this.$getCodeModal.find('.modal-body pre').html( this.generate().replace( /</g, '&lt;' ).replace( />/g, '&gt;' ) );
		},

		// GENERATE CODE
		// -----------------------------------------------------------------------------
		generate: function() {
			var i,
				work;

			var output = [
				'    google.maps.event.addDomListener(window, "load", init);',
				'    var map;',
				'    function init() {',
				'        var mapOptions = {',
				'            center: new google.maps.LatLng({lat}, {lng}),',
				'            zoom: {zoom},',
				'            zoomControl: {zoomControl},',
				'            {zoomControlOptions}',
				'            disableDoubleClickZoom: {disableDoubleClickZoom},',
				'            mapTypeControl: {mapTypeControl},',
				'            {mapTypeControlOptions}',
				'            scaleControl: {scaleControl},',
				'            scrollwheel: {scrollwheel},',
				'            panControl: {panControl},',
				'            streetViewControl: {streetViewControl},',
				'            draggable : {draggable},',
				'            overviewMapControl: {overviewMapControl},',
				'            {overviewMapControlOptions}',
				'            mapTypeId: google.maps.MapTypeId.{mapTypeId}{styles}',
				'        };',
				'',
				'        var mapElement = document.getElementById("{mapid}");',
				'        var map = new google.maps.Map(mapElement, mapOptions);',
				'        {locations}',
				'    }'
			];

			output = output.join("\r\n");

			var zoomControl			= this.$wrapper.find('[data-builder-field="zoomcontrol"] option:selected').val() !== 'false';
			var mapTypeControl		= this.$wrapper.find('[data-builder-field="maptypecontrol"] option:selected').val() !== 'false';
			var overviewMapControl	= this.$wrapper.find('[data-builder-field="overviewcontrol"] option:selected').val().toLowerCase();
			var $themeControl		= this.$wrapper.find('[data-builder-field="maptheme"] option:selected').filter( ':selected' );

			output = output
						.replace( /\{mapid\}/, this.$wrapper.find('[data-builder-field="mapid"]').val() )
						.replace( /\{lat\}/, this.$wrapper.find('[data-builder-field][name="latitude"]').val() )
						.replace( /\{lng\}/, this.$wrapper.find('[data-builder-field][name="longitude"]').val() )
						.replace( /\{zoom\}/, this.$wrapper.find('[data-builder-field="zoomlevel"] option:selected').val() )
						.replace( /\{zoomControl\}/, zoomControl )
						.replace( /\{disableDoubleClickZoom\}/, this.$wrapper.find('[data-builder-field="clicktozoomcontrol"] option:selected').val() === 'false' )
						.replace( /\{mapTypeControl\}/, mapTypeControl )
						.replace( /\{scaleControl\}/, this.$wrapper.find('[data-builder-field="scalecontrol"] option:selected').val() !== 'false' )
						.replace( /\{scrollwheel\}/, this.$wrapper.find('[data-builder-field="scrollwheelcontrol"] option:selected').val() !== 'false' )
						.replace( /\{panControl\}/, this.$wrapper.find('[data-builder-field="pancontrol"] option:selected').val() !== 'false' )
						.replace( /\{streetViewControl\}/, this.$wrapper.find('[data-builder-field="streetviewcontrol"] option:selected').val() !== 'false' )
						.replace( /\{draggable\}/, this.$wrapper.find('[data-builder-field="draggablecontrol"] option:selected').val() !== 'false' )
						.replace( /\{overviewMapControl\}/, overviewMapControl !== 'false' )
						.replace( /\{mapTypeId\}/, this.$wrapper.find('[data-builder-field="maptype"] option:selected').val().toUpperCase() );

			if ( zoomControl ) {
				work = {
					zoomControlOptions: {
						style: this.$wrapper.find('[data-builder-field="maptypecontrol"] option:selected').val().toUpperCase()
					}
				};
				output = output.replace( /\{zoomControlOptions\}/, "zoomControlOptions: {\r\n                style: google.maps.ZoomControlStyle." + this.$wrapper.find('[data-builder-field="zoomcontrol"] option:selected').val().toUpperCase() + "\r\n\            },");
			} else {
				output = output.replace( /\{zoomControlOptions\}/, '' );
			}

			if ( mapTypeControl ) {
				work = {
					zoomControlOptions: {
						style: this.$wrapper.find('[data-builder-field="maptypecontrol"] option:selected').val().toUpperCase()
					}
				};
				output = output.replace( /\{mapTypeControlOptions\}/, "mapTypeControlOptions: {\r\n                style: google.maps.MapTypeControlStyle." + this.$wrapper.find('[data-builder-field="maptypecontrol"] option:selected').val().toUpperCase() + "\r\n\            },");
			} else {
				output = output.replace( /\{mapTypeControlOptions\}/, '' );
			}

			if ( overviewMapControl !== 'false' ) {
				output = output.replace( /\{overviewMapControlOptions\}/, "overviewMapControlOptions: {\r\n                opened: " + (overviewMapControl === 'opened') + "\r\n\            },");
			} else {
				output = output.replace( /\{overviewMapControlOptions\}/, '' );
			}

			if ( $themeControl.val() !== 'false' ) {
				output = output.replace( /\{styles\}/, ',\r\n            styles: ' + $themeControl.data( 'json' ).replace(/\r\n/g, '') );
			} else {
				output = output.replace( /\{styles\}/, '' );
			}

			if ( this.markers.length > 0 ) {
				var work = [ 'var locations = [' ];
				var m,
					object;

				for( i = 0; i < this.markers.length; i++ ) {
					m = this.markers[ i ];
					object = '';

					object += '            { lat: ' + m.lat + ', lng: ' + m.lng;

					if ( !!m.title ) {
						object += ', title: "' + m.title + '"';
					}

					if ( !!m.description ) {
						object += ', description: "' + m.description + '"';
					}

					object += ' }';

					if ( i + 1 < this.markers.length ) {
						object += ',';
					}

					work.push( object );
				}

				work.push( '        ];\r\n' )

				work.push( '        var opts = {};' )
				work.push( '        for (var i = 0; i < locations.length; i++) {' );
				work.push( '            opts.position = new google.maps.LatLng( locations[ i ].lat, locations[ i ].lng );' );
				work.push( '            opts.map = map;' );
				work.push( '            if ( !!locations[ i ] .title ) { opts.title = locations[ i ].title; }');
				work.push( '            if ( !!locations[ i ] .description ) { opts.description = locations[ i ].description; }');
				work.push( '            marker = new google.maps.Marker( opts );' );
				work.push( '' );
				work.push( '            (function() {' );
				work.push( '                var html = [' );
				work.push( '                	\'<div style="background-color: #FFF; color: #000; padding: 5px; width: 150px;">\',' );
				work.push( '                		\'{title}\',' );
				work.push( '                		\'{description}\',' );
				work.push( '                	\'</div>\'' );
				work.push( '                ].join(\'\');' );

				work.push( '' );
				work.push( '                html = html.replace(/\{title\}/, !!opts.title ?  ("<h4>" + opts.title + "</h4>") : "" );' );
				work.push( '                html = html.replace(/\{description\}/, !!opts.description ?  ("<p>" + opts.description + "</p>") : "" );' );

				work.push( '                var infoWindow = new google.maps.InfoWindow({ content: html });' );

				work.push( '                google.maps.event.addListener( marker, \'click\', function() {' );
				work.push( '                	if ( infoWindow.isOpened ) {' );
				work.push( '                		infoWindow.close();' );
				work.push( '                		infoWindow.isOpened = false;' );
				work.push( '                	} else {' );
				work.push( '                		infoWindow.open( map, this );' );
				work.push( '                		infoWindow.isOpened = true;' );
				work.push( '                	}' );
				work.push( '                });' );
				work.push( '            })();' )
				work.push( '        }');

				output = output.replace( /\{locations\}/, work.join('\r\n') );
			} else {
				output = output.replace( /\{locations\}/, '' );
			}

			console.log( output );

			return output;
		}
	};

	// expose
	$.extend( true, theme, {
		Maps: {
			GMapBuilder: GMapBuilder
		}
	});

	// jQuery plugin
	$.fn.themeGMapBuilder = function( opts ) {
		return this.map(function() {
			var $this = $( this ),
				instance;

			instance = $this.data( instanceName );

			if ( instance ) {
				return instance;
			} else {
				return (new GMapBuilder( $this, opts ));
			}
		});
	};

	// auto initialize
	$(function() {
		$('[data-theme-gmap-builder]').each(function() {
			var $this = $( this );

			window.builder = $this.themeGMapBuilder();
		});
	});

}).apply(this, [ window.theme, jQuery ]);

// Animate
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__animate';

	var PluginAnimate = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginAnimate.defaults = {
		accX: 0,
		accY: -150,
		delay: 1
	};

	PluginAnimate.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginAnimate.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			var self = this,
				$el = this.options.wrapper,
				delay = 0;

			$el.addClass('appear-animation');

			if(!$('html').hasClass('no-csstransitions') && $(window).width() > 767) {

				$el.appear(function() {

					delay = ($el.attr('data-appear-animation-delay') ? $el.attr('data-appear-animation-delay') : self.options.delay);

					if(delay > 1) {
						$el.css('animation-delay', delay + 'ms');
					}

					$el.addClass($el.attr('data-appear-animation'));

					setTimeout(function() {
						$el.addClass('appear-animation-visible');
					}, delay);

				}, {accX: self.options.accX, accY: self.options.accY});

			} else {

				$el.addClass('appear-animation-visible');

			}

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginAnimate: PluginAnimate
	});

	// jquery plugin
	$.fn.themePluginAnimate = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginAnimate($this, opts);
			}

		});
	};

}).apply(this, [ window.theme, jQuery ]);

// Carousel
(function(theme, $) {

	theme = theme || {};

	var initialized = false;
	var instanceName = '__carousel';

	var PluginCarousel = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginCarousel.defaults = {
		itemsDesktop: false,
		itemsDesktopSmall: false,
		itemsTablet: false,
		itemsTabletSmall: false,
		itemsMobile: false
	};

	PluginCarousel.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginCarousel.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			this.options.wrapper.owlCarousel(this.options).addClass("owl-carousel-init");

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginCarousel: PluginCarousel
	});

	// jquery plugin
	$.fn.themePluginCarousel = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginCarousel($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Chart Circular
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__chartCircular';

	var PluginChartCircular = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginChartCircular.defaults = {
		accX: 0,
		accY: -150,
		delay: 1,
		barColor: '#0088CC',
		trackColor: '#f2f2f2',
		scaleColor: false,
		scaleLength: 5,
		lineCap: 'round',
		lineWidth: 13,
		size: 175,
		rotate: 0,
		animate: ({
			duration: 2500,
			enabled: true
		})
	};

	PluginChartCircular.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginChartCircular.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			var self = this,
				$el = this.options.wrapper,
				value = ($el.attr('data-percent') ? $el.attr('data-percent') : 0),
				percentEl = $el.find('.percent'),
				shouldAnimate,
				data;

			shouldAnimate = $.isFunction($.fn[ 'appear' ]) && ( typeof $.browser !== 'undefined' && !$.browser.mobile );
			data = { accX: self.options.accX, accY: self.options.accY };

			$.extend(true, self.options, {
				onStep: function(from, to, currentValue) {
					percentEl.html(parseInt(currentValue));
				}
			});

			$el.attr('data-percent', (shouldAnimate ? 0 : value) );

			$el.easyPieChart( this.options );

			if ( shouldAnimate ) {
				$el.appear(function() {
					setTimeout(function() {
						$el.data('easyPieChart').update(value);
						$el.attr('data-percent', value);

					}, self.options.delay);
				}, data);
			} else {
				$el.data('easyPieChart').update(value);
				$el.attr('data-percent', value);
			}

			return this;
		}
	};

	// expose to scope
	$.extend(true, theme, {
		Chart: {
			PluginChartCircular: PluginChartCircular
		}
	});

	// jquery plugin
	$.fn.themePluginChartCircular = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginChartCircular($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Lightbox
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__lightbox';

	var PluginLightbox = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginLightbox.defaults = {
		tClose: 'Close (Esc)', // Alt text on close button
		tLoading: 'Loading...', // Text that is displayed during loading. Can contain %curr% and %total% keys
		gallery: {
			tPrev: 'Previous (Left arrow key)', // Alt text on left arrow
			tNext: 'Next (Right arrow key)', // Alt text on right arrow
			tCounter: '%curr% of %total%' // Markup for "1 of 7" counter
		},
		image: {
			tError: '<a href="%url%">The image</a> could not be loaded.' // Error message when image could not be loaded
		},
		ajax: {
			tError: '<a href="%url%">The content</a> could not be loaded.' // Error message when ajax request failed
		}
	};

	PluginLightbox.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginLightbox.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			this.options.wrapper.magnificPopup(this.options);

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginLightbox: PluginLightbox
	});

	// jquery plugin
	$.fn.themePluginLightbox = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginLightbox($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Portlets
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__portlet',
		storageOrderKey = '__portletOrder',
		storageStateKey = '__portletState';

	var PluginPortlet = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginPortlet.defaults = {
		connectWith: '[data-plugin-portlet]',
		items: '[data-portlet-item]',
		handle: '.portlet-handler',
		opacity: 0.7,
		placeholder: 'portlet-placeholder',
		cancel: 'portlet-cancel',
		forcePlaceholderSize: true,
		forceHelperSize: true,
		tolerance: 'pointer',
		helper: 'original',
		revert: 200
	};

	PluginPortlet.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			var _self = this;

			this.options = $.extend(true, {}, PluginPortlet.defaults, opts, {
				wrapper: this.$el,
				update: _self.onUpdate,
				create: _self.onLoad
			});

			return this;
		},

		onUpdate: function(event, ui) {
			var key = storageOrderKey,
				data = store.get(key),
				$this = $(this),
				porletId = $this.prop('id');

			if (!data) {
				data = {};
			}

			if (!!porletId) {
				data[porletId] = $this.sortable('toArray');
				store.set(key, data);
			}
		},

		onLoad: function(event, ui) {
			var key = storageOrderKey,
				data = store.get(key),
				$this = $(this),
				porletId = $this.prop('id'),
				portlet = $('#' + porletId);

			if (!!data) {
				var panels = data[porletId];

				if (!!panels) {
					$.each(panels, function(index, panelId) {
						$('#' + panelId).appendTo(portlet);
					});
				}
			}
		},

		saveState: function( panel ) {
			var key = storageStateKey,
				data = store.get(key),
				panelId = panel.prop('id');

			if (!data) {
				data = {};
			}

			if (!panelId) {
				return this;
			}

			var collapse = panel.find('.panel-actions').children('a.fa-caret-up, a.fa-caret-down'),
				isCollapsed = !!collapse.hasClass('fa-caret-up'),
				isRemoved = !panel.closest('body').get(0);

			if (isRemoved) {
				data[panelId] = 'removed';
			} else if (isCollapsed) {
				data[panelId] = 'collapsed';
			} else {
				delete data[panelId];
			}

			store.set(key, data);
			return this;
		},

		loadState: function() {
			var key = storageStateKey,
				data = store.get(key);

			if (!!data) {
				$.each(data, function(panelId, state) {
					var panel = $('#' + panelId);
					if (!panel.data('portlet-state-loaded')) {
						if (state == 'collapsed') {
							panel.find('.panel-actions a.fa-caret-down').trigger('click');
						} else if (state == 'removed') {
							panel.find('.panel-actions a.fa-times').trigger('click');
						}
						panel.data('portlet-state-loaded', true);
					}
				});
			}

			return this;
		},

		build: function() {
			var _self = this;

			if ( $.isFunction( $.fn.sortable ) ) {
				this.$el.sortable( this.options );
				this.$el.find('[data-portlet-item]').each(function() {
					_self.events( $(this) );
				});
			}

			var portlet = this.$el;
			portlet.css('min-height', 150);

			return this;
		},

		events: function($el) {
			var _self = this,
				portlet = $el.closest('[data-plugin-portlet]');

			this.loadState();

			$el.find('.panel-actions').on( 'click', 'a.fa-caret-up, a.fa-caret-down, a.fa-times', function( e ) {
				setTimeout(function() {
					_self.saveState( $el );
				}, 250);
			});

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginPortlet: PluginPortlet
	});

	// jquery plugin
	$.fn.themePluginPortlet = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginPortlet($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Slider
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__slider';

	var PluginSlider = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginSlider.defaults = {

	};

	PluginSlider.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setVars()
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setVars: function() {
			var $output = $( this.$el.data('plugin-slider-output') );
			this.$output = $output.get(0) ? $output : null;

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			var _self = this;
			this.options = $.extend( true, {}, PluginSlider.defaults, opts );

			if ( this.$output ) {
				$.extend( this.options, {
					slide: function( event, ui ) {
						_self.onSlide( event, ui );
					}
				});
			}

			return this;
		},

		build: function() {
			this.$el.slider( this.options );

			return this;
		},

		onSlide: function( event, ui ) {
			if ( !ui.values ) {
				this.$output.val( ui.value );
			} else {
				this.$output.val( ui.values[ 0 ] + '/' + ui.values[ 1 ] );
			}

			this.$output.trigger('change');
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginSlider: PluginSlider
	});

	// jquery plugin
	$.fn.themePluginSlider = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginSlider($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Toggle
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__toggle';

	var PluginToggle = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginToggle.defaults = {
		duration: 350,
		isAccordion: false,
		addIcons: true
	};

	PluginToggle.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginToggle.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			var self = this,
				$wrapper = this.options.wrapper,
				$items = $wrapper.find('.toggle'),
				$el = null;

			$items.each(function() {
				$el = $(this);

				if(self.options.addIcons) {
					$el.find('> label').prepend(
						$('<i />').addClass('fa fa-plus'),
						$('<i />').addClass('fa fa-minus')
					);
				}

				if($el.hasClass('active')) {
					$el.find('> p').addClass('preview-active');
					$el.find('> .toggle-content').slideDown(self.options.duration);
				}

				self.events($el);
			});

			if(self.options.isAccordion) {
				self.options.duration = self.options.duration/2;
			}

			return this;
		},

		events: function($el) {
			var self = this,
				previewParCurrentHeight = 0,
				previewParAnimateHeight = 0,
				toggleContent = null;

			$el.find('> label').click(function(e) {

				var $this = $(this),
					parentSection = $this.parent(),
					parentWrapper = $this.parents('.toggle'),
					previewPar = null,
					closeElement = null;

				if(self.options.isAccordion && typeof(e.originalEvent) != 'undefined') {
					closeElement = parentWrapper.find('.toggle.active > label');

					if(closeElement[0] == $this[0]) {
						return;
					}
				}

				parentSection.toggleClass('active');

				// Preview Paragraph
				if(parentSection.find('> p').get(0)) {

					previewPar = parentSection.find('> p');
					previewParCurrentHeight = previewPar.css('height');
					previewPar.css('height', 'auto');
					previewParAnimateHeight = previewPar.css('height');
					previewPar.css('height', previewParCurrentHeight);

				}

				// Content
				toggleContent = parentSection.find('> .toggle-content');

				if(parentSection.hasClass('active')) {

					$(previewPar).animate({
						height: previewParAnimateHeight
					}, self.options.duration, function() {
						$(this).addClass('preview-active');
					});

					toggleContent.slideDown(self.options.duration, function() {
						if(closeElement) {
							closeElement.trigger('click');
						}
					});

				} else {

					$(previewPar).animate({
						height: 0
					}, self.options.duration, function() {
						$(this).removeClass('preview-active');
					});

					toggleContent.slideUp(self.options.duration);

				}

			});
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginToggle: PluginToggle
	});

	// jquery plugin
	$.fn.themePluginToggle = function(opts) {
		return this.map(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginToggle($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Widget - Todo
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__widgetTodoList';

	var WidgetTodoList = function($el, opts) {
		return this.initialize($el, opts);
	};

	WidgetTodoList.defaults = {
	};

	WidgetTodoList.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build()
				.events();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, WidgetTodoList.defaults, opts );

			return this;
		},

		check: function( input, label ) {
			if ( input.is(':checked') ) {
				label.addClass('line-through');
			} else {
				label.removeClass('line-through');
			}
		},

		build: function() {
			var _self = this,
				$check = this.$el.find('.todo-check');

			$check.each(function () {
				var label = $(this).closest('li').find('.todo-label');
				_self.check( $(this), label );
			});

			return this;
		},

		events: function() {
			var _self = this,
				$remove = this.$el.find( '.todo-remove' ),
				$check = this.$el.find('.todo-check'),
				$window = $( window );

			$remove.on('click.widget-todo-list', function( ev ) {
				ev.preventDefault();
				$(this).closest("li").remove();
			});

			$check.on('change', function () {
				var label = $(this).closest('li').find('.todo-label');
				_self.check( $(this), label );
			});

			if ( $.isFunction( $.fn.sortable ) ) {
				this.$el.sortable({
					sort: function(event, ui) {
						var top = event.pageY - _self.$el.offset().top - (ui.helper.outerHeight(true) / 2);
						ui.helper.css({'top' : top + 'px'});
				    }
				});
			}

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		WidgetTodoList: WidgetTodoList
	});

	// jquery plugin
	$.fn.themePluginWidgetTodoList = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new WidgetTodoList($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Widget - Toggle
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__widgetToggleExpand';

	var WidgetToggleExpand = function($el, opts) {
		return this.initialize($el, opts);
	};

	WidgetToggleExpand.defaults = {
	};

	WidgetToggleExpand.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build()
				.events();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, WidgetToggleExpand.defaults, opts );

			return this;
		},

		build: function() {
			return this;
		},

		events: function() {
			var _self = this,
				$toggler = this.$el.find( '.widget-toggle' );

			$toggler.on('click.widget-toggler', function() {
				_self.$el.hasClass('widget-collapsed') ? _self.expand( _self.$el ) : _self.collapse( _self.$el );
			});

			return this;
		},

		expand: function( content ) {
			content.children( '.widget-content-expanded' ).slideDown( 'fast', function() {
				$(this).css( 'display', '' );
				content.removeClass( 'widget-collapsed' );
			});
		},

		collapse: function( content ) {
			content.children('.widget-content-expanded' ).slideUp( 'fast', function() {
				content.addClass( 'widget-collapsed' );
				$(this).css( 'display', '' );
			});
		}
	};

	// expose to scope
	$.extend(theme, {
		WidgetToggleExpand: WidgetToggleExpand
	});

	// jquery plugin
	$.fn.themePluginWidgetToggleExpand = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new WidgetToggleExpand($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Word Rotate
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__wordRotate';

	var PluginWordRotate = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginWordRotate.defaults = {
		delay: 2000
	};

	PluginWordRotate.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend(true, {}, PluginWordRotate.defaults, opts, {
				wrapper: this.$el
			});

			return this;
		},

		build: function() {
			var $el = this.options.wrapper,
				itemsWrapper = $el.find(".word-rotate-items"),
				items = itemsWrapper.find("> span"),
				firstItem = items.eq(0),
				firstItemClone = firstItem.clone(),
				itemHeight = firstItem.height(),
				currentItem = 1,
				currentTop = 0;

			itemsWrapper.append(firstItemClone);

			$el
				.height(itemHeight)
				.addClass("active");

			setInterval(function() {

				currentTop = (currentItem * itemHeight);

				itemsWrapper.animate({
					top: -(currentTop) + "px"
				}, 300, function() {

					currentItem++;

					if(currentItem > items.length) {

						itemsWrapper.css("top", 0);
						currentItem = 1;

					}

				});

			}, this.options.delay);

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginWordRotate: PluginWordRotate
	});

	// jquery plugin
	$.fn.themePluginWordRotate = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginWordRotate($this, opts);
			}

		});
	}

}).apply(this, [ window.theme, jQuery ]);

// Data Tables - Config
(function($) {

	'use strict';

	// we overwrite initialize of all datatables here
	// because we want to use select2, give search input a bootstrap look
	// keep in mind if you overwrite this fnInitComplete somewhere,
	// you should run the code inside this function to keep functionality.
	//
	// there's no better way to do this at this time :(
	if ( $.isFunction( $.fn[ 'dataTable' ] ) ) {

		$.extend(true, $.fn.dataTable.defaults, {
			sDom: "<'row datatables-header form-inline'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>r><'table-responsive't><'row datatables-footer'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
			oLanguage: {
				sLengthMenu: '_MENU_ records per page',
				sProcessing: '<i class="fa fa-spinner fa-spin"></i> Loading'
			},
			fnInitComplete: function( settings, json ) {
				// select 2
				if ( $.isFunction( $.fn[ 'select2' ] ) ) {
					$('.dataTables_length select', settings.nTableWrapper).select2({
						minimumResultsForSearch: -1
					});
				}

				var options = $( 'table', settings.nTableWrapper ).data( 'plugin-options' ) || {};

				// search
				var $search = $('.dataTables_filter input', settings.nTableWrapper);

				$search
					.attr({
						placeholder: typeof options.searchPlaceholder !== 'undefined' ? options.searchPlaceholder : 'Search'
					})
					.addClass('form-control');

				if ( $.isFunction( $.fn.placeholder ) ) {
					$search.placeholder();
				}
			}
		});

	}

}).apply( this, [ jQuery ]);

// Notifications - Config
(function($) {

	'use strict';

	// use font awesome icons if available
	if ( typeof PNotify != 'undefined' ) {
		PNotify.prototype.options.styling = "fontawesome";

		$.extend(true, PNotify.prototype.options, {
			shadow: false,
			stack: {
				spacing1: 15,
	        	spacing2: 15
        	}
		});

		$.extend(PNotify.styling.fontawesome, {
			// classes
			container: "notification",
			notice: "notification-warning",
			info: "notification-info",
			success: "notification-success",
			error: "notification-danger",

			// icons
			notice_icon: "fa fa-exclamation",
			info_icon: "fa fa-info",
			success_icon: "fa fa-check",
			error_icon: "fa fa-times"
		});
	}

}).apply(this, [jQuery]);
var progress = [];
var progress_changed = false;
var view_id;
var view_count = null;
var view_like_content;
var view_like_teaching;
var view_max;
var block_changing = false;
var is_set = false;
var is_rated = false;
var watched_time = 0;
var is_watching = false;
var current_content = 0;
var once = 0;
var watched_time_interval = undefined;
var view_progress_interval = undefined;
var ready = 0;


$("#show-menu-header").on('click',function(){
    $("#menu-dashboard").slideToggle(500);
});

function block_change(){
    $(".block").on('click',function(){
        $(".block.active").removeClass("active");
        $(this).addClass("active");
    });
    /*  $(".block").on('click',function(){



     ready  = 0;
     $(".block.active").removeClass("active");
     $(this).addClass("active");
     $("#show-view").html("Carregando...");
     progress = [];
     progress_changed = false;

     var lesson_id = $("[name='lesson-content']").data("lesson");
     var target_block = $(this).data("block");

     var current_selected_progress = $(".lesson-progress .label.active");
     current_selected_progress.tooltip('hide');
     current_selected_progress.siblings(":nth-of-type(" + target_block + ")").addClass("active").tooltip({title: "Ativo"});
     current_selected_progress.removeClass("active");


     $("[name='lesson-content']").hide();


     $.ajax({
     url: "/classroom/get-video-block",
     type: "POST",
     data: {lesson: lesson_id,
     block: target_block},
     ifModified: true,
     headers: {
     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
     },
     cache: false,
     success: function(data){
     if(watched_time != 0){
     save_watched_time();
     }


     var obj = JSON.parse(data);
     //console.log(obj);
     $("[name='lesson-content']").attr('data-content',obj.id);
     $("[name='lesson-content']").data('content',obj.id);

     $("[name='lesson-content']").attr('src',obj.url);


     }
     });



     });

     */
}




$(document).ready(function(){
    if($("[name='lesson-content']").length > 0){
        block_change();

        vimeo_events();
        content_tree_events();
        $('.lesson-progress .label.active').tooltip();
    }

    if($("[id='ticket-count-mail']").length > 0){
        $('#ticket-count-mail').html( $('.li-mail').length );
        $('#ticket-count-mail-finished').html( $('.li-finished').length );
        $('#ticket-count-mail-replied').html( $('.li-replied').length );
        $('#ticket-count-mail-not-replied').html( $('.li-not-replied').length );
    }

    if($('#question-lesson-filter').length > 0){
        $("#question-lesson-filter").change(function(){
            var target_lesson = ".lesson-" + this.value;
            $(".post").css("display",'none');
            $(target_lesson).css('display','flex');

        });
    }

});



function with_view(callback) {

    var view = $("#actual-content").data('view');


    if (view != null && view != undefined && view.id != null && view.id != undefined){
        view_id = view.id;
        view_count = view.view;
        view_like_content = view.like_content;
        view_like_teaching = view.like_teaching;
        view_max = view.max_view;
        if(view.state != null){
            progress = view.state.split(",").map(Number);

            $(".lesson-progress .label").tooltip();
            window.setTimeout(function(){
                if(view_count > 0){
                    var view_title_name = "visualização";
                    if(view_count > 1)
                        view_title_name = "visualizações";

                    $(".lesson-progress .label.active").attr('title', view_count + " " + view_title_name ).tooltip('fixTitle').tooltip();
                }else{
                    $(".lesson-progress .label.active").attr('title', (progress.length % 100) + "% assistido").tooltip('fixTitle').tooltip();
                }
            },1000);
        }

        callback();


    }else if(current_content == $("[name='lesson-content']").data('content')){
        callback();
    }else{
        current_content = $("[name='lesson-content']").data('content');
        $.ajax({
            url: "/classroom/get-view",
            type: "POST",
            data: {
                enrollment: $("[name='lesson-content']").data('enrollment'),
                content: $("[name='lesson-content']").data('content')
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function(view){


                console.log('view successfuly acquired: ' + view.id);
                if(! view.content_id == $("[name='lesson-content']").data('content') ) console.log('difference');
                view_id = view.id;
                view_count = view.view;
                view_like_content = view.like_content;
                view_like_teaching = view.like_teaching;
                view_max = view.max_view;
                if(view.state != null){
                    progress = view.state.split(",").map(Number);

                    $(".lesson-progress .label").tooltip();
                    window.setTimeout(function(){
                        if(view_count > 0){
                            var view_title_name = "visualização";
                            if(view_count > 1)
                                view_title_name = "visualizações";

                            $(".lesson-progress .label.active").attr('title', view_count + " " + view_title_name ).tooltip('fixTitle').tooltip();
                        }else{
                            $(".lesson-progress .label.active").attr('title', (progress.length % 100) + "% assistido").tooltip('fixTitle').tooltip();
                        }
                    },1000);
                }

                callback();

            },
            error: function(){
                timeout_handling(this);
            }


        });
    }
}




function vimeo_events(){

    with_view(function(){
        //load_comments($("[name='lesson-content']").data('content'));

        var enrollment_id = $("[name='lesson-content']").data('enrollment');
        var content_id = $("[name='lesson-content']").data('content');

        if(  $("[name='lesson-content']").attr('src') == ''  && once == 0) {
            $("[name='lesson-content']").attr('src', $("[name='lesson-content']").data('url'));
            once = 1;
        }
        $("[name='lesson-content']").load(function () {
            $(this).slideDown();
            $("#note-panel").scroll();

            var iframe = $("[name='lesson-content']")[0];
            var player = new Vimeo.Player(iframe);

            var starting_time;
            is_set = false;



            if(ready == 0){
                ready = 1;
                console.log('ready');
                $("#exceeded").html('');

                //console.log('aqui');
                block_changing = false;
                player.on('timeupdate', onPlayProgress);
                player.on('pause', onPause);
                player.on('play', onPlay);
                //console.log('depois');

                load_notes($("[name='lesson-content']").data('content'));

                function onPlayProgress(data, id) {
                    if (view_count >= view_max) {
                        player.unload().then(function(){
                            $("#exceeded").html("<i class='fa fa-hand-stop-o' style='color:red'></i>&nbsp;<b>Você excedeu o limite de visualizações para essa aula</b>");
                        }).catch(function(error){
                            $("[name='lesson-content']").html('O número máximo de visualizações para esse vídeo foi excedido');
                        });
                    }

                    var item = $("[data-time='" + Math.floor(data.seconds) + "']");

                    if (item.length) {
                        item.css('background-color', '#F5F3C9');
                        // $('#note-panel').animate({scrollTop: item.first().position().top});
                    }
                    //console.log(data.percent);
                    var percentual = (Math.floor(data.percent * 100) + (100 * view_count));
                    if (progress.indexOf(percentual) == -1 && !isNaN(percentual) && percentual % 100 != 0) {
                        //console.log(progress);
                        progress.push(percentual);
                        progress_changed = true;



                        if(view_count == 0){
                            $(".lesson-progress .label.active").attr('title', (progress.length % 100) + "% assistido").tooltip('fixTitle').tooltip('show');

                        }
                    }



                    if (percentual == (100 + (100 * view_count)) && block_changing == false) {
                        block_changing = true;

                        if ($(".block.active").next().length == 0) window.location = $(".lesson-list.active").next().find('a').first().attr('href');
                        else window.location = $(".block.active").next().attr('href');

                    }


                    //Descomentar apenas em caso de teste
                    /*
                     if(data.seconds > 60 && test == true){
                     test = false;
                     alert(progress.toStri  ng());
                     }
                     */


                }


                is_rated = false;

                with_view(function (id, count, max) {

                    if (watched_time_interval != 0) window.clearInterval(watched_time_interval);


                    view_progress_interval = setInterval(function () {
                        save_state(enrollment_id);
                    }, 30000);
                    watched_time_interval = setInterval(function () {
                        if (is_watching === true) {
                            watched_time = +watched_time + 1;
                            //console.log(watched_time);
                        }
                    }, 1000);


                    load_view_info(count, max);
                    goto_last_spot(player);
                    like();
                    rate(enrollment_id);



                    $(window).on('beforeunload', function () {
                        save_watched_time();
                    });
                });


                $("#text-todo").off('keypress').on('keypress', function (e) {
                    if (e.which == 13) $("#add-todo").click();
                });


                $("#add-todo").click(function () {
                    player.getCurrentTime().then(function (value) {
                        if (is_set == false) {
                            is_set = true;
                            var val = $("#text-todo").val();
                            var actual_time = value;

                            console.log(actual_time);
                            console.log(val);

                            save_notes(actual_time, val, $("[name='lesson-content']").data('content'));


                            $("#text-todo").val('');
                        }
                    });

                });


            }


        });
    });

    $(".btn_ticket_send").on('click', function () {
        $("#ticket_return").html('');
        if ($("#ticket_message").val() == ''){
            $("#ticket_return").html('É necessário informar a mensagem.');
            return;
        }
        $(".btn_ticket_send").text("Enviando...");
        $.ajax({
            url: "/classroom/open-ticket",
            type: "POST",
            data: {
                'sector_id': $('#ticket_sector_id').val(),
                'content_id': $('#ticket_content_id').val(),
                'enrollment_id': $("#ticket_enrollment_id").val(),
                'message': $("#ticket_message").val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                $(".btn_ticket_send").text("Enviar");
                if (data.trim() === '1'){
                    $("#ticket_return").html('Mensagem enviada com sucesso! Acompanhe na seção Fale Conosco');
                    $("#ticket_message").val("");
                } else {
                    $("#ticket_return").html('Ocorreu um erro ao enviar a sua mensagem!');
                }
            },
            error: function (data) {
                $("#ticket_return").html('Ocorreu um erro ao enviar a sua mensagem!');
            }
        });
    });
}

function onPause(data,id){
    console.log('paused');
    is_watching = false;
    save_watched_time();
}

function onPlay(data,id){
    is_watching = true;
}


function goto_last_spot(player){


    if(progress != null && progress.length > 3) {
        var duration = player.getDuration().then(function(value)
        {
            console.log("duration" + value);
            var final_percentage = progress[progress.length - 1];
            console.log(final_percentage);
            var second_seek = Math.floor((value * (final_percentage - (100 * view_count))) / 100);
            // if(second_seek > 20){
            //    second_seek = second_seek - 20;
            // }
            console.log('Segundo: ' + second_seek);
            player.setCurrentTime(second_seek).then(function(seconds) {
                // seconds = the actual time that the player seeked to
            }).catch(function(error) {
                switch (error.name) {
                    case 'RangeError':
                        console.log('Alcance fora do comprimento do vídeo');
                        break;

                    default:

                        console.log('Um erro inesperado aconteceu: ' + error.name);
                        break;
                }
            });


        }).catch(function(error){
            console.log(error.name);
            player.play();

        });



    }
}


function rate(enrollment_id){

    $.ajax({
        url: "/classroom/needs-rating",
        type: "POST",
        data: {
            enrollment: enrollment_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (needs) {
            //console.log("need" + needs);

            if(needs == 'true' && is_rated == false){
                //  console.log("open it");
                rating_hover_events();
                rating_click_event();
                $("#ratingModal").modal('toggle');
                is_rated = true;
            }


        }


    });
}


function save_notes(starting_time, note, content){
    $.ajax({
        url: "/classroom/save-notes",
        type: "POST",
        data: {
            'starting_time': starting_time,
            'note': note,
            'content':  content
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function (data) {
            load_notes($("[name='lesson-content']").data('content'));
            // $("#user-note").after('<div class="panel-body" style="border-style: solid; border-width: 1px; border-radius: 5px; background-color: white;">' + minutes  + ":" + seconds + " -> "  + mensagem + '</div>');



        }


    });
}

function remove_notes(note_id){
    $.ajax({
        url: "/classroom/remove-notes",
        type: "POST",
        data: {
            'note': note_id,

        },
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (data) {
            load_notes($("[name='lesson-content']").data('content'));



        }


    });
}



function publish_comments(){

}

function load_comments(content_id){


    $('#comments-content').comments({
        profilePictureURL: 'https://app.viima.com/static/media/user_profiles/user-icon.png',

        newestText: 'Recentes',
        oldestText: 'Velhos',
        sendText: 'Enviar',
        noCommentsText: 'Ainda não há nenhum comentário',
        textareaPlaceholderText: 'Deixe um comentário',
        enableUpvoting: false,
        enableReplying: false,
        enableEditing: false,
        youText: 'Você',

        getComments: function(success, error) {
            console.log('Loading comments...');
            var comments = [];

            $.ajax({
                url: "/classroom/get-video-comments",
                type: "POST",
                data: {
                    content: content_id,

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,

                success: function(data){
                    try{
                        response = JSON.parse(data);

                        $.each(response, function(i,value){


                            var match = value.created_at.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
                            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);

                            var matchUpdate = value.updated_at.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
                            var dateUpdate = new Date(matchUpdate[1], matchUpdate[2] - 1, matchUpdate[3], matchUpdate[4], matchUpdate[5], matchUpdate[6]);



                            var photo_url = value.photo != null ? value.photo : "";
                            var photo = image_url('users', value.user_id, photo_url);

                            var fields =
                            {
                                id: value.id,
                                created: date.toISOString(),
                                modified: dateUpdate.toISOString(),
                                content: value.comment,
                                fullname: value.user_name,
                                profile_picture_url:  photo, //'/img/system/generic_size50.png',
                                createdByCurrentUser: true
                            }

                            comments.push(fields);


                        });

                        success(comments);

                    }catch(e){
                        console.log('Data is not a json');
                    }
                },

            });


        },
        postComment: function(commentJSON, success, error) {
            $.ajax({
                type: 'GET',
                url: '/classroomx/post-video-comment/',
                data: {
                    content: content_id,
                    comment: commentJSON,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(comment) {
                    console.log('Registering comment...');
                    // console.log(comment);
                    success(comment);
                },
                error: error
            });
        }
    });

    /*
     $.ajax({
     url: "/classroom/get-lesson-comments",
     type: "POST",
     data: {
     content: lesson_id,

     },
     headers: {
     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
     },
     cache: false,
     success: function(data){
     response = JSON.parse(data);
     $('#note-panel').html('');
     $.each(response, function(i,value){


     $("#note-panel").append('<div class="panel-body" style="border-style: solid; border-width: 1px; border-radius: 5px; background-color: white;" data-time="'+ value.video_index_seconds +'">' +  value.video_index_seconds.toString() + " -> "  + value.note + '</div>');


     });
     }

     }); */
}


function load_notes(content_id){

    $.ajax({
        url: "/classroom/get-video-notes",
        type: "POST",
        data: {
            content: content_id,

        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){
            console.log("Loading notes...");
            is_set = false;


            response = JSON.parse(data);
            $('#note-panel').html('');
            $.each(response, function(i,value){

                console.log(value);

                var minutes = Math.floor(value.video_index_seconds / 60);
                var seconds = Math.floor(value.video_index_seconds - (minutes * 60));



                $("#note-panel").append('<li><div> <label class="todo-label" style="margin-left:14px" for="todoListItem2"><strong>' + ("0" + minutes).slice(-2) + ':' + ("0" + seconds).slice(-2) + '</strong> | <span>' + value.note + '</span></label> </div> <div class="todo-actions"> <a class="todo-remove exclude-note" data-note-id="'+ value.id +'" href="#"> <i class="fa fa-times"></i> </a> </div> </li>');

            });

            $(".exclude-note").click(function(){
                var note_id = $(this).data('note-id');
                remove_notes(note_id);
            });

            $("#note-panel").animate({ scrollTop: $('#note-panel').prop("scrollHeight")}, 1000);
        }

    });

}

function load_view_info(){
    console.log(view_count + ' ' + view_max + ' views');
    console.log('loading view info...');
    if(view_count >= view_max){
        $("#show-view").html("<span style='color:red;'>nenhuma restante</span>");
        //$("#current-view").html("<b style='color:red;'>" + view_max + "</b>");
        //$("#max-view").html("<b style='color:red;'>" + view_max + "</b>");
    }else{
        console.log(view_count);
        var available = +view_max - +view_count;
        $("#show-view").html( +available + " restante" + (available != 1 ? "s" : "") );
        //$("#current-view").html(+view_count +1);
        //$("#max-view").html(view_max);
    }
    switch_like(view_like_content, 'content');
    switch_like(view_like_teaching, 'teaching');

}

function switch_like(up_down, criteria){
    console.log(up_down);
    if(up_down == 1){
        if($("#thumbs-up-" + criteria).hasClass('fa-thumbs-o-up')){
            $("#thumbs-up-" + criteria).removeClass('fa-thumbs-o-up');
            $("#thumbs-up-" + criteria).addClass('fa-thumbs-up');
            $("#thumbs-down-" + criteria).removeClass('fa-thumbs-down');
            $("#thumbs-down-" + criteria).addClass('fa-thumbs-o-down');
        }
    }else if(up_down == -1){
        if($("#thumbs-down-" + criteria).hasClass('fa-thumbs-o-down')) {
            $("#thumbs-down-" + criteria).removeClass('fa-thumbs-o-down');
            $("#thumbs-down-" + criteria).addClass('fa-thumbs-down');
            $("#thumbs-up-" + criteria).removeClass('fa-thumbs-up');
            $("#thumbs-up-" + criteria).addClass('fa-thumbs-o-up');
        }
    }else{
        $("#thumbs-up-" + criteria).removeClass('fa-thumbs-up');
        $("#thumbs-up-" + criteria).addClass('fa-thumbs-o-up');
        $("#thumbs-down-" + criteria).removeClass('fa-thumbs-down');
        $("#thumbs-down-" + criteria).addClass('fa-thumbs-o-down');
    }

}

function like(){
    $("#thumbs-up-content").on('click',function(){
        view_like_content = 1;
        save_like(view_like_content,'content');
    });
    $("#thumbs-down-content").on('click',function(){
        view_like_content = -1;
        save_like(view_like_content,'content');
    });
    $("#thumbs-up-teaching").on('click',function(){
        view_like_teaching = 1;
        save_like(view_like_teaching,'teaching');
    });
    $("#thumbs-down-teaching").on('click',function(){
        view_like_teaching = -1;
        save_like(view_like_teaching,'teaching');
    });



}

function save_like(up_down, criteria){
    $.ajax({
        url: '/classroom/save-like',
        type: 'POST',
        data: {
            view: view_id,
            up_down: up_down,
            criteria: criteria
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data) {
            switch_like(up_down, criteria);
        }

    });
}


var test = true;





function content_tree_events(){
    $("#treeBasic").on("activate_node.jstree",function(e){
        e.preventDefault();//stop the browser from following
        window.open( $(this).find(".jstree-clicked").attr('href'),'_blank');
    });

}


function save_state(enrollment_id){
    if( (progress.length == 1 && progress[0] % 100 == 0)){
        progress[0] = 0;
    }
    if(progress_changed) {
        var content_id =  $("[name='lesson-content']").data('content');
        if(content_id == undefined || content_id == null || content_id == ''){
            content_id = $("[name='lesson-content']").attr('data-content');
        }


        $.ajax({
            url: "/classroom/save-state",
            type: "POST",
            data: {
                state: insertion_sort(progress).toString(),
                percentual: progress.length,
                content: content_id,
                enrollment: enrollment_id,
                count: view_count

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,

            success: function (data) {
                console.log('Saving...');
                progress_changed = false;
                return true;
            },
            error: function () {
                console.log('enrollment_id:' + enrollment_id + ' content: ' + $("[name='lesson-content']").data('content'));
            }
        });

    }
}

function save_watched_time(){
    $.ajax({
        url: "/classroom/save-watched-time",
        type: "POST",
        async: false,
        data: {
            'watched_time': watched_time,
            'content': $("[name='lesson-content']").data('content'),
            'enrollment': $("[name='lesson-content']").data('enrollment'),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,

        success: function (data) {
            watched_time = 0;
        },
        error: function () {
        }
    });


}

$('#treeBasic').jstree({
    'core' : {
        'themes' : {
            'responsive': false
        }
    },
    'types' : {
        'default' : {
            'icon' : 'fa fa-folder'
        },
        'file' : {
            'icon' : 'fa fa-file'
        }
    },
    'plugins': ['types']
});
$(".panel").on("show.bs.collapse hide.bs.collapse", function(e) {
    if (e.type=='show'){
        $(this).find('.panel-heading').addClass('active');
    }else{
        $(this).find('.panel-heading').removeClass('active');
    }
});
$(".row-classroom").owlCarousel({
    items:2,
    itemsMobile:    [479,2],
    navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    navigation:false,
    pagination:true
});

$("#nav-classroom").hover(function(){
    $(this).animate({opacity:1},500);
}, function(){
    $(this).animate({opacity:0.6},500);
});


function openCourseModal(course_id, title, url){

    $("#courseContentLabel").html( title );
    $("#courseContentDiv").html('');
    $("#courseContentModal").modal('toggle');
    $("#courseContentWait").css("display", "block");
    $.ajax({
        url: url,
        type: "POST",
        data: {
            course: course_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (html) {
            $("#courseContentWait").css("display", "none");
            $("#courseContentDiv").html(html);
        }
    });
}

function courseContent(course_id){
    openCourseModal(course_id, '<strong>Conteúdo programático</strong>', "/classroom/course-content");
}

function courseTerms(course_id){
    openCourseModal(course_id, '<strong>Termos de uso</strong>', "/classroom/course-terms");
}

function courseAlerts(course_id){
    openCourseModal(course_id, '<strong>Quadro de Avisos</strong>', "/classroom/course-alerts");
}

function courseCalendar(course_id){
    openCourseModal(course_id, '<strong>Calendário</strong>', "/classroom/course-calendar");
}

function courseModules(course_id){
    openCourseModal(course_id, '<strong>Disciplinas</strong>', "/classroom/course-modules");
}

$(".button-askTheTeacherClassroom").on('click', function () {
    $(".button-askTheTeacherClassroom").text("Enviando...");
    $.ajax({
        url: "/classroom/save-ask-the-teacher",
        type: "POST",
        data: {
            'lesson_id': $('#askTheTeacher_lesson_id').val(),
            'question': $("#questionAskTheTeacher").val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function (data) {
            if (data.trim() === '1'){
                $("#questionAskTheTeacher").val('');
                $(".button-askTheTeacherClassroom").text("Enviar");
                $("#asktheteacher_return").html('Mensagem enviada com sucesso! Acompanhe na seção Minhas Duvidas');
            } else {
                $("#asktheteacher_return").html('Ocorreu um erro ao enviar a sua mensagem!');
            }

        },
        error: function (data) {
            $("#asktheteacher_return").html('Ocorreu um erro ao enviar a sua mensagem!');
        }
    });
});

$(document).ready(function(){
    $(".planstudy_hours").TouchSpin({
        min: 1,
        max: 24,
        step: 1,
        decimals: 0,
        postfix: 'horas'
    });

    handleCounterup(); // handle counterup instances
});

// Handles counterup plugin wrapper
var handleCounterup = function() {
    if (!$().counterUp) {
        return;
    }

    $("[data-counter='counterup']").counterUp({
        delay: 10,
        time: 1000
    });
};


/**
 * Created by ambiente on 20/06/16.
 */

function rating_hover_events(){
    $(".rate-star").not('.voted').hover(function(){
        if(!$(this).hasClass('voted')){
            $(this).removeClass("fa-star-o");
            $(this).prevAll('.rate-star').removeClass('fa-star-o');
            $(this).nextAll('.rate-star').removeClass('fa-star');
            $(this).addClass("fa-star");
            $(this).prevAll('.rate-star').addClass('fa-star');
            $(this).nextAll('.rate-star').addClass('fa-star-o');
        }
    });

    $(".stars").not(".rate-star").hover(function(){
        if(!$(this).hasClass('voted')){
            $(".rate-star").not('.voted').removeClass("fa-star");
            $(".rate-star").not('.voted').addClass("fa-star-o");
        }
    });
}

function rating_click_event(){
    $(".rate-star").click(function(){
        if(!$(this).hasClass('voted')){
            var enrollment_id = $("[name='lesson-content']").data('enrollment');
            var rating = $(this).index() + 1;
            var criteria = $(this).parent().data("criteria");
            $(this).removeClass('fa-star-o');
            $(this).addClass('voted');
            $(this).addClass('fa-star');
            $(this).prevAll('.rate-star').removeClass('fa-star-o');
            $(this).nextAll('.rate-star').removeClass('fa-star');
            $(this).prevAll('.rate-star').addClass('fa-star');
            $(this).nextAll('.rate-star').addClass('fa-star-o');
            console.log('Avaliação feita com sucesso');
            $(this).css("color","gold");
            $(this).siblings(".fa-star").css("color","gold")
            $(this).siblings(".rate-star").addClass('voted');


            $.ajax({
                url: "/classroom/save-rating",
                type: "POST",
                data: {
                    enrollment: enrollment_id,
                    rating: rating,
                    criteria: criteria
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,

                success: function (data) {




                    if($(".rate-star").not(".voted").length <= 0)
                    $(".modal-body").append("<br><p style='color:#075890;'>Agradecemos a sua avaliação!</p>");
                },
                error: function () {

                    //  console.log('enrollment_id:' + enrollment_id + ' content: ' + $("[name='lesson-content']").data('content'));
                }
            });
        }
    });
}
// Popover
(function( $ ) {

	'use strict';

	if ( $.isFunction( $.fn['popover'] ) ) {
		$( '[data-toggle=popover]' ).popover();
	}

}).apply( this, [ jQuery ]);

// Tooltip
(function( $ ) {

	'use strict';

	if ( $.isFunction( $.fn['tooltip'] ) ) {
		$( '[data-toggle=tooltip],[rel=tooltip]' ).tooltip({ container: 'body' });
	}

}).apply( this, [ jQuery ]);

// Sidebar Widgets
(function( $ ) {

	'use strict';

	function expand( content ) {
		content.children( '.widget-content' ).slideDown( 'fast', function() {
			$(this).css( 'display', '' );
			content.removeClass( 'widget-collapsed' );
		});
	}

	function collapse( content ) {
		content.children('.widget-content' ).slideUp( 'fast', function() {
			content.addClass( 'widget-collapsed' );
			$(this).css( 'display', '' );
		});
	}

	var $widgets = $( '.sidebar-widget' );

	$widgets.each( function() {

		var $widget = $( this ),
			$toggler = $widget.find( '.widget-toggle' );

		$toggler.on('click.widget-toggler', function() {
			$widget.hasClass('widget-collapsed') ? expand($widget) : collapse($widget);
		});
	});

}).apply( this, [ jQuery ]);

// Codemirror
(function( $ ) {

	'use strict';

	if ( typeof CodeMirror !== 'undefined' ) {

		$(function() {
			$('[data-plugin-codemirror]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginCodeMirror(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Colorpicker
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'colorpicker' ]) ) {

		$(function() {
			$('[data-plugin-colorpicker]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginColorPicker(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Datepicker
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'datepicker' ]) ) {

		$(function() {
			$('[data-plugin-datepicker]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginDatePicker(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// iosSwitcher
(function( $ ) {

	'use strict';

	if ( typeof Switch !== 'undefined' && $.isFunction( Switch ) ) {

		$(function() {
			$('[data-plugin-ios-switch]').each(function() {
				var $this = $( this );

				$this.themePluginIOS7Switch();
			});
		});

	}

}).apply(this, [ jQuery ]);

// Markdown
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'markdown' ]) ) {

		$(function() {
			$('[data-plugin-markdown-editor]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginMarkdownEditor(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Masked Input
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'mask' ]) ) {

		$(function() {
			$('[data-plugin-masked-input]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginMaskedInput(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// MaxLength
(function( $ ) {

	'use strict';

	if ( $.isFunction( $.fn[ 'maxlength' ]) ) {

		$(function() {
			$('[data-plugin-maxlength]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginMaxLength(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// MultiSelect
(function( $ ) {

	'use strict';

	if ( $.isFunction( $.fn[ 'multiselect' ] ) ) {

		$(function() {
			$( '[data-plugin-multiselect]' ).each(function() {

				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginMultiSelect(opts);

			});
		});

	}

}).apply( this, [ jQuery ]);

(function( $ ) {

	'use strict';

	if ( $.isFunction( $.fn[ 'placeholder' ]) ) {

		$('input[placeholder]').placeholder();

	}

}).apply(this, [ jQuery ]);


// Select2
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'select2' ]) ) {

		$(function() {
			$('[data-plugin-selectTwo]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginSelect2(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Spinner
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'spinner' ]) ) {

		$(function() {
			$('[data-plugin-spinner]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginSpinner(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// SummerNote
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'summernote' ]) ) {

		$(function() {
			$('[data-plugin-summernote]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginSummerNote(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// TextArea AutoSize
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'autosize' ]) ) {

		$(function() {
			$('[data-plugin-textarea-autosize]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginTextAreaAutoSize(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// TimePicker
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'timepicker' ]) ) {

		$(function() {
			$('[data-plugin-timepicker]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginTimePicker(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Mailbox
(function( $ ) {

	'use strict';

	$(function() {
		$('[data-mailbox]').each(function() {
			var $this = $( this );

			$this.themeMailbox();
		});
	});

}).apply(this, [ jQuery ]);

// Animate
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'appear' ]) ) {

		$(function() {
			$('[data-plugin-animate], [data-appear-animation]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginAnimate(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Carousel
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'owlCarousel' ]) ) {

		$(function() {
			$('[data-plugin-carousel]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginCarousel(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Chart Circular
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'easyPieChart' ]) ) {

		$(function() {
			$('[data-plugin-chart-circular], .circular-bar-chart:not(.manual)').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginChartCircular(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Lightbox
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'magnificPopup' ]) ) {

		$(function() {
			$('[data-plugin-lightbox], .lightbox:not(.manual)').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginLightbox(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Portlets
(function( $ ) {

	'use strict';

	$(function() {
		$('[data-plugin-portlet]').each(function() {
			var $this = $( this ),
				opts = {};

			var pluginOptions = $this.data('plugin-options');
			if (pluginOptions)
				opts = pluginOptions;

			$this.themePluginPortlet(opts);
		});
	});

}).apply(this, [ jQuery ]);

// Slider
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'slider' ]) ) {

		$(function() {
			$('[data-plugin-slider]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions) {
					opts = pluginOptions;
				}

				$this.themePluginSlider(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Toggle
(function( $ ) {

	'use strict';

	$(function() {
		$('[data-plugin-toggle]').each(function() {
			var $this = $( this ),
				opts = {};

			var pluginOptions = $this.data('plugin-options');
			if (pluginOptions)
				opts = pluginOptions;

			$this.themePluginToggle(opts);
		});
	});

}).apply(this, [ jQuery ]);

// Widget - Todo
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'themePluginWidgetTodoList' ]) ) {

		$(function() {
			$('[data-plugin-todo-list], ul.widget-todo-list').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginWidgetTodoList(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);

// Widget - Toggle
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'themePluginWidgetToggleExpand' ]) ) {

		$(function() {
			$('[data-plugin-toggle-expand], .widget-toggle-expand').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginWidgetToggleExpand(opts);
			});
		});
	}

}).apply(this, [ jQuery ]);

// Word Rotate
(function( $ ) {

	'use strict';

	if ( $.isFunction($.fn[ 'themePluginWordRotate' ]) ) {

		$(function() {
			$('[data-plugin-word-rotate], .word-rotate:not(.manual)').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginWordRotate(opts);
			});
		});

	}

}).apply(this, [ jQuery ]);
(function( $ ) {

	$('#treeBasic').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
		'types' : {
			'default' : {
				'icon' : 'fa fa-folder'
			},
			'file' : {
				'icon' : 'fa fa-file'
			}
		},
		'plugins': ['types']
	});

	$('li[rel=""]').attr('rel','disabled');

}).apply( this, [ jQuery ]);
(function($) {
  'use strict';

  var _currentSpinnerId = 0;

  function _scopedEventName(name, id) {
    return name + '.touchspin_' + id;
  }

  function _scopeEventNames(names, id) {
    return $.map(names, function(name) {
      return _scopedEventName(name, id);
    });
  }

  $.fn.TouchSpin = function(options) {

    if (options === 'destroy') {
      this.each(function() {
        var originalinput = $(this),
            originalinput_data = originalinput.data();
        $(document).off(_scopeEventNames([
          'mouseup',
          'touchend',
          'touchcancel',
          'mousemove',
          'touchmove',
          'scroll',
          'scrollstart'], originalinput_data.spinnerid).join(' '));
      });
      return;
    }

    var defaults = {
      min: 0,
      max: 100,
      initval: '',
      replacementval: '',
      step: 1,
      decimals: 0,
      stepinterval: 100,
      forcestepdivisibility: 'round', // none | floor | round | ceil
      stepintervaldelay: 500,
      verticalbuttons: false,
      verticalupclass: 'glyphicon glyphicon-chevron-up',
      verticaldownclass: 'glyphicon glyphicon-chevron-down',
      prefix: '',
      postfix: '',
      prefix_extraclass: '',
      postfix_extraclass: '',
      booster: true,
      boostat: 10,
      maxboostedstep: false,
      mousewheel: true,
      buttondown_class: 'btn btn-default',
      buttonup_class: 'btn btn-default',
	  buttondown_txt: '-',
	  buttonup_txt: '+'
    };

    var attributeMap = {
      min: 'min',
      max: 'max',
      initval: 'init-val',
      replacementval: 'replacement-val',
      step: 'step',
      decimals: 'decimals',
      stepinterval: 'step-interval',
      verticalbuttons: 'vertical-buttons',
      verticalupclass: 'vertical-up-class',
      verticaldownclass: 'vertical-down-class',
      forcestepdivisibility: 'force-step-divisibility',
      stepintervaldelay: 'step-interval-delay',
      prefix: 'prefix',
      postfix: 'postfix',
      prefix_extraclass: 'prefix-extra-class',
      postfix_extraclass: 'postfix-extra-class',
      booster: 'booster',
      boostat: 'boostat',
      maxboostedstep: 'max-boosted-step',
      mousewheel: 'mouse-wheel',
      buttondown_class: 'button-down-class',
      buttonup_class: 'button-up-class',
	  buttondown_txt: 'button-down-txt',
	  buttonup_txt: 'button-up-txt'
    };

    return this.each(function() {

      var settings,
          originalinput = $(this),
          originalinput_data = originalinput.data(),
          container,
          elements,
          value,
          downSpinTimer,
          upSpinTimer,
          downDelayTimeout,
          upDelayTimeout,
          spincount = 0,
          spinning = false;

      init();


      function init() {
        if (originalinput.data('alreadyinitialized')) {
          return;
        }

        originalinput.data('alreadyinitialized', true);
        _currentSpinnerId += 1;
        originalinput.data('spinnerid', _currentSpinnerId);


        if (!originalinput.is('input')) {
          console.log('Must be an input.');
          return;
        }

        _initSettings();
        _setInitval();
        _checkValue();
        _buildHtml();
        _initElements();
        _hideEmptyPrefixPostfix();
        _bindEvents();
        _bindEventsInterface();
        elements.input.css('display', 'block');
      }

      function _setInitval() {
        if (settings.initval !== '' && originalinput.val() === '') {
          originalinput.val(settings.initval);
        }
      }

      function changeSettings(newsettings) {
        _updateSettings(newsettings);
        _checkValue();

        var value = elements.input.val();

        if (value !== '') {
          value = Number(elements.input.val());
          elements.input.val(value.toFixed(settings.decimals));
        }
      }

      function _initSettings() {
        settings = $.extend({}, defaults, originalinput_data, _parseAttributes(), options);
      }

      function _parseAttributes() {
        var data = {};
        $.each(attributeMap, function(key, value) {
          var attrName = 'bts-' + value + '';
          if (originalinput.is('[data-' + attrName + ']')) {
            data[key] = originalinput.data(attrName);
          }
        });
        return data;
      }

      function _updateSettings(newsettings) {
        settings = $.extend({}, settings, newsettings);
      }

      function _buildHtml() {
        var initval = originalinput.val(),
            parentelement = originalinput.parent();

        if (initval !== '') {
          initval = Number(initval).toFixed(settings.decimals);
        }

        originalinput.data('initvalue', initval).val(initval);
        originalinput.addClass('form-control');

        if (parentelement.hasClass('input-group')) {
          _advanceInputGroup(parentelement);
        }
        else {
          _buildInputGroup();
        }
      }

      function _advanceInputGroup(parentelement) {
        parentelement.addClass('bootstrap-touchspin');

        var prev = originalinput.prev(),
            next = originalinput.next();

        var downhtml,
            uphtml,
            prefixhtml = '<span class="input-group-addon bootstrap-touchspin-prefix">' + settings.prefix + '</span>',
            postfixhtml = '<span class="input-group-addon bootstrap-touchspin-postfix">' + settings.postfix + '</span>';

        if (prev.hasClass('input-group-btn')) {
          downhtml = '<button class="' + settings.buttondown_class + ' bootstrap-touchspin-down" type="button">' + settings.buttondown_txt + '</button>';
          prev.append(downhtml);
        }
        else {
          downhtml = '<span class="input-group-btn"><button class="' + settings.buttondown_class + ' bootstrap-touchspin-down" type="button">' + settings.buttondown_txt + '</button></span>';
          $(downhtml).insertBefore(originalinput);
        }

        if (next.hasClass('input-group-btn')) {
          uphtml = '<button class="' + settings.buttonup_class + ' bootstrap-touchspin-up" type="button">' + settings.buttonup_txt + '</button>';
          next.prepend(uphtml);
        }
        else {
          uphtml = '<span class="input-group-btn"><button class="' + settings.buttonup_class + ' bootstrap-touchspin-up" type="button">' + settings.buttonup_txt + '</button></span>';
          $(uphtml).insertAfter(originalinput);
        }

        $(prefixhtml).insertBefore(originalinput);
        $(postfixhtml).insertAfter(originalinput);

        container = parentelement;
      }

      function _buildInputGroup() {
        var html;

        if (settings.verticalbuttons) {
          html = '<div class="input-group bootstrap-touchspin"><span class="input-group-addon bootstrap-touchspin-prefix">' + settings.prefix + '</span><span class="input-group-addon bootstrap-touchspin-postfix">' + settings.postfix + '</span><span class="input-group-btn-vertical"><button class="' + settings.buttondown_class + ' bootstrap-touchspin-up" type="button"><i class="' + settings.verticalupclass + '"></i></button><button class="' + settings.buttonup_class + ' bootstrap-touchspin-down" type="button"><i class="' + settings.verticaldownclass + '"></i></button></span></div>';
        }
        else {
          html = '<div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="' + settings.buttondown_class + ' bootstrap-touchspin-down" type="button">' + settings.buttondown_txt + '</button></span><span class="input-group-addon bootstrap-touchspin-prefix">' + settings.prefix + '</span><span class="input-group-addon bootstrap-touchspin-postfix">' + settings.postfix + '</span><span class="input-group-btn"><button class="' + settings.buttonup_class + ' bootstrap-touchspin-up" type="button">' + settings.buttonup_txt + '</button></span></div>';
        }

        container = $(html).insertBefore(originalinput);

        $('.bootstrap-touchspin-prefix', container).after(originalinput);

        if (originalinput.hasClass('input-sm')) {
          container.addClass('input-group-sm');
        }
        else if (originalinput.hasClass('input-lg')) {
          container.addClass('input-group-lg');
        }
      }

      function _initElements() {
        elements = {
          down: $('.bootstrap-touchspin-down', container),
          up: $('.bootstrap-touchspin-up', container),
          input: $('input', container),
          prefix: $('.bootstrap-touchspin-prefix', container).addClass(settings.prefix_extraclass),
          postfix: $('.bootstrap-touchspin-postfix', container).addClass(settings.postfix_extraclass)
        };
      }

      function _hideEmptyPrefixPostfix() {
        if (settings.prefix === '') {
          elements.prefix.hide();
        }

        if (settings.postfix === '') {
          elements.postfix.hide();
        }
      }

      function _bindEvents() {
        originalinput.on('keydown', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 38) {
            if (spinning !== 'up') {
              upOnce();
              startUpSpin();
            }
            ev.preventDefault();
          }
          else if (code === 40) {
            if (spinning !== 'down') {
              downOnce();
              startDownSpin();
            }
            ev.preventDefault();
          }
        });

        originalinput.on('keyup', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 38) {
            stopSpin();
          }
          else if (code === 40) {
            stopSpin();
          }
        });

        originalinput.on('blur', function() {
          _checkValue();
        });

        elements.down.on('keydown', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            if (spinning !== 'down') {
              downOnce();
              startDownSpin();
            }
            ev.preventDefault();
          }
        });

        elements.down.on('keyup', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            stopSpin();
          }
        });

        elements.up.on('keydown', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            if (spinning !== 'up') {
              upOnce();
              startUpSpin();
            }
            ev.preventDefault();
          }
        });

        elements.up.on('keyup', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            stopSpin();
          }
        });

        elements.down.on('mousedown.touchspin', function(ev) {
          elements.down.off('touchstart.touchspin');  // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          }

          downOnce();
          startDownSpin();

          ev.preventDefault();
          ev.stopPropagation();
        });

        elements.down.on('touchstart.touchspin', function(ev) {
          elements.down.off('mousedown.touchspin');  // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          }

          downOnce();
          startDownSpin();

          ev.preventDefault();
          ev.stopPropagation();
        });

        elements.up.on('mousedown.touchspin', function(ev) {
          elements.up.off('touchstart.touchspin');  // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          }

          upOnce();
          startUpSpin();

          ev.preventDefault();
          ev.stopPropagation();
        });

        elements.up.on('touchstart.touchspin', function(ev) {
          elements.up.off('mousedown.touchspin');  // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          }

          upOnce();
          startUpSpin();

          ev.preventDefault();
          ev.stopPropagation();
        });

        elements.up.on('mouseout touchleave touchend touchcancel', function(ev) {
          if (!spinning) {
            return;
          }

          ev.stopPropagation();
          stopSpin();
        });

        elements.down.on('mouseout touchleave touchend touchcancel', function(ev) {
          if (!spinning) {
            return;
          }

          ev.stopPropagation();
          stopSpin();
        });

        elements.down.on('mousemove touchmove', function(ev) {
          if (!spinning) {
            return;
          }

          ev.stopPropagation();
          ev.preventDefault();
        });

        elements.up.on('mousemove touchmove', function(ev) {
          if (!spinning) {
            return;
          }

          ev.stopPropagation();
          ev.preventDefault();
        });

        $(document).on(_scopeEventNames(['mouseup', 'touchend', 'touchcancel'], _currentSpinnerId).join(' '), function(ev) {
          if (!spinning) {
            return;
          }

          ev.preventDefault();
          stopSpin();
        });

        $(document).on(_scopeEventNames(['mousemove', 'touchmove', 'scroll', 'scrollstart'], _currentSpinnerId).join(' '), function(ev) {
          if (!spinning) {
            return;
          }

          ev.preventDefault();
          stopSpin();
        });

        originalinput.on('mousewheel DOMMouseScroll', function(ev) {
          if (!settings.mousewheel || !originalinput.is(':focus')) {
            return;
          }

          var delta = ev.originalEvent.wheelDelta || -ev.originalEvent.deltaY || -ev.originalEvent.detail;

          ev.stopPropagation();
          ev.preventDefault();

          if (delta < 0) {
            downOnce();
          }
          else {
            upOnce();
          }
        });
      }

      function _bindEventsInterface() {
        originalinput.on('touchspin.uponce', function() {
          stopSpin();
          upOnce();
        });

        originalinput.on('touchspin.downonce', function() {
          stopSpin();
          downOnce();
        });

        originalinput.on('touchspin.startupspin', function() {
          startUpSpin();
        });

        originalinput.on('touchspin.startdownspin', function() {
          startDownSpin();
        });

        originalinput.on('touchspin.stopspin', function() {
          stopSpin();
        });

        originalinput.on('touchspin.updatesettings', function(e, newsettings) {
          changeSettings(newsettings);
        });
      }

      function _forcestepdivisibility(value) {
        switch (settings.forcestepdivisibility) {
          case 'round':
            return (Math.round(value / settings.step) * settings.step).toFixed(settings.decimals);
          case 'floor':
            return (Math.floor(value / settings.step) * settings.step).toFixed(settings.decimals);
          case 'ceil':
            return (Math.ceil(value / settings.step) * settings.step).toFixed(settings.decimals);
          default:
            return value;
        }
      }

      function _checkValue() {
        var val, parsedval, returnval;

        val = originalinput.val();

        if (val === '') {
          if (settings.replacementval !== '') {
            originalinput.val(settings.replacementval);
            originalinput.trigger('change');
          }
          return;
        }

        if (settings.decimals > 0 && val === '.') {
          return;
        }

        parsedval = parseFloat(val);

        if (isNaN(parsedval)) {
          if (settings.replacementval !== '') {
            parsedval = settings.replacementval;
          }
          else {
            parsedval = 0;
          }
        }

        returnval = parsedval;

        if (parsedval.toString() !== val) {
          returnval = parsedval;
        }

        if (parsedval < settings.min) {
          returnval = settings.min;
        }

        if (parsedval > settings.max) {
          returnval = settings.max;
        }

        returnval = _forcestepdivisibility(returnval);

        if (Number(val).toString() !== returnval.toString()) {
          originalinput.val(returnval);
          originalinput.trigger('change');
        }
      }

      function _getBoostedStep() {
        if (!settings.booster) {
          return settings.step;
        }
        else {
          var boosted = Math.pow(2, Math.floor(spincount / settings.boostat)) * settings.step;

          if (settings.maxboostedstep) {
            if (boosted > settings.maxboostedstep) {
              boosted = settings.maxboostedstep;
              value = Math.round((value / boosted)) * boosted;
            }
          }

          return Math.max(settings.step, boosted);
        }
      }

      function upOnce() {
        _checkValue();

        value = parseFloat(elements.input.val());
        if (isNaN(value)) {
          value = 0;
        }

        var initvalue = value,
            boostedstep = _getBoostedStep();

        value = value + boostedstep;

        if (value > settings.max) {
          value = settings.max;
          originalinput.trigger('touchspin.on.max');
          stopSpin();
        }

        elements.input.val(Number(value).toFixed(settings.decimals));

        if (initvalue !== value) {
          originalinput.trigger('change');
        }
      }

      function downOnce() {
        _checkValue();

        value = parseFloat(elements.input.val());
        if (isNaN(value)) {
          value = 0;
        }

        var initvalue = value,
            boostedstep = _getBoostedStep();

        value = value - boostedstep;

        if (value < settings.min) {
          value = settings.min;
          originalinput.trigger('touchspin.on.min');
          stopSpin();
        }

        elements.input.val(value.toFixed(settings.decimals));

        if (initvalue !== value) {
          originalinput.trigger('change');
        }
      }

      function startDownSpin() {
        stopSpin();

        spincount = 0;
        spinning = 'down';

        originalinput.trigger('touchspin.on.startspin');
        originalinput.trigger('touchspin.on.startdownspin');

        downDelayTimeout = setTimeout(function() {
          downSpinTimer = setInterval(function() {
            spincount++;
            downOnce();
          }, settings.stepinterval);
        }, settings.stepintervaldelay);
      }

      function startUpSpin() {
        stopSpin();

        spincount = 0;
        spinning = 'up';

        originalinput.trigger('touchspin.on.startspin');
        originalinput.trigger('touchspin.on.startupspin');

        upDelayTimeout = setTimeout(function() {
          upSpinTimer = setInterval(function() {
            spincount++;
            upOnce();
          }, settings.stepinterval);
        }, settings.stepintervaldelay);
      }

      function stopSpin() {
        clearTimeout(downDelayTimeout);
        clearTimeout(upDelayTimeout);
        clearInterval(downSpinTimer);
        clearInterval(upSpinTimer);

        switch (spinning) {
          case 'up':
            originalinput.trigger('touchspin.on.stopupspin');
            originalinput.trigger('touchspin.on.stopspin');
            break;
          case 'down':
            originalinput.trigger('touchspin.on.stopdownspin');
            originalinput.trigger('touchspin.on.stopspin');
            break;
        }

        spincount = 0;
        spinning = false;
      }

    });

  };

})(jQuery);

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
    animation: true,
    animationSteps: 60,
    animationEasing: "easeOutQuart",
    showScale: true,
    scaleOverride: false,
    scaleSteps: null,
    scaleStepWidth: null,
    scaleStartValue: null,
    scaleLineColor: "rgba(0,0,0,.1)",
    scaleLineWidth: 1,
    scaleShowLabels: true,
    scaleLabel: "<%=value%>",
    scaleIntegersOnly: true,
    scaleBeginAtZero: false,
    scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
    scaleFontSize: 12,
    scaleFontStyle: "normal",
    scaleFontColor: "#666",
    responsive: true,
    maintainAspectRatio: true,
    showTooltips: true,
    customTooltips: false,
    tooltipEvents: ["mousemove", "touchstart", "touchmove"],
    tooltipFillColor: "rgba(0,0,0,0.8)",
    tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
    tooltipFontSize: 14,
    tooltipFontStyle: "normal",
    tooltipFontColor: "#fff",
    tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
    tooltipTitleFontSize: 14,
    tooltipTitleFontStyle: "bold",
    tooltipTitleFontColor: "#fff",
    tooltipYPadding: 6,
    tooltipXPadding: 6,
    tooltipCaretSize: 8,
    tooltipCornerRadius: 6,
    tooltipXOffset: 10,
    tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
    multiTooltipTemplate: "<%= value %>",

    // Function - Will fire on animation progression.
    onAnimationProgress: function(){},

    // Function - Will fire on animation completion.
    onAnimationComplete: function(){}
}

if(document.getElementById("performance-graph") != undefined) {
    var ctx = document.getElementById("performance-graph").getContext("2d");

    ctx.canvas.width = 50;
    ctx.canvas.height = 50;
    //sales_ctx.canvas.width = 300;

    // create_chart_by_subject(ctx);
    create_right_chart(ctx);

}

if(document.getElementById("performance-rights-graph") != undefined) {
    var ctx = document.getElementById("performance-rights-graph").getContext("2d");

    ctx.canvas.width = 50;
    ctx.canvas.height = 50;
    //sales_ctx.canvas.width = 300;

    create_right_chart(ctx);

}



function create_chart_by_subject(selector){
    $.ajax({
        url: "/exam/performance",
        data: {
            'question-exec': $("question").data("question-exec")
        },
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,

        success: function(data){
            //console.log(data);
            var data_keys = [];
            var data_values = [];

            $.each(data,function(key,value){
                data_keys.push(key);
                data_values.push(Math.floor((value[1] * 100) / value[0]));
            });



            // console.log(data_keys);
            //console.log(data_values);
            var values = {
                labels: data_keys,
                datasets: [
                    {
                        label: 'Cursos vendidos',
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: data_values
                    }]
            };
            //  console.log(values);


            var time_line_chart = new Chart(selector).Bar(values,{
                barShowStroke: false,
                responsive: false
            });

        }
    });
}

function create_right_chart(selector){
//console.log('right_chart');
    var values = [
        {
            value:  Number($("#results").data('rights')).toFixed(0),
            color:"#3D9056",
            highlight: "#45A46A",
            label: "Acertos"
        },
        {
            value: $("#results").data('partial') - $("#results").data('rights'),
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Erros"
        },



    ];


    // console.log(values);


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;
            var fontsize = (canvasHeight/constant).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";

            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });
            var tpercentage = ((values[0].value/total )*100).toFixed(0)+"%";
            var textWidth =  this.chart.ctx.measureText(tpercentage).width;

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);
            this.chart.ctx.fillStyle =  "#3D9056";
            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });







    var doughnut_chart = new Chart(selector).DoughnutAlt(values,{
        animation:true,
        responsive: true,
        showTooltips: true,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });

}


function create_time_chart(selector){





    var values = [
        {
            value: Math.floor($("#results").data('time') / 60),
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Tempo Utilizado"
        },
        {
            value: $("#results").data('total-time') - Math.floor($("#results").data('time') / 60) ,
            color:"#3D9056",
            highlight: "#45A46A",
            label: "Tempo Restante"
        }


    ];


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;
            var fontsize = (canvasHeight/constant).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";
            this.chart.ctx.fillStyle =  "#F7464A";
            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });
            var hours = Math.floor(values[0].value / 60);
            var minutes = Math.floor((values[0].value - (hours * 60))) ;

            //var tpercentage = (((values[0].value/total)*100) - 100).toFixed(2) * -1+"%";

            var tpercentage = hours + 'h' + minutes + 'm';
            var textWidth =  this.chart.ctx.measureText(tpercentage).width;

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);

            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    // console.log(values);

    var doughnut_chart = new Chart(selector).DoughnutAlt(values,{
        animation:true,
        responsive: true,
        showTooltips: true,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });

}

function create_average_time_chart(selector){

    var values = [
        {
            value: Math.floor($("#results").data('time') / $("#results").data("partial")),
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Tempo Médio"
        },
        {
            value: $("#results").data('total-time') - (Math.floor($("#results").data('time') / $("#results").data("partial"))),
            color:"#3D9056",
            highlight: "#45A46A",
            label: "Tempo Máximo"
        }


    ];


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;
            var fontsize = (canvasHeight/constant).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";
            this.chart.ctx.fillStyle =  "#F7464A";
            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });

            var minutes = Math.floor((values[0].value / 60)) ;
            var seconds = Math.floor((values[0].value - (minutes * 60)));

            //var tpercentage = (((values[0].value/total)*100) - 100).toFixed(2) * -1+"%";

            var tpercentage = minutes + 'm' + seconds + 's';
            var textWidth =  this.chart.ctx.measureText(tpercentage).width;

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);

            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    //  console.log(values);

    var doughnut_chart = new Chart(selector).DoughnutAlt(values,{
        animation:true,
        responsive: true,
        showTooltips: true,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });
}

function create_total_chart(selector,show_percentage){


    var values = [
        {
            value: $("#results").data("partial"),
            color:"#31708f",
            highlight: "#31778f",
            label: "Questões"
        },
        {
            value: $("#results").data("total") - $("#results").data("partial") ,
            color:"#AAAABB",
            highlight: "#AAB1BB",
            label: "Questões"
        }

    ];

    console.log(selector);


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;
            var fontsize = (canvasHeight/constant - 1.0).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";
            this.chart.ctx.fillStyle =  "#31708f";
            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });



            var tpercentage = values[0].value + '/' + $("#results").data("total");
            if(show_percentage != undefined) tpercentage = ((values[0].value/total )*100).toFixed(0)+"%";
            var textWidth =  this.chart.ctx.measureText(tpercentage).width;

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);

            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    //  console.log(values);

    var doughnut_chart = new Chart(selector).DoughnutAlt(values,{
        animation:true,
        responsive: true,
        showTooltips: true,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });
}


function create_clock(selector){
    var values = [
        {
            value: timer,
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Acertos"
        },
        {
            value: parse_time_to_sec($("#time").data('time')) - timer,
            color: "lightgray",
            highlight:  "#5AFF5E",
            label: "Erros"
        }
    ];

    var doughnut_chart = new Chart(selector).Doughnut(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 50,
        segmentShowStroke : false,
        scaleOverride : false,
        maintainAspectRatio: false
    });

    return doughnut_chart;
}


function create_dashboard_right_chart(){

    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;

            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseFloat(this.value,10);
            });
            var tpercentage = ((values[0].value/total )*100).toFixed(0)+"%";

            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";

            var textWidth =  this.chart.ctx.measureText(tpercentage).width;
            var textHeight =  this.chart.ctx.measureText(tpercentage).height;

            console.log(this.chart.ctx.measureText(tpercentage));

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);
            this.chart.ctx.fillStyle =  "#3D9056";
            this.chart.ctx.fillText(tpercentage, txtPosx, ((canvasHeight )/2) );
            console.log("canvasHeight " + canvasHeight);
            console.log("textHeight " + textHeight);
        }
    });





    $(".best-graph").each(function(){




        console.log(Number($(this).data("best")));
        var values = [
            {
                value:  Number($(this).data("best")),
                color:"#5FBEAA",
                highlight: "#45A46A",
                label: "Acertos"
            },
            {
                value: Number($(this).data("questions-count")) - Number($(this).data('best')),
                color:"#CCCCCC",
                highlight: "#FF5A5E",
                label: "Erros"
            }


        ];

        console.log("Exemplo");
        var ctx = $(this).find('.best-result-graph')[0].getContext('2d');
        console.log(ctx);
        ctx.canvas.width = '100';
        ctx.canvas.height = '100';

        var doughnut_chart = new Chart(ctx).DoughnutAlt(values,{
            animation:false,
            responsive: false,
            showTooltips: false,
            percentageInnerCutout : 70,
            segmentShowStroke : false,
            scaleOverride : true,
            maintainAspectRatio: false
        });
    });

}

function create_performance_results_chart() {
    {

        Chart.types.Doughnut.extend({
            name: "DoughnutAlt",
            draw: function () {
                Chart.types.Doughnut.prototype.draw.apply(this, arguments);

                var canvasWidthvar = this.chart.width;
                var canvasHeight = this.chart.height;
                var constant = 114;

                var total = 0;
                var values = this.segments;
                $.each(values, function () {
                    total += parseInt(this.value, 10);
                });
                var tpercentage = ((values[0].value / total ) * 100).toFixed(0) + "%";

                var fontsize = (canvasHeight / constant).toFixed(2);
                this.chart.ctx.font = fontsize + "em Titillium Web,Arial,sans-serif";
                this.chart.ctx.textBaseline = "middle";
                this.chart.ctx.textAlign = "left";

                var textWidth = this.chart.ctx.measureText(tpercentage).width;
                var textHeight = this.chart.ctx.measureText(tpercentage).height;

                console.log(this.chart.ctx.measureText(tpercentage));

                var txtPosx = Math.round((canvasWidthvar - textWidth) / 2);
                this.chart.ctx.fillStyle = "#3D9056";
                this.chart.ctx.fillText(tpercentage, txtPosx, ((canvasHeight ) / 2));
                console.log("canvasHeight " + canvasHeight);
                console.log("textHeight " + textHeight);
            }
        });


        $(".performance-result-graph").each(function () {
            var values = [
                {
                    value: Number($(this).data("result")),
                    color: "#5FBEAA",
                    highlight: "#45A46A",
                    label: "Acertos"
                },
                {
                    value: 100 - Number($(this).data('result')),
                    color: "#CCCCCC",
                    highlight: "#FF5A5E",
                    label: "Erros"
                }


            ];


            var ctx = $(this).find('.performance-result-graph')[0].getContext('2d');
            console.log(ctx);
            ctx.canvas.width = '100';
            ctx.canvas.height = '100';

            var doughnut_chart = new Chart(ctx).DoughnutAlt(values, {
                animation: true,
                responsive: false,
                showTooltips: false,
                percentageInnerCutout: 70,
                segmentShowStroke: false,
                scaleOverride: true,
                maintainAspectRatio: false
            });
        });

    }
}


function create_intro_results_chart(){

    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;

            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });
            var tpercentage = ((values[0].value/total )*100).toFixed(0)+"%";

            var fontsize = (canvasHeight/constant).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";

            var textWidth =  this.chart.ctx.measureText(tpercentage).width;
            var textHeight =  this.chart.ctx.measureText(tpercentage).height;

            console.log(this.chart.ctx.measureText(tpercentage));

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);
            this.chart.ctx.fillStyle =  "#3D9056";
            this.chart.ctx.fillText(tpercentage, txtPosx, ((canvasHeight )/2) );
            console.log("canvasHeight " + canvasHeight);
            console.log("textHeight " + textHeight);
        }
    });




    $(".result-graph").each(function(){
        var values = [
            {
                value:  Number($(this).data("result")),
                color:"#5FBEAA",
                highlight: "#45A46A",
                label: "Acertos"
            },
            {
                value: 100 - Number($(this).data('result')),
                color:"#CCCCCC",
                highlight: "#FF5A5E",
                label: "Erros"
            }


        ];

        console.log("Exemplo");
        var ctx = $(this).find('.intro-result-graph')[0].getContext('2d');
        console.log(ctx);
        ctx.canvas.width = '100';
        ctx.canvas.height = '100';

        var doughnut_chart = new Chart(ctx).DoughnutAlt(values,{
            animation:true,
            responsive: false,
            showTooltips: false,
            percentageInnerCutout : 70,
            segmentShowStroke : false,
            scaleOverride : true,
            maintainAspectRatio: false
        });
    });

}




function create_dashboard_study_charts(){

    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;



            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";


            var total = 0;
            var values = this.segments;
            //      console.log('resto - ' + values[1].value + 'total ' + values[0].value);
            $.each(values,function() {
                total += this.value;
            });
            //console.log('total: ' + total);
            var percentage = ((values[0].value/total )*100).toFixed(0);
            var tpercentage = percentage +"%";

            if(percentage < 40){


                this.segments[0].fillColor = "#F7464A";
                this.segments[0].highlightColor = "#FF5A5E";
                this.chart.ctx.fillStyle =  "#FF5A5E";

            }else if(percentage < 70){
                this.segments[0].fillColor = "#D4C76A";
                this.segments[0].highlightColor = "#FFF4AA";
                this.chart.ctx.fillStyle =  "#FFF4AA";

            }


            var textWidth =  this.chart.ctx.measureText(tpercentage).width;


            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);


            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);

            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });



    var study_time = $("#study-achievements").data("study-time");

    //  console.log( $("#study-plan-daily").data('time-today'));
    //  console.log(study_time);



    var daily_values =
        [

            {
                value: $("#study-plan-daily").data('time-today') / 3600,
                color:"#3D9056",
                highlight: "#45A46A",
                label: 'Horas Cumpridas'
            },
            {
                value: study_time - ( $("#study-plan-daily").data('time-today') / 3600 ),
                color:"#E6E6E6",
                highlight: "#EEFAFA",
                label: 'Horas diárias'
            }



        ];



    var weekly_values =
        [

            {
                value: $("#study-plan-weekly").data('time-this-week') / 3600,
                color:"#3D9056",
                highlight: "#45A46A",
                label: 'Horas Cumpridas'
            },
            {
                value: study_time * 7 - ($("#study-plan-weekly").data('time-this-week') / 3600),
                color:"#E6E6E6",
                highlight: "#EEFAFA",
                label: 'Horas semanais'
            }

        ];


    var monthly_values =
        [
            {
                value: $("#study-plan-monthly").data('time-this-month') / 3600,
                color:"#3D9056",
                highlight: "#45A46A",
                label: 'Horas Cumpridas'
            },
            {
                value: study_time * 30 - ($("#study-plan-monthly").data('time-this-month') / 3600),
                color:"#E6E6E6",
                highlight: "#EEFAFA",
                label: 'Horas mensais'
            }


        ];

    var ctxDaily = $("#study-plan-daily")[0].getContext('2d');
    ctxDaily.canvas.width = '100';
    ctxDaily.canvas.height = '100';

    var ctxWeekly = $("#study-plan-weekly")[0].getContext('2d');
    ctxWeekly.canvas.width = '100';
    ctxWeekly.canvas.height = '100';

    var ctxMonthly = $("#study-plan-monthly")[0].getContext('2d');
    ctxMonthly.canvas.width = '100';
    ctxMonthly.canvas.height = '100';



    var doughnut_chart_daily = new Chart(ctxDaily).DoughnutAlt(daily_values,{
            animation:true,
            animationSteps: 40,
            responsive: false,
            showTooltips: false,
            percentageInnerCutout : 70,
            segmentShowStroke : false,
            scaleOverride : true,
            maintainAspectRatio: false
        });

    var doughnut_chart_monthly = new Chart(ctxMonthly).DoughnutAlt(monthly_values,{
        animation:true,
        animationSteps: 40,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });

    var doughnut_chart_weekly = new Chart(ctxWeekly).DoughnutAlt(weekly_values,{
        animation:true,
        animationSteps: 40,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false,
        scaleFontSize: 16,
        tooltipFontSize: 16,
    });

}

var period_values;
var period_progress_data;
var study_time;
function create_dashboard_progress_charts(){
    $.ajax({
        url: "/dashboard/progress",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,

        success: function(data){

            period_progress_data = data;

            study_time = $("#study-achievements").data("study-time");
            var daily = data['daily'];



            var data_keys = [];
            var data_values = [];
            var data_empty = [];

            $.each(daily,function(key,value){
                data_keys.push(key);
                data_values.push(value / 3600);
                data_empty.push(study_time);
            });


            period_values = {
                labels: data_keys,
                datasets: [
                    {
                        label: 'Horas Assistidas',
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: data_values
                    },
                    {
                        label: 'Horas Assistidas',
                        fillColor: "rgba(200,200,225,0.0)",
                        strokeColor: "#00CCCC",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        pointColor: "rgba(0,0,0,0)",
                        pointStrokeColor: "rgba(0,0,0,0)",
                        pointHighlightFill: "rgba(0,0,0,0)",
                        pointHighlightStroke: "rgba(0,0,0,0)",
                        data: data_empty
                    },
                    {
                        label: 'Horas Assistidas',
                        fillColor: "rgba(200,200,225,0.0)",
                        strokeColor:  "rgba(151,187,205,0.0)",
                        highlightFill: "rgba(151,187,205,0.0)",
                        highlightStroke: "rgba(151,187,205,0)",
                        pointColor: "rgba(0,0,0,0)",
                        pointStrokeColor: "rgba(0,0,0,0)",
                        pointHighlightFill: "rgba(0,0,0,0)",
                        pointHighlightStroke: "rgba(0,0,0,0)",
                        data: [study_time + 1]
                    }]
            };

            console.log('set initial value');
            $(window).resize(respondCanvas);
            respondCanvas();

            $("#daily-progress").click("daily", change_period_values);
            $("#weekly-progress").click("weekly", change_period_values);
            $("#monthly-progress").click("monthly",change_period_values);


        }
    });
}

function change_period_values(type){
    if(period_progress_data != undefined){
        var data;
        if(type.data == "daily"){
            study_time = $("#study-achievements").data("study-time");
            data = period_progress_data['daily'];
            $("#progress-by-title").text('Horas Assistidas nos últimos 8 dias');
            $(".progress-title").css('font-weight','normal');
            $("#daily-progress").css('font-weight','bold');

        }else if(type.data == "weekly"){
            study_time = $("#study-achievements").data("study-time") * 7;
            data = period_progress_data['weekly'];
            $("#progress-by-title").text('Horas Assistidas nas últimas 8 semanas');
            $(".progress-title").css('font-weight','normal');
            $("#weekly-progress").css('font-weight','bold');

        }else{
            study_time = $("#study-achievements").data("study-time") * daysInMonth(new Date().getMonth(), new Date().getFullYear());
            data = period_progress_data['monthly'];
            $("#progress-by-title").text('Horas Assistidas nos últimos 8 meses');
            $(".progress-title").css('font-weight','normal');
            $("#monthly-progress").css('font-weight','bold');
        }

        var data_keys = [];
        var data_values = [];
        var data_empty = [];

        $.each(data,function(key,value){
            data_keys.push(key);
            data_values.push(value / 3600);
            data_empty.push(study_time);
        });



        period_values = {
            labels: data_keys,
            datasets: [
                {
                    label: 'Horas Assistidas',
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: data_values
                },
                {
                    label: 'Horas Assistidas',
                    fillColor: "rgba(200,200,225,0.0)",
                    strokeColor: "#00CCCC",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    pointColor: "rgba(0,0,0,0)",
                    pointStrokeColor: "rgba(0,0,0,0)",
                    pointHighlightFill: "rgba(0,0,0,0)",
                    pointHighlightStroke: "rgba(0,0,0,0)",
                    data: data_empty
                },
                {
                    label: 'Horas Assistidas',
                    fillColor: "rgba(200,200,225,0.0)",
                    strokeColor:  "rgba(151,187,205,0.0)",
                    highlightFill: "rgba(151,187,205,0.0)",
                    highlightStroke: "rgba(151,187,205,0)",
                    pointColor: "rgba(0,0,0,0)",
                    pointStrokeColor: "rgba(0,0,0,0)",
                    pointHighlightFill: "rgba(0,0,0,0)",
                    pointHighlightStroke: "rgba(0,0,0,0)",
                    data: [study_time + 1]
                }]
        };

        respondCanvas();

    }
}

function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}

function respondCanvas() {

    Chart.types.Line.extend({
        name: "ProgressLine",
        draw: function () {
            Chart.types.Line.prototype.draw.apply(this, arguments);

            var points = this.datasets[0].points;

            $.each(points ,function() {
                this.fillColor = "#FFFFFF";
                this.highlightFill = "#FFFFFF";
                if(this.value < study_time){

                    this.strokeColor = "#FF5531";
                    this.highlightStroke = "#FF5531";

                }else{
                    this.strokeColor = "#55FF31";
                    this.highlightStroke = "#55FF31";

                }
            });


        }
    });


    $("#study-plan-continuous").attr('width',  $("#canvas-container").offsetParent().width());
    $("#study-plan-continuous").attr('height', $("#canvas-wrapper").height());
    $("#canvas-wrapper").css('width',  $("#canvas-container").offsetParent().width());

    $("#study-plan-continuous").css('width',  $("#canvas-container").offsetParent().width());
    $("#study-plan-continuous").css('height', $("#canvas-wrapper").height());


    var progress_column_height = $("#progress-column").css('height');
    if(progress_column_height != undefined){
    var card_column_height = $("#card-column").css('height');
    var column_difference =  Number(progress_column_height.substr(0,progress_column_height.length - 2))  - Number(card_column_height.substr(0,card_column_height.length - 2));

    var study_plan_height = $("#study-plan-continuous").css('height');
    study_plan_height = Number(study_plan_height.substr(0,study_plan_height.length - 2));


    $("#study-plan-continuous").css('height',(study_plan_height - column_difference) + "px");
    $("#study-plan-continuous").attr('height',(study_plan_height - column_difference) + "px");
    }else{
        var study_plan_height = $("#study-plan-continuous").css('height');
        study_plan_height = Number(study_plan_height.substr(0,study_plan_height.length - 2));
        $("#study-plan-continuous").css('height',(300) + "px");
        $("#study-plan-continuous").attr('height',(300) + "px");
    }


    var ctx = $("#study-plan-continuous")[0].getContext('2d');

    var time_line_chart = new Chart(ctx).ProgressLine(period_values,{
        bezierCurve: false,
        responsive: true,
        mantainAspectRatio: false,
        animation: false,
        showTooltips: false
    });


    $.each(time_line_chart.datasets[0].points,function(){
        this.fillColor = "#FFFFFF";
        this.highlightFill = "#FFFFFF";
        if(this.value < study_time){

            this.strokeColor = "#FF5531";
            this.highlightStroke = "#FF5531";

        }else{
            this.strokeColor = "#55FF31";
            this.highlightStroke = "#55FF31";

        }

        time_line_chart.update();
    });



}

function swap_result(){
    $(".current-attempt").click(function(){

        console.log("change.");
        $("#attempt-canvas").data('attempt',$(this).data('attempt-grade'));
        $("#attempt-canvas").data('total-questions',$(this).data("total-questions"));
        if($(this).data('attempt-date') != null && $(this).data('attempt-date') != ""){
        $("#result-date").html($(this).data('attempt-date'));
        }else{
            $("#result-date").html("Resultado Parcial");
        }
        $("#attempt-right").html("&nbsp;&nbsp;" + $(this).data('attempt-grade') + " ACERTOS");
        $("#attempt-wrong").html("&nbsp;&nbsp;" + ($("#attempt-canvas").data("total-questions") - $(this).data('attempt-grade')) + " ERROS");
        create_dashboard_result_chart();

    });

}




function create_dashboard_expected_chart(){


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;



            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";


            var total = 0;
            var values = this.segments;
            //      console.log('resto - ' + values[1].value + 'total ' + values[0].value);
            $.each(values,function() {
                total += this.value;
            });
            //console.log('total: ' + total);
            var percentage = ((values[0].value/total )*100).toFixed(0);
            var tpercentage = percentage +"%";



            var textWidth =  this.chart.ctx.measureText(tpercentage).width;


            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);


            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);

            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";

            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    var values = [
        {
            value:  Number($("#target-canvas").data("target")),
            color:"#61A9DC",
            highlight: "#45A46A",
            label: "Acertos"
        },
        {
            value: 100 - Number($("#target-canvas").data("target")),
            color:"#CCCCCC",
            highlight: "#FF5A5E",
            label: "Erros"
        }


    ];

    var ctx = $("#target-canvas")[0].getContext('2d');
    ctx.canvas.width = '100';
    ctx.canvas.height = '100';

    var doughnut_chart = new Chart(ctx).DoughnutAlt(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });


}

function create_dashboard_result_chart(){

    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;



            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";


            var total = 0;
            var values = this.segments;
            //      console.log('resto - ' + values[1].value + 'total ' + values[0].value);
            $.each(values,function() {
                total += this.value;
            });
            //console.log('total: ' + total);
            var percentage = ((values[0].value/total )*100).toFixed(0);
            var tpercentage = percentage +"%";



            var textWidth =  this.chart.ctx.measureText(tpercentage).width;


            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);


            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);

            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.fillStyle = "#CCCCCC";
            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });


    console.log(Number($('#attempt-canvas').data("total-questions")));




    console.log(Number($('#attempt-canvas').data("total-questions")) + Number($("#attempt-canvas").data("attempt")));

    console.log(Number($('#last-exam-results').data("questions-count")) - (Number($('#attempt-canvas').data("total-questions")) + Number($("#attempt-canvas").data("attempt"))));





    var values = [
        {
            value:  Number($("#attempt-canvas").data("attempt")),
            color:"#5FBEAA",
            highlight: "#45A46A",
            label: "Acertos"
        },
        {
            value: Number($('#attempt-canvas').data("total-questions")) - Number($("#attempt-canvas").data("attempt")),
            color:"#CCCCCC",
            highlight: "#FF5A5E",
            label: "Erros"
        },
        {
            value: Number($('#last-exam-results').data("questions-count")) - (Number($('#attempt-canvas').data("total-questions"))),
            color:"#FFF",
            highlight: "#FF5A5E",
            label: "Total"
        }


    ];

    var ctxCurrent = $('#attempt-canvas')[0].getContext('2d');
    ctxCurrent.canvas.width = '100';
    ctxCurrent.canvas.height = '100';

    var doughnut_chart = new Chart(ctxCurrent).DoughnutAlt(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });



}






function create_dashboard_enemies_chart(){


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;



            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";


            var total = 0;
            var values = this.segments;
            //      console.log('resto - ' + values[1].value + 'total ' + values[0].value);
            $.each(values,function() {
                total += this.value;
            });
            //console.log('total: ' + total);
            var percentage = ((values[0].value/total )*100).toFixed(0);
            var tpercentage = percentage +"%";



            var textWidth =  this.chart.ctx.measureText(tpercentage).width;


            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);

            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);

            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    var values = [
        {
            value:  Number($("#enemy-canvas").data("enemy")),
            color:"#ff9e5e",
            highlight: "#45A46A",
            label: "Acertos"
        },
        {
            value: Number($('#last-exam-results').data("questions-count")) - Number($("#enemy-canvas").data("enemy")),
            color:"#CCCCCC",
            highlight: "#FF5A5E",
            label: "Erros"
        }


    ];

    var ctxEnemy = $('#enemy-canvas')[0].getContext('2d');
    ctxEnemy.canvas.width = '100';
    ctxEnemy.canvas.height = '100';

    var doughnut_chart = new Chart(ctxEnemy).DoughnutAlt(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });


}


function create_mini_right_charts(selector){


    if(selector == undefined) selector = ".mini-right-chart";

        $(selector).not(":hidden").each(function(){

            if($(this).width() != 0 && $(this).height() != 0 && $(this).outerHeight() !== 0) {
                var values = [
                    {
                        value: Number($(this).parent().parent().data("percentual")),
                        color: "#5FBEAA",
                        highlight: "#45A46A",
                        label: "Acertos"
                    },
                    {
                        value: 100 - Number($(this).parent().parent().data("percentual")),
                        color: "#CCCCCC",
                        highlight: "#FF5A5E",
                        label: "Erros"
                    }


                ];

                var ctx = $(this)[0].getContext('2d');
                ctx.canvas.width = '30';
                ctx.canvas.height = '30';



                if($(this).width() != 0 && $(this).height()) {
                    var doughnut_chart = new Chart(ctx).Doughnut(values, {
                        animation: false,
                        responsive: false,
                        showTooltips: false,
                        percentageInnerCutout: 70,
                        segmentShowStroke: false,
                        scaleOverride: true,
                        maintainAspectRatio: false
                    });
                }

            }
        });

    }


function create_mini_previous_charts(){
    $(".mini-previous-chart").not(":hidden").each(function(){
        if($(this).width() != 0) {
            var values = [
                {
                    value: Number($(this).parent().parent().data("previous")),
                    color: "#ff9e5e",
                    highlight: "#45A46A",
                    label: "Acertos"
                },
                {
                    value: 100 - Number($(this).parent().parent().data("previous")),
                    color: "#CCCCCC",
                    highlight: "#FF5A5E",
                    label: "Erros"
                }


            ];


            var ctx = $(this)[0].getContext('2d');

            ctx.canvas.width = '30';
            ctx.canvas.height = '30';
            if($(this).width() != 0) {
                var doughnut_chart = new Chart(ctx).Doughnut(values, {
                    animation: false,
                    responsive: false,
                    showTooltips: false,
                    percentageInnerCutout: 70,
                    segmentShowStroke: false,
                    scaleOverride: true,
                    maintainAspectRatio: false
                });
            }
        }
    });

}


function create_mini_expected_charts(){
    $(".mini-expected-chart").not(":hidden").each(function(){
        if($(this).width() != 0 && $(this).height() != 0){
        var values = [
            {
                value:  Number($(this).parent().parent().data("expected")),
                color:"#61A9DC",
                highlight: "#45A46A",
                label: "Acertos"
            },
            {
                value: 100 -Number($(this).parent().parent().data("expected")),
                color:"#CCCCCC",
                highlight: "#FF5A5E",
                label: "Erros"
            }


        ];


        var ctx = $(this)[0].getContext('2d');


        ctx.canvas.width = '30';
        ctx.canvas.height = '30';


        var doughnut_chart = new Chart(ctx).Doughnut(values,{
            animation:false,
            responsive: false,
            showTooltips: false,
            percentageInnerCutout : 70,
            segmentShowStroke : false,
            scaleOverride : true,
            maintainAspectRatio: false
        });
        }
    });

}








/**
 * Created by ambiente on 04/02/16.
 */

var is_answered = false;
var is_next = false;
var is_over = false;
var timer;
var question_timer;

var clock = undefined;
var clock_color = 'rgb(30, 55, 109)';
var time_type;
var fontSizeQuestion = 1.6;
var isHighlighting = "";
var htmlPreHighlight = "";
var highlightId = "";
var idle_time = 0;
var idle_toggle = false;
var integral_time;
var exam_title = "";
var simulation = false;
var iframe;
var player;

$(document).ready( function(){
    $("#toggle-info").one('click', function(){
        $(".exam-explanation").slideToggle();
    });

    $(".exam-begin").on('click',function(e){
        if($(this).data('first-time') != 0) {
            e.preventDefault();
            $("#displayModal").modal('toggle');
            $("#assisted-mode").attr('href','/exam/' + $(this).data('enrollment'));
            $("#simulation-mode").attr('href','/exam/' + $(this).data('enrollment') + '/1');

        }
    });

    $(document).bind("mouseup", bj.Selector.mouseup);

    if($(".explanationModal").length > 0){

        $('.explanationModal').on('hidden.bs.modal', function () {
            console.log("teste");
            $("#explanationContentDiv").html('');
        });
    }





    $("#finish-exam").on('click',function(e){
        $("#choice-message").html( "<div id= style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div><br/>Aguarde...");

        if(!simulation){
        e.preventDefault();
            $.ajax({
                url: "/exam/end-time",
                type: "POST",
                data: {
                    'question': $('#question').data('question-exec')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                timeout: 30000,
                success: function (data) {

                    window.location = "/exam/result/" + $("#exam-panel").data('execution-id');
                },
                error: function(data){
                    timeout_handling(this);
                }
            });

        }
    });

    $("#start-exam").on('click',function(e){

       if($("#start-exam").data('order') == 1){
           if($("#exam-panel").data('display-explanation') == 1) {
               e.preventDefault();
               $("#displayModal").modal('toggle');
           }
       }


    });
    init();
} );





if($(".best-result-graph").length > 0){
    create_dashboard_right_chart();
}


function draw_charts_complete_results(){
    create_dashboard_enemies_chart();
    create_dashboard_expected_chart();
    swap_result();
    create_dashboard_result_chart();
    create_mini_expected_charts();
    create_mini_right_charts();

    create_mini_previous_charts();
    add_to_cart_event_handler();

}


if($("#study-plan-continuous").length > 0){
    create_dashboard_progress_charts();
    if($("#enemy-canvas").length > 0){
    create_dashboard_enemies_chart();
    create_dashboard_expected_chart();
    swap_result();
    create_dashboard_result_chart();
    }
}else   if($("#enemy-canvas").length > 0 && $("#my-exams").length > 0){
    create_dashboard_enemies_chart();
    create_dashboard_expected_chart();
    swap_result();
    create_dashboard_result_chart();
}


if($("#study-achievements").length > 0){
    //create_dashboard_study_charts();
}


function init_question_clock(total_time, display) {
    question_timer = total_time;
    var minutes, seconds;

    var ctx = document.getElementById("clock").getContext("2d");

    ctx.canvas.width = 40;
    ctx.canvas.height = 40;

    clock = create_clock(ctx);
    setInterval(function () {
        if (is_answered == false) {
            minutes = parseInt(question_timer / 60, 10);
            seconds = parseInt(question_timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.text(minutes + ":" + seconds);

            question_timer++;
            idle_time++;
            if( is_more_target_percentage(idle_time, $("#time").data("by-question") * 60, 10)){
                if(idle_toggle == false && $("#exam-panel").data("simulation-mode") == 0){
                    idle_toggle = true;
                    is_answered = true;
                    $("#continueModal").modal('toggle');



                }
            }



        }
    }, 1000);
}







function init_clock(total_time, display) {
    timer = total_time;
    var hours, minutes, seconds;

    var ctx = document.getElementById("clock").getContext("2d");

    ctx.canvas.width = 40;
    ctx.canvas.height = 40;

    clock = create_clock(ctx);

    setInterval(function () {
        if (is_answered == false) {
            hours = Math.floor(parseInt(timer / 3600, 10));
            minutes = parseInt((timer - (hours * 3600)) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.text(hours + ":" + minutes + ":" + seconds);


            if (is_less_target_percentage(timer, integral_time, 20)) {
                clock_color = "red";
                display.css("color", "red");
            } else if (is_less_target_percentage(timer, integral_time, 40)) {
                clock_color = "purple";
                display.css("color", "purple");
            } else {
                clock_color = "rgb(30, 55, 109)";
                display.css("color", "rgb(30, 55, 109)");
            }

            if (--timer < 0) {
                timer = 0;
                display.fadeOut(500);
                display.fadeIn(500);
                if(is_over == false && $("#time").data("by-question") != 0){
                    time_over();
                    is_over = true;
                }
            }
            if(clock != undefined){


                clock.segments[1].value = timer;
                clock.segments[0].value = integral_time - timer;
                clock.segments[0].fillColor = clock_color;
                clock.update();
            }
        }else if(is_answered == true && timer == 0){
            display.fadeOut(500);
            display.fadeIn(500);
        }
    }, 1000);
}

function is_less_target_percentage(timer, total_time, target) {
    return ((100 * timer) / total_time) < target;
}

function is_more_target_percentage(timer, total_time, target) {
    if (((100 * timer) / total_time) > target) {
        return true;
    } else {
        return false;
    }

}


function init_countdown(total_time) {
    time_type = $("#time-type");
    var display = $('#time');
    init_clock(total_time, display);
    if(time_type != 'by-question'){
        init_question_clock(parse_time_to_sec($("#crescent-time").data('crescent-time')),$("#crescent-time"));

        $('#continueModal').on('shown.bs.modal', function (e) {
            console.log('mostrando');
            $(".modal-backdrop").css({ opacity: 0.9 });
        });


        $('.panel').mousemove(function(){
            idle_time = 0;
            if(idle_toggle == true){
                idle_toggle = false;
                $("#continueModal").modal('toggle');
                is_answered = false;
            }
        });
        integral_time = $("#time").data("by-question") * 60;
    }


}


function init(){
    console.log('begin');
if($("#exam-presentation").length > 0 && $("#complete-result").length == 0){
    $(".explanation-tabs").css("display","none");
    htmlPreHighlight = $("#question").html();
    applyHighlightCapture();

    $(window).on('beforeunload',function(){
        save_current_time();
        save_question_time();
    });

    console.log('this once');
    answer_question();
    next_question();
    init_countdown(parse_time_to_sec($("#time").data('time')));
    jump_to_next();

}else if($("#complete-result").length > 0){
    //$(".detail-column").css("display","none");
    $(".detail-column").css("display","none");

    $(".button-askTheTeacher").on('click', function () {
        $.ajax({
            url: "/exam/save-ask-the-teacher",
            type: "POST",
            data: {
                'question_id': $('#askTheTeacher_question_id').val(),
                'question': $("#questionAskTheTeacher").val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                $('#askTheTeacherContentModal').modal('toggle');
                $("#questionAskTheTeacher").val('');
            },
            error: function (data) {
                timeout_handling(this);

            }
        });
    });

    $(".rating-thumb").click(function(){
        if($(this).hasClass('fa-thumbs-o-down')) {
            $(this).removeClass('fa-thumbs-o-down');
            $(this).addClass('fa-thumbs-down');
            $(this).next().removeClass('fa-thumbs-up');
            $(this).next().addClass('fa-thumbs-o-up');
        }else if($(this).hasClass('fa-thumbs-down')) {
            $(this).removeClass('fa-thumbs-down');
            $(this).addClass('fa-thumbs-o-down');
        }else if($(this).hasClass('fa-thumbs-o-up')){
            $(this).removeClass('fa-thumbs-o-up');
            $(this).addClass('fa-thumbs-up');
            console.log($(this));
            $(this).prev().removeClass('fa-thumbs-down');
            $(this).prev().addClass('fa-thumbs-o-down');
        }else{
            $(this).removeClass('fa-thumbs-up');
            $(this).addClass('fa-thumbs-o-up');
        }

        $.ajax({
            url: "/exam/save-teacher-rating",
            type: "POST",
            data: {
                'execution': $('#results-section').data("execution"),
                'rating': $(this).index(),
                'teacher': $(this).parent().parent().parent().data("teacher"),
                'rating-type': $(this).parent().data("type")
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                console.log("nota salva");
            },
            error: function (data) {

            }
        });


    });


    $(".rating-star").click(function(){

        $(this).removeClass("fa-star-o").addClass("fa-star");
        $(this).nextAll().removeClass("fa-star").addClass("fa-star-o");
        $(this).prevAll().removeClass("fa-star-o").addClass("fa-star");
        $(".fa-star").css('color',"#ffc332");

        $.ajax({
            url: "/exam/save-rating",
            type: "POST",
            data: {
                'execution': $('#results-section').data("execution"),
                'rating': $(this).index() + 1
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                $(".teachers-rating").css("display","block");
            },
            error: function (data) {
            }
        });

    });


    $("#rating-comment").focusout(save_rating_comment()).blur(save_rating_comment()).keypress(function(e) {
        if(e.which == 13) {
            save_rating_comment();
        }
    });


        $("#send-rating-comment").click(
            function() {
                if(  $(".teachers-rating").css("display") == "block"){
                save_rating_comment(function () {
                    $(".comment-rating-form").html("<h2>Obrigado pela sua avaliação!</h2>");
                });
                }
            });


    $(".btn-filter").not(".detail").click(function(){
       $(this).siblings().not(".detail").removeClass("active");
    });

    $(".all").click(function(){
        if(!$(this).hasClass("active")){

            $(".subject-line").css("display","table-row");

        }
    });


    $(".good").click(function(){
        if(!$(this).hasClass("active")){

            $(".bad-line").css("display","none");
            $(".good-line").css("display","table-row");
;
        }
    });

    $(".bad").click(function(){
        if(!$(this).hasClass("active")){
            $(".good-line").css("display","none");
            $(".bad-line").css("display","table-row");

        }
    });

    $(".detail").click(function(){
        if($(this).hasClass("active")){
            $(".detail-column").css("display","none");
            $(this).find('.toggle-active').removeClass('fa-check-square-o');
            $(this).find('.toggle-active').addClass('fa-square-o');

        }else{
            $(".detail-column").css("display","table-cell");
            $(this).find('.toggle-active').addClass('fa-check-square-o');
            $(this).find('.toggle-active').removeClass('fa-square-o');
            $(this).addClass("toggled-active");

        }
    });


    $(".all-button").click(function(){
        $(".fail-line").css("display","table-row");
        $(".check-line").css("display","table-row");
    });

    $(".check-button").click(function(){
            $(".fail-line").css("display","none");
            $(".check-line").css("display","table-row");
    });

    $(".fail-button").click(function(){

            $(".check-line").css("display","none");
            $(".fail-line").css("display","table-row");


    });



    result_flip_events();
    draw_charts_complete_results();
}else if($(".intro-result-graph").length > 0){
    create_intro_results_chart();
}else if($("#general_performance").length > 0){
    create_mini_right_charts();

    var ctxTotal = document.getElementById("right-percentage-chart").getContext("2d");

    ctxTotal.canvas.width = 160;
    ctxTotal.canvas.height = 160;

    $(".subject-line").click(function(){
       open_discipline_modal($(this).data('id'), $(this).data('name'));
    });




    create_total_chart(ctxTotal,true);
    console.log('nothing changed');
   create_performance_results_chart();
}
}


function open_discipline_modal(discipline_id,discipline_name){

    $.ajax({
        url: 'performance-geral/disciplina',
        type: "POST",
        data: {
            'discipline': discipline_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){


            $("#disciplineStatisticModal").html(data);
            $("#disciplineStatisticModalTitle").html(discipline_name);
            $("#disciplineStatisticModal").modal('toggle');
            $(document).on('shown.bs.modal','#disciplineStatisticModal', function () {

                create_mini_right_charts(".mini-subject-right-chart");
            });

        },
        error: function (data) {

        }
    });


}



function pause_clock() {

}

function save_rating_comment(after_save){
    $.ajax({
        url: '/result/rating-comment',
        type: "POST",
        data: {
            'execution': $("#results-section").data("execution"),
            'comment': $('#rating-comment').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){
            if(after_save != undefined) after_save();
        },
        error: function (data) {

        }
    });
}

function parse_time_to_sec(time) {

    if (String(time).indexOf(':') === -1) {
        return Number(time) * 60;
    } else {

        var split = time.split(":").map(Number);
        if(split.length == 3) return (split[0] * 3600) + (split[1] * 60) + split[2];
        return (split[0] * 60) + split[1];
    }
}

function time_over(){
    is_next = true;
    is_answered = true;
    $("#options input").prop('disabled', true);
    $("#button-answer").prop('disabled', true);

    $("#correct").html('<b style="color: red;">Tempo Esgotado!</b>');
    $("#explanation .panel-title").html('<strong>TEMPO ESGOTADO!</strong> - Veja o comentário.');
    $("#explanation").addClass('panel-danger');
    if ($( document ).width() > 1024) {
        $("#blade-question").animate({
            width: "50%",
        }, 700, function () {
            $("#explanation").css("display", "block");
        });
    }
    $(".button-answer").addClass("button-result");
    setNoteToQuestionContent();

    save_right_answer(0,[]);
    open_explanation_video();
        if(time_type != "by-question"){
            $.ajax({
                url: "/exam/end-time",
                type: "POST",
                data: {
                    'question': $('#question').data('question-exec')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                timeout: 30000,
                success: function (data) {
                    $("#confirmation").text("Resultado");

                    $(".button-next").text("Ir para resultados");
                    $(".button-next").css("background-color","#0077b3");

                },
                error: function(data){
                    timeout_handling(this);
                }
            });
        }


}
//O campo right define se aquela resposta é correta ou não. Se o campo right dividido pelo código da question_execution
// equivalente, o resto da divisão será 1 caso a alternativa esteja correta e 0 caso não seja
function answer_question() {

    setFontSize();

    $("#explanation-wait").css("display", "block");
    $("#explanation-teacher").css("display", "none");

    $(".button-answer").off();
    var is_clicked = false;
    var is_clicked_note = false;

    $(".button-note").on('click', function () {
        $(".button-note").text("Salvando...");
        if (is_clicked_note === false){
            is_clicked_note = true;
            $.ajax({
                url: "/exam/save-user-note",
                type: "POST",
                data: {
                    'question': $('#question_id').val(),
                    'note': $("#questionnote").val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function (data) {
                    is_clicked_note = false;
                    $(".button-note").text("Salvar");
                },
                error: function (data) {
                    is_clicked_note = false;
                }
            });
        }
    });

    $(".button-askTheTeacher").on('click', function () {
        if (is_clicked_note === false){
            is_clicked_note = true;
            $.ajax({
                url: "/exam/save-ask-the-teacher",
                type: "POST",
                data: {
                    'question_id': $('#askTheTeacher_question_id').val(),
                    'question': $("#questionAskTheTeacher").val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function (data) {
                    $('#askTheTeacherContentModal').modal('toggle');
                    is_clicked_note = false;
                    $("#questionAskTheTeacher").val('');
                },
                error: function (data) {
                    is_clicked_note = false;
                }
            });
        }
    });

    $(".button-answer").not('.button-next').on('click', function () {
        if($('input:checked').length == 0){
            $("#correct").html('<b style="color: red;">É necessário selecionar ao menos uma alternativa!</b>');
        }else if (!is_next) {
            is_next = true;
            is_answered = true;


            $("#time").addClass("time-stop");
            var right_answers = [];
            var selected_answers = [];
            var total_options = 0;
            $(".answer").each(function () {
                    total_options++;
                    console.log($(this));
                    if ($(this).data("right") % $("#question").data('question-exec') == 0) {
                        if($("#exam-panel").data("simulation-mode") == 0) {
                            $(this).css('color', 'lightgrey');
                        }
                        if ($(this).parent().parent().find('input:checked').length <= 0) {
                            right_answers.push($(this).attr('id'));
                        }

                    } else {
                        if($("#exam-panel").data("simulation-mode") == 0) {
                            $(this).css('color', 'black');
                            $(this).parent().parent().parent().css("background-color", "palegreen");
                        }
                        if ($(this).parent().parent().find('input:checked').length > 0) {
                            right_answers.push($(this).attr('id'));
                        }
                    }
                }
            );

            selected_answers = $("#options").find('input:checked').val().toString();

            console.log("right: " + right_answers);
            var value;
            if ($("#options").data("type") == "S" || $("#options").data("type") == "M" || $("#options").data("type") == "CESPE") {
                if (total_options == right_answers.length) {
                    value = 1;
                } else {
                    value = 0;
                }
            } else if ($("#options").data("type") == "MP") {
                value = total_options / right_answers.length;
            } else if ($("#options").data("type") == "ME") {
                value = right_answers - total_options + 1;
            }


            $("#explanation").removeClass('panel-danger');
            $("#explanation").removeClass('panel-success');
            $("#explanation").removeClass('panel-info');


            
            
            var top = document.getElementById('explanation').offsetTop; //Getting Y of target element
            window.scrollTo(0, top);
            if (value == 1) {
                $("#explanation .panel-title").html('<strong>PARABÉNS! VOCÊ ACERTOU</strong> - Veja o comentário.');

                $("#explanation").addClass('panel-success');
                //before('<h5 style="color: green;">Correto!</h5>');
                save_right_answer(1, selected_answers);
            } else {
                $("#explanation .panel-title").html('<strong>RESPOSTA INCORRETA</strong> - Veja o comentário.');
                $("#explanation").addClass('panel-danger');
                if($("#options").data("type") == "CESPE"){
                    save_right_answer(-1, selected_answers);
                } else {
                    save_right_answer(0, selected_answers);
                }
            }

            $("#options input").prop('disabled', true);
            $("#button-answer").prop('disabled', true);



        }
    });
    /*
     $.ajax({
     url: "/exam/get-right-answers",
     type: "POST",
     data: {'question': $('#question').data('question-id'),
     'answers': $("#options input").serialize()},
     headers: {
     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
     },
     cache: false,
     success: function(data){

     var right_answers = [];
     var total_options = 0;
     $.each(data,function(id,is_right){
     total_options++;
     if(is_right == '1'){
     $("#" + id).css('color','green');
     if($("#" + id).parent().find('input:checked').length > 0){
     right_answers.push(id);
     }

     }else{
     $("#" + id).css('color','red');
     if($("#" + id).parent().find('input:checked').length <= 0){
     right_answers.push(id);
     }
     }

     });

     var value;
     if($("#options").data("type") == "S" || $("#options").data("type") == "M"){
     if(total_options == right_answers.length){
     value = 1;
     }else{
     value = 0;
     }
     }else if($("#options").data("type") == "MP"){
     value = total_options / right_answers.length;
     }else if($("#options").data("type") == "ME"){
     value =  right_answers - total_options + 1;
     }

     if(value == 1){
     $("#options").before("Correto!");
     }else{
     $("#options").before("Incorreto.");
     }

     $("#options input").prop('disabled',true);
     open_explanation_video();
     next_question($("#question").data("question-exec"));

     }
     });
     });
     */
}

function save_right_answer(is_right, selected_answers) {

    var right_answers = selected_answers.toString();
    if(selected_answers.length == 0){
        right_answers = ""
    }

    console.log(is_right);
    console.log($("#time").text());

    $.ajax({
        url: "/exam/save-user-answer",
        type: "POST",
        data: {
            'question': $('#question').data('question-exec'),
            'answers': right_answers,
            'time': $("#time").text(),
            'crescent-time': $("#crescent-time").text(),
            'is_right': is_right
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
            if($("#question").data("question-answered") == 0){
                $("#exam-panel").data("not-answered",+$("#exam-panel").data("not-answered") - 1);
            }

            if($("#exam-panel").data("display-explanation") == 1){
                setNoteToQuestionContent();

                if ($( document ).width() > 1024) {
                    $("#blade-question").animate({
                        width: "50%",
                    }, 700, function () {
                        $("#explanation").css("display", "block");
                    });
                } else {

                }

                open_explanation_video();
            }else{
                prepare_for_next();
            }
        },
        error: function(xhr, textStatus, errorThrown ) {

                timeout_handling(this);

        }

    });
}


function open_explanation_video() {

    $("#explanation-result").html('');
    $("#explanation-result").css("display", "none");

    $("#toolsDiv").css("display", "none");

    $("#explanation-content").html("");
    $("#explanation-text").html("");
    $("#explanation-teacher").html("");

    $.ajax({
        url: "/exam/get-explanation-url",
        type: "POST",
        data: {'question': $('#question').data('question-exec')},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
         prepare_for_next();

            $("#explanation").css("display", "block");
            $("#explanation .panel-title").css('display', 'block');
            $("#explanation-wait").css("display", "none");

            if (data[0] != "" && data[0] != "expired") {

                $("#explanation-content").attr('src', data[0]);

                 iframe = $("#explanation-content")[0];
                 player = new Vimeo.Player(iframe);
                


                    }else if(data[0] == "expired"){
                $("#explanation-content").html("<p style='color: lightgrey'>Você assistiu esse vídeo o máximo de vezes permitido para essa execução</p>")
            }else {
                $("#explanation-content").html("");
            }
            console.log('Eis os dados');
            console.log(data);
            if (data[1] != "") {
                $("#explanation-text").html(data[1]);
            } else {
                $("#explanation-text").html("");
            }
            if (data[2] != "") {
                $("#explanation-teacher").css("display", "block");
                $("#explanation-teacher").html("<b>Professor(a): </b>" + data[2]);
            } else {
                $("#explanation-teacher").html("");
            }
            //alert($('#explanation').offset().top);
            //$("html,body").animate({ 'scrollTop':   $('#explanation').offset().top }, 2000);

            $(".button-note").on('click', function () {
                $(".button-note").text("Salvando...");
                $.ajax({
                    url: "/exam/save-user-note",
                    type: "POST",
                    data: {
                        'question': $('#question_id').val(),
                        'note': $("#questionnote").val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    cache: false,
                    success: function (data) {
                        $(".button-note").text("Salvar");
                    },
                    error: function (data) {
                        $(".button-note").text("Erro!");
                    }
                });
            });


        },
        error: function(data){
            timeout_handling(this);
        }
    });

}

//function onPlay(){
//
//        console.log('play');
//        $.ajax({
//            url: "/exam/increment-explanation-view",
//            type: "POST",
//            data: {'question': $('#question').data('question-exec')},
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//            },
//            cache: false,
//            success: function (data) {
//                console.log("views incremented");
//            }
//        });
//
//}

function prepare_for_next(){

    $(".button-answer").addClass('button-next');
    $(".button-next").removeClass('button-answer');
    if($("#exam-panel").data("not-answered") > 0){
        $(".button-next").text('Próxima Questão');
    }else{
        $(".button-next").text("Ir para o resultado");
    }
    next_question();

    $("#button-answer").prop('disabled', false);
}


function next_question() {

    $(".button-next").off();
    var is_clicked = false;
    $(".button-next").not('.button-answer').on('click', function () {
        if (is_next) {

            $(".button-next").addClass('button-answer');
            $(".button-answer").removeClass('button-next');
            $(".button-answer").text('Aguarde...');
            $("#divButtonJump").css("display", "none");
            $("#crescent-time").css("display", "none");

            $("#explanation-content").attr('src', '');


            $("#explanation").css("display", "none");

            var next;
            if($("#next").length > 0){
                console.log("De grupo");
                next = $("#next").data("next");
            }else{
                next = $("#question").data("question-exec");

            }

            var from_result = '';
            if($(this).hasClass("button-from-result")){
                console.log('tem classe');
                from_result = 't';
                $(this).removeClass("button-from-result");
            }

            $("#exam-presentation").html("");
            $("#question-wait").css("display", "block");

            $.ajax({
                url: "/exam/get-next-question",
                type: "POST",
                data: {'question': next,

                    'from-result': from_result},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                timeout: 30000,
                success: function (data) {
                    if (data == 'end') {
                        window.location = "/exam/result/" + $("#exam-panel").data('execution-id');
                        return;
                    } else {


                        var page_content = data;
                        if ($.isArray(data)) {
                            page_content = data[0];
                        }

                        $("#question-wait").css("display", "none");
                        $("#exam-presentation").html(page_content);

                        setFontSize();

                        $("#correct").html('');
                        $("#exam-presentation").fadeIn();

                        if ($("#results").length > 0) {

                            $("#time-space").html('');
                            $("#time").html('');


                            $("#explanation-result").html(data[1]);
                            $("#explanation-result").css("display", "block");
                            $("#explanation").css("display", "block");
                            $("#explanation-content").attr('src', '');
                            $("#explanation .panel-title").html('<strong>Resultados por subtema</strong> ');
                            $("#explanation").removeClass('panel-danger');
                            $("#explanation").removeClass('panel-success');
                            $("#explanation").addClass('panel-info');
                            $("#explanation .panel-heading").css('background', '#d8eceb');
                            $("#explanation .panel-heading").css('border-left', '8px solid #253885');
                            $("#explanation .panel-heading").css('border-right', '8px solid #253885');
                            $("#explanation .panel-heading").css('border-bottom', '0');
                            $("#explanation .panel-heading .panel-title").css('color', '#253885');
                            $("#toggle-info").css("display", "none");

                            $("#explanation-teacher").css("display", "none");

                            $("#explanation-wait").css("display", 'none');

                            if ($(document).width() > 1024) {
                                $("#blade-question").animate({
                                    width: "50%",
                                }, 700, function () {
                                    $("#explanation").css("display", "block");
                                });

                                setNoteToQuestionContent();

                            } else {

                            }


                            if ($("#next").length <= 0) {
                                $(".button-answer").css('display', 'none');
                                $(".button-jump").css('display', 'none');
                                $("#clock").css('display', 'none');

                                $("#explanation .panel-title").html('<div class="row"><div id="result-title" class="col-md-8"> <strong>Resultados por tema</strong> </div> <div id="by-flip" class="col-md-4 text-right" style="cursor: pointer;">Por Subtema &nbsp<i class="fa fa-angle-right"></i></div> </div>');
                                $("#explanation-text").html(data[2]);
                                $("#explanation-text").css("display", "block");
                                $("#explanation-result").css("display", "none");
                                $("#explanation-content").css("display", "none");
                                $("#explanation").css("display", "block");
                                var flip = "theme";

                                $("#by-flip").click(function () {
                                    if (flip == "theme") {
                                        $("#explanation-text").css("display", "none");
                                        $("#explanation-result").css("display", "block");
                                        $("#explanation-content").css("display", "block");
                                        $("#result-title").html('<strong>RESULTADOS POR SUBTEMA</strong>');
                                        $("#by-flip").html('<i class="fa fa-angle-left"></i>&nbsp Por Tema');
                                        flip = "subject";
                                    } else {
                                        $("#explanation-text").css("display", "block");
                                        $("#explanation-result").css("display", "none");
                                        $("#explanation-content").css("display", "none");
                                        $("#result-title").html('<strong>RESULTADOS POR TEMA</strong>');
                                        $("#by-flip").html(' Por Subtema&nbsp<i class="fa fa-angle-right"></i>');
                                        flip = "theme";
                                    }
                                });


                                $(".detail-column").css("display", "none");



                                $(".all").click(function () {
                                    $(".btn-filter").not('.detail').removeClass("active");
                                    $(".subject-line").css("display","table-row");


                                });

                                $(".good").click(function () {
                                    $(".btn-filter").removeClass("active");
                                        $(".subject-line").css("display","none");
                                        $(".good-line").css("display", "table-row");

                                });

                                $(".bad").click(function () {
                                    $(".btn-filter").not('.detail').removeClass("active");
                                    $(".subject-line").css("display","none");
                                        $(".bad-line").css("display", "table-row");
                                });

                                $(".detail").click(function () {
                                    if ($(this).hasClass("active")) {
                                        $(".detail-column").css("display", "none");
                                    } else {
                                        $(".detail-column").css("display", "table-cell");

                                    }
                                });

                                $(".check-button").click(function () {
                                    if ($(this).hasClass("active")) {
                                        $(".check-line").css("display", "none");
                                    } else {
                                        $(".check-line").css("display", "table-row");

                                    }
                                });

                                $(".fail-button").click(function () {
                                    if ($(this).hasClass("active")) {
                                        $(".fail-line").css("display", "none");
                                    } else {
                                        $(".fail-line").css("display", "table-row");

                                    }
                                });


                                draw_charts();


                            } else {
                                console.log('Para adicionar classe');
                                $(".button-answer").addClass('button-next');
                                $(".button-next").addClass("button-from-result");
                                $(".button-next").removeClass('button-answer');
                                $(".button-next").text('Próxima Questão');
                            }
                        } else {
                            $("#blade-question").css("width", "100%");
                            $(".explanation-tabs").css("display","none");

                            $(".button-answer").text('Responder');
                            $("#divButtonJump").css("display", "block");
                            $("#crescent-time").css("display", "block");


                            is_next = false;
                            is_answered = false;
                            $("#time").removeClass("time-stop");
                            answer_question();

                            htmlPreHighlight = $("#question").html();
                            if (isHighlighting == 'B') {
                                $("#highlightBtBlue").html("<i class='fa fa-close'>&nbsp;</i>");
                            } else if (isHighlighting == 'R') {
                                $("#highlightBtRed").html("<i class='fa fa-close'>&nbsp;</i>");
                            } else if (isHighlighting == 'Y') {
                                $("#highlightBtYellow").html("<i class='fa fa-close'>&nbsp;</i>");
                            }

                            applyHighlightCapture();

                            if ($("#time").data("by-question") != "0") {
                                if (time_type == "by-question") {
                                    timer = parse_time_to_sec($("#time").data("by-question"));
                                } else {
                                    question_timer = 0;
                                }
                                is_over = false;
                            }
                        }

                    }
                },
                error: function(xhr, textStatus, errorThrown ) {


                        timeout_handling(this);

                }
            });
        }

    });


}

function jump_to_next(){
    $("#jumpback").click(function(){
      //  if($(".button-answer").length > 0) {
            is_answered = true;
            save_current_time();
            return_question();
     //   }
    });
    $("#jump").click(function(){
      //  if($(".button-answer").length > 0) {
            is_answered = true;
            save_current_time();
            advance_question();
     //   }
    });
    $("#jumpto").click(function(){
      //  if($(".button-answer").length > 0) {
            showQuestionsNotAnswered( $("#jumpto").attr('data'));
     //   }
    });
    
}

function jump_to_question(question_exec_id){
    is_answered = true;
    $("#questionContentModal").modal('hide');
    $('.modal-backdrop').remove();

    save_current_time();
    $(".button-next").addClass('button-answer');
    $(".button-answer").removeClass('button-next');
    $(".button-answer").text('Aguarde...');

    $("#explanation-content").attr('src', '');

    $("#explanation").css("display", "none");



    var next;
    if($("#next").length > 0){
        console.log("De grupo");
        next = $("#next").data("next");
    }else{
        console.log("De questão");
        next = $("#question").data("question-exec");
    }

    var from_result = '';
    if($(this).hasClass("button-from-result")){
        from_result = 't';
        $(this).removeClass("button-from-result");
    }

    $("#exam-presentation").html("");
    $("#question-wait").css("display", "block");

    $.ajax({
        url: "/exam/get-question",
        type: "POST",
        data: {'question_exec_id': question_exec_id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
            $("#blade-question").css("width", "100%");
            $(".explanation-tabs").css("display","none");


            var page_content = data;
            if($.isArray(data)){
                page_content = data[0];
            }

            $("#question-wait").css("display", "none");
            var resulting_html = $("#exam-presentation").html(page_content);

            setFontSize();

            $("#correct").html('');
            $("#exam-presentation").fadeIn();

            $(".button-answer").text('Responder');

            htmlPreHighlight = $("#question").html();
            if (isHighlighting == true){
                $("#highlightBt").css("color","#ffc332");
            }

            is_next = false;
            is_answered = false;
            $("#time").removeClass("time-stop");
            answer_question();
            if($("#time").data("by-question") != "0"){
                if(time_type == "by-question"){
                    timer = parse_time_to_sec($("#time").data("by-question"));
                }else{
                    question_timer = 0;
                }
                is_over = false;
            }

            if(resulting_html != '' &&  $("#question").data('question-answered') == 1 && $("#exam-panel").data("simulation-mode") == 0 ) {
                $(".button-answer").click();
            }

            $("#blade-question").css("width", "100%");
            $(".explanation-tabs").css("display","none");


        },
        error: function(data){
            timeout_handling(this);
        }
    });
}

function return_question(question_exec_id){
    is_answered = true;
    $("#questionContentModal").modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();

    save_current_time();
    $(".button-next").addClass('button-answer');
    $(".button-answer").removeClass('button-next');
    $(".button-answer").text('Aguarde...');

    $("#explanation-content").attr('src', '');

    $("#explanation").css("display", "none");

    var next;
    if($("#next").length > 0){
        console.log("De grupo");
        next = $("#next").data("next");
    }else{
        console.log("De questão");
        next = $("#question").data("question-exec");
    }

    var from_result = '';
    if($(this).hasClass("button-from-result")){
        from_result = 't';
        $(this).removeClass("button-from-result");
    }

    $("#exam-presentation").html("");
    $("#question-wait").css("display", "block");

    $.ajax({
        url: "/exam/get-prev-question",
        type: "POST",
        data: {'question': next},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
            var page_content = data;
            if($.isArray(data)){
                page_content = data[0];
            }

            $("#question-wait").css("display", "none");
            var resulting_html = $("#exam-presentation").html(page_content);

            setFontSize();

            $("#correct").html('');
            $("#exam-presentation").fadeIn();

            $("#blade-question").css("width", "100%");

            $(".button-answer").text('Responder');

            htmlPreHighlight = $("#question").html();
            if (isHighlighting == true){
                $("#highlightBt").css("color","#ffc332");
            }

            is_next = false;
            is_answered = false;
            $("#time").removeClass("time-stop");
            answer_question();
            if($("#time").data("by-question") != "0"){
                if(time_type == "by-question"){
                    timer = parse_time_to_sec($("#time").data("by-question"));
                }else{
                    question_timer = 0;
                }
                is_over = false;
            }

            if(resulting_html != '' &&  $("#question").data('question-answered') == 1 && $("#exam-panel").data("simulation-mode") == 0 ) {
                $(".button-answer").click();
            }
        },
        error: function(data){
            timeout_handling(this);
        }
    });
}


function save_current_time(){
    $.ajax({
        url: "/exam/save-current-time",
        type: "POST",
        async : false,
        data: {
            'question': $('#question').data('question-exec'),
            'current-time': $("#time").text(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },

        cache: false,
        success: function (data) {
        }
    });
}

function save_question_time(){
    $.ajax({
        url: "/exam/save-question-time",
        type: "POST",
        async : false,
        data: {
            'question': $('#question').data('question-exec'),
            'current-time': $("#crescent-time").text(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },

        cache: false,
        success: function (data) {
        }
    });
}





function advance_question(){
    $(".button-next").addClass('button-answer');
    $(".button-answer").removeClass('button-next');
    $(".button-answer").text('Aguarde...');
    $("#divButtonJump").css("display", "none");
    $("#crescent-time").css("display", "none");


    $("#explanation-content").attr('src', '');


    $("#explanation").css("display", "none");

    var next;
    if($("#next").length > 0){
        console.log("De grupo");
        next = $("#next").data("next");
    }else{
        console.log("De questão");
        next = $("#question").data("question-exec");
    }

    var from_result = '';
    if($(this).hasClass("button-from-result")){
        console.log('tem classe');
        from_result = 't';
        $(this).removeClass("button-from-result");
    }

    $("#exam-presentation").html("");
    $("#question-wait").css("display", "block");



    $.ajax({
        url: "/exam/get-next-question-with-answered",
        type: "POST",
        data: {'question': next,

            'from-result': from_result},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
            var page_content = data;
            if($.isArray(data)){
                page_content = data[0];
            }

            $("#question-wait").css("display", "none");
            $("#exam-presentation").html(page_content);

            setFontSize();

            $("#correct").html('');
            $("#exam-presentation").fadeIn();

            if ($("#results").length > 0) {

                $("#time-space").html('');
                $("#time").html('');


                $("#explanation-result").html(data[1]);
                $("#explanation-result").css("display", "block");
                $("#explanation").css("display", "block");
                $("#explanation-content").attr('src', '');
                $("#explanation .panel-title").html('<strong>Resultados por subtema</strong> ');
                $("#explanation").removeClass('panel-danger');
                $("#explanation").removeClass('panel-success');
                $("#explanation").addClass('panel-info');
                $("#explanation .panel-heading").css('background','#d8eceb');
                $("#explanation .panel-heading").css('border-left','8px solid #253885');
                $("#explanation .panel-heading").css('border-right','8px solid #253885');
                $("#explanation .panel-heading").css('border-bottom','0');
                $("#explanation .panel-heading .panel-title").css('color','#253885');
                $("#toggle-info").css("display","none");

                $("#explanation-teacher").css("display", "none");


                if($("#next").length <= 0) {
                    $(".button-answer").css('display', 'none');
                    $(".button-jump").css('display', 'none');
                    $("#crescent-time").css("display", "block");
                    $("#clock").css('display','none');

                    $("#explanation .panel-title").html('<div class="row"><div id="result-title" class="col-md-8"> <strong>Resultados por tema</strong> </div> <div id="by-flip" class="col-md-4 text-right" style="cursor: pointer;">Por Subtema &nbsp<i class="fa fa-angle-right"></i></div> </div>');
                    $("#explanation-text").html(data[2]);
                    $("#explanation-text").css("display", "block");
                    $("#explanation-result").css("display", "none");
                    $("#explanation-content").css("display", "none");
                    $("#explanation").css("display", "block");
                    var flip =  "theme";

                    $("#by-flip").click(function(){
                        if(flip == "theme"){
                            $("#explanation-text").css("display", "none");
                            $("#explanation-result").css("display", "block");
                            $("#explanation-content").css("display", "block");
                            $("#result-title").html('<strong>RESULTADOS POR SUBTEMA</strong>');
                            $("#by-flip").html('<i class="fa fa-angle-left"></i>&nbsp Por Tema' );
                            flip = "subject";
                        }else{
                            $("#explanation-text").css("display", "block");
                            $("#explanation-result").css("display", "none");
                            $("#explanation-content").css("display", "none");
                            $("#result-title").html('<strong>RESULTADOS POR TEMA</strong>');
                            $("#by-flip").html(' Por Subtema&nbsp<i class="fa fa-angle-right"></i>' )     ;
                            flip = "theme";
                        }
                    });




                    draw_charts();


                }else{
                    console.log('Para adicionar classe');
                    $(".button-answer").addClass('button-next');
                    $(".button-next").addClass("button-from-result");
                    $(".button-next").removeClass('button-answer');
                    $(".button-next").text('Próxima Questão');
                }
            } else {
                $("#blade-question").css("width", "100%");

                $(".button-answer").text('Responder');
                $("#divButtonJump").css("display", "block");
                $("#crescent-time").css("display", "block");

                htmlPreHighlight = $("#question").html();
                if (isHighlighting == true){
                    $("#highlightBt").css("color","#ffc332");
                }

                is_next = false;
                is_answered = false;
                $("#time").removeClass("time-stop");
                answer_question();
                if($("#time").data("by-question") != "0"){
                    if(time_type == "by-question"){
                        timer = parse_time_to_sec($("#time").data("by-question"));
                    }else{
                        question_timer = 0;
                    }
                    is_over = false;
                }
            }

        },
        error: function(data){
            timeout_handling(this);
        }
    });

}



function result_flip_events(){

    $("#by-subtheme").click(function(){
            $("#explanation-text").css("display", "none");
            $("#explanation-result").css("display", "block");
            $("#explanation-content").css("display", "block");
            $("#explanation-summary").css("display","none");


        var title = "POR SUBTEMA";
        if($("#result-title").data('level') == 1){
            title = "POR TEMA";


        }


            $("#result-title").html('<strong>RESULTADOS '+ title + '</strong>');
        if($("#result-title").data('level') == 1){
            create_mini_right_charts();

            create_mini_previous_charts();
            create_mini_expected_charts();
        }
        //    $("#by-flip").html('<i class="fa fa-object-group"></i>&nbsp Por Tema' );
        });

        $("#by-theme").click(function(){
            $("#explanation-text").css("display", "block");
            $("#explanation-result").css("display", "none");
            $("#explanation-content").css("display", "none");
            $("#explanation-summary").css("display","none");

            var title = "POR TEMA";
            if($("#result-title").data('level') == 1){
                title = "POR DISCIPLINA";
            }

            $("#result-title").html('<strong>RESULTADOS '+ title +'</strong>');
          //  $("#by-flip").html(' Por Subtema&nbsp<i class="fa fa-object-ungroup"></i>' )     ;
        });




    $(".choice-subject").click(function(e){

        console.log($(this).parent().parent());
        $("#theme-menu").text($(this).text());
        $(".p-bj-course").css("opacity","1.0");
        $(".p-bj-course").not(".subject-" + $(this).data("subject-id")).not('.toggled').css("opacity",'0.3');
        //$(".p-bj-course").not(".subject-" + $(this).data("subject-id")).not('.toggled').addClass('toggled');
    });

    $(".modal-explanation").click(function(){
        $("#explanationContentWait").css("display", "block");
        $("#explanationContentDiv").css("display", "none");
        $("#explanationContentDiv").html("");
        $("#explanationModal").modal('toggle');
        $.ajax({
            url: "/exam/question-explanation",
            type: "POST",
            data: {'question': $(this).data('question'), 'execution': $('#results-section').data("execution"),},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {

                $("#explanationContentDiv").html(data);
                $(".explanation-tabs").css("display","block");
                $("#explanationContentDiv").css("display", "block");
                $("#explanationContentWait").css("display", "none");


                $(".tab-button").click(function(){
                    if($(this).hasClass("tab-question")){
                        $("#explanation-question").css("display", "block");
                        $("#exam-note-info").css("display","none");

                    }else{
                        $("#exam-note-info").css("display","block");
                        $("#exam-note-info").html($(this).data("note") + " <br/>");

                        $("#explanation-question").css("display", "none");

                    }
                    $(".tab-button.active").removeClass("active");
                    $(this).addClass('active');

                });


                $(".button-note").on('click', function () {
                    $(".button-note").text("Salvando...");
                    $.ajax({
                        url: "/exam/save-user-note",
                        type: "POST",
                        timeout: 30000,
                        data: {
                            'question': $('#question_id').val(),
                            'note': $("#questionnote").val()
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        cache: false,
                        success: function (data) {
                            $(".button-note").text("Salvar");
                        },
                        error: function (data) {
                            timeout_handling(this);

                        }
                    });
                });

            }
        });
    });






    $(".summary-line").click(function(){
        if($(this).next().first().hasClass("out")) {
            $(this).next().first().addClass("in");
            $(this).next().first().removeClass("out");
        } else {
            $(this).next().first().addClass("out");
            $(this).next().first().removeClass("in");
        }
    });

    $("#summary").click(function(){
        $("#explanation-text").css("display", "none");
        $("#explanation-result").css("display", "none");
        $("#explanation-content").css("display", "none");
        $("#explanation-summary").css("display","block");
        $("#result-title").html("<strong>GABARITO ANALÍTICO</strong>");
    });
}


function draw_charts(){
    var ctx = document.getElementById("performance-rights-graph").getContext("2d");

    ctx.canvas.width = 150;
    ctx.canvas.height = 150;

    create_right_chart(ctx);

    var ctxTime = document.getElementById("performance-time-graph").getContext("2d");

    ctxTime.canvas.width = 150;
    ctxTime.canvas.height = 150;

    create_time_chart(ctxTime);



    var ctxAvgTime = document.getElementById("performance-average-time-graph").getContext("2d");

    ctxAvgTime.canvas.width = 150;
    ctxAvgTime.canvas.height = 150;

    create_average_time_chart(ctxAvgTime);


    var ctxTotal = document.getElementById("performance-total-graph").getContext("2d");

    ctxTotal.canvas.width = 150;
    ctxTotal.canvas.height = 150;

    create_total_chart(ctxTotal);



}

function setFontSize(){
    $("#question").css("fontSize", fontSizeQuestion + "rem");
    $("#options").css("fontSize", fontSizeQuestion + "rem");

    $(".increase_font").click(function(e) {
        e.preventDefault();
        if (fontSizeQuestion < 2.4) {
            fontSizeQuestion = fontSizeQuestion + 0.2;
        }

        $("#question").css("fontSize", fontSizeQuestion + "rem");
        $("#options").css("fontSize", fontSizeQuestion + "rem");
    });

    $(".reduce_font").click(function(e) {
        e.preventDefault();
        if (fontSizeQuestion > 1.4) {
            fontSizeQuestion = fontSizeQuestion - 0.2;
        }

        $("#question").css("fontSize", fontSizeQuestion + "rem");
        $("#options").css("fontSize", fontSizeQuestion + "rem");

    });


}

function menuIntro(divToShow){
    $("#info_exam").css('display','none');
    $("#mandatory_read_exam").css('display','none');
    $("#360_exam").css('display','none');
    $("#extra_reading_exam").css('display','none');

    $("#" + divToShow).css('display','block');
}



/*

 highlight v5

 Highlights arbitrary terms.

 <http://johannburkard.de/blog/programming/javascript/highlight-javascript-text-higlighting-jquery-plugin.html>

 MIT license.

 Johann Burkard
 <http://johannburkard.de>
 <mailto:jb@eaio.com>

 */

jQuery.fn.highlight = function(pat) {
    function innerHighlight(node, pat) {
        var skip = 0;
        if (node.nodeType == 3) {
            var pos = node.data.toUpperCase().indexOf(pat);
            pos -= (node.data.substr(0, pos).toUpperCase().length - node.data.substr(0, pos).length);
            if (pos >= 0) {
                var spannode = document.createElement('span');
                spannode.className = "fhighlight_" + isHighlighting;
                var middlebit = node.splitText(pos);
                var endbit = middlebit.splitText(pat.length);
                var middleclone = middlebit.cloneNode(true);
                spannode.appendChild(middleclone);
                middlebit.parentNode.replaceChild(spannode, middlebit);
                skip = 1;
            }
        }
        else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
            for (var i = 0; i < node.childNodes.length; ++i) {
                i += innerHighlight(node.childNodes[i], pat);
            }
        }
        return skip;
    }
    return this.length && pat && pat.length ? this.each(function() {
        innerHighlight(this, pat.toUpperCase());
    }) : this;
};

//jQuery.fn.removeHighlight = function() {
//    return this.find("span.fhighlight").each(function() {
//        this.parentNode.firstChild.nodeName;
//        alert(this.parentNode.firstChild.nodeName);
//        with (this.parentNode) {
//            replaceChild(this.firstChild, this);
//            normalize();
//        }
//    }).end();
//};

jQuery.fn.removeHighlight = function() {

}


function activeHighlightRed(){
    if (isHighlighting == 'R') {
        $("#highlightBtRed").html("&nbsp;");
        isHighlighting = '';
    } else {
        isHighlighting = 'R';
        $("#highlightBtYellow").html("&nbsp;");
        $("#highlightBtBlue").html("&nbsp;");
        $("#highlightBtRed").html("<i class='fa fa-close'> </i>");
    }
}

function activeHighlightBlue(){
    if (isHighlighting == 'B') {
        $("#highlightBtBlue").html("&nbsp;");
        isHighlighting = '';
    } else {
        isHighlighting = 'B';
        $("#highlightBtYellow").html("&nbsp;");
        $("#highlightBtBlue").html("<i class='fa fa-close'> </i>");
        $("#highlightBtRed").html("&nbsp;");
    }
}

function activeHighlightYellow(){
    if (isHighlighting == 'B') {
        $("#highlightBtYellow").html("&nbsp;");
        isHighlighting = '';
    } else {
        isHighlighting = 'Y';
        $("#highlightBtYellow").html("<i class='fa fa-close'> </i>");
        $("#highlightBtBlue").html("&nbsp;");
        $("#highlightBtRed").html("&nbsp;");
    }
}


function cleanHighlight() {
    isHighlighting = '';
    $("#highlightBtYellow").html("&nbsp;");
    $("#highlightBtBlue").html("&nbsp;");
    $("#highlightBtRed").html("&nbsp;");
    var sel = "";
    if ($("#options").find('input:checked').length > 0) {
        var sel = $("#options").find('input:checked').val().toString();
    }
    $("#question").html(htmlPreHighlight);
    if (sel != ""){
        $("#checkbox" + sel).attr("checked", true);
    }
    applyHighlightCapture();
}

if(!window.bj){
    bj = {};
}
bj.Selector = {};
bj.Selector.getSelected = function(){
    var t = '';
    if(window.getSelection){
        t = window.getSelection();
    }else if(document.getSelection){
        t = document.getSelection();
    }else if(document.selection){
        t = document.selection.createRange().text;
    }
    return t;
}

bj.Selector.mouseup = function(){
    var st = bj.Selector.getSelected();
    if (((st + '').trim()!='') && (isHighlighting != '')){
        $('#' + highlightId).highlight(st + '');
    }
}



function showQuestionNote( question_id, note, noteTitle){

    $("#questionContentLabel").html( noteTitle );

    $("#questionContentDiv").html('');
    $("#questionContentModal").modal('toggle');
    $("#questionContentWait").css("display", "block");

    $("#questionContentDiv").html();
    $.ajax({
        url: "/exam/question-note",
        type: "POST",
        data: {
            question: question_id,
            note: note,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (html) {
            $("#questionContentWait").css("display", "none");

            if (html.trim() === '') html = 'Não existe informação para este item.';

            $("#questionContentDiv").html(html);
        }
    });
}

function setNoteToQuestionContent(){

    $(".question-attributes").css("display","none");
    $(".explanation-tabs").css("display","flex");





    $(".tab-button").click(function(){
        if($(this).hasClass("tab-question")){
            $("#panel-question").children().css("display", "block");
            $("#exam-table-info").css("display","none");
        }else{
            $("#exam-table-info").html('<table class="table mb-none"><tbody><tr><td>' + $(this).data("note") + '</td></tr></tbody></table>');
            $("#panel-question").children().css("display", "none");
            $("#exam-table-info").css("display","block");
        }
        $(".tab-button.active").removeClass("active");
        $(this).addClass('active');
        // if (html.trim() === '') html = 'Não existe informação para este item.';


    });


}


function showQuestionsNotAnswered( execution_id ){

    $("#questionContentLabel").html( '<strong>Índice de Questões</strong>' );

    $("#questionContentDiv").html('');
    $("#questionContentModal").modal('toggle');
    $("#questionContentWait").css("display", "block");

    $("#questionContentDiv").html();
    $.ajax({
        url: "/exam/questions-not-answered",
        type: "POST",
        data: {
            execution: execution_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (html) {
            $("#questionContentWait").css("display", "none");

            if (html.trim() === '') html = 'Todas as questões já foram respondidas.';

            $("#questionContentDiv").html(html);


        }
    });
}


function add_to_cart_event_handler(){
    console.log("event added");
    $(".add-to-cart").click(function(){
    $.ajax({
        url: "/exam/add-item",
        type: "POST",
        data: {
            item: $(this).data("item"),
            type: $(this).data("type")
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (data) {
            $("#cart-count").text(data["count"] + " itens");
            $("#cart-price").css("display","inline-flex");
            console.log(data);
            $("#cart-price").text("R$ " + data["total"]);
            $("#cart-discount").css("display","inline-flex");
            console.log(data);
            $("#cart-discount").text("Desconto de R$ " + data["discount"]);
        }
    });
    });
}



function showAskTheTeacher( question_id, teacherName) {
    $("#askTheTeacherContentLabel").html("Tira dúvida");
    if (teacherName != '') $("#askTheTeacherContentLabel").html("Tira dúvida com o professor <strong>" + teacherName + "</strong>");
    $("#askTheTeacher_question_id").val(question_id);
    $("#askTheTeacherContentModal").modal('toggle');
}

function showExamNote( exam_id, note, noteTitle){

    $("#examContentLabel").html( noteTitle );

    $("#examContentDiv").html('');
    $("#examContentDiv").html('');
    $("#examContentModal").modal('toggle');
    $("#examContentWait").css("display", "block");

    $("#examContentDiv").html();
    $.ajax({
        url: "/exam/exam-note",
        type: "POST",
        data: {
            exam: exam_id,
            note: note,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (html) {
            $("#examContentWait").css("display", "none");

            if (html.trim() === '') html = 'Não existe informação para este item.';

            $("#examContentDiv").html(html);
        }
    });
}

function applyHighlightCapture(){
    $(".question_div").mousedown(function() {
        highlightId = $(this).attr("id");
    });
}


function clickQuestionButton(){
    $(".button-next").css("display", "block");
    $(".button-answer").css("display", "block");
    $("#divButtonJump").css("display", "block");
    $("#btnTabQuestion").html("<strong><i class='fa fa-pencil-square-o'></i> Questão</strong>");
}

function clickNoteButton(){
    $(".button-next").css("display", "none");
    $(".button-answer").css("display", "none");
    $("#divButtonJump").css("display", "none");
    $("#btnTabQuestion").html("<strong><i class='fa fa-pencil-square-o'></i> Voltar para<br> a questão</strong>");
}


/**
 * Created by ambiente on 07/04/16.
 */

/*
error : function(xhr, textStatus, errorThrown ) {
    if (textStatus == 'timeout') {



    }

  */

var unsent_requests = [];


function timeout_handling(request){
    unsent_requests.push(request);

    if(!$('#connectionTimeoutModal').is(':visible'))
        $("#connectionTimeoutModal").modal("toggle");
}

function request_retry(){

    var is_toggled;
    if($('#connectionTimeoutModal').is(':visible')){
       is_toggled = $("#connectionTimeoutModal").modal("toggle");
    }


    if(is_toggled != undefined){
    $.each(unsent_requests,function(index, value){
        $.ajax(value);
    });
    }


}
/*!
* jquery.counterup.js 1.0
*
* Copyright 2013, Benjamin Intal http://gambit.ph @bfintal
* Released under the GPL v2 License
*
* Date: Nov 26, 2013
*/
!function(t){"use strict";t.fn.counterUp=function(e){var n=t.extend({time:400,delay:10},e);return this.each(function(){var e=t(this),u=n,a=function(){var t=u.time/u.delay,n=e.attr("data-value"),a=[n],r=/[0-9]+,[0-9]+/.test(n);n=n.replace(/,/g,"");for(var o=(/^[0-9]+$/.test(n),/^[0-9]+\.[0-9]+$/.test(n)),c=o?(n.split(".")[1]||[]).length:0,d=t;d>=1;d--){var i=parseInt(n/t*d);if(o&&(i=parseFloat(n/t*d).toFixed(c)),r)for(;/(\d+)(\d{3})/.test(i.toString());)i=i.toString().replace(/(\d+)(\d{3})/,"$1,$2");a.unshift(i)}e.data("counterup-nums",a),e.text("0");var s=function(){e.text(e.data("counterup-nums").shift()),e.data("counterup-nums").length?setTimeout(e.data("counterup-func"),u.delay):(delete e.data("counterup-nums"),e.data("counterup-nums",null),e.data("counterup-func",null))};e.data("counterup-func",s),setTimeout(e.data("counterup-func"),u.delay)};e.waypoint(a,{offset:"100%",triggerOnce:!0})})}}(jQuery);
// Generated by CoffeeScript 1.6.2
/*
jQuery Waypoints - v2.0.3
Copyright (c) 2011-2013 Caleb Troughton
Dual licensed under the MIT license and GPL license.
https://github.com/imakewebthings/jquery-waypoints/blob/master/licenses.txt
*/
(function(){var t=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++){if(e in this&&this[e]===t)return e}return-1},e=[].slice;(function(t,e){if(typeof define==="function"&&define.amd){return define("waypoints",["jquery"],function(n){return e(n,t)})}else{return e(t.jQuery,t)}})(this,function(n,r){var i,o,l,s,f,u,a,c,h,d,p,y,v,w,g,m;i=n(r);c=t.call(r,"ontouchstart")>=0;s={horizontal:{},vertical:{}};f=1;a={};u="waypoints-context-id";p="resize.waypoints";y="scroll.waypoints";v=1;w="waypoints-waypoint-ids";g="waypoint";m="waypoints";o=function(){function t(t){var e=this;this.$element=t;this.element=t[0];this.didResize=false;this.didScroll=false;this.id="context"+f++;this.oldScroll={x:t.scrollLeft(),y:t.scrollTop()};this.waypoints={horizontal:{},vertical:{}};t.data(u,this.id);a[this.id]=this;t.bind(y,function(){var t;if(!(e.didScroll||c)){e.didScroll=true;t=function(){e.doScroll();return e.didScroll=false};return r.setTimeout(t,n[m].settings.scrollThrottle)}});t.bind(p,function(){var t;if(!e.didResize){e.didResize=true;t=function(){n[m]("refresh");return e.didResize=false};return r.setTimeout(t,n[m].settings.resizeThrottle)}})}t.prototype.doScroll=function(){var t,e=this;t={horizontal:{newScroll:this.$element.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.$element.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};if(c&&(!t.vertical.oldScroll||!t.vertical.newScroll)){n[m]("refresh")}n.each(t,function(t,r){var i,o,l;l=[];o=r.newScroll>r.oldScroll;i=o?r.forward:r.backward;n.each(e.waypoints[t],function(t,e){var n,i;if(r.oldScroll<(n=e.offset)&&n<=r.newScroll){return l.push(e)}else if(r.newScroll<(i=e.offset)&&i<=r.oldScroll){return l.push(e)}});l.sort(function(t,e){return t.offset-e.offset});if(!o){l.reverse()}return n.each(l,function(t,e){if(e.options.continuous||t===l.length-1){return e.trigger([i])}})});return this.oldScroll={x:t.horizontal.newScroll,y:t.vertical.newScroll}};t.prototype.refresh=function(){var t,e,r,i=this;r=n.isWindow(this.element);e=this.$element.offset();this.doScroll();t={horizontal:{contextOffset:r?0:e.left,contextScroll:r?0:this.oldScroll.x,contextDimension:this.$element.width(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:r?0:e.top,contextScroll:r?0:this.oldScroll.y,contextDimension:r?n[m]("viewportHeight"):this.$element.height(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};return n.each(t,function(t,e){return n.each(i.waypoints[t],function(t,r){var i,o,l,s,f;i=r.options.offset;l=r.offset;o=n.isWindow(r.element)?0:r.$element.offset()[e.offsetProp];if(n.isFunction(i)){i=i.apply(r.element)}else if(typeof i==="string"){i=parseFloat(i);if(r.options.offset.indexOf("%")>-1){i=Math.ceil(e.contextDimension*i/100)}}r.offset=o-e.contextOffset+e.contextScroll-i;if(r.options.onlyOnScroll&&l!=null||!r.enabled){return}if(l!==null&&l<(s=e.oldScroll)&&s<=r.offset){return r.trigger([e.backward])}else if(l!==null&&l>(f=e.oldScroll)&&f>=r.offset){return r.trigger([e.forward])}else if(l===null&&e.oldScroll>=r.offset){return r.trigger([e.forward])}})})};t.prototype.checkEmpty=function(){if(n.isEmptyObject(this.waypoints.horizontal)&&n.isEmptyObject(this.waypoints.vertical)){this.$element.unbind([p,y].join(" "));return delete a[this.id]}};return t}();l=function(){function t(t,e,r){var i,o;r=n.extend({},n.fn[g].defaults,r);if(r.offset==="bottom-in-view"){r.offset=function(){var t;t=n[m]("viewportHeight");if(!n.isWindow(e.element)){t=e.$element.height()}return t-n(this).outerHeight()}}this.$element=t;this.element=t[0];this.axis=r.horizontal?"horizontal":"vertical";this.callback=r.handler;this.context=e;this.enabled=r.enabled;this.id="waypoints"+v++;this.offset=null;this.options=r;e.waypoints[this.axis][this.id]=this;s[this.axis][this.id]=this;i=(o=t.data(w))!=null?o:[];i.push(this.id);t.data(w,i)}t.prototype.trigger=function(t){if(!this.enabled){return}if(this.callback!=null){this.callback.apply(this.element,t)}if(this.options.triggerOnce){return this.destroy()}};t.prototype.disable=function(){return this.enabled=false};t.prototype.enable=function(){this.context.refresh();return this.enabled=true};t.prototype.destroy=function(){delete s[this.axis][this.id];delete this.context.waypoints[this.axis][this.id];return this.context.checkEmpty()};t.getWaypointsByElement=function(t){var e,r;r=n(t).data(w);if(!r){return[]}e=n.extend({},s.horizontal,s.vertical);return n.map(r,function(t){return e[t]})};return t}();d={init:function(t,e){var r;if(e==null){e={}}if((r=e.handler)==null){e.handler=t}this.each(function(){var t,r,i,s;t=n(this);i=(s=e.context)!=null?s:n.fn[g].defaults.context;if(!n.isWindow(i)){i=t.closest(i)}i=n(i);r=a[i.data(u)];if(!r){r=new o(i)}return new l(t,r,e)});n[m]("refresh");return this},disable:function(){return d._invoke(this,"disable")},enable:function(){return d._invoke(this,"enable")},destroy:function(){return d._invoke(this,"destroy")},prev:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e>0){return t.push(n[e-1])}})},next:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e<n.length-1){return t.push(n[e+1])}})},_traverse:function(t,e,i){var o,l;if(t==null){t="vertical"}if(e==null){e=r}l=h.aggregate(e);o=[];this.each(function(){var e;e=n.inArray(this,l[t]);return i(o,e,l[t])});return this.pushStack(o)},_invoke:function(t,e){t.each(function(){var t;t=l.getWaypointsByElement(this);return n.each(t,function(t,n){n[e]();return true})});return this}};n.fn[g]=function(){var t,r;r=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(d[r]){return d[r].apply(this,t)}else if(n.isFunction(r)){return d.init.apply(this,arguments)}else if(n.isPlainObject(r)){return d.init.apply(this,[null,r])}else if(!r){return n.error("jQuery Waypoints needs a callback function or handler option.")}else{return n.error("The "+r+" method does not exist in jQuery Waypoints.")}};n.fn[g].defaults={context:r,continuous:true,enabled:true,horizontal:false,offset:0,triggerOnce:false};h={refresh:function(){return n.each(a,function(t,e){return e.refresh()})},viewportHeight:function(){var t;return(t=r.innerHeight)!=null?t:i.height()},aggregate:function(t){var e,r,i;e=s;if(t){e=(i=a[n(t).data(u)])!=null?i.waypoints:void 0}if(!e){return[]}r={horizontal:[],vertical:[]};n.each(r,function(t,i){n.each(e[t],function(t,e){return i.push(e)});i.sort(function(t,e){return t.offset-e.offset});r[t]=n.map(i,function(t){return t.element});return r[t]=n.unique(r[t])});return r},above:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset<=t.oldScroll.y})},below:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset>t.oldScroll.y})},left:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset<=t.oldScroll.x})},right:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset>t.oldScroll.x})},enable:function(){return h._invoke("enable")},disable:function(){return h._invoke("disable")},destroy:function(){return h._invoke("destroy")},extendFn:function(t,e){return d[t]=e},_invoke:function(t){var e;e=n.extend({},s.vertical,s.horizontal);return n.each(e,function(e,n){n[t]();return true})},_filter:function(t,e,r){var i,o;i=a[n(t).data(u)];if(!i){return[]}o=[];n.each(i.waypoints[e],function(t,e){if(r(i,e)){return o.push(e)}});o.sort(function(t,e){return t.offset-e.offset});return n.map(o,function(t){return t.element})}};n[m]=function(){var t,n;n=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(h[n]){return h[n].apply(null,t)}else{return h.aggregate.call(null,n)}};n[m].settings={resizeThrottle:100,scrollThrottle:30};return i.load(function(){return n[m]("refresh")})})}).call(this);
//# sourceMappingURL=classroom.js.map
