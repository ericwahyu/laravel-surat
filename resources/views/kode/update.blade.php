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
                                <label style="font-size: 16px" class="form-label">Role Data</label>
                                <select class="form-control @error('role_id') is-invalid @enderror" name="role_id" >
                                    <option disabled selected>-- Role Data--</option>
                                    @if ($user->isAdmin())
                                        <option selected value="{{ $kode->role->id }}">{{ $kode->role->nama }}</option>
                                        @foreach ($role as $role)
                                            @if($kode->role->id === $role->id)
                                                @continue
                                            @else
                                                <option value="{{ $role->id }}" {{ (old("role_id") == $role->id ? "selected":"") }}>{{ $role->nama }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @for ($i = 0; $i < count($getRole); $i++)
                                            @if ($getRole[$i][0] == $kode->role->id)
                                                <option selected value="{{ $kode->role->id }}">{{ $kode->role->nama }}</option>
                                            @else
                                                <option value="{{ $getRole[$i][0] }}" {{ (old("role_id") == $getRole[$i][0] ? "selected":"") }}>{{ $getRole[$i][1] }}</option>
                                            @endif
                                        @endfor
                                    @endif
                                </select>
                                @error('role_id')
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
