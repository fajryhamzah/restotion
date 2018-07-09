{{ \Session::get("error") }}
<form method="post">
  username : <input type="text" name="username" value="{{old('username')}}" required/><br />
  password : <input type="password" name="password" required/><br />
  password confirm : <input type="password" name="password1" required/><br />
  email : <input type="email" name="email" value="{{old('email')}}" required/><br />
  Display name : <input type="text" name="name" value="{{old('name')}}" required/><br />
  {{ csrf_field() }}
  <button type="submit">Register</button>
</form>
