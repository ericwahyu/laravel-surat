@extends('layout')
@section('title','Update Jenis Surat')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.jenis') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Jenis Surat</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('update.jenis', $jenis) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>Data Jenis Surat</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size: 16px">Kategori Jenis Surat</label>
                            <select class="form-control @error('kategori_id') is-invalid @enderror" name="kategori_id">
                                <option selected value="{{ $jenis->kategori_id }}">{{ $jenis->kategori->nama_kategori }}</option>
                                @foreach ($kategori as $kategori)
                                    @if ($kategori->id != $jenis->kategori_id)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label style="font-size: 16px">Nama Jenis Surat</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="" value="{{ $jenis->nama_jenis }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
