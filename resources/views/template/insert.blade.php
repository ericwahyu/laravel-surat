@extends('layout')
@section('title','Form Tambah Template')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.template') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Template Surat</h1>
</div>

<div class="section-body">
    <div class="row">
        <form action="{{ route('store.template') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label style="font-size: 16px">Nama Template</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Surat template" value="{{ old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="formFile" class="form-label" style="font-size: 16px">Nama File</label>
                        <input class="form-control @error('file') is-invalid @enderror" type="file" id="formFile" name="file" value="{{ old('file') }}">
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Masukkan file dengan format .doc/.docx !!
                        </small>
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label style="font-size: 16px">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
