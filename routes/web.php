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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });


//FRONTEND
$router->group(['prefix'=>'mcgn-fe/v1'], function() use($router){

    $router->post('/submitVolunteer', 'FrontEndController@submitVolunteer');
    $router->get('/fetchCauses', 'FrontEndController@fetchCauses');
    $router->get('/first-3-donations', 'FrontEndController@firstThreeDonations');
    $router->get('/gallery', 'FrontEndController@fetchGallery');
    $router->post('/contact', 'FrontEndController@contactUs');
    $router->get('/cashDonated/{id}', 'FrontEndController@cashDonated');


});


//BACKEND
$router->group(['prefix'=>'mcgn-be/v1'], function() use($router){

    $router->get('/countVolunteers', 'BackEndController@countVolunteers');
    $router->get('/totalCashDonated', 'BackEndController@totalCashDonated');
    $router->get('/fetchVolunteers', 'BackEndController@fetchVolunteers');
    $router->post('/addCause', 'BackEndController@addCause');
    $router->get('/recentCause', 'BackEndController@recentCause');
    $router->post('/addDonor', 'BackEndController@addDonor');
    $router->get('/recentDonor', 'BackEndController@recentDonor');
    $router->get('/deleteRecentDonor', 'BackEndController@deleteRecentDonor');
    $router->get('/getCauseName', 'BackEndController@getCauseName');
    $router->post('/test', 'BackEndController@testt');
    $router->get('/cashDonatedToCause/{id}', 'BackEndController@cashDonatedToCause');
});