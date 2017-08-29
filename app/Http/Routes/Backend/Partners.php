<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['partners'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('partners', 'PartnerController', ['except' => ['show']]);

});

