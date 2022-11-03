@extends('layout')
@section('title', 'Generate '.$template->nama)
@section('section')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('index.keluar.template') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Generate <b>{{ $template->nama }}</b></h1>
</div>

<div class="section-body">
    <form action="{{ route('store.surat.keluar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4>Data Surat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Jenis Surat</label>
                            <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id">
                                <option disabled selected>-- Jenis Surat--</option>
                                @foreach ($jenis as $jenis)
                                    <option value="{{ $jenis->id }}" {{ (old("jenis_id") == $jenis->id ? "selected":"") }}>{{ $jenis->nama }}</option>
                                @endforeach
                            </select>
                            @error('jenis_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Keterangan Surat</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan') }}">
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Judul Surat</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ $template->nama }}">
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 16px">Catatan</label>
                            <input type="text" class="form-control @error('catatan') is-invalid @enderror" name="catatan" value="{{ old('catatan') }}">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Masukkan catatan jika ada perlu !!
                            </small>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- hidden input --}}
                    <input type="hidden" name="template_id" value="{{ $template->id }}">
                    <input type="hidden" name="keperluan_id" id="keperluanId">
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Content Generate Surat</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Generate Nomor Surat</label>
                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomorSurat" name="nomor_surat" value="{{ old('nomor_surat') }}" required readonly>
                    </div>
                    <div class="form-group col-md-6" style="margin-top: 32px">
                        <!-- Button trigger modal -->
                        {{-- <a class="btn btn-primary" id="btn-Modal" onclick="modal()">Generate Nomor</a> --}}
                        <button class="btn btn-primary" id="btn-Modal" onclick="modal()">Generate Nomor</button>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Tempat Surat</label>
                        <input type="text" class="form-control @error('tempat_surat') is-invalid @enderror" name="tempat_surat" placeholder="Surabaya" value="{{ old('tempat_surat') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size: 16px">Tanggal Surat</label>
                        <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" name="tanggal_surat" value="{{ old('tanggal_surat') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label style="font-size: 16px">Buat Surat</label>
                        <textarea class="summernote" name="isi_body" id="summernote" cols="30" rows="10" required>{{ $template->isi_body }}</textarea>
                        @error('isiBody')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                @if ($template->isi_footer != null)
                        <div class="form-group">
                            <label style="font-size: 16px">Isi Footer Template</label>
                            <textarea class="summernote2" name="isi_footer" id="summernote2" cols="30" rows="10" required>{{ $template->isi_footer }}</textarea>
                            @error('isi_footer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endif
                <div class="row mt-md-3">
                    <label style="font-size: 16px">Tanda Tangan</label>
                    @for ($ttd = 1; $ttd <= $template->jumlah_ttd; $ttd++)
                        <div class="form-group col-md-6">
                            <label style="font-size: 13px">Jabatan Pihak ke-{{ $ttd }}</label>
                            <input type="text" class="form-control @error('jabatan_{{ $ttd }}') is-invalid @enderror" name="jabatan_{{ $ttd }}" value="" required>
                            <label style="font-size: 13px">Nama Pihak ke-{{ $ttd }}</label>
                            <select class="form-control @error('tertanda_{{ $ttd }}') is-invalid @enderror" name="tertanda_{{ $ttd }}" required>
                                <option disabled selected>--Tertanda--</option>
                                @foreach ($dosen as $dosens)
                                    <option value="{{ $dosens->id }}" {{ (old("tertanda_1") == $dosens->user_id ? "selected":"") }}>{{ $dosens->nama }}</option>
                                @endforeach
                                @foreach ($mahasiswa as $mahasiswas)
                                    <option value="{{ $mahasiswas->user_id }}" {{ (old("tertanda_1") == $mahasiswas->user_id ? "selected":"") }}>{{ $mahasiswas->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endfor
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Generate Nomor Surat</h1>
                {{-- <a href="" type="button" class="btn-close" data-dismiss="modal" aria-hidden="true"></a> --}}
                <button type="button" class="btn-close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="form-generate">
                    @csrf
                    <div class="form-group">
                        <label style="font-size: 16px">Keperluan Surat</label>
                        <select class="form-control @error('keperluan_id') is-invalid @enderror" name="keperluan_id">
                            <option disabled selected>-- Keperluan Surat--</option>
                            @foreach ($keperluan as $keperluan)
                                <option value="{{ $keperluan->id }}" {{ (old("keperluan_id") == $keperluan->id ? "selected":"") }}>{{ $keperluan->nama }} -- {{ $keperluan->kode }}</option>
                            @endforeach
                        </select>
                        @error('keperluan_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('document').ready(function(){
        $('#form-generate').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ route('generateNomor') }}",
                data : $('#form-generate').serialize(),
                success : function(response){
                    $('#modal').modal('hide');
                    $('#nomorSurat').val(response.nomor);
                    $('#keperluanId').val(response.keperluan_id);
                    console.log(response);
                    $('#form-generate')[0].reset();
                },
                error : function(response){
                    console.log(response);
                }
            });
        });
    });

    function modal(){
        $('#modal').modal('show'); //modal tampil
    }

</script>
@endsection
