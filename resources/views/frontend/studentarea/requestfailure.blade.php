<div class="modal fade" id="connectionTimeoutModal" tabindex="-1" role="dialog" aria-labelledby="connectionTimeoutModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="connectionTimeoutModalLabel" style="color: #08C">Falha na conexão!</h4>
            </div>
            <div class="modal-body">

                <div id="choice-message">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Parece que ocorreu uma falha em sua tentativa de se comunicar com o nosso servidor. Por favor, verifique sua conexão e tente novamente.</p>
                            <a  type="button"  onclick="javascript: request_retry()" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;">Tentar novamente</a>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="internalServerErrorModal" tabindex="-1" role="dialog" aria-labelledby="internalServerErrorModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="internalServerErrorModalLabel" style="color: #08C">Ocorreu um erro!</h4>
            </div>
            <div class="modal-body">
                <div id="choice-message">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Por favor, atualize essa página ou informe um administrador sobre o problema.</p>
                            <a  type="button"  onclick="javascript: request_retry()" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;">Tentar novamente</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>