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
    <form action="{{ route('update.surat.keluar', $surat) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4>Data Surat</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Jenis Surat</label>
                        <select class="form-control @error('kategori') is-invalid @enderror" name="jenis_id">
                            <option selected value="{{ $surat->jenis->id }}">{{ $surat->jenis->nama }}</option>
                            @foreach ($jenis as $jenis)
                                @if ($surat->jenis->id != $jenis->id)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
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
                        <label style="font-size: 16px">Tempat Surat</label>
                        <input type="text" class="form-control @error('tempat_surat') is-invalid @enderror" name="tempat_surat" value="{{ $generate->tempat }}">
                        @error('tempat_surat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Nomor Surat</label>
                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" name="nomor_surat" value="{{ $surat->nosurat }}" >
                        @error('nomor_surat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Keperluan Surat</label>
                        <input type="text" class="form-control @error('keperluan') is-invalid @enderror" name="keperluan" value="{{ $surat->keperluan }}">
                        @error('keperluan')
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
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ $surat->tanggal }}">
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="formFile" class="form-label" style="font-size: 16px">Upload File Surat</label>
                        <input class="form-control @error('file') is-invalid @enderror" type="file" id="formFile" name="file" value="{{ old('file') }}">
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Upload file surat jika sudah tercetak dan terdapat tanda tangan, dengan format .doc/.docx/.pdf !!
                        </small>
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    @if ($user->isAdmin())
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Status Surat</label>
                            <select class="form-control" name="status">
                                @if ($surat->status === 1)
                                    <option selected value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                @elseif ($surat->status === 0)
                                    <option selected value="0">Non Aktif</option>
                                    <option value="1">Aktif</option>
                                @endif
                            </select>
                            @error('jenis_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endif
                </div>
                <input type="hidden" name="generate_id" value="{{ $generate->id }}">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </div>
    </form>
</div>
@endsection
