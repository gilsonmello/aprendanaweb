@extends('frontend.layouts.master')

@section('content')

    <section id="main-content">
        <div class="container">
            <div class="row" id="lesson">
                <div class="col-sm-3" >
                    <div id="course-info">
                        <div class="card-course">
                            <div class="card-course-title-container">
                                <h3 class="card-course-title orange-bj ">
                                    <a href="#">
                                        {{ $lesson->title }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                        <div id="course-body">

                            <div id="course-teachers">
                                <h3>Corpo Docente</h3>
                                <ul>
                                    <li class="course-teacher">
                                        <div class="course-avatar">
                                            <img src="http://brasiljuridico.com.br/files/c4ca4238a0b923820dcc509a6f75849b/professores/0f33f894fa145be77d791054350ffe96.jpg" width="150" height="150" alt="Dirley da Cunha Júnior">
                                        </div>
                                        <h4>Dirley da Cunha Júnior</h4>
                                    </li>
                                    <li class="course-teacher">
                                        <div class="course-avatar">
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
                                <a href="#course" id="course-tab" role="tab" data-toggle="tab" aria-controls="video" aria-expanded="false">A Aula</a>
                            </li>

                        </ul>
                        <div id="lesson-tabs-content" class="tab-content">

                            <div role="tabpanel" class="tab-pane fade active in" id="curso" aria-labelledby="course">
                                <p>{!! $lesson->description !!}</p>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="course-panel">
                        <button class="course-button" style="width:100%;"><i class="fa fa-shopping-cart"></i> Comprar a aula</button>
                        <ul class="list-group">
                            <li class="list-group-item course-price">
                                <strike>R$ {{ number_format($lesson->price, 2, ',', '.') }}</strike>
                                <strong  class="label label-success">R$ {{ number_format($lesson->discount_price, 2, ',', '.') }}</strong>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-calendar"></i>
                                Tempo de acesso: {{ $lesson->access_time }} dias
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-clock-o"></i>
                                Carga Horária: {{ $lesson->workload }}/h aula
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