<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Generate;
use App\Models\Surat;
use App\Models\Template;
use App\Models\Jenis;
use App\Models\User;
use App\Models\Catatan;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Keperluan;
use App\Models\PihakTTD;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use \Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    //
    public function index(){
        $nav = 'transaksi';
        $menu = 'search';
        return view('search.index', compact('nav', 'menu'));
    }

    public function search(Request $request){
        $user = Auth::user();
        if($request->ajax()){
            $search = $request->get('query');
            if($user->isAdmin() == 1){
                $suratMasuk = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                    ->where('surat.status', '!=', 0)
                    ->where('kategori_id', 1)
                    ->where(function($query) use($search){
                        $query->where('surat.judul', 'like' , '%'. $search .'%')
                            ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                            ->orwhereYear('surat.tanggal', $search)
                            ->orwhere('surat.keterangan', 'LIKE','%'.$search.'%');
                        })
                    ->select('surat.*')
                    ->distinct()->latest()->get();
            }else{
                $suratMasuk = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('kategori_id', 1)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->where(function($query) use($search){
                            $query->where('surat.judul', 'like' , '%'. $search .'%')
                                ->orwhere('surat.nosurat', 'LIKE','%'.$search.'%')
                                ->orwhereYear('surat.tanggal', $search)
                                ->orwhere('surat.keterangan', 'LIKE','%'.$search.'%');
                            })
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }
            return response()->json([
                'suratMasuk' => $suratMasuk
            ]);
        }
    }
}
