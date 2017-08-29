@extends('frontend.layouts.master')

@section('title')
Conclusão | {{app_name()}}
@endsection

@section('content')
<section id="main-content" class="cart-page">
    <div class="container">
        <div class="row form-group">
            <div class="col-xs-12">
                <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                    <li class="disabled"><a>
                            <h4 class="list-group-item-heading">1</h4>
                            <p class="list-group-item-text">Carrinho</p>
                        </a></li>
                    <li class="disabled"><a>
                            <h4 class="list-group-item-heading">2</h4>
                            <p class="list-group-item-text">Identificação</p>
                        </a></li>
                    <li class="disabled"><a>
                            <h4 class="list-group-item-heading">3</h4>
                            <p class="list-group-item-text">Pagamento</p>
                        </a></li>
                    <li class="active"><a>
                            <h4 class="list-group-item-heading">4</h4>
                            <p class="list-group-item-text">Conclusão</p>
                        </a></li>
                </ul>
            </div>
        </div>
        <section id="steps-container">
            <section class="panel">
                <div class="panel-body">
                    <div class="invoice">
                        <header class="clearfix">
                            <div class="row">
                                <div class="col-sm-6 mt-md">
                                    <h2>Parabéns!! Pedido concluido com sucesso.</h2>
                                    <h2 class="title-bj " style="margin:0;">Seu Pedido nº</h2>
                                    <h4 class="h4 m-none text-dark text-bold"># {{ str_pad(session('order_id_in_session'), 6, '0', STR_PAD_LEFT)  }}</h4>
                                </div>
                                <div class="col-sm-6 text-right mt-md mb-md">
                                    <div class="ib">
                                        <img src="{{ URL::asset('img/frontend/logo-brasil-juridico.jpg') }}" height="40" alt="Brasil Jurídico Cursos Jurídicos" />
                                    </div>
                                    <p>
                                    <address class="ib mr-xlg">
                                        Brasil Jurídico Cursos Jurídicos LTDA CNPJ: 20.599.298-0001/05
                                        <br/>
                                        Av. Prof. Magalhães Neto, Ed.Lena Empresarial 1752 - Pituba - CEP: 41810-012 - Salvador, BA
                                    </address>
                                    </p>
                                </div>
                            </div>
                        </header>
                        <div class="bill-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="bill-to">
                                        <address>
                                            {{ auth()->user()->name }} <br/>

                                            @if(auth()->user()->address) {{ auth()->user()->address }} <br/> @endif

                                            @if(auth()->user()->cel) Telefone: {{ auth()->user()->cel }} <br/> @endif

                                            {{ auth()->user()->email }}
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bill-data text-right">
                                        <p class="mb-none">
                                            <span class="text-dark">Data do Pedido:</span>
                                            <span class="value">{{ date('d/m/Y') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table invoice-items">
                                <thead>
                                    <tr class="h4 text-dark">
                                        <th id="cell-id"     class="text-semibold">#</th>
                                        <th id="cell-item"   class="text-semibold">Item</th>
                                        <th id="cell-price"  class="text-right text-semibold">Preço</th>
                                        <th id="cell-qty"    class="text-center text-semibold">Quantidade</th>
                                        <th id="cell-total"  class="text-right text-semibold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td class="text-semibold text-dark">{{ $item->name }}</td>
                                        <td class="text-right">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-right">R$ {{ number_format($item->price * $item->qty, 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="invoice-summary">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-8">
                                    <table class="table h5 text-dark">
                                        <tbody>
                                            <tr class="b-top-none">
                                                <td colspan="2">Subtotal</td>
                                                <td class="text-right">R$ {{ number_format($items->total + $items->discount, 2, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Descontos</td>
                                                <td class="text-right">R$ {{ number_format($items->discount, 2, ',', '.') }}</td>
                                            </tr>

                                            @if($interest !== 0 && $interest !== $items->total && ($interest - $items->total) > 0.05 )
                                            <tr>
                                                <td colspan="2">Juros</td>
                                                <td class="text-right">R$ {{ number_format($interest - $items->total,2,',','.')  }}</td>
                                            </tr>
                                            <tr class="h4">
                                                <td colspan="2">Total</td>
                                                <td class="text-right">R$ {{ number_format($interest, 2, ',', '.') }}</td>
                                            </tr>
                                            @else
                                            <tr class="h4">
                                                <td colspan="2">Total</td>
                                                <td class="text-right">R$ {{ number_format($items->total, 2, ',', '.') }}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mr-lg">
                        <!-- <a href="carrinho-print.html" target="_blank" class="btn btn-default ml-sm"><i class="fa fa-print"></i> Imprimir</a> -->
                        <a href="{{ route('frontend.dashboard') }}" class="btn btn-primary">Área do Aluno</a>
                    </div>
                </div>
            </section>
        </section>
        <div id="googleAnalicts-register" data-order="{{ $ordergoogle }}" data-items="{{ $itemgoogle }}" ></div>
    </div>
</section>
@endsection

@section('after-scripts-end')
<script>
    setTimeout(function () {
        console.log('Enviando para Google Analytcs');
        items = <?=$itemgoogle ?>;
        transaction = <?=$ordergoogle ?>;
        ga('create', 'UA-78805304-1', 'auto', {'name': 'myTracker'});
        ga('myTracker.require', 'ecommerce');
        ga('myTracker.ecommerce:addTransaction', transaction);
       
        for (var i in items) {
            ga('myTracker.ecommerce:addItem', items[i]);
        }
        ga('myTracker.ecommerce:send');
        console.log('google sent');
    }, 2000);

    !function (f, b, e, v, n, t, s) {
        if (f.fbq)
            return;
        n = f.fbq = function () {
            n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq)
            f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window,
            document, 'script', '//connect.facebook.net/en_US/fbevents.js');
    fbq('track', 'Purchase', {value: '{{ $items->total }}', currency: 'RBR'});
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1576695232624762&ev=PageView&noscript=1"/></noscript>
@stop