<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Kategori;
use App\Models\Disposisi;
use App\Models\Jenis;
use App\Models\Catatan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Files;
use App\Models\Disposisiuser;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use \Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DisposisiController;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = Auth::user();
        if($request->input('tahun')){
            if($user->isAdmin()){
                $surat = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('disposisi_user.kategori_id', 1)
                    ->where('disposisi_user.user_id', Auth::user()->id)
                    ->whereYear('surat.tanggal', $request->tahun)
                    ->select('surat.*')
                    ->distinct()->latest()->get();
            }else{
                $surat = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 1)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->whereYear('surat.tanggal', $request->tahun)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }
        }else{
            if($user->isAdmin()){
                $surat = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        // ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 1)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }else{
                $surat = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 1)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }
        }

        $nav = 'transaksi';
        $menu = 'masuk';

        return view('surat masuk.index', compact('nav', 'menu', 'surat', 'user', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nav = 'transaksi';
        $menu = 'masuk';
        $jenis = Jenis::where('kategori_id', 1)->get();
        $user_dosen = Dosen::join('users', 'dosen.user_id', '=', 'users.id' )->get();
        $user_mahasiswa = Mahasiswa::join('users', 'mahasiswa.user_id', '=', 'users.id' )->get();
        return view('surat masuk.insert', compact('nav', 'menu', 'jenis', 'user_dosen', 'user_mahasiswa'));
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
        // dd($request);
        $request->validate([
            'jenis_id' => 'required',
            'nomor' => 'required',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'file' => 'required|file',
            'keperluan' => 'required',
            'catatan_surat' => 'nullable',
        ]);
        $suratSM = new Surat();
        $suratSM->jenis_id = $request->jenis_id;
        $suratSM->nosurat = $request->nomor;
        $suratSM->judul = $request->judul;
        $suratSM->tanggal = $request->tanggal;
        $suratSM->status = 1;
        $suratSM->keperluan = $request->keperluan;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = now()->timestamp . '_' . $request->judul.'.'.$file->getClientOriginalExtension();
            $file->move('surat/masuk',$file_name);
            $suratSM->file = $file_name;
        }
        if($suratSM){
            $suratSM->save();
            $catatan = new Catatan();
            $catatan->user_id = Auth::user()->id;
            $catatan->surat_id = $suratSM->id;
            if($request->catatan_surat == null){
                $catatan->catatan = 'Menambah data surat pada nomor surat '. $request->nomor;
            }else{
                $catatan->catatan = 'Menambah data surat pada nomor surat '. $request->nomor. ', (catatan : '. $request->catatan_surat. ').';
            }
            $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
            $catatan->save();
        }

        return app('App\Http\Controllers\DisposisiController')->store($request, $suratSM->id);
        // $toDisposisi = (new DisposisiController)->store($request, $suratSM->id);
        // return $toDisposisi;
        // if($catatan){
        //     return redirect()->route('index.disposisi', $suratSM->id)->with('success', 'Data berhasil di tambah !!');
        // }else{
        //     return back()->with('error', 'Data gagal di tambah !!');
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function show(Surat $surat)
    {
        //
        // dd($surat);
        $nav = 'transaksi';
        $menu = 'masuk';
        $user = Auth::user();

        $disposisi = Disposisi::join('disposisi_user', 'disposisi.id', '=', 'disposisi_user.disposisi_id')
            ->where('disposisi.surat_id', $surat->id)
            ->where('disposisi_user.user_id', Auth::user()->id)
            ->where('disposisi_user.status', 2)
            ->where('disposisi_user.kategori_id', 1)
            ->select('disposisi_user.*')->first();

        // dd($disposisi);
        if($disposisi != null){
            $update_read_at = DB::table('disposisi_user')
                // ->where('user_id', Auth::user()->id)
                ->where('disposisi_user.id', $disposisi->id)
                ->update(['read_at' => 1,]);

            $notifikasi = Notifikasi::where('user_id', Auth::user()->id)->get();
            foreach($notifikasi as $update_notifikasi){
                $update = DB::table('notifikasi')
                    ->where('id', $update_notifikasi->id)
                    ->where('disposisi_user_id', $disposisi->id)
                    ->update([
                        'read_at' => 1
                    ]);
            }

        }

        return view('surat masuk.show', compact('nav', 'menu', 'surat', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function edit(Surat $surat)
    {
        //
        $nav = 'transaksi';
        $menu = 'masuk';
        $user = Auth::user();
        $jenis = Jenis::all();
        $file = Files::where('surat_id', $surat->id)->get();
        return view('surat masuk.update', compact('nav', 'menu', 'jenis', 'surat', 'user', 'file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Surat $surat)
    {
        //
        // dd($request->status);
        $request->validate([
            'jenis_id' => 'required',
            'nomor' => 'required',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'keperluan' => 'required',
            'catatan_surat' => 'nullable',
        ]);
        $surat->jenis_id = $request->jenis_id;
        $surat->nosurat = $request->nomor;
        $surat->judul = $request->judul;
        $surat->tanggal = $request->tanggal;
        $surat->keperluan = $request->keperluan;

        if($surat){
            $surat->save();

            $catatan = new Catatan();
            $catatan->user_id = Auth::user()->id;
            $catatan->surat_id = $surat->id;
            if($request->catatan_surat == null){
                $catatan->catatan = 'Mengubah data surat pada nomor surat '. $request->nomor;
            }else{
                $catatan->catatan = 'Mengubah data surat pada nomor surat '. $request->nomor. ', (catatan : '. $request->catatan_surat. ').';
            }
            $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        }

        if($catatan){
            $catatan->save();
            return redirect()->route('show.surat.masuk', $surat)->with('success', 'Berhasil mengupdate data !!');
        }else{
            return back()->with('error', 'Gagal mengupdate data !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surat $surat)
    {
        //
        $surat->status = 0;
        $surat->save();

        $catatan = new Catatan();
        $catatan->user_id = Auth::user()->id;
        $catatan->surat_id = $surat->id;
        $catatan->catatan = 'Menghapus data surat pada nomor '. $surat->nosurat;
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        $catatan->save();

        if($surat){
            return redirect()->route('index.surat.masuk')->with('success', 'Berhasil menghapus data !!');
        }else{
            return back()->with('error', 'Gagal menghapus data !!');
        }

    }

    public function readAtMasuk($surat_id){
        $getReadAt = Surat::join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
            ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
            // ->where('surat.status', '!=', 0)
            ->where('surat.id', $surat_id)
            // ->where('disposisi_user.status', 2)
            ->where('disposisi_user.kategori_id', 1)
            ->where('disposisi_user.user_id', Auth::user()->id)
            ->select('disposisi_user.*')
            ->distinct()->first();
        // dd($getReadAt);
        return $getReadAt;
    }

    public function getReadAtMasuk(){
        $getReadAt = Disposisiuser::where('user_id', Auth::user()->id)
            ->where('status', 2)
            ->where('kategori_id', 1)
            ->get();

        // dd($getReadAt);
        foreach($getReadAt as $read_at){
            if($read_at->read_at == 0){
                return 0;
                break;
            }
        }
        return 1;
    }

}
