@extends ('backend.layouts.master')

@section ('title', trans('menus.partner_manager') . ' | ' . trans('menus.create_partnermanager'))

@section('page-header')
    <h1>
        {{ trans('menus.partner_manager') }}
        <small>{{ trans('menus.create_partnermanager') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.partners.index', trans('menus.partner')) !!}</li>
    <li class="active">{!! trans('menus.create_partnermanager') !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.partnermanagers.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}

    {!! Form::hidden('partner_id',  $partner[0]->id ) !!}
    <br>
    <div class="form-group">
        {!! Form::label('partner', trans('strings.partner'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('partner', $partner[0]->name, ['class' => 'form-control', 'placeholder' => trans('strings.partner'),'disabled']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('admins', trans('strings.name'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('users[]', $users->lists('name', 'id')->all() , $partnermanagers->lists('user_id')->all(), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('admins', '&nbsp;', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="pull-left">
                <a href="{{route('admin.partners.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
            </div>
            <div class="pull-right">
                <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    {!! Form::close() !!}
@stop