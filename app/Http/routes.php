<?php

/**
 * The Home page
 */

Route::get('/', 'PagesController@home');


/**
 * Authentication
 */

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
