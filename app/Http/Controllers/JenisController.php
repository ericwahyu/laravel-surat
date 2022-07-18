<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $nav = 'umum';
        $menu = 'jenis';

        $search = $request->search;

        $kategori = Kategori::all();
        $data = Jenis::join('kategori', 'kategori.id', '=', 'kategori_id')
                ->select('jenis.*')
                ->get();
        $request = $request->all();

        return view('jenis.index', compact('nav', 'menu', 'data', 'request', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nav = 'umum';
        $menu = 'jenis';
        $kategori = Kategori::all();
        return view('jenis.insert', compact('nav', 'menu', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'nama' => 'required|max:100'
        ]);

        $insert = new Jenis();
        $insert->kategori_id = $request->kategori;
        $insert->nama_jenis = $request->nama;
        $insert->save();

        return redirect()->route('index.jenis')->with('success', 'Berhasil tambah data !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jenis  $jenis
     * @return \Illuminate\Http\Response
     */
    public function show(Jenis $jenis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jenis  $jenis
     * @return \Illuminate\Http\Response
     */
    public function edit($jenis)
    {
        //
        $nav = 'umum';
        $menu = 'jenis';
        $kategori = Kategori::all();
        $jenis = Jenis::find($jenis);

        return view('jenis.update', compact('nav', 'menu', 'jenis', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jenis  $jenis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $jenis)
    {
        //
        $jenis = Jenis::find($jenis);
        $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required|max:100'
        ]);

        $jenis->kategori_id = $request->kategori_id;
        $jenis->nama_jenis = $request->nama;
        $jenis->save();

        return redirect()->route('index.jenis')->with('success', 'Data berhasil di Update !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jenis  $jenis
     * @return \Illuminate\Http\Response
     */
    public function destroy($jenis)
    {
        //
        $jenis = Jenis::find($jenis);

        if(!$jenis){
            return redirect()->route('index.jenis')->with('error', 'Data gagal di Hapus !!');
        }else{
            $jenis->delete();
            return redirect()->route('index.jenis')->with('success', 'Data berhasil di Hapus !!');
        }
    }
}
