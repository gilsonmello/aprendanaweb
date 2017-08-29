<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['partnerorders'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('partnerorders', 'PartnerorderController', ['except' => ['show']]);

});

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['partnerorders'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('partnerorderpayments', 'PartnerorderPaymentController', ['except' => ['show']]);

});