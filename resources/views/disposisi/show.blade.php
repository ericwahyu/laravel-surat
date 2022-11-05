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
                                <td>{{ $surat->jenis->nama }}</td>
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
                                <td>{{IdDateFormatter::format( $disposisi->tanggal, IdDateFormatter::COMPLETE) }}</td>
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
                        <div class="col-md-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary">Beri Tanggapan</button>
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    @switch($surat->jenis->kategori->id)
                                        @case(1)
                                            @if ($user->isAdmin() || $user->isPimpinan())
                                                <a class="dropdown-item" href="{{ route('read.surat.masuk', $disposisi) }}"><i class="far fa-eye"></i> Read</a>
                                                <a class="dropdown-item" href="{{ route('create.reply.surat.masuk', $disposisi) }}"><i class="fas fa-reply"></i> Reply</a>
                                                <a class="dropdown-item" href="{{ route('continue.surat.masuk', $disposisi) }}"><i class="fa fa-play"></i> Continue</a>
                                            @elseif ($user->isDosen())
                                                <a class="dropdown-item" href="{{ route('read.surat.masuk', $disposisi) }}"><i class="far fa-eye"></i> Read</a>
                                            @endif
                                            @break
                                        @case(2)
                                            @if ($user->isAdmin()|| $user->isPimpinan())
                                                <a class="dropdown-item" href="{{ route('ttd.surat.keluar', $disposisi) }}"><i class="fa fa-check"></i> Tanda Tangan</a>
                                                {{-- <div class="col-md-2">
                                                    <form action="{{ route('ttd.surat.keluar', $disposisi) }}" method="get">
                                                        <button type="submit" class="btn btn-primary mr-2 show_ttd" data-toggle="tooltip" title="Tanda Tangan"><i class="fa fa-check"></i> Tanda Tangan</button>
                                                    </form>
                                                </div> --}}
                                            @endif
                                            @break
                                        @default
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        {{-- @switch($surat->jenis->kategori->id)
                            @case(1)
                                @if ($user->isAdmin()|| $user->isPimpinan())
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
                                @elseif ($user->isDosen())
                                    <div class="col-sm-2">
                                        <form action="{{ route('read.surat.masuk', $disposisi) }}" method="get">
                                            <button type="submit" class="btn btn-primary mr-2 show_read" data-toggle="tooltip" title="Read"><i class="far fa-eye"></i> Read</button>
                                        </form>
                                    </div>
                                @endif
                                @break
                            @case(2)
                                @if ($user->isAdmin()|| $user->isPimpinan())
                                    <div class="col-md-2">
                                        <form action="{{ route('ttd.surat.keluar', $disposisi) }}" method="get">
                                            <button type="submit" class="btn btn-primary mr-2 show_ttd" data-toggle="tooltip" title="Tanda Tangan"><i class="fa fa-check"></i> Tanda Tangan</button>
                                        </form>
                                    </div>
                                @endif
                                @break
                            @default
                        @endswitch --}}
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <table class="table">
                        <tbody>
                            @foreach (DisposisiController::get_status_dosen($disposisi->id) as $sta_dos)
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
                            @foreach (DisposisiController::get_status_mahasiswa($disposisi->id) as $sta_maha)
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
