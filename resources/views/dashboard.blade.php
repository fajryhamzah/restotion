@extends("layout.index")

@section("content")
@include("layout.menuDashboard")
  <div class="ui basic modal">
    <div class="ui icon header">
      <i class="archive icon"></i>
      Hapus Restoran
    </div>
    <div class="content">
      <p>Apakah anda yakin ingin menghapus restoran <span id="nares"></span>?</p>
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
    <div class="ui grid">
      <div class="one column">
        <!--<div class="ui breadcrumb">
          <a class="active section">Home</a>
        </div>-->
        @if(\Session::has("error"))
          <div class="ui negative message">
            <i class="close icon"></i>
            <div class="header">
              Oops! terjadi kesalahan:
            </div>
            <p>{{ \Session::get("error") }}</p>
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

        <a href="{{ url("add_restaurant") }}">
          <button class="ui labeled icon positive button">
            <i class="plus icon"></i>
            Tambah
          </button>
        </a>
        <table class="ui celled table">
          <thead>
            <tr>
              <th class="fourteen wide">Restoran</th>
              <th class="two wide">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @if($data->isEmpty())
              <tr>
                <td colspan="2">
                  Anda tidak mempunyai restoran
                </td>
              </tr>
            @else
              @foreach($data as $restoran)
              <tr>
                <td>
                  <h4 class="ui image header">
                    <img src='{{$restoran->logo}}' class="ui mini rounded image">
                    <div class="content">
                      <a href='{{ url('dashboard/'.$restoran->id) }}'>{{$restoran->nama_restoran}}</a>
                    </div>
                </h4></td>
                <td>
                  <a href="#" class="del" data-nama="{{$restoran->nama_restoran}}" data-link="{{ url("/dashboard/delete/".$restoran->id) }}">
                    <div class="ui red button">
                      <i class="trash icon"></i> Delete
                    </div>
                  </a>
                </td>
              </tr>
              @endforeach
            @endif

          </tbody>
        </table>
      </div>
    </div>
  </div>
@stop

@section("bottom_include")
<script type="text/javascript">
  $(document).ready(function(){
    $(".del").on("click",function(){
      $("#nares").html($(this).data("nama"));
      $("#link").attr("href",$(this).data("link"));
      $('.ui.basic.modal').modal('show');
    });
  });
</script>
@stop
