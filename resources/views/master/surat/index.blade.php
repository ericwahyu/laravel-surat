@extends('layout')
@section('title','Master Data Surat')
@section('section')
<div class="section-header">
    <h1>Master Data Surat</h1>
</div>
<div class="section-body">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Jenis</th>
                                <th>Nomor Surat</th>
                                <th>Judul</th>
                                <th>Tanggal Surat</th>
                                <th>Keperluan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data)
                                <tr>
                                    <td>
                                        <div class="sort-handler ui-sortable-handle text-center">
                                            <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $data->jenis->nama }}</td>
                                    <td>{{ $data->nosurat }}</td>
                                    <td>{{ $data->judul }}</td>
                                    <td>{{ IdDateFormatter::format($data->tanggal, IdDateFormatter::COMPLETE) }}</td>
                                    <td>{{ $data->keperluan }}</td>
                                    @if ($data->status == 1)
                                        <td><span class="badge badge-success">Aktif</span></td>
                                    @else
                                        <td><span class="badge badge-danger">Tidak Aktif</span></td>
                                    @endif
                                    <td>
                                        <a href="{{ route('edit.masterSurat', $data->id) }}" class="btn btn-warning" title="Update Data"><i class="far fa-edit"></i> Update</a>
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


