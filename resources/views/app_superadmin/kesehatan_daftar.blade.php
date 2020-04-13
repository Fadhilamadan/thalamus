@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Pelayanan Kesehatan</li>
            <li class="active">Daftar Lokasi</li>
        </ol>
        <h4 class="header-title">Daftar Lokasi Pelayanan Kesehatan</h4>
        <div class="m-b-20 table-responsive">
            <table id="datatable-colvid-sorting" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="display: none">No</th>
                        <th>Nama Tempat</th>
                        <th>Alamat</th>
                        <th style="width:50px;">Telepon</th>
                        <th style="width:50px;">Jam</th>
                        <th style="width:50px;">Hari</th>
                        <th style="width:50px;">Status</th>
                        <th>Pemilik</th>
                        <th style="width:100px;">Edit/Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($allDataFaskes as $data)
                    <tr>
                        <td style="display: none">{{$i++}}</td>
                        <td>{{$data->nama_tempat}}</td>
                        <td>{{$data->alamat}}</td>
                        <td align="center">{{$data->telepon}}</td>
                        <td align="center">{{$data->jam_buka}} - {{$data->jam_tutup}}</td>
                        <td align="center">{{$data->hari_buka}} - {{$data->hari_tutup}}</td>

                        @if ($data->hapus == 0)
                        <td align="center"><span class="label label-success">Active</span></td>
                        @elseif ($data->hapus == 1) 
                        <td align="center"><span class="label label-warning">Waiting</span></td>
                        @else 
                        <td align="center"><span class="label label-dark">Deleted</span></td>
                        @endif

                        @foreach($users as $dataUsers)
                        @if($data->users_id == $dataUsers->id)
                        <td align="center">
                            @if($dataUsers->akses == 0)
                            <span class="label label-primary">{{$dataUsers->name}}</span>
                            @else
                            <span class="label label-info">{{$dataUsers->name}}</span>
                            @endif
                        </td>
                        @endif
                        @endforeach

                        <td align="center">

                            @if ($data->hapus == 0)
                            <form class="form-group" method="post" action="{{ url('/statusFaskes_super') }}">
                                {{ csrf_field() }}
                                <input id="m_idnamatempat" name="m_idnamatempat" type="hidden" value="{{$data->id}}">
                                <input name="m_status" type="hidden" value="1">
                                <button class="btn btn-icon btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Moderasi"> <i class="fa fa-ban"></i> </button>
                            </form>

                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editFasKesModal{{$i}}"> <i class="fa fa-edit"></i></button>

                            <form class="form-group" method="post" action="{{ url('/kesehatanMaps_super') }}">
                                {{ csrf_field() }}
                                <input id="m_idmap" name="m_idmap" type="hidden" value="{{ $data->id }}">
                                <button type="submit" class="btn btn-icon btn-info"><i class="fa fa-map"></i></button>
                            </form>

                            @elseif ($data->hapus == 1)
                            <form class="form-group" method="post" action="{{ url('/statusFaskes_super') }}">
                                {{ csrf_field() }}
                                <input id="m_idnamatempat" name="m_idnamatempat" type="hidden" value="{{$data->id}}">
                                <input name="m_status" type="hidden" value="0">
                                <button class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Aktifkan"> <i class="fa fa-check"></i> </button>
                            </form>

                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editFasKesModal{{$i}}"> <i class="fa fa-edit"></i></button>

                            <form class="form-group" method="post" action="{{ url('/statusFaskes_super') }}">
                                {{ csrf_field() }}
                                <input id="m_idnamatempat" name="m_idnamatempat" type="hidden" value="{{$data->id}}">
                                <input name="m_status" type="hidden" value="2">
                                <button class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Hapus"> <i class="fa fa-trash"></i> </button>
                            </form>

                            @else
                            <form class="form-group" method="post" action="{{ url('/statusFaskes_super') }}">
                                {{ csrf_field() }}
                                <input id="m_idnamatempat" name="m_idnamatempat" type="hidden" value="{{$data->id}}">
                                <input name="m_status" type="hidden" value="0">
                                <button class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Aktifkan"> <i class="fa fa-check"></i> </button>
                            </form>

                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editFasKesModal{{$i}}"> <i class="fa fa-edit"></i></button>
                            @endif

                        </td>
                    </tr>

                    <!-- Modal -->
                    <div id="editFasKesModal{{$i}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" method="POST" action="{{ URL::to('/updateFaskes_super') }}" class="form-validation topics-list">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Edit Lokasi Pelayanan Kesehatan</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                            <input type="hidden" name="m_idnamatempat" id="m_idnamatempat" value="{{ $data->id }}">
                                            <input type="hidden" name="m_status" id="m_status" value="0">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" value="{{ $data->nama_tempat }}" disabled="true" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Alamat Lengkap<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="m_alamat" id="m_alamat" required>{{ $data->alamat }}</textarea>
                                                        <span class="help-block"><small>Sesuaikan alamat dengan Google Maps</small></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Telepon<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="m_telepon" id="m_telepon" value="{{ $data->telepon }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Jam<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="time" name="m_jambuka" id="m_jambuka" value="{{ $data->jam_buka }}" required>
                                                    </div>
                                                    <div class="col-sm-1"> sampai </div>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="time" name="m_jamtutup" id="m_jamtutup" value="{{ $data->jam_tutup }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Hari<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" type="text" name="m_haribuka" id="m_haribuka" required>
                                                            <option style="display: none">{{ $data->hari_buka }}</option>
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
                                                            <option style="display: none">{{ $data->hari_tutup }}</option>
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
                                                        <textarea class="form-control" name="m_deskripsi" id="m_deskripsi" rows="5" required>{{ $data->deskripsi }} </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                        <input type="submit" class="btn btn-primary waves-effect waves-light" value="Perbarui">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal -->

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection