
<div id="course-questions" class="tab-pane">
    <div id="course-questions-fields" class="box box-primary" style="padding: 10px">
        <div class="container">
            <form id="group-course-form" data-saved="{{ isset($group) ? "true" : "false" }}">


                <input type="hidden" value="{{ $course->id }}" name="course-id"/>
                <div class="row">
                    <div class="col-md-3" >
                        <label for="course-group-name">Nome do Grupo (Opcional)&nbsp;</label>
                    </div>
                    <div class="col-md-6">
                        <input name="course-group-name"  style="width: 100%" id="course-group-name" @if(isset($group))value="{{ $group->title }}" @endif type="text"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3" >
                        <label for="course-group-duration">Duração em Minutos&nbsp;</label>
                    </div>
                    <div class="col-md-6">
                        <input name="course-group-duration" style="width: 100%" id="course-group-duration" @if(isset($group))value="{{ $course->exam_duration }}" @endif type="text"/>
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

                @if(isset($group))
                    <input type="hidden" value="{{ $group->id }}" name="course-group-id"/>

                @foreach($group->subjects as $subject)

                    <div class="row subject-course-question-row">
                        <div class="form-group" >
                            <div class="form-input col-md-7">
                                {!! Form::select('subjects-course[]', $group->subjects->lists('name', 'id')->all(), $subject->id, ['class' => 'form-control  subject-course-select', 'placeholder' => trans('strings.subject') ])  !!}
                            </div>
                            <div class="form-input col-md-3">
                                {!! Form::input('text','question_count[]',$subject->pivot->questions_count,['class' => 'form-control', 'placeholder' => trans('strings.questions_count')])   !!}
                            </div>
                            <div class="col-md-1">
                                <i class="delete-course-relation fa fa-times" style="color:red; cursor: pointer"></i>
                            </div>
                        </div>
                    </div>

                @endforeach
@endif

                <div class="row subject-course-question-row">



                    <div class="form-group subject-relation">
                        <div class="form-input col-md-7">
                            {!! Form::select('subjects-course[]', [], null, ['class' => 'form-control subject-course-select', 'placeholder' => trans('strings.subject') ])  !!}
                        </div>
                        <div class="form-input col-md-3">
                            {!! Form::input('text','question_count[]',0,['class' => 'form-control', 'placeholder' => trans('strings.questions_count')])   !!}
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
                        <a class="btn btn-success" id="save-course-relation" data-target="{{ $course->id }}">Salvar</a>
                    </div>
                </div>
            </form>

</div>
        </div>
    </div>
</div>
