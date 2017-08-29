@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        {{ trans('menus.userstudent_management') }}
        <small>{{ trans('menus.orders') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.access.users.index', trans('menus.orders')) !!}</li>
@stop

@section('content')
    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.userstudents.edit', $studentordercontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.edit_userstudents') }}</a>
        <a href="{{route('admin.userstudents.enrollments', $studentordercontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.courses') }}</a>
        <a href="{{route('admin.userstudents.exams', $studentordercontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.exams') }}</a>
        <a href="{{route('admin.userstudents.orders', $studentordercontrollerstudentid)}}" class="btn btn-primary btn-xs">{{ trans('menus.orders') }}</a>
    </div>
    <br/>
    <br/>

    @if (sizeof($orders) > 0 )

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Número</th>
            <th width="30%">Status</th>
            <th class="text-right">Valor</th>
            <th class="text-right">Desconto</th>
            <th class="text-right">Valor Pago</th>
            <th>Data da Compra</th>
            <th>Confirmação</th>

        </tr>
        </thead>
        <tbody>

        @foreach ($orders as $order)
            <tr class="{!! $order->status == null ? "" : ($order->status->id === 2 || $order->status->id === 1 ? "warning" : ($order->status->id === 4 ? "success" : ($order->status->id === 5 ? "danger" : ""))) !!}">
                <td>{!! $order->id !!}</td>
                <td><strong class="label label-{!! $order->status == null ? "" : ($order->status->id === 2 || $order->status->id === 1 ? "warning" : ($order->status->id === 4 ? "success" : ($order->status->id === 5 ? "danger" : ""))) !!}">{!! $order->status == null ? "" : $order->status->name !!}</strong></td>
                <td class="text-right">R$ {!! number_format($order->price , 2, ',', '.' ) !!}</td>
                <td class="text-right">R$ {!! number_format($order->price - $order->discount_price , 2, ',', '.' ) !!}</td>
                <td class="text-right">R$ {!! number_format($order->discount_price , 2, ',', '.' ) !!}</td>
                <td>{!! format_datetimebr($order->date_registration) . ' (' . diff_time( $order->date_registration ) . ')'!!}</td>
                <td>{!! $order->date_confirmation != null ? format_datetimebr($order->date_confirmation ). ' (' . diff_time( $order->date_confirmation ) . ')' : '' !!}</td>

            </tr>
            @foreach($order->courses as $course)

                <tr class="active">
                    <td></td>
                    <td>{!! $course->course != null ? $course->course->title : ""!!}</td>
                    <td colspan="2" class="text-right">&nbsp;</td>
                    <td class="text-right">R$ {!! number_format($course->discount_price, 2, ',', '.' ) !!}</td>
                    <td colspan="2" class="text-right">
                        @if (($course->discount_price == 0.00) && (access()->hasPermission('order_external_payment')))
                            <a href="{{ route('admin.userstudents.course_external_payment', $course->id)  }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="{{ trans('crud.edit_button') }}"></i></a>
                        @else
                            @if (($course->justification_external_payment != null) && ($course->justification_external_payment != ''))
                                {{ $course->justification_external_payment  }}
                            @else
                                &nbsp;
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            @foreach($order->packages as $package)

                <tr class="active">
                    <td></td>
                    <td>{!! $package->package != null ? $package->package->title : ""!!}</td>
                    <td colspan="2" class="text-right">&nbsp;</td>
                    <td class="text-right">R$ {!! number_format($package->discount_price, 2, ',', '.' ) !!}</td>
                    <td colspan="2" class="text-right">&nbsp;</td>
                </tr>
            @endforeach
        @endforeach

        </tbody>
    </table>
    @endif

    <div class="clearfix"></div>
@stop