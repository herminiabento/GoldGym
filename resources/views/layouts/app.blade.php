<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gold Gym | @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
  </head>
  <body>

    <!-- header -->
    @include('partials.header')

    <!-- contenido -->
    <main>
        @yield('content')
    </main>

    <!-- footer -->
    <footer class="text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                <div class="mb-3 mb-md-0">
                    <p class="mb-0"><span class="me-1">Herminia G. Bento - 04/07/77</span> - <a href="mailto:herminia.bento@davinci.edu.ar" target="_blank" class="ms-1 me-1">herminia.bento@davinci.edu.ar</a></p>
                </div>
                <div class="mb-3 mb-md-0">
                    <p class="mb-0"><span class="me-1">DWT4AV</span> - <span class="ms-1 me-1">Portales y Comercio Electrónico</span></p>
                </div>
                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="https://www.instagram.com/ladytron_d/" target="_blank" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    @yield('modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    @yield('scripts')

    </body>
</html>
