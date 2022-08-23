@extends('layout')
@section('title','Tambah Disposisi Surat')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.disposisi', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Disposisi <b>{{ $surat->judul }}</b></h1>
</div>

<div class="section-body">
    <div class="row">
        <form action="{{ route('store.disposisi', $surat) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="pembuat" value="{{ Auth::user()->id }}">
            <div class="card">
                <div class="card-header">
                    <h4>Data Disposisi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Perihal Disposisi</label>
                            <input type="text" class="form-control @error('perihal') is-invalid @enderror" name="perihal" placeholder="" value="{{ old('perihal') }}">
                            @error('perihal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Tanggal Disposisi</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
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
                            <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" cols="30" rows="10">{{ old('isi') }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Catatan</label>
                            <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" cols="30" rows="10">{{ old('catatan') }}</textarea>
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
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Penerima Surat</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
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
                                        <th>Nama </th>
                                        <th>Username</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user_dosen as $us_dos)
                                        @if ($us_dos->user_id === Auth::user()->id)
                                            @continue
                                        @else
                                            <tr>
                                                <td>
                                                    <div class="sort-handler ui-sortable-handle text-center">
                                                        <input class="form-check-input checkboxClass" type="checkbox" id="inlineCheckbox1" name="disposisi[]" value={{ $us_dos->id }}>
                                                        <label class="form-check-label" for="inlineCheckbox1"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $us_dos->nama }}</td>
                                                <td>{{ $us_dos->username }}</td>
                                                <td>{{ $us_dos->email }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    @foreach ($user_mahasiswa as $us_maha)
                                        @if ($us_maha->user_id === Auth::user()->id)
                                            @continue
                                        @else
                                            <tr>
                                                <td>
                                                    <div class="sort-handler ui-sortable-handle text-center">
                                                        <input class="form-check-input checkboxClass" type="checkbox" id="inlineCheckbox1" name="disposisi[]" value={{ $us_maha->id }}>
                                                        <label class="form-check-label" for="inlineCheckbox1"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $us_maha->nama }}</td>
                                                <td>{{ $us_maha->username }}</td>
                                                <td>{{ $us_maha->email }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
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
