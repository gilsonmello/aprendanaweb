@extends ('backend.layouts.master')

@section ('title', trans('menus.subjectcourses'))



@section('page-header')
    <h1>
        {{ trans('menus.subjectcourses') }}
        <small>{{ trans('menus.all_subjectcourses') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.subjectcourses.index', trans('menus.subjectcourses')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.subjects.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="">
        <tbody>

    {{--*/ $temp = ''  /*--}}

    @foreach ($subjectcourses as $subjectcourse)
        @if (($subjectcourse->subject !== null))
            @if ($temp !== $subjectcourse->subject->name)
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3"><b>
                                @if (($subjectcourse->subject->subject_id !== null) && ($subjectcourse->subject->parent != null))
                                    [ {{ $subjectcourse->subject->parent->name }} ] -
                                @endif
                                    {{ $subjectcourse->subject->name }}
                        </b>
                    </td>
                </tr>
            {{--*/ $temp = $subjectcourse->subject->name /*--}}
            @endif
        @endif
        <tr>
            <td width="30">&nbsp;</td>
            <td>
                @if ($subjectcourse->course !== null)
                    {{ $subjectcourse->course->title }}
                @endif
            </td>
            <td>
                @if ($subjectcourse->exam !== null)
                    {{ $subjectcourse->exam->title }}
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
</table>
<br>
<div class="pull-left">
{!! $subjectcourses->count() !!} {{ trans('crud.subjectcourses.total') }}
</div>

<div class="clearfix"></div>


@stop