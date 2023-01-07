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
use App\Models\Kode;
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
        // $kode = Kode::all();
        $jenissm = Jenis::all();
        $jenissk = Jenis::all();

        return view('file.index', compact('nav', 'menu', 'jenissm', 'jenissk'));
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
            // $keperluan = $request->get('keperluan_id');
            //SEARCH SURAT MASUK
            $surat_masuk = '';
                if($user->isAdmin()){
                    $suratMasuk = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        // ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 1)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->where(function($query) use($jenis){
                            $query->where('jenis.id', $jenis);

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
                            <td>'.$row->keperluan.'</td>
                            <td><a class="btn btn-primary" href="' .route('download.surat', $row->id). '"><i class="fa fa-download"></i> Download file</a></td>
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
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        // ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 2)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->where(function($query) use($jenis){
                            $query->where('jenis.id', $jenis);
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
                        ->where(function($query) use($jenis){
                            $query->orwhere('jenis.id', $jenis);
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
                            <td>'.$row->keperluan.'</td>
                            <td><a class="btn btn-primary" href="' .route('download.surat', $row->id). '"><i class="fa fa-download"></i> Download file</a></td>
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
    public function store(Request $request, Surat $surat)
    {
        //
        $file_count = Files::where('surat_id', $surat->id)->count();
        // $file
        if($request->hasFile('file')){
            $allowedfileExtension = ['pdf','doc', 'docx'];
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                if($check){
                    $file_name = now()->timestamp . '_' .$surat->judul.'_file'.$file_count++.'.'.$file->getClientOriginalExtension();
                    $file->move('surat/file surat',$file_name);

                    $file = new Files();
                    $file->surat_id = $surat->id;
                    $file->file =  $file_name;
                    $file->save();

                    return redirect()->back()->withInput()->with('success', 'Berhasil mengupload data !!');
                }else{
                    return redirect()->back()->withInput()->with('error', 'Pastikan file yang diupload berformat .doc/.docx/.pdf');
                }
        }else{
            return redirect()->back()->withInput()->with('error', 'Silahkan upload file berformat .doc/.docx/.pdf');
        }
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
    public function update(Request $request, Files $files)
    {
        //
        // dd($files);
        $file_count = Files::where('surat_id', $request->surat_id)->count();
        $surat = Surat::find($request->surat_id);
        if($request->hasFile('file')){
            $allowedfileExtension = ['pdf','doc', 'docx'];
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                if($check){

                    $filelama = public_path('surat/file surat/'.$files->file);
                    File::delete($filelama);

                    $file_name = now()->timestamp . '_' .$surat->judul.'_file'.$file_count++.'.'.$file->getClientOriginalExtension();
                    $file->move('surat/file surat',$file_name);

                    $files->surat_id = $surat->id;
                    $files->file =  $file_name;
                    $files->save();

                    return redirect()->back()->withInput()->with('success', 'Berhasil mengupdate file !!');
                }else{
                    return redirect()->back()->withInput()->with('error', 'Pastikan file yang diupload berformat .doc/.docx/.pdf');
                }
        }else{
            return redirect()->back()->withInput()->with('error', 'Silahkan upload file berformat .doc/.docx/.pdf');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Files $files)
    {
        //
        // dd($files);
        $filelama = public_path('surat/file surat/'.$files->file);
        File::delete($filelama);

        if($files){
            $files->delete();
            return redirect()->back()->withInput()->with('success', 'Berhasil menghapus file !!');
        }else{
            return redirect()->back()->withInput()->with('warning', 'Gagal menghapus file !!');
        }
    }

    public function download(Files $files){
        try {
            return response()->download('surat/file surat/'.$files->file);
        } catch (\Throwable $th) {

            return back()->with('error', 'File tidak ditemukan !!');
        }
    }
}
