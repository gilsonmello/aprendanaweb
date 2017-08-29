<?php
/**
 * Created by PhpStorm.
 * User: geofrey
 * Date: 22/09/15
 * Time: 16:30
 */

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['coupons'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('coupons', 'CouponController', ['except' => ['show']]);
    get('send/{id}', ['as' => 'admin.coupons.send', 'uses' => 'CouponController@send']);

    get('coupons/import', ['as' => 'admin.coupons.import', 'uses' => 'CouponController@import']);
    get('coupons/importfrompartner', ['as' => 'admin.coupons.importfrompartner', 'uses' => 'CouponController@importFromPartner']);
    get('coupons/generatePdf/{coupon_id}', ['as' => 'admin.coupons.generatePdf', 'uses' => 'CouponController@generatePdf']);


});