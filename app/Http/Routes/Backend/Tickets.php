<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['tickets'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('tickets', 'TicketController', ['except' => ['show']]);
    post('tickets/message/store', ['as' => 'admin.tickets.message.store', 'uses' => 'TicketController@messageStore']);
    delete('tickets/message/destroy/{id}', ['as' => 'admin.tickets.message.destroy', 'uses' => 'TicketController@messageDestroy']);
    post('tickets/finish', ['as' => 'admin.tickets.finish', 'uses' => 'TicketController@finish']);


});