@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
<h1>
    {{ trans('menus.userstudent_management') }}
    <small>{{ trans('strings.student_exams') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.access.users.index', trans('strings.student_exams')) !!}</li>
@stop

@section('content')

<br/>
LOG DE ACESSO
<br/>

@if (sizeof($logs) > 0 )

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th width="30%">Aula/Bloco : Nome da Aula</th>
            <th width="10%">Inicio</th>
            <th width="10%">Final</th>
            <th width="5%">Tempo de Visualização</th>
            <th width="100">Navegador</th>
            <th width="100">IP</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($logs as $log)
        <tr>
            <td>{{ $log->lesson_sequence}}/{{ $log->bloco}} : {{ $log->lesson_title }} - </td>
            <td>{{ format_br($log->date_begin, 'd/m/Y H:i:s')}}</td>
            <td>{{ format_br($log->date_end,'d/m/Y H:i:s') }}</td>
            <td>{{ ($log->watched_time == 0) ? "-" : timeConverterMilisecondToMinute($log->watched_time) }}</td>
            <td>{{ $log->user_agent }}</td>
            <td>{{ $log->ip }}</td>
        </tr>
        @endforeach

    </tbody>
</table>
@else
<table><tr><td>Não existe(m) registro(s)</td></tr></table>
@endif
<div class="clearfix"></div>
@stop