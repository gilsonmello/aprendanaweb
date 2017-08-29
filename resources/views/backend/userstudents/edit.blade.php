@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.edit_user'))

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
        <small>{{ trans('menus.edit_user') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.users.edit', trans('menus.edit_user')) !!}</li>
@stop



@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.userstudents.edit', $userstudent->id)}}" class="btn btn-primary btn-xs">{{ trans('menus.edit_userstudents') }}</a>
        <a href="{{route('admin.userstudents.enrollments', $userstudent->id)}}" class="btn btn-primary btn-xs">{{ trans('menus.courses') }}</a>
        <a href="{{route('admin.userstudents.exams', $userstudent->id)}}" class="btn btn-primary btn-xs">{{ trans('menus.exams') }}</a>
        <a href="{{route('admin.userstudents.orders', $userstudent->id)}}" class="btn btn-primary btn-xs">{{ trans('menus.orders') }}</a>
    </div>
    <br/>
    <br/>

    {!! Form::model($userstudent, ['route' => ['admin.userstudents.update', $userstudent->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.full_name')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('gender', trans('strings.gender'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('gender', 'M', true) !!}  {!! trans('strings.male') !!}&nbsp;&nbsp;{!! Form::radio('gender', 'F') !!} {!! trans('strings.female') !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('cel', trans('strings.cel'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('cel', null, ['class' => 'form-control cel', 'placeholder' => trans('strings.cel')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('birthdate', trans('strings.birthdate'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('birthdate', null, ['class' => 'form-control birthdate', 'placeholder' => trans('strings.birthdate')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('personal_id', trans('strings.personal_id'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('personal_id', null, ['class' => 'form-control personal_id', 'placeholder' => trans('strings.personal_id')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('professional_number', trans('strings.professional_number'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('professional_number', null, ['class' => 'form-control', 'placeholder' => trans('strings.professional_number')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('zip', trans('strings.zip'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('zip', null, ['class' => 'form-control zip', 'placeholder' => trans('strings.zip'), 'onblur' => 'javascript:findAddressBrazil($("#zip"), $("#address"));']) !!}
        </div>
    </div><!--form control-->

    {!! Form::hidden('city_id', $city->id, ['id' => 'city_id']) !!}

    <div class="form-group">
        {!! Form::label('city', trans('strings.city'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('city', $city->name, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.city')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('state', trans('strings.state'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('state', $state->short, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.state')]) !!}
        </div>
    </div><!--form control-->



    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('strings.is_newsletter_subscriber') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="is_newsletter_subscriber" class="toggleBtn onoffswitch-checkbox" id="is_newsletter_subscriber-active" {{$userstudent->is_newsletter_subscriber == 1 ? "checked='checked'" : ''}}>
                    <label for="is_newsletter_subscriber-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->

    <div class="form-group">
            <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
            <div class="col-lg-1">
                <div class="sw-green create-permissions-switch">
                    <div class="onoffswitch">
                        <input type="checkbox" value="1" name="status" class="toggleBtn onoffswitch-checkbox" id="user-active" {{$userstudent->status == 1 ? "checked='checked'" : ''}}>
                        <label for="user-active" class="onoffswitch-label">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div><!--green checkbox-->
            </div>
        </div><!--form control-->

        <div class="form-group">
            <label class="col-lg-2 control-label">{{ trans('validation.attributes.confirmed') }}</label>
            <div class="col-lg-1">
                <div class="sw-green confirmation-switch">
                    <div class="onoffswitch">
                        <input type="checkbox" value="1" name="confirmed" class="toggleBtn onoffswitch-checkbox" id="confirm-active" {{$userstudent->confirmed == 1 ? "checked='checked'" : ''}}>
                        <label for="confirm-active" class="onoffswitch-label">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div><!--green checkbox-->
            </div>
        </div><!--form control-->


        <div class="pull-left">
            <a href="{{route('admin.userstudents.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}

@stop

