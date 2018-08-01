@extends("layout.index")

@section("content")
  @include("layout.menuDashboard")
  <div class="ui mini modal">
    <div class="header">Yakin?</div>
    <div class="content">
      <p>Apakah anda yakin ingin menghapus meja <span id="nares"></span>?</p>
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
            Meja Restoran
          </h3>

          <div class="ui attached segment seg">
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

            <div class="ui segment" style="border:0;box-shadow:none">
              <a href="{{url("dashboard/meja/add/".$id)}}">
                <button class="ui labeled icon positive button">
                  <i class="plus icon"></i>
                  Tambah
                </button>
              </a>
            </div>

            <div class="ui link four cards">
              @foreach($meja as $a)
                <div class="{{ $color[array_rand($color)] }} card meja {{($a->status==1)? "ijo":""}}" data-id="{{$a->id_meja}}" data-parent="{{$a->id_restoran}}">
                  <div class="content">
                    <div class="header">
                      {{$a->nama_meja}}
                    </div>
                    <div class="meta">
                      Kapasitas: {{$a->kapasitas}} orang
                    </div>
                    <div class="description">
                      @if($a->status)
                        <span class="status">Diisi</span>
                      @else
                        <span class="status">Kosong</span>
                      @endif
                    </div>
                  </div>

                  <div class="extra content">
                    <span class="left floated">
                        <a href="{{ url("dashboard/meja/".$id."/edit/".$a->id_meja) }}">
                          <i class="pencil alternate icon"></i>
                          Edit
                        </a>
                    </span>
                    <span class="right floated">
                      <a class="del" data-nama="{{$a->nama_meja}}" data-link="{{ url("dashboard/meja/".$id."/delete/".$a->id_meja)}}">
                        <i class="trash icon"></i>
                        Delete
                      </a>
                    </span>
                  </div>
                </div>
              @endforeach
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
  });

  $(".meja").on("click",function(){
    var id = $(this).data("id");
    var parent = $(this).data("parent");
    var st = $(this);

    $(".seg").addClass("loading");

    $.ajax({
        url: "{{ url("dashboard/meja/") }}/"+parent+"/status/"+id,
        success: function(result){

          if(result == 1){
            st.addClass("ijo");
            st.find(".status").html("Diisi");
          }
          else if(result == 0){
            st.removeClass("ijo");
            st.find(".status").html("Kosong");
          }
          else{
            alert("NANIIII?");
          }
          $(".seg").removeClass("loading");
      }
    });


  });

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


  .ijo{
    background-color: #2ABB9B !important;
  }

</style>
@stop
