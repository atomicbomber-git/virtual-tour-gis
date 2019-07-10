<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-default fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route("home.show") }}">
            <i class="fa fa-map mr-2"></i>
            {{ config('app.long_name') }}
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

                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Lokasi Wisata</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="article-list.html">Artikel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tour_guides.html">Tour Guide</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">Tentang & Kontak</a>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>
