

<div class="modal-dialog" role="document" style="width: 80%">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="groupSubjectLabel" style="color: #08C">Associar temas a aula {{ $lesson->sequence }}</h4>
            <h4 class="modal-title" id="savedGroupLabel" style="color: #08C; display:none"> Grupo atualizado! </h4>
        </div>
        <div class="modal-body">

            <form id="group-form">

                <input type="hidden" value="{{ $lesson->id }}" name="lesson-id"/>
                <input type="hidden" value="{{ $group->id }}" name="group-id"/>
                <div class="row">
                    <div class="col-md-12 ">
                        <label for="group-name">Nome do Grupo</label>
                        <input name="group-name" id="group-name" value="{{ $group->title }}" type="text"/>
                    </div>
                </div>

                <br/>

                <div class="row">
                    <div class="col-md-5">
                        <h5 style="font-weight: bold">Tema</h5>
                    </div>
                    <div class="col-md-3">
                        <h5 style="font-weight: bold">Banca</h5>
                    </div>
                    <div class="col-md-2">
                        <h5 style="font-weight: bold">Nº de Questões</h5>
                    </div>
                </div>

                @foreach($group->subjects as $subject)

                    <div class="row subject-question-row">
                        <div class="form-group" >
                            <div class="form-input col-md-5">
                                {!! Form::select('subjects[]', $group->subjects->lists('name', 'id')->all(), $subject->id, ['class' => 'form-control subject-select', 'placeholder' => trans('strings.subject') ])  !!}
                            </div>
                            <div class="form-input col-md-3">
                                {!! Form::select('sources[]', ["" => "Todas"] + $sources->lists('name', 'id')->all(), $subject->pivot->source_id, ['class' => 'form-control', 'placeholder' => trans('strings.source') ])  !!}
                            </div>
                            <div class="form-input col-md-2">
                                {!! Form::input('text','question_count[]',$subject->pivot->questions_count,['class' => 'form-control', 'placeholder' => trans('strings.questions_count')])   !!}
                            </div>
                            <div class="col-md-1">
                                <i class="delete-relation fa fa-times" style="color:red; cursor: pointer"></i>
                            </div>
                        </div>
                    </div>

                @endforeach


                <div class="row subject-question-row">
                    <div class="form-group subject-relation">
                        <div class="form-input col-md-5">
                            {!! Form::select('subjects[]', ["" => ""] + $group->subjects->lists('name', 'id')->all(), null, ['class' => 'form-control  subject-select', 'placeholder' => trans('strings.subject') ])  !!}
                        </div>
                        <div class="form-input col-md-3">
                            {!! Form::select('sources[]', ["" => "Todas"] + $sources->lists('name', 'id')->all(), null, ['class' => 'form-control', 'placeholder' => trans('strings.source') ])  !!}
                        </div>

                        <div class="form-input col-md-2">
                            {!! Form::input('text','question_count[]',0,['class' => 'form-control', 'placeholder' => trans('strings.questions_count')])   !!}
                        </div>
                        <div class="col-md-1">
                            <i class="delete-relation fa fa-times" style="color:red; cursor: pointer"></i>
                        </div>
                    </div>
                </div>


                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <span id="add-subject" style="cursor:pointer;color: blue">Adicionar um novo tema...</span>
                    </div>
                </div>


                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-success" id="save-relation">Salvar</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
