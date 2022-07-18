@extends('templateadmin')
@section('title','Surat Keluar')
@section('header','Surat Keluar')
@section('body')
<div class="row">
    <div class="col-6 mb-3">
        <a href="{{ route('create.surat.keluar') }}" class="btn btn-primary mb-3" style="width: auto" title="Generate Surat"><i class="far fa-plus-square mr-2"></i>Generate Surat</a>
        {{-- <a href="#" class="btn btn-info mb-3 ml-3" style="width: auto"><i class="fas fa-download mr-2"></i>Download Contoh Kategori</a> --}}
    </div>
    <div class="col-6">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ $message }}
                </div>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ $message }}
                </div>
            </div>
        @endif
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Tabel Surat Keluar</h4>
                <div class="card-header-action">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <div class="input-group-btn">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped" id="sortable-table">
                        <thead>
                            <tr>
                            <th class="sort-handler ui-sortable-handle text-center">
                                <i class="fas fa-th"></i>
                            </th>
                            <th>No Surat</th>
                            <th>Judul Surat</th>
                            <th>File Surat</th>
                            <th>Tanggal Surat Keluar</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ui-sortable">
                            @foreach ($data as $data)
                                <tr>
                                    <td>
                                        <div class="sort-handler ui-sortable-handle text-center">
                                        <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $data->nosurat }}</td>
                                    <td>{{ $data->judul }}</td>
                                    <td>{{ $data->file }}</td>
                                    <td>{{ $data->tglkeluar }}</td>
                                    <td>
                                        <form action="{{ route('delete.surat.keluar', $data->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('edit.surat.keluar', $data->id) }}" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i></a>
                                            <button type="submit" class="btn btn-danger mr-2" onclick="return confirm('Apakah Anda yakin ingin menghapus {{ $data->judul }} ?')" title="Hapus"><i class="far fa-trash-alt"></i></button>
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


