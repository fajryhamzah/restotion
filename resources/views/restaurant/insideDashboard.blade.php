@extends("layout.index")

@section("content")
  @include("layout.menuDashboard")
  <div class="ui container">
    <div class="ui padded grid">
      <div class="row">
        @include("restaurant.menu")

        <div class="twelve wide column">
          <h3 class="ui top attached header">
            Informasi Restoran
          </h3>
          <div class="ui attached segment">
              @if(\Session::has("error"))
                <div class="ui negative message">
                  <i class="close icon"></i>
                  <div class="header">
                    Oops! terjadi kesalahan:
                  </div>
                  <ul class="list">
                    {!! \Session::get("error") !!}
                  </ul>
                </div>
              @endif

              @if(\Session::has("success"))
                <div class="ui positive message">
                  <i class="close icon"></i>
                  <div class="header">
                    Sukses
                  </div>
                  <p>{{ \Session::get("success") }}</p>
                </div>
              @endif

              <form method="post" enctype="multipart/form-data">
                <img class="ui medium centered aligned image" src="{{ $logo }}">

                <div class="ui form">

                  <div class="inline field">
                    <label>Ganti Logo</label>
                    <input type="file" name="logo" style="border:0"/>
                  </div>

                  <div class="inline field">
                    <label>Nama Restoran</label>
                    <input value="{{ $info->nama_restoran }}" name="nama" type="text">
                  </div>

                  <div class="equaly width fields">
                    <div class="ui inline field calendar" id="jam_buka">
                      <label>Jam Buka</label>
                      <div class="ui input left icon">
                        <i class="time icon"></i>
                        <input type="text" placeholder="Time" value="{{ $info->jam_buka }}" name="jam_buka">
                      </div>
                    </div>

                    <div class="ui inline field calendar" id="jam_tutup">
                      <label>Jam Tutup</label>
                      <div class="ui input left icon">
                        <i class="time icon"></i>
                        <input type="text" placeholder="Time" name="jam_tutup" value="{{ $info->jam_tutup }}">
                      </div>
                    </div>
                  </div>

                  <div class="field">
                    <label>Hari Buka</label>
                    <select multiple="" class="ui dropdown" name="hari[]">
                      <option value="1" {{ (in_array(1,$hari))? "selected":"" }}>Senin</option>
                      <option value="2" {{ (in_array(2,$hari))? "selected":"" }}>Selasa</option>
                      <option value="3" {{ (in_array(3,$hari))? "selected":"" }}>Rabu</option>
                      <option value="4" {{ (in_array(4,$hari))? "selected":"" }}>Kamis</option>
                      <option value="5" {{ (in_array(5,$hari))? "selected":"" }}>Jumat</option>
                      <option value="6" {{ (in_array(6,$hari))? "selected":"" }}>Sabtu</option>
                      <option value="7" {{ (in_array(7,$hari))? "selected":"" }}>Minggu</option>
                    </select>
                  </div>



                  <div class="field">
                    <label>Detail Restoran</label>
                    <textarea rows="3" name="detail">{{ $info->detail_restoran }}</textarea>
                  </div>

                  <div class="field">
                    <label>Lokasi Restoran</label>
                    <input id="pac-input" class="controls" type="text" placeholder="Cari lokasi restoran anda">
                    <div id="map">
                    </div>
                  </div>
                  {{ csrf_field() }}
                  <input type="hidden" name="lng" id="lng" value="{{$info->longitude}}"/>
                  <input type="hidden" name="lat" id="lat" value="{{$info->latitude}}"/>

                  <div class="ui center aligned field segment" style="border:0;box-shadow:none">
                    <button class="positive ui button" type="submit">Simpan</button>
                  </div>
                </div>
              </form>
          </div>
        </div>

      </div>
    </div>
  </div>
@stop

@section("bottom_include")
<script type="text/javascript">
  $(document).ready(function(){
    $('select.dropdown').dropdown();
    $('#jam_buka').calendar({
      type: 'time',
      ampm: false,
      endCalendar: $("#jam_tutup"),
    });
    $('#jam_tutup').calendar({
      type: 'time',
      ampm: false,
      startCalendar: $("#jam_buka"),
    });

  });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env("MAP_API_KEY","nothing") }}&libraries=places"></script>
<script>
      var map;
      var lat;
      var long;
      var marker = null;

      //map
      function showLoca(posi){
        lat = posi.coords.latitude;
        long = posi.coords.longitude;
        var myLatlng = new google.maps.LatLng(lat,long);
        setLatLng();
        map.setCenter(myLatlng)
        placeMarker(myLatlng);

      }

        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: {{ $info->latitude }}, lng: {{ $info->longitude }}},
          disableDefaultUI: true, // a way to quickly hide all controls
          zoom: 17,
          gestureHandling: 'greedy'
        });

        var myLatLng = {lat: {{ $info->latitude }}, lng: {{ $info->longitude }}};

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
        });



        // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      if(marker){
        marker.setMap(null);
      }
      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
        }
        // Create a marker for each place.
        placeMarker(place.geometry.location);

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });
      map.fitBounds(bounds);
    });


    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showLoca);
    } else {
        console.log("Geolocation is not supported by this browser.");
    }


    google.maps.event.addListener(map, 'click', function(event) {
      lat = event.latLng.lat();
      long = event.latLng.lng();
      setLatLng();
      placeMarker(event.latLng);
    });

    function placeMarker(location) {
      if(marker) marker.setMap(null);

      lat = location.lat();
      long = location.lng();
      marker = new google.maps.Marker({
          position: location,
          draggable: true,
          animation: google.maps.Animation.DROP,
          map: map
      });
      setLatLng();
    }

function setLatLng(){
document.getElementById("lat").value = lat;
document.getElementById("lng").value = long;
}
</script>

@stop

@section("top_include")
  <link rel="stylesheet" href="{{asset("css/calendar.min.css")}}">
  <script src="{{asset("js/calendar.min.js")}}"></script>
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
        .controls {
          margin-top: 10px;
          border: 1px solid transparent;
          border-radius: 2px 0 0 2px;
          box-sizing: border-box;
          -moz-box-sizing: border-box;
          height: 32px;
          outline: none;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
          background-color: #fff;
          font-family: Roboto;
          font-size: 15px;
          font-weight: 300;
          margin-left: 12px;
          padding: 0 11px 0 13px;
          text-overflow: ellipsis;
          width: 300px;
          margin-top:10px;
        }

        #pac-input:focus {
          border-color: #4d90fe;
        }

        .pac-container {
          font-family: Roboto;
        }

        #type-selector {
          color: #fff;
          background-color: #4d90fe;
          padding: 5px 11px 0px 11px;
        }

        #type-selector label {
          font-family: Roboto;
          font-size: 13px;
          font-weight: 300;
        }
  </style>
@stop
