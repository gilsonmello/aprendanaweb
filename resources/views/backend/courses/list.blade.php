@extends ('backend.layouts.master')

@section ('title', trans('menus.courses'))



@section('page-header')
    <h1>
        {{ trans('menus.courses') }}
        <small>{{ trans('strings.validation') }}</small>
    </h1>
@endsection

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.courses.index')}}" class="btn btn-primary btn-xs">
            {{ trans('strings.back') }}
        </a>
    </div>

    <div class="clearfix"></div>

    <table class="table">
        <tbody>
        @foreach ($courses as $course)
            <tr>
                <td colspan="4"><b>{!! $course->title !!}</b></td>
            </tr>
            <tr>
                <td colspan="4"><b>Tags:</b> {!! $course->tags !!}</td>
            </tr>
                <td colspan="4">
                    <b>Preço:</b> R$ {{ number_format( $course->price, 2, ',', '.' ) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>Preço com Desconto:</b> R$ {{ number_format( $course->discount_price , 2, ',', '.' ) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>Prazo de acesso: </b> {{ number_format( $course->access_time, 0, ',', '.' ) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>Carga Horária: </b>{{ format_display_time( $course->workload * 3600, true ) }}
                </td>
            </tr>
            @foreach ($course->modules as $module)
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="3">{!! $module->name !!}</td>
                </tr>
                @foreach ($module->lessons as $lesson)
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td colspan="2">Aula {!! $lesson->sequence !!} - {!! $lesson->title !!}</td>
                    </tr>
                    @foreach ($lesson->contents as $content)
                        @if ($content->is_video == '1')
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="5%">&nbsp;</td>
                            <td width="5%">&nbsp;</td>
                            <td colspan="1">Bloco {!! $content->sequence !!} - {!! $content->url !!}</td>
                        </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="clearfix"></div>
@stop