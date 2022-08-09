@extends('layout')
@section('title', 'Generate '.$template->nama)
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.keluar.template') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Generate <b>{{ $template->nama }}</b></h1>
</div>

<div class="section-body">
    <div class="row">
        <form action="{{ route('store.surat.keluar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4>Data Surat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Jenis Surat</label>
                            <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id" required>
                                <option disabled selected>-- Jenis Surat--</option>
                                @foreach ($jenis as $jenis)
                                    <option value="{{ $jenis->id }}" {{ (old("jenis_id") == $jenis->id ? "selected":"") }}>{{ $jenis->nama_jenis }}</option>
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
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ $template->nama }}">
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
                </div>
                {{-- hidden input --}}
                    <input type="hidden" name="template_id" value="{{ $template->id }}">
            </div>
            @yield('generate')
        </form>
    </div>
</div>
@endsection
