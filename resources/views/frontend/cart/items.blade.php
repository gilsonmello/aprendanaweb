@extends('frontend.layouts.master')

@section('title')
    Carrinho | {{app_name()}}
@endsection

@section('content')
<section id="main-content" class="cart-page">
    <div class="container">
        <div class="row form-group">
            <div class="col-xs-12">
                <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                    <li class="active"><a href="#step-1">
                            <h4 class="list-group-item-heading">1</h4>
                            <p class="list-group-item-text">Carrinho</p>
                        </a></li>
                    <li class="disabled"><a href="#step-2">
                            <h4 class="list-group-item-heading">2</h4>
                            <p class="list-group-item-text">Identificação</p>
                        </a></li>
                    <li class="disabled"><a href="#step-3">
                            <h4 class="list-group-item-heading">3</h4>
                            <p class="list-group-item-text">Pagamento</p>
                        </a></li>
                    <li class="disabled"><a href="#step-3">
                            <h4 class="list-group-item-heading">4</h4>
                            <p class="list-group-item-text">Conclusão</p>
                        </a></li>
                </ul>
            </div>
        </div>

        <section id="steps-container">
            <div class="row setup-content" id="step-1" style="padding-bottom: 20px;">
                <div class="col-md-12">
                    <div id="cart-actions">
                        <div class="row text-center">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <!-- <a href="{{ url('/') }}" class="btn btn-primary course-btn-cart">  Continue comprando </a> -->
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                @if (count($items) != 0)
                                    @if ($items->total != 0)
                                        <a style="float: right;" href="{{ route('cart.auth') }}" id="activate-step-2" class="btn btn-primary product-btn-cart" >Finalizar Compra</a>
                                    @else
                                        <a style="float: right;" href="{{ route('cart.auth') }}" id="activate-step-2" class="btn btn-primary product-btn-cart" >Acesse agora</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="panel panel-info">
                        <div class="panel-body">

                            @foreach($items as $item)
                            <!-- Início do Item do Carrinho de Compras -->
                            <div class="row" >
                                <div class="col-md-12 ">

                                    <!-- Início do Quadrado (imagem) do Carrinho de Compras -->
                                    <div class="col-sm-1 text-center">
                                        <div class="card-course-title-container ">
                                            <a href="{{ route('cart.remove', [$item->rowid]) }}" style="color: #FF0000;" ><i class="fa fa-close product-price-cart"></i></a>
                                        </div>
                                    </div>
                                    <!-- Fim do Quadrado (imagem) do Carrinho de Compras -->

                                    <!-- Início do Quadrado (imagem) do Carrinho de Compras -->
                                    <div class="col-sm-2 hidden-xs no-padding">
                                        <div class="card-course-title-container no-padding">
                                            <img class="img-responsive" src="{{ imageurl( $item->options->type . "s/", $item->id , $item->options->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                        </div>
                                    </div>
                                    <!-- Fim do Quadrado (imagem) do Carrinho de Compras -->

                                    <!-- Início do Título do Item do Carrinho de Compras -->
                                    <div class="col-xs-7">
                                        <h4 class="product-name-cart">{{ $item->name }}</h4>
                                    </div>
                                    <!-- Fim do Título do Item do Carrinho de Compras -->

                                    <!-- Início do Valor do Item do Carrinho de Compras -->
                                    <div class="col-xs-2">
                                        @if($item->options->original_price <> $item->price )
                                        <div class="text-right" style="font-size: 80%">Valor Real : <strike>R$ {{ number_format($item->options->original_price, 2, ',', '.') }}</strike></div><br/>
                                        @endif
                                        <h6 class="product-price-cart text-right">R$ {{ number_format($item->price, 2, ',', '.') }}</h6>

                                    </div>
                                    <!-- Fim do Valor do Item do Carrinho de Compras -->
                                </div>
                            </div>
                            <!-- Fim do Item do Carrinho de Compras -->
                            <div class="clearfix"></div>
                            <!-- Início da linha divisória do Item do Carrinho de Compras -->
                            <hr>
                            <!-- Fim da linha divisória do Item do Carrinho de Compras -->
                            @endforeach

                        </div>

                        <!-- Início do Rodapé do .panel -->
                        <footer class="panel-footer">
                            <div class="text-right" style="font-size: 80%">(*)Desconto(s) aplicado(s) sobre o Valor Real.</div>
                            <div class="row">
                                <div class="col-md-8 code-coupon">

                                    <form action="{{ route('cart.discount') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Caso possua um cupom de desconto, informe o código aqui">
                                            <div class="input-group-btn">
                                                <button type="submit" id="btn-cupom" class="btn btn-primary">ok</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-md-4">
                                    <h5 class="text-right product-discount-cart"><a href="{{ route('cart.remove_discount') }}" style="color: red; margin-left: 10px;"><i class="fa fa-close"></i></a>&nbsp;&nbsp;&nbsp;*Desconto: <strong>R$ {{ number_format($items->discount, 2, ',', '.') }}</strong></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 code-coupon">
                                    Parceiros:
                                    <BR>
                                    <a onclick="javascript: $('#partner_discount_div').css('display', 'block');" style="cursor:pointer; color: red; margin-left: 10px;"><img src="/img/frontend/partner/ucsal.png"></a>
                                    <div id="partner_discount_div" style="display: none; padding-left: 30px;">
                                        {!! Form::open(['route' => ['cart.discount-partner'], 'id' => 'occupation_form', 'class' => '', 'role' => 'form', 'method' => 'POST']) !!}
                                        {!! Form::hidden('partner', '7') !!}
                                        <div class="row">
                                            <div class="code-coupon">
                                                <b>CPF</b>&nbsp;&nbsp;{!! Form::text('key', null, ['class' => 'personal_id', 'placeholder' => trans('strings.personal_id')]) !!}
                                                &nbsp;&nbsp;{!! Form::submit('Aplicar desconto*', ['class' => 'btn btn-success']) !!}
                                                <div class="text-left" style="margin-left: 207px;font-size: 80%">*Aplicado sobre o valor real.</div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="text-right product-total-cart">Total: <strong>R$ {{ number_format($items->total, 2, ',', '.') }}</strong></h4>
                                </div>
                                @if($items->total != 0)
                                    <div class="pull-right">
                                        <div class="col-md-12">
                                            <i class="glyphicon glyphicon-thumbs-up"></i>
                                                Parcele em até : <b>{{ $countParcel }}x R${{ number_format($items->total / $countParcel, 2, ',', '.') }} no Cartão de Crédito</b>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </footer>
                        <!-- Fim do Rodapé do .panel -->
                    </div>
                    <div id="cart-actions">
                        <div class="row text-center">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <!-- <a href="{{ url('/') }}" class="btn btn-primary course-btn-cart">  Continue comprando </a> -->
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                @if (count($items) != 0)
                                    @if ($items->total != 0)
                                        <a style="float: right;" href="{{ route('cart.auth') }}" id="activate-step-2" class="btn btn-primary product-btn-cart" >Finalizar Compra</a>
                                    @else
                                        <a style="float: right;" href="{{ route('cart.auth') }}" id="activate-step-2" class="btn btn-primary product-btn-cart" >Acesse agora</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<div id="white-bg">
    @include('frontend.home.payment-footer')
</div>

@endsection