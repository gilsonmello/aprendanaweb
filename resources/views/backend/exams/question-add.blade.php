@extends ('backend.layouts.master')

@section ('name', trans('menus.questions'))



@section('page-header')
<h1>
    {{ trans('menus.questions') }}
    <small>{{ trans('menus.all_questions') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.questions.index', trans('menus.questions')) !!}</li>
@stop

@section('content')


<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-name">Filtro</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    {!! Form::open(array('route' => array('admin.groupquestions.addindex'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
    <div class="box-body">
        <div class="row">
            {!! Form::hidden('f_submit', '1'  ) !!}
            {!! Form::label('f_QuestionController_text',  trans('strings.question_text'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('f_QuestionController_text', $questioncontrollertext, ['class' => 'form-control']  ) !!}
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
    </div>
    {!! Form::close() !!}
</div>

@if ($questions != null)
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>{{ trans('crud.questions.name') }}</th>
            <th width="10%">{{ trans('crud.add') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($questions as $question)
        <tr>
            <td>{!! $question->id !!}</td>
            <td>{!! $question->text !!}</td>
            <td>{!! $question->add_button !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pull-left">
    {!! $questions->total() !!} {{ trans('crud.questions.total') }}
</div>

<div class="pull-right">
    {!! $questions->render() !!}
</div>
@endif

<div class="clearfix"></div>
@stop