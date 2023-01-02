<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>@yield('title')</title>

        <!-- General CSS Files -->
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"> --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/ionicons/css/ionicons.min.css') }}">

        {{-- Summernote --}}
        <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">


        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

        <!-- Start GA -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script async src="{{ asset('https://www.googletagmanager.com/gtag/js?id=UA-94034622-3') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-94034622-3');
        </script>
    </head>

    <body>
        <div id="app">
            <div class="main-wrapper main-wrapper-1" >
                <div class="navbar-bg"></div>
                <nav class="navbar navbar-expand-lg main-navbar" >
                    <form class="form-inline mr-auto">
                        <ul class="navbar-nav mr-3">
                            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        </ul>
                    </form>
                    <ul class="navbar-nav navbar-right">
                        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            @foreach (Auth::user()->mahasiswa as $user_mahasiswa)
                                <div class="d-sm-none d-lg-inline-block">{{ $user_mahasiswa->nama }}</div></a>
                            @endforeach
                            @foreach (Auth::user()->dosen as $user_dosen)
                                <div class="d-sm-none d-lg-inline-block">{{ $user_dosen->nama }}</div></a>
                            @endforeach
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-title">Logged in 5 min ago</div>
                                <a href="features-profile.html" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i> Profile
                                </a>
                                <a href="features-activities.html" class="dropdown-item has-icon">
                                    <i class="fas fa-bolt"></i> Activities
                                </a>
                                <a href="features-settings.html" class="dropdown-item has-icon">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout.login') }}" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="main-sidebar sidebar-style-2">
                    <aside id="sidebar-wrapper">
                        <div class="sidebar-brand">
                            <a href="{{ route('dashboard') }}">ITATS</a>
                        </div>
                        <div class="sidebar-brand sidebar-brand-sm">
                            <a href="{{ route('dashboard') }}">ITATS</a>
                        </div>
                        <ul class="sidebar-menu">
                            <li class="menu-header">Dashboard</li>
                            <li class="{{ ($menu == 'dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-chart-bar"></i> <span>Dashboard</span></a></li>
                            <li class="menu-header">Master Surat</li>
                            @if (Auth::user()->isAdmin())
                                <li class="dropdown {{ ($nav == 'master') ? 'active' : '' }}">
                                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user"></i> <span>Admin Master</span></a>
                                    <ul class="dropdown-menu">
                                        <li class="{{ ($menu == 'surat') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.masterSurat') }}"><i class="far fa-envelope"></i>Master Surat</a></li>
                                        <li class="{{ ($menu == 'response') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.masterResponse') }}"><i class="far fa-thumbs-up"></i>Master Response</a></li>
                                        <li class="{{ ($menu == 'roleDosen') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.masterRoleDosen') }}"><i class="fas fa-users"></i>Master Role</a></li>
                                    </ul>
                                </li>
                            @endif
                            <li class="dropdown {{ ($nav == 'umum') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Umum</span></a>
                                <ul class="dropdown-menu">
                                    <li class="{{ ($menu == 'jenis') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.jenis') }}"><i class="far fa-folder-open"></i>Jenis Surat</a></li>
                                    <li class="{{ ($menu == 'kode') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.kode') }}"><i class="far fa-folder-open"></i>Kode Surat</a></li>
                                    <li class="{{ ($menu == 'template') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.template') }}"><i class="far fa-folder-open"></i>Template Surat</a></li>
                                </ul>
                            </li>
                            <li class="dropdown active">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-mail-bulk"></i> <span>Transaksi Surat</span></a>
                                <ul class="dropdown-menu">
                                    @if (Auth::user()->isAdmin() || Auth::user()->isPengelola())
                                        <li class="{{ ($menu == 'buat') ? 'active' : '' }}"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#surat"><i class="far fa-paper-plane"></i>Buat Surat</a></li>
                                    @endif
                                    <li class="{{ ($menu == 'masuk') ? 'active' : '' }} "><a class="nav-link" href="{{ route('index.surat.masuk') }}" id="read_masuk"><i class="far fa-envelope"></i>Surat Masuk</a></li>
                                    <li class="{{ ($menu == 'keluar') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.surat.keluar') }}" id="read_keluar"><i class="far fa-envelope-open"></i>Surat Keluar</a></li>
                                    <li class="{{ ($menu == 'search') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.search') }}"><i class="fas fa-search"></i>Pencarian Surat</a></li>
                                    <li class="{{ ($menu == 'file') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.file') }}"><i class="fas fa-file"></i>File Surat</a></li>
                                </ul>
                            </li>
                            <li class="dropdown {{ ($nav == 'agenda') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-book"></i> <span>Buku Agenda</span></a>
                                <ul class="dropdown-menu">
                                    <li class="{{ ($menu == 'masuk_catatan') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.agenda.masuk') }}"><i class="far fa-envelope"></i>Surat Masuk</a></li>
                                    <li class="{{ ($menu == 'keluar_catatan') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.agenda.keluar') }}"><i class="far fa-envelope-open"></i>Surat Keluar</a></li>
                                </ul>
                            </li>
                        </ul>
                    </aside>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <section class="section">
                        @yield('section')
                        {{-- <div class="section-header">
                            <h1>@yield('header')</h1>
                        </div>

                        <div class="section-body mb-1">
                        </div> --}}
                    </section>
                </div>
                @yield('modal')
                <div class="modal fade" id="surat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Menu Surat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Silahkan memilih menu buat surat :
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-primary" href="{{ route('create.keluar.instant') }}">Tanpa Template</a>
                                <a class="btn btn-primary" href="{{ route('index.keluar.template') }}">Menggunakan Template</a>
                                {{-- <button type="submit" class="btn btn-primary">Menggunakan Template</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="footer-left">
                    Copyright &copy; 2021 <div class="bullet"></div> Design By <a href="">EWA</a>
                </div>
                <footer class="main-footer">
                    <div class="footer-right">

                    </div>
                </footer> --}}
            </div>
        </div>
        @yield('script')

        <!-- General JS Scripts -->
        <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/modules/popper.js') }}"></script>
        <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
        <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
        <script src="{{ asset('assets/js/stisla.js') }}"></script>

        <!-- JS Libraies -->
        <script src="{{ asset('assets/modules/prism/prism.js') }}"></script>
        <script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
        <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
        <script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
        <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>

        <!-- Page Specific JS File -->
        <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
        <script src="{{ asset('assets/js/page/modules-ion-icons.js') }}"></script>
        <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>

        {{-- Summernote --}}
        <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
        <script>
            $(document).ready(function(){

            });
            $('#summernote').summernote({
                height: 500,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    // ['fontsize', ['fontsize']],
                    ['para', ['paragraph']],
                    ['height', ['height']],
                    // ['table', ['table']]
                ],
            });
            // $('#summernote').summernote('fontName', 'Times New Roman');

            $('#summernote2').summernote({
                height: 200,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    // ['fontsize', ['fontsize']],
                    ['para', ['paragraph']],
                    ['height', ['height']],
                ],
            });
            // $('#summernote2').summernote('fontName', 'Times New Roman');
        </script>

        <!-- Template JS File -->
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>

        {{-- Toastr --}}
        @include('sweetalert::alert')

        {{-- Confirm modal--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script type="text/javascript">
            // Confirm delete
            $('.show_confirm').click(function(event) {
                let form =  $(this).closest("form");
                let name = $(this).data("name");
                event.preventDefault();
                swal({
                    title: 'Apakah anda yakin akan menghapus data ini !! ',
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                    form.submit();
                    }
                });
            });

            // confirm response
            $('.show_response').click(function(event) {
                let form =  $(this).closest("form");
                let name = $(this).data("name");
                let bla = $('#response').val();
                event.preventDefault();
                swal({
                    title: 'Apakah anda yakin sudah melihat surat, dan memberi tanggapan '+bla+' !! ',
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                    form.submit();
                    }
                });
            });

            $(document).ready(function(){
                $.ajax({
                    type:"GET",
                    url:"{{ route('getReadAtKeluar') }}",
                    data: {},
                    dataType: 'JSON',
                    success:function(response){
                        console.log(response);
                        if(response){
                            $('#read_keluar').removeClass("beep beep-sidebar");
                        }else{
                            console.log('belum baca');
                            $('#read_keluar').addClass("beep beep-sidebar");
                        }
                    }
                });

                $.ajax({
                    type:"GET",
                    url:"{{ route('getReadAtMasuk') }}",
                    data: {},
                    dataType: 'JSON',
                    success:function(response){
                        console.log(response);
                        if(response){
                            $('#read_masuk').removeClass("beep beep-sidebar");
                        }else{
                            console.log('belum baca');
                            $('#read_masuk').addClass("beep beep-sidebar");
                        }
                    }
                });
            });
        </script>
    </body>
</html>
