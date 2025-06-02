@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-2xl mt-10">
    <div class="md:flex">
        <div class="w-full p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Reset Password</h1>
            </div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field with Toggle -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror pr-10">
                        <button type="button" onclick="togglePassword('password')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-700 focus:outline-none" tabindex="-1">
                            <i class="fas fa-eye-slash" id="password-toggle"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field with Toggle -->
                <div class="mb-6">
                    <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <div class="relative">
                        <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline pr-10">
                        <button type="button" onclick="togglePassword('password-confirm')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-700 focus:outline-none" tabindex="-1">
                            <i class="fas fa-eye-slash" id="password-confirm-toggle"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-center mb-4">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = document.getElementById(fieldId + '-toggle');
    
    if (field.type === 'password') {
        field.type = 'text';
        toggle.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
        field.type = 'password';
        toggle.classList.replace('fa-eye', 'fa-eye-slash');
    }
}
</script>
@endpush
@endsection
