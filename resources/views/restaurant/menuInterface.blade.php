@extends("layout.index")

@section("content")
  @include("layout.menuDashboard")
  <div class="ui mini modal">
    <div class="header">Yakin?</div>
    <div class="content">
      <p>Apakah anda yakin ingin menghapus menu <span id="nares"></span>?</p>
    </div>
    <div class="actions">
      <div class="ui red basic cancel inverted button">
        <i class="remove icon"></i>
        Tidak
      </div>
      <a id="link" href="#">
        <div class="ui green ok inverted button">
          <i class="checkmark icon"></i>
          Ya
        </div>
      </a>
    </div>
  </div>
  <div class="ui container">
    <div class="ui padded grid">
      <div class="row">
        @include("restaurant.menu")

        <div class="twelve wide column">
          <h3 class="ui top attached header">
            Menu Restoran
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
              </div>
              </ul>
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

            <a href="{{url("dashboard/menu/add/".$id)}}">
              <button class="ui labeled icon positive button">
                <i class="plus icon"></i>
                Tambah
              </button>
            </a>

            <div class="ui tabular menu">
              <a class="active item" data-tab="appetizer">
                Appetizer
              </a>
              <a class="item" data-tab="main">
                Main Dishes
              </a>
              <a class="item" data-tab="drink">
                Drinks
              </a>
              <a class="item" data-tab="dessert">
                Desserts
              </a>
            </div>
            <div class="ui tab active" data-tab="appetizer">
              <div class="ui items">
                @if($appetizer->count() < 1)
                  <span>Belum ada data</span>
                @endif
                @foreach($appetizer as $a)
                  <div class="item">
                    <div class="ui small image">
                      <img src="{{$image.$a->image}}">
                    </div>
                    <div class="content">
                      <div class="header">{{$a->nama_menu}}</div>
                      <div class="meta">
                        <span class="price">Rp. {{number_format($a->harga,0,".",",")}}</span>

                      </div>
                      <div class="description">
                        <p>{{ $a->detail_menu }}</p>
                      </div>
                    </div>
                    <div class="actions">
                      <a href="{{ url("dashboard/menu/".$id."/edit/".$a->id_menu)}}">
                        <button class="ui circular twitter icon button">
                          <i class="pencil alternate icon"></i>
                        </button>
                      </a>
                      <a class="del" data-nama="{{$a->nama_menu}}" data-link="{{ url("dashboard/menu/".$id."/delete/".$a->id_menu)}}">
                        <button class="ui circular google plus icon button">
                          <i class="trash alternate icon"></i>
                        </button>
                      </a>
                    </div>
                  </div>
                @endforeach
                {{ $appetizer->links() }}
              </div>
            </div>
            <div class="ui tab" data-tab="main">
              <div class="ui items">
                @if($main->count() < 1)
                  <span>Belum ada data</span>
                @endif
                @foreach($main as $a)
                  <div class="item">
                    <div class="ui small image">
                      <img src="{{$image.$a->image}}">
                    </div>
                    <div class="content">
                      <div class="header">{{$a->nama_menu}}</div>
                      <div class="meta">
                        <span class="price">Rp. {{number_format($a->harga,0,".",",")}}</span>

                      </div>
                      <div class="description">
                        <p>{{ $a->detail_menu }}</p>
                      </div>
                    </div>
                    <div class="actions">
                      <a href="{{ url("dashboard/menu/".$id."/edit/".$a->id_menu)}}">
                        <button class="ui circular twitter icon button">
                          <i class="pencil alternate icon"></i>
                        </button>
                      </a>
                      <a class="del" data-nama="{{$a->nama_menu}}" data-link="{{ url("dashboard/menu/".$id."/delete/".$a->id_menu)}}">
                        <button class="ui circular google plus icon button">
                          <i class="trash alternate icon"></i>
                        </button>
                      </a>
                    </div>
                  </div>
                @endforeach
                {{ $main->links() }}
              </div>
            </div>
            <div class="ui tab" data-tab="drink">
              <div class="ui items">
                @if($drink->count() < 1)
                  <span>Belum ada data</span>
                @endif
                @foreach($drink as $a)
                  <div class="item">
                    <div class="ui small image">
                      <img src="{{$image.$a->image}}">
                    </div>
                    <div class="content">
                      <div class="header">{{$a->nama_menu}}</div>
                      <div class="meta">
                        <span class="price">Rp. {{number_format($a->harga,0,".",",")}}</span>

                      </div>
                      <div class="description">
                        <p>{{ $a->detail_menu }}</p>
                      </div>
                    </div>
                    <div class="actions">
                      <a href="{{ url("dashboard/menu/".$id."/edit/".$a->id_menu)}}">
                        <button class="ui circular twitter icon button">
                          <i class="pencil alternate icon"></i>
                        </button>
                      </a>
                      <a class="del" data-nama="{{$a->nama_menu}}" data-link="{{ url("dashboard/menu/".$id."/delete/".$a->id_menu)}}">
                        <button class="ui circular google plus icon button">
                          <i class="trash alternate icon"></i>
                        </button>
                      </a>
                    </div>
                  </div>
                @endforeach
                {{ $drink->links() }}
              </div>
            </div>
            <div class="ui tab" data-tab="dessert">
              <div class="ui items">
                @if($dessert->count() < 1)
                  <span>Belum ada data</span>
                @endif
                @foreach($dessert as $a)
                  <div class="item">
                    <div class="ui small image">
                      <img src="{{$image.$a->image}}">
                    </div>
                    <div class="content">
                      <div class="header">{{$a->nama_menu}}</div>
                      <div class="meta">
                        <span class="price">Rp. {{number_format($a->harga,0,".",",")}}</span>

                      </div>
                      <div class="description">
                        <p>{{ $a->detail_menu }}</p>
                      </div>
                    </div>
                    <div class="actions">
                      <a href="{{ url("dashboard/menu/".$id."/edit/".$a->id_menu)}}">
                        <button class="ui circular twitter icon button">
                          <i class="pencil alternate icon"></i>
                        </button>
                      </a>
                      <a class="del" data-nama="{{$a->nama_menu}}" data-link="{{ url("dashboard/menu/".$id."/delete/".$a->id_menu)}}">
                        <button class="ui circular google plus icon button">
                          <i class="trash alternate icon"></i>
                        </button>
                      </a>
                    </div>
                  </div>
                @endforeach
                {{ $dessert->links() }}
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
    $('.tabular.menu .item').tab();

    $(".pagination").addClass("ui menu")
    $(".page-item").addClass("item")
    $(".del").on("click",function(){
      $("#link").attr("href",$(this).data("link"));
      $("#nares").html($(this).data("nama"));
      $('.ui.mini.modal').modal('show');
    });
    $('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })
;
  });
</script>
@stop

@section("top_include")
<style>
  .full, .full img{
    height: 100% !important;
  }

  .full button{
    position: absolute;
    top:40%;
  }

  .del{
    color:#B03060;
  }




</style>
@stop
