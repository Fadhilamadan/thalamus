@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Peralatan</li>
            <li class="active">Tambah Peralatan</li>
        </ol>
        <h4 class="header-title">Tambah Peralatan Pelayanan Kesehatan</h4>
        <div class="row">
            <form role="form" method="POST" action="{{ URL::to('/insertPeralatan_super') }}" class="form-validation topics-list">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="select2 form-control" name="m_namatempat" id="m_namatempat" required>
                                @foreach($faskes as $data)
                                @if($data->users_id == Auth::user()->id || $data->users_id == 2)
                                <option value="{{ $data->id }}"> {{ $data->nama_tempat }} </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Peralatan<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="select2 form-control" name="m_peralatan" id="m_peralatan" data-placeholder="Pilih Peralatan" required>
                                @foreach($peralatan as $data)
                                <option value="{{ $data->id }}">{{ $data->nama_peralatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-icon btn-default pull-right btn-fit-modal" data-toggle="modal" data-target="#modalPeralatan"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Keterangan<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="m_keterangan" id="m_keterangan" placeholder="Keterangan" maxlength="255" required></textarea>
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

            <!-- Modal -->
            <div id="modalPeralatan" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <form role="form" method="POST" action="{{ URL::to('/tambahNamaPeralatan_super') }}" class="form-validation topics-list">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tambah Peralatan Baru</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Nama Peralatan<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="m_namaperalatan" id="m_namaperalatan" placeholder="Anestesi Diagnostik" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <input type="submit" class="btn btn-primary waves-effect waves-light">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal -->

        </div>
    </div>
</div>
@endsection