@extends('frontend.layouts.master')

@section('title')
    Novo Código de Ética para OAB | {{app_name()}}
@endsection

@section('meta-description', 'Assista a aula e receba o pdf sobre o novo código de ética para oab')
@section('meta-title', 'Novo Código de Ética para OAB')

@section('content')
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,700" rel="stylesheet">
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
            #description-jonas{
                margin-left: 0 !important;
            }
            #description-code{
                margin-left: 0 !important;
            }
            #pc_book{
                width: 100% !important;
                margin-top: 20px !important;
            }
            #jonnas_desktop{
                display: none !important;
            }
            #jonnas_mobile{
                display: block !important;
            }
            #jonnas_mobile img{
                width: 100%;
            }
            #footer_img{
                padding: 10px;
            }
        }
        .row {
            margin: 0 !important;
        }
        .row p{
            font-family: 'Titillium Web', sans-serif;
        }
        .row .content{
            width: 100%;
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
            font-weight: 700;
            font-size: 40px;
        }

        .row a{
            font-family: 'Titillium Web', sans-serif;
        }

        .row .col-md-12{
            padding-left: 0;
            padding-right: 0;
        }
        .inputs input{
            display: block;
            padding: 6px;
            width: 100%;
            margin-bottom: 7px;
        }
        #description-jonas{
            margin-left: 7%;
        }
        #description-code{
            margin-left: 7%;
        }
        #pc_book{
            margin: 0 auto; 
            width: 50%; 
        }
        #jonnas_desktop{
            display: block;
        }
        #jonnas_mobile{
            display: none;
        }
        #jonnas_desktop img{
            width: 100%;
        }
        #description-code a{
            text-decoration: none;
            color: #00539d;
            font-weight: bold;
        }
        #description-code a:hover{
            color: black !important;
        }
    </style>

     <section id="main-content">
        <div class="container">
            <section id="search-meaning">
                <h1 class="section-title">Novo Código de Ética para OAB</h1>
            </section>
            <br/>
            
            <div class="row">
                <div class="content">
                
                    {{-- Linha onde fica o cabeçalho --}}
                    <div class="row" style="background-image: url('../../../../img/landingpages/etica_e_oab/fundo_cinza_grande.png')">
                        <div class="col-md-12">
                            <img src="/img/landingpages/etica_e_oab/topo.png" width="100%" alt="codigodeeticaparaoab">
                        </div>
                    </div>

                    {{-- Linha onde fica o subtítulo --}}
                    <div class="row" style="background-image: url('../../../../img/landingpages/etica_e_oab/fundo_cinza_grande.png')">
                        <br>
                        <div class="col-md-12" id="top">
                            <p class="subtitle" style="text-align: center; color: #00539d;">
                                DICAS ESSENCIAIS DE ÉTICA
                            </p>
                            <p style="color: #00539d; font-size: 30px; font-weight: 300; text-align: center">GARANTA 25% DA PROVA</p>
                        <br>
                        </div>
                        <div class="col-md-12">

                            <div style="width: 95%; margin: 0 auto;">
                            <div class="col-md-6 video">
                                <iframe src="https://player.vimeo.com/video/208139393" width="100%" height="315" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                            </div>

                            <div class="col-md-6">
                                <div style="width: 100%">
                                    <div id="pc_book">
                                        <img width="100%" src="/img/landingpages/etica_e_oab/pc_livro.png" alt="codigodeeticaparaoab">
                                    </div>
                                </div>
                                <fieldset>
                                    <form action="" method="POST" id="subscribe_oab_e_etica">
                                        <div class="form-group col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 2px;">
                                            <label for="name">Nome</label>
                                            <input class="form-control" id="name" placeholder="Digite o Nome" name="name" type="text">
                                        </div>
                                        <div class="form-group col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 7px;">
                                            <label for="email">E-mail</label>
                                            <input class="form-control" id="email" placeholder="Digite o E-mail" name="email" type="email">
                                        </div>
                                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" name="" style="border: none; padding-top: 5px; padding-bottom: 5px; width: 100%; background-color: orange; border-radius: 15px; color: white; font-weight: 700" >QUERO AULA + E-BOOK</button> 
                                        </div>
                                    </form>
                                </fieldset>
                                <div id="loading" style="display: none" class="text-center">
                                    <img src="{{ asset('assets/vendor/pagseguro/images/load-horizontal.gif') }}">
                                </div>
                            </div>
                            </div>
                            <div class="col-md-12">
                                <p style="width: 75%; color: #00539d; text-align: center; margin: 0 auto;">
                                    O professor <strong>Jonnas Vasconcelos</strong> liberou uma <strong>aula especial</strong> com dicas indispensáveis para você garantir pontuação máxima em <strong>Ética no XXII Exame da OAB</strong>. Além disso, disponibilizou um <strong>e-book inédito</strong> com trechos do seu novo livro com tabelas esquematizadas da disciplina.  Para receber o e-book basta informar seu nome e e-mail no espaço acima.
                                </p>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="background-image: url('../../../../img/landingpages/etica_e_oab/fundo_azul.png')">
                        <div class="col-md-12">
                            <div class="col-md-5" id="jonnas_desktop">
                                <img src="/img/landingpages/etica_e_oab/jonnas.png" alt="codigodeeticaparaoab">
                            </div>
                            <div class="col-md-6" id="description-jonas">
                                <p>&nbsp;</p><p>&nbsp;</p>
                                <p style="color: white; font-weight: 700">Jonnas Vasconcelos</p>
                                <p>&nbsp;</p>
                                <p style="color: white; font-weight: 500">Doutorando em Direito Econômico pela Faculdade de Direito da Unversidade de São Paulo (USP), Mestre em Direito Humanos e Bacharel em Direito pela mesma instituição (USP), Professor Substituto da Faculdade de Direito da Universidade Federal da Bahia (UFBA). Advogado. Possui interesse e experiência acadêmica e profissional nas seguintes áreas do conhecimento Jurídico: Direito Econômico, Ética Jurídica, Sociologia Jurídica, Direito Humanos e Filosofia do Direito.</p>
                            </div>
                            <div class="col-md-5" id="jonnas_mobile">
                                <img src="/img/landingpages/etica_e_oab/jonnas.png" width="100%" alt="codigodeeticaparaoab">
                            </div>
                        </div>

                    </div>

                    {{-- Linha onde fica o cabeçalho --}}
                    <div class="row" style="background-image: url('../../../../img/landingpages/etica_e_oab/fundo_cinza_grande.png')">
                        <div class="col-md-12">
                            <div class="col-md-7" id="description-code">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                                <p style="color: white; font-weight: 700; color: #00539d; font-size: 25px;">O NOVO CÓDIGO DE ÉTICA E DISCIPLINA OAB</p>
                                <p style="color: white; font-weight: 500; color: #00539d">O e-book disponível é parte do livro Novo Código de Ética e Disciplina da OAB, do professor Jonnas Vasconcelos. Na obra completa, você encontra:</p>
                                <ol>
                                    <li style="color: #00539d; font-weight: 500;">Quadro comparativo entre a nova e a antiga redação;</li>
                                    <li style="color: #00539d; font-weight: 500;">Explicações sobre os novos capítulos e artigos;</li>
                                    <li style="color: #00539d; font-weight: 500;">Comentários acerca das mudanças normativas;</li>
                                    <li style="color: #00539d; font-weight: 500;">Anexo com a legislação profissional pertinente com notas remissivas.</li>
                                </ol>
                                <p style="color: white; font-weight: 500; color: #00539d; margin-bottom: 0">
                                Obra que faz parte da Coleção Temas Essenciais para OAB.</p>
                                <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
                                <p style="color: white; font-weight: 500; color: #00539d; font-size: 13px; margin-bottom: 0">O livro faz parte da Coleção Temas Essenciais para OAB e está disponível para compra no site da <a href="http://www.editoragz.com.br/o-novo-codigo-de-etica-e-disciplina-da-oab-comentado-vol-i-jonnas-vasconcelos" target="_blank">Editora GZ</a>.</p>
                                <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
                            </div>

                            <div class="col-md-4">
                                <img src="/img/landingpages/etica_e_oab/livro.png" height="" width="60%" alt="codigodeeticaempdf">
                            </div>
                        </div>

                    </div>

                    <div class="row" style="background-color: orange">
                        <a href="#top" style="text-align: center; font-size: 30px; color: white; font-weight: 700">
                            <p style="text-align: center; margin-top: 8px; margin-bottom: 8px">QUERO AULA + E-BOOK</p>
                        </a>
                    </div>

                    <div class="row" style="background-color: #00539d">
                        <br>
                        <p style="text-align: center; font-weight: 500; color: white">
                            ACESSE AS NOSSAS REDES SOCIAIS E FIQUE POR DENTRO DAS NOVIDADES.
                        </p>
                        <p style="text-align: center;" id="footer_img">
                            <img src="../img/landingpages/etica_e_oab/rodape.png" usemap="#Map" alt="codigodeeticaparaoab">
                        </p>
                        <br>
                        <map name="Map" id="Map"><area shape="rect" coords="483,2,640,41" href="https://www.brasiljuridico.com.br/" target="_blank" /><area shape="rect" coords="211,5,459,36" href="https://www.facebook.com/BrasilJuridicoCursos" target="_blank" />
                              <area shape="rect" coords="1,5,175,39" href="https://www.instagram.com/brasiljuridico/" target="_blank" />
                            </map>
                    </div>
                </div>
            </div>
        </div>
    </section> 
@endsection
