


@if ($question != null)
    <div class="row">
        <div class="col-md-6">
            <div id="panel-question" class="panel-question" style="background-color: #fff; padding: 20px;">
                @include('frontend.studentarea.exam.explanation-tabs')
                <div class="" id="exam-note-info" style="padding: 10px; display: none;">
                </div>
                <div id="explanation-question" style="padding: 10px;">
                    <table>
                        <tr>
                            <td colspan="12">
                                {!! $question->text  !!}
                                <br/>
                            </td>
                            <br/>
                        </tr>
                        @if($letter = ord('a'))@endif
                        @foreach($question->answers as $answer)
                            <tr>


                                <td colspan="12"  @if($answer->is_right) style="background-color: #d7ffd5"@endif >
                                    <div class="radio-custom radio-warning">
                                            <span @if($answer->is_right) style="background-color: #d7ffd5"@endif>
                                                  <b>{!! chr($letter) !!}) </b>{!!  $answer->choice !!}
                                            </span>
                                        <br/>
                                    </div>
                                </td>
                            </tr>
                            @if($letter++)@endif
                        @endforeach
                        <tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="panel-comment" class="panel-question" style="background-color: #fff; padding: 20px;">

                @if ($showvideo == true)
                    @if($question->teacher != null)
                        <div id="explanation-teacher">
                            <strong>Professor(a) {{ $question->teacher->name }}</strong>
                        </div>
                    @endif
                    <iframe width="100%" id="explanation-box" height="400" src="{{ $question->explanation_url }}" frameborder="0" allowfullscreen>&nbsp;</iframe>

                    @if (($question->explanation_text != null) && ( $question->explanation_text != ''))
                    <div id="explanation-text"> {!!  $question->explanation_text  !!}</div><br><br>
                    @endif
                @else
                    <div id="explanation-text"><span style="color: red">Você atingiu o número máximo de visualizações para este comentário.</span></div>
                    <br/>
                @endif

                <strong>Anotações</strong>
                {!! Form::hidden('question_id', $question->id, ['id' => 'question_id']  ) !!}
                <br/>
                {!! Form::textarea('questionnote', $notetext, ['id' => 'questionnote', 'rows' => 8, 'style' => 'width:100%;'] ) !!}
                <br/>
                {!! Form::button( trans('strings.save_button') , ['class' => 'btn btn-primary no-border-radius button-note']) !!}
            </div>
            <br/>
        </div>
    </div>
@else
    <div id="explanation-text">Você atingiu o número máximo de visualizações para este comentário.</div>
    <br/>
@endif
