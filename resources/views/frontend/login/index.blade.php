@extends('frontend.layouts.master')

@section('title')
  Login | {{app_name()}}
@endsection

@section('content')



  <div class="signup-page">
    <div class="container">
      <div class="row">
        <!-- user-login -->
        <div class="col-sm-6">
          <div class="ragister-account account-login">
            <h1 class="section-title title">JÁ É CADASTRADO?</h1>
            <div class="login-options text-center">
              <a href="/auth/login/facebook" class="facebook-login"><i class="fa fa-facebook"></i> Login com Facebook</a>
            </div>

            {!! Form::open(['id' => "registation-form", 'name' => "registation-form", 'url' => 'auth/login', 'class' => 'form-horizontal', 'role' => 'form']) !!}


            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="form-group">
              {!! Form::label('email', trans('validation.attributes.email')) !!}
              {!! Form::input('email', 'email', old('email'), ['class' => 'form-control', 'placeholder' => 'Digite o seu login']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('password', trans('validation.attributes.password')) !!}
              {!! Form::input('password', 'password', null, ['class' => 'form-control']) !!}
            </div>
            <!-- checkbox -->
            <div class="checkbox">
              <!-- <label class="pull-left"><input type="checkbox" name="signing" id="signing"> Manter logado </label> -->
              <p><a onclick="javascript:$('#forgotModal').modal();" class="btn btn-link text-center center-block">Esqueceu a senha?</a></p>
            </div><!-- checkbox -->
            <div class="submit-button text-center">
              {!! Form::submit(trans('labels.login_button'), ['class' => 'btn btn-primary']) !!}
            </div>
            {!!   Form::close() !!}
            @include('includes.partials.forgot-password')

          </div>
        </div>






        <!-- user-login -->
        <div class="col-sm-6">
          <div class="ragister-account">

            <h1 class="section-title title">CADASTRE-SE</h1>
            <div class="login-options text-center">
              <!--  <a href="/auth/login/facebook" class="facebook-login"><i class="fa fa-facebook"></i> Acessar com Facebook</a> -->
            </div>

            {!! Form::open([ 'id'=> "registation-form", 'name'=> "registation-form",'url' => 'auth/register', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

            <div class="form-group">
              {!! Form::label('email', trans('validation.attributes.email')) !!}
              {!! Form::input('email', 'email', old('email'), ['class' => 'form-control', 'placeholder' => 'Digite o seu login']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('password', trans('validation.attributes.password')) !!}
              {!! Form::input('password', 'password', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation')) !!}
              {!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control']) !!}
            </div>
            <!-- checkbox -->
            <div class="checkbox">
              <label class="pull-left" for="signing"><input type="checkbox" name="signing" id="signing" value="1"> Li e aceito os <a href="#" data-toggle="modal" data-target="#termsUses">Termos de Uso</a> </label>
            </div><!-- checkbox -->
            <div class="submit-button text-center">
              {!! Form::submit(trans('labels.register_button'), ['class' => 'btn btn-primary']) !!}
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