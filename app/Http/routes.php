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

// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;


Route::get('/', 'WelcomeController@index');

//user
Route::post('api/user/login' , 'Users\UsersController@UserLogin');
Route::post('api/user/logout' , 'Users\UsersController@UserLogOut');
Route::post('api/user/regis' , 'Users\UsersController@UserRegister');
Route::post('api/user/reset' , 'Users\UsersController@UserResetPass');
Route::post('api/user/pass-update' , 'Users\UsersController@UserUpdatePass');
Route::post('api/user/get_nationality' , 'Users\UsersController@get_nationality');
Route::post('/api/user/get_users' , 'Users\UsersController@get_users');
Route::post('/api/user/update_profile' , 'Users\UsersController@update_profile');


//admin
// --- travel ---
Route::post('api/admin/addTravel' , 'Admin\AdminController@addTravel');
Route::post('api/admin/getTravelType' , 'Admin\AdminController@getTraveType');
Route::post('api/admin/getSeasonType' , 'Admin\AdminController@getSeasonType');
Route::post('api/admin/saveTravel' , 'Admin\AdminController@saveTravel');
Route::post('api/admin/uploadImages' , 'Admin\AdminController@uploadImages');
Route::post('api/admin/gettravel' , 'Admin\AdminController@gettravel');
Route::post('api/admin/deletetravel' , 'Admin\AdminController@deletetravel');
Route::post('api/admin/updatetravel' , 'Admin\AdminController@updatetravel');
Route::post('api/admin/updateTravelAcc' , 'Admin\AdminController@updateTravelAcc');
Route::post('api/admin/updateTravelRes' , 'Admin\AdminController@updateTravelRes');


// --- accommodation ---
Route::post('api/admin/getAccType' , 'Admin\AdminController@getAccType');
Route::post('api/admin/getRoomType' , 'Admin\AdminController@getRoomType');
Route::post('api/admin/saveAcc' , 'Admin\AdminController@saveAcc');
Route::post('api/admin/getAcc' , 'Admin\AdminController@getAcc');
Route::post('api/admin/deleteAcc' , 'Admin\AdminController@deleteAcc');
Route::post('api/admin/updateAcc' , 'Admin\AdminController@updateAcc');
Route::post('api/admin/uploadImageAcc' , 'Admin\AdminController@uploadImageAcc');
Route::post('api/admin/getacc' , 'Admin\AdminController@getacc');
// --- restaurant ---
Route::post('api/admin/getResType' , 'Admin\AdminController@getResType');
Route::post('api/admin/saveRes' , 'Admin\AdminController@saveRes');
Route::post('api/admin/getRes' , 'Admin\AdminController@getRes');
Route::post('api/admin/delteRes' , 'Admin\AdminController@delteRes');
Route::post('api/admin/updateRes' , 'Admin\AdminController@updateRes');
Route::post('api/admin/uploadImages_res' , 'Admin\AdminController@uploadImages_res');
Route::post('api/admin/getres' , 'Admin\AdminController@getres');



//Data
Route::post('/api/travel/getTravel' , 'Overviews\OverviewsController@getTravel');
Route::post('/api/acc/getAcc' , 'Overviews\OverviewsController@getAcc');
Route::post('/api/res/getRes' , 'Overviews\OverviewsController@getRes');




Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);