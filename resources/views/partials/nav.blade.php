<header class="header">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="navbar-header">
          <!-- Navbar Header-->
          <a href="index.html" class="navbar-brand">
            <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Lyonhart</strong><strong>Chronicles</strong></div>
            <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong></div>
          </a>
            
          <!-- Sidebar Toggle Btn-->
          <button class="sidebar-toggle"><i class="fas fa-long-arrow-left"></i></button>
        </div>
        <div class="right-menu list-inline no-margin-bottom">
          <!-- Log out               -->
          <div class="list-inline-item logout">
            <a id="logout" href="login.html" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <span class="d-none d-sm-inline">{{ __('Logout') }} </span>
              <i class="icon-logout"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </div>
        </div>
      </div>
    </nav>
</header>