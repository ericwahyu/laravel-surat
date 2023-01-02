<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Catatan;
use App\Models\Response;
use App\Models\Dosen;
use App\Models\RoleDosen;
use App\Models\Role;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    //
    public function indexSurat(){
        $nav = 'master';
        $menu = 'surat';
        $data = Surat::latest()->get();

        return view('master.surat.index', compact('nav', 'menu', 'data'));
    }

    public function editSurat(Surat $surat){
        $nav = 'master';
        $menu = 'surat';

        return view('master.surat.update', compact('nav', 'menu', 'surat'));
    }

    public function updateSurat(Request $request, Surat $surat){
        if($request->status != $surat->status){
            $catatan = new Catatan();
            $catatan->user_id = Auth::user()->id;
            $catatan->surat_id = $surat->id;
            if($request->status == 1){
                $catatan->catatan = 'Admin mengaktifkan kembali surat dengan nomor : '. $surat->nosurat;
            }elseif($request->status == 0){
                $catatan->catatan = 'Admin menonaktifkan surat dengan nomor : '. $surat->nosurat;
            }
            $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
            $catatan->save();
        }
        $surat->status = $request->status;
        $surat->save();


        return redirect()->route('index.masterSurat')->with('success', 'Data berhasil di update !!');
    }

    public function indexResponse(){
        $nav = 'master';
        $menu = 'response';
        $data = Response::all();

        return view('master.response.index', compact('nav', 'menu', 'data'));
    }

    public function createResponse(){
        $nav = 'master';
        $menu = 'response';

        return view('master.response.insert', compact('nav', 'menu'));
    }

    public function storeResponse(Request $request){
        $request->validate([
            'nama' => 'required'
        ]);

        $response = new Response();
        $response->nama = $request->nama;
        $response->save();

        return redirect()->route('index.masterResponse')->with('success', 'Data berhasil di tambah !!');
    }

    public function editResponse(Request $request, Response $response){
        $nav = 'master';
        $menu = 'response';

        return view('master.response.update', compact('nav', 'menu', 'response'));
    }

    public function updateResponse(Request $request, Response $response){
        $request->validate([
            'nama' => 'required'
        ]);

        $response->nama = $request->nama;
        $response->save();

        return redirect()->route('index.masterResponse')->with('success', 'Data berhasil di update !!');
    }

    public function destroyResponse(Response $response){
        $response->delete();
        return redirect()->route('index.masterResponse')->with('success', 'Data berhasil di hapus !!');
    }

    public function getRoleDosen($dosen_id){
        $getRoleDosen = RoleDosen::join('role', 'role_dosen.role_id', '=', 'role.id')
            ->where('dosen_id', $dosen_id)
            ->get();

        return $getRoleDosen;
    }

    public function indexRoleDosen(){
        $nav = 'master';
        $menu = 'roleDosen';
        $data = Dosen::all();
        // dd($data);
        return view('master.role dosen.index', compact('nav', 'menu', 'data'));

    }

    public function settingRoleDosen(Dosen $dosen){
        $nav = 'master';
        $menu = 'roleDosen';

        $getRoleDosen = RoleDosen::join('role', 'role_dosen.role_id', '=', 'role.id')
            ->where('dosen_id', $dosen->id)
            ->select('role_dosen.*')
            ->get();

        $role = Role::all();

        // dd($getRoleDosen);
        return view('master.role dosen.setting', compact('nav', 'menu', 'dosen', 'getRoleDosen', 'role'));
    }

    public function storeRoleDosen(Dosen $dosen, Request $request){
        $roleDosen = new RoleDosen();
        $roleDosen->dosen_id = $dosen->id;
        $roleDosen->role_id = $request->role_id;
        $roleDosen->save();

        return redirect()->route('index.masterRoleDosen')->with('success', 'Berhasil menambah role !!');
    }

    public function updateRoleDosen(RoleDosen $roleDosen, Request $request)
    {
        $roleDosen->role_id = $request->role_id;
        $roleDosen->save();

        return redirect()->route('setting.masterRoleDosen', $roleDosen->dosen_id)->with('success', 'Berhasil mengubah role !!');
    }

    public function destroyRoleDosen(RoleDosen $roleDosen)
    {
        $roleDosen->delete();
        return redirect()->route('setting.masterRoleDosen', $roleDosen->dosen_id)->with('success', 'Berhasil menghapus role !!');
    }
}
