@extends('frontend.layouts.master-classroom')

@section('content')

    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Performance Geral</h2>
        </header>

        <div id="course" class="container">

            {{--*/ $teacher = App\User::findOrNew(210) /*--}}

            <div id="general-statistics" class="row">
                <div class="col-md-3">
                    <div class="row">
                        <div id="results" data-total="{{ $total }}" data-partial="{{ $rights }}"></div>
                        <div id="relative-rights-percentual"  class="col-md-12">
                            <div class="card">
                                <div class="card-content  text-center"><div class="row">
                                        <p style="font-size: 4rem;"><canvas id="right-percentage-chart" class="right-percentage-chart" width="160" height="160"></canvas></p>
                                        <br>
                                        <p style="font-size: 2rem;">% de Acerto Geral</p>
                                    </div>





                                    <div class="row" style="padding-top: 50px">
                                        <div class="mt-widget-2" style="margin-top: 15px;">
                                            <div class="col-xs-6" style="padding:0;margin-top:0;">
                                                <img class="img-responsive userpic" src="{{ imageurl('users/',$teacher->id, $teacher->photo, 200, 'generic.png', true) }}">
                                            </div>
                                            <div class="mt-head-user-info col-xs-6 " style="padding-top: 30px; margin-top:0;">
                                                 <span class="label-big pull-right
                                                @if( $total == 0)
                                                         label-primary
                                                         @elseif (( $rights / $total * 100  ) < 50)
                                                         label-danger
                                                         @elseif (( $rights / $total * 100  ) < 75)
                                                         label-warning
                                                         @else
                                                         label-success  @endif" >
                                                @if( $total == 0)
                                                         BEM VINDO!
                                                     @elseif (( $rights / $total * 100  ) < 50)
                                                         PRECISA MELHORAR!
                                                     @elseif (( $rights / $total * 100  ) < 75)
                                                         PRECISA MELHORAR!
                                                     @else
                                                         MUITO BEM!
                                                     @endif
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-top:10px">
                        <div class='col-md-12'>
                            <div class="page-breadcrumbs" style="margin-top:0px; margin-bottom: 35px">
                                <a href="/saap-oab"><h1 class="section-title">Última Execução</h1></a>
                                <div class="world-nav cat-menu">
                                    <ul class="list-inline">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if($last_execution != null)
                            <a href="/exam/result/{{ $last_execution->id  }}">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card  card-fixed text-center" style="padding:0">
                                        <div class="card-image">
                                            <img class="img-responsive" src="{{ imageurl("exams/", $last_execution->enrollment->exam->id, $last_execution->enrollment->exam->classroom_img, 0, 'saap_home.png',true) }}">
                                        </div>
                                        <br/>
                                        <h4>@if($last_execution->finished == 1 || $last_execution->simulation_mode == 1) {{ $last_execution->attempt }}ª EXECUÇÃO - @if($last_execution->finished == 1){{ format_datebr($last_execution->finished_at) }}@else {{ format_datebr($last_execution->created_at) }} @endif @else  RESULTADO <br class="force-break"/>PARCIAL  @endif</h4>
                                        @if($result_rights = ($last_execution->grade != null ? $last_execution->grade : get_partial_rights($last_execution)))@endif
                                        <br/>
                                        <h4 style="font-size: 3.4rem;" class="@if(abs(($result_rights * 100)/ get_questions_count($last_execution->enrollment->exam)) >= 70 )
                                                font-green-jungle
                                        @else
                                                font-red-flamingo
                                        @endif">
                                            <div class="performance-result-graph" data-result="{{ ($result_rights * 100)/ get_questions_count($last_execution->enrollment->exam),0  }}">
                                                <canvas width="100" height="100" class="performance-result-graph"></canvas>
                                            </div>

                                        </h4>
                                        <br/>
                                        @if($attempt_time = get_questions_time($last_execution))@endif
                                        <h5> {{str_pad(  ($hours = floor($attempt_time / 3600)),2,'0',STR_PAD_LEFT) }}h {{ str_pad(($minutes = floor(($attempt_time - ($hours * 3600)) / 60)),2,'0',STR_PAD_LEFT) }}m </h5>
                                        <h5><i class="fa fa-check font-green-jungle"></i><span class="font-green-jungle">&nbsp;&nbsp;{{ number_format($result_rights, 0)}} ACERTOS</span>
                                            /
                                            @if($last_execution->finished == 1)
                                                <i class="fa fa-close font-red-flamingo"></i><span class="font-red-flamingo">&nbsp;&nbsp;{{ number_format($last_execution->enrollment->exam->questions_count - $result_rights, 0) }} ERROS</span></h5>
                                        @else
                                            <i class="fa fa-close font-red-flamingo"></i><span class="font-red-flamingo">&nbsp;&nbsp;{{ number_format($last_execution->questions_executions->reject(function($item){return $item->grade === null;})->count() - $result_rights, 0) }} ERROS</span></h5>

                                        @endif
                                        <br/>
                                    </div>
                                </div>
                            </a>
                        @endif


                    </div>

                </div>




                <div class="col-md-9">
                    <div class="row">
                        <div id="total-answered-questions" class="col-md-4">
                            <div class="card">
                                <div class="card-content  text-center">
                                    <p style="font-size: 3rem; color: #456D8C;"><i class="fa fa-list-ol"></i></p>
                                    <br>
                                    <p style="font-size: 4rem;">{{ $total }}</p>
                                    <br>
                                    <p style="font-size: 2rem;">Questões Respondidas</p>
                                </div>
                            </div>

                        </div>
                        <div id="total-right-questions" class="col-md-4">
                            <div class="card">
                                <div class="card-content text-center">
                                    <p style="font-size: 3rem; color: #456D8C;"><i class="fa fa-check" style="color: green"></i></p>
                                    <br>
                                    <p style="font-size: 4rem;">{{ $rights}}</p>
                                    <br>
                                    <p style="font-size: 2rem;">Acertos</p>
                                </div>
                            </div>
                        </div>
                        <div id="total-wrong-questions" class="col-md-4">
                            <div class="card">
                                <div class="card-content text-center">
                                    <p style="font-size: 3rem; color: #456D8C;"><i class="fa fa-times" style="color: red"></i></p>
                                    <br>
                                    <p style="font-size: 4rem;">{{ $total - $rights}}</p>
                                    <br>
                                    <p style="font-size: 2rem;">Erros</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="relative-statistics" class="row">
                        <div id="time-per-question-mean" class="col-md-4">
                            <div class="card">
                                <div class="card-content  text-center">
                                    <p style="font-size: 3rem; color: #456D8C;"><i class="fa fa-hourglass-o"></i><i class="fa fa-list-ol"></i></p>
                                    <br>
                                    <p style="font-size: 4rem;">{{ $time_question }}</p>
                                    <br>
                                    <p style="font-size: 2rem;">Tempo médio por questão</p>
                                </div>
                            </div>
                        </div>

                        <div id="total-execution-time" class="col-md-4">
                            <div class="card">
                                <div class="card-content  text-center">
                                    <p style="font-size: 3rem; color: #456D8C;"><i class="fa fa-hourglass-o"></i><i class="fa fa-file-o"></i></p>
                                    <br>
                                    <p style="font-size: 4rem;">{{ $total_time }}</p>
                                    <br>
                                    <p style="font-size: 2rem;">Tempo total de questões</p>
                                </div>
                            </div>
                        </div>


                        <div id="last-execution" class="col-md-4">
                            <div class="card">
                                <div class="card-content  text-center">
                                    <p style="font-size: 3rem; color: #456D8C;"><i class="fa fa-pencil-square-o"></i></p>
                                    <br>
                                    <p style="font-size: 4rem;">{{ $execution_count }}</p>
                                    <br>
                                    <p style="font-size: 2rem;">Resoluções de SAAP</p>
                                </div>
                            </div>
                        </div>
                    </div>










                <div class="row" style="padding-top: 10px">
                    <div class="col-md-12">
                        <div id="groups"  >


                            <div  id="general_performance" class="table-responsive panel-body">

                                <table class="table mb-none">
                                    <thead>
                                    <th width="50%">Disciplina</th>
                                    <th class="text-right detail-column">Performance</th>
                                    <th class="text-right detail-column">Questões</th>
                                    <th class="text-right detail-column">Acertos</th>
                                    <th class="text-right"><nobr>% Acerto</nobr></th>
                                    </thead>
                                    <tbody>
                                    @foreach($disciplines as $discipline)
                                        <tr class="subject-line" data-name="{{ $discipline->discipline }}" data-id={{ $discipline->discipline_id }} data-percentual="{{$discipline->percent}}" >
                                            <td>
                                                {{ $discipline->discipline }}
                                            </td>
                                            <td class="text-right" ><canvas class="mini-right-chart" width="30" height="30"  ></canvas></td>
                                            <td class="text-right detail-column" >
                                                {{ $discipline->questions }}
                                            </td>
                                            <td class="text-right detail-column">
                                                {{ $discipline->rights }}
                                            </td>
                                            <td class="text-right">
                                                @if ($discipline->percent < 50)
                                                    <span style="color: red">
                                    @elseif ($discipline->percent < 75)
                                                            <span style="color: yellow">
                                    @else
                                                                    <span style="color: green">
                                    @endif
                                                                        {{ number_format( $discipline->percent, 2, ',', '.' ) }}
                                     </span>
                                            </td>

                                        </tr>
                                    @endforeach
                                    <tr class="subject-line" data-percentual="{{ $rights / $total * 100  }}">
                                        <td>
                                            <strong>TOTAL</strong>
                                        </td>
                                        <td class="text-right" ><canvas class="mini-right-chart" width="30" height="30"  ></canvas></td>
                                        <td class="text-right detail-column" >
                                            <strong>{{ $total }}</strong>
                                        </td>
                                        <td class="text-right detail-column">
                                            <strong>{{ $rights }}</strong>
                                        </td>
                                        <td class="text-right">
                                            {{ number_format( $rights / $total * 100, 2, ',', '.' ) }}
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            </div>
        </div>
        </div>

        <div class="modal fade" id="disciplineStatisticModal" tabindex="-1" role="dialog" ></div>

    </section>


@endsection