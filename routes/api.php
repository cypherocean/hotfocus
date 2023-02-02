<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'namespace' => 'API'], function () {
    Route::controller(AuthController::class)
        ->group(function () {
            Route::post('signup', 'signup');
            Route::post('login', 'login');
            Route::post('social_auth', 'socialAuth');
            Route::post('forgot_password', 'password_forget');
            Route::post('validate_otp', 'validate_otp');
            Route::post('verify_email', 'verifyEmail');
            Route::post('reset_password', 'reset_password');
        });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', 'AuthController@logout');
        /* Dashboard */
            Route::controller(DashboardController::class)
            ->group(function () {
                Route::post('dashboard', 'dashboard');
                Route::post('discover', 'discover');
            });
        /* Dashboard */

        /* My Profile */
            Route::controller(UsersController::class)
            ->group(function () {
                Route::post('my_profile', 'myProfile');
                Route::post('edit_profile', 'updateProfile');
                Route::post('find_friend', 'findFriend');
                Route::post('get_user_profile', 'getUserProfile');
                Route::post('send_friend_request', 'sendFriendRequest');
                Route::post('get_request_list', 'getRequestList');
                Route::post('change_request_status', 'changeFriendRequestStatus');
                Route::post('get_follower', 'getFollower');
            });
        /* My Profile */
       
        /* My Post */
            Route::controller(PostController::class)
            ->group(function () {
                Route::post('make_post', 'makePost');
                Route::post('get_post', 'getPost');
                Route::post('edit_post', 'editPost');
                Route::post('like_post', 'likePost');
                Route::post('comment_post', 'commentPost');
            });
        /* My Post */
       
        /* Chat */
            Route::controller(ChatController::class)
            ->group(function () {
                Route::get('get_chat', 'getChat');
                Route::post('make_chat', 'makeChat');
            });
        /* Chat */
    });
});

Route::get('/unauthenticated', function () {
    return response()->json(['status' => 201, 'message' => 'Unacuthorized Access']);
})->name('api.unauthenticated');

Route::get("{path}", function () {
    return response()->json(['status' => 500, 'message' => 'Bad request']);
})->where('path', '.+');
