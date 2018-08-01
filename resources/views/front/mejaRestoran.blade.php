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

            @if( (strtotime($info->jam_buka) <= $now) && (strtotime($info->jam_tutup) >= $now) && (in_array($days,json_decode($info->hari_buka, true))) )
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
              <a class="item" href="{{ url("restoran/".$id) }}">
                Lokasi
              </a>
              <a class="item" href="{{ url("restoran/galeri/".$id) }}">
                Galeri
              </a>
              <a class="item" href="{{ url("restoran/menu/".$id) }}">
                Menu
              </a>
              <a class="item active" >
                Meja
              </a>
            </div>
            <div class="ui attached segment">
              <div class="ui four stackable cards">

                @foreach($meja as $a)
                  <div class="card">

                    <div class="content">
                      @if($a->status)
                        <a class="ui red ribbon label">Diisi</a>
                      @else
                        <a class="ui green ribbon label">Kosong</a>
                      @endif
                      <div class="header">
                        {{$a->nama_meja}}
                      </div>
                      <div class="meta">
                        Kapasitas: {{$a->kapasitas}} orang
                      </div>
                      <div class="description">
                        {{$a->keterangan}}
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            </div>
          </div>

        </div>

    </div>

  </div>
@stop
