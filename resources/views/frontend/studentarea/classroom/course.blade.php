@extends('frontend.layouts.master-classroom')
@section('content')

<!-- <p>Atingido: {{ $actual = get_total_percentage_completed($enrollment)}}% | Esperado: {{ $ideal = get_ideal_percentage($enrollment->date_end,$enrollment->date_begin) }}%</p> -->

<section role="main" class="content-body">
    <header class="page-header">
        <h2>{{ str_limit($course->title, 60) }}</h2>
    </header>

    <div id="course" class="container">

        {{--*/ $teacher = null /*--}}
        @if (count($enrollment->course->teachers) != 0)
        {{--*/ $teacher = $enrollment->course->teachers->random()->teacher /*--}}
        @endif
        @if ($teacher === null)
        {{--*/ $teacher = App\User::findOrNew(210) /*--}}
        @endif

        <div id="top-row" class="row">
            @include('frontend.studentarea.classroom.course.view-info')
        </div>


        {{--<div class="row">--}}
        {{--<div class="col-md-3" id="side-panel">--}}
        {{--<div id="teacher-advice" class="row" style="padding-top: 30px;">--}}
        {{--@include('frontend.studentarea.classroom.course.teacher_advice')--}}
        {{--</div>--}}

        {{--<div id="actions" class="row">--}}
        {{--@include('frontend.studentarea.classroom.course.actions')--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div id="center-panel" class="col-md-9" style="padding: 10px;">--}}

        {{--@include('frontend.studentarea.classroom.course.daily-watched-time')--}}

        {{--</div>--}}
        {{--</div>--}}

        <br>

        <div id="tabs-section" data-default={{$default_tab}} class="row" style="padding-left: 20px; margin-top: -40px;">
            <div id="pill-block" class="row" role="navigation">
                <div class="col-md-12" style="padding: 10px;">
                    <ul class="nav nav-pills nav-justified equal " style="color: black">
                        @if (count($examenrollments) != 0)
                        <li id="exams-pill" role="presentation" class="parent-pill active"><a data-toggle="pill" class="noCalendar card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#exams-tab"><h3>Iniciar pelos SAAPs</h3></a></li>
                        <li id="modules-pill" role="presentation" class="parent-pill"><a data-toggle="pill" class="noCalendar card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#module-tab"><h3>Vídeo-aulas</h3></a></li>
                        @else
                        <li id="modules-pill" role="presentation" class="parent-pill active"><a data-toggle="pill" class="noCalendar card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#module-tab"><h3>Vídeo-aulas</h3></a></li>
                        @endif
                        @if (count($workshops) != 0)
                        <li id="workshops-pill" role="presentation" class="parent-pill"><a data-toggle="pill" class="noCalendar card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#workshops-tab"><h3>{{ $course->custom_workshop_title != null ? $course->custom_workshop_title . 's' : "Oficinas" }} </h3></a></li>
                        @endif

                        @if(count($webinars) > 0)
                        <li id="webinar-pill" role="presentation" class="parent-pill"><a data-toggle="pill" class="noCalendar card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#webinar-tab"><h3>Webinar</h3></a></li>
                        @endif
                        <li id="calendar-pill" role="presentation" class="parent-pill"><a id="calendar-pill" data-toggle="pill" class="calend card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#calendar-tab"><h3>Calendário</h3></a></li>
                        <li id="board-pill" role="presentation" class="parent-pill"><a data-toggle="pill" class="noCalendar card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#board-tab"><h3>Quadro de avisos</h3></a></li>
                        <li id="material-pill" role="presentation" class="parent-pill"><a data-toggle="pill" class="noCalendar card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#material-tab"><h3>Material de Apoio</h3></a></li>
                            @if (($course->generate_certificate == 1))
                        <li id="certification-pill" role="presentation" class="parent-pill"><a data-toggle="pill" class="noCalendar card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#certificate-tab"><h3>Emitir Certificado</h3></a></li>
                            @endif
                        @if(!$exams->isEmpty())
                        <li id="exam-pill" role="presentation" class="parent-pill "><a data-toggle="pill" class="noCalendar card mb-md mt-md mr-md pb-lg pt-lg course-pill" href="#exam-tab"><h3>SAAP - Avalie Sua Performance</h3></a></li>
                        @endif
                    </ul>
                </div>

            </div>



            <div class="row" >
                <div class="col-md-12" >
                    <div id="tabs-content" class="tab-content">


                        @if (count($examenrollments) != 0)
                        <div id="exams-tab" class="tab-pane fade in active">
                            <section class="panel">
                                <div class="panel-body">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">SAAP's</span>
                                    @include('frontend.studentarea.classroom.course.exams')
                                </div>
                            </section>
                        </div>
                        @endif

                        <div id="module-tab" class="tab-pane fade in
                             @if ( count($examenrollments) == 0)
                             active
                             @endif ">

                            @include('frontend.studentarea.classroom.course.actions')

                            @if (count($modulesonline))
                            <section class="panel">
                                <div class="panel-body">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Disciplinas / Conteúdos</span>

                                    @include('frontend.studentarea.classroom.course.module')
                                </div>
                            </section>
                            @endif

                            @if (count($modulescomplementary))
                            <section class="panel">
                                <div class="panel-body">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Disciplinas Online Complementares</span>
                                    @include('frontend.studentarea.classroom.course.module-complementary')
                                </div>
                            </section>
                            @endif

                            @if (($course->online_for_presential == 1) && (count($modulespresential)))
                            <section class="panel">
                                <div class="panel-body">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Aulas presenciais disponibilizadas online</span>
                                    @include('frontend.studentarea.classroom.course.module-presential')
                                </div>
                            </section>
                            @endif

                        </div>

                        @if (count($workshops) != 0)
                        <div id="workshops-tab" class="tab-pane fade">
                            <section class="panel">
                                <div class="panel-body">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">{{ $course->custom_workshop_title != null ? $course->custom_workshop_title . 's' : "Oficinas" }} </span>

                                    @include('frontend.studentarea.classroom.course.workshops')
                                </div>
                            </section>
                        </div>
                        @endif

                        <div id="calendar-tab" >
                            @if ($course->show_calendar)
                            <section class="panel">
                                <div class="panel-body"  style="font-size: 1.6rem;">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Calendário</span>
                                    @include('frontend.studentarea.classroom.course.fullcalendar')   
                                </div>
                            </section>
                            @endif
                        </div>


                        @if(count($webinars) > 0)
                        <div id="webinar-tab" class="tab-pane fade" >
                            <section class="panel">
                                <div class="panel-body"  style="font-size: 1.6rem;">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Webinars</span>
                                    @include('frontend.studentarea.classroom.course.webinars')   
                                </div>
                            </section>
                        </div>
                        @endif

                        <div id="board-tab" class="tab-pane fade">
                            @if ($course->show_alert)
                            <section class="panel">
                                <div class="panel-body"  style="font-size: 1.6rem;">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Quadro de Avisos</span>
                                    @include('frontend.studentarea.classroom.course.alert-board')
                                </div>
                            </section>
                            @endif


                        </div>
                        <div id="material-tab" class="tab-pane fade">


                            @if (($course->show_files) && (count($course->course_contents->whereLoose('is_video', 0))))
                            <section class="panel">
                                <div class="panel-body" style="font-size: 1.6rem;">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Material de Apoio - Geral do Curso</span>
                                    <hr>
                                    @include('frontend.studentarea.classroom.course.course-material')
                                </div>
                            </section>
                            @endif


                            @if (($course->show_files) && (count($modulescomplementary)) )
                            <section class="panel">
                                <div class="panel-body" style="font-size: 1.6rem;">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Material de Apoio - Aulas Online Complementares</span>
                                    <hr>
                                    @include('frontend.studentarea.classroom.course.material')
                                </div>
                            </section>
                            @endif

                            @if (($course->show_files) && (count($modulesonline)))
                            <section class="panel">
                                <div class="panel-body" style="font-size: 1.6rem;">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Material de Apoio - Aulas Online</span>
                                    <hr>
                                    @include('frontend.studentarea.classroom.course.material-online')
                                </div>
                            </section>
                            @endif



                        </div>
                        <div id="certificate-tab" class="tab-pane fade">
                            @if (($course->generate_certificate == 1))
                            <section class="panel">
                                <div class="panel-body" style="font-size: 1.6rem;">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Emissão de Certificado</span>
                                    <hr>
                                    @include('frontend.studentarea.classroom.course.certificate')
                                </div>
                            </section>
                            @endif

                        </div>
                        <div id="exam-tab" class="tab-pane fade">
                            @if($exams != null && !$exams->isEmpty())
                            <section class="panel">
                                <div class="panel-body" style="font-size: 1.6rem;">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold">Avalie sua Performance agora com o SAAP</span>
                                    <hr>
                                    @include('frontend.studentarea.classroom.course.exam')
                                </div>
                            </section>
                            @endif


                        </div>

                        <div id="course-contents-tab" class="tab-pane fade">
                            <section class="panel">
                                <div class="panel-body" style="font-size: 1.6rem;">
                                    <span class="panel-title" style="color:#777777; margin-left: 7px; font-weight: bold"> Conteúdo Programático</span>
                                    <table class="table mb-none" style="margin-top: 5px;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {!!   $course->course_content  !!}

                                                </td>
                                            </tr>
                                    </table>
                                </div>
                            </section>

                        </div>
                    </div>
                </div>
            </div>
        </div>

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
</section>


@endsection
