@extends("layout.index")

@section("content")
  @include("layout.menuDashboard")
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

        <div class="ui form segment">
          <h3>Ganti nama</h3>
          <div class="ui divider"></div>

          <form method="post" name="display">
              <div class="field">
                <label>Display name</label>
                <input type="text" value="{{$profile->name}}" name="name" required/>
              </div>

              <div class="field">
                <label>Email</label>
                <input type="text" value="{{ $profile->email }}" name="email" required/>
              </div>
              {{ csrf_field() }}
              <div class="ui center aligned field segment" style="border:0;box-shadow:none">
                <button class="positive ui button" type="submit" name="display" value="1">Simpan</button>
              </div>
          </form>

          <h3>Ganti Password</h3>
          <div class="ui divider"></div>
          <form method="post" name="change">

              <div class="field">
                <label>Password lama</label>
                <input type="password" name="passwordlama" required/>
              </div>

              <div class="field">
                <label>Password Baru</label>
                <input type="password" name="passwordbaru" required/>
              </div>

              <div class="field">
                <label>Password Baru Konfirmasi</label>
                <input type="password" name="passwordbarukonf" required/>
              </div>

              {{ csrf_field() }}
              <div class="ui center aligned field segment" style="border:0;box-shadow:none">
                <button class="positive ui button" type="submit" name="display" value="0">Ganti</button>
              </div>
          </form>

        </div>

      </div>
    </div>
  </div>
@stop

@section("bottom_include")
  <script type="text/javascript">
    $(document).ready(function(){

    });
  </script>
@stop
