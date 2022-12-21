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
                <ul class="nav nav-pills" id="myTab3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">Data Surat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">Data Disposisi Surat</a>
                    </li>
                </ul>
                <div class="tab-content mt-4" id="myTabContent2">
                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
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
                                <label style="font-size: 16px">Keperluan Surat</label>
                                <input type="text" class="form-control @error('keperluan') is-invalid @enderror" name="keperluan" value="{{ old('keperluan') }}">
                                @error('keperluan')
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
                                <label style="font-size: 16px">Catatan Surat</label>
                                <input type="text" class="form-control @error('catatan_surat') is-invalid @enderror" name="catatan_surat" value="{{ old('catatan_surat') }}">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Masukkan catatan jika ada perlu !!
                                </small>
                                @error('catatan_surat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomorSurat" name="nomor_surat" value="{{ old('nomor_surat') }}" required>
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
                            </div>
                        </div>
                        {{-- hidden input --}}
                        <input type="hidden" name="template_id" value="{{ $template->id }}">
                        <input type="hidden" name="kode_id" id="kodeId">
                        <div class="modal-footer">
                            <a href="#" class="nav-link btn btn-primary" id="next">Next >></a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Perihal Disposisi</label>
                                <input type="text" class="form-control @error('perihal') is-invalid @enderror" name="perihal" placeholder="" value="{{ old('perihal') }}">
                                @error('perihal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Tanggal Disposisi</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
                                @error('tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Isi Disposisi</label>
                                <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" cols="30" rows="10">{{ old('isi') }}</textarea>
                                @error('isi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-size: 16px">Catatan Disposisi</label>
                                <textarea name="catatan_disposisi" class="form-control @error('catatan_disposisi') is-invalid @enderror" cols="30" rows="10">{{ old('catatan_disposisi') }}</textarea>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Masukkan catatan jika ada perlu !!
                                </small>
                                @error('catatan_disposisi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="sort-handler ui-sortable-handle text-center">
                                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th>Nama </th>
                                            <th>Username</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user_dosen as $us_dos)
                                            @if ($us_dos->user_id === Auth::user()->id)
                                                @continue
                                            @else
                                                <tr>
                                                    <td>
                                                        <div class="sort-handler ui-sortable-handle text-center">
                                                            <input class="form-check-input checkboxClass" type="checkbox" id="inlineCheckbox1" name="disposisi[]" value={{ $us_dos->id }}>
                                                            <label class="form-check-label" for="inlineCheckbox1"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $us_dos->nama }}</td>
                                                    <td>{{ $us_dos->username }}</td>
                                                    <td>{{ $us_dos->email }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @foreach ($user_mahasiswa as $us_maha)
                                            @if ($us_maha->user_id == Auth::user()->id)
                                                @continue
                                            @else
                                                <tr>
                                                    <td>
                                                        <div class="sort-handler ui-sortable-handle text-center">
                                                            <input class="form-check-input checkboxClass" type="checkbox" id="inlineCheckbox1" name="disposisi[]" value={{ $us_maha->id }}>
                                                            <label class="form-check-label" for="inlineCheckbox1"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $us_maha->nama }}</td>
                                                    <td>{{ $us_maha->username }}</td>
                                                    <td>{{ $us_maha->email }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="nav-link btn btn-primary" id="back"><< Back</a>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </div>
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
                    {{-- <div class="form-group">
                        <label style="font-size: 16px">Format Nomor Surat</label>
                        <select class="form-control" name="format" id="format">
                            <option disabled selected>-- Format Nomor Surat--</option>
                            @foreach ($format as $format)
                                <option value="{{ $format->id }}" {{ (old("format_id") == $format->id ? "selected":"") }}>{{ $format->nama }}</option>
                            @endforeach
                            <option value="1">FTETI</option>
                            <option value="2">Jurusan Informatika</option>
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label style="font-size: 16px" class="form-label">Role Data Surat</label>
                        <select class="form-control" name="role_id" id="role">
                            <option disabled selected>-- Role Data--</option>
                            @if ($user->isAdmin())
                                @foreach ($role as $role)
                                    <option value="{{ $role->id }}" {{ (old("role_id") == $role->id ? "selected":"") }}>{{ $role->nama }}</option>
                                @endforeach
                            @else
                                @for ($i = 0; $i < count($getRole); $i++)
                                        <option value="{{ $getRole[$i][0] }}" {{ (old("role_id") == $getRole[$i][0] ? "selected":"") }}>{{ $getRole[$i][1] }}</option>
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
                        <label style="font-size: 16px">Kode Surat</label>
                        <select class="form-control kode" name="kode_id" id="kode">
                        </select>
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
        // //format nomor
        // // $('.huruf').attr("required", false);
        // $('#huruf').hide();
        // $('#format').change(function() {
        //     $('#huruf').hide();
        //     $('.huruf').removeAttr('required');
        //     let format_id = $(this).val();
        //     // console.log(format_id)
        //     if(format_id == 1){
        //         $('#huruf').show();
        //         $('.huruf').attr("required", true);
        //     }
        // });

        //generate nomor
        $('#form-generate').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type : "POST",
                url : "{{ route('generateNomor') }}",
                data : $('#form-generate').serialize(),
                success : function(response){
                    // console.log('kode' response.kode_id);
                    $('#modal').modal('hide');
                    // $('#nomorSurat').reset();
                    $('#nomorSurat').val(response.nomor);
                    $('#kodeId').val(response.kode_id);
                    console.log(response);
                    $('#form-generate')[0].reset();
                },
                error : function(response){
                    console.log(response);
                }
            });
        });

        $('#role').change(function(){
            let role_id = $(this).val();
            if(role_id){
                $.ajax({
                    type:"GET",
                    url:"{{ route('getKode') }}",
                    data: {'id': role_id},
                    dataType: 'JSON',
                    success:function(response){
                        console.log(response);
                        if(response){
                            $("#kode").empty();
                            $("#kode").append('<option>---Pilih Kode surat---</option>');
                            $.each(response.kode,function(key, value){
                                $("#kode").append('<option value="'+value.id+'">'+value.nama+' -- '+value.kode+'</option>');
                            });
                        }else{
                            $("#kode").empty();
                        }
                    }
                });
            }else{
                $("#kode").empty();
            }
        });
        $('#next').click(function(){
            $('#home-tab3').removeClass("active");
            $('#home3').removeClass("active");
            $('#profile-tab3').addClass("active");
            $('#profile3').addClass("show active");
        });
        $('#back').click(function(){
            $('#profile-tab3').removeClass("active");
            $('#profile3').removeClass("show active");
            $('#home-tab3').addClass("active");
            $('#home3').addClass("show active");
        });
    });
</script>
@endsection
