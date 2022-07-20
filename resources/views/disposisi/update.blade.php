@extends('layout')
@section('title','Update Disposisi Surat Masuk')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.disposisi.masuk', $disposisi->surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Disposisi</h1>
</div>

<div class="section-body">
    <div class="row">
        <form action="{{ route('update.disposisi.masuk', $disposisi) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Perihal Disposisi</label>
                            <input type="text" class="form-control @error('perihal') is-invalid @enderror" name="perihal" placeholder="" value="{{ $disposisi->perihal }}">
                            @error('perihal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Tanggal Disposisi</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ $disposisi->tanggal }}">
                            @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Isi Disposisi</label>
                            <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" cols="30" rows="10">{{ $disposisi->isi }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Catatan</label>
                            <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" cols="30" rows="10"></textarea>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Masukkan catatan jika ada perlu !!
                            </small>
                            @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    {{-- <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Lihat penerima surat
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
                        </div>
                    </div> --}}
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
