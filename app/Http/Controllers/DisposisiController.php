<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Surat;
use App\Models\User;
use App\Models\Catatan;
use App\Models\Disposisiuser;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Dosenunit;
use App\Models\ResponseDisposisi;
use App\Models\UserEksternal;
use App\Models\Response;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Support\Facades\DB;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Surat $surat)
    {
        //
        $kategori = Disposisi::join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                ->where('surat_id', $surat->id)
                ->where('user_id', Auth::user()->id)
                ->first();
        switch($kategori->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
                break;
            }
        $nav = 'transaksi';
        $user = Auth::user();
        if($user->isAdmin()){
            $data = Disposisi::join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat_id', $surat->id)
                        ->select('disposisi.*')
                        ->distinct()->get();
        }else{
            $data = Disposisi::join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat_id', $surat->id)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->select('disposisi.*')
                        ->distinct()->get();
        }
        // dd($data);
        return view('disposisi.index', compact('nav','menu','data','surat', 'user','kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Surat $surat)
    {
        //
        $kategori = Disposisi::join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
            ->join('users', 'disposisi_user.user_id', '=', 'users.id')
            ->where('surat_id', $surat->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        switch($kategori->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
                break;
            }
        $nav = 'transaksi';
        $user = Auth::user();
        $response = Response::all();
        $user_dosen = Dosen::join('users', 'dosen.user_id', '=', 'users.id' )->get();
        $user_mahasiswa = Mahasiswa::join('users', 'mahasiswa.user_id', '=', 'users.id' )->get();
        return view('disposisi.insert', compact('nav', 'menu', 'surat', 'user', 'user_dosen', 'user_mahasiswa', 'response'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $surat_id)
    {
        //
        // dd($request);
        $request->validate([
            'perihal' => 'required',
            // 'tanggal' => 'required|date',
            'isi' => 'required'
        ]);

        $surat = Surat::find($surat_id);
        $disposisi = new Disposisi();
        $disposisi->surat_id = $surat->id;
        $disposisi->perihal = $request->perihal;
        $disposisi->tanggal = Carbon::now();
        $disposisi->isi = $request->isi;
        $disposisi->save();

        //input response disposisi
        foreach($request->response as $response){
            $response_disposisi = new ResponseDisposisi();
            $response_disposisi->disposisi_id = $disposisi->id;
            $response_disposisi->response_id = $response;
            $response_disposisi->save();
        }

        //input data pembuat
        $disposisi_pembuat = new Disposisiuser();
        $disposisi_pembuat->disposisi_id = $disposisi->id;
        $disposisi_pembuat->user_id = Auth::user()->id;
        $disposisi_pembuat->kategori_id = 2;
        $disposisi_pembuat->save();

        //input data yang di tujukan
        if($request->radiobox == 1){
            foreach($request->disposisi as $dis_user){
                $disposisi_user = new Disposisiuser();
                $disposisi_user->disposisi_id = $disposisi->id;
                $disposisi_user->user_id = $dis_user;
                $disposisi_user->kategori_id = 1;
                $disposisi_user->save();
            }
        }elseif($request->radiobox == 2){
            $user_eksternal = new UserEksternal();
            $user_eksternal->nama = $request->nama_tujuan;
            $user_eksternal->email = $request->alamat_email;
            $user_eksternal->save();

            $disposisi_user = new Disposisiuser();
            $disposisi_user->disposisi_id = $disposisi->id;
            $disposisi_user->user_eksternal_id = $user_eksternal->id;
            $disposisi_user->kategori_id = 1;
            $disposisi_user->save();
        }

        // tambah data catatan
        $kategori = Disposisiuser::where('user_id', Auth::user()->id)->first();
        $catatan = new Catatan();
        $catatan->surat_id = $surat->id;
        $catatan->user_id = Auth::user()->id;
        if($request->catatan_disposisi == null){
            $catatan->catatan = 'Menambah disposisi baru pada surat dengan nomor surat '.$surat->nosurat;
        }else{
            $catatan->catatan = 'Menambah disposisi baru pada surat dengan nomor surat ' .$surat->nosurat. ', (catatan : '.$request->catatan_disposisi.').';
        }
        $catatan->waktu = Carbon::now();
        $catatan->save();

        $surat = Surat::findOrFail($disposisi->surat_id);
        switch($kategori->kategori_id){
            case(1):
                return redirect()->route('index.surat.masuk')->with('success', 'Data berhasil di tambah !!');
                break;
            case(2):
                return redirect()->route('index.surat.keluar')->with('success', 'Data berhasil di tambah !!');
                break;
        }
        return back()->with('warning', 'Data gagal di Tambah !!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function show(Disposisi $disposisi)
    {
        //
        $kategori = Disposisi::join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                ->where('surat_id', $disposisi->surat_id)
                ->where('user_id', Auth::user()->id)
                ->first();
        switch($kategori->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
                break;
            }

        $surat = Surat::with('disposisi')
            ->where('surat.id', $disposisi->surat_id)
            ->first();

        $response = ResponseDisposisi::join('response', 'response_disposisi.response_id', '=', 'response.id')
            ->where('disposisi_id', $disposisi->id)
            ->get();

        $responseModal = ResponseDisposisi::join('response', 'response_disposisi.response_id', '=', 'response.id')
            ->where('disposisi_id', $disposisi->id)
            ->get();
        // dd($response);
        $nav = 'transaksi';
        $user = Auth::user();
        return view('disposisi.show', compact('nav', 'menu','surat', 'disposisi', 'user', 'kategori', 'response', 'responseModal'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function edit(Disposisi $disposisi)
    {
        //
        $kategori = Disposisi::join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                ->where('surat_id', $disposisi->surat_id)
                ->where('user_id', Auth::user()->id)
                ->first();
        switch($kategori->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
                break;
            }
        $nav = 'transaksi';
        $user = User::all();
        return view('disposisi.update', compact('nav', 'menu', 'disposisi', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disposisi $disposisi)
    {
        //
        $request->validate([
            'perihal' => 'required',
            // 'tanggal' => 'required|date',
            'isi' => 'required'
        ]);

        $disposisi->perihal = $request->perihal;
        $disposisi->tanggal = Carbon::now();
        $disposisi->isi = $request->isi;
        $disposisi->save();

        $surat = Surat::with('disposisi')
        ->where('surat.id', $disposisi->surat_id)
        ->first();

        // tambah data cacatan
        $catatan = new Catatan();
        $catatan->surat_id = $disposisi->surat->id;
        $catatan->user_id = Auth::user()->id;
        if($request->catatan_disposisi == null){
            $catatan->catatan = 'Menambah disposisi baru pada surat dengan nomor surat '.$surat->nosurat;
        }else{
            $catatan->catatan = 'Menambah disposisi baru pada surat dengan nomor surat ' .$surat->nosurat. ', (catatan : '.$request->catatan_disposisi.').';
        }
        $catatan->waktu = Carbon::now();
        $catatan->save();

        if($disposisi){
            return redirect()->route('index.disposisi', $disposisi->surat)->with('success', 'Data berhasil di ubah !!');
        }else{
            return back()->with('warning', 'Data gagal di Tambah !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disposisi $disposisi)
    {
        $surat = Surat::findOrFail($disposisi->surat_id);

        //tambah data catatan
        $catatan = new Catatan();
        $catatan->surat_id = $surat->id;
        $catatan->user_id = Auth::user()->id;
        $catatan->catatan = 'Menghapus disposisi surat pada nomor surat '.$surat->nosurat;
        $catatan->waktu = Carbon::now();
        $catatan->save();

        if($disposisi){
            $disposisi->delete();
            return redirect()->route('index.disposisi', $surat)->with('success', 'Data berhasil di Hapus !!');
        }else{
            return back()->with('warning', 'Data gagal di Hapus !!');
        }
    }

    public function create_reply(Disposisi $disposisi){
        $status_dosen = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('dosen', 'dosen.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi->id)
                ->get();
        $status_mahasiswa = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('mahasiswa', 'mahasiswa.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi->id)
                ->get();
        $surat = Surat::findOrFail($disposisi->surat_id);
        switch($disposisi->surat->jenis->kategori_id){
            case(1):
                $menu = 'masuk';
            break;
            case(2):
                $menu = 'keluar';
            break;
        }
        $nav = 'transaksi';
        $user = Auth::user();
        return view('disposisi.replySM', compact('nav', 'menu', 'surat', 'disposisi', 'user', 'status_dosen', 'status_mahasiswa'));
    }

    // public function store_reply(Request $request, Disposisi $disposisi){
    //     $getStatusDosen = $this->get_dosen($disposisi->id, Auth::user()->id);
    //     $getStatusMahasiswa = $this->get_mahasiswa($disposisi->id, Auth::user()->id);
    //     if ($getStatusDosen->isNotEmpty()) {
    //         foreach($getStatusDosen as $get){
    //             $get_status = $get->status;
    //         }
    //     }elseif($getStatusMahasiswa->isNotEmpty()) {
    //         foreach($getStatusMahasiswa as $get){
    //             $get_status = $get->status;
    //         }
    //     }
    //     if (Auth::user()->isAdmin()|| $get_status == 1) {
    //         $disposisiAdmin = new Disposisiuser();
    //         $disposisiAdmin->disposisi_id = $disposisi->id;
    //         $disposisiAdmin->user_id =  Auth::user()->id;
    //         $disposisiAdmin->status = 5;
    //         $disposisiAdmin->save();
    //     } else {
    //         $update_status = DB::table('disposisi_user')
    //                         ->where('disposisi_id', $disposisi->id)
    //                         ->where('user_id', Auth::user()->id)
    //                         ->update([
    //                             'status' => 5
    //                         ]);
    //     }

    //     $surat = Surat::findOrFail($disposisi->surat_id);

    //     // tambah data catatan
    //     $catatan = new Catatan();
    //     $catatan->surat_id = $disposisi->surat_id;
    //     $catatan->user_id = Auth::user()->id;
    //     $catatan->catatan = 'Memberi tanggapan balas data pada surat masuk, dengan nomor surat '. $surat->nosurat. ', (catatan balas : '. $request->catatan. ').';
    //     $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
    //     $catatan->save();

    //     if($catatan){
    //         return redirect()->route('show.disposisi', $disposisi)->with('success', 'Tanggapan surat berhasil, akan dilakukan proses selanjutnya !!');
    //     }else{
    //         return back()->with('warning', 'Tanggapan surat gagal dikirim !!');
    //     }
    // }

    public function setResponse(Request $request, Disposisi $disposisi){
        // dd($request);
        $get_dosen = $this->getDosen($disposisi->id, Auth::user()->id);
        $get_mahasiswa = $this->getMahasiswa($disposisi->id, Auth::user()->id);
        // dd($get_dosen);
        if ($get_dosen->isNotEmpty()) {
            foreach($get_dosen as $get){
                $get_kategori = $get->kategori_id;
            }
        }elseif($get_mahasiswa->isNotEmpty()) {
            foreach($get_mahasiswa as $get){
                $get_kategori = $get->kategori_id;
            }
        }

        // dd($get_kategori);
        if (Auth::user()->isAdmin() || $get_kategori == 1) {
            $update_response = DB::table('disposisi_user')
                            ->where('disposisi_id', $disposisi->id)
                            ->where('user_id', Auth::user()->id)
                            // ->get();
                            ->update([
                                'response_id' => $request->response_id
                            ]);
        }
        // dd($update_response);

        $surat = Surat::findOrFail($disposisi->surat_id);

        // tambah data catatan
        $catatan = new Catatan();
        $catatan->surat_id = $disposisi->surat_id;
        $catatan->user_id = Auth::user()->id;
        if($request->catatan_response == null){
            $catatan->catatan = 'Memberi tanggapan '.$request->response_nama.', pada nomor surat '.$surat->nosurat;
        }else{
            $catatan->catatan = 'Memberi tanggapan '.$request->response_nama.', pada nomor surat ' .$surat->nosurat. ', (catatan : '.$request->catatan_response.').';
        }
        // $catatan->catatan = 'Memberi tanggapan membaca pada surat masuk, dengan nomor surat '. $surat->nosurat;
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        $catatan->save();

        if($catatan){
            return redirect()->route('show.disposisi', $disposisi)->with('succes', 'Tanggapan surat berhasil, akan dilakukan proses selanjutnya !!');
        }else{
            return back()->with('warning', 'Tanggapan surat gagal dikirim !!');
        }
    }

    public function getDosen($disposisi_id = null, $user_id = null){
        if($disposisi_id != null && $user_id == null){
            $get_dosen = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('dosen', 'dosen.user_id', '=', 'users.id')
                // ->join('response', 'response.id', '=', 'disposisi_user.response_id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                ->get();
        }elseif($disposisi_id != null && $user_id != null){
            $get_dosen = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('dosen', 'dosen.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                ->where(function($query) use ($user_id){
                    $query->where('disposisi_user.user_id', $user_id);
                })
                ->get();
        }
        // dd($get_dosen);
        return $get_dosen;
    }

    public function getDosenResponse($disposisi_id = null, $user_id = null){
        if($disposisi_id != null && $user_id == null){
            $get_dosen_response = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('dosen', 'dosen.user_id', '=', 'users.id')
                ->join('response', 'response.id', '=', 'disposisi_user.response_id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                // ->select('disposisi_user.*')
                ->first();
        }elseif($disposisi_id != null && $user_id != null){
            $get_dosen_response = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('dosen', 'dosen.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                ->where(function($query) use ($user_id){
                    $query->where('disposisi_user.user_id', $user_id);
                })
                ->first();
        }
        // dd($get_dosen_response);
        return $get_dosen_response;
    }

    public function getMahasiswa($disposisi_id = null, $user_id = null){
        if ($disposisi_id != null && $user_id == null) {
            $get_mahasiswa = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('mahasiswa', 'mahasiswa.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                ->get();
        }elseif($disposisi_id != null && $user_id != null) {
            $get_mahasiswa = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('mahasiswa', 'mahasiswa.user_id', '=', 'users.id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                ->where(function($query) use ($user_id){
                    $query->where('disposisi_user.user_id', $user_id);
                    })
                ->get();
        }
        return $get_mahasiswa;
    }

    public function getMahasiswaResponse($disposisi_id = null, $user_id = null){
        if ($disposisi_id != null && $user_id == null) {
            $get_mahasiswa_response = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('mahasiswa', 'mahasiswa.user_id', '=', 'users.id')
                ->join('response', 'response.id', '=', 'disposisi_user.response_id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                ->first();
        }elseif($disposisi_id != null && $user_id != null) {
            $get_mahasiswa_response = DB::table('disposisi_user')
                ->join('users', 'users.id', '=', 'disposisi_user.user_id')
                ->join('mahasiswa', 'mahasiswa.user_id', '=', 'users.id')
                ->join('response', 'response.id', '=', 'disposisi_user.response_id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                ->where(function($query) use ($user_id){
                    $query->where('disposisi_user.user_id', $user_id);
                    })
                ->first();
        }
        return $get_mahasiswa_response;
    }

    public function getUserEksternal($disposisi_id = null, $user_eksternal_id = null){
        if ($disposisi_id != null && $user_eksternal_id == null) {
            $getUserEksternal = DB::table('disposisi_user')
                ->join('user_eksternal', 'user_eksternal.id', '=', 'disposisi_user.user_eksternal_id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                ->get();
        }elseif($disposisi_id != null && $user_eksternal_id != null) {
            $getUserEksternal = DB::table('disposisi_user')
                ->join('user_eksternal', 'user_eksternal.id', '=', 'disposisi_user.user_eksternal_id')
                ->where('disposisi_user.disposisi_id', $disposisi_id)
                ->where(function($query) use ($user_eksternal_id){
                    $query->where('disposisi_user.user_eksternal_id', $user_eksternal_id);
                    })
                ->get();
        }
        // dd($getUserEksternal);
        return $getUserEksternal;
    }

    public function getUnitKerja($user_id){
        $mahasiswa = Mahasiswa::where('user_id', $user_id)->get();
        $dosen = Dosen::where('user_id', $user_id)->get();

        if($mahasiswa->isNotEmpty()){
            foreach($mahasiswa as $id_maha){
                $unit_kerja[] = $id_maha->unit_kerja->nama;
            }
        }elseif($dosen->isNotEmpty()){
            foreach($dosen as $id_dos){
                $unit_dosen = Dosenunit::where('dosen_id', $id_dos->id)->get();
                    foreach($unit_dosen as $unit){
                      $unit_kerja[] = $unit->unit_kerja->nama;
                }
            }
        }
        return $unit_kerja;
    }

    public function getReadAt(){
        $getReadAt = Disposisiuser::where('user_id', Auth::user()->id)
            ->where('kategori_id', 1)
            ->get();

        foreach($getReadAt as $read_at){
            if($read_at->read_at == null){
                return 0;
                break;
            }
        }
        return 1;
    }
}
