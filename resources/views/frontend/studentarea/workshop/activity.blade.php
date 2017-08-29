@extends('frontend.layouts.master-classroom')

@section('content')

<section role="main" class="content-body">





    <header class="page-header">
        <h2>{{ $activity->description }}</h2>
    </header>

    <!-- start: page -->
    <div class="page-content">
        <div class="container">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
            @endforeach

            <div class="page-content-inner">

                @if (($activity->active == 1) && ($activity->date_begin < Carbon\Carbon::today()) )
                {{--@if ($activity->evaluation_deadline < Carbon\Carbon::today())--}}
                {{--<strong style="color: darkblue;">{{ $activity->description }} - concluída</strong>--}}
                {{--@elseif ($activity->submit_deadline < Carbon\Carbon::today())--}}
                {{--<strong style="color: orange;">{{ $activity->description }} - período de correção</strong>--}}
                {{--@else--}}
                {{--<strong style="color: green;">{{ $activity->description }} - período de envio de resposta</strong>--}}
                {{--@endif--}}


                <div class="row" >
                    <div class="col-md-2">
                        <a class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" href="/classroom/workshops/{{ $enrollment->id  }}/{{ $activity->workshop->id  }}"></i>&nbsp;&nbsp;VOLTAR&nbsp;&nbsp;</a>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 20px; margin-top: 10px;">

                    <div class="col-lg-8 col-md-8">
                        <div class="card col-lg-12 col-md-12">
                            @if ($activity->submit_deadline >= Carbon\Carbon::today())
                            @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                            {!! Form::open(['route' => 'frontend.classroom.upload-activity', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}
                            {!! Form::hidden('enrollment_id', $enrollment->id, ['id' => 'enrollment_id']) !!}
                            {!! Form::hidden('activity_id', $activity->id, ['id' => 'activity_id']) !!}
                            <div style="height:0px;overflow:hidden">
                                <input type="file" id="response_document_{{ $activity->id }}" name="response_document_{{ $activity->id }}" onchange="javascript: this.form.submit();" />
                            </div>
                            {!! Form::close() !!}
                            @endif
                            @endif

                            <h3><strong>Enunciado</strong></h3>
                            @if (($activity->text != null) && ($activity->text !='' ))
                            {!! trim($activity->text) !!}
                            @else
                                Constando na Folha de Resposta.
                            <br>
                            @endif
                            <br>

                            @if (($activity->personal_evaluation == null) || ($activity->personal_evaluation == 0 ))
                                <p class="font-red-flamingo">
                                    <strong>Para esta atividade, não haverá correção individualizada, ou seja, não será feito o envio da resposta.</strong>
                                </p>
                                <br/>
                            @endif

                            @if(isset($wrong_filetype))
                            <p style="color: #c12720">Formato inválido. Só serão aceitas respostas no formato PDF.</p>
                            <br/>
                            @endif




                            <a type="button" target="_blank" href="{{$activity->url_document}}" class="btn grey-mint btn-lg" ></i>&nbsp;&nbsp;FOLHA DE RESPOSTA</a>
                            @if (count($activity->myactivity) != 0)
                            @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                            <a type="button" target="_blank" href="{{ $activity->myactivity[0]->url_document_activity }}" class="btn grey-mint btn-lg" ></i>&nbsp;&nbsp;MINHA RESPOSTA</a>
                            @endif
                            @endif
                            @if ($activity->submit_deadline >= Carbon\Carbon::today())
                            @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                            <button type="button" onclick="javascript:$('#response_document_{{ $activity->id }}').click();" class="btn grey-mint btn-lg" ></i>&nbsp;&nbsp;ENVIAR RESPOSTA</button>
                            @endif
                            @endif
                            @if (($activity->submit_deadline < Carbon\Carbon::today()) && ($activity->evaluation_deadline >= Carbon\Carbon::today()))

                            @if (count($activity->myactivity) !== 0)
                            @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                            <a type="button" target="_blank"  href="{{ route('frontend.classroom.export-workshop-protocol', $activity->myactivity[0]->id ) }}" class="btn grey-mint btn-lg" ></i>&nbsp;&nbsp;PROTOCOLO ENT.</a>
                            @endif
                            @endif
                            @endif

                        </div>

                        @if($activity->estimated_duration != null && $activity->submit_deadline >= Carbon\Carbon::today())
                        <div id="chronometer" data-activity="{{ $activity->id }}" data-enrollment="{{ $enrollment->id }}" data-active="0" class="row" style="padding-bottom: 30px">
                            <div class="col-lg-12 col-md-12">
                                <div class="card" style="min-height:230px">
                                    <div  id="chronometer-title" class="row">
                                        <div  class="col-md-12">
                                            <h3><strong>Cronometrar meu tempo</strong></h3>
                                            <h4>Tempo previsto para conclusão: {{ $activity->estimated_duration }} minutos</h4>
                                        </div>
                                    </div>
                                    <div id="chronometer-clock" class="row">
                                        <div  class="col-md-12 text-center">
                                            <canvas id="chrono-canvas" width="200" height="200" style="display: inline-block; width: 200px; height: 200px;" ></canvas>
                                        </div>
                                    </div>
                                    <div id="chronometer-time" data-incremental-time={{ $time != null ? parse_time_to_sec($time->time_spent) : 0 }} data-time="{{ $time != null ? parse_time_to_sec($time->time_left)  : $activity->estimated_duration * 60 }}" data-duration="{{ $activity->estimated_duration * 60 }}" class="row">
                                         <div  class="col-md-12 text-center" style="padding-bottom: 5px">
                                            @if($time == null)
                                            <h3 id="chrono-display" style="display: none;" >{{ parse_sec_to_time($activity->estimated_duration * 60) }}</h3>
                                            <h3 id="chrono-incremental-display"> 00:00:00</h3>
                                            @else
                                            <h3 id="chrono-display" style="display: none;" >{{ $time->time_left }}</h3>
                                            <h3 id="chrono-incremental-display">{{ $time->time_spent }}</h3>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="chronometer-buttons" class="row">
                                        <div class="col-md-6 text-right">
                                            <a id='chrono-button-pause' class="btn btn-danger"><i class="fa fa-pause"></i> Parar Relógio</a>
                                        </div>
                                        <div class="col-md-6 text-left">
                                            <a id='chrono-button-play' class="btn btn-success"><i class="fa fa-play"></i> Continuar Contagem</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif



                        @if ($activity->evaluation_deadline < Carbon\Carbon::today())
                        <div class="row">

                            @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                            <div class="col-lg-12 col-md-12">
                                <div class="card" >
                                    <h3><strong>Avaliação da minha atividade</strong></h3>

                                    @if (($activity->myevaluations != null) && (count($activity->myevaluations) !=0 ))

                                    @if (count($activity->myactivity) != 0)
                                    @if ($activity->myactivity[0]->reference == 1)
                                    <strong style="color: green;">Parabéns! A sua resposta foi considerada como referência pelo tutor!</strong>
                                    <br>
                                    <br>
                                    @endif
                                    @endif

                                    @foreach ( $activity->myevaluations as $myevaluation)
                                    @if (count($activity->workshop->criterias) > 1)
                                    <div class="row">
                                        <div class="col-md-2">{{ $myevaluation->criteria->description }}</div>
                                        <div class="col-md-1">{{ number_format( $myevaluation->grade, 2, ',', '.') }}</div>
                                    </div>
                                    <br>
                                    @endif
                                    @if (($activity->workshop->content != null) && ($activity->workshop->content != ''))
                                    <strong>Comentários do Tutor {{ (count($activity->workshop->criterias) > 1) ? " - " . $myevaluation->criteria->description : ""  }}</strong>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">{!! nl2br($myevaluation->evaluation)  !!}</div>
                                    </div>
                                    @endif
                                    <BR>
                                    @endforeach
                                    @foreach ( $activity->myevaluations as $myevaluation)
                                    @if (count($activity->workshop->criterias) > 0)
                                    @if (($myevaluation->url_evaluation != null) && ($myevaluation->url_evaluation != ''))
                                    <a type="button" target="_blank" href="{{ $myevaluation->url_evaluation }}" class="btn grey-mint btn-lg" ></i>&nbsp;&nbsp;BAIXAR CORREÇÃO {{ (count($activity->workshop->criterias) > 1) ? " - " . $myevaluation->criteria->description : ""  }}</a>
                                    @endif
                                    @endif
                                    @endforeach
                                    @else
                                    <strong>Não existe avaliação para esta atividade</strong>
                                    @endif
                                </div>
                            </div>

                            @endif
                            <div class="col-lg-12 col-md-12">
                                <div class="card" >
                                    <h3><strong>Comentários e Barema</strong></h3>
                                    @if (($activity->references != null) && (count($activity->references) !=0 ))
                                    <strong>Respostas de referência de outros alunos</strong>
                                    <br>
                                    @foreach ( $activity->references as $reference)
                                    <a href="{{$reference->url_document_activity}}" target="_blank">{{ $reference->enrollment->student->name }}</a>
                                    <br>
                                    @endforeach
                                    <br>
                                    @endif

                                    <br/>
                                    @if (($activity->explanation_url != null) && ($activity->explanation_url !='' ))
                                    <iframe width="100%" id="explanation-box" height="400" src="{{ $activity->explanation_url }}" frameborder="0" allowfullscreen>&nbsp;</iframe>
                                    @endif
                                    <br/>
                                    <br/>
                                    @if (($activity->text_response != null) && ($activity->text_response !='' ))
                                    {!! trim($activity->text_response) !!}
                                    @endif
                                    <br/>
                                    <br/>
                                    @if (($activity->url_response != null) && ($activity->url_response !='' ))
                                    <a type="button" target="_blank" href="{{$activity->url_response}}"  class="btn grey-mint btn-lg"></i>&nbsp;&nbsp;BAIXAR BAREMA</a>
                                    @endif
                                </div>
                            </div>



                        </div>
                        @endif
                        @if(!$activity->lessons->isEmpty())
                        <div class="col-lg-12 col-md-12">
                            <div class="card" >
                                <h3><strong>Aulas Associadas</strong></h3>
                                <table class="table table-hover mb-none" style="margin-top: 20px; font-size:1.6rem">
                                    <tbody>
                                        @foreach($activity->lessons as $lesson)
                                        <tr>
                                            <td width="50%">
                                                <a href="/classroom/{{ $lesson->module->course->id }}/{{ $lesson->module->id }}/{{ $lesson->id }}/1/{{ $enrollment->id }}">
                                                    {{ $lesson->module->name . '-'. $lesson->title .'- ' . ' Aula ' . $lesson->sequence }}
                                                </a>
                                            </td>

                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="row" >
                            <div class="col-lg-12 col-md-12">
                                @if (($activity->personal_evaluation == null) || ($activity->personal_evaluation == 0 ))
                                <div class="card text-center">
                                    <div >
                                        <h1><span class="font-red-flamingo"><strong>VÍDEO / BAREMA</strong></span></h1>
                                        <p> MODO DA CORREÇÃO</p>
                                    </div>
                                </div>
                                @else
                                <div class="card text-center">
                                    <div >
                                        <h1><span class="font-green-jungle"><strong>INDIVIDUALIZADA</strong></span></h1>
                                        <p> MODO DA CORREÇÃO</p>
                                    </div>
                                </div>
                                @endif


                                @if ($activity->submit_deadline >= Carbon\Carbon::today())
                                <div class="card text-center" >
                                    <div >
                                        <h1 class="font-green-jungle"><i class="fa fa-copy"></i>&nbsp;&nbsp;<strong>EM ANDAMENTO</strong></h1>
                                    </div>
                                </div>
                                @endif
                                @if (($activity->submit_deadline < Carbon\Carbon::today()) && ($activity->evaluation_deadline >= Carbon\Carbon::today()))
                                <div class="card text-center" >
                                    <div >
                                        <h1 class="font-red-flamingo"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;<strong>EM CORREÇÃO</strong></h1>
                                    </div>
                                </div>
                                @endif

                                @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                                @if ($activity->evaluation_deadline < Carbon\Carbon::today())
                                <div class="card text-center">
                                    <div >
                                        @if ($activity->grade >= $activity->minimum_grade)
                                        <h1 class="font-green-jungle"><i class="fa fa-thumbs-up font-green-jungle" ></i>&nbsp;&nbsp;<strong>{{ number_format( $activity->grade, 2, ',', '.') }}</strong></h1>
                                        @else
                                        <h1 class="font-red-flamingo"><i class="fa fa-thumbs-down font-red-flamingo" ></i>&nbsp;&nbsp;<strong>{{ number_format( $activity->grade, 2, ',', '.') }}</strong></h1>
                                        @endif
                                        <p> SUA NOTA NA ATIVIDADE  </p>
                                    </div>
                                </div>
                                @endif
                                @endif

                                @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                                <div class="card text-center">
                                    <div >
                                        <h1><i class="fa fa-check font-green-jungle"></i>&nbsp;&nbsp;<strong>{{ number_format( $activity->minimum_grade, 2, ',', '.') }}</strong></h1>
                                        <p> NOTA MÍNIMA ESPERADA  </p>
                                    </div>
                                </div>
                                @endif

                                @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                                <div class="card text-center" >
                                    <div>
                                        <h1 class="font-blue-soft"><i class="fa fa-calendar" ></i>&nbsp;&nbsp;<strong>{{format_datebr( $activity->submit_deadline )}}</strong></h1>
                                        <p> PRAZO PARA ENVIO DE RESPOSTA  </p>
                                    </div>

                                </div>
                                @endif

                                @if($activity->evaluation_deadline > Carbon\Carbon::today())
                                <div class="card text-center" >
                                    <div>
                                        <h1 class="font-red-flamingo"><i class="fa fa-calendar" ></i>&nbsp;&nbsp;<strong>{{format_datebr( $activity->evaluation_deadline )}}</strong></h1>
                                        <p> PRAZO PARA CORREÇÃO  </p>
                                    </div>
                                </div>
                                @else
                                <div class="card text-center" >
                                    <div>
                                        <h1 class="font-green-jungle"><i class="fa fa-calendar" ></i>&nbsp;&nbsp;<strong>{{format_datebr( $activity->evaluation_deadline )}}</strong></h1>
                                        <p> RESPOSTA DISPONÍVEL  </p>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>




            @endif
        </div>
    </div>
</div>
</section>
<!-- end: page -->
</section>
@endsection