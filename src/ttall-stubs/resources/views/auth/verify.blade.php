@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="w-full max-w-sm mx-auto">
            @if (session('resent'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 shadow-sm" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <div class="bg-white border border-2 rounded shadow-sm">
                <div class="px-6 py-3 mb-0 font-semibold text-gray-700 bg-gray-200">
                    {{ __('Verify Your Email Address') }}
                </div>

                <div x-data class="flex flex-wrap w-full p-6">
                    <p class="leading-normal">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                    </p>

                    <p class="mt-6 leading-normal">
                        {{ __('If you did not receive the email') }}, <a class="text-indigo-500 no-underline cursor-pointer hover:text-indigo-400" x-on:click.prevent="$refs.resend_verification_form.submit()">{{ __('click here to request another') }}</a>.
                    </p>

                    <form x-ref="resend_verification_form" id="resend-verification-form" method="POST" action="{{ route('verification.resend') }}" class="hidden">
                        @csrf
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
