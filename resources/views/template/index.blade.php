@extends('layout')
@section('title','Template Surat')
@section('section')
<div class="section-header">
    <h1>Template Surat</h1>
    <div class="section-header-button">
        <a href="{{ route('create.template') }}" class="btn btn-primary" title="Tambah Template Surat">Tambah Baru</a>
        <a href="{{ route('download.template', $id = 'template_contoh.docx') }}" class="btn btn-info" style="width: auto" title="Download Contoh Template"><i class="fas fa-download mr-2"></i>Download Contoh Template</a>
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
                                    <th class="text-center">
                                    #
                                    </th>
                                    <th>Nama Template</th>
                                    <th>Nama File</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($template as $data)
                                    <tr>
                                        <td>
                                            <div class="sort-handler ui-sortable-handle text-center">
                                            <i class="fas fa-th"></i>
                                            </div>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->file }}</td>
                                        <td>{{ $data->keterangan }}</td>
                                        <td>
                                            <form action="{{ route('destroy.template', $data) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('edit.template', $data) }}" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i></a>
                                                <a href="{{ route('download.template', $data->id) }}" class="btn btn-info" title="Download Template"><i class="fas fa-download"></i></a>
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


