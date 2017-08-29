    {!! Form::open( ['route' => ['admin.courses.updateteachers'], 'id' => 'teacher-form','class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}


<div id="teachers" class="tab-pane">
 <!--   <table id="teachers-table" class="table table-bordered table-hover dataTable" role="grid">
        <thead>
        <tr role="row">
            <th aria-label="Nome" aria-sort="ascending"  aria-controls="name" tabindex="0" class="sorting_asc">Name</th>
            <th aria-label="Percentual"  aria-controls="sequence" tabindex="0" class="sorting">Percentage</th>
            <th aria-label="Excluir"  aria-controls="delete" tabindex="0" class="sorting">Delete</th>
        </tr>
        </thead>





    </table> -->

    <div id="teachers-fields" class="box box-primary">
        {!! Form::open(['route' => 'admin.courses.updateteachers', 'id' => 'update-teacher-form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}


        @if(!$relations->first())
            <div class="form-group form-teachers" style="margin:20px 0;">

                {!! Form::label('name' , trans('validation.attributes.teacher'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="form-input col-md-4">
                    {!! Form::select('teacher-name-1' , [], [],['class' => 'form-control teachers-select', 'placeholder' => trans('strings.name'), 'style' => 'width: 100%']) !!}
                </div>
                <div class="form-input col-sm-3">
                    {!! Form::text('teacher-percentage-1' , 100, ['class' => 'form-control teacher-percentage', 'placeholder' => trans('strings.percentage')]) !!}
                </div>
                <div class="col-sm-1 text-left">%</div>
                <div class="col-sm-2">
                    <i class="fa fa-times remove-lesson-teacher" style="color:red; cursor:pointer"></i>
                </div>

            </div>
        @else
            @foreach($relations as $relation)
                <div class="form-group form-teachers" style="margin:20px 0;">

                    {!! Form::label('name' , trans('validation.attributes.teacher'), ['class' => 'col-lg-2 control-label']) !!}
                    <div class="form-input col-md-4">
                        {!! Form::select('teacher-name-1' , $relation->lists('name','id'),$relation->id, ['class' => 'form-control teachers-select ', 'placeholder' => trans('strings.name'),'style' => 'width: 100%']) !!}
                    </div>
                    <div class="form-input col-sm-3">
                        {!! Form::text('teacher-percentage-1' , $relation->pivot->percentage, ['class' => 'form-control teacher-percentage', 'placeholder' => trans('strings.percentage')]) !!}
                    </div>
                    <div class="col-sm-1 text-left">%</div>
                    <div class="col-sm-2">
                        <i class="fa fa-times remove-lesson-teacher" style="color:red; cursor: pointer"></i>
                    </div>
                </div>
            @endforeach
        @endif


        <div class="box-footer">
         <div class="form-group form-add pull-left ">
            <a href="#" class="btn btn-primary add-teacher" style="margin-left:20px;"><i class="fa fa-plus-square"></i> {{trans('strings.add_teacher') }}</a>
        </div>
            <div class="pull-left ">
                <a href="#" class="btn btn-primary equal-divide" style="margin-left:20px;"><i class="fa fa-percent"></i> {{trans('strings.divide_equally') }}</a>
            </div>
        <div class="pull-right">
            <input id="save-teachers" name="save-teachers" type="button" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>
        </div>
       

        {!! Form::close() !!}
    </div>


        
        <div class="clearfix"></div>
    </div>

    {!! Form::close() !!}