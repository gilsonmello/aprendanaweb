
<div class="modal fade" id="displayModal" tabindex="-1" role="dialog" aria-labelledby="displayModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-body" style="padding-bottom: 0px; padding-top: 3px ">

                <div id="choice-message">
                    <div id="card-row" class="row" style="padding:20px">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-title" style="color:#32C6D4; font-size:2rem">AVALIAÇÃO DE RENDIMENTO </div><br/>
                                <p>A Avaliação de Rendimento permite avaliar o seu aprendizado durante o curso, medindo sua aptidão para obter o certificado.</p>
                                <p>Na Avaliação de Rendimento, somente após concluir todo o simulado, respondendo a todas as questões, o aluno terá acesso aos comentários dos professores. Assim, será necessário responder todas as questões, marcando suas alternativas, para ao final  ter acesso as respostas correlatas e comentários dos professores.</p>
                                <p>Na Avaliação de Rendimento será possível alterar as respostas das questões já marcadas. Aquelas questões que não forem respondidas, seja pelo esgotamento do tempo, seja pela finalização do SAAP pelo aluno, serão computadas como erro.</p>                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <br/>
                                <a  type="button"  href="{{ route('frontend.final.exam', $enrollment->id ) }}" class="mt-xs mr-xs btn btn-primary" style="border-color: #32C6D2;background-color:#32C6D4; width:100%; font-size: 1.7rem;">Iniciar a Prova do Curso</a>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>
</div>


