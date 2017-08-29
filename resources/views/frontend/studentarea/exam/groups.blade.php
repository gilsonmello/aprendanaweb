<div  @if($type == 'discipline') id="disciplines" @else id="groups" @endif>
    {{--<p style="padding:15px;">Você acertou <b>{{ $rights }}</b> de <b>{{ $total }}</b>, um total de <b>{{ floor(($rights * 100) / $total) }}%</b> de acerto. </p>--}}
    {{--<p> Você concluiu o exame em {{$time}}</p>--}}

<div class="table-responsive" @if($type == 'discipline') id="discipline-group-table-info" @else id="exam-group-table-info" @endif>
                                    <table class="table mb-none">
                                    <thead>
                                    @if( $level != null && $level == 1 && $type == 'discipline')
                                      <th width="50%">Disciplina </th>
                                    @else
                                        <th id="theme-title" width="50%">Tema </th>
                                    @endif
                                        <th class="text-right" colspan="2">Performance</th>
                                        <th class="text-right" colspan="2">Esperado</th>

                                        <th class="text-right">Questões</th>
                                        <th class="text-right">Acertos</th>
                                        <th class="text-right">Erros</th>

                                        @if($previous_group_results != null && !$previous_group_results->isEmpty())
                                            <th class="text-right" colspan="2"><b>% Anterior</b></th>
                                            <th class="text-right"><b></b></th>
                                        @endif
                                    </thead>                                        
                                    <tbody>
                                    @foreach($group_results as $group => $results)
        <tr class="theme-line" data-group-id="{{ $results["object"] != null ? $results["object"]->id : 0  }}" data-expected="{{ $expected }}" data-percentual="{{$percentual = floor(($results['rights'] * 100) / $results['total'])}}" data-previous="{{$previous_group_results != null && isset($previous_group_results[$group]) ? $previous = floor(($previous_group_results[$group]['rights'] * 100) / $previous_group_results[$group]['total']) : "empty" }}">
            <td>


                @if($percentual < $expected)
                    <i class="fa fa-thumbs-down" style="color:red"></i>
                @else
                    <i class="fa fa-thumbs-up" style="color:green"></i>
                @endif
                    &nbsp;
                    @if( $level != null && $level == 1 && $type == 'group')
                        <strong> {{ ($results['object'] != null && $results['object']->parent != null) ? '[' . $results['object']->parent->name . ']' : "" }}</strong>
                    @endif

                    {{ $group }}
                <div class="misplaced-warning" style="font-size: 0.9em; display: none">

                    Clique aqui e reforce seus conhecimentos na vídeo-aula
                </div>
            </td>
            <td class="text-right" ><canvas class="mini-right-chart" width="30" height="30"  ></canvas></td>
            <td class="text-left" width="30px" style="vertical-align: middle" >{{ $percentual }}%</td>
            <td class="text-right"><canvas class="mini-expected-chart" width="30" height="30"  ></canvas> </td>
            <td class="text-left" width="30px" style="vertical-align: middle"  >{{ round($expected,0) }}%</td>
            <td class="text-right" style="vertical-align: middle" >
                {{ $results['total']  }}
            </td>
            <td class="text-right font-green-jungle" style="vertical-align: middle" >
                <i class="fa fa-check font-green-jungle"></i>  {{ $results['rights'] }}
            </td>
            <td class="text-right font-red-flamingo" style="vertical-align: middle" >
                <i class="fa fa-times font-red-flamingo"></i>  {{   $results['total']  - $results['rights'] }}
            </td>
            @if($previous_group_results != null && !$previous_group_results->isEmpty() && isset($previous_group_results[$group]))
                <td class="text-right">
                    <canvas class="mini-previous-chart" width="20" height="20"  ></canvas>
                </td>
                <td class="text-left" width="30px" style="vertical-align: middle" > {{ $previous }}%</td>

                <td class="text-right" style="vertical-align: middle" >
                    @if(($percentage = $percentual - $previous) > 0)
                        <i class="fa fa-arrow-up" style="color: green"></i>
                    @elseif($percentage < 0)
                        <i class="fa fa-arrow-down" style="color: red"></i>
                    @else
                        <i class="fa fa-minus" style="color: black"></i>
                    @endif
                </td>

            @elseif($previous_group_results != null)
                <td class="text-right">&nbsp;</td>
                <td class="text-left" width="30px" style="vertical-align: middle">&nbsp;</td>
                <td class="text-right" style="vertical-align: middle"></td>
            @endif
        </tr>
        <tr style="display: none"><td></td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>



</div>