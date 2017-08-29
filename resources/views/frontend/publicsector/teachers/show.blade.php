@extends('frontend.layouts.masterpublicsector')

@section('title')
    {{ $teacher->name }} | {{app_name()}}
@endsection

@section('content')

    <section id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="{{ $teacher->id }}" class="teacher">
                        <div class="col-md-3 teacher-photo no-padding">
                            <div class="post feature-post">
                                <div class="entry-thumbnail">
                                        <img width="260" src="{{ imageurl("users/", $teacher->id, $teacher->photo === null || $teacher->photo === '' ? 'X' : $teacher->photo, 400, 'generic.png', 1) }}" class="img-responsive pull-left">
                                </div>
                            @if($teacher->video)
                                <hr>
                                <div class="embed-responsive embed-responsive-16by9">
                                    @if($teacher->video_frag->vendor == 'youtube')
                                        <iframe width="420" height="315"
                                                src="https://www.youtube.com/embed/{{ $teacher->video_frag->id }}" webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                                        </iframe>
                                    @endif
                                    @if($teacher->video_frag->vendor == 'vimeo')
                                        <iframe src="https://player.vimeo.com/video/{{ $teacher->video_frag->id }}?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                                                frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                                        </iframe>
                                    @endif
                                </div>
                            @endif
                        </div>
                            </div>
                        <div class="col-md-9 teacher-info" >
                            <h1  class="teacher-name">{{ $teacher->name }}</h1>
                                <p>{!!  str_replace(';', ', ', $teacher->tags) !!}</p>
                                <br>
                                <ul class="list-inline social-icons">
                                    @if (($teacher->youtube != null) && ($teacher->youtube != ''))
                                        <li><a href="http://{{ $teacher->youtube }}" target="_blank"><i class="fa fa-youtube"></i></a></li>
                                    @endif
                                    @if (($teacher->facebook != null) && ($teacher->facebook != ''))
                                        <li><a href="http://{{ $teacher->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    @endif
                                    @if (($teacher->twitter != null) && ($teacher->twitter != ''))
                                        <li><a href="http://{{ $teacher->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    @endif
                                    @if (($teacher->linkedin != null) && ($teacher->linkedin != ''))
                                        <li><a href="http://{{ $teacher->linkedin }}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    @endif
                                    @if (($teacher->instagram != null) && ($teacher->instagram != ''))
                                        <li><a href="http://{{ $teacher->instagram }}" target="_blank">Instagram</a></li>
                                    @endif
                                    @if (($teacher->jusbrasil != null) && ($teacher->jusbrasil != ''))
                                        <li><a href="http://{{ $teacher->jusbrasil }}" target="_blank" style="text-decoration: none;">JusBrasil</a></li>
                                    @endif
                                    @if (($teacher->periscope != null) && ($teacher->periscope != ''))
                                        <li><a href="http://{{ $teacher->periscope }}" target="_blank"  style="text-decoration: none;">Periscope</a></li>
                                    @endif
                                </ul>
                            <br>
                            <div class="teacher-about">

                                <p>{!! nl2br( $teacher->resume ) !!}</p>
                            </div>
                            @if (($teacher->linkcv != null) && ($teacher->linkcv != ''))
                                <a href="{{ $teacher->linkcv }}" target="_blank">Currículo completo</a>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    @if (count($coursesrelated))
        <br>
    <div class="container no-padding p-bj">
        <h3 class="section-title">CURSOS DO PROFESSOR</h3>
        <div id="recomendados" class="tab-pane no-padding" style="margin:0px 0px 30px;padding:0;">
            <div class="row no-padding ">
                @foreach($coursesrelated as $course)
                        <!-- Início do Card do Curso -->
                <div class=" no-padding p-bj-course  col-md-3 col-xs-6 ">
                    <div class="post feature-post" style="cursor: pointer" onclick="window.location='/gestaopublica/curso/{{ route('course-section', ['cursinhos',$course->course->slug]) }}'" >
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="{{ imageurl("courses/", $course->course->id , $course->course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                            </div>
                        </div>
                        <div class="post-content2">
                            <h2 class="entry-title">
                               <a>R$ {{ number_format($course->course->final_price, 2, ',', '.') }} </a>
                            </h2>
                        </div>

                    </div><!--/post-->
                        <!-- Início do Conteúdo Card do Curso -->
                    </article>
                </div>



                    <!-- Fim do Card do Curso -->
            @endforeach


        </div>
        </div>
    </div>
    @endif


    <br><br><br>
@endsection