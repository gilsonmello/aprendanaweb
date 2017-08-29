@extends ('backend.layouts.master')

@section ('title', trans('menus.partnerorder_management') . ' | ' . trans('menus.create_partnerorder'))

@section('page-header')
    <h1>
        {{ trans('menus.partnerorder_management') }}
        <small>{{ trans('menus.create_partnerorder') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.partnerorders.index', trans('menus.partnerorder')) !!}</li>
    <li class="active">{!! link_to_route('admin.partnerorders.create', trans('menus.create_partnerorder')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.partnerorders.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        {!! Form::label('partner_id', trans('strings.partner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('partner_id', $partners->lists("name","id"), null, ['class' => 'form-control']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('course_id', trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('course_id', $courses->lists("title","id"), null, ['class' => 'form-control']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('total_enrollments', trans('strings.total_enrollments'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('total_enrollments', null, ['class' => 'form-control', 'placeholder' => trans('strings.total_enrollments')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('date', trans('strings.date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date', null, ['class' => 'form-control datepicker', 'placeholder' => trans('strings.date')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('value', trans('strings.value'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('value', null , ['class' => 'form-control money', 'placeholder' => trans('strings.value')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('external_course_id', trans('crud.partnerorders.external_course_id'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('external_course_id', null, ['class' => 'form-control', 'placeholder' => trans('crud.partnerorders.external_course_id')]) !!}
        </div>

    </div><!--form control-->
    <div class="form-group">
        {!! Form::label('html_email', trans('crud.partnerorders.html_email'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="box-body" style="padding: 0px;">
                {!! Form::textarea('html_email', null, ['class' => 'form-control', 'placeholder' => trans('strings.html_email')]) !!}
            </div>
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('html_subscribe', trans('crud.partnerorders.html_subscribe'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="box-body" style="padding: 0px;">
                {!! Form::textarea('html_subscribe', null, ['class' => 'form-control', 'placeholder' => trans('strings.html_subscribe')]) !!}
            </div>
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="partnerorder-active" checked="checked">
                    <label for="partnerorder-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->



    <div class="pull-left">
            <a href="{{route('admin.partnerorders.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop