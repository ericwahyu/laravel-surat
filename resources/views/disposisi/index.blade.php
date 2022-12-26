@extends('layout')
@section('title','Disposisi Surat')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        {{-- @foreach ($kategori as $datas) --}}
            @if ($kategori->kategori_id == 1)
                <a href="{{ route('show.surat.masuk', $kategori->surat_id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            @elseif ($kategori->kategori_id == 2)
                <a href="{{ route('show.surat.keluar', $kategori->surat_id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            @endif
        {{-- @endforeach --}}
    </div>
    <h1>Disposisi Surat Dari <b>{{ $surat->judul }}</b></h1>
    <div class="section-header-button">
        @if ($user->isAdmin()|| $user->isPengelola())
            <a href="{{ route('create.disposisi', $surat) }}" class="btn btn-primary" title="Tambah Disposisi Surat">Tambah Baru</a>
        @endif
    </div>
</div>
<div class="section-body">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nomor Surat</th>
                            <th>Perihal</th>
                            <th>Tanggal</th>
                            {{-- <th>Isi</th> --}}
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
                                {{-- <td>{{ $disposisi->isi }}</td> --}}
                                <td>
                                    <table>
                                        @foreach (DisposisiController::getDosen($disposisi->id) as $disposisi_dosen)
                                            <tr>
                                                <td>{{ $disposisi_dosen->nama }}</td>
                                                @switch($disposisi_dosen->kategori_id)
                                                    @case(2)
                                                        <td><span class="badge badge-primary">Asal Surat</span></td>
                                                        @break
                                                    @case(1)
                                                        <td><span class="badge badge-secondary">Terkirim</span></td>
                                                        @break
                                                    @default
                                                @endswitch
                                                @if ($disposisi_dosen->kategori_id == 1)
                                                    @if (DisposisiController::getDosenResponse($disposisi->id) != null)
                                                        <td><span class="badge badge-dark">{{ DisposisiController::getDosenResponse($disposisi->id)->nama }}</span></td>
                                                    @else
                                                        <td><span class="badge badge-dark">Belom ada response</span></td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                        @foreach (DisposisiController::getMahasiswa($disposisi->id) as $disposisi_mahasiswa)
                                            <tr>
                                                <td>{{ $disposisi_mahasiswa->nama }}</td>
                                                @switch($disposisi_mahasiswa->kategori_id)
                                                    @case(2)
                                                        <td><span class="badge badge-primary">Asal Surat</span></td>
                                                        @break
                                                    @case(1)
                                                        <td><span class="badge badge-secondary">Terkirim</span></td>
                                                        @break
                                                @endswitch
                                                @if ($disposisi_mahasiswa->kategori_id == 1)
                                                    @if ( DisposisiController::getMahasiswaResponse($disposisi->id) != null)
                                                        <td><span class="badge badge-dark">{{ DisposisiController::getMahasiswaResponse($disposisi->id)->nama }}</span></td>
                                                    @else
                                                        <td><span class="badge badge-dark">Belom ada response</span></td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                        @foreach (DisposisiController::getUserEksternal($disposisi->id) as $disposisi_usereksternal)
                                            <tr>
                                                <td>{{ $disposisi_usereksternal->nama }}</td>
                                                @switch($disposisi_usereksternal->kategori_id)
                                                    @case(2)
                                                        <td><span class="badge badge-primary">Asal Surat</span></td>
                                                        @break
                                                    @case(1)
                                                        <td><span class="badge badge-secondary">Terkirim</span></td>
                                                        @break
                                                @endswitch
                                                {{-- <td><span class="badge badge-dark">Terkirim</span></td> --}}
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('show.disposisi', $disposisi) }}" class="btn btn-info" title="Lihat detail"><i class="fa fa-eye"></i> Detail</a>
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
@endsection


