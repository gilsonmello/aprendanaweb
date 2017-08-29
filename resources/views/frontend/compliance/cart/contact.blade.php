@extends('frontend.layouts.masterpublicsector')

@section('content')



  <div class="signup-page">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="ragister-account">

            <h1 class="section-title title">INFORME OS SEUS DADOS PARA SOLICITAÇÃO DE ORÇAMENTO</h1>
            <div class="text-center">
              onon onono onononono nono nononononon on on ono no nononononon onono nonononon non on on onono nnonn nono nonn
              onon onono onononono nono nononononon on on ono no nononononon onono nonononon non on on onono nnonn nono nonn
              onon onono onononono nono nononononon on on ono no nononononon onono nonononon non on on onono nnonn nono nonn
            </div>
            <br>

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
              {!! Form::label('obs', trans('Observação')) !!}
              {!! Form::text('obs', null,  ['class' => 'form-control', 'placeholder' => '']) !!}
            </div>
            <!-- checkbox -->
            <div class="submit-button text-center">
              {!! Form::submit(trans('SOLICITAR ORÇAMENTO'), ['class' => 'btn btn-primary']) !!}
            </div>
            {!!   Form::close() !!}
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