<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="{{ asset('images/assets/PSU logo.png') }}" sizes="any">
<link rel="icon" href="{{ asset('images/assets/PSU logo.png') }}" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    * {
        font-family: Poppins;
    }

    .data-item:hover {
        scale: 101%;
    }

    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
