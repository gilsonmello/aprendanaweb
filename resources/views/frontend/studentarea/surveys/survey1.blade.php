<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h1 style="color:black"><strong>| COLABORE</strong> com a nossa pesquisa</h1>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card" style="margin-bottom: 20px;">
                    Queremos deixar a nossa plataforma ainda mais eficiente, por isso sua opinião é muito importante. Por favor, responda as 3 questões da nossa pesquisa de opinião e ajude-nos a deixá-la ainda melhor.
                    <br>
                    <br>
                    {!! Form::open(['route' => ['frontend.profile.answer_survey'], 'id' => 'answer_survey_form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) !!}
                    <input type="hidden" name="survey" id="survey" value="1">
                    <b>1 – Avalie de 1 a 5 os itens a seguir relativos a área do aluno, sendo 1 - péssimo, 2 - ruim, 3 - razoável, 4 - bom e 5 - ótimo.</b>
                    <br>
                    <br>
                    Facilidade em localizar as informações (quadro de avisos, calendário, evolução do curso, resultados dos SAAP's)<br>
                    <input type="radio" name="qst1" id="qst1" value="1">&nbsp;1&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst1" id="qst1" value="2">&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst1" id="qst1" value="3">&nbsp;3&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst1" id="qst1" value="4">&nbsp;4&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst1" id="qst1" value="5">&nbsp;5&nbsp;&nbsp;&nbsp;&nbsp;
                    <br>
                    Facilidade em localizar as funcionalidades (acesso às aulas e SAAP's, anotações, avaliações, fale conosco)<br>
                    <input type="radio" name="qst2" id="qst2" value="1">&nbsp;1&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst2" id="qst2" value="2">&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst2" id="qst2" value="3">&nbsp;3&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst2" id="qst2" value="4">&nbsp;4&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst2" id="qst2" value="5">&nbsp;5&nbsp;&nbsp;&nbsp;&nbsp;
                    <br>
                    Qualidade na exibição dos vídeos<br>
                    <input type="radio" name="qst3" id="qst3" value="1">&nbsp;1&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst3" id="qst3" value="2">&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst3" id="qst3" value="3">&nbsp;3&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst3" id="qst3" value="4">&nbsp;4&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst3" id="qst3" value="5">&nbsp;5&nbsp;&nbsp;&nbsp;&nbsp;
                    <br>
                    Aparência e design<br>
                    <input type="radio" name="qst4" id="qst4" value="1">&nbsp;1&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst4" id="qst4" value="2">&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst4" id="qst4" value="3">&nbsp;3&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst4" id="qst4" value="4">&nbsp;4&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst4" id="qst4" value="5">&nbsp;5&nbsp;&nbsp;&nbsp;&nbsp;
                    <br>
                    <br>
                    <b>2 – Você indicaria o Brasil Jurídico aos seus amigos?</b>
                    <br>
                    <input type="radio" name="qst5" id="qst5" value="1">&nbsp;Sim&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="qst5" id="qst5" value="0">&nbsp;Não&nbsp;&nbsp;&nbsp;&nbsp;
                    <br>
                    <br>
                    <b>3 - Qual a sua opinião a respeito da nossa plataforma? Deixe aqui suas sugestões e críticas.</b>
                    {!! Form::textarea('qst6', null, ['class' => 'form-control', 'rows' => '4' ]) !!}
                    <br>
                    {!! Form::submit('Enviar a minha opinião', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                    <br>
                    {!! Form::open(['route' => ['frontend.profile.dont_answer_survey'], 'id' => 'dont_answer_survey_form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) !!}
                    <input type="hidden" name="survey" id="survey" value="1">
                    {!! Form::submit('Não desejo enviar a minha opinião', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
