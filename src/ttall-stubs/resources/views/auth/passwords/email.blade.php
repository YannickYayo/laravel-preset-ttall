@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="w-full max-w-sm mx-auto">
            @if (session('status'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 shadow-sm" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white border border-2 rounded shadow-sm">
                <div class="px-6 py-3 mb-0 font-semibold text-gray-700 bg-gray-200">
                    {{ __('Reset Password') }}
                </div>

                <form class="w-full p-6" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="flex flex-wrap mb-6">
                        <label for="email" class="block mb-2 text-sm font-bold text-gray-700">
                            {{ __('E-Mail Address') }}:
                        </label>

                        <input id="email" type="email" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <p class="mt-4 text-xs italic text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap">
                        <button type="submit" class="px-4 py-2 font-bold text-gray-100 bg-indigo-500 rounded shadow-sm hover:bg-indigo-400 focus:outline-none focus:shadow-outline">
                            {{ __('Send Password Reset Link') }}
                        </button>

                        <p class="w-full mt-8 -mb-4 text-xs text-center">
                            <a class="text-indigo-500 no-underline hover:text-indigo-400" href="{{ route('login') }}">
                                {{ __('Back to login') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
