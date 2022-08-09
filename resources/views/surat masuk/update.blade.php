@extends('layout')
@section('title','Update Surat Masuk')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('show.surat.masuk', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Surat Masuk <b>{{ $surat->judul }}</b></h1>
</div>

<div class="section-body">
    <div class="row">
        <form action="{{ route('update.surat.masuk', $surat) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Jenis Surat</label>
                            <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id">
                                <option selected value="{{ $surat->jenis->id }}">{{ $surat->jenis->nama_jenis }}</option>
                                @foreach ($jenis as $jenis)
                                    @if ($surat->jenis->id != $jenis->id)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('jenis_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Keterangan Surat</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ $surat->keterangan }}">
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Nomor Surat</label>
                            <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor" readonly="" value="{{ $surat->nosurat }}" >
                            @error('nomor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Catatan</label>
                            <input type="text" class="form-control @error('catatan') is-invalid @enderror" name="catatan" value="">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Masukkan catatan jika ada perlu !!
                            </small>
                            @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Judul Surat</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="" value="{{ $surat->judul }}">
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">File Surat Masuk</label>
                            <input class="form-control @error('file') is-invalid @enderror" type="file" name="file">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Akan menghapus file lama jika mengupload file baru !!
                            </small>
                            @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Tanggal Surat</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ $surat->tanggal }}">
                            @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
