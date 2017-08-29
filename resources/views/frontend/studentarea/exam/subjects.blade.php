<div id="subjects">
    {{--<p style="padding:15px;">Você acertou <b>{{ $rights }}</b> de <b>{{ $total }}</b>, um total de <b>{{ floor(($rights * 100) / $total) }}%</b> de acerto. </p>--}}
    {{--<p> Você concluiu o exame em {{$time}}</p>--}}

<div class="table-responsive" id="exam-table-info">
                                    <table class="table mb-none table-hover">
                                    <thead>
                                        <th width="50%">@if($next == null) Clique no subtema e saiba como aprimorar seu desempenho @else Subtema @endif </th>
                                        <th class="text-right">Questões</th>
                                        <th class="text-right">Acertos</th>
                                        <th class="text-center"><nobr>% Acerto</nobr></th>
                                        @if($previous_rights != 0)
                                            <th class="text-right"><nobr><b>% Anterior</b></nobr></th>
                                            <th class="text-right"><b></b></th>
                                        @endif
                                    </thead>                                        
                                    <tbody>
                                    @foreach($subjects as $subject => $results)
        <tr class="subject-line" data-subject-id="{{ $results['id'] }}"
            style="cursor: pointer;

            @if(($percentual = floor(($results['rights'] * 100) / $results['total'])) < 50)
                    background-color: #ffe4dd;
                    @elseif($percentual < 75)
                    background-color: #fffdb1;
                    @else
                    background-color: #d7ffd5;
                    @endif
            ">
            <td>
              <strong> {{ $results['object']->parent != null ? '[' . $results['object']->parent->name . ']' : "" }}</strong>  {{ $subject }}
            </td>
            <td class="text-right">
                {{ $results['total']  }}
            </td>
            <td class="text-right">
                {{ $results['rights'] }}
            </td>
            <td class="text-right">{{ $percentual }}%</td>
            @if($previous_rights != 0)
                <td class="text-right">
                    {{ floor(($previous_subjects[$subject]['rights'] * 100) / $previous_subjects[$subject]['total']) }}%
                </td>
                <td class="text-right">
                    @if(($percentage = floor(($results['rights'] * 100) / $results['total']) - floor(($previous_subjects[$subject]['rights'] * 100) / $previous_subjects[$subject]['total'])) > 0)
                    <i class="fa fa-arrow-up" style="color: green"></i>
                    @elseif($percentage < 0)
                        <i class="fa fa-arrow-down" style="color: red"></i>
                    @else
                        <i class="fa fa-minus" style="color: black"></i>
                    @endif
                </td>
            @endif
        </tr>
        <tr style="display: none"><td></td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>



  
    @if($next != null)

        <div id="next" data-next="{{ $next->id }}"></div>

    @else

        <div class="box-body" style="width:100% !important; height:40% !important;">
            <div>
                <canvas id="performance-graph" style="max-height: 300px;" ></canvas>
            </div>
        </div><!-- /.box-body -->
    @endif


    <div class="modal fade" id="suggestionModal" tabindex="-1" role="dialog" aria-labelledby="suggestionModalLabel"></div>


</div>