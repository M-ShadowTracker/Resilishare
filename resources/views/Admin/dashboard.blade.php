@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Users</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $usersCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Quizzes</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $quizzesCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Shared Files</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $filesCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">URL Tests</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $urlTestsCount }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Quick Actions</h2>
            </div>
            <div class="space-y-4">
                <a href="{{ route('admin.manage.quizzes') }}" class="block bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-3 px-4 rounded-lg transition">
                    Manage Quizzes
                </a>
                <a href="{{ route('admin.manage.files') }}" class="block bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-3 px-4 rounded-lg transition">
                    Manage Shared Files
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Recent Activity</h2>
            <div class="space-y-4">
                <div class="border-b pb-4">
                    <p class="text-gray-600">No recent activity</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection