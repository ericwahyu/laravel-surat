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
    public function indexsm(Request $request)
    {
        //
        $user = Auth::user();
        // if($user->isAdmin() || $user->isPimpinan()){
            if($request->input('tanggalAwal') && $request->input('tanggalAkhir')){
                $tanggal_awal = date('Y-m-d',strtotime($request->tanggalAwal));
                $tanggal_akhir = date('Y-m-d',strtotime($request->tanggalAkhir));

                $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
                    ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('disposisi_user.kategori_id', 1)
                    ->where('users.id', Auth::user()->id)
                    ->whereDate('waktu', '>=', $tanggal_awal)
                    ->whereDate('waktu', '<=', $tanggal_akhir)
                    ->select('catatan.*')
                    ->distinct()->latest('catatan.id')->get();
            }else{
                $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
                    ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('disposisi_user.kategori_id', 1)
                    ->where('users.id', Auth::user()->id)
                    ->select('catatan.*')
                    ->distinct()->latest('catatan.id')->get();
            }
        // }else{
        //     if($request->input('tanggalAwal') && $request->input('tanggalAkhir')){
        //         $tanggal_awal = date('Y-m-d',strtotime($request->tanggalAwal));
        //         $tanggal_akhir = date('Y-m-d',strtotime($request->tanggalAkhir));

        //         $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
        //             ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
        //             ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
        //             ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
        //             ->join('users', 'disposisi_user.user_id', '=', 'users.id')
        //             ->where('surat.status', '!=', 0)
        //             ->where('disposisi_user.kategori_id', 1)
        //             ->where('users.id', Auth::user()->id)
        //             // ->where('disposisi_user.user_id', Auth::user()->id)
        //             ->whereDate('waktu', '>=', $tanggal_awal)
        //             ->whereDate('waktu', '<=', $tanggal_akhir)
        //             ->select('catatan.*')
        //             ->distinct()->latest('catatan.id')->get();
        //     }else{
        //         $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
        //             ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
        //             ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
        //             ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
        //             ->join('users', 'disposisi_user.user_id', '=', 'users.id')
        //             ->where('surat.status', '!=', 0)
        //             ->where('disposisi_user.kategori_id', 1)
        //             ->where('users.id', Auth::user()->id)
        //             ->select('catatan.*')
        //             ->distinct()->latest('catatan.id')->get();
        //     }
        // }

        $nav = 'agenda';
        $menu = 'masuk_catatan';
        $user = Auth::user();
        return view('catatan SM.index', compact('nav', 'menu', 'catatan', 'user', 'request'));
    }

    public function indexsk(Request $request)
    {
        //
        $user = Auth::user();
        // if($user->isAdmin() || $user->isPimpinan()){
            if($request->input('tanggalAwal') && $request->input('tanggalAkhir')){
                $tanggal_awal = date('Y-m-d',strtotime($request->tanggalAwal));
                $tanggal_akhir = date('Y-m-d',strtotime($request->tanggalAkhir));

                $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
                    ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('disposisi_user.kategori_id', 2)
                    ->where('users.id', Auth::user()->id)
                    ->whereDate('waktu', '>=', $tanggal_awal)
                    ->whereDate('waktu', '<=', $tanggal_akhir)
                    ->select('catatan.*')
                    ->distinct()->latest('catatan.id')->get();
            }else{
                $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
                    ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('disposisi_user.kategori_id', 2)
                    ->where('users.id', Auth::user()->id)
                    ->select('catatan.*')
                    ->distinct()->latest('catatan.id')->get();
            }
        // }else{
        //     if($request->input('tanggalAwal') && $request->input('tanggalAkhir')){
        //         $tanggal_awal = date('Y-m-d',strtotime($request->tanggalAwal));
        //         $tanggal_akhir = date('Y-m-d',strtotime($request->tanggalAkhir));

        //         $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
        //             ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
        //             ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
        //             ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
        //             ->join('users', 'disposisi_user.user_id', '=', 'users.id')
        //             ->where('surat.status', '!=', 0)
        //             ->where('disposisi_user.kategori_id', 2)
        //             ->where('users.id', Auth::user()->id)
        //             ->whereDate('waktu', '>=', $tanggal_awal)
        //             ->whereDate('waktu', '<=', $tanggal_akhir)
        //             ->select('catatan.*')
        //             ->distinct()->latest('catatan.id')->get();
        //     }else{
        //         $catatan = Catatan::join('surat', 'surat.id', '=', 'catatan.surat_id')
        //             ->join('jenis', 'jenis.id', '=', 'surat.jenis_id')
        //             ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
        //             ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
        //             ->join('users', 'disposisi_user.user_id', '=', 'users.id')
        //             ->where('surat.status', '!=', 0)
        //             ->where('disposisi_user.kategori_id', 2)
        //             ->where('users.id', Auth::user()->id)
        //             ->where('disposisi_user.user_id', Auth::user()->id)
        //             ->select('catatan.*')
        //             ->distinct()->latest('catatan.id')->get();
        //     }
        // }

        $nav = 'agenda';
        $menu = 'keluar_catatan';
        $user = Auth::user();
        return view('catatan SK.index', compact('nav', 'menu', 'catatan', 'request'));
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
