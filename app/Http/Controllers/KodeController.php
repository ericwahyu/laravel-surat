<?php

namespace App\Http\Controllers;

use App\Models\Kode;
use App\Models\Role;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;

class KodeController extends Controller
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
        $menu = 'kode';

        $user = Auth::user();
        $unit = $user->isUnitkerja();

        if(Auth::user()->isAdmin()){
            $kode = Kode::all();
        }else{
            for($i = 0; $i < count($unit); $i++){
                if($user->isAdmin()){
                    $getUnit[] = '';

                }elseif($unit[$i][1] === 'Fakultas Teknik Elektro dan Teknologi Informasi'){
                    $getUnit[] = array($unit[$i][0], 'Fakultas Teknik Elektro dan Teknologi Informasi');

                } elseif($unit[$i][1] === 'Jurusan Teknik Informatika'){
                    $getUnit[] = array($unit[$i][0], 'Jurusan Teknik Informatika');

                } elseif($unit[$i][1] === 'Jurusan Sistem Informasi'){
                    $getUnit[] = array($unit[$i][0], 'Jurusan Sistem Informasi');

                } elseif($unit[$i][1] === 'Jurusan Teknik Elektro'){
                    $getUnit[] = array($unit[$i][0], 'Jurusan Teknik Elektro');

                }
            }
            // dd(count($getUnit));
            for ($a=0; $a < count($getUnit); $a++) {
                $getIdUnit[] = $getUnit[$a][0];
            }
            // dd($getIdUnit);
            $kode = Kode::whereIn('unit_kerja_id', $getIdUnit)->get();
        }


        // dd($kode);

        // $kode = Kode::where

        return view('kode.index', compact('nav', 'menu', 'kode', 'user'));
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
        $menu = 'kode';
        $user = Auth::user();
        $unitKerja = UnitKerja::orwhere('nama', 'like', '%Fakultas Teknik Elektro dan Teknologi Informasi%')
                    ->orwhere('nama', 'like', '%Jurusan Teknik Informatika%')
                    ->orwhere('nama', 'like', '%Jurusan Sistem Informasi%')
                    ->orwhere('nama', 'like', '%Jurusan Teknik Elektro%')
                    ->get();
        $unit = $user->isUnitkerja();
        for($i = 0; $i < count($unit); $i++){
            if($user->isAdmin()){
                $getUnit[] = '';

            }elseif($unit[$i][1] === 'Fakultas Teknik Elektro dan Teknologi Informasi'){
                $getUnit[] = array($unit[$i][0], 'Fakultas Teknik Elektro dan Teknologi Informasi');

            } elseif($unit[$i][1] === 'Jurusan Teknik Informatika'){
                $getUnit[] = array($unit[$i][0], 'Jurusan Teknik Informatika');

            } elseif($unit[$i][1] === 'Jurusan Sistem Informasi'){
                $getUnit[] = array($unit[$i][0], 'Jurusan Sistem Informasi');

            } elseif($unit[$i][1] === 'Jurusan Teknik Elektro'){
                $getUnit[] = array($unit[$i][0], 'Jurusan Teknik Elektro');

            }
        }
        return view('kode.insert', compact('nav', 'menu', 'user', 'unitKerja', 'getUnit'));
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
        // dd($request);
        $request->validate([
            'unit_id' => 'required',
            'nama' => 'required|max:100',
            'kode' => 'required',
            'penomoran' => 'required',
        ]);
        $kode = new Kode();
        $kode->unit_kerja_id = $request->unit_id;
        $kode->nama = $request->nama;
        $kode->kode = $request->kode;
        $kode->penomoran = $request->penomoran;
        $kode->increment = 1;
        $kode->save();

        if($kode){
            return redirect()->route('index.kode')->with('success', 'Berhasil tambah data !!');
        }else{
            return redirect()->route('index.kode')->with('warning', 'Gagal menambah data !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kode  $kode
     * @return \Illuminate\Http\Response
     */
    public function show(Kode $kode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kode  $kode
     * @return \Illuminate\Http\Response
     */
    public function edit(Kode $kode)
    {
        //
        $nav = 'umum';
        $menu = 'kode';
        $user = Auth::user();
        $unitKerja = UnitKerja::orwhere('nama', 'like', '%Fakultas Teknik Elektro dan Teknologi Informasi%')
                    ->orwhere('nama', 'like', '%Jurusan Teknik Informatika%')
                    ->orwhere('nama', 'like', '%Jurusan Sistem Informasi%')
                    ->orwhere('nama', 'like', '%Jurusan Teknik Elektro%')
                    ->get();
        $unit = $user->isUnitkerja();
        for($i = 0; $i < count($unit); $i++){
            if($user->isAdmin()){
                $getUnit[] = '';

            }elseif($unit[$i][1] === 'Fakultas Teknik Elektro dan Teknologi Informasi'){
                $getUnit[] = array($unit[$i][0], 'Fakultas Teknik Elektro dan Teknologi Informasi');

            } elseif($unit[$i][1] === 'Jurusan Teknik Informatika'){
                $getUnit[] = array($unit[$i][0], 'Jurusan Teknik Informatika');

            } elseif($unit[$i][1] === 'Jurusan Sistem Informasi'){
                $getUnit[] = array($unit[$i][0], 'Jurusan Sistem Informasi');

            } elseif($unit[$i][1] === 'Jurusan Teknik Elektro'){
                $getUnit[] = array($unit[$i][0], 'Jurusan Teknik Elektro');

            }
        }

        return view('kode.update', compact('nav', 'menu', 'user', 'kode', 'unitKerja', 'getUnit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kode  $kode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kode $kode)
    {
        //
        // dd($request);
        $request->validate([
            'unit_id' => 'required',
            'nama' => 'required|max:100',
            'kode' => 'required|max:100',
            'penomoran' => 'required|max:100',
            'increment' => 'required',
        ]);

        $kode->unit_kerja_id = $request->unit_id;
        $kode->nama = $request->nama;
        $kode->kode = $request->kode;
        $kode->penomoran = $request->penomoran;
        $kode->increment = $request->increment;
        $kode->save();

        if($kode){
            return redirect()->route('index.kode')->with('success', 'Berhasil ubah data !!');
        }else{
            return redirect()->route('index.kode')->with('warning', 'Gagal mengubah data !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kode  $kode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kode $kode)
    {
        //
        if($kode){
            $kode->delete();
            return redirect()->route('index.kode')->with('success', 'Data berhasil di Hapus !!');
        }
    }
}
