<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Thavorn</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <link rel="icon" href="images/eye.svg">
    </head>
    <body>
        <div id="app"></div>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
    </html>
    