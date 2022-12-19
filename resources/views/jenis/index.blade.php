@extends('layout')
@section('title','Jenis Surat')
@section('section')
<div class="section-header">
    <h1>Jenis Surat</h1>
    <div class="section-header-button">
        @if ($user->isAdmin() || $user->isPengelola())
            <a href="{{ route('create.jenis') }}" class="btn btn-primary" title="Tambah Jenis Surat">Tambah Baru</a>
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
                                    <th class="text-center">
                                    #
                                    </th>
                                    <th>Kategori Surat</th>
                                    <th>Jenis Surat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenis as $data)
                                    <tr>
                                        <td>
                                            <div class="sort-handler ui-sortable-handle text-center">
                                            <i class="fas fa-th"></i>
                                            </div>
                                        </td>
                                        <td>{{ $data->kategori->nama }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>
                                            <form id="delete" action="{{ route('destroy.jenis', $data) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                @if ($user->isAdmin() || $user->isPengelola() || $user->isPimpinan())
                                                    <a href="{{ route('edit.jenis', $data) }}" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i> Update</a>
                                                @endif
                                                @if ($user->isAdmin() || $user->isPengelola())
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


