
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="groupCourseSubjectLabel" style="color: #08C">Associar temas ao curso </h4>
            <h4 class="modal-title" id="savedCourseGroupLabel" style="color: #08C; display:none"> Grupo atualizado! </h4>
        </div>
        <div class="modal-body">

            <form id="group-course-form">


                <input type="hidden" value="{{ $course->id }}" name="course-id"/>
                <input type="hidden" value="{{ $group->id }}" name="course-group-id"/>
                <div class="row">
                    <div class="col-md-12 ">
                        <label for="course-group-name">Nome do Grupo</label>
                        <input name="course-group-name" id="course-group-name" value="{{ $group->title }}" type="text"/>
                    </div>
                </div>

                <br/>

                <div class="row">
                    <div class="col-md-7">
                        <h5 style="font-weight: bold">Tema</h5>
                    </div>
                    <div class="col-md-3">
                        <h5 style="font-weight: bold">Nº de Questões</h5>
                    </div>
                </div>

                @foreach($group->subjects as $subject)

                    <div class="row subject-course-question-row">
                        <div class="form-group" >
                            <div class="form-input col-md-7">
                                {!! Form::select('subjects-course[]', $group->subjects->lists('name', 'id')->all(), $subject->id, ['class' => 'form-control  subject-course-select', 'placeholder' => trans('strings.subject') ])  !!}
                            </div>
                            <div class="form-input col-md-3">
                                {!! Form::input('text','course_question_count[]',$subject->pivot->questions_count,['class' => 'form-control', 'placeholder' => trans('strings.questions_count')])   !!}
                            </div>
                            <div class="col-md-1">
                                <i class="delete-course-relation fa fa-times" style="color:red; cursor: pointer"></i>
                            </div>
                        </div>
                    </div>

                @endforeach


                <div class="row subject-course-question-row">



                    <div class="form-group subject-relation">
                        <div class="form-input col-md-7">
                            {!! Form::select('subjects-course[]', [], null, ['class' => 'form-control subject-course-select', 'placeholder' => trans('strings.subject') ])  !!}
                        </div>
                        <div class="form-input col-md-3">
                            {!! Form::input('text','course_question_count[]',0,['class' => 'form-control', 'placeholder' => trans('strings.questions_count')])   !!}
                        </div>
                        <div class="col-md-1">
                            <i class="delete-course-relation fa fa-times" style="color:red; cursor: pointer"></i>
                        </div>
                    </div>


                </div>


                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <span id="add-course-subject" style="cursor:pointer;color: blue">Adicionar um novo tema...</span>
                    </div>
                </div>


                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-success" id="save-course-relation">Salvar</a>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
