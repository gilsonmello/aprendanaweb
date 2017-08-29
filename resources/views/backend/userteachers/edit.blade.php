@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.edit_user'))

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
        <small>{{ trans('menus.edit_user') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.users.edit', trans('menus.edit_user')) !!}</li>
@stop



@section('content')

    {!! Form::model($userteacher, ['route' => ['admin.userteachers.update', $userteacher->id], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true, 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.full_name')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('slug', trans('validation.attributes.slug'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('slug', null, ['class' => 'form-control slug-from-title', 'placeholder' => trans('strings.slug')]) !!}
        </div>
    </div><!--form control-->


        <div class="form-group">
            {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('gender', trans('strings.gender'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('gender', 'M', true) !!}  {!! trans('strings.male') !!}&nbsp;&nbsp;{!! Form::radio('gender', 'F') !!} {!! trans('strings.female') !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('cel', trans('strings.cel'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('cel', null, ['class' => 'form-control cel', 'placeholder' => trans('strings.cel')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('birthdate', trans('strings.birthdate'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('birthdate', null, ['class' => 'form-control birthdate', 'placeholder' => trans('strings.birthdate')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('personal_id', trans('strings.personal_id'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('personal_id', null, ['class' => 'form-control personal_id', 'placeholder' => trans('strings.personal_id')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('company_id', trans('strings.company_id'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('company_id', null, ['class' => 'form-control company_id', 'placeholder' => trans('strings.company_id')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('professional_number', trans('strings.professional_number'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('professional_number', null, ['class' => 'form-control', 'placeholder' => trans('strings.professional_number')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('video', trans('strings.video_teacher'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('video', null, ['class' => 'form-control', 'placeholder' => trans('strings.video_teacher')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('youtube', trans('strings.youtube'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('youtube', null, ['class' => 'form-control', 'placeholder' => trans('strings.youtube')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('facebook', trans('strings.facebook'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('facebook', null, ['class' => 'form-control', 'placeholder' => trans('strings.facebook')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('instagram', trans('strings.instagram'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('instagram', null, ['class' => 'form-control', 'placeholder' => trans('strings.instagram')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('linkedin', "Linked in", ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('linkedin', null, ['class' => 'form-control', 'placeholder' => "Linked in" ]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('jusbrasil', "JusBrasil", ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('jusbrasil', null, ['class' => 'form-control', 'placeholder' => "JusBrasil"]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('twitter', "Twitter", ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('twitter', null, ['class' => 'form-control', 'placeholder' => "Twitter"]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('periscope', "Periscope", ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('periscope', null, ['class' => 'form-control', 'placeholder' => "Periscope"]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('zip', trans('strings.zip'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('zip', null, ['class' => 'form-control zip', 'placeholder' => trans('strings.zip'), 'onblur' => 'javascript:findAddressBrazil($("#zip"), $("#address"));']) !!}
        </div>
    </div><!--form control-->

    {!! Form::hidden('city_id', $city->id, ['id' => 'city_id']) !!}

    <div class="form-group">
        {!! Form::label('city', trans('strings.city'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('city', $city->name, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.city')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('state', trans('strings.state'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('state', $state->short, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.state')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('neighborhood', trans('strings.neighborhood'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('neighborhood', null, ['class' => 'form-control', 'placeholder' => trans('strings.neighborhood')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('address', trans('strings.address'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => trans('strings.address')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('address_number', trans('strings.address_number'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('address_number', null, ['class' => 'form-control', 'placeholder' => trans('strings.address_number')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('address_comp', trans('strings.address_comp'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('address_comp', null, ['class' => 'form-control', 'placeholder' => trans('strings.address_comp')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('tags', trans('validation.attributes.tags'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('tags[]', $userteacher->tags_array, $userteacher->tags_array, ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('educational_title', trans('strings.educational_title'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('educational_title', null, ['class' => 'form-control', 'placeholder' => trans('strings.educational_title')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('linkcv', trans('strings.linkcv'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('linkcv', null, ['class' => 'form-control', 'placeholder' => trans('strings.linkcv')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('resume', trans('strings.resume'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('resume', null, ['class' => 'form-control', 'placeholder' => trans('strings.resume')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('bank', trans('strings.bank_code'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('bank', null, ['class' => 'form-control', 'placeholder' => trans('strings.bank_code')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('agency', trans('strings.agency'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('agency', null, ['class' => 'form-control', 'placeholder' => trans('strings.agency')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('account', trans('strings.bank_account'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('account', null, ['class' => 'form-control', 'placeholder' => trans('strings.bank_account')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('meta_description', "Meta Description", ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="box-body" style="padding: 0px;">
                {!! Form::textarea('meta_description', null, ['maxlength' => '140', 'class' => 'form-control', 'placeholder' => "Meta Description"]) !!}
            </div>
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('photo', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <a href="{!! $photooriginal !!}" target="_blank">
                <input type="file" name="photo"/> <br/>{!!   HTML::image($photoresize) !!}
            </a>
        </div><!-- /.col -->
    </div>


    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('strings.has_children') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="has_children" class="toggleBtn onoffswitch-checkbox" id="has_children-active" {{$userteacher->has_children == 1 ? "checked='checked'" : ''}}>
                    <label for="has_children-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('strings.is_newsletter_subscriber') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="is_newsletter_subscriber" class="toggleBtn onoffswitch-checkbox" id="is_newsletter_subscriber-active" {{$userteacher->is_newsletter_subscriber == 1 ? "checked='checked'" : ''}}>
                    <label for="is_newsletter_subscriber-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.list_on_site') }}</label>
        <div class="col-lg-1">
            <div class="sw-green confirmation-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="list_on_site" class="toggleBtn onoffswitch-checkbox" id="confirm-list_on_site" {{$userteacher->list_on_site == 1 ? "checked='checked'" : ''}}>
                    <label for="confirm-list_on_site" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.featured') }}</label>
        <div class="col-lg-1">
            <div class="sw-green confirmation-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="featured" class="toggleBtn onoffswitch-checkbox" id="confirm-featured" {{$userteacher->featured == 1 ? "checked='checked'" : ''}}>
                    <label for="confirm-featured" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->


    <div class="form-group">
            <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
            <div class="col-lg-1">
                <div class="sw-green create-permissions-switch">
                    <div class="onoffswitch">
                        <input type="checkbox" value="1" name="status" class="toggleBtn onoffswitch-checkbox" id="user-active" {{$userteacher->status == 1 ? "checked='checked'" : ''}}>
                        <label for="user-active" class="onoffswitch-label">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div><!--green checkbox-->
            </div>
        </div><!--form control-->

        <div class="form-group">
            <label class="col-lg-2 control-label">{{ trans('validation.attributes.confirmed') }}</label>
            <div class="col-lg-1">
                <div class="sw-green confirmation-switch">
                    <div class="onoffswitch">
                        <input type="checkbox" value="1" name="confirmed" class="toggleBtn onoffswitch-checkbox" id="confirm-active" {{$userteacher->confirmed == 1 ? "checked='checked'" : ''}}>
                        <label for="confirm-active" class="onoffswitch-label">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div><!--green checkbox-->
            </div>
        </div><!--form control-->


    <div class="form-group">
        {!! Form::label('last_access', trans('strings.last_access'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('last_access', null, ['class' => 'form-control',  'disabled' => 'disabled', 'placeholder' => trans('strings.last_access')]) !!}
        </div>
    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.userteachers.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}

@stop

