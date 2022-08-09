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
    public function index()
    {
        //
        $nav = 'transaksi';
        $menu = 'keluar';
        $user = Auth::user();
        if($user->isAdmin() == 1){
            $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                    ->where('surat.status', '!=', 0)
                    ->where('kategori_id', 2)
                    ->select('surat.*')
                    ->distinct()->get();
        }else{
            $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                    ->join('disposisi', 'disposisi.surat_id', '=', 'surat.id')
                    ->join('disposisi_user', 'disposisi_user.disposisi_id', '=', 'disposisi.id')
                    ->join('users', 'disposisi_user.user_id', '=', 'users.id')
                    ->where('surat.status', '!=', 0)
                    ->where('kategori_id', 2)
                    ->where('disposisi_user.user_id', Auth::user()->id)
                    ->select('surat.*')
                    ->distinct()
                    ->get();
        }
        // dd($generate);
        return view('surat keluar.index', compact('nav', 'menu', 'generate', 'user'));
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

        if(file_exists(public_path('surat/template/'.$template->file))){
            switch($template->file){
                case('template surat permohonan beasiswa.docx'):
                    return view('surat keluar.layout template.surat permohonan beasiswa', compact('nav', 'menu', 'template', 'jenis', 'dosen', 'mahasiswa'));
                    break;

                case('template surat keterangan aktif kuliah.docx'):
                    return view('surat keluar.layout template.surat keterangan aktif kuliah', compact('nav', 'menu', 'template', 'jenis', 'dosen', 'mahasiswa'));
                break;
            }
        }else{
            return back()->with('error', 'Berkas tidak ditemukan !!');
        }
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
            'keterangan' => 'required',
            'catatan' => 'nullable',
        ]);

        // dd($request);
        $surat = new Surat();
        $surat->jenis_id = $request->jenis_id;
        $surat->judul = $request->judul;
        $surat->nosurat = $request->nomor_surat;
        $surat->tanggal = $request->tanggal_surat;
        $surat->status = 1;
        $surat->keterangan = $request->keterangan;
        $surat->save();

        $generate = new Generate();
        $generate->template_id = $request->template_id;
        $generate->surat_id = $surat->id;
        $generate->save();

        $catatan = new Catatan();
        $catatan->surat_id = $surat->id;
        $catatan->user_id = Auth::user()->id;
        if($request->catatan == null){
            $catatan->catatan = 'Menambah data surat keluar dengan nomor '. $request->nomor_surat;
        }else{
            $catatan->catatan = 'Menambah data surat keluar dengan nomor '. $request->nomor_surat. ', ('. $request->catatan. ').';
        }
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        $catatan->save();


        $surat = Surat::find($surat->id);

        //cari nama untuk ttd
        $tujukan = Mahasiswa::where('user_id', $request->tertanda_1)->get();
        $tujukan = Dosen::where('user_id', $request->tertanda_1)->get();

        $template = Template::find($request->template_id);

        if(file_exists(public_path('surat/template/'.$template->file))){
            switch($template->file){
                case('template surat permohonan beasiswa.docx'):
                    $file_surat = $this->TP_surat_permohonan_beasiswa($request, $tujukan);
                    break;

                case('template surat keterangan aktif kuliah.docx'):
                    $file_surat = $this->TP_surat_keterangan_aktif($request, $tujukan);
                    break;
            }
        }

        //merubah file_surat
        $surat->file_surat = $file_surat;
        $surat->save();

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
        return view('surat keluar.update', compact('nav', 'menu', 'jenis', 'surat'));

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
        $request->validate([
            'jenis_id' => 'required',
            'nomor' => 'required',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'catatan' => 'nullable',
        ]);
        $surat->jenis_id = $request->jenis_id;
        $surat->nosurat = $request->nomor;
        $surat->judul = $request->judul;
        $surat->tanggal = $request->tanggal;
        $surat->keterangan = $request->keterangan;
        if($surat){
            $surat->save();

            $catatan = new Catatan();
            $catatan->user_id = Auth::user()->id;
            $catatan->surat_id = $surat->id;
            if($request->catatan == null){
                $catatan->catatan = 'Mengubah data surat keluar nomor '. $request->nomor;
            }else{
                $catatan->catatan = 'Mengubah data surat keluar nomor '. $request->nomor. ', ('. $request->catatan. ').';
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
        $catatan->catatan = 'Menghapus data surat keluar nomor '. $surat->nosurat;
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');

        $catatan->save();
        if($surat){
            return redirect()->route('index.surat.keluar')->with('success', 'Data berhasil di hapus !!');
        }else{
            return back()->with('error', 'Data gagal di hapus !!');
        }
    }

    public function download_file(Surat $surat){
        if(file_exists(public_path('surat/generate/'.$surat->file_surat))){
            return response()->download('surat/generate/'.$surat->file_surat);
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

    public function TP_surat_permohonan_beasiswa($request, $tujukan){
        $template = Template::find($request->template_id);
        $docs = public_path('surat/template/').$template->file;

        // cek template
        if (file_exists($docs)) {
            //generate surat
            $date = Carbon::parse($request->tanggal_surat)->isoFormat("D MMMM YYYY");

            $templateProcessor = new TemplateProcessor($docs);
            $templateProcessor->setValue('tempat_surat', $request->tempat_surat);
            $templateProcessor->setValue('tanggal_surat', $date);
            $templateProcessor->setValue('lampiran_surat', $request->lampiran_surat);
            $templateProcessor->setValue('perihal_surat', $request->perihal_surat);
            $templateProcessor->setValue('tujuan_surat', $request->tujuan_surat);
            $templateProcessor->setValue('pembuka_surat', $request->pembuka_surat);
            $templateProcessor->setValue('paragraf_1', $request->paragraf_1);
            $templateProcessor->setValue('paragraf_2.1', $request->paragraf_21);
            $templateProcessor->setValue('paragraf_2.2', $request->paragraf_22);
            $templateProcessor->setValue('paragraf_2.3', $request->paragraf_23);
            $templateProcessor->setValue('paragraf_2.4', $request->paragraf_24);
            $templateProcessor->setValue('paragraf_2.5', $request->paragraf_25);
            $templateProcessor->setValue('paragraf_2.6', $request->paragraf_26);
            $templateProcessor->setValue('paragraf_2.7', $request->paragraf_27);
            $templateProcessor->setValue('paragraf_3', $request->paragraf_3);
            $templateProcessor->setValue('paragraf_4.1', $request->paragraf_41);
            $templateProcessor->setValue('paragraf_4.2', $request->paragraf_42);
            $templateProcessor->setValue('paragraf_4.3', $request->paragraf_43);
            $templateProcessor->setValue('paragraf_4.4', $request->paragraf_44);
            $templateProcessor->setValue('penutup_surat', $request->penutup_surat);
            foreach($tujukan as $tuju){
                $templateProcessor->setValue('tertanda_1', $tuju->nama);
            }

            $file_name = now()->timestamp . '_' . $request->judul . '.docx';
            $templateProcessor->saveAs($file_name);

            // Pindah file
            File::move(public_path() . '/' . $file_name, public_path('surat/generate/') .$file_name);

            return $file_name;

        }else{
            return back()->with('error', 'Berkas tidak ditemukan !!');
        }

    }

    public function TP_surat_keterangan_aktif($request, $tujukan){
        $template = Template::find($request->template_id);
        $docs = public_path('surat/template/').$template->file;

        // cek template
        if (file_exists($docs)) {
            //generate surat
            $date = Carbon::parse($request->tanggal_surat)->isoFormat("D MMMM YYYY");

            $templateProcessor = new TemplateProcessor($docs);
            $templateProcessor->setValue('tempat_surat', $request->tempat_surat);
            $templateProcessor->setValue('tanggal_surat', $date);
            $templateProcessor->setValue('nomor_surat', $request->nomor_surat);
            $templateProcessor->setValue('pembuka_surat', $request->pembuka_surat);
            $templateProcessor->setValue('paragraf_2.1', $request->paragraf_21);
            $templateProcessor->setValue('paragraf_2.2', $request->paragraf_22);
            $templateProcessor->setValue('paragraf_2.3', $request->paragraf_23);
            $templateProcessor->setValue('paragraf_2.4', $request->paragraf_24);
            $templateProcessor->setValue('paragraf_2.5', $request->paragraf_25);
            $templateProcessor->setValue('paragraf_2.6', $request->paragraf_26);
            $templateProcessor->setValue('paragraf_2', $request->paragraf_2);
            $templateProcessor->setValue('penutup_surat', $request->penutup_surat);
            foreach($tujukan as $tuju){
                $templateProcessor->setValue('tertanda_1', $tuju->nama);
            }

            $file_name = now()->timestamp . '_' . $request->judul . '.docx';
            $templateProcessor->saveAs($file_name);

            // Pindah file
            File::move(public_path() . '/' . $file_name, public_path('surat/generate/') .$file_name);

            return $file_name;

        }else{
            return back()->with('error', 'Berkas tidak ditemukan !!');
        }

    }
}
