<section role="main" class="content-body">
    <section class="panel">


        <div class="row">
            <div class="col-md-12" id="blade-question" >



                <section id="exam-panel" class="panel panel-warning no-border-radius panel-exam" data-not-answered="{{ $count }}" data-execution-id="{{ $question_exec->execution->id }}" data-display-explanation="{{ $question_exec->execution->display_explanation }}">

                    <div class="panel-body" style="padding:0; padding-bottom: 10px;">
                        <div id="question-wait" style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div>
                        <div id="exam-presentation">
                            @include('frontend.studentarea.classroom.exam.question')
                        </div>
                        <div id="exam-notes" style="display:none">
                        </div>

                        <br/>
                        <div class="row">
                            <div class="col-md-5" >{!!  Form::button('Responder',['id' => 'confirmation', 'class' => 'no-border-radius mb-xs mt-xs mr-xs btn btn-success button-answer']) !!}</div>
                            <div class="col-md-7 text-right pull-right" style="text-align: right; padding-right: 30px;" id="divButtonJump">


                            <div class="btn-group mb-xs mt-xs mr-xs" role="group" aria-label="...">
                                <button class="btn btn-default" id="jumpback" data-toggle="tooltip" title="Ir para a questão anterior" type="button" ><strong> <i class="fa fa-chevron-left"></i> </strong></button>
                                <button class="btn btn-default" id="jumpto" data-toggle="tooltip" title="Ver questões" data="{{ $question_exec->execution->id }}" type="button"  > <strong><i class="fa fa-list"></i> </strong></button>
                                <button class="btn btn-default" id="jump" data-toggle="tooltip" title="Ir para a próxima questão" type="button"  ><strong> <i class="fa fa-chevron-right"></i>  </strong></button>
                            </div>
                                {!!  Form::button('Finalizar a prova',['id' => 'end', 'class' => 'no-border-radius mb-xs mt-xs mr-xs btn btn-danger button-end','data-toggle' => 'modal','data-target' => '#abandonModal']) !!}

                            </div>


                        </div>

                    </div>
                </section>
            </div>

            <div class="col-md-6">

                <section class="panel no-border-radius panel-exam" id="explanation" style="display:none; padding-top:1px;">
                    <header class="panel-heading no-border-radius" >
                        <h2 class="panel-title"></h2>
                    </header>
                    <div class="panel-body" style="padding:0;">
                        <div class="explanation">
                            <div id="explanation-teacher" style='padding: 20px; border-bottom: 1px solid #DDD;'></div>
                            <div id="explanation-wait" style='padding: 20px;'><img src='/img/system/wait.gif' border='0'></div>
                            <div id="explanation-result"></div>
                            <iframe width="100%" id="explanation-content" height="400" src="" frameborder="0" allowfullscreen>&nbsp;</iframe>
                            <div id="explanation-text" style="padding: 20px;"></div>
                            <div id="explanation-summary" style="display:none"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>


<div class="modal fade" id="abandonModal" tabindex="-1" role="dialog" aria-labelledby="abandonModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="abandonModalLabel" style="color: #08C">Deseja finalizar o SAAP?</h4>
            </div>
            <div class="modal-body">

                <div id="choice-message">
                    <div class="row">
                        <div class="col-md-12">
                            @if (isset($exam) && ($exam->finish_message != null) && ($exam->finish_message != ""))
                                {{finish_message}}
                                <br/>
                            @endif
                            <p>Todas as questões não respondidas serão deixadas em branco.</p>

                            <a  type="button" id="finish-exam"  class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;">Sim, desejo finalizar.</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a type="button" id="continue-exam" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;">Não, desejo continuar.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

