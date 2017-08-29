@extends('frontend.layouts.master-classroom')

@section('content')
<section role="main" class="content-body">

    <header class="page-header">
        <h2>MEUS SAAP's</h2>

        <!--div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Painel</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div-->
    </header>

    @if (count($exams) === 0)
    @if (($selectedtag == null) || ($selectedtag == "") || ($selectedtag == "-") )
    <div id="my-courses" class="container">
        <h3>Você ainda não adquiriu nenhum SAAP. <!--a href="/" style="text-decoration: underline;">Acesse a nossa loja.</a--></h3>
    </div>
    @endif
    @endif

    <!-- start: page -->
    <div id="my-courses" class="container">
        @if (count($tags) != 0)
        <div class="row" >
            <div class="col-md-4" style="background-color: #1E376D; padding: 10px; margin-left: 15px;margin-right: 15px;">
                
                <form method="get" action="{{ Route('frontend.exams')  }}" style="">
                    <div class="col-md-9 "  >
                        <select name="cat" id="cat" class="form-control">
                            <option value="-">Todos os SAAPs</option>
                            @foreach($tags as $tag => $count)
                            @if ($tag !== "")
                            <option value="{{ $tag }}" {{ $tag == $selectedtag ? "selected" : "" }}>{{ $tag }} [{{$count}}]</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 "  >
                        <button type="submit" class="btn btn-primary btn-block"  style="background-color: #4d71af;"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- start: page -->
        @if (count($exams) != 0)
        <div class="row">
            @foreach($exams as $exam)
            {{--*/  $best = get_best_result($exam) /*--}}
            {{--*/ $teacher = $exam->exam->teacherMessage /*--}}
            @if ($teacher === null)
            {{--*/ $teacher = App\User::findOrNew(210) /*--}}
            @endif
            <div class="col-md-4 col-sm-6">

                <div class="card card-fixed" style="padding:0">
                    <div class="card-image">
                        <img class="img-responsive" src="{{ imageurl("exams/", $exam->exam->id, $exam->exam->classroom_img, 0, 'saap_home.png',true) }}">
                    </div>
                    <div class="row">
                        <div class="fotoautor">
                            <div class="card-user">
                                <img class="img-responsive userpic" src="{{ imageurl('users/', $teacher->id, $teacher->photo, 100, 'generic.png',true) }}">
                            </div>
                        </div>
                        @if ($best != null)
                        <div class="fraseautor">
                            <div class="card-content">
                                <p><span class="label-big @if( (($best->grade * 100)/ $exam->exam->questions_count)  >= $exam->exam->minimum_percentage )
                                         label-success
                                         @else
                                         label-danger" style="background-color: #e02612 !important; border-color: #d72411; @endif"> @if( (($best->grade * 100)/ $exam->exam->questions_count)  >= $exam->exam->minimum_percentage )
                                        ÓTIMA PERFORMANCE
                                        @else
                                        PRECISA MELHORAR!
                                        @endif</span></p>
                            </div>
                        </div>
                        @else
                        <div class="fraseautor">
                            <div class="card-content">
                                <p><span class="label-big label-info">COMECE AGORA!</span></p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h4 class="text-center" style="height: 50px; padding-left: 20px; padding-right: 20px;">SAAP | {{ str_limit($exam->exam->title, 80) }} </h4>
                        <p class="text-center" style="height: 20px;">@if ($best != null)
                            <a href="/exam/result/{{ $best->id  }}">
                                <span class="label label-md @if( (($best->grade * 100)/ $exam->exam->questions_count)  >= $exam->exam->minimum_percentage )
                                      label-success
                                      @else
                                      label-danger
                                      @endif">{{ number_format($best->grade * 100 / $exam->exam->questions_count,0)  }}%</span>
                                &nbsp;&nbsp;<span class="font-green-jungle">
                                    <i class="fa fa-check"></i><strong> {{ number_format($best->grade,0) }}</strong> acertos</span>
                                &nbsp;
                                <span class="font-red-flamingo">
                                    <i class="fa fa-close"></i> {{ number_format($exam->exam->questions_count - $best->grade, 0) }} erros</span>
                            </a>
                            @else
                            &nbsp;
                            @endif</p>

                        <ul class="mt-body-stats text-center">
                            <li class="font-grey-gallery">
                                <i class="fa fa-pencil-square-o"></i> {{$attempt =  get_attempted($exam) }}/{{$exam->exam_max_tries}}</li>
                            <li class="font-grey-gallery">
                                <i class="fa fa-hourglass-3"></i> Concluir em até <strong>{{ Carbon\Carbon::now()->diffInDays( Carbon\Carbon::parse($exam->date_end) ) }} dias</strong></li>
                        </ul>

                        <a class="btn default btn-block" href="/exam/intro/{{ $exam->id  }}">PAINEL DO SAAP</a>



                        @if(!is_exam_tries_over($exam))

                        @if($exam->executions->whereLoose('finished',0)->isEmpty() || $exam->executions->whereLoose('finished',0)->first()->simulation_mode == 1)

                        <a class="btn blue-steel btn-block exam-begin" data-enrollment="{{ $exam->id }}" data-first-time="{{ $attempt }}" href="/exam/intro/{{ $exam->id  }}">INICIE O SAAP</a>
                        @else


                        <a class="btn blue-steel btn-block" href="/exam/{{ $exam->id  }}">CONTINUE - QUESTÃO @if($exam->executions->whereLoose('finished',0)->first()->last_question_execution != null){{ $exam->executions->whereLoose('finished',0)->first()->last_question_execution->order + 1}} @else 1 @endif</a>
                        @endif
                        @else

                        @if($exam->order != null && !$exam->order->packages->isEmpty())
                        <a type="button" href="{{ $exam->order != null ? route('packages.show',[$exam->order->packages->filter(function($item)use($exam){ return !$item->package->exams->where('exam_id',$exam->exam_id)->isEmpty(); })->first()->package->slug ]) : "#" }}" class="btn blue-steel btn-block buy-exam">ADQUIRIR O PACOTE NOVAMENTE</a>
                        @else
                        <a type="button" href="/exam/result/{{ $best->id  }}" class="btn blue-steel btn-block buy-exam">MELHOR RESULTADO</a>
                        @endif
                        @endif
                    </div>
                </div><!-- /.card -->
            </div><!-- /.col -->
            @endforeach
        </div>
        @endif
    </div>

    @if (count($expireds) != 0)
    <div id="my-exams" class="container">
        <hr>
        <h1 style="color:black"><strong>| SAAPs</strong> Encerrados</h1>
        <div class="row">
            @foreach($expireds as $exam)
            {{--*/  $best = get_best_result($exam) /*--}}
            {{--*/ $teacher = $exam->exam->teacherMessage /*--}}
            @if ($teacher === null)
            {{--*/ $teacher = App\User::findOrNew(210) /*--}}
            @endif
            <div class="col-md-4 col-sm-6">

                <div class="card card-fixed" style="padding:0">
                    <div class="card-image">
                        <img class="img-responsive" src="{{ imageurl("exams/", $exam->exam->id, $exam->exam->classroom_img, 0, 'saap_home.png',true) }}">
                    </div>
                    <div class="row">
                        <div class="fotoautor">
                            <div class="card-user">
                                <img class="img-responsive userpic" src="{{ imageurl('users/', $teacher->id, $teacher->photo, 100, 'generic.png',true) }}">
                            </div>
                        </div>
                        @if ($best != null)
                        <div class="fraseautor">
                            <div class="card-content">
                                <p><span class="label-big @if( (($best->grade * 100)/ $exam->exam->questions_count)  >= $exam->exam->minimum_percentage )
                                         label-success
                                         @else
                                         label-danger" style="background-color: #e02612 !important; border-color: #d72411; @endif"> @if( (($best->grade * 100)/ $exam->exam->questions_count)  >= $exam->exam->minimum_percentage )
                                        ÓTIMA PERFORMANCE
                                        @else
                                        PRECISA MELHORAR!
                                        @endif</span></p>
                            </div>
                        </div>
                        @else
                        <div class="fraseautor">
                            <div class="card-content">
                                <p><span class="label-big label-info">COMECE AGORA!</span></p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h4 class="text-center" style="height: 50px; padding-left: 20px; padding-right: 20px;">SAAP | {{ str_limit($exam->exam->title, 80) }} </h4>
                        <p class="text-center" style="height: 20px;">@if ($best != null)
                            <a href="/exam/result/{{ $best->id  }}">
                                <span class="label label-md @if( (($best->grade * 100)/ $exam->exam->questions_count)  >= $exam->exam->minimum_percentage )
                                      label-success
                                      @else
                                      label-danger
                                      @endif">{{ number_format($best->grade * 100 / $exam->exam->questions_count,0)  }}%</span>
                                &nbsp;&nbsp;<span class="font-green-jungle">
                                    <i class="fa fa-check"></i><strong> {{ number_format($best->grade,0) }}</strong> acertos</span>
                                &nbsp;
                                <span class="font-red-flamingo">
                                    <i class="fa fa-close"></i> {{ number_format($exam->exam->questions_count - $best->grade, 0) }} erros</span>
                            </a>
                            @else
                            &nbsp;
                            @endif</p>

                        <ul class="mt-body-stats text-center">
                            <li class="font-grey-gallery">
                                <i class="fa fa-pencil-square-o"></i> {{$attempt =  get_attempted($exam) }}/{{$exam->exam_max_tries}}</li>
                            <li class="font-grey-gallery">
                                <i class="fa fa-hourglass-3"></i> Encerrado</li>
                        </ul>

                        <a class="btn default btn-block" href="/exam/intro/{{ $exam->id  }}">PAINEL DO SAAP</a>

                        {{--<a type="button" href="{{ $exam->order != null ? route('packages.show',[$exam->order->packages->filter(function($item)use($exam){ return !$item->package->exams->where('exam_id',$exam->exam_id)->isEmpty(); })->first()->package->slug ]) : "#" }}" class="btn blue-steel btn-block buy-exam">ADQUIRIR O PACOTE NOVAMENTE</a>--}}
                    </div>
                </div><!-- /.card -->
            </div><!-- /.col -->
            @endforeach
        </div>
    </div>
    @endif

    <div class='clearfix'></div>


    <div class="modal fade" id="courseContentModal" tabindex="-1" role="dialog" >
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="courseContentLabel"></h4>
                </div>
                <div id="courseContentWait" style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div>
                <div id="courseContentDiv" style="padding: 20px; font-size: 1.5rem;">
                </div>
            </div>
        </div>
    </div>

    <!-- end: page -->
</section>

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
                                <a  type="button"  id="assisted-mode" class="mt-xs mr-xs btn btn-primary" style="border-color: #32C6D2;background-color:#32C6D4; width:100%; font-size: 1.7rem;">Iniciar SAAP Modo Comentado</a>
                            </div>
                            <div class="col-md-6">
                                <br/>
                                <a type="button" id="simulation-mode" class="mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;">Iniciar SAAP Modo Prova</a>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection