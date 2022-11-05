@extends('layout')
@section('title','Update Surat Keluar')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('show.surat.keluar', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Surat Keluar <b>{{ $surat->judul }}</b></h1>
</div>

<div class="section-body">
    <div class="row">
        <form action="{{ route('update.surat.keluar', $surat) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4>Data Surat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Jenis Surat</label>
                            <select class="form-control @error('kategori') is-invalid @enderror" name="jenis_id">
                                <option selected value="{{ $surat->jenis->id }}">{{ $surat->jenis->nama }}</option>
                                @foreach ($jenis as $jenis)
                                    @if ($surat->jenis->id != $jenis->id)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('jenis_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Tanggal Surat</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ $surat->tanggal }}">
                            @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Nomor Surat</label>
                            <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor" readonly="" value="{{ $surat->nosurat }}" >
                            @error('nomor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Keterangan Surat</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ $surat->keterangan }}">
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
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="" value="{{ $surat->judul }}">
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Catatan</label>
                            <input type="text" class="form-control @error('catatan') is-invalid @enderror" name="catatan" value="">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Masukkan catatan jika ada perlu !!
                            </small>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" name="generate_id" value="{{ $generate->id }}">
                        <input type="hidden" name="template_id" value="{{ $generate->template->id }}">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Content Surat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Tempat Surat</label>
                            <input type="text" class="form-control @error('tempat_surat') is-invalid @enderror" name="tempat_surat" placeholder="Surabaya" value="{{ $generate->tempat }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Tanggal Surat</label>
                            <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" name="tanggal_surat" value="{{ $surat->tanggal }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-11">
                            <label style="font-size: 16px">Isi Content Surat</label>
                            <textarea class="summernote" name="isi_body" id="summernote" cols="30" rows="10" required>{{ $generate->content }}</textarea>
                            @error('isiBody')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-1">
                            <a data-toggle="tooltip" title="Langkah Penulisan Content Surat :
                                                        1. Untuk nomor surat di inputkan variable ${nomor_surat}
                                                        2. Jika muncul peringatan terjadi kesalahan menulis maka edit ulang isi content, karena ada beberapa tag html yang tidak terbaca oleh PHPWORD" >
                            <i class="fas fa-exclamation-circle"></i><b> info</b></a>
                        </div>
                    </div>
                    @if ($generate->footer_content != null)
                        <div class="form-group">
                            <label style="font-size: 16px">Isi Footer Template</label>
                            <textarea class="summernote2" name="isi_footer" id="summernote2" cols="30" rows="10" required>{{ $template->isi_footer }}</textarea>
                            @error('isi_footer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endif
                    <div class="row mt-md-3">
                        <label style="font-size: 16px">Tanda Tangan</label>
                        @for ($ttd = 1; $ttd <= $generate->template->jumlah_ttd; $ttd++)
                            <div class="form-group col-md-6">
                                <input type="hidden" name="ttd_id_{{ $ttd }}" value="{{ $pihak_ttd[$ttd-1]->id }}">
                                <label style="font-size: 13px">Jabatan Pihak ke-{{ $ttd }}</label>
                                <input type="text" class="form-control @error('jabatan_{{ $ttd }}') is-invalid @enderror" name="jabatan_{{ $ttd }}" value="{{ $pihak_ttd[$ttd-1]->jabatan }}" required>
                                <label style="font-size: 13px">Nama Pihak ke-{{ $ttd }}</label>
                                <select class="form-control @error('tertanda_{{ $ttd }}') is-invalid @enderror" name="tertanda_{{ $ttd }}" required>
                                    <option disabled selected>--Tertanda--</option>
                                    @foreach ($dosen as $dosens)
                                        @if ($dosens->id == $pihak_ttd[$ttd-1]->nip)
                                            <option selected value="{{ $dosens->id }}" {{ (old("tertanda_1") == $dosens->user_id ? "selected":"") }}>{{ $dosens->nama }}</option>
                                        @endif
                                            <option value="{{ $dosens->id }}" {{ (old("tertanda_1") == $dosens->user_id ? "selected":"") }}>{{ $dosens->nama }}</option>
                                    @endforeach
                                    {{-- @foreach ($mahasiswa as $mahasiswas)
                                        <option value="{{ $mahasiswas->user_id }}" {{ (old("tertanda_1") == $mahasiswas->user_id ? "selected":"") }}>{{ $mahasiswas->nama }}</option>
                                    @endforeach --}}
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
</div>
@endsection
