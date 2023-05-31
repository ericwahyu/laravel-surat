<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Carbon;

class NotifikasiController extends Controller
{

    public function index()
    {
        //
        $notification = '';
        $notifikasi = Notifikasi::where('user_id', Auth::user()->id)->latest()->get();

        foreach($notifikasi as $notif){
            if(preg_match("/surat baru/i", $notif->message)){
                $disposisi_user = Notifikasi::join('disposisi_user', 'notifikasi.disposisi_user_id', '=', 'disposisi_user.id')
                    ->join('disposisi', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->where('notifikasi.user_id', Auth::user()->id)
                    ->where('disposisi_user.id', $notif->disposisi_user_id)
                    ->select('disposisi_user.*')
                    ->first();

                $kategori = Disposisi::join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('disposisi_id', $disposisi_user->disposisi_id)
                    ->where('user_id', Auth::user()->id)
                    ->first();

                if($notif->read_at == 0){
                    $color = '#E8E7FF';
                }elseif($notif->read_at == 1){
                    $color = '#FFFFFF';
                }

                $created = new Carbon($notif->created_at);
                $now = Carbon::now();
                $difference = ($created->diff($now)->days < 1)
                    ? 'HARI INI'
                    : $created->diffForHumans($now);

                switch($kategori->kategori_id){
                    case(1):
                        // $menu = 'masuk';
                        $notification .= '
                            <a href="'.route('show.surat.masuk', $kategori->surat_id).'" class="dropdown-item" style="background-color: '.$color.'">
                                <div class="dropdown-item-icon bg-info text-white">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    '.$notif->message.'
                                    <div class="time text-primary">'.$difference.'</div>
                                </div>
                            </a>';
                    break;
                    case(2):
                        // $menu = 'keluar';
                        $notification .= '
                            <a href="'.route('show.surat.keluar', $kategori->surat_id).'" class="dropdown-item" style="background-color: '.$color.'">
                                <div class="dropdown-item-icon bg-info text-white">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    '.$notif->message.'
                                    <div class="time text-primary">'.$difference.'</div>
                                </div>
                            </a>';
                        break;
                    }
            }elseif(preg_match("/memberikan response/i", $notif->message)){
                $disposisi_user = Notifikasi::join('disposisi_user', 'notifikasi.disposisi_user_id', '=', 'disposisi_user.id')
                    ->join('disposisi', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->where('notifikasi.user_id', Auth::user()->id)
                    ->where('disposisi_user.id', $notif->disposisi_user_id)
                    ->select('disposisi_user.*')
                    ->first();
                if($notif->read_at == 0){
                    $color = '#E8E7FF';
                }elseif($notif->read_at == 1){
                    $color = '#FFFFFF';
                }

                $created = new Carbon($notif->created_at);
                $now = Carbon::now();
                $difference = ($created->diff($now)->days < 1)
                    ? 'HARI INI'
                    : $created->diffForHumans($now);

                $notification .= '
                    <a href="'.route('show.disposisi', $disposisi_user->disposisi_id).'" class="dropdown-item" style="background-color: '.$color.'">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            '.$notif->message.'
                            <div class="time text-primary">'.$difference.'</div>
                        </div>
                    </a>';
            }
        }

        $notifikasiReadAt = Notifikasi::where('user_id', Auth::user()->id)
            ->where('read_at', 0)
            ->first();
        if($notifikasiReadAt != null){
            $readAt = 0;
        }else{
            $readAt = 1;
        }
            // dd($readAt);
        $data = array(
            'data_notifikasi' => $notification,
            'data_readAt' => $readAt
        );
        echo json_encode($data);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Notifikasi $notifikasi)
    {
        //
    }

    public function edit(Notifikasi $notifikasi)
    {
        //
    }

    public function update(Request $request, Notifikasi $notifikasi)
    {
        //
    }

    public function destroy(Notifikasi $notifikasi)
    {
        //
    }
}
