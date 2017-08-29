<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['newsletters'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('newsletters', 'NewsletterController', ['except' => ['show']]);
    get('newsletters/generate', ['as' => 'admin.newsletters.generate', 'uses' => 'NewsletterController@listNewsletter']);


});