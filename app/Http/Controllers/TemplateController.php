<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Template;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\Auth;


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
        $template = Template::all();
        $user = Auth::user();

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
            'keterangan' => 'nullable'
        ]);

        $template = new Template();
        $template->nama = $request->nama;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = now()->timestamp . '_' . $request->nama.'.'.$file->getClientOriginalExtension();
            $file->move('surat/template',$file_name);
            $template->file = $file_name;
        }
        $template->keterangan = $request->keterangan;

        if($template){
            $template->save();
            return redirect()->route('index.template')->with('success', 'Data berhasil di tambah !!');
        }else{
            return back()->with('error', 'Data gagal di Tambah !!');
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
    public function edit(Template $template)
    {
        //
        $nav = 'umum';
        $menu = 'template';

        return view('template.update', compact('nav', 'menu', 'template'));
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
            'nama' => 'required',
            'file' => 'mimes:doc,docx',
            'keterangan' => 'nullable'
        ]);

        $template->nama = $request->nama;
        $template->keterangan = $request->keterangan;
        if($request->hasFile('file')){
            $filelama = public_path('surat/template/'.$template->file);
            if(File::exists($filelama)){
                File::delete($filelama);
                $file = $request->file('file');
                $file_name = now()->timestamp . '_' .$request->nama.'.'.$file->getClientOriginalExtension();
                $file->move('surat/template',$file_name);
                $template->file = $file_name;
            }
        }

        if($template){
            $template->save();
            return redirect()->route('index.template')->with('success', 'Data berhasil di Update !!');
        }else{
            return back()->with('error', 'Data gagal di Update !!');
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
            return back()->with('error', 'Data gagal di Hapus !!');
        }

    }

}
