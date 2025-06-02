<?php

namespace App\Http\Controllers;

use App\Models\FileLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show file upload form
    public function showUploadForm()

{
    $user = auth()->user();
    return view('user.file-upload', compact('user'));
}

    // Upload file
    public function uploadFile(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:500',
        ]);

        $file = $request->file('file');
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads', $fileName);

        $fileLink = FileLink::create([
            'user_id' => Auth::id(),
            'file_name' => $file->getClientOriginalName(),
            'storage_path' => $path,
            'description' => $validated['description'],
            'access_code' => Str::random(32),
            'expires_at' => Carbon::now()->addMinutes(30),
        ]);

        return redirect()->back()->with([
            'success' => 'File uploaded successfully!',
            'access_link' => route('file.download', ['code' => $fileLink->access_code]),
        ]);
    }

    // Download file
    public function downloadFile($code)
    {
        $fileLink = FileLink::where('access_code', $code)->firstOrFail();

        if ($fileLink->expires_at < now()) {
            Storage::delete($fileLink->storage_path);
            $fileLink->delete();
            abort(404, 'File link has expired');
        }

        return Storage::download($fileLink->storage_path, $fileLink->file_name);
    }

    // Delete file
    public function deleteFile($fileId)
    {
        $fileLink = FileLink::where('user_id', Auth::id())->findOrFail($fileId);

        Storage::delete($fileLink->storage_path);
        $fileLink->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }
}