@extends ('backend.layouts.master')

@section ('title', trans('menus.exams'))



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

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.exams.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_exam') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.exams.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_ExamController_title',  trans('strings.title'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('f_ExamController_title', $examcontrollertitle, ['class' => 'form-control']  ) !!}
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>    

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.exams.title') }}</th>
            {{--<th class="text-right" >{{ trans('crud.exams.price') }}</th>--}}
            {{--<th class="text-right" >{{ trans('crud.exams.average_grade') }}</th>--}}
            {{--<th class="text-right" >{{ trans('crud.exams.orders_count') }}</th>--}}
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($exams as $exam)
            <tr>
                <td>{!! $exam->title !!}</td>
                {{--<td class="text-right" >{!! number_format($exam->price, 2, ',', '.' ) !!}</td>--}}
                {{--<td class="text-right" >{!! number_format($exam->average_grade, 2, ',', '.' )  !!}</td>--}}
                {{--<td class="text-right" >{!!  number_format($exam->orders_count, 0, ',', '.' )   !!}</td>--}}
                <td>{!! $exam->action_buttons !!}</td>
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

    <div class="clearfix"></div>
@stop