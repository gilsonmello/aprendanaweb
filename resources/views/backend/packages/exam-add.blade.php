@extends ('backend.layouts.master')

@section ('name', trans('menus.exams'))



@section('page-header')
    <h1>
        {{ trans('menus.exams') }}
        <small>{{ trans('menus.all_exams') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.exams.index', trans('menus.exams')) !!}</li>
@stop

@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-name">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.packageexams.addindex'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_ExamController_text',  trans('strings.title'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_ExamController_text', $examcontrollertext, ['class' => 'form-control']  ) !!}
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.packageexams.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    @if ($exams != null)
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>{{ trans('crud.exams.title') }}</th>
                <th width="10%">{{ trans('strings.add') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($exams as $exam)
                <tr>
                    <td>{!! $exam->title !!}</td>
                    <td>{!! $exam->add_button !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pull-left">
            {!! $exams->total() !!} {{ trans('crud.exams.total') }}
        </div>

        <div class="pull-right">
            {!! $exams->render() !!}
        </div>
    @endif

    <div class="clearfix"></div>
@stop