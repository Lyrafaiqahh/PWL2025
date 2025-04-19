<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+');

// Route untuk login dan logout
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);

    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
        Route::post('/profile/update-photo', [UserController::class, 'updatePhoto'])->name('user.updatePhoto');
        Route::get('/', [UserController::class, 'index']);
        Route::post('/list', [UserController::class, 'list']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::get('/{id}/edit', [UserController::class, 'edit']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
        Route::get('import', [UserController::class, 'import']);
        Route::post('import_ajax', [UserController::class, 'import_ajax']);
        Route::get('export_excel', [UserController::class, 'export_excel']);
        Route::get('export_pdf', [UserController::class, 'export_pdf']);
    });

    Route::middleware(['authorize:ADM'])->prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::post('/list', [LevelController::class, 'list']);
        Route::get('/create', [LevelController::class, 'create']);
        Route::post('/', [LevelController::class, 'store']);
        Route::get('/{id}', [LevelController::class, 'show']);
        Route::get('/{id}/edit', [LevelController::class, 'edit']);
        Route::put('/{id}', [LevelController::class, 'update']);
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        Route::delete('/{id}', [LevelController::class, 'destroy']);
        Route::get('import', [LevelController::class, 'import']);
        Route::post('import_ajax', [LevelController::class, 'import_ajax']);
        Route::get('export_excel', [LevelController::class, 'export_excel']);
        Route::get('export_pdf', [LevelController::class, 'export_pdf']);
    });

    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index']);
        Route::post('/list', [KategoriController::class, 'list']);
        Route::post('/', [KategoriController::class, 'store']);
        Route::get('/{id}', [KategoriController::class, 'show']);
        Route::get('/create_ajax', [KategoriController::class, 'create'])->name('kategori.create_ajax');
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit'])->name('kategori.edit_ajax');
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'destroy'])->name('kategori.delete_ajax');
        Route::put('/{id}', [KategoriController::class, 'update']);
        Route::delete('/{id}', [KategoriController::class, 'destroy']);
        Route::get('import', [KategoriController::class, 'import']);
        Route::post('import_ajax', [KategoriController::class, 'import_ajax']);
        Route::get('export_excel', [KategoriController::class, 'export_excel']);
        Route::get('export_pdf', [KategoriController::class, 'export_pdf']);
    });

    Route::middleware(['authorize:ADM,MNG'])->prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/list', [BarangController::class, 'list']);
        Route::get('/create', [BarangController::class, 'create']);
        Route::post('/', [BarangController::class, 'store']);
        Route::get('/{id}/detail', [BarangController::class, 'show']);
        Route::get('/{id}/edit', [BarangController::class, 'edit']);
        Route::put('/{id}', [BarangController::class, 'update']);
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
        Route::delete('/{id}', [BarangController::class, 'destroy']);
        Route::get('/import', [BarangController::class, 'import']);
        Route::post('/import_ajax', [BarangController::class, 'import_ajax']);
        Route::get('export_excel', [BarangController::class, 'export_excel']);
        Route::get('export_pdf', [BarangController::class, 'export_pdf']);
    });

    Route::middleware(['authorize:ADM,MNG,STF'])->prefix('stok')->group(function () {
        Route::get('/', [StokController::class, 'index']);
        Route::post('/list', [StokController::class, 'list']);
        Route::post('/', [StokController::class, 'store']);
        Route::get('/stok/create_ajax', [StokController::class, 'create'])->name('stok.create_ajax');
        Route::get('/{id}/edit_ajax', [StokController::class, 'edit'])->name('stok.edit_ajax');
        Route::get('/{id}/delete_ajax', [StokController::class, 'destroy'])->name('stok.delete_ajax');
        Route::get('/{id}/show_ajax', [StokController::class, 'show'])->name('stok.show_ajax');
        Route::put('/{id}', [StokController::class, 'update']);
        Route::delete('/{id}', [StokController::class, 'destroy']);
        Route::get('import', [StokController::class, 'import']);
        Route::post('import_ajax', [StokController::class, 'import_ajax']);
        Route::get('export_excel', [StokController::class, 'export_excel']);
        Route::get('export_pdf', [StokController::class, 'export_pdf']);
    });

    Route::middleware(['authorize:ADM,MNG,STF'])->prefix('penjualan')->group(function() {
        Route::get('/',[PenjualanController::class, 'index']);
        Route::post('/list',[PenjualanController::class, 'list']);
        Route::get('/create_ajax',[PenjualanController::class, 'create_ajax']);
        Route::post('/ajax',[PenjualanController::class, 'store_ajax']);
        Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax',[PenjualanController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax',[PenjualanController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax',[PenjualanController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax',[PenjualanController::class, 'delete_ajax']);
        Route::get('/import', [PenjualanController::class, 'import']);
        Route::post('/import_ajax', [PenjualanController::class, 'import_ajax']);
        Route::get('/export_excel', [PenjualanController::class, 'export_excel']);
        Route::get('/export_pdf', [PenjualanController::class, 'export_pdf']);
    });

    Route::middleware(['authorize:ADM,MNG,STF'])->prefix('penjualandetail')->group(function() {
        Route::get('/',[PenjualanDetailController::class, 'index']);
        Route::post('/list',[PenjualanDetailController::class, 'list']);
        Route::get('/create_ajax',[PenjualanDetailController::class, 'create_ajax']);
        Route::post('/ajax',[PenjualanDetailController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax',[PenjualanDetailController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax',[PenjualanDetailController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax',[PenjualanDetailController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax',[PenjualanDetailController::class, 'delete_ajax']);
        Route::get('/import', [PenjualanDetailController::class, 'import']);
        Route::post('/import_ajax', [PenjualanDetailController::class, 'import_ajax']);
        Route::get('/export_excel', [PenjualanDetailController::class, 'export_excel']);
        Route::get('/export_pdf', [PenjualanDetailController::class, 'export_pdf']);
    });

    Route::middleware(['authorize:ADM,MNG'])->prefix('supplier')->group(function() {
        Route::get('/',[SupplierController::class, 'index']);
        Route::post('/list',[SupplierController::class, 'list']);
        Route::get('/create_ajax',[SupplierController::class, 'create_ajax']);
        Route::post('/ajax',[SupplierController::class, 'store_ajax']);
        Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax',[SupplierController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax',[SupplierController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax',[SupplierController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax',[SupplierController::class, 'delete_ajax']);
        Route::get('/import', [SupplierController::class, 'import']);
        Route::post('/import_ajax', [SupplierController::class, 'import_ajax']);
        Route::get('/export_excel', [SupplierController::class, 'export_excel']);
        Route::get('/export_pdf', [SupplierController::class, 'export_pdf']);
    });
});
