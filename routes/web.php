<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\DisposisiuserController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [LoginController::class, 'index'])->name('index.login');
Route::post('/login', [LoginController::class, 'store'])->name('store.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout.login');

Route::group(['middleware' => ['isAdmin']], function(){
    Route::prefix('/umum')->group(function(){
            Route::prefix('/jenis')->group(function(){
                Route::get('/', [JenisController::class, 'index'])->name('index.jenis');
                Route::get('/create', [JenisController::class, 'create'])->name('create.jenis');
                Route::post('/store', [JenisController::class, 'store'])->name('store.jenis');
                Route::get('/edit/{jenis}', [JenisController::class, 'edit'])->name('edit.jenis');
                Route::post('/update/{jenis}', [JenisController::class, 'update'])->name('update.jenis');
                Route::delete('/destroy/{jenis}', [JenisController::class, 'destroy'])->name('destroy.jenis');
            });
        Route::prefix('/template')->group(function(){
            Route::get('/', [TemplateController::class, 'index'])->name('index.template');
            Route::get('/create', [TemplateController::class, 'create'])->name('create.template');
            Route::post('/store', [TemplateController::class, 'store'])->name('store.template');
            Route::get('/edit/{template}', [TemplateController::class, 'edit'])->name('edit.template');
            Route::post('/update/{template}', [TemplateController::class, 'update'])->name('update.template');
            Route::delete('/destroy/{template}', [TemplateController::class, 'destroy'])->name('destroy.template');
            Route::get('/download/{id}', [TemplateController::class, 'download'])->name('download.template');
        });
    });
});
Route::group(['middleware' => ['isPengelola']], function(){
    Route::prefix('/transaksi/surat/masuk')->group(function(){
        Route::get('/', [SuratController::class, 'index'])->name('index.surat.masuk');
        Route::get('/create', [SuratController::class, 'create'])->name('create.surat.masuk');
        Route::post('/store', [SuratController::class, 'store'])->name('store.surat.masuk');
        Route::get('/edit/{surat}', [SuratController::class, 'edit'])->name('edit.surat.masuk');
        Route::post('/update/{surat}', [SuratController::class, 'update'])->name('update.surat.masuk');
        Route::get('/show/{surat}', [SuratController::class, 'show'])->name('show.surat.masuk');
        Route::delete('/destroy/{surat}', [SuratController::class, 'destroy'])->name('destroy.surat.masuk');
        Route::get('create/reply/{surat}', [SuratController::class, 'create_reply'])->name('create.reply.surat.masuk');
        Route::post('store/reply/{surat}', [SuratController::class, 'store_reply'])->name('store.reply.surat.masuk');
        Route::post('read/reply/{surat}', [SuratController::class, 'read_reply'])->name('read.reply.surat.masuk');
        Route::post('continue/reply/{surat}', [SuratController::class, 'continue_reply'])->name('continue.reply.surat.masuk');
    });
});

Route::prefix('/transaksi/surat/keluar')->group(function(){
    Route::get('/', [GenerateController::class, 'index'])->name('index.surat.keluar');
    Route::get('/create/{template}', [GenerateController::class, 'create'])->name('create.surat.keluar');
    Route::post('/store', [GenerateController::class, 'store'])->name('store.surat.keluar');
    Route::get('/index/template', [GenerateController::class, 'index_template'])->name('index.keluar.template');
});

Route::prefix('/surat/disposisi')->group(function(){
    Route::get('/{surat}', [DisposisiController::class, 'index'])->name('index.disposisi');
    Route::get('/create/{surat}', [DisposisiController::class, 'create'])->name('create.disposisi');
    Route::post('/store/{surat}', [DisposisiController::class, 'store'])->name('store.disposisi');
    Route::get('/edit/{disposisi}', [DisposisiController::class, 'edit'])->name('edit.disposisi');
    Route::post('/update/{disposisi}', [DisposisiController::class, 'update'])->name('update.disposisi');
    });

Route::prefix('/agenda')->group(function(){
    Route::prefix('/surat/masuk')->group(function(){
        Route::get('/', [CatatanController::class, 'indexsm'])->name('index.agenda.masuk');
    });

    Route::prefix('/surat/keluar')->group(function(){
        Route::get('/', [CatatanController::class, 'indexsk'])->name('index.agenda.keluar');
    });
});
