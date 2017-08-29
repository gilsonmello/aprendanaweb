<?php

/**
 * Frontend Controllers
 */
Route::group(['prefix' => 'compliance'],function() {

    get('/', ['as' => 'compliance.index', 'uses' => 'ComplianceController@index']);

    post('/carrinho/adicionar', ['as' => 'compliance.cart.add', 'uses' => 'ComplianceController@cartAdd']);
    get('/carrinho/remover', ['as' => 'compliance.cart.remove', 'uses' => 'ComplianceController@cartRemove']);
    get('/carrinho/itens', ['as' => 'compliance.cart', 'uses' => 'ComplianceController@cartItems']);
    get('/carrinho/contato', ['as' => 'compliance.cart.contact', 'uses' => 'ComplianceController@cartContact']);
    post('/carrinho/enviar', ['as' => 'compliance.cart.sendproposal', 'uses' => 'ComplianceController@cartSend']);

    get('/cursos', ['as' => 'compliance.courses', 'uses' => 'ComplianceController@courses']);
    get('/curso/{slug}', ['as' => 'compliance.course', 'uses' => 'ComplianceController@course']);

    get('/professores', ['as' => 'compliance.teachers', 'uses' => 'ComplianceController@teachers']);
    get('/professor/{id}', ['as' => 'compliance.teacher', 'uses' => 'ComplianceController@teacher']);
    get('/institucional', ['as' => 'compliance.institutional.index', 'uses' => 'ComplianceController@institutional']);
    get('/contratacao', ['as' => 'compliance.institutional.contract', 'uses' => 'ComplianceController@contract']);
    get('/sobmedida', ['as' => 'compliance.institutional.ondemand', 'uses' => 'ComplianceController@ondemand']);
    get('/diferenciais', ['as' => 'compliance.institutional.advantages', 'uses' => 'ComplianceController@advantages']);
    get('/termos-de-uso', ['as' => 'compliance.institutional.termos-de-uso', 'uses' => 'ComplianceController@terms']);

    get('/noticias', ['as' => 'compliance.news', 'uses' => 'ComplianceController@indexNews']);
    get('/noticias/{slug}', ['as' => 'compliance.news.show', 'uses' => 'ComplianceController@showNews']);

    get('/faleconosco', ['as' => 'compliance.contactus', 'uses' => 'ComplianceController@ContactUs']);
});


