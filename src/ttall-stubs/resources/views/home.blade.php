@extends('layouts.app')

@section('content')
    <div class="mx-2 md:w-1/2 md:mx-auto">

        @if (session('status'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 shadow-sm" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border-2 rounded shadow-sm">
            <div class="px-6 py-3 mb-0 font-semibold text-gray-700 bg-gray-200">
                Dashboard
            </div>

            <p class="p-6 text-gray-700">
                You are logged in!
            </p>
        </div>
    </div>
@endsection
