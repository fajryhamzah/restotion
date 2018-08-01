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
              <a class="item active">
                Menu
              </a>
              <a class="item" href="{{ url("restoran/meja/".$id) }}">
                Meja
              </a>
            </div>
            <div class="ui attached segment">
              <div class="ui grid">
                <div class="four wide column">
                  <div class="ui vertical fluid tabular menu">
                    <a class="active item" data-tab="appe">
                      Appetizer
                    </a>
                    <a class="item" data-tab="mai">
                      Main Dishes
                    </a>
                    <a class="item" data-tab="drink">
                      Drinks
                    </a>
                    <a class="item" data-tab="des">
                      Desserts
                    </a>
                  </div>
                </div>
                <div class="twelve wide stretched column">
                  <div class="ui tab active segment" data-tab="appe">
                      <div class="ui items">
                        @foreach($menu as $mn)
                          <div class="item">
                            <div class="image">
                              <img src="{{ asset('restoran/'.md5($id).'/menu/'.$mn->image) }}">
                            </div>
                            <div class="content">
                              <a class="header">{{ $mn->nama_menu }}</a>
                              <div class="meta">
                                <span>Rp.{{ number_format($mn->harga,0,",",".") }}</span>
                              </div>
                              <div class="description">
                                <p>{{ $mn->detail_menu }}</p>
                              </div>
                            </div>
                          </div>
                        @endforeach
                    </div>
                </div>

                <div class="ui tab segment" data-tab="mai">
                    <div class="ui  tab items">
                      @foreach($mna as $mn)
                        <div class="item">
                          <div class="image">
                            <img src="{{ asset('restoran/'.md5($id).'/menu/'.$mn->image) }}">
                          </div>
                          <div class="content">
                            <a class="header">{{ $mn->nama_menu }}</a>
                            <div class="meta">
                              <span>Rp.{{ number_format($mn->harga,0,",",".") }}</span>
                            </div>
                            <div class="description">
                              <p>{{ $mn->detail_menu }}</p>
                            </div>
                          </div>
                        </div>
                      @endforeach
                  </div>
              </div>

              <div class="ui tab segment" data-tab="drink">

                  <div class="ui tab items">

                    @foreach($dr as $mn)
                      <div class="item">
                        <div class="image">
                          <img src="{{ asset('restoran/'.md5($mn->id_restoran).'/menu/'.$mn->image) }}">
                        </div>
                        <div class="content">
                          <a class="header">{{ $mn->nama_menu }}</a>
                          <div class="meta">
                            <span>Rp.{{ number_format($mn->harga,0,",",".") }}</span>
                          </div>
                          <div class="description">
                            <p>{{ $mn->detail_menu }}</p>
                          </div>
                        </div>
                      </div>
                    @endforeach

                </div>

            </div>

            <div class="ui tab segment" data-tab="des">
                <div class="ui items">
                  @foreach($ds as $mn)
                    <div class="item">
                      <div class="image">
                        <img src="{{ asset('restoran/'.md5($id).'/menu/'.$mn->image) }}">
                      </div>
                      <div class="content">
                        <a class="header">{{ $mn->nama_menu }}</a>
                        <div class="meta">
                          <span>Rp.{{ number_format($mn->harga,0,",",".") }}</span>
                        </div>
                        <div class="description">
                          <p>{{ $mn->detail_menu }}</p>
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

    </div>

  </div>
@stop

@section("bottom_include")
<script type="text/javascript">
$(document).ready(function(){
  $('.menu .item')
  .tab();

});
</script>
@stop
