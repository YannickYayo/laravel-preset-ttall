@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="w-full max-w-sm mx-auto">
            <div class="bg-white border border-2 rounded shadow-sm">
                <div class="px-6 py-3 mb-0 font-semibold text-gray-700 bg-gray-200">
                    {{ __('Login') }}
                </div>

                <form class="w-full p-6" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="flex flex-wrap mb-6">
                        <label for="email" class="block mb-2 text-sm font-bold text-gray-700">
                            {{ __('E-Mail Address') }}:
                        </label>

                        <input id="email" type="email" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <p class="mt-4 text-xs italic text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="password" class="block mb-2 text-sm font-bold text-gray-700">
                            {{ __('Password') }}:
                        </label>

                        <input id="password" type="password" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" name="password" required>

                        @error('password')
                            <p class="mt-4 text-xs italic text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex mb-6">
                        <input class="bg-blue-200" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="ml-3 text-sm text-gray-700" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="flex flex-wrap items-center">
                        <button type="submit" class="px-4 py-2 text-base font-bold text-gray-100 bg-indigo-500 rounded shadow-sm hover:bg-indigo-400 focus:outline-none focus:shadow-outline">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="flex-1 text-sm text-right text-indigo-500 no-underline whitespace-no-wrap hover:text-indigo-400" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <p class="w-full mt-8 -mb-4 text-xs text-center text-gray-700">
                                {{ __("Don't have an account?") }}
                                <a class="text-indigo-500 no-underline hover:text-indigo-400" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            </p>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
