@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Asuransi</li>
            <li class="active">Daftar Asuransi</li>
        </ol>
        <h4 class="header-title">Daftar Asuransi Pelayanan Kesehatan</h4>
        <div class="m-b-20 table-responsive">
            <table id="datatable-colvid-sorting-superadmin" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="display: none">No</th>
                        <th>Nama Pelayanan Kesehatan</th>
                        <th>Pemilik</th>
                        <th style="width:100px;">Lihat/Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($faskes as $dataFakes)
                    <tr>
                        <td style="display: none">{{$i++}}</td>
                        <td>{{$dataFakes->nama_tempat}}</td>

                        @foreach($users as $dataUsers)
                        @if($dataFakes->users_id == $dataUsers->id)
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
                            <button class="btn btn-icon btn-info" data-toggle="modal" data-target="#viewAsuransiModal{{$i}}"> <i class="fa fa-eye"></i></button>
                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editAsuransiModal{{$i}}"> <i class="fa fa-edit"></i></button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div id="viewAsuransiModal{{$i}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Lihat Asuransi</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" value="{{ $dataFakes->nama_tempat }}" disabled="true" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Asuransi<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <select class="select2 form-control" name="m_asuransi[]" id="m_asuransi" multiple="multiple" data-placeholder="Data Kosong" style="width: 100%;" disabled="true" required>
                                                        @foreach($asuransi as $dataAsuransi)
                                                        <option value="{{$dataAsuransi->id}}"
                                                            @foreach($allDataAsuransi as $dataFaskesAsuransi)
                                                            @if($dataFakes->id == $dataFaskesAsuransi->faskes_id)
                                                            @if($dataFaskesAsuransi->asuransi_id == $dataAsuransi->id)
                                                            selected="selected"
                                                            @endif
                                                            @endif
                                                            @endforeach>
                                                            {{$dataAsuransi->nama_asuransi}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="editAsuransiModal{{$i}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" method="POST" action="{{ URL::to('/updateAsuransi_super') }}" class="form-validation topics-list">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Edit Asuransi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                            <input type="hidden" name="m_idnamatempat" id="m_idnamatempat" value="{{ $dataFakes->id }}">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" value="{{ $dataFakes->nama_tempat }}" disabled="true" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Asuransi<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="select2 form-control" name="m_asuransi[]" id="m_asuransi" multiple="multiple" data-placeholder="Pilih Asuransi" style="width: 100%;" required>
                                                            @foreach($asuransi as $dataAsuransi)
                                                            <option value="{{$dataAsuransi->id}}"
                                                                @foreach($allDataAsuransi as $dataFaskesAsuransi)
                                                                @if($dataFakes->id == $dataFaskesAsuransi->faskes_id)
                                                                @if($dataFaskesAsuransi->asuransi_id == $dataAsuransi->id)
                                                                selected="selected"
                                                                @endif
                                                                @endif
                                                                @endforeach>
                                                                {{$dataAsuransi->nama_asuransi}}
                                                            </option>
                                                            @endforeach
                                                        </select>
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