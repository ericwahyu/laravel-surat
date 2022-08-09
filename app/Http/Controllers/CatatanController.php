<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use App\Models\Surat;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class CatatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexsm()
    {
        //
        $nav = 'agenda';
        $menu = 'masuk';
        $user = Auth::user();
        $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
                    ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('surat.status', '!=', 0)
                    ->where('kategori_id', 1)
                    ->select('catatan.*')
                    ->distinct()->latest()->get();
        // dd($catatan);
        return view('catatan SM.index', compact('nav', 'menu', 'catatan', 'user'));
    }

    public function indexsk()
    {
        //
        $nav = 'agenda';
        $menu = 'keluar';
        $user = Auth::user();
        $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
                    ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('surat.status', '!=', 0)
                    ->where('kategori_id', 2)
                    ->select('catatan.*')
                    ->distinct()->latest()->get();
        return view('catatan SK.index', compact('nav', 'menu', 'catatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catatan  $catatan
     * @return \Illuminate\Http\Response
     */
    public function show(Catatan $catatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catatan  $catatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Catatan $catatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catatan  $catatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catatan $catatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catatan  $catatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catatan $catatan)
    {
        //
    }
}
