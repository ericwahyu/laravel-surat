@extends('templateadmin')
@section('title','Form Update Template')
@section('header','Form Update Template')
@section('body')
<div class="row">
    <div class="col-6 offset-6">
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ $message }}
                </div>
            </div>
        @endif
    </div>
    <div class="col-12">
        <form action="{{ route('update.template', $template->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-1">
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
                                        Nama file template adalah {{ $template->file }}, Apakah akan di rubah ??
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
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <a href="{{ route('index.template') }}" type="button" class="btn btn-secondary">Close</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
