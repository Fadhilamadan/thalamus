@extends('layouts.app_public')

@section('masthead')
<div class="masthead">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Welcome Back</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('login')
<section class="card-section">
    <div class="container">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="card text-center">

                <header class="text-center">
                    <h2 class="section-title">Sign In Now</h2>
                    <div class="section-subtitle">Let's Help Others Without a Single Penny</div>
                </header>
                <div class="icon">
                    <img src="images/icon/icon-login.png" alt=""/>
                </div>

                <div class="row p-t-20">
                    <div class="col-sm-12">
                        @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            {{ $errors->first('password') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="search-field form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="search-field form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-success" value="Login">
                            <a class="btn btn-link forget-pass" href="{{ URL::to('/register') }}"> Don't have Account? Register </a>
                            <a class="btn btn-link forget-pass" href="{{ route('password.request') }}"> Forgot your Password? </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="section"> <!-- Blank Space--> </section>
@endsection