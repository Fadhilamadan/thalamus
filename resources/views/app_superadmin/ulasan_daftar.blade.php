@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Ulasan</li>
            <li class="active">Daftar Ulasan</li>
        </ol>
        <h4 class="header-title">Daftar Ulasan Semua Pelayanan Kesehatan</h4>
        <div class="m-b-20 table-responsive">
            <table id="datatable-colvid-sorting" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="display: none">No</th>
                        <th>Pelayanan Kesehatan</th>
                        <th>Nama Pengguna</th>
                        <th>Ulasan</th>
                        <th style="width:50px;">Kenyamanan Tempat</th>
                        <th style="width:50px;">Layanan Kesehatan</th>
                        <th style="width:50px;">Status</th>
                        <th style="width:100px;">Edit/Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($allUlasan as $data)
                    <tr>
                        <td style="display: none">{{$i++}}</td>
                        @foreach($faskes as $dataFaskes)
                        @if($dataFaskes->id == $data->faskes_id)
                        <td>{{$dataFaskes->nama_tempat}}</td>
                        @endif
                        @endforeach
                        <td>{{$data->nama_pengguna}}</td>
                        <td>{{$data->ulasan}}</td>

                        @if($data->rating_faskes == 5)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                        </td>

                        @elseif($data->rating_faskes == 4)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>

                        @elseif($data->rating_faskes == 3)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>

                        @elseif($data->rating_faskes == 2)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>

                        @elseif($data->rating_faskes == 1)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>

                        @elseif($data->rating_faskes == 0)
                        <td align="center">
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>
                        @endif

                        @if($data->rating_layanan == 5)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                        </td>

                        @elseif($data->rating_layanan == 4)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>

                        @elseif($data->rating_layanan == 3)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>

                        @elseif($data->rating_layanan == 2)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>

                        @elseif($data->rating_layanan == 1)
                        <td align="center">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>

                        @elseif($data->rating_layanan == 0)
                        <td align="center">
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </td>
                        @endif

                        @if ($data->hapus == 0)
                        <td align="center"><span class="label label-success">Active</span></td>
                        @elseif ($data->hapus == 1) 
                        <td align="center"><span class="label label-warning">Waiting</span></td>
                        @else 
                        <td align="center"><span class="label label-dark">Deleted</span></td>
                        @endif

                        <td align="center">

                            @if ($data->hapus == 0)
                            <form class="form-group" method="post" action="{{ url('/statusUlasan_super') }}">
                                {{ csrf_field() }}
                                <input id="m_statusid" name="m_statusid" type="hidden" value="{{$data->id}}">
                                <input name="n_status" type="hidden" value="1">
                                <button class="btn btn-icon btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Moderasi"> <i class="fa fa-ban"></i> </button>
                            </form>

                            <form class="form-group" method="post" action="{{ url('/statusUlasan_super') }}">
                                {{ csrf_field() }}
                                <input id="m_statusid" name="m_statusid" type="hidden" value="{{$data->id}}">
                                <input name="n_status" type="hidden" value="2">
                                <button class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Hapus"> <i class="fa fa-trash"></i> </button>
                            </form>

                            @elseif ($data->hapus == 1)
                            <form class="form-group" method="post" action="{{ url('/statusUlasan_super') }}">
                                {{ csrf_field() }}
                                <input id="m_statusid" name="m_statusid" type="hidden" value="{{$data->id}}">
                                <input name="n_status" type="hidden" value="0">
                                <button class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Aktifkan"> <i class="fa fa-check"></i> </button>
                            </form>

                            @else
                            <form class="form-group" method="post" action="{{ url('/statusUlasan_super') }}">
                                {{ csrf_field() }}
                                <input id="m_statusid" name="m_statusid" type="hidden" value="{{$data->id}}">
                                <input name="n_status" type="hidden" value="0">
                                <button class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Aktifkan"> <i class="fa fa-check"></i> </button>
                            </form>

                            <button class="btn btn-icon btn-grey" data-toggle="modal" data-target="#editFasKesModal{{$i}}"> <i class="fa fa-edit"></i></button>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection