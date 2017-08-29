<div id="question-summary" >


    <div class="btn-group btn-exam btn-group-justified" data-toggle="buttons">
        <label class="btn btn-filter active all-button">
            <input name="filter" id="check" value="check"  type="checkbox"> Todos
        </label>
        <label class="btn btn-filter check-button">
            <input name="filter" id="check" value="check"  type="checkbox"> <i class="fa fa-check" style="color:green"></i> Meus Acertos
        </label>
        <label class="btn btn-filter fail-button">
            <input name="filter" id="fail" value="fail" type="checkbox">  <i class="fa fa-times" style="color:red"></i> Meus Erros
        </label>
    </div>



    <div class="table-responsive">
        <table class="table mb-none table-hover">
            <thead>
            <th class="text-left" style="width: 5%"></th>
            <th class="text-left" style="width: 15%">Questão</th>
            <th class="text-left" style="width: 15%">Tempo</th>
            @if ($execution->enrollment->exam != null && $execution->enrollment->exam->result_level == 1)
                <th class="text-left">[Disciplina] Tema / Subtema</th>
            @else
                <th class="text-left">Tema / Subtema</th>
            @endif


            </thead>
            <tbody>
            @foreach($execution->questions_executions->reject(function($item){ return $item->grade === null;}) as $questionSummary)

                @if($questionSummary->grade == 1)
                    <tr class="summary-line check-line" style="cursor: pointer;">
                @else
                    <tr class="summary-line fail-line" style="cursor: pointer;">
                        @endif

                        <td class="text-left">@if($questionSummary->grade == 1)<i class="fa fa-check" style="font-size: 16pt ;color:#47a447"></i>@else<i class="fa fa-times" style="font-size: 16pt; color:#d2322d"></i>@endif</td>

                        <td class="text-left">{{ $questionSummary->order }}</td>
                        <td class="text-left">{{ parse_sec_to_time( parse_time_to_sec($questionSummary->time)) }}</td>
                        @if ($execution->enrollment->exam != null && $execution->enrollment->exam->result_level == 1)
                            <td class="text-left"><b>{{ ($questionSummary->question->subject->parent->parent != null ? "[" . $questionSummary->question->subject->parent->parent->name . "]" : "") }}</b> {{ $questionSummary->question->subject->parent->name }} / {{ $questionSummary->question->subject->name }}</td>
                        @else
                            <td class="text-left">{{ $questionSummary->question->subject->parent->name }} / {{ $questionSummary->question->subject->name }}</td>
                        @endif

                    </tr>
                    <tr class="collapse out summary-detail">
                        <td colspan="12" style="padding: 30px; padding-top: 10px;">
                            <table width="100%">
                                <tr>
                                    <td colspan="12">
                                        <div>{!! $questionSummary->question->text  !!}</div>
                                        <br/>
                                    </td>
                                    <br/>
                                </tr>
                                @if($letter = ord('a'))@endif
                                @if($marked_answer = null)@endif
                                @foreach($questionSummary->question->answers as $answer)
                                    <tr>
                                        <td colspan="12"
                                            @if($answer->is_right) style="background-color: #d7ffd5"
                                            @if($right_answer = chr($letter))@endif
                                            @elseif($answer->id == $questionSummary->answersExecution->answers_chosen)
                                            @if($marked_answer = chr($letter))@endif
                                            style="background-color: #ffe4dd"
                                                @endif >
                                            <div class="radio-custom radio-warning">


                                                @if($answer->is_right)
                                                    <span>
                                                @elseif($answer->id == $questionSummary->answersExecution->answers_chosen)
                                                    @if($marked_answer = chr($letter))@endif
                                                    <span>
                                                @else
                                                    <span style="color: #847d86;">
                                                @endif
                                                <b>{!! chr($letter) !!}) </b>{!!  $answer->choice !!}
                                                </span><br/>
                                            </div>
                                        </td>
                                    </tr>
                                    @if($letter++)@endif
                                @endforeach
                                <tr >
                                    <td colspan="12" style="font-size: 2rem; ">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <i class="fa fa-check font-green-jungle" ></i>
                                                    </div>
                                                    <div class="col-md-9     text-left">
                                                        Resposta Correta&nbsp;&nbsp;<strong> {{ strtoupper($right_answer) }} </strong>
                                                    </div>
                                                </div>
                                                @if($marked_answer != null)
                                                    <div class="row">
                                                    <div class="col-md-1">
                                                        <i class="fa fa-close font-red-flamingo" ></i>
                                                    </div>
                                                    <div class="col-md-9 text-left">
                                                        Você respondeu&nbsp;&nbsp;<strong>{{ strtoupper($marked_answer) }} </strong>
                                                    </div>
                                                    </div>
                                                @elseif ($questionSummary->time == "00:00")
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <i class="fa fa-close font-red-flamingo" ></i>
                                                        </div>
                                                        <div class="col-md-10 text-left">
                                                            Você não respondeu em <strong>tempo hábil </strong>
                                                        </div>
                                                    </div>
                                                @else
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn blue-steel btn-block modal-explanation" data-question="{{ $questionSummary->question->id }}" data-enrollment="{{ $execution->enrollment_id }}" style="cursor: pointer; font-size: 1.0em; height: 40px;"><i class="fa fa-play-circle-o"></i> Comentário</button>
                                            </div>
                                            <div class="col-md-4 text-center question-percentage" data-question-percentage="{{ $questionSummary->question->percentageRight() }}">
                                                <strong>{{ number_format($questionSummary->question->percentageRight(), 0, ',', '.')   }}%</strong> {{ ($questionSummary->question->percentageRight() != 0 ? 'acertaram' : 'acertou') }} esta questão.
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td >
                    </tr>

                    @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade explanationModal" id="explanationModal" tabindex="-1" role="dialog" aria-labelledby="explanationModalLabel">
        <div class="modal-dialog" role="document"  style="width: 80%">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="explanationModalLabel" style="color: #08C">Comentário</h4>
                </div>
                <div id="explanationContentWait" style='padding: 20px; display: none; background-color: #EFF3F8;'><img src='/img/system/wait.gif' border='0'></div>
                <div id="explanationContentDiv" style="padding: 20px; background-color: #EFF3F8;"></div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade questionContentModal" id="questionContentModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="questionContentLabel"></h4>
            </div>
            <div id="questionContentWait" style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div>
            <div id="questionContentDiv"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="askTheTeacherContentModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="askTheTeacherContentLabel"></h4>
            </div>
            <div id="questionContentWait" style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div>
            <div id="questionContentDiv" style="padding: 20px; font-size: 1.5rem;">
                {!! Form::hidden('askTheTeacher_question_id', null, ['id' => 'askTheTeacher_question_id']  ) !!}
                <br/>
                {!! Form::textarea('questionAskTheTeacher', '', ['id' => 'questionAskTheTeacher', 'rows' => 8, 'style' => 'width:100%;'] ) !!}
                <br/>
                {!! Form::button( trans('strings.send') , ['class' => 'btn btn-primary button-askTheTeacher']) !!}
            </div>
        </div>
    </div>
</div>