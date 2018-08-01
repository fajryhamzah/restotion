<div class="four wide column">

  <div class="ui vertical menu">
    <a class="{{ ($page == "detail")? "active teal":""}} item" href="{{ url("dashboard/".$id) }}">
      Detail
    </a>
    <a class="{{ ($page == "galeri")? "active teal":""}} item" href="{{ url("dashboard/gallery/".$id) }}">
      Galeri
    </a>
    <a class="{{ ($page == "menu")? "active teal":""}} item" href="{{ url("dashboard/menu/".$id) }}">
      Menu
    </a>
    <a class="{{ ($page == "meja")? "active teal":""}} item" href="{{ url("dashboard/meja/".$id) }}">
      Meja
    </a>

  </div>

</div>
