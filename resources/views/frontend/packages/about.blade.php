@extends('frontend.layouts.master')

@section('title')
    Conheça o SAAP | {{app_name()}}
@endsection

        <!-- Facebook Pixel Code -->
{{--<script>--}}
{{--!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?--}}
{{--n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;--}}
{{--n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;--}}
{{--t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,--}}
{{--document,'script','//connect.facebook.net/en_US/fbevents.js');--}}
{{--fbq('track', "ViewContent");--}}
{{--</script>--}}
{{--<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=973245029429675&ev=PageView&noscript=1"/></noscript>--}}
<!-- End Facebook Pixel Code -->

@section('content')




    <div class="video-header section-sobre">
        <video class="hidden-xs hidden-sm" autoplay loop muted poster="screenshot.jpg" id="background">
            <source src="../img/system/bj_saap_201605.mp4">
        </video>

        <img class="hidden-md hidden-lg" src="../img/system/bj_saap_201605.png" id="background-image">

        </img>


        <div class="col-md-8  col-md-offset-2 col-sm-12 text-center">
            <div class="video-header-content">
                <div><img src="../img/system/logo-saap.png" /></div>
                <h1>Um novo conceito em ensino de alta performance.</h1>

            </div>
        </div>
    </div>

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
                        <a href="/simulados/simulador-online-saap-exame-oab-1-fase-teste-gratuito" class="btn btn-testar btn-outline btn-block btn-lg"> <span>TESTE GRATUITAMENTE!</span></a>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
    </div>
    <div id="main-wrapper" class="page">
        <div class="container">

            <div class="space small hidden-md hidden-lg"></div>

            <div class="section curso-big">
                <div class="post">
                    <div class="entry-header">
                        <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/173817322" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="post-content">
                        <h2>
                            Como o SAAP pode potencializar sua performance e ajudar a alcançar seus objetivos de forma efetiva
                        </h2>
                        <div class="entry-content" style="margin-top: 20px;">
                            <p>O SAAP é um sistema de aprendizagem de alta performance que alia conteúdo de excelência e análise de dados proporcionando o direcionamento do estudo de candidatos e examinandos.</p>
                        </div>
                    </div>
                </div><!--/post-->
            </div><!--/.section-->

            <div class="row">
                <div class="container col-md-10 col-md-offset-1 text-center">
                    <h1>Um sistema desenvolvido com foco em alta performance para que você alcance os seus objetivos</h1>
                    <p>Uma ferramenta revolucionária que combina conteúdo de excelência atualizado com tecnologia em análise de dados e avaliações simuladas. Tudo isso voltado para a sua aprovação!</p>
                    <div class="space"></div>
                </div>
            </div><!--/row-->

            <div class="section">
                <div class="space small"></div>

                <div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="0">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-7"><img src="/img/frontend/brj-tela-saap-03.jpg" class="img-responsive"></div>
                                    <div class="col-md-5">
                                        <div class="space large hidden-xs hidden-sm"></div>
                                        <h2>Simulação de provas com questões comentadas em vídeo, áudio e material complementar</h2>
                                        <p>Um poderoso simulador permitirá que você avalie seu desempenho e estude de forma orientada, seguindo todos os parâmetros de uma prova real, com eficiência e precisão.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-7"><img src="/img/frontend/brj-tela-saap-02.jpg" class="img-responsive"></div>
                                    <div class="col-md-5">
                                        <div class="space large hidden-xs hidden-sm"></div>
                                        <h2>Resultado personalizado através de infográficos estatísticos de performance</h2>
                                        <p>Tenha acesso a dados e métricas de sua real performance, verificando erros e acertos, o que permitirá um melhor planejamento dos estudos com foco no que é essencial para a sua aprovação.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--<div class="item">--}}
                            {{--<div class="container-fluid">--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-md-7"><img src="/img/frontend/brj-tela-saap-04.jpg" class="img-responsive"></div>--}}
                                    {{--<div class="col-md-5">--}}
                                        {{--<div class="space large hidden-xs hidden-sm"></div>--}}
                                        {{--<h2>Gráficos analíticos por disciplinas, temas e subtemas</h2>--}}
                                        {{--<p>Veja de forma segmentada o seu real desempenho, apresentando para você extamente o essencial a ser estudado.</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <!-- End Item -->
                    </div>
                    <!-- End Carousel Inner -->
                    <div class="controls">
                        <ul class="nav">
                            <li data-target="#custom_carousel" data-slide-to="0" class="active"  style="padding: 10px;">
                                <figure class="tint">
                                <a href="#"><img src="/img/frontend/brj-tela-saap-07.jpg"></a>
                                </figure>
                            </li>


                            <li data-target="#custom_carousel" data-slide-to="1" style="padding: 10px;">
                                <figure class="tint"><a href="#"><img src="/img/frontend/brj-tela-saap-06.jpg" ></a></figure>
                            </li>
                            {{--<li data-target="#custom_carousel" data-slide-to="2"><a href="#"><img src="/img/frontend/brj-tela-saap-05.jpg"></a></li>--}}
                        </ul>
                    </div>
                </div>
                <!-- End Carousel -->

            </div><!--/.section-->


            <div class="space"></div>

            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="noticiacard">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="/img/frontend/saap-inovador.png" alt="" />
                            </div>
                        </div>
                        <div class="noticiacard-content">
                            <h3 class="title">
                                Inovador e completo
                            </h3>
                            <div class="entry-content">
                                <p>Avaliação simulada com cronômetro, comentários a cada questão em vídeo, áudio e textos, espaço para anotações, marcações diretamente na questão, gabarito analítico e relatório segmentado de desempenho.</p>
                            </div>
                        </div>
                    </div><!--/post-->
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="noticiacard">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="/img/frontend/saap-360.png" alt="" />
                            </div>
                        </div>
                        <div class="noticiacard-content">
                            <h3 class="title">
                                Análise 360°
                            </h3>
                            <div class="entry-content">
                                <p>Análise completa e detalhada de cada concurso e Exame da OAB, apresentando um estudo minucioso de todos os aspectos relevantes sobre as últimas provas.</p>
                            </div>
                        </div>
                    </div><!--/post-->
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="noticiacard">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="/img/frontend/saap-otimizacao.png" alt="" />
                            </div>
                        </div>
                        <div class="noticiacard-content">
                            <h3 class="title">
                                Otimização dos estudos
                            </h3>
                            <div class="entry-content">
                                <p>Somente com treinamento é possível alcançar bons resultados. Por isso o SAAP oferece de maneira objetiva, contextualizada e eficiente, todos os mecanismos para potencializar seus estudos e desempenho.</p>
                            </div>
                        </div>
                    </div><!--/post-->
                </div>

            </div><!--/.row-->
            <div class="space"></div>

            <div class="row">

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="noticiacard">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="/img/frontend/saap-avalie.png" alt="" />
                            </div>
                        </div>
                        <div class="noticiacard-content">
                            <h3 class="title">
                                Avalie sua performance
                            </h3>
                            <div class="entry-content">
                                <p>Saiba exatamente como está sua performance através de relatórios completos de desempenho, que mostram ponto a ponto os erros e acertos correspondentes a cada tema.</p>
                            </div>
                        </div>
                    </div><!--/post-->
                </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="noticiacard">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <img class="img-responsive" src="/img/frontend/saap-orientado.png" alt="" />
                                </div>
                            </div>
                            <div class="noticiacard-content">
                                <h3 class="title">
                                    Conteúdo orientado ao resultado
                                </h3>
                                <div class="entry-content">
                                    <p>Indicação de legislação, jurisprudência, informativos, livros, e-books e principalmente cursos essenciais, com base nas suas estatísticas de desempenho.</p>
                                </div>
                            </div>
                        </div><!--/post-->
                    </div><!--/.row-->

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="noticiacard">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <img class="img-responsive" src="/img/frontend/saap-desempenho.png" alt="" />
                                </div>
                            </div>
                            <div class="noticiacard-content">
                                <h3 class="title">
                                    Alcance seu melhor desempenho
                                </h3>
                                <div class="entry-content">
                                    <p>Ferramentas desenvolvidas após análise criteriosa de todo o processo de estudo com sedimentação do conhecimento orientado a aferir e melhorar o seu desempenho a cada etapa do SAAP.</p>
                                </div>
                            </div>
                        </div><!--/post-->
                    </div>


                </div><!--/.row-->
        </div><!--/.container-->

        {{-- <div class="space medium"></div>
        @include('frontend.includes.exams-discount') --}}
        <div class="space small"></div>

        <div class="container">
            <div class="row">
                <div class="container col-md-10 col-sm-10 col-xs-10  col-md-offset-1 text-center">
                    <h1>Escolha o seu SAAP e comece a estudar com alta performance</h1>
                    <div class="space"></div>
                </div>
            </div><!--/row-->
        </div><!--/.container-->



        <div class="container">
            <div class="row">
                <div class="section curso-small">
                    @foreach($packages as $index => $package)


                        @if($index == 0 || $index == ceil($packages->count() / 2.0))
                            <div class="col-md-6 col-sm-12">
                                <div class="space"></div>
                                @endif


                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <a href="{{ route('packages.show',[$package->slug]) }}"><img class="img-responsive" src="{{ imageurl("packages/", $package->id , $package->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <span class="label-small label-success">SAAP</span>
                                        <h2>
                                            <a href="{{ route('packages.show',[$package->slug]) }}">{{ $package->title }}</a>
                                        </h2>
                                        <div class="entry-content">
                                            <p>{{ $package->short_description }}</p>
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
                                </div><!--/card-->

                                @if($index == (ceil($packages->count() / 2.0) - 1) || $index == $packages->count() - 1  )
                            </div>
                        @endif
                    @endforeach
                </div><!--/.section-->
            </div><!--/.row -->
            <h3> <a type="button" href="/exame-oab/1-fase-simuladores-por-disciplina" class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;"></i>&nbsp;&nbsp;TODOS OS SAAP's</a></h3>
        </div><!--/.container-->
        <br/>
    </div>



@endsection