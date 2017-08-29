@extends('frontend.layouts.master')

@section('title')
    Análise 360° | {{app_name()}}
@endsection

@section('content')


    <div class="video-header section-sobre">
        <video  class="hidden-xs hidden-sm" autoplay loop muted poster="screenshot.jpg" id="background">
            <source src="../img/system/bj_saap_201605.mp4">
        </video>

        <img class="hidden-md hidden-lg" src="../img/system/bj_saap_201605.png" id="background-image">

        <div class="col-md-8  col-md-offset-2 col-sm-12 text-center">
            <div class="video-header-content">
                <div><img src="../img/system/logo-360.png" /></div>
                <h1>Um novo conceito em ensino de alta performance!</h1>

            </div>
        </div>
    </div>

    <div id="main-wrapper" class="page">
        <div class="container">

        <br/>

        <div class="space small hidden-md hidden-lg"></div>

        <div class="section curso-big">
            <div class="post">
                <div class="entry-header">
                    <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/168482389" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="post-content">
                    <h2>
                        ANÁLISE 360°: uma seleção analítica de conteúdo coordenada por nomes consagrados do Direito
                    </h2>
                    <div class="entry-content" style="margin-top: 20px;">
                        <p>Nossa equipe especializada fará uma análise minuciosa da incidência de conteúdos nas provas aplicadas em concursos e Exames da OAB, possibilitando aos candidatos e examinandos otimizarem o seu tempo de estudo com o máximo de aproveitamento.</p>
                    </div>
                </div>
            </div><!--/post-->
        </div><!--/.section-->

        <div class="row">
            <div class="container col-md-10 col-md-offset-1 text-center">
                <h1>Você tem que saber o que deve ser estudado!</h1>
                <p>Quantas vezes você já ficou sem saber o que estudar, por onde começar, ou qual assunto é mais relevante? Com o ANÁLISE 360° do Brasil Jurídico você saberá exatamente o que é essencial para a sua aprovação e qual o impacto de cada disciplina e tema para alcançar os seus objetivos!</p>
                <div class="space"></div>
            </div>
        </div><!--/row-->

        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="noticiacard">
                    <div class="entry-header">
                        <div class="entry-thumbnail">
                            <img class="img-responsive" src="/img/frontend/saap-otimizacao.png" alt="" />
                        </div>
                    </div>
                    <div class="noticiacard-content">
                        <h3 class="title">
                            Pesquisa Analítica
                        </h3>
                        <div class="entry-content">
                            <p>Uma equipe especializada, coordenada por grandes nomes da área jurídica, analisa provas anteriores para categorizar as questões e identificar a incidência de temas e subtemas.</p>
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
                            Seleção de conteúdo
                        </h3>
                        <div class="entry-content">
                            <p>A partir da pesquisa analítica nossa equipe seleciona todo o material de estudos essencial para uma preparação de alta performance orientada a resultados.</p>
                        </div>
                    </div>
                </div><!--/post-->
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="noticiacard">
                    <div class="entry-header">
                        <div class="entry-thumbnail">
                            <img class="img-responsive" src="/img/frontend/saap-inovador.png" alt="" />
                        </div>
                    </div>
                    <div class="noticiacard-content">
                        <h3 class="title">
                            Tecnologia e inovação
                        </h3>
                        <div class="entry-content">
                            <p>Todos os dados referentes à Análise 360° são cadastrados no nosso sistema que, com base nos parâmetros de concursos e Exames da OAB, geram simulados específicos de questões.</p>
                        </div>
                    </div>
                </div><!--/post-->
            </div><!--/.row-->
        </div><!--/.row-->

        <div class="space"></div>

    </div>



@endsection