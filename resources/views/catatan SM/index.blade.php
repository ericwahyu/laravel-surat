@extends('layout')
@section('title','Agenda Surat Masuk')
@section('section')
<div class="section-header">
    <h1>Agenda Surat Masuk</h1>
    <div class="section-header-button">

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
                                    <th class="text-center">#</th>
                                    <th>Waktu Masuk</th>
                                    <th>Nama Penyatat</th>
                                    <th>No Surat</th>
                                    <th>Judul Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Catatan Surat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($catatan as $data)
                                    <tr>
                                        <td>
                                            <div class="sort-handler ui-sortable-handle text-center">
                                            <i class="fas fa-th"></i>
                                            </div>
                                        </td>
                                        {{-- @php
                                            dd($data->user->mahasiswa)
                                        @endphp --}}
                                        <td>{{ $data->waktu }}</td>
                                        <td>{{ $data->user->username }}</td>
                                        <td>{{ $data->surat->nosurat }}</td>
                                        <td>{{ $data->surat->judul }}</td>
                                        <td>{{ $data->surat->tanggal }}</td>
                                        <td>{{ $data->catatan }}</td>
                                        {{-- <td>
                                            <form action="" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i></a>
                                                <button type="submit" class="btn btn-danger mr-2" onclick="" title="Hapus"><i class="far fa-trash-alt"></i></button>
                                            </form>
                                        </td> --}}
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


