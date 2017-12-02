/**
 * Created by ambiente on 05/07/16.
 */
PagSeguroDirectPayment.setSessionId($("[name='pedido_id']").val());
function setSenderHash() {
    var form = document.querySelector('#pay');
    var hash = PagSeguroDirectPayment.getSenderHash();

    if (document.querySelector("input[name=senderHash]") == null) {
        var senderHash = document.createElement('input');
        senderHash.setAttribute('name', "senderHash");
        senderHash.setAttribute('type', "hidden");
        senderHash.setAttribute('value', hash);
        form.appendChild(senderHash);
    }
}

function validateCPF(cpf)
{
    var numbers, digits, sum, i, result, equal_digits;
    equal_digits = 1;
    if (cpf.length < 11)
        return false;
    for (i = 0; i < cpf.length - 1; i++)
        if (cpf.charAt(i) != cpf.charAt(i + 1))
        {
            equal_digits = 0;
            break;
        }
    if (!equal_digits)
    {
        numbers = cpf.substring(0,9);
        digits = cpf.substring(9);
        sum = 0;
        for (i = 10; i > 1; i--)
            sum += numbers.charAt(10 - i) * i;
        result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result != digits.charAt(0))
            return false;
        numbers = cpf.substring(0,10);
        sum = 0;
        for (i = 11; i > 1; i--)
            sum += numbers.charAt(11 - i) * i;
        result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result != digits.charAt(1))
            return false;
        return true;
    }
    else
        return false;
}






function setCardBrand() {

    $('#cardNumber').blur(function () {
        var cardNumber = document.querySelector('#cardNumber').value;
        if (cardNumber != null) {
            PagSeguroDirectPayment.getBrand({
                cardBin: cardNumber.replace(/ /g, ''),
                success: function (data) {
                    var form = document.querySelector('#pay');
                    var brand = JSON.stringify(data.brand.name).replace(/"/g, '');
                    if (document.querySelector("input[name=cardBrand]") == null) {
                        var cardBrand = document.createElement('input');
                        cardBrand.setAttribute('name', "cardBrand");
                        cardBrand.setAttribute('type', "hidden");
                        cardBrand.setAttribute('value', brand);
                        form.appendChild(cardBrand);
                        setInstallmentAmount();
                    } else {
                        document.querySelector("input[name=cardBrand]").value = brand;
                    }
                    $(".credit-card-brand-icon").removeClass('fa-credit-card').addClass('fa-cc-' + brand);
                    $(".invalid-card-number").remove();
                    
                    $("#cardNumber").css('background-color', 'initial');
                    if(brand == "" || brand == null || cardNumber.replace(/ /g, '').length > 20){
                        $("#cardNumber").parent().find('label').after('<i data-toggle="tooltip" title="Cartão inválido" class="fa fa-warning invalid-card-number" style="color: red"></i>');
                        $("#cardNumber").after('<p class="invalid-card-number" style="color: red;">Cartão inválido</p>');
                        $("#cardNumber").css({
                            'background-color': 'rgba(249, 3, 3, 0.37)'
                        });
                    }
                },
                error: function (data, error, other) {
                    $(".invalid-card-number").remove();
                    //$("#cardNumber").css('background-color', 'initial');
                    $("#cardNumber").parent().find('label').after('<i data-toggle="tooltip" title="Cartão inválido" class="fa fa-warning invalid-card-number" style="color: red"></i>');
                    $("#cardNumber").after('<p class="invalid-card-number" style="color: red;">Cartão inválido</p>');
                    $("#cardNumber").css({
                        'background-color': 'rgba(249, 3, 3, 0.37)'
                    });
                    //console.log("Erro");
                }
            });
        }
    });
}
function setCardToken() {
    var parametros = {
        cardNumber: document.getElementById('cardNumber').value,
        brand: document.querySelector("input[name=cardBrand]").value,
        cvv: document.getElementById('cvv').value,
        expirationMonth: document.querySelector('#expirationMonth option:checked').value,
        expirationYear: document.querySelector('#expirationYear option:checked').value,
        success: function (data) {
            var form = document.querySelector('#pay');
            var token = JSON.stringify(data.card.token).replace(/"/g, '');
            if (document.querySelector("input[name=cardToken]") == null) {
                var cardToken = document.createElement('input');
                cardToken.setAttribute('name', "cardToken");
                cardToken.setAttribute('type', "hidden");
                cardToken.setAttribute('value', token);
                form.appendChild(cardToken);
            } else {
                document.querySelector("input[name=cardToken]").value = token;
            }
        },
        error: function (data) {
//            console.log('Ocorreu um erro na validação do cartão');
//            console.log(JSON.stringify(data));
        }
    };
    PagSeguroDirectPayment.createCardToken(parametros);
}
function setInstallmentAmount() {
    var brand = document.querySelector("input[name=cardBrand]").value;
    //var brand = 'visa';
    var form = document.querySelector('#pay');
    PagSeguroDirectPayment.getInstallments({
        amount: document.getElementById('amount').value,
        maxInstallmentNoInterest: 10,
        brand: brand,
        success: function (data) {

            //var installment = document.querySelector('#installments option:checked').value;
            var installments = JSON.parse(JSON.stringify(data))['installments'];
            var max_installments = document.getElementById('max_installments').value;
            if (max_installments == "unlimited")
                max_installments = -1;

            if (document.querySelector("input[name=installmentAmount]") == null) {
                installments[brand].forEach(function (single) {
                    if ((single.installmentAmount > 20 && (max_installments == -1 || single.quantity <= max_installments)) || single.quantity == 1) {
                        var option = "<option value='" + single.quantity + "'>";
                        option = option + single.quantity + 'x de R$ ' + single.installmentAmount.toFixed(2).replace('.', ',') + '</option>';
                        $("#installments").append(option);
                    }
                });

                $("#card-placeholder").remove();
                var amount = installments[brand][0]['installmentAmount'];
                var installmentAmount = document.createElement('input');
                installmentAmount.setAttribute('name', "installmentAmount");
                installmentAmount.setAttribute('type', "hidden");
                installmentAmount.setAttribute('value', amount);
                form.appendChild(installmentAmount);

            } else {
                var installment = document.querySelector('#installments option:checked').value;
                var amount = installments[brand][installment - 1]['installmentAmount'];
                document.querySelector("input[name=installmentAmount]").value = amount;
            }
        },
        error: function(data){
        },
        complete: function(data){

        }
    });
}

//Botão do Boleto
document.querySelector(".btn-boleto").addEventListener('click', function (event) {
    document.querySelector('#method').setAttribute('value', 'boleto');
    var form = document.querySelector('#pay');
    setSenderHash();
    $('#button').attr('disabled', 'disabled');
    $('#button').attr('disabled', 'disabled');
    document.getElementById('loading').style.display = 'block';

    $.ajax({
        url: form.getAttribute('action'),
        type: 'post',
        data: $('#pay').serialize(),
        success: function (data) {
            var appendUrlBoleto = "<input name='url_boleto' id='url_boleto' type='hidden'>";
            document.querySelector("#print-boleto").innerHTML = appendUrlBoleto;
            //Rota da tela de emissão do Banner
            $('#pay').attr("action", "/carrinho/boleto-emitido");

         //  setTimeout(function () {
         //       $('#url_boleto').val(data.paymentLink);
         //       $('#pay').submit();
         //  }, 3000);

            var set_url_boleto = setInterval(function(){
               if($("#url_boleto").length > 0 && data.paymentLink != "" && data.paymentLink != undefined && data.paymentLink != null){
                   $('#url_boleto').val(data.paymentLink);
                   $('#pay').submit();
                   clearInterval(set_url_boleto);
               }

            },3000);

        }
    });
});

//Escuta do botão de envio do formulário
document.querySelector(".btn-credit-card").addEventListener('click', function (event) {
    document.querySelector('#method').setAttribute('value', 'creditCard');
    $('#button').attr('disabled', 'disabled');
    document.getElementById('loadingCredit').style.display = 'block';

    if (validateCreditCardFields() === false) {
        document.getElementById('loadingCredit').style.display = 'none';
        $('#button').removeAttr("disabled");  // retirar
        return false;
    } else {

        setTimeout(function () {
            var form = document.querySelector('#pay');
            setSenderHash();
            if (document.querySelector("#method").getAttribute('value') == "creditCard") {
                setInstallmentAmount();
                setCardToken();
            }

            setTimeout(function () {
                form.submit();
            }, 2000);
            return false;

        }, 1000);
    }


});

var valid_fields = false;

function validateCreditCardFields() {
    var is_valid = true;
    var fields = $("#credit-card-pay");
    $(".fa-warning").remove();
    $('.p-error').remove();

    fields.find('input').each(function () {
        if (isEmpty($(this)) && $(this).val() == "") {
            is_valid = false;
            $(this).css('background-color', 'rgba(249, 3, 3, 0.37)');
            $(this).parent().find('label').after('&nbsp;<i data-toggle="tooltip" title="Campo obrigatório" class="fa fa-warning" style="color: red"></i>');
            $(this).after('<p class="p-error" style="color: red;">Campo Obrigatório</p>');
        } else {
            //Voltando o input para o background para cor original
            $(this).css('background-color', 'initial');
            $(".invalid-card-number").remove();
            //Verificando se o número digitado pelo usuário é válido
            var cardNumber = document.querySelector('#cardNumber').value;
            if (cardNumber != null) {
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.replace(/ /g, ''),
                    success: function (data) {
                        var form = document.querySelector('#pay');
                        var brand = JSON.stringify(data.brand.name).replace(/"/g, '');
                        if (document.querySelector("input[name=cardBrand]") == null) {
                            var cardBrand = document.createElement('input');
                            cardBrand.setAttribute('name', "cardBrand");
                            cardBrand.setAttribute('type', "hidden");
                            cardBrand.setAttribute('value', brand);
                            form.appendChild(cardBrand);
                            setInstallmentAmount();
                        } else {
                            document.querySelector("input[name=cardBrand]").value = brand;
                        }
                        $(".credit-card-brand-icon").removeClass('fa-credit-card').addClass('fa-cc-' + brand);
                        $(".invalid-card-number").remove();
                        
                        if(brand == "" || brand == null || cardNumber.replace(/ /g, '').length > 20){

                            $("#cardNumber").parent().find('label').after('<i data-toggle="tooltip" title="Cartão inválido" class="fa fa-warning invalid-card-number" style="color: red"></i>');
                            $("#cardNumber").after('<p class="invalid-card-number" style="color: red;">Cartão inválido</p>');
                            $("#cardNumber").css({
                                'background-color': 'rgba(249, 3, 3, 0.37)'
                            });
                        }
                    },
                    error: function (data, error, other) {
                        $(".invalid-card-number").remove();
                        $("#cardNumber").parent().find('label').after('<i data-toggle="tooltip" title="Cartão inválido" class="fa fa-warning invalid-card-number" style="color: red"></i>');
                        $("#cardNumber").after('<p class="invalid-card-number" style="color: red;">Cartão inválido</p>');
                        $("#cardNumber").css({
                            'background-color': 'rgba(249, 3, 3, 0.37)'
                        });
                        //console.log("Erro");
                    }
                });
            }
        }

    });

    return is_valid;

}
function isEmpty(el) {
    return !$.trim(el.html());
}

setCardBrand();
document.querySelector('#pay').addEventListener('submit', function (event) {
    event.preventDefault();
});

//Desabilitando o Submit através do ENTER
$(document).keypress(function (e) {
    var code = null;
    code = (e.keyCode ? e.keyCode : e.which);
    return (code == 13) ? false : true;
});

/**
 * Arranjo para ser refatorado
 */
//Limpando as Sugestões de CPF, Data de Nascimento e populando campo complemento
$(document).ready(function () {
    $('.personal_id').val('');
    $('.birthdate').val('');
    $('#billAddressComplement').val('-');

    $(".invalid-personal-id").remove();

    $("#personal_id").blur(function(){
        $(".label-error").remove();
        $(".p-error").remove();
        console.log($(this).parent().find('i'), $(this).parent());
        $(this).parent().find('i').remove();
        //console.log(validateCPF($(this).val().replace(".","").replace(".","").replace("-","")));
        if(!validateCPF($(this).val().replace(".","").replace(".","").replace("-",""))){
            $(this).css({
                'background-color': 'rgba(249, 3, 3, 0.37)'
            });
            $(this).parent().find('label').after('<i data-toggle="tooltip" title="CPF Inválido" class="fa fa-warning invalid-personal-id" style="color: red"></i>');
            $(this).after('<p class="p-error" style="color: red;">CPF Inválido</p>');
        }
    });
    $(".birthdate").blur(function(){
        $(".invalid-birthdate").remove();
        if(parseDate($(this).val()) == null){

            $(this).parent().find('label').after('<i data-toggle="tooltip" title="Data de Nascimento Inválida" class="fa fa-warning invalid-birthdate" style="color: red"></i>');

        }
    });
});




function parseDate(str) {
    var m = str.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
    return (m) ? new Date(m[3], m[2]-1, m[1]) : null;
}