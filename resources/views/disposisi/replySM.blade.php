@extends('layout')
@section('title','Reply Surat Masuk')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('show.disposisi', $disposisi) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Reply Surat Masuk <b>{{ $surat->judul }}</b></h1>
</div>

<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Reply Surat</h4>
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
                </div>
                <div class="col-12 col-md-5">
                    <table class="table">
                        <tbody>
                            @foreach ($status_dosen as $sta_dos)
                                <tr>
                                    <td>{{ $sta_dos->nama }}</td>
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
                                        @default
                                    @endswitch
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-12">
                        <form action="{{ route('store.reply.surat.masuk', $disposisi) }}" method="post">
                            @csrf
                            <label style="font-size: 16px">Catatan</label>
                            <textarea name="catatan" cols="30" rows="10" class="form-control @error('catatan') is-invalid @enderror">Balas surat {{ $surat->judul }}, dengan catatan ......</textarea>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Masukkan catatan  !!
                            </small>
                            @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="row">
                                <div class="col-12 col-md-2 offset-md-8">
                                    <button type="submit" class="btn btn-primary" title="Reply"><i class="fa fa-paper-plane"> Reply surat</i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
