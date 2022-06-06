<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

          <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>


    </head>
    <body  >
        @inertia

        @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv


        <script src="{{ asset('backend/') }}/assets/libs/jquery/jquery.min.js"></script>
        <script src="{{ asset('backend/') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('backend/') }}/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{ asset('backend/') }}/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ asset('backend/') }}/assets/libs/node-waves/waves.min.js"></script>
        <script src="{{ asset('backend/') }}/assets/js/app.js"  ></script>



    </body>
</html>
