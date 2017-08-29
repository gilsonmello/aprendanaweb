@extends ('backend.layouts.master')

@section ('title', trans('menus.reports.coursereport_stats'))

@section('page-header')
    <h1>
        {{ trans('menus.course_stats') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.coursereports.sales', trans('menus.course_stats')) !!}</li>
@stop

@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.coursereports.stats'), 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                <div class="col-md-6">
                    {!! Form::label('f_CourseReportController_date_begin',  trans('strings.date_begin')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::text('f_CourseReportController_date_begin', $coursereportcontrollerdatebegin, ['class' => 'datemask']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::label('f_CourseReportController_date_end',  trans('strings.date_end')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::text('f_CourseReportController_date_end', $coursereportcontrollerdateend, ['class' => 'datemask']  ) !!}
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @if (isset($stats))
        <table class="table table-bordered table-hover" style="width:1000px;">
            <tbody>
            <tr><td width="400" ><strong>Novos Alunos</strong></td><td class="text-right">{!! $stats->students!!}</td><td class="text-right"></td></tr>
            <tr><td width="400" >&nbsp;</td></tr>
            <tr><td width="400" ><strong>Total de pedidos</strong></td><td class="text-right">{!! $stats->total !!}</td><td class="text-right">100 %</td></tr>
            <tr><td style="padding-left: 30px;"><strong>Pré pedidos</strong></td><td class="text-right">{!! $stats->status1 !!}</td><td class="text-right">{!! $stats->total == 0 ? "-" : number_format($stats->status1 / $stats->total * 100, 2, ',', '.' ) !!} %</td></tr>
            <tr><td style="padding-left: 60px;" >Pré pedidos SEM cadastro</td><td class="text-right">{!! $stats->status1WithoutUser !!}</td><td class="text-right">{!! $stats->status1 == 0 ? "-" : number_format($stats->status1WithoutUser / $stats->status1 * 100, 2, ',', '.' ) !!} %</td></tr>
            <tr><td style="padding-left: 60px;" >Pré pedidos COM cadastro</td><td class="text-right">{!! $stats->status1WithUser !!}</td><td class="text-right">{!! $stats->status1 == 0 ? "-" : number_format($stats->status1WithUser / $stats->status1 * 100, 2, ',', '.' ) !!} %</td></tr>
            <tr><td style="padding-left: 30px;" ><strong>Pendente de Pagamento</strong></td><td class="text-right">{!! $stats->status2 !!}</td><td class="text-right">{!! $stats->total == 0 ? "-" : number_format($stats->status2 / $stats->total * 100, 2, ',', '.' ) !!} %</td> <td class="text-right">R$ {!! number_format($stats->status2Money, 2, ',', '.' )  !!}</td> </tr>
            <tr><td style="padding-left: 30px;" ><strong>Liberados</strong></td><td class="text-right">{!! $stats->status4 !!}</td><td class="text-right">{!! $stats->total == 0 ? "-" :number_format($stats->status4 / $stats->total * 100, 2, ',', '.' ) !!} %</td></tr>
            <tr><td style="padding-left: 60px;" >Pagos</td><td class="text-right">{!! $stats->status4Paid + $stats->status4PaidCoupon  !!}</td><td class="text-right">{!! $stats->status4 == 0 ? "-" : number_format(($stats->status4Paid + $stats->status4PaidCoupon) / $stats->status4 * 100, 2, ',', '.' ) !!} %</td>  <td class="text-right">R$ {!! number_format($stats->status4PaidMoney + $stats->status4PaidCouponMoney, 2, ',', '.' )  !!}</td>  </tr>
            <tr><td style="padding-left: 90px;" >Totalmente Pagos</td><td class="text-right">{!! $stats->status4Paid !!}</td><td class="text-right">{!! ($stats->status4Paid + $stats->status4PaidCoupon) == 0 ? "-" : number_format($stats->status4Paid / ($stats->status4Paid + $stats->status4PaidCoupon) * 100, 2, ',', '.' ) !!} %</td> <td class="text-right">R$ {!! number_format($stats->status4PaidMoney , 2, ',', '.' )  !!}</td></tr>
            <tr><td style="padding-left: 90px;" >Parcialmente pagos com cupom</td><td class="text-right">{!! $stats->status4PaidCoupon !!}</td><td class="text-right">{!! ($stats->status4Paid + $stats->status4PaidCoupon) == 0 ? "-" : number_format($stats->status4PaidCoupon / ($stats->status4Paid + $stats->status4PaidCoupon) * 100, 2, ',', '.' ) !!} %</td> <td class="text-right">R$ {!! number_format($stats->status4PaidCouponMoney, 2, ',', '.' )  !!}</td></tr>
            <tr><td style="padding-left: 60px;" >Gratuitos</td><td class="text-right">{!! $stats->status4Free + $stats->status4FreeCoupon  !!}</td><td class="text-right">{!! $stats->status4 == 0 ? "-" : number_format(($stats->status4Free + $stats->status4FreeCoupon)/ $stats->status4 * 100, 2, ',', '.' ) !!} %</td></tr>
            <tr><td style="padding-left: 90px;" >Produtos Gratuitos</td><td class="text-right">{!! $stats->status4Free !!}</td><td class="text-right">{!! ($stats->status4Free + $stats->status4FreeCoupon) == 0 ? "-" : number_format($stats->status4Free / ($stats->status4Free + $stats->status4FreeCoupon) * 100, 2, ',', '.' ) !!} %</td></tr>
            <tr><td style="padding-left: 90px;" >Gratuitos com cupom</td><td class="text-right">{!! $stats->status4FreeCoupon !!}</td><td class="text-right">{!! ($stats->status4Free + $stats->status4FreeCoupon) == 0 ? "-" : number_format($stats->status4FreeCoupon / ($stats->status4Free + $stats->status4FreeCoupon) * 100, 2, ',', '.' ) !!} %</td></tr>
            <tr><td style="padding-left: 30px;" ><strong>Cancelados</strong></td><td class="text-right">{!! $stats->status5 !!}</td><td class="text-right">{!! $stats->total == 0 ? "-" :number_format($stats->status5 / $stats->total * 100, 2, ',', '.' ) !!} %</td> <td class="text-right">R$ {!! number_format($stats->status5Money, 2, ',', '.' )  !!}</td></tr>
            </tbody>
        </table>

        @if ((auth()->user() != null) && (auth()->user()->id == 1))
            {{--<BR>--}}
            {{--<strong>Navegação no carrinho</strong>--}}
            {{--<table class="table table-bordered table-hover" style="width:600px;">--}}
                {{--<tbody>--}}
                    {{--@foreach ($tracks as $track)--}}
                        {{--<tr><td width="400" >{{ $track->path }}</td><td class="text-right">{!! $track->count !!}</td></tr>--}}
                    {{--@endforeach--}}
                {{--</tbody>--}}
            {{--</table>--}}
        @endif

        @if (count($preorders))
            <BR>
            <h2><strong>Abandono de carrinho</strong></h2>
            <table class="table table-striped table-bordered table-hover" style="width:1000px;">
                <tr>
                    <th width="50" >Id Compra</th>
                    <th width="350" >Comprador</th>
                    <th width="150" >Telefone</th>
                    <th width="100" >Data</th>
                    <th class="text-right" width="150" >Valor</th>
                    <th width="50" >Perfil</th>
                    <th width="50" >Pedido</th>
                </tr>
                <tbody>
                @foreach ($preorders as $preorder)
                    @if (count($preorder->student->roles()->get()) == 1)
                    <tr>
                        <td width="50" >{{$preorder->id}} </td>
                        <td width="350" >{{$preorder->student->name}} </td>
                        <td width="200" >{{$preorder->student->cel}} </td>
                        <td width="200" >{{ format_datetimebr( $preorder->date_registration ) }}</td>
                        <td class="text-right" width="200" >{{ number_format($preorder->discount_price , 2, ',', '.' )  }}</td>
                        <td width="50" ><a href="{{route('admin.userstudents.edit', $preorder->student->id)}}" class="btn btn-primary btn-xs">Perfil</a></td>
                        <td width="50" ><a href="{{route('admin.orders.edit', $preorder->id)}}" class="btn btn-primary btn-xs">Pedido</a></td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        @endif

        @if (count($pendings))
            <BR>
            <h2><strong>Boletos pendentes</strong></h2>
            <table class="table table-striped table-bordered table-hover" style="width:1000px;">
                <tr>
                    <th width="50" >Id Compra</th>
                    <th width="350" >Comprador</th>
                    <th width="200" >Telefone</th>
                    <th width="200" >Data</th>
                    <th class="text-right" width="200" >Valor</th>
                    <th width="50" >Perfil</th>
                    <th width="50" >Pedido</th>
                </tr>
                <tbody>
                @foreach ($pendings as $pending)
                    @if (count($pending->student->roles()->get()) == 1)
                        <tr>
                            <td width="50" >{{$pending->id}} </td>
                            <td width="350" >{{$pending->student->name}} </td>
                            <td width="200" >{{$pending->student->cel}} </td>
                            <td width="200" >{{ format_datetimebr( $pending->date_registration ) }}</td>
                            <td class="text-right" width="200" >{{ number_format($pending->discount_price , 2, ',', '.' )  }}</td>
                            <td width="50" ><a href="{{route('admin.userstudents.edit', $pending->student->id)}}" class="btn btn-primary btn-xs">Perfil</a></td>
                            <td width="50" ><a href="{{route('admin.orders.edit', $pending->id)}}" class="btn btn-primary btn-xs">Pedido</a></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        @endif

        @if (count($cancelleds))
            <BR>
            <h2><strong>Cancelados</strong></h2>orders
            <table class="table table-striped table-bordered table-hover" style="width:1000px;">
                <tr>
                    <th width="50" >Id Compra</th>
                    <th width="350" >Comprador</th>
                    <th width="200" >Telefone</th>
                    <th width="200" >Data</th>
                    <th class="text-right" width="200" >Valor</th>
                    <th width="50" >Perfil</th>
                    <th width="50" >Pedido</th>
                </tr>
                <tbody>
                @foreach ($cancelleds as $cancelled)
                    @if (count($cancelled->student->roles()->get()) == 1)
                    <tr>
                        <td width="50" >{{$cancelled->id}} </td>
                        <td width="350" >{{$cancelled->student->name}} </td>
                        <td width="200" >{{$cancelled->student->cel}} </td>
                        <td width="200" >{{ format_datetimebr( $cancelled->date_registration ) }}</td>
                        <td class="text-right" width="200" >{{ number_format($cancelled->discount_price , 2, ',', '.' )  }}</td>
                        <td width="50" ><a href="{{route('admin.userstudents.edit', $cancelled->student->id)}}" class="btn btn-primary btn-xs">Perfil</a></td>
                        <td width="50" ><a href="{{route('admin.orders.edit', $cancelled->id)}}" class="btn btn-primary btn-xs">Pedido</a></td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        @endif


        @if (count($attempts))
            <BR>
            <h2><strong>Tentativa de Cadastro sem sucesso</strong></h2>
            <table class="table table-striped table-bordered table-hover" style="width:1000px;">
                <tr>
                    <th width="50" >Id Compra</th>
                    <th width="350" >Email</th>
                    <th width="100" >Data</th>
                    <th width="50" >Pedido</th>
                </tr>
                <tbody>
                @foreach ($attempts as $attempt)
                    <tr>
                        <td width="50" >{{$attempt->order_id}} </td>
                        <td width="350" >{{$attempt->email}} </td>
                        <td width="200" >{{ format_datetimebr( $attempt->created_at ) }}</td>
                        <td width="100" ><a href="{{route('admin.orders.edit', $attempt->order_id)}}" class="btn btn-primary btn-xs">Pedido</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    @endif

    <div class="clearfix"></div>
@stop