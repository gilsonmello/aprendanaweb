@extends('frontend.layouts.master-classroom')

@section('content')

    <section role="main" class="content-body">
        <header class="page-header">
                <h2>SAAP - Simulador de Aprendizagem de Alta Performance</h2>
        </header>


        <!-- start: page -->



            <section class="panel">
                <div class="row">
                    <div class="col-md-6">

                        <section class="panel panel-warning no-border-radius panel-exam">
                            <header class="panel-heading no-border-radius" style="background: #d8f0da;border-left:8px solid #4fba72; border-right:8px solid #4fba72;border-bottom:0;">
                                <h2 class="panel-title" style="color:#4fba72;"><strong>{!!  $exam->title !!}</strong></h2>
                            </header>

                            <div class="panel-body" style="padding:0; padding-bottom: 10px;">
                                <div class="exam-explanation">
                                    <img src="/img/system/SAAP_Logo.png" style="width:200px; margin-bottom:20px;">                                  
                                    <div id="start_exam" class="pull-right" style="padding-top: 15px;padding-left: 15px; ">
                                    <a href="{{ route('frontend.exam',['id' => $enrollment->id]) }}" type="button" class="no-border-radius mb-xs mt-xs mr-xs btn btn-primary" style="font-size: 1.8rem;"> @if($order > 1) Continuar @else Iniciar @endif o SAAP agora - {{ $order }}<SUP>a</SUP> questao</a>
                                </div>
                                </div>
                                <div class="tabs tabs-success">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active" style="height: 30px;">
                                        <a href="#info-exam-tab" data-toggle="tab" class="text-center" style="height: 65px;">
                                        <i class="fa fa-file" style="color: #3D9056;padding:5px; "></i>
                                            Informações de Uso</a>
                                    </li>
                                    <li>
                                        <a href="#read-ob-tab" data-toggle="tab" class="text-center" style="height: 65px;">
                                        <i class="fa fa-book" style="color: #3D9056;padding:5px; "></i>
                                        Leitura Obrigatória
                                        </a>
                                    </li>
                                     <li>
                                        <a href="#360-exam-tab" data-toggle="tab" class="text-center" style="height: 65px;">
                                        <i  class="fa fa-circle-o-notch" style="color: #3D9056; padding:5px;"></i>
                                        Análise 360 Graus
                                        </a>
                                    </li>
                                     <li>
                                        <a href="#extra-reading-exam" data-toggle="tab" class="text-center" style="height: 65px;">
                                        <i class="fa fa-plus" style="color: #3D9056;padding:5px; "></i>
                                        Material Complementar
                                        </a>
                                    </li>
                                    <br/>
                                        <li >
                                            <a href="#legis-exam-tab" data-toggle="tab" class="text-center" style="height: 65px;">
                                                <i class="fa fa-book" style="color: #3D9056;padding:5px; "></i>
                                                Legislação Correlata</a>
                                        </li>
                                        <li>
                                            <a href="#juris-exam-tab" data-toggle="tab" class="text-center" style="height: 65px;">
                                                <i class="fa fa-book" style="color: #3D9056;padding:5px; "></i>
                                                Jurisprudência Correlata
                                            </a>
                                        </li>
                                        <li >
                                            <a href="#infomativos-exam-tab" data-toggle="tab" class="text-center" style="height: 65px;">
                                                <i  class="fa fa-book" style="color: #3D9056; padding:5px;"></i>
                                                Informativos
                                            </a>
                                        </li>
                                    </ul>
                                <div class="tab-content">
                                    <div id="info-exam-tab" class="tab-pane active">
                                        <h3>INFORMAÇÔES DE USO</h3>
                                    <br/>
                                    <p><strong style="color:blue"> {{ get_questions_count($exam) }} </strong> questões.</p>
                                    @if ($exam->duration != null && $exam->duration != '')
                                        <p>O tempo pré-estipulado para conclusão desse SAAP é de <strong style="color:red">{{ $exam->duration }} minutos</strong>, com aproximadamente
                                            <strong style="color:red">{{ ceil($exam->duration / get_questions_count($exam)) }}</strong> minutos por questão.</p>
                                    @else
                                        <p>O tempo pré-estipulado POR QUESTÃO para esse SAAP é de <strong style="color:red">{{ $exam->time_by_question }}</strong> minutos</p>
                                    @endif
                                    <p>Executado: <strong>{{$attempt =  get_attempted($enrollment) }}/{{$enrollment->exam->max_tries}}</strong> </p>
                                    @if($attempt > 0)
                                        <p>Melhor Pontuação: <strong>{{ number_format((get_rights($enrollment)->max() * 100) / (get_questions_count($enrollment->exam)),0) }}%</strong></p>
                                    @endif
                                    <p>Expira em: <strong style="color:red">{{ format_datebr($enrollment->date_end)}}</strong> </p>
                                    <br/>
                                    <p>{!! $exam->explanation !!}</p>
                                    @if (count($exam->courses))
                                        <div class="container no-padding p-bj">
                                            <h3>CONTEÚDO RELACIONADO</h3>
                                            <div id="recomendados" class="tab-pane no-padding" style="margin:0px 0px 30px;padding:0;" >
                                                <div class="row no-padding "  style="padding:15px;">
                                                    @foreach($exam->courses as $course)
                                                        <div class=" no-padding p-bj-course  col-md-3 col-xs-6 ">
                                                            <article class="card-course with-border">
                                                                <!-- Início do Título Card do Curso -->
                                                                <a href="{{ route('course-section', [$course->slug]) }}" title="{{ $course->title }}">
                                                                    <div class="card-course-title-container">

                                                                        <h3 class="card-course-title"  style="background-color: {{ $course->subsection->section->color }}">
                                                                            {{ $course->title }}
                                                                        </h3>

                                                                    </div>
                                                                </a>
                                                                <!-- Fim do Título Card do Curso -->

                                                                <!-- Início do Conteúdo Card do Curso -->
                                                                <div class="card-course-content">
                                                                    @if ($course->price == 0.00)
                                                                        <span class="meta-value">&nbsp;</span>
                                                                        <span class="meta-value-promo"><strong style="color:{{ $course->subsection->section->color }};">GRÁTIS</strong></span>
                                                                    @else
                                                                        @if($course->price !=  $course->discount_price)
                                                                            <span class="meta-value">De R$ {{ number_format($course->price, 2, ',', '.') }}</span>
                                                                            <span class="meta-value-promo">Por <strong style="color:{{ $course->subsection->section->color }};">R$ {{ number_format($course->final_price, 2, ',', '.') }}</strong></span>
                                                                        @else
                                                                            <span class="meta-value">&nbsp;</span>
                                                                            <span class="meta-value-promo">Por <strong style="color:{{ $course->subsection->section->color }};">R$ {{ number_format($course->final_price, 2, ',', '.') }}</strong></span>
                                                                        @endif
                                                                    @endif
                                                                    <small>Até 10x sem juros</small>
                                                                    <div class="clearfix height-10"></div>
                                                                    <a href="{{ route('cart.fast_purchase', [$course->id]) }}" class="pull-left btn-buy-now-card"><i class="fa fa-shopping-cart" style="color: {{ $course->subsection->section->color }}"></i> Compra Rápida</a>
                                                                    <a href="{{ route('course-section', [$course->slug]) }}" class="pull-right btn-plus-article" style="color: {{ $course->subsection->section->color }}"><i class="fa fa-plus-square-o"></i></a>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                                <!-- Início do Conteúdo Card do Curso -->
                                                            </article>
                                                        </div>

                                                    @endforeach


                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    </div>
                                    <div id="read-ob-tab" class="tab-pane">
                                         <h3>LEITURA OBRIGATÓRIA</h3>
                                         <p>{!! $exam->required_reading !!}</p>
                                    </div>
                                    <div id="360-exam-tab"  class="tab-pane">
                                        <h3>ANÁLISE 360 GRAUS</h3>
                                        <p>{!! $exam->note1 !!}</p>
                                    </div>
                                <div id="extra-reading-exam" class="tab-pane">
                                    <h3>LEITURA COMPLEMENTAR</h3>
                                    <p>{!! $exam->additional_reading !!}</p>
                                </div>
                                    <div id="legis-exam-tab"  class="tab-pane">
                                        <h3>LEGISLAÇÃO CORRELATA</h3>
                                        <p>{!! $exam->note2 !!}</p>
                                    </div>
                                    <div id="juris-exam-tab"  class="tab-pane">
                                        <h3>JURISPRUDÊNCIA CORRELATA</h3>
                                        <p>{!! $exam->note3 !!}</p>
                                    </div>
                                    <div id="infomativos-exam-tab"  class="tab-pane">
                                        <h3>INFORMATIVOS</h3>
                                        <p>{!! $exam->note4 !!}</p>
                                    </div>
                            </div>

                                

                                


                            </div>
                        </section>


                    </div>

                    <div class="col-md-6">
                        <section class="panel no-border-radius panel-exam" id="explanation" style="padding-top:1px;">
                            <header class="panel-heading no-border-radius" style="background: #d8eceb;border-left:8px solid #253885; border-right:8px solid #253885;border-bottom:0;">
                                <h2 class="panel-title" style="color:#253885;"><strong>O que é o SAAP?</strong></h2>
                            </header>
                            <div class="panel-body" style="padding:0;">
                                <div class="explanation" style="display: block;">
                                    <iframe width="100%" id="explanation-content" height="400" src="https://player.vimeo.com/video/151931854" frameborder="0" allowfullscreen="">&amp;nbsp;</iframe>                                </div>
                            </div>
                        </section>
                    </div>
                </div>



            </section>



@endsection