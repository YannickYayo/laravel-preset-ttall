<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @livewireStyles

    <!-- Turbolinks -->
    <script src="{{ mix('js/turbolinks.js') }}"></script>
</head>
<body class="h-screen antialiased leading-tight bg-gray-100">
    <div id="app">
        <nav class="py-6 mb-8 bg-indigo-800 shadow-sm">
            <div class="container px-6 mx-auto md:px-0">
                <div class="flex items-center justify-center">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-100 no-underline">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div x-data class="flex-1 text-right">
                        @guest
                            <a class="p-3 text-base font-normal text-gray-300 no-underline hover:underline" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a class="p-3 text-base font-normal text-gray-300 no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else
                            <span class="pr-3 text-base font-normal text-gray-300">{{ Auth::user()->name }}</span>

                            <a href="{{ route('logout') }}"
                                class="p-3 text-base font-normal text-gray-300 no-underline hover:underline"
                                x-on:click.prevent="$refs.logout_form.submit()">
                                {{ __('Logout') }}
                            </a>
                            <form x-ref="logout_form" id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                {{ csrf_field() }}
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    @livewireScripts
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
