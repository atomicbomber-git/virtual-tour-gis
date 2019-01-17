<nav class="navbar navbar-dark bg-dark navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#"> SIG Virtual Tour </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <li class='nav-item {{ Route::is('layer.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('layer.index') }}'>
                        <i class='fa fa-list-alt'></i>
                        Layer
                    </a>
                </li>

                <li class='nav-item {{ Route::is('location.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('location.index') }}'>
                        <i class='fa fa-map-marker'></i>
                        Lokasi
                    </a>
                </li>
            </div>
        </div>
    </div>
</nav>