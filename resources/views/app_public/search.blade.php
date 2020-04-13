@extends('layouts.app_public')

@section('topics')
<div class="breadcrumbs">
    <div class="container">
        <ol>
            <li>Home</li>
            <li class="active">Hasil Pencarian</li>
        </ol>
    </div>
</div>

<section class="topics">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="m-b-20 table-responsive">
                                <table id="datatable-simple" class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Hasil Pencarian</th>
                                            <th style="width:75px;" class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($hasil))
                                        @foreach($hasil as $data => $value)
                                        @if($value[5] == 0 && $value[3] >= 0.65)
                                        <tr>
                                            <td>
                                                <p>
                                                    <b>{{ $value[0] }}</b><br>
                                                    {{ $value[1] }}<br>
                                                    <small><font color="grey">{{ $value[2] }}</font></small>
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                $persen = ($value[3] * 100);
                                                @endphp
                                                <p>
                                                    @if($persen >= 95)
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>

                                                    @elseif($persen < 95 && $persen >= 90)
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon half">★</span>

                                                    @elseif($persen < 90 && $persen >= 80)
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon">★</span>

                                                    @elseif($persen < 80 && $persen >= 70)
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon half">★</span>
                                                    <span class="star-icon">★</span>

                                                    @elseif($persen < 70 && $persen >= 60)
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>

                                                    @elseif($persen < 60 && $persen >= 50)
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon half">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>

                                                    @elseif($persen < 50 && $persen >= 40)
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>

                                                    @elseif($persen < 40 && $persen >= 30)
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon half">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>

                                                    @elseif($persen < 30 && $persen >= 20)
                                                    <span class="star-icon full">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>

                                                    @elseif($persen < 20 && $persen >= 10)
                                                    <span class="star-icon half">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>

                                                    @elseif($persen < 10)
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    <span class="star-icon">★</span>
                                                    @endif
                                                </p>
                                                <p>
                                                    <form class="form-group" method="post" action="{{ url('/search_detail') }}">
                                                        {{ csrf_field() }}
                                                        <input id="m_searchid" name="m_searchid" type="hidden" value="{{ $value[4] }}">
                                                        <button type="submit" class="btn btn-success">Lihat</button>
                                                    </form>
                                                </p>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="widget widget-support-forum">
                        <span class="icon icon-forum"></span>
                        <h4>Anda Pemilik Pelayanan Kesehatan?</h4>
                        <p>Dengan mendaftarkan pelayanan kesehatan milik Anda, Anda juga membantu untuk menunjang kesehatan masyarakat disekitar Anda.</p>
                        <a href="{{ URL::to('/register') }}" class="btn btn-success">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection