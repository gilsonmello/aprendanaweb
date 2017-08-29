@extends('frontend.layouts.master-classroom')

@section('content')

    <section role="main" class="content-body">
        <header class="page-header">
            <div class='row'>
                <div class="col-md-12">
                    <h2><img alt="" src="/img/system/saap2.png" style="width: 100px; margin-top: -10px;"><strong style="padding-left: 20px;">SISTEMA DE APRENDIZAGEM DE ALTA PERFORMANCE</strong>
                </h2>
                </div>
            </div>
        </header>


        <!-- start: page -->



        <section id="exam-panel" class="panel" data-display-explanation="{{ $exam->display_explanation }}">

            <div class="col-md-10 centered">
                <div class="row margin-bottom-40"><h1 style="color:black"><strong>| SAAP</strong> {{ $exam->title }} </h1></div>

                <div class="row" >
                    <div class="col-md-6">
                        <div class="card" style="font-size: 1.7rem; height: 400px;">
                            <img class="img-responsive"  src="/img/system/saap.png" class="pull-center">
                            <br>
                            {{--{!! $exam->description !!}--}}
                            O SAAP é um sistema de aprendizagem de alta performance que alia conteúdo de excelência e análise de dados,  proporcionando o direcionamento do estudo do nosso aluno. A partir do Análise 360º,  nossa equipe especializada oferece um mapeamento minucioso da incidência dos temas mais recorrentes nas provas aplicadas em concursos e Exames da OAB, possibilitando aos candidatos e examinandos que otimizem seu tempo de estudo com o máximo de aproveitamento.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="marginVideo">
                            @if($exam->video_frag->vendor == 'youtube')
                                <iframe width="100%" height="200"
                                        src="https://www.youtube.com/embed/{{ $exam->video_frag->id }}">
                                </iframe>
                            @endif
                            @if($exam->video_frag->vendor == 'vimeo')
                                <iframe src="https://player.vimeo.com/video/{{ $exam->video_frag->id }}?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                                        width="100%" height="400" frameborder="0"
                                        webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                                </iframe>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($executions = $enrollment->executions->sortBy('attempt'))@endif
                @if (count($executions) != 0)
                    <div class="row margin-bottom-40 " ><h1 style="color:black"><strong>| SAAP</strong> Resultados anteriores</h1></div>
                    <div class="row previous-results-row margin-bottom-40">
                        @foreach( $executions->slice(-4, 4) as $exec_attempt)
                            <a href="/exam/result/{{ $exec_attempt->id  }}">
                                <div class="col-lg-3 col-md-6">
                                    <div class="card  text-center">
                                        <h4>@if($exec_attempt->finished == 1 || $exec_attempt->simulation_mode == 1) {{$exec_attempt->attempt}}º EXECUÇÃO - @if($exec_attempt->finished == 1){{ format_datebr($exec_attempt->finished_at) }}@else {{ format_datebr($exec_attempt->created_at) }} @endif @else  RESULTADO <br class="force-break"/>PARCIAL  @endif</h4>
                                        @if($result_rights = ($exec_attempt->grade != null ? $exec_attempt->grade : get_partial_rights($exec_attempt)))@endif
                                        <h4 style="font-size: 3.4rem;" class="@if(abs(($result_rights * 100)/ get_questions_count($enrollment->exam)) >= 70 )
                                                font-green-jungle
                                        @else
                                                font-red-flamingo
                                        @endif">
                                            <div class="result-graph" data-result="{{ ($result_rights * 100)/ get_questions_count($enrollment->exam),0  }}">
                                                <canvas width="100" height="100" class="intro-result-graph"></canvas>
                                            </div>

                                        </h4>
                                        @if($attempt_time = get_questions_time($exec_attempt))@endif
                                        <h5> {{str_pad(  ($hours = floor($attempt_time / 3600)),2,'0',STR_PAD_LEFT) }}h {{ str_pad(($minutes = floor(($attempt_time - ($hours * 3600)) / 60)),2,'0',STR_PAD_LEFT) }}m </h5>
                                        <h5><i class="fa fa-check font-green-jungle"></i><span class="font-green-jungle">&nbsp;&nbsp;{{ number_format($result_rights, 0)}} ACERTOS</span>
                                            /
                                            @if($exec_attempt->finished == 1)
                                            <i class="fa fa-close font-red-flamingo"></i><span class="font-red-flamingo">&nbsp;&nbsp;{{ number_format($exam->questions_count - $result_rights, 0) }} ERROS</span></h5>
                                            @else
                                            <i class="fa fa-close font-red-flamingo"></i><span class="font-red-flamingo">&nbsp;&nbsp;{{ number_format($exec_attempt->questions_executions->reject(function($item){return $item->grade === null;})->count() - $result_rights, 0) }} ERROS</span></h5>

                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif



                {{--<div class="row margin-bottom-40"><h1><strong>| SAAP</strong> Revolucionando sua performance</h1></div>--}}
                {{--<div class="row margin-bottom-40">--}}
                {{--<div class="col-lg-3 col-md-6">--}}
                {{--<div class="card">--}}
                {{--<div class="card-icon">--}}
                {{--<i class="fa fa-line-chart fa-lg saap-intro-icons"></i>--}}
                {{--</div>--}}
                {{--<div class="card-title">--}}
                {{--<span> Foco em desempenho </span>--}}
                {{--</div>--}}
                {{--<div class="card-desc">--}}
                {{--<span> Relatório completo de desempenho mostrando pontos que precisam de mais atenção </span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-3 col-md-6">--}}
                {{--<div class="card">--}}
                {{--<div class="card-icon">--}}
                {{--<i class="fa fa-trophy fa-lg saap-intro-icons"></i>--}}
                {{--</div>--}}
                {{--<div class="card-title">--}}
                {{--<span> Avalie sua performance </span>--}}
                {{--</div>--}}
                {{--<div class="card-desc">--}}
                {{--<span> Ferramenta completa de aferição de performance para a sua aprovação </span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-3 col-md-6">--}}
                {{--<div class="card">--}}
                {{--<div class="card-icon">--}}
                {{--<i class="fa fa-refresh fa-lg saap-intro-icons"></i>--}}
                {{--</div>--}}
                {{--<div class="card-title">--}}
                {{--<span> Análise 360º </span>--}}
                {{--</div>--}}
                {{--<div class="card-desc">--}}
                {{--<span> Uma análise completa sobre o concurso--}}
                {{--que lhe permite saber exatamente quanto performar </span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-3 col-md-6">--}}
                {{--<div class="card">--}}
                {{--<div class="card-icon">--}}
                {{--<i class="fa fa-book fa-lg saap-intro-icons"></i>--}}
                {{--</div>--}}
                {{--<div class="card-title">--}}
                {{--<span> Indicação de conteúdo </span>--}}
                {{--</div>--}}
                {{--<div class="card-desc">--}}
                {{--<span> Indicação de conteúdo complementar para potencializar seu desempenho  </span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}

                <div class="row margin-bottom-40"><h1 style="color:black"><strong>| SAAP</strong> Informações </h1>

                <div class="col-md-6" style="padding-top: 10px; ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" style="padding-top: 15px; height: 210px; ">
                                <div class="card-content  text-center">
                                    <p style="font-size: 3.6rem; color: #456D8C; padding-bottom: 10px;"><i class="fa fa-list-ol"></i></p>
                                    <br>
                                    <p class="font-blue-soft" style="font-size: 4.2rem;  padding-bottom: 10px;" data-counter="counterup" data-value="{{ $exam->questions_count }}">0</p>

                                    <br>
                                    <p style="font-size: 1.5rem;">QUESTÕES</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" style="padding-top: 15px; height: 210px;  ">
                                <div class="card-content  text-center">
                                    <p style="font-size: 3.6rem; color: #456D8C;padding-bottom: 10px;"><i class="fa fa-pencil-square-o"></i></p>
                                    <br>
                                    <p class="font-blue-soft" style="font-size: 4.2rem;padding-bottom: 10px;"data-counter="counterup" data-value="{{$enrollment->exam->max_tries}}">0</p>
                                    <br>
                                    <p style="font-size: 1.5rem;">EXECUÇÕES</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6" style="padding: 10px;">
                            <div class="card" style="padding: 10px; padding-top: 15px; height: 210px;  ">
                                <div class="card-content  text-center">
                                    <p style="font-size: 3.6rem; color: #456D8C;padding-bottom: 10px;"><i class="fa fa-hourglass-o"></i>&nbsp;<i class="fa fa-list-ol"></i></p>
                                    <br>
                                    <span class="font-blue-soft" style="font-size: 4.2rem;padding-bottom: 10px;" data-counter="counterup" data-value="{{  $minutes = floor($exam->duration / $exam->questions_count) }}">0</span>
                                    <small class="font-blue-soft" style="font-size: 4.2rem;padding-bottom: 10px;" class="font-red-flamingo" style="text-transform: lowercase; !important">m</small>
                                    <span class="font-blue-soft" style="font-size: 4.2rem;padding-bottom: 10px;" data-counter="counterup" data-value=" {{ $seconds = floor((($exam->duration / $exam->questions_count) - $minutes ) * 60) }}">0</span>
                                    <small class="font-blue-soft" style="font-size: 4.2rem;padding-bottom: 10px;" class="font-red-flamingo" style="text-transform: lowercase; !important">s</small>
                                    <br>
                                    <br>
                                    <p style="font-size: 1.5rem;">TEMPO MÉDIO POR QUESTÃO</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" style="padding: 10px;">
                            <div class="card" style="padding: 10px; padding-top: 15px; height: 210px;  ">
                                <div class="card-content  text-center">
                                    <p style="font-size: 3.6rem; color: #456D8C;padding-bottom: 10px;"><i class="fa fa-hourglass-o"></i>&nbsp;<i class="fa fa-file-o"></i></p>
                                    <br>
                                    <span class="font-blue-soft" style="font-size: 4.2rem;padding-bottom: 10px;" data-counter="counterup" data-value="{{  $hour = floor($exam->duration / 60) }}">0</span>
                                    <small class="font-blue-soft" style="font-size: 4.2rem;padding-bottom: 10px;" class="font-red-flamingo" style="text-transform: lowercase; !important">h</small>
                                    <span class="font-blue-soft" style="font-size: 4.2rem;padding-bottom: 10px;" data-counter="counterup" data-value=" {{ $minutes = floor($exam->duration - ($hour * 60)) }}">0</span>
                                    <small class="font-blue-soft" style="font-size: 4.2rem;padding-bottom: 10px;" class="font-red-flamingo" style="text-transform: lowercase; !important">m</small>
                                    <br>
                                    <br>
                                    <p style="font-size: 1.5rem;">TEMPO TOTAL DE RESOLUÇÃO</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6" style="padding-top: 10px;">
                    <div class="card" style="padding-top: 15px; height: 450px;  ">
                        <div class="card-content  text-center">
                            <div class="row">
                                <br>
                                <div class="col-md-12 text-left" style="padding-left: 30px;">
                                    <div class="container best-graph" style="padding: 0px; width: 200px; height: 200px;" width="200" height="200" data-questions-count="{{ $exam->questions_count }}" data-best="{{ $exam->questions_count * $exam->minimum_percentage / 100 }}">
                                        <canvas id="exam-{{ $exam->id }}" class="best-result-graph" width="200" height="200"  style="width: 200px; height: 200px; " ></canvas>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center" style="font-size: 1.8rem; padding-left: 20px; padding-top: 20px;">
                                    <br><br>
                                    <i class="fa fa-check" style="color: green"></i>&nbsp;&nbsp;<span class="font-green-jungle">{{ number_format($exam->questions_count * $exam->minimum_percentage / 100, 1) + 0}} ACERTOS</span>
                                    &nbsp;&nbsp;
                                    <i class="fa fa-close" style="color: red"></i>&nbsp;&nbsp;<span class="font-red-flamingo">{{ number_format($exam->questions_count - ($exam->questions_count * $exam->minimum_percentage / 100), 1) + 0}} ERROS</span>
                                    <br>
                                </div>
                            </div>
                            <br>
                            <br>
                            <p style="font-size: 1.5rem; ">DESEMPENHO ESPERADO DE <br>ACORDO  COM O ANÁLISE 360º</p>
                        </div>
                    </div>
                </div>
                <div class='clearfix'></div>
                <div class="row" style="margin-top: 20px; padding: 10px;">
                    <div class="col-md-6">
                        @if (($exam->required_reading != null) && ($exam->required_reading != ''))
                            <div class="col-md-12 col-lg-12" style="padding-bottom: 10px;">
                                <a type="button" href="javascript:showExamNote( '{!! $exam->id !!}', 'R', 'Leitura Essencial' );" class="btn btn-block grey-mint" ><i class="fa fa-book">&nbsp;&nbsp;</i>LEITURA ESSENCIAL</a>
                            </div>
                        @endif
                        @if (($exam->additional_reading != null) && ($exam->additional_reading != ''))
                            <div class="col-md-12 col-lg-12" style="padding-bottom: 10px;">
                                <a type="button" href="javascript:showExamNote( '{!! $exam->id !!}', 'A', 'Bibliografia Recomendada' );" onclick="" class="btn btn-block grey-mint "><i class="fa fa-book"></i>&nbsp;&nbsp;BIBLIOGRAFIA RECOMENDADA</a>
                            </div>
                        @endif
                        @if (($exam->note1 != null) && ($exam->note1 != ''))
                            <div class="col-md-12 col-lg-12" style="padding-bottom: 10px;">
                                <a type="button" href="javascript:showExamNote( '{!! $exam->id !!}', '1', 'Jurisprudência Correlata' );" class="btn grey-mint btn-block" ><i class="fa fa-book"></i>&nbsp;&nbsp;JURISPRUDÊNCIA CORRELATA</a>
                            </div>
                        @endif
                        @if (($exam->note2 != null) && ($exam->note2 != ''))
                            <div class="col-md-12 col-lg-12" style="padding-bottom: 10px;">
                                <a type="button" href="javascript:showExamNote( '{!! $exam->id !!}', '2', 'Legislação Correlata' );" class="btn grey-mint btn-block" ><i class="fa fa-book"></i>&nbsp;&nbsp;LEGISLAÇÃO CORRELATA</a>
                            </div>
                        @endif
                        @if (($exam->note3 != null) && ($exam->note3 != ''))
                            <div class="col-md-12 col-lg-12" style="padding-bottom: 10px;">
                                <a type="button" href="javascript:showExamNote( '{!! $exam->id !!}', '3', 'Informativos' );" class="btn grey-mint btn-block" ><i class="fa fa-book"></i>&nbsp;&nbsp;INFORMATIVOS</a>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6" >
                        @if (( $exam->analysis != null) && ( $exam->analysis != ''))
                            <div class="col-md-12" style="padding-bottom: 10px;">
                                <a type="button" href="{{ route('frontend.classroom.analysis', $enrollment->id ) }}" class="btn green-jungle btn-block"  ><i class="fa fa-circle-o-notch"></i>&nbsp;&nbsp;ANÁLISE 360º</a>
                            </div>
                        @endif
                        <div class="col-md-12" style="padding-bottom: 10px;">

                            @if (Carbon\Carbon::now() < Carbon\Carbon::parse( $enrollment->date_end ))
                                @if(!is_exam_tries_over($enrollment))
                                    <a id='start-exam' type="button" data-order='{{ $order }}' href="{{ route('frontend.exam',['id' => $enrollment->id]) }}" class="btn blue-steel btn-block"><i class="fa fa-pencil-square-o">&nbsp;&nbsp;</i>@if($order > 1) CONTINUAR @else INICIAR @endif O SAAP AGORA - {{ $order }}<SUP>a</SUP> QUESTÃO</a>
                                @else
                                    <a id='buy-exam' type="button" data-order='{{ $order }}' href="{{ $exam->order != null ? route('packages.show',[$exam->order->packages->filter(function($item)use($exam){ return !$item->package->exams->where('exam_id',$exam->exam_id)->isEmpty(); })->first()->package->slug ]) : "#" }}" class="btn blue-steel btn-block">ADQUIRIR O PACOTE NOVAMENTE</a>
                                @endif
                            @endif

                        </div>
                        @if($countnote > 0)
                            <div class="col-md-12">
                                <a type="button" target="_blank" href="{{ route('frontend.exam.export-notes', $enrollment->id ) }}" class="btn green-jungle btn-block"  ><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;EXPORTAR ANOTAÇÕES</a>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="row" style="margin-top: -10px; padding: 10px;">
                </div>

                <div class="modal fade" id="displayModal" tabindex="-1" role="dialog" aria-labelledby="displayModalLabel">
                    <div class="modal-dialog" role="document" style="width: 60%;">
                        <div class="modal-content">
                            <div class="modal-body" style="padding-bottom: 0px; padding-top: 3px ">

                                <div id="choice-message">
                                    <div id="card-row" class="row" style="padding:20px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card-title" style="color:#32C6D4; font-size:2rem">SAAP MODO <strong>COMENTADO</strong></div><br/>
                                                <p>O Modo Comentado é direcionado a quem deseja fazer um estudo detalhado de cada questão, podendo, ao mesmo tempo, contar com todas as ferramentas do SAAP para a execução completa do simulador.</p>
                                                <p>No Modo Comentado o aluno terá acesso aos comentários dos professores logo após responder a questão. Tendo acertado ou errado, o vídeo ou áudio será apresentado com os comentários da questão assim que a alternativa for marcada.</p>
                                                <p>Será possível assistir aos comentários por até duas vezes, fazer as anotações desejadas, bem como interromper o SAAP a qualquer momento e retornar ao ponto em que parou quantas vezes quiser. Lembrando que haverá um prazo para concluir o simulador a depender de cada SAAP.</p>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card-title" style="color:#4B77BE; font-size:2rem">SAAP MODO <strong>PROVA</strong></div>
                                                <br/>
                                                <p>O Modo Prova permite simular o tempo real de prova promovendo uma experiência semelhante à prova que irá realizar.</p>
                                                <p>No Modo Prova, somente após concluir todo o simulado, respondendo a todas as questões, o aluno terá acesso aos comentários dos professores. Assim, será necessário responder todas as questões, marcando suas alternativas, para ao final do simulador ter acesso as respostas correlatas e comentários dos professores.</p>
                                                <p>No SAAP Modo Prova será possível alterar as respostas das questões já marcadas. Aquelas questões que não forem respondidas, seja pelo esgotamento do tempo, seja pela finalização do SAAP pelo aluno, serão computadas como erro.</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <br/>
                                                <a  type="button"  href="{{ route('frontend.exam',['id' => $enrollment->id]) }}" class="mt-xs mr-xs btn btn-primary" style="border-color: #32C6D2;background-color:#32C6D4; width:100%; font-size: 1.7rem;">Iniciar SAAP Modo Comentado</a>
                                            </div>
                                            <div class="col-md-6">
                                                <br/>
                                                <a type="button"  href="{{ route('frontend.exam',['id' => $enrollment->id, 'simulation' => 1]) }}" class="mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;">Iniciar SAAP Modo Prova</a>
                                            </div>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="examContentModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="examContentLabel"></h4>
                    </div>
                    <div id="examContentWait" style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div>
                    <div id="examContentDiv" style="padding: 20px; font-size: 1.5rem;">
                    </div>
                </div>
            </div>
        </div>
        </class>
    </section>
@endsection