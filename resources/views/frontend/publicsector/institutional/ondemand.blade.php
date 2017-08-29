@extends('frontend.layouts.masterpublicsector')

@section('title')
    Vantagens e Diferenciais | {{app_name()}}
@endsection



@section('content')

 <section id="main-content">
    <div class="container">
        <section id="search-meaning">
            <h1 class="section-title">Cursos sob medida</h1>
        </section>

        <br/>
        <div class="row">
          <div class="col-md-12 ">
              <p>O Brasil Jurídico Gestão Pública traz para vocês, servidores públicos e cidadãos, uma plataforma de desenvolvimento, aperfeiçoamento e transformação inovadora.</p>

              <p>Com a metodologia de capacitação a distância, o servidor poderá acessar o seu curso a qualquer momento e em qualquer lugar. Essa facilidade permite uma maior flexibilidade e otimização do treinamento de acordo com cada disponibilidade do aluno.</p>

              {!! Form::open([ 'id'=> "registation-form", 'name'=> "registation-form",'url' => route('publicsector.cart.sendproposal'), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

              <div class="col-md-8 ">
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
                  {!! Form::label('obs', trans('Área de Conhecimento do Curso')) !!}
                  {!! Form::text('obs', null,  ['class' => 'form-control', 'placeholder' => '']) !!}
              </div>
              <!-- checkbox -->
              <div class="submit-button text-center">
                  {!! Form::submit(trans('SOLICITAR ORÇAMENTO'), ['class' => 'btn btn-primary']) !!}
              </div>
              {!!   Form::close() !!}
              </div>

          </div>
        </div>
        <br/>
        <br/>

    </div>
    

</section> 
@endsection
