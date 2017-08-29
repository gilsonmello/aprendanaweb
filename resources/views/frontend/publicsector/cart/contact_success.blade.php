@extends('frontend.layouts.masterpublicsector')

@section('content')



  <div class="signup-page">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="ragister-account">

            <h1 class="section-title title">SOLICITAÇÃO DE ORÇAMENTO ENVIADA COM SUCESSO</h1>
            <div class="text-center">
              Sua solicitação será analisada com total prioridade e critério. Em seguida retornaremos com todas as informações necessárias para finalizarmos uma proposta.
            </div>
            <br>
            <br>

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