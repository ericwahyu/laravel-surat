@extends('layout')
@section('title','Update Surat Masuk')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('show.surat.masuk', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Surat Masuk <b>{{ $surat->judul }}</b></h1>
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
                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">Data File Surat</a>
                </li>
            </ul>
            <form action="{{ route('update.surat.masuk', $surat) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="tab-content mt-4" id="myTabContent2">
                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Jenis Surat</label>
                                <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id">
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
                                    <label style="font-size: 16px">Keperluan Surat</label>
                                    <input type="text" class="form-control @error('keperluan') is-invalid @enderror" name="keperluan" value="{{ $surat->keperluan }}">
                                    @error('keperluan')
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
                                <textarea class="form-control @error('catatan_surat') is-invalid @enderror" name="catatan_surat" cols="30" rows="10">{{ old('catatan_surat') }}</textarea>
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
                            {{-- @if ($user->isAdmin())
                                <div class="form-group col-md-6">
                                    <label style="font-size: 16px">Status Surat</label>
                                    <select class="form-control" name="status">
                                        @if ($surat->status === 1)
                                            <option selected value="1">Aktif</option>
                                            <option value="0">Non Aktif</option>
                                        @elseif ($surat->status === 0)
                                            <option selected value="0">Non Aktif</option>
                                            <option value="1">Aktif</option>
                                        @endif
                                    </select>
                                    @error('jenis_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif --}}
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="nav-link btn btn-primary" id="next">Next >></a>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </div>
            </form>
                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                        <a href="#" class="btn btn-primary" title="Upload File Baru" data-bs-toggle="modal" data-bs-target="#file{{ $surat->id }}">Upload File</a>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="ui-sortable">
                                    @foreach ($file as $data)
                                        <tr>
                                            <td>
                                                <div class="sort-handler ui-sortable-handle text-center">
                                                <i class="fas fa-th"></i>
                                                </div>
                                            </td>
                                            <td>{{ $data->file }}</td>
                                            <td>
                                                <form action="{{ route('destroy.file', $data->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('download.file', $data->id) }}" class="btn btn-info" title="Lihat file"><i class="fa fa-eye"></i> View</a>
                                                    <a href="#" class="btn btn-warning" title="Update File" data-bs-toggle="modal" data-bs-target="#file_update{{ $data->id }}"><i class="far fa-edit"></i> Update</a>
                                                    <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title="Delete"><i class="far fa-trash-alt"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="nav-link btn btn-primary" id="back"><< Back</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    <div class="modal fade" id="file{{ $surat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin upload file baru pada <b>{{ $surat->judul }}</b>
                    <form action="{{ route('store.file', $surat->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Upload file :</label>
                            <input type="file" class="form-control" id="recipient-name" name="file">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                               Pastikan upload file berformat .doc/.docx/.pdf
                            </small>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($file as $files)
        <div class="modal fade" id="file_update{{ $files->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('update.file', $files->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            Apakah anda yakin update file <b>{{ $files->file }}</b>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Upload file :</label>
                                <input type="file" class="form-control" id="recipient-name" name="file">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                Pastikan upload file berformat .doc/.docx/.pdf
                                </small>
                            </div>
                            <input type="hidden" name="surat_id" value="{{ $surat->id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
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
