<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['faq_category'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('faqcategory', 'FaqCategoryController', ['except' => ['show']]);

});