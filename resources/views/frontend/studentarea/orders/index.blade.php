@extends('frontend.layouts.master-classroom')

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Meus Pedidos</h2>
    
        <!--div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Meus Pedidos</span></li>              
            </ol>
    
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div-->
    </header>

    <!-- start: page -->
        <section class="panel">
            @if (count($orders) != 0)
            <div class="panel-body">

                    <div class="table-my-historic">
                        <table class="table mb-none">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Status</th>
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
                                    <td class="text-right">R$ {!! number_format($course->discount_price, 2, ',', '.' ) !!}</td>
                                    <td colspan="2" class="text-right">&nbsp;</td>
                                    <td colspan="2" class="text-right">&nbsp;</td>
                                </tr>
                                @endforeach
                                @foreach($order->packages as $package)

                                    <tr class="active">
                                        <td></td>
                                        <td>{!! $package->package != null ? $package->package->title : ""!!}</td>
                                        <td class="text-right">R$ {!! number_format($package->discount_price, 2, ',', '.' ) !!}</td>
                                        <td colspan="2" class="text-right">&nbsp;</td>
                                        <td colspan="2" class="text-right">&nbsp;</td>
                                    </tr>
                                @endforeach
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <h3>Você ainda não adquiriu nenhum curso ou SAAP. <a href="/" style="text-decoration: underline;">Acesse a nossa loja.</a></h3><br/>
            @endif
        </section>
    <!-- end: page -->
</section>
@endsection