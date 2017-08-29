<?php

$titulo = " | Exame OAB 1º Fase";

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 1715;

$questoesPorProva = 80;

$questoesParaAprovacao = 40;

$disciplinas = array(
        array('ÉTICA', 10, 'top-part', 80),
        array('DIREITO CONSTITUCIONAL', 7, 'top-part', 60),
        array('DIREITO CIVIL', 	7, 'top-part', 60),
        array('DIREITO ADMINISTRATIVO', 6, 'top-part', 60),
        array('DIREITO PENAL', 6, 'top-part', 60),
        array('DIREITO DO TRABALHO',  	6, 'top-part', 60),
        array('DIREITO PROCESSUAL CIVIL', 	6, 'top-part', 60),
        array('DIREITO PROCESSUAL PENAL', 	5, 'top-part', 60),
        array('DIREITO PROCESSUAL DO TRABALHO', 	5, 'top-part', 60),
        array('DIREITO EMPRESARIAL',  	5, 'top-part', 60),
        array('DIREITO TRIBUTÁRIO', 	4, 'top-part', 60),
        array('DIREITOS HUMANOS', 	3, 'low-part', 60),
        array('DIREITO DO CONSUMIDOR', 	2, 'low-part', 60),
        array('DIREITO DA CRIANÇA E DO ADOLESCENTE', 	2, 'low-part', 60),
        array('DIREITO INTERNACIONAL',  	2, 'low-part', 60),
        array('DIREITO AMBIENTAL',  	2, 'low-part', 60),
        array('FILOSOFIA DO DIREITO', 	2, 'low-part', 60),

);


$textVisaoGeralOAB = "
                    <p>O Exame de Ordem é um divisor de águas na vida do Bacharel em Direito. A partir da sua aprovação, ele deixa de ser um Bacharel para se tornar efetivamente Advogado. Por esta razão é que a aprovação no Exame de Ordem é tão almejada pelos candidatos.</p>
                    <p>O Exame de Ordem foi reconhecido pelo Supremo Tribunal Federal como instrumento de proficiência correto para aferir qualificação profissional ao Bacharel em Direito e tem por fim garantir as mínimas condições para o exercício da advocacia, sendo sua obrigatoriedade, portanto, constitucional.</p>
                    <p>Em 2010 ocorreu a unificação do Exame da OAB, passando a ser realizado simultaneamente nas 27 seccionais do país, três vezes por ano, em calendário fixado pela Diretoria do Conselho Federal da OAB.</p>
                    <p>Tão desejado quanto temido, o Exame de Ordem é bastante rigoroso na aprovação dos examinandos, buscando oferecer ao mercado profissionais qualificados para o exercício da advocacia, uma atividade indispensável à administração da justiça. Esse rigor se reflete nos altos índices de reprovação, que chegam a ultrapassar o percentual de 80%!</p>
                    <p>Aliada à rigidez excessiva, há a ausência de um conteúdo programático especificando os temas das disciplinas que serão exigidos na primeira fase do Exame, dificultando ainda mais o estudo do examinando.</p>
                    <p>Diante desse cenário urge a necessidade de um estudo direcionado, que se propõe a indicar para o examinando todos os aspectos mais relevantes do Exame, de modo que ele possa nortear seu estudo para aquilo que seja essencial à sua aprovação.</p>
                    <p>O Exame possui 17 disciplinas na 1ª Fase, que estavam dispostas da seguinte maneira na última prova (XIX Exame de Ordem):</p>
";


?>

<section id="exam-panel" class="panel" >

    <div class="container">
        <div class="row margin-bottom-40"><h1 style="color:black"><strong>| Análise 360º</strong>  {{ $titulo }}</h1></div>

        <div class="row" >
            <div class="col-md-6">
                <div class="card" style="font-size: 1.55rem; height: 410px; padding: 40px;">
                    <img class="img-responsive"  src="/img/system/{{ $logo }}" class="pull-center">
                    <br>
                    O SAAP é um sistema de aprendizagem de alta performance que alia conteúdo de excelência e análise de dados,  proporcionando o direcionamento do estudo do nosso aluno. A partir do Análise 360º,  nossa equipe especializada oferece um mapeamento minucioso da incidência dos temas mais recorrentes nas provas aplicadas em concursos e Exames da OAB, possibilitando aos candidatos e examinandos que otimizem seu tempo de estudo com o máximo de aproveitamento.
                    <br>

                </div>

            </div>

            <div class="col-md-6">
                <div class="marginVideo">
                    <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/168482389?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                            width="100%" height="410" frameborder="0"
                            webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                    </iframe>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-2">
                <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" onclick="javascript: window.history.back();"></i>&nbsp;&nbsp;VOLTAR&nbsp;&nbsp;</button>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-12">
                <div class="card" style="font-size: 1.7rem; padding: 40px; padding-top: 20px; padding-bottom: 20px;">
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <h2 style="color: #444"><strong>| Provas</strong> analisadas</h2>

                                </div>

                                <div class="col-md-2">
                                    <h1 style="color: #4CB8C4"><i class="fa fa-file-text-o "></i> {{$provas}}</h1>
                                </div>

                                <div class="col-md-4">
                                    <h2 style="color: #444"><strong>| Questões</strong> analisadas</h2>
                                </div>

                                <div class="col-md-2">
                                    <h1 style="color: #4CB8C4"><i class="fa fa-list-ol"></i> {{  $questoes }}</h1>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-12">
                <div class="card" style="font-size: 1.7rem; padding: 40px;">


                    <h2 style="color: #444"><strong>| Visão</strong> geral sobre o Exame da OAB &nbsp;&nbsp;</h2>
                    <div id="visaoGeralOAB" >
                        <br>
                        {!! $textVisaoGeralOAB !!}
                        <br>
                        <table class="table table-hover mb-none" style="font-size:1.6rem">
                            <tr style="background-color: #ddd !important;">
                                <th width="34%">DISCIPLINAS POR ORDEM DE RELEVÂNCIA</th>
                                <th width="22%" class="text-right">QTD DE QUESTÕES</th>
                                <th width="22%" class="text-right">PORCENTAGEM EM RELAÇÃO AO TOTAL DA PROVA (80 QUESTÕES)</th>
                                <th width="22%" class="text-right">% PARA ATINGIR A APROVAÇÃO (40 QUESTÕES)</th>
                            </tr>
                            <tbody>
                            @foreach ($disciplinas as $disciplina)
                                <tr>
                                    <td >{{ $disciplina[0] }}</td>
                                    <td class="text-right">{{ $disciplina[1] }}</td>
                                    <td class="text-right"><span class="label label-{{ $disciplina[2] }}">{{ number_format( $disciplina[1] / $questoesPorProva * 100, 2, ',', '.') }}%</span></td>
                                    <td class="text-right"><span class="label label-{{ $disciplina[2] }}">{{ number_format( $disciplina[1] / $questoesParaAprovacao * 100, 2, ',', '.') }}%</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <table class="table table-hover mb-none" style="font-size:1.6rem">
                            <tr style="background-color: #ddd !important;">
                                <th width="36%">DISCIPLINAS POR <BR>ORDEM DE RELEVÂNCIA</th>
                                <th width="16%" class="text-right">QTD DE <BR>QUESTÕES</th>
                                <th width="16%" class="text-right">PERFORMANCE <BR>ESPERADA</th>
                                <th width="16%" class="text-right">ACERTOS</th>
                                <th width="16%" class="text-right">% PARA ATINGIR A APROVAÇÃO (40 QUESTÕES)</th>
                            </tr>
                            <tbody>
                            {{--*/ $acumulado = 0; /*--}}
                            @foreach ($disciplinas as $disciplina)
                                <tr>
                                    <td >{{ $disciplina[0] }}</td>
                                    <td class="text-right">{{ $disciplina[1] }}</td>
                                    <td class="text-right">{{ $disciplina[3] }}%</td>
                                    <td class="text-right"><span class="label label-{{ $disciplina[2] }}">{{ number_format( $disciplina[1] * $disciplina[3] / 100, 2, ',', '.') }}</span></td>
                                    {{--*/ $acumulado = $acumulado + ($disciplina[1] * $disciplina[3] / 100); /*--}}
                                    <td class="text-right"><span class="label label-{{ $disciplina[2] }}">{{ number_format( $acumulado / $questoesParaAprovacao * 100, 2, ',', '.') }}%</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-2">
                <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" onclick="javascript: window.history.back();"></i>&nbsp;&nbsp;VOLTAR&nbsp;&nbsp;</button>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-12">
                <div class="card"  style="padding: 30px; padding-left: 60px; padding-right: 60px; text-align: center; background-color: black; color: white;">
                    <p>Violação de Direito Autoral é crime (art. 184, do CP). Nos termos do inciso I do artigo 29 da Lei 9.610/1998, a reprodução parcial ou total da obra de outros autores requer a autorização expressa do autor ou titular dos direitos autorais, mesmo que para fins didáticos e sem intuito lucrativo.</p>
                </div>
            </div>
        </div>
    </div>
</section>
