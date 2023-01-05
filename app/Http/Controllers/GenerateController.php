<?php

namespace App\Http\Controllers;

use App\Models\Generate;
use App\Models\Surat;
use App\Models\Template;
use App\Models\Jenis;
use App\Models\User;
use App\Models\Catatan;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Kode;
use App\Models\PihakTTD;
use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\Response;
use App\Models\Files;
use App\Models\Disposisi;
use App\Models\Disposisiuser;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use \Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use \PhpOffice\PhpWord\TemplateProcessor;

class GenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $user = Auth::user();
        if($request->input('tahun')){
            if($user->isAdmin()){
                $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        // ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 2)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->whereYear('surat.tanggal', $request->tahun)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }else{
                $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 2)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->whereYear('surat.tanggal', $request->tahun)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }
        }else{
            if($user->isAdmin()){
                $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        // ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 2)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }else{
                $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('disposisi_user.kategori_id', 2)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }
        }
        $nav = 'transaksi';
        $menu = 'keluar';
        // dd($generate);
        return view('surat keluar.index', compact('nav', 'menu', 'generate', 'user', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Template $template)
    {
        //
        $nav = 'transaksi';
        $menu = 'buat';
        $jenis = Jenis::all();
        $dosen = Dosen::all();
        $mahasiswa = Mahasiswa::all();
        $user = Auth::user();
        $user_dosen = Dosen::join('users', 'dosen.user_id', '=', 'users.id' )->get();
        $user_mahasiswa = Mahasiswa::join('users', 'mahasiswa.user_id', '=', 'users.id' )->get();
        $response = Response::all();
        $kode = Kode::all();
        $unitKerja = UnitKerja::orwhere('nama', 'like', '%Fakultas Teknik Elektro dan Teknologi Informasi%')
            ->orwhere('nama', 'like', '%Jurusan Teknik Informatika%')
            ->orwhere('nama', 'like', '%Jurusan Sistem Informasi%')
            ->orwhere('nama', 'like', '%Jurusan Teknik Elektro%')
            ->get();
        $unit = Auth::user()->isUnitkerja();
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
        return view('surat keluar.insert', compact('nav', 'menu', 'template','kode', 'jenis', 'dosen', 'mahasiswa', 'user', 'user_dosen', 'user_mahasiswa', 'unitKerja', 'getUnit', 'response'));
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
            'jenis_id' => 'required',
            'judul' => 'required',
            'keperluan' => 'required',
            'nomor_surat' => 'required',
            'tempat_surat' => 'required',
            'perihal' => 'required',
            // 'isi' => 'required',
            'response' => 'required',
            'target_akhir' => 'required',
        ]);
        // dd($request);

        if($request->isi_body == null){
            if($request->hasFile('file')){
                $allowedfileExtension = ['pdf','doc', 'docx'];
                    $file = $request->file('file');
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $check=in_array($extension,$allowedfileExtension);
                    if($check){
                        $file_name = now()->timestamp . '_' .$request->judul.'_file1'.'.'.$file->getClientOriginalExtension();
                        $file->move('surat/file surat',$file_name);
                    }else{
                        return redirect()->back()->withInput()->with('warning', 'Pastikan file yang diupload berformat .doc/.docx/.pdf');
                    }
                $surat = new Surat();
                $surat->jenis_id = $request->jenis_id;
                $surat->judul = $request->judul;
                // $surat->file= $file_name;
                $surat->nosurat = $request->nomor_surat;
                $surat->tanggal = $request->tanggal_surat;
                $surat->status = 1;
                $surat->keperluan = $request->keperluan;
                $surat->save();

                $file = new Files();
                $file->surat_id = $surat->id;
                $file->file =  $file_name;
                $file->save();

                $generate = new Generate();
                $generate->surat_id = $surat->id;
                $generate->kode_id = $request->kode_id;
                $generate->tempat = $request->tempat_surat;
                $generate->save();

                $kode = Kode::find($request->kode_id);
                $update_increment = DB::table('kode')
                    ->where('id', $request->kode_id)
                    ->update([
                        'increment' => $kode->increment+1,
                    ]);

            }else{
                return redirect()->back()->withInput()->with('warning', 'Silahkan upload file berformat .doc/.docx/.pdf');
            }
        }else{

            list($file_name, $pihak) = $this->generateSurat($request);

            $surat = new Surat();
            $surat->jenis_id = $request->jenis_id;
            $surat->judul = $request->judul;
            // $surat->file= $file_name;
            $surat->nosurat = $request->nomor_surat;
            $surat->tanggal = $request->tanggal_surat;
            $surat->status = 1;
            $surat->keperluan = $request->keperluan;
            $surat->save();

            $file = new Files();
            $file->surat_id = $surat->id;
            $file->file =  $file_name;
            $file->save();

            $generate = new Generate();
            $generate->template_id = $request->template_id;
            $generate->surat_id = $surat->id;
            $generate->kode_id = $request->kode_id;
            $generate->content = $request->isi_body;
            $generate->footer_content = $request->isi_footer;
            $generate->tempat = $request->tempat_surat;
            $generate->save();

            //add pihak ttd
            $template = Template::find($request->template_id);
            for ($i=0; $i < $template->jumlah_ttd; $i++) {
                $pihak_ttd = new PihakTTD();
                $pihak_ttd->generate_id = $generate->id;
                $pihak_ttd->jabatan = $pihak[$i][0];
                $pihak_ttd->nip = $pihak[$i][1];
                $pihak_ttd->save();
            }

            $kode = Kode::find($request->kode_id);
            $update_increment = DB::table('kode')
                ->where('id', $request->kode_id)
                ->update([
                    'increment' => $kode->increment+1,
                ]);


        }

        $catatan = new Catatan();
        $catatan->surat_id = $surat->id;
        $catatan->user_id = Auth::user()->id;
        if($request->catatan_surat == null){
            $catatan->catatan = 'Menambah data surat pada nomor surat '. $request->nomor_surat;
        }else{
            $catatan->catatan = 'Menambah data surat pada nomor surat '. $request->nomor_surat. ', (catatan : '. $request->catatan_surat. ').';
        }
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        $catatan->save();

        return app('App\Http\Controllers\DisposisiController')->store($request, $surat->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Generate  $generate
     * @return \Illuminate\Http\Response
     */
    public function show(Surat $surat)
    {
        //
        $disposisi = Disposisi::join('disposisi_user', 'disposisi.id', '=', 'disposisi_user.disposisi_id')
            ->where('disposisi.surat_id', $surat->id)
            ->where('disposisi_user.user_id', Auth::user()->id)
            ->where('disposisi_user.status', 2)
            ->select('disposisi_user.*')->first();

        // dd($disposisi);
        if($disposisi != null){
            $update_read_at = DB::table('disposisi_user')
                // ->where('user_id', Auth::user()->id)
                ->where('disposisi_user.id', $disposisi->id)
                ->update(['read_at' => 1,]);
        }

        $notifikasi = Notifikasi::where('user_id', Auth::user()->id)->get();
        foreach($notifikasi as $update_notifikasi){
            $update = DB::table('notifikasi')
                ->where('id', $update_notifikasi->id)
                ->update([
                    'read_at' => 1
                ]);
        }

        $nav = 'transaksi';
        $menu = 'keluar';
        $user = Auth::user();
        return view('surat keluar.show', compact('nav', 'menu', 'surat', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Generate  $generate
     * @return \Illuminate\Http\Response
     */
    public function edit(Surat $surat)
    {
        //
        $nav = 'transaksi';
        $menu = 'keluar';
        $jenis = Jenis::all();
        $user = Auth::user();
        $file = Files::where('surat_id', $surat->id)->get();
        $generate = Generate::where('surat_id', $surat->id)
                    ->select('generate.*')
                    ->first();
                    // dd($generate);
        if($generate->content == null){
            return view('surat keluar.update_instant', compact('nav', 'menu', 'jenis' ,'surat', 'generate', 'user', 'file'));

        }else{
            $generate = Generate::join('template', 'template.id', '=', 'generate.template_id')
                        ->where('surat_id', $surat->id)
                        ->select('generate.*')
                        ->first();
            $pihak_ttd = PihakTTD::where('generate_id', $generate->id)->get();
            $dosen = Dosen::all();
            $mahasiswa = Mahasiswa::all();
            return view('surat keluar.update', compact('nav', 'menu', 'jenis', 'surat', 'generate', 'pihak_ttd', 'dosen', 'mahasiswa', 'user', 'file'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Generate  $generate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Surat $surat)
    {
        //
        // dd($request);
        $request->validate([
            'jenis_id' => 'required',
            'nomor_surat' => 'required',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'keperluan' => 'required',
            'catatan' => 'nullable',
            // 'file' => 'mimes:docx,doc,pdf',
        ]);


        $generate = Generate::find($request->generate_id);
        if($generate->content == null){
            $surat->jenis_id = $request->jenis_id;
            $surat->nosurat = $request->nomor_surat;

            // $surat->file= $file_name;
            $surat->judul = $request->judul;
            $surat->tanggal = $request->tanggal;
            $surat->keperluan = $request->keperluan;
            $surat->save();

            // $generate = Generate::find($request->generate_id);
            $generate->tempat = $request->tempat_surat;
            $generate->save();

        }else{

            //hapus surat lama
            $filelamaSurat = Files::where('surat_id', $surat->id)->first();
            $hapusfile = public_path('surat/file surat/'.$filelamaSurat->file);
            // dd($hapusfile);
            File::delete($hapusfile);

            list($file_name, $pihak) = $this->generateSurat($request);

            $files = Files::find($filelamaSurat->id);
            $files->file = $file_name;
            $files->save();

            $surat->jenis_id = $request->jenis_id;
            // $surat->nosurat = $request->nomor;
            $surat->judul = $request->judul;
            $surat->tanggal = $request->tanggal;
            $surat->keperluan = $request->keperluan;
            $surat->save();

            $generate = Generate::find($request->generate_id);
            $generate->tempat = $request->tempat_surat;
            $generate->content = $request->isi_body;
            $generate->footer_content = $request->isi_footer;
            $generate->save();

            $template = Template::find($request->template_id);
            for ($x=1; $x <= $template->jumlah_ttd; $x++) {
                $jabatan = 'jabatan_'.$x;
                $req_jabatan = $request->$jabatan;

                $tertanda = 'tertanda_'.$x;
                $req_tertanda = $request->$tertanda;

                $id = 'ttd_id_'.$x;
                $req_id = $request->$id;

                $update_status = DB::table('pihak_ttd')
                                ->where('id', $req_id)
                                ->update([
                                    'jabatan' => $req_jabatan,
                                    'nip' => $req_tertanda,
                                ]);
            }
        }

        if($surat){
            $catatan = new Catatan();
            $catatan->user_id = Auth::user()->id;
            $catatan->surat_id = $surat->id;
            if($request->catatan == null){
                $catatan->catatan = 'Mengubah data surat pada nomor surat '. $request->nomor_surat;
            }else{
                $catatan->catatan = 'Mengubah data surat pada nomor surat '. $request->nomor_surat. ', (catatan : '. $request->catatan. ').';
            }
            $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        }

        if($catatan){
            $catatan->save();
            return redirect()->route('show.surat.keluar', $surat)->with('success', 'Data berhasil di update !!');
        }else{
            return back()->with('error', 'Data gagal di update !!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Generate  $generate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surat $surat)
    {
        //
        $surat->status = 0;
        $surat->save();

        $catatan = new Catatan();
        $catatan->user_id = Auth::user()->id;
        $catatan->surat_id = $surat->id;
        $catatan->catatan = 'Menghapus data surat pada nomor surat '. $surat->nosurat;
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        $catatan->save();

        if($surat){
            return redirect()->route('index.surat.keluar')->with('success', 'Data berhasil di hapus !!');
        }else{
            return back()->with('warning', 'Data gagal di hapus !!');
        }
    }

    // public function getGenerate($surat_id){
    //     $getGenerate = Generate::join('surat', 'surat.id', '=', 'generate.surat_id')
    //             ->where('generate.surat_id', $surat_id)
    //             ->select('generate.*')
    //             ->get();
    //             // dd($getGenerate);
    //     return $getGenerate;
    // }

    public function downloadFile(Surat $surat){

        $files = Files::where('surat_id', $surat->id)->get();
        // dd($files);
        $zip      = new \ZipArchive;
        $fileName = 'Downloads_'. $surat->judul. '.zip';

        if ($zip->open(public_path('/surat/download/'.$fileName), \ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file){
                // dd($file);
                $path =  public_path('surat/file surat/'.$file->file);
                $relativeName = basename($path);
                $zip->addFile($path, $relativeName);
            }
            $zip->close();
        }

        return response()->download(public_path('/surat/download/'.$fileName));
    }

    public function index_template(){
        $nav = 'transaksi';
        $menu = 'keluar';
        $template = Template::all();
        $user = Auth::user();
        return view('surat keluar.index_template', compact('nav', 'menu', 'template', 'user'));
    }

    //function generate surat tanpa template
    public function createInstant(){
        // dd('sini');
        $nav = 'transaksi';
        $menu = 'buat';
        $jenis = Jenis::all();
        $user_dosen = Dosen::join('users', 'dosen.user_id', '=', 'users.id' )->get();
        $user_mahasiswa = Mahasiswa::join('users', 'mahasiswa.user_id', '=', 'users.id' )->get();
        $response = Response::all();
        $user = Auth::user();

        $unitKerja = UnitKerja::orwhere('nama', 'like', '%Fakultas Teknik Elektro dan Teknologi Informasi%')
            ->orwhere('nama', 'like', '%Jurusan Teknik Informatika%')
            ->orwhere('nama', 'like', '%Jurusan Sistem Informasi%')
            ->orwhere('nama', 'like', '%Jurusan Teknik Elektro%')
            ->get();
        $unit = Auth::user()->isUnitkerja();
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
        return view('surat keluar.insert_instant', compact('nav', 'menu', 'jenis', 'user_dosen', 'user_mahasiswa', 'response', 'user', 'unitKerja', 'getUnit'));
    }

    public function generateSurat($request){
        $template = Template::find($request->template_id);
        $docs = public_path('surat/template/').$template->file;

        $date = Carbon::parse($request->tanggal_surat)->isoFormat("D MMMM YYYY");
        // cek template
        if (file_exists($docs)) {

            //generate surat
            $templateProcessor = new TemplateProcessor($docs);
            $templateProcessor->setValue('tempat_surat', $request->tempat_surat);
            $templateProcessor->setValue('tanggal_surat', $date);

            try {
                //add html to word
                $isiBody = str_replace('<br>','&nbsp;',$request->isi_body);
                $word = new PhpWord();
                $section = $word->addSection();
                Html::addHtml($section, $isiBody, false, false);
                $containers = $section->getElements();
                $templateProcessor->cloneBlock('body', count($containers), true, true);
                for($i = 0; $i < count($containers); $i++) {
                    $templateProcessor->setComplexBlock('isiBody#' . ($i+1), $containers[$i]);
                }

                //set pihak bersangkutan
                for($j = 1; $j <= $template->jumlah_ttd; $j++){
                    $jabatan = 'jabatan_'.$j;
                    $req_jabatan = $request->$jabatan;
                    $templateProcessor->setValue($jabatan, $req_jabatan);

                    $tertanda = 'tertanda_'.$j;
                    $req_tertanda = $request->$tertanda;
                    $tujukan = $this->getUser($req_tertanda);

                    $nama = 'nama_'.$j;
                    $nip = 'nip_'.$j;
                    foreach($tujukan as $tuju){
                        $templateProcessor->setValue($nama, $tuju->nama);
                        $templateProcessor->setValue($nip, $tuju->id);

                        $pihak[] = array($request->$jabatan, $tuju->id);
                    }
                }

                if($request->isi_footer != null){
                    $isiFooter = str_replace('<br>','&nbsp;',$request->isi_footer);
                    $word = new PhpWord();
                    $section = $word->addSection();
                    Html::addHtml($section, $isiFooter, false, false);
                    $containers = $section->getElements();
                    $templateProcessor->cloneBlock('footer', count($containers), true, true);
                    for($i = 0; $i < count($containers); $i++) {
                        $templateProcessor->setComplexBlock('isiFooter#' . ($i+1), $containers[$i]);
                    }
                }

            } catch (\Throwable $th) {
                return redirect()->back()->withInput()->with('warning', 'Terjadi kesalahan dalam penulisan isi content atau footer content, Silahkan Ubah !!');
            }

            $fileSurat = now()->timestamp . '_'  .$request->judul.'.docx';
            $templateProcessor->saveAs($fileSurat);

            // Pindah file
            File::move(public_path() . '/' . $fileSurat, public_path('surat/file surat/'.$fileSurat));

            return $this->setNomor($request, $fileSurat, $pihak);

        }else{
            return back()->with('warning', 'Berkas tidak ditemukan !!');
        }
    }

    //set nomor dan mengubah surat
    public function setNomor($request, $suratFile, $pihak){
        $suratLama = public_path('surat/file surat/').$suratFile;
        if (file_exists($suratLama)) {
            //generate surat
            $templateProcessor = new TemplateProcessor($suratLama);
            $templateProcessor->setValue('nomor_surat', $request->nomor_surat);

            $file_name = now()->timestamp . '_'  .$request->judul.'_file1'. '.docx';
            $templateProcessor->saveAs($file_name);
            //hapus surat lama
            File::delete($suratLama);

            // Pindah file surat Baru
            File::move(public_path() . '/' .$file_name, public_path('surat/file surat/').$file_name);

            // return $file_name and $pihak;
            return [$file_name, $pihak];
        }
    }

    // get pihak yang bersangkutan
    public function getUser($user_id){
        $dosen = Dosen::where('id', $user_id)->get();
        $mahasiswa = Mahasiswa::where('id', $user_id)->get();

        if($dosen->isNotEmpty()){
            return $dosen;
        }else if($mahasiswa->isNotEmpty()){
            return $mahasiswa;
        }
    }

    //form generate nomor surat
    public function getKode(Request $request){
        $id = $request->get('id');
        $data['kode'] = kode::where('unit_kerja_id', $id)->get();
        return response()->json($data);
    }

    //generate nomor surat
    public function generateNomor(Request $request){

        $kode = Kode::find($request->input('kode_id'));
        $formatSisipan = $request->input('sisipan');

        // karna array dimulai dari 0 maka kita tambah di awal data kosong
        $noUrutAkhir = Generate::where('kode_id', $kode->id)->count();

        // bisa juga mulai dari "1"=>"I"
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

        // if(!$noUrutAkhir && $request->input('sisipan') == 'true'){
        //     $data = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
        //             ->join('generate', 'surat.id', '=', 'generate.surat_id')
        //             ->join('kode', 'kode.id', '=', 'generate.kode_id')
        //             ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
        //             ->where('kategori_id', 2)
        //             ->where('surat.nosurat', 'like', '%'.$kode->kode.'%')
        //             ->whereDate('surat.tanggal', '<=', $request->input('tanggal'))
        //             ->count();

        //     $nomor = str_replace('{nomor_urut}',sprintf("%0".$request->input('digit')."s", $data),$kode->penomoran);
        //     $nomor = str_replace('{kode}',$kode->kode,$nomor);
        //     $nomor = str_replace('{bulan}',$bulanRomawi[date('n')],$nomor);
        //     $nomor = str_replace('{tahun}',date('Y'),$nomor);

        // }elseif($noUrutAkhir && $request->input('sisipan') != 'true') {
        //     //pengecekkan reset nomor
        //     $suratLast = Generate::select('created_at')->groupBy('created_at')->latest()->first();
        //     $tahun = date('Y',strtotime($suratLast->created_at));

        //     if($request->input('sisipan') != 'true' && date('Y') > (int) $tahun){
        //             $nomor = str_replace('{nomor_urut}',sprintf("%0".$request->input('digit')."s", 1),$kode->penomoran);
        //             $nomor = str_replace('{kode}',$kode->kode,$nomor);
        //             $nomor = str_replace('{bulan}',$bulanRomawi[date('n')],$nomor);
        //             $nomor = str_replace('{tahun}',date('Y'),$nomor);
        //     }else{
        //         // $nomor = 'lanjut';
        //         $nomor = str_replace('{nomor_urut}',sprintf("%0".$request->input('digit')."s", abs($noUrutAkhir + 1)),$kode->penomoran);
        //         $nomor = str_replace('{kode}',$kode->kode,$nomor);
        //         $nomor = str_replace('{bulan}',$bulanRomawi[date('n')],$nomor);
        //         $nomor = str_replace('{tahun}',date('Y'),$nomor);
        //         // $nomor = sprintf("%03s", abs($noUrutAkhir + 1)) .'/'. $kode->kode .'/'. 'ITATS/' . $bulanRomawi[date('n')] .'/'. date('Y');
        //     }

        // }else {
        //     $nomor = str_replace('{nomor_urut}',sprintf("%0".$request->input('digit')."s", 1),$kode->penomoran);
        //     $nomor = str_replace('{kode}',$kode->kode,$nomor);
        //     $nomor = str_replace('{bulan}',$bulanRomawi[date('n')],$nomor);
        //     $nomor = str_replace('{tahun}',date('Y'),$nomor);
        //     // $nomor = sprintf("%03s", 1) .'/'. $kode->kode .'/'. 'ITATS/' . $bulanRomawi[date('n')] .'/'. date('Y');
        // }

        $nomor = str_replace('{nomor_urut}',sprintf("%0".$request->input('digit')."s", $kode->increment),$kode->penomoran);
        $nomor = str_replace('{kode}',$kode->kode,$nomor);
        $nomor = str_replace('{bulan}',$bulanRomawi[date('n')],$nomor);
        $nomor = str_replace('{tahun}',date('Y'),$nomor);

        return response()->json([
            'nomor' => $nomor,
            'kode_id' => $kode->id
        ]);
    }

    public function readAtKeluar($surat_id){
        $getReadAt = Surat::join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
            ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
            // ->where('surat.status', '!=', 0)
            ->where('surat.id', $surat_id)
            // ->where('disposisi_user.status', 2)
            ->where('disposisi_user.kategori_id', 2)
            ->where('disposisi_user.user_id', Auth::user()->id)
            ->select('disposisi_user.*')
            ->distinct()->first();
        // dd($getReadAt);
        return $getReadAt;
    }

    public function getReadAtKeluar(){
        $getReadAt = Disposisiuser::where('user_id', Auth::user()->id)
            ->where('status', 2)
            ->where('kategori_id', 2)
            ->get();

        // dd($getReadAt);
        foreach($getReadAt as $read_at){
            if($read_at->read_at == 0){
                return 0;
                break;
            }
        }
        return 1;
    }
}
