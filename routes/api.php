<?php

use Illuminate\Http\Request;
use \App\Laravue\Faker;
use \App\Laravue\JsonResponse;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function () {
    Route::post('auth/login', 'Auth\AuthController@login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('auth/user', 'Auth\AuthController@user');
        Route::post('auth/logout', 'Auth\AuthController@logout');
    });

    Route::apiResource('users', 'Auth\UserController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_USER_MANAGE);
    Route::get('users/{user}/permissions', 'Auth\UserController@permissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    Route::put('users/{user}/permissions', 'Auth\UserController@updatePermissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    Route::apiResource('roles', 'Auth\RoleController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    Route::get('roles/{role}/permissions', 'Auth\RoleController@permissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    Route::apiResource('permissions', 'Auth\PermissionController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);

    /*
    Route::get('/articles', function () {
        $rowsNumber = 10;
        $data = [];
        for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
            $row = [
                'id' => mt_rand(100, 10000),
                'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
                'title' => Faker::randomString(mt_rand(20, 50)),
                'author' => Faker::randomString(mt_rand(5, 10)),
                'comment_disabled' => Faker::randomBoolean(),
                'content' => Faker::randomString(mt_rand(100, 300)),
                'content_short' => Faker::randomString(mt_rand(30, 50)),
                'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
                'forecast' => mt_rand(100, 9999) / 100,
                'image_uri' => 'https://via.placeholder.com/400x300',
                'importance' => mt_rand(1, 3),
                'pageviews' => mt_rand(10000, 999999),
                'reviewer' => Faker::randomString(mt_rand(5, 10)),
                'timestamp' => Faker::randomDateTime()->getTimestamp(),
                'type' => Faker::randomInArray(['US', 'VI', 'JA']),

            ];

            $data[] = $row;
        }

        return response()->json(new JsonResponse(['items' => $data, 'total' => mt_rand(1000, 10000)]));
    });

    Route::get('articles/{id}', function ($id) {
        $article = [
            'id' => $id,
            'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
            'title' => Faker::randomString(mt_rand(20, 50)),
            'author' => Faker::randomString(mt_rand(5, 10)),
            'comment_disabled' => Faker::randomBoolean(),
            'content' => Faker::randomString(mt_rand(100, 300)),
            'content_short' => Faker::randomString(mt_rand(30, 50)),
            'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
            'forecast' => mt_rand(100, 9999) / 100,
            'image_uri' => 'https://via.placeholder.com/400x300',
            'importance' => mt_rand(1, 3),
            'pageviews' => mt_rand(10000, 999999),
            'reviewer' => Faker::randomString(mt_rand(5, 10)),
            'timestamp' => Faker::randomDateTime()->getTimestamp(),
            'type' => Faker::randomInArray(['US', 'VI', 'JA']),

        ];

        return response()->json(new JsonResponse($article));
    });

    Route::get('articles/{id}/pageviews', function ($id) {
        $pageviews = [
            'PC' => mt_rand(10000, 999999),
            'Mobile' => mt_rand(10000, 999999),
            'iOS' => mt_rand(10000, 999999),
            'android' => mt_rand(10000, 999999),
        ];
        $data = [];
        foreach ($pageviews as $device => $pageview) {
            $data[] = [
                'key' => $device,
                'pv' => $pageview,
            ];
        }

        return response()->json(new JsonResponse(['pvData' => $data]));
    });
    */

    Route::apiResource('articles', 'Cms\ArticleController');
    Route::get('countarticles', 'Cms\ArticleController@countarticles');

    // All api requests to categories need "manage category" permission
    Route::apiResource('categories', 'Settings\CategoryController')->middleware('permission:manage category');
    // Listing category will require "view category" or "manage category"
    Route::get('categories', 'Settings\CategoryController@index')->name('categories.index')->middleware('permission:view category|manage category');
    Route::get('currenciecategories', 'Settings\CategoryController@currencycategories');
    Route::get('medicationcategories', 'Settings\CategoryController@medicationcategories');
    Route::get('petcategories', 'Settings\CategoryController@petcategories');
    Route::get('vaccinecategories', 'Settings\CategoryController@vaccinecategories');

    // All api requests to leads need "manage lead" permission
    Route::apiResource('leads', 'Crm\LeadController')->middleware('permission:manage lead');
    // Listing lead will require "view lead" or "manage lead"
    Route::get('leads', 'Crm\LeadController@index')->name('leads.index')->middleware('permission:view lead|manage lead');
    Route::get('countleads', 'Crm\LeadController@countleads');

    // All api requests to medication need "manage medication" permission
    Route::apiResource('medication', 'Crm\MedicationController');
    Route::get('medications', 'Crm\MedicationController@medications')->name('medications.list');

    // All api requests to pets need "manage pet" permission
    Route::apiResource('pets', 'Crm\PetController')->middleware('permission:manage pet');
    // Listing pet will require "view pet" or "manage pet"
    Route::get('pets', 'Crm\PetController@index')->name('pets.index')->middleware('permission:view pet|manage pet');
    Route::get('countpets', 'Crm\PetController@countpets');

    // All api requests to leads need "manage post" permission
    Route::apiResource('posts', 'Cms\PostController');

    // All api requests to vaccines need "manage vaccine" permission
    Route::apiResource('vaccines', 'Crm\VaccineController');
    // Listing pet will require "view pet" or "manage pet"
    Route::get('vaccines', 'Crm\VaccineController@vaccines')->name('vaccines.list');

    // Fake APIs
    Route::get('/table/list', function () {
        $rowsNumber = mt_rand(20, 30);
        $data = [];
        for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
            $row = [
                'author' => Faker::randomString(mt_rand(5, 10)),
                'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
                'id' => mt_rand(100000, 100000000),
                'pageviews' => mt_rand(100, 10000),
                'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
                'title' => Faker::randomString(mt_rand(20, 50)),
            ];

            $data[] = $row;
        }

        return response()->json(new JsonResponse(['items' => $data]));
    });

    Route::get('/orders', function () {
        $rowsNumber = 8;
        $data = [];
        for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
            $row = [
                'order_no' => 'LARAVUE' . mt_rand(1000000, 9999999),
                'price' => mt_rand(10000, 999999),
                'status' => Faker::randomInArray(['success', 'pending']),
            ];

            $data[] = $row;
        }

        return response()->json(new JsonResponse(['items' => $data]));
    });

});
