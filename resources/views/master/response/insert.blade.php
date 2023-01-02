@extends('layout')
@section('title','Tambah Response')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.masterResponse') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Response</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('store.masterResponse') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>Data Response</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size: 16px">Nama Response</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Nama" value="{{ old('nama') }}">
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
