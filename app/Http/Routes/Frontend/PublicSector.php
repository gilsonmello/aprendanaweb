<?php

/**
 * Frontend Controllers
 */
Route::group(['prefix' => 'gestaopublica'], function() {

    get('/', ['as' => 'publicsector.index', 'uses' => 'PublicSectorController@index']);

    get('/carrinho/adicionar', ['as' => 'publicsector.cart.add', 'uses' => 'PublicSectorController@cartAdd']);
    get('/carrinho/remover', ['as' => 'publicsector.cart.remove', 'uses' => 'PublicSectorController@cartRemove']);
    get('/carrinho/itens', ['as' => 'publicsector.cart', 'uses' => 'PublicSectorController@cartItems']);
    get('/carrinho/contato', ['as' => 'publicsector.cart.contact', 'uses' => 'PublicSectorController@cartContact']);
    post('/carrinho/enviar', ['as' => 'publicsector.cart.sendproposal', 'uses' => 'PublicSectorController@cartSend']);

    get('/cursos', ['as' => 'publicsector.courses', 'uses' => 'PublicSectorController@courses']);
    get('/curso/{slug}', ['as' => 'publicsector.course', 'uses' => 'PublicSectorController@course']);

    get('/professores', ['as' => 'publicsector.teachers', 'uses' => 'PublicSectorController@teachers']);
    get('/professor/{id}', ['as' => 'publicsector.teacher', 'uses' => 'PublicSectorController@teacher']);
    get('/institucional', ['as' => 'publicsector.institutional.index', 'uses' => 'PublicSectorController@institutional']);
    get('/contratacao', ['as' => 'publicsector.institutional.contract', 'uses' => 'PublicSectorController@contract']);
    get('/sobmedida', ['as' => 'publicsector.institutional.ondemand', 'uses' => 'PublicSectorController@ondemand']);
    get('/diferenciais', ['as' => 'publicsector.institutional.advantages', 'uses' => 'PublicSectorController@advantages']);
    get('/certificacao', ['as' => 'publicsector.institutional.certification', 'uses' => 'PublicSectorController@certification']);
    get('/termos-de-uso', ['as' => 'publicsector.institutional.termos-de-uso', 'uses' => 'PublicSectorController@terms']);

    get('/noticias', ['as' => 'publicsector.news', 'uses' => 'PublicSectorController@indexNews']);
    get('/noticias/{slug}', ['as' => 'publicsector.news.show', 'uses' => 'PublicSectorController@showNews']);

    get('/faleconosco', ['as' => 'publicsector.contactus', 'uses' => 'PublicSectorController@ContactUs']);
    post('/faleconosco/send', ['as' => 'publicsector.contactus.send', 'uses' => 'PublicSectorController@send']);

});

