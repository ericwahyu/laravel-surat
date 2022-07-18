@extends('layout')
@section('title','Disposisi Surat Masuk')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.surat.masuk') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Disposisi Surat Dari <b>{{ $surat->judul }}</b></h1>
    <div class="section-header-button">
        <a href="{{ route('create.disposisi.masuk', $surat->id) }}" class="btn btn-primary" title="Tambah Disposisi Surat">Tambah Baru</a>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>No Surat</th>
                                <th>Perihal Disposisi</th>
                                <th>Tanggal</th>
                                <th>Isi Disposisi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $datas)
                                <tr>
                                    <td>
                                        <div class="sort-handler ui-sortable-handle text-center">
                                        <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $datas->surat->nosurat }}</td>
                                    <td>{{ $datas->perihal }}</td>
                                    <td>{{ $datas->tanggal }}</td>
                                    <td>{{ $datas->isi }}</td>
                                    <td>
                                        <form action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i></a>
                                            <button type="submit" class="btn btn-danger mr-2" onclick="return confirm('Apakah Anda yakin ingin menghapus {{ $datas->judul }} ?')" title="Hapus"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


