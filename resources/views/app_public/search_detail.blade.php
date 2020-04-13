@extends('layouts.app_public')

@section('topics')
<div class="breadcrumbs">
    <div class="container">
        <ol>
            <li>Home</li>
            <li class="active">Search Detail</li>
        </ol>
    </div>
</div>
<section class="topics">
    <div class="container">
        <div class="row">
            @foreach($data_search as $data)
            <div class="col-lg-4">
                <div class="widget widget_categories">
                    <span class="icon icon-data"></span>
                    <h4 style="text-transform: capitalize; padding-bottom: 20px;"><b>{{ $data->nama_tempat }}</b></h4>

                    <header><h5>Layanan:</h5></header>
                    <ul>
                        @forelse($layanan_search as $dataLayanan)
                        @foreach($layanan as $allLayanan)
                        @if($dataLayanan->layanan_id == $allLayanan->id)
                        <li><a>{{ $allLayanan->nama_layanan }}</a></li>
                        @endif
                        @endforeach
                        @empty
                        <li><a>Data Layanan Kosong</a></li>
                        @endforelse
                    </ul>
                    <br>
                    <header><h5>Asuransi:</h5></header>
                    <ul>
                        @forelse($asuransi_search as $dataAsuransi)
                        @foreach($asuransi as $allAsuransi)
                        @if($dataAsuransi->asuransi_id == $allAsuransi->id)
                        <li>
                            <a>{{ $allAsuransi->nama_asuransi }}</a>
                            <span data-toggle="tooltip" data-placement="right" data-original-title="{{ $allAsuransi->keterangan }}">
                                <img src="{{ asset('images/icon/info.svg') }}" alt="" width="12">
                            </span>
                        </li>
                        @endif
                        @endforeach
                        @empty
                        <li><a>Data Asuransi Kosong</a></li>
                        @endforelse
                    </ul>
                    <br>
                    <header><h5>Peralatan:</h5></header>
                    <ul>
                        @forelse($peralatan_search as $dataPeralatan)
                        @foreach($peralatan as $allPeralatan)
                        @if($dataPeralatan->peralatan_id == $allPeralatan->id)
                        <li>
                            <a>{{ $allPeralatan->nama_peralatan }}</a>
                            <span data-toggle="tooltip" data-placement="right" data-original-title="{{ $dataPeralatan->keterangan }}">
                                <img src="{{ asset('images/icon/info.svg') }}" alt="" width="12">
                            </span>
                        </li>
                        @endif
                        @endforeach
                        @empty
                        <li><a>Data Peralatan Kosong</a></li>
                        @endforelse
                    </ul>
                    <br>
                    <header><h5>Dokter:</h5></header>
                    <ul>
                        @php $checkForDoctor = false; @endphp
                        @foreach($dokter as $allDokter)
                        @if($allDokter->faskes_id == $data->id)
                        @php $checkForDoctor = true; @endphp
                        <li><a>{{ $allDokter->nama_dokter }}</a>
                            <span data-toggle="tooltip" data-placement="right" data-original-title="
                            @foreach($dokter_search as $dataDokter)
                            @foreach($penyakit as $allPenyakit)
                            @if($dataDokter->dokter_id == $allDokter->id && $dataDokter->penyakit_id == $allPenyakit->id)
                            {{ $allPenyakit->nama_penyakit }}.
                            @endif
                            @endforeach
                            @endforeach"><img src="{{ asset('images/icon/info.svg') }}" alt="" width="12"></span>
                        </li>
                        @endif
                        @endforeach
                        @if(!$checkForDoctor)
                        <li><a>Data Dokter Kosong</a></li>
                        @endif
                    </ul>
                </div>

                <div style="margin-top: 20px; padding-bottom: 40px;">
                    <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahUlasan" style="width: 100%;">Berikan Ulasan</a>
                </div>

                <!-- Modal -->
                <div id="tambahUlasan" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <form role="form" method="POST" action="{{ URL::to('/insertUlasan') }}" class="form-validation topics-list">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Memberikan Ulasan</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <input type="hidden" name="m_idnamatempat" id="m_idnamatempat" value="{{ $data->id }}">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Nama Tempat<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" value="{{ $data->nama_tempat }}" required disabled="true">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Nama Anda<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="m_namapengguna" id="m_namapengguna" placeholder="Nama Lengkap" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Ulasan<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="m_ulasan" id="m_ulasan" rows="5" maxlength="255" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Kenyamanan Tempat<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" type="text" name="m_ratingfaskes" id="m_ratingfaskes" required>
                                                        <option value="1">★</option>
                                                        <option value="2">★★</option>
                                                        <option value="3">★★★</option>
                                                        <option value="4">★★★★</option>
                                                        <option value="5">★★★★★</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">Layanan Kesehatan<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" type="text" name="m_ratinglayanan" id="m_ratinglayanan" required>
                                                        <option value="1">★</option>
                                                        <option value="2">★★</option>
                                                        <option value="3">★★★</option>
                                                        <option value="4">★★★★</option>
                                                        <option value="5">★★★★★</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                    <input type="submit" class="btn btn-primary waves-effect waves-light" value="Ulas">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal -->
            </div>

            <div class="col-lg-8">
                <div class="widget widget_categories" style="padding: 10px;">
                    <div class="m-b-20">
                        <div id="googleMaps" class="gmaps gmaps-tiny"></div>
                    </div>
                </div>

                <div class="widget widget_categories">
                    <h4><b>{{ $data->nama_tempat }}</b></h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <h5><b>Alamat</b></h5>
                            <p>{{ $data->alamat }}</p>
                        </div>

                        <div class="col-lg-3">
                            <h5><b>Telepon</b></h5>
                            <p>{{ $data->telepon }}</p>
                        </div>

                        <div class="col-lg-3">
                            <h5><b>Jam Buka - Tutup</b></h5>
                            <p>{{ $data->jam_buka }} - {{ $data->jam_tutup }}</p>
                            <br>
                            <h5><b>Hari Buka - Tutup</b></h5>
                            <p>{{ $data->hari_buka }} - {{ $data->hari_tutup }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <h4><b>Deskripsi</b></h4>
                            <p>{{ $data->deskripsi }}</p>
                        </div>
                    </div>
                </div>

                <div class="widget" style="padding-top: 10px">
                    <table id="datatable-ulasan" class="table table-responsive">
                        <thead>
                            <tr>
                                <th><h4><b>Ringkasan Ulasan</b></h4></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ulasan_search as $dataUlasan)
                            @if($dataUlasan->faskes_id == $data->id)
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <h5><p>Dari: {{ $dataUlasan->nama_pengguna }}</p></h5>
                                        </div>
                                        <div class="col-lg-3">
                                            <small><p class="pull-right">{{ date($dataUlasan->updated_at) }}</p></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <p><small>{{ $dataUlasan->ulasan }}</small></p>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <span class="badge">Kenyamanan Tempat</span>
                                                </div>
                                                <div class="col-lg-5">
                                                    <p>
                                                        @if($dataUlasan->rating_faskes == 5)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>

                                                        @elseif($dataUlasan->rating_faskes == 4)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star unchecked"></span>

                                                        @elseif($dataUlasan->rating_faskes == 3)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>

                                                        @elseif($dataUlasan->rating_faskes == 2)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>

                                                        @elseif($dataUlasan->rating_faskes == 1)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>

                                                        @elseif($dataUlasan->rating_faskes == 0)
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <span class="badge">Layanan Kesehatan</span>
                                                </div>
                                                <div class="col-lg-5">
                                                    <p>
                                                        @if($dataUlasan->rating_layanan == 5)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>

                                                        @elseif($dataUlasan->rating_layanan == 4)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star unchecked"></span>

                                                        @elseif($dataUlasan->rating_layanan == 3)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>

                                                        @elseif($dataUlasan->rating_layanan == 2)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>

                                                        @elseif($dataUlasan->rating_layanan == 1)
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>

                                                        @elseif($dataUlasan->rating_layanan == 0)
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        <span class="fa fa-star unchecked"></span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
	function initMap() {
		var map;
		var bounds = new google.maps.LatLngBounds();
		var mapOptions = {
			mapTypeId: 'roadmap'
		};

        map = new google.maps.Map(document.getElementById("googleMaps"), mapOptions);
        map.setTilt(50);

        // Markers Lokasi
        var markers = [
        @foreach($data_search as $data)
        ['{{$data->nama_tempat}}', {{$data->latitude}}, {{$data->longitude}}],
        @endforeach
        ];

        // Info Content
        var infoWindowContent = [
        @foreach($data_search as $data) [
        '<div class="content">' +
        '<h4> {{$data->nama_tempat}} </h4>' +
        '<p style="line-height:15px;">{{$data->alamat}} <br>' +
        'Kontak: {{$data->telepon}} dan '+
        'buka hari: {{$data->hari_buka}} - {{$data->hari_tutup}} ' +
        'dari jam: {{$data->jam_buka}} - {{$data->jam_tutup}} </p> </div>'],
        @endforeach
        ];

        var infoWindow = new google.maps.InfoWindow(), marker, i;

        for (i = 0; i < markers.length; i++) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: "{{ asset('images/icon/marker.png') }}",
                animation: google.maps.Animation.BOUNCE,
                title: markers[i][0]
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            map.fitBounds(bounds);
        }

        // Zoom level
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
        	this.setZoom(17);
        	google.maps.event.removeListener(boundsListener);
        });
        google.maps.event.trigger(map, "resize");

        google.maps.event.addDomListener(window, 'load', initMap);
    }
</script>
@endsection

@section('script_content')
<script src="https://maps.googleapis.com/maps/api/js?key=KEY&callback=initMap"></script>
<script src="{{ asset('plugins/gmaps/gmaps.js') }}"></script>
@endsection