<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="disciplineModalLabel" style="color: #08C"><span id="disciplineStatisticModalTitle" class="discipline-name"></span></h4>
        </div>
        <div class="modal-body">

                <div id="discipline-subjects" class="tab-pane " style="margin:0px 0px 30px;padding:0;" data-discipline="0" >

                        <table class="table mb-none">
                            <thead>
                            <th width="50%">Tema</th>
                            <th class="text-right detail-column">Performance</th>
                            <th class="text-right detail-column">Questões</th>
                            <th class="text-right detail-column">Acertos</th>
                            <th class="text-right"><nobr>% Acerto</nobr></th>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)

                                <tr class="subject-line" data-percentual="{{$percentual  = ($subject->rights / $subject->questions) * 100}}" >
                                    <td>
                                        {{ $subject->subject }}
                                    </td>
                                    <td class="text-right" ><canvas class="mini-subject-right-chart" width="30" height="30"  ></canvas></td>
                                    <td class="text-right detail-column" >
                                        {{ $subject->questions }}
                                    </td>
                                    <td class="text-right detail-column">
                                        {{ round($subject->rights,0) }}
                                    </td>
                                    <td class="text-right">
                                        @if ($percentual < 50)
                                            <span style="color: red">
                                        @elseif ($percentual < 75)
                                                    <span style="color: #cdac56">
                                        @else
                                                            <span style="color: green">
                                        @endif
                                                                {{ number_format( $percentual, 2, ',', '.' ) }}
                                     </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>

        </div>
    </div>
</div>