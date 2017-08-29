<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['faqs'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('faqs', 'FaqController', ['except' => ['show']]);

});