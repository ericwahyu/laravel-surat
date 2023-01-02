@extends('layout')
@section('title','Update Master Surat')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.masterSurat') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Master Surat</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('update.masterSurat', $surat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>Data Jenis Surat</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Status Surat</label>
                                <select class="form-control" name="status">
                                    @if ($surat->status === 1)
                                        <option selected value="1">Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    @elseif ($surat->status === 0)
                                        <option selected value="0">Non Aktif</option>
                                        <option value="1">Aktif</option>
                                    @endif
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
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
