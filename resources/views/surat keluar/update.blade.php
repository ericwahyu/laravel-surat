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
    <div class="card">
        <div class="card-header">
            <h4>Data Surat</h4>
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
            <form action="{{ route('update.surat.keluar', $surat) }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="tab-content mt-4" id="myTabContent2">
                <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
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
                        {{-- <div class="form-group col-md-6">
                            <label style="font-size: 16px">Tanggal Surat</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ $surat->tanggal }}">
                            @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div> --}}
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
                            <label style="font-size: 16px">Nomor Surat</label>
                            <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor_surat" readonly="" value="{{ $surat->nosurat }}" >
                            @error('nomor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Catatan</label>
                                {{-- <input type="text" class="form-control @error('catatan') is-invalid @enderror" name="catatan" value=""> --}}
                                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" cols="30" rows="10"></textarea>
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
                    </div>
                    <input type="hidden" name="generate_id" value="{{ $generate->id }}">
                    <input type="hidden" name="template_id" value="{{ $generate->template->id }}">
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
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ $surat->tanggal }}" required>
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
                                    <a data-toggle="tooltip" title="Langkah Penulisan Content :
                                                                    1. Untuk nomor surat di inputkan variable ${nomor_surat}.
                                                                    2. Jika muncul peringatan terjadi kesalahan menulis maka edit ulang isi content, karena ada beberapa tag html yang tidak terbaca oleh PHPWORD." >
                                    <i class="fas fa-exclamation-circle"></i><b> info</b></a>
                                </div>
                            </div>
                            @if ($generate->footer_content != null)
                            <div class="row">
                                <div class="form-group col-sm-11">
                                    <label style="font-size: 16px">Isi Footer Template</label>
                                    <textarea class="summernote2" name="isi_footer" id="summernote2" cols="30" rows="10" required>{{ $generate->footer_content }}</textarea>
                                    @error('isi_footer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-1" style="margin-top: 10px">
                                    <a data-toggle="tooltip" title="Footer adalah paragraf yang terletak di bawah tandatangan,
                                                                    Langkah Penulisan footer:
                                                                    1. Penulisan seperti paragraf biasa.
                                                                    2. Jika muncul peringatan terjadi kesalahan menulis maka edit ulang isi content, karena ada beberapa tag html yang tidak terbaca oleh PHPWORD." >
                                    <i class="fas fa-exclamation-circle"></i><b> info</b></a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
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
                                <a href="#" class="nav-link btn btn-primary" id="next">Next >></a>
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                    <div class="row">
                        <div class="form-group col-md-11">
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
                        </div>
                        <div class="form-group col-md-1">
                             <a data-toggle="tooltip" title="Diharapkan tidak menghapus dan merubah file yang pertama !!. Agar tidak menjadi kesalahan saat file terjadi perubahan data surat, karena data surat ini menggunakan template" >
                            <i class="fas fa-exclamation-circle"></i><b> info</b></a>
                        </div>
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
