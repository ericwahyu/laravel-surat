@extends('layout')
@section('title','Surat Masuk')
@section('section')
<div class="section-header">
    <h1>Surat Masuk</h1>
    <div class="section-header-button">
        <a href="{{ route('create.surat.masuk') }}" class="btn btn-primary" title="Tambah Surat Masuk">Tambah Baru</a>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Jenis</th>
                                    <th>No Surat</th>
                                    <th>Judul Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Keterangan Surat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $surat)
                                    <tr>
                                        <td>
                                            <div class="sort-handler ui-sortable-handle text-center">
                                            <i class="fas fa-th"></i>
                                            </div>
                                        </td>
                                        <td>{{ $surat->jenis->nama_jenis }}</td>
                                        <td>{{ $surat->nosurat }}</td>
                                        <td>{{ $surat->judul }}</td>
                                        <td>{{ $surat->tanggal }}</td>
                                        <td>{{ $surat->keterangan }}</td>
                                        <td>
                                            <form action="{{ route('destroy.surat.masuk', $surat) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('edit.surat.masuk', $surat) }}" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i></a>
                                                <a href="{{ route('index.disposisi.masuk', $surat) }}" class="btn btn-info" title="Disposisi Surat"><i class="fas fa-file"></i></a>
                                                <button type="submit" class="btn btn-danger mr-2 show_confirm" data-toggle="tooltip" title="Hapus"><i class="far fa-trash-alt"></i></button>
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
</div>
@endsection


