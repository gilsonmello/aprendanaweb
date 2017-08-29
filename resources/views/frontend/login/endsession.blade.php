@extends('frontend.layouts.master')

@section('content')

<div class="center-sign">

  <div id="login-tabs" class="nav nav-tabs panel-title-sign mt-xl text-center">
    <h2 class="title active text-uppercase text-bold m-none">
      <a href="#" data-toggle="tab">Sessão Aberta</a>
    </h2>
  </div>

  <div class="tab-content panel panel-sign">


  <div class="tab-pane active" id="login">
    <div class="container">
    <div class="panel-body">
      <div class="mb-xs text-center">
        Você já está utilizando a área do aluno em outro navegador. Deseja encerrar todas as suas sessões?
      </div>


        <div class="row">
          <div class="col-sm-6">
            <p><a href="{{ route('frontend.swapSession') }}" class="btn btn-danger text-center center-block">Sim</a></p>
          </div>
          <div class="col-sm-6 ">
            <p><a href="/" class="btn btn-info text-center center-block">Não</a></p>

          </div>
        </div>
    </div>
    </div>

  </div>

  </div>

</div>


@endsection