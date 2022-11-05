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
use App\Models\Keperluan;
use App\Models\PihakTTD;
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
                        ->join('keperluan', 'keperluan.id', '=', 'generate.keperluan_id')
                        ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                        ->where('surat.status', '!=', 0)
                        ->where('kategori_id', 2)
                        ->whereYear('surat.tanggal', $request->tahun)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }else{
                $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('keperluan', 'keperluan.id', '=', 'generate.keperluan_id')
                        ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('kategori_id', 2)
                        ->where('disposisi_user.user_id', Auth::user()->id)
                        ->whereYear('surat.tanggal', $request->tahun)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }
        }else{
            if($user->isAdmin()){
                $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('keperluan', 'keperluan.id', '=', 'generate.keperluan_id')
                        ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                        ->where('surat.status', '!=', 0)
                        ->where('kategori_id', 2)
                        ->select('surat.*')
                        ->distinct()->latest()->get();
            }else{
                $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                        ->join('generate', 'surat.id', '=', 'generate.surat_id')
                        ->join('keperluan', 'keperluan.id', '=', 'generate.keperluan_id')
                        ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                        ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                        ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                        ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                        ->where('surat.status', '!=', 0)
                        ->where('kategori_id', 2)
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
        $menu = 'keluar';
        $jenis = Jenis::where('kategori_id', 2)->get();
        $dosen = Dosen::all();
        $mahasiswa = Mahasiswa::all();
        $keperluan = Keperluan::all();
        // dd($keperluan);
        return view('surat keluar.insert', compact('nav', 'menu', 'template','keperluan', 'jenis', 'dosen', 'mahasiswa'));
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
        // return $this->generateSurat($request);
        // dd($request);
        $request->validate([
            'jenis_id' => 'required',
            'judul' => 'required',
            'keterangan' => 'required',
            'catatan' => 'nullable',
        ]);

        list($file_name, $pihak, $suratLama) = $this->generateSurat($request);

        $surattanpanomor = public_path('surat/generate/').$suratLama;
        File::delete($surattanpanomor);

        $surat = new Surat();
        $surat->jenis_id = $request->jenis_id;
        $surat->judul = $request->judul;
        $surat->file= $file_name;
        $surat->nosurat = $request->nomor_surat;
        $surat->tanggal = $request->tanggal_surat;
        $surat->status = 1;
        $surat->keterangan = $request->keterangan;
        $surat->save();

        $generate = new Generate();
        $generate->template_id = $request->template_id;
        $generate->surat_id = $surat->id;
        $generate->keperluan_id = $request->keperluan_id;
        $generate->content = $request->isi_body;
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

        $catatan = new Catatan();
        $catatan->surat_id = $surat->id;
        $catatan->user_id = Auth::user()->id;
        if($request->catatan == null){
            $catatan->catatan = 'Menambah data surat keluar, dengan nomor surat '. $request->nomor_surat;
        }else{
            $catatan->catatan = 'Menambah data surat keluar, dengan nomor surat '. $request->nomor_surat. ', (catatan : '. $request->catatan. ').';
        }
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        $catatan->save();

        if($surat){
            return redirect()->route('index.disposisi', $surat)->with('success', 'Surat berhasil di generate !!');
        }else{
            return back()->with('warning', 'Generate surat gagal !!');
        }
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
        $jenis = Jenis::where('kategori_id', 2)->get();
        $generate = Generate::join('template', 'template.id', '=', 'generate.template_id')
                    ->where('surat_id', $surat->id)
                    ->select('generate.*')
                    ->first();
        $pihak_ttd = PihakTTD::where('generate_id', $generate->id)->get();
        $dosen = Dosen::all();
        $mahasiswa = Mahasiswa::all();
        return view('surat keluar.update', compact('nav', 'menu', 'jenis', 'surat', 'generate', 'pihak_ttd', 'dosen', 'mahasiswa'));

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
            'nomor' => 'required',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'catatan' => 'nullable',
        ]);

        //hapus surat lama
        $suratLama = public_path('surat/generate/').$surat->file;
        File::delete($suratLama);

        list($file_name, $pihak) = $this->generateSurat($request);

        $surat->jenis_id = $request->jenis_id;
        // $surat->nosurat = $request->nomor;
        $surat->file= $file_name;
        $surat->judul = $request->judul;
        $surat->tanggal = $request->tanggal;
        $surat->keterangan = $request->keterangan;
        $surat->save();

        $generate = Generate::find($request->generate_id);
        $generate->tempat = $request->tempat_surat;
        $generate->content = $request->isi_body;
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

        if($surat){
            $catatan = new Catatan();
            $catatan->user_id = Auth::user()->id;
            $catatan->surat_id = $surat->id;
            if($request->catatan == null){
                $catatan->catatan = 'Mengubah data surat keluar, dengan nomor surat '. $request->nomor;
            }else{
                $catatan->catatan = 'Mengubah data surat keluar, dengan nomor surat '. $request->nomor. ', (catatan : '. $request->catatan. ').';
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
        $catatan->catatan = 'Menghapus data surat keluar, dengan nomor surat '. $surat->nosurat;
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');

        $catatan->save();
        if($surat){
            return redirect()->route('index.surat.keluar')->with('success', 'Data berhasil di hapus !!');
        }else{
            return back()->with('warning', 'Data gagal di hapus !!');
        }
    }

    public function getGenerate($surat_id){
        $getGenerate = Generate::join('surat', 'surat.id', '=', 'generate.surat_id')
                ->join('keperluan', 'generate.keperluan_id', '=', 'keperluan.id')
                ->where('generate.surat_id', $surat_id)
                ->select('generate.*')
                ->get();
                // dd($getGenerate);
        return $getGenerate;
    }

    public function download_file(Surat $surat){
        if(file_exists(public_path('surat/generate/'.$surat->file))){
            return response()->download('surat/generate/'.$surat->file);
        }else{
            return back()->with('error', 'Download gagal');
        }
    }

    public function index_template(){
        $nav = 'transaksi';
        $menu = 'keluar';
        $template = Template::all();
        return view('surat keluar.index_template', compact('nav', 'menu', 'template'));
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

            // try {
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

            // } catch (\Throwable $th) {
                // return back()->with('warning', 'Terjadi kesalahan dalam penulisan isi body template, Silahkan Ubah !!');
            // }

            $fileSurat = now()->timestamp . '_' . $request->judul . '.docx';
            $templateProcessor->saveAs($fileSurat);

            // Pindah file
            File::move(public_path() . '/' . $fileSurat, public_path('surat/generate/').$fileSurat);

            return $this->setNomor($request, $fileSurat, $pihak);

        }else{
            return back()->with('warning', 'Berkas tidak ditemukan !!');
        }
    }

    //set nomor dan mengubah surat
    public function setNomor($request, $suratFile, $pihak){
        $suratLama = public_path('surat/generate/').$suratFile;
        if (file_exists($suratLama)) {
            //generate surat
            $templateProcessor = new TemplateProcessor($suratLama);
            $templateProcessor->setValue('nomor_surat', $request->nomor_surat);

            $file_name = now()->timestamp . '_' .$request->judul. '.docx';
            $templateProcessor->saveAs($file_name);
            // Pindah file surat Baru
            File::move(public_path() . '/' .$file_name, public_path('surat/generate/').$file_name);
            //hapus surat lama
            // File::delete($suratLama);

            // return $file_name and $pihak;
            return [$file_name, $pihak, $suratLama];
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

    // private function addPihak($nip){
    //     $pihak[] += $nip;
    // }

    //generate nomor surat
    public function generateNomor(Request $request){
        $request->validate([
            'keperluan_id' => 'required',
        ]);
        $keperluan = Keperluan::find($request->input('keperluan_id'))->first();
        $data = $request->input('surat');

        // karna array dimulai dari 0 maka kita tambah di awal data kosong
        // bisa juga mulai dari "1"=>"I"
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $noUrutAkhir = Generate::where('keperluan_id', $keperluan->id)->count();
        if($noUrutAkhir) {
           $nomor = sprintf("%03s", abs($noUrutAkhir + 1)) .'/'. $keperluan->kode .'/'. 'ITATS/' . $bulanRomawi[date('n')] .'/'. date('Y');
        }
        else {
          $nomor = sprintf("%03s", 1) .'/'. $keperluan->kode .'/'. 'ITATS/' . $bulanRomawi[date('n')] .'/'. date('Y');
        }
        return response()->json([
            'nomor' => $nomor,
            'keperluan_id' => $keperluan->id
        ]);
    }
}
