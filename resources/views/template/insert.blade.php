@extends('layout')
@section('title','Tambah Template')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.template') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Template Surat</h1>
    <div class="section-header-button">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Intruksi Pembuatan Template
        </button>
    </div>
</div>

<div class="section-body">
    <form action="{{ route('store.template') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4>Data Template</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px" class="form-label">Unit Data</label>
                        <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id">
                            <option disabled selected>-- Unit Data--</option>
                            @if ($user->isAdmin())
                                @foreach ($unitKerja as $unitKerja)
                                    <option value="{{ $unitKerja->id }}" {{ (old("unitKerja_id") == $unitKerja->id ? "selected":"") }}>{{ $unitKerja->nama }}</option>
                                @endforeach
                            @else
                                @for ($i = 0; $i < count($getUnit); $i++)
                                    <option value="{{ $getUnit[$i][0] }}" {{ (old("unit_id") == $getUnit[$i][0] ? "selected":"") }}>{{ $getUnit[$i][1] }}</option>
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
                            Masukkan file dengan format .doc/.docx !!
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
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Surat template" value="{{ old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">Jabatan yang bersangkutan :</textarea>
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
                        <textarea class="summernote @error('isi_body') is-invalid @enderror" name="isi_body" id="summernote" cols="30" rows="10">{{ old('isi_body') }}</textarea>
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
                <div class="row">
                    <div class="form-group col-sm-11">
                        <label style="font-size: 16px">Footer Template</label>
                        <textarea class="summernote2" id="summernote2" name="isi_footer">{{ old('isi_footer') }}</textarea>
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
                <div class="form-group">
                    <label style="font-size: 16px">Jumlah Tanda Tangan</label>
                    <input type="number" class="form-control @error('jumlah_ttd') is-invalid @enderror" name="jumlah_ttd" id="" value="{{ old('jumlah_ttd') }}">
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
@endsection
@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Langkah-langkah pembuatan template</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Membuat file word (.doc / .docx) dengan beberapa variabel sebagai berikut :<br>
                        ${body}<br>
                        ${isiBody}<br>
                        ${/body}<br>
                        -> variabel diatas adalah untuk body surat yang akan di isi pada body template. <br><br>

                        ${tempat_surat} -> variabel ini terdapat pada area tandatangan yang berfungsi untuk memasukkan tempat surat disaat membuat surat.<br><br>

                        ${tanggal_surat} -> variabel ini terdapat pada area tandatangan yang berfungsi untuk memasukkan tanggal surat disaat pembuatan surat.<br><br>

                        ${jabatan_1} -> variabel ini terdapat pada area tandatangan yang berfungsi untuk memasukkan jabatan disaat pembuatan surat,
                        angka '1' pada variabel tersebut untuk menunjukkan jumlah tandatangan berjumlah 1, jika tandangan lebih dari 1 maka dapat ditambahkan
                        (${jabatan_2}, ${jabatan_3}, dst), pada form jumlah tandatangan harus menyesuaikan banyaknya jumlah tanda tangan.<br><br>

                        ${nama_1} -> variabel ini terdapat pada area tandatangan yang berfungsi untuk memasukkan nama yang bersangkutan pada surat tersebut,
                        angka '1' pada variabel tersebut untuk menunjukkan jumlah tandatangan berjumlah 1, jika tandangan lebih dari 1 maka dapat ditambahkan
                        (${nama_2}, ${nama_3}, dst), pada form jumlah tandatangan harus menyesuaikan banyaknya jumlah tanda tangan.<br><br>

                        ${nip_1} -> variabel ini terdapat pada area tandatangan yang berfungsi untuk memasukkan nomor NIP yang bersangkutan pada surat tersebut,
                        angka '1' pada variabel tersebut untuk menunjukkan jumlah tandatangan berjumlah 1, jika tandangan lebih dari 1 maka dapat ditambahkan
                        (${nip_2}, ${nip_3}, dst), pada form jumlah tandatangan harus menyesuaikan banyaknya jumlah tanda tangan.<br><br>

                        ${footer}<br>
                        ${isiFooter}<br>
                        ${/footer}<br>
                        -> variabel diatas adalah untuk footer surat yang terletak dibawah area tandatangan, dan akan di isi pada body template. <br><br>
                    </p>
                    {{-- <div class="row">
                        <div class="col-4">
                          <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab">Langkah 1</a>
                            <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab">Langkah 2</a>
                            <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab">Langkah 3</a>
                            <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab">Langkah 4</a>
                          </div>
                        </div>
                        <div class="col-8">
                          <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">

                            </div>
                            <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">

                            </div>
                            <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                              In quis non esse eiusmod sunt fugiat magna pariatur officia anim ex officia nostrud amet nisi pariatur eu est id ut exercitation ex ad reprehenderit dolore nostrud sit ut culpa consequat magna ad labore proident ad qui et tempor exercitation in aute veniam et velit dolore irure qui ex magna ex culpa enim anim ea mollit consequat ullamco exercitation in.
                            </div>
                            <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                              Lorem ipsum culpa in ad velit dolore anim labore incididunt do aliqua sit veniam commodo elit dolore do labore occaecat laborum sed quis proident fugiat sunt pariatur. Cupidatat ut fugiat anim ut dolore excepteur ut voluptate dolore excepteur mollit commodo.
                            </div>
                          </div>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
