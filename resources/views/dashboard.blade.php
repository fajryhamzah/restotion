Dashboard:
<a href="{{ url("/add_restaurant") }}">Tambah restoran</a>
<a href="{{ url("/setting") }}">Edit akun</a>
<a href="{{ url("/logout") }}">Log out</a>

<table border="1">
  <tr>
    <th>Logo</th>
    <th>Nama Restoran</th>
  </tr>
  <tr>
    @foreach($data as $restoran)
      <td><img src='{{$restoran->logo}}' /></td>
      <td><a href='{{ url('dashboard/'.$restoran->id) }}'>{{$restoran->nama_restoran}}</a></td>
    @endforeach
  </tr>

</table>
