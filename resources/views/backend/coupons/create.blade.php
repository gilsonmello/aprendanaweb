@extends ('backend.layouts.master')

@section ('title', trans('menus.coupon_management') . ' | ' . trans('menus.create_coupon'))

@section('page-header')
    <h1>
        {{ trans('menus.coupon_management') }}
        <small>{{ trans('menus.create_coupon') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.coupons.index', trans('menus.coupons')) !!}</li>
    <li class="active">{!! link_to_route('admin.coupons.create', trans('menus.create_coupon')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.coupons.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.coupon_name').'*', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('code', trans('validation.attributes.code').'*', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-7">
                {!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => trans('strings.code')]) !!}
            </div>
            <div class="col-lg-3">
                <input type ='button' id="random_code" class="btn btn-primary pull-right" value="{{ trans('strings.code_button') }}"/>
            </div>
        </div><!--form group-->

        <div class="form-group">
            {!! Form::label('start_date', trans('validation.attributes.start_date').'*', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('start_date', null, ['class' => 'form-control datemask datepicker', 'placeholder' => trans('strings.start_date')]) !!}
            </div>
        </div><!--form group-->

        <div class="form-group">
            {!! Form::label('due_date', trans('validation.attributes.due_date').'*', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('due_date', null, ['class' => 'form-control datemask datepicker', 'placeholder' => trans('strings.due_date')]) !!}
            </div>
        </div><!--form group-->

        <div class="form-group">
            <label name="limit" class="col-lg-2 control-label">
                {!! trans('validation.attributes.limit').'*' !!}
                <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{!! trans('validation.attributes.question_limit') !!}">
                </i>
            </label>
            <div class="col-lg-10">
                {!! Form::text('limit', null, ['class' => 'form-control', 'placeholder' => trans('strings.limit')]) !!}
            </div>
        </div><!--form group-->

        <div class="form-group">
            {!! Form::label('used', trans('validation.attributes.used'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('used', null, ['class' => 'form-control', 'placeholder' => trans('strings.used'),'disabled']) !!}
            </div>
        </div><!--form group-->

        <div class="form-group">
            {!! Form::label('percentage', trans('validation.attributes.percentage').'**', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('percentage', null, ['class' => 'form-control', 'placeholder' => trans('strings.percentage')]) !!}
            </div>
        </div><!--form group-->

        <div class="form-group">
            {!! Form::label('value', trans('validation.attributes.value').'**', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('value', null, ['class' => 'form-control money', 'placeholder' => trans('strings.value')]) !!}
            </div>
        </div><!--form group-->

        <div class="form-group">
            {!! Form::label('students', trans('validation.attributes.students'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('students[]', [], [], ['class' => 'form-control students-select', 'multiple' => 'multiple']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('courses', trans('validation.attributes.courses'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('courses[]', [], [], ['class' => 'form-control courses-select', 'multiple' => 'multiple']) !!}
            </div>
        </div><!--form group-->
    
        <div class="form-group">
            {!! Form::label('description', trans('validation.attributes.description').'*', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="box-body" style="padding: 0px;">
                    {!! Form::textarea('description', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.description')]) !!}
                </div>
            </div>
        </div><!--form group-->

    <div class="pull-left">
            <a href="{{route('admin.coupons.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
    </div>

    <div class="pull-right">
        <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
    </div>
    <div class="clearfix"></div>

      {!! Form::close() !!}
@stop