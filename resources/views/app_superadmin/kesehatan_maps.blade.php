@extends('layouts.app_admin')

@section('content')
<div class="row p-t-20">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>Pelayanan Kesehatan</li>
            <li class="active">Google Maps</li>
        </ol>
        <h4 class="header-title">Edit Lokasi Google Maps</h4>
        <div class="row">
            <form role="form" method="POST" action="{{ URL::to('/updateMap_super') }}" class="form-validation topics-list">
                @foreach($data_map as $data)
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="hidden" name="m_idnamatempat" value="{{ $data->id }}">
                <input class="form-control" type="hidden" name="m_latitude" id="m_latitude">
                <input class="form-control" type="hidden" name="m_longitude" id="m_longitude">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <input class="form-control" type="text" value="{{ $data->nama_tempat }}" disabled="true">
                        </div>
                        <div class="btn pull-right">
                            <a href="{{ URL::to('/kesehatan_daftar_super') }}" type="button" class="btn btn-danger waves-effect m-l-5">Kembali</a>
                            <input type="submit" class="btn btn-primary waves-effect waves-light" value="Perbarui">
                        </div>
                    </div>
                </div>
                @endforeach
            </form>
        </div>
        <div class="m-b-20">
            <div id="googleMaps" class="gmaps"></div>
        </div>
    </div>
</div>

<script>
    var marker;

    function taruhMarker(peta, posisiTitik) {
        if(marker) {
            marker.setPosition(posisiTitik);
        }
        else {
            marker = new google.maps.Marker({
                position: posisiTitik,
                map: peta
            });
        }

        document.getElementById("m_latitude").setAttribute('value', posisiTitik.lat());
        document.getElementById("m_longitude").setAttribute('value', posisiTitik.lng());
    }

    function initMap() {
        var propertiPeta = {
            center:new google.maps.LatLng(-7.3188843, 112.7706156),
            zoom: 15,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };

        // Markers Lokasi
        var markers = [
        @foreach($data_map as $data)
        ['{{$data->nama_tempat}}', {{$data->latitude}}, {{$data->longitude}}],
        @endforeach
        ];

        var peta = new google.maps.Map(document.getElementById("googleMaps"), propertiPeta);

        for (i = 0; i < markers.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(markers[i][1], markers[i][2]),
                icon: "{{ asset('images/icon/marker.png') }}",
                map: peta
            });
        }

        google.maps.event.addListener(peta, 'click', function(event) {
            taruhMarker(this, event.latLng);
        });

        google.maps.event.addDomListener(window, 'load', initMap);
    }
</script>
@endsection

@section('script_content')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=KEY&callback=initMap"></script>
<script src="{{ asset('plugins/gmaps/gmaps.js') }}"></script>
@endsection