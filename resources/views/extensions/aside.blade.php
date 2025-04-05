<style>
    #aside {
        /* background-color: red !important */
        padding: 1em !important;
        padding-right: 0 !important;
        /* background-color: red; */
    }
    /* Media query for max-width of 575px */
    @media only screen and (max-width: 575px) {
        #aside {
            /* background-color: red !important */
            padding: 0 !important;
        }
    }
</style>

<aside class="" id="aside">
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
                    <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center gap-2 text-dark @if (Route::currentRouteName() == "dashboard") active @endif">
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
                                aria-expanded="false"
                                aria-haspopup="true"
                                aria-labelledby="barangayDropdown">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Barangay</span>
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="barangayDropdown" role="menu">

                             {{-- check if log in --}}
                            @if (auth()->check())
                                <li style="cursor: pointer;">
                                    <a class="dropdown-item" href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-add-brgy">
                                        <i class="bi bi-plus" style="font-style: normal;"> Add Barangay</i>
                                    </a>
                                </li>

                                {{-- list of brgy --}}
                                <li style="cursor: pointer;">
                                    <a class="dropdown-item" href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-show-brgys">
                                        <i class="bi bi-list" style="font-style: normal;"> Barangay List</i>
                                    </a>
                                </li>

                                {{-- hr --}}
                                <hr>
                            @endif

                            {{-- loop the brgys in the database --}}
                            @foreach (App\Models\Barangay::getAll() as $item)
                                <li style="cursor: pointer;">
                                    <a class="dropdown-item" href="#/{{$item->encrypted_id}}">
                                        <i class="bi bi-geo" style="font-style: normal;"> {{$item->name}}</i>
                                    </a>
                                </li>
                            @endforeach

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

                {{-- check if authenticated --}}
                @if (auth()->check())
                    <li class="nav-item w-100">
                        <a href="{{route('data-input')}}" class="nav-link d-flex align-items-center gap-2 text-dark @if (Route::currentRouteName() == "data-input") active @endif">
                            <i class="bi bi-database-fill-add"></i>
                            <span>
                                Data Input
                            </span>
                        </a>
                    </li>
                @else
                    <li class="nav-item w-100" data-bs-toggle="modal" data-bs-target="#modal-login">
                        <button class="nav-link d-flex align-items-center gap-2 text-dark @if (Route::currentRouteName() == "data-input") active @endif">
                            <i class="bi bi-database-fill-add"></i>
                            <span>
                                Data Input
                            </span>
                        </button>
                    </li>
                @endif

                @if (auth()->check())
                    {{-- log out --}}
                    <li class="nav-item w-100">
                        <i class="bi bi-box-arrow-right" style="font-style: normal;"> Log Out</i>
                    </li>
                @endif
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
                <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center gap-2 text-dark @if (Route::currentRouteName() == "dashboard") active @endif">
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
                            aria-expanded="false"
                            aria-haspopup="true"
                            aria-labelledby="barangayDropdown">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Barangay</span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="barangayDropdown" role="menu">

                        {{-- check if log in --}}
                        @if (auth()->check())
                            <li style="cursor: pointer;">
                                <a class="dropdown-item" href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-add-brgy">
                                    <i class="bi bi-plus" style="font-style: normal;"> Add Barangay</i>
                                </a>
                            </li>

                            {{-- list of brgy --}}
                            <li style="cursor: pointer;">
                                <a class="dropdown-item" href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-show-brgys">
                                    <i class="bi bi-list" style="font-style: normal;"> Barangay List</i>
                                </a>
                            </li>

                            {{-- hr --}}
                            <hr>
                        @endif

                        {{-- loop the brgys in the database --}}
                        @foreach (App\Models\Barangay::getAll() as $item)
                            <li style="cursor: pointer;">
                                <a class="dropdown-item" href="{{ route('view-brgy-data', ['id' => $item->encrypted_id]) }}">
                                    <i class="bi bi-geo" style="font-style: normal;"> {{$item->name}}</i>
                                </a>
                            </li>
                        @endforeach

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

            {{-- check if authenticated --}}
            @if (auth()->check())
                <li class="nav-item w-100">
                    <a href="{{route('data-input')}}" class="nav-link d-flex align-items-center gap-2 text-dark @if (Route::currentRouteName() == "data-input") active @endif">
                        <i class="bi bi-database-fill-add"></i>
                        <span>
                            Data Input
                        </span>
                    </a>
                </li>
            @else
                <li class="nav-item w-100" data-bs-toggle="modal" data-bs-target="#modal-login">
                    <button class="nav-link d-flex align-items-center gap-2 text-dark @if (Route::currentRouteName() == "data-input") active @endif">
                        <i class="bi bi-database-fill-add"></i>
                        <span>
                            Data Input
                        </span>
                    </button>
                </li>
            @endif

            @if (auth()->check())
                {{-- log out --}}
                <li class="nav-item w-100">
                    <a href="{{ route('logout') }}" class="nav-link d-flex align-items-center gap-2  text-dark">
                        <i class="bi bi-box-arrow-right" style="font-style: normal;"> Log Out</i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>