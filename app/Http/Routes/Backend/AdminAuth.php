<?php

Route::group(['namespace' => 'AdminAuth'], function () {
	Route::group(['middleware' => 'auth'], function () {
		get('auth/logout', 'AdminAuthController@getLogout');
		get('auth/password/change', 'PasswordController@getChangePassword');
		post('auth/password/change', ['as' => 'password.change', 'uses' => 'PasswordController@postChangePassword']);
	});

	Route::group(['middleware' => 'guest'], function () {
		get('auth/login/{provider}', ['as' => 'auth.provider', 'uses' => 'AdminAuthController@loginThirdParty']);
		get('account/confirm/{token}', ['as' => 'account.confirm', 'uses' => 'AdminAuthController@confirmAccount']);
		get('account/confirm/resend/{user_id}', ['as' => 'account.confirm.resend', 'uses' => 'AdminAuthController@resendConfirmationEmail']);

		Route::controller('auth', 'AdminAuthController');
		Route::controller('password', 'PasswordController');
	});
});