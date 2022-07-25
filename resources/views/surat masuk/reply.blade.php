@extends('layout')
@section('title','Reply Surat Masuk')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('show.surat.masuk', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Reply Surat Masuk <b>{{ $surat->judul }}</b></h1>
</div>

<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Reply Surat</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-7">
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
                </div>
                <div class="col-12 col-md-5">
                    <form action="{{ route('store.reply.surat.masuk', $surat) }}" method="post">
                        @csrf
                        <label style="font-size: 16px">Catatan</label>
                        <textarea name="catatan" cols="30" rows="10" class="form-control @error('catatan') is-invalid @enderror">Balas surat {{ $surat->judul }}, dengan catatan ......</textarea>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Masukkan catatan  !!
                        </small>
                        @error('catatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="row">
                            <div class="col-12 col-md-2 offset-md-9">
                                <button type="submit" class="btn btn-primary" title="Reply"><i class="fa fa-paper-plane"> Reply surat</i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
