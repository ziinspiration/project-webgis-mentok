<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
        <style>
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
                width: 100%;
                overflow: hidden;
            }
        </style>
    </head>
    <body class="h-full w-full">
        {{ $slot }}

        @livewireScripts
    </body>
</html>
