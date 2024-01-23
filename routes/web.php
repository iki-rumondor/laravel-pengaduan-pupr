<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AduanMasyarakatController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\ShareAppController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/masyarakat/buat-aduan', [WelcomeController::class, 'buatAduan'])->name('masyarakat.create.pengaduan');
Route::post('/masyarakat/buat-aduan', [WelcomeController::class, 'storeAduan'])->name('masyarakat.store.pengaduan');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('pengaduan', [PengaduanController::class, 'index'])->name('index.pengaduan');
Route::get('/buat-aduan', [PengaduanController::class, 'buatAduan'])->name('create.pengaduan');
Route::post('/buat-aduan', [PengaduanController::class, 'store'])->name('save.pengaduan');

Route::get('/rekapan-pengaduan', [RekapController::class, 'index'])->name('rekap.pengaduan');

Route::get('/material', [MaterialController::class, 'index'])->name('material.pengaduan');
Route::post('/material', [MaterialController::class, 'addMaterial'])->name('add.material.pengaduan');
Route::post('/material/stok', [MaterialController::class, 'updateStokMaterial'])->name('update.stok.material.pengaduan');
Route::post('/material/delete', [MaterialController::class, 'deleteMaterial'])->name('delete.material.pengaduan');

Route::get('/daftar-admin', [AdminController::class, 'index'])->name('index.admin');
Route::post('/daftar-admin', [AdminController::class, 'store'])->name('add.admin');
Route::post('/daftar-admin/delete/{id}', [AdminController::class, 'delete'])->name('delete.admin');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::post('/profil/update-username', [ProfilController::class, 'updateUsername'])->name('profil.update.username');
Route::post('/profil/update-password', [ProfilController::class, 'updatePassword'])->name('profil.update.password');

Route::get('/aduan-masyarakat', [AduanMasyarakatController::class, 'index'])->name('aduan.masyarakat.index');
Route::get('/aduan-masyarakat/{aduan:id}', [AduanMasyarakatController::class, 'show'])->name('aduan.masyarakat.show');
Route::get('/aduan-masyarakat/create/{aduan:id}', [AduanMasyarakatController::class, 'create'])->name('aduan.masyarakat.create');
Route::get('/aduan-masyarakat/delete/{aduan:id}', [AduanMasyarakatController::class, 'delete'])->name('aduan.masyarakat.delete');
Route::get('/aduan-masyarakat/open-in-google-maps/{latitude}/{longitude}', [AduanMasyarakatController::class, 'openInGoogleMaps'])->name('aduan.masyarakat.open');

Route::get('/share/{provider}', [ShareAppController::class, 'share'])->name('share.app');