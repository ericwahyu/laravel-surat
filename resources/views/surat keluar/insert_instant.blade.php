@extends('layout')
@section('title','Tambah Surat Keluar')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.surat.keluar') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Surat Keluar</h1>
</div>

<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Data Surat Keluar</h4>
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
            <form action="{{ route('store.surat.keluar') }}" method="POST" enctype="multipart/form-data">
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
                                <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" name="nomor_surat" placeholder="0123/PSI/ITATS/2021" value="{{ old('nomor_surat') }}">
                                @error('nomor_surat')
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
                                <label style="font-size: 16px">Judul Surat</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="" value="{{ old('judul') }}">
                                @error('judul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Catatan Surat  'opsional'</label>
                                {{-- <input type="text" class="form-control @error('catatan_surat') is-invalid @enderror" name="catatan_surat" value="{{ old('catatan_surat') }}"> --}}
                                <textarea name="catatan_surat" class="form-control @error('catatan_surat') is-invalid @enderror" cols="30" rows="10">{{ old('catatan_surat') }}</textarea>
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
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label style="font-size: 16px">Tempat Surat</label>
                                        <input type="text" class="form-control @error('tempat_surat') is-invalid @enderror" name="tempat_surat" value="{{ old('tempat_surat') }}" required>
                                        @error('tempat_surat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label style="font-size: 16px">Tanggal Surat</label>
                                        <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" name="tanggal_surat" value="{{ Carbon::now() }}" id="date">
                                        @error('tanggal_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
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
                                <label style="font-size: 16px">Catatan Disposisi  'opsional'</label>
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
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Isi Disposisi 'opsional'</label>
                                <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" cols="30" rows="10">{{ old('isi') }}</textarea>
                                @error('isi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Target Akhir Surat</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="target_akhir" id="flexRadio1" value="1">
                                    <label class="form-check-label" for="flexRadio1"> Ya</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="target_akhir" id="flexRadio2" value="0" checked>
                                    <label class="form-check-label" for="flexRadio2"> Tidak</label>
                                </div>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Target akhir surat adalah tujuan akhir dari surat ini dan akan menerima dalam surat masuk, jika bukan target akhir surat maka penerima akan menerima surat pada surat keluar !!
                                </small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 16px">Pilih Response</label>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="sort-handler ui-sortable-handle text-center">
                                                    {{-- <input class="form-check-input" type="checkbox" id="checkAll">
                                                    <label class="form-check-label" for="checkAll"></label> --}}
                                                </div>
                                            </th>
                                            {{-- <th>Response </th> --}}
                                            <th>Response </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response as $response)
                                                <tr>
                                                    <td>
                                                        <div class="sort-handler ui-sortable-handle text-center">
                                                            <input class="form-check-input checkboxClass" type="checkbox" id="inlineCheckbox1" name="response[]" value={{ $response->id }}>
                                                            <label class="form-check-label" for="inlineCheckbox1"></label>
                                                        </div>
                                                    </td>
                                                    {{-- <td>{{ $response->id}}</td> --}}
                                                    <td>{{ $response->nama }}</td>
                                                </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="section-title">Memilih tujuan disposisi</div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="fakultas" name="radiobox" class="custom-control-input @error('radiobox') is-invalid @enderror" value="1">
                                <label class="custom-control-label" for="fakultas">User <b>Internal</b></label>
                            </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="luar-fakultas" name="radiobox" class="custom-control-input @error('radiobox') is-invalid @enderror" value="2">
                                <label class="custom-control-label" for="luar-fakultas">User <b>Eksternal</b></label>
                            </div>
                            @error('radiobox')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                        <div class="form-group fakultas">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="sort-handler ui-sortable-handle text-center">
                                                    {{-- <input class="form-check-input" type="checkbox" id="checkAll">
                                                    <label class="form-check-label" for="checkAll"></label> --}}
                                                </div>
                                            </th>
                                            <th>Nama </th>
                                            <th>Email</th>
                                            <th>Unit Kerja</th>
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
                                                    <td>{{ $us_dos->email }}</td>
                                                    <td>
                                                        <table>
                                                            @foreach (DisposisiController::getUnitKerja($us_dos->id) as $unitDosen)
                                                                <tr>
                                                                    <td>{{ $unitDosen }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </td>
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
                                                    <td>{{ $us_maha->email }}</td>
                                                    <td>
                                                        <table>
                                                            @foreach (DisposisiController::getUnitKerja($us_maha->id) as $unitMahasiswa)
                                                                <tr>
                                                                    <td>{{ $unitMahasiswa }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group eksternal">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label style="font-size: 16px">Nama yang dituju</label>
                                    <input type="text" class="form-control @error('nama_tujuan') is-invalid @enderror" name="nama_tujuan" value="{{ old('nama_tujuan') }}">
                                    @error('nama_tujuan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label style="font-size: 16px">Alamat Email</label>
                                    <input type="email" class="form-control @error('alamat_email') is-invalid @enderror" name="alamat_email" value="{{ old('alamat_email') }}">
                                    @error('alamat_email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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

            $('.fakultas').hide();
            $('.eksternal').hide();
            $('.custom-control-input').change(function() {
                if ($(this).val() === '1') {
                    console.log('fakultas');
                    $('.fakultas').show();
                    $('.eksternal').hide();
                } else if ($(this).val() === '2') {
                    $('.fakultas').hide();
                    $('.eksternal').show();
                }
            });

            $('#date').val(new Date().toISOString().substring(0, 10));
        });
        // document.getElementById('date').value = new Date().toISOString().substring(0, 10);
    </script>
@endsection

