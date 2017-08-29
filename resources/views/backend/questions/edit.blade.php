    
@extends ('backend.layouts.master')

@section ('title', trans('menus.question_management') . ' | ' . trans('menus.edit_question'))

@section('page-header')
    <h1>
        {{ trans('menus.questions') }}
        <small>{{ trans('menus.edit_question') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.questions.index', trans('menus.questions')) !!}</li>
    <li class="active">{!! link_to_route('admin.questions.create', trans('menus.edit_question')) !!}</li>
@stop

@section('content')

    {!! Form::model($question, ['route' => ['admin.questions.update', $question->id], 'class' => 'form-horizontal', 'files' => true, 'role' => 'form', 'method' => 'PATCH']) !!}

    @if ($group != null)
        {!! Form::hidden('group_id', $group) !!}
    @endif

    @if ($editastext == '1')
        <!-- {{ $editastext = "form-control" }}-->
    @else
        <!-- {{ $editastext = "form-control textarea" }}-->
    @endif


    <div class="form-group">
        {!! Form::label('text', trans('strings.question_text'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('text', $question->text, ['id' => 'question_text', 'class' => $editastext, 'placeholder' => trans('strings.question_text')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('answer_type', trans('strings.answer_type'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('answer_type', 'M', true) !!}  {!! trans('strings.multiple_options_unique_choices') !!}
        </div>
    </div><!--form control-->

    {{--//////////////////////// aswers ////////////////////////--}}
    @if(count($answers) > 0)
        <div class="form-group">
            {!! Form::label('answer1_choice', trans('strings.choice1'), ['class' => 'col-lg-2 control-label']) !!}
            {!! Form::hidden('answer1_id', $answers[0]->id, ['class' => 'form-control']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer1_choice', $answers[0]->choice, ['class' => 'form-control', 'placeholder' => trans('strings.choice1')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer1_is_right', '1', ($answers[0]->is_right === 1 ? true : false)) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
    @endif

    @if(count($answers) > 1)
        <div class="form-group">
            {!! Form::label('answer2_choice', trans('strings.choice2'), ['class' => 'col-lg-2 control-label']) !!}
            {!! Form::hidden('answer2_id', $answers[1]->id, ['class' => 'form-control']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer2_choice', $answers[1]->choice, ['class' => 'form-control', 'placeholder' => trans('strings.choice2')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer2_is_right', '1', ($answers[1]->is_right === 1 ? true : false)) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
    @endif

    @if(count($answers) > 2)
        <div class="form-group">
            {!! Form::label('answer3_choice', trans('strings.choice3'), ['class' => 'col-lg-2 control-label']) !!}
            {!! Form::hidden('answer3_id', $answers[2]->id, ['class' => 'form-control']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer3_choice', $answers[2]->choice, ['class' => 'form-control', 'placeholder' => trans('strings.choice3')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer3_is_right', '1', ($answers[2]->is_right === 1 ? true : false)) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
    @endif

    @if(count($answers) > 3)
        <div class="form-group">
            {!! Form::label('answer4_choice', trans('strings.choice4'), ['class' => 'col-lg-2 control-label']) !!}
            {!! Form::hidden('answer4_id', $answers[3]->id, ['class' => 'form-control']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer4_choice', $answers[3]->choice, ['class' => 'form-control', 'placeholder' => trans('strings.choice4')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer4_is_right', '1', ($answers[3]->is_right === 1 ? true : false)) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
    @endif

    @if(count($answers) > 4)
        <div class="form-group">
            {!! Form::label('answer5_choice', trans('strings.choice5'), ['class' => 'col-lg-2 control-label']) !!}
            {!! Form::hidden('answer5_id', $answers[4]->id, ['class' => 'form-control']) !!}
            <div class="col-lg-7">
                {!! Form::text('answer5_choice', $answers[4]->choice, ['class' => 'form-control', 'placeholder' => trans('strings.choice5')]) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::checkbox('answer5_is_right', '1', ($answers[4]->is_right === 1 ? true : false)) !!} {{ trans('strings.correct') }}
            </div>
        </div><!--form control-->
    @endif
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
            {!! Form::select('teachers[]', [''=>'Não informado'] + $teachers->lists('name', 'id')->all(), ( $question->teacher()->get()->first() != null ? $question->teacher()->get()->first()->id : null), ['class' => 'form-control select2', 'placeholder' => trans('strings.teacher') ])  !!}
        </div>
    </div>


    <div class="form-group">
        {!! Form::label('sources', trans('strings.source'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("sources[]", [''=>'Não informado'] + $sources->lists("name","id")->all(), ( $question->source()->get()->first() != null ? $question->source()->get()->first()->id : null), ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_source') ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('institutions', trans('strings.institution'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("institutions[]", [''=>'Não informado'] + $institutions->lists("name","id")->all(), ( $question->institution()->get()->first() != null ? $question->institution()->get()->first()->id : null), ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_institution') ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('offices', trans('strings.office'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("offices[]", [''=>'Não informado'] + $offices->lists("name","id")->all(), ( $question->office()->get()->first() != null ? $question->office()->get()->first()->id : null), ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_office') ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('subjects', trans('strings.subtheme'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("subjects[]", ['' =>'Não informado'] + $subjects->lists("parent_and_name","id")->all(), ( $question->subject()->get()->first() != null ? $question->subject()->get()->first()->id : null), ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_subject') ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('image', trans('strings.image'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="image"/>
            @if (($question->image != null) && ($question->image != ''))
                <br/>
                <a href="{!! $photooriginal !!}" target="_blank">
                   {!!   HTML::image($photoresize) !!}
                </a>
            @endif
        </div><!-- /.col -->
    </div>
      
    <div class="form-group">
        {!! Form::label('explanation_url', trans('strings.explanation_url'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10" style="width: 80.5%;">
            {!! Form::text('explanation_url', null, ['class' => 'form-control', 'placeholder' => trans('strings.explanation_url')]) !!}
        </div>
        <div class="col-lg-1" style="padding: 0; width: 2%; margin-top: 0.6%;">
            <i class="fa fa-tv content-preview" data-toggle="tooltip" title="Preview do vídeo" style="cursor:pointer"></i>
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('explanation_text', trans('strings.explanation_text'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('explanation_text', $question->explanation_text, ['class' => 'form-control', 'placeholder' => trans('strings.explanation_text')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('note1', trans('strings.note1'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('note1', $question->note1, ['class' => $editastext, 'placeholder' => trans('strings.note1')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('note2', trans('strings.note2'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('note2', $question->note2, ['class' => $editastext, 'placeholder' => trans('strings.note2')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('note3', trans('strings.note3'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('note3', $question->note3, ['class' => $editastext, 'placeholder' => trans('strings.note3')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('note4', trans('strings.note4'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('note4', $question->note4, ['class' => $editastext, 'placeholder' => trans('strings.note4')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="question-is_active" @if($question->is_active == 1)checked="checked"@endif>
                    <label for="question-is_active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->


    <div class="pull-left">
        <a href="{{route('admin.questions.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
    </div>

    <div class="pull-right">
        <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
    </div>
    <div class="clearfix"></div>

    {!! Form::close() !!}

    <div class="modal fade" id="vimeoPreviewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="suggestionModalLabel" style="color: #08C">Preview do vídeo</h4>
                </div>
                <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <iframe id="vimeo-preview" src="{{$question->explanation_url}}" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="100%" height="400" frameborder="0">
                                </iframe>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>


@stop