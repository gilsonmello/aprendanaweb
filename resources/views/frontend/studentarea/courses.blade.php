@extends('frontend.layouts.master-classroom')

@section('content')
    <section role="main" class="content-body">

        <header class="page-header">
            <h2 class="title-header" >MEUS CURSOS</h2>
        </header>

            @if (count($enrollments) === 0)
                @if (($selectedtag == null) || ($selectedtag == "") || ($selectedtag == "-") )
                <div id="my-courses" class="container">
                    <h3>Você ainda não adquiriu nenhum curso. <!--a href="/" style="text-decoration: underline;">Acesse a nossa loja.</a--></h3>
                </div>
                @endif
            @endif

                    <!-- start: page -->
                <div id="my-courses" class="container">
                    @if (count($tags) != 0)
                        <div class="row" >
                            <div class="col-md-4" style="background-color: #1E376D; padding: 10px; margin-left: 30px;margin-right: 30px;">
                        <form method="get" action="{{ Route('frontend.courses')  }}" >
                            <div class="col-md-9 "  >
                            <select name="cat" id="cat" class="form-control">
                                <option value="-">Todos os cursos</option>
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

            @if (count($enrollments) != 0)


                    @foreach($enrollments as $enrollment)
                            <!-- <p>Atingido: {{ $actual = get_total_percentage_completed($enrollment)}}% | Esperado: {{ $ideal = get_ideal_percentage($enrollment->date_end,$enrollment->date_begin) }}%</p> -->
                    {{--*/ $teacher = null /*--}}
                    @if (count($enrollment->course->teachers) != 0)
                        {{--*/ $teacher = $enrollment->course->teachers->random()->teacher /*--}}
                    @endif
                    @if ($teacher === null)
                        {{--*/ $teacher = App\User::findOrNew(210) /*--}}
                    @endif


                    <div id="card-column" class="col-md-4 col-sm-6">
                        <div class="card" style="padding: 0">
                            <div class="card-image">
                                <img class="img-responsive" src="{{ imageurl("courses/", $enrollment->course->id, $enrollment->course->classroom_img, 0, 'course_home.jpg') }}">
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
                                <div class="dashboard-stat2 " style="margin-top: 10px; margin-bottom: 0px;">
                                    <div class="progress-info">

                                        <div class="status2">
                                            <div class="status-title"> ASSISTIDO </div>
                                            <div class="status-number @if(abs($actual - $ideal) < 10 )
                                                    font-yellow-saffron
                                            @elseif($actual - $ideal > 10)
                                                    font-green-jungle
                                             @else
                                                    font-red-flamingo
                                            @endif"> {{ $actual }}% </div>
                                        </div>
                                        <div class="progress">
                                                                    <span style="width: {{ $actual }}%;" class="progress-bar progress-bar-success @if(abs($actual - $ideal) < 10 )
                                                                            yellow-saffron
                                                                    @elseif($actual - $ideal > 10)
                                                                    @endif
                                                                            <span class="sr-only">{{ $actual }}% progress</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-body text-center">
                                    <h3 class="mt-body-title mt-body-title-course" > {{ str_limit($enrollment->course->title, 60) }} </h3>
                                    <ul class="mt-body-stats">
                                        <li class="font-grey-gallery">
                                            <i class="fa fa-hourglass-3"></i> Concluir em até <strong>{{ Carbon\Carbon::now()->diffInDays( Carbon\Carbon::parse($enrollment->date_end) ) }} dias</strong></li>
                                    </ul>
                                    <a class="btn default btn-block" href="classroom/course/{{$enrollment->id}}">ÁREA DO CURSO</a>
                                    {{--*/ $lastviewedcontent = get_last_viewed_content($enrollment) /*--}}
                                    @if( ($enrollment->views->isEmpty()) || (count($enrollment->views) == 0) || ($lastviewedcontent == null) || ($lastviewedcontent->lesson == null))
                                        <a class="btn blue-steel btn-block" href="{{ get_url_from_content(get_first_content($enrollment))  }}/{{$enrollment->id}}">INICIE CURSO</a>
                                    @else
                                        <a class="btn blue-steel btn-block" href="{{ get_url_from_content(get_last_viewed_content($enrollment)) }}/{{$enrollment->id}}">CONTINUE CURSO</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                @endforeach
            @endif
            </div>

            @if (count($expireds) != 0)

                <div id="my-courses" class="container">
                    <hr>
                    <h1 style="color:black"><strong>| CURSOS</strong> Encerrados</h1>

                    @foreach($expireds as $enrollment)
                            <!-- <p>Atingido: {{ $actual = get_total_percentage_completed($enrollment)}}% | Esperado: {{ $ideal = get_ideal_percentage($enrollment->date_end,$enrollment->date_begin) }}%</p> -->
                    {{--*/ $teacher = null /*--}}
                    @if (count($enrollment->course->teachers) != 0)
                        {{--*/ $teacher = $enrollment->course->teachers->random()->teacher /*--}}
                    @endif
                    @if ($teacher === null)
                        {{--*/ $teacher = App\User::findOrNew(210) /*--}}
                    @endif


                    <div id="card-column" class="col-md-4 col-sm-6">
                        <div class="card" style="padding: 0">
                            <div class="card-image">
                                <img class="img-responsive" src="{{ imageurl("courses/", $enrollment->course->id, $enrollment->course->classroom_img, 0, 'course_home.jpg') }}">
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
                                <div class="dashboard-stat2 " style="margin-top: 10px; margin-bottom: 0px;">
                                    <div class="progress-info">

                                        <div class="status2">
                                            <div class="status-title"> ASSISTIDO </div>
                                            <div class="status-number @if(abs($actual - $ideal) < 10 )
                                                    font-yellow-saffron
                                            @elseif($actual - $ideal > 10)
                                                    font-green-jungle
                                             @else
                                                    font-red-flamingo
                                            @endif"> {{ $actual }}% </div>
                                        </div>
                                        <div class="progress">
                                                                    <span style="width: {{ $actual }}%;" class="progress-bar progress-bar-success @if(abs($actual - $ideal) < 10 )
                                                                            yellow-saffron
                                                                    @elseif($actual - $ideal > 10)
                                                                    @endif
                                                                            <span class="sr-only">{{ $actual }}% progress</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-body text-center">
                                    <h3 class="mt-body-title mt-body-title-course" > {{ str_limit($enrollment->course->title, 60) }} </h3>
                                    <ul class="mt-body-stats">
                                        <li class="font-grey-gallery">
                                            <i class="fa fa-hourglass-3"></i> Encerrado </li>
                                    </ul>
                                    <a class="btn default btn-block" href="classroom/course/{{$enrollment->id}}">ÁREA DO CURSO</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    @endforeach
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


@endsection