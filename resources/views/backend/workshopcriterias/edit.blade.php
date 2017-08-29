
@extends ('backend.layouts.master')

@section ('title', trans('menus.workshopcriteria_management') . ' | ' . trans('menus.edit_workshopcriteria'))

@section('page-header')
    <h1>
        {{ trans('menus.workshopcriterias') }}
        <small>{{ trans('menus.edit_workshopcriteria') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.workshopcriterias.index', trans('menus.workshopcriterias')) !!}</li>
    <li class="active">{!! link_to_route('admin.workshopcriterias.create', trans('menus.edit_workshopcriteria')) !!}</li>
@stop

@section('content')

    {!! Form::model($workshopcriteria, ['route' => ['admin.workshopcriterias.update', $workshopcriteria->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('explanation', trans('strings.explanation'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('explanation', null, ['class' => 'form-control', 'placeholder' => trans('strings.explanation')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('max_grade', trans('strings.max_grade'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('max_grade', str_replace('.',',',$workshopcriteria->max_grade), ['class' => 'form-control', 'placeholder' => trans('strings.max_grade')]) !!}
        </div>
    </div><!--form control-->
    

    <div class="pull-left">
            <a href="{{route('admin.workshopcriterias.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop