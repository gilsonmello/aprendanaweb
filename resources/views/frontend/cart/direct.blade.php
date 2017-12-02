@extends('frontend.layouts.master')

@section('title')
Pagamento | {{app_name()}}
@endsection

@section('content')

<section id="main-content" class="cart-page">

    <div class="container">
        <div class="row form-group">
            <div class="col-xs-12">
                <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                    <li class="disabled"><a>
                            <h4 class="list-group-item-heading">1</h4>
                            <p class="list-group-item-text">Carrinho</p>
                        </a></li>
                    <li class="disabled"><a>
                            <h4 class="list-group-item-heading">2</h4>
                            <p class="list-group-item-text">Identificação</p>
                        </a></li>
                    <li class="active"><a>
                            <h4 class="list-group-item-heading">3</h4>
                            <p class="list-group-item-text">Pagamento</p>
                        </a></li>
                    <li class="disabled"><a>
                            <h4 class="list-group-item-heading">4</h4>
                            <p class="list-group-item-text">Conclusão</p>
                        </a></li>
                </ul>
            </div>
        </div>
    </div>



    <div class="container">
        <div style="margin-top: -30px; margin-bottom: 20px;">

            <img class="img-responsive" src="../../img/frontend/rodape-pagseguro.png" alt="">

        </div>
    </div>

    <div class="container">


        <div  class="panel panel-info panel-payment" style="border-color:#e0e4e4">
            <div class="panel-heading" style="color:#20376d">
                <span><strong> Escolha sua forma de pagamento </strong></span>
            </div>

            <div class="panel-body"  >






                {!! Form::open(['route' => 'pagseguro.send' ,'id' => 'pay', 'name' => 'pay']) !!}

                <input type="hidden" name="pedido_id" value="{{ $sessionId }}">
                <input type="hidden" id="amount" name="amount" value="{{ $items->total }}">
                <input type="hidden" id="max_installments" name="max_installments" value="{{ $max_installments != null ? $max_installments : "unlimited" }}">


                <input type="hidden" id="district" name="district" value="">
                <input type="hidden" id="city" name="city" value="">
                <input type="hidden" id="cityCode" name="cityCode" value="">
                <input type="hidden" id="address" name="address" value="">
                <input type="hidden" id="number" name="number" value="">
                <input type="hidden" id="state" name="state" value="">
                <input type="hidden" id="zip" name="zip" value="{{ Auth::user()->zip }}">




                <input type="hidden" id="billCityCode" name="billCityCode" value="">


                <input type="hidden" id="method" name="method" value="">

                <div  class="panel panel-default" >
                    <div class="panel-heading" data-toggle="collapse" data-target="#print-boleto" style="cursor:pointer">
                        <i class="fa fa-barcode"></i><span class="boleto"> Pagar com boleto </span>
                    </div>

                    <div class="panel-body collapse"  id="print-boleto">
                        <a class="btn btn-info btn-boleto" >Emitir boleto - R$ {{number_format($items->total ,2,',','.')}}</a> 
                        <p>Mais tarifa de R$ 1,00 (Cobrada pelo PagSeguro).
                        </p>
                    </div>

                    <div id="loading" style="display: none" class="text-center">
                        <img src="{{ asset('assets/vendor/pagseguro/images/load-horizontal.gif') }}">
                    </div>
                </div>

                <div class="panel panel-default" id="credit-card-panel" >
                    <div class="panel-heading" data-toggle="collapse" data-target="#credit-card-pay" style="cursor:pointer">
                        <i class="fa fa-credit-card credit-card-brand-icon"></i> Pagar com Cartão de Crédito
                        <div id="brand" class="pull-right">

                        </div>

                    </div>

                    <div class="panel-body collapse" id="credit-card-pay">
                        <div class="alert alert-warning fade in alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Atenção!</strong> É importante conferir as informações do Cartão de Crédito que será utilizado para realizar a compra.
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group small text-uppercase">
                                            <label><strong>NOME IMPRESSO NO CARTÃO</strong></label>
                                            <input type="text" value="{{Auth::user()->name}}" id="holderName" name="holderName" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group small text-uppercase">
                                            {!! Form::label('personal_id', trans('strings.card_personal_id'), ['style' => 'style="margin-right: 1%";']) !!}
                                            {!! Form::text('holderPersonal_id', Auth::user()->personal_id, ['id' => 'personal_id' ,'class' => 'form-control', 'placeholder' => trans('strings.personal_id')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group small text-uppercase">
                                            {!! Form::label('birthdate', trans('strings.birthdate')) !!}
                                            {!! Form::text('holderBirthdate', Auth::user()->birthdate, ['id' => 'birthdate', 'class' => 'form-control', 'placeholder' => trans('strings.birthdate')]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group small text-uppercase">
                                            <label style="margin-right: 1%">Número do Cartão</label>
                                            <input type="text" id="cardNumber" class="form-control">
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group small text-uppercase">
                                            <label><abbr title="Código de Segurança (Atrás do Cartão)">Código de Segurança</abbr></label>
                                            <input type="text" id="cvv" class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group small text-uppercase">
                                            <label>Mês</label>
                                            <select id="expirationMonth" name="expirationMonth"
                                                    class="form-control">
                                                @for($m = 1; $m <= 12; $m++)
                                                <option value="{{ (strlen($m) == 1) ? '0' . $m : $m }}">{{ (strlen($m) == 1) ? '0' . $m : $m }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group small text-uppercase">
                                            <label>Ano</label>
                                            <select id="expirationYear" name="expirationYear" class="form-control">
                                                @for($y = get_current_year(); $y <= get_current_year() + 15; $y++)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group small text-uppercase">
                                            <label>Parcelas   @if( $installments = $items->total / 50 < 1 ? 1 : floor($items->total / 50) )@endif</label>
                                            <select id="installments" name="installments"
                                                    class="form-control">
                                                <option id='card-placeholder' value="">Para selecionar o parcelamento, informe o número do seu cartão.</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="row">

                                    <div class="form-group  col-sm-8 small text-uppercase">
                                        <label>CEP DO ENDEREÇO DE COBRANÇA</label>&nbsp;<i id="update_zip" data-toggle="tooltip" title="Atualizar CEP" class="fa fa-refresh" style="color: red; cursor: pointer;"></i>
                                        {!! Form::text('billZip', Auth::user()->zip, ['id' => 'billZip', 'class' => 'form-control zip', 'placeholder' => trans('strings.zip'), 'onblur' => 'javascript:findAddressBrazil($("#billZip"),$("#billCityCode"),$("#billCity"),$("#billState"),$("#billAddress"),$("#billDistrict"));']) !!}

                                    </div>





                                    <div class="form-group  col-sm-4 small text-uppercase">
                                        <label>Número</label>
                                        <input type="text" id="billNumber" name="billNumber" class="form-control">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-8 small text-uppercase">
                                        {!! Form::label('billAddressComplement', trans('strings.complement')) !!}
                                        <input type="text" class="form-control" id="billAddressComplement" name="billAddressComplement" value="">
                                    </div><!--form control-->



                                    <div class="form-group col-md-4  small text-uppercase">
                                        {!! Form::label('cel', trans('strings.holderphone')) !!}
                                        {!! Form::text('cel', null, ['class' => 'form-control cel', 'placeholder' => trans('strings.holderphone')]) !!}
                                    </div><!--form control-->
                                </div>





                                <div class="row">
                                    <div class="form-group col-md-6  small text-uppercase">
                                        {!! Form::label('billAddress', trans('strings.address')) !!}

                                        <input type="text" id="billAddress" class="form-control" name="billAddress"  value="" >

                                    </div>

                                    <div class="form-group col-md-6  small text-uppercase">
                                        {!! Form::label('billCity', trans('strings.city')) !!}

                                        <input type="text" id="billCity" class="form-control" name="billCity" value="" readonly>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6  small text-uppercase">
                                        {!! Form::label('billDistrict', trans('strings.district')) !!}

                                        <input type="text" id="billDistrict" class="form-control" name="billDistrict" value="" >

                                    </div>


                                    <div class="form-group col-md-6  small text-uppercase">
                                        {!! Form::label('billState', trans('strings.state')) !!}

                                        <input type="text" id="billState" class="form-control" name="billState" value="" readonly>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br/>
                                        <p class="text-center">
                                            <button id="button" class="btn btn-info btn-block btn-credit-card" ><i
                                                    class="fa fa-lock"></i> PAGAR
                                                COM CARTÃO
                                            </button>
                                        </p>
                                        <div id="loadingCredit" style="display: none" class="text-center">
                                            <img src="{{ asset('assets/vendor/pagseguro/images/load-horizontal.gif') }}">
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>



            </div>



        </div>
    </div>

    {!! Form::close() !!}






</section>

@endsection

@section('after-scripts-end')

    <?php $environment = config('laravelpagseguro.use-sandbox'); ?>

    @if($environment == 'local')
        <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    @else
        <script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    @endif


<script src="../js/pagseguro-setup.js"></script>



<script>
$(document).ready(function () {
    findAddressBrazil($("#zip"), $("#cityCode"), $("#city"), $("#state"), $("#address"), $("#district"));
});
</script>


@stop

