@extends ('backend.layouts.master')

@section ('title', trans('menus.courses'))



@section('page-header')
    <h1>
        {{ trans('menus.courses') }}
        <small>{{ trans('menus.all_courses') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.courses.index', trans('menus.courses')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.courses.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_course') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.courses.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_CourseController_title',  trans('strings.title'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_CourseController_title', $coursecontrollertitle, ['class' => 'form-control']  ) !!}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('validation.attributes.featured') }}</label>
                        <div class="col-lg-1">
                            <div class="sw-green create-permissions-switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" value="1" name="f_CourseController_featured" class="toggleBtn onoffswitch-checkbox" id="course-active" @if($coursecontrollerfeatured == 1)checked="checked"@endif>
                                    <label for="course-featured" class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div><!--green checkbox-->
                        </div>

                        <label class="col-lg-2 control-label">{{ trans('validation.attributes.special_offer') }}</label>
                        <div class="col-lg-1">
                            <div class="sw-green create-permissions-switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" value="1" name="f_CourseController_special_offer" class="toggleBtn onoffswitch-checkbox" id="course-special_offer" @if($coursecontrollerspecialoffer == 1)checked="checked"@endif>
                                    <label for="course-special_offer" class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div><!--green checkbox-->
                        </div>

                        <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
                        <div class="col-lg-1">
                            <div class="sw-green create-permissions-switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" value="1" name="f_CourseController_is_active" class="toggleBtn onoffswitch-checkbox" id="course-active" @if($coursecontrollerisactive == 1)checked="checked"@endif>
                                    <label for="course-active" class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div><!--green checkbox-->
                        </div>
                        <label class="col-lg-2 control-label">{{ trans('strings.validation') }}</label>
                        <div class="col-lg-1">
                            <div class="sw-green create-permissions-switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" value="1" name="f_CourseController_validation" class="toggleBtn onoffswitch-checkbox" id="course-validation" >
                                    <label for="course-validation" class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div><!--green checkbox-->
                        </div>

                    </div><!--form control-->
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>    

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.courses.title') }}</th>
            <th class="text-right" >{{ trans('crud.courses.price') }}</th>
            <th class="text-right" >{{ trans('crud.courses.average_grade') }}</th>
            <th class="text-right" >{{ trans('crud.courses.orders_count') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($courses as $course)
            <tr>
                <td>{!! $course->title !!}</td>
                <td class="text-right" >{!! number_format($course->price, 2, ',', '.' ) !!}</td>
                <td class="text-right" >{!! number_format($course->average_grade, 2, ',', '.' )  !!}</td>
                <td class="text-right" >{!!  number_format($course->orders_count, 0, ',', '.' )   !!}</td>
                <td>{!! $course->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $courses->total() !!} {{ trans('crud.courses.total') }}
    </div>

    <div class="pull-right">
        {!! $courses->render() !!}
    </div>

    <div class="clearfix"></div>
@stop