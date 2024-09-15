<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CakadaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KanvasingController;
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
    return view('mobile.frontend.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// Routes with middleware
Route::middleware(['auth'])->group(function () {

    Route::get('/role-permission', [RolePermissionController::class, 'index'])->middleware('can:role_permission read')->name('role_permission.index');
    Route::post('/roles/store', [RolePermissionController::class, 'storeRole'])->middleware('can:role_permission create')->name('roles.store');
    Route::post('/permissions/store', [RolePermissionController::class, 'storePermission'])->middleware('can:role_permission create')->name('permissions.store');
    Route::post('/roles/assign-permissions', [RolePermissionController::class, 'assignPermissionToRole'])->middleware('can:role_permission update')->name('roles.assign-permissions');

    // Routes for TipeCakada
    Route::get('/tipe-cakada', [TipeCakadaController::class, 'index'])->middleware('can:tipe_cakada read')->name('tipe_cakada.index');
    Route::get('/tipe-cakada/create', [TipeCakadaController::class, 'create'])->middleware('can:tipe_cakada create')->name('tipe_cakada.create');
    Route::post('/tipe-cakada', [TipeCakadaController::class, 'store'])->middleware('can:tipe_cakada create')->name('tipe_cakada.store');
    Route::get('/tipe-cakada/{id}/edit', [TipeCakadaController::class, 'edit'])->middleware('can:tipe_cakada update')->name('tipe_cakada.update');
    Route::put('/tipe-cakada/{id}', [TipeCakadaController::class, 'update'])->middleware('can:tipe_cakada update')->name('tipe_cakada.update');
    Route::delete('/tipe-cakada/{id}', [TipeCakadaController::class, 'destroy'])->middleware('can:tipe_cakada delete')->name('tipe_cakada.destroy');

    Route::get('/cakada', [CakadaController::class, 'index'])->middleware('can:cakada read')->name('cakada.index');
    Route::post('/cakada', [CakadaController::class, 'store'])->middleware('can:cakada create')->name('cakada.store');
    Route::put('/cakada/{cakada}', [CakadaController::class, 'update'])->middleware('can:cakada update')->name('cakada.update');
    Route::delete('/cakada/{cakada}', [CakadaController::class, 'destroy'])->middleware('can:cakada delete')->name('cakada.destroy');

    Route::get('/kanvasing/create', [KanvasingController::class, 'create'])->middleware('can:kanvasing create')->name('kanvasing.create');
    Route::post('/kanvasing', [KanvasingController::class, 'store'])->middleware('can:kanvasing create')->name('kanvasing.store');
    Route::get('/kanvasing', [KanvasingController::class, 'index'])->middleware('can:kanvasing read')->name('kanvasing.index');
    Route::get('/get-cakada', [KanvasingController::class, 'getCakadaByFilters'])->name('getCakadaByFilters');

});



Route::get('/provinces', [LocationController::class, 'getProvinces']);
Route::get('/get-kabupaten/{provinsi_id}', [LocationController::class, 'getKabupaten']);
Route::get('/get-kecamatan/{kabupaten_id}', [LocationController::class, 'getKecamatan']);
Route::get('/get-kelurahan/{kecamatan_id}', [LocationController::class, 'getKelurahan']);
