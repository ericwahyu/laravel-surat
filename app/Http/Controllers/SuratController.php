<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Jenis;
use App\Models\Catatan;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

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
        $data = Surat::join('jenis', 'surat.jenis_id', '=', 'jenis.id')
                ->select('surat.*')
                ->get();
        return view('surat masuk.index', compact('nav', 'menu', 'data'));
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
        $jenis = Jenis::all();
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
            'nosurat' => 'nullable',
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
            $catatan->surat_id = $suratSM->id;
            if($request->catatan === null){
                $catatan->catatan = 'Menambah data Surat Masuk '. $request->judul;
            }else{
                $catatan->catatan = 'Menambah data Surat Masuk '. $request->judul. ', ('. $request->catatan. ').';
            }
            $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        }

        if($catatan){
            $catatan->save();
            return redirect()->route('index.surat.masuk')->with('success', 'Data berhasil di Tambah !!');
        }else{
            return back()->with('success', 'Data berhasil di Update !!');
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Surat $surat)
    {
        //
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
    }
}
