@extends('layout')
@section('title','Kode Surat')
@section('section')
<div class="section-header">
    <h1>Kode Surat</h1>
    <div class="section-header-button">
        @if ($user->isAdmin() || $user->isPengelola())
            <a href="{{ route('create.kode') }}" class="btn btn-primary" title="Tambah Kode Surat">Tambah Baru</a>
        @endif
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">

                </div> --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Unit</th>
                                    <th>Nama</th>
                                    <th>Kode</th>
                                    <th>Format Penomoran</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kode as $data)
                                    <tr>
                                        <td>
                                            <div class="sort-handler ui-sortable-handle text-center">
                                            <i class="fas fa-th"></i>
                                            </div>
                                        </td>

                                        <td>{{ $data->unitKerja->nama }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->kode }}</td>
                                        <td>{{ $data->penomoran }}</td>
                                        <td>
                                            <form id="delete" action="{{ route('destroy.kode', $data) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                @if ($user->isAdmin() || $user->isPengelola() || $user->isPimpinan())
                                                    <a href="{{ route('edit.kode', $data) }}" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i> Update</a>
                                                @endif
                                                @if ($user->isAdmin()|| $user->isPengelola())
                                                    <button type="submit" class="btn btn-danger mr-2 show_confirm" data-toggle="tooltip" title="Hapus"><i class="far fa-trash-alt"></i> Delete</button>
                                                @endif
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


