@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Welcome, {{ $user->name }}!</h1>
    
    <!-- Success/Error Messages -->
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif
    
   
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('user.quiz') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="text-blue-600 text-3xl mb-4">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Cybersecurity Quiz</h3>
            <p class="text-gray-600">Test your knowledge with our interactive quizzes</p>
        </a>
        <a href="{{ route('user.url-test') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="text-blue-600 text-3xl mb-4">
                <i class="fas fa-link"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">URL Safety Check</h3>
            <p class="text-gray-600">Check if a URL is safe before visiting</p>
        </a>
        <a href="{{ route('user.file.upload') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="text-blue-600 text-3xl mb-4">
                <i class="fas fa-file-upload"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Secure File Sharing</h3>
            <p class="text-gray-600">Share files securely with auto-expiring links</p>
        </a>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-blue-600 text-3xl mb-4">
                <i class="fas fa-user-shield"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Security Tips</h3>
            <p class="text-gray-600">Learn how to stay safe online</p>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Quiz Attempts -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Recent Quiz Attempts</h2>
            
            @if($quizAttempts->count() > 0)
            <div class="space-y-4">
                @foreach($quizAttempts as $attempt)
                <div class="border-b pb-4 last:border-b-0 last:pb-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold">{{ $attempt->quiz->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $attempt->quiz->level }} level</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                Score: {{ $attempt->score }}/{{ $attempt->quiz->questions->count() }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $attempt->completed_at ? $attempt->completed_at->format('M d, Y H:i') : 'In progress' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-600">You haven't taken any quizzes yet.</p>
            <a href="{{ route('user.quiz') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Take a Quiz
            </a>
            @endif
        </div>
        
        <!-- Profile Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Profile Information</h2>
            
            <!-- Profile Update Form -->
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                    Update Profile
                </button>
            </form>
            
            <!-- Password Change Form -->
            <div class="mt-6 pt-6 border-t">
                <h3 class="text-lg font-semibold mb-2">Change Password</h3>
                <form action="{{ route('user.password.change') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="current_password" class="block text-gray-700 font-semibold mb-2">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('current_password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-700 font-semibold mb-2">New Password</label>
                        <input type="password" id="new_password" name="new_password" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('new_password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="new_password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                        Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection