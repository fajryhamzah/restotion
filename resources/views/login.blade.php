@extends("layout.index")

@section("content")
  @include("layout.menu")
  <div class="ui container">
    <div class="ui three column centered grid">
      <div class="one column">

        <div class="ui segment">
          <div class="ui form error">
            <form method="post">
              
              @if(\Session::has("error"))
              <div class="ui error message">
                <div class="header">Error</div>
                <p>{!! \Session::get("error") !!}</p>
              </div>
              @endif

              <div class="field">
                <label>Username</label>
                <input name="uname" placeholder="Username" type="text" required>
              </div>
              <div class="field">
                <label>password</label>
                <input name="password" placeholder="Password" type="password" required>
              </div>
              {{ csrf_field() }}
              <div class="field ui buttons">
                <a href="{{ url('/register') }}"><button type="button" class="ui button">Daftar</button></a>
                <div class="or"></div>
                <button class="ui positive button" type="submit">Log In</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
@stop
