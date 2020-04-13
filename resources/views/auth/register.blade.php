@extends('layouts.app_public')

@section('masthead')
<div class="masthead">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Hello Nice People?</h1>
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
                    <h2 class="section-title">Create New Account</h2>
                    <div class="section-subtitle">Let's Help Others Without a Single Penny</div>
                </header>
                <div class="icon">
                    <img src="images/icon/icon-login.png" alt=""/>
                </div>

                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nama</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Alamat E-mail</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('akses') ? ' has-error' : '' }}">
                            <label for="akses" class="col-md-4 control-label">Tipe Akses</label>
                            <div class="col-md-6">
                                <select id="akses" name="akses" class="form-control">
                                    <option value="1">Pemilik - Pelayanan Kesehatan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-success" value="Register">
                            <a class="btn btn-link forget-pass" href="{{ URL::to('/login') }}"> Already have Account? Login </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="section"> <!-- Blank Space--> </section>
@endsection