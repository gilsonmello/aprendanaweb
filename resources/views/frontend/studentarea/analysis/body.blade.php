
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


                        <h2 style="color: #444"><strong>| Visão</strong> geral&nbsp;&nbsp;
                    <button class="btn btn-default btn-sm" style="border-color: #949398; color:#626471;cursor: pointer;" data-toggle="collapse" data-target="#visaoGeralOAB"></i>&nbsp;&nbsp;VER&nbsp;&nbsp;</button></h2>
                    <div id="visaoGeralOAB" class="collapse">
                        <br>
                        {!! $textVisaoGeralOAB !!}
                        <br>
                        <table class="table table-hover mb-none" style="font-size:1.6rem">
                            <tr style="background-color: #ddd !important;">
                                <th width="34%">DISCIPLINAS POR ORDEM DE RELEVÂNCIA</th>
                                <th width="22%" class="text-right">QTD DE QUESTÕES</th>
                                <th width="22%" class="text-right">PORCENTAGEM EM RELAÇÃO AO TOTAL DA PROVA</th>
                                <th width="22%" class="text-right">% PARA ATINGIR A APROVAÇÃO</th>
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
                                <th width="16%" class="text-right">% PARA ATINGIR A APROVAÇÃO</th>
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
