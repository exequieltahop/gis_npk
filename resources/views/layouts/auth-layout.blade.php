@props(['title' => 'App', 'header' => '', 'footer' => ''])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery (full version) -->
    <script src="{{ asset('assets/jquery/jquery.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.3.3-dist/css/bootstrap.css') }}">

    <!-- Bootstrap Bundle with Popper.js -->
    <script src="{{asset('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.js')}}"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.3-dist/font/bootstrap-icons.css')}}">

    {{-- sweet alert2 --}}
    <script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}">

    {{-- data tables assets --}}
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">

    {{-- leaflet assets --}}
    <link rel="stylesheet" href="{{ asset('assets/leaflet/leaflet.css') }}">
    <script src="{{asset('assets/leaflet/leaflet.js')}}"></script>

    {{-- main script --}}
    <script src="{{asset('assets/js/main.js')}}"></script>

    {{-- style --}}
    <style>
        html {
            --primary-color: rgb(0, 94, 0);
        }

        .active {
            background-color: var(--primary-color) !important;
            color: white !important;
            border-radius: 5px !important;
            /* width: 100% !important; */
        }

        .dt-layout-full {
            overflow: auto !important;
        }

        /* Media query for max-width of 575px */
        @media all and (width: 575px) {
            aside {
                padding: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-light">

    {{-- aside side bar --}}
    <div class="d-flex vh-100">
        {{-- side bar --}}
        @include('extensions.aside')

        {{-- header, main, footer --}}
        <div class="d-flex flex-column p-3 mb-3 w-100">
            <header class="rounded bg-white shadow-lg p-3 mb-3">
                <div class="d-flex align-items-center">
                    <button style="all:unset;" data-bs-toggle="offcanvas" data-bs-target="#sidebar-menu"
                        aria-controls="staticBackdrop">
                        <i class="d-sm-none d-block bi bi-list" style="font-size: 1.5rem;"></i>
                    </button>
                    <h5 class="m-0 mx-3 text-center">GIS NPK IS</h5>
                </div>
            </header>

            <main class="container-fluid m-0 p-0">
                {{$slot}}
            </main>

            <footer class="">
                {{$footer}}
            </footer>
        </div>
    </div>

    {{-- modals --}}
    @include('extensions.modals')

    {{-- errors --}}
    @if (session('error'))
    <x-toast type="danger">
        {{ session('error') }}
    </x-toast>
    @endif

    {{-- success --}}
    @if (session('success'))
    <x-toast type="success">
        {{ session('success') }}
    </x-toast>
    @endif

    {{-- toast for error and success for js only --}}
    <div class="toast-container position-fixed top-0 end-0 p-3" id="toast-danger" style="display: none;">
        <div class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                <div class="d-flex justify-content-between p-2">
                    <strong style="text-transform: uppercase;" id="toast-danger-message">
                    </strong>
                    <button class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="close"></button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3" id="toast-success">
        <div class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                <div class="d-flex justify-content-between p-2">
                    <strong style="text-transform: uppercase;" id="toast-success-message">
                    </strong>
                    <button class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="close"></button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>