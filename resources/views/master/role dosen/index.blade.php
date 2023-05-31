@extends('layout')
@section('title','Master Role Dosen')
@section('section')
<div class="section-header">
    <h1>Master Role Dosen</h1>
    {{-- <div class="section-header-button">
        <a href="" class="btn btn-primary" title="Tambah Jenis Surat">Tambah Baru</a>
    </div> --}}
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
                                <th>Unit Kerja</th>
                                <th>Role</th>
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
                                        <table>
                                            @foreach (App\Http\Controllers\DisposisiController::getUnitKerja($data->user_id) as $unitDosen)
                                                <tr>
                                                    <td>{{ $unitDosen }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            @foreach (App\Http\Controllers\MasterController::getRoleDosen($data->id) as $role)
                                                <tr>
                                                    <td>{{ $role->nama }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>
                                        <a href="{{ route('setting.masterRoleDosen', $data->id) }}" class="btn btn-warning" title="Update Data"><i class="fa fa-wrench"></i> Setting Role</a>
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


