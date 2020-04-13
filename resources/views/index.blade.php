@extends('layouts.app_public')

@section('masthead')
<div class="masthead text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Informasi Pelayanan Kesehatan</h1>
                <p class="lead text-muted">Kesehatan selalu tampak berharga setelah kita kehilangannya. Jadi jangan menunggu untuk kehilangannya.</p>
                <form role="form" method="POST" action="{{ URL::to('/search') }}">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="text" name="m_keyword" class="search-field" placeholder="Cari Pelayanan Kesehatan..." required/>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                <button type="button" class="btn-search" data-toggle="modal" data-target="#advancedSearch">Advanced Search</button>
            </div>
            <a href="#googleMaps" class="btn btn-hero"><span class="icon-maps"></span> Google Maps <span class="icon-down"></span></a>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="advancedSearch" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <form role="form" method="POST" action="{{ URL::to('/searchAdvanced') }}" class="form-validation topics-list">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Advanced Search</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="form-group">
                                <label>Pelayanan Kesehatan<span class="text-danger">*</span></label>
                                <input type="text" name="m_keyword" class="form-control search-control" placeholder="Cari Pelayanan Kesehatan..." required/>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Layanan</label>
                                                <select class="select2 form-control" name="m_layanan" id="m_layanan" data-placeholder="Pilih Layanan" style="width:100%">
                                                    <option value="" disabled selected hidden></option>
                                                    @foreach($layanan as $dataLayanan)
                                                    <option value="{{ $dataLayanan->id }}">{{ $dataLayanan->nama_layanan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Asuransi</label>
                                                <select class="select2 form-control" name="m_asuransi" id="m_asuransi" data-placeholder="Pilih Asuransi" style="width:100%">
                                                    <option value="" disabled selected hidden></option>
                                                    @foreach($asuransi as $dataAsuransi)
                                                    <option value="{{ $dataAsuransi->id }}">{{ $dataAsuransi->nama_asuransi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Peralatan</label>
                                                <select class="select2 form-control" name="m_peralatan" id="m_peralatan" data-placeholder="Pilih Peralatan" style="width:100%">
                                                    <option value="" disabled selected hidden></option>
                                                    @foreach($peralatan as $dataPeralatan)
                                                    <option value="{{ $dataPeralatan->id }}">{{ $dataPeralatan->nama_peralatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Jam Buka</label>  
                                                <input class="form-control search-control" type="text" name="m_jambuka" id="m_jambuka" placeholder="07:00"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Jam Tutup</label>
                                                <input class="form-control search-control" type="text" name="m_jamtutup" id="m_jamtutup" placeholder="20:00 "/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Hari Buka</label>
                                                <select class="form-control search-control" type="text" name="m_haribuka" id="m_haribuka">
                                                    <option value="" disabled selected hidden>Pilih Hari Buka</option>
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                    <option value="Minggu">Minggu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Hari Tutup</label>
                                                <select class="form-control search-control" type="text" name="m_haritutup" id="m_haritutup">
                                                    <option value="" disabled selected hidden>Pilih Hari Tutup</option>
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                    <option value="Minggu">Minggu</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pull-right">
                                        <div class="col-lg-12" style="margin-top: 50px">
                                            <label><span class="text-danger">*</span> Required</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-primary waves-effect waves-light" value="Search">
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
@endsection

@section('features')
<section id="features" class="features bgc-light-gray">
    <div class="container ">
        <div class="row features-section">
            <div class="text-center col-sm-4">
                <div class="media-body">
                    <span class="icon"><img src="{{ asset('images/icon/icon1.png') }}" alt=""></span>
                    <h3>Membantu Masyarakat</h3>
                    <p class="text-muted">Dengan adanya sistem Thalamus ini, diharapkan agar masyarakat lebih mudah untuk pencarian pelayanan kesehatan</p>
                </div>
            </div>
            <div class="text-center col-sm-4">
                <div class="media-body">
                    <span class="icon"><img src="{{ asset('images/icon/icon2.png') }}" alt=""></span>
                    <h3>Data Tervalidasi</h3>
                    <p class="text-muted">Data yang ditampilkan sudah melalui proses validasi oleh admin Thalamus</p>
                </div>
            </div>
            <div class="text-center col-sm-4">
                <div class="media-body">
                    <span class="icon"><img src="{{ asset('images/icon/icon3.png') }}" alt=""></span>
                    <h3>Mendukung Pelayanan Kesehatan</h3>
                    <p class="text-muted">Mempermudah para memilik pelayanan kesehatan dalam menyebarluaskan program kesehatan kepada masyarakat</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('topics')
<div class="container" style="margin-bottom: 25px; margin-top: 25px;">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-b-20">
                <div id="googleMaps" class="gmaps"></div>
            </div>
        </div>
        <h6></h6>
    </div>
</div>

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
        @foreach($faskes as $data)
        ['{{$data->nama_tempat}}', {{$data->latitude}}, {{$data->longitude}}],
        @endforeach
        ];

        // Info Content
        var infoWindowContent = [
        @foreach($faskes as $data) [
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
            this.setZoom(14);
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