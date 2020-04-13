@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Peralatan</li>
            <li class="active">Daftar Peralatan</li>
        </ol>
        <h4 class="header-title">Daftar Peralatan Pelayanan Kesehatan</h4>
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
                    @php $i = 1; $count = 0; @endphp
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
                            <button class="btn btn-icon btn-info" data-toggle="modal" data-target="#viewPeralatanModal{{$i}}"> <i class="fa fa-eye"></i></button>
                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editPeralatanModal{{$i}}"> <i class="fa fa-edit"></i></button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div id="viewPeralatanModal{{$i}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Lihat Peralatan</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" value="{{ $dataFakes->nama_tempat }}" required disabled="true">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Peralatan<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <select class="m_peralatanview select2 form-control" index="{{$count}}" name="m_peralatanview" data-placeholder="Pilih Peralatan" style="width: 100%;" required>
                                                        <option value=""></option>
                                                        @foreach($peralatan as $dataPeralatan)
                                                        @foreach($allDataPeralatan as $dataFaskesPeralatan)
                                                        @if($dataPeralatan->id == $dataFaskesPeralatan->peralatan_id)
                                                        @if($dataFakes->id == $dataFaskesPeralatan->faskes_id)
                                                        <option value="{{$dataPeralatan->id}}">{{$dataPeralatan->nama_peralatan}}</option>
                                                        @endif
                                                        @endif
                                                        @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Keterangan<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea class="m_keteranganview form-control" name="m_keteranganview" placeholder="Data Kosong" maxlength="255" disabled="true" required></textarea>
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

                    <div id="editPeralatanModal{{$i}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" method="POST" action="{{ URL::to('/updatePeralatan_super') }}" class="form-validation topics-list">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Edit Peralatan</h4>
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
                                                    <label class="col-sm-3 form-control-label">Peralatan<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="m_peralatan select2 form-control" index="{{$count}}" name="m_peralatan" data-placeholder="Pilih Peralatan" style="width: 100%;" required>
                                                            <option value=""></option>
                                                            @foreach($peralatan as $dataPeralatan)
                                                            @foreach($allDataPeralatan as $dataFaskesPeralatan)
                                                            @if($dataPeralatan->id == $dataFaskesPeralatan->peralatan_id)
                                                            @if($dataFakes->id == $dataFaskesPeralatan->faskes_id)
                                                            <option value="{{$dataPeralatan->id}}">{{$dataPeralatan->nama_peralatan}}</option>
                                                            @endif
                                                            @endif
                                                            @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 form-control-label">Keterangan<span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <textarea class="m_keterangan form-control" name="m_keterangan" placeholder="Data Kosong" maxlength="255" required></textarea>
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
        $('.m_peralatan').on('change.select2', function() {
            var index = $(this).attr('index');
            var id    = $(this).val();
            var div   = $(this).parent();
            var clone = "";

            $.ajax({
                type: 'GET',
                url : '{!!URL::to('dataPeralatan_super')!!}',
                data: { 'id':id },
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        clone += data[i].keterangan;
                    }
                    document.getElementsByClassName('m_keterangan')[index].innerHTML = clone;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });

    $(document).ready(function(){
        $('.m_peralatanview').on('change.select2', function() {
            var index = $(this).attr('index');
            var id    = $(this).val();
            var div   = $(this).parent();
            var clone = "";

            $.ajax({
                type: 'GET',
                url : '{!!URL::to('dataPeralatan_super')!!}',
                data: { 'id':id },
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        clone += data[i].keterangan;
                    }
                    document.getElementsByClassName('m_keteranganview')[index].innerHTML = clone;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>
@endsection