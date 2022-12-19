@extends('layout')
@section('title','File Surat')
@section('section')
<div class="section-header">
    <h1>File Surat</h1>
    <div class="section-header-button">
    </div>
</div>
<div class="section-body">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    {{-- <div class="form-group col-md-6">
                        <input type="text" class="form-control " name="search" id="search" placeholder="Search...">
                    </div> --}}
                    <div class="form-group">
                        <ul class="nav nav-pills" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab1" data-toggle="tab" href="#SM" role="tab" aria-controls="home" aria-selected="true">Surat Masuk <span class="badge badge-primary SM" ></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab2" data-toggle="tab" href="#SK" role="tab" aria-controls="profile" aria-selected="false">Surat Keluar <span class="badge badge-primary SK" ></span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent2">
                        <div class="tab-pane fade show active" id="SM" role="tabpanel" aria-labelledby="tab1">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <select class="form-control @error('') is-invalid @enderror" name="" id="jenissm">
                                        <option selected disabled>-- Pilih jenis surat --</option>
                                        @foreach ($jenissm as $jenissm)
                                            <option value="{{ $jenissm->id }}">{{ $jenissm->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h2 class="section-title">Surat Masuk</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tr>
                                        <th>Jenis Surat</th>
                                        <th>Nomor Surat</th>
                                        <th>Judul Surat</th>
                                        <th>Tanggal Surat</th>
                                        <th>File Surat</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody id="dataSuratMasuk"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="SK" role="tabpanel" aria-labelledby="tab2">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <select class="form-control @error('') is-invalid @enderror" name="" id="jenissk">
                                        <option selected disabled>-- Pilih jenis surat --</option>
                                        @foreach ($jenissk as $jenissk)
                                            <option value="{{ $jenissk->id }}">{{ $jenissk->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="form-group col-md-3">
                                    <select class="form-control @error('') is-invalid @enderror" name="" id="keperluan">
                                        <option selected disabled>-- Pilih kelompok surat --</option>
                                        @foreach ($keperluan as $keperluan)
                                            <option value="{{ $keperluan->id }}">{{ $keperluan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 mt-1">
                                    <button type="button" class="btn btn-primary" id="filter">Filter</button>
                                </div> --}}
                            </div>
                            <h2 class="section-title">Surat Keluar</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tr>
                                        <th>Jenis Surat</th>
                                        <th>Nomor Surat</th>
                                        <th>Judul Surat</th>
                                        <th>Tanggal Surat</th>
                                        <th>File Surat</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody id="dataSuratKeluar"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="card">
            <div class="card-body">

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#jenissm').change(function(){
            let jenis_id = $(this).val();
            console.log(jenis_id);
            if(jenis_id){
                $.ajax({
                    url: "{{ route('filter.file') }}",
                    method: 'GET',
                    data: {'jenis_id': jenis_id},
                    dataType: 'JSON',
                    success: function(data) {
                        // console.log(data);
                        $('#dataSuratMasuk').html(data.table_data_suratMasuk);
                        // $('#dataSuratKeluar').html(data.table_data_suratKeluar);
                        $('.SM').html(data.data_suratMasuk);
                        // $('.SK').html(data.data_suratKeluar);
                    }
                });
            }else{
                $('#dataSuratMasuk').empty();
            }
        });
        $('#jenissk').change(function(){
            let jenis_id = $('#jenissk').val();
            // let keperluan_id = $('#keperluan').val();
            console.log(jenis_id);
            $.ajax({
                url: "{{ route('filter.file') }}",
                method: 'GET',
                data: {'jenis_id': jenis_id},
                dataType: 'JSON',
                success: function(data) {
                    // console.log(data);
                    // $('#dataSuratMasuk').html(data.table_data_suratMasuk);
                    $('#dataSuratKeluar').html(data.table_data_suratKeluar);
                    // $('.SM').html(data.data_suratMasuk);
                    $('.SK').html(data.data_suratKeluar);
                }
            });
        });

    });

</script>
@endsection


