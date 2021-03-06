<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-default fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route("home.show") }}">
            <i class="fa fa-map mr-2"></i>

            <span class="d-none d-sm-inline">
                {{ config('app.long_name') }}
            </span>

            <span class="d-inline d-sm-none">
                {{ config('app.name') }}
            </span>
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">

                <li class='nav-item {{ Route::is('home.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('home.show') }}'>
                        <i class="fa fa-home"></i>
                        Beranda
                    </a>
                </li>

                <li class='nav-item {{ Route::is('guest-virtual-tour.show') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('guest-virtual-tour.show') }}'>
                        <i class='fa fa-map'></i>
                        Peta
                    </a>
                </li>

                <li class='nav-item {{ Route::is('guest-article.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('guest-article.index') }}'>
                        <i class='fa fa-newspaper-o'></i>
                        Artikel
                    </a>
                </li>

                @foreach ($information_menus as $information_menu)
                <li class='nav-item {{ $information_menu["type"] === ($information->type ?? '') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('information.show', $information_menu['type']) }}'>
                        <i class="fa {{ $information_menu["icon"] }}"></i>
                        {{ $information_menu["title"] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
