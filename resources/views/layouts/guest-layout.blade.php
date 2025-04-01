@props(['title' => 'App', 'header' => '', 'footer' => ''])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>

    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    {{-- style and script--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- style  --}}
    <style>
        html{
            --primary-color : black;
        }
        .active{
            background-color: var(--primary-color) !important;
            color: white !important;
            border-radius: 5px !important;
            width: 100% !important;
        }
    </style>

    {{-- <script>
        const toastElList = document.querySelectorAll('.toast')
        const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl, option))
    </script> --}}
</head>
<body class="bg-light">
    {{-- aside side bar --}}
    <div class="d-flex gap-2 p-2 vh-100">
        {{-- side bar --}}
        @include('extensions.aside')

        {{-- header, main, footer --}}
        <div class="d-flex flex-column">
            <header class=" rounded bbg-white shadow-lg p-3">
                <div class="d-flex align-items-center">
                    <button style="all:unset;"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#sidebar-menu"
                        aria-controls="staticBackdrop">
                        <i class="d-sm-none d-block bi bi-list"  style="font-size: 1.5rem;"></i>
                    </button>
                    <h5 class="m-0 mx-3 text-center">GIS NPK IS</h5>
                </div>
            </header>

            <main class="">
                {{-- alert toast --}}

                {{-- errors --}}
                @if (session('error'))
                    {{-- <x-toast type="danger"> --}}
                    {{-- </x-toast> --}}
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- success --}}
                @if (session('success'))
                    {{-- <x-toast type="success"> --}}
                    {{-- </x-toast> --}}
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                {{$slot}}
            </main>

            <footer class="">
                {{$footer}}
            </footer>
        </div>
    </div>

    {{-- modals --}}
    @include('extensions.modals')



</body>
</html>