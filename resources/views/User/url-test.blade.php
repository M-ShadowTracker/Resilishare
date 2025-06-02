@extends('layouts.app')

@section('title', 'URL Safety Test')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">URL Safety Test</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Check a URL for Safety</h2>
        <p class="text-gray-600 mb-6">Enter a URL below to check if it's safe using multiple security databases.</p>
        
        <form action="{{ route('user.url-test') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="url" class="block text-gray-700 font-semibold mb-2">URL to Check</label>
                <div class="flex">
                    <input type="url" id="url" name="url" required placeholder="https://example.com"
                        class="flex-1 px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg">
                        Check Safety
                    </button>
                </div>
                @error('url')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
        </form>
        
        <div class="mt-6">
            <h3 class="font-semibold mb-2">How it works:</h3>
            <ul class="list-disc pl-5 space-y-1 text-gray-600">
                <li>Checks against Google Safe Browsing database</li>
                <li>Analyzes with VirusTotal's threat intelligence</li>
                <li>Verifies against AbuseDB's malicious URL database</li>
            </ul>
        </div>
    </div>
    
    @if($user->urlTests->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h2 class="text-xl font-bold mb-4">Your Recent URL Tests</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tested At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($user->urlTests->take(5) as $test)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <a href="{{ $test->url }}" target="_blank" class="text-blue-600 hover:text-blue-800">{{ Str::limit($test->url, 40) }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $test->is_safe ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $test->is_safe ? 'Safe' : 'Unsafe' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $test->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection