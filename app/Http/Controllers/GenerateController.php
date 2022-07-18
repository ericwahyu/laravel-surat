<?php

namespace App\Http\Controllers;

use App\Models\Generate;
use App\Models\Surat;
use App\Models\Template;
use App\Models\Keperluan;
use App\Models\Kategori;
use App\Models\Dosen;
use App\Models\Unitkerja;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\File;
use \Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

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
        $nav = 'datasurat';
        $menu = 'keluar';
        $data = DB::table('generate')
                ->join('surat', 'generate.surat_id', '=', 'surat.id')
                ->selectRaw('surat.*')
                ->join('kategori', 'surat.kategori_id', '=', 'kategori.id')
                ->where('kategori.id','=','2')
                ->get();
        return view('surat keluar.index', compact('nav', 'menu', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nav = 'datasurat';
        $menu = 'keluar';
        $huruf = range('A', 'Z');
        $template = Template::all();
        $dosen1 = Dosen::all();
        $dosen2 = Dosen::all();
        $user = Auth::user()->id;
        $unit =  Unitkerja::where('user_id', $user)->get();
        return view('surat keluar.insert', compact('nav', 'menu', 'template', 'huruf', 'dosen1', 'dosen2', 'unit'));
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
            // 'template_id' => 'required',
            // 'judul' => 'required',
            // 'huruf' => 'required',
            // 'unit' => 'required',
            // 'isi' => 'required',
            // 'dosen1' => 'required',
            // 'dosen2' => 'required',
            // 'tanggal' => 'required|date',
            // 'keterangan' => 'nullable'
        ]);

        $template_id = $request->template_id;
        $judul = $request->judul;
        $huruf = $request->huruf;
        $unit = $request->unit;
        $isi = $request->isi;
        $dosen1 = $request->dosen1;
        $dosen2 = $request->dosen2;
        $tanggal = $request->tanggal;
        $keterangan = $request->keterangan;

        $datadosen1 = Dosen::find($dosen1);
        $datadosen2 = Dosen::find($dosen2);

        $surat = Generate::orderByDesc('id')->limit(1)->first();
        if (is_null($surat)) {
            $nosurat = $huruf. '.' .str_pad(1, 4, "0", STR_PAD_LEFT) . '/' . $unit . '/' . "ITATS" . '/' . date('Y');
        } else {
            $nosurat = $huruf. '.' .str_pad($surat->id++, 4, "0", STR_PAD_LEFT) . '/' . $unit . '/' . "ITATS" . '/' . date('Y');
        }

        //cari file template
        $template = Template::find($template_id);
        $docs = public_path('surat/template/') . $template->file;
        if (file_exists($docs)) {
            $tanggal_surat = Carbon::parse($tanggal)->isoFormat("D MMMM YYYY");

            //proses generate surat
            $templateProcessor = new TemplateProcessor($docs);
            $templateProcessor->setValue('judul_surat', $judul);
            $templateProcessor->setValue('no_surat', $nosurat);
            $templateProcessor->setValue('isi_surat', $isi);
            $templateProcessor->setValue('tanggal_surat', $tanggal_surat);
            $templateProcessor->setValue('nama_dosen_1', $datadosen1->nama);
            $templateProcessor->setValue('nip_dosen_1', $datadosen1->nip);
            $templateProcessor->setValue('nama_dosen_2', $datadosen2->nama);
            $templateProcessor->setValue('nip_dosen_2', $datadosen2->nip);

            //merubah nama file generate
            $file_name = now()->timestamp . '_' . $judul . '.docx';
            $templateProcessor->saveAs($file_name);

        //     //insert ke table surat
        //     $generate_surat = new Surat();
        //     $generate_surat->kategori_id = 2;
        //     $generate_surat->users_id = Auth::user()->id;
        //     $generate_surat->nosurat = $nosurat;
        //     $generate_surat->judul = $judul;
        //     $generate_surat->file = $file_name;
        //     $generate_surat->verifikasi = 0;
        //     $generate_surat->tglmasuk = null;
        //     $generate_surat->tglkeluar = $tanggal;
        //     $generate_surat->dosen1_id = $datadosen1->id;
        //     $generate_surat->dosen2_id = $datadosen2->id;
        //     $generate_surat->keterangan = $keterangan;
        //     $generate_surat->save();

        //     //insert ke table generate dengan surat_id di ambil dari atas
        //     $insert = new Generate();
        //     $insert->surat_id = $generate_surat->id;
        //     $insert->template_id = $template_id;
        //     $insert->save();

            // Pindah file
            File::move(public_path() . '/' . $file_name, public_path('surat/generate/') . $file_name);

            //Download generate surat
            $pathToFile = 'surat/generate/'.$file_name;
            return response()->download($pathToFile);
        }
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
}
