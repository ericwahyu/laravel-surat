@extends('layout')
@section('title','Surat Masuk {{ $surat->judul }}')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.surat.masuk') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                        <div class="col-md-2">
                            <a href="{{ route('edit.surat.masuk', $surat) }}" class="btn btn-warning" title="Update"><i class="far fa-edit"> Update</i></a>
                        </div>
                        <div class="col-md-2">
                            <form action="{{ route('destroy.surat.masuk', $surat) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title="Hapus"><i class="far fa-trash-alt"> Delete</i></button>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <a href="" class="btn btn-primary" title="Read"><i class="far fa-eye"> Read</i></a>
                        </div>
                        <div class="col-md-2">
                            <a href="" class="btn btn-primary" title="Ubah"><i class="fas fa-reply"> Reply</i></a>
                        </div>
                        <div class="col-md-2">
                            <a href="" class="btn btn-primary" title="Ubah"><i class="fa fa-play"> Continue</i></a>
                        </div>
                        <div class="col-md-2">
                            <a href="" class="btn btn-success" title="Ubah"><i class="fa fa-download"> View File</i></a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <iframe src="" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
