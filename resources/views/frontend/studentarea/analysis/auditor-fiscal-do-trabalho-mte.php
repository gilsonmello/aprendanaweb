
<?php

$titulodisciplina = "Segurança e Saúde no Trabalho";

$titulo = " | Auditor Fiscal do Trabalho - MTE | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 3;

$questoes = 133;

$questoesNaDisciplina = 113;

$questoesPorProva = 180;

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
$temasMaisFrequentesBaseSuperior = 18 + 1;
$temasMaisFrequentesBaseInferior = 9 - 2;

$temasMaisFrequentes = array(
        array('ORGANIZAÇÃO ADMINISTRATIVA E TERCEIRO SETOR', 18 ),
        array('AGENTES PÚBLICOS', 17 ),
        array('CONTRATOS ADMINISTRATIVOS', 13 ),
        array('INTERVENÇÃO ESTATAL NA PROPRIEDADE PRIVADA', 12 ),
        array('CONTROLE DA ADMINISTRAÇÃO', 9 ),
      );

$temas = array(
    array('1. nº 07, Programa de Controle Médico de Saúde Ocupacional, da Portaria nº 24, de 29/12/1994; '),
    array('2. ORGANIZAÇÃO ADMINISTRATIVA E TERCEIRO SETOR'),
    array('3. PODERES DA ADMINISTRAÇÃO'),
    array('4. ATOS ADMINISTRATIVOS'),
    array('5. CONTRATOS ADMINISTRATIVOS'),
    array('6. LICITAÇÕES'),
    array('7. SERVIÇOS PÚBLICOS'),
    array('8. AGENTES PÚBLICOS'),
    array('10. INTERVENÇÃO ESTATAL NA PROPRIEDADE PRIVADA'),
    array('11. INTERVENÇÃO ESTATAL NO DOMÍNIO ECONÔMICO'),
    array('12. CONTROLE DA ADMINISTRAÇÃO'),
    array('13. IMPROBIDADE ADMINISTRATIVA: LEI 8.429/92'),
    array('14. RESPONSABILIDADE CIVIL DO ESTADO'),
    array('15. PRESCRIÇÃO NO DIREITO ADMINISTRATIVO'),
    array('16. PROCESSO ADMINISTRATIVO'),
    array('17. BENS PÚBLICOS'),
);


$temasJaExigidos = array(
    array('PRINCÍPIOS, FONTES E INTERPRETAÇÃO' , 'IX, XII'),
    array('ORGANIZAÇÃO ADMINISTRATIVA E TERCEIRO SETOR' , 'II, III, IV, V, VI, VII, VIII, XI, XIII, XIV, XV, XVII, XVIII, XX (Salvador)'),
    array('PODERES DA ADMINISTRAÇÃO' , 'II, VII, X, XI, XIII, XIV'),
    array('ATOS ADMINISTRATIVOS' , 'IV, V, VI,  VII, XII, XVII, XIX'),
    array('CONTRATOS ADMINISTRATIVOS' , 'II, III, IV, VIII, IX, XI, XVI, XVIII, XIX'),
    array('LICITAÇÕES' , 'III, X, XI, XII, XIII, XV, XVIII, XX'),
    array('SERVIÇOS PÚBLICOS' , 'IX, XIII, XIV, XVI, XIX, XX'),
    array('AGENTES PÚBLICOS' , 'II, III, V, VI, X, XI, XII, XIV, XV, XVII, XVIII, XIX, XX, XX (Salvador)'),
    array('INTERVENÇÃO ESTATAL NA PROPRIEDADE PRIVADA' , 'II, III, VII, VIII, IX, X, XI, XII, XIII, XVII'),
    array('CONTROLE DA ADMINISTRAÇÃO' , 'II, III, VI,  VIII, IX, X, XV, XVI, XIX, XX'),
    array('IMPROBIDADE ADMINISTRATIVA: LEI 8.429/92' , 'V, VIII, XIV, XVI, XVII, XVIII, XIX, XX (Salvador)'),
    array('RESPONSABILIDADE CIVIL DO ESTADO' , 'III, IV, V, VI, VIII, XIX, XX, XX (Salvador)'),
    array('PROCESSO ADMINISTRATIVO' , 'II, III, XII, XVI, XVII, XVIII, XX'),
    array('BENS PÚBLICOS' , 'VI'),
    array('INTERVENÇÃO ESTATAL NO DOMÍNIO ECONÔMICO' , 'IX, XII, XVI'),
    array('PRESCRIÇÃO NO DIREITO ADMINISTRATIVO' , 'V, XX, XX (Salvador)'),
    );

$temasNuncaExigidos = array(
);

$temasIncidencias = array(
        array('1' , 'ORGANIZAÇÃO ADMINISTRATIVA E TERCEIRO SETOR', 18, 'top-part' ),
        array('2' , 'AGENTES PÚBLICOS', 17, 'top-part' ),
        array('3' , 'CONTRATOS ADMINISTRATIVOS', 13, 'top-part' ),
        array('4' , 'INTERVENÇÃO ESTATAL NA PROPRIEDADE PRIVADA', 12, 'top-part' ),
        array('5' , 'CONTROLE DA ADMINISTRAÇÃO', 9, 'top-part' ),
        array('6' , 'LICITAÇÕES', 9, 'top-part' ),
        array('7' , 'IMPROBIDADE ADMINISTRATIVA: LEI 8.429/92', 9, 'top-part' ),
        array('8' , 'PODERES DA ADMINISTRAÇÃO', 8, 'top-part' ),
        array('9' , 'ATOS ADMINISTRATIVOS', 8, 'top-part' ),
        array('10' , 'SERVIÇOS PÚBLICOS', 7, 'top-part' ),
        array('11' , 'RESPONSABILIDADE CIVIL DO ESTADO', 7, 'low-part' ),
        array('12' , 'PROCESSO ADMINISTRATIVO', 7, 'low-part' ),
        array('13' , 'INTERVENÇÃO ESTATAL NO DOMÍNIO ECONÔMICO', 4, 'low-part' ),
        array('14' , 'PRINCÍPIOS, FONTES E INTERPRETAÇÃO', 2, 'low-part' ),
        array('15' , 'PRESCRIÇÃO NO DIREITO ADMINISTRATIVO', 2, 'low-part' ),
        array('16' , 'BENS PÚBLICOS', 1, 'low-part' ),
      );


$textVisaoGeralOAB = "
                   <p>O Ministério do Trabalho e Emprego apresentou este ano um total de 847 vagas em

aberto para o cargo de Auditor Fiscal do Trabalho ao Ministério do Planejamento,

Orçamento e Gestão, demandando a urgente necessidade de realização de concurso

público para suprir ao menos parte destas vagas.
</p><p>
Dentre as disciplinas que costumam ser abordadas nos concursos de Auditor Fiscal do

Trabalho, uma disciplina que se destaca é Segurança e Saúde no Trabalho, tendo em

vista tanto a sua especificidade, quanto seu peso e o número de questões contempladas

nas provas.
</p><p>
Diante disto, faz-se necessário aprofundar o olhar sobre esta disciplina, e tomamos

como parâmetro as duas últimas provas objetivas do MTE para verificar de que forma o

conhecimento em Segurança e Saúde no Trabalho vem sendo exigido do examinando.
</p><p>
Concurso que tradicionalmente era realizado pela ESAF (2003, 2006 e 2010), em 2013

foi realizado pelo CESPE (CEBRASPE), razão pela qual foram analisadas as provas de

2006, 2010 e 2013, para garantir as informações mais importantes relativas às duas

bancas que podem ser escolhidas pela instituição para a realização do Concurso.
</p><p>
Vejamos os aspectos mais importantes, delineados neste 360º:
</p>
";


$textVisaoGeralDisciplina = "
                    <p>De acordo com a tabela exposta, Direito Administrativo compõe o terceiro grupo de disciplinas mais importantes da prova, pois foi contemplado com 06 questões no último exame, o que corresponde à 15% da pontuação necessária para a aprovação do candidato na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na primeira fase, visando oferecer dados concretos ao candidato, para que o mesmo possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar uma lista com temas passíveis de cobrança na 1ª fase.</p>
                    <p>Para Direito Administrativo foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo candidato para que o mesmo possa avançar para a 2ª Fase. É importante observar que os temas “Organização Administrativa e Terceiro Setor”, “Agentes Públicos” “Contratos Administrativos” e “Intervenção do Estado na Propriedade Privada” correspondem a quase 50% do total de incidência da prova nesta disciplina, o que demostra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do candidato a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente cobrados nas provas, conduzindo-o à aprovação no Exame da Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";

?>
<section id="exam-panel" class="panel" >

    <div class="container">
        <div class="row margin-bottom-40"><h1 style="color:black"><strong>| Análise 360º</strong>  {{ $titulo }}</h1>&nbsp;&nbsp;
        </div>

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
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-8">
                                    <h2 style="color: #444"><strong>| Provas</strong> analisadas</h2>

                                </div>

                                <div class="col-md-4">
                                    <h1 style="color: #4CB8C4"><i class="fa fa-file-text-o "></i> {{$provas}}</h1>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">

                                <div class="col-md-8">
                                    <h2 style="color: #444"><strong>| Temas</strong> analisados</h2>
                                </div>

                                <div class="col-md-4">
                                    <h1 style="color: #4CB8C4"><i class="fa fa-object-ungroup"></i> {{count($temas)}}</h1>
                                </div>

                            </div>
                            <br>
                            <br>
                            <div class="row">

                                <div class="col-md-8">
                                    <h2 style="color: #444"><strong>| Questões</strong> analisadas</h2>
                                </div>

                                <div class="col-md-4">
                                    <h1 style="color: #4CB8C4"><i class="fa fa-list-ol"></i> {{ $questoesNaDisciplina != 0 ? $questoesNaDisciplina : $questoes }}</h1>
                                </div>

                            </div>
                            <br>
                            <br>

                        </div>

                        <div class="col-md-6">
                            <h2 style="color: #444"><strong>| {{ count( $temasMaisFrequentes ) }} Temas</strong> mais frequentes</h2>
                            <div class="chart chart--dev">
                                <ul class="chart--horiz">
                                    @foreach ($temasMaisFrequentes as $temaMaisFrequente)
                                    <li class="chart__bar" style="width:{{ ($temaMaisFrequente[1] - $temasMaisFrequentesBaseInferior) / ($temasMaisFrequentesBaseSuperior - $temasMaisFrequentesBaseInferior) * 100  }}%;">
                                    </li>
                                    <p class="chart__label">
                                        {{ $temaMaisFrequente[0] }} - {{ $temaMaisFrequente[1]  }} QUESTÕES
                                    </p>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-12">
                <div class="card" style="font-size: 1.7rem; padding: 40px;">


                    <h2 style="color: #444"><strong>| Visão</strong> geral sobre o Exame da OAB &nbsp;&nbsp;
                        <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" data-toggle="collapse" data-target="#visaoGeralOAB"></i>&nbsp;&nbsp;VER&nbsp;&nbsp;</button></h2>
                    <div id="visaoGeralOAB" class="collapse">
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
            <div class="col-md-12">
                <div class="card" style="font-size: 1.7rem; padding: 40px;">
                    <h2 style="color: #444"><strong>| Visão</strong> geral sobre a disciplina</h2>
                    <br>
                    {!! $textVisaoGeralDisciplina !!}
                    <br>

                    <button class="btn btn-primary" style="cursor: pointer;" data-toggle="collapse" data-target="#temasSelecionados"></i>&nbsp;&nbsp;VER TEMAS ANALISADOS&nbsp;&nbsp;</button></h2>
                    <br>
                    <br>

                    <div id="temasSelecionados" class="collapse">
                        @foreach ($temas as $tema)
                        <p><strong>{{ $tema[0] }}</strong></p>
                        @endforeach
                    </div>
                    <br>
                    <p>Confira nas tabelas a seguir quais destes temas já foram abordados e em quais Exames:</p>
                    <br>
                    <table class="table table-hover mb-none">
                        <tr class="" style="background-color: #ddd !important;"><th colspan="2">{!! $titulodisciplina  !!}</th></tr>

                        <tr class="active"><th>TEMAS JÁ EXIGIDOS</th><th>EXAMES</th></tr>
                        @foreach ($temasJaExigidos as $temaJaExigido)
                        <tr><td>{{ $temaJaExigido[0] }}</td><td>{{ $temaJaExigido[1] }}</td></tr>
                        @endforeach

                        @if (count($temasNuncaExigidos) != 0)
                        <tr class="active"><th colspan="2">TEMAS AINDA NÃO EXIGIDOS</th></tr>
                        @endif
                        @foreach ($temasNuncaExigidos as $temaNuncaExigido)
                        <tr><td colspan="2">{{ $temaNuncaExigido[0] }}</td></tr>
                        @endforeach

                    </table>
                    <br>
                </div>
            </div>
        </div>


        {{--<div class="col-md-6">--}}
            {{--<div class="card" style="font-size: 1.7rem; height: auto; padding: 40px; margin-top: 20px">--}}
                {{--<h2 style="color: #444"><strong>| Subtemas</strong> mais frequentes</h2>--}}
                {{--<div class="chart chart--dev">--}}
                    {{--<ul class="chart--horiz">--}}
                        {{--@foreach ($subTemasMaisFrequentes as $subTemaMaisFrequente)--}}
                        {{--<li class="chart__bar" style="width:{{ ($subTemaMaisFrequente[1] - $subTemasMaisFrequentesBaseInferior) / ($subTemasMaisFrequentesBaseSuperior - $subTemasMaisFrequentesBaseInferior) * 100  }}%;">--}}
                            {{--</li>--}}
                        {{--<p class="chart__label">--}}
                            {{--{{ $subTemaMaisFrequente[0] }} - {{ $subTemaMaisFrequente[1]  }} QUESTÕES--}}
                            {{--</p>--}}
                        {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--<script src='http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular.min.js'></script>--}}
                {{--</div>--}}
            {{--</div>--}}

        <div class="row" >
            <div class="col-md-12">
                <div class="card" style="font-size: 1.7rem; padding: 40px;">
                    <h2 style="color: #444"><strong>| Análise</strong></h2>
                    <BR>
                    <p>A tabela abaixo indica quantas questões abordaram os temas já contemplados, apontando o percentual de incidência de cada um deles:</p>
                    <br>
                    <table class="table table-hover mb-none" style="font-size:1.6rem">
                        <tr style="background-color: #ddd !important;">
                            <th width="7%">NÍVEL DE INCIDÊNCIA</th>
                            <th width="33%">TEMA</th>
                            <th width="10%" class="text-right">QTD DE <BR>QUESTÕES</th>
                            <th width="30%"></th>
                            <th width="10%" class="text-right">%</th>
                        </tr>
                        <tbody>
                        {{--*/ $acumulado = 0; /*--}}
                        @foreach ($temasIncidencias as $temaIncidencia)
                        <tr>
                            <td width="10%">{{ $temaIncidencia[0] }}º</td>
                            <td width="40%">{{ $temaIncidencia[1] }}</td>
                            <td width="10%" class="text-right">{{ $temaIncidencia[2] }}</td>
                            <td width="30%">
                                <div class="progress" style="height:4px; margin-top: 10px">
                                    <span style="width: {{ $temaIncidencia[2] / $questoes * 100 }}%;" class="progress-bar progress-bar-{{ $temaIncidencia[3] }}"><span class="sr-only">{{ $temaIncidencia[2] / $questoes * 100 }}% progress</span></span>
                                </div>
                            </td><td width="10%" class="text-right"><span class="label label-{{ $temaIncidencia[3] }}">{{ number_format( $temaIncidencia[2] / $questoes * 100, 2, ',', '.') }}%</span></td>
                            {{--*/ $acumulado = $acumulado + ($temaIncidencia[2] / $questoes * 100); /*--}}
                            {{--</td><td width="10%" class="text-right"><span class="label label-{{ $temaIncidencia[3] }}">{{ number_format( $acumulado, 2, ',', '.') }}%</span></td>--}}
                        </tr>
                        @endforeach
                        <tr>
                            <td width="10%"></td>
                            <td width="40%"><b>TOTAL</b></td>
                            <td width="10%" class="text-right"><b>{{ $questoes }}{{ ( $questoesNaDisciplina != 0 ? '*' : '' ) }}</b></td>
                            <td width="30%"></td>
                            <td width="10%" class="text-right"><b>100%</b></td>
                            <td width="30%"></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    @if ($questoesNaDisciplina != 0)
                    <span style="font-size: 0.8em;">*O número total indicado na tabela não corresponde ao total de questões dos Exames, mas ao total de incidência dos temas, uma vez que algumas questões abordaram mais de um tema, sendo contabilizadas mais de uma vez. Até o momento, considerando-se todos os exames realizados pela FGV, a disciplina contou com o número total de {{ $questoesNaDisciplina }} questões.</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-12">
                <div class="card" style="font-size: 1.7rem; padding: 40px;">
                    <h2><strong>| Conclusão</strong></h2>
                    <br>
                    {!! $textVisaoGeralConclusao !!}


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
