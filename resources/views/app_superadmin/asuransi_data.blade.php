@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Asuransi</li>
            <li class="active">Data Asuransi</li>
        </ol>
        <h4 class="header-title">Data Asuransi Pelayanan Kesehatan</h4>
        <div class="m-b-20 table-responsive">
            <table id="datatable-colvid" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="display: none">No</th>
                        <th>Nama Asuransi</th>
                        <th>Keterangan</th>
                        <th style="width:100px;">Status</th>
                        <th style="width:100px;">Lihat/Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($asuransi_data as $data)
                    <tr>
                        <td style="display: none">{{$i++}}</td>
                        <td>{{$data->nama_asuransi}}</td>
                        <td>{{$data->keterangan}}</td>

                        @if ($data->hapus == 0)
                        <td align="center"><span class="label label-success">Active</span></td>
                        @else 
                        <td align="center"><span class="label label-dark">Deleted</span></td>
                        @endif
                        
                        <td align="center">

                            @if ($data->hapus == 0)
                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editAsuransiModal{{$i}}"> <i class="fa fa-edit"></i></button>

                            <form class="form-group" method="post" action="{{ url('/statusAsuransi_super') }}">
                                {{ csrf_field() }}
                                <input id="m_idasuransi" name="m_idasuransi" type="hidden" value="{{$data->id}}">
                                <input name="m_status" type="hidden" value="2">
                                <button class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Hapus"> <i class="fa fa-trash"></i> </button>
                            </form>

                            @else
                            <form class="form-group" method="post" action="{{ url('/statusAsuransi_super') }}">
                                {{ csrf_field() }}
                                <input id="m_idasuransi" name="m_idasuransi" type="hidden" value="{{$data->id}}">
                                <input name="m_status" type="hidden" value="0">
                                <button class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Aktifkan"> <i class="fa fa-check"></i> </button>
                            </form>

                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editAsuransiModal{{$i}}"> <i class="fa fa-edit"></i></button>
                            @endif

                        </td>
                    </tr>

                    <!-- Modal -->
                    <div id="editAsuransiModal{{$i}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" method="POST" action="{{ URL::to('/updateNamaAsuransi_super') }}" class="form-validation topics-list">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Edit Nama Asuransi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                            <input type="hidden" name="m_idasuransi" id="m_idasuransi" value="{{ $data->id }}">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Nama Asuransi<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="m_namaasuransi" id="m_namaasuransi" value="{{ $data->nama_asuransi }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Keterangan<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="m_keterangan" id="m_keterangan" rows="3" required>{{ $data->keterangan }} </textarea>
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