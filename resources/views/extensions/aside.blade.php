<aside>
    {{-- border border-danger --}}
    <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="sidebar-menu" style="max-width: 200px;">
        <div class="offcanvas-header m-0">
            <div class="d-flex justify-content-center align-items-center w-100">
                <img src="{{ asset('assets/icons/gis-icon.png')}}"
                    alt="logo"
                    srcset=""
                    class="w-100"
                    style="max-width: 35px; aspect-ratio: 1;">
                <h5 id="side-bar-menu-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        {{-- <hr> --}}
        <div class="offcanvas-body">
            <ul class="nav">
                <li class="nav-item w-100">
                    <a href="" class="nav-link d-flex align-items-center gap-2 text-dark @if (Route::currentRouteName() == "dashboard") active @endif">
                        <i class="bi bi-speedometer"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="nav-item w-100">
                    <div class="dropdown">
                        <button class="nav-link d-flex align-items-center gap-2 text-dark dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>
                                Barangay
                            </span>
                        </button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item">Nueva Estrella Norte</li>
                            <li class="dropdown-item">Nueva Estrella Sur</li>
                            <li class="dropdown-item">Dan-an</li>
                            <li class="dropdown-item">Catrawan</li>
                            <li class="dropdown-item">Manglit</li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item w-100">
                    <a href="" class="nav-link d-flex align-items-center gap-2  text-dark">
                        <i class="bi bi-map"></i>
                        <span>
                            Heat Map
                        </span>
                    </a>
                </li>
                <li class="nav-item w-100">
                    <a href="" class="nav-link d-flex align-items-center gap-2  text-dark">
                        <i class="bi bi-database-fill-add"></i>
                        <span>
                            Data Input
                        </span>
                    </a>
                </li>
            </ul>
        </div>
      </div>


    <div class="d-none d-sm-block w-100" style="max-width: 200px;">
        <div class="d-flex justify-content-center align-items-center w-100">
            <img src="{{ asset('assets/icons/gis-icon.png')}}"
                alt="logo"
                srcset=""
                class="w-100"
                style="max-width: 35px; aspect-ratio: 1;">
        </div>

        <ul class="nav">
            <li class="nav-item w-100">
                <a href="" class="nav-link d-flex align-items-center gap-2 text-dark @if (Route::currentRouteName() == "dashboard") active @endif">
                    <i class="bi bi-speedometer"></i>
                    <span>
                        Dashboard
                    </span>
                </a>
            </li>
            <li class="nav-item w-100">
                <div class="dropdown">
                    <button class="nav-link d-flex align-items-center gap-2 text-dark dropdown-toggle"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>
                            Barangay
                        </span>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item">Nueva Estrella Norte</li>
                        <li class="dropdown-item">Nueva Estrella Sur</li>
                        <li class="dropdown-item">Dan-an</li>
                        <li class="dropdown-item">Catrawan</li>
                        <li class="dropdown-item">Manglit</li>
                    </ul>
                </div>
            </li>
            <li class="nav-item w-100">
                <a href="" class="nav-link d-flex align-items-center gap-2  text-dark">
                    <i class="bi bi-map"></i>
                    <span>
                        Heat Map
                    </span>
                </a>
            </li>

            <li class="nav-item w-100" data-bs-toggle="modal" data-bs-target="#modal-login">
                <button class="nav-link d-flex align-items-center gap-2 text-dark @if (Route::currentRouteName() == "data-input") active @endif">
                    <i class="bi bi-database-fill-add"></i>
                    <span>
                        Data Input
                    </span>
                </button>
            </li>

            @if (Auth::check())
                {{-- log out --}}
                <li class="nav-item w-100">
                    <a href="{{ route('logout') }}" class="nav-link d-flex align-items-center gap-2  text-dark">
                        <i class="bi bi-database-fill-add"></i>
                        <span>
                            Log Out
                        </span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>