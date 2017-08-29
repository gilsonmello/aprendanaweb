@extends('frontend.layouts.master-classroom')

@section('content')

<section role="main" class="content-body">
    <?php $origin = app('session')->get('origin');?>
    <header class="page-header">
        @if($content->lesson->module != null)
        @if($content->lesson->module->course != null)
        <h2>{{ str_limit( $content->lesson->module->course->title, 50) }} - {{ str_limit($content->lesson->module->name, 20) }} - Aula {{ $content->lesson->sequence }}</h2>
        @else
        <h2>{{ $content->lesson->module->name }}</h2>
        @endif
        @else
        <h2>{{ str_limit($content->lesson->title, 60) }}</h2>
        @endif

        <!--
<div class="right-wrapper pull-right">
<ol class="breadcrumbs">
    <li>
        <a href="index.html">
        <a href="index.html">
            <i class="fa fa-home"></i>
        </a>
    </li>
    <li><span>Área do Aluno</span></li>

    @if($content->lesson->module != null)
@if($content->lesson->module->course != null)
        <li><span>{{ $content->lesson->module->course->title }}</span></li>
        @else
        <li><span>{{ $content->lesson->module->name }}</span> </li>
        @endif
@else
        <li><span>{{ $content->lesson->title }} </span></li>
    @endif
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div> -->
    </header>


    <!-- start: page -->

    <div id="actual-content" data-lesson-exam="{{ $content->lesson->groups->isEmpty() ? "false" : "true" }}" data-classroom-exam="{{ $course_exam ? "true" : "false" }}" data-view="{{ $view }}" data-actual-content="{{ $actual_content }}"  style="visibility: hidden;"></div>
    <div class="row">
        <div class="col-md-7">
            @if($content->lesson->is_active == 1)
            <section class="panel">
                <div class="panel-body panel-body-nopadding">
                    <div id="exceeded"></div>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe width="100%" class="embed-responsive-item" name="lesson-content" data-content="{{ $content->id }}" data-lesson="{{ $content->lesson->id }}" data-enrollment="{{ $enrollment->id }}" data-url='{{ $content->url }}' height="400" src="" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="panel-footer panel-footer-btn-group panel-footer-class">
                    <span>BLOCOS</span>
                    @foreach ($content->lesson->contents as $contentList)
                    @if ($contentList->is_video == 1)
                    <a href="/classroom/{{ $contentList->lesson->module->course->id }}/{{ $contentList->lesson->module->id }}/{{ $contentList->lesson->id }}/{{ $contentList->sequence }}/{{ $enrollment->id }}" name="block-{{ $contentList->sequence }}" data-block="{{ $contentList->sequence }}" class="block @if($content->sequence == $contentList->sequence) active @endif"> {{ $contentList->sequence }} </a>
                    @endif
                    @endforeach

                </div>

                @if(!$content->lesson->groups->isEmpty())

                @if(!has_execution_in_lesson_finished($enrollment,$content->lesson))
                    <div class="container row classroom-exam-suggestion no-padding" style="padding-top: 20px;">
                        <a id="clickSaap" class="btn btn-primary btn_ticket_send" style="text-transform: uppercase;cursor: pointer; background-color: #075890;">
                            @if(!is_null($origin) || $enrollment->course_id === 566)
                                AVALIAÇÃO EXCLUSIVA DE PERFORMANCE
                             @elseif($enrollment->course->custom_exam_title != null)
                                {{ $enrollment->course->custom_exam_title }}
                            @else
                                Clique aqui e teste seus conhecimentos executando o SAAP da aula
                            @endif
                        </a>
                    </div>
                @else
                    <div class="container row classroom-exam-suggestion no-padding" style="padding-top: 20px;">
                        <a id="clickSaap" class="btn btn-primary btn_ticket_send" style="cursor: pointer; background-color: #075890; text-transform: uppercase">
                            @if(!is_null($origin) || $enrollment->course_id === 566)
                                VEJA SEU DESEMPENHO EXCLUSIVO DE PERFORMANCE
                            @elseif($enrollment->course->custom_exam_title != null)
                                {{ $enrollment->course->custom_exam_title }} - Veja seu desempenho
                            @else
                                Veja o seu desempenho no SAAP desta aula
                            @endif
                        </a>
                    </div>
                @endif
                @endif
            </section>
            @else
            <section class="panel">

                <div class="panel-body panel-body-nopadding" style="min-height: 400px; background-color: black" >
                    <p style="text-align: center; margin-top: 27%"><span class="label label-info" style="font-size: 40px;">Em breve</span></p>
                </div>

            </section>
            @endif
        </div>
        <div class="col-md-5">

            @if ( $enrollment->partner_id != null)
            <div class="panel-group" style="border:0;">
                <div class="panel panel-accordion panel-featured panel-featured-primary" >
                    <div class="panel-heading" style="background:#FFF; padding: 30px;">
                        <div class="row">
                            <img src="{{ imageurl('partners/',$enrollment->partner_id, $enrollment->partner->logo, 100, 'generic.png', false) }}">
                            <span style="padding-left: 20px; color: #0088cc; font-size: 20px; font-weight: bold;">Turma {{ $enrollment->studentgroup->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <div class="panel-group" id="accordionPrimary" style="border:0;">
                <div id="panel-rating-bj" class="panel panel-accordion panel-featured panel-featured-primary">
                    <div class="panel-heading" style="background:#FFF">
                        <h4 class="panel-title">
                            <a class="accordion-toggle">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <span style=" color: #777; font-weight: bold; ">Visualizações</span>&nbsp;&nbsp;&nbsp;<span id="show-view"></span>
                                    </div>
                                </div>
                            </a>
                        </h4>
                    </div>
                </div>

                <div id="panel-rating-bj" class="panel panel-accordion panel-featured panel-featured-primary">
                    <div class="panel-heading" style="background:#FFF">
                        <h4 class="panel-title">
                            <a class="accordion-toggle">
                                <div class="row">
                                    <div class="col-xs-6" >
                                        <span style=" color: #777; font-weight: bold; ">Conteúdo</span>&nbsp;&nbsp;
                                        <i class="fa fa-thumbs-o-up" href="#" id="thumbs-up-content" style="cursor:pointer"></i>
                                        &nbsp;&nbsp;
                                        <i class="fa fa-thumbs-o-down" href="#" id="thumbs-down-content" style="cursor:pointer"></i>
                                    </div>
                                    <div class="col-xs-6">
                                        <span style=" color: #777; font-weight: bold; ">Didática</span>&nbsp;&nbsp;
                                        <i class="fa fa-thumbs-o-up" href="#" id="thumbs-up-teaching" style="cursor:pointer"></i>
                                        &nbsp;&nbsp;
                                        <i class="fa fa-thumbs-o-down" href="#" id="thumbs-down-teaching" style="cursor:pointer"></i>
                                    </div>
                                </div>
                                @include('frontend.studentarea.classroom.rating')
                            </a>
                        </h4>
                    </div>
                </div>

                @if($hideContent = 0)@endif
                @if (($content->lesson->module->course->generate_certificate != null) && ($content->lesson->module->course->generate_certificate == 1))
                @if(get_total_percentage_completed($enrollment) >= $enrollment->course->percentage_certificate)
                <div id="panel-rating-bj" class="panel panel-accordion panel-featured panel-featured-primary">
                    <div class="panel-heading" style="background:#FFF">
                        <h4 class="panel-title">
                            @if($hideContent = 1) @endif


                            @if( $enrollment->course->groups  !== null && !($enrollment->course->groups->isEmpty()) &&  $enrollment->executions->isEmpty())

                            @include('frontend.studentarea.classroom.exam.course_exam_modal')

                            <a class="accordion-toggle" data-toggle="modal" href="#displayModal">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <span style=" color: #47a447; font-weight: bold; cursor: pointer;" >FAÇA AQUI SUA PROVA</span>
                                    </div>
                                </div>
                            </a>


                            @elseif($enrollment->course->groups == null || $enrollment->course->groups->isEmpty() ||  $enrollment->executions->first()->grade * 100 / ($enrollment->executions->first()->questions_executions->count()) > $enrollment->course->minimum_percentage)
                            @if(  ($enrollment->student->personal_id != null)  && ($enrollment->student->personal_id != ''))


                            <a class="accordion-toggle" href="{{ route('frontend.classroom.certificate', $enrollment->id ) }}">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <span style=" color: #47a447; font-weight: bold; cursor: pointer;" >EMITA AQUI SEU CERTIFICADO</span>
                                    </div>
                                </div>
                            </a>
                            @else

                            <a class="accordion-toggle" href="{{ route('profile.edit',Auth::user()->id) }}">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <span style=" color: #47a447; font-weight: bold; cursor: pointer;" >INFORME SEU CPF PARA EMISSÃO DO CERTIFICADO</span>
                                    </div>
                                </div>
                            </a>

                            @endif
                            @endif
                        </h4>
                    </div>
                </div>
                @endif
                @endif

                @if (($content->lesson->module->course->course_content != null) && ($content->lesson->module->course->course_content != '') && $hideContent == 0)
                <div id="panel-rating-bj" class="panel panel-accordion panel-featured panel-featured-primary">
                    <div class="panel-heading" style="background:#FFF">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" onclick="javascript:courseContent({{     $content->lesson->module->course->id  }});">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <span style=" color: #777; font-weight: bold; cursor: pointer;" >Conteúdo Programático</span>
                                    </div>
                                </div>
                            </a>
                        </h4>
                    </div>
                </div>
                @endif



                @if(!$content->lesson->groups->isEmpty())
                <div  class="panel panel-accordion panel-featured panel-featured-primary">
                    <div class="panel-heading" style="background:#FFF">
                        <h4 class="panel-title">
                            <a id="classroomExamButton" data-modal="toggle" name="block-exam" class="accordion-toggle">
                                <div class="row">
                                    <div class="col-xs-12">
                                        @if($enrollment->course->id==566)
                                        <span style=" color: #777; font-weight: bold; cursor: pointer;" >AVALIAÇÃO EXCLUSIVA DE PERFORMANCE</span>
                                            @elseif($enrollment->course->custom_exam_title != null)
                                            <span style=" color: #777; font-weight: bold; cursor: pointer;" > {{ $enrollment->course->custom_exam_title }}</span>

                                        @else
                                        <span style=" color: #777; font-weight: bold; cursor: pointer;" >  <img alt="" src="/img/system/saap2.png" style="width: 45px; margin-top: -3px;"> da Aula</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </h4>
                    </div>
                    <div class="modal fade" id="classroomExamModal"  tabindex="-1" role="dialog" >@include('frontend.studentarea.classroom.exam.classroom_exam')</div>

                </div>


                @endif


                <div class="panel panel-accordion panel-accordion-bj " >
                    <div class="panel-heading active" style="">
                        <h4 class="panel-title" style="background-color: white;">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionPrimary" href="#collapsePrimaryOne" style=" color: #777; font-weight: bold; ">
                                Anotações
                            </a>
                        </h4>
                    </div>
                    <div id="collapsePrimaryOne" class="accordion-body collapse in">
                        <div class="panel-body">
                            <div id="accordion">
                                <ul id="note-panel" class="widget-todo-list" style="max-height: 200px;overflow: auto;">

                                </ul>
                                <hr class="solid mt-sm mb-lg">

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="input-group mb-md">
                                            <input type="text" id="text-todo" class="form-control" placeholder="Escreva sua anotação...">
                                            <div class="input-group-btn">
                                                <button type="button" id="add-todo" class="btn btn-success" tabindex="-1">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!$files->isEmpty())
                <div class="panel panel-accordion panel-accordion-bj">
                    <div class="panel-heading">
                        <h4 class="panel-title" style="background-color: white;">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionPrimary" href="#collapsePrimaryTwo"  style=" color: #777; font-weight: bold; ">
                                Material de Apoio
                            </a>
                        </h4>
                    </div>
                    <div id="collapsePrimaryTwo" class="accordion-body collapse">
                        <div class="panel-body" style="padding: 30px; font-size: 1.2em;">

                            @foreach($files as $file)

                            @if(get_filetype($file->url) == '.pdf')
                            <i class="fa fa-file-pdf-o"></i><a href="/{{ $file->url  }}" target="_blank">&nbsp;&nbsp;{{ $file->title }}</a><br>
                            @elseif(get_filetype($file->url) == '.pps')
                            <i class="fa fa-file-powerpoint-o"></i><a href="/{{ $file->url  }}" target="_blank">&nbsp;&nbsp;{{ $file->title }}</a><br>
                            @elseif(get_filetype($file->url) == '.doc' || $file->url == '.docx')
                            <i class="fa fa-file-word-o"></i><a href="/{{ $file->url  }}" target="_blank">&nbsp;&nbsp;{{ $file->title }}</a><br>
                            @elseif(get_filetype($file->url) == '.png' ||$file->url == '.jpg' || get_filetype($file->url) == 'jpeg')
                            <i class="fa fa-file-image-o"></i><a target="_blank" href="/{{ $file->url  }}" target="_blank">&nbsp;&nbsp;{{ $file->title }}</a><br>
                            @else
                            <i class="fa fa-file"></i><a href="/{{ $file->url  }}" target="_blank">&nbsp;&nbsp;{{ $file->title }}</a><br>
                            @endif

                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{--<div class="panel panel-accordion panel-accordion-bj">--}}
                {{--<div class="panel-heading">--}}
                {{--<h4 class="panel-title" style="background-color: white;">--}}
                {{--<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionPrimary" href="#collapsePrimaryThree"  style=" color: #777; font-weight: bold; ">--}}
                {{--Comentários--}}
                {{--</a>--}}
                {{--</h4>--}}
                {{--</div>--}}
                {{--<div id="collapsePrimaryThree" class="accordion-body collapse">--}}
                {{--<div id="comments-content" class="panel-body">&nbsp;</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                @if($enrollment->course->ask_the_teacher == 1)
                <div class="panel panel-accordion panel-accordion-bj " >
                    <div class="panel-heading" style="">
                        <h4 class="panel-title" style="background-color: white;">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionPrimary" href="#collapsePrimaryFour" style=" color: #777; font-weight: bold; ">
                                Fale com o Professor
                            </a>
                        </h4>
                    </div>
                    <div id="collapsePrimaryFour" class="accordion-body collapse">
                        <div class="panel-body">
                            <div id="accordion">
                                <div class="form-group" id="asktheteacher_return" style="padding-left: 15px; color: #449a43;">
                                </div>
                                <div class="form-group" style="padding-left: 15px;">
                                    {!! Form::hidden('askTheTeacher_lesson_id', $content->lesson_id, ['id' => 'askTheTeacher_lesson_id']  ) !!}
                                    {!! Form::label('questionAskTheTeacher', 'Escreva aqui a sua dúvida', ['class' => 'control-label']) !!}
                                    <br/>
                                    {!! Form::textarea('questionAskTheTeacher', '', ['class' => 'form-control', 'id' => 'questionAskTheTeacher', 'rows' => 5, 'style' => 'width:100%;'] ) !!}
                                    <br/>
                                    {!! Form::button( trans('strings.send') , ['class' => 'btn btn-success button-askTheTeacherClassroom']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="panel panel-accordion panel-accordion-bj">
                    <div class="panel-heading">
                        <h4 class="panel-title" style="background-color: white;">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionPrimary" href="#collapsePrimaryThree"  style=" color: #777; font-weight: bold; ">
                                Fale Conosco
                            </a>
                        </h4>
                    </div>
                    <div id="collapsePrimaryThree" class="accordion-body collapse">
                        <div id="comments-content" class="panel-body">
                            <div class="form-group" id="ticket_return" style="padding-left: 15px; color: #449a43;">
                            </div>
                            <div class="form-group">
                                {!! Form::hidden('ticket_content_id', $content->id, ['id' => 'ticket_content_id']  ) !!}
                                {!! Form::hidden('ticket_enrollment_id', $enrollment->id, ['id' => 'ticket_enrollment_id']  ) !!}
                                <div class="col-md-12">
                                    {!! Form::label('sectors', 'Escolha o assunto', ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-12">
                                    {!! Form::select("sectors[]",$sector->lists("name","id"), null, ['id' => 'ticket_sector_id', 'class' => '', 'placeholder' => trans('strings.choice_sector') ])  !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    {!! Form::textarea('message', null, ['id' => 'ticket_message', 'rows' => '4',  'class' => 'form-control', 'placeholder' => trans('strings.message')]) !!}
                                </div>
                            </div>
                            <!--form control-->


                            <div class="form-group" style="padding-left: 15px;">
                                <input type="submit" class="btn btn-success btn_ticket_send" value="{{ trans('strings.send') }}"/>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            @if($type != 'lesson')

            @endif
        </div>


    </div>
    @if($type != 'lesson')
    <div class="row">
        <div class="course-clasroom col-md-7">
            <section class="panel">
                <header class="panel-heading" style="background: white;"><h2 class="panel-title" style="color:#777;">Aulas {{ (($content->lesson->module->course->workload_presential == null) || ($content->lesson->module->course->workload_presential == 0)) ? "" : "Complementares" }} de <strong>{{$content->lesson->module->name}}</strong></h2></header>
                <div class="panel-body">
                    <div class="">
                        <table class="table table-hover mb-none" style="font-size:1.6rem">
                            <tbody>
                                @foreach ($lessons as $lessonlist)
                                @if(!$lessonlist->contents->isEmpty())
                                <tr class="{{ ($lessonlist->id === $content->lesson->id ? "active" : "") }} lesson-list">
                                    <td width="80%">
                                        @if($lessonlist->is_active)
                                        <a href="/classroom/{{ $content->lesson->module->course->id }}/{{ $lessonlist->module->id }}/{{ $lessonlist->id }}/1/{{ $enrollment->id }}">
                                            @if ($lessonlist->id === $content->lesson->id)
                                            <strong style="color:#075890;">
                                                @endif

                                                Aula {!! $lessonlist->sequence !!}{!! $lessonlist->title != null && $lessonlist->title != '' ? ' - ' . $lessonlist->title : '' !!}
                                                @if ($lessonlist->id === $content->lesson->id)
                                            </strong>
                                            @endif
                                        </a>
                                        @else
                                        <a href="#">
                                            @if ($lessonlist->id === $content->lesson->id)
                                            <strong style="color:grey !important;">
                                                @endif

                                                <span style="color:grey; cursor:default">Aula {!! $lessonlist->sequence !!}{!! $lessonlist->title != null && $lessonlist->title != '' ? ' - ' . $lessonlist->title : '' !!}</span>
                                                @if ($lessonlist->id === $content->lesson->id)
                                            </strong>
                                            @endif
                                        </a>
                                        @endif
                                    </td>

                                    <td  width="10%" style="color: #54ce4a;"><span class="label label-info">{{ $lessonlist->is_active == 0 ? "Em breve" : ""  }}</span>
                                        @if(is_array($lessonlist->viewed))

                                        <div class="row text-center lesson-progress">
                                            @foreach($lessonlist->viewed as $index => $view)

                                            <span class="label label-success @if($view == 0) label-not-viewed @endif @if($index + 1 == $content->sequence && $lessonlist->id === $content->lesson->id) active @endif"  @if($index + 1 == $content->sequence && $lessonlist->id === $content->lesson->id)  title="Ativo" @elseif($view !== false) title='{{ $view }} @if($view == 1)visualização @else visualizações @endif' @endif data-index="{{ $index + 1 }}">&nbsp;</span>


                                            @endforeach
                                        </div>
                                        @else
                                        @if($lessonlist->contents->where('is_video',1) == null || $lessonlist->contents->whereLoose('is_video',1)->count() == 0)

                                        <span class="label label-info">Em breve</span>

                                        @else
                                        <div class="row text-center">
                                            <span class="label label-success">{{ ($lessonlist->viewed === false ? "" : "Assistida") }}</span>
                                        </div>
                                        @endif
                                        @endif

                                    <td class="actions"  width="10%">
                                        @if($lessonlist->is_active)
                                        <a href="/classroom/{{ $content->lesson->module->course->id }}/{{ $lessonlist->module->id }}/{{ $lessonlist->id }}/1/{{ $enrollment->id }}">
                                            <i class="fa fa-play" style="color:#075890;" ></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <div class="course-clasroom col-md-5">
            <section class="panel">
                <header class="panel-heading" style="background-color: white;"><h2 class="panel-title" style="color:#777;">Disciplinas / Conteúdos {{ (($content->lesson->module->course->workload_presential == null) || ($content->lesson->module->course->workload_presential == 0)) ? "" : "Online" }} de <a href="/classroom/course/{{$enrollment->id}}"><strong>{{$content->lesson->module->course->title}}</strong></a></h2></header>
                <div class="panel-body">
                    <div class="">
                        <table class="table table-hover mb-none" style="font-size:1.6rem">

                            <tbody>


                                @foreach ($modules->sortBy('sequence') as $modulelist)
                                @if(!$modulelist->lessons->isEmpty())
                                {{--*/ $contentlist = get_module_first_content($modulelist); /*--}}

                                {{--*/ $colorpercentage = ($modulelist->percentage_viewed < 40 ? "danger" : ($modulelist->percentage_viewed < 70 ? "warning" : "success")); /*--}}
                                @if ($contentlist != null)
                                <tr>
                                    <td width="50%">
                                        <a href="/classroom/{{ $content->lesson->module->course->id }}/{{ $modulelist->id }}/{{ $contentlist->lesson_id }}/1/{{ $enrollment->id }}">
                                            {{ $modulelist->name }}
                                        </a>
                                    </td>
                                    <td width="30%">
                                        <div class="progress" style="height:4px; margin-top: 10px">
                                            <span style="width: {{ $viewed =  $modulelist->percentage_viewed }}%;" class="progress-bar progress-bar-{{ $colorpercentage }}">
                                                <span class="sr-only">{{ $viewed }}% progress</span>
                                            </span>
                                        </div>
                                    </td>

                                    <td width="20%" class="text-right">
                                        <span class="label label-{{ $colorpercentage }}">
                                            {{ number_format($viewed, 0, ',', '.' ) }} %
                                        </span>
                                    </td>
                                </tr>
                                @endif
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @endif
</section>

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