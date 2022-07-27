<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Surat;
use App\Models\User;
use App\Models\Catatan;
use App\Models\Disposisiuser;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Support\Facades\DB;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Surat $surat)
    {
        //
        switch($surat->jenis->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
            break;
        }
        $nav = 'transaksi';
        $data = Disposisi::join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.disposisi_id', '=', 'users.id')
                    ->where('surat_id', $surat->id)
                    ->where('disposisi_user.user_id', Auth::user()->id)
                    ->get(['disposisi.*']);
        $user = Auth::user();
        return view('disposisi.index', compact('nav','menu','data','surat', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Surat $surat)
    {
        //
        switch($surat->jenis->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
            break;
        }
        $nav = 'transaksi';
        $user = User::all();
        return view('disposisi.insert', compact('nav', 'menu', 'surat', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Surat $surat)
    {
        //
        $request->validate([
            'perihal' => 'required',
            'tanggal' => 'required|date',
            'isi' => 'required'
        ]);

        $disposisi = new Disposisi();
        $disposisi->surat_id = $surat->id;
        $disposisi->perihal = $request->perihal;
        $disposisi->tanggal = $request->tanggal;
        $disposisi->isi = $request->isi;
        $disposisi->save();

        //input data pembuat
        $disposisi_pembuat = new Disposisiuser();
        $disposisi_pembuat->disposisi_id = $disposisi->id;
        $disposisi_pembuat->user_id = $request->pembuat;
        $disposisi_pembuat->status = 1;
        $disposisi_pembuat->save();

        //input data tang di tujukan
        foreach($request->disposisi as $dis_user){
            $disposisi_user = new Disposisiuser();
            $disposisi_user->disposisi_id = $disposisi->id;
            $disposisi_user->user_id = $dis_user;
            $disposisi_user->status = 2;
            $disposisi_user->save();
        }

        if($disposisi){
            $catatan = new Catatan();
            $catatan->surat_id = $surat->id;
            $catatan->user_id = Auth::user()->id;
            switch($surat->jenis->kategori_id){
                case(1):
                    if($request->catatan == null){
                        $catatan->catatan = 'Menambah disposisi surat masuk dengan nomor '.$surat->nosurat;
                    }else{
                        $catatan->catatan = 'Menambah disposisi surat masuk dengan nomor ' . $surat->nosurat . ', ('.$request->catatan.').';
                    }
                    break;
                case(2):
                    if($request->catatan == null){
                        $catatan->catatan = 'Menambah disposisi surat keluar dengan nomor '.$surat->nosurat;
                    }else{
                        $catatan->catatan = 'Menambah disposisi surat keluar dengan nomor ' . $surat->nosurat . ', ('.$request->catatan.').';
                    }
                break;
            }
            $catatan->waktu = Carbon::now();
            $catatan->save();
        }

        if($disposisi){
            return redirect()->route('index.surat.masuk')->with('success', 'Data berhasil di tambah !!');
        }else{
            return back()->with('error', 'Data gagal di Tambah !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function show(Disposisi $disposisi)
    {
        //
        $status_dosen = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('dosen', 'dosen.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi->id)
                ->get();
        $status_mahasiswa = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('mahasiswa', 'mahasiswa.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi->id)
                ->get();
        $surat = Surat::findOrFail($disposisi->surat_id);
        switch($surat->jenis->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
            break;
        }
        $nav = 'transaksi';
        $user = Auth::user();
        return view('disposisi.show', compact('nav', 'menu', 'surat', 'disposisi', 'user', 'status_dosen', 'status_mahasiswa'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function edit(Disposisi $disposisi)
    {
        //
        switch($disposisi->surat->jenis->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
            break;
        }
        $nav = 'transaksi';
        $user = User::all();
        return view('disposisi.update', compact('nav', 'menu', 'disposisi', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disposisi $disposisi)
    {
        //
        $request->validate([
            'perihal' => 'required',
            'tanggal' => 'required|date',
            'isi' => 'required'
        ]);

        $disposisi->perihal = $request->perihal;
        $disposisi->tanggal = $request->tanggal;
        $disposisi->isi = $request->isi;
        $disposisi->save();

        if($disposisi){
            $catatan = new Catatan();
            $catatan->surat_id = $disposisi->surat->id;
            $catatan->user_id = Auth::user()->id;
            switch($disposisi->surat->jenis->kategori_id){
                case(1):
                    if($request->catatan == null){
                        $catatan->catatan = 'Mengubah disposisi surat masuk dengan nomor '.$disposisi->surat->nosurat;
                    }else{
                        $catatan->catatan = 'Mengubah disposisi surat masuk dengan nomor ' .$disposisi->surat->nosurat. ', ('.$request->catatan.').';
                    }
                    break;
                case(2):
                    if($request->catatan == null){
                        $catatan->catatan = 'Mengubah disposisi surat keluar dengan nomor '.$disposisi->surat->nosurat;
                    }else{
                        $catatan->catatan = 'Mengubah disposisi surat keluar dengan nomor ' .$disposisi->surat->nosurat. ', ('.$request->catatan.').';
                    }
                break;
            }
            $catatan->waktu = Carbon::now();
            $catatan->save();
        }

        if($disposisi){
            return redirect()->route('index.disposisi', $disposisi->surat)->with('success', 'Data berhasil di ubah !!');
        }else{
            return back()->with('error', 'Data gagal di Tambah !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disposisi $disposisi)
    {
        dd($disposisi);
    }

    public function create_reply(Disposisi $disposisi){
        $status_dosen = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('dosen', 'dosen.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi->id)
                ->get();
        $status_mahasiswa = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('mahasiswa', 'mahasiswa.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi->id)
                ->get();
        $surat = Surat::findOrFail($disposisi->surat_id);
        switch($disposisi->surat->jenis->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
            break;
        }
        $nav = 'transaksi';
        $user = Auth::user();
        return view('disposisi.replySM', compact('nav', 'menu', 'surat', 'disposisi', 'user', 'status_dosen', 'status_mahasiswa'));
    }

    public function store_reply(Request $request, Disposisi $disposisi){
        $surat = Surat::findOrFail($disposisi->surat_id);
        $update_status = DB::table('disposisi_user')
                        ->where('disposisi_id', $disposisi->id)
                        ->where('user_id', Auth::user()->id)
                        ->update([
                            'status' => 5
                        ]);

        $catatan = new Catatan();
        $catatan->user_id = Auth::user()->id;
        $catatan->surat_id = $disposisi->surat_id;
        $catatan->catatan = 'Balas data surat masuk nomor '. $surat->nosurat. ', ( Catatan balas :'. $request->catatan. ').';
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        $catatan->save();

        if($catatan){
            return redirect()->route('show.disposisi', $disposisi)->with('success', 'Tanggapan surat berhasil, akan dilakukan proses selanjutnya !!');
        }else{
            return back()->with('error', 'Tanggapan surat gagal dikirim !!');
        }

    }

    public function store_read(Disposisi $disposisi){

        $update_status = DB::table('disposisi_user')
                        ->where('disposisi_id', $disposisi->id)
                        ->where('user_id', Auth::user()->id)
                        ->update([
                            'status' => 3
                        ]);
        if($update_status){
            return redirect()->route('show.disposisi', $disposisi)->with('succes', 'TTanggapan surat berhasil, akan dilakukan proses selanjutnya !!');
        }else{
            return back()->with('error', 'Tanggapan surat gagal dikirim !!');
        }
    }

    public function store_continue(Disposisi $disposisi){
        $update_status = DB::table('disposisi_user')
                        ->where('disposisi_id', $disposisi->id)
                        ->where('user_id', Auth::user()->id)
                        ->update([
                            'status' => 4
                        ]);
        if($update_status){
            return redirect()->route('show.disposisi', $disposisi)->with('succes', 'TTanggapan surat berhasil, akan dilakukan proses selanjutnya !!');
        }else{
            return back()->with('error', 'Tanggapan surat gagal dikirim !!');
        }

    }
}
