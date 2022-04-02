<?php

declare(strict_types=1);

/*
 * Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PluginsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UsersController;
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

Route::put('/v1/action/login', [LoginController::class, 'loginAction']);
Route::put('/v1/action/register', [RegisterController::class, 'registerAction']);

Route::put('/v1/action/profile/update', [ProfileController::class, 'updateAction']);

Route::post('/v1/users', [UsersController::class, 'createAction'])->middleware('permission:create_user');
Route::put('/v1/users/{id}', [UsersController::class, 'updateAction'])->middleware('permission:update_user');
Route::delete('/v1/users/{id}', [UsersController::class, 'deleteAction'])->middleware('permission:delete_user');

Route::put('/v1/plugins/activate/{id}', [PluginsController::class, 'activateAction'])->middleware('permission:activate_plugin');
Route::put('/v1/plugins/deactivate/{id}', [PluginsController::class, 'deactivateAction'])->middleware('permission:deactivate_plugin');
Route::put('/v1/plugins/configure/{id}', [PluginsController::class, 'configureAction'])->middleware('permission:configure_plugin');
Route::delete('/v1/plugins/{id}', [PluginsController::class, 'deleteAction'])->middleware('permission:delete_plugin');

Route::put('/v1/action/settings/update', [SettingsController::class, 'updateAction'])->middleware('permission:update_settings');
