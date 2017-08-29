@extends('frontend.layouts.master')

@section('meta-description', 'Curso online para concurso. Seja aprovado no concurso do TRE. Novo CPC para concurso. Estude online. Melhor curso para concursos')

@section('meta-title', 'Curso para concurso - Metodologia')

@section('title')
    Metodologia - Concursos | {{app_name()}}
@endsection

@section('content')
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,800,900" rel="stylesheet">
    <style type="text/css">
        @media (min-width: 300px) and (max-width: 1200px){
            .row .computer img{
                width: 100% !important;
            }
            img{
                width: 100% !important;
            }
            .link-test-gratuitamente{
                font-size: 15px !important;
            }

            #footer a{
                font-size: 15px;
                margin-bottom: 10px;
                display: block;
            }
        }

        .row p{
            font-family: 'Raleway', sans-serif;
        }
        .row .methodology-content{
            width: 80%;
            margin: 0 auto;
        }
        .row .text-top{
            margin-top: 10%;
        }
        .row .text-top{
            color: white;
            font-weight: 800;
            font-size: 30px;
            padding-left: 10%;
        }
        .row .text-reduced{
            font-size: 15px;
            font-weight: normal;
        }
        .subtitle{
            color: white;
            font-weight: 900;
            font-size: 33px;
        }

        .row a{
            font-family: 'Raleway', sans-serif;
        }



    </style>

     <section id="main-content">
        <div class="container">
            <section id="search-meaning">
                <h1 class="section-title">Curso&nbsp;para&nbsp;concurso&nbsp;-&nbsp;Metodologia</h1>
            </section>
            <br/>
            
            <div class="row">
                <div class="methodology-content">
                    <div class="row" style="background-color: #023f5f">
                        <div class="col-md-12">
                            <div class="col-md-6 text-top">
                                <p>Um novo método para passar nos Concursos</p>
                                <p class="text-reduced">{{ strtoupper("Pesquisa, tecnologia e prÁtica") }}</p>
                                <p style="font-weight: 900;"><a class="link-test-gratuitamente" style="background-color: #ff9000; border: 2px solid white; padding: 9px; color: white; font-size: 20px;" href="#footer">TESTE GRATUITAMENTE</a></p>
                            </div>
                            <div class="col-md-6 computer">
                                <img src="../img/metodologia-landingpage/Concurso/cursoconcursoonline.png" alt="cursoconcursoonline">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="background-color: #14577c">
                        <br>
                        <div class="col-md-12">
                            <p class="subtitle" style="text-align: center">
                                ENTENDA A TRÍADE DA APROVAÇÃO
                            </p>
                            <p style="color:white; font-size: 22px; font-weight: 300; text-align: center">ANÁLISE 360º - SIMULADOR SAAP - CURSOS ESSENCIAIS</p>

                        <br>
                        </div>
                    </div>
                   
                    
                    <div class="row" style="background-color: white;">
                    <br>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <img src="../img/metodologia-landingpage/Concurso/cursotre.png" alt="cursotre">
                            </div>
                            <div class="col-md-5">
                                <br>
                                <p style="font-weight: 500; color: #666; font-size: 25px;">Tudo começa com a pesquisa. O <strong>Análise 360°</strong> mapeia os <strong>dados</strong> de <strong>todas as provas</strong> aplicadas pela banca</p>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row" style="background-color: #e1e1e1;">
                    <br>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <img src="../img/metodologia-landingpage/Concurso/melhorcursoconcurso.png" alt="melhorcursoconcurso">
                            </div>
                            <div class="col-md-5">
                                <br><br>
                                <p style="font-weight: 500; color: #666; font-size: 25px;">e classifica em percentuais os <strong>temas</strong> e <strong>subtemas</strong> mais cobrados nas provas</p>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row" style="background-color: white;">
                    <br>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <img src="../img/metodologia-landingpage/Concurso/questoesconcurso.png" alt="questoesconcurso">
                            </div>
                            <div class="col-md-5">
                                <br><br>
                                <p style="font-weight: 500; color: #666; font-size: 25px;">Assim, desenvolvemos uma ferramenta <strong>inédita</strong> que simula uma experiência real da prova: o <strong>Simulador SAAP.</strong></p>
                                <p style="color: #666;">AS QUESTÕES SÃO <strong>INÉDITAS</strong> E <strong>ADAPTADAS</strong>, <strong>COMENTADAS EM VÍDEO</strong> POR PROFESSORES.</p>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row" style="background-color: #e1e1e1;">
                    <br>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <img src="../img/metodologia-landingpage/Concurso/cursinhoconcurso.png" alt="cursinhoconcurso">
                            </div>
                            <div class="col-md-5">
                                <br>
                                <p style="font-weight: 500; color: #666; font-size: 25px;">Você utiliza o simulador e, ao final do teste, recebe um <strong>relatório completo</strong> com tudo que você necessita reforçar</p>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row" style="background-color: white;">
                    <br>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <img src="../img/metodologia-landingpage/Concurso/logo-analise.png" alt="cursinhoconcurso">
                            </div>
                            <div class="col-md-5">
                                <br>
                                <p style="font-weight: 500; color: #666; font-size: 25px;">Indicado pelo sistema, você estuda somente o <strong>essencial</strong>, apontado na <strong>análise de desempenho</strong>. Tudo para otimizar o seu tempo.</p>
                            </div>
                        </div>
                        
                    </div>


                    <div id="footer" class="row" style="background-color: #ff9000;">
                        <br>
                        <div class="col-md-12">
                            <br>
                            <p style="text-align: center; font-weight: 500; color: white; font-size: 25px;">Siga o nosso método e faça a prova com segurança.</p>
                            <p style="text-align: center; font-weight: 900; color: white;">TESTE GRATUITAMENTE</p>
                            <br>
                            <div class="col-md-7" style="width: 100%; text-align: center;">
                                <a style="font-weight: 500; font-size: 25px; text-align: center; border: 2px solid white; padding: 8px 40px 8px 40px; color: white;" href="/carrinho/add/55/package">QUESTÕES DO NOVO CPC</a>
                                
                            </div>
                            <br><br><br>
                        </div>
                        
                    </div>


                    <div class="row" style="background-color: white;">
                        
                        <div class="col-md-12"><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
@endsection
