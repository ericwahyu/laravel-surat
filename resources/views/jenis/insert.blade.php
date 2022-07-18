@extends('layout')
@section('title','Form Tambah Jenis Surat')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.jenis') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Jenis Surat</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('store.jenis') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size: 16px">Kategori Jenis Surat</label>
                            <select class="form-control  @error('kategori') is-invalid @enderror" name="kategori">
                                <option disabled selected>-- Kategori Jenis Surat--</option>
                                @foreach ($kategori as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label style="font-size: 16px">Nama Jenis Surat</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Nama" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            {{-- <a href="{{ route('index.jenis') }}" type="button" class="btn btn-secondary">Close</a> --}}
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
