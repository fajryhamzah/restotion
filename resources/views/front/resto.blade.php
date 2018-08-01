@extends("layout.index")
@section("content")
  @include("layout.menu")
  <div class="ui grid">
    <div class="ui row container">
      <div class="ui five column grid">

        @foreach($resto as $a)
          <div class="column">
            <div class="ui fluid card">
              <div class="image">
                <img src="{{ asset("restoran/".md5($a->id_restoran)."/logo.png") }}">
              </div>
              <div class="content">
                <a class="header" href="{{ url("restoran/".$a->id_restoran) }}">{{$a->nama_restoran}}</a>
              </div>
            </div>
          </div>
        @endforeach

        </div>
    </div>
    <div class="ui row container">
      {{ $resto->links() }}

    </div>
  </div>
@stop



@section("bottom_include")
<script type="text/javascript">
  $(document).ready(function(){
    $(".pagination").addClass("ui menu")
    $(".page-item").addClass("item");
  });
</script>
@stop
