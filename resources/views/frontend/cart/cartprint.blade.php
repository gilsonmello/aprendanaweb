@extends('frontend.layouts.print')

@section('content')
    <section class="panel">
        <div class="panel-body">
            <div class="invoice">
                <header class="clearfix">
                    <div class="row">
                        <div class="col-sm-6 mt-md">
                            <h2 class="title-bj " style="margin:0;">Seu Pedido nº</h2>
                            <h4 class="h4 m-none text-dark text-bold">#76598345</h4>
                        </div>
                        <div class="col-sm-6 text-right mt-md mb-md">
                            <div class="ib">
                                <img src="assets/img/logo-brasil-juridico-print.png" alt="Brasil Jurídico Cursos Jurídicos" />
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
                                    Pedro Cordier
                                    <br/>
                                    Acupe de Brotas
                                    <br/>
                                    Telefone: (71) 992937273
                                    <br/>
                                    pedrocordier@gmail.com
                                </address>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bill-data text-right">
                                <p class="mb-none">
                                    <span class="text-dark">Data do Pedido:</span>
                                    <span class="value">16/11/2015</span>
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
                            <th id="cell-price"  class="text-center text-semibold">Preço</th>
                            <th id="cell-qty"    class="text-center text-semibold">Qunatidade</th>
                            <th id="cell-total"  class="text-center text-semibold">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>333333</td>
                            <td class="text-semibold text-dark">DIREITO ADMINISTRATIVO - Deveres e Poderes da Administração Pública</td>
                            <td class="text-center">R$ 150,00</td>
                            <td class="text-center">2</td>
                            <td class="text-center">R$ 300,00</td>
                        </tr>
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
                                    <td class="text-left">R$ 300,00</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Descontos</td>
                                    <td class="text-left">R$ 0,00</td>
                                </tr>
                                <tr class="h4">
                                    <td colspan="2">Total</td>
                                    <td class="text-left">R$300,00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        window.print();
    </script>
@endsection