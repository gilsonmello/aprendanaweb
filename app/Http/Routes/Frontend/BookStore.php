<?php

/**
 * Frontend Controllers
 */
Route::group(['prefix' => 'livraria'],function() {
    
    get('/', ['as' => 'bookstore.index', 'uses' => 'BookStoreController@index']);
/*
    post('/carrinho/adicionar', ['as' => 'publicsector.cart.add', 'uses' => 'PublicSectorController@cartAdd']);
    get('/carrinho/remover', ['as' => 'publicsector.cart.remove', 'uses' => 'PublicSectorController@cartRemove']);
    get('/carrinho', ['as' => 'publicsector.cart', 'uses' => 'PublicSectorController@cartItems']);
    get('/carrinho/contato', ['as' => 'publicsector.cart.contact', 'uses' => 'PublicSectorController@cartContact']);
    post('/carrinho/enviar', ['as' => 'publicsector.cart.sendproposal', 'uses' => 'PublicSectorController@cartSend']);

    get('/cursos', ['as' => 'publicsector.courses', 'uses' => 'PublicSectorController@courses']);
    get('/curso/{slug}', ['as' => 'publicsector.course', 'uses' => 'PublicSectorController@course']);

    get('/professores', ['as' => 'publicsector.teachers', 'uses' => 'PublicSectorController@courses']);
*/
});


