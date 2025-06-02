@extends('layouts.app')

@section('title', 'Welcome to ResiliShare')

@section('content')
<div class="bg-blue-600 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">ResiliShare</h1>
        <p class="text-xl md:text-2xl mb-8">Your Cybersecurity Awareness Platform</p>
        <div class="flex justify-center space-x-4">
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Admin Dashboard</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">User Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">Register</a>
            @endauth
        </div>
    </div>
</div>

<div class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Features</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="text-blue-600 text-4xl mb-4">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Cybersecurity Quizzes</h3>
                <p class="text-gray-600">Test your knowledge with our interactive quizzes at different difficulty levels.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="text-blue-600 text-4xl mb-4">
                    <i class="fas fa-link"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">URL Safety Check</h3>
                <p class="text-gray-600">Check if a URL is safe using multiple security APIs before visiting.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="text-blue-600 text-4xl mb-4">
                    <i class="fas fa-file-upload"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Secure File Sharing</h3>
                <p class="text-gray-600">Share files securely with auto-expiring links that disappear after 30 minutes.</p>
            </div>
        </div>
    </div>
</div>
@endsection