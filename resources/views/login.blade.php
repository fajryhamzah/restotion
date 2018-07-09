{{ \Session::get("error") }}
<form method="post">
  username : <input type="text" name="username" value="{{old('username')}}" required/><br />
  password : <input type="password" name="password" required/><br />
  {{ csrf_field() }}
  <button type="submit">Login</button>
</form>
