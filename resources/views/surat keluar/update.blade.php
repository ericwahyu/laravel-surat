@extends('layout')
@section('title','Update Surat Keluar')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('show.surat.keluar', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Surat Keluar <b>{{ $surat->judul }}</b></h1>
</div>

<div class="section-body">
    <div class="row">
        <form action="{{ route('update.surat.keluar', $surat) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Jenis Surat</label>
                            <select class="form-control @error('kategori') is-invalid @enderror" name="jenis_id">
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
                            <label style="font-size: 16px">Tanggal Surat</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ $surat->tanggal }}">
                            @error('tanggal')
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
                            <label style="font-size: 16px">Judul Surat</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="" value="{{ $surat->judul }}">
                            @error('judul')
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
                            @error('keterangan')
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
