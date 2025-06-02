<?php

namespace App\Http\Controllers;

use App\Models\URLTest;
use App\Services\URLTestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class URLTestController extends Controller
{
    protected $urlTestService;

    public function __construct(URLTestService $urlTestService)
    {
        $this->middleware('auth');
        $this->urlTestService = $urlTestService;
    }

    public function showTestForm()
    {
        $user = auth()->user();
        return view('User.url-test', compact('user'));
    }

    public function testURL(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
        ]);

        $url = $validated['url'];
        $result = $this->urlTestService->checkURLSafety($url);

        // Ensure 'abuse_db' key is always defined to avoid undefined index errors in views
        if (!isset($result['details']['abuse_db'])) {
            $result['details']['abuse_db'] = [
                'is_abused' => false,
                'abuse_type' => null,
            ];
        }

        $urlTest = URLTest::create([
            'user_id' => Auth::id(),
            'url' => $url,
            'is_safe' => $result['is_safe'],
            'details' => json_encode($result['details']),
        ]);

        return view('user.url-test-result', [
            'url' => $url,
            'isSafe' => $result['is_safe'],
            'details' => $result['details'],
        ]);
    }
}
