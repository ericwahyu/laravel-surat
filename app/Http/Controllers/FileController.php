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
use App\Models\PihakTTD;
use App\Models\Format;
use App\Models\Files;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use \Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use \PhpOffice\PhpWord\TemplateProcessor;
use FrosyaLabs\Lang\IdDateFormatter;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nav = 'transaksi';
        $menu = 'file';
        $keperluan = Keperluan::all();
        $jenissm = Jenis::where('kategori_id', 1)->get();
        $jenissk = Jenis::where('kategori_id', 2)->get();

        return view('file.index', compact('nav', 'menu', 'keperluan', 'jenissm', 'jenissk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        //
        $user = Auth::user();
        if($request->ajax()){

            $jenis = $request->get('jenis_id');
            $keperluan = $request->get('keperluan_id');
            //SEARCH SURAT MASUK
            $surat_masuk = '';
                if($user->isAdmin()){
                    $suratMasuk = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                        ->where('kategori_id', 1)
                        ->where(function($query) use($jenis){
                            $query->where('jenis.id', $jenis);

                            })
                        ->select('surat.*')
                        ->distinct()->latest()->get();
                }else{
                    $suratMasuk = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('kategori_id', 1)
                        ->where('users.id', Auth::user()->id)
                        ->where(function($query) use($jenis){
                            $query->where('jenis.id', $jenis);

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
                            <td><span class="badge badge-dark">File tersedia</span></td>
                            <td><a href="' .route('download.surat.masuk', $row). '" class="btn btn-primary" title="Download"><i class="fa fa-download"></i> Download File</a></td>
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
            if($user->isAdmin()){
                $suratKeluar = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        // ->join('keperluan', 'keperluan.id', '=', 'generate.keperluan_id')
                        ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                        // ->where(function($query2) use($keperluan){
                        //     $query2
                        //     // ->join('keperluan', 'keperluan.id', '=', 'generate.keperluan_id')
                        //     // ->where('keperluan.id', $keperluan);

                        //         // -orwhere('jenis.id', $jenis);
                        //     })
                        ->where('kategori_id', 2)
                        ->where(function($query) use($jenis){
                            $query->where('jenis.id', $jenis);
                                // ->where('generate.keperluan_id', $keperluan);
                            })
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }else{
                $suratKeluar = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('keperluan', 'keperluan.id', '=', 'generate.keperluan_id')
                        ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('kategori_id', 2)
                        ->where(function($query) use($jenis){
                            $query->orwhere('jenis.id', $jenis);
                                // ->where('generate.keperluan_id', $keperluan);
                            })
                        ->where(function($query2) use($keperluan){
                            $query2->orwhere('generate.keperluan_id', $keperluan);

                            })
                        ->where('users.id', Auth::user()->id)
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
                            <td>'.$this->cekFile($row->id).'</td>
                            <td> <div class="btn-group">
                            <button type="button" class="btn btn-primary">Download File</button>
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' .route('download.surat.keluar', ['surat' => $row, 'kode' => 1]). '"><i class="fa fa-download"></i> Download file mentahan / file awal upload</a>
                                <a class="dropdown-item" href="' .route('download.surat.keluar', ['surat' => $row, 'kode' => 2]). '"><i class="fa fa-download"></i> Download file upload terbaru</a>
                            </div>
                        </div></td>
                        </tr>';
                }
            }else{
                $surat_keluar =
                    '<tr>
                        <td align="center" colspan="5">Data tidak ditemukan.</td>
                    </tr>';
            }

            $data = array(
                'table_data_suratMasuk'  => $surat_masuk,
                'table_data_suratKeluar'  => $surat_keluar,

                'data_suratMasuk' => $total_row_masuk,
                'data_suratKeluar' => $total_row_keluar,
                // 'id' => $filter,
               );
            echo json_encode($data);
        }
    }
    public function cekFile($surat_id){
        $tag = '';
        $query = Generate::where('surat_id', $surat_id)->get();

        foreach($query as $row){
            if($row->file == null){
                $tag .= '<span class="badge badge-dark">File masih format Awal / Mentahan</span>';

            }else{
                $tag .= ' <span class="badge badge-light">File sudah format Perbaharuan</span>';
            }
        }
        return $tag;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
