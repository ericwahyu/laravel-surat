@extends('templateadmin')
@section('title','Form Ubah Surat Keluar')
@section('header','Form Ubah Surat Keluar')
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
        @foreach ($generate as $generate)
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-1">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label style="font-size: 16px">Nomor Surat</label>
                                        <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor" value="{{ $generate->nosurat }}" disabled>
                                        @error('nomor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size: 16px">Judul Surat</label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ $generate->judul }}">
                                        @error('judul')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size: 16px">Verifikasi Surat Keluar</label>
                                        <select class="form-control  @error('verifikasi') is-invalid @enderror" name="verifikasi">
                                            <option selected value="{{ $generate->verifikasi }}">{{ ($generate->verifikasi == '0') ? 'Belum Verifikasi' : 'Sudah Verifikasi' }}</option>
                                            <option value="0">Belum Verifikasi</option>
                                            <option value="1">Sudah Verifikasi</option>
                                        </select>
                                        @error('verifikasi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size: 16px">Keterangan Surat Keluar</label>
                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ $generate->keterangan }}">
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
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        @endforeach
    </div>
</div>
@endsection
