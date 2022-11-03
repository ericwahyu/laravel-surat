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
            <div class="form-group col-md-4">
                <input type="text" class="form-control " name="search" id="search" placeholder="Search">
            </div>
        </div>
    <div class="row">
        <h2 class="section-title">Surat Masuk</h2>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <tr>
                            <th>Nomor Surat</th>
                            <th>Judul Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Action</th>
                        </tr>
                        <tbody id="dataSuratMasuk"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h2 class="section-title">Surat Keluar</h2>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <tr>
                            <th>Nomor Surat</th>
                            <th>Judul Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Action</th>
                        </tr>
                        {{-- <tbody id="dataSuratMasuk"></tbody> --}}
                    </table>
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
                    let suratmasuk = '';
                    for(let i = 0; i < data.suratMasuk.length; i++){
                        suratmasuk += `
                            <tr>
                                <td>`+data.suratMasuk[i].nosurat+`</td>
                                <td>`+data.suratMasuk[i].judul+`</td>
                                <td>`+data.suratMasuk[i].tanggal+`</td>
                            </tr>`;
                    }

                    $('#dataSuratMasuk').html(suratmasuk);
                    console.log(data.suratMasuk);
                }
            });
        };
    });
    $(document).on('keyup', '#search', function(){
        var query = $(this).val();
            fetch_customer_data(query);
    });

</script>
@endsection


