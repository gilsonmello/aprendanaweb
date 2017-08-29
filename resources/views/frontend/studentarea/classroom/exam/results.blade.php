<div id="panel-summary" data-execution="{{ $execution->id }}" class="panel-summary">
    <div class="" id="exam-table-info"   style="display:none; padding: 10px;"></div>

    @if($marked_answer = null)@endif
    <div class="container" style="width: 100%">

        <div class="row">
            <div class="col-md-9">
              <h3 style="color: #075890">
                  <i>Você acertou </i>

                  <canvas style="vertical-align: -28px" id="class-exam-percentage" data-expected="{{ $execution->lesson->module->course->minimum_percentage }}" data-rights="{{ $execution->grade }}" data-total="{{ $execution->questions_executions->count() }}"></canvas>

                  <i> das questões</i>
              </h3>
            </div>
            <div class="col-md-3 text-right">
               <h3 style="color:#075890"> {{ number_format($execution->grade,0)  }} de {{ $execution->questions_executions->count() }} </h3>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">

                @if(($execution->grade * 100) / $execution->questions_executions->count() >= $execution->lesson->module->course->minimum_percentage )
                <h3 style="color: #4f8f4f; border-bottom: 1px solid rgb(193, 193, 193); padding: 15px">
                    Parabéns, você atingiu a performance esperada para essa aula ( {{$execution->lesson->module->course->minimum_percentage}}% ).
                </h3>
                @else
                 <h3 style="color: #9f3e39;  border-bottom: 1px solid rgb(193, 193, 193); padding: 15px">
                     Sua performance foi abaixo do esperado ( {{$execution->lesson->module->course->minimum_percentage}}% ). Recomendamos assistir novamente as vídeo aulas sobre o(s) tema(s) abordados(s).
                 </h3>
                @endif
            </div>
        </div>


        @foreach($execution->questions_executions->reject(function($item){ return $item->grade === null;}) as $questionSummary)
            @if($marked_answer = null)@endif
            <div class='row' style="border-bottom: 1px #c1c1c1 solid; padding: 20px">

                <div class="col-md-12">
                    <div class="row">
                    {!! $questionSummary->question->text  !!}
                        </div>

                    @if($letter = ord('a'))@endif
                    @foreach($questionSummary->question->answers as $answer)
                        <div class="row"
                            @if($answer->is_right) style="background-color: #d7ffd5"
                            @if($right_answer = chr($letter))@endif
                            @elseif($answer->id == $questionSummary->answersExecution->answers_chosen)
                                @if($marked_answer = chr($letter))@endif
                                style="background-color: #ffe4dd"
                            @endif >
                            <div class="radio-custom radio-warning">


                                @if($answer->is_right)
                                    <span class="classroom-span" style="border-left: 0 !important; background-color: #d7ffd5">
                                                @elseif($answer->id == $questionSummary->answersExecution->answers_chosen)
                                            @if($marked_answer = chr($letter))@endif
                                                    <span class="classroom-span" style="border-left: 0 !important; background-color: #ffe4dd">
                                                @else
                                                    <span class="classroom-span" style="border-left: 0 !important;  color: #847d86;">
                                                @endif
                                                        <b>{!! chr($letter) !!}) </b>{!!  $answer->choice !!}
                                                </span>
                            </div>




                        </div>
                        @if($letter++)@endif
                    @endforeach


                    <br/>
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
                            @endif
                        </div>
                        <div class="col-md-3">
                             <button class="btn blue-steel btn-block modal-explanation" data-question="{{ $questionSummary->question->id }}" data-enrollment="{{ $execution->enrollment_id }}" style="cursor: pointer; font-size: 1.0em; height: 40px;"><i class="fa fa-play-circle-o"></i> Comentário</button>
                        </div>
                        <div class="col-md-4 text-center question-percentage" data-question-percentage="{{ $questionSummary->question->percentageRight() }}">
                            <strong>{{ number_format($questionSummary->question->percentageRight(), 0, ',', '.')   }}%</strong> {{ ($questionSummary->question->percentageRight() != 0 ? 'acertaram' : 'acertou') }} esta questão.
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="explanation-text">{{ $questionSummary->question->explanation_text }}</div>
                            <div style="cursor:pointer" class="explanation-point"></div>
                        </div>
                    </div>
                </div>


            </div>
            <br/>
        @endforeach
    </div>



</div>

