@extends('layout')
@section('title','Tambah Surat Keluar')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.surat.keluar') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Pilih Template</h1>
</div>

<div class="section-body">

</div>
<div class="row">
    <form action="{{ route('store.surat.keluar') }}" method="POST">
        @csrf
        <div class="card">
            {{-- <div class="card-header">
                <h4>Daftar Surat</h4>
            </div> --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nama template</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ui-sortable">
                            @foreach ($template as $data)
                                <tr>
                                    <td>
                                        <div class="sort-handler ui-sortable-handle text-center">
                                        <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    <td>
                                        <form action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('create.surat.keluar', $data) }}" class="btn btn-primary" title="Buat Surat"><i class="fas fa-pen-alt"></i> Buat Surat</a>
                                            {{-- <button type="submit" class="btn btn-danger mr-2" onclick="return confirm('Apakah Anda yakin ingin menghapus {{ $data->judul }} ?')" title="Hapus"><i class="far fa-trash-alt"></i></button> --}}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
