@extends("layout.index")

@section("content")
  @include("layout.menu")
  <div class="ui container">
    <div class="ui two column centered grid">
      <div class="one column">
        <h1>Register</h1>
        <div class="ui divider"></div>
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
              <input name="username" name="username" value="{{old('username')}}" placeholder="Username" type="text" required>
            </div>
            <div class="field">
              <label>Password</label>
              <input name="password" placeholder="Password" type="password" required>
            </div>
            <div class="field">
              <label>Password Konfirmasi</label>
              <input name="password1" placeholder="Password" type="password" required>
            </div>
            <div class="field">
              <label>Email</label>
              <input name="email" placeholder="Password" type="email" value="{{old('email')}}" required>
            </div>
            <div class="field">
              <label>Display Name</label>
              <input type="text" name="name" value="{{old('name')}}" required>
            </div>
            {{ csrf_field() }}
            <div class="field ui buttons">
              <button class="ui positive button" type="submit">Daftar</button>
              <div class="or"></div>
              <a href="{{ url('/login') }}"><button class="ui button" type="button">Log In</button></a>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
@stop
