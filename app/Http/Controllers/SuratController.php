<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Kategori;
use App\Models\Disposisi;
use App\Models\Jenis;
use App\Models\Catatan;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use \Illuminate\Support\Facades\Auth;

class SuratController extends Controller
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
        $menu = 'masuk';
        $user = Auth::user();
        if($user->isAdmin() == 1){
            $surat = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                    // ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    // ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    // ->join('users', 'disposisi_user.disposisi_id', '=', 'users.id')
                    ->where('surat.status', '!=', 0)
                    ->where('kategori_id', 1)
                    // ->where('disposisi_user.user_id', Auth::user()->id)
                    ->get(['surat.*']);
        }elseif($user->isPimpinan() == 2 || $user->isPengelola() == 3){
            $surat = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.disposisi_id', '=', 'users.id')
                    ->where('surat.status', '!=', 0)
                    ->where('kategori_id', 1)
                    ->where('disposisi_user.user_id', Auth::user()->id)
                    ->get(['surat.*']);
        }
        // dd($surat);
        return view('surat masuk.index', compact('nav', 'menu', 'surat', 'user'));
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
        return view('surat masuk.insert', compact('nav', 'menu', 'jenis'));
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
        $request->validate([
            'jenis_id' => 'required',
            'nomor' => 'required',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'file' => 'required|file',
            'keterangan' => 'required',
            'catatan' => 'nullable',
        ]);
        $suratSM = new Surat();
        $suratSM->jenis_id = $request->jenis_id;
        $suratSM->nosurat = $request->nomor;
        $suratSM->judul = $request->judul;
        $suratSM->tanggal = $request->tanggal;
        $suratSM->status = 1;
        $suratSM->keterangan = $request->keterangan;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = now()->timestamp . '_' . $request->judul.'.'.$file->getClientOriginalExtension();
            $file->move('surat/masuk',$file_name);
            $suratSM->file_surat = $file_name;
        }
        if($suratSM){
            $suratSM->save();

            $catatan = new Catatan();
            $catatan->user_id = Auth::user()->id;
            $catatan->surat_id = $suratSM->id;
            if($request->catatan == null){
                $catatan->catatan = 'Menambah data surat masuk dengan nomor '. $request->nomor;
            }else{
                $catatan->catatan = 'Menambah data surat masuk dengan nomor '. $request->nomor. ', ('. $request->catatan. ').';
            }
            $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
            $catatan->save();
        }

        if($catatan){
            return redirect()->route('index.disposisi', $suratSM->id)->with('success', 'Data berhasil di tambah !!');
        }else{
            return back()->with('error', 'Data gagal di tambah !!');
        }

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
        $jenis = Jenis::where('kategori_id', 1)->get();
        return view('surat masuk.update', compact('nav', 'menu', 'jenis', 'surat'));
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
        $request->validate([
            'jenis_id' => 'required',
            'nomor' => 'required',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'catatan' => 'nullable',
        ]);
        $surat->jenis_id = $request->jenis_id;
        $surat->nosurat = $request->nomor;
        $surat->judul = $request->judul;
        $surat->tanggal = $request->tanggal;
        $surat->status = 1;
        $surat->keterangan = $request->keterangan;
        if($request->hasFile('file')){
            $filelama = public_path('surat/masuk/'.$surat->file_surat);
            File::delete($filelama);
            $file = $request->file('file');
            $file_name = now()->timestamp . '_' . $request->judul.'.'.$file->getClientOriginalExtension();
            $file->move('surat/masuk',$file_name);
            $surat->file_surat = $file_name;
        }
        if($surat){
            $surat->save();

            $catatan = new Catatan();
            $catatan->user_id = Auth::user()->id;
            $catatan->surat_id = $surat->id;
            if($request->catatan == null){
                $catatan->catatan = 'Mengubah data surat masuk nomor '. $request->nomor;
            }else{
                $catatan->catatan = 'Mengubah data surat masuk nomor '. $request->nomor. ', ('. $request->catatan. ').';
            }
            $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        }

        if($catatan){
            $catatan->save();
            return redirect()->route('index.surat.masuk')->with('success', 'Data berhasil di update !!');
        }else{
            return back()->with('error', 'Data gagal di update !!');
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
        if($surat){
            return redirect()->route('index.surat.masuk')->with('success', 'Data berhasil di hapus !!');
        }else{
            return back()->with('error', 'Data gagal di hapus !!');
        }

    }

    public function create_reply(Surat $surat){
        $nav = 'transaksi';
        $menu = 'masuk';
        return view('surat masuk.reply', compact('nav', 'menu', 'surat'));
    }

    public function store_reply(Request $request, Surat $surat){
        $catatan = new Catatan();
        $catatan->user_id = Auth::user()->id;
        $catatan->surat_id = $surat->id;
        $catatan->catatan = 'Balas data surat masuk nomor '. $surat->nosurat. ', ('. $request->catatan. ').';
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        $catatan->save();

        if($catatan){
            return redirect()->route('index.surat.masuk')->with('success', 'Tanggapan surat berhasil, akan dilakukan proses selanjutnya !!');
        }else{
            return back()->with('error', 'Tanggapan surat gagal dikirim !!');
        }

    }

    public function store_read(Surat $surat){

    }

    public function store_continue(Surat $surat){

    }

    public function download_file(Surat $surat){
        if(file_exists(public_path('surat/masuk/'.$surat->file_surat))){
            return response()->download('surat/masuk/'.$surat->file_surat);
        }else{
            return back()->with('error', 'Download gagal');
        }
    }

}
