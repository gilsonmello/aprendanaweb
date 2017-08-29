
@extends ('backend.layouts.master')

@section ('title', trans('menus.subsection_management') . ' | ' . trans('menus.edit_subsection'))

@section('page-header')
    <h1>
        {{ trans('menus.subsections') }}
        <small>{{ trans('menus.edit_subsection') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.subsections.index', trans('menus.subsections')) !!}</li>
    <li class="active">{!! link_to_route('admin.subsections.create', trans('menus.edit_subsection')) !!}</li>
@stop

@section('content')

    {!! Form::model($subsection, ['route' => ['admin.subsections.update', $subsection->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('nome', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', $subsection->name, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.name')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('slug', trans('validation.attributes.slug'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('slug', null, ['class' => 'form-control slug-from-title', 'placeholder' => trans('strings.slug')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('sections', trans('validation.attributes.sections'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("sections[]",$sections->lists("name","id"), $subsection->section()->get()->first()->id, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_subsections') ])  !!}

        </div>
    </div>

        <div class="pull-left">
            <a href="{{route('admin.subsections.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop