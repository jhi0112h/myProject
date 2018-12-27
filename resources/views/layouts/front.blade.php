<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
</head>
<body>

    <div id="app-mount">
        <transition name="fade">
            <router-view></router-view>
        </transition>
    </div>

    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
