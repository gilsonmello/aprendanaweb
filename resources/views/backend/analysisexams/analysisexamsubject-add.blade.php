@extends ('backend.layouts.master')

@section ('name', trans('menus.subjects'))



@section('page-header')
    <h1>
        {{ trans('menus.analysisexamsubject') }}
        <small>{{ trans('menus.all_analysisexamsubjects') }}</small>
    </h1>
@endsection


@section('content')


    {!! Form::open(['route' => 'admin.analysisexamsubjects.add', 'id' => 'update-course-form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
        <div class="form-group form-courses" style="">

            {!! Form::label('title' , trans('strings.theme'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="form-input col-md-4">
                {!! Form::select('subjects[]', $subjects_list->lists('name', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.subject') ])  !!}
            </div>
        </div>

    <div class="form-group">
        {!! Form::label('count', trans('strings.questions'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('count', null, ['class' => 'form-control', 'placeholder' => trans('strings.questions')]) !!}
        </div>

    </div><!--form control-->

            <div class="pull-left">
                <a href="{{route('admin.analysisexamsubjects.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
            </div>

            <div class="pull-right">
                <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
            </div>

    {!! Form::close() !!}
    <div class="clearfix"></div>
@stop