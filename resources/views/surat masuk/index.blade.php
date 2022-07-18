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
                                @foreach ($data as $datas)
                                    <tr>
                                        <td>
                                            <div class="sort-handler ui-sortable-handle text-center">
                                            <i class="fas fa-th"></i>
                                            </div>
                                        </td>
                                        <td>{{ $datas->jenis->nama_jenis }}</td>
                                        <td>{{ $datas->nosurat }}</td>
                                        <td>{{ $datas->judul }}</td>
                                        <td>{{ $datas->tanggal }}</td>
                                        <td>{{ $datas->keterangan }}</td>
                                        <td>
                                            <form action="" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i></a>
                                                <a href="{{ route('index.disposisi.masuk', $datas->id) }}" class="btn btn-info" title="Disposisi Surat"><i class="fas fa-file"></i></a>
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
</div>
@endsection


