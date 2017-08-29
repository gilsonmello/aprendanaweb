

<div id="course-teachers" class="tab-pane">
 <!--   <table id="teachers-table" class="table table-bordered table-hover dataTable" role="grid">
        <thead>
        <tr role="row">
            <th aria-label="Nome" aria-sort="ascending"  aria-controls="name" tabindex="0" class="sorting_asc">Name</th>
            <th aria-label="Percentual"  aria-controls="sequence" tabindex="0" class="sorting">Percentage</th>
            <th aria-label="Excluir"  aria-controls="delete" tabindex="0" class="sorting">Delete</th>
        </tr>
        </thead>





    </table> -->

    <div id="course-teachers-fields" class="box box-primary">
        {!! Form::open(['route' => 'admin.courses.updateteachers', 'id' => 'update-course-teacher-form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
            
            <!-- Texto de observação para utilizar o totalizador automático -->
            <div class="form-group form-course-teachers" style="margin:20px 0;">
                <label class="col-lg-10 control-label" style="text-align: left;">
                    Para utilizar o totalizador automático, verifique se todas as aulas estão com as associações de professores e percentuais corretos em cada aula, na aba de Professores de (Número da aula).
                </label>
            </div>
            <!-- Fim do texto de observação para utilizar o totalizador automático -->

        @if($course->teachers->isEmpty())
            <div class="form-group form-course-teachers" style="margin:20px 0;">

                {!! Form::label('name' , trans('validation.attributes.teacher'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="form-input col-md-5">
                    {!! Form::select('course-teacher-name-1' , [""=>""]  + App\User::teachers()->get()->sortBy('name')->lists('name','id')->all(), [],['class' => 'form-control course-teachers-select']) !!}
                </div>
                <div class="form-input col-sm-1">
                    {!! Form::text('course-teacher-percentage-1' , 100, ['class' => 'form-control course-teacher-percentage', 'placeholder' => trans('strings.percentage')]) !!}
                </div>
                <div class="col-sm-1 text-left">
                    %
                </div>
                <div class="col-sm-2 pull-left">
                    <i class="remove-course-teacher fa fa-times" style="color:red;cursor:pointer;"></i>
                </div>

            </div>
        @else
            @foreach($course->teachers as $relation)
                <div class="form-group form-course-teachers" style="
                margin:20px 0;">
                    {!! Form::label('name' , trans('validation.attributes.teacher'), ['class' => 'col-lg-2 control-label']) !!}
                    <div class="form-input col-md-5">

                        {!! Form::select('course-teacher-name-1' , App\User::teachers()->get()->sortBy('name')->lists('name','id')->all(),$relation->teacher->id . '', ['class' => 'form-control course-teachers-select ']) !!}
                    </div>
                    <div class="form-input col-sm-1">
                        {!! Form::text('course-teacher-percentage-1' , number_format($relation->percentage, 2, ',', '.'), ['class' => 'form-control course-teacher-percentage', 'placeholder' => trans('strings.percentage')]) !!}
                    </div>
                    <div class="col-sm-1 text-left">
                        %
                    </div>
                    <div class="col-sm-2 pull-left">
                        <i class="remove-course-teacher fa fa-times" style="color:red; cursor:pointer;"></i>
                    </div>
                </div>
            @endforeach
        @endif


        <div class="box-footer">
         <div class="form-group form-add pull-left ">
            <a href="#" class="btn btn-primary add-course-teacher" style="margin-left:20px;"><i class="fa fa-plus-square"></i> {{trans('strings.add_teacher') }}</a>
             &nbsp;&nbsp;
             <a href="#" id="calculate-percentage-teacher" class="btn btn-primary calculate-percentage-teacher" style="margin-left:20px;">{{trans('strings.totalize-teacher') }}</a>
         </div>
        <div class="pull-right">
            <input id="save-course-teachers" name="save-course-teachers" type="button" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>
        </div>
       

        {!! Form::close() !!}
    </div>


        
        <div class="clearfix"></div>
    </div>

