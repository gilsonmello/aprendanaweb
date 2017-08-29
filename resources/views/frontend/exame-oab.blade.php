@extends('frontend.layouts.master')

@section('title')
    Cursos Essenciais e SAAP para o Exame da OAB | {{app_name()}}
@endsection


@section('content')

    <div class="container-fluid" style="padding: 0 0 0 0; margin-top: -20px">
        <div class="entry-header">
            <div class="entry-thumbnail">
                <img class="img-responsive" src="img/frontend/banner_topo_oab.png" alt="" />
            </div>
        </div>
    </div>


    <div id="white-bg" class="page">
        <div class="container">

            <div class="space small  "></div>



            <div class="row">
                <div class="container text-center">
                    <h3 style="font-weight: normal; line-height: 1.5">Só o Brasil Jurídico aponta o que é verdadeiramente essencial para a sua aprovação, através de uma análise criteriosa das últimas 20 provas realizadas pela OAB (incluindo a reaplicada em Salvador). 86% do último exame foi apontado pelo nosso Análise 360° e todo conteúdo com questões inéditas e adaptadas (100% padrão FGV) já é praticado pelos nossos alunos no Simulador SAAP - ferramenta exclusiva do Brasil Jurídico.</h3>
                    <h3 style="font-weight: normal; line-height: 1.5">Otimize seu tempo com os Cursos Essenciais e pratique tudo que aprendeu no melhor simulador do mercado - o único que exibe relatório completo do seu desempenho!</h3>
                </div>
            </div><!--/row-->


        </div><!--/row-->
    </div><!--/row-->

    <div class="space"></div>
            <div class="container" style="background-color: #f2f3f5;">
                <h2>Adquira agora o SAAP específico de cada disciplina e os Cursos Essenciais por disciplinas e temas. Você só vai investir no que realmente necessita para sua aprovação. O melhor custo benefício do mercado.</h2>
                <div class="space"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="section curso-small">
                    @foreach($courses as $index => $course)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/{{ $course->slug }}'">
                                                <a href="/{{ $course->slug }}"><img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                            </div>
                                        </div>
                                        <div class="post-content">
                                            <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>
                                            <h2>
                                                <a href="/{{ $course->slug }}" title="{{ $course->title }}">{{ str_limit($course->title, 65) }}</a>
                                            </h2>
                                            <div class="entry-content">
                                                <p>{{$course->short_description != null ? $course->short_description : ''}}</p>
                                            </div>
                                            <div class="entry-meta">
                                                @if ($course->final_price == 0.00)
                                                    <p><strong  class="label label-success">GRATUITO</strong></p>
                                                @elseif ($course->price != $course->final_price)
                                                    <p>De <strike>R$ {{number_format($course->price, 2, ',', '.')}}</strike> Por R$ {{number_format($course->final_price, 2, ',', '.')}}</p>
                                                @else
                                                    <p>R$ {{number_format($course->final_price, 2, ',', '.')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div><!--/.card-->
                                </div><!--/.col-->
                            </div><!--/.row-->
                    @endforeach
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 10px;">
                                <a href="/cursos-para-exame-oab" class="btn btn-testar btn-outline btn-block btn-lg"></i> <span>LISTA COMPLETA DOS CURSOS</span></a>
                            </div><!--/.row-->
                        </div>
                    </div><!--/.row-->
                </div>
                <div class="col-md-6">
                    <div class="section curso-small">
                        @foreach($packages as $index => $package)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/{{ $package->slug }}'">
                                                <a href="{{ route('packages.show',[$package->slug ]) }}"><img class="img-responsive" src="{{ imageurl("packages/", $package->id , $package->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                            </div>
                                        </div>
                                        <div class="post-content">
                                            <span class="label-small label-primary" style="background-color: {{ $package->subsection->section->color }}">{{ $package->subsection->section->name }}</span>
                                            <h2>
                                                <a href="{{ route('packages.show',[$package->slug ]) }}">{{ $package->title }}</a>
                                            </h2>
                                            <div class="entry-content">
                                                <p>{{$package->short_description != null ? $package->short_description : ''}}</p>
                                            </div>
                                            <div class="entry-meta">
                                                <p style="margin: 0px !importante;">
                                                    @if ($package->final_price == 0.00)
                                                        <strong  class="label label-success">GRATUITO</strong>
                                                    @else
                                                        R$ {{number_format($package->final_price, 2, ',', '.')}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div><!--/.card-->
                                </div><!--/.col-->
                            </div><!--/.row-->
                        @endforeach
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 10px;">
                                <a href="/saap-para-exame-oab" class="btn btn-testar btn-outline btn-block btn-lg"></i> <span>LISTA COMPLETA DOS SAAPS</span></a>
                            </div><!--/.row-->
                        </div>
                    </div><!--/.row-->
                </div>
            </div><!--/.row-->
            </div>





    <div id="white-bg" class="page">
        <div class="container">
            <div class="row">
                <div class="container col-md-10 col-md-offset-1 text-center">
                    <h1>Conheça como funciona o nosso sistema de alta performance!</h1>
                    <div class="space"></div>
                </div>
            </div><!--/row-->

            <div class="row">
                <div class="container col-md-10 col-md-offset-1 text-center">
                    <div class="entry-header">
                        <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/184900605" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space"></div>
        </div>
    </div>


    <!-- Call to action -->
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12  chamadasaap">
                <div class="col-md-8  col-md-offset-2 col-sm-12 ">
                    <div class="col-md-5 text-right">
                        <p class="title">
                            COMPROVE A EFICIÊNCIA DO SAAP
                        </p>
                    </div>
                    <div class="col-md-1 text-right">
                    </div>
                    <div class="col-md-5  text-left">
                        <a href="/simulados/saap-exame-oab-1-fase-teste-gratuito" class="btn btn-testar btn-outline btn-block btn-lg"> <span>TESTE GRATUITAMENTE!</span></a>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
    </div>
    <!-- /.Call to action -->


    <div id="white-bg" class="page">
        <div class="container">

            <div class="space"></div>

            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <h1>Confira trechos dos Temas Essenciais e <BR>comprove o conteúdo de excelência.</h1>
                    <div class="space"></div>
                </div>
            </div><!--/row-->


            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <h3>Ética</h3>
                            <h4>Da Publicidade Na Advocacia</h4>
                        </div>
                        <div class="col-md-6 text-center">
                            <h3>Novo Processo Civil</h3>
                            <h4>Recursos</h4>
                        </div>
                    </div>
                </div>
            </div><!--/.row-->

            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="entry-header">
                                <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                                    <iframe width="854" height="480" src="https://www.youtube.com/embed/MW8X0sMhkHc" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 text-center">
                            <div class="entry-header">
                                <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                                    <iframe width="854" height="480" src="https://www.youtube.com/embed/EZ0B3V3-FgQ" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!--/.row-->

            <div class="space"></div>
        </div><!--/.container-->
    </div>


    <div class="space small"></div>


@endsection