@extends('layout')
@section('title','Search Surat')
@section('section')
<div class="section-header">
    <h1>Search Surat</h1>
    <div class="section-header-button">
    </div>
</div>
<div class="section-body">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control " name="search" id="search" placeholder="Search...">
                    </div>
                    <div class="form-group">
                        <ul class="nav nav-pills" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab1" data-toggle="tab" href="#SM" role="tab" aria-controls="home" aria-selected="true">Surat Masuk <span class="badge badge-primary SM" ></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab2" data-toggle="tab" href="#SK" role="tab" aria-controls="profile" aria-selected="false">Surat Keluar <span class="badge badge-primary SK" ></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab3" data-toggle="tab" href="#DSM" role="tab" aria-controls="contact" aria-selected="false">Disposisi Surat Masuk <span class="badge badge-primary DSM" ></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab4" data-toggle="tab" href="#DSK" role="tab" aria-controls="contact" aria-selected="false">Disposisi Surat Keluar <span class="badge badge-primary DSK" ></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="myTabContent2">
                    <div class="tab-pane fade show active" id="SM" role="tabpanel" aria-labelledby="tab1">
                        <h2 class="section-title">Surat Masuk</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                    <th>Jenis Surat</th>
                                    <th>Nomor Surat</th>
                                    <th>Judul Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Keperluan Surat</th>
                                    <th>Action</th>
                                </tr>
                                <tbody id="dataSuratMasuk"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="SK" role="tabpanel" aria-labelledby="tab2">
                        <h2 class="section-title">Surat Keluar</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                    <th>Jenis Surat</th>
                                    <th>Nomor Surat</th>
                                    <th>Judul Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Keperluan Surat</th>
                                    <th>Action</th>
                                </tr>
                                <tbody id="dataSuratKeluar"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="DSM" role="tabpanel" aria-labelledby="tab3">
                        <h2 class="section-title">Disposisi Surat Masuk</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                    <th>Nomor Surat</th>
                                    <th>Judul Surat</th>
                                    <th>Perihal Disposisi</th>
                                    <th>Tanggal Disposisi</th>
                                    <th>Isi Disposisi</th>
                                    <th>Action</th>
                                </tr>
                                <tbody id="dataDisposisiSuratMasuk"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="DSK" role="tabpanel" aria-labelledby="tab4">
                        <h2 class="section-title">Disposisi Surat Keluar</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                    <th>Nomor Surat</th>
                                    <th>Judul Surat</th>
                                    <th>Perihal Disposisi</th>
                                    <th>Tanggal Disposisi</th>
                                    <th>Isi Disposisi</th>
                                    <th>Action</th>
                                </tr>
                                <tbody id="dataDisposisiSuratKeluar"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        fetch_customer_data();
        function fetch_customer_data(query=''){
            $.ajax({
                url:"{{ route('search.data') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data){
                    $('#dataSuratMasuk').html(data.table_data_suratMasuk);
                    $('#dataSuratKeluar').html(data.table_data_suratKeluar);
                    $('#dataDisposisiSuratMasuk').html(data.table_data_disposisiMasuk);
                    $('#dataDisposisiSuratKeluar').html(data.table_data_disposisiKeluar);
                    $('.SM').html(data.data_suratMasuk);
                    $('.SK').html(data.data_suratKeluar);
                    $('.DSM').html(data.data_disposisiSuratMasuk);
                    $('.DSK').html(data.data_disposisiSuratKeluar);
                }
            });
        };
    });
    $(document).on('keyup', '#search', function(){
        $query = $(this).val().toLowerCase();
        $.ajax({
            url: "{{ route('search.data') }}",
            method: 'GET',
            data: {
                'query': $query
            },
            dataType: 'json',
            success: function(data) {
                $('#dataSuratMasuk').html(data.table_data_suratMasuk);
                $('#dataSuratKeluar').html(data.table_data_suratKeluar);
                $('#dataDisposisiSuratMasuk').html(data.table_data_disposisiMasuk);
                $('#dataDisposisiSuratKeluar').html(data.table_data_disposisiKeluar);
                $('.SM').html(data.data_suratMasuk);
                $('.SK').html(data.data_suratKeluar);
                $('.DSM').html(data.data_disposisiSuratMasuk);
                $('.DSK').html(data.data_disposisiSuratKeluar);
            }
        });
    });

</script>
@endsection


