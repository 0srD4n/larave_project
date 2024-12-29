{{-- ini berlaku hanya untuk headerr saja dimana nantinya bisa di modifikasi untuk headernya agar mencegah terjadinya xss --}}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} | {{ $title ?? ''}}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self';">
        <link rel="stylesheet" href="{{ asset('css/app-bysBjyKn.css') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    </head>
    <body>
        {{ $slot }}
        <script src="{{ asset('js/app-BPnfBaih.js') }}"></script>

    </body>

</html>
