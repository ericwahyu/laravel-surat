@extends('layout')
@section('title','Detail Surat Keluar')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.surat.keluar') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Surat Masuk <b>{{ $surat->judul }}</b></h1>
</div>

<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Detail</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-8">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Jenis Surat</td>
                                <td>:</td>
                                <td>{{ $surat->jenis->nama_jenis }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Surat</td>
                                <td>:</td>
                                <td>{{ $surat->nosurat }}</td>
                            </tr>
                            <tr>
                                <td>Judul Surat</td>
                                <td>:</td>
                                <td>{{ $surat->judul }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Surat</td>
                                <td>:</td>
                                <td>{{ $surat->tanggal }}</td>
                            </tr>
                            <tr>
                                <td>Keterangan Surat</td>
                                <td>:</td>
                                <td>{{ $surat->keterangan }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="{{ route('edit.surat.keluar', $surat) }}" class="btn btn-warning" title="Update"><i class="far fa-edit"></i> Update</a>
                        </div>
                        <div class="col-sm-2">
                            <form action="{{ route('destroy.surat.keluar', $surat) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title="Delete"><i class="far fa-trash-alt"></i> Delete</button>
                            </form>
                        </div>
                        <div class="col-sm-2">
                            <a href="{{ route('download.surat.keluar', $surat) }}" class="btn btn-success" title="Download"><i class="fa fa-download"></i> View File</a>
                        </div>
                        <div class="col-sm-2 offset-md-3">
                            <a href="{{ route('index.disposisi', $surat) }}" class="btn btn-info" title="Lihat Detail Disposisi dan beri tanggapan"><i class="fas fa-file"></i> Lihat Disposisi</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection