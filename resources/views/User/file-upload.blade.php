@extends('layouts.app')

@section('title', 'Secure File Sharing')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Secure File Sharing</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Upload a File</h2>
        <p class="text-gray-600 mb-6">Share files securely with auto-expiring links (valid for 30 minutes).</p>
        
        <form action="{{ route('user.file.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="file">Select File</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col w-full h-32 border-4 border-blue-200 border-dashed hover:bg-gray-100 hover:border-gray-300 transition">
                        <div class="flex flex-col items-center justify-center pt-7">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">Select a file</p>
                        </div>
                        <input type="file" name="file" id="file" class="opacity-0" required>
                    </label>
                </div>
                @error('file')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description (Optional)</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Upload & Generate Link
            </button>
        </form>
        
        @if(session('access_link'))
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-semibold text-blue-800 mb-2">Your secure file link:</h3>
            <div class="flex">
                <input type="text" value="{{ session('access_link') }}" id="fileLink" readonly
                    class="flex-1 px-4 py-2 border rounded-l-lg focus:outline-none">
                <button onclick="copyToClipboard()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg">
                    Copy
                </button>
            </div>
            <p class="text-sm text-gray-600 mt-2">This link will expire in 30 minutes.</p>
        </div>
        @endif
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Your Shared Files</h2>
        
        @if($user->fileLinks->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($user->fileLinks as $file)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $file->file_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($file->description, 30) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $file->isExpired() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $file->expires_at->format('Y-m-d H:i') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if(!$file->isExpired())
                            <a href="{{ route('file.download', ['code' => $file->access_code]) }}" class="text-blue-600 hover:text-blue-900 mr-3">Download</a>
                            @endif
                            <form action="{{ route('user.file.delete', $file->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-600">You haven't shared any files yet.</p>
        @endif
    </div>
</div>

<script>
function copyToClipboard() {
    const copyText = document.getElementById("fileLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert("Link copied to clipboard!");
}
</script>
@endsection