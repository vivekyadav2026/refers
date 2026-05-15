@extends('layouts.app')

@section('title', 'Verify OTP - SK Solutions')

@section('content')
<div class="min-h-[70vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900">
            Verify Your Number
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            We've sent a 4-digit OTP to +91 {{ $phone }}
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-slate-200">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <form class="space-y-6" action="{{ route('verify.check') }}" method="POST">
                @csrf
                <input type="hidden" name="phone" value="{{ $phone }}">
                
                <div>
                    <label for="otp" class="block text-sm font-medium text-slate-700 text-center">
                        Enter 4-Digit OTP
                    </label>
                    <div class="mt-1">
                        <input id="otp" name="otp" type="text" maxlength="4" required class="appearance-none block w-full px-3 py-3 border border-slate-300 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-2xl text-center tracking-widest font-mono" placeholder="••••">
                    </div>
                    @error('otp')
                        <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Verify & Login
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Change Phone Number</a>
            </div>
        </div>
    </div>
</div>
@endsection
