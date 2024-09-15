<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CakadaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TipeCakadaController;
use App\Http\Controllers\RolePermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('mobile.frontend.dashboard.index');
    // return view('mobile2.layouts.app');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Routes with middleware
Route::middleware(['auth'])->group(function () {
    // Route::get('/cakada', [CakadaController::class, 'index'])->middleware('can:cakada read');
    // Route::get('/cakada/create', [CakadaController::class, 'create'])->middleware('can:cakada create')->name('cakada.create');
    // Route::post('/cakada', [CakadaController::class, 'store'])->middleware('can:cakada create');
    // Route::get('/cakada/{id}/edit', [CakadaController::class, 'edit'])->middleware('can:cakada update');
    // Route::put('/cakada/{id}', [CakadaController::class, 'update'])->middleware('can:cakada update');
    // Route::delete('/cakada/{id}', [CakadaController::class, 'destroy'])->middleware('can:cakada delete');

    Route::get('/role-permission', [RolePermissionController::class, 'index'])->middleware('can:role_permission read')->name('role_permission.index');
    Route::post('/roles/store', [RolePermissionController::class, 'storeRole'])->middleware('can:role_permission create')->name('roles.store');
    Route::post('/permissions/store', [RolePermissionController::class, 'storePermission'])->middleware('can:role_permission create')->name('permissions.store');
    Route::post('/roles/assign-permissions', [RolePermissionController::class, 'assignPermissionToRole'])->middleware('can:role_permission update')->name('roles.assign-permissions');

    // Routes for TipeCakada
    Route::get('/tipe-cakada', [TipeCakadaController::class, 'index'])->middleware('can:tipe_cakada read')->name('tipe_cakada.index');
    Route::get('/tipe-cakada/create', [TipeCakadaController::class, 'create'])->middleware('can:tipe_cakada create')->name('tipe_cakada.create');
    Route::post('/tipe-cakada', [TipeCakadaController::class, 'store'])->middleware('can:tipe_cakada create')->name('tipe_cakada.store');;
    Route::get('/tipe-cakada/{id}/edit', [TipeCakadaController::class, 'edit'])->middleware('can:tipe_cakada update')->name('tipe_cakada.update');
    Route::put('/tipe-cakada/{id}', [TipeCakadaController::class, 'update'])->middleware('can:tipe_cakada update')->name('tipe_cakada.update');
    Route::delete('/tipe-cakada/{id}', [TipeCakadaController::class, 'destroy'])->middleware('can:tipe_cakada delete')->name('tipe_cakada.destroy');;;
});

Route::get('/cakada', [CakadaController::class, 'index'])->name('cakada.index');
Route::post('/cakada', [CakadaController::class, 'store'])->name('cakada.store');
Route::put('/cakada/{cakada}', [CakadaController::class, 'update'])->name('cakada.update');
Route::delete('/cakada/{cakada}', [CakadaController::class, 'destroy'])->name('cakada.destroy');



Route::get('/provinces', [LocationController::class, 'getProvinces']);
Route::get('/get-kabupaten/{provinsi_id}', [LocationController::class, 'getKabupaten']);
Route::get('/get-kecamatan/{kabupaten_id}', [LocationController::class, 'getKecamatan']);
Route::get('/get-kelurahan/{kecamatan_id}', [LocationController::class, 'getKelurahan']);


use App\Http\Controllers\KanvasingController;

Route::get('/kanvasing/create', [KanvasingController::class, 'create'])->name('kanvasing.create');
Route::post('/kanvasing', [KanvasingController::class, 'store'])->name('kanvasing.store');
Route::get('/kanvasing', [KanvasingController::class, 'index'])->name('kanvasing.index');
