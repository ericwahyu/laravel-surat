@extends('layout')
@section('title','Keperluan Surat')
@section('section')
<div class="section-header">
    <h1>Keperluan Surat</h1>
    <div class="section-header-button">
        @if ($user->isAdmin() == 1 || $user->isPengelola() == 3)
            <a href="{{ route('create.keperluan') }}" class="btn btn-primary" title="Tambah Keperluan Surat">Tambah Baru</a>
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
                                    <th>Format Surat</th>
                                    <th>Nama Keperluan Surat</th>
                                    <th>Kode Keperluan Surat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($keperluan as $data)
                                    <tr>
                                        <td>
                                            <div class="sort-handler ui-sortable-handle text-center">
                                            <i class="fas fa-th"></i>
                                            </div>
                                        </td>
                                        <td>{{ $data->format->nama }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->kode }}</td>
                                        <td>
                                            <form id="delete" action="{{ route('destroy.keperluan', $data) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('edit.keperluan', $data) }}" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i> Update</a>
                                                @if ($user->isAdmin() == 1 || $user->isPengelola() == 3)
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


