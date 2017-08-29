@extends ('backend.layouts.master')

@section ('title', trans('menus.question_management') . ' | ' . trans('menus.create_question'))

@section('page-header')
    <h1>
        {{ trans('menus.question_management') }}
        <small>{{ trans('menus.create_question') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.questions.index', trans('menus.question')) !!}</li>
    <li class="active">{!! link_to_route('admin.questions.create', trans('menus.create_question')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.questions.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}

    @if ($group != null)
    {!! Form::hidden('group_id', $group) !!}
    @endif

    <div class="form-group">
        {!! Form::label('text', trans('strings.question_text'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('text', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.question_text')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('answer_type', trans('strings.answer_type'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('answer_type', 'M', true) !!}  {!! trans('strings.multiple_options_unique_choices') !!}
        </div>
    </div><!--form control-->

    {{--//////////////////////// aswers ////////////////////////--}}
        <div class="form-group">
            {!! Form::label('answer1_choice', trans('strings.choice1'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer1_choice', null, ['class' => 'form-control', 'placeholder' => trans('strings.choice1')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer1_is_right', '1', null) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
        <div class="form-group">
            {!! Form::label('answer2_choice', trans('strings.choice2'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer2_choice', null, ['class' => 'form-control', 'placeholder' => trans('strings.choice2')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer2_is_right', '1', null) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
        <div class="form-group">
            {!! Form::label('answer3_choice', trans('strings.choice3'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer3_choice', null, ['class' => 'form-control', 'placeholder' => trans('strings.choice3')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer3_is_right', '1', null) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
        <div class="form-group">
            {!! Form::label('answer4_choice', trans('strings.choice4'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer4_choice', null, ['class' => 'form-control', 'placeholder' => trans('strings.choice4')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer4_is_right', '1', null) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
        <div class="form-group">
            {!! Form::label('answer5_choice', trans('strings.choice5'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer5_choice', null, ['class' => 'form-control', 'placeholder' => trans('strings.choice5')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer5_is_right', '1', null) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
    {{--////////////////////////////////////////////////////////////////////////////////////////////////--}}

    <br/>
    <br/>
    <br/>
    <div class="form-group">
        {!! Form::label('year', trans('strings.year'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('year', null, ['class' => 'form-control', 'placeholder' => trans('strings.year')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('original', trans('strings.origin'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('original', '1', true) !!}  {!! trans('strings.original_question') !!}
            &nbsp;&nbsp;{!! Form::radio('original', '0') !!} {!! trans('strings.adaptada') !!}
            &nbsp;&nbsp;{!! Form::radio('original', '2') !!} {!! trans('strings.concursos_anteriores') !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('scope', trans('strings.scope'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('scope', '0', true) !!}  {!! trans('strings.geral') !!}
            &nbsp;&nbsp;{!! Form::radio('scope', '1') !!} {!! trans('strings.municipal') !!}
            &nbsp;&nbsp;{!! Form::radio('scope', '2') !!} {!! trans('strings.estadual') !!}
            &nbsp;&nbsp;{!! Form::radio('scope', '3') !!} {!! trans('strings.federal') !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('teachers', trans('strings.teacher'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('teachers[]', [''=>'Não informado'] + $teachers->lists('name', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.teacher') ])  !!}
        </div>
    </div>


    <div class="form-group">
        {!! Form::label('sources', trans('strings.source'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("sources[]", [''=>'Não informado'] + $sources->lists("name","id")->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_source') ])  !!}

        </div>
    </div>


    <div class="form-group">
        {!! Form::label('institutions', trans('strings.institution'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("institutions[]", [''=>'Não informado'] + $institutions->lists("name","id")->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_institution') ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('offices', trans('strings.office'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("offices[]", [''=>'Não informado'] + $offices->lists("name","id")->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_office') ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('subjects', trans('strings.subtheme'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("subjects[]", [''=>'Não informado'] + $subjects->lists("parent_and_name","id")->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_subject') ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('image', trans('strings.image'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="image"/>
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('explanation_url', trans('strings.explanation_url'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('explanation_url', null, ['class' => 'form-control', 'placeholder' => trans('strings.explanation_url')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('explanation_text', trans('strings.explanation_text'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('explanation_text', null, ['class' => 'form-control', 'placeholder' => trans('strings.explanation_text')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('note1', trans('strings.note1'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('note1', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.note1')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('note2', trans('strings.note2'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('note2', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.note2')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('note3', trans('strings.note3'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('note3', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.note3')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('note4', trans('strings.note4'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('note4', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.note4')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="section-is_active" checked="checked">
                    <label for="section-is_active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->


    <div class="pull-left">
            <a href="{{route('admin.questions.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop