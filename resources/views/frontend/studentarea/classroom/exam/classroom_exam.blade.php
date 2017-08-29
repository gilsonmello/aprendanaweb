
<div class="modal-dialog" role="document" style="width:85%">
    <div class="modal-content">
        <div id="exam-modal-header" class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php $origin = app('session')->get('origin');?>
            <h4 class="modal-title" id="revisionLabel" style="color: #08C">
                @if(!is_null($origin) || $enrollment->course_id === 566)
                    AVALIAÇÃO EXCLUSIVA DE PERFORMANCE
                @elseif($enrollment->course->custom_exam_title != null)
                    {{ $enrollment->course->custom_exam_title }}
                @else
                    SAAP da aula
                @endif
            </h4>
        </div>

        <!-- Lembrar de retirar a condição de 1 == 1 quando for usar a validação de número de blocos -->
        @if(!is_array($lessons->where('id',$content->lesson->id)->first()->viewed) || (count_viewed($lessons->where('id',$content->lesson->id)->first()->viewed) > count($lessons->where('id',$content->lesson->id)->first()->viewed) * 0.7) || 1 == 1)
            <div class="modal-body" style="width:100%">
                <div id="classroom-modal-main-container" class="container" style="padding-left:0px; width: 100% !important">
                </div>
            </div>
        @else
            <div class="modal-body" style="width:80%">
                <div id="not-available-container" class="container" style="padding-left:0px;">
                    @if($enrollment->course->custom_exam_title != null )
                        <span>{{ $enrollment->course->custom_exam_title }} - Você ainda precisa concluir mais blocos para acessar.</span>
                        @else
                    <span>É preciso concluir mais blocos para conseguir acessar o SAAP dessa aula.</span>
                        @endif
                </div>
            </div>
        @endif
    </div>
</div>




<div class="modal fade" id="questionContentModal" tabindex="2" role="dialog" style="overflow-y: auto">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="questionContentLabel"></h4>
            </div>
            <div id="questionContentWait" style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div>
            <div id="questionContentDiv" style="padding: 20px; font-size: 1.5rem;">
            </div>
        </div>
    </div>
</div>


<div class="modal fade explanationModal" id="explanationModal" tabindex="-1" role="dialog" aria-labelledby="explanationModalLabel">
    <div class="modal-dialog" role="document"  style="width: 80%">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="explanationModalLabel" style="color: #08C">Comentário</h4>
            </div>
            <div id="explanationContentWait" style='padding: 20px; display: none; background-color: #EFF3F8;'><img src='/img/system/wait.gif' border='0'></div>
            <div id="explanationContentDiv" style="padding: 20px; background-color: #EFF3F8;"></div>
        </div>
    </div>
</div>
