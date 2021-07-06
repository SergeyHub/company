<?php

use Illuminate\Http\Request;

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

Route::get('countries/top', 'Geo\CountriesController@top');
Route::get('countries/slug/{slug}', 'Geo\CountriesController@showSlug');
Route::get('geographies/slug/{slug}', 'Options\GeographiesController@showSlug');
Route::apiResource('countries', 'Geo\CountriesController');
Route::apiResource('cities', 'Geo\CitiesController');
Route::get('cities/slug/{slug}', 'Geo\CitiesController@getBySlug');
Route::get('girls/random', 'Girls\GirlsController@randomGirls');
Route::get('girls/pornstar', 'Girls\GirlsController@pornstarGirls');
Route::get('girls/top50', 'Girls\GirlsController@top50Girls');
Route::get('girls/keptWomans', 'Girls\GirlsController@keptWomans');
Route::get('girls/dating', 'Girls\GirlsController@dating');
Route::get('girls/shemales', 'Girls\GirlsController@shemales');
Route::get('girls/vip', 'Girls\GirlsController@vipGirls');
Route::get('girls/travels', 'Girls\GirlsController@travelGirls');
Route::get('girls/videos', 'Girls\GirlsController@videoGirls');
Route::get('girls/reviews', 'Girls\GirlsController@reviewGirls');
Route::get('girls/favourites', 'Girls\GirlsController@favouriteGirls');
Route::get('girls/hidden', 'Girls\GirlsController@hiddenGirls');
Route::apiResource('eyes', 'Options\EyesController');
Route::apiResource('hairs', 'Options\HairsController');
Route::apiResource('nationalities', 'Options\NationalitiesController');
Route::apiResource('languages', 'Options\LanguagesController');
Route::apiResource('geographies', 'Options\GeographiesController');
Route::apiResource('ready-for', 'Options\ReadyForController');
Route::apiResource('i-likes', 'Options\WhatIlikeController');
Route::apiResource('ethnicities', 'Options\EthnicityController');
Route::apiResource('bodies', 'Options\BodyController');
Route::apiResource('body-hairs', 'Options\BodyHairController');
Route::apiResource('orientations', 'Options\OrientationController');
Route::apiResource('contact-methods', 'Options\ContactMethodsController');
Route::apiResource('currencies', 'Options\CurrenciesController');
Route::apiResource('purposes', 'Options\PurposesController');

Route::prefix('girls')->group(function() {
    Route::get('{id}/similar', 'Girls\GirlsController@similarGirls');
});

Route::prefix('client-applications')->group(function() {
    Route::post('/', 'ClientApplications\ClientApplicationController@store');
});

Route::prefix('env')->group(function() {
   Route::get('config', 'Environment\EnvironmentController@getConfig');
});

Route::prefix('auth')->group(function() {
    Route::prefix('password')->group(function() {
       Route::post('/sendResetLink', 'Auth\PasswordResetController@sendResetLink');
       Route::post('/authByResetToken', 'Auth\PasswordResetController@authByResetToken');
       Route::post('/reset', 'Auth\PasswordResetController@passwordReset');
   });
   Route::post('register', 'Auth\AuthController@register');
   Route::post('verify/{token}', 'Auth\AuthController@emailVerify');
   Route::post('verify/send/{id}', 'Auth\AuthController@emailVerifySend');
   Route::post('login', 'Auth\AuthController@login');
   Route::get('me', 'Auth\AuthController@me');
   Route::get('logout', 'Auth\AuthController@logout');
});

Route::middleware('auth:api')->group(function () {
    Route::middleware('admin')->
        get('/client-applications', 'ClientApplications\ClientApplicationController@index');
    Route::middleware('admin')->
        delete('/client-applications/{id}', 'ClientApplications\ClientApplicationController@destroy');

    Route::prefix('profile')->group(function () {
        Route::get('own-girl', 'Profile\ProfileController@ownGirlProfile');
        Route::get('own-girls', 'Profile\ProfileController@ownGirlsProfile');
        Route::get('own-client', 'Profile\ProfileController@ownClientProfile');
        Route::get('own-agency', 'Profile\ProfileController@ownAgencyProfile');
        Route::get('girls', 'Profile\ProfileController@ownedGirls');
    });
    Route::prefix('girls')->group(function () {
        Route::post('{id}/addToHidden', 'Girls\GirlsController@addToHidden');
        Route::post('{id}/removeFromHidden', 'Girls\GirlsController@removeFromHidden');
        Route::post('{id}/bookmark', 'Girls\GirlsController@setBookmark');
        Route::post('storeByGirl', 'Girls\GirlsController@storeByGirl');
        Route::post('{id}/destroy', 'Girls\GirlsController@destroy');
        Route::post('{id}/cover', 'Girls\GirlsController@uploadAvatar');
        Route::post('{id}/photos', 'Girls\GirlsController@uploadPhoto');
        Route::post('{id}/videos', 'Girls\GirlsController@uploadVideo');
        Route::post('{id}/hidden-photos', 'Girls\GirlsController@uploadHiddenPhoto');
        Route::post('{id}/verify', 'Girls\GirlsController@verify');
        Route::post('{id}/unverify', 'Girls\GirlsController@unverify');
        Route::post('{id}/publish', 'Girls\GirlsController@publish');
        Route::post('{id}/publishProfile', 'Girls\GirlsController@publishProfile');
        Route::post('{id}/unpublishProfile', 'Girls\GirlsController@unpublishProfile');
        Route::post('{id}/activate', 'Girls\GirlsController@activate');
        Route::post('{id}/buy', 'Girls\GirlsController@buy');
        Route::post('{id}/removePhoto', 'Girls\GirlsController@removePhoto');
        Route::post('{id}/removeVideo', 'Girls\GirlsController@removeVideo');
        Route::post('{id}/setAvatar', 'Girls\GirlsController@setAvatar');
        Route::post('{id}/verify', 'Girls\GirlsController@verify');
        Route::post('{id}/unverify', 'Girls\GirlsController@unverify');
        Route::post('{id}/documents', 'Girls\GirlsController@uploadDocument');
        Route::post('{id}/addToFavourites', 'Girls\GirlsController@addToFavourites');
        Route::post('{id}/removeFromFavourites', 'Girls\GirlsController@removeFromFavourites');
        Route::post('{id}/vip/getPaymentLink', 'Girls\GirlsController@getVipPaymentLink');
        Route::middleware('admin')
            ->get('all', 'Girls\GirlsController@indexAll');

        Route::middleware('admin')
            ->get('verification', 'Girls\GirlsController@verification');


        Route::middleware('admin')
            ->post('{id}/vip/issue', 'Girls\GirlsController@issueVip');

        Route::middleware('admin')
            ->post('{id}/vip/remove', 'Girls\GirlsController@removeVip');

    });
//    Route::prefix('offers')->group(function() {
//        Route::get('own-offers', 'Offers\OffersController@ownOffers');
//        Route::post('{id}/publish', 'Offers\OffersController@publish');
//        Route::post('{id}/buy', 'Offers\OffersController@buy');
//        Route::middleware('admin')
//            ->get('all', 'Offers\OffersController@indexAll');
//    });
    Route::prefix('messages')->group(function() {
        Route::get('/', 'Messages\MessagesController@index');
        Route::post('/', 'Messages\MessagesController@create');
        Route::get('/listDialog', 'Messages\MessagesController@listDialog');
        Route::get('/unreadCount', 'Messages\MessagesController@unreadCount');
        Route::post('/markAsRead', 'Messages\MessagesController@markAsRead');
    });

    Route::prefix('verify')->group(function() {
        Route::post('/send', 'Verification\PhoneVerificationsController@send');
        Route::post('/verify', 'Verification\PhoneVerificationsController@verify');
    });

    Route::group(['middleware' => 'admin'], function() {
        Route::apiResource('users', 'Users\UsersController');

        Route::post('users/{user}/ban', 'Users\UsersController@banUser');
        Route::post('users/{user}/unban', 'Users\UsersController@unbanUser');

        Route::post('users/{user}/confirmEmail', 'Users\UsersController@confirmEmail');

        Route::post('reviews/{id}/publish', 'Reviews\ReviewsController@publish');
        Route::post('reviews/{id}/unpublish', 'Reviews\ReviewsController@unpublish');
    });

    Route::middleware('admin')
        ->get('/bills/all', 'Bills\BillsController@indexAll');

    Route::middleware('admin')
        ->get('/clients/all', 'Clients\ClientsController@indexAll');

    Route::apiResource('bills', 'Bills\BillsController');
    Route::apiResource('users', 'Users\UsersController');
    Route::prefix('users/{id}/')->group(function() {
        Route::get('notifications', 'Users\NotificationsController@index');
        Route::get('notifications/unread', 'Users\NotificationsController@indexUnread');
        Route::post('notifications/markAsRead', 'Users\NotificationsController@markAsRead');
    });

    Route::apiResource('clients', 'Clients\ClientsController');

    Route::post('/agencies/{id}/uploadAvatar', 'Agencies\AgenciesController@uploadAvatar');
    Route::apiResource('agencies', 'Agencies\AgenciesController');

    Route::resource('tariffs', 'Settings\TariffsController');
    Route::resource('vip-tariffs', 'Settings\VipTariffsController');
    Route::post('subscribe', 'Subscribes\SubscribesController@subscribe');
    Route::post('subscribe/check', 'Subscribes\SubscribesController@check');
});

//Route::resource('offers', 'Offers\OffersController');
Route::resource('girls', 'Girls\GirlsController');
Route::resource('reviews', 'Reviews\ReviewsController');
Route::resource('fake-reports', 'FakeReports\FakeReportsController');
Route::resource('agencies', 'Agencies\AgenciesController');
Route::resource('content', 'Settings\ContentController');

Route::resource('faq', 'Faqs\FaqsController');
