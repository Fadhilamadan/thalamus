@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Layanan</li>
            <li class="active">Tambah Layanan</li>
        </ol>
        <h4 class="header-title">Tambah Layanan Pelayanan Kesehatan</h4>
        <div class="row">
            <form role="form" method="POST" action="{{ URL::to('/insertLayanan_super') }}" class="form-validation topics-list">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="select2 js-placeholder form-control" name="m_namatempat" id="m_namatempat" required>
                                <option value="" disabled>Pilih Nama Tempat</option>
                                @foreach($faskes as $data)
                                @if($data->users_id == Auth::user()->id || $data->users_id == 2)
                                <option value="{{ $data->id }}"
                                    @foreach($allDataFaskesLayanan as $dataFaskesLayanan)
                                    @if($data->id == $dataFaskesLayanan->faskes_id)
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
                        <label class="col-sm-3 form-control-label">Layanan<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="select2 form-control" name="m_layanan[]" id="m_layanan" multiple="multiple" data-placeholder="Pilih Layanan">
                                @foreach($layanan as $data)
                                <option value="{{ $data->id }}">{{ $data->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-icon btn-default pull-right btn-fit-modal" data-toggle="modal" data-target="#modalLayanan"><i class="fa fa-plus"></i></button>
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
            <div id="modalLayanan" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <form role="form" method="POST" action="{{ URL::to('/tambahNamaLayanan_super') }}" class="form-validation topics-list">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tambah Layanan Baru</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Nama Layanan<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="m_namalayanan" id="m_namalayanan" placeholder="Unit Gawat Darurat" required>
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