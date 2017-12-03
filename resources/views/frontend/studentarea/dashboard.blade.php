@extends('frontend.layouts.master-classroom')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header" style="background-color: white; height:100px; padding: 22px; padding-left: 20px;">
        
            <div class="row">


                <div class="col-md-4 col-sm-5 col-xs-12 text-left" >
                    <figure class="profile-picture profile-picture-sub">
                        <h4 style="font-size: 2.0rem;"> <img height="60"  src="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100, 'generic.png', true) }}" class="img-circle no-padding" data-lock-picture="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100) }}"> &nbsp;&nbsp;&nbsp;{{ Auth::user()->name }}</h4>
                    </figure>
                </div>
                <div class="col-md-7 col-sm-7 col-xs-12 text-left hidden-xs " style="margin-top:20px;  font-size: 1.3rem; height: 80px;">
                    @if (count($messages) != 0)
                        <div id="myCarousel" class="carousel slide message-margin" data-ride="carousel">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner " role="listbox">
                                @for ($message = 0; $message < count($messages); $message++)
                                    <div class="item {{ $message == 0 ? "active" : "" }}" style="padding-top: 2px; height: 36px ">
                                        {!! $messages[$message] !!}
                                    </div>
                                @endfor
                            </div>

                            @if (count($messages) != 1)
                                    <!-- Left and right controls -->
                            <a class="dash_left carousel-bj-control" href="#myCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="dash_right carousel-bj-control" href="#myCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
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


<div class="container">



@if (count($coursecalendar) != 0) 
    <div class="row">
        <br>
        <div class="col-lg-12 col-md-12 col-sm-12"> 

                            <h1 style="color:black"><strong>| EVENTOS </strong> do dia</h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="padding:30px">

                                        @foreach($coursecalendar as $value)

                                                <p style="position: relative; overflow: hidden; width: 100%;">
                                                <span class="fa fa-calendar">&nbsp;</span>&nbsp;
                                                {{$value->description . ' - ' . $value->course_title}}
                                                </p>

                                        @endforeach

                                </div>
                            </div>


    </div>
        </div>
    </div>
@endif
    @if ((count($exams) === 0) && (count($enrollments) === 0))
        <div class="row">

            
            <div class="col-lg-12 col-md-10 col-sm-10">

                    <h3>Você ainda não adquiriu nenhum curso ou SAAP. <a href="/" style="text-decoration: underline;">Acesse a loja Aprenda na Web.</a></h3>

            </div>
  
        </div>
    @endif
        @if ($welcomemessage != '')
            @include('frontend.studentarea.welcome')
        @endif

        {{-- @if (count($lastenrollments) != 0)
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h1 style="color:black"><strong>| ÚLTIMAS</strong> matrículas</h1>
                <div class="row">
                    @foreach ($lastenrollments as $lastenrollment)
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="card-image" style="margin-bottom: 20px;">
                                @if ($lastenrollment->course != null)
                                    <a href="classroom/course/{{$lastenrollment->id}}">
                                    <img class="img-responsive" src="{{ imageurl("courses/", $lastenrollment->course->id, $lastenrollment->course->classroom_img, 400, 'course_home.png') }}">
                                    </a>
                                @elseif ($lastenrollment->exam != null)
                                    <a href="/exam/intro/{{ $lastenrollment->id  }}">
                                    <img class="img-responsive" src="{{ imageurl("exams/", $lastenrollment->exam->id, $lastenrollment->exam->classroom_img, 400, 'saap_home.png') }}">
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif --}}

    @if ($survey == 1)
        @include('frontend.studentarea.surveys.survey1')
    @endif

    @if (($occupations != null) && (count($occupations) != 0))
        @include('frontend.studentarea.surveys.occupation')
    @endif

    @if ((count($enrollments) > 0))



        @if (isset($final_exam_pending) && $final_exam_pending != null && count($final_exam_pending) != 0)
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">


                                    <h1 style="color:black"><strong>| AVALIAÇÕES </strong> Realize sua avaliação</h1>
                        <div class="row">
                            <div class="col-md-12">
                               <div class="card">


                                       <div class="row" style="font-weight: bold">
                                           <div class="col-md-12">
                                           <p>A Avaliação de Rendimento permite avaliar o seu aprendizado durante o curso, medindo sua aptidão para obter o certificado.</p>
                                           <p>Na Avaliação de Rendimento, somente após concluir todo o simulado, respondendo a todas as questões, o aluno terá acesso aos comentários dos professores. Assim, será necessário responder todas as questões, marcando suas alternativas, para ao final  ter acesso as respostas correlatas e comentários dos professores.</p>
                                           <p>Na Avaliação de Rendimento será possível alterar as respostas das questões já marcadas. Aquelas questões que não forem respondidas, seja pelo esgotamento do tempo, seja pela finalização do SAAP pelo aluno, serão computadas como erro.</p>
                                           </div>
                                       </div>
                                        <hr/>
                                    @foreach($final_exam_pending as $enrollment_with_exam)
                                        <div class="row">
                                            <div class="col-md-12">
                                            <h4>{{ $enrollment_with_exam->course->title }}</h4>
                                            <a  type="button"  href="{{ route('frontend.final.exam', $enrollment_with_exam->id ) }}" class="mt-xs mr-xs btn btn-success" style=" font-size: 1.7rem;">Iniciar a Prova do Curso (Performance Mínima Esperada: <strong>{{ $enrollment_with_exam->course->minimum_percentage  }}% </strong>)</a>
                                            </div>
                                        </div>

                                    @endforeach

                               </div>
                            </div>

                        </div>

                </div>
            </div>
        @endif







        <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 style="color:black"><strong>| CURSOS</strong> Visão geral de performance</h1>

                    <div class="row">
                        @if($study_plan == false)
                            <div class="col-lg-3 col-md-6 col-sm-3 col-xs-12">
                                <div class="dashboard-stat2 card">
                                    <p style="padding-top: 20px;"><h4>QUANTAS HORAS DIÁRIAS DE VÍDEO AULA VOCÊ PRETENDE ASSISTIR?</h4></p>
                                    {!! Form::open(['route' => ['frontend.initialize_study_plan'], 'id' => 'planstudy_form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) !!}
                                    <input id="planstudy_hours" type="text" value="2" name="planstudy_hours" class="form-control input-lg planstudy_hours">
                                    <a type="button" onclick="javascript: $('#planstudy_form').submit();" class="mb-xs mt-xs mr-xs btn btn-default" style="width:100%; border-color: #949398; color:#626471"><i class="fa fa-check"></i>&nbsp;&nbsp;CONFIRMAR</a>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                        @else
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 card">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-blue-chambray">
                                                <span data-counter="counterup" data-value="{{ $courses_taken }}">0</span>
                                            </h3>
                                            <small>CURSOS ATIVOS</small>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-desktop"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                                <span style="width: 100%; background-color: black" class="progress-bar progress-bar-success blue-chambray">
                                                    <span class="sr-only">100%</span>
                                                </span>
                                        </div>
                                        <div class="status">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 card">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="{{ $font = ($study_plan->time_today >= ($study_plan->daily_time * 3600) ? "font-green-jungle" : "font-red-flamingo") }}">
                                                <span data-counter="counterup" data-value="{{  $hour = floor($study_plan->time_today / 3600) }}">0</span>
                                                <small class="{{ $font }}">h</small>
                                                <span data-counter="counterup" data-value="{{ $minute = floor(($study_plan->time_today - ($hour * 3600)) / 60) }}">0</span>
                                                <small class="{{ $font }}">m</small>
                                            </h3>
                                            <small>ASSISTIDOS HOJE</small>
                                        </div>
                                        <div class="icon">
                                            <i class="fa icon-like"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                                    <span style="width: {{$percentage = ($study_plan->time_today/($study_plan->daily_time * 3600)) * 100 }}%;" class="progress-bar progress-bar-success @if($percentage >= 100) green-jungle @else red-flamingo @endif">
                                                        <span class="sr-only">{{ $percentage }}%</span>
                                                    </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> META DIÁRIA </div>
                                            <div class="status-number"> {{ $study_plan->daily_time }} horas</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 card">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="{{ $font = ($study_plan->time_this_week >= (($study_plan->daily_time * 7) * 3600) ? "font-green-jungle" : "font-red-flamingo") }}">

                                                <span data-counter="counterup" data-value="{{  $hour = floor($study_plan->time_this_week / 3600) }}">0</span>
                                                <small class="{{ $font }}" style="text-transform: lowercase; !important">h</small>
                                                <span data-counter="counterup" data-value=" {{ $minutes = floor(($study_plan->time_this_week - ($hour * 3600)) / 60) }}">0</span>
                                                <small class="{{ $font }}" style="text-transform: lowercase; !important">m</small>
                                            </h3>
                                            <small>ASSISTIDOS SEMANA</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-dislike"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                                    <span style="width: {{ $percentage = ($study_plan->time_this_week/(($study_plan->daily_time  * 7)* 3600)) * 100  }}%;" class="progress-bar progress-bar-success @if($percentage >= 100) green-jungle @else red-flamingo @endif">
                                                        <span class="sr-only">{{ $percentage }}%</span>
                                                    </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> META SEMANAL </div>
                                            <div class="status-number"> {{ $study_plan->daily_time  * 7}} horas </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 card">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="{{ $font = ($study_plan->time_year >= (($study_plan->daily_time * 30) * 3600) ? "font-green-jungle" : "font-red-flamingo") }}">
                                                <span data-counter="counterup" data-value="{{  $hour = floor($study_plan->time_this_month / 3600) }}">0</span>
                                                <small class="{{ $font }}">h</small>
                                                <span data-counter="counterup" data-value="{{ $minutes = floor(($study_plan->time_this_month - ($hour * 3600)) / 60) }}">0</span>
                                                <small class="{{ $font }}">m</small>
                                            </h3>
                                            <small>ASSISTIDOS MÊS</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-dislike"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                            {{ $study_plan->time_this_month }} - {{ ($study_plan->daily_time  *  \Carbon\Carbon::now()->daysInMonth) * 60 }}
                                            <span style="width: {{ $percentage = ($study_plan->time_this_month/(($study_plan->daily_time  *  \Carbon\Carbon::now()->daysInMonth)* 3600)) * 100  }}%;" class="progress-bar progress-bar-success @if($percentage >= 100) green-jungle @else red-flamingo @endif">
                                                        <span class="sr-only">{{ $percentage }}%</span>
                                                    </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> META MENSAL </div>
                                            <div class="status-number"> {{ $study_plan->daily_time * \Carbon\Carbon::now()->daysInMonth}} horas </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

                    <!-- start: page -->
            @if (count($enrollments) != 0)
                <div class="row" style="margin-bottom: 0px;">
                    <div>


                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row">

                            <div class="col-md-10">
                            <h1 style="color:black"><strong>| CURSO</strong> Assistido  recentemente</h1>
                            </div>
                                <div class="col-md-2 text-right">
                            <h3 style="margin-top: 30px"> <a type="button" href="{{ Route('frontend.courses') }}" class="btn default btn-block" style="border-color: #949398; color:#626471;"></i>&nbsp;&nbsp;MEUS CURSOS</a></h3>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div id="my-courses" class="row" style="padding-top: 0px">


                    @foreach($enrollments as $enrollment)

                    <!-- <p>Atingido: {{ $actual = get_total_percentage_completed($enrollment)}}% | Esperado: {{ $ideal = get_ideal_percentage($enrollment->date_end,$enrollment->date_begin) }}%</p> -->
                    {{--*/ $teacher = null /*--}}
                    @if (count($enrollment->course->teachers) != 0)
                        {{--*/ $teacher = $enrollment->course->teachers->random()->teacher /*--}}
                    @endif
                    @if ($teacher === null)
                        {{--*/ $teacher = App\User::findOrNew(210) /*--}}
                    @endif


                    <div id="card-column" class="col-lg-3 col-md-3 col-sm-6 ">
                        <div class="card" style="padding:0">
                            <div class="card-image">
                                <img class="img-responsive" src="{{ imageurl("courses/", $enrollment->course->id, $enrollment->course->classroom_img, 400, 'course_home.png') }}">
                            </div>
                            <div class="row">
                                <div class="fotoautor">
                                    <div class="card-user">
                                        <img class="img-responsive userpic" src="{{ imageurl('users/',$teacher->id, $teacher->photo, 100, 'generic.png', true) }}">
                                    </div>
                                </div>
                                <div class="fraseautor">
                                    <div class="card-content">
                                        <p><span class="label-big
                                        @if( $enrollment->views->isEmpty() || count($enrollment->views) == 0)
                                                    label-primary
                                                   @elseif(abs($actual - $ideal) < 10 )
                                                    label-warning
                                                    @elseif($actual - $ideal > 10)
                                                    label-success
                                            @else
                                                    label-danger  @endif" >
                                                @if( $enrollment->views->isEmpty() || count($enrollment->views) == 0)
                                                    BEM VINDO!
                                                @elseif(abs($actual - $ideal) < 10 )
                                                    MANTENHA O RITMO!
                                                @elseif($actual - $ideal > 10)
                                                    CONTINUE NESTE RITMO
                                                @else
                                                    ACELERE O RITMO !
                                                @endif</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body ">
                                <br/>

                                <div class="mt-body text-center">
                                    <h3 class="mt-body-title"> {{ $enrollment->course->title }} </h3>
                                    <br/>
                                    <ul class="mt-body-stats">
                                        <li class="font-grey-gallery">
                                            <i class="fa fa-hourglass-3"></i> Concluir em até <strong>{{ Carbon\Carbon::now()->diffInDays( Carbon\Carbon::parse($enrollment->date_end) ) }} dias</strong></li>
                                    </ul>
                                    <br/>
                                    <a class="btn default btn-block" href="classroom/course/{{$enrollment->id}}">ÁREA DO CURSO</a>
                                    {{--*/ $lastviewedcontent = get_last_viewed_content($enrollment) /*--}}
                                    @if( ($enrollment->views->isEmpty()) || (count($enrollment->views) == 0) || ($lastviewedcontent == null) || ($lastviewedcontent->lesson == null))
                                        <a class="btn blue-steel btn-block" href="{{ get_url_from_content(get_first_content($enrollment))  }}/{{$enrollment->id}}">INICIE O CURSO</a>
                                    @else
                                        <a class="btn blue-steel btn-block" href="{{ get_url_from_content(get_last_viewed_content($enrollment)) }}/{{$enrollment->id}}">CONTINUE O CURSO</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>



                    @endforeach

                    <div id="progress-column" class="col-lg-9 col-md-9 col-sm-12">
                        @if($study_plan != false)
                            <div id="study-achievements" data-study-time="{{ $study_plan->daily_time }}" class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-content" style="float: unset">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong id="progress-by-title">Horas Assistidas nos últimos 8 dias</strong>
                                                </div>
                                                <div id="daily-progress" class="col-md-2 progress-title"  style="cursor:pointer; font-weight: bold">
                                                    Dia
                                                </div>
                                                <div id="weekly-progress" class="col-md-2 progress-title" style="cursor:pointer">
                                                    Semana
                                                </div>
                                                <div id="monthly-progress" class="col-md-2 progress-title" style="cursor:pointer">
                                                    Mês
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="canvas-container" class="container">
                                                        <div id="canvas-wrapper" class="wrapper">
                                                            <canvas id="study-plan-continuous"  class="study-continuous-graph"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{--<div id="study-achievements" class="row">--}}
                                {{--<div class="col-md-12">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-content" style="float: unset;--}}
                                        {{--height: 400px;--}}
                                        {{--vertical-align: middle;--}}
                                        {{--background-image: url('/img/system/dashboard_hours.png');--}}
                                        {{--background-size:contain;">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        @endif


                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="card">

                                    <div class="display">
                                        <div class="number">
                                            @if($actual = get_total_percentage_completed($enrollment))@endif

                                            <h3 class=" @if(abs($actual - $ideal) < 10 )
                                                    font-yellow-saffron
                                            @elseif($actual - $ideal > 10)
                                                    font-green-jungle
                                             @else
                                                    font-red-flamingo
                                            @endif">
                                                <span data-counter="counterup" data-value="{{ $actual }}">{{$actual}}</span>
                                                <small class="@if(abs($actual - $ideal) < 10 )
                                                        font-yellow-saffron
                                                @elseif($actual - $ideal > 10)
                                                        font-green-jungle
                                                 @else
                                                        font-red-flamingo
                                                @endif">%</small>
                                            </h3>
                                            <small>ASSISTIDO</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-like"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress" style="height:4px">
                                                     <span style="width: {{ $actual }}%;" class="progress-bar progress-bar-success @if(abs($actual - $ideal) < 10 )
                                                             yellow-saffron
                                                     @elseif($actual - $ideal > 10)
                                                             green-jungle
                                                      @else
                                                             red-flamingo
                                                     @endif">
                                                                        <span class="sr-only">{{ $actual }}% progress</span>
                                                                    </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> AULAS ASSISTIDAS </div>
                                            <div class="status-number"> {{ lessons_completed($enrollment) }} </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6  col-sm-6">
                                <div class="card">

                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-blue-steel">
                                                <span data-counter="counterup" data-value="{{ $ideal = get_ideal_percentage($enrollment->date_end,$enrollment->date_begin) }}">{{ $ideal }}</span>
                                                <small class="font-blue-steel">%</small>
                                            </h3>
                                            <small>ESPERADO</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-screen-desktop"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress" style="height:4px">
                                                            <span style="width: {{ $ideal }}%;" class="progress-bar progress-bar-success blue-steel">
                                                                <span class="sr-only">{{ $ideal }}%</span>
                                                            </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> AULAS ESPERADAS </div>
                                            <div class="status-number"> {{ round(get_lessons_count_by_course($enrollment) * ($ideal / 100),0,PHP_ROUND_HALF_UP) }} </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            @endif

            <div class='clearfix'></div>

            @if (count($exams) != 0)
                <div class="row" style="margin-bottom: 0px;">


                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom: 0px;" >
                        <div class="row">
                            <div class="col-md-8">
                        <h1 style="color:black"><strong>| SAAP</strong> Visão geral de performance</h1>
                            </div>
                            @if(!$exams->first()->executions->isEmpty())
                            <div class="col-md-2 text-right">
                                <h3 style="margin-top: 30px"> <a type="button" href="{{ Route('frontend.examGeneralPerformance') }}" class="btn blue-steel btn-block" style="border-color: #949398; color:#white;"></i>&nbsp;&nbsp;PERFORMANCE GERAL</a>
                            </div>
                            <div class="col-md-2 text-right">
                        <h3 style="margin-top: 30px"> <a type="button" href="{{ Route('frontend.exams') }}" class="btn default btn-block" style="border-color: #949398; color:#626471;"></i>&nbsp;&nbsp;MEUS SAAP'S</a>
                        </h3>
                            </div>
                                @else
                                <div class="col-md-4 text-right">
                                    <h3 style="margin-top: 30px"> <a type="button" href="{{ Route('frontend.exams') }}" class="btn default btn-block" style="border-color: #949398; color:#626471;"></i>&nbsp;&nbsp;MEUS SAAP'S</a>
                                    </h3>
                            @endif

                        </div>
                    </div>



                </div>
                <div id="my-exams" class="row">


                    @foreach($exams as $exam)


                            <!--  {{ $best = get_best_result($exam) }} -->
                    {{--*/ $teacher = $exam->exam->teacherMessage /*--}}
                    @if ($teacher === null)
                        {{--*/ $teacher = App\User::findOrNew(210) /*--}}
                    @endif
                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <div class="card" style="padding: 0px">
                            <div class="card-image">
                                <img class="img-responsive" src="{{ imageurl("exams/", $exam->exam->id, $exam->exam->classroom_img, 0, 'saap_home.png') }}">
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
                                                        label-danger" style="background-color: #e02612 !important; border-color: #d72411; @endif"> @if((($best->grade * 100)/ $exam->exam->questions_count) >= $exam->exam->minimum_percentage )
                                                        ÓTIMA PERFORMANCE
                                                    @else
                                                        PRECISA MELHORAR!
                                                    @endif</span></p>
                                        </div>
                                    </div>
                            </div>
                            @else
                                <div class="fraseautor">
                                    <div class="card-content">
                                        <p><span class="label-big label-info">COMECE AGORA!</span></p>
                                    </div>
                                </div>
                        </div>
                        @endif
                        <div class="card-body">
                            <br/>
                            <p class="text-center">@if ($best != null)
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
                                @endif
                            </p>

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
                </div>
                @endforeach

                @if(!$exam->executions->isEmpty())
                    <div class="col-lg-9 col-md-9 col-sm-12 " >
                        <div class="card">
                            <div class="row" style="border-bottom: 1px solid lightgrey; min-height:48px">
                                <div class="col-md-6">
                                    <span style="font-size:1.2em"><strong> Resultados do SAAP </strong></span>
                                </div>
                                <div class="col-md-6" style="padding-top: 3px;">
                                    <div class="actions text-right">
                                        @if(($attempt =  get_attempted($exam)) > 0)

                                            <div class="btn-group btn-group-divided text-right" data-toggle="buttons">
                                                @if($attempt > 1)
                                                    <label class="btn  btn-default grey-cascade btn-outline   current-attempt btn-sm "
                                                           data-attempt-time="{{ $attempt_time_prev = get_questions_time($exam->executions->whereLoose('attempt',$attempt - 1)->last()) }}"
                                                           data-attempt-date="{{ $attempt_date_prev =  format_datebr($exam->executions->whereLoose('attempt',$attempt - 1)->last()->finished_at)}}"
                                                           data-attempt-grade="{{  $current_grade_prev = floor($exam->executions->whereLoose('attempt',$attempt - 1)->last()->grade) }}"
                                                           data-total-questions="{{ get_questions_count($exams->last()->exam) }}"
                                                            >
                                                        <input name="options" class="toggle" id="option2"
                                                               type="radio">RESULTADO {{ $attempt - 1 }}
                                                    </label>
                                                @endif
                                                <label class="btn btn-default grey-cascade btn-outline current-attempt btn-sm active"
                                                       data-attempt-time="{{ $attempt_time = get_questions_time($exam->executions->whereLoose('attempt',$attempt)->last()) }}"
                                                       data-attempt-date="{{ $attempt_date =  format_datebr($exam->executions->whereLoose('attempt',$attempt)->last()->finished_at)}}"
                                                       data-attempt-grade="{{  $current_grade = (floor($exam->executions->whereLoose('attempt',$attempt)->last()->grade ) != null ? floor($exam->executions->whereLoose('attempt',$attempt)->last()->grade ) : get_partial_rights($exam->executions->whereLoose('attempt',$attempt)->last())) }}"
                                                       data-total-questions="{{ $answered_questions = ($attempt_date != null ? get_questions_count($exams->last()->exam) : $exam->executions->whereLoose('attempt',$attempt)->last()->questions_executions->reject(function($item){return $item->grade === null;})->count())  }}"
                                                        >
                                                    <input name="options" class="toggle " id="option1"
                                                           type="radio">RESULTADO {{ $attempt }}
                                                </label>


                                            </div>
                                    </div>



                                    @endif
                                </div>
                            </div>
                            <div id="last-exam-results" data-questions-count="{{ $count = get_questions_count($exams->last()->exam) }}" class="row no-padding"  style="padding-top: 23px;">
                                <div class="col-md-4 col-sm-4 text-center">
                                 <span class="title">

                                    <strong> <div id="result-date">@if($attempt_date != null) Em  {{ $attempt_date }} @else Resultado Parcial @endif</div></strong>
                                    <br/>
                                </span>
                                    <div class=" current-graph" style="padding: 0px;" width="100" height="100">
                                        <canvas id="attempt-canvas" data-total-questions="{{ $answered_questions }}" data-attempt="{{ $current_grade }}" class="current-graph" width="100" height="100"  style="width: 100px; height: 100px; " ></canvas>
                                    </div>
                                    <div>
                                        <h5>
                                            <i class="fa fa-check font-green-jungle"></i><span id="attempt-right" class="font-green-jungle">&nbsp;{{ floor($current_grade) }} ACERTOS</span>
                                            <br/>
                                            <br/>
                                            <i class="fa fa-close font-red-flamingo"></i><span id="attempt-wrong" class="font-red-flamingo">&nbsp;{{ $answered_questions - $current_grade }} ERROS</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                <span class="title">
                                   <div> <strong>Mínimo Esperado</strong></div>
                                    <br/>
                                </span>
                                    <div class=" target-graph" style="padding: 0px;" width="100" height="100">
                                        <canvas id="target-canvas" data-target="{{ floor($exams->last()->exam->minimum_percentage) }}" class="target-graph" width="100" height="100"  style="width: 100px; height: 100px; " ></canvas>
                                    </div>
                                    <div>
                                        <h5>
                                            <i class="fa fa-check font-green-jungle"></i><span class="font-green-jungle">&nbsp;{{ $target_right=  $count * (floor($exams->last()->exam->minimum_percentage) / 100)}} ACERTOS</span>
                                            <br/>
                                            <br/>
                                            <i class="fa fa-close font-red-flamingo"></i><span class="font-red-flamingo">&nbsp;{{ $count - $target_right }} ERROS</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                <span class="title">
                                  <div><strong>Demais alunos</strong></div>
                                    <br/>
                                </span>
                                    <div class=" enemy-graph" style="padding: 0px;" width="100" height="100">
                                        <canvas id="enemy-canvas" data-enemy="{{ $enemy_grade = round($exams->last()->exam->average_grade,2) }}"  class="enemy-graph" width="100" height="100"  style="width: 100px; height: 100px; " ></canvas>
                                    </div>
                                    <div>
                                        <h5>
                                            <i class="fa fa-check font-green-jungle"></i><span class="font-green-jungle">&nbsp;{{ number_format( $enemy_grade, 1, ',', '.') }} ACERTOS</span>
                                            <br/>
                                            <br/>
                                            <i class="fa fa-close font-red-flamingo"></i><span class="font-red-flamingo">&nbsp;{{ number_format($count - $enemy_grade,1, ',', '.') }} ERROS</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
        <!-- ZZZZZZZZZZZZZZZ -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 data-time-by-question="{{ $time_by_question = round($attempt_time / $count) }}" data-total-time-by-question="{{ $total_time = floor(($exam->exam->duration * 60)/$count) }}">
                                <div class="card">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="{{ $font = ($time_by_question < $total_time ? 'font-green-jungle' : 'font-red-flamingo') }}">
                                                <span data-counter="counterup" data-value="{{  $minutes = floor($time_by_question / 60) }}">{{$minutes}}</span>
                                                <small class="{{ $font }}" style="text-transform: lowercase; !important">m</small>
                                                <span data-counter="counterup" data-value=" {{ $seconds = floor($time_by_question - ($minutes * 60)) }}">{{$seconds}}</span>
                                                <small class="{{ $font }}" style="text-transform: lowercase; !important">s</small>
                                            </h3>
                                            <small>Tempo por questão</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-screen-desktop"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress" style="height:4px">
                                                            <span style="width: {{ $percentage = (($time_by_question * 100) / $total_time)  }}%;" class="progress-bar progress-bar-success @if($percentage >= 100) red-flamingo @else green-jungle @endif">
                                                                <span class="sr-only">{{ $percentage }}%</span>
                                                            </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> TEMPO ESPERADO  </div>
                                            <div class="status-number"> {{$total_minutes = floor($total_time / 60)}}m {{ floor($total_time - ($total_minutes * 60))  }}s </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" data-time-expected="{{ $time_expected = $exam->exam->duration * 60 }}">
                                <div class="card">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="{{ $font = ($attempt_time >= $time_expected ? 'font-red-flamingo' : 'font-green-jungle') }}">
                                                <span data-counter="counterup" data-value="{{  $hours = floor($attempt_time / 3600) }}">{{str_pad($hours,2,'0',STR_PAD_LEFT)}}</span>
                                                <small class="{{ $font }}" style="text-transform: lowercase; !important">h</small>
                                                <span data-counter="counterup" data-value=" {{ $minutes = floor(($attempt_time - ($hours * 3600)) / 60) }}">{{str_pad($minutes,2,'0',STR_PAD_LEFT)}}</span>
                                                <small class="{{ $font }}" style="text-transform: lowercase; !important">m</small>
                                            </h3>
                                            <small>Tempo Total</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-screen-desktop"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress" style="height:4px">
                                                            <span style="width: {{ $percentage =  (($attempt_time * 100) / $time_expected)  }}%;" class="progress-bar progress-bar-success @if($percentage == 100) red-flamingo  @else green-jungle @endif ">
                                                                <span class="sr-only">{{ $percentage  }}%</span>
                                                            </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> TEMPO ESPERADO  </div>
                                            <div class="status-number"> {{$total_hours = floor($time_expected / 3600)}}h {{ floor(($time_expected - ($total_hours * 3600))/60)  }}m </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


 

                    </div>
                @endif

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