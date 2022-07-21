<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>@yield('title')</title>

        <!-- General CSS Files -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        {{-- <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

            {{-- summernote --}}
            <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/modules/codemirror/lib/codemirror.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/modules/codemirror/theme/duotone-dark.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

        <script src="{{ asset('assets/summernote-cleaner.js') }}"></script>

        <!-- Start GA -->
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
                        {{-- <div class="search-element">
                            <div class="search-backdrop"></div>
                            <div class="search-result">
                                <div class="search-header">
                                    Histories
                                </div>
                                <div class="search-item">
                                    <a href="#">How to hack NASA using CSS</a>
                                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                                </div>
                                <div class="search-item">
                                    <a href="#">Kodinger.com</a>
                                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                                </div>
                                <div class="search-item">
                                    <a href="#">#Stisla</a>
                                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                                </div>
                                <div class="search-header">
                                    Result
                                </div>
                                <div class="search-item">
                                    <a href="#"><img class="mr-3 rounded" width="30" src="assets/img/products/product-3-50.png" alt="product">
                                        oPhone S9 Limited Edition
                                    </a>
                                </div>
                                <div class="search-item">
                                    <a href="#"><img class="mr-3 rounded" width="30" src="assets/img/products/product-2-50.png" alt="product">
                                        Drone X2 New Gen-7
                                    </a>
                                </div>
                                <div class="search-item">
                                    <a href="#"><img class="mr-3 rounded" width="30" src="assets/img/products/product-1-50.png" alt="product">
                                        Headphone Blitz
                                    </a>
                                </div>
                                <div class="search-header">
                                    Projects
                                </div>
                                <div class="search-item">
                                    <a href="#">
                                    <div class="search-icon bg-danger text-white mr-3">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    Stisla Admin Template
                                    </a>
                                </div>
                                <div class="search-item">
                                    <a href="#">
                                    <div class="search-icon bg-primary text-white mr-3">
                                        <i class="fas fa-laptop"></i>
                                    </div>
                                    Create a new Homepage Design
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                    </form>
                    <ul class="navbar-nav navbar-right position-absolute top-45 end-0">
                        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
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
                        </li>
                        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, Ujang Maman</div></a>
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
                                <a href="#" class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="main-sidebar sidebar-style-2">
                    <aside id="sidebar-wrapper">
                        <div class="sidebar-brand">
                            <a href="index.html">ITATS</a>
                        </div>
                        <div class="sidebar-brand sidebar-brand-sm">
                            <a href="index.html">ITATS</a>
                        </div>
                        <ul class="sidebar-menu">
                            <li class="menu-header">Dashboard</li>
                            <li class="dropdown">
                                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
                                    <li><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
                                </ul>
                            </li>
                            <li class="menu-header">Master Surat</li>
                            <li class="dropdown {{ ($nav == 'umum') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Umum</span></a>
                                <ul class="dropdown-menu">
                                    <li class="{{ ($menu == 'jenis') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.jenis') }}">Jenis Surat</a></li>
                                    <li class="{{ ($menu == 'template') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.template') }}">Template Surat</a></li>
                                </ul>
                            </li>
                            <li class="dropdown {{ ($nav == 'transaksi') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-mail-bulk"></i> <span>Transaksi Surat</span></a>
                                <ul class="dropdown-menu">
                                    <li class="{{ ($menu == 'masuk') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.surat.masuk') }}"><i class="far fa-envelope"></i>Surat Masuk</a></li>
                                    <li class="{{ ($menu == 'keluar') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.surat.keluar') }}"><i class="far fa-envelope-open"></i>Surat Keluar</a></li>
                                </ul>
                            </li>
                            <li class="dropdown {{ ($nav == 'agenda') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-book"></i> <span>Buku Agenda</span></a>
                                <ul class="dropdown-menu">
                                    <li class="{{ ($menu == 'masuk') ? 'active' : '' }}"><a class="nav-link" href="{{ route('index.agenda.masuk') }}"><i class="far fa-envelope"></i>Surat Masuk</a></li>
                                    {{-- <li class="{{ ($menu == 'keluar') ? 'active' : '' }}"><a class="nav-link" href=""><i class="far fa-envelope-open"></i>Surat Keluar</a></li> --}}
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

                {{-- <div class="footer-left">
                    Copyright &copy; 2021 <div class="bullet"></div> Design By <a href="">EWA</a>
                </div>
                <footer class="main-footer">
                    <div class="footer-right">

                    </div>
                </footer> --}}
            </div>
        </div>

        <!-- General JS Scripts -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script> --}}
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

            {{-- summernote --}}
            <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
            <script src="{{ asset('assets/modules/codemirror/lib/codemirror.js') }}"></script>
            <script src="{{ asset('assets/modules/codemirror/mode/javascript/javascript.js') }}"></script>
            <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>


        <!-- Page Specific JS File -->
        <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
        <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script>
        <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
        <script src="{{ asset('assets/js/page/modules-ion-icons.js') }}"></script>

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

        {{-- Confirm delete --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script type="text/javascript">
            $('.show_confirm').click(function(event) {
                var form =  $(this).closest("form");
                var name = $(this).data("name");
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
        </script>

        {{-- textarea --}}
        <script>
            document.getElementById('submit').onclick = function() {
                document.getElementById('isi').innerHTML = 'It was a dark and stormy night…';
            };
        </script>
    </body>
</html>
