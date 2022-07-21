<?php

namespace App\Http\Controllers;

use App\Models\Generate;
use App\Models\Surat;
use App\Models\Template;
use App\Models\Jenis;
use App\Models\User;
use App\Models\Catatan;
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
        $generate = Surat::join('jenis', 'jenis.id', '=', 'surat.jenis_id')
                    ->join('kategori', 'kategori.id', '=', 'jenis.kategori_id')
                    ->where('status', '!=', 0)
                    ->where('kategori_id', 2)->get(['surat.*']);
        return view('surat keluar.index', compact('nav', 'menu', 'generate'));
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
        $user = User::all();

        if(file_exists(public_path('surat/template/'.$template->file))){
            switch($template->file){
                case('1658407481_Surat Permohonan Beasiswa.docx'):
                    return view('surat keluar.layout template.surat permohonan beasiswa', compact('nav', 'menu', 'template', 'jenis', 'user'));
                    break;

                case('1658386692_Surat Keterangan Aktif Kuliah.docx'):
                    return view('surat keluar.layout template.surat keterangan aktif kuliah', compact('nav', 'menu', 'template', 'jenis', 'user'));
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

        $surat = new Surat();
        $surat->jenis_id = $request->jenis_id;
        $surat->judul = $request->judul;
        $surat->nosurat = $request->nomor_surat;
        $surat->tanggal = $request->tanggal_surat;
        $surat->status = 1;
        $surat->keterangan = $request->keterangan;
        $surat->save();

        $catatan = new Catatan();
        $catatan->surat_id = $surat->id;
        if($request->catatan == null){
            $catatan->catatan = 'Menambah data surat keluar dengan nomor '. $request->nomor_surat;
        }else{
            $catatan->catatan = 'Menambah data surat keluar dengan nomor '. $request->nomor_surat. ', ('. $request->catatan. ').';
        }
        $catatan->waktu = Carbon::now()->format('Y-m-d H:i:s');
        $catatan->save();

        $generate = new Generate();
        $generate->template_id = $request->template_id;
        $generate->surat_id = $surat->id;
        $generate->save();

        return $this->surat_permohonan_beasiswa($request, $surat->id);

        // $surat = Generate::orderByDesc('id')->limit(1)->first();
        // if (is_null($surat)) {
        //     $nosurat = $huruf. '.' .str_pad(1, 4, "0", STR_PAD_LEFT) . '/' . $unit . '/' . "ITATS" . '/' . date('Y');
        // } else {
        //     $nosurat = $huruf. '.' .str_pad($surat->id++, 4, "0", STR_PAD_LEFT) . '/' . $unit . '/' . "ITATS" . '/' . date('Y');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Generate  $generate
     * @return \Illuminate\Http\Response
     */
    public function show(Generate $generate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Generate  $generate
     * @return \Illuminate\Http\Response
     */
    public function edit($generate)
    {
        //
        $nav = 'datasurat';
        $menu = 'keluar';
        $generate = DB::table('generate')
                ->join('surat', 'generate.surat_id', '=', 'surat.id')
                ->selectRaw('surat.*')
                ->join('kategori', 'surat.kategori_id', '=', 'kategori.id')
                ->where('generate.id', '=', $generate)
                ->get();
        return view('surat keluar.update', compact('nav', 'menu', 'generate'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Generate  $generate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $generate)
    {
        //
        $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date'
        ]);
        $generate = Surat::find($generate);

        $generate->nama = $request->nama;
        $generate->tglkeluar = $request->tanggal;

        if(!$generate){
            return back()->with('error', 'Data gagal di Update !!');
        }else{
            $generate->save();
            return redirect()->route('index.surat.keluar')->with('success', 'Data berhasil di Update !!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Generate  $generate
     * @return \Illuminate\Http\Response
     */
    public function destroy($generate)
    {
        //
        $generate = Surat::find($generate);
        $filelama = public_path('surat/generate/'.$generate->file);

        if(!$generate){
            return back()->with('error', 'Data gagal di Update !!');
        }else{
            File::delete($filelama);
            $generate->delete();
            return redirect()->route('index.surat.keluar')->with('success', 'Data berhasil di Update !!');
        }
    }

    public function index_template(){
        $nav = 'transaksi';
        $menu = 'keluar';
        // $jenis = Jenis::where('kategori_id', 2)->get();
        $template = Template::all();
        return view('surat keluar.index_template', compact('nav', 'menu', 'template'));
    }

    // generate docx

    public function surat_permohonan_beasiswa($request, $surat_id){
        $surat = Surat::find($surat_id);
        $template = Template::find($request->template_id);
        $pihak = User::find($request->pihak_1);
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
            $templateProcessor->setValue('data_1', $request->data_1);
            $templateProcessor->setValue('paragraf_2', $request->paragraf_2);
            $templateProcessor->setValue('data_2', $request->data_2);
            $templateProcessor->setValue('penutup_surat', $request->penutup_surat);
            $templateProcessor->setValue('pihak_1', $pihak->username);

            $file_name = now()->timestamp . '_' . $request->judul . '.docx';
            $templateProcessor->saveAs($file_name);

            $surat->file_surat = $file_name;
            $surat->save();

            // Pindah file
            File::move(public_path() . '/' . $file_name, public_path('surat/generate/') .$file_name);

            return redirect()->route('index.surat.keluar')->with('success', 'Surat berhasil di generate !!');
        }
    }
}
