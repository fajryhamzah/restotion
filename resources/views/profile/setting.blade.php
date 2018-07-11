<form method="post">
  Display Name : <input type="text" name="name" value="{{$profile->name}}" />
  Email : <input type="email" name="email" value="{{$profile->email}}" />
  {{ csrf_field() }}
  <button>Submit</button>
</form>
