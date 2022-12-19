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
use App\Http\Controllers\KeperluanController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FileController;
use App\Models\Generate;
use App\Models\Surat;
use App\Models\Template;
use App\Models\Jenis;
use App\Models\User;
use App\Models\Catatan;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Keperluan;
use App\Models\PihakTTD;
use \Illuminate\Support\Facades\Auth;


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


Route::group(['middleware' => ['auth']], function(){
    // Route::post('/generateNomor', [GenerateController::class, 'generateNomor'])->name('generateNomor');

    Route::get('/dashboard', function(){
        $user = Auth::user();
        $countUser = User::count();
        if($user->isAdmin()){
            $countSuratMasuk = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                                ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                                ->where('kategori_id', 1)
                                ->count();
            $countSuratKeluar = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                                ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                                ->where('kategori_id', 2)
                                ->count();
            $countCatatan = Catatan::count();
        }else{
            $countSuratMasuk = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                                ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                                ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                                ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                                ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                                ->where('surat.status', '!=', 0)
                                ->where('kategori_id', 1)
                                ->where('disposisi_user.user_id', Auth::user()->id)
                                ->count();
            $countSuratKeluar = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                                ->join('generate', 'surat.id', '=', 'generate.surat_id')
                                ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                                ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                                ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                                ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                                ->where('surat.status', '!=', 0)
                                ->where('kategori_id', 2)
                                ->where('disposisi_user.user_id', Auth::user()->id)
                                ->count();
            $countCatatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
                            ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                            ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                            ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                            ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                            ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                            ->where('surat.status', '!=', 0)
                            ->where('kategori_id', 1)
                            ->orwhere('kategori_id', 2)
                            ->where('disposisi_user.user_id', Auth::user()->id)
                            ->count();
        }
        return view('dashboard', array(
            'nav' => 'dashboard',
            'menu' => 'dashboard',
            'user' => $countUser,
            'suratmasuk' => $countSuratMasuk,
            'suratkeluar' => $countSuratKeluar,
            'agenda' => $countCatatan
        ));
    })->name('dashboard');

    Route::prefix('/umum')->group(function(){
        Route::prefix('/jenis')->group(function(){
            Route::get('/', [JenisController::class, 'index'])->name('index.jenis');
            Route::get('/create', [JenisController::class, 'create'])->name('create.jenis')->middleware('checkRole:Admin,Pengelola');
            Route::post('/store', [JenisController::class, 'store'])->name('store.jenis')->middleware('checkRole:Admin,Pengelola');
            Route::get('/edit/{jenis}', [JenisController::class, 'edit'])->name('edit.jenis')->middleware('checkRole:Admin,Pimpinan,Pengelola');
            Route::post('/update/{jenis}', [JenisController::class, 'update'])->name('update.jenis')->middleware('checkRole:Admin,Pimpinan,Pengelola');
            Route::delete('/destroy/{jenis}', [JenisController::class, 'destroy'])->name('destroy.jenis')->middleware('checkRole:Admin,Pengelola');
        });
        Route::prefix('/keperluan')->group(function(){
            Route::get('/', [KeperluanController::class, 'index'])->name('index.keperluan');
            Route::get('/create', [KeperluanController::class, 'create'])->name('create.keperluan')->middleware('checkRole:Admin,Pengelola');
            Route::post('/store', [KeperluanController::class, 'store'])->name('store.keperluan')->middleware('checkRole:Admin,Pengelola');
            Route::get('/edit/{keperluan}', [KeperluanController::class, 'edit'])->name('edit.keperluan')->middleware('checkRole:Admin,Pimpinan,Pengelola');
            Route::post('/update/{keperluan}', [KeperluanController::class, 'update'])->name('update.keperluan')->middleware('checkRole:Admin,Pimpinan,Pengelola');
            Route::delete('/destroy/{keperluan}', [KeperluanController::class, 'destroy'])->name('destroy.keperluan')->middleware('checkRole:Admin,Pengelola');
        });
        Route::prefix('/template')->group(function(){
            Route::get('/', [TemplateController::class, 'index'])->name('index.template');
            Route::get('/create', [TemplateController::class, 'create'])->name('create.template')->middleware('checkRole:Admin,Pengelola');
            Route::post('/store', [TemplateController::class, 'store'])->name('store.template')->middleware('checkRole:Admin,Pengelola');
            Route::get('/edit/{template}', [TemplateController::class, 'edit'])->name('edit.template')->middleware('checkRole:Admin,Pengelola');
            Route::post('/update/{template}', [TemplateController::class, 'update'])->name('update.template')->middleware('checkRole:Admin,Pengelola');
            Route::delete('/destroy/{template}', [TemplateController::class, 'destroy'])->name('destroy.template')->middleware('checkRole:Admin,Pengelola');
            Route::get('/formTestingTemplate/{template}', [TemplateController::class, 'formTestingTemplate'])->name('formtesting.template');
            Route::post('/testingTemplate', [TemplateController::class, 'testingTemplate'])->name('testing.template');
        });
    });
    Route::prefix('/transaksi/surat/masuk')->group(function(){
        Route::get('/', [SuratController::class, 'index'])->name('index.surat.masuk');
        Route::get('/create', [SuratController::class, 'create'])->name('create.surat.masuk')->middleware('checkRole:Admin,Pengelola');
        Route::post('/store', [SuratController::class, 'store'])->name('store.surat.masuk')->middleware('checkRole:Admin,Pengelola');
        Route::get('/edit/{surat}', [SuratController::class, 'edit'])->name('edit.surat.masuk')->middleware('checkRole:Admin,Pimpinan,Pengelola');
        Route::post('/update/{surat}', [SuratController::class, 'update'])->name('update.surat.masuk')->middleware('checkRole:Admin,Pimpinan,Pengelola');
        Route::get('/show/{surat}', [SuratController::class, 'show'])->name('show.surat.masuk');
        Route::delete('/destroy/{surat}', [SuratController::class, 'destroy'])->name('destroy.surat.masuk')->middleware('checkRole:Admin,Pimpinan,Pengelola');
        Route::get('/download/{surat}', [SuratController::class, 'download_file'])->name('download.surat.masuk');
    });
    Route::prefix('/transaksi/surat/keluar')->group(function(){
        Route::get('/', [GenerateController::class, 'index'])->name('index.surat.keluar');
        Route::get('/create/{template}', [GenerateController::class, 'create'])->name('create.surat.keluar')->middleware('checkRole:Admin,Pengelola');
        Route::post('/store', [GenerateController::class, 'store'])->name('store.surat.keluar')->middleware('checkRole:Admin,Pengelola');
        Route::get('/show/{surat}', [GenerateController::class, 'show'])->name('show.surat.keluar');
        Route::get('/edit/{surat}', [GenerateController::class, 'edit'])->name('edit.surat.keluar')->middleware('checkRole:Admin,Pimpinan,Pengelola');
        Route::post('/update/{surat}', [GenerateController::class, 'update'])->name('update.surat.keluar')->middleware('checkRole:Admin,Pimpinan,Pengelola');
        Route::delete('/destroy/{surat}', [GenerateController::class, 'destroy'])->name('destroy.surat.keluar')->middleware('checkRole:Admin,Pimpinan,Pengelola');
        Route::get('/index/template', [GenerateController::class, 'index_template'])->name('index.keluar.template');
        Route::get('/create', [GenerateController::class, 'createInstant'])->name('create.keluar.instant')->middleware('checkRole:Admin,Pengelola');
        Route::get('/download/{surat}/{kode}', [GenerateController::class, 'download_file'])->name('download.surat.keluar');

        //generate nomor sarat
        Route::post('/generateNomor', [GenerateController::class, 'generateNomor'])->name('generateNomor');
    });
    Route::get('/getKeperluan', [GenerateController::class, 'getKeperluan'])->name('getKeperluan');

    Route::prefix('/search/')->group(function(){
        Route::get('/', [SearchController::class, 'index'])->name('index.search');
        Route::get('/data', [SearchController::class, 'search'])->name('search.data');
    });

    Route::prefix('/file')->group(function(){
        Route::get('/', [FileController::class, 'index'])->name('index.file');
        Route::get('/data', [FileController::class, 'filter'])->name('filter.file');
    });

    Route::prefix('/surat/disposisi')->group(function(){
        Route::get('/{surat}', [DisposisiController::class, 'index'])->name('index.disposisi');
        Route::get('/create/{surat}', [DisposisiController::class, 'create'])->name('create.disposisi')->middleware('checkRole:Admin,Pengelola');
        Route::post('/store/{surat}', [DisposisiController::class, 'store'])->name('store.disposisi')->middleware('checkRole:Admin,Pengelola');
        Route::get('/edit/{disposisi}', [DisposisiController::class, 'edit'])->name('edit.disposisi')->middleware('checkRole:Admin,Pengelola');
        Route::post('/update/{disposisi}', [DisposisiController::class, 'update'])->name('update.disposisi')->middleware('checkRole:Admin,Pengelola');
        Route::get('/show/{disposisi}', [DisposisiController::class, 'show'])->name('show.disposisi');
        Route::delete('/destroy/{disposisi}', [DisposisiController::class, 'destroy'])->name('destroy.disposisi')->middleware('checkRole:Admin,Pimpinan,Pengelola');

        Route::get('/create/reply/{disposisi}', [DisposisiController::class, 'create_reply'])->name('create.reply.surat.masuk')->middleware('checkRole:Admin,Pimpinan');
        Route::post('/store/reply/{disposisi}', [DisposisiController::class, 'store_reply'])->name('store.reply.surat.masuk')->middleware('checkRole:Admin,Pimpinan');
        Route::get('/read/{disposisi}', [DisposisiController::class, 'store_read'])->name('read.surat.masuk');
        Route::get('/continue/{disposisi}', [DisposisiController::class, 'store_continue'])->name('continue.surat.masuk');
        Route::get('/TTD/{disposisi}', [DisposisiController::class, 'store_TTD'])->name('ttd.surat.keluar')->middleware('checkRole:Admin,Pimpinan');
    });

    Route::prefix('/agenda')->group(function(){
        Route::prefix('/surat/masuk')->group(function(){
            Route::get('/', [CatatanController::class, 'indexsm'])->name('index.agenda.masuk');
        });
        Route::prefix('/surat/keluar')->group(function(){
            Route::get('/', [CatatanController::class, 'indexsk'])->name('index.agenda.keluar');
        });
    });
});
