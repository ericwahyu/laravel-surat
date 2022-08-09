@extends('layout')
@section('title','Detail Surat Disposisi')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.disposisi', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Surat Disposisi</h1>
</div>

<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Detail</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-7">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Jenis Surat</td>
                                <td>:</td>
                                <td>{{ $surat->jenis->nama_jenis }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Surat</td>
                                <td>:</td>
                                <td>{{ $surat->nosurat }}</td>
                            </tr>
                            <tr>
                                <td>Perihal Disposisi</td>
                                <td>:</td>
                                <td>{{ $disposisi->perihal }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Disposisi</td>
                                <td>:</td>
                                <td>{{ $disposisi->tanggal }}</td>
                            </tr>
                            <tr>
                                <td>Isi Disposisi</td>
                                <td>:</td>
                                <td>{{ $disposisi->isi }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ route('edit.disposisi', $disposisi) }}" class="btn btn-warning" title="Update"><i class="far fa-edit"></i> Update</a>
                        </div>
                        <div class="col-md-2">
                            <form action="{{ route('destroy.disposisi', $disposisi) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title="Delete"><i class="far fa-trash-alt"></i> Delete</button>
                            </form>
                        </div>
                        @switch($surat->jenis->kategori->id)
                            @case(1)
                                @if ($user->isAdmin() == 1 || $user->isPimpinan() == 2)
                                    <div class="col-sm-2">
                                        <form action="{{ route('read.surat.masuk', $disposisi) }}" method="get">
                                            <button type="submit" class="btn btn-primary mr-2 show_read" data-toggle="tooltip" title="Read"><i class="far fa-eye"></i> Read</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{{ route('create.reply.surat.masuk', $disposisi) }}" class="btn btn-primary" title="Reply"><i class="fas fa-reply"></i> Reply</a>
                                    </div>
                                    <div class="col-sm-2">
                                        <form action="{{ route('continue.surat.masuk', $disposisi) }}" method="get">
                                            <button type="submit" class="btn btn-primary mr-2 show_continue" data-toggle="tooltip" title="Continue"><i class="fa fa-play"></i> Continue</button>
                                        </form>
                                    </div>
                                @elseif ($user->isDosen() == 4)
                                    <div class="col-sm-2">
                                        <form action="{{ route('read.surat.masuk', $disposisi) }}" method="get">
                                            <button type="submit" class="btn btn-primary mr-2 show_read" data-toggle="tooltip" title="Read"><i class="far fa-eye"></i> Read</button>
                                        </form>
                                    </div>
                                @endif
                                @break
                            @case(2)
                                @if ($user->isAdmin() == 1 || $user->isPimpinan() == 2)
                                    <div class="col-md-2">
                                        <form action="{{ route('ttd.surat.keluar', $disposisi) }}" method="get">
                                            <button type="submit" class="btn btn-primary mr-2 show_ttd" data-toggle="tooltip" title="Tanda Tangan"><i class="fa fa-check"></i> Tanda Tangan</button>
                                        </form>
                                    </div>
                                @endif
                                @break
                            @default
                        @endswitch
                        <div class="col-md-2 {{ ($surat->jenis->kategori->id == 2) ? 'offset-md-4' : ''}}">
                            <a href="" class="btn btn-success" title="Download"><i class="fa fa-download"></i> View File</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <table class="table">
                        <tbody>
                            @foreach ($status_dosen as $sta_dos)
                                <tr>
                                    <td>{{ $sta_dos->nama }}</td>
                                    <td>:</td>
                                    @switch($sta_dos->status)
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
                            @foreach ($status_mahasiswa as $sta_maha)
                                <tr>
                                    <td>{{ $sta_maha->nama }}</td>
                                    <td>:</td>
                                    @switch($sta_maha->status)
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
