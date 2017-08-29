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
                                    <h1>Pedido realizado com sucesso.</h1>
                                    <h2 class="title-bj " style="margin:0;">O Número do Seu Pedido é: <div class="text-bold"># {{ str_pad(session('order_id_in_session'), 6, '0', STR_PAD_LEFT) }}</div></h2>                                    
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
                    </div>
                    <div class="text-left mr-lg" style="color: #AA0000">
                        <h4><p>O curso estará disponível para acesso em até 3 dias úteis após a identificação do pagamento.</p>
                            <p>Seu boleto tem validade de 03 dias úteis. Após este prazo é necessário entrar em contato com a equipe do Brasil Jurídico para emissão da segunda via do boleto através do email: atendimento@brasiljuridico.com.br.</p>
                        </h4>
                    </div>
                    
                    <div class="text-right mr-lg">
                        <!-- <a href="carrinho-print.html" target="_blank" class="btn btn-default ml-sm"><i class="fa fa-print"></i> Imprimir</a> -->
                        @if(session('compliance.cart') === TRUE)
                            <a id="" href="http://compliancenet.com.br" class="btn btn-primary" style="background-color: #00A65A !important" target="_blank">Voltar </a>
                        @endif
                        <a id="billet-print-button" href="{{ $form->url_boleto }}" class="btn btn-primary" style="background-color: #00A65A !important" target="_blank">Imprimir Boleto</a>
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


        console.log(items);
        console.log(transaction);

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