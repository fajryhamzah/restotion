@extends("layout.index")
@section("content")
  @include("layout.menu")
  <div class="ui grid segment">
    <div class="ui row container">
      <div class="ui horizontal segments" style="border:0;box-shadow:none">
          <div class="ui segment">
            <img class="ui medium rounded image" src="{{ asset("restoran/".md5($info->id_restoran)."/logo.png") }}">
          </div>

          <div class="ui segment">
            <div class="ui divided selection list">
              <a class="item">
                <div class="ui red horizontal label">Nama Restoran</div>
                {{$info->nama_restoran}}
              </a>
              <a class="item">
                <div class="ui purple horizontal label">Jam Buka</div>
                {{ date("H:i", strtotime($info->jam_buka) ) }}
              </a>
              <a class="item">
                <div class="ui olive horizontal label">Jam Tutup</div>
                {{ date("H:i", strtotime($info->jam_tutup) ) }}
              </a>
              <a class="item">
                <div class="ui blue horizontal label">Hari Buka</div>
                @foreach($hari as $a)
                  {{ $days[$a-1] }}
                @endforeach
              </a>
              <div class="ui form">
                <div class="field">
                  <label>Detail Restoran</label>
                  <textarea disabled>{{ $info->detail_restoran }}</textarea>
                </div>
              </div>
            </div>

            @if( (strtotime(ltrim($info->jam_buka,'0')) <= $now) && (strtotime($info->jam_tutup) >= $now) && (in_array($day,json_decode($info->hari_buka, true))) )
              <a class="ui green label">Masih Buka</a>
            @else
              <a class="ui red label">Sudah Tutup</a>
            @endif

          </div>
        </div>
      </div>

        <div class="ui row fluid container">
          <div class="ui fluid segment" style="border:0;box-shadow:none;width:100%">
            <div class="ui top attached menu">
              <a class="item active">
                Lokasi
              </a>
              <a class="item" href="{{ url("restoran/galeri/".$id) }}">
                Galeri
              </a>
              <a class="item" href="{{ url("restoran/menu/".$id) }}">
                Menu
              </a>
              <a class="item" href="{{ url("restoran/meja/".$id) }}">
                Meja
              </a>
            </div>
            <div class="ui attached segment">
              <div id="map">

              </div>
            </div>

            </div>
          </div>

        </div>

    </div>

  </div>
@stop

@section("bottom_include")
<script src="https://maps.googleapis.com/maps/api/js?key={{ env("MAP_API_KEY","nothing") }}&libraries=places"></script>
<script>
      var map;

        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: {{ $info->latitude }}, lng: {{ $info->longitude }} },
          disableDefaultUI: true, // a way to quickly hide all controls
          zoom: 17,
          gestureHandling: 'greedy'
        });

        var myLatLng = {lat: {{ $info->latitude }}, lng: {{ $info->longitude }}};

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
        });


</script>

@stop

@section("top_include")
<style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
          height: 350px;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
          height: 100%;
          margin: 0;
          padding: 0;
        }

  </style>
@stop
