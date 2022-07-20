<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Surat;
use App\Models\User;
use App\Models\Catatan;
use App\Models\Disposisiuser;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

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
        $nav = 'transaksi';
        $menu = 'masuk';
        $data = Disposisi::where('surat_id', $surat->id)->get();
        return view('disposisi.index', compact('nav','menu','data','surat'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Surat $surat)
    {
        //
        $nav = 'transaksi';
        $menu = 'masuk';
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

        $disposisiSM = new Disposisi();
        $disposisiSM->surat_id = $surat->id;
        $disposisiSM->perihal = $request->perihal;
        $disposisiSM->tanggal = $request->tanggal;
        $disposisiSM->isi = $request->isi;
        $disposisiSM->save();

        foreach($request->disposisi as $disposisi){
            $disposisi_user = new Disposisiuser();
            $disposisi_user->disposisi_id = $disposisiSM->id;
            $disposisi_user->user_id = $disposisi;
            $disposisi_user->save();
        }

        if($disposisiSM){
            $catatan = new Catatan();
            $catatan->surat_id = $surat->id;
            if($request->catatan == null){
                $catatan->catatan = 'Menambah disposisi surat masuk dengan nomor '.$surat->nosurat;
            }else{
                $catatan->catatan = 'Menambah disposisi surat masuk dengan nomor ' . $surat->nosurat . ', ('.$request->catatan.').';
            }
            $catatan->waktu = Carbon::now();
            $catatan->save();
        }

        if($disposisiSM){
            return redirect()->route('index.disposisi.masuk', $surat)->with('success', 'Data berhasil di tambah !!');
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
    public function show($disposisi)
    {
        //
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
        $nav = 'transaksi';
        $menu = 'masuk';
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
            if($request->catatan == null){
                $catatan->catatan = 'Mengubah disposisi surat masuk dengan nomor '.$disposisi->surat->nosurat;
            }else{
                $catatan->catatan = 'Mengubah disposisi surat masuk dengan nomor ' . $disposisi->surat->nosurat . ', ('.$request->catatan.').';
            }
            $catatan->waktu = Carbon::now();
            $catatan->save();
        }

        if($disposisi){
            return redirect()->route('index.disposisi.masuk', $disposisi->surat)->with('success', 'Data berhasil di ubah !!');
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
        //
    }
}
