<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DekanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\WarekController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UserAdminController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::middleware('userAkses:admin')->group(function () {
        Route::get('/admin', [UserAdminController::class, 'index']);
        Route::get('/admin/user', [UserAdminController::class, 'user']);
        Route::get('/admin/course', [UserAdminController::class, 'course']);
        Route::get('/admin/user/tambah', [UserAdminController::class, 'create']);
        Route::post('/admin/user/tambah', [UserAdminController::class, 'store']);
        Route::get('/admin/user/{nidn}/edit', [UserAdminController::class, 'edit']);
        Route::get('/admin/study/{id}/edit', [UserAdminController::class, 'editStudy']);
        Route::put('/admin/user/{nidn}', [UserAdminController::class, 'update']);
        Route::put('/admin/study/{id}', [UserAdminController::class, 'updateStudy']);
        Route::delete('/admin/user/{nidn}', [UserAdminController::class, 'destroy'])->name('users.destroy');
        Route::delete('/admin/study/{id}', [UserAdminController::class, 'destroyStudy'])->name('study.destroy');
    });

    Route::middleware('userAkses:warek')->group(function () {
        Route::get('/warek', [AdminController::class, 'warek']);
        Route::get('/nilai/warek/{warek}', [WarekController::class, 'nilai']);
        Route::get('/graduate/warek/{warek}', [WarekController::class, 'caseGraduate']);
        Route::get('/krs/warek/{warek}', [WarekController::class, 'krs']);
        Route::get('/warek/get-fakultas-table/{fakultas}', [WarekController::class, 'getFakultasTable']);
    });

    Route::middleware('userAkses:dekan')->group(function () {
        Route::get('/dekan', [AdminController::class, 'dekan']);
        Route::get('/dekan/ipk', [WarekController::class, 'ipk']);
        Route::get('/dekan/filter/ipk', [WarekController::class, 'filterIpk'])->name('filter.ipk');
        Route::get('/graduate/dekan/{fakultas}', [DekanController::class, 'caseFakultas']);
        Route::get('/nilai/dekan/{fakultas}', [DekanController::class, 'nilaiDekan']);
        Route::get('/krs/dekan/{fakultas}', [DekanController::class, 'KRSDekan']);
        Route::get('/nilai/{fakultas}/get-prodi-table/{prodi}', [DekanController::class, 'getProdiTable']);
    });

    Route::middleware('userAkses:kaprodi')->group(function () {
        Route::get('/kaprodi', [AdminController::class, 'kaprodi']);
        Route::get('/nilai/kaprodi/{prodi}', [ProdiController::class, 'case']);
        Route::get('/graduate/kaprodi/{prodi}', [ProdiController::class, 'caseProdi']);
    });

    Route::get('/logout', [SesiController::class, 'logout']);
});


Route::get('/home', function () {
    return redirect('/admin');
});

Route::get('/404', [AdminController::class, 'index']);
