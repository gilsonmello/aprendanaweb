<?php

/**
 * Frontend Cart Routes
 */
get('carrinho/compra-rapida/{course_id}/{type}', ['as' => 'cart.fast_purchase', 'uses' => 'CartController@fast_purchase']);
get('carrinho/add/{course_id}/{type}', ['as' => 'cart.add', 'uses' => 'CartController@add']);
get('carrinho/itens', ['as' => 'cart.items', 'uses' => 'CartController@items']);
get('carrinho/autenticacao', ['as' => 'cart.auth', 'uses' => 'CartController@auth']);
get('carrinho/pagamento', ['https' => true, 'as' => 'cart.payment', 'uses' => 'CartController@payment']);
get('carrinho/conclusao', ['as' => 'cart.conclusion', 'uses' => 'CartController@conclusion']);
get('carrinho/remove/{id}', ['as' => 'cart.remove', 'uses' => 'CartController@remove']);
get('carrinho/desconto', ['as' => 'cart.discount', 'uses' => 'CartController@discount']);
post('carrinho/desconto-parceiro', ['as' => 'cart.discount-partner', 'uses' => 'CartController@discountPartner']);
get('carrinho/remove-desconto', ['as' => 'cart.remove_discount', 'uses' => 'CartController@remove_discount']);
get('carrinho/completa-cadastro', ['as' => 'cart.complete_profile', 'uses' => 'CartController@complete_profile']);
get('carrinho/saap-80', ['as' => 'cart.buy_saap_80', 'uses' => 'CartController@buySaap80']);

get('carrinho/course-577', ['as' => 'cart.buy_course_577', 'uses' => 'CartController@buyCourse577']);
get('carrinho/course-565', ['as' => 'cart.buy_course_565', 'uses' => 'CartController@buyCourse565']);

get('carrinho/oab-sem-parar', ['as' => 'cart.oab-sem-parar', 'uses' => 'CartController@addOabSemParar']);
post('pagseguro/send', [ 'as' => 'pagseguro.send', 'uses' => 'CartController@directSend']);
post('pagseguro/feedback', ['as' => 'pagseguro.notification', 'uses' => 'CartController@pagseguroFeedback']);
post('carrinho/boleto-emitido', ['as' => 'cart.billet_sent', 'uses' => 'CartController@billet_sent']);
post('carrinho/criar-tentativa-de-registro-no-carrinho', ['as' => 'cart.createAttemptToRegisterOnTheCart', 'uses' => 'CartController@createAttemptToRegisterOnTheCart']);
/*
Route::group(['https'],function() {
});
*/