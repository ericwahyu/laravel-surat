<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nav = 'surat';
        $menu = 'kategori';
        $data = Kategori::where('nama','not like','%'.'surat'.'%')->get();
        return view('kategori template.index', compact('nav', 'menu', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nav = 'surat';
        $menu = 'kategori';

        return view('kategori template.insert', compact('nav', 'menu'));
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
            'nama' => 'required'
        ]);

        $insert = new Kategori();
        $insert->nama = $request->nama;

        if(!$insert){
            return back()->with('error', 'Gagal tambah data !!');
        }else{
            $insert->save();
            return redirect()->route('index.template.kategori')->with('success', 'Berhasil tambah data !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit($kategori)
    {
        //
        $nav = 'surat';
        $menu = 'kategori';
        $kategori = Kategori::find($kategori);

        return view('kategori template.update', compact('nav', 'menu', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$kategori)
    {
        //
        $kategori = Kategori::find($kategori);
        $request->validate([
            'nama' => 'required'
        ]);

        $kategori->nama = $request->nama;

        if(!$kategori){
            return back()->with('error', 'Data gagal di Update !!');
        }else{
            $kategori->save();
            return redirect()->route('index.template.kategori')->with('success', 'Data berhasil di Update !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy($kategori)
    {
        //
        $kategori = Kategori::find($kategori);

        if(!$kategori){
            return redirect()->route('index.template.kategori')->with('error', 'Data gagal di Hapus !!');
        }else{
            $kategori->delete();
            return redirect()->route('index.template.kategori')->with('success', 'Data berhasil di Hapus !!');
        }
    }
}
