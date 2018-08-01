<div class="ui blue secondary pointing inverted menu">
    <a class="{{ ( (isset($hal)) ) ? "":"active"  }} item" href="{{ url('/dashboard')  }}">
      Home
    </a>
    <a class="{{ ( (isset($hal)) && ($hal) )? "active":""  }} item" href="{{ url('/setting')  }}">
      Setting
    </a>
    <a class="item" href="{{ url('/logout')  }}">
      Log Out
    </a>
</div>
