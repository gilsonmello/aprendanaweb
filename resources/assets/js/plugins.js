// Avoid `console` errors in browsers that lack a console.
(function () {
    var method;
    var noop = function () {
    };
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
$(function () {

    function is_email(email){
        er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2,3}/; 
        if(!er.exec(email)){
            return false;
        }
        return true;
    }

    //Escuta o botão de submit do formulário de cadastro de usuários no carrinho
    //Verifica se o usuário informou os campos obrigatórios
    $('.register_on_cart').submit(function(e){
        
        //Variável que retornará se tudo ocorreu bem
        var is_valid = true;
        //Removendo todos os ícones de alerta
        $(".fa-warning").remove();
        //Removendo todos os p mensagem de campo obrigatório
        $('.p-error').remove();
        //Removendo todas os spans com a mensagem de campo obrigatório
        $('.span-error').remove();
       
        //Faz loop em todos os inputs do formulário
        $(this).find('input').each(function(key, val){
            //Se o input for do tipo text ou email
            if(($(this).attr('type') == 'text' || $(this).attr('type') == 'email') && $(this).attr('data-not-required') == undefined){
                //Verifico se está vazio
                if($(this).val() == "" ){
                    is_valid = false;
                    $(this).css('background-color', 'rgba(249, 3, 3, 0.37)');
                    $(this).parent().find('label').after('&nbsp;<i data-toggle="tooltip" title="Campo obrigatório" class="fa fa-warning" style="color: red"></i>');
                    $(this).after('<p class="p-error" style="color: red;">Campo Obrigatório</p>');
                }else{
                    $(this).css('background-color', 'initial');
                }
            }
            //Se o input for do tipo password
            if($(this).attr('type') == 'password' && $(this).attr('data-not-required') == undefined){
                //Verifico se está vazio
                if($(this).val() == ""){
                    is_valid = false;
                    $(this).css('background-color', 'rgba(249, 3, 3, 0.37)');
                    $(this).parent().find('label').after('&nbsp;<i data-toggle="tooltip" title="Campo obrigatório" class="fa fa-warning" style="color: red"></i>');
                    $(this).after('<p class="p-error" style="color: red;">Campo Obrigatório</p>');
                }else{
                    $(this).css('background-color', 'initial');
                }
            }
            //Se o input for do tipo checkbox
            if($(this).attr('type') == 'checkbox' && $(this).attr('data-not-required') == undefined){
                //Verifico se está selecionado
                if(!$(this).is(':checked')){
                    $(this).parent().after('<span class="span-error" style="color: red; margin-left: 2%;">Campo Obrigatório</span>');
                    $(this).parent().after('&nbsp;<i data-toggle="tooltip" title="Campo obrigatório" class="fa fa-warning" style="color: red"></i>');
                    is_valid = false;
                }else{
                    $(this).parent().parent().find('.span-error').remove();
                }
            }
        });
        //Se deu tudo certo, retorna true, se não, retorna false
        return is_valid;
    });

    //Escuta o botão de e-mail da url carrinho/autenticacao, e insere um registro
    //Criar log das tentativas de cadastro a partir do carrinho
    $('#email_register').on('focusout', function(){
        if($(this).val() != ""){
            $.ajax({
                method: 'POST',
                url: '/carrinho/criar-tentativa-de-registro-no-carrinho',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {
                    email: $(this).val()
                },
                success: function(data){
                }
            });
        }
    });

    /**
     * Função para validação de formulário
     * @param form
     *      
     **/
    function validateForm(form){
        //Variável que retornará se tudo ocorreu bem
        var is_valid = true;
        //Removendo todos os ícones de alerta
        $(".fa-warning").remove();
        //Removendo todos os p mensagem de campo obrigatório
        $('.p-error').remove();
        //Removendo todas os spans com a mensagem de campo obrigatório
        $('.span-error').remove();
       
        //Faz loop em todos os inputs do formulário
        form.find('input').each(function(key, val){
            //Se o input for do tipo text ou email
            if($(this).attr('type') == 'text' && $(this).attr('data-not-required') == undefined){
                //Verifico se está vazio
                if($(this).val() == "" ){
                    is_valid = false;
                    $(this).css('background-color', 'rgba(249, 3, 3, 0.37)');
                    $(this).parent().find('label').after('&nbsp;<i data-toggle="tooltip" title="Campo obrigatório" class="fa fa-warning" style="color: red"></i>');
                    $(this).after('<p class="p-error" style="color: red;">Campo Obrigatório</p>');
                }else{
                    $(this).css('background-color', 'white');
                }
            }
            //Se o input for do tipo password
            if($(this).attr('type') == 'password' && $(this).attr('data-not-required') == undefined){
                //Verifico se está vazio
                if($(this).val() == ""){
                    is_valid = false;
                    $(this).css('background-color', 'rgba(249, 3, 3, 0.37)');
                    $(this).parent().find('label').after('&nbsp;<i data-toggle="tooltip" title="Campo obrigatório" class="fa fa-warning" style="color: red"></i>');
                    $(this).after('<p class="p-error" style="color: red;">Campo Obrigatório</p>');
                }else{
                    $(this).css('background-color', 'white');
                }
            }
            //Se o input for do tipo checkbox
            if($(this).attr('type') == 'checkbox' && $(this).attr('data-not-required') == undefined){
                //Verifico se está selecionado
                if(!$(this).is(':checked')){
                    $(this).parent().after('<span class="span-error" style="color: red; margin-left: 2%;">Campo Obrigatório</span>');
                    $(this).parent().after('&nbsp;<i data-toggle="tooltip" title="Campo obrigatório" class="fa fa-warning" style="color: red"></i>');
                    is_valid = false;
                }else{
                    $(this).parent().parent().find('.span-error').remove();
                }
            }
            //Se o input for do tipo email
            if($(this).attr('type') == 'email'){
                //Verifico se está vazio
                if($(this).val() == ""){
                    is_valid = false;
                    $(this).css('background-color', 'rgba(249, 3, 3, 0.37)');
                    $(this).parent().find('label').after('&nbsp;<i data-toggle="tooltip" title="Campo obrigatório" class="fa fa-warning" style="color: red"></i>');
                    $(this).after('<p class="p-error" style="color: red;">Campo Obrigatório</p>');
                }
                //Verifico se o email é valido
                else if(!is_email($(this).val())){
                    is_valid = false;
                    $(this).css('background-color', 'rgba(249, 3, 3, 0.37)');
                    $(this).parent().find('label').after('&nbsp;<i data-toggle="tooltip" title="E-mail Inválido" class="fa fa-warning" style="color: red"></i>');
                    $(this).after('<p class="p-error" style="color: red;">E-mail Inválido</p>');
                }else{
                    $(this).css('background-color', 'white');
                }
            }
        });

        return is_valid;
    }

    //Variável que irá controlar os clicks do usuário
    var click = 1;
    //Escuta o botão de inscrição de usuários na campanha Quero Aula + E-book
    $('#subscribe_oab_e_etica').on('submit', function(e){
        
        //Validando formulário
        var is_valid = validateForm($(this));
        
        //Se o formulário foi validado com sucesso
        if(is_valid == true){
            if(click == 1){
                click = 2;
                $('#loading').css({
                    'display': 'block'
                });
                $.ajax({
                    method: 'POST',
                    dataType: 'Json',
                    url: '/subscribe-ebook-oab-e-etica',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: $(this).serialize(),
                    success: function(data){
                        if(data == 'success'){
                            click = 1;
                            $('#loading').css({
                                'display': 'none'
                            });

                            window.location.href = '/etica-oab/enviado';
                            /*html = '<div id="alert" style="display: none; color: white; background-color: #00a65a !important; border-radius: 3px; padding: 15px; border: 1px solid transparent" class="form-group col-xs-12 col-sm-12 col-md-12">';
                            html += 'E-book enviado com sucesso!';
                            html += '</div>';
                            $(html).insertAfter('#subscribe_oab_e_etica');
                            $('#alert').fadeIn('slow');
                            $('#email').val("");
                            $('#name').val("");
                            setTimeout(function(){
                                $('#alert').fadeOut('slow');
                                $('#alert').remove();
                            }, 2000);*/
                        }else{
                            $('#loading').css({
                                'display': 'none'
                            });
                            html = '<div id="alert" style="display: none; color: white; background-color: #red !important; border-radius: 3px; padding: 15px; border: 1px solid transparent" class="form-group col-xs-12 col-sm-12 col-md-12">';
                            html += 'Erro ao enviar e-book!';
                            html += '</div>';
                            $(html).insertAfter('#subscribe_oab_e_etica');
                            $('#alert').fadeIn('slow');
                            $('#email').val("");
                            $('#name').val("");
                            setTimeout(function(){ 
                                $('#alert').fadeOut('slow');
                                $('#alert').remove();
                            }, 2000);
                        }
                    }
                });
            }
        }
        return false;
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });


    if ($(".colorpicker-box").length)
        $(".colorpicker-box").colorpicker();
    if ($.isFunction($.fn.select2)) {
        $(".select2").select2();
    }
    if ($.isFunction($.fn.datepicker)) {
        $(".datepicker").datepicker({format: 'dd/mm/yyyy'});
    }

    if ($.isFunction($.fn.wysihtml5)) {
        if (!$("#comments-content").length) {

            $(".textarea").wysihtml5({
                toolbar: {
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
                        img: {
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

    $(".title-has-slug").blur(function () {
        var slug = convertToSlug(this.value);
        $(".slug-from-title").val(slug);
    });
    if ($.isFunction($.fn.select2)) {
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
    function formatRepo(repo) {
        if (repo.loading)
            return repo.text;
        var markup = '<div class="clearfix">' + repo.name + '</div>';
        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.name;
    }





    if ($.isFunction($.fn.select2)) {
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
        if ($("#course-data").length > 0)
            createSelect('lessons', '/admin/lessons/select', undefined, $("#course-data").data('course-id'));
    }



    $(".zip").on('blur', function (e) {
        findAddressBrazil($("#zip"), $("#city_id"), $("#city"), $("#state"), $("#address"), $("#neighborhood"));
    });

    $('#update_zip').click(function(e){
        findAddressBrazil($("#billZip"),$("#billCityCode"),$("#billCity"),$("#billState"),$("#billAddress"),$("#billDistrict"));
    });

    $(".zip").parent().parent().one('mouseover', function () {
        findAddressBrazil($("#zip"), $("#city_id"), $("#city"), $("#state"), $("#address"), $("#neighborhood"));
    });


    $(".testCoupon").on('click', function (e) {
        if ($("#coupon_code").val() != '') {
            alert('Confirme o cupom de descontos informado antes de finalizar a compra. Para isso, clique em Ok.');
            return false;
        }
    });

    // Relativo a tabs
    //-----------------------------------------------------------------------------------------------------



    if ($("#module-table").length)
        createModuleTable();

    /*
     Allows you to add data-method="METHOD to links to automatically inject a form with the method on click
     Example: <a href="{{route('customers.destroy', $customer->id)}}" data-method="delete" name="delete_item">Delete</a>
     Injects a form with that's fired on click of the link with a DELETE request.
     Good because you don't have to dirty your HTML with delete forms everywhere.
     */

    $(".cel").inputmask("(99) 999999999");
    $(".personal_id").inputmask("999.999.999-99");

    $('#personal_id').inputmask('999.999.999-99');
    $(".company_id").inputmask("99.999.999/9999-99");
    $(".birthdate").inputmask("99/99/9999");
    $("#birthdate").inputmask("99/99/9999");
    $(".datemask").inputmask("99/99/9999");
    $(".zip").inputmask("99.999-999");

    $('#update_zip').on('click', function(){
        $(".zip").focus();
    });

    var mask = 0;
    $('.grade').focus(function () {
        if (mask == 0) {
            $('.grade').inputmask({mask: '[9][9][9].99', numericInput: true});
            mask = 1;
        }
    });

    $('.grade').click(function () {
        if (mask == 0) {
            $('.grade').inputmask({mask: '[9][9][9].99', numericInput: true});
            mask = 1;
        }
    });


    $(".money").maskMoney({thousands: '.', decimal: ',', affixesStay: false, allowZero: true});
    //$(".time").maskMoney({thousands:'',decimal:',',affixesStay: false, allowZero: true});

    $('[data-method]').append(function ()
    {
        var method;
        if($(this).attr('data-method') != undefined || $(this).attr('data-method') != ""){
            method = $(this).attr('data-method');
        }else{
            method = "POST";
        }
        //id do order
        var orderid = $(this).attr('data-id');
        var typeAlert = $(this).attr('data-alert');
        var message = $(this).attr('data-message');
        var name = null;
        switch (typeAlert) {
            case 'delete-order':
                name = "delete_order";
                break;
            case 'send_email':
                name = "send_email";
                break;
            case 'released_for_certification':
                name = "released_for_certification";
                break;
            default:
                name = "delete_item";
                break;
        }
        return "\n" +
                "<form action='" + $(this).attr('href') + "' method='"+method+"' data-id='" + orderid + "' data-message='" + message + "' name='" + name + "' style='display:none'>\n" +
                "   <input type='hidden' name='_method' value='" + $(this).attr('data-method') + "'>\n" +
                "   <input type='hidden' name='_token' value='" + $('meta[name="_token"]').attr('content') + "'>\n" +
                "</form>\n"
    })
            .removeAttr('href')
            .attr('style', 'cursor:pointer;')
            .attr('onclick', '$(this).find("form").submit();');

    /*
     Generic are you sure dialog
     */
    $('form[name=delete_item]').submit(function () {
        return confirm("Tem certeza que deseja excluir esse item?");
    });

    /**
     * Todo fomulário que contém o nome
     */
    //Formulário para exclusao de pedidos
    $('form[name=delete_order]')
            .submit(function () {

                console.log('Enviando para Google Analytcs' + ' Order:' + $(this).attr('data-id'));

                //Se o atributo data-message ele exibe a messagem de data-message
                if ($(this).attr('data-message') != undefined) {

                    //Se o usuario confirmar a exclusão o pedido será retirado do google analitcs
                    if (confirm($(this).attr('data-message'))) {
                        //Pesquisando dados do pedido para exclusão do google analitcs
                        $.ajax({
                            url: "/admin/orders/" + $(this).attr('data-id'),
                            method: 'GET'
                        }).done(function (data) {

                            //Recuperando informaçoes do pedido e itens
                            var items = data[1];
                            var transaction = data[0];
                            ga('create', 'UA-78805304-1', 'auto', {'name': 'myTracker'});
                            ga('myTracker.require', 'ecommerce');
                            ga('myTracker.ecommerce:addTransaction', transaction);

                            for (var i in items) {
                                ga('myTracker.ecommerce:addItem', items[i]);
                            }

                            //Nao remove do google analitcs se estiver sendo executado em Localhost
                            if (window.location.hostname != 'localhost') {
                                ga('myTracker.ecommerce:send');
                                console.log('Removed of Google Analitcs');
                            } else {
                                console.log('Not Removed of Google Analitcs because is LocalHost');
                            }

                        });
                    } else {
                        return false;
                    }
                }
            });
    /*
     Generic are you sure dialog
     */
    $('form[name=send_email]').submit(function () {
        if ($(this).attr('data-message') != undefined) {
            return confirm($(this).attr('data-message'));
        }
        return confirm("Tem certeza que deseja enviar a mensagem para o(s) aluno(s)?");
    });
    
    /*
     Generic are you sure dialog
     */
    $('form[name=released_for_certification]').submit(function () {
        if ($(this).attr('data-message') != undefined) {
            return confirm($(this).attr('data-message'));
        }
        return confirm("Tem certeza que deseja enviar a mensagem para o(s) aluno(s)?");
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
    var to = "aaaaaeeeeeiiiiooooouuuunc------";
    for (var i = 0, l = from.length; i < l; i++) {
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
function createSelect(selector, route, modal, other_parameter) {

    var target_route;
    if (route == undefined) {
        target_route = '/admin/' + selector + '/select';
    } else {
        target_route = route;
    }

    var param = other_parameter;
    var $select_selector;

    if (selector instanceof jQuery) {
        $select_selector = selector;

    } else {
        $select_selector = $('.' + selector + '-select');
    }
    if (modal == undefined) {
        $select_selector.select2({
            minimumInputLength: 3,
            ajax: {
                type: 'POST',
                url: target_route,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: function (params) {
                    if (param != undefined) {
                        return{
                            term: params.term,
                            other: param,
                        }
                    }
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {results: data};
                }
            }
        });
    } else {
        $select_selector.select2({
            minimumInputLength: 3,
            dropdownParent: modal,
            ajax: {
                type: 'POST',
                url: target_route,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: function (params) {
                    if (param != undefined) {
                        return{
                            term: params.term,
                            other: param,
                        }
                    }
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {results: data};
                }
            }
        });
    }
}



function generateUUID() {
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
    return uuid;
}
;


function setRandom() {
    $('#random_code').on('click', function () {
        $('[name="code"]').val(generateUUID());
    });
}

