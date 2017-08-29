@extends('frontend.layouts.master-classroom')

@section('content')
<div id="nav-classroom">
    <div class="col-xs-1 no-padding nav-course"><a href="{{ get_next_lesson_url($content,false) }}"><i class="fa fa-angle-left hidden-md hidden-lg"></i> <span class="hidden-xs hidden-sm">Anterior</span></a></div>
    <div class="col-xs-10 active-course no-padding">{{$content->lesson->module->name}} - Aula {{$content->lesson->sequence}}</div>
    <div class="col-xs-1 no-padding nav-course"><a href="{{ get_next_lesson_url($content,true) }}"><span class="hidden-xs hidden-sm">Próxima</span> <i class="fa fa-angle-right hidden-md hidden-lg"></i></a></div>
</div>
    <section role="main" class="content-body">
        <header class="page-header">
            @if($content->lesson->module != null)
                @if($content->lesson->module->course != null)
            <h2>{{ $content->lesson->module->course->title }}</h2>
                @else
                    <h2>{{ $content->lesson->module->name }}</h2>
                @endif
            @else
                <h2>{{ $content->lesson->title }}</h2>
            @endif

<!--
            <div class="right-wrapper pull-right">
                <ol class="breadcrumbs">
                    <li>
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

        <div id="actual-content" data-actual-content="{{ $actual_content }}" style="visibility: hidden;"></div>
        <div class="row">
            <div class="col-md-7">
                <section class="panel">
                    <div class="panel-body panel-body-nopadding">
                        <div id="exceeded"></div>
                        <div class="embed-responsive embed-responsive-16by9">
                        <iframe width="100%" class="embed-responsive-item" name="lesson-content" data-content="{{ $content->id }}" data-lesson="{{ $content->lesson->id }}" data-enrollment="{{ $enrollment->id }}" height="400" src="{{ $content->url }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="panel-footer panel-footer-btn-group panel-footer-class">
                        <a href="#" name="block-1" data-block="1" class="block active">Bloco 1</a>
                        <a href="#" name="block-2" data-block="2" class="block">Bloco 2</a>
                        <a href="#" name="block-3" data-block="3" class="block">Bloco 3</a>
                        <a href="#" name="block-4" data-block="4" class="block">Bloco 4</a>
                    </div>
                </section>
            </div>
            <div class="col-md-5">
                <div class="panel-group" id="accordionPrimary" style="border:0;">
                    <div id="panel-rating-bj" class="panel panel-accordion panel-featured panel-featured-primary">
                        <div class="panel-heading" style="background:#FFF">
                            <h4 class="panel-title">
                                <a class="accordion-toggle">
                                    <div class="row">
                                        <div class="col-xs-8">
                                    Visualização: <i id="current-view"></i>/<i id="max-view"></i>
                                        </div>
                                    <div class="col-xs-1">
                                            <i class="fa fa-thumbs-o-up" href="#" id="thumbs-up"></i>
                                    </div>
                                        <div class="col-xs-1">
                                            <i class="fa fa-thumbs-o-down" href="#" id="thumbs-down"></i>
                                        </div>
                                    </div>
                                    @include('frontend.studentarea.classroom.rating')
                                </a>
                            </h4>

                        </div>
                    </div>









                    <div class="panel panel-accordion panel-accordion-bj " >
                        <div class="panel-heading active" style="">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionPrimary" href="#collapsePrimaryOne">
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
                                                    <button type="button" id="add-todo" class="btn btn-success" tabindex="-1">Adicionar</button>
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
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionPrimary" href="#collapsePrimaryTwo">
                                    Material de Apoio
                                </a>
                            </h4>
                        </div>
                        <div id="collapsePrimaryTwo" class="accordion-body collapse">
                            <div class="panel-body">

                                <div id="treeBasic">
                                    <ul>

                                        @foreach($files as $file)

                                            @if(get_filetype($file->url) == '.pdf')
                                                    <li data-jstree='{ "icon" : "fa fa-file-pdf-o" }'><a href="/{{ $file->url  }}">{{ $file->title }}</a></li>
                                                @elseif(get_filetype($file->url) == '.pps')
                                                    <li data-jstree='{ "icon" : "fa fa-file-powerpoint-o" }'><a href="/{{ $file->url  }}">{{ $file->title }}</a></li>
                                                @elseif(get_filetype($file->url) == '.doc' || $file->url == '.docx')
                                                    <li data-jstree='{ "icon" : "fa fa-file-word-o" }'><a href="/{{ $file->url  }}">{{ $file->title }}</a></li>
                                                @elseif(get_filetype($file->url) == '.png' ||$file->url == '.jpg' || get_filetype($file->url) == 'jpeg')
                                                    <li data-jstree='{ "icon" : "fa fa-file-image-o" }'><a href="/{{ $file->url  }}">{{ $file->title }}</a></li>
                                                @else
                                                    <li data-jstree='{ "type" : "file" }'><a href="/{{ $file->url  }}">{{ $file->title }}</a></li>
                                            @endif

                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                        @endif
                    <div class="panel panel-accordion panel-accordion-bj">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionPrimary" href="#collapsePrimaryThree">
                                    Comentários
                                </a>
                            </h4>
                        </div>
                        <div id="collapsePrimaryThree" class="accordion-body collapse">
                            <div id="comments-content" class="panel-body">
                                Donec tellus massa, tristique sit amet condimentum vel, facilisis quis sapien.
                            </div>
                        </div>
                    </div>
                </div>
                    @if($type != 'lesson')
                
                        @endif
            </div>


            </div>
            @if($type != 'lesson')
            <section id="all-courses-classroom">
                <h3 style="color:black;margin:40px 0px 0px;">Todas Disciplinas</h3>
                @if($type == 'module')
                    @foreach($content->lesson->module->lessons as $lesson)
                        {{ $lesson }}

                    @endforeach
                @endif
                @if($i = 0)@endif
                @if($type == 'course')
                <div class="row">
                    @foreach($content->lesson->module->course->modules as $module)
                             <div class="course-clasroom col-md-6">
                            <section class="panel">
                                <header class="panel-heading">
                                   

                                    <h2 class="panel-title" style="color:#FFF;">{{  $module->name }}</h2>
                                </header>
                                <div class="panel-body">
                                <div class="row-classroom">
                                    @foreach($module->lessons as $lesson)
                                            <div class="class-clasroom">
                                                @if($lesson->ad_video_url != null)
                                                    <a href="/classroom/{{ $content->lesson->module->course->id }}/{{ $module->id }}/{{ $lesson->id }}">
                                                    <img src="{!!  get_vimeo_thumbnail(substr($lesson->contents->first()->url, strrpos($lesson->contents->first()->url, '/') + 1),'medium')  !!}" class="img-responsive">
                                                        </a>
                                                @else
                                                    <a href="/classroom/{{ $content->lesson->module->course->id }}/{{ $module->id }}/{{ $lesson->id }}">
                                                <img src="http://placehold.it/275x140"  class="img-responsive">
                                                    </a>
                                                @endif
                                                @if($lesson->title != '')
                                                    <span class="class-number">{{$lesson->title}}</span>
                                                @else
                                                    <span class="class-number">Aula {{$lesson->sequence}}</span>
                                                @endif
                                            </div>

                                    @endforeach
                                    </div>
                                </div>
                            </section>
                        </div>

                        @endforeach
                    </div>
                    @endif

        </section>
            @endif
        <!-- end: page -->
        </section>





@endsection