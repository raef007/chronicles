<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('partials.header')

<body>
    <div id="app">
        @guest
            <main>
                @yield('content')
            </main>
        @else
            @include('partials.nav')
            
            <div class="d-flex align-items-stretch">
                <!-- Sidebar Navigation-->
                <nav id="sidebar">
                    <!-- Sidebar Header-->
                    <div class="sidebar-header d-flex align-items-center">
                        <div class="avatar"><img src="images/ppic.jpg" alt="..." class="img-fluid rounded-circle"></div>
                        <div class="title">
                            <h1 class="h5">Ruffy Collado</h1>
                            <p>Praetor</p>
                        </div>
                    </div>
                    <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
                    <ul class="list-unstyled">
                        <li class="active"><a href="index.html"> <i class="icon-home"></i>Dashboard </a></li>
                        <li><a href="tables.html"> <i class="icon-grid"></i>Journal </a></li>
                        <li><a href="forms.html"> <i class="icon-padnote"></i>Settings </a></li>
                    </ul>
                </nav>
                    
                <main>
                    @yield('content')
                </main>
                    
                @include('partials.footer')
              </div>
        @endguest

    </div>
</body>
</html>
