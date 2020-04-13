@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Layanan</li>
            <li class="active">Data Layanan</li>
        </ol>
        <h4 class="header-title">Data Layanan Pelayanan Kesehatan</h4>
        <div class="m-b-20 table-responsive">
            <table id="datatable-colvid" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="display: none">No</th>
                        <th>Nama Layanan</th>
                        <th style="width:100px;">Status</th>
                        <th style="width:100px;">Lihat/Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($layanan_data as $data)
                    <tr>
                        <td style="display: none">{{$i++}}</td>
                        <td>{{$data->nama_layanan}}</td>

                        @if ($data->hapus == 0)
                        <td align="center"><span class="label label-success">Active</span></td>
                        @else 
                        <td align="center"><span class="label label-dark">Deleted</span></td>
                        @endif
                        
                        <td align="center">

                            @if ($data->hapus == 0)
                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editLayananModal{{$i}}"> <i class="fa fa-edit"></i></button>

                            <form class="form-group" method="post" action="{{ url('/statusLayanan_super') }}">
                                {{ csrf_field() }}
                                <input id="m_idlayanan" name="m_idlayanan" type="hidden" value="{{$data->id}}">
                                <input name="m_status" type="hidden" value="2">
                                <button class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Hapus"> <i class="fa fa-trash"></i> </button>
                            </form>

                            @else
                            <form class="form-group" method="post" action="{{ url('/statusLayanan_super') }}">
                                {{ csrf_field() }}
                                <input id="m_idlayanan" name="m_idlayanan" type="hidden" value="{{$data->id}}">
                                <input name="m_status" type="hidden" value="0">
                                <button class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Aktifkan"> <i class="fa fa-check"></i> </button>
                            </form>

                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editLayananModal{{$i}}"> <i class="fa fa-edit"></i></button>
                            @endif

                        </td>
                    </tr>

                    <!-- Modal -->
                    <div id="editLayananModal{{$i}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" method="POST" action="{{ URL::to('/updateNamaLayanan_super') }}" class="form-validation topics-list">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Edit Nama Layanan</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                            <input type="hidden" name="m_idlayanan" id="m_idlayanan" value="{{ $data->id }}">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Nama Layanan<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="m_namalayanan" id="m_namalayanan" value="{{ $data->nama_layanan }}" required>
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