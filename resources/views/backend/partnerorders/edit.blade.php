
@extends ('backend.layouts.master')

@section ('title', trans('menus.partnerorder_management') . ' | ' . trans('menus.edit_partnerorder'))

@section('page-header')
    <h1>
        {{ trans('menus.partnerorders') }}
        <small>{{ trans('menus.edit_partnerorder') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.partnerorders.index', trans('menus.partnerorders')) !!}</li>
    <li class="active">{!! link_to_route('admin.partnerorders.create', trans('menus.edit_partnerorder')) !!}</li>
@stop

@section('content')
    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.partnerorderpayments.index')}}?f_partnerorder_id={{$partnerorder->id}}" class="btn btn-primary btn-xs">{{ trans('menus.partnerorder_payments') }}</a>
    </div>
    <br/>
    <br/>

    {!! Form::model($partnerorder, ['route' => ['admin.partnerorders.update', $partnerorder->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('partner_id', trans('strings.partner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('partner_id', $partnerorder->partner->name, ['class' => 'form-control','disabled']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('course_id', trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('course_id', $partnerorder->course->title, ['class' => 'form-control','disabled']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('total_enrollments', trans('strings.total_enrollments'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('total_enrollments', null, ['class' => 'form-control', 'placeholder' => trans('strings.total_enrollments'),'disabled']) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('date', trans('strings.date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date', format_datebr( $partnerorder->date), ['class' => 'form-control', 'placeholder' => trans('strings.date'),'disabled']) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('value', trans('validation.attributes.price'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('value', number_format($partnerorder->value, 2, ',', '.' ) , ['class' => 'form-control money', 'placeholder' => trans('strings.price')]) !!}
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
                    <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="partnerorder-active" @if($partnerorder->is_active == 1)checked="checked"@endif>
                    <label for="partnerorder-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->    

    <div class="pull-left">
            <a href="{{route('admin.partnerorders.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop