
@extends ('backend.layouts.master')

@section ('title', trans('menus.subject_management') . ' | ' . trans('menus.edit_subject'))

@section('page-header')
    <h1>
        {{ trans('menus.subjects') }}
        <small>{{ trans('menus.edit_subject') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.subjects.index', trans('menus.subjects')) !!}</li>
    <li class="active">{!! link_to_route('admin.subjects.create', trans('menus.edit_subject')) !!}</li>
@stop

@section('content')

    {!! Form::model($subject, ['route' => ['admin.subjects.update', $subject->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('nome', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', $subject->name, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('parents', trans('validation.attributes.parent'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("parents[]",  [''=>''] + $subjects->lists("name","id")->all(), ($subject->parent()->get()->first() != null ? $subject->parent()->get()->first()->id : null), ['class' => 'form-control select2' ])  !!}

        </div>
    </div>


    <div class="form-group">
        {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
        </div>
    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.subjects.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop