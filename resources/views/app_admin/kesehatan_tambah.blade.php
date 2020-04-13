@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Pelayanan Kesehatan</li>
            <li class="active">Tambah Lokasi</li>
        </ol>
        <h4 class="header-title">Tambah Lokasi Pelayanan Kesehatan</h4>
        <div class="row">
            <form role="form" method="POST" action="{{ URL::to('/insertFasKes') }}" class="form-validation topics-list">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="hidden" name="m_userid" value="{{ Auth::user()->id }}">
                <div class="col-md-12">
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
                                <option value="Senin" selected>Senin</option>
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
                                <option value="Jumat" selected>Jumat</option>
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
                            <input class="form-control" type="number" name="m_telepon" id="m_telepon" placeholder="08123456xxxx" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="btn pull-right">
                            <button type="reset" class="btn btn-danger waves-effect m-l-5"> Cancel </button>
                            <input type="submit" class="btn btn-primary waves-effect waves-light">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection