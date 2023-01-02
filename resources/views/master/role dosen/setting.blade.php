@extends('layout')
@section('title','Setting Master Role Dosen')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.masterRoleDosen') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Setting Master Role Dosen <b>{{ $dosen->nama }}</b></h1>
</div>
<div class="section-body">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <a href="#" class="btn btn-primary" title="Tambah Role Dosen" data-bs-toggle="modal" data-bs-target="#add-role">Tambah Role</a>
                <div class="table-responsive mt-3">
                    <table class="table" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getRoleDosen as $data)
                                <tr>
                                    <td>
                                        <div class="sort-handler ui-sortable-handle text-center">
                                            <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $data->role->nama }}</td>
                                    <td>
                                        <form action="{{ route('destroy.masterRoleDosen', $data->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="btn btn-warning" title="Update Role" data-bs-toggle="modal" data-bs-target="#update-role{{ $data->id }}"><i class="far fa-edit"></i> Update</a>
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
@section('modal')
    <div class="modal fade" id="add-role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menambah role pada <b>{{ $dosen->nama }}</b>
                    <form action="{{ route('store.masterRoleDosen', $dosen->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="col-form-label">Role</label>
                            <select class="form-control" name="role_id">
                                <option selected disabled>--Pilih Role--</option>
                                @foreach ($role as $roles)
                                    <option value="{{ $roles->id }}">{{ $roles->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($getRoleDosen as $roleDosen)
        <div class="modal fade" id="update-role{{ $roleDosen->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('update.masterRoleDosen', $roleDosen->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            Apakah anda yakin ingin merubah role pada <b>{{ $dosen->nama }}</b>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Role</label>
                                <select class="form-control" name="role_id">
                                    <option selected value="{{ $roleDosen->role_id }}">{{ $roleDosen->role->nama }}</option>
                                    @foreach ($role as $roleUpdate)
                                        @if ($roleDosen->role->id == $roleUpdate->id)
                                            @continue
                                        @endif
                                        <option value="{{ $roleUpdate->id }}">{{ $roleUpdate->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection


