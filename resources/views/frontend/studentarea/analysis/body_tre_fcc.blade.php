
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
                    <h2 style="color: #444"><strong>| Análise</strong></h2>
                    <BR>
                    <p>A tabela abaixo indica quantas questões abordaram os temas já contemplados, apontando o percentual de incidência de cada um deles:</p>
                    <br>
                    <table class="table table-hover mb-none" style="font-size:1.6rem">
                        <tr style="background-color: #ddd !important;">
                            <th >Banca: FCC - CE 2011</th>
                        </tr>
                        <tbody>

                            <tr><td>Data de publicação do Edital: 28/10/2011</td></tr>
                            <tr><td>Nº de vagas: Analista Judiciário – Área Judiciária: 9
                                    Técnico Judiciário – Área Administrativa: 20
                                    Demais cargos: 17

                                </td></tr>
                            <tr><td>Nº de inscritos: Analista Judiciário – Área Judiciária: 7.423 / 9 vagas = 824,77 candidatos por vaga
                                    Técnico Judiciário – Área Administrativa: 22.930 / 20 vagas = 1.146,25 candidatos por vaga
                                </td></tr>
                            <tr><td>Etapas do Concurso:
                                    Prova Objetiva contemplando conhecimentos gerais e específicos / Prova subjetiva consistente numa redação.
                                </td></tr>
                            <tr><td>Nota de corte Analista Judiciário – Área Judiciária: 6,0</td></tr>
                            <tr><td>Nota de corte Técnico Judiciário – Área Administrativa: 6,04</td></tr>
                            <tr><td>Total de classificados Analista Judiciário – Área Judiciária: 243</td></tr>
                            <tr><td>Total de classificados Técnico Judiciário – Área Administrativa: 395</td></tr>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-hover mb-none" style="font-size:1.6rem">
                        <tr style="background-color: #ddd !important;">
                            <th >Banca: FCC - SP 2011</th>
                        </tr>
                        <tbody>

                            <tr><td>Data de publicação do Edital: 24/11/2011</td></tr>
                            <tr><td>Nº de vagas: Analista Judiciário – Área Judiciária: 34
                                    Técnico Judiciário – Área Administrativa: 49
                                    Demais cargos: 36
                                </td></tr>
                            <tr><td>Nº de inscritos: Analista Judiciário – Área Judiciária: 26.072 / 34 vagas = 766,82 candidatos por vaga
                                    Técnico Judiciário – Área Administrativa: 70.142 / 49 vagas = 1.431,46 candidatos por vaga
                                </td></tr>
                            <tr><td>Etapas do Concurso:
                                    Analista Judiciário – Área Judiciária: Prova Objetiva contemplando conhecimentos gerais e específicos / Prova subjetiva consistente numa redação.
                                    Técnico Judiciário – Área Administrativa: Prova Objetiva contemplando conhecimentos gerais e específicos
                                </td></tr>
                            <tr><td>Nota de corte Analista Judiciário – Área Judiciária: 6,0</td></tr>
                            <tr><td>Nota de corte Técnico Judiciário – Área Administrativa: 6,0</td></tr>
                            <tr><td>Total de classificados Analista Judiciário – Área Judiciária: 675</td></tr>
                            <tr><td>Total de classificados Técnico Judiciário – Área Administrativa: 8.608</td></tr>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-hover mb-none" style="font-size:1.6rem">
                        <tr style="background-color: #ddd !important;">
                            <th >Banca: FCC - RO 2013</th>
                        </tr>
                        <tbody>
                            <tr><td>Data de publicação do Edital: 17/09/2013</td></tr>
                            <tr><td>Nº de vagas: Analista Judiciário – Área Judiciária: 6
                                    Técnico Judiciário – Área Administrativa: 8
                                    Demais cargos: 1 + Cadastro reserva
                                </td></tr>
                            <tr><td>Nº de inscritos: Analista Judiciário – Área Judiciária: 1.941 / 6 vagas = 323,5 candidatos por vaga
                                    Técnico Judiciário – Área Administrativa: 12.007/ 8 vagas = 1.500,87 candidatos por vaga
                                </td></tr>
                            <tr><td>Etapas do Concurso:
                                    Analista Judiciário – Área Judiciária: Prova Objetiva contemplando conhecimentos gerais e específicos / Prova subjetiva consistente numa redação.
                                    Técnico Judiciário – Área Administrativa: Prova Objetiva contemplando conhecimentos gerais e específicos
                                </td></tr>
                            <tr><td>Nota de corte Analista Judiciário – Área Judiciária: 6,17</td></tr>
                            <tr><td>Nota de corte Técnico Judiciário – Área Administrativa: 6,0</td></tr>
                            <tr><td>Total de classificados Analista Judiciário – Área Judiciária: 210</td></tr>
                            <tr><td>Total de classificados Técnico Judiciário – Área Administrativa: 1.463</td></tr>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-hover mb-none" style="font-size:1.6rem">
                        <tr style="background-color: #ddd !important;">
                            <th >Banca: FCC - RR 2014</th>
                        </tr>
                        <tbody>
                            <tr><td>Data de publicação do Edital: 04/12/2014</td></tr>
                            <tr><td>Nº de vagas: Analista Judiciário – Área Judiciária: 1 + Cadastro reserva
                                    Técnico Judiciário – Área Administrativa: 4 + Cadastro reserva
                                    Demais cargos: 3 + Cadastro reserva



                                </td></tr>
                            <tr><td>Nº de inscritos: Analista Judiciário – Área Judiciária: 1.320 / 1 vagas = 1.320 candidatos por vaga
                                    Técnico Judiciário – Área Administrativa: 7.121/ 4 vagas = 1.780,25 candidatos por vaga
                                </td></tr>
                            <tr><td>Etapas do Concurso:
                                    Analista Judiciário – Área Judiciária: Prova Objetiva contemplando conhecimentos gerais e específicos / Prova subjetiva consistente numa redação.
                                    Técnico Judiciário – Área Administrativa: Prova Objetiva contemplando conhecimentos gerais e específicos
                                </td></tr>
                            <tr><td>Nota de corte Analista Judiciário – Área Judiciária: 6,24</td></tr>
                            <tr><td>Nota de corte Técnico Judiciário – Área Administrativa: 6,0</td></tr>
                            <tr><td>Total de classificados Analista Judiciário – Área Judiciária: 73</td></tr>
                            <tr><td>Total de classificados Técnico Judiciário – Área Administrativa: 828</td></tr>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-hover mb-none" style="font-size:1.6rem">
                        <tr style="background-color: #ddd !important;">
                            <th >Banca: CESPE - AP 2015</th>
                        </tr>
                        <tbody>
                            <tr><td>Data de publicação do Edital: 28/09/2015</td></tr>
                            <tr><td>Nº de vagas: Analista Judiciário – Área Judiciária: 2 + Cadastro reserva
                                    Técnico Judiciário – Área Administrativa: 5 + Cadastro reserva
                                    Demais cargos: Cadastro reserva
                                </td></tr>
                            <tr><td>Nº de inscritos: Analista Judiciário – Área Judiciária: 1.392 / 2 vagas = 696 candidatos por vaga
                                    Técnico Judiciário – Área Administrativa: 7.391/ 5 vagas = 1.478,2 candidatos por vaga
                                </td></tr>
                            <tr><td>Etapas do Concurso:
                                    Analista Judiciário – Área Judiciária: Prova Objetiva contemplando conhecimentos gerais e específicos / Prova subjetiva consistente numa redação.
                                    Técnico Judiciário – Área Administrativa: Prova Objetiva contemplando conhecimentos gerais e específicos
                                </td></tr>
                            <tr><td>Nota de corte Analista Judiciário – Área Judiciária: 6,08</td></tr>
                            <tr><td>Nota de corte Técnico Judiciário – Área Administrativa: 6,0</td></tr>
                            <tr><td>Total de classificados Analista Judiciário – Área Judiciária: 171</td></tr>
                            <tr><td>Total de classificados Técnico Judiciário – Área Administrativa: 930</td></tr>
                        </tbody>
                    </table>
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
