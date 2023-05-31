@extends('layout')
@section('title','Update Kode Surat')
@section('section')
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('index.kode') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Update Kode Surat</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('update.kode', $kode) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Kode Surat</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label style="font-size: 16px" class="form-label">Unit Data</label>
                                <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id" >
                                    <option disabled selected>-- Unit Data--</option>
                                    @if ($user->isAdmin())
                                        <option selected value="{{ $kode->unitKerja->id }}">{{ $kode->unitKerja->nama }}</option>
                                        @foreach ($unitKerja as $unitKerja)
                                            @if($kode->unitKerja->id === $unitKerja->id)
                                                @continue
                                            @else
                                                <option value="{{ $unitKerja->id }}" {{ (old("unit_id") == $unitKerja->id ? "selected":"") }}>{{ $unitKerja->nama }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @for ($i = 0; $i < count($getUnit); $i++)
                                            @if ($getUnit[$i][0] == $kode->unitKerja->id)
                                                <option selected value="{{ $kode->unitKerja->id }}">{{ $kode->unitKerja->nama }}</option>
                                            @else
                                                <option value="{{ $getUnit[$i][0] }}" {{ (old("unit_id") == $getUnit[$i][0] ? "selected":"") }}>{{ $getUnit[$i][1] }}</option>
                                            @endif
                                        @endfor
                                    @endif
                                </select>
                                @error('unit_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px">Nama Kode Surat</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="" value="{{ $kode->nama }}">
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px">Kode Surat</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" placeholder="" value="{{ $kode->kode }}">
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px">Format Penomoran Surat</label>
                                <input type="text" class="form-control @error('penomoran') is-invalid @enderror" name="penomoran" placeholder="" value="{{ $kode->penomoran }}">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Jika format nomor 021/JTC/ITATS/XI/2022, maka masukkan dengan {nomor_urut}/{kode}/ITATS/{bulan}/{tahun}
                                </small>
                                @error('penomoran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label style="font-size: 16px">Penomoran Surat Selanjutnya</label>
                                        <input type="number" class="form-control @error('increment') is-invalid @enderror" name="increment" placeholder="" value="{{ $kode->increment }}" min="1">
                                        @error('increment')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label style="font-size: 16px; margin-top: 40px">Nomor Urut Selanjutnya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px">Jumlah Digit Penomoran Surat</label>
                                <input type="number" class="form-control @error('digit') is-invalid @enderror" name="digit" placeholder="" value="{{ $kode->digit }}">
                                @error('digit')
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
