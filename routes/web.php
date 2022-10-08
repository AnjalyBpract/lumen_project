<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api','middleware'=>'auth'], function () use ($router) {
    $router->post('/refresh', 'UserController@refresh');


});

$router->post('/logout', 'UserController@logout');

$router->post('/register','UserController@register');
$router->post('sendEmail', 'MailController@sendEmail');
// $router->post('sendPasswordResetLink', 'PasswordResetRequestController@sendEmail');
// $router->post('resetPassword', 'ChangePasswordController@passwordResetProcess');


// $router->get('/forgot-password', function () {
//     return view('auth.forgot-password');
// })->middleware('guest')->name('password.request');

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });
 // $router->get('/user', function(){
    //     return 'hii';
    // });
    $router->post('forgot-password', 'NewPasswordController@forgotPassword');
