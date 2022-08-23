<?php

namespace App\Http\Controllers;

use App\Models\Keperluan;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class KeperluanController extends Controller
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
        $menu = 'keperluan';

        $keperluan = Keperluan::all();
        $user = Auth::user();

        return view('keperluan.index', compact('nav', 'menu', 'keperluan', 'user'));
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
        $menu = 'keperluan';
        $user = Auth::user();

        return view('keperluan.insert', compact('nav', 'menu', 'user'));
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
            'nama' => 'required|max:100'
        ]);

        $keperluan = new Keperluan();
        $keperluan->nama = strtoupper($request->nama);
        $keperluan->save();

        return redirect()->route('index.keperluan')->with('success', 'Berhasil tambah data !!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keperluan  $keperluan
     * @return \Illuminate\Http\Response
     */
    public function show(Keperluan $keperluan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keperluan  $keperluan
     * @return \Illuminate\Http\Response
     */
    public function edit(Keperluan $keperluan)
    {
        //
        $nav = 'umum';
        $menu = 'keperluan';
        $user = Auth::user();

        return view('keperluan.update', compact('nav', 'menu', 'user', 'keperluan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keperluan  $keperluan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keperluan $keperluan)
    {
        //
        $request->validate([
            'nama' => 'required|max:100'
        ]);

        $keperluan->nama = strtoupper($request->nama);
        $keperluan->save();

        return redirect()->route('index.keperluan')->with('success', 'Data berhasil di Update !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keperluan  $keperluan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Keperluan $keperluan)
    {
        //
        if($keperluan){
            $keperluan->delete();
            return redirect()->route('index.keperluan')->with('success', 'Data berhasil di Hapus !!');
        }
    }
}
