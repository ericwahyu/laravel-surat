@extends('layout')
@section('title','Disposisi Surat')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        @if ($surat->jenis->kategori_id == 1)
            <a href="{{ route('index.surat.masuk', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        @elseif ($surat->jenis->kategori_id == 2)
            <a href="{{ route('index.surat.keluar', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        @endif
    </div>
    <h1>Disposisi Surat Dari <b>{{ $surat->judul }}</b></h1>
    <div class="section-header-button">
        @if ($user->isAdmin() == 1 || $user->isPengelola() == 3)
            <a href="{{ route('create.disposisi', $surat) }}" class="btn btn-primary" title="Tambah Disposisi Surat">Tambah Baru</a>
        @endif
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>No Surat</th>
                                <th>Perihal Disposisi</th>
                                <th>Tanggal</th>
                                <th>Isi Disposisi</th>
                                <th>Pihak Bersangkutan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $disposisi)
                                <tr>
                                    <td>
                                        <div class="sort-handler ui-sortable-handle text-center">
                                        <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $disposisi->surat->nosurat }}</td>
                                    <td>{{ $disposisi->perihal }}</td>
                                    <td>{{ IdDateFormatter::format($disposisi->tanggal, IdDateFormatter::COMPLETE) }}</td>
                                    <td>{{ $disposisi->isi }}</td>
                                    <td>
                                        <table>
                                            @foreach (DisposisiController::get_dosen($disposisi->id) as $status_dosen)
                                                <tr>
                                                    <td>{{ $status_dosen->nama }}</td>
                                                    @switch($status_dosen->status)
                                                        @case(1)
                                                            <td><span class="badge badge-primary">Asal Surat</span></td>
                                                            @break
                                                        @case(2)
                                                            <td><span class="badge badge-secondary">Terkirim</span></td>
                                                            @break
                                                        @case(3)
                                                            <td><span class="badge badge-success">Terbaca</span></td>
                                                            @break
                                                        @case(4)
                                                            <td><span class="badge badge-success">LanjutKan Proses</span></td>
                                                            @break
                                                        @case(5)
                                                            <td><span class="badge badge-success">Balas Surat</span></td>
                                                            @break
                                                        @case(6)
                                                            <td><span class="badge badge-success">Tertanda Tangan</span></td>
                                                            @break
                                                        @default
                                                    @endswitch
                                                </tr>
                                            @endforeach
                                            @foreach (DisposisiController::get_mahasiswa($disposisi->id) as $status_mahasiswa)
                                                <tr>
                                                    <td>{{ $status_mahasiswa->nama }}</td>
                                                    @switch($status_mahasiswa->status)
                                                        @case(1)
                                                            <td><span class="badge badge-primary">Asal Surat</span></td>
                                                            @break
                                                        @case(2)
                                                            <td><span class="badge badge-secondary">Terkirim</span></td>
                                                            @break
                                                        @case(3)
                                                            <td><span class="badge badge-success">Terbaca</span></td>
                                                            @break
                                                        @case(4)
                                                            <td><span class="badge badge-success">LanjutKan Proses</span></td>
                                                            @break
                                                        @case(5)
                                                            <td><span class="badge badge-success">Balas Surat</span></td>
                                                            @break
                                                        @case(6)
                                                            <td><span class="badge badge-success">Tertanda Tangan</span></td>
                                                            @break
                                                        @default
                                                    @endswitch
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <a href="{{ route('edit.disposisi', $disposisi) }}" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i></a> --}}
                                            <a href="{{ route('show.disposisi', $disposisi) }}" class="btn btn-info" title="Lihat detail"><i class="fa fa-eye"></i> Detail</a>
                                            {{-- <button type="submit" class="btn btn-danger mr-2 show_confirm" data-toggle="tooltip" title="Hapus"><i class="far fa-trash-alt"></i></button> --}}
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


