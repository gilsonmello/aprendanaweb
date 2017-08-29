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
            <th>{{ trans('strings.question') }}</th>
        </tr>
        </thead>
        <tbody>

            @foreach ($groupquestions as $groupquestion)
                @if ($groupquestion->question != null)
                    <tr>
                        <td>{!! $groupquestion->sequence !!}</td>
                        <td>{!! $groupquestion->question_id !!}</td>
                        <td >
                            <strong>{!! $groupquestion->question->text!!}</strong>
                            <br/>
                            {!! ($groupquestion->question->answer_type == 'M' ? trans('strings.multiple_options_unique_choices') : "") !!}
                            <br/>
                            <br/>
                                @if($letter = ord('a'))@endif
                                @foreach ($groupquestion->question->answers()->get() as $answer)
                                    <div style="margin-left: 40px; padding: 5px; background-color: {!! ($answer->is_right == 1 ? "#adee96" : "" ) !!}">
                                        <b>{!! chr($letter) !!}) </b>{!! $answer->choice  !!}
                                    </div>
                                    @if($letter++)@endif
                                @endforeach
                            <br/>
                            {!! ($groupquestion->question->year) !!} |

                            {!! ($groupquestion->question->original == 1 ? trans('strings.original_question') : (($groupquestion->question->original == 0 ? trans('strings.adaptada') : trans('strings.concursos_anteriores') ) ) )!!} |

                            {!! ($groupquestion->question->scope == 0 ? trans('strings.geral') : (
                                ($groupquestion->question->scope == 1 ? trans('strings.municipal') :
                                ($groupquestion->question->scope == 2 ? trans('strings.estadual') : trans('strings.federal') ) ) ) )!!}

                            |

                            @if (($groupquestion->question->source != null) || ($groupquestion->question->institution != null) || ($groupquestion->question->office != null))
                                @if ($groupquestion->question->source != null)
                                {!! ($groupquestion->question->source->name) !!} |
                                @endif

                                @if ($groupquestion->question->institution != null)
                                {!! ($groupquestion->question->institution->abbreviation) !!} |
                                @endif

                                @if ($groupquestion->question->office != null)
                                {!! ($groupquestion->question->office->name) !!} |
                                @endif
                            @endif
                            <br/><br/>

                            @if ($groupquestion->question->subject != null)
                                <strong>{!! trans('strings.subtheme') !!}: </strong>
                                @if (($groupquestion->question->subject->parent != null) && ($groupquestion->question->subject->parent->parent != null))
                                    <span>
                                    <strong>[{!! ($groupquestion->question->subject->parent->parent->name) !!}]</strong> -
                                @else
                                    <span style="color: red;">
                                @endif
                                @if ($groupquestion->question->subject->parent != null)
                                    {!! ($groupquestion->question->subject->parent->name) !!} -
                                @endif
                                {!! ($groupquestion->question->subject->name) !!}
                                </span>
                                <br/><br/>
                            @else
                                <span style="color: red;">{!! trans('strings.subtheme') !!} - {!! trans('strings.not_informed') !!}</span><br/><br/>
                            @endif

                            @if ($groupquestion->question->teacher != null)
                                <strong>{!! trans('strings.teacher') !!}:</strong> {!! ($groupquestion->question->teacher->name) !!}<br/><br/>
                            @else
                                <span style="color: red;">{!! trans('strings.teacher') !!} - {!! trans('strings.not_informed') !!}</span><br/><br/>
                            @endif

                            @if ($groupquestion->question->explanation_url != null)
                                <strong>{!! trans('strings.explanation_url') !!}: </strong>{!! ($groupquestion->question->explanation_url) !!}<br/><br/>
                            @else
                                <span style="color: red;">{!! trans('strings.explanation_url') !!} - {!! trans('strings.not_informed') !!}</span><br/><br/>
                            @endif

                            @if ($groupquestion->question->note1 != null)
                            <strong>{!! trans('strings.note1') !!}</strong> - {!! trans('strings.informed') !!}<br/>
                            {{--{!! ($groupquestion->question->note1) !!}<br/><br/>--}}
                            @else
                                <span style="color: red;">{!! trans('strings.note1') !!} - {!! trans('strings.not_informed') !!}</span><br/>
                            @endif

                            @if ($groupquestion->question->note2 != null)
                            <strong>{!! trans('strings.note2') !!}</strong> - {!! trans('strings.informed') !!}<br/>
                            {{--{!! ($groupquestion->question->note2) !!}<br/><br/>--}}
                            @else
                                <span style="color: red;">{!! trans('strings.note2') !!} - {!! trans('strings.not_informed') !!}</span><br/>
                            @endif

                            @if ($groupquestion->question->note3 != null)
                            <strong>{!! trans('strings.note3') !!}</strong> - {!! trans('strings.informed') !!}<br/>
                            {{--{!! ($groupquestion->question->note3) !!}<br/><br/>--}}
                            @else
                                <span style="color: red;">{!! trans('strings.note3') !!} - {!! trans('strings.not_informed') !!}</span><br/>
                            @endif

                            @if ($groupquestion->question->note4 != null)
                                <strong>{!! trans('strings.note4') !!}</strong> - {!! trans('strings.informed') !!}<br/>
                                {{--{!! ($groupquestion->question->note4) !!}<br/><br/>--}}
                            @else
                                <span style="color: red;">{!! trans('strings.note4') !!} - {!! trans('strings.not_informed') !!}</span><br/>
                            @endif


                        </td>
                    </tr>
                @endif
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