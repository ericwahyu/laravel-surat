<?php

namespace App\Http\Controllers;

use App\Models\Kode;
use App\Models\Role;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

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
        $kode = Kode::all();
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
        $role = Role::all();
        $unit = $user->isUnitkerja();
        foreach($unit as $units){
            if ($units == 'Fakultas Teknik Elektro dan Teknologi Informasi') {
                $getRole[] = array(1, 'Fakultas Teknik Elektro dan Teknologi Informasi');

            } elseif($units == 'Jurusan Teknik Informatika'){
                $getRole[] = array(2, 'Jurusan Teknik Informatika');

            } elseif($units == 'Jurusan Sistem Informasi'){
                $getRole[] = array(3, 'Jurusan Sistem Informasi');

            } elseif($units == 'Jurusan Teknik Elektro'){
                $getRole[] = array(4, 'Jurusan Teknik Elektro');

            }elseif($user->isAdmin()){
                $getRole[] = '';

            }elseif(!$user->isAdmin() && $user->isPimpinan() || $user->isPengelola()){
                break;
            }
        }

        return view('kode.insert', compact('nav', 'menu', 'user', 'role', 'getRole'));
    }

    public function isRoleUnit(){

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
            'role_id' => 'required',
            'nama' => 'required|max:100',
            'kode' => 'required',
            'penomoran' => 'required',
        ]);
        $kode = new Kode();
        $kode->role_id = $request->role_id;
        $kode->nama = $request->nama;
        $kode->kode = $request->kode;
        $kode->penomoran = $request->penomoran;
        $kode->save();

        return redirect()->route('index.kode')->with('success', 'Berhasil tambah data !!');
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
        $role = Role::all();
        $unit = $user->isUnitkerja();
        foreach($unit as $units){
            if ($units == 'Fakultas Teknik Elektro dan Teknologi Informasi') {
                $getRole[] = array(1, 'Fakultas Teknik Elektro dan Teknologi Informasi');

            } elseif($units == 'Jurusan Teknik Informatika'){
                $getRole[] = array(2, 'Jurusan Teknik Informatika');

            } elseif($units == 'Jurusan Sistem Informasi'){
                $getRole[] = array(3, 'Jurusan Sistem Informasi');

            } elseif($units == 'Jurusan Teknik Elektro'){
                $getRole[] = array(4, 'Jurusan Teknik Elektro');
                
            } elseif($user->isAdmin()){
                $getRole[] = '';

            }elseif(!$user->isAdmin() && $user->isPimpinan() || $user->isPengelola()){
                break;
            }
        }

        return view('kode.update', compact('nav', 'menu', 'user', 'kode', 'role', 'getRole'));
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
        $request->validate([
            'role_id' => 'required',
            'nama' => 'required|max:100',
            'kode' => 'required|max:100',
            'penomoran' => 'required|max:100',
        ]);

        $kode->role_id = $request->role_id;
        $kode->nama = $request->nama;
        $kode->kode = $request->kode;
        $kode->penomoran = $request->penomoran;
        $kode->save();

        return redirect()->route('index.kode')->with('success', 'Data berhasil di Update !!');
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
