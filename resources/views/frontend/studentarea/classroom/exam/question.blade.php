<div class="row">
    <div class="col-md-12">
        <h4 class="modal-title" id="revisionLabel" style="color: #08C">Questão<strong id="count-now"> {{ $question_exec->order }}</strong> de <strong id="count-max">{{ $count }}</strong>
            <div class="progress" style="height: 7px; margin-top: 7px" >
                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                     aria-valuemin="0" aria-valuemax="100" style="width:{{ ($question_exec->order * 100) /  $count }}%; height: 20px">
                    <span class="sr-only">1/3</span>
                </div>
            </div>
        </h4>
    </div>
</div>





<div class="exam-explanation" >
    <div class="pull-left col-md-8 no-padding question-attributes">
        @if ( ($question_exec->question->subject != null) && ($question_exec->question->subject->parent != null) )


            <strong>Tema:</strong> {{ $question_exec->question->subject->parent->name }}<br/>

        @endif
            @if ($question_exec->question->original === 1)
                <strong>INÉDITA</strong> /
            @elseif ($question_exec->question->original === 2)
                <strong>{{ $question_exec->question->source->name }}</strong> /
            @else
                <strong>ADAPTADA</strong> /
            @endif
            @if ($question_exec->question->year != null)
                <strong>{{ $question_exec->question->year }}</strong> /
            @endif
            @if ($question_exec->question->institution != null)
                <strong>{{ $question_exec->question->institution->name }}</strong> /
            @endif
            @if ($question_exec->question->office != null)
                <strong>{{ $question_exec->question->office->name }}</strong>  /
            @endif
            @if ($question_exec->question->subject != null)
                {{ $question_exec->question->subject->name }}
            @endif

    </div>
    <!-- {{$question = $question_exec->question}} -->

    @include('frontend.studentarea.exam.explanation-tabs')


    <div class="col-md-4 pull-right text-right no-padding" id="toolsDiv">

        <div class="btn-group" role="group" aria-label="..."><label class="fontesMarcadores">Fontes <br>
                <button type="button" class="increase_font  btn btn-default" data-toggle="tooltip" title="Aumentar fonte" href="#" id="increaseFontBt"><strong>A+</strong></button>
                <button type="button" class="reduce_font btn btn-default" data-toggle="tooltip" title="Reduzir fonte" href="#" id="reduceFontBt"><strong>A-</strong></button></label>
        </div>

    </div>



</div>


<div id="panel-question" class="panel-question">
    <div class="" id="exam-table-info" style="display:none; padding: 10px; color: black !important"></div>
    <div id="question" style="padding: 10px;" data-question-id="{{ $question_exec->question->id  }}" data-question-exec="{{ $question_exec->id }}" data-question-answered="{{ $question_exec->grade === null ? 0 : 1 }}">

        <div id="options" data-type="{{ $question_exec->question->answer_type }}">

            <table class="table mb-none">
                <tbody>
                <tr>
                    <td>
                        <strong>{!! $question_exec->order !!})</strong>
                        {!! strip_tags ($question_exec->question->text, '<br><a>') !!}
                    </td>
                </tr>
                @if($letter = ord('a'))@endif
                @foreach($question_exec->question->answers as $answer)
                    <tr >
                        <td class="class-exam-td" @if($question_exec->grade !== null &&
                                        $question_exec->execution->simulation_mode == 0 &&
                                         $answer->is_right)
                             style="background-color: palegreen"
                                @endif>
                            <div class="radio-custom radio-warning question_div" id="question_div_{{ $answer->id }}">
                                <input type="radio" value="{{$answer->id}}" id="checkbox{{ $answer->id }}" name="resposta"
                                       @if($question_exec->grade !== null &&
                                       $question_exec->answersExecution->answers_chosen == $answer->id) checked
                                       @endif
                                       @if($question_exec->grade !== null &&
                                        $question_exec->execution->simulation_mode == 0)
                                       disabled
                                        @endif
                                        >
                                <label for="checkbox{{ $answer->id }}"><span id="{{ $answer->id }}" class="answer classroom-answer"
                                                                             @if($question_exec->grade !== null &&
                                        $question_exec->execution->simulation_mode == 0 && $question_exec->answersExecution->answers_chosen != $answer->id)
                                                                             style="color: lightgrey"
                                                                             @endif

                                                                             data-right="{{ ($answer->id * $question_exec->id) + $answer->is_right }}"><b>{!! chr($letter) !!}) </b>{!!  $answer->choice !!}</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    @if($letter++)@endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

{{--<!-- Modal de anotações -->--}}
{{--<div class="modal fade pull-center" id="modalNote" tabindex="-1" role="dialog">--}}
{{--<div class="modal-dialog" role="document">--}}
{{--<div class="modal-content">--}}
{{--<div class="modal-header">--}}
{{--<strong>Anotações</strong>--}}
{{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
{{--</div>--}}
{{--<div class="modal-body">--}}
{{--{!! Form::hidden('question_id', $question_exec->question_id, ['id' => 'question_id']  ) !!}--}}
{{--<br/>--}}
{{--{!! Form::textarea('questionnote', ($questionnote !=  null ? $questionnote->note : ""), ['id' => 'questionnote', 'rows' => 8, 'style' => 'width:100%;'] ) !!}--}}
{{--<br/>--}}
{{--{!! Form::button( trans('strings.save_button') , ['class' => 'btn btn-primary button-note']) !!}--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}



{{--<div class="modal fade" id="askTheTeacherContentModal" tabindex="-1" role="dialog" >--}}
{{--<div class="modal-dialog  modal-lg" role="document">--}}
{{--<div class="modal-content">--}}
{{--<div class="modal-header">--}}
{{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
{{--<h4 class="modal-title" id="askTheTeacherContentLabel"></h4>--}}
{{--</div>--}}
{{--<div id="questionContentWait" style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div>--}}
{{--<div id="questionContentDiv" style="padding: 20px; font-size: 1.5rem;">--}}
{{--{!! Form::hidden('askTheTeacher_question_id', $question_exec->question_id, ['id' => 'askTheTeacher_question_id']  ) !!}--}}
{{--<br/>--}}
{{--{!! Form::textarea('questionAskTheTeacher', '', ['id' => 'questionAskTheTeacher', 'rows' => 8, 'style' => 'width:100%;'] ) !!}--}}
{{--<br/>--}}
{{--{!! Form::button( trans('strings.send') , ['class' => 'btn btn-primary button-askTheTeacher']) !!}--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}