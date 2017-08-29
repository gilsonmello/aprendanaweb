@extends('frontend.layouts.master')

@section('content')

    <section id="main-content">
        <div class="container">
            <div class="row" id="module">
                <div class="col-sm-3" >
                    <div id="course-info">
                        <div class="card-course">
                            <div class="card-course-title-container">
                                <h3 class="card-course-title orange-bj ">
                                    <a href="#">
                                        {{ $module->name }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                        <div id="course-body">
                            <div id="course-teachers">
                                @if(!empty($module->video_ad_url))
                                    <h3>Vídeo de Apresentação</h3>

                                    @if($module->ad_url->vendor == 'youtube')
                                        <iframe width="100%" height="200"
                                                src="https://www.youtube.com/embed/{{ $module->ad_url->id }}">
                                        </iframe>
                                    @endif
                                    @if($module->ad_url->vendor == 'vimeo')
                                        <iframe src="https://player.vimeo.com/video/{{ $module->ad_url->id }}?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                                                width="100%" height="200" frameborder="0"
                                                webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                                        </iframe>
                                    @endif
                                    <p>Link: <a href="{{ $module->video_ad_url }}">{{ $module->video_ad_url }}</a></p>
                                @endif
                            </div>


                            <div id="course-teachers">
                                <h3>Corpo Docente</h3>
                                <ul>
                                    <li class="course-teacher">
                                        <div class="teacher-avatar">
                                            <img src="http://brasiljuridico.com.br/files/c4ca4238a0b923820dcc509a6f75849b/professores/0f33f894fa145be77d791054350ffe96.jpg" width="150" height="150" alt="Dirley da Cunha Júnior">
                                        </div>
                                        <h4>Dirley da Cunha Júnior</h4>
                                    </li>
                                    <li class="course-teacher">
                                        <div class="teacher-avatar">
                                            <img src="http://brasiljuridico.com.br/files/c4ca4238a0b923820dcc509a6f75849b/professores/a753f713d7d407f636a6508e090953c4.jpg" width="150" height="150" alt="Dirley da Cunha Júnior">

                                        </div>
                                        <h4>ADRIANA WYZYKOWSKI</h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="list-group">
                                <a href="#" class="list-group-item"><i class="fa fa-exclamation-circle"></i> Termos de Uso</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div data-example-id="togglable-tabs">
                        <ul id="course-tabs" class="nav nav-tabs" role="tablist">
                            <li class="active">
                                <a href="#curso" id="curso-tab" role="tab" data-toggle="tab" aria-controls="video" aria-expanded="false">O Curso</a>
                            </li>
                            <li>
                                <a href="#disciplinas" role="tab" id="disciplinas-tab" data-toggle="tab" aria-controls="disciplinas">Disciplinas</a>
                            </li>
                            <li>
                                <a href="#conteudo" role="tab" id="conteudo-tab" data-toggle="tab" aria-controls="conteudo">Conteúdo</a>
                            </li>
                        </ul>
                        <div id="course-tabs-content" class="tab-content">

                            <div role="tabpanel" class="tab-pane fade active in" id="curso" aria-labelledby="curso">
                                <p>{!! $module->description !!}</p>
                            </div>
                            <div class="tab-pane fade" id="disciplinas" aria-labelledby="disciplinas">
                                <div class="table-responsive">

                                    <table class="table table-hover">
                                        <thead><th>{{ $module->name }}</th></thead>
                                        <tbody>
                                        @foreach($module->lessons as $lesson)
                                        <tr>
                                            <td class="col-xs-7 no-padding">{{ $lesson->title }}</td>
                                            <td class="col-xs-3 no-padding text-center"><span class="label label-danger">R$ {{ number_format($lesson->discount_price, 2, ',', '.') }}</span></td>
                                            <td class="col-xs-2 no-padding text-center"><i class="fa fa-shopping-cart"></i></td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="conteudo" aria-labelledy="conteudo">
                                {{--<h4><strong>DIREITO CONSTITUCIONAL - 17 AULAS</strong></h4>--}}
                                {!! $module->module_content !!}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="course-panel">
                        <button class="course-button" style="width:100%;"><i class="fa fa-shopping-cart"></i> Comprar a disciplina</button>
                        <ul class="list-group">
                            <li class="list-group-item course-price">
                                <strike>R$ {{ number_format($module->price, 2, ',', '.') }}</strike>
                                <strong  class="label label-success">R$ {{ number_format($module->discount_price, 2, ',', '.') }}</strong>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-calendar"></i>
                                Tempo de acesso: {{ $module->access_time }} dias
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-clock-o"></i>
                                Carga Horária: {{ $module->workload }}/h aula
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-credit-card"></i>
                                Em parcela de 10x sem juros e a prazo no cartão
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </section>

@endsection