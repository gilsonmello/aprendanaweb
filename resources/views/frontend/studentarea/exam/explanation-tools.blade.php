


<strong>Anotações</strong>
{!! Form::hidden('question_id', $question->id, ['id' => 'question_id']  ) !!}
<br/>
{!! Form::textarea('questionnote', $notetext, ['id' => 'questionnote', 'rows' => 8, 'style' => 'width:100%;'] ) !!}
<br/>
{!! Form::button( trans('strings.save_button') , ['class' => 'btn btn-primary no-border-radius button-note']) !!}
