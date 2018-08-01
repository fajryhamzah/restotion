@extends("layout.index")
@section("content")
  @include("layout.menu")
  <div class="ui grid">
      <div class="ui sixteen wide column front">
        <div class="ui clearing segment" id="head">
          <div class="ui text container">
            <div class="ui right floated segment clear_segment" style="max-width:400px">
              <h1>RESTOTION</h1>
              <h3>Sulit cari restoran? Gak tahu menu makanannya? mau dateng tapi takut gak kebagian meja? Cek disini!</h3>

              <a href="{{ url("/register") }}">
                <div class="ui animated fade primary button" tabindex="0">
                  <div class="visible content">Anda pemilik restoran?</div>
                  <div class="hidden content">
                    Daftar disini
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="ui sixteen wide column centered grid front" id="search">
        <div class="five wide centered aligned column">
          <div class="ui form">
            <form method="post">
              <div class="field">
                  <h3><label>CARI RESTORAN</label></h3>
                  <div class="ui icon input">
                    <input placeholder="Search..." type="text" name="cari">
                    <i class="circular search link icon"></i>
                  </div>
                  {{csrf_field()}}
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="ui sixteen wide column grid front" id="new_restoran">
        <h3>Restoran Baru</h3>
        <div class="ui five cards">
          @foreach($new as $a)
            <a href="{{ url("restoran/".$a->id_restoran) }}">
              <div class="ui card">
                <span class="ui fluid image">
                  <img  src="{{ asset("restoran/".md5($a->id_restoran)."/logo.png") }}">
                </span>
                <div class="content">
                  <a class="header" href="{{ url("restoran/".$a->id_restoran) }}">{{$a->nama_restoran}}</a>
                  <div class="meta">
                    @if( (strtotime($a->jam_buka) <= $now) && (strtotime($a->jam_tutup) >= $now) && (in_array($day,json_decode($a->hari_buka, true)) ) )
                      <a class="ui blue ribbon label">Buka</a>
                    @else
                      <a class="ui red ribbon label">Tutup</a>
                    @endif
                  </div>
                </div>
              </div>
            </a>
          @endforeach
        </div>
      </div>

      <div class="ui sixteen wide column grid front" id="new_menu">
        <h3>Menu Baru</h3>
        <div class="ui five cards">
          @foreach($menu as $a)
          <a href="{{ url("restoran/".$a->id_restoran) }}">
            <div class="ui card">
              <span class="ui fluid image">
                <img  src="{{ asset("restoran/".md5($a->id_restoran)."/menu/".$a->image) }}">
              </span>
              <div class="content">
                <span class="header">{{$a->nama_menu}}</span>
                <div class="description">
                    <span class="ui red tag label">Rp.{{number_format($a->harga,0,",",".")}}</span>
                    <span class="ui teal tag label">{{$a->tipe}}</span>
                </div>
              </div>
            </div>
          </a>
          @endforeach
        </div>
      </div>



  </div>

@stop

@section("top_include")
<style>


  .clear_segment{
    border: 0 !important;
    box-shadow: none !important;
    background:none !important;
  }

  #head{
    border: 0;
    box-shadow: none;
    background-image: url("{{ asset('background.jpg')}}");
    background-size: cover;
    width:100%;
    height:100%;
    min-height:400px;
    color:white;
  }

  .front{
    padding:0 !important;
    height: 100%;
    width: 100%;
  }

  #search{
    background-image: url("{{ asset('food.jpg')}}");
    color:white;

  }

  #search,#new_restoran,#new_menu{
    padding:25px !important;
  }
</style>
@stop
