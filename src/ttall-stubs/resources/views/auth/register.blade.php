@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="w-full max-w-sm mx-auto">
            <div class="bg-white border border-2 rounded shadow-sm">
                <div class="px-6 py-3 mb-0 font-semibold text-gray-700 bg-gray-200">
                    {{ __('Register') }}
                </div>

                <form class="w-full p-6" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="flex flex-wrap mb-6">
                        <label for="name" class="block mb-2 text-sm font-bold text-gray-700">
                            {{ __('Name') }}:
                        </label>

                        <input id="name" type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name')  border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <p class="mt-4 text-xs italic text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="email" class="block mb-2 text-sm font-bold text-gray-700">
                            {{ __('E-Mail Address') }}:
                        </label>

                        <input id="email" type="email" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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

                        <input id="password" type="password" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <p class="mt-4 text-xs italic text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="password-confirm" class="block mb-2 text-sm font-bold text-gray-700">
                            {{ __('Confirm Password') }}:
                        </label>

                        <input id="password-confirm" type="password" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded appearance-none shadow-sm focus:outline-none focus:shadow-outline" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="flex flex-wrap">
                        <button type="submit" class="inline-block px-4 py-2 text-base font-bold leading-normal text-center text-gray-100 no-underline bg-indigo-500 border rounded shadow-sm hover:bg-indigo-400">
                            {{ __('Register') }}
                        </button>

                        <p class="w-full mt-8 -mb-4 text-xs text-center text-gray-700">
                            {{ __('Already have an account?') }}
                            <a class="text-indigo-500 no-underline hover:text-indigo-400" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
