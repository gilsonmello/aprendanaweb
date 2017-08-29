
<div class="row explanation-tabs" style=" padding: 0px; display: none; margin-left: 0px; margin-right: 0px; ">
    <div class="btn-group btn-group-justified" role="group" >
        <div class="btn-group" role="group" aria-label="...">
            <button class="btn btn-primary active tab-button tab-question" id="btnTabQuestion"  style="height: 60px;" onclick="javascript: clickQuestionButton();"><strong><i class="fa fa-pencil-square-o"></i> Questão</strong></button>
        </div>
        @if (($question->note1 != null ) || ($question->note1 != '' ))
            <div class="btn-group" role="group" aria-label="...">

                <button class="btn btn-primary tab-button" data-note="{{ $question->note1 }}"  style="height: 60px;" onclick="javascript: clickNoteButton();"><strong><i class="fa fa-book"></i> Jurisprudência<br>Correlata</strong></button>
            </div>
        @endif

        @if (($question->note2 != null ) || ($question->note2 != '' ))
            <div class="btn-group" role="group" aria-label="..." >

                <button class="btn btn-primary  tab-button" data-note="{{ $question->note2 }}"  style="height: 60px;" onclick="javascript: clickNoteButton();"><strong><i class="fa fa-book"></i> Legislação<br>Correlata</strong></button>
            </div>
        @endif

        @if (($question->note3 != null ) || ($question->note3 != '' ))
            <div class="btn-group" role="group" aria-label="..." >

                <button class="btn btn-primary tab-button" data-note="{{ $question->note3 }}"  style="height: 60px;" onclick="javascript: clickNoteButton();"><strong><i class="fa fa-book"></i> Informativos</strong></button>
            </div>
        @endif

        @if (($question->note4 != null ) || ($question->note4 != '' ))
            <div class="btn-group" role="group" aria-label="..." >

                <button class="btn btn-primary tab-button" data-note="{{ $question->note4 }}"  style="height: 60px;" onclick="javascript: clickNoteButton();"><strong><i class="fa fa-book"></i> Doutrinas</strong></button>
            </div>
        @endif

        @if (!empty($question->explanation_text != ''))
            <div class="btn-group" role="group" aria-label="...">
                <button class="btn btn-primary tab-button" data-note="{{ $question->explanation_text }}"  style="height: 60px;" onclick="javascript: clickNoteButton();"><strong><i class="fa fa-book"></i> Comentários</strong></button>
            </div>
        @endif

    </div>
</div>

