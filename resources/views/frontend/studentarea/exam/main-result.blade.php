    <div class="card">
            <div class="row" style="border-bottom: 1px solid lightgrey; min-height:48px">

                <div class="col-md-8">
                    <span style="font-size:1.2em"><strong> Resultados do SAAP: {{ $execution->enrollment->exam != null ? $execution->enrollment->exam->title : $execution->enrollment->course->title }}</strong></span>
                </div>
                <div class="col-md-4" style="padding-top: 3px;">
                    <div class="actions text-right">
                        @if(($attempt =  get_attempted($execution->enrollment)) > 0)

                            <div class="btn-group btn-group-divided text-right" data-toggle="buttons">
                                <label class="btn btn-default grey-cascade btn-outline current-attempt btn-sm"
                                       data-attempt-time="{{ $attempt_time = $duration }}"
                                       data-attempt-date="{{ $attempt_date =  format_datebr($execution->finished_at)}}"
                                       data-attempt-grade="{{  $current_grade = floor($execution->grade) != null ? floor($execution->grade) : get_partial_rights($execution) }}"
                                       data-total-questions="{{ $answered_questions = ($attempt_date != null ? $count : $execution->questions_executions->reject(function($item){return $item->grade === null;})->count())  }}"

                                        >
                                    <input name="options" class="toggle " id="option1"
                                           type="radio">RESULTADO {{ $attempt }}
                                </label>
                            </div>
                    </div>
                    @endif
                </div>
            </div>
            <div id="last-exam-results" data-questions-count="{{ $count }}" class="row mt-lg mb-lg" >
                <div class="col-md-4 text-center">
                                 <span class="title mt-lg" >
                                    <strong> <div id="result-date">@if($execution->finished == 1) Em {{ $attempt_date }} @else Pendente Conclusão @endif</div></strong>
                                    <br/>
                                </span>
                    <div class=" current-graph" style="padding: 0px;" width="100" height="100">
                        <canvas id="attempt-canvas" data-total-questions={{ $answered_questions }} data-attempt="{{ $current_grade }}" class="current-graph" width="150" height="150"  style="width: 150px; height: 150px; " ></canvas>
                    </div>
                    <div>
                        <br/>
                        <h5>
                            <i class="fa fa-check font-green-jungle"></i><span id="attempt-right" class="font-green-jungle">&nbsp;{{ floor($current_grade) }} ACERTOS</span>
                            &nbsp;
                            <i class="fa fa-close font-red-flamingo"></i><span id="attempt-wrong" class="font-red-flamingo">&nbsp;{{ $answered_questions - $current_grade }} ERROS</span>
                        </h5>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                                <span class="title mt-lg">
                                   <div> <strong>Mínimo Esperado</strong></div>
                                    <br/>
                                </span>
                    <div class=" target-graph" style="padding: 0px;" width="100" height="100">
                        <canvas id="target-canvas" data-target="{{ floor($minimum_percentage) }}" class="target-graph" width="150" height="150"  style="width: 150px; height: 150px; " ></canvas>
                    </div>
                    <div>
                        <br/>
                        <h5>
                            <i class="fa fa-check font-green-jungle"></i><span class="font-green-jungle">&nbsp;{{ $target_right=  $count * (floor($minimum_percentage) / 100) }} ACERTOS</span>
                            &nbsp;
                            <i class="fa fa-close font-red-flamingo"></i><span class="font-red-flamingo">&nbsp;{{ $count - $target_right }} ERROS</span>
                        </h5>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                               <span class="title mt-lg" >
                                  <div><strong>Demais alunos</strong></div>
                                   <br/>
                               </span>
                    <div class=" enemy-graph" style="padding: 0px;" width="100" height="100">
                        <canvas id="enemy-canvas" data-enemy="{{ $enemy_grade = round($execution->course != null ? $execution->course->average_exam_grade : $execution->enrollment->exam->average_grade,2) }}"  class="enemy-graph" width="150" height="150"  style="width: 150px; height: 150px; " ></canvas>
                    </div>
                    <div>
                        <br/>
                        <h5>
                            <i class="fa fa-check font-green-jungle"></i><span class="font-green-jungle">&nbsp;{{ number_format( $enemy_grade, 1,',','.') }} ACERTOS</span>
                            &nbsp;
                            <i class="fa fa-close font-red-flamingo"></i><span class="font-red-flamingo">&nbsp;{{ number_format( $count - $enemy_grade, 1, ',','.' ) }} ERROS</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
