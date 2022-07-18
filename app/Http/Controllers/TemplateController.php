<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Template;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $nav = 'umum';
        $menu = 'template';

        $search = $request->search;
        $data = Template::when($search, function($query) use ($search){
            return Template::where('nama','like','%'.$search.'%');
        })->paginate(5);

        $request = $request->all();

        return view('template.index', compact('nav', 'menu', 'data', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nav = 'surat';
        $menu = 'template';

        return view('template.insert', compact('nav', 'menu'));
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
            'nama' => 'required',
            'file' => 'required|mimes:doc,docx',
            'keterangan' => 'required'
        ]);

        $insert = new Template();
        $insert->nama = $request->nama;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = now()->timestamp . '_' . $file->getClientOriginalName();
            $file->move('surat/template',$file_name);
            $insert->file = $file_name;
        }
        $insert->keterangan = $request->keterangan;

        if(!$insert){
            return back()->with('error', 'Data gagal di Tambah !!');
        }else{
            $insert->save();
            return redirect()->route('index.template')->with('success', 'Data berhasil di Tambah !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show($template)
    {
        //
        // $nav = 'surat';
        // $menu = 'template';
        // $template = Template::find($template);

        // if(Storage::disk('public')->exists("template_PENDAFTARAN_ASLAB.pdf")){
        //     $path = Storage::disk('public')->path("template_PENDAFTARAN_ASLAB.pdf");
        //     $content = file_get_contents($path);
        //     return response($content)->withHeaders([
        //         'Content-Type' => mime_content_type($path)
        //     ]);
        // }
        // return redirect('/404');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit($template)
    {
        //
        $nav = 'surat';
        $menu = 'template';
        $template = Template::find($template);

        return view('template.update', compact('nav', 'menu', 'template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$template)
    {
        //
        $request->validate([
            'nama' => 'required',
            'file' => 'mimes:doc,docx',
            'keterangan' => 'required'
        ]);

        $template = Template::find($template);
        $template->nama = $request->nama;
        if($request->hasFile('file')){
            $filelama = public_path('surat/template/'.$template->file);
            if(File::exists($filelama)){
                File::delete($filelama);
                $file = $request->file('file');
                $file_name = now()->timestamp . '_' . $file->getClientOriginalName();
                $file->move('surat/template',$file_name);
                $template->file = $file_name;
            }
        }
        $template->keterangan = $request->keterangan;

        if(!$template){
            return back()->with('error', 'Data gagal di Update !!');
        }else{
            $template->save();
            return redirect()->route('index.template')->with('success', 'Data berhasil di Update !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy($template)
    {
        //
        $template = Template::find($template);
        $filelama = public_path('surat/template/'.$template->file);

        if(!$template){
            return back()->with('error', 'Data gagal di Hapus !!');
        }else{
            File::delete($filelama);
            $template->delete();
            return redirect()->route('index.template')->with('success', 'Data berhasil di Hapus !!');
        }

    }

    public function download($template){
        $template = Template::find($template);
        if(!$template){
            // dd($template);
            $pathToFile = 'surat/template/template_contoh.docx';
            return response()->download($pathToFile);
        }else{
            // dd($template);
            $file = $template->file;
            $pathToFile = 'surat/template/'.$file;
            return response()->download($pathToFile);
        }

    }

}
