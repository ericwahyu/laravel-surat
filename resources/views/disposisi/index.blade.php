@extends('layout')
@section('title','Disposisi Surat')
@section('section')
<div class="section-header">
    <div class="section-header-back">
        @if ($surat->jenis->kategori_id == 1)
            <a href="{{ route('index.surat.masuk', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        @elseif ($surat->jenis->kategori_id == 2)
            <a href="{{ route('index.surat.keluar', $surat) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        @endif
    </div>
    <h1>Disposisi Surat Dari <b>{{ $surat->judul }}</b></h1>
    <div class="section-header-button">
        <a href="{{ route('create.disposisi', $surat) }}" class="btn btn-primary" title="Tambah Disposisi Surat">Tambah Baru</a>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>No Surat</th>
                                <th>Perihal Disposisi</th>
                                <th>Tanggal</th>
                                <th>Isi Disposisi</th>
                                <th>Tujukan Disposisi</th>
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
                                    <td>{{ $disposisi->tanggal }}</td>
                                    <td>{{ $disposisi->isi }}</td>
                                    <td>
                                        <ul>
                                            @foreach($disposisi->user as $user)
                                                <li> {{ $user->username }} </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('edit.disposisi', $disposisi) }}" class="btn btn-warning" title="Ubah"><i class="far fa-edit"></i></a>
                                            <button type="submit" class="btn btn-danger mr-2" onclick="" title="Hapus"><i class="far fa-trash-alt"></i></button>
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
</div>
@endsection


