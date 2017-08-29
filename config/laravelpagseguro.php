<?php

$sandbox = false;
if ($sandbox) {
    $token = 'ED3A2A5992A34665ADA207E55DE33778';
} else {
    $token = 'AC117FA621704A2A80576871DE2F0AE3';
}

return [
    /* DEFINE SE SERÁ UTILIZADO O AMBIENTE DE TESTES */
    'use-sandbox' => $sandbox,
    /*
     * Coloque abaixo as informações do seu cadastro no PagSeguro
     */
    'credentials' => [//INFORME AS CREDENCIAIS PADRÕES DE SUA LOJA, MAS PORDERÁ SER ALTERADA EM RUNTIME
        'email' => 'adriana@brasiljuridico.com.br',
        'token' => $token,
    ],
    /*
     * Informe abaixo o nome / url das rotas de aplicação para notificações
     * e redirecionamento após pagamento
     * Parâmetro: "route-name" para nome de rota laravel ou "fixed" para url fixa (URL completa)
     * Ex. 01: "route-name" => "tela-de-obrigado" (Nome de Rota)
     * Ex. 02: "fixed" => "http://minhaloja.com.br/pagamento/tela-de-obrigado" (URL Fixa)
     *
     * PARA MAIS INFORMAÇÕES VIDE:
     * https://sandbox.pagseguro.uol.com.br/vendedor/configuracoes.html
     */
    'routes' => [
        'redirect' => [
            'route-name' => 'cart.conclusion', // Criar uma rota com este nome
        ],
        'notification' => [
            'callback' => null, // Callable callback to Notification function (notificationInfo) : void {}
            'credential' => 'default', // Callable resolve credential function (notificationCode) : Credentials {}
            'route-name' => 'pagseguro.notification', // Criar uma rota com este nome
        ],
    ],
    /*
     * MOEDA QUE SERÁ UTILIZADA COMO MEIO DE PAGAMENTO
     * Somente BRL é aceito no momento (Real do Brasil)
     * */
    'currency' => [
        'type' => 'BRL'
    ],
    /**
     * Adaptador de Requisições
     */
    'http' => [
        'adapter' => [
            'type' => 'curl',
            'options' => [
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
            //CURLOPT_PROXY => 'http://user:pass@host:port', // PROXY OPTION
            ]
        ],
    ],
    /*
     * ATENÇÃO: Não altere as configurações abaixo
     * */
    'host' => [
        'production' => 'https://ws.pagseguro.uol.com.br',
        'sandbox' => 'https://ws.sandbox.pagseguro.uol.com.br'
    ],
    'url' => [
        'checkout' => '/v2/checkout',
        'transactions' => '/v3/transactions',
        'transactions-notifications' => '/v3/transactions/notifications',
        'transactions-history' => '/v2/transactions',
        'transactions-abandoned' => '/v2/transactions/abandoned',
    ],
    'compliance' => [
        'credentials' => [//INFORME AS CREDENCIAIS PADRÕES DE SUA LOJA, MAS PORDERÁ SER ALTERADA EM RUNTIME
            'email' => 'compliancenet@brasiljuridico.com.br',
            'token' => 'F0E29A82C84C431C92C63B0C70322703',
        ],
        'routes' => [
            'redirect' => [
                'route-name' => 'compliance.cart.conclusion', // Criar uma rota com este nome
            ],
        ],
    ]
];
