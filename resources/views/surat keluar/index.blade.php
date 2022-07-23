@extends('layout')
@section('title','Surat Keluar')
@section('section')
<div class="section-header">
    <h1>Surat Keluar</h1>
    <div class="section-header-button">
        <a href="{{ route('index.keluar.template') }}" class="btn btn-primary" title="Tambah Surat Masuk">Tambah Baru</a>
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
                                <th>Jenis</th>
                                <th>No Surat</th>
                                <th>Judul Surat</th>
                                <th>Tanggal Surat</th>
                                <th>Keterangan Surat</th>
                                <th>Download Surat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ui-sortable">
                            @foreach ($generate as $data)
                                <tr>
                                    <td>
                                        <div class="sort-handler ui-sortable-handle text-center">
                                        <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $data->jenis->nama_jenis }}</td>
                                    <td>{{ $data->nosurat }}</td>
                                    <td>{{ $data->judul }}</td>
                                    <td>{{ $data->tanggal }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    <td class="text-center"><a href="" class="btn btn-primary" title="Ubah"><i class="fas fa-save"></i></a></td>
                                    <td>
                                        <form action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i></a>
                                            <a href="{{ route('index.disposisi', $data) }}" class="btn btn-info" title="Disposisi Surat"><i class="fas fa-file"></i></a>
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
@endsection


