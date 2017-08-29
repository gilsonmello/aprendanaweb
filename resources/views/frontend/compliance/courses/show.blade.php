@extends('frontend.layouts.masterpublicsector')

@section('title')
    {{ $course->title }} | {{app_name()}}
@endsection

@section('subtopbar')

    <div style="border-top: 1px solid rgba(0, 0, 0, 0.10); width: 100%">
        <div class="container">
            <div id="package-presentation" class="navbar-header">
                <div>
                    <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>

                    <h1 style="line-height: 0.8"> {{ $course->title }}</h1>
                </div>

            </div>
        </div>
    </div>

@endsection




@section('content')

    <section id="main-content">
        <div class="container">
            <h1 class="section-title"> {{ $course->title }}</h1>
            <div class="row" id="course">
                <div class="col-sm-3 no-padding p-bj">
                    <div id="course-info">
                        <div class="card-course no-padding">
                            <div class="card-course-title-container">
                                <div class="entry-thumbnail">
                                    <img class="img-responsive" style="max-width:100%;height:auto;" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                </div>
                            </div>
                        </div>
                        <div id="course-body">

                            <div class="list-group">
                                <button type="button" class="list-group-item" data-toggle="modal" data-target="#termsUses"><i class="fa fa-exclamation-circle"></i> Termos de Uso</button>
                                <button type="button" class="list-group-item" data-toggle="modal" data-target="#requisites"><i class="fa fa-exclamation-circle"></i> Requisitos Minímos
                                </button>
                            </div>

                            <ul class="list-group">
                                <li class="list-group-item">
                                    <i class="fa fa-calendar"></i>
                                    Tempo de acesso: <b>{{ $course->access_time }} dias</b>
                                </li>
                                @if (($course->workload_presential != null) && ($course->workload_presential != 0))
                                <li class="list-group-item">
                                    <i class="fa fa-clock-o"></i>
                                    Carga H. Presencial: <b>{{ format_display_time($course->workload_presential * 3600, true) }}</b>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa fa-clock-o"></i>
                                    Carga H. Online: <b>{{ $course->workload == 0 ? 'A definir' : number_format($course->workload * 3600, true) }}</b>
                                </li>
                                @else
                                    @if (($course->workload != null) && ($course->workload != 0))
                                    <li class="list-group-item">
                                        <i class="fa fa-clock-o"></i>
                                        Carga Horária: <b>{{ format_display_time($course->workload * 3600, true) }}</b>
                                    </li>
                                    @endif
                                @endif
                                <li class="list-group-item">
                                    <i class="fa fa-eye"></i>
                                    Visualizações por bloco{{ (($course->workload_presential != null) && ($course->workload_presential != 0)) ? " das aulas online" : "" }}: <b>{{ $course->max_view }}</b>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa fa-clock-o"></i>
                                    Por bloco{{ (($course->workload_presential != null) && ($course->workload_presential != 0)) ? " das aulas online" : "" }}:
                                    <b>
                                        @if (($course->time_per_content != null) && ($course->time_per_content != ''))
                                            {!! $course->time_per_content !!}
                                        @else
                                            aprox. 30 min.
                                        @endif
                                    </b>
                                </li>
                            </ul>

                        </div>
                    </div>
                    
                    {{--<div class="esconde-Botoes">--}}
                        {{--<ul class="list-group">--}}
                            {{--<li class="list-group-item course-price" style="text-align: center;">--}}
                                {{--@if ($course->final_price == 0.00)--}}
                                    {{--<strong  class="label label-success">GRATUITO</strong>--}}
                                {{--@else--}}
                                    {{--@if($course->price != $course->final_price)--}}
                                        {{--<strike>R$ {{ number_format($course->price, 2, ',', '.') }}</strike>--}}
                                        {{--<br/>--}}
                                        {{--<br/>--}}
                                    {{--@endif--}}
                                    {{--<H1>R$ {{ number_format($course->final_price, 2, ',', '.') }}</H1>--}}
                                    {{--@if ($course->id == 453)--}}
                                            {{--<br/>--}}
                                            {{--<br/>--}}
                                        {{--<span style="color: red;">Desconto válido para os 100 primeiros matriculados.</span>--}}
                                    {{--@endif--}}
                                {{--@endif--}}
                            {{--</li>--}}
                            {{--<li class="list-group-item" style="padding:0">--}}
                                {{--<a href="{{ route('cart.add', [$course->id, 'course']) }}" class="btn btn-success course-button" style="width:100%;height:100%;  font-size: 18px; font-color: white;  border:0; ">--}}
                                    {{--@if ($course->final_price == 0.00)--}}
                                        {{--ACESSE AGORA--}}
                                    {{--@else--}}
                                        {{--COMPRAR CURSO--}}
                                    {{--@endif--}}

                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                        {{--<ul class="list-group"  style="margin-top: 30px;">--}}
                            {{--<li class="list-group-item">--}}
                                {{--<i class="fa fa-credit-card"></i>--}}
                                {{--@if (($course->payment != null) && ($course->payment != ''))--}}
                                    {{--{{ $course->payment   }}--}}
                                {{--@else--}}
                                    {{--em até 4x sem juros com parcela mínima de R$ 50,00--}}
                                {{--@endif--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}


                </div>
                <div style="position:relative;">

                    <hr class="visible-xs visible-sm">


                    <div class="col-sm-6">

                        <div data-example-id="togglable-tabs">

                            <div class="world-nav cat-menu " style="right: initial; top: initial; position:initial">
                                <ul class="list-inline big-cat">
                                    <li class="active">
                                        <a href="#curso" id="curso-tab" role="tab" data-toggle="tab" aria-controls="video" aria-expanded="false">O Curso</a>
                                    </li>
                                    @if (($course->course_content != null) && ($course->course_content != ''))
                                    <li>
                                        <a href="#conteudo" role="tab" id="conteudo-tab" data-toggle="tab" aria-controls="conteudo">Conteúdo</a>
                                    </li>
                                    @endif
                                    @if (($course->methodology != null) && ($course->methodology != ''))
                                        <li >
                                            <a href="#metodologia" role="tab" id="metodologia-tab" data-toggle="tab" aria-controls="metodologia">Metodologia</a>
                                        </li>
                                    @endif
                                    @if (($course->testimonials != null) && ($course->testimonials != ''))
                                        <li >
                                            <a href="#depoimentos" role="tab" id="depoimentos-tab" data-toggle="tab" aria-controls="depoimentos">Depoimentos</a>
                                        </li>
                                    @endif
                                    @if (($course->workload_presential == null) || ($course->workload_presential == 0))
                                        @if (count($course->modules) > 1)
                                        <li >
                                            <a href="#disciplinas" role="tab" id="disciplinas-tab" data-toggle="tab" aria-controls="disciplinas">Disciplinas</a>
                                        </li>
                                        @endif
                                    @endif
                                    <li >
                                        <a href="#docentes" id="docentes-tab" role="tab" data-toggle="tab" aria-controls="docentes" aria-expanded="false">Docentes</a>
                                    </li>
                                </ul>
                                <br/>
                            </div>




                        </div>


                        <div id="course-tabs-content" class="tab-content">

                            <div role="tabpanel" class="tab-pane fade active in" id="curso" aria-labelledby="curso">
                                <div id="course-teachers">
                                    @if(!empty($course->video_ad_url))
                                        @if($course->video_frag->vendor == 'youtube')
                                            <iframe width="100%" height="400"
                                                    src="https://www.youtube.com/embed/{{ $course->video_frag->id }}">
                                            </iframe>
                                        @endif
                                        @if($course->video_frag->vendor == 'vimeo')
                                            <iframe src="https://player.vimeo.com/video/{{ $course->video_frag->id }}?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                                                    width="100%"  frameborder="0"  height="400"
                                                    webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                                            </iframe>
                                            @endif
                                                    <!--p>Link: <a href="{{ $course->video_ad_url }}">{{ $course->video_ad_url }}</a></p-->
                                        @endif
                                </div>

                                <p>{!! $course->description !!}</p>
                            </div>

                            <div role="tabpanel" class="tab-pane fade active" id="docentes" aria-labelledby="docentes">
                                <div id="course-teachers" >
                                    <section class="section professor">
                                        <div class="row">
                                            @foreach($course->teachers as $index => $teacher)

                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="entry-header">
                                                            <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='{{ route("teachers.show", [$teacher->teacher->idOrSlug()]) }}'">
                                                                <a href="{{ route("teachers.show", [$teacher->teacher->idOrSlug()]) }}"><img class="img-responsive" src="{{ imageurl('users/', $teacher->teacher->id, $teacher->teacher->photo, 200, 'generic.png',true) }}" alt="" /></a>
                                                            </div>
                                                        </div>
                                                        <div class="post-content">
                                                            <h2>
                                                                <a href="{{ route("teachers.show", [$teacher->teacher->idOrSlug()]) }}" >{{ $teacher->teacher->name }}</a>
                                                            </h2>
                                                            <div class="entry-content">
                                                                <p>{{ str_limit($teacher->teacher->resume, 300) }}</p>
                                                            </div>
                                                        </div>
                                                    </div><!--/.card-->
                                                </div><!--/.col-->

                                            @endforeach
                                        </div>
                                    </section>
                                </div>
                            </div>

                            @if (($course->methodology != null) && ($course->methodology != ''))
                            <div class="tab-pane fade" id="metodologia" aria-labelledby="metodologia">
                                <p>{!! $course->methodology !!}</p>
                            </div>
                            @endif

                            @if (($course->testimonials != null) && ($course->testimonials != ''))
                                <div class="tab-pane fade" id="depoimentos" aria-labelledby="depoimentos">
                                    <p>{!! $course->testimonials !!}</p>
                                </div>
                            @endif

                            <div class="tab-pane fade" id="disciplinas" aria-labelledby="disciplinas">

                                <div class="panel-group" id="faq-page" role="tablist" aria-multiselectable="true">
                                    @foreach($course->modules as $module)
                                        <div>
                                            <div  role="tab" id="headingOne">
                                                <h2 class="title-tab-search" style="font-size:2.0rem;"> {{ $module->name }}</h2>


                                                <div class="row">
                                                    @foreach($module->teachers as $objTeacher)
                                                        <div class="col-sm-4 col-xs-6" style="margin-top: -20px;">
                                                            <div class="post feature-post">
                                                                <div class="entry-thumbnail">
                                                                    <img class="img-responsive" src="{{ imageurl('users/', $objTeacher->id, $objTeacher->photo, 200, 'generic.png',true) }}" alt="" />
                                                                </div>
                                                                <div class="post-content2">
                                                                    <h2 class="entry-title">
                                                                        <a href="{{ route("teachers.show", [$objTeacher->id]) }}">{{ $objTeacher->name }}</a>
                                                                    </h2>
                                                                </div>
                                                            </div><!--/post-->
                                                            <div class="text-center">{{ $objTeacher->lesson_teachers }} {{ $objTeacher->lesson_teachers > 1 ? "aulas" : "aula" }}</div>
                                                        </div><!--/.col-->
                                                    @endforeach
                                                </div>




                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="conteudo" aria-labelledy="conteudo">
                                {{--<h4><strong>DIREITO CONSTITUCIONAL - 17 AULAS</strong></h4>--}}
                                {!! $course->course_content !!}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="course-panel">
                        <ul class="list-group">
                            <li class="list-group-item course-price" style="text-align: center;">
                                @if ($course->final_price == 0.00)
                                    <strong  class="label label-success">GRATUITO</strong>
                                @else
                                    @if($course->price != $course->final_price)
                                        <strike>R$ {{ number_format($course->price, 2, ',', '.') }}</strike>
                                        <br/>

                                        <BR>
                                    @endif
                                @endif
                                    <h1>R$ {{ number_format($course->final_price, 2, ',', '.') }}</h1>
                             </li>
                            <BR>
                    {!! Form::open(['route' => ['publicsector.cart.add'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) !!}

                                <input type="hidden" name="course" value="{{ $course->id }}">
                            <li class="list-group-item course-price" style="text-align: center;">
                                Quantos alunos deseja inscrever para este curso?
                                <br>
                                <br>
                                <input type="text" name="count" size="3" value="{{$count}}">
                                <br>
                                <br>
                            </li>
                            <li class="list-group-item" style="padding:0">
                                <input type="submit" value="ADICIONAR CURSOS" class="btn btn-success course-button" style="width:100%;height:100%; padding: 20px; font-size: 18px; font-color: white;  border:0; "/>
                            </li>
                            {!! Form::close() !!}
                            <BR>
                            <button type="button" class="btn btn-success course-button" style="width:100%;height:100%; padding: 20px; font-size: 18px; font-color: white;  border:0; " data-toggle="modal" data-target="#directBuy">PESSOA FÍSICA</button>

                        </ul>
                        @if (count($relatedcourses))
                            @foreach($relatedcourses as $course_related)
                                <div class="post feature-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <a href="/gestaopublica/curso/{{ $course_related->slug }}"><img class="img-responsive" src="{{ imageurl("courses/", $course_related->id , $course_related->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                        </div>
                                    </div>
                                    <div class="post-content2">
                                        <h2 class="entry-title">
                                        </h2>
                                    </div>
                                </div><!--/post-->
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="termsUses" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Termos de Uso</h4>
                </div>
                <div class="modal-body">
                    @include('frontend.institutional.terms-content')
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="requisites" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Requisitos Mínimos</h4>
                </div>
                <div class="modal-body">
                    <strong>Desktops e notebooks</strong><br/>
                    Largura de banda mínima de 2Mbps<br/>
                    Resolução mínima de 1024 x 768 pixels<br/>
                    Versão mais atual do do Flash Player<br/>
                    Última versão dos principais Navegadores: Internet Explorer, Mozilla Firefox, Google Chrome e Safari<br/>
                    <br/>
                    <strong>iPad e iPhone</strong><br/>
                    Conexão WiFi<br/>
                    Largura de banda mínima de 2Mbps<br/>
                    iOS 7 ou superior<br/>
                    <br/>
                    <strong>Smartphones e tablets Android</strong><br/>
                    Conexão WiFi<br/>
                    Largura de banda mínima de 2Mbps<br/>
                    Android 4.4 ou superior<br/>
                    <br/>
                    <strong>Smart TVs</strong><br/>
                    Conexão WiFi<br/>
                    Largura de banda mínima de 2Mbps<br/>
                    Navegadores Compatíveis<br/>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="directBuy" tabindex="-1" role="dialog" aria-labelledby="directBuy">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Compra Pessoa Física</h4>
                </div>
                <div class="modal-body">
                    <p>Você será direcionado para o carrinho no portal principal do Brasil Jurídico, onda se dará a conclusão da transação</p>
                    <p>Para retornar para o site BrJ gestão Pública, acesse http://www.brasiljuridico.com.br/gestaopublica.</p>

                    <BR>
                    <BR>
                    <a href="{{ route('cart.add', [$course->id, 'course']) }}" class="btn btn-success course-button" style="width:100%;height:100%; padding: 20px; font-size: 18px; font-color: white;  border:0; ">
                        COMPRAR
                    </a>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('after-scripts-end')

    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','//connect.facebook.net/en_US/fbevents.js');
        fbq('track',  'ViewContent');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1576695232624762&ev=PageView&noscript=1"/></noscript>

@stop