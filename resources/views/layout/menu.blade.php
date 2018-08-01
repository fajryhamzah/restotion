
  <div class="ui stackable blue secondary pointing inverted menu">
    <a href="{{url('/')}}" class="item {{($page == "home")? "active":""}}">
      Home
    </a>
    <a href="{{url('resto')}}" class="item {{($page == "resto")? "active":""}}">
      Restoran
    </a>

    <div class="right menu">
      <a href="{{url('login')}}" class="item {{($page == "login")? "active":""}}">Login</a>
    </div>
  </div>
