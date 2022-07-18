@extends('templateadmin')
@section('title','Form Tambah Surat Keluar')
@section('header','Form Tambah Surat Keluar')
@section('body')
<div class="row">
    <div class="col-6 offset-6">
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ $message }}
                </div>
            </div>
        @endif
    </div>
    <div class="col-12">
        <form action="{{ route('store.surat.keluar') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-1">
                            <div class="card-body">
                                <div class="form-group">
                                    <label style="font-size: 16px">Template</label>
                                    <select class="form-control  @error('template_id') is-invalid @enderror" name="template_id">
                                        <option disabled selected>-- Pilih Template Surat--</option>
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
                                <div class="form-group">
                                    <label style="font-size: 16px">Judul Surat</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="Surat " value="{{ old('judul') }}">
                                    @error('judul')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 16px">Nomor Surat</label>
                                    <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor" placeholder="" value="{{ old('nomor') }}">
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                        Masukkan nomor surat jika ada, dan kosongkan kode huruf dan kode unit surat !!
                                    </small>
                                    @error('nomor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 16px">Kode Huruf Surat</label>
                                    <select class="form-control  @error('huruf') is-invalid @enderror" name="huruf">
                                        <option disabled selected>-- Kode Huruf Surat--</option>
                                        @foreach ($huruf as $huruf)
                                            <option value="{{ $huruf }}">{{ $huruf }}</option>
                                        @endforeach
                                    </select>
                                    @error('huruf')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 16px">Kode Unit Surat</label>
                                    <select class="form-control  @error('unit') is-invalid @enderror" name="unit">
                                        <option disabled selected>-- Pilih Kode Unit Surat--</option>
                                        @foreach ($unit as $unit)
                                            <option value="{{ $unit->unit_kerja }}">{{ $unit->unit_kerja }}</option>
                                        @endforeach
                                    </select>
                                    @error('kode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 16px">Isi Body Surat</label>
                                    <textarea name="isi" id="summernote">{{ old('isi') }}</textarea>
                                    @error('isi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 16px">Tanggal Surat</label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
                                </div>
                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label style="font-size: 16px">Dosen 1</label>
                                    <select class="form-control  @error('dosen1') is-invalid @enderror" name="dosen1">
                                        <option disabled selected>-- Pilih Dosen 1 --</option>
                                        @foreach ($dosen1 as $dosen1)
                                            <option value="{{ $dosen1->id }}">{{ $dosen1->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('dosen1')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 16px">Dosen 2</label>
                                    <select class="form-control  @error('dosen2') is-invalid @enderror" name="dosen2">
                                        <option disabled selected>-- Pilih Dosen 2 --</option>
                                        @foreach ($dosen2 as $dosen2)
                                            <option value="{{ $dosen2->id }}">{{ $dosen2->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('dosen2')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 16px">Keterangan Surat</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan') }}">
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <a href="{{ route('index.surat.keluar') }}" type="button" class="btn btn-secondary">Close</a>
                <button type="submit" class="btn btn-primary">Generate</button>
            </div>
        </form>
    </div>
</div>
@endsection
