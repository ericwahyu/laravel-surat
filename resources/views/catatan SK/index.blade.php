@extends('layout')
@section('title','Agenda Surat Keluar')
@section('section')
<div class="section-header">
    <h1>Agenda Surat Keluar</h1>
    <div class="section-header-button">

    </div>

</div>
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('index.agenda.keluar') }}" method="get">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label style="font-size: 16px">Tanggal Awal</label>
                                <input type="date" class="form-control @error('tanggalAwal') is-invalid @enderror" name="tanggalAwal" value="{{ $request->tanggalAwal }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label style="font-size: 16px">Tanggal Akhir</label>
                                <input type="date" class="form-control @error('tanggalAkhir') is-invalid @enderror" name="tanggalAkhir" value="{{ $request->tanggalAkhir }}">
                            </div>
                            <div class="form-group col-md-4">
                                <button type="submit" class="btn btn-primary" style="margin-top: 35px">Filter Data</button>
                            </div>
                        </div>
                    </form>
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
                                    {{-- <th>Action</th> --}}
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
                                        <td>{{ IdDateFormatter::format($data->waktu, IdDateFormatter::COMPLETE_WITH_TIME) }}</td>
                                        @foreach ($data->user->mahasiswa as $dat_maha)
                                            <td>{{ $dat_maha->nama }}</td>
                                        @endforeach
                                        @foreach ($data->user->dosen as $dat_dos)
                                            <td>{{ $dat_dos->nama }}</td>
                                        @endforeach
                                        <td>{{ $data->surat->nosurat }}</td>
                                        <td>{{ $data->surat->judul }}</td>
                                        <td>{{ IdDateFormatter::format($data->surat->tanggal, IdDateFormatter::COMPLETE) }}</td>
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


