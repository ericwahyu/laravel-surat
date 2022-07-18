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
    public function index($surat)
    {
        //
        $nav = 'transaksi';
        $menu = 'masuk';
        $surat = Surat::find($surat);
        try{
            $data = Disposisi::join('surat', 'surat.id', '=', 'surat_id')
                    ->where('surat.id', $surat->id)
                    ->select('disposisi.*')
                    ->get();
        }catch(ModelNotFoundException $exception){
            return back()->withError($exception->getMessage())->withInput();
        }
            return view('disposisi.index', compact('nav','menu','data', 'surat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($surat)
    {
        //
        $nav = 'transaksi';
        $menu = 'masuk';
        $surat = Surat::find($surat);
        $user = User::all();
        return view('disposisi.insert', compact('nav', 'menu', 'surat', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $surat)
    {
        //
        $surat = Surat::find($surat);
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
            $surat = Surat::find($surat->id);

            $catatan = new Catatan();
            $catatan->surat_id = $surat->id;
            if($request->perihal == null){
                $catatan->catatan = 'Menambah disposisi surat masuk '.$surat->judul;
            }else{
                $catatan->catatan = 'Menambah disposisi surat masuk ' . $surat->judul . ', ('.$request->perihal.').';
            }
            $catatan->waktu = Carbon::now();
            $catatan->save();
        }


        if($disposisi){
            return redirect()->route('index.disposisi.masuk', $surat->id)->with('success', 'Data berhasil di Tambah !!');
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
