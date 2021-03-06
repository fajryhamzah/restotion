@extends("layout.index")

@section("content")
  @include("layout.menuDashboard")
  <div class="ui container">
    <div class="ui padded grid">
      <div class="row">
        <div class="sixteen wide column">
          <h3 class="ui top attached header">
            Tambah Restoran
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
              <form method="post" enctype="multipart/form-data">
                <div class="ui form">

                  <div class="field">
                    <label>Nama Restoran</label>
                    <input placeholder="Nama restoran" value="{{old('nama')}}" name="nama" type="text" required>
                  </div>

                  <div class="fields">
                    <div class="ui field calendar" id="jam_buka">
                      <label>Jam Buka</label>
                      <div class="ui input left icon">
                        <i class="time icon"></i>
                        <input type="text" placeholder="Time"  name="jam_buka">
                      </div>
                    </div>

                    <div class="ui field calendar" id="jam_tutup">
                      <label>Jam Tutup</label>
                      <div class="ui input left icon">
                        <i class="time icon"></i>
                        <input type="text" placeholder="Time" name="jam_tutup">
                      </div>
                    </div>
                  </div>

                  <div class="field">
                    <label>Hari Buka</label>
                    <select multiple="" class="ui dropdown" name="hari[]">
                      <option value="">Pilih hari apa saja anda buka</option>
                      <option value="1">Senin</option>
                      <option value="2">Selasa</option>
                      <option value="3">Rabu</option>
                      <option value="4">Kamis</option>
                      <option value="5">Jumat</option>
                      <option value="6">Sabtu</option>
                      <option value="7">Minggu</option>
                    </select>
                  </div>

                  <div class="field">
                    <label>Upload Logo</label>
                    <input type="file" name="logo" style="border:0"/>
                  </div>

                  <div class="field">
                    <label>Upload gambar restoran</label>
                    <input type="file" name="image[]" style="border:0"  multiple/>
                  </div>


                  <div class="field">
                    <label>Detail Restoran</label>
                    <textarea rows="3" name="detail" placeholder="ceritakan tentang restoran anda">{{old('detail')}}</textarea>
                  </div>
                  <div class="field">
                    <label>Lokasi Restoran</label>
                    <input id="pac-input" class="controls" type="text" placeholder="Cari lokasi restoran anda">
                    <div id="map">
                    </div>
                  </div>
                  {{ csrf_field() }}
                  <input type="hidden" name="lng" id="lng"/>
                  <input type="hidden" name="lat" id="lat"/>
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
          center: {lat: -6.914744, lng: 107.609810},
          disableDefaultUI: true, // a way to quickly hide all controls
          zoom: 17,
          gestureHandling: 'greedy'
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
