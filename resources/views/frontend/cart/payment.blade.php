@extends('frontend.layouts.master')

@section('title')
Pagamento | {{app_name()}}
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
                    <li class="active"><a>
                            <h4 class="list-group-item-heading">3</h4>
                            <p class="list-group-item-text">Pagamento</p>
                        </a></li>
                    <li class="disabled"><a>
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
                                    <h2 class="title-bj " style="margin:0;">Informações<BR>de Compra</h2>
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
                                            <span class="text-dark">Data de Compra:</span>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td class="text-semibold text-dark">{{ $item->name }}</td>
                                        <td class="text-right">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
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
                                            <tr class="h4">
                                                <td colspan="2">Total</td>
                                                <td class="text-right">R$ {{ number_format($items->total, 2, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mr-lg">
                        @if($checkout_code !== false)<a href="#" id="open-pagseguro" class="btn btn-success">Pagar via PagSeguro</a>@endif
                        @if($checkout_code === false)<a href="{{ route('cart.conclusion') }}" class="btn btn-success">Finalizar pedido</a>@endif
                    </div>
                </div>
            </section>
        </section>
    </div>
</section>

@endsection

@section('after-scripts-end')
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>

<script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>





<script>
$(document).ready(function () {
    $("#open-pagseguro").click(function () {

        checkoutCode = '{{ $checkout_code }}';
        PagSeguroLightbox({
            code: checkoutCode
        }, {
            success: function (transactionCode) {
                window.location.replace('/carrinho/conclusao');
                //console.log("success - " + transactionCode);
            },
            abort: function () {
                //   alert("abort");
            }
        });

        return false;
    });
});
</script>

<script>
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
    fbq('track', "InitiateCheckout");
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1576695232624762&ev=PageView&noscript=1"/></noscript>

@stop

