@extends('layout')
@section('title','Tambah Surat Masuk')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.surat.masuk') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Surat Masuk</h1>
</div>

<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Data Surat Masuk</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills" id="myTab3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">Data Surat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">Data Disposisi Surat</a>
                </li>
            </ul>
            <form action="{{ route('store.surat.masuk') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="tab-content mt-4" id="myTabContent2">
                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Jenis Surat</label>
                                <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id">
                                    <option disabled selected>-- Jenis Surat--</option>
                                    @foreach ($jenis as $jenis)
                                        <option value="{{ $jenis->id }}" {{ (old("jenis_id") == $jenis->id ? "selected":"") }}>{{ $jenis->nama }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Keperluan Surat</label>
                                <input type="text" class="form-control @error('keperluan') is-invalid @enderror" name="keperluan" value="{{ old('keperluan') }}">
                                @error('keperluan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Nomor Surat</label>
                                <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor" placeholder="0123/PSI/ITATS/2021" value="{{ old('nomor') }}">
                                @error('nomor')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Catatan Surat</label>
                                <input type="text" class="form-control @error('catatan_surat') is-invalid @enderror" name="catatan_surat" value="{{ old('catatan_surat') }}">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Masukkan catatan jika ada perlu !!
                                </small>
                                @error('catatan_surat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Judul Surat</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="" value="{{ old('judul') }}">
                                @error('judul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">File Surat Masuk</label>
                                <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" value="{{ old('file') }}">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Pastikan file yang di upload dengan format .docx/.doc/.pdf
                                </small>
                                @error('file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Tanggal Surat</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
                                @error('tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="nav-link btn btn-primary" id="next">Next >></a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
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
                                <label style="font-size: 16px">Catatan Disposisi</label>
                                <textarea name="catatan_disposisi" class="form-control @error('catatan_disposisi') is-invalid @enderror" cols="30" rows="10">{{ old('catatan_disposisi') }}</textarea>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Masukkan catatan jika ada perlu !!
                                </small>
                                @error('catatan_disposisi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
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
                                            @if ($us_maha->user_id == Auth::user()->id)
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
                            <a href="#" class="nav-link btn btn-primary" id="back"><< Back</a>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#next').click(function(){
            $('#home-tab3').removeClass("active");
            $('#home3').removeClass("active");
            $('#profile-tab3').addClass("active");
            $('#profile3').addClass("show active");
        });
        $('#back').click(function(){
            $('#profile-tab3').removeClass("active");
            $('#profile3').removeClass("show active");
            $('#home-tab3').addClass("active");
            $('#home3').addClass("show active");
        });
    });
</script>
@endsection
