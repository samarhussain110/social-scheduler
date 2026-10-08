<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ config('app.name', 'SocialScheduler') }}
    </title>



    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
        rel="stylesheet"
    >

    {{-- Laravel / Vite assets --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    {{-- Tailwind fallback --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
        }

        /*
         * The sidebar is fixed on desktop,
         * so the main application needs left spacing.
         */
        @media (min-width: 1024px) {
            .app-main-content {
                margin-left: 250px;
            }
        }

        @media (max-width: 1023px) {
            .app-main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-900 antialiased">

    <div class="min-h-screen bg-slate-100">

        {{-- Sidebar --}}
        @include('layouts.navigation')

        {{-- Main Application --}}
        <div class="app-main-content min-h-screen">

            {{-- Optional Page Heading --}}
            @isset($header)
                <header class="border-b border-slate-200 bg-white">

                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>

                </header>
            @endisset

            {{-- Page Content --}}
            <main class="min-h-screen">
                {{ $slot }}
            </main>

        </div>

    </div>

</body>

</html>