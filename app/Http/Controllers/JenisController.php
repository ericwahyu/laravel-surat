<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nav = 'umum';
        $menu = 'jenis';

        $jenis = Jenis::all();
        $user = Auth::user();

        return view('jenis.index', compact('nav', 'menu', 'jenis', 'user'));
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

        return view('jenis.insert', compact('nav', 'menu'));
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
            'nama' => 'required|max:100'
        ]);

        $jenis = new Jenis();
        // $kategori->kategori_id = $request->kategori_id;
        $jenis->nama = $request->nama;
        $jenis->save();

        if($jenis){
            return redirect()->route('index.jenis')->with('success', 'Data berhasil di Tambah !!');
        }else{
            return redirect()->route('index.jenis')->with('warning', 'Data gagal di Tambah !!');
        }
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
    public function edit(Jenis $jenis)
    {
        //
        $nav = 'umum';
        $menu = 'jenis';

        return view('jenis.update', compact('nav', 'menu', 'jenis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jenis  $jenis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jenis $jenis)
    {
        //
        $request->validate([
            'nama' => 'required|max:100'
        ]);

        // $jenis->kategori_id = $request->kategori_id;
        $jenis->nama = $request->nama;
        $jenis->save();

        if($jenis){
            return redirect()->route('index.jenis')->with('success', 'Data berhasil di Update !!');
        }else{
            return redirect()->route('index.jenis')->with('warning', 'Data gagal di Update !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jenis  $jenis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jenis $jenis)
    {
        //
        if($jenis){
            $jenis->delete();
            return redirect()->route('index.jenis')->with('success', 'Data berhasil di Hapus !!');
        }else{
            return redirect()->route('index.jenis')->with('error', 'Data gagal di Hapus !!');
        }
    }
}
