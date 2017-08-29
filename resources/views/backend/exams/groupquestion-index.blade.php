@extends ('backend.layouts.master')

@section ('title', trans('menus.groupquestions'))



@section('page-header')
    <h1>
        {{ trans('menus.groupquestions') }}
        <small>{{ trans('menus.all_groupquestions') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.groupquestions.index', trans('menus.groupquestions')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.groupquestions.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_question') }}
        </a>
        <a href="{{route('admin.groupquestions.addindex')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.add_question') }}
        </a>
        <a href="{{route('admin.groups.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th  width="80">{{ trans('crud.groupquestions.number') }}</th>
            <th  width="80">Qst Id</th>
            <th>{{ trans('crud.groupquestions.text') }}</th>
            <th width="120">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($groupquestions as $groupquestion)
            <tr>
                <td>{!! $groupquestion->sequence !!}</td>
                <td>{!! $groupquestion->question_id !!}</td>
                <td>{!! ($groupquestion->question != null ? $groupquestion->question->text : '') !!}</td>
                <td>{!! $groupquestion->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $groupquestions->count() !!} {{ trans('crud.groupquestions.total') }}
    </div>

    <div class="clearfix"></div>

    <div class="modal fade" id="modalGroupQuestionChangeSequence" tabindex="-1" role="dialog"  >
        <div class="modal-dialog  modal-lg" role="document"  style="width: 300px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nova posição</h4>
                </div>
                <div style="padding: 20px; font-size: 1.5rem;">
                    {!! Form::open(['route' => ['admin.groupquestions.changesequence'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) !!}
                    {!! Form::hidden('group_question_id', null, ['id' => 'group_question_id']  ) !!}
                    {!! Form::text('new_sequence', '', ['id' => 'new_sequence'] ) !!}
                    <br/>
                    <br/>
                    {!! Form::submit( trans('strings.change') , ['class' => 'btn btn-primary button-askTheTeacher']) !!}
                </div>
            </div>
        </div>
    </div>
@stop