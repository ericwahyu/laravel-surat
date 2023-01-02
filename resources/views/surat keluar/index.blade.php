@extends('layout')
@section('title','Surat Keluar')
@section('section')
<div class="section-header">
    <h1>Surat Keluar</h1>
    {{-- <div class="section-header-button">
        @if ($user->isAdmin() || $user->isPengelola())
            <a href="{{ route('index.keluar.template') }}" class="btn btn-primary" title="Tambah Surat Masuk">Tambah Baru</a>
        @endif
    </div> --}}
</div>
<div class="section-body">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('index.surat.keluar') }}" method="get">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label style="font-size: 16px">Filter Tahun</label>
                            <input type="number" class="form-control @error('tahun') is-invalid @enderror" name="tahun" min="2020" max="3000" value="{{ $request->tahun }}">
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary" style="margin-top: 35px">Filter Data</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table " id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Jenis</th>
                                <th>Nomor Surat</th>
                                <th>Judul</th>
                                <th>Tanggal Surat</th>
                                <th>Keperluan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ui-sortable">
                            @foreach ($generate as $data)

                                <tr style="background-color: {{ (GenerateController::readAtKeluar($data->id)->read_at == null) ? '#BEBBBA' : '#FFFBF9' }}">
                                    <td>
                                        <div class="sort-handler ui-sortable-handle text-center">
                                        <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $data->jenis->nama }}</td>
                                    <td>{{ $data->nosurat }}</td>
                                    <td>{{ $data->judul }}</td>
                                    <td>{{ IdDateFormatter::format($data->tanggal, IdDateFormatter::COMPLETE) }}</td>
                                    <td>{{ $data->keperluan }}</td>
                                    <td>
                                        <a href="{{ route('show.surat.keluar', $data) }}" class="btn btn-info" title="Lihat detail"><i class="fa fa-eye"></i> Detail</a>
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



