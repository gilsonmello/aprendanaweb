@extends ('backend.layouts.master')

@section ('title', trans('menus.content_comments'))

@section('page-header')
    <h1>
        {{ trans('menus.content_comments') }}
        <small>{{ trans('menus.all_contents_comments') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.contentcomments.index', trans('menus.content_comments')) !!}</li>
@stop

@section('content')
    {!! Form::open(array('route' => array('admin.contentcomments.index'), 'method' => 'get'))  !!}

    {!! Form::radio('status', '2',($status ===  '2' || $status === '' ? true : false), ['onClick' => 'javascript:this.form.submit();']) !!}Todos
    {!! Form::radio('status', '1',($status ===  '1' ? true : false),['onClick' => 'javascript:this.form.submit();']) !!}Ativado
    {!! Form::radio('status', '0',($status ===  '0' ? true : false),['onClick' => 'javascript:this.form.submit();']) !!}Desativado
    {!! Form::close() !!}


    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.contentscomments.id') }}</th>
            <th>{{ trans('crud.contentscomments.publishfor') }}</th>
            <th>{{ trans('crud.contentscomments.comment') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($contentscomments as $contentcomment)

            <tr>
                <td>{!! $contentcomment->id !!}</td>
                <td>{!! $contentcomment->publisher->name .'<br>' . format_datetimebr($contentcomment->created_at) .'<br>' !!}
                    @if($contentcomment->moderator != null)
                    {!! '<b>Ativado por:</b> ' . $contentcomment->moderator->name !!}
                    @endif
                </td>
                <td>{!! $contentcomment->comment !!}</td>
                <td>{!! $contentcomment->action_buttons !!}</td>
            </tr>

        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $contentscomments->total() !!} {{ trans('crud.contentscomments.total') }}
    </div>

    <div class="pull-right">
        {!! $contentscomments->render() !!}
    </div>

    <div class="clearfix"></div>
@stop