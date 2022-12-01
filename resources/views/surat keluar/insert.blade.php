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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Generate Nomor</button>
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
                    <div class="form-group col-sm-11">
                        <label style="font-size: 16px">Isi Content Surat</label>
                        <textarea class="summernote" name="isi_body" id="summernote" cols="30" rows="10" required>{{ $template->isi_body }}</textarea>
                        @error('isiBody')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-1" style="margin-top: 10px">
                        <a data-toggle="tooltip" title="Langkah Penulisan Content :
                                                        1. Untuk nomor surat di inputkan variable ${nomor_surat}.
                                                        2. Jika muncul peringatan terjadi kesalahan menulis maka edit ulang isi content, karena ada beberapa tag html yang tidak terbaca oleh PHPWORD." >
                        <i class="fas fa-exclamation-circle"></i><b> info</b></a>
                    </div>
                </div>
                @if ($template->isi_footer != null)
                <div class="row">
                    <div class="form-group col-sm-11">
                        <label style="font-size: 16px">Isi Footer Template</label>
                        <textarea class="summernote2" name="isi_footer" id="summernote2" cols="30" rows="10" required>{{ $template->isi_footer }}</textarea>
                    </div>
                    <div class="form-group col-sm-1" style="margin-top: 10px">
                        <a data-toggle="tooltip" title="Footer adalah paragraf yang terletak di bawah tandatangan, jika tidak ada footer maka kosongi
                                                        Langkah Penulisan footer:
                                                        1. Penulisan seperti paragraf biasa.
                                                        2. Jika muncul peringatan terjadi kesalahan menulis maka edit ulang isi content, karena ada beberapa tag html yang tidak terbaca oleh PHPWORD." >
                        <i class="fas fa-exclamation-circle"></i><b> info</b></a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-body">
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
                <h5 class="modal-title" id="exampleModalLabel">Generate Nomor Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-generate">
                    @csrf
                    <div class="form-group">
                        <label style="font-size: 16px">Format Nomor Surat</label>
                        <select class="form-control" name="format" id="format">
                            <option disabled selected>-- Format Nomor Surat--</option>
                            @foreach ($format as $format)
                                <option value="{{ $format->id }}" {{ (old("format_id") == $format->id ? "selected":"") }}>{{ $format->nama }}</option>
                            @endforeach
                            {{-- <option value="1">FTETI</option> --}}
                            {{-- <option value="2">Jurusan Informatika</option> --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 16px">Keperluan Surat</label>
                        <select class="form-control keperluan" name="keperluan_id" id="keperluan">
                            {{-- <option disabled selected>-- Keperluan Surat --</option> --}}
                            {{-- @foreach ($keperluan as $keperluan)
                                <option value="{{ $keperluan->id }}" {{ (old("keperluan_id") == $keperluan->id ? "selected":"") }}>{{ $keperluan->nama }} -- {{ $keperluan->kode }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group" id="huruf">
                        <label style="font-size: 16px">Kode Huruf</label>
                        <input type="text" class="form-control huruf" name="huruf">
                    </div>
            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('document').ready(function(){
        //format nomor
        // $('.huruf').attr("required", false);
        $('#huruf').hide();
        $('#format').change(function() {
            $('#huruf').hide();
            $('.huruf').removeAttr('required');
            let format_id = $(this).val();
            // console.log(format_id)
            if(format_id == 1){
                $('#huruf').show();
                $('.huruf').attr("required", true);
            }
        });

        //generate nomor
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

        $('#format').change(function(){
            let formatID = $(this).val();
            if(formatID){
                $.ajax({
                    type:"GET",
                    url:"{{ route('getKeperluan') }}",
                    data: {'id': formatID},
                    dataType: 'JSON',
                    success:function(response){
                        console.log(response);
                        if(response){
                            $("#keperluan").empty();
                            $("#keperluan").append('<option>---Pilih keperluan surat---</option>');
                            $.each(response.keperluan,function(key, value){
                                $("#keperluan").append('<option value="'+value.id+'">'+value.nama+' -- '+value.kode+'</option>');
                            });
                        }else{
                            $("#keperluan").empty();
                        }
                    }
                });
            }else{
                $("#keperluan").empty();
            }
        });
    });
</script>
@endsection
