@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Dokter</li>
            <li class="active">Tambah Dokter</li>
        </ol>
        <h4 class="header-title">Tambah Dokter Pelayanan Kesehatan</h4>
        <div class="row">
            <form role="form" method="POST" action="{{ URL::to('/insertDokter') }}" class="form-validation topics-list"> 
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="select2 form-control" name="m_namatempat" id="m_namatempat" data-placeholder="Pilih Pelayanan Kesehatan" required>
                                <option value=""></option>
                                @foreach($faskes as $data)
                                @if($data->users_id == Auth::user()->id)
                                <option value="{{ $data->id }}">{{ $data->nama_tempat }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Nama Dokter<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="select2 form-control" name="m_namadokter" id="m_namadokter" data-placeholder="Pilih Dokter" required>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-icon btn-default pull-right btn-fit-modal" data-toggle="modal" data-target="#modalDokter"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Penyakit<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="select2 form-control" name="m_penyakit[]" id="m_penyakit" multiple="multiple" data-placeholder="Pilih Penyakit" required>
                                @foreach($penyakit as $data)
                                <option value="{{ $data->id }}">{{ $data->nama_penyakit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-icon btn-default pull-right btn-fit-modal" data-toggle="modal" data-target="#modalPenyakit"><i class="fa fa-plus"></i></button>
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
            <div id="modalDokter" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <form role="form" method="POST" action="{{ URL::to('/tambahNamaDokter') }}" class="form-validation topics-list">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tambah Dokter Baru</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="select2 form-control" name="n_namatempat" id="n_namatempat" data-placeholder="Pilih Pelayanan Kesehatan" style="width: 100%" required>
                                                    @foreach($faskes as $data)
                                                    @if($data->users_id == Auth::user()->id)
                                                    <option value="{{ $data->id }}">{{ $data->nama_tempat }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Nama Dokter<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="n_namadokter" id="n_namadokter" placeholder="dr. Fadhil Amadan" required>
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

            <div id="modalPenyakit" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <form role="form" method="POST" action="{{ URL::to('/tambahNamaPenyakit') }}" class="form-validation topics-list">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tambah Penyakit Baru</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Nama Penyakit<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="m_namapenyakit" id="m_namapenyakit" placeholder="Jantung Koroner" required>
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
    $(document).ready(function(){
        $('#m_namatempat').on('change.select2', function() {
            var id    = $(this).val();
            var div   = $(this).parent();
            var clone = "";

            $.ajax({
                type: 'GET',
                url : '{!!URL::to('dataDokter')!!}',
                data: { 'id':id },
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        clone += '<option value="' + data[i].id + '" selected="selected">' + data[i].nama_dokter + '</option>';
                    }
                    document.getElementById('m_namadokter').innerHTML = clone;
                },
                error: function(data) {
                    alert(data);
                }
            });
        });
    });
</script>
@endsection