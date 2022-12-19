@extends('layout')
@section('title','Update Keperluan Surat')
@section('section')
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('index.keperluan') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Update Keperluan Surat</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('update.keperluan', $keperluan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Keperluan</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label style="font-size: 16px" class="form-label">Format Surat</label>
                                <select class="form-control @error('format_id') is-invalid @enderror" name="format_id">
                                    <option disabled selected>-- Format Surat--</option>
                                    <option selected value="{{ $keperluan->format_id }}">{{ $keperluan->format->nama }}</option>
                                    @foreach ($format as $format)
                                        @if ($format->id != $keperluan->format_id)
                                            <option value="{{ $format->id }}">{{ $format->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('format_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px">Nama Keperluan Surat</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="" value="{{ $keperluan->nama }}">
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px">Kode Keperluan Surat</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" placeholder="" value="{{ $keperluan->kode }}">
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px">Format Penomoran Surat</label>
                                <input type="text" class="form-control @error('penomoran') is-invalid @enderror" name="penomoran" placeholder="" value="{{ $keperluan->penomoran }}">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Jika format nomor 021/JTC/ITATS/XI/2022, maka masukkan dengan {nomor_urut}/{kode}/ITATS/{bulan}/{tahun}
                                </small>
                                @error('penomoran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
