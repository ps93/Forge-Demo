<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/security/authenticate','SnapReviewController@login');
Route::get('/security/recoverPassword','SnapReviewController@recover');
Route::post('user','SnapReviewController@create');
Route::get('user/{id?}', 'SnapReviewController@userById');
Route::get('/business/search/findAllSortedByRanking', 'SnapReviewController@sortByRanking');
Route::get('/business/{id?}/reviews', 'SnapReviewController@getReviews');
Route::get('me','SnapReviewController@me');






//Route::get('security/authenticate/','SnapReviewController@prova');
