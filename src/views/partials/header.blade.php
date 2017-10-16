<nav class="navbar menu-background" id="laramin_menu">
  <div class="navbar-brand">
    <a class="navbar-item" href="http://bulma.io">
      <img src="{{ laramin_asset('laramin.png') }}" alt="Laramin">
    </a>

    <a class="navbar-item is-hidden-desktop" href="https://github.com/jgthms/bulma" target="_blank">
      <span class="icon" style="color: #333;">
        <i class="fa fa-github"></i>
      </span>
    </a>

    <a class="navbar-item is-hidden-desktop" href="https://twitter.com/jgthms" target="_blank">
      <span class="icon" style="color: #55acee;">
        <i class="fa fa-twitter"></i>
      </span>
    </a>

    <div class="navbar-burger burger" data-target="navMenuExample">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div id="navMenuExample" class="navbar-menu">
    <div class="navbar-end">
      <div class="navbar-item">
          <a class="navbar-item">
            Profile
          </a>
    |
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
