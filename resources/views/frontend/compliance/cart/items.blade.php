@extends('frontend.layouts.masterpublicsector')

@section('title')
    Carrinho | {{app_name()}}
@endsection

@section('content')
    <section id="main-content" class="cart-page">
        <div class="container">

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
                                        <div class="col-sm-1 text-center">
                                            <div class="card-course-title-container ">
                                                <a href="{{ route('publicsector.cart.remove', ['course' => $item['course']]) }}" style="color: #FF0000;" ><i class="fa fa-close product-price-cart"></i></a>
                                            </div>
                                        </div>
                                        <!-- Fim do Quadrado (imagem) do Carrinho de Compras -->

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
                                            <h6 class="product-price-cart text-right">{{ number_format($item['count'], 0, ',', '.') }}</h6>

                                        </div>
                                        <div class="col-xs-1" style="padding-top: 10px;">
                                            <!-- Início do Quadrado (imagem) do Carrinho de Compras -->
                                            <a href="{{ route('publicsector.course', ['course' => $item['slug'], 'count' => number_format($item['count'], 0, ',', '.') ]) }}" style="color: #000099;" ><i class="fa fa-pencil product-price-cart"></i></a>

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

                        </div>
                        <div id="cart-actions">
                            <div class="row text-center">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <a href="{{ url('/gestaopublica/cursos') }}" class="btn btn-primary course-btn-cart">  Continue escolhendo </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    @if (count($items) != 0)
                                            <a href="{{ route('publicsector.cart.contact') }}" id="activate-step-2" class="btn btn-primary product-btn-cart" >Solicitar Orçamento</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

@endsection