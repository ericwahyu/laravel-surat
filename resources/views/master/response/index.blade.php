@extends('layout')
@section('title','Master Response')
@section('section')
<div class="section-header">
    <h1>Master Respponse</h1>
    <div class="section-header-button">
        <a href="{{ route('create.masterResponse') }}" class="btn btn-primary" title="Tambah Jenis Surat">Tambah Baru</a>
    </div>
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
                                <th>Nama</th>
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
                                    <td>{{ $data->nama }}</td>
                                    <td>
                                        <form action="{{ route('destroy.masterResponse', $data->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('edit.masterResponse', $data->id) }}" class="btn btn-warning" title="Update Data"><i class="far fa-edit"></i> Update</a>
                                            <button type="submit" class="btn btn-danger mr-2 show_confirm" data-toggle="tooltip" title="Hapus"><i class="far fa-trash-alt"></i> Delete</button>
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


