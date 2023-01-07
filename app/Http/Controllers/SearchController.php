<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Generate;
use App\Models\Surat;
use App\Models\Template;
use App\Models\Jenis;
use App\Models\User;
use App\Models\Catatan;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Keperluan;
use App\Models\Disposisi;
use App\Models\PihakTTD;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use \Illuminate\Support\Facades\Auth;
use FrosyaLabs\Lang\IdDateFormatter;

class SearchController extends Controller
{
    //
    public function index(){
        $nav = 'transaksi';
        $menu = 'search';
        return view('search.index', compact('nav', 'menu'));
    }

    public function search(Request $request){
        $user = Auth::user();
        if($request->ajax()){

            //SEARCH SURAT MASUK
            $surat_masuk = '';
            $search = $request->get('query');
                if($user->isAdmin()){
                    $suratMasuk = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    // ->where('surat.status', '!=', 0)
                    ->where('disposisi_user.kategori_id', 1)
                    ->where('disposisi_user.user_id', Auth::user()->id)
                    ->where(function($query) use($search){
                        $query->where('surat.judul', 'like' , '%'. $search .'%')
                            ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                            ->orwhereYear('surat.tanggal', $search)
                            ->orwhere('surat.keperluan', 'LIKE','%'.$search.'%')
                            ->orwhere('jenis.nama', 'LIKE','%'.$search.'%');
                        })
                    ->select('surat.*')
                    ->distinct()->latest()->get();
                }else{
                    $suratMasuk = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 1)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->where(function($query) use($search){
                            $query->where('surat.judul', 'like' , '%'. $search .'%')
                                ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                                ->orwhereYear('surat.tanggal', $search)
                                ->orwhere('surat.keperluan', 'LIKE','%'.$search.'%')
                                ->orwhere('jenis.nama', 'LIKE','%'.$search.'%');
                            })
                        ->select('surat.*')
                        ->distinct()->latest()->get();
                }

            $total_row_masuk = $suratMasuk->count();
            if($total_row_masuk > 0){
                foreach($suratMasuk as $row){
                    $surat_masuk .= '
                        <tr>
                            <td>'.$row->jenis->nama.'</td>
                            <td>'.$row->nosurat.'</td>
                            <td>'.$row->judul.'</td>
                            <td>'.IdDateFormatter::format($row->tanggal, IdDateFormatter::COMPLETE).'</td>
                            <td>'.$row->keperluan.'</td>
                            <td><a href="'.route('show.surat.masuk', $row).'" class="btn btn-info" title="Lihat detail"><i class="fa fa-eye"></i> Detail</a></td>
                        </tr>';
                }
            }else{
                $surat_masuk =
                    '<tr>
                        <td align="center" colspan="5">Data tidak ditemukan.</td>
                    </tr>';
            }

            //SEARCH SURAT KELUAR
            $surat_keluar = '';
            // $search = $request->get('query');
            if($user->isAdmin()){
                $suratKeluar = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('generate', 'surat.id', '=', 'generate.surat_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    // ->where('surat.status', '!=', 0)
                    ->where('disposisi_user.kategori_id', 2)
                    ->where('disposisi_user.user_id', Auth::user()->id)
                    ->where(function($query) use($search){
                        $query->where('surat.judul', 'like' , '%'. $search .'%')
                            ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                            ->orwhereYear('surat.tanggal', $search)
                            ->orwhere('surat.keperluan', 'LIKE','%'.$search.'%')
                            ->orwhere('jenis.nama', 'LIKE','%'.$search.'%')
                            ->orwhere('generate.content', 'LIKE','%'.$search.'%')
                            ->orwhere('generate.tempat', 'LIKE','%'.$search.'%')
                            ->orwhere('generate.footer_content', 'LIKE','%'.$search.'%');
                        })
                    ->select('surat.*')
                    ->distinct()->latest()->get();
            }else{
                $suratKeluar = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('generate', 'surat.id', '=', 'generate.surat_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('surat.status', '!=', 0)
                    ->where('disposisi_user.kategori_id', 2)
                    ->where('disposisi_user.user_id', Auth::user()->id)
                    ->where(function($query) use($search){
                        $query->where('surat.judul', 'like' , '%'. $search .'%')
                            ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                            ->orwhereYear('surat.tanggal', $search)
                            ->orwhere('surat.keperluan', 'LIKE','%'.$search.'%')
                            ->orwhere('jenis.nama', 'LIKE','%'.$search.'%')
                            ->orwhere('generate.content', 'LIKE','%'.$search.'%')
                            ->orwhere('generate.tempat', 'LIKE','%'.$search.'%')
                            ->orwhere('generate.footer_content', 'LIKE','%'.$search.'%');
                        })
                    ->select('surat.*')
                    ->distinct()->latest()->get();
            }

            $total_row_keluar = $suratKeluar->count();
            if($total_row_keluar > 0){
                foreach($suratKeluar as $row){
                    $surat_keluar .= '
                        <tr>
                            <td>'.$row->jenis->nama.'</td>
                            <td>'.$row->nosurat.'</td>
                            <td>'.$row->judul.'</td>
                            <td>'.IdDateFormatter::format($row->tanggal, IdDateFormatter::COMPLETE).'</td>
                            <td>'.$row->keperluan.'</td>
                            <td><a href="'.route('show.surat.keluar', $row).'" class="btn btn-info" title="Lihat detail"><i class="fa fa-eye"></i> Detail</a></td>
                        </tr>';
                }
            }else{
                $surat_keluar =
                    '<tr>
                        <td align="center" colspan="5">Data tidak ditemukan.</td>
                    </tr>';
            }

            //SEARCH DISPOSISI SURAT MASUK
            $disposisi_surat_masuk = '';
                if($user->isAdmin()){
                    $disposisiSuratMasuk = Disposisi::join('surat', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        // ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 1)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->where(function($query) use($search){
                            $query->where('surat.judul', 'like' , '%'. $search .'%')
                                ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                                ->orwhereYear('surat.tanggal', $search)
                                ->orwhere('surat.keperluan', 'LIKE','%'.$search.'%')
                                ->orwhere('jenis.nama', 'LIKE','%'.$search.'%')
                                ->orwhere('disposisi.perihal', 'LIKE','%'.$search.'%')
                                ->orwhereYear('disposisi.tanggal', $search)
                                ->orwhere('disposisi.isi', 'LIKE','%'.$search.'%');
                            })
                        ->select('disposisi.*')
                        ->distinct()->latest()
                        ->get();
                }else{
                    $disposisiSuratMasuk = Disposisi::join('surat', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 1)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->where(function($query) use($search){
                            $query->where('surat.judul', 'like' , '%'. $search .'%')
                                ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                                ->orwhereYear('surat.tanggal', $search)
                                ->orwhere('surat.keperluan', 'LIKE','%'.$search.'%')
                                ->orwhere('jenis.nama', 'LIKE','%'.$search.'%')
                                ->orwhere('disposisi.perihal', 'LIKE','%'.$search.'%')
                                ->orwhereYear('disposisi.tanggal', $search)
                                ->orwhere('disposisi.isi', 'LIKE','%'.$search.'%');
                            })
                        ->select('disposisi.*')
                        ->distinct()->latest()->get();
                }

                $total_row_disposisimasuk = $disposisiSuratMasuk->count();
                if($total_row_disposisimasuk > 0){
                    foreach($disposisiSuratMasuk as $row){
                        $disposisi_surat_masuk .= '
                            <tr>
                                <td>'.$row->surat->nosurat.'</td>
                                <td>'.$row->surat->judul.'</td>
                                <td>'.$row->perihal.'</td>
                                <td>'.IdDateFormatter::format($row->tanggal, IdDateFormatter::COMPLETE).'</td>
                                <td>'.$row->isi.'</td>
                                <td><a href="'.route('index.disposisi', $row->surat_id).'" class="btn btn-info" title="Lihat detail"><i class="fa fa-eye"></i> Detail</a></td>
                            </tr>';
                    }
                }else{
                    $disposisi_surat_masuk =
                        '<tr>
                            <td align="center" colspan="5">Data tidak ditemukan.</td>
                        </tr>';
                }

            //SEARCH DISPOSISI SURAT KELUAR
            $disposisi_surat_keluar = '';
                if($user->isAdmin()){
                    $disposisiSuratKeluar = Disposisi::join('surat', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        // ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 2)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->where(function($query) use($search){
                            $query->where('surat.judul', 'like' , '%'. $search .'%')
                                ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                                ->orwhereYear('surat.tanggal', $search)
                                ->orwhere('surat.keperluan', 'LIKE','%'.$search.'%')
                                ->orwhere('jenis.nama', 'LIKE','%'.$search.'%')
                                ->orwhere('generate.content', 'LIKE','%'.$search.'%')
                                ->orwhere('generate.tempat', 'LIKE','%'.$search.'%')
                                ->orwhere('generate.footer_content', 'LIKE','%'.$search.'%')
                                ->orwhere('disposisi.perihal', 'LIKE','%'.$search.'%')
                                ->orwhereYear('disposisi.tanggal', $search)
                                ->orwhere('disposisi.isi', 'LIKE','%'.$search.'%');
                            })
                        ->select('disposisi.*')
                        ->distinct()->latest()
                        ->get();
                }else{
                    $disposisiSuratKeluar = Disposisi::join('surat', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 2)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->where(function($query) use($search){
                            $query->where('surat.judul', 'like' , '%'. $search .'%')
                                ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                                ->orwhereYear('surat.tanggal', $search)
                                ->orwhere('surat.keperluan', 'LIKE','%'.$search.'%')
                                ->orwhere('jenis.nama', 'LIKE','%'.$search.'%')
                                ->orwhere('generate.content', 'LIKE','%'.$search.'%')
                                ->orwhere('generate.tempat', 'LIKE','%'.$search.'%')
                                ->orwhere('generate.footer_content', 'LIKE','%'.$search.'%')
                                ->orwhere('disposisi.perihal', 'LIKE','%'.$search.'%')
                                ->orwhereYear('disposisi.tanggal', $search)
                                ->orwhere('disposisi.isi', 'LIKE','%'.$search.'%');
                            })
                        ->select('disposisi.*')
                        ->distinct()->latest()->get();
                }

                $total_row_disposisikeluar = $disposisiSuratKeluar->count();
                if($total_row_disposisikeluar > 0){
                    foreach($disposisiSuratKeluar as $row){
                        $disposisi_surat_keluar .= '
                            <tr>
                                <td>'.$row->surat->nosurat.'</td>
                                <td>'.$row->surat->judul.'</td>
                                <td>'.$row->perihal.'</td>
                                <td>'.IdDateFormatter::format($row->tanggal, IdDateFormatter::COMPLETE).'</td>
                                <td>'.$row->isi.'</td>
                                <td><a href="'.route('index.disposisi', $row->surat_id).'" class="btn btn-info" title="Lihat detail"><i class="fa fa-eye"></i> Detail</a></td>
                            </tr>';
                    }
                }else{
                    $disposisi_surat_keluar =
                        '<tr>
                            <td align="center" colspan="5">Data tidak ditemukan.</td>
                        </tr>';
                }

            //Output ke view
            $data = array(
                'table_data_suratMasuk'  => $surat_masuk,
                'table_data_suratKeluar'  => $surat_keluar,
                'table_data_disposisiMasuk'  => $disposisi_surat_masuk,
                'table_data_disposisiKeluar'  => $disposisi_surat_keluar,
                'data_suratMasuk' => $total_row_masuk,
                'data_suratKeluar' => $total_row_keluar,
                'data_disposisiSuratMasuk' => $total_row_disposisimasuk,
                'data_disposisiSuratKeluar' => $total_row_disposisikeluar,
               );
            echo json_encode($data);
        }
    }
}
