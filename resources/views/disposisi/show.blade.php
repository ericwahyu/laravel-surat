@extends('layout')
@section('title','Detail Surat Disposisi')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.disposisi', $kategori->surat_id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                        @if ($user->isAdmin() || $user->isPengelola())
                            <div class="col-md-2">
                                <a href="{{ route('edit.disposisi', $disposisi) }}" class="btn btn-warning" title="Update"><i class="far fa-edit"></i> Update</a>
                            </div>
                        @endif
                        @if($user->isAdmin() || $user->isPengelola() || $user->isPimpinan())
                            <div class="col-md-2" style="margin-right: 10px">
                                <form action="{{ route('destroy.disposisi', $disposisi) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title="Delete"><i class="far fa-trash-alt"></i> Delete</button>
                                </form>
                            </div>
                        @endif
                        @if ($kategori->status == 2)
                            <div class="col-md-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">Beri Respons</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        @foreach ($response as $dataResponse)
                                            <div class="col-sm-2">
                                                <input type="hidden" name="response" id="response" value="{{ $dataResponse->nama }}">
                                                <button type="submit" class="btn btn-primary mr-2" title="{{ $dataResponse->nama }}" data-bs-toggle="modal" data-bs-target="#response{{ $dataResponse->id }}"> {{ $dataResponse->nama }}</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($user->isAdmin() || $user->isPengelola())
                            <div class="col-md-2 offset-md-2">
                                <a href="#" class="btn btn-dark" title="Ubah Response Penerima" data-bs-toggle="modal" data-bs-target="#ubah-response-penerima"><i class="far fa-edit"></i> Ubah Response Penerima</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <table class="table">
                        @foreach (DisposisiController::getDosen($disposisi->id) as $disposisi_dosen)
                            <tr>
                                <td>{{ $disposisi_dosen->nama }}</td>
                                @switch($disposisi_dosen->status)
                                    @case(1)
                                        <td><span class="badge badge-primary">Asal Surat</span></td>
                                        @break
                                    @case(2)
                                        <td><span class="badge badge-secondary">Terkirim</span></td>
                                        @break
                                    @default
                                @endswitch
                                @if ($disposisi_dosen->status == 2)
                                    @if (DisposisiController::getDosenResponse($disposisi->id, $disposisi_dosen->user_id) != null)
                                        <td><span class="badge badge-dark">{{ DisposisiController::getDosenResponse($disposisi->id, $disposisi_dosen->user_id)->nama }}</span></td>
                                    @else
                                        <td><span class="badge badge-dark">Belom ada respons</span></td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                        @foreach (DisposisiController::getMahasiswa($disposisi->id) as $disposisi_mahasiswa)
                            <tr>
                                <td>{{ $disposisi_mahasiswa->nama }}</td>
                                @switch($disposisi_mahasiswa->status)
                                    @case(1)
                                        <td><span class="badge badge-primary">Asal Surat</span></td>
                                        @break
                                    @case(2)
                                        <td><span class="badge badge-secondary">Terkirim</span></td>
                                        @break
                                @endswitch
                                @if ($disposisi_mahasiswa->status == 2)
                                    @if ( DisposisiController::getMahasiswaResponse($disposisi->id, $disposisi_mahasiswa->user_id) != null)
                                        <td><span class="badge badge-dark">{{ DisposisiController::getMahasiswaResponse($disposisi->id, $disposisi_mahasiswa->user_id)->nama }}</span></td>
                                    @else
                                        <td><span class="badge badge-dark">Belom ada respons</span></td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                        @foreach (DisposisiController::getUserEksternal($disposisi->id) as $disposisi_usereksternal)
                            <tr>
                                <td>{{ $disposisi_usereksternal->nama }}</td>
                                @switch($disposisi_usereksternal->status)
                                    @case(1)
                                        <td><span class="badge badge-primary">Asal Surat</span></td>
                                        @break
                                    @case(2)
                                        <td><span class="badge badge-secondary">Terkirim</span></td>
                                        @break
                                @endswitch
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @foreach ($response as $respon)
        <div class="modal fade" id="response{{ $respon->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Respons Surat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin sudah melihat surat, dan memberi respons {{ $respon->nama }} !!
                        <form action="{{ route('setResponse', $disposisi->id) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Catatan :</label>
                                <input type="text" class="form-control" id="recipient-name" name="catatan_response">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Masukkan catatan jika ada perlu !!
                                </small>
                            </div>
                            <input type="hidden" name="response_id" value="{{ $respon->id }}">
                            <input type="hidden" name="response_nama" value="{{ $respon->nama }}">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Kirim Respons</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal fade" id="ubah-response-penerima" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Respons Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('setResponsePenerima', $disposisi->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Penerima</label>
                            <select class="form-control" name="user_id" id="">
                                <option disabled selected>--Pilih User Penerima--</option>
                                @foreach ($getDosen as $getDosen)
                                    <option value="{{ $getDosen->user_id }}" {{ (old("user_id") == $getDosen->user_id ? "selected":"") }}>{{ $getDosen->nama }}</option>
                                @endforeach
                                @foreach ($getMahasiswa as $getMahasiswa)
                                    <option value="{{ $getMahasiswa->user_id }}" {{ (old("user_id") == $getMahasiswa->user_id ? "selected":"") }}>{{ $getMahasiswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Ubah Respons </label>
                            <select class="form-control" name="response_id" id="">
                                <option disabled selected>--Pilih Respons--</option>
                                @foreach ($response as $getResponse)
                                    <option value="{{ $getResponse->id }}" {{ (old("response_id") == $getResponse->id ? "selected":"") }} >{{ $getResponse->nama }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Catatan :</label>
                            <input type="text" class="form-control" id="recipient-name" name="catatan_response">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Masukkan catatan jika ada perlu !!
                            </small>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim Respons</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
