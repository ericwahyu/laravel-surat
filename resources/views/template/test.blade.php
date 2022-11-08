@extends('layout')
@section('title', 'Testing Template'.$template->nama)
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.template') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Testing Template <b>{{ $template->nama }}</b></h1>
</div>

<div class="section-body">
    <form action="{{ route('testing.template') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="template_id" value="{{ $template->id }}">
        <div class="card">
            <div class="card-header">
                <h4>Testing Template</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Nomor Surat</label>
                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" name="nomor_surat" placeholder="0123/PSI/ITATS/2021" value="{{ old('nomor_surat') }}" required>
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
                    <div class="form-group col-sm-11">
                        <label style="font-size: 16px">Body Template</label>
                        <textarea class="summernote" name="isi_body" id="summernote" cols="30" rows="10" required>{{ $template->isi_body }}</textarea>
                        @error('isi_body')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-1">
                        <a data-toggle="tooltip" title="Langkah Penulisan Content :
                                                        1. Untuk nomor surat di inputkan variable ${nomor_surat}.
                                                        2. Jika muncul peringatan terjadi kesalahan menulis maka edit ulang isi content, karena ada beberapa tag html yang tidak terbaca oleh PHPWORD." >
                        <i class="fas fa-exclamation-circle"></i><b> info</b></a>
                    </div>
                </div>
                @if ($template->isi_footer != null)
                    <div class="row">
                        <div class="form-group col-sm-11">
                            <label style="font-size: 16px">Footer Template</label>
                            <textarea class="summernote2" name="isi_footer" id="summernote2" cols="30" rows="10" >{{ $template->isi_footer }}</textarea>
                            @error('isi_footer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-1">
                            <a data-toggle="tooltip" title="Footer adalah paragraf yang terletak di bawah tandatangan,
                                                            Langkah Penulisan footer:
                                                            1. Penulisan seperti paragraf biasa.
                                                            2. Jika muncul peringatan terjadi kesalahan menulis maka edit ulang isi content, karena ada beberapa tag html yang tidak terbaca oleh PHPWORD." >
                            <i class="fas fa-exclamation-circle"></i><b> info</b></a>
                        </div>
                    </div>
                @endif
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
                    <button type="submit" class="btn btn-primary">Testing Template</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
