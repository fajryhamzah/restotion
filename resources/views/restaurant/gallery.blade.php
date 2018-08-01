@extends("layout.index")

@section("content")
  @include("layout.menuDashboard")
  <div class="ui mini modal">
  <div class="header">Yakin?</div>
  <div class="content">
    <p>Apakah anda yakin ingin menghapus gambar ini?</p>
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
            Galeri Restoran
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

            <div class="ui form column">
              <form method="post" enctype="multipart/form-data">
                  <div class="inline field">
                    <label>Upload gambar restoran</label>
                    <input type="file" name="image[]" style="border:0"  multiple/>
                    {{ csrf_field() }}
                    <button class="positive ui button" type="submit">Tambah</button>
                  </div>
              </form>
            </div>
              <div class="ui three stackable cards">
                @foreach($img as $im)
                  <div class="card">
                    <div class="ui move up masked reveal image full">
                      <img src="{{ asset("restoran/".$id_hash."/".$im->link) }}" class="visible content">
                      <div class="hidden content center aligned full">
                        <button class="ui negative labeled icon button del" data-link="{{ url("dashboard/gallery/".$id."/delete/".$im->id_image) }}">
                          <i class="trash icon"></i>
                          Delete
                        </button>
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
@stop

@section("bottom_include")
<script type="text/javascript">
  $(document).ready(function(){
    $(".del").on("click",function(){
      $("#link").attr("href",$(this).data("link"));
      $('.ui.mini.modal').modal('show');
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


</style>
@stop
