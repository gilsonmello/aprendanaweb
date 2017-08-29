@extends ('backend.layouts.master')

@section ('title', trans('menus.teacherstatements'))

@section('page-header')
    <h1>
        {{ trans('menus.teacherstatements') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.teacherstatements.index', trans('menus.teacherstatements')) !!}</li>
@stop

@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.teacherstatements.index'), 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                <div class="col-md-5">
                {!! Form::label('f_TeacherStatementController_date_begin',  trans('strings.date_begin')) !!}
                {!! Form::text('f_TeacherStatementController_date_begin', $teacherstatementcontrollerdatebegin, ['class' => 'datemask']) !!}
                {!! Form::label('f_TeacherStatementController_date_end',  trans('strings.date_end')) !!}
                {!! Form::text('f_TeacherStatementController_date_end', $teacherstatementcontrollerdateend, ['class' => 'datemask']  ) !!}
                </div>

                @if (sizeof($teachers) != 0)
                            <div class="col-md-5">
                    {!! Form::label('$f_TeacherStatementController_user_id', trans('validation.attributes.teacher')) !!}
                    {!! Form::select('f_TeacherStatementController_user_id', $teachers->lists('name', 'id'), $teacherstatementcontrolleruserid, ['class' => 'select2']) !!}
                            </div>
                @endif
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
            <div class="pull-right" style="margin-bottom:10px">
                <a href="{{route('admin.teacherstatements.create')}}" class="btn btn-primary btn-xs">
                    {{ trans('menus.create_payment') }}
                </a>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
    

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.teacherstatements.date') }}</th>
            <th width="20%">{{ trans('crud.teacherstatements.order_id') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.value_order') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.value_discount') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.value_order_final') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.value_payment_tax') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.value_taxes') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.value_costs') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.value_net') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.percentage_distribute') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.value_distribute') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.percentage') }}</th>
             <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.value') }}</th>
            <th class="text-right"  width="6%">{{ trans('crud.teacherstatements.balance') }}</th>
            <th   width="3%">{{ trans('crud.teacherstatements.del') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($teacherstatements as $teacherstatement)
            <tr>
                <td>{!! format_datebr($teacherstatement->date) !!}</td>
                <td>
                    {!! $teacherstatement->order_id != null ?
                        $teacherstatement->order_id . ' - ' . format_datebr($teacherstatement->date_order) . '<br/>' . $teacherstatement->buyer_name . '<br/>' .
                        $teacherstatement->product_name
                        :
                        '' !!}
                    {!! $teacherstatement->partnerorder_id != null ?
                        $teacherstatement->partnerorder_id . '/' . $teacherstatement->partnerorderpayment_id . ' - ' . format_datebr($teacherstatement->date_order) . '<br/>' . $teacherstatement->buyer_name . '<br/>' .
                        $teacherstatement->product_name
                        :
                        '' !!}
                </td>
                <td class="text-right">{!! number_format($teacherstatement->value_order, 2, ',', '.' )!!}</td>
                <td class="text-right">{!! number_format($teacherstatement->value_discount , 2, ',', '.' )!!}</td>
                <td class="text-right">{!! number_format($teacherstatement->value_order_final , 2, ',', '.' )!!}</td>
                <td class="text-right">{!! number_format($teacherstatement->value_payment_tax , 2, ',', '.' )!!}</td>
                <td class="text-right">{!! number_format($teacherstatement->value_taxes , 2, ',', '.' )!!}</td>
                <td class="text-right">{!! number_format($teacherstatement->value_costs , 2, ',', '.' )!!}</td>
                <td class="text-right">{!! number_format($teacherstatement->value_net , 2, ',', '.' )!!}</td>
                <td class="text-right">{!! number_format($teacherstatement->percentage_distribute , 0, ',', '.' ) !!}%</td>
                <td class="text-right">{!! number_format($teacherstatement->value_distribute , 2, ',', '.' )!!}</td>
                <td class="text-right">{!! number_format($teacherstatement->percentage , 0, ',', '.' ) !!}%</td>
                <td class="text-right bold {{ $teacherstatement->value > 0 ? "green" :  ($teacherstatement->anticipation === 1 ? "blue" : "red" ) }}">
                    {!! number_format($teacherstatement->value , 2, ',', '.' )!!}
                </td>
                <td class="text-right bold {{ $teacherstatement->balance >= 0 ? "green" : "red" }}">
                    {!! number_format($teacherstatement->balance , 2, ',', '.' )!!}
                </td>
                <td>
                    @if (($teacherstatement->order_id == null) && ($teacherstatement->partnerorder_id == null))
                        {!! $teacherstatement->action_buttons !!}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-green-active color-palette">
                <td colspan="15">{{ trans('crud.teacherstatements.orders_value') }}:  R$ {!! number_format($ordersvalue , 2, ',', '.' )!!}</td>
            </tr>
            <tr class="bg-green color-palette">
                <td colspan="15">{{ trans('crud.teacherstatements.orders_count') }}:  {!! number_format($orderscount , 0, ',', '.' )!!}</td>
            </tr>
            <tr class="bg-red-active color-palette">
                <td colspan="15">{{ trans('crud.teacherstatements.payments_value') }}:  R$ {!! number_format($paymentsvalue , 2, ',', '.' )!!}</td>
            </tr>
            <tr class="bg-red color-palette">
                <td colspan="15">{{ trans('crud.teacherstatements.payments_count') }}:  {!! number_format($paymentscount , 0, ',', '.' )!!}</td>
            </tr>
            <tr class="bg-light-blue-active color-palette">
                <td colspan="15">{{ trans('crud.teacherstatements.anticipations_value') }}:  R$ {!! number_format($anticipationsvalue , 2, ',', '.' )!!}</td>
            </tr>
            <tr class="bg-light-blue color-palette">
                <td colspan="15">{{ trans('crud.teacherstatements.anticipations_count') }}:  {!! number_format($anticipationscount , 0, ',', '.' )!!}</td>
            </tr>
            <tr class="bg-gray-active color-palette">
                <td colspan="15">{{ trans('crud.teacherstatements.balance_value') }}:  R$ {!! number_format($ordersvalue - $paymentsvalue - $anticipationsvalue , 2, ',', '.' )!!}</td>
            </tr>
            <tr class="bg-gray color-palette">
                <td colspan="15">{{ trans('crud.teacherstatements.records_count') }}:  {!! number_format($orderscount + $paymentscount + $anticipationscount, 0, ',', '.' )!!}</td>
            </tr>
        </tfoot>
    </table>

    <div class="clearfix"></div>
@stop