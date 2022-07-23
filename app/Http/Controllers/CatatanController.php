<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use App\Models\Surat;
use Illuminate\Http\Request;

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
        $catatan = Catatan::join('surat', 'surat.id', '=', 'surat_id')
                ->join('jenis', 'jenis.id', '=', 'jenis_id')
                ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                ->where('kategori.id', 1)
                ->get(['catatan.*']);
        return view('catatan SM.index', compact('nav', 'menu', 'catatan'));
    }

    public function indexsk()
    {
        //
        $nav = 'agenda';
        $menu = 'keluar';
        $catatan = Catatan::join('surat', 'surat.id', '=', 'surat_id')
                ->join('jenis', 'jenis.id', '=', 'jenis_id')
                ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                ->where('kategori.id', 2)
                ->get(['catatan.*']);
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
