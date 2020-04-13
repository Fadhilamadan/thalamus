@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Asuransi</li>
            <li class="active">Tambah Asuransi</li>
        </ol>
        <h4 class="header-title">Tambah Asuransi Pelayanan Kesehatan</h4>
        <div class="row">
            <form role="form" method="POST" action="{{ URL::to('/insertAsuransi_super') }}" class="form-validation topics-list">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="select2 js-placeholder form-control" name="m_namatempat" id="m_namatempat" required>
                                @foreach($faskes as $data)
                                @if($data->users_id == Auth::user()->id || $data->users_id == 2)
                                <option value="{{ $data->id }}"
                                    @foreach($allDataAsuransi as $dataFaskesAsuransi)
                                    @if($data->id == $dataFaskesAsuransi->faskes_id)
                                    disabled="disabled"
                                    @endif
                                    @endforeach>
                                    {{ $data->nama_tempat }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Asuransi<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="select2 form-control" name="m_asuransi[]" id="m_asuransi" multiple="multiple" data-placeholder="Pilih Asuransi" required>
                                @foreach($asuransi as $data)
                                <option value="{{ $data->id }}">{{ $data->nama_asuransi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-icon btn-default pull-right btn-fit-modal" data-toggle="modal" data-target="#modalAsuransi"><i class="fa fa-plus"></i></button>
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
            <div id="modalAsuransi" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <form role="form" method="POST" action="{{ URL::to('/tambahNamaAsuransi_super') }}" class="form-validation topics-list">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tambah Asuransi Baru</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Nama Asuransi<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="m_namaasuransi" id="m_namaasuransi" placeholder="BPJS Kesehatan" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Keterangan<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="m_keterangan" id="m_keterangan" placeholder="Tidak Melayani..." required></textarea>
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

@section('script_content')
<script type="text/javascript">
    $(".js-placeholder").select2({
        placeholder: "Semua Data Telah Terisi"
    });
</script>
@endsection