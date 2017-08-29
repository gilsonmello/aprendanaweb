<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['subsections'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('subsections', 'SubsectionController', array('except' => array('show')));

});