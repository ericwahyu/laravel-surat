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
                <div class="col-12 col-md-8">
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
                    {{-- <div class="row">
                        <div class="col-md-2">
                            <a href="" class="btn btn-warning" title="Update"><i class="far fa-edit"> Update</i></a>
                        </div>
                        <div class="col-md-2">
                            <form action="" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title="Delete"><i class="far fa-trash-alt"> Delete</i></button>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form action="" method="post">
                                <button type="submit" class="btn btn-primary mr-2 show_read" data-toggle="tooltip" title="Read"><i class="far fa-eye"> Read</i></button>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <a href="" class="btn btn-primary" title="Reply"><i class="fas fa-reply"> Reply</i></a>
                        </div>
                        <div class="col-md-2">
                            <form action="" method="post">
                                <button type="submit" class="btn btn-primary mr-2 show_continue" data-toggle="tooltip" title="Continue"><i class="fa fa-play"> Continue</i></button>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <a href="" class="btn btn-success" title="Download"><i class="fa fa-download"> View File</i></a>
                        </div>
                    </div> --}}
                </div>
                <div class="col-12 col-md-4">
                    <table class="table">
                        <tbody>
                            @foreach ($status_dosen as $sta_dos)
                                <tr>
                                    <td>{{ $sta_dos->nama }}</td>
                                    <td>:</td>
                                    @if ($sta_dos->status = 1)
                                        <td><span class="badge badge-secondary">Terkirim</span></td>
                                    @elseif ($sta_dos->status = 2)
                                        <td><span class="badge badge-primary">Asal Surat</span></td>
                                    @endif
                                </tr>
                            @endforeach
                            @foreach ($status_mahasiswa as $sta_maha)
                                <tr>
                                    <td>{{ $sta_maha->nama }}</td>
                                    <td>:</td>
                                    @switch($sta_maha->status)
                                        @case(1)
                                            <td><span class="badge badge-secondary">Terkirim</span></td>
                                            @break
                                        @case(2)
                                            <td><span class="badge badge-primary">Asal Surat</span></td>
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
