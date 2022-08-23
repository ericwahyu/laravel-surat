@extends('layout')
@section('title', 'Generate '.$template->nama)
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.keluar.template') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Generate <b>{{ $template->nama }}</b></h1>
</div>

<div class="section-body">
    <form action="{{ route('store.surat.keluar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4>Data Surat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Jenis Surat</label>
                            <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id">
                                <option disabled selected>-- Jenis Surat--</option>
                                @foreach ($jenis as $jenis)
                                    <option value="{{ $jenis->id }}" {{ (old("jenis_id") == $jenis->id ? "selected":"") }}>{{ $jenis->nama_jenis }}</option>
                                @endforeach
                            </select>
                            @error('jenis_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Keterangan Surat</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan') }}">
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Judul Surat</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ $template->nama }}">
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Catatan</label>
                            <input type="text" class="form-control @error('catatan') is-invalid @enderror" name="catatan" value="{{ old('catatan') }}">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Masukkan catatan jika ada perlu !!
                            </small>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- hidden input --}}
                    <input type="hidden" name="template_id" value="{{ $template->id }}">
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Generate Surat</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Generate Nomor Surat</label>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="kodeHuruf" style="font-size: 13px">Kode Huruf</label>
                                <input type="text" class="form-control" id="kodeHuruf" name="kodeHuruf" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="kodeKeperluan" style="font-size: 13px">Kode Keperluan</label>
                                <select id="kodeKeperluan" class="form-control" name="kodeKeperluan" required>
                                    <option disabled selected>-- Keperluan Surat--</option>
                                    @foreach ($keperluan as $keperluan)
                                        <option value="{{ $keperluan->id }}" {{ (old("kodeKeperluan") == $keperluan->id ? "selected":"") }}>{{ $keperluan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="kodeTahun" style="font-size: 13px">Tahun</label>
                                <input type="text" class="form-control" id="kodeTahun" name="kodeTahun" value="{{ Carbon::now()->format('Y') }}" required>
                            </div>
                            <div class="form-group col-md-3" style="margin-top: 32px">
                                {{-- <button type="button" class="btn btn-primary" onclick="generate()" id="generateButton"> Generate Nomor</button> --}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6" style="margin-top: 32px">
                        <label style="font-size: 13px">Nomor Surat</label>
                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomorSurat" name="nomor_surat" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Tempat Surat</label>
                        <input type="text" class="form-control @error('tempat_surat') is-invalid @enderror" name="tempat_surat" placeholder="Surabaya" value="{{ old('tempat_surat') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Tanggal Surat</label>
                        <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" name="tanggal_surat" value="{{ old('tanggal_surat') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label style="font-size: 16px">Buat Surat</label>
                        <textarea class="summernote" name="isiBody" id="summernote" cols="30" rows="10" required>{{ $template->isiBody }}</textarea>
                        @error('isiBody')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-md-3">
                    <label style="font-size: 16px">Tanda Tangan</label>
                    @for ($ttd = 1; $ttd <= $template->jumlah_ttd; $ttd++)
                        <div class="form-group col-md-6">
                            <label style="font-size: 13px">Jabatan Pihak ke-{{ $ttd }}</label>
                            <input type="text" class="form-control @error('jabatan_{{ $ttd }}') is-invalid @enderror" name="jabatan_{{ $ttd }}" value="" required>
                            <label style="font-size: 13px">Nama Pihak ke-{{ $ttd }}</label>
                            <select class="form-control @error('tertanda_{{ $ttd }}') is-invalid @enderror" name="tertanda_{{ $ttd }}" required>
                                <option disabled selected>--Tertanda--</option>
                                @foreach ($dosen as $dosens)
                                    <option value="{{ $dosens->user_id }}" {{ (old("tertanda_1") == $dosens->user_id ? "selected":"") }}>{{ $dosens->nama }}</option>
                                @endforeach
                                @foreach ($mahasiswa as $mahasiswas)
                                    <option value="{{ $mahasiswas->user_id }}" {{ (old("tertanda_1") == $mahasiswas->user_id ? "selected":"") }}>{{ $mahasiswas->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endfor
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#kodeKeperluan').change(function(){
            let kodehuruf = document.getElementById('kodeHuruf').value;
            let kodekeperluan = document.getElementById('kodeKeperluan').value;
            let kodetahun = document.getElementById('kodeTahun').value;
            console.log(kodehuruf);
            console.log(kodekeperluan);
            console.log(kodetahun);

            $('#nomorSurat').val(`${kodehuruf}/${kodekeperluan}/${kodetahun}`);
        });
    });
</script>
@endsection
