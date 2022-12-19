@extends('layout')
@section('title','Tambah Surat Keluar')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.surat.keluar') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Surat Keluar</h1>
</div>

<div class="section-body">
    <form action="{{ route('store.surat.keluar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4>Data Surat Keluar</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Jenis Surat</label>
                        <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id">
                            <option disabled selected>-- Jenis Surat--</option>
                            @foreach ($jenis as $jenis)
                                <option value="{{ $jenis->id }}" {{ (old("jenis_id") == $jenis->id ? "selected":"") }}>{{ $jenis->nama }}</option>
                            @endforeach
                        </select>
                        @error('jenis_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Tempat Surat</label>
                        <input type="text" class="form-control @error('tempat_surat') is-invalid @enderror" name="tempat_surat" value="{{ old('tempat_surat') }}" required>
                        @error('tempat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Nomor Surat</label>
                        <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor_surat" placeholder="0123/PSI/ITATS/2021" value="{{ old('nomor') }}">
                        @error('nomor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Keterangan Surat</label>
                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan') }}">
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Judul Surat</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Catatan</label>
                        <input type="text" class="form-control @error('catatan') is-invalid @enderror" name="catatan" value="{{ old('catatan') }}">
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
                        <label style="font-size: 16px">Tanggal Surat</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal_surat" value="{{ old('tanggal') }}">
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">File Surat Masuk</label>
                        <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" value="{{ old('file') }}">
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Pastikan file yang di upload dengan format .docx/.doc/.pdf
                        </small>
                        @error('file')
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
@endsection
