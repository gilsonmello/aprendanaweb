@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section('page-header')
    <h1>
        {{ trans('menus.sectors') }}
        <small>{{ trans('menus.edit_sector') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.sectors.index', trans('menus.sectors')) !!}</li>
    <li class="active">{!! link_to_route('admin.sectors.create', trans('menus.edit_sector')) !!}</li>
@stop

@section('content')

    {!! Form::model($sector, ['route' => ['admin.sectors.update', $sector->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.name')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('admins', trans('strings.admins'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('admins[]', $admins->lists('name', 'id'), $sector->users->lists('id')->all(), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
            </div><!-- /.col -->
        </div>

    <div class="form-group">
        {!! Form::label('hours_to_reply', trans('validation.attributes.hours_to_reply'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('hours_to_reply', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.hours_to_reply')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('message_finish', trans('validation.attributes.message_finish'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('message_finish', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.message_finish')]) !!}
        </div>
    </div><!--form control-->


        <div class="pull-left">
            <a href="{{route('admin.sectors.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop