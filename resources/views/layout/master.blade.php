<?php
    $_site_name = settings("site_name");
    $_site_logo = \Illuminate\Support\Facades\Storage::disk('upload')->url(settings("logo"));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', "MASTER PAGE")</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="{{url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{url('plugins/jqvmap/jqvmap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker.css')}}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

        <link rel="icon" type="image/png" href="{{$_site_logo}}"/>
        <!-- Please Wait -->
        <link rel="stylesheet" href="{{url('css/please_wait/please-wait.css')}}">
        <!-- SpinKit -->
        <link rel="stylesheet" href="{{url('css/spin_kit/spinkit.min.css')}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{url('plugins/toastr/toastr.min.css')}}">
        <!-- DatePicker -->
        <link rel="stylesheet" href="{{url('css/bootstrap-datepicker/bootstrap-datepicker3.min.css')}}">

        <style>
            /* pleaseWait için ortalama */
            .sk-spinner{
                width: 40px;
                height: 40px;
                margin-left:auto;
                margin-right: auto;
            }
        </style>

        @yield('css')
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">

        <div class="wrapper">

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/" class="nav-link">Ana Sayfa</a>
                    </li>
                </ul>

                <!-- SEARCH FORM -->
                <!--form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form-->

            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="/" class="brand-link">
                    <img src="{{$_site_logo}}" alt="{{$_site_name}}" class="brand-image img-circle elevation-3"
                         style="opacity: .8">
                    <span class="brand-text font-weight-light">{{$_site_name}}</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <!--div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">Alexander Pierce</a>
                        </div>
                    </div-->

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                 with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <a href="/" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>
                                        Ana Sayfa
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-search"></i>
                                    <p>
                                        Takipler
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('admin.tracking.traffic_accident')}}" class="nav-link">
                                            <i class="fas fa-car-crash nav-icon"></i>
                                            <p>Trafik Kazası</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{route('admin.tracking.work_accident')}}" class="nav-link">
                                            <i class="fas fa-user-injured nav-icon"></i>
                                            <p>İş Kazası</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{route('admin.tracking.tow')}}" class="nav-link">
                                            <i class="fas fa-truck-pickup nav-icon"></i>
                                            <p>Çekici</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-eye"></i>
                                    <p>
                                        İnceleme Durumu
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('admin.tracking.getApproved')}}" class="nav-link">
                                            <i class="fas fa-check-circle nav-icon"></i>
                                            <p>Onaylanan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.tracking.getCancel')}}" class="nav-link">
                                            <i class="fas fa-ban nav-icon"></i>
                                            <p>İptal</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin.lawTracking.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Hukukta
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>
                                        Ayarlar
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('admin.settings.index')}}" class="nav-link">
                                            <i class="nav-icon fas fa-sliders-h"></i>
                                            <p>
                                                Genel Ayarlar
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.word.index')}}" class="nav-link">
                                            <i class="nav-icon fas fa-font"></i>
                                            <p>
                                                Aranacak Kelimeler
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.log.index')}}" class="nav-link">
                                            <i class="nav-icon fas fa-bug"></i>
                                            <p>
                                                Hata Kayıtları
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('login.logout')}}" class="nav-link">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        Çıkış Yap
                                    </p>
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">@yield('page_name')</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <!--li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active">Dashboard v1</li-->
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Main row -->
                        @yield('content')
                        <!-- /.row (main row) -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2010-{{date("Y")}} {{strtoupper($_site_name)}}</strong>
                All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{url('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- ChartJS -->
        <script src="{{url('plugins/chart.js/Chart.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{url('plugins/sparklines/sparkline.js')}}"></script>
        <!-- JQVMap -->
        <script src="{{url('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
        <script src="{{url('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{url('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
        <!-- daterangepicker -->
        <script src="{{url('plugins/moment/moment.min.js')}}"></script>
        <script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <!-- Summernote -->
        <script src="{{url('plugins/summernote/summernote-bs4.min.js')}}"></script>
        <!-- overlayScrollbars -->
        <script src="{{url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{url('dist/js/adminlte.js')}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{url('dist/js/pages/dashboard.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{url('dist/js/demo.js')}}"></script>
        <!-- SweetAlert2 -->
        <script src="{{url('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
        <!-- Please Wait -->
        <script src="{{url('js/please_wait/please-wait.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{url('plugins/toastr/toastr.min.js')}}"></script>
        <!-- DatePicker -->
        <script src="{{url('js/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{url('js/bootstrap-datepicker/bootstrap-datepicker.tr.min.js')}}" charset="UTF-8"></script>

        @yield('javascript')

        @yield('js_init')

        <script>
            // Ajax yüklemelerinde kullanıcının beklemesi için preloader
            var loading_screen;
            function pleaseWaitOpen() {
                loading_screen = pleaseWait({
                    logo: "{{$_site_logo}}",
                    backgroundColor: '#f46d3b',
                    loadingHtml: "<h3 style='color:white;margin-bottom: 30px;'>İşlem Yapılıyor, Lütfen Bekleyiniz...</h3>" +
                        "<div class='sk-spinner sk-spinner-wave'><div class='sk-bounce'>" +
                        "  <div class='sk-bounce-dot'></div>" +
                        "  <div class='sk-bounce-dot'></div>" +
                        "</div></div>"
                });
            }
            function pleaseWaitClose(){
                loading_screen.finish();
            }

            // Sweet Toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });

            $( document ).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                //Sayfada datepicker varsa ayarlarının yapılması.
                $('.datepicker').datepicker({
                    language: 'tr',
                    autoclose: true
                });
            });
        </script>
    </body>
</html>
