@extends('frontend.layouts.masterpublicsector')

@section('content')



  <div class="signup-page">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="ragister-account">

            <h1 class="section-title title">INFORME OS SEUS DADOS PARA SOLICITAÇÃO DE ORÇAMENTO</h1>
            <div class="text-center">
              Sua solicitação será analisada com total prioridade e critério. Em seguida retornaremos com todas as informações necessárias para finalizarmos uma proposta.
            </div>
            <br>

            <h2>Curso:</h2>
                  @foreach($items as $item)
                          <!-- Início do Item do Carrinho de Compras -->
                  <div class="row no-padding" >
                    <div class="col-md-12 no-padding">

                      <!-- Início do Quadrado (imagem) do Carrinho de Compras -->
                      {{--<div class="col-sm-1 text-center">--}}
                        {{--<div class="card-course-title-container ">--}}
                          {{--<a href="{{ route('publicsector.cart.remove', ['course' => $item['course']]) }}" style="color: #FF0000;" ><i class="fa fa-close product-price-cart"></i></a>--}}
                        {{--</div>--}}
                      {{--</div>--}}
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
                        <h3>{{ $item['title'] }}</h3>
                      </div>
                      <!-- Fim do Título do Item do Carrinho de Compras -->

                      <!-- Início do Valor do Item do Carrinho de Compras -->
                      {{--<div class="col-xs-1">--}}
                      {{--<h6 class="product-price-cart text-right">{{ number_format($item['count'], 0, ',', '.') }}</h6>--}}

                      {{--</div>--}}
                      {{--<div class="col-xs-1" style="padding-top: 10px;">--}}
                      {{--<!-- Início do Quadrado (imagem) do Carrinho de Compras -->--}}
                      {{--<a href="{{ route('publicsector.course', ['course' => $item['slug'], 'count' => number_format($item['count'], 0, ',', '.') ]) }}" style="color: #000099;" ><i class="fa fa-pencil product-price-cart"></i></a>--}}

                      {{--</div>--}}
                      <!-- Fim do Valor do Item do Carrinho de Compras -->
                    </div>
                  </div>
                  <!-- Fim do Item do Carrinho de Compras -->
                  <div class="clearfix"></div>
                  <!-- Início da linha divisória do Item do Carrinho de Compras -->
                  <hr>
                  <!-- Fim da linha divisória do Item do Carrinho de Compras -->
                  @endforeach


            <div class="row" style=" padding: 20px;background-color: #f2f3f5">
              <div class="col-sm-12" >
            {!! Form::open([ 'id'=> "registation-form", 'name'=> "registation-form",'url' => route('publicsector.cart.sendproposal'), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

            <div class="form-group">
              {!! Form::label('name', trans('Nome')) !!}
              {!! Form::input('name', 'name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('organization', trans('Organização')) !!}
              {!! Form::input('organization', 'organization', null, ['class' => 'form-control', 'placeholder' => '']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('email', trans('validation.attributes.email')) !!}
              {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => '']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('phone', trans('Telefone')) !!}
              {!! Form::input('phone', 'phone', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('cel', trans('Celular')) !!}
              {!! Form::input('cel', 'cel', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('obs', trans('Observação')) !!}
              {!! Form::text('obs', null,  ['class' => 'form-control', 'placeholder' => '']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('number', trans('Número de colaboradores alunos')) !!}
              {!! Form::text('number', null,  ['class' => 'form-control', 'placeholder' => '']) !!}
            </div>
            <!-- checkbox -->
            <div class="submit-button text-center">
              {!! Form::submit(trans('SOLICITAR ORÇAMENTO'), ['class' => 'btn btn-primary']) !!}
            </div>
            {!!   Form::close() !!}
              </div>
          </div>
          </div>
        </div><!-- user-login -->
      </div><!-- row -->
    </div><!-- container -->
  </div><!-- signup-page -->


  <!-- Modal -->
  <div class="modal fade" id="termsUses" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
    <div class="modal-dialog  modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Termos de Uso</h4>
        </div>
        <div class="modal-body">
          @include('frontend.institutional.terms-content')
        </div>
      </div>
    </div>
  </div>




@endsection