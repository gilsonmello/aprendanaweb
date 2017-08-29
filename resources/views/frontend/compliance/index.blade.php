@extends('frontend.layouts.master-compliance')

@section('content')

    <div id="main-wrapper" class="page">
        <div class="container">
            <div class="section">
                <div class="row">
                    <section id="steps-container">
                        <div class="row setup-content" id="step-1" style="padding-bottom: 20px;">
                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        @foreach($items as $item)
                                                <!-- Início do Item do Carrinho de Compras -->
                                        <div class="row" >
                                            <div class="col-md-12 ">
                                                <!-- Início do Quadrado (imagem) do Carrinho de Compras -->
                                                <div class="col-sm-2 hidden-xs no-padding">
                                                    <div class="card-course-title-container no-padding">
                                                        <img class="img-responsive" src="{{ imageurl( "courses/", $item['course'] , $item['img'], 0, 'course_home.jpg') }}" alt="" />
                                                    </div>
                                                </div>
                                                <!-- Fim do Quadrado (imagem) do Carrinho de Compras -->

                                                <!-- Início do Título do Item do Carrinho de Compras -->
                                                <div class="col-xs-7">
                                                    <h4 class="product-name-cart">{{ $item['title'] }}</h4>
                                                </div>
                                                <!-- Fim do Título do Item do Carrinho de Compras -->

                                                <!-- Início do Valor do Item do Carrinho de Compras -->
                                                <div class="col-xs-1">
                                                    <h6 class="product-price-cart text-right">R${{ number_format($item['price'], 2, ',', '.') }}</h6>
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
                                        
                                        <!-- Início do Rodapé do .panel -->
                                        <div class="row">
                                            <div class="pull-right">
                                                <div class="col-md-12">
                                                    <h4 class="text-right product-total-cart">Total: <strong>R$ {{ number_format($items[$id]['price'], 2, ',', '.') }}</strong></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="pull-right">
                                                <div class="col-md-12">
                                                    <i class="glyphicon glyphicon-thumbs-up"></i>
                                                        @if($items[$id]['max_installments'] > 0)
                                                            Parcele em até : <b>{{ $items[$id]['max_installments'] }}x R${{ number_format($items[$id]['price'] / $items[$id]['max_installments'], 2, ',', '.') }} no Cartão de Crédito</b>
                                                        @else
                                                            Total.: <b>R${{ number_format($items[$id]['price'], 2, ',', '.') }} no Cartão de Crédito</b>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fim do Rodapé do .panel -->
                                    </div>
                                </div>
                                
                                <div id="cart-actions">
                                    <div class="row text-center">
                                        <div class="col-xs-12 col-sm-6 col-md-6" style="float: right">
                                            @if (count($items) != 0)
                                                <a href="{{ route('cart.auth') }}" id="activate-step-2" class="btn btn-primary product-btn-cart" >Finalizar compra</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div><!--/.row-->
            </div><!--/.section-->
        </div>

    <div class="space"></div>

    {{--@foreach($coursesCategorySet as $coursesCategory)--}}

        {{--@if ($coursesCategory != null)--}}
            {{--@include('frontend.home.courses-from-category')--}}
        {{--@endif--}}

    {{--@endforeach--}}


        <div class="space small"></div>



    <div id="white-bg">
        @include('frontend.home.payment-footer')
    </div>
</div>
<!--/#main-wrapper-->
@endsection

@section('after-scripts-end')
<script>
    //Being injected from FrontendController
</script>

@stop
