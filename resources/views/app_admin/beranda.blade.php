@extends('layouts.app_admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">Beranda</li>
        </ol>

        @if(Auth::user()->akses == 0)
        <div class="card-box widget-inline">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="widget-inline-box text-center">
                        <h3><i class="text-info fa fa-user"></i> <b data-plugin="counterup">{{ $totalOwner }}</b></h3>
                        <p class="text-muted">Total Owner</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="widget-inline-box text-center">
                        <h3><i class="text-warning fa fa-user-md"></i> <b data-plugin="counterup">{{ $totalDokter }}</b></h3>
                        <p class="text-muted">Dokter Terdaftar</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="widget-inline-box text-center">
                        <h3><i class="text-custom fa fa-hospital-o"></i> <b data-plugin="counterup">{{ $totalAktifFaskes }}</b></h3>
                        <p class="text-muted">Lokasi Aktif</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="widget-inline-box text-center b-0">
                        <h3><i class="text-danger fa fa-hospital-o"></i> <b data-plugin="counterup">{{ $totalFaskesBelumAktif }}</b></h3>
                        <p class="text-muted">Lokasi Belum Terverifikasi</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <h4 class="header-title">Lokasi Pelayanan Kesehatan</h4>
        @endif

        <div class="m-b-20">
            <div id="googleMaps" class="gmaps"></div>
        </div>
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
        @if(Auth::user()->akses == 0)
        ['{{$data->nama_tempat}}', {{$data->latitude}}, {{$data->longitude}}],
        @elseif($data->users_id == Auth::user()->id)
        ['{{$data->nama_tempat}}', {{$data->latitude}}, {{$data->longitude}}],
        @endif
        @endforeach
        ];

        // Info Content
        var infoWindowContent = [
        @foreach($faskes as $data)
        @if(Auth::user()->akses == 0) [
        '<div class="content">' +
        '<h4> {{$data->nama_tempat}} </h4>' +
        '<p style="line-height:15px;">{{$data->alamat}} <br>' +
        'Kontak: {{$data->telepon}} dan '+
        'buka hari: {{$data->hari_buka}} - {{$data->hari_tutup}} ' +
        'dari jam: {{$data->jam_buka}} - {{$data->jam_tutup}} </p> </div>'],
        @elseif($data->users_id == Auth::user()->id) [
        '<div class="content">' +
        '<h4> {{$data->nama_tempat}} </h4>' +
        '<p style="line-height:15px;">{{$data->alamat}} <br>' +
        'Kontak: {{$data->telepon}} dan '+
        'buka hari: {{$data->hari_buka}} - {{$data->hari_tutup}} ' +
        'dari jam: {{$data->jam_buka}} - {{$data->jam_tutup}} </p> </div>'],
        @endif
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=KEY&callback=initMap"></script>
<script src="{{ asset('plugins/gmaps/gmaps.js') }}"></script>
@endsection