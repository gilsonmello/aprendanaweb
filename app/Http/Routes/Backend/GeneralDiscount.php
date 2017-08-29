<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['courses'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    get('generaldiscount/', ['as' => 'admin.generaldiscount.index', 'uses' => 'GeneralDiscountController@index']);
    get('generaldiscount/apply/', ['as' => 'admin.generaldiscount.apply', 'uses' => 'GeneralDiscountController@apply']);


});