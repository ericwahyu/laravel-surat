<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Template;
use App\Models\Kategori;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use \PhpOffice\PhpWord\TemplateProcessor;



class TemplateController extends Controller
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
        $menu = 'template';
        $user = Auth::user();
        $unit = $user->isUnitkerja();

        if(Auth::user()->isAdmin()){
            $template = Template::all();
        }else{
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
            // dd(count($getUnit));
            for ($a=0; $a < count($getUnit); $a++) {
                $getIdUnit[] = $getUnit[$a][0];
            }
            // dd($getIdUnit);
            $template = Template::whereIn('unit_kerja_id', $getIdUnit)->get();
        }

        return view('template.index', compact('nav', 'menu', 'template', 'user'));
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
        $menu = 'template';
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
        // dd($getUnit);
        return view('template.insert', compact('nav', 'menu', 'user', 'unitKerja', 'getUnit'));
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
            'unit_id' => 'required',
            'nama' => 'required',
            'file' => 'required|mimes:docx,doc',
            'keterangan' => 'nullable',
            'isi_body' => 'required',
            'jumlah_ttd' => 'required',
        ]);

        // dd($request);
        $template = new Template();
        $template->unit_kerja_id = $request->unit_id;
        $template->nama = $request->nama;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = now()->timestamp . '_' .$file->getClientOriginalName();
            // dd($file_name);
            // $file_name = $file->getClientOriginalName();
            $file->move('surat/template',$file_name);
            $template->file = $file_name;
        }
        $template->keterangan = $request->keterangan;
        $template->isi_body = $request->isi_body;
        $template->isi_footer = $request->isi_footer;
        $template->jumlah_ttd = $request->jumlah_ttd;
        $template->save();

        if($template){
            return redirect()->route('index.template')->with('success', 'Data berhasil di tambah !!');
        }else{
            return back()->with('warning', 'Data gagal di Tambah !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        //
        $nav = 'umum';
        $menu = 'template';
        $user = Auth::user();
        $unitKerja = UnitKerja::orwhere('nama', 'like', '%Fakultas Teknik Elektro dan Teknologi Informasi%')
                ->orwhere('nama', 'like', '%Jurusan Teknik Informatika%')
                ->orwhere('nama', 'like', '%Jurusan Sistem Informasi%')
                ->orwhere('nama', 'like', '%Jurusan Teknik Elektro%')
                ->get();

        $unit = Auth::user()->isUnitkerja();
        // DD($unit);
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

        return view('template.update', compact('nav', 'menu', 'template', 'unitKerja', 'user', 'getUnit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        //
        $request->validate([
            'unit_id' => 'required',
            'nama' => 'required',
            'file' => 'mimes:docx,doc|unique:template',
            'keterangan' => 'nullable',
            'isi_body' => 'required',
            'jumlah_ttd' => 'required',
        ]);

        $template->unit_kerja_id = $request->unit_id;
        $template->nama = $request->nama;
        $template->keterangan = $request->keterangan;
        if($request->hasFile('file')){
            //delete file lama
            $filelama = public_path('surat/template/'.$template->file);
            File::delete($filelama);

            $file = $request->file('file');
            $file_name = now()->timestamp . '_' .$file->getClientOriginalName();
            // $file_name = $file->getClientOriginalName();
            $file->move('surat/template',$file_name);
            $template->file = $file_name;
        }
        $template->isi_body = $request->isi_body;
        $template->isi_footer = $request->isi_footer;
        $template->jumlah_ttd = $request->jumlah_ttd;
        $template->save();

        if($template){
            return redirect()->route('index.template')->with('success', 'Data berhasil di Update !!');
        }else{
            return back()->with('warning', 'Data gagal di Update !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //
        $filelama = public_path('surat/template/'.$template->file);

        if($template){
            File::delete($filelama);
            $template->delete();
            return redirect()->route('index.template')->with('success', 'Data berhasil di Hapus !!');
        }else{
            return back()->with('warning', 'Data gagal di Hapus !!');
        }

    }

    public function formTestingTemplate(Template $template){

        $nav = 'umum';
        $menu = 'template';
        $dosen = Dosen::all();
        $mahasiswa = Mahasiswa::all();

        return view('template.test', compact('nav', 'menu', 'template', 'dosen', 'mahasiswa'));

    }

    public function testingTemplate(Request $request){
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
                return back()->with('warning', 'Terjadi kesalahan dalam penulisan isi body template atau footer template, Silahkan Ubah !!');
            }

                $file_name = now()->timestamp . '_' . 'Testing Template'. '.docx';
                $templateProcessor->saveAs($file_name);

                // Pindah file
                File::move(public_path() . '/' . $file_name, public_path('surat/template/').$file_name);

                //test success
                $template->isi_body = $request->isi_body;
                $template->isi_footer = $request->isi_footer;
                $template->save();

                return $this->setNomor($request, $file_name);

            }else{
                return back()->with('warning', 'Berkas tidak ditemukan !!');
            }

    }

    public function setNomor($request, $suratFile){
        $suratLama = public_path('surat/template/').$suratFile;
        if (file_exists($suratLama)) {
            //generate surat
            $templateProcessor = new TemplateProcessor($suratLama);
            $templateProcessor->setValue('nomor_surat', $request->nomor_surat);

            $file_name = 'Testing Template'. '.docx';
            $templateProcessor->saveAs($file_name);
            // Pindah file surat Baru
            File::move(public_path() . '/' . $file_name, public_path('surat/template/').$file_name);
            //hapus surat lama
            File::delete($suratLama);

            $file_path = public_path('surat/template/').$file_name;
            return response()->download($file_path);
        }
    }

    // get pihak yang bersangkutan
    public function getUser($user_id){
        $dosen = Dosen::where('user_id', $user_id)->get();
        $mahasiswa = Mahasiswa::where('user_id', $user_id)->get();

        if($dosen->isNotEmpty()){
            return $dosen;
        }else if($mahasiswa->isNotEmpty()){
            return $mahasiswa;
        }
    }

}
