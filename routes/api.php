<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Laravue\Faker;
use \App\Laravue\JsonResponse;
use \App\Laravue\Acl;

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

Route::namespace('Api')->group(function() {
    Route::post('auth/login', 'AuthController@login');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Auth routes
        Route::get('auth/user', 'AuthController@user');
        Route::post('auth/logout', 'AuthController@logout');

        Route::get('/user', function (Request $request) {
            return new UserResource($request->user());
        });

        // Api resource routes
        Route::apiResource('roles', 'RoleController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::apiResource('users', 'UserController')->middleware('permission:' . Acl::PERMISSION_USER_MANAGE);
        Route::apiResource('permissions', 'PermissionController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);

        // Custom routes
        Route::put('users/{user}', 'UserController@update');
        Route::get('users/{user}/permissions', 'UserController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::put('users/{user}/permissions', 'UserController@updatePermissions')->middleware('permission:' .Acl::PERMISSION_PERMISSION_MANAGE);
        Route::get('roles/{role}/permissions', 'RoleController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
    });
});

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

Route::apiResource('accounts', 'Accounting\Banking\AccountController');
Route::get('countcontracts', 'Accounting\Income\ContractController@countcontracts');

Route::apiResource('articles', 'Cms\ArticleController');
// Route::get('articles/show/{article}', 'Cms\ArticleContorller@show')->name('categories.show');
Route::get('countarticles', 'Cms\ArticleController@countarticles');

// All api requests to categories need "manage category" permission
Route::apiResource('categories', 'Settings\CategoryController')->middleware('permission:manage category');
// Listing category will require "view category" or "manage category"
Route::get('categories', 'Settings\CategoryController@index')->name('categories.index')->middleware('permission:view category|manage category');
Route::get('currencycategories', 'Settings\CategoryController@currencycategories');
Route::get('medicationcategories', 'Settings\CategoryController@medicationcategories');
Route::get('petcategories', 'Settings\CategoryController@petcategories');
Route::get('revenuecategories', 'Settings\CategoryController@revenuecategories');
Route::get('vaccinecategories', 'Settings\CategoryController@vaccinecategories');

Route::apiResource('contracts', 'Accounting\Income\ContractController');

// All api requests to leads need "manage lead" permission
Route::apiResource('leads', 'Crm\LeadController')->middleware('permission:manage lead');
// Listing lead will require "view lead" or "manage lead"
Route::get('leads', 'Crm\LeadController@index')->name('leads.index')->middleware('permission:view lead|manage lead');
Route::get('countleads', 'Crm\LeadController@countleads');

// All api requests to medication need "manage medication" permission
Route::apiResource('medications', 'Crm\MedicationController');
Route::get('medications', 'Crm\MedicationController@medications')->name('medications.list');

// All api requests to pets need "manage pet" permission
Route::apiResource('pets', 'Crm\PetController')->middleware('permission:manage pet');
// Listing pet will require "view pet" or "manage pet"
Route::get('pets', 'Crm\PetController@index')->name('pets.index')->middleware('permission:view pet|manage pet');
Route::get('countpets', 'Crm\PetController@countpets');

// All api requests to leads need "manage post" permission
Route::apiResource('posts', 'Cms\PostController');

// All api requests to settings need "manage setting" permission
Route::apiResource('settings', 'Settings\SettingController');

// All api requests to vaccines need "manage vaccine" permission
Route::apiResource('vaccines', 'Crm\VaccineController');
// Listing pet will require "view pet" or "manage pet"
Route::get('vaccines', 'Crm\VaccineController@vaccines')->name('vaccines.list');
