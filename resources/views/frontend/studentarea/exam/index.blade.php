@extends('frontend.layouts.master-classroom')

@section('meta')
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
@endsection


@section('content')

    <section role="main" class="content-body">
        <header class="page-header" style="height: 80px;">
            <div class="row" >
                <div class="col-md-8" style="">
                    <h2 style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">

                        @if(isset($exam))
                        {!!  $exam->title !!}
                        @else
                        {!! $course->title !!}
                        @endif
                    </h2>
                </div>
                <div class="col-md-4 margin-time-exam hidden-sm hidden-xs">

                        <div class="col-md-5">
                            <span class="tempoQuestao text-center">Tempo Questão</span>
                            <div id="crescent-time" data-crescent-time="{{ $question_exec != null && $question_exec->time != null ? $question_exec->time : 0 }}"  style="padding-top:10px; color: #5F6B6D; font-size:2.4rem; font-weight: bold;text-align: center; ">
                            </div>
                        </div>

                        <div class="col-md-7 text-right total-clock" style="padding-right:50px;" >
                            <div >
                                <canvas id="clock" width="40" height="40" style="display: inline-block; width: 50px; height: 60px;" ></canvas>


                                <div class="tempoQuestaoTotal">
                                    <span class="tempoQuestao">Tempo Total</span>
                                    <strong id="time" style="color:#1e376d !important;font-size:2.4rem; margin-top: 10px; display: block; "
                                            @if(isset($exam))
                                            data-time-type="{{ $exam->time_by_question != null ? "by-question" : "by-exam" }}" data-by-question="{{ $exam->time_by_question != null ? $exam->time_by_question : $exam->duration}}"
                                            @else
                                            data-time-type="by-exam" data-by-question="{{$time}}"
                                            @endif
                                            data-time="{{ $time }}"></strong>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </header>

        <!-- start: page -->

        <section class="panel">


                {{--<div class="row visible-xs visible-sm" style="background-color: #FFF; padding: 20px 0;margin: 10px 0;">--}}
                {{--<div class="col-xs-12 ">--}}
                    {{--<div class="col-xs-5">--}}
                        {{--<span class="tempoQuestao text-center">Tempo Questão</span>--}}
                        {{--<div id="crescent-time" data-crescent-time="{{ $question_exec->time != null ? $question_exec->time : 0 }}"  style="padding-top:10px; color: #5F6B6D; font-size:2.4rem; font-weight: bold;text-align: center; ">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col-xs-7 text-right"  >--}}
                        {{--<div >--}}


                            {{--<div class="tempoQuestaoTotal">--}}
                                {{--<span class="tempoQuestao">Tempo Total</span>--}}
                                {{--<strong id="time" style="color:#1e376d !important;font-size:2.4rem; margin-top: 10px; display: block; "  data-time-type="{{ $exam->time_by_question != null ? "by-question" : "by-exam" }}" data-by-question="{{ $exam->time_by_question != null ? $exam->time_by_question : $exam->duration}}" data-time="{{ $time }}"></strong>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                    {{--</div>--}}

            <div class="row">
                <div class="col-md-12" id="blade-question" >


                    @if($question_exec == null)


                        <section class="panel panel-warning no-border-radius">
                            <div>
                                <h3>
                                Esse SAAP está temporariamente indisponível.
                                </h3>
                            </div>
                        </section>
                        @else


                    <section id="exam-panel" class="panel panel-warning no-border-radius panel-exam" data-not-answered="{{ $question_exec->execution->questions_executions->reject(function($item){ return $item->grade !== null;})->count() }}" data-execution-id="{{ $question_exec->execution->id }}" data-simulation-mode="{{ $question_exec->execution->simulation_mode }}"  data-display-explanation="{{ $question_exec->execution->display_explanation }}">

                        <div class="panel-body" style="padding:0; padding-bottom: 10px;">
                            <div id="question-wait" style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div>
                            <div id="exam-presentation">
                            @include('frontend.studentarea.exam.question')
                            </div>
                            <div id="exam-notes" style="display:none">
                            </div>

                            <br/>
                            <div class="row">
                            <div class="col-md-5" style="padding-left:30px;">{!!  Form::button('Responder',['id' => 'confirmation', 'class' => 'no-border-radius mb-xs mt-xs mr-xs btn btn-success button-answer']) !!}</div>
                                <div class="col-md-7 text-right pull-right" style="text-align: right; padding-right: 30px;" id="divButtonJump">


                                        <div class="btn-group" role="group" aria-label="...">
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
            </div>
        @include('frontend.studentarea.exam.continue')

            <div class="modal fade" id="abandonModal" tabindex="-1" role="dialog" aria-labelledby="abandonModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

                                        <a  type="button" id="finish-exam" href="{{ route('frontend.completeResults',['id' => $question_exec->execution->id]) }}" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;">Sim, desejo finalizar.</a>
                                    </div>
                                </div>
                                @if($question_exec->execution->simulation_mode == 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a type="button" href="{{ route('frontend.completeResults',['id' => $question_exec->execution->id]) }}" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;">Sim, mas concluir posteriormente.</a>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <a type="button" data-dismiss="modal" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;">Não, desejo continuar.</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif



        </section>





        </div>



    </section>
    </div>
    </div>



@endsection