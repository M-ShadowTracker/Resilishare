@extends('layouts.app')

@section('title', 'URL Test Result')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">URL Test Result</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-start mb-6">
            <div class="flex-shrink-0">
                <div class="p-3 rounded-full {{ $isSafe ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    <i class="fas {{ $isSafe ? 'fa-check-circle' : 'fa-exclamation-triangle' }} text-3xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-bold">{{ $isSafe ? 'This URL appears to be safe' : 'Warning: This URL may be unsafe' }}</h2>
                <p class="text-gray-600 break-all">{{ $url }}</p>
            </div>
        </div>
        
        <div class="space-y-6">
            <div>
                <h3 class="font-semibold mb-2 flex items-center">
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-full mr-2">
                        <i class="fas fa-google"></i>
                    </span>
                    Google Safe Browsing
                </h3>
                <div class="ml-10">
                    @if($details['google_safe_browsing']['safe'])
                    <p class="text-green-600">No threats detected</p>
                    @else
                    <p class="text-red-600">Potential threats detected:</p>
                    <ul class="list-disc pl-5 mt-1">
                        @foreach($details['google_safe_browsing']['threats'] as $threat)
                        <li class="text-red-600">{{ ucfirst($threat) }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            
            <div>
                <h3 class="font-semibold mb-2 flex items-center">
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-full mr-2">
                        <i class="fas fa-shield-virus"></i>
                    </span>
                    VirusTotal Analysis
                </h3>
                <div class="ml-10">
                    @if($details['virus_total']['malicious'] === 0)
                    <p class="text-green-600">Clean (0/{$details['virus_total']['total']} engines detected threats)</p>
                    @else
                    <p class="text-red-600">{{ $details['virus_total']['malicious'] }}/{{ $details['virus_total']['total'] }} engines detected threats</p>
                    <div class="mt-2 space-y-1">
                        @foreach($details['virus_total']['engines'] as $engine => $result)
                        <div class="flex">
                            <span class="w-32 font-medium">{{ $engine }}:</span>
                            <span class="{{ $result === 'malicious' ? 'text-red-600' : 'text-green-600' }}">{{ ucfirst($result) }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            
            <div>
                <h3 class="font-semibold mb-2 flex items-center">
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-full mr-2">
                        <i class="fas fa-database"></i>
                    </span>
                    AbuseDB Check
                </h3>
                <div class="ml-10">
                    @if($details['abuse_db']['is_abused'])
                    <p class="text-red-600">URL found in abuse database</p>
                    <p class="text-red-600">Type: {{ ucfirst($details['abuse_db']['abuse_type']) }}</p>
                    @else
                    <p class="text-green-600">No abuse records found</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-6 border-t">
            <a href="{{ route('user.url-test') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Test Another URL
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Safety Recommendations</h2>
        @if($isSafe)
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <h3 class="font-semibold text-green-800 mb-2">This URL appears safe, but always be cautious:</h3>
            <ul class="list-disc pl-5 space-y-1 text-green-700">
                <li>Check for HTTPS in the address bar</li>
                <li>Look for trust indicators like company logos</li>
                <li>Be wary of requests for personal information</li>
            </ul>
        </div>
        @else
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <h3 class="font-semibold text-red-800 mb-2">This URL may be unsafe. We recommend:</h3>
            <ul class="list-disc pl-5 space-y-1 text-red-700">
                <li>Do not enter any personal information on this site</li>
                <li>Do not download any files from this URL</li>
                <li>Consider reporting this URL to your IT department</li>
            </ul>
        </div>
        @endif
    </div>
</div>
@endsection