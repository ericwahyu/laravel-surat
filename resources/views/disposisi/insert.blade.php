@extends('layout')
@section('title','Tambah Disposisi Surat Masuk')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.disposisi.masuk', $surat->id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Disposisi</h1>
</div>

<div class="section-body">
    <div class="row">
        <form action="{{ route('store.disposisi.masuk', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label style="font-size: 16px">Perihal Disposisi</label>
                        <input type="text" class="form-control @error('perihal') is-invalid @enderror" name="perihal" placeholder="" value="{{ old('perihal') }}">
                        @error('perihal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label style="font-size: 16px">Tanggal Disposisi</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label style="font-size: 16px">Isi Disposisi</label>
                        <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" cols="30" rows="10">{{ old('isi') }}</textarea>
                        @error('isi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Tambah penerima surat
                    </a>
                    <div class="collapse" id="collapseExample">
                        <div class="form-group">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-2">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="sort-handler ui-sortable-handle text-center">
                                                                <input class="form-check-input" type="checkbox" id="checkAll">
                                                                <label class="form-check-label" for="checkAll"></label>
                                                            </div>
                                                        </th>
                                                        <th>Username</th>
                                                        <th>Email</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user as $users)
                                                        <tr>
                                                            <td>
                                                                <div class="sort-handler ui-sortable-handle text-center">
                                                                    <input class="form-check-input checkboxClass" type="checkbox" id="inlineCheckbox1" name="disposisi[]" value={{ $users->id }}>
                                                                    <label class="form-check-label" for="inlineCheckbox1"></label>
                                                                </div>
                                                            </td>
                                                            <td>{{ $users->username }}</td>
                                                            <td>{{ $users->email }}</td>
                                                            <td>{{ $users->email }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
