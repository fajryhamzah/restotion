@extends("layout.index")

@section("content")
  @include("layout.menuDashboard")
  <div class="ui container">
    <div class="ui padded grid">
      <div class="row">
        @include("restaurant.menu")

        <div class="ten wide column">
          <h3 class="ui top attached header">
            Edit Menu
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
                  <div class="fields">
                    <div class="inline field">
                      <label>Nama Menu</label>
                      <input placeholder="Nama Menu" value="{{ $info->nama_menu }}" name="nama" type="text" required>
                    </div>

                    <div class="inline field">
                      <label>Harga</label>
                      <div class="ui right labeled input">
                        <label for="amount" class="ui label">Rp.</label>
                        <input min="0" placeholder="Harga" type="number" name="harga" value="{{ $info->harga }}">
                        <div class="ui basic label">.00</div>
                      </div>
                    </div>
                  </div>

                  <div class="inline fields">
                    <label for="tipe">Jenis menu:</label>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input name="tipe" {{ ($info->tipe == "Appetizer")?  'checked=checked':""}} value="Appetizer" type="radio" >
                        <label>Appetizer</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input name="tipe" type="radio" value="Main Dishes" {{ ($info->tipe == "Main Dishes")?  'checked=checked':""}}>
                        <label>Main Dishes</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input name="tipe" type="radio" value="Drinks" {{ ($info->tipe == "Drinks")?  'checked=checked':""}}>
                        <label>Drink</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input name="tipe" type="radio" value="Desserts" {{ ($info->tipe == "Desserts")?  'checked=checked':""}}>
                        <label>Dessert</label>
                      </div>
                    </div>
                  </div>

                  <div class="field">
                    <label>Detail Menu</label>
                    <textarea rows="2" name="detail" placeholder="Deskripsi menu" maxlength="60">{{ $info->detail_menu }}</textarea>
                  </div>

                  <div class="inline field">
                    <label>Gambar Menu</label>
                    <input type="file" name="gambar" style="border:0"/>
                  </div>

                  <div class="field">
                    <div class="ui small image">
                      <img src="{{ $image.$info->image }}">
                    </div>
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
@stop
