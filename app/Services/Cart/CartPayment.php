<?php

namespace App\Services\Cart;

use laravel\pagseguro\Platform\Laravel5\PagSeguro;

/**
 * Created by PhpStorm.
 * User: soufraz
 * Date: 1/12/16
 * Time: 5:08 PM
 */
trait CartPayment {

    /**
     * Render pagseguro button payment
     *
     * @param $items
     * @return string
     */
    public function getCheckoutCode($items) {

        $pagseguro_data = array();

        $pagseguro_data['reference'] = $this->orderInSession;
        $pagseguro_data['items'] = array();

        foreach ($items as $item) {
            if ($item->options->discount_price > 0) {
                $pagseguro_data['items'][] = array(
                    'id' => $item->id,
                    'description' => str_limit($item->name, 80),
                    'quantity' => $item->qty,
                    'amount' => number_format($item->options->discount_price, 2, '.', ''),
                    'weight' => null,
                    'shippingCost' => null
                );
            }
        }



        $pagseguro_data['sender'] = array(
            'name' => auth()->user()->name,
            'documents' => [
                [
                    'number' => auth()->user()->personal_id,
                    'type' => 'CPF'
                ]
            ],
            'email' => auth()->user()->email,
            //'email' => 'adhemarfontes@sandbox.pagseguro.com.br',
            'phone' => '(71)562734401',
        );

        $pagseguro_data['shipping'] = array(
            'type' => 1,
            'address' => [
                'postalCode' => '04433130',
                'street' => 'Rua benjamin vieira da silva',
                'number' => '1077',
                'complement' => '',
                'district' => 'Centro',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'BRA',
            ]
        );

        $pagseguro_data['payment'] = array(
            'bank' => [
                'name' => 'bancodobrasil',
            ]
        );


        $pagseguro_data['currency'] = 'BRL';
        //$pagseguro_data['extraAmount'] = number_format(-1 * session('discount'), 2, '.', '');


        /*
         * ATENÇÃO - Se enviar o CPF errado para o PAGSEGURO a script SEND retorna ERRO ( quebrando o sistema )
         * Por isso foi realizada esta validação de CPF neste momento
         */
        if (!validateCPF_helper(auth()->user()->personal_id)) {
            return redirect()->back()
                            ->withFlashDanger('CPF inválido. Favor atualizar o seu cadastro.');
        } else {
            //Caso o CPF esteja correto ele segue o fluxo sem alterações
            $checkout = PagSeguro::checkout()->createFromArray($pagseguro_data);
            $credentials = PagSeguro::credentials()->get();
            $information = $checkout->send($credentials);
            return $information->getCode();
        }
    }

    public function paymentArrayToXml($array) {
        
    }

    public function getCheckoutArray($items, $request) {
        //dd(session('compliance.cart'));

        $pagseguro_data = array();



        $pagseguro_data['email'] = 'adriana@brasiljuridico.com.br';
        $pagseguro_data['token'] = config('laravelpagseguro.credentials.token');

        if (session('compliance.cart') === TRUE) {
            $pagseguro_data['email'] = 'compliancenet@brasiljuridico.com.br';
            $pagseguro_data['token'] = config('laravelpagseguro.compliance.credentials.token');
        }
        $pagseguro_data['senderHash'] = $request['senderHash'];

        $pagseguro_data['reference'] = $this->orderInSession;
        $pagseguro_data['items'] = array();

        $index = 0;
        foreach ($items as $item) {

            if ($item->options->discount_price > 0) {
                $index++;
                $pagseguro_data['itemId' . $index] = $item->id;
                $pagseguro_data['itemDescription' . $index] = str_limit($item->name, 80);
                $pagseguro_data['itemQuantity' . $index] = $item->qty;
                $pagseguro_data['itemAmount' . $index] = number_format($item->options->discount_price, 2, '.', '');
                $pagseguro_data['itemWeight' . $index] = null;
            }
        }


        $pagseguro_data['senderName'] = auth()->user()->name;
        $pagseguro_data['senderEmail'] = auth()->user()->email;

        //$telephone = $this->parsePhone(auth()->user()->cel);
        $pagseguro_data['senderAreaCode'] = 71; //str_replace('(','',explode(')',$telephone)[0]);
        $pagseguro_data['senderPhone'] = 562734401; //str_replace(' ','',explode(')',$telephone)[1]);
        $pagseguro_data['senderCPF'] = str_replace('-', '', str_replace('.', '', auth()->user()->personal_id));



        $pagseguro_data['shippingAddressCountry'] = 'BRA';
        $pagseguro_data['shippingAddressState'] = 'BA'; //$request['state'];
        $pagseguro_data['shippingAddressCity'] = 'Salvador'; // $request['city'];
        $pagseguro_data['shippingAddressDistrict'] = 'Comércio'; //$request['district'];
        $pagseguro_data['shippingAddressNumber'] = '123'; //$request['number'];
        $pagseguro_data['shippingAddressStreet'] = 'Rua Alameda Carrara'; //$request['address'];
        $pagseguro_data['shippingAddressPostalCode'] = str_replace('.', '', str_replace('-', '', auth()->user()->zip));





        $pagseguro_data['paymentMode'] = "default";
        $pagseguro_data['paymentMethod'] = $request["method"];


        $pagseguro_data['currency'] = 'BRL';

        if ($pagseguro_data["paymentMethod"] == "creditCard") {
            $pagseguro_data['noInterestInstallmentQuantity'] = 10;

            /* Dados do cartão de crédito */
            $pagseguro_data['installmentValue'] = number_format($request['installmentAmount'], 2);
            $pagseguro_data['installmentQuantity'] = $request['installments'];
            $pagseguro_data['creditCardHolderName'] = $request['holderName'];
            $pagseguro_data['creditCardHolderBirthDate'] = $request['holderBirthdate'];
            $pagseguro_data['creditCardHolderCPF'] = str_replace('-', '', str_replace('.', '', $request['holderPersonal_id']));
            if ($request['cel'] != "") {
                $pagseguro_data['creditCardHolderAreaCode'] = str_replace('(', '', explode(')', $request['cel'])[0]);
                $pagseguro_data['creditCardHolderPhone'] = str_replace(' ', '', explode(')', $request['cel'])[1]);
            }
            $pagseguro_data['creditCardToken'] = $request['cardToken'];


            $pagseguro_data['billingAddressPostalCode'] = str_replace('.', '', str_replace('-', '', auth()->user()->zip));
            ;
            $pagseguro_data['billingAddressStreet'] = $request['billAddress'];
            $pagseguro_data['billingAddressNumber'] = $request['billNumber'];
            $pagseguro_data['billingAddressDistrict'] = $request['billDistrict'];
            $pagseguro_data['billingAddressCity'] = $request['billCity'];
            $pagseguro_data['billingAddressState'] = $request['billState'];
            $pagseguro_data['billingAddressCountry'] = 'BRA';
        }



        $credentials = PagSeguro::credentials()->get();


        return [$pagseguro_data, count($pagseguro_data)];
    }

    public function parsePhone($telephone) {

        if (preg_match('/^\(\d{2}\)\d{8,9}/', $telephone))
            return $telephone;

        if (preg_match('/^\d{8,9}/', $telephone))
            return '(71)' . $telephone;

        if (preg_match('/^\d{2}\-\d{8,9}/', $telephone)) {
            return '(' . substr($telephone, 0, 2) . ')' . substr($telephone, 3);
        }

        if (preg_match('/^\d{2}\-\d{4,5}\-\d{4}/', $telephone)) {
            $telephone = str_replace('-', "", $telephone);
            return '(' . substr($telephone, 0, 2) . ')' . substr($telephone, 3);
        }
    }

}
