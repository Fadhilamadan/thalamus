@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Dokter</li>
            <li class="active">Daftar Dokter</li>
        </ol>
        <h4 class="header-title">Daftar Dokter Pelayanan Kesehatan</h4>
        <div class="m-b-20 table-responsive">
            <table id="datatable-colvid" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="display: none">No</th>
                        <th>Nama Pelayanan Kesehatan</th>
                        <th style="width:100px;">Lihat/Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; $count = 0; @endphp
                    @foreach($faskes as $dataFakes)
                    @if($dataFakes->users_id == Auth::user()->id)
                    <tr>
                        <td style="display: none">{{$i++}}</td>
                        <td>{{$dataFakes->nama_tempat}}</td>
                        <td align="center">
                            <button class="btn btn-icon btn-info" data-toggle="modal" data-target="#viewDokterModal{{$i}}"> <i class="fa fa-eye"></i></button>
                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editDokterModal{{$i}}"> <i class="fa fa-edit"></i></button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div id="viewDokterModal{{$i}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Edit Dokter</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" value="{{ $dataFakes->nama_tempat }}" required disabled="true">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Dokter<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <select class="m_namadokterview select2 form-control" index="{{$count}}" name="n_namadokter" data-placeholder="Pilih Dokter" style="width: 100%;" required>
                                                        <option value=""></option>
                                                        @foreach($dokter as $dataDokter)
                                                        @if($dataDokter->faskes_id == $dataFakes->id)
                                                        <option value="{{ $dataDokter->id }}">{{$dataDokter->nama_dokter}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Penyakit<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <select class="m_penyakitview select2 form-control" name="n_penyakit[]" multiple="multiple" data-placeholder="Pilih Penyakit" style="width: 100%;" disabled="true" required>
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

                    <div id="editDokterModal{{$i}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" method="POST" action="{{ URL::to('/updateDokter') }}" class="form-validation topics-list">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Edit Dokter</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                            <input type="hidden" name="m_idnamatempat" id="m_idnamatempat" value="{{ $dataFakes->id }}">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" value="{{ $dataFakes->nama_tempat }}" required disabled="true">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Dokter<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="m_namadokter select2 form-control" index="{{$count}}" name="m_namadokter" data-placeholder="Pilih Dokter" style="width: 100%;" required>
                                                            <option value=""></option>
                                                            @foreach($dokter as $dataDokter)
                                                            @if($dataDokter->faskes_id == $dataFakes->id)
                                                            <option value="{{ $dataDokter->id }}">{{$dataDokter->nama_dokter}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Penyakit<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="m_penyakit select2 form-control" name="m_penyakit[]" multiple="multiple" data-placeholder="Pilih Penyakit" style="width: 100%;" required>
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
                    @php $count++ @endphp
                    <!-- Modal -->

                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script_content')
<script type="text/javascript">
    $(document).ready(function(){
        $('.m_namadokter').on('change.select2', function() {
            var index = $(this).attr('index');
            var id    = $(this).val();
            var div   = $(this).parent();
            var clone = "";

            $.ajax({
                type: 'GET',
                url : '{!!URL::to('dataPenyakit')!!}',
                data: { 'id':id },
                success: function(data) {
                    for(var j = 0; j < data[1].length; j++) {
                        clone += '<option value="' + data[1][j].id + '"';
                        for (var i = 0; i < data[0].length; i++) {
                            if(data[0][i].penyakit_id == data[1][j].id) {
                                clone += ' selected="selected"';
                                break;
                            }
                        }
                        clone += '>' + data[1][j].nama_penyakit + '</option>';
                    }
                    document.getElementsByClassName('m_penyakit')[index].innerHTML = clone;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });

    $(document).ready(function(){
        $('.m_namadokterview').on('change.select2', function() {
            var index = $(this).attr('index');
            var id    = $(this).val();
            var div   = $(this).parent();
            var clone = "";

            $.ajax({
                type: 'GET',
                url : '{!!URL::to('dataPenyakit')!!}',
                data: { 'id':id },
                success: function(data) {
                    for(var j = 0; j < data[1].length; j++) {
                        clone += '<option value="' + data[1][j].id + '"';
                        for (var i = 0; i < data[0].length; i++) {
                            if(data[0][i].penyakit_id == data[1][j].id) {
                                clone += ' selected="selected"';
                                break;
                            }
                        }
                        clone += '>' + data[1][j].nama_penyakit + '</option>';
                    }
                    document.getElementsByClassName('m_penyakitview')[index].innerHTML = clone;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>
@endsection