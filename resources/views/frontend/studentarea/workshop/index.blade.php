@extends('frontend.layouts.master-classroom')

@section('content')

    @if (count($workshops) != 0)

        @foreach ($workshops as $workshop)
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>{{$workshop->description}}</h2>

                </header>

                <!-- start: page -->
                <div class="page-content">

                    <div class="container">
                        <div class="row" >
                            <div class="col-md-2">
                                <a class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" href="/classroom/course/{{$enrollment->id}}"></i>&nbsp;&nbsp;VOLTAR&nbsp;&nbsp;</a>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-md-6">
                                <div class="card" style="font-size: 1.7rem;">
                                    {!! $workshop->content !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                @if(count($workshop->coordinators) > 0)
                                    <div class="col-lg-12" >
                                        <div class="card">
                                            <h2>| Coordenadores</h2>
                                            @foreach($workshop->coordinators as $coordinator)
                                                <h4><img height="60"  src="{{ imageurl('users/',$coordinator->id, $coordinator->photo, 100, 'generic.png', true) }}" class="img-circle no-padding" data-lock-picture="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100) }}">
                                                    <strong>{{ $coordinator->name }}</strong>
                                                </h4>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12" >
                                    <div class="card">
                                        <h2>| Meu(s) tutor(es)</h2>
                                        @foreach($workshop->tutors as $tutor)
                                            <h4><img height="60"  src="{{ imageurl('users/',$tutor->id, $tutor->photo, 100, 'generic.png', true) }}" class="img-circle no-padding" data-lock-picture="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100) }}">
                                                <strong>{{ $tutor->name }}</strong>
                                            </h4>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-12" >
                                    <div class="portlet light">
                                        {{--<a type="button" href="" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;" ><i class="fa fa-question"></i>&nbsp;&nbsp;Tutoriais</a>--}}
                                        <a type="button" href="" class="mb-xs mt-xs mr-xs btn btn-primary" style="width:100%; font-size: 1.7rem;" data-toggle="modal" data-target="#addUser"><i class="fa fa-question"></i>&nbsp;&nbsp;Fale com o Professor</a>
                                        <a type="button" href="{{ route('frontend.classroom.analysis', $enrollment->id ) }}" class="mb-xs mt-xs mr-xs btn btn-primary green-jungle" style="width:100%; font-size: 1.7rem;" ><i class="fa fa-circle-o-notch"></i>&nbsp;&nbsp;Análise 360º</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row margin-bottom-20" style="margin-top: 20px;">
                            <div class="col-lg-12" >
                                <div class="portlet light">


                                    <h2>| Atividades</h2>

                                    <div class="table-responsive" id="exam-table-info">
                                        <table class="table mb-none table-hover">

                                            @foreach($workshop->activities as $activity)
                                                <tr>
                                                    <td><strong>{{ $activity->description }}</strong></td>

                                                    @if ($activity->begin > Carbon\Carbon::today())
                                                        <td>INICIARÁ EM <strong>{{ format_datebr( $activity->begin ) }}</strong></td>
                                                        <td><a type="button" class="mb-xs mt-xs mr-xs btn btn-primary yellow-saffron" href="#">Aguarde</a></td>
                                                    @endif

                                                    @if (($activity->begin <= Carbon\Carbon::today()) && ($activity->submit_deadline >= Carbon\Carbon::today()))
                                                        <td>RESPONDER ATÉ <strong>{{ format_datebr( $activity->submit_deadline ) }}</strong></td>
                                                        <td><a type="button" class="mb-xs mt-xs mr-xs btn btn-primary green-jungle" href="/classroom/workshops/{{ $enrollment->id  }}/{{ $workshop->id  }}/{{ $activity->id  }}">Em Andamento</a></td>
                                                    @endif

                                                    @if (($activity->submit_deadline < Carbon\Carbon::today()) && ($activity->evaluation_deadline >= Carbon\Carbon::today()))
                                                        <td>PRAZO CORREÇÃO <strong>{{ format_datebr( $activity->evaluation_deadline ) }}</strong></td>
                                                        @if (count($activity->myactivity) !== 0)
                                                            <td><a type="button" class="mb-xs mt-xs mr-xs btn btn-primary red-flamingo" href="/classroom/workshops/{{ $enrollment->id  }}/{{ $workshop->id  }}/{{ $activity->id  }}">Protocolo</a></td>
                                                        @else
                                                            @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                                                                <td><a type="button" class="mb-xs mt-xs mr-xs btn btn-primary red-flamingo" href="#">Não respondida</a></td>
                                                            @else
                                                                <td><a type="button" class="mb-xs mt-xs mr-xs btn btn-primary" href="/classroom/workshops/{{ $enrollment->id  }}/{{ $workshop->id  }}/{{ $activity->id  }}">Resposta</a></td>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    @if ($activity->evaluation_deadline < Carbon\Carbon::today())
                                                        <td>CONCLUÍDA</td>
                                                        @if (count($activity->myactivity) !== 0)
                                                            <td><a type="button" class="mb-xs mt-xs mr-xs btn btn-primary" href="/classroom/workshops/{{ $enrollment->id  }}/{{ $workshop->id  }}/{{ $activity->id  }}">Resultado</a></td>
                                                        @else
                                                            @if (($activity->personal_evaluation != null) && ($activity->personal_evaluation ==1 ))
                                                                <td><a type="button" class="mb-xs mt-xs mr-xs btn btn-primary red-flamingo" href="/classroom/workshops/{{ $enrollment->id  }}/{{ $workshop->id  }}/{{ $activity->id  }}">Não respondida</a></td>
                                                            @else
                                                                <td><a type="button" class="mb-xs mt-xs mr-xs btn btn-primary" href="/classroom/workshops/{{ $enrollment->id  }}/{{ $workshop->id  }}/{{ $activity->id  }}">Resposta</a></td>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                            @if($average_grade = average_workshop_grade($workshop))@endif
                                                @if($average_grade !== null)
                                                <tfoot>
                                                <tr style="font-size: 14px;">
                                                    <td></td>
                                                    <td><strong>Sua Média Geral:</strong></td>
                                                    <td>{{ $average_grade }}</td>
                                                    <td></td>


                                                </tr>
                                                </tfoot>
                                                @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        @endforeach

                @endif
            <!-- end: page -->
            <script
                    src="https://code.jquery.com/jquery-2.2.4.min.js"
                    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
                    crossorigin="anonymous"></script>
            <script type="text/javascript" src="/js/send.js">

            </script>
        <!-- Modal de tela de envio de dúvidas. -->
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div id="tabs-content" class="modal-content">
                        <section id="tell-a-friend-form" class="panel">
                            <div class="panel-body" style='height: 100%;'>
                                <div class="col-md-12">
                                    <div style="padding-top: 0 !important;padding-bottom: 5px;margin-bottom: 0px;">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <h1 class="section-title title">Envie sua dúvida.</h1>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                        {!! Form::open(['route' => 'student.asktheteacher', 'id' => 'sendAskTheTutor', 'class' => 'form-horizontal', 'role' => 'form', 'style' => 'padding:20px']) !!}
                                            {!! Form::hidden('workshop_id', $workshop->id, ['id' => 'workshop_id']) !!}

                                            <div class="form-group">
                                                {!! Form::textarea('question', null ,['rows' => 5, 'class' => 'form-control', 'placeholder' => 'Deixe aqui sua dúvida', 'id' => 'question']) !!}
                                            </div>

                                        <div class="form-group">
                                            {!! Form::submit( trans('strings.send'), ['class' => 'btn btn-primary btn-tell']) !!}
                                        </div>

                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal tira dúvidas -->

        <!-- Modal de tela caso o cadastro foi com sucesso ou erro. -->
        <div class="modal fade" id="askTheTutorModalClose" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div id="tabs-content" class="modal-content">
                        <section id="tell-a-friend-form" class="panel">
                            <div class="panel-body" style="height: 100%;">
                                <div class="col-md-12">
                                    <div class='row'>
                                        <div class='col-md-11'>
                                            <h2 style='padding:20px'></h2>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal caso o cadastro foi com sucesso ou erro -->
@endsection