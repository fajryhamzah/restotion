@extends("layout.index")

@section("content")
  @include("layout.menuDashboard")
  <div class="ui container">
    <div class="ui padded grid">
      <div class="row">
        @include("restaurant.menu")
        <div class="ten wide column">
          <h3 class="ui top attached header">
            Tambah Meja
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
              <form method="post">
                <div class="ui form">
                  <div class="fields">
                    <div class="inline field">
                      <label>Nama Meja</label>
                      <input placeholder="Nama Meja" value="{{old('nama')}}" name="nama" type="text" required>
                    </div>
                    <div class="inline field">
                      <label>Kapasitas</label>
                      <div class="ui right labeled input">
                        <label for="amount" class="ui label">Jumlah</label>
                        <input min="0" placeholder="Kapasitas" type="number" name="kapasitas" value="{{ old('kapasitas') }}">
                        <div class="ui basic label"> Orang</div>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label>Detail Meja</label>
                    <textarea rows="2" name="detail" placeholder="Deskripsi meja">{{old('detail')}}</textarea>
                  </div>
                  {{ csrf_field() }}
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
  });
</script>
@stop
