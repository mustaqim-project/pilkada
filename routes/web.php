<?php

use Detection\MobileDetect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CakadaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KanvasingController;
use App\Http\Controllers\ManajementController;
use App\Http\Controllers\TipeCakadaController;
use App\Http\Controllers\RolePermissionController;


Route::get('/', function () {
    $detect = new MobileDetect;

    if ($detect->isMobile() || $detect->isTablet()) {
        return view('mobile.frontend.dashboard.index');
    } else {
        if (Auth::check()) {
            return view('desktop.home-component.partials.dashboard');
        } else {
            return view('desktop.auth.login');
        }
    }
});



Route::get('/dashboard', function () {
    $detect = new MobileDetect;
    if ($detect->isMobile()) {
        return view('mobile.frontend.dashboard.index');
    } elseif ($detect->isTablet()) {
        return view('mobile.frontend.dashboard.index');
    } else {
        return view('desktop.home-component.partials.dashboard');
    }
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
    Route::post('/tipe-cakada', [TipeCakadaController::class, 'store'])->middleware('can:tipe_cakada create')->name('tipe_cakada.store');
    Route::put('/tipe-cakada/{id}', [TipeCakadaController::class, 'update'])->middleware('can:tipe_cakada update')->name('tipe_cakada.update');
    Route::delete('/tipe-cakada/{id}', [TipeCakadaController::class, 'destroy'])->middleware('can:tipe_cakada delete')->name('tipe_cakada.destroy');

    Route::get('/cakada', [CakadaController::class, 'index'])->middleware('can:cakada read')->name('cakada.index');
    Route::post('/cakada', [CakadaController::class, 'store'])->middleware('can:cakada create')->name('cakada.store');
    Route::get('/cakada/{cakada}/edit', [CakadaController::class, 'edit'])->middleware('can:cakada update')->name('cakada.edit');
    Route::put('/cakada/{cakada}', [CakadaController::class, 'update'])->middleware('can:cakada update')->name('cakada.update');
    Route::delete('/cakada/{cakada}', [CakadaController::class, 'destroy'])->middleware('can:cakada delete')->name('cakada.destroy');


    Route::get('/kanvasing/create', [KanvasingController::class, 'create'])->middleware('can:kanvasing create')->name('kanvasing.create');
    Route::post('/kanvasing', [KanvasingController::class, 'store'])->middleware('can:kanvasing create')->name('kanvasing.store');
    Route::get('/kanvasing', [KanvasingController::class, 'index'])->middleware('can:kanvasing read')->name('kanvasing.index');
    Route::get('/get-cakada', [KanvasingController::class, 'getCakadaByFilters'])->name('getCakadaByFilters');



    Route::get('/analisis', [AnalisisController::class, 'index'])->middleware('can:analisis read')->name('analisis.read');

    Route::get('/grafik-suara', [AnalisisController::class, 'grafik_suara'])->middleware('can:analisis read')->name('analisis.grafik-suara');
    Route::get('/get-grafik-suara', [AnalisisController::class, 'get_grafik_suara'])->name('getGrafikSuara');


    Route::get('/segmen-pemilih', [AnalisisController::class, 'segmen_pemilih'])->middleware('can:analisis read')->name('analisis.segmen-pemilih');
    Route::get('/tren-suara', [AnalisisController::class, 'tren_suara'])->middleware('can:analisis read')->name('analisis.tren-suara');
    Route::get('/strength', [AnalisisController::class, 'strength'])->middleware('can:analisis read')->name('analisis.strength');
    Route::get('/weakness', [AnalisisController::class, 'weakness'])->middleware('can:analisis read')->name('analisis.weakness');
    Route::get('/satisfaction', [AnalisisController::class, 'satisfaction'])->middleware('can:analisis read')->name('analisis.satisfaction');





    Route::get('/manajement', [ManajementController::class, 'index'])->middleware('can:manajement read')->name('manajement.read');
});



Route::get('/provinces', [LocationController::class, 'getProvinces']);
Route::get('/get-kabupaten/{provinsi_id}', [LocationController::class, 'getKabupaten']);
Route::get('/get-kecamatan/{kabupaten_id}', [LocationController::class, 'getKecamatan']);
Route::get('/get-kelurahan/{kecamatan_id}', [LocationController::class, 'getKelurahan']);
