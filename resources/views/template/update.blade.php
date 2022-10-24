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
                    <div class="form-group">
                        <label style="font-size: 16px">Nama Template</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Surat permohonan cuti" value="{{ $template->nama }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
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
                    <div class="form-group">
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
            <div class="card">
                <div class="card-header">
                    <h4>Content Template</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label style="font-size: 16px">Isi Body Template</label>
                        <textarea class="summernote" name="isi_body" id="summernote" cols="30" rows="10" required>{{ $template->isi_body }}</textarea>
                        @error('isi_body')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if ($template->isi_footer != null)
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
