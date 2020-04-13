<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Thalamus - Informasi Pelayanan Kesehatan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <link rel="shortcut icon" href="{{ asset('images/logo-symbol.png') }}">

    <!-- Vector MAP -->
    <link href="{{ asset('plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">

    <!-- Plugins CSS-->
    <link href="{{ asset('plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/switchery/switchery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/clockpicker/css/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- DataTables -->
    <link href="{{ asset('plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/dataTables.colVis.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/fixedColumns.dataTables.min.css') }}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{ asset('plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Icons CSS -->
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
    <!-- Custom -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>


<body>

    <div id="page-wrapper">

        <!-- Top Bar -->
        <div class="topbar">

            <!-- Logo -->
            <div class="topbar-left">
                <a href="{{ URL::to('/beranda') }}" class="logo">
                    <img src="{{ asset('images/logo-dark.png') }}" alt="logo" class="logo-lg" />
                    <img src="{{ asset('images/logo-symbol.png') }}" alt="logo" class="logo-sm hidden" />
                </a>
            </div>
            <!-- Logo -->

            <!-- Top Navbar -->
            <div class="navbar navbar-default" role="navigation">
                <div class="container">
                    <div class="">
                        <!-- Mobile Menu Button -->
                        <div class="pull-left">
                            <button type="button" class="button-menu-mobile visible-xs visible-sm">
                                <i class="fa fa-bars"></i>
                            </button>
                            <span class="clearfix"></span>
                        </div>
                        <!-- Mobile Menu Button -->

                        <!-- Top Navbar - Right Menu -->
                        <ul class="nav navbar-nav navbar-right top-navbar-items-right pull-right">
                            <li class="dropdown top-menu-item-xs">
                                <a href="" class="dropdown-toggle menu-right-item profile" data-toggle="dropdown" aria-expanded="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                        <i class="ti-power-off m-r-10"></i> Logout </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!-- Top Navbar - Right Menu -->
                    </div>
                </div>
            </div>
            <!-- Top Navbar -->
        </div>
        <!-- Top Bar -->


        <!-- Page Content -->
        <div class="page-contentbar">

            <!-- left Navigation -->
            <aside class="sidebar-navigation">
                <div class="scrollbar-wrapper">
                    <div>
                        <button type="button" class="button-menu-mobile btn-mobile-view visible-xs visible-sm">
                            <i class="mdi mdi-close"></i>
                        </button>
                        <!-- User Detail -->
                        <div class="user-details">
                            <div class="pull-left">
                                <img src="{{ asset('images/icon/avatar.png') }}" alt="" class="thumb-md img-circle">
                            </div>
                            <div class="user-info">
                                <a>{{ Auth::user()->name }}</a>
                                <p class="text-muted m-0">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <!-- User Detail -->

                        <!-- Left Menu -->
                        <ul class="metisMenu nav" id="side-menu">
                            <li>
                                <a href="{{ URL::to('/beranda') }}"><span><i class="fa fa-home"></i></span><span> Beranda </span></a>
                            </li>
                            
                            @if(Auth::user()->akses == 0)
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-hospital-o"></i> Pelayanan Kesehatan <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/kesehatan_daftar_super') }}">Daftar Lokasi</a></li>
                                    <li><a href="{{ URL::to('/kesehatan_tambah_super') }}">Tambah Lokasi</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-medkit"></i> Layanan <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/layanan_daftar_super') }}">Daftar Layanan</a></li>
                                    <li><a href="{{ URL::to('/layanan_tambah_super') }}">Tambah Layanan</a></li>
                                    <li><a href="{{ URL::to('/layanan_data_super') }}">Data Layanan</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-heartbeat"></i> Asuransi <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/asuransi_daftar_super') }}">Daftar Asuransi</a></li>
                                    <li><a href="{{ URL::to('/asuransi_tambah_super') }}">Tambah Asuransi</a></li>
                                    <li><a href="{{ URL::to('/asuransi_data_super') }}">Data Asuransi</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-user-md"></i> Dokter <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/dokter_daftar_super') }}">Daftar Dokter</a></li>
                                    <li><a href="{{ URL::to('/dokter_tambah_super') }}">Tambah Dokter</a></li>
                                    <li><a href="{{ URL::to('/dokter_data_super') }}">Data Dokter</a></li>
                                    <li><a href="{{ URL::to('/penyakit_data_super') }}">Data Penyakit</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-wrench"></i> Peralatan <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/peralatan_daftar_super') }}">Daftar Peralatan</a></li>
                                    <li><a href="{{ URL::to('/peralatan_tambah_super') }}">Tambah Peralatan</a></li>
                                    <li><a href="{{ URL::to('/peralatan_data_super') }}">Data Peralatan</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ URL::to('/ulasan_super') }}"><i class="fa fa-users"></i> Ulasan </a>
                            </li>

                            @elseif(Auth::user()->akses == 1)
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-hospital-o"></i> Pelayanan Kesehatan <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/kesehatan_daftar') }}">Daftar Lokasi</a></li>
                                    <li><a href="{{ URL::to('/kesehatan_tambah') }}">Tambah Lokasi</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-medkit"></i> Layanan <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/layanan_daftar') }}">Daftar Layanan</a></li>
                                    <li><a href="{{ URL::to('/layanan_tambah') }}">Tambah Layanan</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-heartbeat"></i> Asuransi <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/asuransi_daftar') }}">Daftar Asuransi</a></li>
                                    <li><a href="{{ URL::to('/asuransi_tambah') }}">Tambah Asuransi</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-user-md"></i> Dokter <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/dokter_daftar') }}">Daftar Dokter</a></li>
                                    <li><a href="{{ URL::to('/dokter_tambah') }}">Tambah Dokter</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" aria-expanded="true"><i class="fa fa-wrench"></i> Peralatan <span class="fa arrow"></span></a>
                                <ul class="nav-second-level nav" aria-expanded="true">
                                    <li><a href="{{ URL::to('/peralatan_daftar') }}">Daftar Peralatan</a></li>
                                    <li><a href="{{ URL::to('/peralatan_tambah') }}">Tambah Peralatan</a></li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                        <!-- Left Menu -->
                    </div>
                </div>
            </aside>
            <!-- left Navigation -->

            <!-- Content -->
            <div id="page-right-content">
                <div class="container">
                    <div class="row p-t-20">
                        <div class="col-sm-12">
                            @if (session()->has('sukses'))
                            <div class="alert alert-success">
                                {{session()->get('sukses')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            @if (session()->has('gagal'))
                            <div class="alert alert-danger">
                                {{session()->get('gagal')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    @yield('content')

                    <!-- Footer -->
                    <div class="footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <a class="brand">
                                        <img src="{{ asset('images/logo-dark.png') }}" alt="logo" class="logo-lg"/>
                                        <img src="{{ asset('images/logo-symbol.png') }}" alt="logo" class="logo-sm hidden"/>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="copyright text-right">
                                        <p style="margin: 10px 0 10px;">© 2018 Thalamus Copyrights</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                </div>
            </div>
            <!-- Content -->
        </div>
        <!-- Page Content -->

        <!-- js placed at the end of the document so the pages load faster -->
        <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>

        <!-- App Js -->
        <script src="{{ asset('js/jquery.app.js') }}"></script>

        <!-- Datatable -->
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/dataTables.bootstrap.js') }}"></script>
        <script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/buttons.bootstrap.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/responsive.bootstrap.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/dataTables.scroller.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/dataTables.colVis.js') }}"></script>
        <script src="{{ asset('plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>

        <script src="{{ asset('plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
        <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>
        <script src="{{ asset('plugins/parsleyjs/parsley.min.js') }}"></script>
        <script src="{{ asset('plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('plugins/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('plugins/summernote/summernote.min.js') }}"></script>

        <!-- Sweet-Alert  -->
        <script src="{{ asset('plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('pages/jquery.sweet-alert.init.js') }}"></script>

        <!-- init -->
        <script src="{{ asset('pages/jquery.form-advanced.init.js') }}"></script>
        <script src="{{ asset('pages/jquery.datatables.init.js') }}"></script>

        <!-- Alert -->
        <script type="text/javascript">
            $('div.alert').not('.alert-important').delay(5000).slideUp(500);
        </script>

        @yield('script_content')

    </div>
</body>
</html>