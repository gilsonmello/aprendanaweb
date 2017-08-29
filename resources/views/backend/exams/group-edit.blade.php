@extends ('backend.layouts.master')

@section ('title', trans('menus.group_management') . ' | ' . trans('menus.create_group'))

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        {{ trans('menus.group_management') }}
        <small>{{ trans('menus.create_group') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.groups.index', trans('menus.groups')) !!}</li>
    <li class="active">{!! link_to_route('admin.groups.create', trans('menus.create_group')) !!}</li>
@stop

@section('content')
    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.groupquestions.index')}}?f_group_id={{$group->id}}" class="btn btn-primary btn-xs">{{ trans('menus.group_questions') }}</a>
    </div>
    <br/>
    <br/>

    {!! Form::model($group, ['route' => ['admin.groups.update', $group->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('title', trans('strings.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('answer_type', trans('strings.answer_type'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('answer_type', 'M', true) !!}  {!! trans('strings.multiple_options_unique_choices') !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('weight', trans('strings.weight'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('weight', 1, ['class' => 'form-control', 'placeholder' => trans('strings.weight')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('strings.is_random') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="is_random" class="toggleBtn onoffswitch-checkbox" id="is_random" {{$group->is_random == 1 ? "checked='checked'" : ''}}>
                    <label for="is_random" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->
    <div class="pull-left">
        <a href="{{route('admin.groups.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
    </div>


    <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop