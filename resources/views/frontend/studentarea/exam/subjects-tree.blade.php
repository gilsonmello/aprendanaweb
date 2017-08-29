<div @if($type == 'discipline') id="groups" @else id="subjects" @endif >
    {{--<p style="padding:15px;">Você acertou <b>{{ $rights }}</b> de <b>{{ $total }}</b>, um total de <b>{{ floor(($rights * 100) / $total) }}%</b> de acerto. </p>--}}
    {{--<p> Você concluiu o exame em {{$time}}</p>--}}






    <div class="btn-group btn-exam btn-group-justified" data-toggle="buttons">
        <label class="btn btn-filter active all">
            <input name="filter" id="all" value="good"  type="checkbox">Todos
        </label>
        <label class="btn btn-filter good">
            <input name="filter" id="good" value="good"  type="checkbox"><i class="fa fa-thumbs-up" style="color:green"></i> Fui bem
        </label>
        <label class="btn  btn-filter bad">
            <input name="filter" id="bad" value="bad" type="checkbox"> <i class="fa fa-thumbs-down" style="color:red"></i> Fui mal
        </label>
        <label class="btn btn-filter detail">
            <input name="detail-filter" id="detail" value="detail" type="checkbox"><i class="fa fa-square-o toggle-active"></i> Mais detalhes
        </label>
    </div>


    <div  id="exam-table-info">

        <table class="table mb-none table-hover">
            <thead>
            <th width="50%">@if($type == 'discipline') Tema @else Subtema @endif </th>
            <th class="text-right detail-column">Questões</th>
            <th class="text-right detail-column">Acertos</th>
            <th class="text-right"><nobr>% Acerto</nobr></th>
            @if($previous_rights != 0)
                <th class="text-right detail-column" ><nobr><b>% Anterior</b></nobr></th>
                <th class="text-right detail-column" ><b></b></th>
            @endif
            </thead>
            <tbody>
            @foreach($subjects as $subject => $results)
                <tr class="subject-line" data-subject-id="{{ $results['id'] }}"
                    style="
            background-color: #f0f6ff;
            @if(($percentual = floor(($results['rights'] * 100) / $results['total'])) < 50)

                    @elseif($percentual < 75)

                    @else

                    @endif
                            ">
                    <td>
                        {{ $subject }}
                    </td>
                    <td class="text-right detail-column" >

                    </td>
                    <td class="text-right detail-column">

                    </td>
                    <td class="text-right"></td>
                    @if($previous_rights != 0)
                        <td class="text-right detail-column">

                        </td>
                        <td class="text-right detail-column">

                        </td>
                    @endif
                </tr>
                <tr style="display: none"><td></td>
                </tr>


                @foreach($results["sons"]->sortBy(function($item,$key){
            return ($item['rights'] * 100) / $item['total'];
        }) as $subject_son => $results_son)


                    @if(($percentual = floor(($results_son['rights'] * 100) / $results_son['total'])) < 60) 
                    {{-- Refatorar --}}
                    <tr class="subject-line bad-line" data-subject-id="{{ $results_son['id'] }}"
                        style="


                                ">

                            <td style="padding-left:40px;" class="bad-grade">

                                <i class="fa fa-thumbs-down" data-toggle="tooltip" title="Você pode melhorar!" style="color:red"></i>
                        @else
                        <tr class="subject-line good-line" data-subject-id="{{ $results_son['id'] }}"
                            style="


                                ">

                            <td style="padding-left:40px;" class="good-grade">
                                <i class="fa fa-thumbs-up" data-toggle="tooltip" title="Você está indo bem!"  style="color:green"></i>

                                @endif
                                &nbsp;
                                {{ $subject_son }}
                            </td>
                            <td class="text-right detail-column">
                                {{ $results_son['total']  }}
                            </td>
                            <td class="text-right detail-column">
                                {{ $results_son['rights'] }}
                            </td>
                            <td class="text-right">{{ $percentual }}%</td>
                            @if($previous_rights != 0 && isset($previous_subjects[$subject]) && isset($previous_subjects[$subject]["sons"][$subject_son]))
                                <td class="text-right detail-column">
                                    {{ floor(($previous_subjects[$subject]["sons"][$subject_son]['rights'] * 100) / $previous_subjects[$subject]["sons"][$subject_son]['total']) }}%
                                </td>
                                <td class="text-right detail-column">
                                    @if(($percentage = floor(($results_son['rights'] * 100) / $results_son['total']) - floor(($previous_subjects[$subject]["sons"][$subject_son]['rights'] * 100) / $previous_subjects[$subject]["sons"][$subject_son]['total'])) > 0)
                                        <i class="fa fa-arrow-up" style="color: green"></i>
                                    @elseif($percentage < 0)
                                        <i class="fa fa-arrow-down" style="color: red"></i>
                                    @else
                                        <i class="fa fa-minus" style="color: black"></i>
                                    @endif
                                </td>
                                @elseif($previous_rights != 0)
                                <td class="text-right detail-column"> &nbsp; </td>
                                <td class="text-right detail-column"><i>&nbsp; </i> </td>
                            @endif
                    </tr>
                @endforeach

            @endforeach
            </tbody>
        </table>
    </div>




    @if($next != null)

        <div id="next" data-next="{{ $next->id }}"></div>

    @else

    @endif


    <div class="modal fade" id="suggestionModal" tabindex="-1" role="dialog" aria-labelledby="suggestionModalLabel"></div>


</div>