<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>@yield('title')</title>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
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

        {{-- Summernote --}}
        {{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"> --}}
        <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">


        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

        <!-- Start GA -->
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
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
                            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                        </ul>
                    </form>
                    <ul class="navbar-nav navbar-right position-absolute top-45 end-0">
                        {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                <div class="dropdown-header">Messages
                                    <div class="float-right">
                                        <a href="#">Mark All As Read</a>
                                    </div>
                                </div>
                                <div class="dropdown-list-content dropdown-list-message">
                                    <a href="#" class="dropdown-item dropdown-item-unread">
                                        <div class="dropdown-item-avatar">
                                            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle">
                                            <div class="is-online"></div>
                                        </div>
                                        <div class="dropdown-item-desc">
                                            <b>Kusnaedi</b>
                                            <p>Hello, Bro!</p>
                                            <div class="time">10 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item dropdown-item-unread">
                                        <div class="dropdown-item-avatar">
                                            <img alt="image" src="assets/img/avatar/avatar-2.png" class="rounded-circle">
                                        </div>
                                        <div class="dropdown-item-desc">
                                            <b>Dedik Sugiharto</b>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                                            <div class="time">12 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item dropdown-item-unread">
                                        <div class="dropdown-item-avatar">
                                            <img alt="image" src="assets/img/avatar/avatar-3.png" class="rounded-circle">
                                            <div class="is-online"></div>
                                        </div>
                                        <div class="dropdown-item-desc">
                                            <b>Agung Ardiansyah</b>
                                            <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            <div class="time">12 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <div class="dropdown-item-avatar">
                                            <img alt="image" src="assets/img/avatar/avatar-4.png" class="rounded-circle">
                                        </div>
                                        <div class="dropdown-item-desc">
                                            <b>Ardian Rahardiansyah</b>
                                            <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                                            <div class="time">16 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <div class="dropdown-item-avatar">
                                            <img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle">
                                        </div>
                                        <div class="dropdown-item-desc">
                                            <b>Alfa Zulkarnain</b>
                                            <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                                            <div class="time">Yesterday</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-footer text-center">
                                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                <div class="dropdown-header">Notifications
                                    <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                    </div>
                                </div>
                                <div class="dropdown-list-content dropdown-list-icons">
                                    <a href="#" class="dropdown-item dropdown-item-unread">
                                        <div class="dropdown-item-icon bg-primary text-white">
                                            <i class="fas fa-code"></i>
                                        </div>
                                        <div class="dropdown-item-desc">
                                            Template update is available now!
                                            <div class="time text-primary">2 Min Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <div class="dropdown-item-icon bg-info text-white">
                                            <i class="far fa-user"></i>
                                        </div>
                                        <div class="dropdown-item-desc">
                                            <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                                            <div class="time">10 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <div class="dropdown-item-icon bg-success text-white">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="dropdown-item-desc">
                                            <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                                            <div class="time">12 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <div class="dropdown-item-icon bg-danger text-white">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="dropdown-item-desc">
                                            Low disk space. Let's clean it!
                                            <div class="time">17 Hours Ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <div class="dropdown-item-icon bg-info text-white">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                        <div class="dropdown-item-desc">
                                            Welcome to Stisla template!
                                            <div class="time">Yesterday</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-footer text-center">
                                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </li> --}}
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
                            <li class="dropdown {{ ($nav == 'dashboard') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                                <ul class="dropdown-menu">
                                    <li class="{{ ($menu == 'dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dashboard') }}">General Dashboard</a></li>
                                </ul>
                            </li>
                            <li class="menu-header">Master Surat</li>
                            <li class="dropdown {{ ($nav == 'umum') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Umum</span></a>
                                <ul class="dropdown-menu">
                                    <li class="{{ ($menu == 'jenis') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.jenis') }}"><i class="far fa-folder-open"></i> Jenis Surat</a></li>
                                    <li class="{{ ($menu == 'keperluan') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.keperluan') }}"><i class="far fa-folder-open"></i> Keperluan Surat</a></li>
                                    <li class="{{ ($menu == 'template') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.template') }}"><i class="far fa-folder-open"></i> Template Surat</a></li>
                                </ul>
                            </li>
                            <li class="dropdown {{ ($nav == 'transaksi') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-mail-bulk"></i> <span>Transaksi Surat</span></a>
                                <ul class="dropdown-menu">
                                    <li class="{{ ($menu == 'masuk') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.surat.masuk') }}"><i class="far fa-envelope"></i>Surat Masuk</a></li>
                                    <li class="{{ ($menu == 'keluar') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.surat.keluar') }}"><i class="far fa-envelope-open"></i>Surat Keluar</a></li>
                                    <li class="{{ ($menu == 'search') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.search') }}"><i class="fas fa-search"></i>Pencarian Surat</a></li>
                                </ul>
                            </li>
                            <li class="dropdown {{ ($nav == 'agenda') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-book"></i> <span>Buku Agenda</span></a>
                                <ul class="dropdown-menu">
                                    <li class="{{ ($menu == 'masuk') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.agenda.masuk') }}"><i class="far fa-envelope"></i>Surat Masuk</a></li>
                                    <li class="{{ ($menu == 'keluar') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.agenda.keluar') }}"><i class="far fa-envelope-open"></i>Surat Keluar</a></li>
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
        <script src="{{ asset('assets/modules/cleave-js/dist/cleave.min.js') }}"></script>
        <script src="{{ asset('assets/modules/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
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
        <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>

        <!-- Page Specific JS File -->
        <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script>
        <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
        <script src="{{ asset('assets/js/page/modules-ion-icons.js') }}"></script>
        <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>

        {{-- Summernote --}}
        <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
        <script>
            $('#summernote').summernote({
                height: 500,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['para', ['paragraph']],
                    ['height', ['height']],
                    // ['table', ['table']]
                ],
            });
            $('#summernote').summernote('fontName', 'Times New Roman');

            $('#summernote2').summernote({
                height: 200,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['para', ['paragraph']],
                ],
            });
            $('#summernote2').summernote('fontName', 'Times New Roman');
        </script>

        <!-- Template JS File -->
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>

        {{-- Toastr --}}
        @include('sweetalert::alert')

        {{-- Checkbox tabel --}}
        <script>
            $(function(){
                $("#checkAll").click(function(){
                    $(".checkboxClass").prop('checked',$(this).prop('checked'));
                });
            });
        </script>

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

            // confirm read surat masuk
            $('.show_read').click(function(event) {
                let form =  $(this).closest("form");
                let name = $(this).data("name");
                event.preventDefault();
                swal({
                    title: 'Apakah anda yakin sudah melihat surat, dan memberi tanggapan hanya membaca !! ',
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

            // confirm continue surat masuk
            $('.show_continue').click(function(event) {
                let form =  $(this).closest("form");
                let name = $(this).data("name");
                event.preventDefault();
                swal({
                    title: 'Apakah anda yakin sudah melihat surat, dan memberi tanggapan lanjutkan proses lanjutnya !! ',
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

            // confirm TTD surat Keluar
            $('.show_ttd').click(function(event) {
                let form =  $(this).closest("form");
                let name = $(this).data("name");
                event.preventDefault();
                swal({
                    title: 'Apakah anda yakin sudah memeriksa surat, dan memberi tanda tangan pada surat !! ',
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
        </script>
    </body>
</html>
