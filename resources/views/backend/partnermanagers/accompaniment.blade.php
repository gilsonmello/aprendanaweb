@extends ('backend.layouts.master')

@section ('name', trans('menus.partners'))

@section('page-header')
    <h1>
        {{ trans('menus.partner_management') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <i class="fa fa-dashboard"></i> 
            {{ trans('menus.dashboard') }}
        </a>
    </li>
    <li class="active">
        {!! link_to_route('admin.partners.index', trans('menus.partners')) !!}
    </li>
@stop

@section('content')
    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-name">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(['route' => ['admin.partnermanagers.accompaniment'], 'class' => 'form-horizontal', 'method' => 'get'])  !!}
            {!! Form::hidden('f_submit', '1') !!}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        {!! Form::label('f_PartnerManagerController_partner_id', trans('strings.partners')) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::select('f_PartnerManagerController_partner_id', ['' => ''] + $partnerusers->lists('partners_name', 'partners_id')->all(), $partnermanagercontrollerpartnerid, ['class' => 'select2']) !!}
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-2">
                        {!! Form::label('f_PartnerManagerController_date_begin', trans('strings.registration_date_begin')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('f_PartnerManagerController_date_begin', $partnermanagercontrollerdatebegin, ['class' => 'datemask']) !!}
                    </div>
                    <div class="col-md-1">
                        {!! Form::label('f_PartnerManagerController_date_end',  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.trans('strings.registration_date_end')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('f_PartnerManagerController_date_end', $partnermanagercontrollerdateend, ['class' => 'datemask']  ) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    {!! Form::label('f_PartnerManagerController_user_name',  trans('strings.student'), ['class' => 'col-md-1']) !!}
                    <div class="col-md-7">
                        {!! Form::text('f_PartnerManagerController_user_name', $partnermanagercontrollerusername, ['class' => 'form-control']  ) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        {!! Form::label('f_PartnerManagerController_course_id', trans('strings.courses')) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::select('f_PartnerManagerController_course_id', $courses->lists('title', 'id')->all(), $partnermanagercontrollercourseid, ['class' => 'select2']) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    {!! Form::label('f_PartnerManagerController_studentgroup',  trans('strings.studentgroup'), ['class' => 'col-md-1']) !!}
                    <div class="col-md-2">
                        {!! Form::text('f_PartnerManagerController_studentgroup', $partnermanagercontrollerstudentgroup, ['class' => 'form-control']  ) !!}
                    </div>
                </div>
                <br>
                <div class="box-footer">
                    {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th width="" class="text-center">{{ trans('strings.partner') }}</th>
                <th width="" class="text-center">{{ trans('strings.name') }}</th>
                <th width="" class="text-center">{{ trans('strings.user_email') }}</th>
                <th width="" class="text-center">{{ trans('strings.course') }}</th>
                <th width="" class="text-center">{{ trans('strings.studentgroup') }}</th>
                <th width="" class="text-center">{{ trans('strings.percentage_course') }}</th>
                <th width="" class="text-center">{{ trans('strings.date_add') }}</th>
                <th width="" class="text-center">{{ trans('strings.date_active') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $partner)
                <tr>
                    <td>{!! $partner->partners_name !!}</td>
                    <td>{!! $partner->users_name !!}</td>
                    <td>{!! $partner->users_email !!}</td>
                    <td>{!! $partner->courses_title !!}</td>
                    <td class="text-center">{!! $partner->studentgroups_name !!}</td>
                    <td class="text-center">{!! number_format($partner->percent_finished, 0, ',', '.' )!!} %</td>
                    <td class="text-center">{!! format_datebr($partner->created_at) !!}</td>
                    <td class="text-center">{!! format_datebr($partner->date_activation) !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pull-left">
          {!! $partnermanagercontrollercountstudent !!} {{ trans('crud.partners.total') }} 
    </div>
    <div class="pull-right">
        {!! $results->render() !!}
    </div>
    <div class="clearfix"></div>
@stop