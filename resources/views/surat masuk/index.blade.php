@extends('layout')
@section('title','Surat Masuk')
@section('section')
<div class="section-header">
    <h1>Surat Masuk</h1>
    <div class="section-header-button">
        @if ($user->isAdmin() == 1 || $user->isPengelola() == 3)
            <a href="{{ route('create.surat.masuk') }}" class="btn btn-primary" title="Tambah Surat Masuk">Tambah Baru</a>
        @endif
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surat as $data)
                                <tr>
                                    <td>
                                        <div class="sort-handler ui-sortable-handle text-center">
                                        <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $data->nama_jenis }}</td>
                                    <td>{{ $data->nosurat }}</td>
                                    <td>{{ $data->judul }}</td>
                                    <td>{{ $data->tanggal }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('show.surat.masuk', $data) }}" class="btn btn-info" title="Lihat detail"><i class="fa fa-eye"></i></a>
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


