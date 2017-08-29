
<section id="exam-panel" class="panel" >

    <div class="container">
        <div class="row margin-bottom-40"><h1 style="color:black"><strong>| Análise 360º</strong>  {{ $titulo }}</h1>&nbsp;&nbsp;
        </div>

        <div class="row" >
            <div class="col-md-6">
                <div class="card" style="font-size: 1.55rem; height: 410px; padding: 40px;">
                    <img class="img-responsive"  src="/img/system/{{ $logo }}" class="pull-center">
                    <br>
                    A partir do Análise 360º,  nossa equipe especializada oferece um mapeamento minucioso da incidência dos temas mais recorrentes nas provas aplicadas em concursos e Exames da OAB, possibilitando aos candidatos e examinandos que otimizem seu tempo de estudo com o máximo de aproveitamento.
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
                                    <br>
                                    <h1 style="color: #4CB8C4"><i class="fa fa-file-text-o "></i> {{$provas}}</h1>
                                </div>

                                <div class="col-md-4">
                                    <h2 style="color: #444"><strong>| Peças</strong> analisadas</h2>
                                    <br>
                                    <h1 style="color: #4CB8C4"><i class="fa fa-object-ungroup"></i> {{$pecas}}</h1>
                                </div>


                                <div class="col-md-4">
                                    <h2 style="color: #444"><strong>| Questões</strong> analisadas</h2>
                                    <br>
                                    <h1 style="color: #4CB8C4"><i class="fa fa-list-ol"></i> {{ $questoes }}</h1>
                                </div>

                            </div>
                            <br>
                            <br>

                        </div>
                    </div>
                    {{--<div class="row" >--}}

                        {{--<div class="col-md-6">--}}
                            {{--<h2 style="color: #444"><strong>| {{ count( $pecasMaisFrequentes ) }} Temas</strong> mais frequentes</h2>--}}
                            {{--<div class="chart chart--dev">--}}
                                {{--<ul class="chart--horiz">--}}
                                    {{--@foreach ($temasMaisFrequentes as $temaMaisFrequente)--}}
                                        {{--<li class="chart__bar" style="width:{{ ($temaMaisFrequente[1] - $temasMaisFrequentesBaseInferior) / ($temasMaisFrequentesBaseSuperior - $temasMaisFrequentesBaseInferior) * 100  }}%;">--}}
                                        {{--</li>--}}
                                        {{--<p class="chart__label">--}}
                                            {{--{{ $temaMaisFrequente[0] }} - {{ $temaMaisFrequente[1]  }} QUESTÕES--}}
                                        {{--</p>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-6">--}}
                            {{--<h2 style="color: #444"><strong>| {{ count( $pecasMaisFrequentes ) }} Peças</strong> mais frequentes</h2>--}}
                            {{--<div class="chart chart--dev">--}}
                                {{--<ul class="chart--horiz">--}}
                                    {{--@foreach ($pecasMaisFrequentes as $pecaMaisFrequente)--}}
                                        {{--<li class="chart__bar" style="width:{{ ($pecaMaisFrequente[1] - $pecasMaisFrequentesBaseInferior) / ($pecasMaisFrequentesBaseSuperior - $pecasMaisFrequentesBaseInferior) * 100  }}%;">--}}
                                        {{--</li>--}}
                                        {{--<p class="chart__label">--}}
                                            {{--{{ $pecaMaisFrequente[0] }} - {{ $pecaMaisFrequente[1]  }} QUESTÕES--}}
                                        {{--</p>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-12">
                <div class="card" style="font-size: 1.7rem; padding: 40px;">
                    <h2 style="color: #444"><strong>| Análise</strong></h2>
                    <BR>
                    <p>A tabela abaixo indica quantas peças abordaram os tipos já contemplados, apontando o percentual de incidência de cada um deles:</p>
                    <br>
                    <table class="table table-hover mb-none" style="font-size:1.6rem">
                        <tr style="background-color: #ddd !important;">
                            <th width="7%">NÍVEL DE INCIDÊNCIA</th>
                            <th width="33%">TIPO DE PEÇA</th>
                            <th width="10%">EXAMES</th>
                            <th width="10%" class="text-right">QTD DE <BR>QUESTÕES</th>
                            <th width="30%"></th>
                            <th width="10%" class="text-right">%</th>
                        </tr>
                        <tbody>
                        {{--*/ $acumulado = 0; /*--}}
                        @foreach ($pecasIncidencias as $pecasIncidencia)
                            <tr>
                                <td width="10%">{{ $pecasIncidencia[0] }}º</td>
                                <td width="40%">{{ $pecasIncidencia[1] }}</td>
                                <td width="40%">{{ $pecasIncidencia[3] }}</td>
                                <td width="10%" class="text-right">{{ $pecasIncidencia[2] }}</td>
                                <td width="30%">
                                    <div class="progress" style="height:4px; margin-top: 10px">
                                        <span style="width: {{ $pecasIncidencia[2] / $pecas * 100 }}%;" class="progress-bar progress-bar-{{ $pecasIncidencia[4] }}"><span class="sr-only">{{ $pecasIncidencia[2] / $pecas * 100 }}% progress</span></span>
                                    </div>
                                </td><td width="10%" class="text-right"><span class="label label-{{ $pecasIncidencia[4] }}">{{ number_format( $pecasIncidencia[2] / $pecas * 100, 2, ',', '.') }}%</span></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td width="10%"></td>
                            <td width="40%"><b>TOTAL</b></td>
                            <td width="40%"></td>
                            <td width="10%" class="text-right"><b>{{ $pecas }}</b></td>
                            <td width="30%"></td>
                            <td width="10%" class="text-right"><b>100%</b></td>
                            <td width="30%"></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>

                    <BR>
                    <p>A tabela abaixo indica quantas peças abordaram os temas já contemplados, apontando o percentual de incidência de cada um deles:</p>
                    <br>
                    <table class="table table-hover mb-none" style="font-size:1.6rem">
                        <tr style="background-color: #ddd !important;">
                            <th width="7%">NÍVEL DE INCIDÊNCIA</th>
                            <th width="33%">TEMA</th>
                            <th width="10%">EXAMES</th>
                            <th width="10%" class="text-right">QTD DE <BR>PEÇAS</th>
                            <th width="30%"></th>
                            <th width="10%" class="text-right">%</th>
                        </tr>
                        <tbody>
                        {{--*/ $acumulado = 0; /*--}}
                        @foreach ($temasPecasIncidencias as $temasPecasIncidencia)
                            <tr>
                                <td width="10%">{{ $temasPecasIncidencia[0] }}º</td>
                                <td width="40%">{{ $temasPecasIncidencia[1] }}</td>
                                <td width="10%">{{ $temasPecasIncidencia[3] }}</td>
                                <td width="10%" class="text-right">{{ $temasPecasIncidencia[2] }}</td>
                                <td width="30%">
                                    <div class="progress" style="height:4px; margin-top: 10px">
                                        <span style="width: {{ $temasPecasIncidencia[2] / $pecas * 100 }}%;" class="progress-bar progress-bar-{{ $temasPecasIncidencia[4] }}"><span class="sr-only">{{ $temasPecasIncidencia[2] / $pecas * 100 }}% progress</span></span>
                                    </div>
                                </td><td width="10%" class="text-right"><span class="label label-{{ $temasPecasIncidencia[4] }}">{{ number_format( $temasPecasIncidencia[2] / $pecas * 100, 2, ',', '.') }}%</span></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td width="10%"></td>
                            <td width="40%"><b>TOTAL</b></td>
                            <td width="40%"></td>
                            <td width="10%" class="text-right"><b>{{ $pecas }}</b></td>
                            <td width="30%"></td>
                            <td width="10%" class="text-right"><b>100%</b></td>
                            <td width="30%"></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>

                    <BR>
                    <p>A tabela abaixo indica quantas questões abordaram os temas já contemplados, apontando o percentual de incidência de cada um deles:</p>
                    <br>
                    <table class="table table-hover mb-none" style="font-size:1.6rem">
                        <tr style="background-color: #ddd !important;">
                            <th width="7%">NÍVEL DE INCIDÊNCIA</th>
                            <th width="33%">TEMA</th>
                            <th width="10%">EXAMES</th>
                            <th width="10%" class="text-right">QTD DE <BR>QUESTÕES</th>
                            <th width="30%"></th>
                            <th width="10%" class="text-right">%</th>
                        </tr>
                        <tbody>
                        {{--*/ $acumulado = 0; /*--}}
                        @foreach ($temasQuestoesIncidencias as $temasQuestoesIncidencia)
                            <tr>
                                <td width="10%">{{ $temasQuestoesIncidencia[0] }}º</td>
                                <td width="30%">{{ $temasQuestoesIncidencia[1] }}</td>
                                <td width="10%">{{ $temasQuestoesIncidencia[3] }}</td>
                                <td width="10%" class="text-right">{{ $temasQuestoesIncidencia[2] }}</td>
                                <td width="30%">
                                    <div class="progress" style="height:4px; margin-top: 10px">
                                        <span style="width: {{ $temasQuestoesIncidencia[2] / $questoes * 100 }}%;" class="progress-bar progress-bar-{{ $temasQuestoesIncidencia[4] }}"><span class="sr-only">{{ $temasQuestoesIncidencia[2] / $pecas * 100 }}% progress</span></span>
                                    </div>
                                </td><td width="10%" class="text-right"><span class="label label-{{ $temasQuestoesIncidencia[4] }}">{{ number_format( $temasQuestoesIncidencia[2] / $questoes * 100, 2, ',', '.') }}%</span></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td width="10%"></td>
                            <td width="40%"><b>TOTAL</b></td>
                            <td width="40%"></td>
                            <td width="10%" class="text-right"><b>{{ $questoes }}</b></td>
                            <td width="30%"></td>
                            <td width="10%" class="text-right"><b>100%</b></td>
                            <td width="30%"></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>

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
