
@extends ('backend.layouts.master')

@section ('title', trans('menus.myworkshopevaluation_management') . ' | ' . trans('menus.edit_myworkshopevaluation'))

@section('page-header')
    <h1>
        {{ trans('menus.myworkshopevaluations') }}
        <small>{{ trans('menus.edit_myworkshopevaluation') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.myworkshopevaluations.index', trans('menus.myworkshopevaluations')) !!}</li>
    <li class="active">{!! link_to_route('admin.myworkshopevaluations.create', trans('menus.edit_myworkshopevaluation')) !!}</li>
@stop

@section('content')

    <form class='form-horizontal'>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                 @if ( (isset($myworkshopevaluation->myActivity->activity->url_document)) && ($myworkshopevaluation->myActivity->activity->url_document != '') )
                <a type="button" target="_blank" href="{{ $myworkshopevaluation->myActivity->activity->url_document }}" class="btn btn-success" ></i>&nbsp;&nbsp;FOLHA DE RESPOSTA</a>
                @endif
                @if ( (isset($myworkshopevaluation->myActivity->activity->url_response)) && ($myworkshopevaluation->myActivity->activity->url_response != '') )
                    <a type="button" target="_blank" href="{{ $myworkshopevaluation->myActivity->activity->url_response }}" class="btn btn-success" ></i>&nbsp;&nbsp;BAREMA</a>
                @endif
                @if ( (isset($myworkshopevaluation->myActivity->url_document_activity)) && ($myworkshopevaluation->myActivity->url_document_activity != '') )
                <a type="button" target="_blank" href="{{ $myworkshopevaluation->myActivity->url_document_activity }}" class="btn btn-success" ></i>&nbsp;&nbsp;RESPOSTA DO ALUNO</a>
                @endif
                @if ( (isset($myworkshopevaluation->url_response)) && ($myworkshopevaluation->url_response != '') )
                    <a type="button" target="_blank" href="{{ $myworkshopevaluation->url_response }}" class="btn btn-success" ></i>&nbsp;&nbsp;CORRE??O</a>
                @endif
            </div>
        </div><!--form control-->
        <div class="clearfix"></div>
    <div class="form-group">
        {!! Form::label('student', trans('strings.student'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('student', $myworkshopevaluation->myActivity->enrollment->student->name, ['class' => 'form-control', 'placeholder' => trans('strings.submit'), 'disabled' => 'disabled']) !!}
        </div>
    </div><!--form control-->
    <div class="clearfix"></div>

    <div class="form-group">
        {!! Form::label('submit', trans('strings.submit_date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-4">
            {!! Form::text('submit', format_datebr($myworkshopevaluation->myActivity->date_submit), ['class' => 'form-control', 'placeholder' => trans('strings.submit'), 'disabled' => 'disabled']) !!}
        </div>
        {!! Form::label('submit', trans('strings.deadline_evaluation'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-4">
            {!! Form::text('submit', $myworkshopevaluation->date_deadline, ['class' => 'form-control', 'placeholder' => trans('strings.deadline_evaluation'), 'disabled' => 'disabled']) !!}
        </div>

    </div><!--form control-->
        @if ( (isset($myworkshopevaluation->myActivity->activity->text)) && ($myworkshopevaluation->myActivity->activity->text != '') )
        <div class="form-group">
            {!! Form::label('text', trans('crud.myworkshopevaluations.text'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::textarea('text_response', strip_tags($myworkshopevaluation->myActivity->activity->text) , ['class' => 'form-control', 'placeholder' => trans('crud.myworkshopevaluations.text')]) !!}
            </div>
        </div><!--form control-->
        @endif
     
        @if ( (isset($myworkshopevaluation->myActivity->activity->text_response)) && ($myworkshopevaluation->myActivity->activity->text_response != '') )
        <div class="form-group">
            {!! Form::label('text_response', trans('crud.myworkshopevaluations.text_response'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::textarea('text_response', $myworkshopevaluation->myActivity->activity->text_response , ['class' => 'form-control', 'placeholder' => trans('crud.myworkshopevaluations.text_response')]) !!}
            </div>
        </div><!--form control-->
        @endif
        
        
    </form>

    {!! Form::model($myworkshopevaluation, ['route' => ['admin.myworkshopevaluations.update', $myworkshopevaluation->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}


    <div class="form-group">
        {!! Form::label('image', trans('crud.myworkshopevaluations.url_evaluation'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="url_evaluation"/>
            <br>
            @if(isset($myworkshopevaluation->url_evaluation) && !empty($myworkshopevaluation->url_evaluation))
                <a style="margin-top: 5px;" type="button" target="_blank" href="{{ $myworkshopevaluation->url_evaluation }}" class="btn btn-success" ></i>&nbsp;ARQUIVO DE CORREÇÂO</a>
            @endif


        </div><!-- /.col -->


    </div>

    <div class="form-group">
        {!! Form::label('evaluation', trans('crud.myworkshopevaluations.evaluation'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('evaluation', null, ['class' => 'form-control', 'placeholder' => trans('crud.myworkshopevaluations.evaluation')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('grade', trans('strings.grade'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-2">
            {!! Form::text('grade', $myworkshopevaluation->grade, ['class' => 'grade form-control', 'placeholder' => trans('strings.grade')])!!}
        </div>
    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.myworkshopevaluations.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop