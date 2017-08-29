@extends('frontend.layouts.master-classroom')

@section('meta')
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
@endsection



@section('content')
<section id="results-section" data-execution="{{ $execution->id }}" role="main" class="content-body">
    <header class="page-header">
        <h2>SAAP - Sistema de Aprendizagem de Alta Performance </h2>
    </header>

    <!-- start: page -->
    {{--*/  $teacher = $execution->enrollment->exam != null ? $execution->enrollment->exam->teacherMessage : null /*--}}
    @if ($teacher === null)
        @if($execution->course != null)
            {{--*/  $teacher = $execution->course->teachers->first()->teacher /*--}}
            @else
    {{--*/  $teacher = App\User::findOrNew(210) /*--}}
            @endif
    @endif



    <div class="modal fade" id="suggestionModal" tabindex="-1" role="dialog" aria-labelledby="suggestionLabel"></div>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-lg-3 col-md-3">
            <div class="row">
                <div class="mt-widget-2">
                    <div class="card" style="background-color: rgba(0,0,0,0)">
                        <div class="mt-head" style="position: relative;">
                            <div class="mt-head-user">

                                <div class="mt-head-user-img" style="margin-top: 0px">
                                    <img class="image-teacher" src="{{ imageurl('users/', $teacher->id, $teacher->photo, 100, 'generic.png',true) }}">
                                    <div class="mt-head-user-info" style="margin-top: 17px">
                                        <span class="label-big  @if((($execution->grade * 100)/ $questions_count) >= $minimum_percentage )
                                              label-success
                                              @else
                                              label-danger
                                              @endif">

                                            @if( (($execution->grade * 100)/ $questions_count)   >= $minimum_percentage )
                                            ÓTIMA PERFORMANCE
                                            @else
                                            PRECISA MELHORAR!
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- {{ $count = $questions_count }} -->
                <!-- {{ $attempt_time = get_questions_time($execution) }} -->
                <!-- {{ $attempt_date =  format_datebr($execution->finished_at)}} -->

                <div class="col-md-12" data-time-by-question="{{ $time_by_question = floor($attempt_time / $count) }}" data-total-time-by-question="{{ $total_time = floor(($duration * 60)/$count) }}">
                    <div class="card" style="padding-top: 4px; padding-bottom: 5px">
                        <div class="display">
                            <div class="number">
                                <h3 class="{{ $font = ($time_by_question < $total_time ? 'font-green-jungle' : 'font-red-flamingo') }}">
                                    <span data-counter="counterup" data-value="{{  $minutes = floor($time_by_question / 60) }}">{{$minutes}}</span>
                                    <small class="{{ $font }}" style="text-transform: lowercase !important; ">m</small>
                                    <span data-counter="counterup" data-value=" {{ $seconds = floor($time_by_question - ($minutes * 60)) }}">{{$seconds}}</span>
                                    <small class="{{ $font }}" style="text-transform: lowercase !important; ">s</small>
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
                                <div class="status-title" style="display: inline"> TEMPO ESPERADO  </div>
                                <div class="status-number" style="display: inline"> {{$total_minutes = floor($total_time / 60)}}m {{ floor($total_time - ($total_minutes * 60))  }}s </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12" data-time-expected="{{ $time_expected = $duration * 60 }}">
                    <div class="card"  style="padding-top: 4px; padding-bottom: 5px">
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
                                <div class="status-title" style="display: inline"> TEMPO ESPERADO  </div>
                                <div class="status-number" style="display:inline"> {{$total_hours = floor($time_expected / 3600)}}h {{ floor(($time_expected - ($total_hours * 3600))/60)  }}m </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7" id="blade-question">
            <div class="row">
                <div id="complete-result"></div>
                <div style="padding:0; padding-bottom: 10px;">
                    <div id="exam-presentation">
                        @include('frontend.studentarea.exam.main-result')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>





    </div>
    <div class="row no-padding p-bj">
        <div class="col-md-1 col-lg-1"></div>
        <div class="col-lg-10 col-md-10">
            <header class="panel-heading" style="border: 1px solid; background-color: white ">
                <h2 class="panel-title" style="color: black">
                    <div class="row">
                        <div id="result-title" class="col-md-3" data-level="{{ $level }}">

                            <strong>RESULTADOS {{ $level == 1? "POR DISCIPLINA" : "POR TEMA" }}</strong>
                        </div>
                        <div id="by-theme" class="col-md-3 text-right" style="cursor: pointer;">
                            <i class="fa fa-object-ungroup"></i> &nbsp;<strong> {{ $level ==1 ? "Por Disciplina" : "Por Tema" }}</strong>
                        </div>

                        <div id="by-subtheme" class="col-md-3 text-right" style="cursor: pointer;">
                            <i class="fa fa-object-group"></i>&nbsp; <strong> {{ $level == 1? "Por Tema" : "Por Subtema" }}</strong>
                        </div>
                        <div id="summary" class="col-md-3 text-right" style="cursor:pointer;">
                            <i class="fa fa-tasks"></i> &nbsp; <strong>Gabarito Analítico</strong>
                        </div>
                    </div>
                </h2>
            </header>
            <div class="panel-body" style="padding:0;">
                <div class="explanation ">
                    <div id="explanation-result" style="display: none">
                        {!!  $results[1] !!}
                    </div>
                    <div id="explanation-text">
                        {!!  $results[2]  !!}
                    </div>
                    <div id="explanation-summary" style="display:none">
                        @include('frontend.studentarea.exam.summary')
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1"></div>
    </div>




    @if($execution->course == null && $execution->rating == 0 && $execution->grade != null)
        <div class="row">
            <div class="col-md-1 col-lg-1"></div>
            <div class="col-md-10 col-lg-10">
                @include('frontend.studentarea.exam.rating')
            </div>

            <div class="col-md-1 col-lg-1"></div>

        </div>
    @endif




    <div class="clearfix"></div>
    @if($execution->finished != 0 && $execution->course != null)
    <div class="col-md-1 col-lg-1"></div>
    <div class="col-lg-9 col-md-9">
        @if((($execution->grade * 100)/ $count) >= $minimum_percentage)
        <div class="row" style="height: 200px">
            <div class="col-md-3">




                <div class="fotoautor" style="width: 200px;">

                    <div class="card-user">
                        <img class="img-responsive userpic" style="bottom: 0" src="{{ imageurl('users/', $teacher->id, $teacher->photo, 200, 'generic.png',true) }}">
                    </div>

                </div>
            </div>
            <div class="col-md-9 pull-left">
                <h3>  Parabéns, <strong> {{ Auth::user()->name }}</strong>,  você atingiu a performance esperada para aprovação. Verifique na área do curso se você cumpre todos os critérios para emissão do seu certificado. </h3>
                <br/>
                <a class="btn btn-success" href="{{ route('frontend.classroom.course', [$execution->enrollment->id, 'certification-pill'] ) }}" style="font-size: 1.8em; width: 50%">Área do Curso</a>

            </div>


        </div>

        @else
        <div class="row" style="height: 200px">
            <div class="col-md-3">




                <div class="fotoautor" style="width: 200px;">

                    <div class="card-user">
                        <img class="img-responsive userpic" style="bottom: 0" src="{{ imageurl('users/', $teacher->id, $teacher->photo, 200, 'generic.png',true) }}">
                    </div>

                </div>
            </div>
            <div class="col-md-9 pull-left">
                <h3>  <strong> {{ Auth::user()->name }}</strong>,  você não atingiu a performance esperada para aprovação. </h3>
                <a class="btn btn-primary" href="/classroom/course/{{$execution->enrollment->id}}" style="font-size: 1.8em; width: 50%">Área do Curso</a>

            </div>


        </div>
        @endif
    </div>
    <div class="col-md-1 col-lg-1"></div>
    @endif
    @if($execution->finished != 0 && $execution->enrollment->exam != null)
    @if($subjects = get_parents_with_courses($execution->enrollment->exam, $results[3]))@endif
    @if(exam_has_subject($execution->enrollment->exam) && $execution->enrollment->course_enrollment_id <> null ) 
    <div class="col-md-1 col-lg-1"></div>
    <div class="col-lg-9 col-md-9 course-link">
        <h1 style="color:black"><strong>|  @if((($execution->grade * 100)/ $execution->enrollment->exam->questions_count) < ($execution->enrollment->exam->minimum_percentage * 0.8)) <span style="color:#c12720; font-weight: 700"> ATENÇÃO! &nbsp;</span> @endif Melhore sua performance</strong> </h1>

        <div class="row" style="height: 200px">
            <div class="col-md-3">



                <div class="fotoautor" style="width: 200px;">

                        </div>
                    </div>
                    <div class="col-md-9 pull-left">
                        <h3>Olá,  {{ Auth::user()->name }}! Clique no tema correspondente em <strong id="scrollToGroup"> RESULTADO POR TEMA </strong> e assista a sua vídeo-aula. Para reforçar sua performance, não esqueça de executar o SAAP DA AULA caso tenha.</h3>
                    </div>


                </div>


            </div>
            <div class="col-md-1 col-lg-1"></div>
        @else

        @if(!$subjects->isEmpty() || !$execution->enrollment->exam->courses->isEmpty())
            <div class="row no-padding p-bj">
                <div class="col-md-1 col-lg-1"></div>
                <div class="col-lg-10 col-md-10">
                    <h1 style="color:black"><strong>|  @if((($execution->grade * 100)/ $execution->enrollment->exam->questions_count) < ($execution->enrollment->exam->minimum_percentage * 0.8)) <span style="color:#c12720; font-weight: 700"> ATENÇÃO! &nbsp;</span> @endif Melhore sua performance</strong> </h1>
                    <br/>
                    <div class="row" style="height: 200px">
                        <div class="col-md-3">

                        <div class="fotoautor" style="width: 200px;">

                            <div class="card-user">
                                <img class="img-responsive userpic" style="bottom: 0" src="{{ imageurl('users/', $teacher->id, $teacher->photo, 200, 'generic.png',true) }}">
                            </div>

                        </div>
                    </div>
                    <div class="col-md-9 pull-left">
                        <h3>  Oi, <strong> {{ Auth::user()->name }}</strong>, a partir da análise dos dados de desempenho do seu SAAP, sugerimos alguns cursos que podem melhorar a sua performance! </h3>
                    </div>


                </div>
                {{-- Remoção da régua dos descontos --}}
                {{-- <br/>
                <div class="row">
                    <div class="col-md-12">
                        @include('frontend.includes.courses-discount')

                    </div>
                </div> --}}

                @if($execution->enrollment->exam->id == 125 || $execution->enrollment->exam->id == 144)
                    <div class="row no-padding p-bj center">
                        <div class="col-md-1 col-lg-1"></div>
                        <div class="col-lg-10 col-md-10" >
                            <a  href="#cart" class="btn btn-success course-button" style="width:60%;height:100%; padding: 20px; font-size: 18px; font-color: white;  border:0 ;background-color: #ff8415;">
                                <strong>COMPRE AGORA OS CURSOS COM DESCONTO</strong>
                            </a>
                        </div>
                        <div class="col-md-1 col-lg-1"></div>
                    </div>
                @endif
                <br/><br>
                
                {{-- CASO OS SAAPS SEJAM TESTES GRATUITOS DE : 80 questoes ELE ENTRA AQUI --}}
                @if($execution->enrollment->exam->id <> 123 )
                <div class="col-md-6 col-sm-6" id="cart">

                    <a href="{{ route("cart.items") }}" class="btn btn-default" style="width: 100%;vertical-align: middle;">
                        <i class="fa fa-shopping-cart" style="position:relative;"></i>&nbsp;&nbsp;
                        <span id="cart-count" class="badge">{{ Cart::count() }} itens</span> &nbsp;
                        <span id="cart-price" style="display:none" class="badge"></span> &nbsp;
                        <span id="cart-discount" style="display:none" class="badge"></span> &nbsp;&nbsp;
                        {{--<span href="#" style="font-weight: bold; height:100%;  font-size: 14px; font-color: white;  border:0; "> CARRINHO</span>&nbsp;--}}
                        <i class="fa fa-arrow-right" style="position:relative; color: green;"></i>

                    </a>
                </div>
                <div class="col-md-1 col-lg-1"></div>
            </div>
            @endif
            <br/><br>


            {{-- CASO OS SAAPS SEJAM TESTES GRATUITOS DE : 80 questoes ELE ENTRA AQUI --}}
            @if($execution->enrollment->exam->id <> 123 )
            <div class="col-md-6 col-sm-6" id="cart">

                <a href="{{ route('cart.items') }}" class="btn btn-default" style="width: 100%;vertical-align: middle;">
                    <i class="fa fa-shopping-cart" style="position:relative;"></i>&nbsp;&nbsp;
                    <span id="cart-count" class="badge">{{ Cart::count() }} itens</span> &nbsp;
                    <span id="cart-price" style="display:none" class="badge"></span> &nbsp;
                    <span id="cart-discount" style="display:none" class="badge"></span> &nbsp;&nbsp;
                    {{--<span href="#" style="font-weight: bold; height:100%;  font-size: 14px; font-color: white;  border:0; "> CARRINHO</span>&nbsp;--}}
                    <i class="fa fa-arrow-right" style="position:relative; color: green;"></i>

                </a>
            </div>
            @endif
            <div class="row">
                @if(count($subjects) > 0)
                <div class="col-md-6">
                    <div class="dropdown" >
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="width: 100%"><b id="theme-menu"><i class="fa fa-thumbs-down"></i>
                                Filtrar por cursos em que não fui bem</b>
                            <span class="caret"></span>
                        </button>

                            <ul class="dropdown-menu" style="width:100%">




                                @foreach($subjects as $course_id => $course)
                                <li ><a class="choice-subject" data-subject-id="{{ $course_id }}" style="cursor: pointer">{{ App\Subject::find($course_id)->name }}</a></li>


                                @endforeach

                            </ul>

                        </div>
                    </div>
                    @endif

                </div>
                <br/>


                <div id="recomendados" class="tab-pane no-padding" style="margin:0px 0px padding:0;" >
                    <div class="row no-padding ">
                    {{-- CASO OS SAAPS SEJAM TESTES GRATUITOS DE : 80 questoes ELE ENTRA AQUI --}}

                    @if($execution->enrollment->exam->id == 123)
                    @include('frontend.studentarea.exam.complete-results-cards')

                        @else
                        {{-- FIM DO IF CASO SEJA TESTE GRATUITO DIREITO CIVIL E ÉTICA --}}


                        <div class="section curso-hor-section"><div class="space"></div>
                            @if( $execution->grade < $execution->enrollment->exam->minimum_percentage )
                            @foreach($execution->enrollment->exam->courses->filter(function($item){ return $item->is_active == 1; }) as $course)

                            <div class="col-md-6">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location ='{{ route('course',[$course->subsection->section->slug, $course->slug]) }}'">
                                            <img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>
                                        <h3 class="entry-title-big">
                                            <a href="{{ route('course',[$course->subsection->section->slug, $course->slug]) }}">{{ $course->title }}</a>
                                        </h3>
                                        <div class="entry-content">
                                            <p>{{ $course->short_description != null ? $course->short_description : ''}}</p>
                                        </div>
                                        <div class="entry-meta" >
                                            <p><strong style="color: #0F74BA;">R$ {{number_format($course->final_price, 2, ',', '.')}}</strong></p>
                                        </div>
                                        <div>
                                            <a class="add-to-cart" data-item="{{ $course->id }}" data-type="course" class="pull-right btn-plus-article" style=" cursor:pointer"><i class="fa fa-shopping-cart"></i> <strong style="color: #0F74BA;">Adicionar ao carrinho</strong></a>

                                        </div>
                                    </div>
                                </div><!--/post-->
                            </div>



                            @endforeach
                            @endif
                            @foreach(get_courses_from_parent_subjects($subjects) as $course_id => $course)

                            <div class="col-md-6 p-bj-course subject-{{ $course["subject-parent"] }}">

                                <div class="post small-post"> 
                                    <div class="entry-header">
                                        <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location ='{{ route('course',[$course["course"]->subsection->section->slug, $course["course"]->slug]) }}'">
                                            <img class="img-responsive" src="{{ imageurl("courses/", $course["course"]->id , $course["course"]->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                        </div>
                                    </div>
                                    <div class="post-content">

                                        <span class="label-small label-primary" style="background-color: {{ $course["course"]->subsection->section->color }}">{{ $course["course"]->subsection->section->name }}</span>
                                        <h3 class="entry-title-big">
                                            <a href="{{ route('course',[$course["course"]->subsection->section->slug, $course["course"]->slug]) }}">
                                                {{ $course["course"]->title }}
                                            </a>
                                        </h3>
                                        <div class="entry-content">
                                            <p>{{ $course["course"]->short_description != null ? $course["course"]->short_description : ''}}</p>
                                        </div>
                                        <div class="entry-meta">
                                            <p><strong style="color: #0F74BA;">R$ {{number_format($course["course"]->final_price, 2, ',', '.')}}</strong></p>
                                        </div>
                                        <div>
                                            <a class="add-to-cart" data-item="{{ $course["course"]->id }}" data-type="course" class="pull-right btn-plus-article" style=" cursor:pointer"><i class="fa fa-shopping-cart"></i> <strong style="color: #0F74BA;">Adicionar ao carrinho</strong></a>
                                        </div>
                                    </div>
                                </div><!--/post-->
                            </div>

                            @endforeach
                        </div>
                        @endif 
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-lg-2"></div>

        </div>
    @else
    <div id="recomendados" class="tab-pane no-padding" style="margin:0px 0px padding:0;" >
        <div class="row"><div class="col-md-1"></div>
            <div class="col-md-10">

                @if($subjects = get_parents_with_packages($execution->enrollment->exam, $results[4]))@endif

                <div class="row no-padding ">
                    <div class="section curso-hor-section">
                        <div class="section curso-small">


                            @if(stripos($execution->enrollment->exam->title, 'oab') !== false )
                            @if($subjects->isEmpty())
                            <h1 style="color:black; padding-top:15px"><strong>|  Adquira outros SAAP's</strong> </h1>
                            @else
                            <h1 style="color:black"><strong>|  @if((($execution->grade * 100)/ $execution->enrollment->exam->questions_count) < ($execution->enrollment->exam->minimum_percentage * 0.8)) <span style="color:#c12720; font-weight: 700"> ATENÇÃO! &nbsp;</span> @endif Melhore sua performance</strong> </h1>
                            <br/>
                            <div class="row" style="height: 200px">
                                <div class="col-md-3">




                                    <div class="fotoautor" style="width: 200px;">

                                        <div class="card-user">
                                            <img class="img-responsive userpic" style="bottom: 0" src="{{ imageurl('users/', $teacher->id, $teacher->photo, 200, 'generic.png',true) }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-9 pull-left">
                                    <h3>  Oi, <strong> {{ Auth::user()->name }}</strong>, a partir da análise dos dados de desempenho do seu SAAP, sugerimos alguns cursos que podem melhorar a sua performance! </h3>
                                </div>


                            </div>


                            @endif
                            <br/>


                            @include('frontend.includes.exams-discount')
                            <br/>
                            @endif


                            @if(!$subjects->isEmpty())

                            <div class="row" style="padding-bottom: 30px">
                                <div class="col-md-6">
                                    <div class="dropdown" >
                                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="width: 100%"><b id="theme-menu"><i class="fa fa-thumbs-down"></i>
                                                Filtrar por disciplinas em que não fui bem</b>
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu" style="width:100%">



                                            @foreach($subjects as $package_id => $package)
                                            <li><a class="choice-subject" data-subject-id="{{ $package_id }}" style="cursor: pointer">{{ App\Subject::find($package_id)->name }}</a></li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">

                                    <a href="{{ route("cart.items") }}" class="btn btn-default" style="width: 100%;vertical-align: middle;">
                                        <i class="fa fa-shopping-cart" style="position:relative;"></i>&nbsp;&nbsp;
                                        <span id="cart-count" class="badge">{{ Cart::count() }} itens</span> &nbsp;
                                        <span id="cart-price" style="display:none" class="badge"></span> &nbsp;
                                        <span id="cart-discount" style="display:none" class="badge"></span> &nbsp;&nbsp;
                                        {{--<span href="#" style="font-weight: bold; height:100%;  font-size: 14px; font-color: white;  border:0; "> CARRINHO</span>&nbsp;--}}
                                        <i class="fa fa-arrow-right" style="position:relative; color: green;"></i>

                                    </a>
                                </div>

                            </div>


                            @foreach(get_packages_from_parent_subjects($subjects) as $index => $package)


                            <div class="col-md-6 p-bj-course subject-{{ $package["subject-parent"]}}">

                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location ='{{ route('packages.show',[$package["package"]->slug]) }}'">
                                            <img class="img-responsive" src="{{ imageurl("packages/", $index ,$package["package"]->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <span class="label-small label-primary" style="background-color: {{ $package["package"]->subsection->section->color }}">{{ $package["package"]->subsection->section->name }}</span>
                                        <h3 class="entry-title-big">
                                            <a href="{{ route('packages.show', [$package["package"]->slug]) }}">{{ $package["package"]->title }}</a>
                                        </h3>
                                        <div class="entry-content">
                                            <p>{{ $package["package"]->short_description != null ? $package["package"]->short_description : ''}}</p>
                                        </div>
                                        <div class="entry-meta">
                                            <p>
                                                @if ($package["package"]->final_price == 0.00)
                                                <strong  class="label label-success">GRATUITO</strong>
                                                @else
                                                <strong>R$ {{number_format($package["package"]->final_price, 2, ',', '.')}} </strong>
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <a class="add-to-cart" data-item="{{ $package["package"]->id }}" data-type="package" class="pull-right btn-plus-article" style=" cursor:pointer"><i class="fa fa-shopping-cart"></i> Adicionar ao carrinho</a>
                                        </div>
                                    </div>
                                </div><!--/post-->
                            </div>


                            @endforeach

                            @else
                            @if(stripos($execution->enrollment->exam->title, 'oab') !== false )
                            @foreach($packages as $index => $package)

                            <div class="col-md-6 p-bj-course">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location ='{{route('packages.show',  [$package->slug]) }}'">
                                            <img class="img-responsive" src="{{ imageurl("packages/", $package->id ,$package->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <span class="label-small label-primary" style="background-color: {{ $package->subsection->section->color }}">{{ $package->subsection->section->name }}</span>
                                        <h3 class="entry-title-big">
                                            <a href="{{route('packages.show', [$package->slug]) }}">{{ $package->title }}</a>
                                        </h3>

                                        <div class="entry-content">
                                            <p>{{ $package->short_description != null ? $package->short_description : ''}}</p>
                                        </div>
                                        <div class="entry-meta">
                                            <p>
                                                @if ($package->final_price == 0.00)
                                                <strong  class="label label-success">GRATUITO</strong>
                                                @else
                                                <strong>R$ {{number_format($package->final_price, 2, ',', '.')}} </strong>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div><!--/post-->
                            </div>

                            @endforeach
                            @endif
                            @endif
                        </div><!--/.section-->
                    </div><!--/.row-->
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    @endif
    @endif
    @endif
</section>


@endsection
