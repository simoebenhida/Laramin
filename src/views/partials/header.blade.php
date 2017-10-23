<nav class="navbar" id="laramin_menu">
  <div class="navbar-brand">
    <a class="navbar-item" href="http://devma.net">
      <img src="{{ laramin_asset('laramin.png') }}" alt="Laramin" width="112" height="28" style="max-height : 16.75rem">
    </a>
    <menuclicked></menuclicked>
  </div>

  <div id="navMenu" class="navbar-menu">
    <div class="navbar-end">
      <div class="navbar-item">
          <a href="{{ route('laramin.profile') }}" class="navbar-item @if(laramin_get_active_menu()->first() == 'profile')is-active @endif">
            <span class="fa fa-user"></span>  Profile
          </a>
     <a class="navbar-item" href="{{ route('laramin.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
      </a>
          <form id="logout-form" action="{{ route('laramin.logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
  </div>
    </div>
  </div>

</nav>
