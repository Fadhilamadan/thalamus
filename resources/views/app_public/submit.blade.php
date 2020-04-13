@extends('layouts.app_public')

@section('topics')
<div class="breadcrumbs">
    <div class="container">
        <ol>
            <li><a href="{{ URL::to('/') }}">Home</a></li>
            <li class="active">Submit</li>
        </ol>
    </div>
</div>

<section class="topics">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <header style="margin-bottom: 30px;">
                    <h2><span class="icon-pages"></span> Submit Lokasi Pelayanan Kesehatan </h2>
                </header>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="p-20 m-b-20">
                                <form role="form" method="POST" action="{{ URL::to('/insertFaskes') }}" class="form-validation topics-list">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="form-group row">
                                        <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="m_namatempat" id="m_namatempat" placeholder="Nama Tempat" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 form-control-label">Alamat Lengkap<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="m_alamat" id="m_alamat" placeholder="Alamat Lengkap" required></textarea>
                                            <span class="help-block"><small>Sesuaikan alamat dengan Google Maps</small></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 form-control-label">Jam<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="time" name="m_jambuka" id="m_jambuka" placeholder="07:00 (Jam Buka)" required>
                                        </div>
                                        <div class="col-sm-1"> sampai </div>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="time" name="m_jamtutup" id="m_jamtutup" placeholder="20:00 (Jam Tutup)" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 form-control-label">Hari<span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" type="text" name="m_haribuka" id="m_haribuka" required>
                                                <option value="Senin">Senin</option>
                                                <option value="Selasa">Selasa</option>
                                                <option value="Rabu">Rabu</option>
                                                <option value="Kamis">Kamis</option>
                                                <option value="Jumat">Jumat</option>
                                                <option value="Sabtu">Sabtu</option>
                                                <option value="Minggu">Minggu</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1"> sampai </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" type="text" name="m_haritutup" id="m_haritutup" required>
                                                <option value="Senin">Senin</option>
                                                <option value="Selasa">Selasa</option>
                                                <option value="Rabu">Rabu</option>
                                                <option value="Kamis">Kamis</option>
                                                <option value="Jumat">Jumat</option>
                                                <option value="Sabtu">Sabtu</option>
                                                <option value="Minggu">Minggu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 form-control-label">Deskripsi<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" type="text" name="m_deskripsi" id="m_deskripsi" placeholder="Deskripsi" rows="5" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 form-control-label">Telepon<span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="m_telepon" id="m_telepon" placeholder="08123456xxxx" maxlength="12" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="btn pull-right">
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"> Cancel </button>
                                            <input type="submit" class="btn btn-primary waves-effect waves-light">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="widget widget-support-forum">
                        <span class="icon icon-forum"></span>
                        <h4>Anda Pemilik Pelayanan Kesehatan?</h4>
                        <p>Dengan mendaftarkan pelayanan kesehatan milik Anda, Anda juga membantu untuk menunjang kesehatan masyarakat disekitar Anda.</p>
                        <a href="{{ URL::to('/register') }}" class="btn btn-success">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection