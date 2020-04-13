<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Thalamus - Informasi Pelayanan Kesehatan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    
    <link rel="shortcut icon" href="{{ asset('images/logo-symbol.png') }}">
    
    <!-- Plugins CSS-->
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- DataTables -->
    <link href="{{ asset('plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/metisMenu.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body class="template-card">

    <!-- Header -->
    <header id="hero" class="hero overlay">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                    </button>
                    <a href="{{ URL::to('/') }}" class="brand"><img src="{{ asset('images/logo-light.png') }}" alt="Knowledge"></a>
                </div>
                <div class="navbar-collapse collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ URL::to('/') }}">Telusuri</a></li>
                        <li><a href="{{ URL::to('/submit') }}">Submit</a></li>
                    </ul>
                </div>
                <div class="row p-t-20">
                    <div class="col-md-8 col-md-offset-2" style="padding-top:20px">
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
            </div>
        </nav>
        @yield('masthead')
    </header>
    <!-- Header -->

    <!-- Login --> @yield('login') <!-- Login -->

    <!-- Features --> @yield('features') <!-- Features -->

    <!-- Topics --> @yield('topics') <!-- Topics -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <a href="{{ URL::to('/') }}" class="brand">
                        <img src="{{ asset('images/logo-dark.png') }}" alt="Knowledge">
                        <span class="circle"></span>
                    </a>
                </div>
                <div class="col-lg-7 col-md-5 col-sm-9">
                    <ul class="footer-links">
                        <li><a href="{{ URL::to('/') }}">Telusuri</a></li>
                        <li><a href="{{ URL::to('/submit') }}">Submit</a></li>
                        <li><a href="{{ URL::to('/login') }}">Login</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="copyright">
                        <p>© 2018 Thalamus Copyrights</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer -->

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>

    <!-- App Js -->
    <script src="{{ asset('js/jquery.app.js') }}"></script>

    <!-- Datatable js -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap.js') }}"></script>

    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <!-- init -->
    <script src="{{ asset('pages/jquery.datatables.init.js') }}"></script>
    <script src="{{ asset('pages/jquery.form-advanced.init.js') }}"></script>

    <!-- Alert -->
    <script type="text/javascript">
        $('div.alert').not('.alert-important').delay(5000).slideUp(500);
    </script>

    @yield('script_content')
</body>
</html>