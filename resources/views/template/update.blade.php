@extends('layout')
@section('title','Form Update Template')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.template') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Template Surat</h1>
</div>

<div class="section-body">
    <div class="row">
        <form action="{{ route('update.template', $template) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4>Data Template</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px" class="form-label">Unit Data</label>
                            <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id" >
                                <option disabled selected>-- Unit Data--</option>
                                @if ($user->isAdmin())
                                    <option selected value="{{ $template->unitKerja->id }}">{{ $template->unitKerja->nama }}</option>
                                    @foreach ($unitKerja as $unitKerja)
                                        @if($template->unitKerja->id === $unitKerja->id)
                                            @continue
                                        @else
                                            <option value="{{ $unitKerja->id }}" {{ (old("unit_id") == $unitKerja->id ? "selected":"") }}>{{ $unitKerja->nama }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @for ($i = 0; $i < count($getRole); $i++)
                                        @if ($getRole[$i][0] == $template->role->id)
                                            <option selected value="{{ $template->role->id }}">{{ $template->role->nama }}</option>
                                        @else
                                            <option value="{{ $getRole[$i][0] }}" {{ (old("unit_id") == $getRole[$i][0] ? "selected":"") }}>{{ $getRole[$i][1] }}</option>
                                        @endif
                                    @endfor
                                @endif
                            </select>
                            @error('unit_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="formFile" class="form-label" style="font-size: 16px">Nama File</label>
                            <input class="form-control @error('file') is-invalid @enderror" type="file" id="formFile" name="file" value="{{ old('file') }}">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                               File template sudah ada. Apakah yakin akan di rubah ??
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
                            <label style="font-size: 16px">Nama Template</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $template->nama }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">{{ $template->keterangan }}</textarea>
                            @error('keterangan')
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
                    <h4>Content Template</h4>
                </div>
                <div class="card-body">
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
                    {{-- @if ($template->isi_footer != null) --}}
                        <div class="row">
                            <div class="form-group col-sm-11">
                                <label style="font-size: 16px">Footer Template</label>
                                <textarea class="summernote2" name="isi_footer" id="summernote2" cols="30" rows="10" required>{{ $template->isi_footer }}</textarea>
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
                    {{-- @endif --}}
                    <div class="form-group">
                        <label style="font-size: 16px">Jumlah Tanda Tangan</label>
                        <input type="number" class="form-control @error('jumlah_ttd') is-invalid @enderror" name="jumlah_ttd" id="" value="{{ $template->jumlah_ttd }}">
                        @error('jumlah_ttd')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
