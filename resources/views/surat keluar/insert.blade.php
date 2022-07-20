@extends('layout')
@section('title','Form Tambah Surat Keluar')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.surat.keluar') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Surat Keluar</h1>
</div>

<div class="section-body">

</div>
<div class="row">
    <form action="{{ route('store.surat.keluar') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4>Data Surat</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Jenis Surat</label>
                        <select class="form-control selectric @error('kategori') is-invalid @enderror" name="jenis_id">
                            <option disabled selected>-- Jenis Surat--</option>
                            @foreach ($jenis as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
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
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Tanggal Surat</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Edit surat
                </a>
            </div>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="card">
                <div class="card-header">
                    <h4>Generate Surat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Template Surat</label>
                            <select class="form-control selectric @error('template') is-invalid @enderror" name="template_id">
                                <option disabled selected>-- Template Surat--</option>
                                @foreach ($template as $template)
                                    <option value="{{ $template->id }}">{{ $template->nama }}</option>
                                @endforeach
                            </select>
                            @error('template_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Nomor Surat</label>
                            <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor" placeholder="0123/PSI/ITATS/2021" value="{{ old('nomor') }}">
                            @error('nomor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 16px">Isi Surat</label>
                        <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" cols="30" rows="10">{{ old('isi') }}</textarea>
                        {{-- <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor" placeholder="0123/PSI/ITATS/2021" value="{{ old('nomor') }}"> --}}
                        @error('nomor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Generate Surat</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
